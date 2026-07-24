<section class="people-ops-kpis is-four" aria-label="Commission rule summary">
    <article class="people-ops-kpi is-info"><span class="people-ops-kpi-icon"><i class="fa-solid fa-percent" aria-hidden="true"></i></span><span>Active commission rules</span><strong><?php echo e(number_format($summary->activeCommissionRules)); ?></strong><small>Rules eligible for controlled commission runs.</small></article>
    <article class="people-ops-kpi is-warning"><span class="people-ops-kpi-icon"><i class="fa-solid fa-hourglass-half" aria-hidden="true"></i></span><span>Runs awaiting decision</span><strong><?php echo e(number_format($summary->generatedCommissionRuns)); ?></strong><small>Generated runs require a separate approver.</small></article>
    <article class="people-ops-kpi is-success"><span class="people-ops-kpi-icon"><i class="fa-solid fa-circle-check" aria-hidden="true"></i></span><span>Approved commission runs</span><strong><?php echo e(number_format($summary->approvedCommissionRuns)); ?></strong><small>Approved total: <?php echo e($summary->approvedCommissionTotal); ?></small></article>
</section>

<section class="people-ops-grid is-wide-left" aria-label="Commission rule controls">
    <article class="people-ops-panel" id="create-commission-rule">
        <header class="people-ops-panel-head"><div><h2>Create commission rule</h2><p>Define a company-scoped commission basis without changing payroll calculations in the browser.</p></div></header>
        <div class="people-ops-panel-body">
            <?php if($abilities['canCreateCommissionRule']): ?>
                <form method="POST" action="<?php echo e(route('payroll.commission-rules.store')); ?>" class="people-form-grid" x-data="commissionRuleForm" data-initial-rule-type="<?php echo e(old('rule_type', 'percentage')); ?>">
                    <?php echo csrf_field(); ?>
                    <label class="people-field"><span>Rule code</span><input class="people-control" name="rule_code" value="<?php echo e(old('rule_code')); ?>" maxlength="40" pattern="[A-Z0-9-]+" required aria-invalid="<?php echo e($errors->has('rule_code') ? 'true' : 'false'); ?>"><?php $__errorArgs = ['rule_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Name</span><input class="people-control" name="name" value="<?php echo e(old('name')); ?>" maxlength="160" required aria-invalid="<?php echo e($errors->has('name') ? 'true' : 'false'); ?>"><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Rule type</span><select class="people-control" name="rule_type" x-on:change="selectRuleType" required><?php $__currentLoopData = $commissionRuleTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($type['value']); ?>" <?php if(old('rule_type', 'percentage') === $type['value']): echo 'selected'; endif; ?>><?php echo e($type['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                    <label class="people-field"><span>Basis</span><select class="people-control" name="basis" required><?php $__currentLoopData = $commissionBases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $basis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($basis['value']); ?>" <?php if(old('basis') === $basis['value']): echo 'selected'; endif; ?>><?php echo e($basis['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                    <label class="people-field"><span>Project</span><select class="people-control" name="project_id"><option value="">All projects</option><?php $__currentLoopData = $projectOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($project['id']); ?>" <?php if((string)old('project_id') === (string)$project['id']): echo 'selected'; endif; ?>><?php echo e($project['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                    <label class="people-field"><span>Status</span><select class="people-control" name="status"><?php $__currentLoopData = $commissionRuleStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($status['value']); ?>" <?php if(old('status', 'active') === $status['value']): echo 'selected'; endif; ?>><?php echo e($status['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                    <label class="people-field" x-show="isFixed"><span>Fixed amount</span><input class="people-control" type="number" min="0.01" step="0.01" name="fixed_amount" value="<?php echo e(old('fixed_amount')); ?>" x-bind:disabled="!isFixed" x-bind:required="isFixed"><?php $__errorArgs = ['fixed_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field" x-show="isPercentage"><span>Rate percent</span><input class="people-control" type="number" min="0.0001" max="100" step="0.0001" name="rate_percent" value="<?php echo e(old('rate_percent')); ?>" x-bind:disabled="!isPercentage" x-bind:required="isPercentage"><?php $__errorArgs = ['rate_percent'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field" x-show="isTarget"><span>Target amount</span><input class="people-control" type="number" min="0.01" step="0.01" name="target_amount" value="<?php echo e(old('target_amount')); ?>" x-bind:disabled="!isTarget" x-bind:required="isTarget"><?php $__errorArgs = ['target_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field" x-show="isTarget"><span>Rate after target</span><input class="people-control" type="number" min="0.0001" max="100" step="0.0001" name="rate_percent" value="<?php echo e(old('rate_percent')); ?>" x-bind:disabled="!isTarget" x-bind:required="isTarget"><?php $__errorArgs = ['rate_percent'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <div class="people-form-grid is-wide" x-show="isSlab">
                        <label class="people-field"><span>Slab from</span><input class="people-control" type="number" min="0" step="0.01" name="slab_rules[0][from]" value="<?php echo e(old('slab_rules.0.from', 0)); ?>" x-bind:disabled="!isSlab" x-bind:required="isSlab"></label>
                        <label class="people-field"><span>Slab to (optional)</span><input class="people-control" type="number" min="0" step="0.01" name="slab_rules[0][to]" value="<?php echo e(old('slab_rules.0.to')); ?>" x-bind:disabled="!isSlab"></label>
                        <label class="people-field"><span>Slab rate percent</span><input class="people-control" type="number" min="0.0001" max="100" step="0.0001" name="slab_rules[0][rate_percent]" value="<?php echo e(old('slab_rules.0.rate_percent')); ?>" x-bind:disabled="!isSlab" x-bind:required="isSlab"></label>
                        <?php $__errorArgs = ['slab_rules'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error is-wide"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <label class="people-field"><span>Effective from</span><input class="people-control" type="date" name="effective_from" value="<?php echo e(old('effective_from', now()->toDateString())); ?>" required><?php $__errorArgs = ['effective_from'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Effective to</span><input class="people-control" type="date" name="effective_to" value="<?php echo e(old('effective_to')); ?>"><?php $__errorArgs = ['effective_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <div class="people-modal-actions is-wide"><button class="people-button is-primary" type="submit"><i class="fa-solid fa-plus" aria-hidden="true"></i>Create rule</button></div>
                </form>
            <?php else: ?>
                <div class="people-ops-empty"><i class="fa-solid fa-lock" aria-hidden="true"></i><strong>Rule creation unavailable</strong><span>Your role can review commission rules but cannot create one.</span></div>
            <?php endif; ?>
        </div>
    </article>
    <article class="people-ops-panel">
        <header class="people-ops-panel-head"><div><h2>Rule filters</h2><p>Limit the register by supported rule attributes.</p></div></header>
        <div class="people-ops-panel-body">
            <form method="GET" action="<?php echo e(route('payroll.commission-rules.index')); ?>" class="people-form-grid">
                <label class="people-field"><span>Search</span><input class="people-control" name="search" maxlength="120" value="<?php echo e(request('search')); ?>"></label>
                <label class="people-field"><span>Status</span><select class="people-control" name="status"><option value="">All statuses</option><?php $__currentLoopData = $commissionRuleStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($status['value']); ?>" <?php if(request('status') === $status['value']): echo 'selected'; endif; ?>><?php echo e($status['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Rule type</span><select class="people-control" name="rule_type"><option value="">All rule types</option><?php $__currentLoopData = $commissionRuleTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($type['value']); ?>" <?php if(request('rule_type') === $type['value']): echo 'selected'; endif; ?>><?php echo e($type['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Basis</span><select class="people-control" name="basis"><option value="">All bases</option><?php $__currentLoopData = $commissionBases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $basis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($basis['value']); ?>" <?php if(request('basis') === $basis['value']): echo 'selected'; endif; ?>><?php echo e($basis['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field is-wide"><span>Project</span><select class="people-control" name="project_id"><option value="">All projects</option><?php $__currentLoopData = $projectOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($project['id']); ?>" <?php if((string)request('project_id') === (string)$project['id']): echo 'selected'; endif; ?>><?php echo e($project['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <div class="people-modal-actions is-wide"><button class="people-button" type="submit">Apply filters</button><a class="people-button" href="<?php echo e(route('payroll.commission-rules.index')); ?>">Clear</a></div>
            </form>
        </div>
    </article>
</section>

<section class="people-ops-panel" aria-labelledby="commission-rules-title">
    <header class="people-ops-panel-head"><div><h2 id="commission-rules-title">Commission rules</h2><p><?php echo e($commissionRules->total()); ?> rule<?php echo e($commissionRules->total() === 1 ? '' : 's'); ?> in this authorized register.</p></div></header>
    <div class="people-ops-table-wrap"><table class="people-ops-table"><caption>Commission rule register</caption><thead><tr><th scope="col">Rule</th><th scope="col">Type / basis</th><th scope="col">Value</th><th scope="col">Project</th><th scope="col">Effective</th><th scope="col">Status</th><th scope="col">Created by</th></tr></thead><tbody>
        <?php $__empty_1 = true; $__currentLoopData = $commissionRules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr><td><strong><?php echo e($rule->code); ?></strong><small><?php echo e($rule->name); ?></small></td><td><?php echo e($rule->typeLabel); ?><small><?php echo e($rule->basisLabel); ?></small></td><td><?php echo e($rule->valueLabel); ?></td><td><?php echo e($rule->projectLabel); ?></td><td><?php echo e($rule->effectiveRange); ?></td><td><span class="people-status is-<?php echo e($rule->status === 'active' ? 'success' : ($rule->status === 'draft' ? 'warning' : 'neutral')); ?>"><?php echo e($rule->statusLabel); ?></span></td><td><?php echo e($rule->createdBy); ?></td></tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="7"><div class="people-ops-empty"><i class="fa-solid fa-percent" aria-hidden="true"></i><strong>No commission rules found</strong><span>Clear filters or create the first permitted commission rule.</span></div></td></tr>
        <?php endif; ?>
    </tbody></table></div>
    <div class="people-pagination"><?php echo e($commissionRules->withQueryString()->links()); ?></div>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/payroll/workspace/partials/commission_rules.blade.php ENDPATH**/ ?>