<?php $__env->startSection('title', 'Employee Activity History - Builder360 ERP-CRM'); ?>
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Employee Activity History','description' => $employee->employee_code.' - '.$employee->name.' - '.$employee->designation,'eyebrow' => 'People / Employee 360','active' => 'employees'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> <a class="people-button" href="<?php echo e(route('hr.employees.index')); ?>"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Employee directory</a> <?php $__env->endSlot(); ?>
    <?php if (isset($component)) { $__componentOriginald7d6991c6f8cbf6e7a6895c044edeaa1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald7d6991c6f8cbf6e7a6895c044edeaa1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.employee-profile-navigation','data' => ['links' => $profileNavigation,'active' => 'audit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.employee-profile-navigation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($profileNavigation),'active' => 'audit']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald7d6991c6f8cbf6e7a6895c044edeaa1)): ?>
<?php $attributes = $__attributesOriginald7d6991c6f8cbf6e7a6895c044edeaa1; ?>
<?php unset($__attributesOriginald7d6991c6f8cbf6e7a6895c044edeaa1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald7d6991c6f8cbf6e7a6895c044edeaa1)): ?>
<?php $component = $__componentOriginald7d6991c6f8cbf6e7a6895c044edeaa1; ?>
<?php unset($__componentOriginald7d6991c6f8cbf6e7a6895c044edeaa1); ?>
<?php endif; ?>
    <section class="blade-card"><div class="blade-card-header"><div><p class="blade-eyebrow">Traceable changes</p><h2>Employee-related events</h2></div></div><form method="GET" action="<?php echo e(route('hr.employees.audit-events.index',$employee)); ?>" class="blade-filter-grid"><label>Event type<input name="event_type" value="<?php echo e(request('event_type')); ?>" placeholder="hr.employee.updated"></label><label>Date from<input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>"></label><label>Date to<input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>"></label><button class="blade-secondary-action">Apply filters</button></form><div class="blade-table-wrap"><table class="blade-table"><caption class="sr-only">Audit events for <?php echo e($employee->name); ?></caption><thead><tr><th scope="col">Date and time</th><th scope="col">Action</th><th scope="col">Event</th><th scope="col">User</th><th scope="col">Request context</th></tr></thead><tbody><?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><?php echo e($event->created_at?->format('d M Y H:i:s')); ?></td><td><?php echo e($event->action); ?></td><td><?php echo e($event->event_type); ?></td><td><?php echo e($event->user?->name??'System process'); ?><br><span><?php echo e($event->user?->role?->name); ?></span></td><td><?php echo e($event->request_method); ?> <?php echo e($event->request_path); ?><br><span><?php echo e($event->request_id); ?></span></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="5">No employee activity events are available for the selected filters.</td></tr><?php endif; ?></tbody></table></div><?php echo e($events->withQueryString()->links()); ?></section>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\employees\audit.blade.php ENDPATH**/ ?>