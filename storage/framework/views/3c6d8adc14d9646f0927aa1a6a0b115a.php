<section class="people-ops-panel" aria-labelledby="leave-policy-title">
    <header class="people-ops-panel-head"><div><h2 id="leave-policy-title">Leave policy controls</h2><p>Active persisted leave policies. No leave rule is hardcoded in this screen.</p></div><?php if(!$abilities['canManageLeave']): ?><span class="people-status">Read only</span><?php endif; ?></header>
    <div class="people-ops-controls-grid">
        <?php $__empty_1 = true; $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $policy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="people-ops-control">
                <strong><?php echo e($policy->code); ?> - <?php echo e($policy->name); ?></strong>
                <span><small>Annual entitlement</small><?php echo e($policy->annualEntitlement); ?></span>
                <span><small>Payment</small><?php echo e($policy->paidLabel); ?></span>
                <span><small>Carry forward</small><?php echo e($policy->carryForwardLabel); ?></span>
                <span><small>Encashment</small><?php echo e($policy->encashmentLabel); ?></span>
                <span><small>Partial day</small><?php echo e($policy->halfDayLabel); ?></span>
                <span><small>Supporting evidence</small><?php echo e($policy->documentLabel); ?></span>
                <span><small>Balance control</small><?php echo e($policy->negativeBalanceLabel); ?></span>
                <span><small>Approval chain</small><?php echo e($policy->approvalChain); ?></span>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="people-ops-empty"><strong>No active leave policies</strong><span>An authorized administrator must configure and activate leave types before requests can be submitted.</span></div>
        <?php endif; ?>
    </div>
    <div class="people-pagination"><?php echo e($types->withQueryString()->links()); ?></div>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/hr/leave/partials/types.blade.php ENDPATH**/ ?>