<?php $__env->startSection('title', 'Payroll Summary - Builder360 ERP-CRM'); ?>
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Payroll Summary','description' => $summary['employee']['employee_code'].' - '.$summary['employee']['name'].' - '.$summary['employee']['designation'],'eyebrow' => 'People / Employee 360','active' => 'employees'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> <a class="people-button" href="<?php echo e(route('payroll.runs.index')); ?>"><i class="fa-solid fa-money-check-dollar" aria-hidden="true"></i> Payroll workspace</a> <?php $__env->endSlot(); ?>
    <?php if (isset($component)) { $__componentOriginald7d6991c6f8cbf6e7a6895c044edeaa1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald7d6991c6f8cbf6e7a6895c044edeaa1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.employee-profile-navigation','data' => ['links' => $profileNavigation,'active' => 'payroll']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.employee-profile-navigation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($profileNavigation),'active' => 'payroll']); ?>
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
    <section class="blade-dashboard-kpis" aria-label="Payroll totals"><article class="blade-dashboard-card"><span>Payroll records</span><strong><?php echo e($summary['totals']['payroll_items_count']); ?></strong><small>Available pay periods</small></article><article class="blade-dashboard-card"><span>Gross earnings</span><strong>INR <?php echo e(number_format($summary['totals']['gross_earnings'],2)); ?></strong><small>Across available records</small></article><article class="blade-dashboard-card"><span>Deductions</span><strong>INR <?php echo e(number_format($summary['totals']['total_deductions'],2)); ?></strong><small>Across available records</small></article><article class="blade-dashboard-card"><span>Net payable</span><strong>INR <?php echo e(number_format($summary['totals']['net_payable'],2)); ?></strong><small>Across available records</small></article></section>
    <section class="blade-card"><div class="blade-card-header"><div><p class="blade-eyebrow">Current assignment</p><h2>Salary structure</h2></div></div><?php if($summary['current_assignment']): ?><dl class="blade-profile-list"><div><dt>Structure</dt><dd><?php echo e(data_get($summary,'current_assignment.structure.code')); ?> &middot; <?php echo e(data_get($summary,'current_assignment.structure.name')); ?></dd></div><div><dt>Version</dt><dd><?php echo e(data_get($summary,'current_assignment.structure.version')); ?></dd></div><div><dt>Effective from</dt><dd><?php echo e($summary['current_assignment']['effective_from']); ?></dd></div><div><dt>Status</dt><dd><?php echo e(ucfirst($summary['current_assignment']['status'])); ?></dd></div></dl><?php else: ?><p class="blade-workspace-note">No active salary assignment is available.</p><?php endif; ?></section>
    <section class="blade-card"><div class="blade-card-header"><div><p class="blade-eyebrow">Pay history</p><h2>Payroll records</h2></div></div><div class="blade-table-wrap"><table class="blade-table"><caption class="sr-only">Authorized payroll history for <?php echo e($summary['employee']['name']); ?></caption><thead><tr><th scope="col">Run</th><th scope="col">Period</th><th scope="col">Payable days</th><th scope="col">Gross</th><th scope="col">Deductions</th><th scope="col">Net</th><th scope="col">Status</th></tr></thead><tbody><?php $__empty_1 = true; $__currentLoopData = $summary['payroll_items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><?php echo e($item['run_number']); ?></td><td><?php echo e($item['period_month']); ?>/<?php echo e($item['period_year']); ?></td><td><?php echo e($item['payable_days']); ?> / <?php echo e($item['working_days']); ?></td><td>INR <?php echo e(number_format($item['gross_earnings'],2)); ?></td><td>INR <?php echo e(number_format($item['total_deductions'],2)); ?></td><td>INR <?php echo e(number_format($item['net_payable'],2)); ?></td><td><span class="blade-status-pill"><?php echo e(ucfirst($item['status'])); ?></span></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="7">No payroll records are available.</td></tr><?php endif; ?></tbody></table></div></section>
    <section class="blade-card"><div class="blade-card-header"><div><p class="blade-eyebrow">Tax records</p><h2>Employee tax documents</h2></div></div><div class="blade-table-wrap"><table class="blade-table"><caption class="sr-only">Authorized tax document history for <?php echo e($summary['employee']['name']); ?></caption><thead><tr><th scope="col">Document</th><th scope="col">Financial year</th><th scope="col">Gross salary</th><th scope="col">Taxable income</th><th scope="col">TDS</th><th scope="col">Status</th></tr></thead><tbody><?php $__empty_1 = true; $__currentLoopData = $summary['tax_documents']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><?php echo e($document['document_number']); ?><br><span><?php echo e(str_replace('_',' ',ucfirst($document['document_type']))); ?></span></td><td><?php echo e($document['financial_year']); ?></td><td>INR <?php echo e(number_format($document['gross_salary'],2)); ?></td><td>INR <?php echo e(number_format($document['taxable_income'],2)); ?></td><td>INR <?php echo e(number_format($document['tds_deducted'],2)); ?></td><td><span class="blade-status-pill"><?php echo e(ucfirst($document['status'])); ?></span></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="6">No tax documents are available.</td></tr><?php endif; ?></tbody></table></div></section>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/developer/public_html/builder360/resources/views/hr/employees/payroll-summary.blade.php ENDPATH**/ ?>