<section class="people-ops-grid is-wide-left" aria-label="Leave encashment operations">
    <article class="people-ops-panel">
        <header class="people-ops-panel-head"><div><h2>Request leave encashment</h2><p>Submit eligible leave days for policy validation and approval.</p></div></header>
        <div class="people-ops-panel-body">
            <?php if($abilities['canCreateEncashment']): ?>
                <form method="POST" action="<?php echo e(route('hr.leave-encashments.store')); ?>" class="people-form-grid"><?php echo csrf_field(); ?>
                    <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id" required><option value="">Select employee</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string)old('employee_id')===(string)$employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Leave type</span><select class="people-control" name="leave_type_id" required><option value="">Select eligible leave type</option><?php $__currentLoopData = $leaveTypeOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($type->id); ?>" <?php if((string)old('leave_type_id')===(string)$type->id): echo 'selected'; endif; ?>><?php echo e($type->code); ?> - <?php echo e($type->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['leave_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Period year</span><input class="people-control" type="number" name="period_year" min="2000" max="2100" value="<?php echo e(old('period_year', now()->year)); ?>" required><?php $__errorArgs = ['period_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Requested days</span><input class="people-control" type="number" name="requested_days" min="0.5" max="365" step="0.5" value="<?php echo e(old('requested_days')); ?>" required><?php $__errorArgs = ['requested_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field is-wide"><span>Request note</span><textarea class="people-control" name="request_note" maxlength="1000" rows="3"><?php echo e(old('request_note')); ?></textarea><?php $__errorArgs = ['request_note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <div class="people-modal-actions is-wide"><button class="people-button is-primary" type="submit">Submit encashment</button></div>
                </form>
            <?php else: ?><div class="people-ops-empty"><i class="fa-solid fa-lock" aria-hidden="true"></i><strong>Encashment unavailable</strong><span>Your role cannot submit leave encashment requests.</span></div><?php endif; ?>
        </div>
    </article>
    <article class="people-ops-panel"><header class="people-ops-panel-head"><div><h2>Encashment workflow</h2><p>Calculation and posting remain server-authoritative.</p></div></header><ul class="people-ops-checklist"><li><i class="fa-solid fa-check" aria-hidden="true"></i><span>Eligibility and available balance validated</span><strong>On submit</strong></li><li><i class="fa-solid fa-check" aria-hidden="true"></i><span>Approval adjusts the leave ledger once</span><strong>Audited</strong></li><li><i class="fa-solid fa-check" aria-hidden="true"></i><span>Payroll handoff requires payroll permission</span><strong>Separated</strong></li></ul></article>
</section>

<section class="people-ops-panel" aria-labelledby="leave-encashments-title"><header class="people-ops-panel-head"><div><h2 id="leave-encashments-title">Leave encashments</h2><p>Request, approval, and payroll handoff states.</p></div></header>
    <div class="people-ops-panel-body"><form method="GET" action="<?php echo e(route('hr.leave-encashments.index')); ?>" class="people-ops-filterbar"><label class="people-field"><span>Employee</span><select class="people-control" name="employee_id"><option value="">All employees</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string)request('employee_id')===(string)$employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label><label class="people-field"><span>Year</span><input class="people-control" type="number" name="period_year" min="2000" max="2100" value="<?php echo e(request('period_year')); ?>"></label><label class="people-field"><span>Status</span><select class="people-control" name="status"><option value="">All statuses</option><?php $__currentLoopData = $encashmentStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($status['value']); ?>" <?php if(request('status')===$status['value']): echo 'selected'; endif; ?>><?php echo e($status['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label><button class="people-button" type="submit">Apply filters</button><a class="people-button" href="<?php echo e(route('hr.leave-encashments.index')); ?>">Clear</a></form></div>
    <div class="people-ops-table-wrap"><table class="people-ops-table"><caption>Leave encashment register</caption><thead><tr><th scope="col">Encashment</th><th scope="col">Employee</th><th scope="col">Leave / year</th><th scope="col">Days</th><th scope="col">Amount</th><th scope="col">Status</th><th scope="col">Notes</th><th scope="col" class="is-actions">Action</th></tr></thead><tbody>
        <?php $__empty_1 = true; $__currentLoopData = $encashments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><strong><?php echo e($item->encashmentNumber); ?></strong></td><td><div class="people-ops-identity"><div><strong><?php echo e($item->employeeName); ?></strong><small><?php echo e($item->employeeCode); ?></small></div></div></td><td><?php echo e($item->leaveTypeCode); ?><small><?php echo e($item->periodYear); ?></small></td><td>Requested <?php echo e($item->requestedDays); ?><small>Approved <?php echo e($item->approvedDays); ?></small></td><td><?php echo e($item->grossAmount); ?><small>Net <?php echo e($item->netAmount); ?></small></td><td><span class="people-status is-<?php echo e($item->status); ?>"><?php echo e($item->statusLabel); ?></span></td><td><?php echo e($item->requestNote); ?><?php if($item->decisionNote): ?><small>Decision: <?php echo e($item->decisionNote); ?></small><?php endif; ?> <?php if($item->payrollReference): ?><small>Payroll: <?php echo e($item->payrollReference); ?></small><?php endif; ?></td><td class="is-actions">
            <?php if($item->canApprove): ?><form method="POST" action="<?php echo e(route('hr.leave-encashments.approve', $item->id)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><input class="people-control" type="number" name="approved_days" min="0.5" max="365" step="0.5" placeholder="Approved days"><input class="people-control" name="decision_note" maxlength="1000" placeholder="Approval note"><button class="people-ops-action-link" type="submit">Approve</button></form><?php endif; ?>
            <?php if($item->canReject): ?><form method="POST" action="<?php echo e(route('hr.leave-encashments.reject', $item->id)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><input class="people-control" name="decision_note" maxlength="1000" placeholder="Rejection reason" required><button class="people-ops-action-link is-danger" type="submit">Reject</button></form><?php endif; ?>
            <?php if($item->canMarkPayroll): ?><form method="POST" action="<?php echo e(route('hr.leave-encashments.mark-payroll', $item->id)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><input class="people-control" name="payroll_reference" maxlength="120" placeholder="Payroll reference" required><input class="people-control" name="note" maxlength="1000" placeholder="Payroll note"><button class="people-ops-action-link" type="submit">Mark payroll</button></form><?php endif; ?>
            <?php if(! $item->canApprove && ! $item->canReject && ! $item->canMarkPayroll): ?><span class="people-subtext">No action</span><?php endif; ?>
        </td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="8"><div class="people-ops-empty"><strong>No leave encashments found</strong><span>No requests match the selected filters.</span></div></td></tr><?php endif; ?>
    </tbody></table></div><div class="people-pagination"><?php echo e($encashments->withQueryString()->links()); ?></div>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\leave\partials\encashments.blade.php ENDPATH**/ ?>