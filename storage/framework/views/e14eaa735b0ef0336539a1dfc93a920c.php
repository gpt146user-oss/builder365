<?php if($ticket->canManage): ?>
    <details>
        <summary class="people-ops-action-link" aria-label="Assign HR ticket <?php echo e($ticket->ticketNumber); ?>">Assign</summary>
        <form method="POST" action="<?php echo e(route('hr.helpdesk-tickets.assign', $ticket->id)); ?>" x-data="serverFormState" x-on:submit="beginSubmit" x-bind:aria-busy="busyAria" data-idle-label="Assign ticket" data-busy-label="Assigning…">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <label class="people-field">
                <span>Active assignee</span>
                <select class="people-control" name="assigned_to_user_id" required>
                    <option value="">Select assignee</option>
                    <?php $__currentLoopData = $assignees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($assignee->id); ?>"><?php echo e($assignee->name); ?> - <?php echo e($assignee->email); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>
            <label class="people-field">
                <span>Assignment note</span>
                <textarea class="people-control" name="note" rows="2" maxlength="1000" placeholder="Optional assignment context"></textarea>
            </label>
            <button class="people-button is-primary" type="submit" x-bind:disabled="busy"><span x-text="submitLabel">Assign ticket</span></button>
        </form>
    </details>

    <details>
        <summary class="people-ops-action-link" aria-label="Resolve HR ticket <?php echo e($ticket->ticketNumber); ?>">Resolve</summary>
        <form method="POST" action="<?php echo e(route('hr.helpdesk-tickets.resolve', $ticket->id)); ?>" x-data="serverFormState" x-on:submit="beginSubmit" x-bind:aria-busy="busyAria" data-idle-label="Resolve ticket" data-busy-label="Resolving…">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <label class="people-field">
                <span>Resolution summary</span>
                <textarea class="people-control" name="resolution_summary" rows="3" minlength="10" maxlength="5000" required placeholder="Describe the completed resolution"></textarea>
            </label>
            <button class="people-button is-primary" type="submit" x-bind:disabled="busy"><span x-text="submitLabel">Resolve ticket</span></button>
        </form>
    </details>
<?php endif; ?>

<?php if($ticket->canClose): ?>
    <details>
        <summary class="people-ops-action-link" aria-label="Close HR ticket <?php echo e($ticket->ticketNumber); ?>">Close</summary>
        <form method="POST" action="<?php echo e(route('hr.helpdesk-tickets.close', $ticket->id)); ?>" x-data="serverFormState" x-on:submit="beginSubmit" x-bind:aria-busy="busyAria" data-idle-label="Close ticket" data-busy-label="Closing…">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <label class="people-field">
                <span>Closure note</span>
                <textarea class="people-control" name="note" rows="2" maxlength="1000" placeholder="Optional closure note"></textarea>
            </label>
            <button class="people-button is-primary" type="submit" x-bind:disabled="busy"><span x-text="submitLabel">Close ticket</span></button>
        </form>
    </details>
<?php endif; ?>

<?php if(! $ticket->canManage && ! $ticket->canClose): ?>
    <span class="people-subtext">No action available</span>
<?php endif; ?>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\operations\partials\helpdesk-actions.blade.php ENDPATH**/ ?>