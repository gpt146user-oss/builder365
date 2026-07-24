<section class="people-ops-grid is-wide-left" aria-label="Bank transfer controls">
    <article class="people-ops-panel">
        <header class="people-ops-panel-head"><div><h2>Bank transfer controls</h2><p>Bank batches can be prepared only from approved payroll runs.</p></div></header>
        <div class="people-ops-panel-body">
            <ul class="people-ops-checklist">
                <li><i class="fa-solid fa-shield-halved" aria-hidden="true"></i><span>Preparation validates employee bank details, duplicate employees, control totals, and checksums.</span><strong><?php echo e($summary->preparedBatches); ?> prepared</strong></li>
                <li><i class="fa-solid fa-user-lock" aria-hidden="true"></i><span>Release is a separate authorized action and enforces segregation of duties.</span><strong><?php echo e($summary->releasedBatches); ?> released</strong></li>
            </ul>
        </div>
    </article>
    <article class="people-ops-panel">
        <header class="people-ops-panel-head"><div><h2>Batch filters</h2><p>Filter without exposing restricted payment instructions.</p></div></header>
        <div class="people-ops-panel-body">
            <form method="GET" action="<?php echo e(route('payroll.bank-transfer-batches.index')); ?>" class="people-form-grid">
                <label class="people-field"><span>Status</span><select class="people-control" name="status"><option value="">All supported statuses</option><?php $__currentLoopData = $batchStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($status['value']); ?>" <?php if(request('status') === $status['value']): echo 'selected'; endif; ?>><?php echo e($status['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Bank name</span><input class="people-control" name="bank_name" value="<?php echo e(request('bank_name')); ?>" maxlength="120"></label>
                <label class="people-field"><span>From</span><input class="people-control" type="date" name="from" value="<?php echo e(request('from')); ?>"></label>
                <label class="people-field"><span>To</span><input class="people-control" type="date" name="to" value="<?php echo e(request('to')); ?>"></label>
                <?php if($abilities['canViewBankPayload']): ?>
                    <label class="people-field is-wide"><span>Restricted payment instructions</span><select class="people-control" name="include_payload"><option value="">Keep hidden</option><option value="1" <?php if(request('include_payload') === '1'): echo 'selected'; endif; ?>>Show in this authorized session</option></select><small>Contains bank-transfer instructions. It remains hidden unless explicitly disclosed by an authorized payroll approver.</small></label>
                <?php endif; ?>
                <div class="people-modal-actions is-wide"><button type="submit" class="people-button">Apply filters</button><a class="people-button" href="<?php echo e(route('payroll.bank-transfer-batches.index')); ?>">Clear</a></div>
            </form>
        </div>
    </article>
</section>

<?php if(request('include_payload') === '1' && $abilities['canViewBankPayload']): ?>
    <div class="people-alert" role="status"><strong>Restricted disclosure enabled.</strong> Payment instructions below are visible only for this filtered response. Do not share or copy them outside the approved bank-transfer workflow.</div>
<?php endif; ?>

<section class="people-ops-panel" aria-labelledby="bank-batches-title">
    <header class="people-ops-panel-head"><div><h2 id="bank-batches-title">Bank transfer batches</h2><p><?php echo e($batches->total()); ?> batch<?php echo e($batches->total() === 1 ? '' : 'es'); ?> in this authorized register.</p></div></header>
    <div class="people-ops-table-wrap">
        <table class="people-ops-table">
            <caption>Payroll bank transfer batch register</caption>
            <thead><tr><th scope="col">Batch</th><th scope="col">Payroll run</th><th scope="col">Bank / date</th><th scope="col">Status</th><th scope="col" class="is-number">Items</th><th scope="col" class="is-number">Control total</th><th scope="col">Control</th><th scope="col">Prepared / released</th><th scope="col" class="is-actions">Action</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($batch->batchNumber); ?></strong></td>
                        <td><?php echo e($batch->runNumber); ?><small><?php echo e($batch->period); ?></small></td>
                        <td><?php echo e($batch->bankName); ?><small><?php echo e($batch->paymentDate); ?></small></td>
                        <td><span class="people-status is-<?php echo e($batch->status === 'released' ? 'success' : 'warning'); ?>"><?php echo e($batch->statusLabel); ?></span></td>
                        <td class="is-number"><?php echo e(number_format($batch->itemCount)); ?></td>
                        <td class="is-number"><strong><?php echo e($batch->controlTotal); ?></strong></td>
                        <td><?php echo e($batch->checksum); ?></td>
                        <td><?php echo e($batch->preparedBy); ?><?php if($batch->releasedBy): ?><small>Released by <?php echo e($batch->releasedBy); ?></small><?php endif; ?></td>
                        <td class="is-actions">
                            <?php if($batch->canRelease): ?>
                                <form method="POST" action="<?php echo e(route('payroll.bank-transfer-batches.release', $batch->id)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><label class="people-field"><span class="sr-only">Release note for <?php echo e($batch->batchNumber); ?></span><input class="people-control" name="release_note" maxlength="500" placeholder="Release note"></label><button type="submit" class="people-ops-action-link">Release batch</button></form>
                            <?php else: ?><span class="people-subtext">No permitted action</span><?php endif; ?>
                        </td>
                    </tr>
                    <?php if($batch->payload !== null): ?>
                        <tr><td colspan="9"><details><summary>Restricted payment instructions for <?php echo e($batch->batchNumber); ?></summary><pre><?php echo e($batch->payload); ?></pre></details></td></tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="9"><div class="people-ops-empty"><i class="fa-solid fa-building-columns" aria-hidden="true"></i><strong>No bank batches found</strong><span>Clear filters or prepare a batch from an approved payroll run.</span></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="people-pagination"><?php echo e($batches->withQueryString()->links()); ?></div>
</section>
<?php /**PATH /home/developer/public_html/builder360/resources/views/payroll/workspace/partials/bank_batches.blade.php ENDPATH**/ ?>