<?php ($actionContext = $actionContext ?? 'desktop'); ?>

<?php if($loan->canApprove): ?>
    <details id="loan-approve-<?php echo e($loan->id); ?>-<?php echo e($actionContext); ?>">
        <summary class="people-ops-action-link" aria-label="Approve loan <?php echo e($loan->loanNumber); ?> for <?php echo e($loan->employeeName); ?>">Approve</summary>
        <form
            method="POST"
            action="<?php echo e(route('hr.loans.approve', $loan->id)); ?>"
            x-data="serverFormState"
            x-on:submit="beginSubmit"
            x-bind:aria-busy="busyAria"
            data-idle-label="Approve"
            data-busy-label="Approving…"
        >
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <input class="people-control" type="number" name="approved_amount" value="<?php echo e($loan->approvalAmountInput); ?>" min="1000" step="0.01" required aria-label="Approved amount for loan <?php echo e($loan->loanNumber); ?>">
            <label class="people-field"><span>Repayment starts</span><input class="people-control" type="date" name="repayment_starts_on" value="<?php echo e($loan->repaymentStartsOnInput); ?>" required></label>
            <input class="people-control" name="decision_note" maxlength="1000" placeholder="Decision note" aria-label="Approval note for loan <?php echo e($loan->loanNumber); ?>">
            <button class="people-button is-primary" type="submit" x-bind:disabled="busy"><span x-text="submitLabel">Approve</span></button>
        </form>
    </details>
<?php endif; ?>

<?php if($loan->canReject): ?>
    <details id="loan-reject-<?php echo e($loan->id); ?>-<?php echo e($actionContext); ?>">
        <summary class="people-ops-action-link is-danger" aria-label="Reject loan <?php echo e($loan->loanNumber); ?> for <?php echo e($loan->employeeName); ?>">Reject</summary>
        <form
            method="POST"
            action="<?php echo e(route('hr.loans.reject', $loan->id)); ?>"
            x-data="serverFormState"
            x-on:submit="beginSubmit"
            x-bind:aria-busy="busyAria"
            data-idle-label="Reject"
            data-busy-label="Rejecting…"
        >
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <textarea class="people-control" name="decision_note" maxlength="1000" required placeholder="Rejection reason" aria-label="Rejection reason for loan <?php echo e($loan->loanNumber); ?>"></textarea>
            <button class="people-button" type="submit" x-bind:disabled="busy"><span x-text="submitLabel">Reject</span></button>
        </form>
    </details>
<?php endif; ?>

<?php if($loan->canDisburse): ?>
    <details id="loan-disburse-<?php echo e($loan->id); ?>-<?php echo e($actionContext); ?>">
        <summary class="people-ops-action-link" aria-label="Disburse loan <?php echo e($loan->loanNumber); ?> for <?php echo e($loan->employeeName); ?>">Disburse</summary>
        <form
            method="POST"
            action="<?php echo e(route('hr.loans.disburse', $loan->id)); ?>"
            x-data="serverFormState"
            x-on:submit="beginSubmit"
            x-bind:aria-busy="busyAria"
            data-idle-label="Disburse"
            data-busy-label="Disbursing…"
        >
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <label class="people-field"><span>Audit reference (optional)</span><input class="people-control" name="payment_reference" maxlength="120"></label>
            <textarea class="people-control" name="note" maxlength="1000" placeholder="Disbursement note" aria-label="Disbursement note for loan <?php echo e($loan->loanNumber); ?>"></textarea>
            <button class="people-button is-primary" type="submit" x-bind:disabled="busy"><span x-text="submitLabel">Disburse</span></button>
        </form>
    </details>
<?php endif; ?>

<?php if(! $loan->canApprove && ! $loan->canReject && ! $loan->canDisburse): ?>
    <span class="people-subtext">No action</span>
<?php endif; ?>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/hr/operations/partials/loan-actions.blade.php ENDPATH**/ ?>