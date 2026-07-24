<?php $__env->startSection('title', 'Policy Acknowledgements - Builder360 ERP-CRM'); ?>
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Policy Acknowledgements','description' => 'Review active employee policies and retain traceable acknowledgement records by version.','eyebrow' => 'People / Policies','active' => 'compliance','selfService' => $selfService] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if (! ($selfService)): ?><a class="people-button" href="<?php echo e(route('hr.compliance-rule-settings.index')); ?>"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> Compliance rules</a><?php endif; ?>
        <?php if($currentEmployee): ?><a class="people-button" href="<?php echo e(route('hr.employees.me')); ?>"><i class="fa-solid fa-id-card" aria-hidden="true"></i> Self Service</a><?php endif; ?>
     <?php $__env->endSlot(); ?>
    <?php if(session('status')): ?><section class="blade-alert blade-alert-success" role="status"><?php echo e(session('status')); ?></section><?php endif; ?>
    <?php if($errors->any()): ?><section class="blade-alert blade-alert-danger" role="alert" tabindex="-1"><strong>Please correct the highlighted acknowledgement fields.</strong><ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></section><?php endif; ?>

    <?php if($policies!==[]): ?>
    <section class="blade-workspace-grid" aria-label="Policies available to acknowledge">
        <?php $__currentLoopData = $policies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $policy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <article class="blade-card"><div class="blade-card-header"><div><p class="blade-eyebrow">Version <?php echo e($policy['policy_version']); ?></p><h2><?php echo e($policy['policy_title']); ?></h2></div><span class="blade-status-pill"><?php echo e(ucfirst($policy['status'])); ?></span></div><p><?php echo e($policy['summary']); ?></p><dl class="blade-profile-list"><div><dt>Effective from</dt><dd><?php echo e($policy['effective_from']); ?></dd></div><div><dt>Status</dt><dd><?php echo e(ucfirst($policy['status'])); ?></dd></div></dl>
            <?php if($abilities['canAcknowledge']&&$policy['status']!=='acknowledged'): ?><form method="POST" action="<?php echo e(route('hr.policy-acknowledgements.store')); ?>" class="blade-inline-form"><?php echo csrf_field(); ?><input type="hidden" name="employee_id" value="<?php echo e($currentEmployee->id); ?>"><input type="hidden" name="policy_key" value="<?php echo e($policy['policy_key']); ?>"><input type="hidden" name="policy_version" value="<?php echo e($policy['policy_version']); ?>"><textarea name="acknowledgement_note" maxlength="1000" placeholder="Optional acknowledgement note"></textarea><button class="blade-primary-action">Acknowledge policy</button></form><?php endif; ?>
        </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </section>
    <?php endif; ?>

    <section class="blade-card"><div class="blade-card-header"><div><p class="blade-eyebrow">Acknowledgement register</p><h2>Policy history</h2></div></div>
        <form method="GET" action="<?php echo e(route('hr.policy-acknowledgements.index')); ?>" class="blade-filter-grid"><?php if($employees->count()>1): ?><label>Employee<select name="employee_id"><option value="">All visible employees</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string)request('employee_id')===(string)$employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> &middot; <?php echo e($employee->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label><?php endif; ?><label>Policy key<input name="policy_key" value="<?php echo e(request('policy_key')); ?>" placeholder="Policy identifier"></label><label>Status<select name="status"><option value="">All statuses</option><option value="pending" <?php if(request('status')==='pending'): echo 'selected'; endif; ?>>Pending</option><option value="acknowledged" <?php if(request('status')==='acknowledged'): echo 'selected'; endif; ?>>Acknowledged</option></select></label><button class="blade-secondary-action">Apply filters</button></form>
        <div class="blade-table-wrap"><table class="blade-table"><caption class="sr-only">Policy acknowledgement history for employees visible to your role</caption><thead><tr><th scope="col">Policy</th><th scope="col">Employee</th><th scope="col">Version</th><th scope="col">Status</th><th scope="col">Acknowledged by</th><th scope="col">Date</th><th scope="col">Note</th></tr></thead><tbody><?php $__empty_1 = true; $__currentLoopData = $acknowledgements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $acknowledgement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><strong><?php echo e($acknowledgement->policy_title); ?></strong><br><span><?php echo e($acknowledgement->policy_key); ?></span></td><td><?php echo e($acknowledgement->employee?->employee_code); ?><br><span><?php echo e($acknowledgement->employee?->name); ?></span></td><td>v<?php echo e($acknowledgement->policy_version); ?></td><td><span class="blade-status-pill"><?php echo e(ucfirst($acknowledgement->status)); ?></span></td><td><?php echo e($acknowledgement->acknowledgedBy?->name??'Pending'); ?></td><td><?php echo e($acknowledgement->acknowledged_at?->format('d M Y H:i')??'—'); ?></td><td><?php echo e($acknowledgement->acknowledgement_note??'—'); ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="7">No policy acknowledgement records are available for the selected filters.</td></tr><?php endif; ?></tbody></table></div><?php echo e($acknowledgements->withQueryString()->links()); ?>

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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\policies\index.blade.php ENDPATH**/ ?>