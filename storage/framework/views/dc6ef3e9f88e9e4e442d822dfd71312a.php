<section class="people-ops-panel">
    <header class="people-ops-panel-head">
        <div>
            <h2>Attendance calculation trace</h2>
            <p>Recorded inputs, the current linked shift definition, and the persisted attendance result.</p>
        </div>
        <span class="people-count"><?php echo e($calculationTraces->total()); ?> records</span>
    </header>

    <form method="GET" action="<?php echo e(route('hr.attendance-records.index')); ?>" class="people-ops-filterbar">
        <input type="hidden" name="view" value="trace">
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
            Stored result
            <select class="people-control" name="status">
                <option value="">All results</option>
                <?php $__currentLoopData = $statusFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($status['value']); ?>" <?php if(request('status') === $status['value']): echo 'selected'; endif; ?>><?php echo e($status['label']); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </label>
        <label class="people-field">Date from<input class="people-control" type="date" name="date_from" value="<?php echo e(request('date_from')); ?>"></label>
        <label class="people-field">Date to<input class="people-control" type="date" name="date_to" value="<?php echo e(request('date_to')); ?>"></label>
        <button class="people-button" type="submit"><i class="fa-solid fa-filter" aria-hidden="true"></i> Apply</button>
        <?php if(request()->hasAny(['employee_id', 'status', 'date_from', 'date_to'])): ?>
            <a class="people-button" href="<?php echo e(route('hr.attendance-records.index', ['view' => 'trace'])); ?>">Clear</a>
        <?php endif; ?>
    </form>

    <div class="people-alert" role="note">
        <strong>Evidence boundary.</strong> The trace never recalculates attendance. Shift values are the current linked definition because a calculation-time rule snapshot and provider punch stream are not stored on attendance records.
    </div>

    <div class="people-ops-panel-body">
        <div class="people-ops-stack">
            <?php $__empty_1 = true; $__currentLoopData = $calculationTraces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trace): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <details class="people-processing-details">
                    <summary>
                        <?php echo e($trace->employeeName); ?> / <?php echo e($trace->workDate); ?> / <?php echo e($trace->statusLabel); ?>

                    </summary>
                    <div class="people-processing-details-body">
                        <section aria-labelledby="attendance-inputs-<?php echo e($trace->recordId); ?>">
                            <h3 id="attendance-inputs-<?php echo e($trace->recordId); ?>">1. Recorded inputs</h3>
                            <dl class="people-processing-rules">
                                <div><dt>Employee</dt><dd><?php echo e($trace->employeeCode); ?> / <?php echo e($trace->employeeName); ?></dd></div>
                                <div><dt>Branch</dt><dd><?php echo e($trace->branch); ?></dd></div>
                                <div><dt>Work date</dt><dd><?php echo e($trace->workDate); ?></dd></div>
                                <div><dt>Source</dt><dd><?php echo e($trace->sourceLabel); ?></dd></div>
                                <div><dt>Check-in</dt><dd><?php echo e($trace->checkIn); ?></dd></div>
                                <div><dt>Check-out</dt><dd><?php echo e($trace->checkOut); ?></dd></div>
                                <?php if($trace->regularizationRequestNumber): ?>
                                    <div class="is-wide"><dt>Regularization request</dt><dd><?php echo e($trace->regularizationRequestNumber); ?></dd></div>
                                <?php endif; ?>
                            </dl>
                        </section>

                        <section aria-labelledby="attendance-shift-<?php echo e($trace->recordId); ?>">
                            <h3 id="attendance-shift-<?php echo e($trace->recordId); ?>">2. Current linked shift</h3>
                            <?php if($trace->hasLinkedShift): ?>
                                <dl class="people-processing-rules">
                                    <div><dt>Shift</dt><dd><?php echo e($trace->shiftCode); ?> / <?php echo e($trace->shiftName); ?></dd></div>
                                    <div><dt>Timing</dt><dd><?php echo e($trace->shiftTiming); ?></dd></div>
                                    <div><dt>Overnight</dt><dd><?php echo e($trace->overnight ? 'Yes' : 'No'); ?></dd></div>
                                    <div><dt>Late grace</dt><dd><?php echo e($trace->lateGraceMinutes); ?> min</dd></div>
                                    <div><dt>Early-leave grace</dt><dd><?php echo e($trace->earlyLeaveGraceMinutes); ?> min</dd></div>
                                    <div><dt>Half-day threshold</dt><dd><?php echo e($trace->halfDayThresholdMinutes); ?> min</dd></div>
                                    <div><dt>Full-day threshold</dt><dd><?php echo e($trace->fullDayThresholdMinutes); ?> min</dd></div>
                                </dl>
                            <?php else: ?>
                                <div class="people-ops-empty">
                                    <i class="fa-solid fa-link-slash" aria-hidden="true"></i>
                                    <strong>No linked shift</strong>
                                    <span>No persisted shift definition is available for this record.</span>
                                </div>
                            <?php endif; ?>
                        </section>

                        <section aria-labelledby="attendance-result-<?php echo e($trace->recordId); ?>">
                            <h3 id="attendance-result-<?php echo e($trace->recordId); ?>">3. Persisted result</h3>
                            <dl class="people-processing-rules">
                                <div><dt>Status</dt><dd><?php echo e($trace->statusLabel); ?></dd></div>
                                <div><dt>Worked</dt><dd><?php echo e($trace->workedMinutes); ?> min</dd></div>
                                <div><dt>Late</dt><dd><?php echo e($trace->lateMinutes); ?> min</dd></div>
                                <div><dt>Early leave</dt><dd><?php echo e($trace->earlyLeaveMinutes); ?> min</dd></div>
                            </dl>
                        </section>

                        <section aria-labelledby="attendance-provenance-<?php echo e($trace->recordId); ?>">
                            <h3 id="attendance-provenance-<?php echo e($trace->recordId); ?>">Provenance</h3>
                            <p><?php echo e($trace->provenanceNote); ?></p>
                        </section>
                    </div>
                </details>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="people-ops-empty">
                    <i class="fa-solid fa-diagram-project" aria-hidden="true"></i>
                    <strong>No calculation traces</strong>
                    <span>No persisted attendance records match the selected employee, result, and date filters.</span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="people-pagination">
        <span>Showing <?php echo e($calculationTraces->firstItem() ?? 0); ?> to <?php echo e($calculationTraces->lastItem() ?? 0); ?> of <?php echo e($calculationTraces->total()); ?></span>
        <?php echo e($calculationTraces->withQueryString()->links()); ?>

    </div>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/hr/attendance/partials/trace.blade.php ENDPATH**/ ?>