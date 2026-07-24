<section class="people-ops-grid is-wide-left" aria-label="Employee loan controls">
    <article class="people-ops-panel" id="loan-form">
        <header class="people-ops-panel-head"><div><h2>Request employee loan</h2><p>Submit a governed advance or welfare loan request.</p></div></header>
        <div class="people-ops-panel-body">
            <?php if($abilities['canCreateLoan']): ?>
                <form method="POST" action="<?php echo e(route('hr.loans.store')); ?>" class="people-form-grid" x-data="serverFormState" x-on:submit="beginSubmit" x-bind:aria-busy="busyAria" data-idle-label="Request employee loan" data-busy-label="Submitting…">
                    <?php echo csrf_field(); ?>
                    <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id" required><option value="">Select employee</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string) old('employee_id') === (string) $employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?><?php echo e($employee->department ? ' / '.$employee->department : ''); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Loan type</span><select class="people-control" name="loan_type" required><option value="">Select type</option><?php $__currentLoopData = $loanTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($type['value']); ?>" <?php if(old('loan_type') === $type['value']): echo 'selected'; endif; ?>><?php echo e($type['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['loan_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Principal amount (INR)</span><input class="people-control" type="number" name="principal_amount" value="<?php echo e(old('principal_amount')); ?>" min="1000" step="0.01" required><?php $__errorArgs = ['principal_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Installments</span><input class="people-control" type="number" name="installment_months" value="<?php echo e(old('installment_months', 6)); ?>" min="1" max="60" required><?php $__errorArgs = ['installment_months'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Requested on</span><input class="people-control" type="date" name="requested_on" value="<?php echo e(old('requested_on', now()->toDateString())); ?>" max="<?php echo e(now()->toDateString()); ?>"><?php $__errorArgs = ['requested_on'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field is-wide"><span>Purpose</span><textarea class="people-control" name="purpose" rows="3" minlength="10" maxlength="255" required placeholder="Reason and intended use"><?php echo e(old('purpose')); ?></textarea><?php $__errorArgs = ['purpose'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <div class="people-modal-actions is-wide"><button type="submit" class="people-button is-primary" x-bind:disabled="busy"><span x-text="submitLabel">Request employee loan</span></button></div>
                </form>
            <?php else: ?>
                <div class="people-ops-empty"><i class="fa-solid fa-lock" aria-hidden="true"></i><strong>Loan requests unavailable</strong><span>Your role can view loans but cannot submit a request.</span></div>
            <?php endif; ?>
        </div>
    </article>

    <article class="people-ops-panel">
        <header class="people-ops-panel-head"><div><h2>Loan filters</h2><p>Filter recorded loan terms without changing scope.</p></div></header>
        <div class="people-ops-panel-body">
            <form method="GET" action="<?php echo e(route('hr.loans.index')); ?>" class="people-form-grid">
                <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id"><option value="">All employees</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string) request('employee_id') === (string) $employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Status</span><select class="people-control" name="status"><option value="">All statuses</option><?php $__currentLoopData = $loanStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($status); ?>" <?php if(request('status') === $status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Loan type</span><select class="people-control" name="loan_type"><option value="">All types</option><?php $__currentLoopData = $loanTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($type['value']); ?>" <?php if(request('loan_type') === $type['value']): echo 'selected'; endif; ?>><?php echo e($type['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <div class="people-modal-actions is-wide"><button class="people-button" type="submit">Apply filters</button><a class="people-button" href="<?php echo e(route('hr.loans.index')); ?>">Clear</a></div>
            </form>
        </div>
    </article>
</section>

<section class="people-ops-panel has-mobile-cards" aria-labelledby="employee-loans-title">
    <header class="people-ops-panel-head"><div><h2 id="employee-loans-title">Employee loans</h2><p><?php echo e($loans->total()); ?> loan<?php echo e($loans->total() === 1 ? '' : 's'); ?> in this authorized register. Requested <?php echo e($loanSummary->requestedAmount); ?>; approved <?php echo e($loanSummary->approvedAmount); ?>.</p></div></header>
    <div class="people-ops-table-wrap">
        <table class="people-ops-table">
            <caption>Employee loan register</caption>
            <thead><tr><th scope="col">Loan</th><th scope="col">Employee</th><th scope="col">Type / requested</th><th scope="col" class="is-number">Recorded terms</th><th scope="col">Status</th><th scope="col">Workflow history</th><th scope="col" class="is-actions">Action</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($loan->loanNumber); ?></strong><small><?php echo e($loan->purpose); ?></small></td>
                        <td><div class="people-ops-identity"><span class="people-avatar"><?php echo e($loan->employeeInitial); ?></span><div><strong><?php echo e($loan->employeeName); ?></strong><small><?php echo e($loan->employeeCode); ?> / <?php echo e($loan->employeeContext); ?></small></div></div></td>
                        <td><?php echo e($loan->loanTypeLabel); ?><small><?php echo e($loan->requestedOn); ?></small></td>
                        <td class="is-number"><?php echo e($loan->principalAmount); ?><small><?php echo e($loan->installmentMonths); ?> months / <?php echo e($loan->monthlyInstallment); ?> recorded monthly installment</small><small>Repayment starts: <?php echo e($loan->repaymentStartsOn); ?></small></td>
                        <td><span class="people-status is-<?php echo e($loan->statusTone); ?>"><?php echo e($loan->statusLabel); ?></span></td>
                        <td><?php echo e($loan->workflowNote); ?><small><?php echo e($loan->workflowActor); ?> / <?php echo e($loan->workflowAt); ?></small></td>
                        <td class="is-actions"><?php echo $__env->make('hr.operations.partials.loan-actions', ['loan' => $loan, 'actionContext' => 'desktop'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7"><div class="people-ops-empty"><i class="fa-solid fa-hand-holding-dollar" aria-hidden="true"></i><strong>No employee loans found</strong><span>Clear the filters or submit a new loan request.</span></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="people-ops-mobile-list">
        <?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="people-ops-mobile-card"><div class="people-ops-mobile-card-head"><strong><?php echo e($loan->loanNumber); ?> / <?php echo e($loan->employeeName); ?></strong><span class="people-status is-<?php echo e($loan->statusTone); ?>"><?php echo e($loan->statusLabel); ?></span></div><dl class="people-ops-mobile-facts"><div><dt>Type</dt><dd><?php echo e($loan->loanTypeLabel); ?></dd></div><div><dt>Requested</dt><dd><?php echo e($loan->principalAmount); ?></dd></div><div><dt>Approved</dt><dd><?php echo e($loan->approvedAmount); ?></dd></div><div><dt>Recorded term</dt><dd><?php echo e($loan->installmentMonths); ?> months</dd></div></dl><p><?php echo e($loan->purpose); ?></p><div class="people-ops-mobile-actions"><?php echo $__env->make('hr.operations.partials.loan-actions', ['loan' => $loan, 'actionContext' => 'mobile'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div></article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="people-pagination"><?php echo e($loans->withQueryString()->links()); ?></div>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/hr/operations/partials/loans.blade.php ENDPATH**/ ?>