<section class="people-ops-kpis" aria-label="Attendance summary" data-summary-total="<?php echo e($summary->total); ?>">
    <article class="people-ops-kpi is-success">
        <span class="people-ops-kpi-icon"><i class="fa-solid fa-user-check" aria-hidden="true"></i></span>
        <span>Present</span>
        <strong><?php echo e($summary->present); ?></strong>
        <small>Stored present results in the selected date and employee scope</small>
    </article>
    <article class="people-ops-kpi is-warning">
        <span class="people-ops-kpi-icon"><i class="fa-solid fa-clock" aria-hidden="true"></i></span>
        <span>Late</span>
        <strong><?php echo e($summary->late); ?></strong>
        <small>Records beyond the linked shift grace threshold</small>
    </article>
    <article class="people-ops-kpi is-warning">
        <span class="people-ops-kpi-icon"><i class="fa-solid fa-person-walking-arrow-right" aria-hidden="true"></i></span>
        <span>Early leaving</span>
        <strong><?php echo e($summary->earlyLeave); ?></strong>
        <small>Stored early-leave results in your authorized scope</small>
    </article>
    <article class="people-ops-kpi is-purple">
        <span class="people-ops-kpi-icon"><i class="fa-solid fa-circle-half-stroke" aria-hidden="true"></i></span>
        <span>Half-day</span>
        <strong><?php echo e($summary->halfDay); ?></strong>
        <small>Records classified below the configured full-day threshold</small>
    </article>
    <article class="people-ops-kpi is-danger">
        <span class="people-ops-kpi-icon"><i class="fa-solid fa-user-xmark" aria-hidden="true"></i></span>
        <span>Absent</span>
        <strong><?php echo e($summary->absent); ?></strong>
        <small><?php echo e($summary->attendanceRate); ?>% attendance coverage across <?php echo e($summary->total); ?> records</small>
    </article>
</section>

<section class="people-ops-grid is-wide-left">
    <article class="people-ops-panel has-mobile-cards">
        <header class="people-ops-panel-head">
            <div>
                <h2>Attendance register</h2>
                <p>Persisted results from the complete authorized attendance query.</p>
            </div>
            <span class="people-count"><?php echo e($records->total()); ?> records</span>
        </header>

        <form method="GET" action="<?php echo e(route('hr.attendance-records.index')); ?>" class="people-ops-filterbar">
            <label class="people-field">
                Employee
                <select class="people-control" name="employee_id">
                    <option value="">All visible employees</option>
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($employee->id); ?>" <?php if((string) request('employee_id') === (string) $employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>
            <label class="people-field">
                Status
                <select class="people-control" name="status">
                    <option value="">All statuses</option>
                    <?php $__currentLoopData = $statusFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($status['value']); ?>" <?php if(request('status') === $status['value']): echo 'selected'; endif; ?>><?php echo e($status['label']); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>
            <label class="people-field">
                Date from
                <input class="people-control" type="date" name="date_from" value="<?php echo e(request('date_from')); ?>">
            </label>
            <label class="people-field">
                Date to
                <input class="people-control" type="date" name="date_to" value="<?php echo e(request('date_to')); ?>">
            </label>
            <button type="submit" class="people-button"><i class="fa-solid fa-filter" aria-hidden="true"></i> Apply</button>
            <?php if(request()->hasAny(['employee_id', 'status', 'date_from', 'date_to'])): ?>
                <a class="people-button" href="<?php echo e(route('hr.attendance-records.index')); ?>">Clear</a>
            <?php endif; ?>
        </form>

        <div class="people-ops-table-wrap">
            <table class="people-ops-table">
                <caption>Attendance records for the selected filters</caption>
                <thead><tr><th scope="col">Date</th><th scope="col">Employee</th><th scope="col">Shift</th><th scope="col">Check-in</th><th scope="col">Check-out</th><th scope="col">Status</th><th scope="col" class="is-number">Late</th><th scope="col" class="is-number">Early</th><th scope="col" class="is-number">Worked</th><th scope="col">Source</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($record->workDate); ?></td>
                            <td><div class="people-ops-identity"><span class="people-avatar"><?php echo e($record->employeeInitial); ?></span><div><strong><?php echo e($record->employeeName); ?></strong><small><?php echo e($record->employeeCode); ?> / <?php echo e($record->branch); ?></small></div></div></td>
                            <td><strong><?php echo e($record->shiftCode); ?></strong><small><?php echo e($record->shiftName); ?> / <?php echo e($record->shiftTiming); ?></small></td>
                            <td><?php echo e($record->checkIn); ?></td>
                            <td><?php echo e($record->checkOut); ?></td>
                            <td><span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['people-status', 'is-success' => $record->status === 'present', 'is-warning' => in_array($record->status, ['late', 'early_leave', 'half_day'], true), 'is-danger' => $record->status === 'absent', 'is-muted' => ! in_array($record->status, ['present', 'late', 'early_leave', 'half_day', 'absent'], true)]); ?>"><?php echo e($record->statusLabel); ?></span></td>
                            <td class="is-number"><?php echo e($record->lateMinutes); ?> min</td>
                            <td class="is-number"><?php echo e($record->earlyLeaveMinutes); ?> min</td>
                            <td class="is-number"><?php echo e($record->workedMinutes); ?> min</td>
                            <td><?php echo e($record->sourceLabel); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="10"><div class="people-ops-empty"><i class="fa-solid fa-calendar-xmark" aria-hidden="true"></i><strong>No attendance records</strong><span>No records match the selected employee, status, and date filters.</span></div></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="people-ops-mobile-list">
            <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="people-ops-mobile-card">
                    <header class="people-ops-mobile-card-head"><div class="people-ops-identity"><span class="people-avatar"><?php echo e($record->employeeInitial); ?></span><div><strong><?php echo e($record->employeeName); ?></strong><small><?php echo e($record->employeeCode); ?></small></div></div><span class="people-status is-muted"><?php echo e($record->statusLabel); ?></span></header>
                    <dl class="people-ops-mobile-facts"><div><dt>Date</dt><dd><?php echo e($record->workDate); ?></dd></div><div><dt>Shift</dt><dd><?php echo e($record->shiftCode); ?> / <?php echo e($record->shiftTiming); ?></dd></div><div><dt>Check-in</dt><dd><?php echo e($record->checkIn); ?></dd></div><div><dt>Check-out</dt><dd><?php echo e($record->checkOut); ?></dd></div><div><dt>Exceptions</dt><dd>Late <?php echo e($record->lateMinutes); ?> min / Early <?php echo e($record->earlyLeaveMinutes); ?> min</dd></div><div><dt>Worked</dt><dd><?php echo e($record->workedMinutes); ?> min</dd></div></dl>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="people-pagination"><span>Showing <?php echo e($records->firstItem() ?? 0); ?> to <?php echo e($records->lastItem() ?? 0); ?> of <?php echo e($records->total()); ?></span><?php echo e($records->withQueryString()->links()); ?></div>
    </article>

    <aside class="people-ops-panel">
        <header class="people-ops-panel-head"><div><h2>Site attendance coverage</h2><p>Distinct employees marked present-like within the selected period.</p></div></header>
        <?php $__empty_1 = true; $__currentLoopData = $siteAttendance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="people-ops-panel-body">
                <strong><?php echo e($site['location']); ?></strong>
                <div class="people-ops-progress"><progress max="100" value="<?php echo e($site['coverage']); ?>"><?php echo e($site['coverage']); ?>%</progress><span><?php echo e($site['coverage']); ?>%</span></div>
                <small><?php echo e($site['marked']); ?> marked of <?php echo e($site['strength']); ?> active employees</small>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="people-ops-empty"><i class="fa-solid fa-location-dot" aria-hidden="true"></i><strong>No site coverage available</strong><span>No active employee branch data is available in your authorized scope.</span></div>
        <?php endif; ?>
    </aside>
</section>
<?php /**PATH /home/developer/public_html/builder360/resources/views/hr/attendance/partials/records.blade.php ENDPATH**/ ?>