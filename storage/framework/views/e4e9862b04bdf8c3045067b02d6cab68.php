<?php
    $listQuery = collect($filters)->except(['message_id', 'page'])->filter(fn ($value) => $value !== null && $value !== '')->all();
    $currentFolder = $filters['folder'] ?? 'inbox';
    $pageMessages = $messages->getCollection();
    $unreadCount = $pageMessages->where('status', 'unread')->count();
    $scheduledCount = $pageMessages->where('status', 'scheduled')->count();
    $archivedCount = $pageMessages->where('status', 'archived')->count();
?>

<?php $__env->startSection('title', 'Mailbox | Builder360'); ?>

<?php $__env->startSection('content'); ?>
    <section class="b360-collaboration-screen b360-mailbox-screen" aria-label="Mailbox">
        <aside class="b360-mailbox-rail" aria-label="Mailbox folders">
            <?php if($canCreateMessage): ?>
                
            <?php endif; ?>

            <a class="b360-mail-account" href="<?php echo e(route('mailbox.accounts.index')); ?>"><span class="b360-mail-account-dot"></span><span><strong>All accounts</strong><small><?php echo e(auth()->user()->email); ?></small></span><b>⌄</b></a>

            <?php if($externalAccounts->isNotEmpty()): ?>
                <nav class="b360-mail-account-links" aria-label="Connected email accounts">
                    <a class="is-active" href="<?php echo e(route('collaboration.messages.index')); ?>"><span class="b360-mail-account-dot"></span><span><strong>Builder360 Internal</strong><small>Employee messages</small></span></a>
                    <?php $__currentLoopData = $externalAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('mailbox.external.show', $account)); ?>"><span class="b360-mail-account-dot is-external"></span><span><strong><?php echo e($account->name); ?></strong><small><?php echo e($account->email); ?></small></span></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </nav>
            <?php endif; ?>

            <nav class="b360-mail-folders">
                <a class="<?php echo e($currentFolder === 'inbox' && empty($filters['status']) ? 'is-active' : ''); ?>" href="<?php echo e(route('collaboration.messages.index', ['folder' => 'inbox'])); ?>"><span>▣</span><strong>Inbox</strong><?php if($unreadCount): ?><em><?php echo e($unreadCount); ?></em><?php endif; ?></a>
                <a class="<?php echo e($currentFolder === 'sent' && empty($filters['status']) ? 'is-active' : ''); ?>" href="<?php echo e(route('collaboration.messages.index', ['folder' => 'sent'])); ?>"><span>➤</span><strong>Sent</strong></a>
                <a class="<?php echo e(($filters['status'] ?? null) === 'scheduled' ? 'is-active' : ''); ?>" href="<?php echo e(route('collaboration.messages.index', ['folder' => 'sent', 'status' => 'scheduled'])); ?>"><span>□</span><strong>Scheduled</strong><?php if($scheduledCount): ?><em><?php echo e($scheduledCount); ?></em><?php endif; ?></a>
                <a class="<?php echo e(($filters['status'] ?? null) === 'archived' ? 'is-active' : ''); ?>" href="<?php echo e(route('collaboration.messages.index', ['folder' => 'all', 'status' => 'archived'])); ?>"><span>▤</span><strong>Archived</strong><?php if($archivedCount): ?><em><?php echo e($archivedCount); ?></em><?php endif; ?></a>
                <a class="<?php echo e($currentFolder === 'all' && empty($filters['status']) ? 'is-active' : ''); ?>" href="<?php echo e(route('collaboration.messages.index', ['folder' => 'all'])); ?>"><span>☰</span><strong>All mail</strong></a>
            </nav>

            <?php if($internalDrafts->isNotEmpty()): ?>
                <?php if(false): ?><section class="b360-internal-drafts" aria-labelledby="internal-drafts-title">
                    <h2 id="internal-drafts-title">Drafts & scheduled <span><?php echo e($internalDrafts->count()); ?></span></h2>
                    <?php $__currentLoopData = $internalDrafts->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $draft): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('collaboration.messages.index', ['internal_draft' => $draft->id])); ?>">
                            <i class="fa-regular fa-file-lines" aria-hidden="true"></i>
                            <span><strong><?php echo e($draft->subject ?: 'Untitled draft'); ?></strong><small><?php echo e(str($draft->state)->headline()); ?> · <?php echo e($draft->updated_at->diffForHumans()); ?></small></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </section><?php endif; ?>
            <?php endif; ?>

            <div class="b360-mail-rail-footer"><a href="<?php echo e(route('collaboration.messages.export', array_merge($listQuery, ['format' => 'csv']))); ?>">⇩ Export CSV</a></div>
        </aside>

        <section class="b360-mail-list-pane" aria-label="Message list">
            <header class="b360-mail-list-head">
                <div class="b360-mail-list-title"><span class="b360-mail-checkbox"></span><h1><?php echo e($folders[$currentFolder] ?? 'Inbox'); ?></h1><span><?php echo e(number_format($messages->total())); ?></span></div>
                <a class="b360-collab-icon-btn" href="<?php echo e(route('collaboration.messages.index', $listQuery)); ?>" aria-label="Refresh mailbox">↻</a>
            </header>

            <form method="GET" action="<?php echo e(route('collaboration.messages.index')); ?>" class="b360-mail-search">
                <span>⌕</span><input type="search" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" placeholder="Search mail — sender, subject, body...">
                <input type="hidden" name="folder" value="<?php echo e($currentFolder); ?>">
                <?php if(!empty($filters['status'])): ?><input type="hidden" name="status" value="<?php echo e($filters['status']); ?>"><?php endif; ?>
            </form>

            <nav class="b360-mail-chips" aria-label="Mailbox filters">
                <a class="<?php echo e(($filters['status'] ?? null) === 'unread' ? 'is-active' : ''); ?>" href="<?php echo e(route('collaboration.messages.index', array_merge($listQuery, ['folder' => $currentFolder, 'status' => 'unread']))); ?>">✉ Unread</a>
                <details><summary>Priority</summary><div><a href="<?php echo e(route('collaboration.messages.index', array_merge($listQuery, ['priority' => 'high']))); ?>">High</a><a href="<?php echo e(route('collaboration.messages.index', array_merge($listQuery, ['priority' => 'critical']))); ?>">Critical</a><a href="<?php echo e(route('collaboration.messages.index', collect($listQuery)->except('priority')->all())); ?>">Any priority</a></div></details>
                <details><summary>Project</summary><div><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><a href="<?php echo e(route('collaboration.messages.index', array_merge($listQuery, ['project_id' => $project->id]))); ?>"><?php echo e($project->code); ?></a><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><a href="<?php echo e(route('collaboration.messages.index', collect($listQuery)->except('project_id')->all())); ?>">All projects</a></div></details>
            </nav>

            <div class="b360-mail-rows">
                <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $isMine = (int) $message->sender_user_id === (int) auth()->id();
                        $person = $isMine ? $message->recipient : $message->sender;
                        $messageUrl = route('collaboration.messages.index', array_merge($listQuery, ['message_id' => $message->id]));
                    ?>
                    <a href="<?php echo e($messageUrl); ?>" class="b360-mail-row <?php echo e($selectedMessage?->id === $message->id ? 'is-active' : ''); ?> <?php echo e($message->status === 'unread' ? 'is-unread' : ''); ?>">
                        <span class="b360-mail-row-check"></span>
                        <span class="b360-mail-star">☆</span>
                        <span class="b360-mail-avatar"><?php echo e(str($person?->name ?? 'System')->substr(0, 2)->upper()); ?></span>
                        <span class="b360-mail-row-copy"><span><strong><?php echo e($person?->name ?? 'System'); ?></strong><time><?php echo e(($message->sent_at ?? $message->created_at)?->format('h:i A')); ?></time></span><b><?php echo e($message->subject); ?></b><small><?php echo e(str($message->body)->squish()->limit(74)); ?></small><i><?php if($message->project): ?><?php echo e($message->project->code); ?><?php else: ?><?php echo e(str($message->priority)->headline()); ?><?php endif; ?></i></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="b360-collab-empty b360-collab-empty-large"><span class="b360-empty-icon">✉</span><strong>This folder is empty</strong><span>Messages will appear here when they are available.</span></div>
                <?php endif; ?>
            </div>
            <?php if($messages->hasPages()): ?><div class="b360-mail-pagination"><?php echo e($messages->links()); ?></div><?php endif; ?>
        </section>

        <section class="b360-mail-reading-pane" aria-label="Selected message">
            <?php if($selectedMessage): ?>
                <?php $selectedPerson = (int) $selectedMessage->sender_user_id === (int) auth()->id() ? $selectedMessage->recipient : $selectedMessage->sender; ?>
                <header class="b360-mail-reading-head"><div><span><?php echo e($selectedMessage->message_number); ?></span><h2><?php echo e($selectedMessage->subject); ?></h2></div><span class="blade-status-pill"><?php echo e($statuses[$selectedMessage->status] ?? str($selectedMessage->status)->headline()); ?></span></header>
                <article class="b360-mail-reading-body">
                    <div class="b360-mail-sender"><span class="b360-mail-avatar"><?php echo e(str($selectedPerson?->name ?? 'System')->substr(0, 2)->upper()); ?></span><span><strong><?php echo e($selectedPerson?->name ?? 'System'); ?></strong><small><?php echo e($selectedMessage->sender?->email); ?></small></span><time><?php echo e(($selectedMessage->sent_at ?? $selectedMessage->created_at)?->format('d M Y, h:i A')); ?></time></div>
                    <div class="b360-mail-message-copy"><?php echo nl2br(e($selectedMessage->body)); ?></div>
                    <?php if($selectedMessage->project): ?><div class="b360-mail-linked-record"><span>Linked project</span><strong><?php echo e($selectedMessage->project->code); ?> · <?php echo e($selectedMessage->project->name); ?></strong></div><?php endif; ?>
                    <?php if($selectedMessage->internalDispatch?->attachments?->isNotEmpty()): ?>
                        <section class="b360-mail-attachments" aria-label="Message attachments">
                            <strong>Attachments</strong>
                            <?php $__currentLoopData = $selectedMessage->internalDispatch->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span>
                                    <i class="fa-solid fa-paperclip" aria-hidden="true"></i>
                                    <?php echo e($attachment->original_filename); ?>

                                    <small><?php echo e(number_format($attachment->size_bytes / 1024, 1)); ?> KB</small>
                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </section>
                    <?php endif; ?>
                </article>
                <footer class="b360-mail-reading-actions">
                    <a class="blade-secondary-action" href="<?php echo e(route('collaboration.messages.index', array_merge($listQuery, ['message_id' => $selectedMessage->id, 'compose_action' => 'reply', 'compose_message_id' => $selectedMessage->id]))); ?>">Reply</a>
                    <a class="blade-secondary-action" href="<?php echo e(route('collaboration.messages.index', array_merge($listQuery, ['message_id' => $selectedMessage->id, 'compose_action' => 'reply_all', 'compose_message_id' => $selectedMessage->id]))); ?>">Reply all</a>
                    <a class="blade-secondary-action" href="<?php echo e(route('collaboration.messages.index', array_merge($listQuery, ['message_id' => $selectedMessage->id, 'compose_action' => 'forward', 'compose_message_id' => $selectedMessage->id]))); ?>">Forward</a>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('markRead', $selectedMessage)): ?><form method="POST" action="<?php echo e(route('collaboration.messages.read', $selectedMessage)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><button type="submit" class="blade-secondary-action">Mark read</button></form><?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('archive', $selectedMessage)): ?><form method="POST" action="<?php echo e(route('collaboration.messages.archive', $selectedMessage)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><button type="submit" class="blade-danger-action">Archive</button></form><?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cancelScheduled', $selectedMessage)): ?><form method="POST" action="<?php echo e(route('collaboration.messages.cancel-scheduled', $selectedMessage)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><input type="hidden" name="reason" value="Cancelled from mailbox"><button type="submit" class="blade-danger-action">Cancel scheduled</button></form><?php endif; ?>
                </footer>
            <?php else: ?>
                <div class="b360-collab-empty b360-collab-empty-large"><span class="b360-empty-icon">✉</span><strong>Select a message</strong><span>Choose a message from the list to read the conversation and linked project details.</span></div>
            <?php endif; ?>
        </section>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/collaboration/messages/index.blade.php ENDPATH**/ ?>