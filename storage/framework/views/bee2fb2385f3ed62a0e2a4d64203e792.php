<?php ($actionContext = $actionContext ?? 'desktop'); ?>

<?php if($claim->canApprove): ?>
    <details id="claim-approve-<?php echo e($claim->id); ?>-<?php echo e($actionContext); ?>">
        <summary class="people-ops-action-link" aria-label="Approve claim <?php echo e($claim->claimNumber); ?> for <?php echo e($claim->employeeName); ?>">Approve</summary>
        <form
            method="POST"
            action="<?php echo e(route('hr.expense-claims.approve', $claim->id)); ?>"
            x-data="serverFormState"
            x-on:submit="beginSubmit"
            x-bind:aria-busy="busyAria"
            data-idle-label="Approve"
            data-busy-label="Approving…"
        >
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <input class="people-control" type="number" name="approved_amount" value="<?php echo e($claim->approvalAmountInput); ?>" min="1" step="0.01" required aria-label="Approved amount for claim <?php echo e($claim->claimNumber); ?>">
            <input class="people-control" name="decision_note" maxlength="1000" placeholder="Decision note" aria-label="Approval note for claim <?php echo e($claim->claimNumber); ?>">
            <button class="people-button is-primary" type="submit" x-bind:disabled="busy"><span x-text="submitLabel">Approve</span></button>
        </form>
    </details>
<?php endif; ?>

<?php if($claim->canReject): ?>
    <details id="claim-reject-<?php echo e($claim->id); ?>-<?php echo e($actionContext); ?>">
        <summary class="people-ops-action-link is-danger" aria-label="Reject claim <?php echo e($claim->claimNumber); ?> for <?php echo e($claim->employeeName); ?>">Reject</summary>
        <form
            method="POST"
            action="<?php echo e(route('hr.expense-claims.reject', $claim->id)); ?>"
            x-data="serverFormState"
            x-on:submit="beginSubmit"
            x-bind:aria-busy="busyAria"
            data-idle-label="Reject"
            data-busy-label="Rejecting…"
        >
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <textarea class="people-control" name="decision_note" maxlength="1000" required placeholder="Rejection reason" aria-label="Rejection reason for claim <?php echo e($claim->claimNumber); ?>"></textarea>
            <button class="people-button" type="submit" x-bind:disabled="busy"><span x-text="submitLabel">Reject</span></button>
        </form>
    </details>
<?php endif; ?>

<?php if($claim->canPay): ?>
    <details id="claim-pay-<?php echo e($claim->id); ?>-<?php echo e($actionContext); ?>">
        <summary class="people-ops-action-link" aria-label="Mark claim <?php echo e($claim->claimNumber); ?> as paid">Mark paid</summary>
        <form
            method="POST"
            action="<?php echo e(route('hr.expense-claims.pay', $claim->id)); ?>"
            x-data="serverFormState"
            x-on:submit="beginSubmit"
            x-bind:aria-busy="busyAria"
            data-idle-label="Mark paid"
            data-busy-label="Recording payment…"
        >
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <label class="people-field"><span>Audit reference (optional)</span><input class="people-control" name="payment_reference" maxlength="120"></label>
            <textarea class="people-control" name="note" maxlength="1000" placeholder="Payment note" aria-label="Payment note for claim <?php echo e($claim->claimNumber); ?>"></textarea>
            <button class="people-button is-primary" type="submit" x-bind:disabled="busy"><span x-text="submitLabel">Mark paid</span></button>
        </form>
    </details>
<?php endif; ?>

<?php if(! $claim->canApprove && ! $claim->canReject && ! $claim->canPay): ?>
    <span class="people-subtext">No action</span>
<?php endif; ?>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/hr/operations/partials/claim-actions.blade.php ENDPATH**/ ?>