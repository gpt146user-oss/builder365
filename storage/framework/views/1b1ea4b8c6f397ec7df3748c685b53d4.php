<?php $__env->startSection('title', 'Payroll - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Payroll Workspace','description' => 'Run payroll, control approved bank batches, and review the active salary masters available to your role.','active' => 'payroll'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if($activeRegister !== 'runs' && $abilities['canGenerateRun']): ?>
            <a class="people-button is-primary" href="<?php echo e(route('payroll.runs.index')); ?>#generate-payroll-run">
                <i class="fa-solid fa-play" aria-hidden="true"></i>
                <span>Generate payroll</span>
            </a>
        <?php endif; ?>
     <?php $__env->endSlot(); ?>

    <?php if(session('status')): ?>
        <div class="people-alert is-success" role="status"><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <section class="people-alert is-danger" role="alert" aria-labelledby="payroll-errors-title" tabindex="-1">
            <strong id="payroll-errors-title">Please correct the highlighted payroll fields.</strong>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </section>
    <?php endif; ?>

    <nav class="people-ops-tabs" aria-label="Payroll registers">
        <a href="<?php echo e(route('payroll.runs.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'runs']); ?>" <?php if($activeRegister === 'runs'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-calculator" aria-hidden="true"></i><span>Payroll runs</span>
        </a>
        <a href="<?php echo e(route('payroll.bank-transfer-batches.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'bank_batches']); ?>" <?php if($activeRegister === 'bank_batches'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-building-columns" aria-hidden="true"></i><span>Bank transfers</span>
        </a>
        <a href="<?php echo e(route('payroll.salary-structures.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'structures']); ?>" <?php if($activeRegister === 'structures'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-layer-group" aria-hidden="true"></i><span>Salary structures</span>
        </a>
        <a href="<?php echo e(route('payroll.components.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'components']); ?>" <?php if($activeRegister === 'components'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-list-check" aria-hidden="true"></i><span>Payroll components</span>
        </a>
        <a href="<?php echo e(route('payroll.commission-rules.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'commission_rules']); ?>" <?php if($activeRegister === 'commission_rules'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-percent" aria-hidden="true"></i><span>Commission rules</span>
        </a>
        <a href="<?php echo e(route('payroll.commission-runs.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'commission_runs']); ?>" <?php if($activeRegister === 'commission_runs'): ?> aria-current="page" <?php endif; ?>>
            <i class="fa-solid fa-coins" aria-hidden="true"></i><span>Commission runs</span>
        </a>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewAny', \App\Models\EmployeeTaxProfile::class)): ?>
            <a href="<?php echo e(route('payroll.employee-tax-profiles.index')); ?>">
                <i class="fa-solid fa-file-shield" aria-hidden="true"></i><span>Employee tax inputs</span>
            </a>
        <?php endif; ?>
    </nav>

    <section class="people-ops-kpis is-four" aria-label="Payroll summary">
        <article class="people-ops-kpi is-info">
            <span class="people-ops-kpi-icon"><i class="fa-solid fa-receipt" aria-hidden="true"></i></span>
            <span>Total payroll runs</span>
            <strong><?php echo e(number_format($summary->totalRuns)); ?></strong>
            <small>Across the complete authorized company register.</small>
        </article>
        <article class="people-ops-kpi is-warning">
            <span class="people-ops-kpi-icon"><i class="fa-solid fa-hourglass-half" aria-hidden="true"></i></span>
            <span>Awaiting approval</span>
            <strong><?php echo e(number_format($summary->generatedRuns)); ?></strong>
            <small>Generated payroll runs that have not been approved.</small>
        </article>
        <article class="people-ops-kpi is-success">
            <span class="people-ops-kpi-icon"><i class="fa-solid fa-circle-check" aria-hidden="true"></i></span>
            <span>Approved payroll runs</span>
            <strong><?php echo e(number_format($summary->approvedRuns)); ?></strong>
            <small>Approved net payable: <?php echo e($summary->approvedNetPayable); ?></small>
        </article>
        <article class="people-ops-kpi is-purple">
            <span class="people-ops-kpi-icon"><i class="fa-solid fa-money-check-dollar" aria-hidden="true"></i></span>
            <span>Bank batches</span>
            <strong><?php echo e(number_format($summary->preparedBatches + $summary->releasedBatches)); ?></strong>
            <small><?php echo e($summary->preparedBatches); ?> prepared and <?php echo e($summary->releasedBatches); ?> released.</small>
        </article>
    </section>

    <?php echo $__env->make('payroll.workspace.partials.'.$activeRegister, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\payroll\workspace\index.blade.php ENDPATH**/ ?>