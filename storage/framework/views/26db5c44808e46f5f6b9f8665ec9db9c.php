<section class="people-ops-grid is-wide-left" aria-label="Expense claim controls">
    <article class="people-ops-panel" id="claim-form">
        <header class="people-ops-panel-head"><div><h2>Submit expense claim</h2><p>Record an employee reimbursement request for governed review.</p></div></header>
        <div class="people-ops-panel-body">
            <?php if($abilities['canCreateClaim']): ?>
                <form method="POST" action="<?php echo e(route('hr.expense-claims.store')); ?>" class="people-form-grid" x-data="serverFormState" x-on:submit="beginSubmit" x-bind:aria-busy="busyAria" data-idle-label="Submit expense claim" data-busy-label="Submitting…">
                    <?php echo csrf_field(); ?>
                    <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id" required><option value="">Select employee</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string) old('employee_id') === (string) $employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?><?php echo e($employee->department ? ' / '.$employee->department : ''); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Claim type</span><select class="people-control" name="claim_type" required><option value="">Select type</option><?php $__currentLoopData = $claimTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($type['value']); ?>" <?php if(old('claim_type') === $type['value']): echo 'selected'; endif; ?>><?php echo e($type['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['claim_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Claim date</span><input class="people-control" type="date" name="claim_date" value="<?php echo e(old('claim_date', now()->toDateString())); ?>" max="<?php echo e(now()->toDateString()); ?>" required><?php $__errorArgs = ['claim_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Amount (INR)</span><input class="people-control" type="number" name="amount" value="<?php echo e(old('amount')); ?>" min="1" step="0.01" required><?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <input type="hidden" name="currency" value="INR">
                    <label class="people-field is-wide"><span>Description</span><textarea class="people-control" name="description" rows="3" minlength="10" maxlength="255" required placeholder="Business purpose and expense details"><?php echo e(old('description')); ?></textarea><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <div class="people-modal-actions is-wide"><button type="submit" class="people-button is-primary" x-bind:disabled="busy"><span x-text="submitLabel">Submit expense claim</span></button></div>
                </form>
            <?php else: ?>
                <div class="people-ops-empty"><i class="fa-solid fa-lock" aria-hidden="true"></i><strong>Claim submission unavailable</strong><span>Your role can view claims but cannot submit a reimbursement request.</span></div>
            <?php endif; ?>
        </div>
    </article>

    <article class="people-ops-panel">
        <header class="people-ops-panel-head"><div><h2>Claim filters</h2><p>Filter without changing the authorized company scope.</p></div></header>
        <div class="people-ops-panel-body">
            <form method="GET" action="<?php echo e(route('hr.expense-claims.index')); ?>" class="people-form-grid">
                <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id"><option value="">All employees</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string) request('employee_id') === (string) $employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Status</span><select class="people-control" name="status"><option value="">All statuses</option><?php $__currentLoopData = $claimStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($status); ?>" <?php if(request('status') === $status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Claim type</span><select class="people-control" name="claim_type"><option value="">All types</option><?php $__currentLoopData = $claimTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($type['value']); ?>" <?php if(request('claim_type') === $type['value']): echo 'selected'; endif; ?>><?php echo e($type['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>From</span><input class="people-control" type="date" name="date_from" value="<?php echo e(request('date_from')); ?>"></label>
                <label class="people-field"><span>To</span><input class="people-control" type="date" name="date_to" value="<?php echo e(request('date_to')); ?>"></label>
                <div class="people-modal-actions is-wide"><button class="people-button" type="submit">Apply filters</button><a class="people-button" href="<?php echo e(route('hr.expense-claims.index')); ?>">Clear</a></div>
            </form>
        </div>
    </article>
</section>

<section class="people-ops-panel has-mobile-cards" aria-labelledby="expense-claims-title">
    <header class="people-ops-panel-head"><div><h2 id="expense-claims-title">Expense claims</h2><p><?php echo e($claims->total()); ?> claim<?php echo e($claims->total() === 1 ? '' : 's'); ?> in this authorized register. Claimed <?php echo e($claimSummary->claimedAmount); ?>; approved <?php echo e($claimSummary->approvedAmount); ?>.</p></div></header>
    <div class="people-ops-table-wrap">
        <table class="people-ops-table">
            <caption>Expense claim register</caption>
            <thead><tr><th scope="col">Claim</th><th scope="col">Employee</th><th scope="col">Type / date</th><th scope="col" class="is-number">Amounts</th><th scope="col">Status</th><th scope="col">Evidence / history</th><th scope="col" class="is-actions">Action</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $claims; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $claim): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($claim->claimNumber); ?></strong><small><?php echo e($claim->description); ?></small></td>
                        <td><div class="people-ops-identity"><span class="people-avatar"><?php echo e($claim->employeeInitial); ?></span><div><strong><?php echo e($claim->employeeName); ?></strong><small><?php echo e($claim->employeeCode); ?> / <?php echo e($claim->employeeContext); ?></small></div></div></td>
                        <td><?php echo e($claim->claimTypeLabel); ?><small><?php echo e($claim->claimDate); ?></small></td>
                        <td class="is-number"><?php echo e($claim->claimedAmount); ?><small>Approved: <?php echo e($claim->approvedAmount); ?></small></td>
                        <td><span class="people-status is-<?php echo e($claim->statusTone); ?>"><?php echo e($claim->statusLabel); ?></span></td>
                        <td>
                            <?php if($claim->attachmentCount): ?><strong><?php echo e($claim->attachmentCount); ?> attachment<?php echo e($claim->attachmentCount === 1 ? '' : 's'); ?> recorded</strong><small><?php echo e(implode(', ', $claim->attachmentNames)); ?></small><?php else: ?><span>No attachments recorded</span><?php endif; ?>
                            <small><?php echo e($claim->workflowNote); ?> / <?php echo e($claim->workflowActor); ?> / <?php echo e($claim->workflowAt); ?></small>
                        </td>
                        <td class="is-actions"><?php echo $__env->make('hr.operations.partials.claim-actions', ['claim' => $claim, 'actionContext' => 'desktop'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7"><div class="people-ops-empty"><i class="fa-solid fa-receipt" aria-hidden="true"></i><strong>No expense claims found</strong><span>Clear the filters or submit a new expense claim.</span></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="people-ops-mobile-list">
        <?php $__currentLoopData = $claims; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $claim): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="people-ops-mobile-card"><div class="people-ops-mobile-card-head"><strong><?php echo e($claim->claimNumber); ?> / <?php echo e($claim->employeeName); ?></strong><span class="people-status is-<?php echo e($claim->statusTone); ?>"><?php echo e($claim->statusLabel); ?></span></div><dl class="people-ops-mobile-facts"><div><dt>Type / date</dt><dd><?php echo e($claim->claimTypeLabel); ?> / <?php echo e($claim->claimDate); ?></dd></div><div><dt>Claimed</dt><dd><?php echo e($claim->claimedAmount); ?></dd></div><div><dt>Approved</dt><dd><?php echo e($claim->approvedAmount); ?></dd></div><div><dt>Evidence</dt><dd><?php echo e($claim->attachmentCount ? $claim->attachmentCount.' recorded' : 'Unavailable'); ?></dd></div></dl><p><?php echo e($claim->description); ?></p><div class="people-ops-mobile-actions"><?php echo $__env->make('hr.operations.partials.claim-actions', ['claim' => $claim, 'actionContext' => 'mobile'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div></article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="people-pagination"><?php echo e($claims->withQueryString()->links()); ?></div>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\operations\partials\claims.blade.php ENDPATH**/ ?>