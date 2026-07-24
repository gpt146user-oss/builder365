<?php $__env->startSection('title', 'Recruitment - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Recruitment','description' => 'Manage authorized job openings, candidate pipelines, interviews, and offers from one company-scoped workspace.','active' => 'recruitment'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php
            $createLabels = [
                'openings' => ['ability' => 'canCreateOpening', 'label' => 'New job opening', 'href' => '#recruitment-create'],
                'pipeline' => ['ability' => 'canCreateCandidate', 'label' => 'New candidate', 'href' => route('recruitment.candidates.index').'#recruitment-create'],
                'candidates' => ['ability' => 'canCreateCandidate', 'label' => 'New candidate', 'href' => '#recruitment-create'],
                'interviews' => ['ability' => 'canScheduleInterview', 'label' => 'Schedule interview', 'href' => '#recruitment-create'],
                'offers' => ['ability' => 'canCreateOffer', 'label' => 'New offer draft', 'href' => '#recruitment-create'],
            ];
            $createAction = $createLabels[$activeRegister] ?? null;
        ?>
        <?php if($createAction && ($abilities[$createAction['ability']] ?? false)): ?>
            <a class="people-button is-primary" href="<?php echo e($createAction['href']); ?>">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> <?php echo e($createAction['label']); ?>

            </a>
        <?php endif; ?>
     <?php $__env->endSlot(); ?>

    <?php if(session('status')): ?>
        <section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <section class="people-alert is-danger" role="alert" tabindex="-1">
            <strong>The recruitment action was not completed.</strong>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </section>
    <?php endif; ?>

    <nav class="people-ops-tabs" aria-label="Recruitment sections">
        <a href="<?php echo e(route('recruitment.pipeline.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'pipeline']); ?>" <?php if($activeRegister === 'pipeline'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-table-columns" aria-hidden="true"></i> Pipeline
        </a>
        <a href="<?php echo e(route('recruitment.job-openings.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'openings']); ?>" <?php if($activeRegister === 'openings'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-briefcase" aria-hidden="true"></i> Job openings
        </a>
        <a href="<?php echo e(route('recruitment.candidates.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'candidates']); ?>" <?php if($activeRegister === 'candidates'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-user-group" aria-hidden="true"></i> Candidates
        </a>
        <a href="<?php echo e(route('recruitment.interviews.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'interviews']); ?>" <?php if($activeRegister === 'interviews'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-regular fa-calendar-check" aria-hidden="true"></i> Interviews
        </a>
        <a href="<?php echo e(route('recruitment.offers.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'offers']); ?>" <?php if($activeRegister === 'offers'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-file-signature" aria-hidden="true"></i> Offers
        </a>
    </nav>

    <section class="people-ops-kpis" aria-label="Recruitment summary">
        <article class="people-ops-kpi is-info"><span class="people-ops-kpi-icon"><i class="fa-solid fa-briefcase" aria-hidden="true"></i></span><span>Open requisitions</span><strong><?php echo e($summary->openRequisitions); ?></strong><small><?php echo e($summary->openPositions); ?> approved positions</small></article>
        <article class="people-ops-kpi is-purple"><span class="people-ops-kpi-icon"><i class="fa-solid fa-user-group" aria-hidden="true"></i></span><span>Active candidates</span><strong><?php echo e($summary->activeCandidates); ?></strong><small>Across your authorized company scope</small></article>
        <article class="people-ops-kpi is-warning"><span class="people-ops-kpi-icon"><i class="fa-regular fa-calendar-check" aria-hidden="true"></i></span><span>Scheduled interviews</span><strong><?php echo e($summary->scheduledInterviews); ?></strong><small>Interview feedback remains workflow controlled</small></article>
        <article class="people-ops-kpi"><span class="people-ops-kpi-icon"><i class="fa-solid fa-file-signature" aria-hidden="true"></i></span><span>Draft offers</span><strong><?php echo e($summary->draftOffers); ?></strong><small>Awaiting an authorized release</small></article>
        <article class="people-ops-kpi is-success"><span class="people-ops-kpi-icon"><i class="fa-solid fa-user-check" aria-hidden="true"></i></span><span>Converted</span><strong><?php echo e($summary->convertedCandidates); ?></strong><small>Candidates converted to employees</small></article>
    </section>

    <?php echo $__env->make('recruitment.workspace.partials.'.$activeRegister, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/recruitment/workspace/index.blade.php ENDPATH**/ ?>