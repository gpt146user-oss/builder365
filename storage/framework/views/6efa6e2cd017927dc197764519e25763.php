<?php ($actionContext = $actionContext ?? 'desktop'); ?>

<?php if($setting->canVerify): ?>
    <details id="compliance-verify-<?php echo e($setting->id); ?>-<?php echo e($actionContext); ?>">
        <summary class="people-ops-action-link" aria-label="Verify official source evidence for <?php echo e($setting->label); ?> version <?php echo e($setting->version); ?>">Verify source</summary>
        <form
            method="POST"
            action="<?php echo e(route('hr.compliance-rule-settings.verify', $setting->id)); ?>"
            x-data="serverFormState"
            x-on:submit="beginSubmit"
            x-bind:aria-busy="busyAria"
            data-idle-label="Record independent verification"
            data-busy-label="Recording verification..."
        >
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <label class="people-field">
                <span>Independent attestation</span>
                <textarea class="people-control" name="attestation" minlength="20" maxlength="2000" rows="4" required placeholder="Confirm which official source, checksum and effective period you independently reviewed."></textarea>
            </label>
            <p class="people-subtext">The creator cannot verify this version. A different authorized user must approve it after verification.</p>
            <button class="people-button is-primary" type="submit" x-bind:disabled="busy"><span x-text="submitLabel">Record independent verification</span></button>
        </form>
    </details>
<?php endif; ?>

<?php if($setting->canApprove): ?>
    <details id="compliance-approve-<?php echo e($setting->id); ?>-<?php echo e($actionContext); ?>">
        <summary class="people-ops-action-link" aria-label="Review <?php echo e($setting->label); ?> version <?php echo e($setting->version); ?>">Review draft</summary>
        <form
            method="POST"
            action="<?php echo e(route('hr.compliance-rule-settings.approve', $setting->id)); ?>"
            x-data="serverFormState"
            x-on:submit="beginSubmit"
            x-bind:aria-busy="busyAria"
            data-idle-label="Approve and activate"
            data-busy-label="Activating..."
        >
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <input class="people-control" name="note" maxlength="1000" placeholder="Approval note" aria-label="Approval note for <?php echo e($setting->label); ?> version <?php echo e($setting->version); ?>">
            <button class="people-button is-primary" type="submit" x-bind:disabled="busy"><span x-text="submitLabel">Approve and activate</span></button>
        </form>
    </details>
<?php elseif(! $setting->canVerify): ?>
    <span class="people-subtext">No action</span>
<?php endif; ?>
<?php /**PATH /home/developer/public_html/builder360/resources/views/hr/compliance/partials/rule-actions.blade.php ENDPATH**/ ?>