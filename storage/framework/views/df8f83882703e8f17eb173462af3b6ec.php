<?php $__env->startSection('title', 'Reports & MIS - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $reports = $catalog['reports'] ?? [];
    $reportCount = (int) ($catalog['reportCount'] ?? count($reports));
    $compensationVisible = (bool) ($catalog['compensationVisible'] ?? false);
    $availableFormats = collect($reports)
        ->flatMap(fn (array $report): array => array_values($report['formats'] ?? []))
        ->unique()
        ->values();
?>

<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Reports & MIS','description' => 'Run the HR exports that are implemented, permission-scoped, and auditable today.','active' => 'reports'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewAny', \App\Models\Employee::class)): ?>
            <a class="people-button" href="<?php echo e(route('hr.employees.index')); ?>">
                <i class="fa-solid fa-address-card" aria-hidden="true"></i> Employee Master
            </a>
        <?php endif; ?>
     <?php $__env->endSlot(); ?>

    <section class="people-ops-kpis is-four" aria-label="HR report catalog summary">
        <article class="people-ops-kpi is-info">
            <span class="people-ops-kpi-icon"><i class="fa-solid fa-file-lines" aria-hidden="true"></i></span>
            <span>Available reports</span><strong><?php echo e(number_format($reportCount)); ?></strong><small>Backed by implemented export routes</small>
        </article>
        <article class="people-ops-kpi is-success">
            <span class="people-ops-kpi-icon"><i class="fa-solid fa-file-export" aria-hidden="true"></i></span>
            <span>Export formats</span><strong><?php echo e(number_format($availableFormats->count())); ?></strong><small><?php echo e($availableFormats->isEmpty() ? 'No export format is available' : $availableFormats->map(fn (string $format): string => strtoupper($format === 'xlsx' ? 'Excel' : $format))->join(', ')); ?></small>
        </article>
        <article class="people-ops-kpi is-purple">
            <span class="people-ops-kpi-icon"><i class="fa-solid fa-building-shield" aria-hidden="true"></i></span>
            <span>Data scope</span><strong>Company</strong><small>Role and company filters remain authoritative</small>
        </article>
        <article class="people-ops-kpi is-warning">
            <span class="people-ops-kpi-icon"><i class="fa-solid fa-lock" aria-hidden="true"></i></span>
            <span>Employee compensation</span><strong><?php echo e($compensationVisible ? 'Permitted' : 'Restricted'); ?></strong><small><?php echo e($compensationVisible ? 'Included only where the employee export policy permits it' : 'Masked in Employee Master exports'); ?></small>
        </article>
    </section>

    <section class="people-alert" role="note" aria-label="Report security notice">
        <strong>Governed exports only.</strong>
        Each report keeps its existing company scope and authorization policy. Employee exports also retain Employee Master field-visibility rules. Every completed export is recorded in the audit trail.
    </section>

    <section class="people-ops-panel" aria-labelledby="hr-report-catalog-title">
        <header class="people-ops-panel-head">
            <div><h2 id="hr-report-catalog-title">Report catalog</h2><p>Only production-backed exports are listed; unavailable prototype reports are not shown.</p></div>
            <span class="people-count"><?php echo e(number_format($reportCount)); ?></span>
        </header>

        <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="people-command-row">
                <span class="people-command-row-icon"><i class="fa-solid <?php echo e($report['icon']); ?>" aria-hidden="true"></i></span>
                <span class="people-command-row-copy">
                    <strong><?php echo e($report['title']); ?></strong>
                    <small><?php echo e($report['description']); ?> &middot; <?php echo e($report['category']); ?></small>
                </span>
                <span class="people-page-actions" aria-label="Export <?php echo e($report['title']); ?>">
                    <?php $__currentLoopData = $report['formats']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $format => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $exportParameters = array_merge(
                                ['format' => $format],
                                $report['routeParameters'] ?? ['report_type' => $report['reportType'] ?? $report['title']],
                            );
                        ?>
                        <a
                            class="people-button<?php echo e($format === 'csv' ? ' is-primary' : ''); ?>"
                            href="<?php echo e(route($report['routeName'], $exportParameters)); ?>"
                            aria-label="Export <?php echo e($report['title']); ?> as <?php echo e($label); ?>"
                        >
                            <i class="fa-solid fa-download" aria-hidden="true"></i> <?php echo e($label); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </span>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php if (isset($component)) { $__componentOriginal3abc64969eeeba849011f1a920d3a3ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.people-state','data' => ['type' => 'restricted','icon' => 'fa-file-circle-xmark','title' => 'No HR reports are available','message' => 'Your current role does not have access to an implemented HR export.','compact' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'restricted','icon' => 'fa-file-circle-xmark','title' => 'No HR reports are available','message' => 'Your current role does not have access to an implemented HR export.','compact' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $attributes = $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $component = $__componentOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?>
        <?php endif; ?>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\reports\index.blade.php ENDPATH**/ ?>