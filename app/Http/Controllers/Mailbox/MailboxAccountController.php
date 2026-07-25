<?php

namespace App\Http\Controllers\Mailbox;

use App\Application\Mailbox\Actions\ConnectMailboxAccount;
use App\Application\Mailbox\Actions\SendExternalEmail;
use App\Application\Mailbox\Actions\SynchronizeMailboxAccount;
use App\Application\Mailbox\Actions\SaveExternalDraft;
use App\Application\Mailbox\Actions\AssignMailboxAccount;
use App\Domain\Mailbox\Contracts\ImapMailboxGateway;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mailbox\SendExternalEmailRequest;
use App\Http\Requests\Mailbox\StoreMailboxAccountRequest;
use App\Http\Requests\Mailbox\SaveMailboxDraftRequest;
use App\Http\Requests\Mailbox\StoreMailboxAccountAssignmentRequest;
use App\Models\MailboxAccount;
use App\Models\MailboxAttachment;
use App\Models\MailboxEmail;
use App\Models\MailboxOutboxMessage;
use App\Models\MailboxAccountAssignment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Services\Audit\AuditLogger;
use App\Domain\Mailbox\Services\MailboxContactSuggestions;
use App\Support\PaginationPolicy;
use Throwable;

class MailboxAccountController extends Controller
{
    public function __construct(
        private readonly AuditLogger $audit,
        private readonly MailboxContactSuggestions $contacts,
        private readonly PaginationPolicy $pagination,
    ) {}

    public function workspace(Request $request): RedirectResponse
    {
        $this->authorize('viewAny', MailboxAccount::class);
        $account = MailboxAccount::query()
            ->accessibleTo($request->user())
            ->with(['assignments' => fn ($query) => $query->where('user_id', $request->user()->id)])
            ->get()
            ->sortByDesc(fn (MailboxAccount $item): bool => (bool) $item->assignments->first()?->is_default)
            ->first();

        if (! $account) {
            return redirect()->route('mailbox.accounts.index');
        }

        return redirect()->route('mailbox.external.show', $account);
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', MailboxAccount::class);
        $accounts = MailboxAccount::query()->accessibleTo($request->user())->with(['assignments.user.role'])->withCount(['emails', 'emails as unread_count' => fn ($q) => $q->where('is_read', false)])->latest()->get();
        $assignableUsers = User::query()->where('company_id', $request->user()->company_id)->where('status', 'active')->with('role')->orderBy('name')->get();
        return view('mailbox.accounts.index', compact('accounts', 'assignableUsers'));
    }

    public function store(StoreMailboxAccountRequest $request, ConnectMailboxAccount $action): RedirectResponse
    {
        try { $account = $action->execute($request->user(), $request->validated()); }
        catch(Throwable $exception) { report($exception); return back()->withInput($request->safe()->except('secret'))->withErrors(['connection'=>'The mailbox connection could not be verified. Check the server, ports, security mode, username, and app password.']); }
        $this->audit->record($request->user(),'mailbox.account.connected','Connected an external mailbox account',$account,['email'=>$account->email],$request);
        return redirect()->route('mailbox.external.show', $account)->with('status', 'Mailbox account connected. Initial synchronization can now begin.');
    }

    public function sync(Request $request, MailboxAccount $mailboxAccount, SynchronizeMailboxAccount $action): RedirectResponse
    {
        $this->authorize('update', $mailboxAccount);
        try { $run = $action->execute($mailboxAccount); }
        catch(Throwable $exception) { return back()->withErrors(['sync'=>'Mailbox synchronization failed. Your existing messages are unchanged; retry after checking the connection.']); }
        $this->audit->record($request->user(),'mailbox.account.synchronized','Synchronized an external mailbox account',$mailboxAccount,['sync_run_id'=>$run->id,'created'=>$run->messages_created,'updated'=>$run->messages_updated],$request);
        return back()->with('status', "Mailbox synchronized: {$run->messages_created} new and {$run->messages_updated} updated messages.");
    }

    public function syncJson(Request $request, MailboxAccount $mailboxAccount, SynchronizeMailboxAccount $action)
    {
        $this->authorize('update', $mailboxAccount);
        try {
            $run = $action->execute($mailboxAccount);
            $freshAccount = $mailboxAccount->fresh();
            return response()->json([
                'status' => 'ok',
                'created' => $run->messages_created,
                'updated' => $run->messages_updated,
                'last_synced_at' => $freshAccount->last_synced_at ? 'Synced '.$freshAccount->last_synced_at->diffForHumans() : 'Just now',
                'message' => "Mailbox synchronized: {$run->messages_created} new messages.",
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mailbox sync failed: '.$exception->getMessage(),
                'last_synced_at' => $mailboxAccount->last_synced_at ? 'Synced '.$mailboxAccount->last_synced_at->diffForHumans() : 'Not synced',
            ], 500);
        }
    }

    public function update(Request $request, MailboxAccount $mailboxAccount): RedirectResponse
    {
        $this->authorize('update', $mailboxAccount);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'signature' => ['nullable', 'string', 'max:5000'],
            'secret' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'remove_avatar' => ['nullable', 'boolean'],
        ]);

        $settings = $mailboxAccount->settings ?? [];
        $settings['signature_text'] = $validated['signature'] ?? null;

        if ($request->boolean('remove_avatar')) {
            if (! empty($settings['avatar_path'])) {
                Storage::disk('local')->delete($settings['avatar_path']);
                unset($settings['avatar_path']);
            }
        } elseif ($request->hasFile('avatar')) {
            if (! empty($settings['avatar_path'])) {
                Storage::disk('local')->delete($settings['avatar_path']);
            }
            $path = $request->file('avatar')->store('mailbox-avatars/' . $mailboxAccount->id, 'local');
            $settings['avatar_path'] = $path;
        }

        $data = [
            'name' => $validated['name'],
            'settings' => $settings,
        ];

        if (! empty($validated['secret'])) {
            $data['secret'] = $validated['secret'];
        }

        $mailboxAccount->update($data);

        $this->audit->record($request->user(), 'mailbox.account.updated', 'Updated mailbox account profile and details', $mailboxAccount, ['name' => $mailboxAccount->name], $request);

        return back()->with('status', 'Email account profile updated successfully.');
    }

    public function avatar(Request $request, MailboxAccount $mailboxAccount)
    {
        $this->authorize('view', $mailboxAccount);
        $avatarPath = $mailboxAccount->settings['avatar_path'] ?? null;

        if ($avatarPath && Storage::disk('local')->exists($avatarPath)) {
            return Storage::disk('local')->response($avatarPath, null, [
                'Cache-Control' => 'private, max-age=86400',
                'Content-Disposition' => 'inline',
            ]);
        }

        $initials = strtoupper(substr($mailboxAccount->name ?: $mailboxAccount->email, 0, 2));
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 128 128">'
            . '<rect width="128" height="128" rx="64" fill="#F58220"/>'
            . '<text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="#FFFFFF" font-family="sans-serif" font-size="44" font-weight="700">' . e($initials) . '</text>'
            . '</svg>';

        return response($svg, 200, [
            'Content-Type' => 'image/svg+xml',
            'Cache-Control' => 'private, max-age=86400',
        ]);
    }

    public function changePassword(Request $request, MailboxAccount $mailboxAccount): RedirectResponse
    {
        $this->authorize('update', $mailboxAccount);

        $validated = $request->validate([
            'secret' => ['required', 'string', 'min:1', 'max:255'],
        ], [
            'secret.required' => 'Please enter the new email account password.',
        ]);

        $mailboxAccount->update([
            'secret' => $validated['secret'],
        ]);

        $this->audit->record($request->user(), 'mailbox.account.password_changed', 'Changed email account password', $mailboxAccount, [], $request);

        return back()->with('status', 'Email account password updated successfully.');
    }

    public function destroy(Request $request, MailboxAccount $mailboxAccount): RedirectResponse
    {
        $this->authorize('delete', $mailboxAccount);
        $this->audit->record($request->user(),'mailbox.account.disconnected','Disconnected an external mailbox account',$mailboxAccount,['email'=>$mailboxAccount->email],$request);
        DB::transaction(function () use ($mailboxAccount): void { Storage::disk('local')->deleteDirectory('mailbox/'.$mailboxAccount->id); Storage::disk('local')->deleteDirectory('mailbox-outbox/'.$mailboxAccount->id); $mailboxAccount->forceDelete(); });
        return redirect()->route('mailbox.accounts.index')->with('status', 'Mailbox account and its cached private data were removed.');
    }

    public function assign(StoreMailboxAccountAssignmentRequest $request, MailboxAccount $mailboxAccount, AssignMailboxAccount $action): RedirectResponse
    {
        $assignment = $action->execute($mailboxAccount, $request->user(), $request->validated());
        $this->audit->record($request->user(), 'mailbox.account.assigned', 'Assigned access to a company mailbox', $mailboxAccount, ['assigned_user_id' => $assignment->user_id], $request);

        return back()->with('status', 'Mailbox access updated.');
    }

    public function unassign(Request $request, MailboxAccount $mailboxAccount, MailboxAccountAssignment $mailboxAccountAssignment): RedirectResponse
    {
        $this->authorize('update', $mailboxAccount);
        abort_unless($mailboxAccountAssignment->mailbox_account_id === $mailboxAccount->id, 404);
        abort_if($mailboxAccountAssignment->user_id === $mailboxAccount->user_id, 422, 'The account owner assignment cannot be removed.');
        $assignedUserId = $mailboxAccountAssignment->user_id;
        $mailboxAccountAssignment->delete();
        $this->audit->record($request->user(), 'mailbox.account.unassigned', 'Removed access to a company mailbox', $mailboxAccount, ['assigned_user_id' => $assignedUserId], $request);

        return back()->with('status', 'Mailbox access removed.');
    }

    // public function show(Request $request, MailboxAccount $mailboxAccount)
    // {
    //     $this->authorize('view', $mailboxAccount);
    //     $folder = $mailboxAccount->folders()->when($request->filled('folder'), fn ($q) => $q->whereKey($request->integer('folder')))->when(! $request->filled('folder'), fn ($q) => $q->orderByRaw("CASE WHEN special_use = 'inbox' THEN 0 ELSE 1 END"))->first();
    //     $query = $mailboxAccount->emails()->with(['folder', 'attachments'])->where('is_deleted', false)->when($folder, fn ($q) => $q->whereBelongsTo($folder, 'folder'));
    //     if ($request->filled('q')) { $term = '%'.str_replace(['%', '_'], ['\\%', '\\_'], $request->string('q')).'%'; $query->where(fn ($q) => $q->where('subject', 'like', $term)->orWhere('text_body', 'like', $term)->orWhere('from_addresses', 'like', $term)->orWhere('to_addresses', 'like', $term)); }
    //     if ($request->boolean('unread')) { $query->where('is_read', false); }
    //     if ($request->boolean('flagged')) { $query->where('is_flagged', true); }
    //     if ($request->boolean('attachments')) { $query->where('has_attachments', true); }
    //     match($request->string('sort')->toString()) { 'oldest'=>$query->oldest('received_at'),'subject'=>$query->orderBy('subject'),'sender'=>$query->orderBy('from_addresses'),default=>$query->latest('received_at') };
    //     $emails = $query->paginate($this->pagination->workspacePerPage())->withQueryString();
    //     $selected = $request->filled('message') ? $mailboxAccount->emails()->with('attachments')->where('is_deleted',false)->findOrFail($request->integer('message')) : $emails->first();
    //     $threadMessages=$selected?->thread_key?$mailboxAccount->emails()->with('attachments')->where('thread_key',$selected->thread_key)->where('is_deleted',false)->oldest('received_at')->get():collect([$selected])->filter();
    //     $composeDraft=$request->filled('draft')?$mailboxAccount->outboxMessages()->with('attachments')->where('user_id',$request->user()->id)->whereIn('state',['draft','failed'])->findOrFail($request->integer('draft')):null;
    //     $contacts = $this->contacts->forAccount($mailboxAccount, $request->user());
    //     $availableAccounts = MailboxAccount::query()->accessibleTo($request->user())->orderBy('name')->get();
    //     $sendAccounts = MailboxAccount::query()->accessibleTo($request->user(), 'send')->orderBy('name')->get();
    //     $composeData = $this->externalComposeContext($request, $mailboxAccount, $selected, $composeDraft);
    //     $mailboxAccount->load('folders');
    //     return view('mailbox.external.show', compact('mailboxAccount', 'folder', 'emails', 'selected','threadMessages','composeDraft','contacts','availableAccounts','sendAccounts','composeData'));
    // }
    public function show(Request $request, MailboxAccount $mailboxAccount, SynchronizeMailboxAccount $syncAction)
    {
        $this->authorize('view', $mailboxAccount);

        // ── Auto-sync mailbox before displaying latest messages ─────────────
        if ($mailboxAccount->status !== 'disabled' && $mailboxAccount->sync_enabled) {
            try {
                $syncAction->execute($mailboxAccount);
                $mailboxAccount->refresh();
            } catch (Throwable $exception) {
                report($exception);
            }
        }
    
        // ── Resolve active folder ──────────────────────────────────────────
        $folder = $mailboxAccount->folders()
            ->when(
                $request->filled('folder'),
                fn ($q) => $q->whereKey($request->integer('folder'))
            )
            ->when(
                ! $request->filled('folder'),
                fn ($q) => $q->orderByRaw("CASE WHEN special_use = 'inbox' THEN 0 ELSE 1 END")
            )
            ->first();
    
        // ── Detect outbox-backed folders (sent / drafts) ───────────────────
        $outboxSpecialUses = ['sent', 'drafts'];
        $isOutboxFolder    = $folder && in_array($folder->special_use, $outboxSpecialUses, true);
    
        // ── Build email list (IMAP or outbox, depending on folder) ────────
        if ($isOutboxFolder) {
    
            // Outbox states that map to each folder type
            $outboxStates = match ($folder->special_use) {
                'sent'   => ['sent'],
                'drafts' => ['draft', 'scheduled', 'failed'],
                default  => ['sent'],
            };
    
            $outboxQuery = $mailboxAccount->outboxMessages()
                ->with('attachments')
                ->whereIn('state', $outboxStates)
                ->when(
                    $request->filled('q'),
                    function ($q) use ($request) {
                        $term = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $request->string('q')) . '%';
                        $q->where(fn ($inner) =>
                            $inner->where('subject', 'like', $term)
                                ->orWhere('text_body', 'like', $term)
                                ->orWhere('to_addresses', 'like', $term)
                        );
                    }
                )
                ->when($request->boolean('attachments'), fn ($q) => $q->whereHas('attachments'))
                ->latest('created_at');
    
            $emails = $outboxQuery
                ->paginate($this->pagination->workspacePerPage())
                ->withQueryString();
    
            // Selected message — also from outbox
            $selected = $request->filled('message')
                ? $mailboxAccount->outboxMessages()
                    ->with('attachments')
                    ->findOrFail($request->integer('message'))
                : $emails->first();
    
            // Thread = single outbox message (outbox messages are standalone)
            $threadMessages = collect([$selected])->filter();
    
        } else {
    
            // ── Standard IMAP folder (inbox, archive, spam, trash, etc.) ──
            $query = $mailboxAccount->emails()
                ->with(['folder', 'attachments'])
                ->where('is_deleted', false)
                ->when($folder, fn ($q) => $q->whereBelongsTo($folder, 'folder'));
    
            if ($request->filled('q')) {
                $term = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $request->string('q')) . '%';
                $query->where(fn ($q) =>
                    $q->where('subject', 'like', $term)
                    ->orWhere('text_body', 'like', $term)
                    ->orWhere('from_addresses', 'like', $term)
                    ->orWhere('to_addresses', 'like', $term)
                );
            }
    
            if ($request->boolean('unread'))       { $query->where('is_read', false); }
            if ($request->boolean('flagged'))       { $query->where('is_flagged', true); }
            if ($request->boolean('attachments'))   { $query->where('has_attachments', true); }
    
            match ($request->string('sort')->toString()) {
                'oldest'  => $query->oldest('received_at'),
                'subject' => $query->orderBy('subject'),
                'sender'  => $query->orderBy('from_addresses'),
                default   => $query->latest('received_at'),
            };
    
            $emails = $query
                ->paginate($this->pagination->workspacePerPage())
                ->withQueryString();
    
            $selected = $request->filled('message')
                ? $mailboxAccount->emails()
                    ->with('attachments')
                    ->where('is_deleted', false)
                    ->findOrFail($request->integer('message'))
                : $emails->first();
    
            // Build conversation thread from shared thread_key or message headers
            $threadKey = $selected?->thread_key;
            if (! $threadKey && $selected) {
                $threadResolver = app(\App\Domain\Mailbox\Services\MailboxThreadResolver::class);
                $threadKey = $threadResolver->resolveThreadKey(
                    $mailboxAccount,
                    $selected->internet_message_id,
                    $selected->in_reply_to,
                    $selected->references ?? [],
                    $selected->subject
                );
                $selected->update(['thread_key' => $threadKey]);
            }

            $threadMessages = $threadKey
                ? $mailboxAccount->emails()
                    ->with('attachments')
                    ->where('thread_key', $threadKey)
                    ->where('is_deleted', false)
                    ->oldest('received_at')
                    ->get()
                : collect([$selected])->filter();
        }
    
        // ── Compose context (only relevant for IMAP messages) ─────────────
        $composeDraft = $request->filled('draft')
            ? $mailboxAccount->outboxMessages()
                ->with('attachments')
                ->where('user_id', $request->user()->id)
                ->whereIn('state', ['draft', 'failed'])
                ->findOrFail($request->integer('draft'))
            : null;
    
        $composeData = $isOutboxFolder
            ? ['open' => false]   // no reply/forward from sent/drafts folder view
            : $this->externalComposeContext($request, $mailboxAccount, $selected, $composeDraft);
    
        // ── Shared data ───────────────────────────────────────────────────
        $contacts          = $this->contacts->forAccount($mailboxAccount, $request->user());
        $availableAccounts = MailboxAccount::query()->accessibleTo($request->user())->orderBy('name')->get();
        $sendAccounts      = MailboxAccount::query()->accessibleTo($request->user(), 'send')->orderBy('name')->get();
    
        $mailboxAccount->load('folders');
    
        return view('mailbox.external.show', compact(
            'mailboxAccount',
            'folder',
            'emails',
            'selected',
            'threadMessages',
            'composeDraft',
            'contacts',
            'availableAccounts',
            'sendAccounts',
            'composeData',
            'isOutboxFolder',   // ← passed to Blade so Reply/Forward buttons hide on outbox folders
        ));
    }

    public function send(SendExternalEmailRequest $request, MailboxAccount $mailboxAccount, SendExternalEmail $action): RedirectResponse
    {
        $this->authorize('send', $mailboxAccount);
        try { $message = $action->execute($mailboxAccount, $request->user(), $request->validated()); }
        catch(Throwable $exception) { return back()->withInput($request->safe()->except('attachments'))->withErrors(['send'=>'Email was not sent. The message was retained in Failed drafts so you can review and retry it.']); }
        $this->audit->record($request->user(),'mailbox.email.sent','Sent an external email',$message,['account_id'=>$mailboxAccount->id,'provider_message_id'=>$message->provider_message_id],$request);
        return back()->with('status', $message->provider_message_id ? "Email sent ({$message->provider_message_id})." : 'Email sent successfully.');
    }

    public function drafts(Request $request, MailboxAccount $mailboxAccount)
    {
        $this->authorize('view',$mailboxAccount);
        $drafts=$mailboxAccount->outboxMessages()->where('user_id',$request->user()->id)->whereIn('state',['draft','scheduled','failed'])->latest('updated_at')->paginate($this->pagination->workspacePerPage());
        return view('mailbox.drafts.index',compact('mailboxAccount','drafts'));
    }

    public function saveDraft(SaveMailboxDraftRequest $request, MailboxAccount $mailboxAccount, SaveExternalDraft $action)
    {
        $this->authorize('send',$mailboxAccount); $draft=$action->execute($mailboxAccount,$request->user(),$request->validated());
        $this->audit->record($request->user(),$draft->state==='scheduled'?'mailbox.email.scheduled':'mailbox.draft.saved',$draft->state==='scheduled'?'Scheduled an external email':'Saved an external email draft',$draft,['account_id'=>$mailboxAccount->id],$request);
        if($request->expectsJson()) return response()->json(['data'=>['id'=>$draft->id,'state'=>$draft->state,'lock_version'=>$draft->lock_version,'updated_at'=>$draft->updated_at?->toISOString(),'discard_url'=>route('mailbox.drafts.destroy',[$mailboxAccount,$draft])],'message'=>$draft->state==='scheduled'?'Email scheduled.':'Draft saved.']);
        return redirect()->route('mailbox.drafts.index',$mailboxAccount)->with('status',$draft->state==='scheduled'?'Email scheduled.':'Draft saved.');
    }

    public function discardDraft(Request $request, MailboxAccount $mailboxAccount, MailboxOutboxMessage $mailboxOutboxMessage)
    {
        $this->authorize('send',$mailboxAccount); abort_unless($mailboxOutboxMessage->mailbox_account_id===$mailboxAccount->id&&$mailboxOutboxMessage->user_id===$request->user()->id,403); abort_if(in_array($mailboxOutboxMessage->state,['sending','sent'],true),409);
        $this->audit->record($request->user(),'mailbox.draft.discarded','Discarded an external email draft',$mailboxOutboxMessage,['account_id'=>$mailboxAccount->id],$request);
        foreach($mailboxOutboxMessage->attachments as $file) Storage::disk($file->disk)->delete($file->path); $mailboxOutboxMessage->delete();
        if ($request->expectsJson()) return response()->json(['message' => 'Draft discarded.']);
        return redirect()->route('mailbox.drafts.index',$mailboxAccount)->with('status','Draft discarded.');
    }

    public function state(Request $request, MailboxEmail $mailboxEmail, ImapMailboxGateway $gateway): RedirectResponse
    {
        $this->authorize('view', $mailboxEmail->account);
        $data = $request->validate(['action' => ['required', 'in:read,unread,star,unstar,archive,trash,spam,inbox']]);
        $action = $data['action'];
        try {
            if (in_array($action, ['read', 'unread'], true)) { $gateway->setFlag($mailboxEmail, 'Seen', $action === 'read'); $mailboxEmail->update(['is_read' => $action === 'read']); }
            elseif (in_array($action, ['star', 'unstar'], true)) { $gateway->setFlag($mailboxEmail, 'Flagged', $action === 'star'); $mailboxEmail->update(['is_flagged' => $action === 'star']); }
            else { $target = $mailboxEmail->account->folders()->where('special_use', $action)->firstOrFail(); $gateway->move($mailboxEmail, $target->remote_path); $mailboxEmail->delete(); }
        } catch(Throwable $exception) { report($exception); return back()->withErrors(['message_state'=>'The provider did not accept this change. The message remains unchanged; retry after the connection recovers.']); }
        $this->audit->record($request->user(),'mailbox.email.state_changed','Updated an external email state',$mailboxEmail,['action'=>$action,'account_id'=>$mailboxEmail->mailbox_account_id],$request);
        return back()->with('status', 'Message updated.');
    }

    public function attachment(Request $request, MailboxAttachment $mailboxAttachment): StreamedResponse
    {
        $this->authorize('view', $mailboxAttachment->email->account);
        abort_unless(Storage::disk($mailboxAttachment->disk)->exists($mailboxAttachment->path), 404);
        return Storage::disk($mailboxAttachment->disk)->download($mailboxAttachment->path, $mailboxAttachment->filename, ['Content-Type' => $mailboxAttachment->mime_type]);
    }

    /** @return array<string, mixed> */
    private function externalComposeContext(Request $request, MailboxAccount $account, ?MailboxEmail $selected, ?MailboxOutboxMessage $draft): array
    {
        if ($draft) {
            return [
                'open' => true,
                'mode' => 'draft',
                'title' => $draft->state === 'failed' ? 'Review failed email' : 'Continue draft',
                'to' => $draft->to_addresses ?? [],
                'cc' => $draft->cc_addresses ?? [],
                'bcc' => $draft->bcc_addresses ?? [],
                'subject' => $draft->subject ?? '',
                'body' => $draft->text_body ?? '',
                'body_html' => $draft->html_body ?? '',
                'in_reply_to' => $draft->in_reply_to,
                'references' => $draft->references_header,
            ];
        }

        $mode = $request->string('compose')->toString();
        if ($mode === '1') {
            $mode = 'new';
        }
        if (! in_array($mode, ['new', 'reply', 'reply_all', 'forward'], true)) {
            return ['open' => false, 'mode' => 'new', 'title' => 'New message', 'to' => [], 'cc' => [], 'bcc' => [], 'subject' => '', 'body' => '', 'body_html' => '', 'in_reply_to' => null, 'references' => null];
        }

        $message = $request->filled('compose_message')
            ? $account->emails()->with('attachments')->findOrFail($request->integer('compose_message'))
            : $selected;
        if ($mode === 'new' || ! $message) {
            return ['open' => true, 'mode' => 'new', 'title' => 'New message', 'to' => [], 'cc' => [], 'bcc' => [], 'subject' => '', 'body' => '', 'body_html' => '', 'in_reply_to' => null, 'references' => null];
        }

        $from = collect($message->reply_to_addresses ?: $message->from_addresses)->pluck('email')->filter();
        $to = $from;
        $cc = collect();
        if ($mode === 'reply_all') {
            $to = $from->concat(collect($message->to_addresses)->pluck('email'));
            $cc = collect($message->cc_addresses)->pluck('email');
        }
        $normalize = fn (Collection $addresses): array => $addresses
            ->map(fn ($email): string => strtolower(trim((string) $email)))
            ->filter(fn (string $email): bool => filter_var($email, FILTER_VALIDATE_EMAIL) !== false && $email !== strtolower($account->email))
            ->unique()
            ->values()
            ->all();
        $subject = trim((string) $message->subject);

        if ($mode === 'forward') {
            $fromAddress = collect($message->from_addresses)->first();
            return [
                'open' => true,
                'mode' => 'forward',
                'title' => 'Forward',
                'to' => [], 'cc' => [], 'bcc' => [],
                'subject' => str_starts_with(strtolower($subject), 'fwd:') ? $subject : 'Fwd: '.$subject,
                'body' => "\n\n---------- Forwarded message ----------\nFrom: ".($fromAddress['email'] ?? '')."\nDate: ".$message->received_at?->toRfc7231String()."\nSubject: {$subject}\n\n{$message->text_body}",
                'body_html' => '', 'in_reply_to' => null, 'references' => null,
            ];
        }

        return [
            'open' => true,
            'mode' => $mode,
            'title' => $mode === 'reply_all' ? 'Reply all' : 'Reply',
            'to' => $normalize($to),
            'cc' => $normalize($cc),
            'bcc' => [],
            'subject' => str_starts_with(strtolower($subject), 're:') ? $subject : 'Re: '.$subject,
            'body' => '', 'body_html' => '',
            'in_reply_to' => $message->internet_message_id,
            'references' => collect($message->references)->push($message->internet_message_id)->filter()->join(' '),
        ];
    }

}
