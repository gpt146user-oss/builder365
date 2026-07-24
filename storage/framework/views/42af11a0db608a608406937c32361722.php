<?php ($actionContext = $actionContext ?? 'desktop'); ?>

<?php if($document->canDownload): ?>
    <a
        class="<?php echo e($actionContext === 'mobile' ? 'people-button' : 'people-ops-action-link'); ?>"
        href="<?php echo e(route('documents.download', $document->id)); ?>"
        aria-label="Download <?php echo e($document->title); ?> for <?php echo e($document->employeeName); ?>"
    >Download</a>
<?php endif; ?>

<?php if($document->canApprove): ?>
    <details id="document-approve-<?php echo e($document->id); ?>-<?php echo e($actionContext); ?>">
        <summary class="people-ops-action-link" aria-label="Approve document <?php echo e($document->documentNumber); ?> for <?php echo e($document->employeeName); ?>">Approve</summary>
        <form
            method="POST"
            action="<?php echo e(route('hr.employees.documents.approve', [$document->employeeId, $document->id])); ?>"
            x-data="serverFormState"
            x-on:submit="beginSubmit"
            x-bind:aria-busy="busyAria"
            data-idle-label="Approve"
            data-busy-label="Approving…"
        >
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <input class="people-control" name="approval_note" maxlength="1000" placeholder="Approval note" aria-label="Approval note for document <?php echo e($document->documentNumber); ?>">
            <button class="people-button is-primary" type="submit" x-bind:disabled="busy"><span x-text="submitLabel">Approve</span></button>
        </form>
    </details>
<?php endif; ?>

<?php if(! $document->canDownload && ! $document->canApprove): ?>
    <span class="people-subtext">No action</span>
<?php endif; ?>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\documents\partials\document-actions.blade.php ENDPATH**/ ?>