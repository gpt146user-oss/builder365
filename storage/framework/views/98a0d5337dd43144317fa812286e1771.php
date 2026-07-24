<section class="people-alert" role="note">
    <strong>Effective assignment history.</strong> Create overlap-protected assignments and manage dated rosters, rotations, and swaps in
    <a href="<?php echo e(route('hr.attendance-rosters.index')); ?>">Shifts &amp; Rosters</a>.
</section>

<section class="people-ops-panel has-mobile-cards">
    <header class="people-ops-panel-head"><div><h2>Effective shift assignments</h2><p>Active employee-to-shift relationships in your permitted scope.</p></div><span class="people-count"><?php echo e($assignments->total()); ?> assignments</span></header>

    <div class="people-ops-table-wrap">
        <table class="people-ops-table">
            <caption>Current effective employee shift assignments</caption>
            <thead><tr><th scope="col">Employee</th><th scope="col">Department / branch</th><th scope="col">Shift</th><th scope="col">Effective from</th><th scope="col">Effective to</th><th scope="col">Status</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><div class="people-ops-identity"><span class="people-avatar"><?php echo e($assignment->employeeInitial); ?></span><div><strong><?php echo e($assignment->employeeName); ?></strong><small><?php echo e($assignment->employeeCode); ?></small></div></div></td>
                        <td><strong><?php echo e($assignment->department); ?></strong><small><?php echo e($assignment->branch); ?></small></td>
                        <td><strong><?php echo e($assignment->shiftCode); ?> / <?php echo e($assignment->shiftName); ?></strong><small><?php echo e($assignment->shiftTiming); ?></small></td>
                        <td><?php echo e($assignment->effectiveFrom); ?></td>
                        <td><?php echo e($assignment->effectiveTo); ?></td>
                        <td><span class="people-status is-success"><?php echo e($assignment->statusLabel); ?></span></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6"><div class="people-ops-empty"><i class="fa-solid fa-user-clock" aria-hidden="true"></i><strong>No active shift assignments</strong><span>No stored active assignments are visible in your authorized employee scope.</span></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="people-ops-mobile-list">
        <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="people-ops-mobile-card">
                <header class="people-ops-mobile-card-head"><div class="people-ops-identity"><span class="people-avatar"><?php echo e($assignment->employeeInitial); ?></span><div><strong><?php echo e($assignment->employeeName); ?></strong><small><?php echo e($assignment->employeeCode); ?></small></div></div><span class="people-status is-success"><?php echo e($assignment->statusLabel); ?></span></header>
                <dl class="people-ops-mobile-facts"><div><dt>Team</dt><dd><?php echo e($assignment->department); ?> / <?php echo e($assignment->branch); ?></dd></div><div><dt>Shift</dt><dd><?php echo e($assignment->shiftCode); ?> / <?php echo e($assignment->shiftName); ?></dd></div><div><dt>Timing</dt><dd><?php echo e($assignment->shiftTiming); ?></dd></div><div><dt>Effective</dt><dd><?php echo e($assignment->effectiveFrom); ?> to <?php echo e($assignment->effectiveTo); ?></dd></div></dl>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="people-pagination"><span>Showing <?php echo e($assignments->firstItem() ?? 0); ?> to <?php echo e($assignments->lastItem() ?? 0); ?> of <?php echo e($assignments->total()); ?></span><?php echo e($assignments->withQueryString()->links()); ?></div>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\attendance\partials\assignments.blade.php ENDPATH**/ ?>