<section class="people-ops-kpis is-four" aria-label="Salary master summary">
    <article class="people-ops-kpi is-info"><span class="people-ops-kpi-icon"><i class="fa-solid fa-layer-group" aria-hidden="true"></i></span><span>Active structures</span><strong><?php echo e(number_format($summary->activeStructures)); ?></strong><small>Only currently active structures are listed.</small></article>
    <article class="people-ops-kpi is-purple"><span class="people-ops-kpi-icon"><i class="fa-solid fa-list-check" aria-hidden="true"></i></span><span>Active components</span><strong><?php echo e(number_format($summary->activeComponents)); ?></strong><small>Configured earnings and deductions.</small></article>
</section>

<section class="people-ops-panel" aria-labelledby="salary-structures-title">
    <header class="people-ops-panel-head"><div><h2 id="salary-structures-title">Salary structures</h2><p><?php echo e($structures->total()); ?> active structure<?php echo e($structures->total() === 1 ? '' : 's'); ?> in this company scope.</p></div></header>
    <div class="people-ops-table-wrap">
        <table class="people-ops-table">
            <caption>Active salary structure register</caption>
            <thead><tr><th scope="col">Code</th><th scope="col">Name</th><th scope="col" class="is-number">Version</th><th scope="col">Effective</th><th scope="col" class="is-number">Monthly CTC</th><th scope="col">Components</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $structures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $structure): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr><td><strong><?php echo e($structure->code); ?></strong></td><td><?php echo e($structure->name); ?></td><td class="is-number"><?php echo e($structure->version); ?></td><td><?php echo e($structure->effectiveRange); ?></td><td class="is-number"><strong><?php echo e($structure->monthlyCtc); ?></strong></td><td><?php $__empty_2 = true; $__currentLoopData = $structure->components; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?><span class="people-subtext"><?php echo e($component); ?></span><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?><span class="people-subtext">No components configured</span><?php endif; ?></td></tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6"><div class="people-ops-empty"><i class="fa-solid fa-layer-group" aria-hidden="true"></i><strong>No active salary structures</strong><span>No active salary structures are available in your company scope.</span></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="people-pagination"><?php echo e($structures->withQueryString()->links()); ?></div>
</section>
<?php /**PATH /home/developer/public_html/builder360/resources/views/payroll/workspace/partials/structures.blade.php ENDPATH**/ ?>