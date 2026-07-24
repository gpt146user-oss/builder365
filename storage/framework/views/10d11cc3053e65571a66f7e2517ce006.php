<?php if($abilities['canCreateReview']): ?>
    <details class="people-ops-panel" id="create-performance-review" <?php if($errors->any()): ?> open <?php endif; ?>>
        <summary class="people-ops-panel-head"><div><h2>Open employee review</h2><p>Create a review inside an active authorized performance cycle.</p></div></summary>
        <div class="people-ops-panel-body">
            <form method="POST" action="<?php echo e(route('hr.performance-reviews.store')); ?>" class="people-form-grid">
                <?php echo csrf_field(); ?>
                <label class="people-field"><span>Cycle</span><select class="people-control" name="performance_cycle_id" required><option value="">Select cycle</option><?php $__currentLoopData = $activeCycles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cycle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($cycle->id); ?>" <?php if((string)old('performance_cycle_id')===(string)$cycle->id): echo 'selected'; endif; ?>><?php echo e($cycle->cycle_code); ?> - <?php echo e($cycle->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id" required><option value="">Select employee</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string)old('employee_id')===(string)$employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Manager</span><select class="people-control" name="manager_employee_id"><option value="">Use reporting manager</option><?php $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($manager->id); ?>" <?php if((string)old('manager_employee_id')===(string)$manager->id): echo 'selected'; endif; ?>><?php echo e($manager->employee_code); ?> - <?php echo e($manager->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>KPI</span><input class="people-control" name="kpis[0][name]" maxlength="160" value="<?php echo e(old('kpis.0.name')); ?>" required></label>
                <label class="people-field"><span>Target</span><input class="people-control" name="kpis[0][target]" maxlength="160" value="<?php echo e(old('kpis.0.target')); ?>" required></label>
                <label class="people-field"><span>Metric</span><input class="people-control" name="kpis[0][metric]" maxlength="100" value="<?php echo e(old('kpis.0.metric')); ?>" required></label>
                <label class="people-field"><span>Weight percent</span><input class="people-control" type="number" name="kpis[0][weight]" min="0" max="100" step="0.01" value="<?php echo e(old('kpis.0.weight',100)); ?>" required></label>
                <button class="people-button is-primary" type="submit">Open review</button>
            </form>
        </div>
    </details>
<?php endif; ?>

<section class="people-ops-panel has-mobile-cards" aria-labelledby="performance-reviews-title">
    <header class="people-ops-panel-head"><div><h2 id="performance-reviews-title">Employee reviews</h2><p><?php echo e($reviews->total()); ?> authorized review<?php echo e($reviews->total() === 1 ? '' : 's'); ?>.</p></div></header>
    <div class="people-ops-panel-body">
        <form method="GET" action="<?php echo e(route('hr.performance-reviews.index')); ?>" class="people-ops-filterbar">
            <label class="people-field"><span>Cycle</span><select class="people-control" name="cycle_id"><option value="">All cycles</option><?php $__currentLoopData = $activeCycles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cycle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($cycle->id); ?>" <?php if((string)request('cycle_id')===(string)$cycle->id): echo 'selected'; endif; ?>><?php echo e($cycle->cycle_code); ?> - <?php echo e($cycle->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id"><option value="">All visible employees</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string)request('employee_id')===(string)$employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="people-field"><span>Status</span><select class="people-control" name="status"><option value="">All statuses</option><?php $__currentLoopData = ['draft'=>'Draft','self_submitted'=>'Self submitted','manager_submitted'=>'Manager submitted','closed'=>'Closed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(request('status')===$value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="people-field"><span>PIP</span><select class="people-control" name="pip_required"><option value="">All reviews</option><option value="1" <?php if(request('pip_required')==='1'): echo 'selected'; endif; ?>>PIP required</option><option value="0" <?php if(request('pip_required')==='0'): echo 'selected'; endif; ?>>Not required</option></select></label>
            <button class="people-button is-primary">Apply filters</button><a class="people-button" href="<?php echo e(route('hr.performance-reviews.index')); ?>">Clear</a>
        </form>
    </div>
    <div class="people-ops-table-wrap">
        <table class="people-ops-table">
            <caption>Employee performance reviews</caption>
            <thead><tr><th scope="col">Review</th><th scope="col">Employee</th><th scope="col">Cycle / period</th><th scope="col">Scores</th><th scope="col">Status</th><th scope="col" class="is-actions">Action</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><strong><?php echo e($review->number); ?></strong><small>Manager: <?php echo e($review->managerName); ?></small></td>
                    <td><div class="people-ops-identity"><div><strong><?php echo e($review->employeeName); ?></strong><small><?php echo e($review->employeeCode); ?> / <?php echo e($review->department); ?></small></div></div></td>
                    <td><?php echo e($review->cycleName); ?><small><?php echo e($review->period); ?></small></td>
                    <td>
                        Self <?php echo e($review->selfScore ?? '—'); ?> / Manager <?php echo e($review->managerScore ?? '—'); ?>

                        <?php if($review->formulaScore): ?>
                            <small>Formula <?php echo e($review->formulaScore); ?> / <?php echo e($review->formulaRating); ?><?php echo e($review->scoreIsOverride ? ' (approved override)' : ''); ?></small>
                            <details class="people-score-trace">
                                <summary>Calculation trace</summary>
                                <span>Rule v<?php echo e($review->scoringRuleVersion); ?> · <?php echo e($review->scoringCalculatedAt); ?></span>
                                <?php $__currentLoopData = ($review->calculationTrace['components'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $componentKey => $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span><?php echo e($component['label'] ?? str($componentKey)->headline()); ?>: <?php echo e(number_format((float)($component['normalized_score'] ?? 0), 2)); ?> × <?php echo e(number_format((float)data_get($review->calculationTrace, 'weights.'.$componentKey, 0), 2)); ?>%</span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <span>Input hash: <?php echo e(str((string)($review->calculationTrace['input_hash'] ?? ''))->limit(20)); ?></span>
                            </details>
                        <?php endif; ?>
                        <small>Final <?php echo e($review->finalScore ?? '—'); ?><?php echo e($review->finalRating ? ' / '.$review->finalRating : ''); ?></small>
                    </td>
                    <td>
                        <span class="people-status is-<?php echo e($review->status === 'closed' ? 'success' : 'info'); ?>"><?php echo e($review->statusLabel); ?></span>
                        <?php if($review->overrideStatus === 'pending'): ?><small>Override awaiting separate approval</small><?php endif; ?>
                        <?php if($review->pipRequired): ?><small>PIP required</small><?php endif; ?>
                    </td>
                    <td class="is-actions"><?php echo $__env->make('hr.performance.partials.review-actions', ['review' => $review, 'mobile' => false], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6"><div class="people-ops-empty"><strong>No employee reviews found</strong><span>Clear the filters or open an authorized review.</span></div></td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="people-ops-mobile-list">
        <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="people-ops-mobile-card">
                <header class="people-ops-mobile-card-head"><div><strong><?php echo e($review->employeeName); ?></strong><small><?php echo e($review->number); ?></small></div><span class="people-status is-info"><?php echo e($review->statusLabel); ?></span></header>
                <dl class="people-ops-mobile-facts">
                    <div><dt>Cycle</dt><dd><?php echo e($review->cycleName); ?></dd></div><div><dt>Period</dt><dd><?php echo e($review->period); ?></dd></div>
                    <div><dt>Formula score</dt><dd><?php echo e($review->formulaScore ?? '—'); ?></dd></div><div><dt>Final score</dt><dd><?php echo e($review->finalScore ?? '—'); ?></dd></div>
                    <div><dt>Manager</dt><dd><?php echo e($review->managerName); ?></dd></div><div><dt>Governance</dt><dd><?php echo e($review->overrideStatus === 'pending' ? 'Override pending' : ($review->scoreIsOverride ? 'Approved override' : 'Formula')); ?></dd></div>
                </dl>
                <?php echo $__env->make('hr.performance.partials.review-actions', ['review' => $review, 'mobile' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="people-ops-empty"><strong>No employee reviews found</strong></div>
        <?php endif; ?>
    </div>
    <?php echo e($reviews->withQueryString()->links()); ?>

</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/hr/performance/partials/reviews.blade.php ENDPATH**/ ?>