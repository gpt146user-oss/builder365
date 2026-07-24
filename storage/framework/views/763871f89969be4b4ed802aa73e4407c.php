<?php $__env->startSection('title', 'Shifts & Rosters - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Shifts & Rosters','description' => 'Effective assignments, dated rosters, reusable rotations, governed swaps, and payroll-ready attendance locks.','active' => 'shifts'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if($abilities['canManage']): ?>
            <a class="people-button is-primary" href="#roster-create"><i class="fa-solid fa-plus" aria-hidden="true"></i> New roster</a>
        <?php endif; ?>
     <?php $__env->endSlot(); ?>

    <?php if(session('status')): ?>
        <section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <section class="people-alert is-danger" role="alert" tabindex="-1">
            <strong>Please correct the highlighted roster fields.</strong>
            <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </section>
    <?php endif; ?>

    <nav class="people-ops-tabs" aria-label="Attendance Management sections">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewAny', \App\Models\AttendanceRegularizationRequest::class)): ?>
            <a href="<?php echo e(route('hr.attendance-records.index')); ?>"><i class="fa-solid fa-table-list" aria-hidden="true"></i> Attendance register</a>
            <a href="<?php echo e(route('hr.attendance-records.index', ['view' => 'exceptions'])); ?>"><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i> Exceptions &amp; basis</a>
            <a href="<?php echo e(route('hr.attendance-regularizations.index')); ?>"><i class="fa-solid fa-clipboard-check" aria-hidden="true"></i> Regularizations</a>
            <a href="<?php echo e(route('hr.attendance-shifts.index')); ?>"><i class="fa-regular fa-clock" aria-hidden="true"></i> Shift definitions</a>
        <?php endif; ?>
        <a class="is-active" href="<?php echo e(route('hr.attendance-rosters.index')); ?>" aria-current="page"><i class="fa-solid fa-calendar-days" aria-hidden="true"></i> Rosters &amp; rotations</a>
    </nav>

    <?php ($activeView = $filters['view'] ?? 'rosters'); ?>
    <?php ($rosterViews = ['rosters' => ['calendar-days', 'Rosters'], 'rotations' => ['rotate', 'Rotations'], 'swaps' => ['right-left', 'Shift swaps']]); ?>
    <?php if($abilities['canViewPeriods']): ?>
        <?php ($rosterViews['periods'] = ['lock', 'Attendance periods']); ?>
    <?php endif; ?>
    <nav class="people-ops-tabs is-secondary" aria-label="Roster workspace sections">
        <?php $__currentLoopData = $rosterViews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $view => [$icon, $label]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('hr.attendance-rosters.index', ['view' => $view])); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeView === $view]); ?>" <?php if($activeView === $view): ?> aria-current="page" <?php endif; ?>>
                <i class="fa-solid fa-<?php echo e($icon); ?>" aria-hidden="true"></i> <?php echo e($label); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>

    <?php echo $__env->make('hr.attendance.rosters.'.$activeView, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/developer/public_html/builder360/resources/views/hr/attendance/rosters.blade.php ENDPATH**/ ?>