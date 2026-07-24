<?php $__env->startSection('title', 'Employee Confirmation - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Employee Confirmation','description' => 'Track probation reviews, manager recommendations, and authorized HR confirmation decisions.','active' => 'lifecycle'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if($abilities['canCreate']): ?><a class="people-button is-primary" href="#create-confirmation-case"><i class="fa-solid fa-plus" aria-hidden="true"></i> New case</a><?php endif; ?>
     <?php $__env->endSlot(); ?>

    <?php echo $__env->make('hr.lifecycle.partials.navigation', ['activeLifecycleSection' => 'confirmation'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if(session('status')): ?><section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section><?php endif; ?>
    <?php if($errors->any()): ?><section class="people-alert is-danger" role="alert" tabindex="-1"><strong>Please correct the highlighted confirmation fields.</strong><ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></section><?php endif; ?>

    <?php if($abilities['canCreate']): ?>
        <details class="people-ops-panel" id="create-confirmation-case" <?php if($errors->any()): ?> open <?php endif; ?>>
            <summary class="people-ops-panel-head"><div><h2>Create confirmation case</h2><p>Start a governed probation review for an authorized employee.</p></div></summary>
            <div class="people-ops-panel-body">
                <form method="POST" action="<?php echo e(route('hr.confirmation-cases.store')); ?>" class="people-form-grid"><?php echo csrf_field(); ?>
                    <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id" required><option value="">Select employee</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string)old('employee_id')===(string)$employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> · <?php echo e($employee->name); ?><?php echo e($employee->department ? ' · '.$employee->department : ''); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Confirmation manager</span><select class="people-control" name="manager_employee_id"><option value="">Use reporting manager</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($manager->id); ?>" <?php if((string)old('manager_employee_id')===(string)$manager->id): echo 'selected'; endif; ?>><?php echo e($manager->employee_code); ?> · <?php echo e($manager->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['manager_employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Probation starts on</span><input class="people-control" type="date" name="probation_starts_on" value="<?php echo e(old('probation_starts_on')); ?>"><?php $__errorArgs = ['probation_starts_on'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Probation ends on</span><input class="people-control" type="date" name="probation_ends_on" value="<?php echo e(old('probation_ends_on')); ?>" required><?php $__errorArgs = ['probation_ends_on'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Review due on</span><input class="people-control" type="date" name="review_due_on" value="<?php echo e(old('review_due_on')); ?>"><?php $__errorArgs = ['review_due_on'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <button class="people-button is-primary" type="submit">Create case</button>
                </form>
            </div>
        </details>
    <?php endif; ?>

    <section class="people-ops-panel has-mobile-cards" aria-labelledby="confirmation-register-title">
        <header class="people-ops-panel-head"><div><h2 id="confirmation-register-title">Probation and confirmation cases</h2><p><?php echo e($cases->total()); ?> authorized case<?php echo e($cases->total() === 1 ? '' : 's'); ?>.</p></div></header>
        <div class="people-ops-panel-body">
            <form method="GET" action="<?php echo e(route('hr.confirmation-cases.index')); ?>" class="people-ops-filterbar" aria-label="Filter confirmation cases">
                <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id"><option value="">All visible employees</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string)request('employee_id')===(string)$employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> · <?php echo e($employee->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Department</span><select class="people-control" name="department"><option value="">All departments</option><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($department); ?>" <?php if(request('department')===$department): echo 'selected'; endif; ?>><?php echo e($department); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Status</span><select class="people-control" name="status"><option value="">All statuses</option><?php $__currentLoopData = ['due'=>'Due','manager_recommended'=>'Manager recommended','confirmed'=>'Confirmed','extended'=>'Extended','rejected'=>'Rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(request('status')===$value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Due from</span><input class="people-control" type="date" name="due_from" value="<?php echo e(request('due_from')); ?>"></label>
                <label class="people-field"><span>Due to</span><input class="people-control" type="date" name="due_to" value="<?php echo e(request('due_to')); ?>"></label>
                <button class="people-button is-primary">Apply</button><a class="people-button" href="<?php echo e(route('hr.confirmation-cases.index')); ?>">Clear</a>
            </form>
        </div>

        <div class="people-ops-table-wrap"><table class="people-ops-table"><caption>Employee confirmation cases</caption><thead><tr><th scope="col">Case</th><th scope="col">Employee</th><th scope="col">Probation</th><th scope="col">Manager</th><th scope="col">Decision</th><th scope="col">Status</th><th scope="col">Action</th></tr></thead><tbody>
        <?php $__empty_1 = true; $__currentLoopData = $cases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> <?php ($actions=$caseActions[$case->id]??[]); ?>
            <tr>
                <td><strong><?php echo e($case->case_number); ?></strong><small>Review due <?php echo e($case->review_due_on?->format('d M Y') ?? 'not set'); ?></small></td>
                <td><span class="people-ops-identity"><strong><?php echo e($case->employee?->name); ?></strong><small><?php echo e($case->employee?->employee_code); ?> · <?php echo e($case->employee?->department ?: 'No department'); ?></small></span></td>
                <td><?php echo e($case->probation_starts_on?->format('d M Y') ?? 'Not set'); ?><small>to <?php echo e($case->probation_ends_on?->format('d M Y') ?? 'Not set'); ?></small></td>
                <td><?php echo e($case->managerEmployee?->name ?? 'Not assigned'); ?></td>
                <td><?php echo e($case->manager_recommendation ? ucfirst($case->manager_recommendation) : 'Awaiting manager'); ?><small><?php echo e($case->hr_decision ? 'HR: '.ucfirst($case->hr_decision) : 'HR decision pending'); ?></small></td>
                <td><span class="people-status is-<?php echo e(in_array($case->status,['confirmed'],true) ? 'success' : (in_array($case->status,['rejected'],true) ? 'danger' : 'warning')); ?>"><?php echo e(str_replace('_',' ',ucfirst($case->status))); ?></span></td>
                <td><?php echo $__env->make('hr.confirmation.partials.case-actions', ['case' => $case, 'actions' => $actions, 'mobile' => false], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="7"><div class="people-ops-empty"><strong>No confirmation cases found</strong><span>Clear the filters or create an authorized case.</span></div></td></tr><?php endif; ?>
        </tbody></table></div>

        <div class="people-ops-mobile-list"><?php $__empty_1 = true; $__currentLoopData = $cases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> <?php ($actions=$caseActions[$case->id]??[]); ?><article class="people-ops-mobile-card"><header class="people-ops-mobile-card-head"><span class="people-ops-identity"><strong><?php echo e($case->employee?->name); ?></strong><small><?php echo e($case->case_number); ?> · <?php echo e($case->employee?->employee_code); ?></small></span><span class="people-status is-info"><?php echo e(str_replace('_',' ',ucfirst($case->status))); ?></span></header><dl class="people-ops-mobile-facts"><div><dt>Review due</dt><dd><?php echo e($case->review_due_on?->format('d M Y') ?? 'Not set'); ?></dd></div><div><dt>Manager</dt><dd><?php echo e($case->managerEmployee?->name ?? 'Not assigned'); ?></dd></div><div><dt>Recommendation</dt><dd><?php echo e($case->manager_recommendation ? ucfirst($case->manager_recommendation) : 'Pending'); ?></dd></div></dl><?php echo $__env->make('hr.confirmation.partials.case-actions', ['case' => $case, 'actions' => $actions, 'mobile' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></article><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><div class="people-ops-empty"><strong>No confirmation cases found</strong></div><?php endif; ?></div>
        <?php echo e($cases->withQueryString()->links()); ?>

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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\confirmation\index.blade.php ENDPATH**/ ?>