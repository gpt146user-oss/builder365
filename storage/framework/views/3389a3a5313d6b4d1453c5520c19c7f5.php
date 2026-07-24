<?php if($asset->canAssign): ?>
    <details>
        <summary class="people-ops-action-link" aria-label="Assign asset <?php echo e($asset->assetCode); ?>">Assign</summary>
        <form method="POST" action="<?php echo e(route('hr.assets.assign', $asset->id)); ?>" x-data="serverFormState" x-on:submit="beginSubmit" x-bind:aria-busy="busyAria" data-idle-label="Assign asset" data-busy-label="Assigning…">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <label class="people-field">
                <span>Employee</span>
                <select class="people-control" name="employee_id" required>
                    <option value="">Select employee</option>
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>
            <label class="people-field">
                <span>Assigned on</span>
                <input class="people-control" type="date" name="assigned_on" value="<?php echo e(now()->toDateString()); ?>" max="<?php echo e(now()->toDateString()); ?>">
            </label>
            <label class="people-field">
                <span>Assignment note</span>
                <textarea class="people-control" name="note" maxlength="1000" rows="2" placeholder="Optional governed assignment note"></textarea>
            </label>
            <button class="people-button is-primary" type="submit" x-bind:disabled="busy"><span x-text="submitLabel">Assign asset</span></button>
        </form>
    </details>
<?php endif; ?>

<?php if($asset->canRecover): ?>
    <details>
        <summary class="people-ops-action-link" aria-label="Recover asset <?php echo e($asset->assetCode); ?> from <?php echo e($asset->employeeName); ?>">Recover</summary>
        <form method="POST" action="<?php echo e(route('hr.assets.recover', $asset->id)); ?>" x-data="serverFormState" x-on:submit="beginSubmit" x-bind:aria-busy="busyAria" data-idle-label="Record recovery" data-busy-label="Recording…">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <label class="people-field">
                <span>Condition</span>
                <select class="people-control" name="condition" required>
                    <?php $__currentLoopData = $assetConditions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($condition); ?>" <?php if($asset->condition === $condition): echo 'selected'; endif; ?>><?php echo e(ucfirst($condition)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>
            <label class="people-field">
                <span>Outcome</span>
                <select class="people-control" name="status">
                    <option value="recovered">Recovered</option>
                    <option value="retired">Retired</option>
                    <option value="lost">Lost</option>
                </select>
            </label>
            <label class="people-field">
                <span>Recovered on</span>
                <input class="people-control" type="date" name="recovered_on" value="<?php echo e(now()->toDateString()); ?>" max="<?php echo e(now()->toDateString()); ?>">
            </label>
            <label class="people-field">
                <span>Recovery note</span>
                <textarea class="people-control" name="note" maxlength="1000" rows="2" placeholder="Optional governed recovery note"></textarea>
            </label>
            <button class="people-button is-primary" type="submit" x-bind:disabled="busy"><span x-text="submitLabel">Record recovery</span></button>
        </form>
    </details>
<?php endif; ?>

<?php if(! $asset->canAssign && ! $asset->canRecover): ?>
    <span class="people-subtext">No action available</span>
<?php endif; ?>
<?php /**PATH /home/developer/public_html/builder360/resources/views/hr/operations/partials/asset-actions.blade.php ENDPATH**/ ?>