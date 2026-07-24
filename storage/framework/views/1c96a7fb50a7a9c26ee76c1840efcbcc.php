<?php if($abilities['canFinalize']): ?>
    <section class="people-ops-panel people-roster-create">
        <header class="people-ops-panel-head"><div><h2>Finalize attendance period</h2><p>Freezes immutable per-employee payroll attendance snapshots. Pending regularizations block finalization.</p></div><span class="people-status is-warning">Payroll boundary</span></header>
        <form class="people-ops-panel-body people-form-grid" method="POST" action="<?php echo e(route('hr.attendance-periods.finalize')); ?>" data-disable-on-submit>
            <?php echo csrf_field(); ?>
            <label class="people-field">Period start<input class="people-control" type="date" name="period_start" value="<?php echo e(old('period_start', now()->subMonthNoOverflow()->startOfMonth()->toDateString())); ?>" required></label>
            <label class="people-field">Period end<input class="people-control" type="date" name="period_end" value="<?php echo e(old('period_end', now()->subMonthNoOverflow()->endOfMonth()->toDateString())); ?>" max="<?php echo e(now()->toDateString()); ?>" required></label>
            <div class="people-form-actions is-wide"><button class="people-button is-primary" type="submit"><i class="fa-solid fa-lock" aria-hidden="true"></i> Finalize and snapshot</button></div>
        </form>
    </section>
<?php endif; ?>

<section class="people-ops-panel has-mobile-cards">
    <header class="people-ops-panel-head"><div><h2>Attendance period locks</h2><p>Reopening preserves prior snapshots and creates a governed new period version on the next finalization.</p></div><span class="people-count"><?php echo e($periodLocks->total()); ?> periods</span></header>
    <div class="people-ops-table-wrap"><table class="people-ops-table"><caption>Finalized and reopened attendance periods</caption><thead><tr><th scope="col">Period</th><th scope="col">Version</th><th scope="col">Snapshots</th><th scope="col">Finalized by</th><th scope="col">Status</th><th scope="col">Action</th></tr></thead><tbody>
    <?php $__empty_1 = true; $__currentLoopData = $periodLocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr><td><strong><?php echo e($period->period_start->format('d M Y')); ?> – <?php echo e($period->period_end->format('d M Y')); ?></strong><small>Hash <?php echo e(str($period->source_hash)->limit(18)); ?></small></td><td>v<?php echo e($period->version); ?></td><td><?php echo e($period->snapshots_count); ?></td><td><?php echo e($period->finalizedBy?->name ?: 'System'); ?><small><?php echo e($period->finalized_at?->format('d M Y, H:i')); ?></small></td><td><span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['people-status', 'is-success' => $period->status === 'finalized', 'is-warning' => $period->status === 'reopened']); ?>"><?php echo e(str($period->status)->headline()); ?></span><?php if($period->reopen_reason): ?><small><?php echo e($period->reopen_reason); ?></small><?php endif; ?></td><td>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('reopen', $period)): ?>
                <form class="people-inline-form" method="POST" action="<?php echo e(route('hr.attendance-periods.reopen', $period)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><input type="hidden" name="lock_version" value="<?php echo e($period->lock_version); ?>"><input class="people-control" name="reopen_reason" placeholder="Required reopen reason" required maxlength="2000"><button class="people-button is-danger" type="submit">Reopen</button></form>
            <?php else: ?><span class="people-muted">Immutable</span><?php endif; ?>
        </td></tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="6"><div class="people-ops-empty"><i class="fa-solid fa-lock-open" aria-hidden="true"></i><strong>No finalized periods</strong><span>Finalize attendance only after exceptions and regularizations are resolved.</span></div></td></tr>
    <?php endif; ?>
    </tbody></table></div>
    <div class="people-ops-mobile-list"><?php $__currentLoopData = $periodLocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><article class="people-ops-mobile-card"><header class="people-ops-mobile-card-head"><div><strong><?php echo e($period->period_start->format('d M')); ?> – <?php echo e($period->period_end->format('d M Y')); ?></strong><small>Version <?php echo e($period->version); ?></small></div><span class="people-status is-success"><?php echo e(str($period->status)->headline()); ?></span></header><dl class="people-ops-mobile-facts"><div><dt>Snapshots</dt><dd><?php echo e($period->snapshots_count); ?></dd></div><div><dt>Finalized by</dt><dd><?php echo e($period->finalizedBy?->name ?: 'System'); ?></dd></div></dl></article><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
    <div class="people-pagination"><span>Showing <?php echo e($periodLocks->firstItem() ?? 0); ?> to <?php echo e($periodLocks->lastItem() ?? 0); ?> of <?php echo e($periodLocks->total()); ?></span><?php echo e($periodLocks->links()); ?></div>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\attendance\rosters\periods.blade.php ENDPATH**/ ?>