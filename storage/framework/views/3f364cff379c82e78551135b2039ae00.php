<?php $__env->startSection('title', 'Separation and Final Settlement - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Separation & Final Settlement','description' => 'Manage separation dates, calculated dues and recoveries, independent approvals, and settlement completion.','active' => 'lifecycle'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> <?php if($abilities['canCreate']): ?><a class="people-button is-primary" href="#initiate-settlement"><i class="fa-solid fa-plus" aria-hidden="true"></i> New settlement</a><?php endif; ?> <?php $__env->endSlot(); ?>
    <?php echo $__env->make('hr.lifecycle.partials.navigation', ['activeLifecycleSection' => 'separation'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php if(session('status')): ?><section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section><?php endif; ?>
    <?php if($errors->any()): ?><section class="people-alert is-danger" role="alert" tabindex="-1"><strong>Please correct the highlighted settlement fields.</strong><ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></section><?php endif; ?>

    <?php if($abilities['canCreate']): ?>
        <details class="people-ops-panel" id="initiate-settlement" <?php if($errors->any()): ?> open <?php endif; ?>>
            <summary class="people-ops-panel-head"><div><h2>Initiate final settlement</h2><p>Start the existing governed HR and Finance approval workflow.</p></div></summary>
            <div class="people-ops-panel-body"><form method="POST" action="<?php echo e(route('hr.separation-settlements.store')); ?>" class="people-form-grid"><?php echo csrf_field(); ?>
                <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id" required><option value="">Select employee</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string)old('employee_id')===(string)$employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> · <?php echo e($employee->name); ?><?php echo e($employee->department ? ' · '.$employee->department : ''); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field"><span>Separation type</span><select class="people-control" name="separation_type" required><?php $__currentLoopData = ['resignation'=>'Resignation','termination'=>'Termination','retirement'=>'Retirement','contract_end'=>'Contract end']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(old('separation_type')===$value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['separation_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field"><span>Resignation date</span><input class="people-control" type="date" name="resignation_date" value="<?php echo e(old('resignation_date')); ?>"><?php $__errorArgs = ['resignation_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field"><span>Last working date</span><input class="people-control" type="date" name="last_working_date" value="<?php echo e(old('last_working_date')); ?>" required><?php $__errorArgs = ['last_working_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field"><span>Settlement date</span><input class="people-control" type="date" name="settlement_date" value="<?php echo e(old('settlement_date')); ?>"><?php $__errorArgs = ['settlement_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <?php $__currentLoopData = ['bonus_amount'=>'Bonus amount','gratuity_amount'=>'Gratuity amount','notice_recovery_amount'=>'Notice recovery','tax_recovery_amount'=>'Tax recovery']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><label class="people-field"><span><?php echo e($label); ?></span><input class="people-control" type="number" min="0" step="0.01" name="<?php echo e($name); ?>" value="<?php echo e(old($name,0)); ?>"><?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <label class="people-field is-wide"><span>Reason</span><textarea class="people-control" name="reason" maxlength="2000"><?php echo e(old('reason')); ?></textarea></label>
                <button class="people-button is-primary" type="submit">Initiate settlement</button>
            </form></div>
        </details>
    <?php endif; ?>

    <section class="people-ops-panel has-mobile-cards" aria-labelledby="settlement-register-title">
        <header class="people-ops-panel-head"><div><h2 id="settlement-register-title">Final settlement register</h2><p><?php echo e($settlements->total()); ?> authorized settlement<?php echo e($settlements->total() === 1 ? '' : 's'); ?>.</p></div></header>
        <div class="people-ops-panel-body"><form method="GET" action="<?php echo e(route('hr.separation-settlements.index')); ?>" class="people-ops-filterbar" aria-label="Filter separation settlements">
            <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id"><option value="">All visible employees</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string)request('employee_id')===(string)$employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> · <?php echo e($employee->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="people-field"><span>Status</span><select class="people-control" name="status"><option value="">All statuses</option><?php $__currentLoopData = ['initiated'=>'Initiated','hr_approved'=>'HR approved','finance_approved'=>'Finance approved','completed'=>'Completed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(request('status')===$value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="people-field"><span>Type</span><select class="people-control" name="separation_type"><option value="">All types</option><?php $__currentLoopData = ['resignation'=>'Resignation','termination'=>'Termination','retirement'=>'Retirement','contract_end'=>'Contract end']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(request('separation_type')===$value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="people-field"><span>From</span><input class="people-control" type="date" name="from" value="<?php echo e(request('from')); ?>"></label><label class="people-field"><span>To</span><input class="people-control" type="date" name="to" value="<?php echo e(request('to')); ?>"></label>
            <button class="people-button is-primary">Apply</button><a class="people-button" href="<?php echo e(route('hr.separation-settlements.index')); ?>">Clear</a>
        </form></div>

        <div class="people-ops-table-wrap"><table class="people-ops-table"><caption>Employee separation and final settlements</caption><thead><tr><th scope="col">Settlement</th><th scope="col">Employee</th><th scope="col">Schedule</th><th scope="col">Amounts</th><th scope="col">Clearance</th><th scope="col">Status</th><th scope="col">Action</th></tr></thead><tbody>
        <?php $__empty_1 = true; $__currentLoopData = $settlements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $settlement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> <?php ($actions=$settlementActions[$settlement->id]??[]); ?> <?php ($canViewCompensation=$settlementCompensationVisibility[$settlement->id]??false); ?>
            <tr>
                <td><strong><?php echo e($settlement->settlement_number); ?></strong><small><?php echo e(str_replace('_',' ',ucfirst($settlement->separation_type))); ?></small></td>
                <td><span class="people-ops-identity"><strong><?php echo e($settlement->employee?->name); ?></strong><small><?php echo e($settlement->employee?->employee_code); ?> · <?php echo e($settlement->employee?->department ?: 'No department'); ?></small></span></td>
                <td>Last day <?php echo e($settlement->last_working_date?->format('d M Y') ?? 'Not set'); ?><small>Settlement <?php echo e($settlement->settlement_date?->format('d M Y') ?? 'not set'); ?></small></td>
                <td><?php if($canViewCompensation): ?>Gross INR <?php echo e(number_format((float)$settlement->gross_payable,2)); ?><small>Recovery INR <?php echo e(number_format((float)$settlement->total_recoveries,2)); ?> · Net INR <?php echo e(number_format((float)$settlement->net_payable,2)); ?></small><?php else: ?><span class="people-status is-muted">Restricted</span><small>Compensation details restricted</small><?php endif; ?></td>
                <td><?php echo e(count($settlement->clearance_blockers??[])); ?> blocker(s)</td>
                <td><span class="people-status is-<?php echo e($settlement->status === 'completed' ? 'success' : 'warning'); ?>"><?php echo e(str_replace('_',' ',ucfirst($settlement->status))); ?></span></td>
                <td><?php echo $__env->make('hr.separation.partials.settlement-actions', ['settlement' => $settlement, 'actions' => $actions, 'mobile' => false], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="7"><div class="people-ops-empty"><strong>No settlements found</strong><span>Clear the filters or initiate an authorized settlement.</span></div></td></tr><?php endif; ?>
        </tbody></table></div>

        <div class="people-ops-mobile-list"><?php $__empty_1 = true; $__currentLoopData = $settlements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $settlement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> <?php ($actions=$settlementActions[$settlement->id]??[]); ?> <?php ($canViewCompensation=$settlementCompensationVisibility[$settlement->id]??false); ?><article class="people-ops-mobile-card"><header class="people-ops-mobile-card-head"><span class="people-ops-identity"><strong><?php echo e($settlement->employee?->name); ?></strong><small><?php echo e($settlement->settlement_number); ?></small></span><span class="people-status is-info"><?php echo e(str_replace('_',' ',ucfirst($settlement->status))); ?></span></header><dl class="people-ops-mobile-facts"><div><dt>Last day</dt><dd><?php echo e($settlement->last_working_date?->format('d M Y') ?? 'Not set'); ?></dd></div><div><dt>Settlement amounts</dt><dd><?php echo e($canViewCompensation ? 'INR '.number_format((float)$settlement->net_payable,2) : 'Restricted'); ?></dd></div><div><dt>Clearance</dt><dd><?php echo e(count($settlement->clearance_blockers??[])); ?> blocker(s)</dd></div></dl><?php echo $__env->make('hr.separation.partials.settlement-actions', ['settlement' => $settlement, 'actions' => $actions, 'mobile' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></article><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><div class="people-ops-empty"><strong>No settlements found</strong></div><?php endif; ?></div>
        <?php echo e($settlements->withQueryString()->links()); ?>

    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9)): ?>
<?php $attributes = $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9; ?>
<?php unset($__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9)): ?>
<?php $component = $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9; ?>
<?php unset($__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/hr/separation/index.blade.php ENDPATH**/ ?>