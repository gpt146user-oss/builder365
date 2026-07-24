<section class="people-ops-panel" aria-labelledby="leave-balances-title">
    <header class="people-ops-panel-head"><div><h2 id="leave-balances-title">Leave balances</h2><p>Posted and pending ledger positions for the selected year.</p></div></header>
    <div class="people-ops-panel-body">
        <form method="GET" action="<?php echo e(route('hr.leave-balances.index')); ?>" class="people-ops-filterbar">
            <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id"><option value="">All employees</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string) request('employee_id') === (string) $employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="people-field"><span>Period year</span><input class="people-control" type="number" name="period_year" min="2000" max="2100" value="<?php echo e(request('period_year')); ?>" placeholder="Any year"></label>
            <button class="people-button" type="submit">Apply filters</button><a class="people-button" href="<?php echo e(route('hr.leave-balances.index')); ?>">Clear</a>
        </form>
    </div>
    <div class="people-ops-table-wrap">
        <table class="people-ops-table">
            <caption>Employee leave balance register</caption>
            <thead><tr><th scope="col">Employee</th><th scope="col">Leave type</th><th scope="col">Year</th><th scope="col" class="is-number">Opening</th><th scope="col" class="is-number">Accrued</th><th scope="col" class="is-number">Used</th><th scope="col" class="is-number">Pending</th><th scope="col" class="is-number">Adjusted</th><th scope="col" class="is-number">Available</th></tr></thead>
            <tbody><?php $__empty_1 = true; $__currentLoopData = $balances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $balance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><div class="people-ops-identity"><div><strong><?php echo e($balance->employeeName); ?></strong><small><?php echo e($balance->employeeCode); ?></small></div></div></td><td><?php echo e($balance->leaveTypeName); ?><small><?php echo e($balance->leaveTypeCode); ?></small></td><td><?php echo e($balance->periodYear); ?></td><td class="is-number"><?php echo e($balance->opening); ?></td><td class="is-number"><?php echo e($balance->accrued); ?></td><td class="is-number"><?php echo e($balance->used); ?></td><td class="is-number"><?php echo e($balance->pending); ?></td><td class="is-number"><?php echo e($balance->adjusted); ?></td><td class="is-number"><strong><?php echo e($balance->available); ?></strong></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="9"><div class="people-ops-empty"><strong>No leave balances found</strong><span>No ledger rows match the selected filters.</span></div></td></tr><?php endif; ?></tbody>
        </table>
    </div>
    <div class="people-pagination"><?php echo e($balances->withQueryString()->links()); ?></div>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\leave\partials\balances.blade.php ENDPATH**/ ?>