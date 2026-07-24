<?php $__env->startSection('title', 'Performance Management - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Performance Management','description' => 'Run authorized review cycles and monitor persisted employee and department outcomes.','active' => 'performance'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if($activeRegister === 'cycles' && $abilities['canCreateCycle']): ?>
            <a class="people-button is-primary" href="#create-performance-cycle"><i class="fa-solid fa-plus" aria-hidden="true"></i> New cycle</a>
        <?php elseif($activeRegister === 'reviews' && $abilities['canCreateReview']): ?>
            <a class="people-button is-primary" href="#create-performance-review"><i class="fa-solid fa-plus" aria-hidden="true"></i> New review</a>
        <?php endif; ?>
     <?php $__env->endSlot(); ?>

    <?php if(session('status')): ?><section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section><?php endif; ?>
    <?php if($errors->any()): ?>
        <section class="people-alert is-danger" role="alert" tabindex="-1">
            <strong>Please correct the highlighted performance fields.</strong>
            <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </section>
    <?php endif; ?>

    <nav class="people-ops-tabs" aria-label="Performance Management sections">
        <a href="<?php echo e(route('hr.performance-dashboard.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'dashboard']); ?>" <?php if($activeRegister === 'dashboard'): ?> aria-current="page" <?php endif; ?>><i class="fa-solid fa-chart-column" aria-hidden="true"></i> Department dashboard</a>
        <a href="<?php echo e(route('hr.performance-reviews.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'reviews']); ?>" <?php if($activeRegister === 'reviews'): ?> aria-current="page" <?php endif; ?>><i class="fa-regular fa-star" aria-hidden="true"></i> Reviews</a>
        <a href="<?php echo e(route('hr.performance-cycles.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'cycles']); ?>" <?php if($activeRegister === 'cycles'): ?> aria-current="page" <?php endif; ?>><i class="fa-regular fa-calendar" aria-hidden="true"></i> Cycles</a>
    </nav>

    <section class="people-ops-kpis" aria-label="Performance summary">
        <article class="people-ops-kpi is-info"><span class="people-ops-kpi-icon"><i class="fa-regular fa-calendar" aria-hidden="true"></i></span><span>Cycles</span><strong><?php echo e($summary->cycles); ?></strong><small><?php echo e($summary->activeCycles); ?> active</small></article>
        <article class="people-ops-kpi is-purple"><span class="people-ops-kpi-icon"><i class="fa-solid fa-list-check" aria-hidden="true"></i></span><span>Reviews</span><strong><?php echo e($summary->reviews); ?></strong><small><?php echo e($summary->openReviews); ?> open</small></article>
        <article class="people-ops-kpi is-success"><span class="people-ops-kpi-icon"><i class="fa-solid fa-circle-check" aria-hidden="true"></i></span><span>Closed</span><strong><?php echo e($summary->closedReviews); ?></strong><small>Persisted review closures</small></article>
        <article class="people-ops-kpi is-warning"><span class="people-ops-kpi-icon"><i class="fa-solid fa-arrow-trend-up" aria-hidden="true"></i></span><span>Average final score</span><strong><?php echo e($summary->averageFinalScore ?? '—'); ?></strong><small>Closed reviews with a final score</small></article>
        <article class="people-ops-kpi is-danger"><span class="people-ops-kpi-icon"><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i></span><span>PIP required</span><strong><?php echo e($summary->pipRequired); ?></strong><small>Persisted review flag</small></article>
    </section>

    <?php echo $__env->make('hr.performance.partials.'.$activeRegister, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/developer/public_html/builder360/resources/views/hr/performance/workspace.blade.php ENDPATH**/ ?>