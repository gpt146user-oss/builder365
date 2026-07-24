<section class="people-ops-kpis is-four" aria-label="Attendance regularization summary">
    <article class="people-ops-kpi is-warning">
        <span class="people-ops-kpi-icon"><i class="fa-solid fa-hourglass-half" aria-hidden="true"></i></span>
        <span>Pending review</span>
        <strong><?php echo e($summary->pendingRegularizations); ?></strong>
        <small>Submitted requests awaiting an authorized decision</small>
    </article>
    <article class="people-ops-kpi is-purple">
        <span class="people-ops-kpi-icon"><i class="fa-solid fa-list-check" aria-hidden="true"></i></span>
        <span>Visible requests</span>
        <strong><?php echo e($regularizations->total()); ?></strong>
        <small>Requests in the current employee and status filter</small>
    </article>
</section>

<section class="people-ops-grid is-wide-left">
    <article class="people-ops-panel has-mobile-cards">
        <header class="people-ops-panel-head">
            <div><h2>Regularization queue</h2><p>Review requested attendance corrections without changing the original request history.</p></div>
            <span class="people-count"><?php echo e($regularizations->total()); ?> requests</span>
        </header>

        <form method="GET" action="<?php echo e(route('hr.attendance-regularizations.index')); ?>" class="people-ops-filterbar">
            <label class="people-field">Employee
                <select class="people-control" name="employee_id">
                    <option value="">All visible employees</option>
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($employee->id); ?>" <?php if((string) request('employee_id') === (string) $employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>
            <label class="people-field">Status
                <select class="people-control" name="status">
                    <option value="">All statuses</option>
                    <?php $__currentLoopData = $regularizationStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($status['value']); ?>" <?php if(request('status') === $status['value']): echo 'selected'; endif; ?>><?php echo e($status['label']); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>
            <button class="people-button" type="submit"><i class="fa-solid fa-filter" aria-hidden="true"></i> Apply</button>
            <?php if(request()->hasAny(['employee_id', 'status'])): ?>
                <a class="people-button" href="<?php echo e(route('hr.attendance-regularizations.index')); ?>">Clear</a>
            <?php endif; ?>
        </form>

        <div class="people-ops-table-wrap">
            <table class="people-ops-table">
                <caption>Attendance regularization requests in the selected filters</caption>
                <thead><tr><th scope="col">Request</th><th scope="col">Employee</th><th scope="col">Work date</th><th scope="col">Requested attendance</th><th scope="col">Reason</th><th scope="col">Status</th><th scope="col" class="is-actions">Decision</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $regularizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($item->requestNumber); ?></strong></td>
                            <td><strong><?php echo e($item->employeeName); ?></strong><small><?php echo e($item->employeeCode); ?></small></td>
                            <td><?php echo e($item->workDate); ?></td>
                            <td><strong><?php echo e($item->requestedCheckIn); ?></strong><small>to <?php echo e($item->requestedCheckOut); ?></small></td>
                            <td><?php echo e($item->reason); ?></td>
                            <td><span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['people-status', 'is-warning' => $item->status === 'submitted', 'is-success' => $item->status === 'approved', 'is-danger' => $item->status === 'rejected']); ?>"><?php echo e($item->statusLabel); ?></span><?php if($item->decisionNote): ?><small><?php echo e($item->decisionNote); ?></small><?php endif; ?></td>
                            <td class="is-actions">
                                <?php if($item->canApprove || $item->canReject): ?>
                                    <?php if($item->canApprove): ?>
                                    <form method="POST" action="<?php echo e(route('hr.attendance-regularizations.approve', $item->id)); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <input class="people-control" name="decision_note" maxlength="2000" placeholder="Approval note">
                                        <button class="people-ops-action-link" type="submit">Approve</button>
                                    </form>
                                    <?php endif; ?>
                                    <?php if($item->canReject): ?>
                                    <form method="POST" action="<?php echo e(route('hr.attendance-regularizations.reject', $item->id)); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <input class="people-control" name="decision_note" maxlength="2000" required placeholder="Rejection reason">
                                        <button class="people-ops-action-link is-danger" type="submit">Reject</button>
                                    </form>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="people-status is-muted">No action available</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="7"><div class="people-ops-empty"><i class="fa-solid fa-clipboard-check" aria-hidden="true"></i><strong>No regularization requests</strong><span>No requests match the selected employee and status filters.</span></div></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="people-ops-mobile-list">
            <?php $__currentLoopData = $regularizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="people-ops-mobile-card">
                    <header class="people-ops-mobile-card-head"><div><strong><?php echo e($item->employeeName); ?></strong><small><?php echo e($item->requestNumber); ?> / <?php echo e($item->employeeCode); ?></small></div><span class="people-status is-muted"><?php echo e($item->statusLabel); ?></span></header>
                    <dl class="people-ops-mobile-facts"><div><dt>Work date</dt><dd><?php echo e($item->workDate); ?></dd></div><div><dt>Requested</dt><dd><?php echo e($item->requestedCheckIn); ?> to <?php echo e($item->requestedCheckOut); ?></dd></div><div><dt>Reason</dt><dd><?php echo e($item->reason); ?></dd></div><?php if($item->decisionNote): ?><div><dt>Decision note</dt><dd><?php echo e($item->decisionNote); ?></dd></div><?php endif; ?></dl>
                    <?php if($item->canApprove || $item->canReject): ?>
                        <div class="people-ops-list-actions">
                            <?php if($item->canApprove): ?>
                                <form method="POST" action="<?php echo e(route('hr.attendance-regularizations.approve', $item->id)); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <input class="people-control" name="decision_note" maxlength="2000" placeholder="Approval note">
                                    <button class="people-ops-action-link" type="submit">Approve</button>
                                </form>
                            <?php endif; ?>
                            <?php if($item->canReject): ?>
                                <form method="POST" action="<?php echo e(route('hr.attendance-regularizations.reject', $item->id)); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <input class="people-control" name="decision_note" maxlength="2000" required placeholder="Rejection reason">
                                    <button class="people-ops-action-link is-danger" type="submit">Reject</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="people-pagination"><span>Showing <?php echo e($regularizations->firstItem() ?? 0); ?> to <?php echo e($regularizations->lastItem() ?? 0); ?> of <?php echo e($regularizations->total()); ?></span><?php echo e($regularizations->withQueryString()->links()); ?></div>
    </article>

    <aside class="people-ops-panel" id="regularization-form">
        <header class="people-ops-panel-head"><div><h2>Submit correction request</h2><p>Provide the requested attendance interval and a clear business reason.</p></div></header>
        <?php if($abilities['canCreateRegularization']): ?>
            <form method="POST" action="<?php echo e(route('hr.attendance-regularizations.store')); ?>" class="people-ops-panel-body">
                <?php echo csrf_field(); ?>
                <label class="people-field">Employee
                    <select class="people-control" name="employee_id" required>
                        <option value="">Select employee</option>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($employee->id); ?>" <?php if((string) old('employee_id') === (string) $employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>
                <label class="people-field">Work date<input class="people-control" type="date" name="work_date" value="<?php echo e(old('work_date')); ?>" required><?php $__errorArgs = ['work_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field">Requested check-in<input class="people-control" type="datetime-local" name="requested_check_in_at" value="<?php echo e(old('requested_check_in_at')); ?>" required><?php $__errorArgs = ['requested_check_in_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field">Requested check-out<input class="people-control" type="datetime-local" name="requested_check_out_at" value="<?php echo e(old('requested_check_out_at')); ?>" required><?php $__errorArgs = ['requested_check_out_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field">Reason<textarea class="people-control" name="reason" rows="4" maxlength="2000" required><?php echo e(old('reason')); ?></textarea><?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <button class="people-button is-primary" type="submit"><i class="fa-solid fa-paper-plane" aria-hidden="true"></i> Submit request</button>
            </form>
        <?php else: ?>
            <div class="people-ops-empty"><i class="fa-solid fa-lock" aria-hidden="true"></i><strong>Submission unavailable</strong><span>Your current role can review the queue but cannot submit a regularization request.</span></div>
        <?php endif; ?>
    </aside>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\attendance\partials\regularizations.blade.php ENDPATH**/ ?>