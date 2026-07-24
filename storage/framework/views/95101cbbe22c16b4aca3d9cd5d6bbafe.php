<?php $__env->startSection('title', 'Attendance Management - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Attendance Management','description' => 'Attendance records, explainable exceptions, regularization approvals, shift definitions, and effective assignments.','active' => in_array($activeRegister, ['shifts', 'assignments'], true) ? 'shifts' : 'attendance'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if($activeRegister === 'regularizations' && $abilities['canCreateRegularization']): ?>
            <a class="people-button is-primary" href="#regularization-form">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> New regularization
            </a>
        <?php elseif($activeRegister === 'shifts' && $abilities['canCreateShift']): ?>
            <a class="people-button is-primary" href="#shift-form">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> New shift
            </a>
        <?php endif; ?>
     <?php $__env->endSlot(); ?>

    <?php if(session('status')): ?>
        <section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <section class="people-alert is-danger" role="alert" tabindex="-1">
            <strong>Please correct the highlighted attendance fields.</strong>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </section>
    <?php endif; ?>

    <nav class="people-ops-tabs" aria-label="Attendance Management sections">
        <a href="<?php echo e(route('hr.attendance-records.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'records']); ?>" <?php if($activeRegister === 'records'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-table-list" aria-hidden="true"></i> Attendance register
        </a>
        <a href="<?php echo e(route('hr.attendance-records.index', ['view' => 'exceptions'])); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'exceptions']); ?>" <?php if($activeRegister === 'exceptions'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i> Exceptions &amp; basis
        </a>
        <a href="<?php echo e(route('hr.attendance-records.index', ['view' => 'trace'])); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'trace']); ?>" <?php if($activeRegister === 'trace'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-diagram-project" aria-hidden="true"></i> Calculation trace
        </a>
        <a href="<?php echo e(route('hr.attendance-regularizations.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'regularizations']); ?>" <?php if($activeRegister === 'regularizations'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-clipboard-check" aria-hidden="true"></i> Regularizations
        </a>
        <a href="<?php echo e(route('hr.attendance-shifts.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'shifts']); ?>" <?php if($activeRegister === 'shifts'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-regular fa-clock" aria-hidden="true"></i> Shift definitions
        </a>
        <a href="<?php echo e(route('hr.attendance-shifts.index', ['view' => 'assignments'])); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'assignments']); ?>" <?php if($activeRegister === 'assignments'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-user-clock" aria-hidden="true"></i> Assignments
        </a>
        <a href="<?php echo e(route('hr.attendance-rosters.index')); ?>">
            <i class="fa-solid fa-calendar-days" aria-hidden="true"></i> Rosters &amp; rotations
        </a>
    </nav>

    <?php echo $__env->make('hr.attendance.partials.'.$activeRegister, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/developer/public_html/builder360/resources/views/hr/attendance/workspace.blade.php ENDPATH**/ ?>