<?php

namespace App\Domain\Mailbox\Services;

use App\Models\MailboxAccount;
use App\Models\MailboxEmail;
use Illuminate\Support\Str;

final class MailboxThreadResolver
{
    public function resolveThreadKey(
        MailboxAccount $account,
        ?string $messageId,
        ?string $inReplyTo,
        array $references = [],
        ?string $subject = null
    ): string {
        $cleanId = fn (?string $id): ?string => $id ? trim((string) $id, '<> ') : null;

        $messageId = $cleanId($messageId);
        $inReplyTo = $cleanId($inReplyTo);
        $references = array_values(array_filter(array_map($cleanId, $references)));

        // Collect all referenced message IDs in priority order: [references..., inReplyTo]
        $referencedIds = array_values(array_unique(array_filter([...$references, $inReplyTo])));

        // Step 1: Look up existing MailboxEmail in DB by referenced Message-IDs
        if (! empty($referencedIds)) {
            $existingThreadEmail = MailboxEmail::query()
                ->where('mailbox_account_id', $account->id)
                ->whereIn('internet_message_id', $referencedIds)
                ->whereNotNull('thread_key')
                ->first();

            if ($existingThreadEmail?->thread_key) {
                return $existingThreadEmail->thread_key;
            }
        }

        // Step 2: Root message ID from References[0], In-Reply-To, or Message-ID
        $rootId = $references[0] ?? $inReplyTo ?? $messageId;
        if ($rootId !== null && $rootId !== '') {
            return hash('sha256', 'msg:' . strtolower($rootId));
        }

        // Step 3: Normalized Subject Fallback (Gmail Subject-based Threading)
        $normalizedSubject = $this->normalizeSubject($subject);
        if ($normalizedSubject !== '') {
            $subjectMatches = MailboxEmail::query()
                ->where('mailbox_account_id', $account->id)
                ->whereNotNull('thread_key')
                ->where('subject', '!=', '')
                ->get(['id', 'subject', 'thread_key']);

            foreach ($subjectMatches as $match) {
                if ($this->normalizeSubject($match->subject) === $normalizedSubject) {
                    return $match->thread_key;
                }
            }

            return hash('sha256', 'subj:' . $account->id . ':' . $normalizedSubject);
        }

        return $messageId ? hash('sha256', 'msg:' . strtolower($messageId)) : hash('sha256', Str::uuid()->toString());
    }

    /**
     * Re-evaluate and repair conversation thread_key links for all emails in a mailbox account.
     */
    public function repairAccountThreads(MailboxAccount $account): void
    {
        $emails = $account->emails()
            ->where('is_deleted', false)
            ->oldest('received_at')
            ->get();

        foreach ($emails as $email) {
            $key = $this->resolveThreadKey(
                $account,
                $email->internet_message_id,
                $email->in_reply_to,
                $email->references ?? [],
                $email->subject
            );

            if ($key && $email->thread_key !== $key) {
                $email->update(['thread_key' => $key]);
            }
        }
    }

    /**
     * Normalize email subject by stripping Re:, Fwd:, FW:, etc., extra spaces, and converting to lowercase.
     */
    public function normalizeSubject(?string $subject): string
    {
        if ($subject === null || trim($subject) === '') {
            return '';
        }

        $cleaned = trim($subject);
        while (preg_match('/^(?:(?i)re|fwd|fw|re\[\d+\]|re\(\d+\)|fwd\[\d+\]|fwd\(\d+\))[\s:]+/i', $cleaned)) {
            $cleaned = preg_replace('/^(?:(?i)re|fwd|fw|re\[\d+\]|re\(\d+\)|fwd\[\d+\]|fwd\(\d+\))[\s:]+/i', '', $cleaned);
            $cleaned = trim($cleaned);
        }

        $cleaned = preg_replace('/^\[[^\]]+\]\s*/', '', $cleaned);

        return strtolower(preg_replace('/\s+/', ' ', trim($cleaned)));
    }
}
