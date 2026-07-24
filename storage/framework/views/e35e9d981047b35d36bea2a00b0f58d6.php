<section class="people-ops-kpis is-four" aria-label="Attendance exception summary">
    <article class="people-ops-kpi is-warning"><span class="people-ops-kpi-icon"><i class="fa-solid fa-clock" aria-hidden="true"></i></span><span>Late</span><strong><?php echo e($summary->late); ?></strong><small>Stored results beyond the linked shift grace</small></article>
    <article class="people-ops-kpi is-warning"><span class="people-ops-kpi-icon"><i class="fa-solid fa-person-walking-arrow-right" aria-hidden="true"></i></span><span>Early leaving</span><strong><?php echo e($summary->earlyLeave); ?></strong><small>Stored early-leave classifications</small></article>
    <article class="people-ops-kpi is-purple"><span class="people-ops-kpi-icon"><i class="fa-solid fa-circle-half-stroke" aria-hidden="true"></i></span><span>Half-day</span><strong><?php echo e($summary->halfDay); ?></strong><small>Below the configured full-day threshold</small></article>
    <article class="people-ops-kpi is-danger"><span class="people-ops-kpi-icon"><i class="fa-solid fa-user-xmark" aria-hidden="true"></i></span><span>Absent</span><strong><?php echo e($summary->absent); ?></strong><small>Persisted absent records in scope</small></article>
</section>

<section class="people-ops-panel">
    <header class="people-ops-panel-head">
        <div><h2>Attendance exceptions</h2><p>Review stored exceptions and their linked shift calculation basis.</p></div>
        <span class="people-count"><?php echo e($records->total()); ?> exceptions</span>
    </header>

    <form method="GET" action="<?php echo e(route('hr.attendance-records.index')); ?>" class="people-ops-filterbar">
        <input type="hidden" name="view" value="exceptions">
        <label class="people-field">Employee<select class="people-control" name="employee_id"><option value="">All visible employees</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string) request('employee_id') === (string) $employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
        <label class="people-field">Exception type<select class="people-control" name="status"><option value="">All exception types</option><?php $__currentLoopData = $statusFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(in_array($status['value'], ['late', 'early_leave', 'half_day', 'absent'], true)): ?><option value="<?php echo e($status['value']); ?>" <?php if(request('status') === $status['value']): echo 'selected'; endif; ?>><?php echo e($status['label']); ?></option><?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
        <label class="people-field">Date from<input class="people-control" type="date" name="date_from" value="<?php echo e(request('date_from')); ?>"></label>
        <label class="people-field">Date to<input class="people-control" type="date" name="date_to" value="<?php echo e(request('date_to')); ?>"></label>
        <button class="people-button" type="submit"><i class="fa-solid fa-filter" aria-hidden="true"></i> Apply</button>
        <?php if(request()->hasAny(['employee_id', 'status', 'date_from', 'date_to'])): ?><a class="people-button" href="<?php echo e(route('hr.attendance-records.index', ['view' => 'exceptions'])); ?>">Clear</a><?php endif; ?>
    </form>

    <div class="people-alert" role="note">
        <strong>Explainable stored result.</strong> This screen displays the persisted attendance outcome and linked shift thresholds; it does not recalculate or override attendance policy.
    </div>

    <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <article class="people-ops-list-row">
            <span class="people-avatar"><?php echo e($record->employeeInitial); ?></span>
            <div class="people-ops-list-copy">
                <strong><?php echo e($record->employeeName); ?> / <?php echo e($record->statusLabel); ?></strong>
                <span><?php echo e($record->workDate); ?> / <?php echo e($record->shiftName); ?> / <?php echo e($record->branch); ?></span>
                <small><?php echo e($record->calculationBasis); ?></small>
            </div>
            <div class="people-ops-list-actions">
                <?php if($record->lateMinutes > 0): ?><span class="people-status is-warning">Late <?php echo e($record->lateMinutes); ?> min</span><?php endif; ?>
                <?php if($record->earlyLeaveMinutes > 0): ?><span class="people-status is-warning">Early <?php echo e($record->earlyLeaveMinutes); ?> min</span><?php endif; ?>
                <?php if($record->status === 'absent'): ?><span class="people-status is-danger">Absent</span><?php endif; ?>
                <span class="people-status is-muted"><?php echo e($record->workedMinutes); ?> min worked</span>
            </div>
        </article>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="people-ops-empty"><i class="fa-solid fa-circle-check" aria-hidden="true"></i><strong>No attendance exceptions</strong><span>No stored exceptions match the selected employee and date filters.</span></div>
    <?php endif; ?>

    <div class="people-pagination"><span>Showing <?php echo e($records->firstItem() ?? 0); ?> to <?php echo e($records->lastItem() ?? 0); ?> of <?php echo e($records->total()); ?></span><?php echo e($records->withQueryString()->links()); ?></div>
</section>
<?php /**PATH /home/developer/public_html/builder360/resources/views/hr/attendance/partials/exceptions.blade.php ENDPATH**/ ?>