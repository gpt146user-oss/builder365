<section class="people-ops-grid is-wide-left" aria-label="Salary component controls">
    <article class="people-ops-panel">
        <header class="people-ops-panel-head"><div><h2>Component master</h2><p>Review active earnings and deductions used by salary structures.</p></div></header>
        <div class="people-ops-panel-body"><ul class="people-ops-checklist"><li><i class="fa-solid fa-circle-check" aria-hidden="true"></i><span>Only active payroll components are included in this register.</span><strong><?php echo e($summary->activeComponents); ?> active</strong></li><li><i class="fa-solid fa-shield-halved" aria-hidden="true"></i><span>Calculation rules remain governed by the persisted payroll configuration.</span><strong>No inline edits</strong></li></ul></div>
    </article>
    <article class="people-ops-panel">
        <header class="people-ops-panel-head"><div><h2>Component filters</h2><p>Limit the register to earnings or deductions.</p></div></header>
        <div class="people-ops-panel-body"><form method="GET" action="<?php echo e(route('payroll.components.index')); ?>" class="people-form-grid"><label class="people-field is-wide"><span>Component type</span><select class="people-control" name="component_type"><option value="">All component types</option><?php $__currentLoopData = $componentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($type['value']); ?>" <?php if(request('component_type') === $type['value']): echo 'selected'; endif; ?>><?php echo e($type['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label><div class="people-modal-actions is-wide"><button class="people-button" type="submit">Apply filter</button><a class="people-button" href="<?php echo e(route('payroll.components.index')); ?>">Clear</a></div></form></div>
    </article>
</section>

<section class="people-ops-panel" aria-labelledby="components-title">
    <header class="people-ops-panel-head"><div><h2 id="components-title">Salary components</h2><p><?php echo e($components->total()); ?> active component<?php echo e($components->total() === 1 ? '' : 's'); ?> in this company scope.</p></div></header>
    <div class="people-ops-table-wrap">
        <table class="people-ops-table">
            <caption>Active salary component register</caption>
            <thead><tr><th scope="col">Code</th><th scope="col">Name</th><th scope="col">Type</th><th scope="col">Calculation</th><th scope="col">Tax</th><th scope="col">Statutory</th><th scope="col">Rules</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $components; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr><td><strong><?php echo e($component->code); ?></strong></td><td><?php echo e($component->name); ?></td><td><span class="people-status is-<?php echo e($component->type === 'earning' ? 'success' : 'warning'); ?>"><?php echo e($component->typeLabel); ?></span></td><td><?php echo e($component->calculationLabel); ?></td><td><?php echo e($component->taxableLabel); ?></td><td><?php echo e($component->statutoryLabel); ?></td><td><?php $__empty_2 = true; $__currentLoopData = $component->rules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?><span class="people-subtext"><?php echo e($rule); ?></span><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?><span class="people-subtext">No additional rules</span><?php endif; ?></td></tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7"><div class="people-ops-empty"><i class="fa-solid fa-list-check" aria-hidden="true"></i><strong>No salary components found</strong><span>Clear the filter or activate components in the governed payroll configuration.</span></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="people-pagination"><?php echo e($components->withQueryString()->links()); ?></div>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/payroll/workspace/partials/components.blade.php ENDPATH**/ ?>