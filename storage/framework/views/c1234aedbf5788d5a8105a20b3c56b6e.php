<section class="people-ops-grid is-wide-left" aria-label="Payroll run controls">
    <article class="people-ops-panel" id="generate-payroll-run">
        <header class="people-ops-panel-head">
            <div><h2>Generate payroll run</h2><p>Create one controlled payroll run for a company period.</p></div>
        </header>
        <div class="people-ops-panel-body">
            <?php if($abilities['canGenerateRun']): ?>
                <form method="POST" action="<?php echo e(route('payroll.runs.generate')); ?>" class="people-form-grid">
                    <?php echo csrf_field(); ?>
                    <label class="people-field">
                        <span>Period year</span>
                        <input class="people-control" type="number" name="period_year" min="2000" max="2100" value="<?php echo e(old('period_year', now()->addMonthNoOverflow()->year)); ?>" required aria-invalid="<?php echo e($errors->has('period_year') ? 'true' : 'false'); ?>" <?php $__errorArgs = ['period_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> aria-describedby="payroll-period-year-error" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                        <?php $__errorArgs = ['period_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="people-field-error" id="payroll-period-year-error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                    <label class="people-field">
                        <span>Period month</span>
                        <input class="people-control" type="number" name="period_month" min="1" max="12" value="<?php echo e(old('period_month', now()->addMonthNoOverflow()->month)); ?>" required aria-invalid="<?php echo e($errors->has('period_month') ? 'true' : 'false'); ?>" <?php $__errorArgs = ['period_month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> aria-describedby="payroll-period-month-error" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                        <?php $__errorArgs = ['period_month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="people-field-error" id="payroll-period-month-error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                    <label class="people-field">
                        <span>Working days</span>
                        <input class="people-control" type="number" name="working_days" min="1" max="31" value="<?php echo e(old('working_days', 26)); ?>" required aria-invalid="<?php echo e($errors->has('working_days') ? 'true' : 'false'); ?>" <?php $__errorArgs = ['working_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> aria-describedby="payroll-working-days-error" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                        <?php $__errorArgs = ['working_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="people-field-error" id="payroll-working-days-error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                    <div class="people-modal-actions"><button type="submit" class="people-button is-primary"><i class="fa-solid fa-play" aria-hidden="true"></i>Generate run</button></div>
                </form>
            <?php else: ?>
                <div class="people-ops-empty"><i class="fa-solid fa-lock" aria-hidden="true"></i><strong>Generation unavailable</strong><span>Your role can review payroll runs but cannot generate one.</span></div>
            <?php endif; ?>
        </div>
    </article>

    <article class="people-ops-panel">
        <header class="people-ops-panel-head"><div><h2>Run filters</h2><p>Filter the authorized run register by supported lifecycle state.</p></div></header>
        <div class="people-ops-panel-body">
            <form method="GET" action="<?php echo e(route('payroll.runs.index')); ?>" class="people-form-grid">
                <label class="people-field"><span>Year</span><input class="people-control" type="number" name="period_year" min="2000" max="2100" value="<?php echo e(request('period_year')); ?>"></label>
                <label class="people-field"><span>Month</span><input class="people-control" type="number" name="period_month" min="1" max="12" value="<?php echo e(request('period_month')); ?>"></label>
                <label class="people-field is-wide"><span>Status</span><select class="people-control" name="status"><option value="">All supported statuses</option><?php $__currentLoopData = $runStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($status['value']); ?>" <?php if(request('status') === $status['value']): echo 'selected'; endif; ?>><?php echo e($status['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <div class="people-modal-actions is-wide"><button class="people-button" type="submit">Apply filters</button><a class="people-button" href="<?php echo e(route('payroll.runs.index')); ?>">Clear</a></div>
            </form>
        </div>
    </article>
</section>

<section class="people-ops-panel has-mobile-cards" aria-labelledby="payroll-runs-title">
    <header class="people-ops-panel-head"><div><h2 id="payroll-runs-title">Payroll runs</h2><p><?php echo e($runs->total()); ?> run<?php echo e($runs->total() === 1 ? '' : 's'); ?> in this authorized register.</p></div></header>
    <div class="people-ops-table-wrap">
        <table class="people-ops-table">
            <caption>Payroll run register</caption>
            <thead><tr><th scope="col">Run</th><th scope="col">Period</th><th scope="col">Status</th><th scope="col" class="is-number">Employees</th><th scope="col" class="is-number">Gross</th><th scope="col" class="is-number">Deductions</th><th scope="col" class="is-number">Net payable</th><th scope="col">Control</th><th scope="col" class="is-actions">Action</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $runs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $run): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($run->runNumber); ?></strong><?php if (! ($run->canViewCompensation)): ?><small>Employee trace restricted</small><?php endif; ?></td>
                        <td><?php echo e($run->period); ?><small><?php echo e($run->dateRange); ?></small></td>
                        <td><span class="people-status is-<?php echo e($run->status === 'approved' ? 'success' : 'warning'); ?>"><?php echo e($run->statusLabel); ?></span></td>
                        <td class="is-number"><?php echo e(number_format($run->employeeCount)); ?></td>
                        <td class="is-number"><?php echo e($run->grossEarnings); ?></td>
                        <td class="is-number"><?php echo e($run->deductions); ?></td>
                        <td class="is-number"><strong><?php echo e($run->netPayable); ?></strong></td>
                        <td><?php echo e($run->generatedBy); ?><?php if($run->approvedBy): ?><small>Approved by <?php echo e($run->approvedBy); ?></small><?php endif; ?></td>
                        <td class="is-actions">
                            <?php if($run->canApprove): ?>
                                <form method="POST" action="<?php echo e(route('payroll.runs.approve', $run->id)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><label class="people-field"><span class="sr-only">Approval note for <?php echo e($run->runNumber); ?></span><input class="people-control" name="note" maxlength="1000" placeholder="Approval note"></label><button type="submit" class="people-ops-action-link">Approve run</button></form>
                            <?php endif; ?>
                            <?php if($run->canPrepareBatch): ?>
                                <details class="people-edit-details" id="payroll-run-<?php echo e($run->id); ?>-bank-batch">
                                    <summary>Prepare bank batch</summary>
                                    <form method="POST" action="<?php echo e(route('payroll.runs.bank-transfer-batches.store', $run->id)); ?>" class="people-form-grid people-edit-form">
                                        <?php echo csrf_field(); ?>
                                        <label class="people-field"><span>Bank name</span><input class="people-control" name="bank_name" maxlength="120" required></label>
                                        <label class="people-field"><span>Payment date</span><input class="people-control" type="date" name="payment_date" min="<?php echo e(now()->toDateString()); ?>" value="<?php echo e(now()->addDay()->toDateString()); ?>" required></label>
                                        <label class="people-field"><span>Debit account number</span><input class="people-control" name="debit_account_number" inputmode="numeric" minlength="6" maxlength="32" pattern="[0-9]+" required></label>
                                        <label class="people-field"><span>Narration</span><input class="people-control" name="narration" maxlength="160"></label>
                                        <button type="submit" class="people-button is-primary is-wide">Prepare batch</button>
                                    </form>
                                </details>
                            <?php endif; ?>
                            <?php if(! $run->canApprove && ! $run->canPrepareBatch): ?><span class="people-subtext">No permitted action</span><?php endif; ?>
                        </td>
                    </tr>
                    <?php if($run->canViewCompensation): ?>
                        <tr class="people-payroll-trace-row">
                            <td colspan="9">
                                <details class="people-payroll-trace">
                                    <summary>
                                        <span><i class="fa-solid fa-users-rectangle" aria-hidden="true"></i>Employee line trace</span>
                                        <span><?php echo e(count($run->items)); ?> persisted line<?php echo e(count($run->items) === 1 ? '' : 's'); ?></span>
                                    </summary>
                                    <?php if($run->items === []): ?>
                                        <div class="people-payroll-trace-empty">No persisted employee lines are available for this run.</div>
                                    <?php else: ?>
                                        <div class="people-payroll-trace-scroll" tabindex="0" aria-label="Employee payroll lines for <?php echo e($run->runNumber); ?>">
                                            <table class="people-payroll-trace-table">
                                                <caption>Persisted employee payroll lines for <?php echo e($run->runNumber); ?></caption>
                                                <thead><tr><th scope="col">Employee</th><th scope="col">Department</th><th scope="col" class="is-number">Payable days</th><th scope="col" class="is-number">Gross</th><th scope="col" class="is-number">Deductions</th><th scope="col" class="is-number">Net payable</th><th scope="col">Line status</th></tr></thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $run->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><strong><?php echo e($item->employeeName); ?></strong><small><?php echo e($item->employeeCode); ?> / <?php echo e($item->designation); ?></small></td>
                                                            <td><?php echo e($item->department); ?></td>
                                                            <td class="is-number"><?php echo e(number_format($item->payableDays)); ?></td>
                                                            <td class="is-number"><?php echo e($item->grossEarnings); ?></td>
                                                            <td class="is-number"><?php echo e($item->deductions); ?></td>
                                                            <td class="is-number"><strong><?php echo e($item->netPayable); ?></strong></td>
                                                            <td><span class="people-status"><?php echo e($item->statusLabel); ?></span></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </details>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="9"><div class="people-ops-empty"><i class="fa-solid fa-file-circle-xmark" aria-hidden="true"></i><strong>No payroll runs found</strong><span>Clear filters or generate the first authorized payroll run.</span></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="people-ops-mobile-list">
        <?php $__empty_1 = true; $__currentLoopData = $runs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $run): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="people-ops-mobile-card">
                <header class="people-ops-mobile-card-head"><div><strong><?php echo e($run->runNumber); ?></strong><small class="people-subtext"><?php echo e($run->period); ?> / <?php echo e($run->dateRange); ?></small></div><span class="people-status is-<?php echo e($run->status === 'approved' ? 'success' : 'warning'); ?>"><?php echo e($run->statusLabel); ?></span></header>
                <dl class="people-ops-mobile-facts"><div><dt>Employees</dt><dd><?php echo e($run->employeeCount); ?></dd></div><div><dt>Net payable</dt><dd><?php echo e($run->netPayable); ?></dd></div><div><dt>Generated by</dt><dd><?php echo e($run->generatedBy); ?></dd></div><div><dt>Approved by</dt><dd><?php echo e($run->approvedBy ?? 'Not approved'); ?></dd></div></dl>
                <?php if($run->canViewCompensation): ?>
                    <details class="people-payroll-trace is-mobile">
                        <summary><span><i class="fa-solid fa-users-rectangle" aria-hidden="true"></i>Employee line trace</span><span><?php echo e(count($run->items)); ?></span></summary>
                        <?php $__empty_2 = true; $__currentLoopData = $run->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <article class="people-payroll-trace-card">
                                <header><div><strong><?php echo e($item->employeeName); ?></strong><small><?php echo e($item->employeeCode); ?> / <?php echo e($item->designation); ?></small></div><span class="people-status"><?php echo e($item->statusLabel); ?></span></header>
                                <dl>
                                    <div><dt>Department</dt><dd><?php echo e($item->department); ?></dd></div>
                                    <div><dt>Payable days</dt><dd><?php echo e($item->payableDays); ?></dd></div>
                                    <div><dt>Gross</dt><dd><?php echo e($item->grossEarnings); ?></dd></div>
                                    <div><dt>Deductions</dt><dd><?php echo e($item->deductions); ?></dd></div>
                                    <div><dt>Net payable</dt><dd><strong><?php echo e($item->netPayable); ?></strong></dd></div>
                                </dl>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <div class="people-payroll-trace-empty">No persisted employee lines are available for this run.</div>
                        <?php endif; ?>
                    </details>
                <?php else: ?>
                    <p class="people-subtext"><i class="fa-solid fa-lock" aria-hidden="true"></i> Employee trace is restricted for your role.</p>
                <?php endif; ?>
                <div class="people-ops-mobile-actions">
                    <?php if($run->canApprove): ?><form method="POST" action="<?php echo e(route('payroll.runs.approve', $run->id)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><button class="people-button is-primary" type="submit">Approve</button></form><?php endif; ?>
                    <?php if($run->canPrepareBatch): ?>
                        <details class="people-edit-details">
                            <summary>Prepare bank batch</summary>
                            <form method="POST" action="<?php echo e(route('payroll.runs.bank-transfer-batches.store', $run->id)); ?>" class="people-form-grid people-edit-form">
                                <?php echo csrf_field(); ?>
                                <label class="people-field"><span>Bank name</span><input class="people-control" name="bank_name" maxlength="120" required></label>
                                <label class="people-field"><span>Payment date</span><input class="people-control" type="date" name="payment_date" min="<?php echo e(now()->toDateString()); ?>" value="<?php echo e(now()->addDay()->toDateString()); ?>" required></label>
                                <label class="people-field"><span>Debit account number</span><input class="people-control" name="debit_account_number" inputmode="numeric" minlength="6" maxlength="32" pattern="[0-9]+" required></label>
                                <label class="people-field"><span>Narration</span><input class="people-control" name="narration" maxlength="160"></label>
                                <button type="submit" class="people-button is-primary is-wide">Prepare batch</button>
                            </form>
                        </details>
                    <?php endif; ?>
                    <?php if(! $run->canApprove && ! $run->canPrepareBatch): ?><span class="people-subtext">No permitted action</span><?php endif; ?>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="people-ops-empty"><strong>No payroll runs found</strong><span>Clear filters or generate the first authorized payroll run.</span></div>
        <?php endif; ?>
    </div>
    <div class="people-pagination"><?php echo e($runs->withQueryString()->links()); ?></div>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\payroll\workspace\partials\runs.blade.php ENDPATH**/ ?>