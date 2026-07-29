<?php

namespace Tests\Feature;

use App\Domain\Mailbox\Services\MailboxThreadResolver;
use App\Models\MailboxAccount;
use App\Models\MailboxEmail;
use App\Models\MailboxFolder;
use App\Models\MailboxOutboxMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MailboxThreadResolverTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite.database' => ':memory:']);
    }

    public function test_thread_resolver_links_by_in_reply_to_and_references(): void
    {
        $this->seed();
        $user = User::where('email', 'aditya.mehra@builder360.test')->firstOrFail();
        $account = $this->account($user);
        $folder = MailboxFolder::create(['mailbox_account_id' => $account->id, 'name' => 'Inbox', 'remote_path' => 'INBOX', 'special_use' => 'inbox']);

        $email1 = MailboxEmail::create([
            'mailbox_account_id' => $account->id,
            'mailbox_folder_id' => $folder->id,
            'remote_uid' => 1,
            'internet_message_id' => 'msg-100@example.com',
            'thread_key' => hash('sha256', 'msg:msg-100@example.com'),
            'subject' => 'Project Timeline',
            'from_addresses' => [['email' => 'client@example.com']],
            'to_addresses' => [['email' => $account->email]],
            'received_at' => now()->subHour(),
        ]);

        $resolver = new MailboxThreadResolver();
        $resolvedKey = $resolver->resolveThreadKey(
            $account,
            'msg-101@example.com',
            'msg-100@example.com',
            ['msg-100@example.com'],
            'Re: Project Timeline'
        );

        $this->assertSame($email1->thread_key, $resolvedKey);
    }

    public function test_thread_resolver_links_by_normalized_subject_fallback(): void
    {
        $this->seed();
        $user = User::where('email', 'aditya.mehra@builder360.test')->firstOrFail();
        $account = $this->account($user);
        $folder = MailboxFolder::create(['mailbox_account_id' => $account->id, 'name' => 'Inbox', 'remote_path' => 'INBOX', 'special_use' => 'inbox']);

        $email1 = MailboxEmail::create([
            'mailbox_account_id' => $account->id,
            'mailbox_folder_id' => $folder->id,
            'remote_uid' => 2,
            'internet_message_id' => 'msg-200@example.com',
            'thread_key' => 'thread-subj-key-1',
            'subject' => 'Skyline Site Handover',
            'from_addresses' => [['email' => 'buyer@example.com']],
            'to_addresses' => [['email' => $account->email]],
            'received_at' => now()->subHours(2),
        ]);

        $resolver = new MailboxThreadResolver();

        // Email without in-reply-to or references headers, but subject is "Re: Skyline Site Handover"
        $resolvedKey = $resolver->resolveThreadKey(
            $account,
            'msg-201@example.com',
            null,
            [],
            'Re: Skyline Site Handover'
        );

        $this->assertSame('thread-subj-key-1', $resolvedKey);
    }

    public function test_draft_saving_and_sending_attaches_thread_key(): void
    {
        $this->seed();
        $user = User::where('email', 'aditya.mehra@builder360.test')->firstOrFail();
        $account = $this->account($user);
        $folder = MailboxFolder::create(['mailbox_account_id' => $account->id, 'name' => 'Inbox', 'remote_path' => 'INBOX', 'special_use' => 'inbox']);

        $email = MailboxEmail::create([
            'mailbox_account_id' => $account->id,
            'mailbox_folder_id' => $folder->id,
            'remote_uid' => 3,
            'internet_message_id' => 'msg-300@example.com',
            'thread_key' => 'thread-300',
            'subject' => 'Architectural Blueprint',
            'from_addresses' => [['email' => 'arch@example.com']],
            'to_addresses' => [['email' => $account->email]],
            'received_at' => now()->subMinutes(30),
        ]);

        $this->actingAs($user)->post(route('mailbox.drafts.store', $account), [
            'client_token' => fake()->uuid(),
            'state' => 'draft',
            'to' => ['arch@example.com'],
            'subject' => 'Re: Architectural Blueprint',
            'body' => 'I have reviewed the blueprint.',
            'in_reply_to' => 'msg-300@example.com',
            'references' => 'msg-300@example.com',
        ])->assertRedirect();

        $outbox = MailboxOutboxMessage::where('mailbox_account_id', $account->id)->firstOrFail();
        $this->assertSame('thread-300', $outbox->thread_key);
    }

    private function account(User $owner): MailboxAccount
    {
        return MailboxAccount::create([
            'company_id' => $owner->company_id,
            'user_id' => $owner->id,
            'name' => 'Company Sales',
            'email' => 'sales@company.test',
            'imap_host' => 'imap.company.test',
            'imap_port' => 993,
            'imap_encryption' => 'ssl',
            'imap_validate_cert' => true,
            'smtp_host' => 'smtp.company.test',
            'smtp_port' => 587,
            'smtp_encryption' => 'tls',
            'username' => 'sales@company.test',
            'secret' => 'app-password',
            'status' => 'active',
            'settings' => [],
        ]);
    }
}
