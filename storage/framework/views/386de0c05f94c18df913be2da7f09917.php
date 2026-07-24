<?php $__env->startSection('title', 'Leave Management - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Leave Management','description' => 'Leave Workspace for requests, balances, governed processing, encashment, and active policy controls.','active' => 'leave'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if($activeRegister === 'requests' && $abilities['canCreateLeaveRequest']): ?>
            <a class="people-button is-primary" href="#leave-request-form">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> New leave request
            </a>
        <?php endif; ?>
     <?php $__env->endSlot(); ?>

    <?php if(session('status')): ?>
        <section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <section class="people-alert is-danger" role="alert" tabindex="-1">
            <strong>Please correct the highlighted leave fields.</strong>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </section>
    <?php endif; ?>

    <nav class="people-ops-tabs" aria-label="Leave Management sections">
        <a href="<?php echo e(route('hr.leave-requests.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'requests']); ?>" <?php if($activeRegister === 'requests'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-regular fa-calendar-check" aria-hidden="true"></i> Requests
        </a>
        <a href="<?php echo e(route('hr.leave-balances.index')); ?>" aria-label="Leave balances" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'balances']); ?>" <?php if($activeRegister === 'balances'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-scale-balanced" aria-hidden="true"></i> Balances
        </a>
        <a href="<?php echo e(route('hr.leave-processing-runs.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'processing']); ?>" <?php if($activeRegister === 'processing'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-gears" aria-hidden="true"></i> Processing
        </a>
        <a href="<?php echo e(route('hr.leave-encashments.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'encashments']); ?>" <?php if($activeRegister === 'encashments'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-wallet" aria-hidden="true"></i> Encashment
        </a>
        <a href="<?php echo e(route('hr.leave-types.index')); ?>" aria-label="Leave types policy controls" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'types']); ?>" <?php if($activeRegister === 'types'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-sliders" aria-hidden="true"></i> Policy controls
        </a>
    </nav>

    <section class="people-ops-kpis is-four" aria-label="Leave operations summary">
        <article class="people-ops-kpi is-warning">
            <span class="people-ops-kpi-icon"><i class="fa-solid fa-hourglass-half" aria-hidden="true"></i></span>
            <span>Pending requests</span>
            <strong><?php echo e($summary->pendingRequests); ?></strong>
            <small>Submitted requests in your authorized scope</small>
        </article>
        <article class="people-ops-kpi is-info">
            <span class="people-ops-kpi-icon"><i class="fa-solid fa-person-walking-luggage" aria-hidden="true"></i></span>
            <span>On leave today</span>
            <strong><?php echo e($summary->onLeaveToday); ?></strong>
            <small>Approved leave intersecting today</small>
        </article>
        <article class="people-ops-kpi is-purple">
            <span class="people-ops-kpi-icon"><i class="fa-regular fa-calendar" aria-hidden="true"></i></span>
            <span>Upcoming</span>
            <strong><?php echo e($summary->upcoming); ?></strong>
            <small>Future submitted or approved requests</small>
        </article>
        <article class="people-ops-kpi is-success">
            <span class="people-ops-kpi-icon"><i class="fa-solid fa-indian-rupee-sign" aria-hidden="true"></i></span>
            <span>Encashment pending</span>
            <strong><?php echo e($summary->pendingEncashments); ?></strong>
            <small>Submitted requests awaiting a decision</small>
        </article>
    </section>

    <?php echo $__env->make('hr.leave.partials.'.$activeRegister, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\leave\workspace.blade.php ENDPATH**/ ?>