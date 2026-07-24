<section class="people-ops-grid is-wide-left" aria-label="HR helpdesk controls">
    <article class="people-ops-panel" id="helpdesk-form">
        <header class="people-ops-panel-head">
            <div><h2>Raise HR helpdesk ticket</h2><p>Submit a governed employee support request to the authorized HR team.</p></div>
        </header>
        <div class="people-ops-panel-body">
            <?php if($abilities['canCreateTicket']): ?>
                <form method="POST" action="<?php echo e(route('hr.helpdesk-tickets.store')); ?>" class="people-form-grid" x-data="serverFormState" x-on:submit="beginSubmit" x-bind:aria-busy="busyAria" data-idle-label="Raise HR ticket" data-busy-label="Submitting…">
                    <?php echo csrf_field(); ?>
                    <label class="people-field">
                        <span>Employee</span>
                        <select class="people-control" name="employee_id" required>
                            <option value="">Select employee</option>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>" <?php if((string) old('employee_id') === (string) $employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?><?php echo e($employee->department ? ' / '.$employee->department : ''); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                    <label class="people-field">
                        <span>Category</span>
                        <select class="people-control" name="category" required>
                            <option value="">Select category</option>
                            <?php $__currentLoopData = $helpdeskCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category); ?>" <?php if(old('category') === $category): echo 'selected'; endif; ?>><?php echo e(str($category)->replace('_', ' ')->title()); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                    <label class="people-field">
                        <span>Priority</span>
                        <select class="people-control" name="priority" required>
                            <?php $__currentLoopData = $helpdeskPriorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($priority); ?>" <?php if(old('priority', 'medium') === $priority): echo 'selected'; endif; ?>><?php echo e(ucfirst($priority)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                    <label class="people-field is-wide">
                        <span>Subject</span>
                        <input class="people-control" name="subject" value="<?php echo e(old('subject')); ?>" maxlength="255" required placeholder="Short support request summary">
                        <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                    <label class="people-field is-wide">
                        <span>Description</span>
                        <textarea class="people-control" name="description" rows="4" minlength="10" maxlength="5000" required placeholder="Describe the issue and the outcome you need"><?php echo e(old('description')); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                    <div class="people-modal-actions is-wide"><button type="submit" class="people-button is-primary" x-bind:disabled="busy"><span x-text="submitLabel">Raise HR ticket</span></button></div>
                </form>
            <?php else: ?>
                <div class="people-ops-empty"><i class="fa-solid fa-lock" aria-hidden="true"></i><strong>Ticket creation unavailable</strong><span>Your role can review authorized tickets but cannot raise a support request.</span></div>
            <?php endif; ?>
        </div>
    </article>

    <article class="people-ops-panel">
        <header class="people-ops-panel-head"><div><h2>Ticket filters</h2><p>Filter the authorized register without changing company scope.</p></div></header>
        <div class="people-ops-panel-body">
            <form method="GET" action="<?php echo e(route('hr.helpdesk-tickets.index')); ?>" class="people-form-grid">
                <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id"><option value="">All employees</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string) request('employee_id') === (string) $employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Status</span><select class="people-control" name="status"><option value="">All statuses</option><?php $__currentLoopData = $helpdeskStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($status); ?>" <?php if(request('status') === $status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Category</span><select class="people-control" name="category"><option value="">All categories</option><?php $__currentLoopData = $helpdeskCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($category); ?>" <?php if(request('category') === $category): echo 'selected'; endif; ?>><?php echo e(str($category)->replace('_', ' ')->title()); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Priority</span><select class="people-control" name="priority"><option value="">All priorities</option><?php $__currentLoopData = $helpdeskPriorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($priority); ?>" <?php if(request('priority') === $priority): echo 'selected'; endif; ?>><?php echo e(ucfirst($priority)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <div class="people-modal-actions is-wide"><button class="people-button" type="submit">Apply filters</button><a class="people-button" href="<?php echo e(route('hr.helpdesk-tickets.index')); ?>">Clear</a></div>
            </form>
        </div>
    </article>
</section>

<section class="people-ops-panel has-mobile-cards" aria-labelledby="hr-helpdesk-title">
    <header class="people-ops-panel-head"><div><h2 id="hr-helpdesk-title">HR helpdesk tickets</h2><p><?php echo e($tickets->total()); ?> ticket<?php echo e($tickets->total() === 1 ? '' : 's'); ?> match the selected filters.</p></div></header>
    <div class="people-ops-table-wrap">
        <table class="people-ops-table">
            <caption>HR helpdesk ticket register</caption>
            <thead><tr><th scope="col">Ticket</th><th scope="col">Employee</th><th scope="col">Category / priority</th><th scope="col">Status / owner</th><th scope="col">Timing</th><th scope="col">Resolution / history</th><th scope="col" class="is-actions">Action</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($ticket->ticketNumber); ?> / <?php echo e($ticket->subject); ?></strong><small><?php echo e($ticket->description); ?></small></td>
                        <td><div class="people-ops-identity"><span class="people-avatar"><?php echo e($ticket->employeeInitial); ?></span><div><strong><?php echo e($ticket->employeeName); ?></strong><small><?php echo e($ticket->employeeCode); ?> / <?php echo e($ticket->employeeContext); ?></small></div></div></td>
                        <td><?php echo e($ticket->categoryLabel); ?><small><span class="people-status is-<?php echo e($ticket->priorityTone); ?>"><?php echo e($ticket->priorityLabel); ?></span></small></td>
                        <td><span class="people-status is-<?php echo e($ticket->statusTone); ?>"><?php echo e($ticket->statusLabel); ?></span><small>Raised by: <?php echo e($ticket->raisedBy); ?></small><small>Assigned to: <?php echo e($ticket->assignedTo); ?></small></td>
                        <td><?php echo e($ticket->createdAt); ?><small>Resolved: <?php echo e($ticket->resolvedAt); ?></small><small>Closed: <?php echo e($ticket->closedAt); ?></small></td>
                        <td><strong><?php echo e($ticket->resolutionSummary); ?></strong><?php if($ticket->attachmentCount): ?><small><?php echo e($ticket->attachmentCount); ?> attachment<?php echo e($ticket->attachmentCount === 1 ? '' : 's'); ?> recorded: <?php echo e(implode(', ', $ticket->attachmentNames)); ?></small><?php else: ?><small>No attachments recorded</small><?php endif; ?><small><?php echo e($ticket->workflowNote); ?> / <?php echo e($ticket->workflowActor); ?> / <?php echo e($ticket->workflowAt); ?></small></td>
                        <td class="is-actions"><?php echo $__env->make('hr.operations.partials.helpdesk-actions', ['ticket' => $ticket], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7"><div class="people-ops-empty"><i class="fa-solid fa-headset" aria-hidden="true"></i><strong>No HR helpdesk tickets found</strong><span>Clear the filters or raise a new ticket when permitted.</span></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="people-ops-mobile-list">
        <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="people-ops-mobile-card">
                <div class="people-ops-mobile-card-head"><strong><?php echo e($ticket->ticketNumber); ?> / <?php echo e($ticket->subject); ?></strong><span class="people-status is-<?php echo e($ticket->statusTone); ?>"><?php echo e($ticket->statusLabel); ?></span></div>
                <dl class="people-ops-mobile-facts"><div><dt>Employee</dt><dd><?php echo e($ticket->employeeName); ?> / <?php echo e($ticket->employeeCode); ?></dd></div><div><dt>Category / priority</dt><dd><?php echo e($ticket->categoryLabel); ?> / <?php echo e($ticket->priorityLabel); ?></dd></div><div><dt>Raised / assigned</dt><dd><?php echo e($ticket->raisedBy); ?> / <?php echo e($ticket->assignedTo); ?></dd></div><div><dt>Created</dt><dd><?php echo e($ticket->createdAt); ?></dd></div><div><dt>Resolved</dt><dd><?php echo e($ticket->resolvedAt); ?></dd></div><div><dt>Closed</dt><dd><?php echo e($ticket->closedAt); ?></dd></div></dl>
                <p><?php echo e($ticket->description); ?></p>
                <p><strong>Resolution:</strong> <?php echo e($ticket->resolutionSummary); ?></p>
                <p><strong>Evidence:</strong> <?php echo e($ticket->attachmentCount ? implode(', ', $ticket->attachmentNames) : 'No attachments recorded'); ?></p>
                <p class="people-subtext"><?php echo e($ticket->workflowNote); ?> / <?php echo e($ticket->workflowActor); ?> / <?php echo e($ticket->workflowAt); ?></p>
                <div class="people-ops-mobile-actions"><?php echo $__env->make('hr.operations.partials.helpdesk-actions', ['ticket' => $ticket], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="people-ops-empty"><strong>No HR helpdesk tickets found</strong><span>Clear the filters or raise a new ticket when permitted.</span></div>
        <?php endif; ?>
    </div>
    <div class="people-pagination"><?php echo e($tickets->withQueryString()->links()); ?></div>
</section>
<?php /**PATH /home/developer/public_html/builder360/resources/views/hr/operations/partials/helpdesk.blade.php ENDPATH**/ ?>