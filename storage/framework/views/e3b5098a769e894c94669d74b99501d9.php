<section class="people-ops-kpis is-four" aria-label="Commission run summary">
    <article class="people-ops-kpi is-info"><span class="people-ops-kpi-icon"><i class="fa-solid fa-percent" aria-hidden="true"></i></span><span>Active commission rules</span><strong><?php echo e(number_format($summary->activeCommissionRules)); ?></strong><small>Available for controlled generation.</small></article>
    <article class="people-ops-kpi is-warning"><span class="people-ops-kpi-icon"><i class="fa-solid fa-hourglass-half" aria-hidden="true"></i></span><span>Awaiting decision</span><strong><?php echo e(number_format($summary->generatedCommissionRuns)); ?></strong><small>Segregation of duties applies.</small></article>
    <article class="people-ops-kpi is-success"><span class="people-ops-kpi-icon"><i class="fa-solid fa-circle-check" aria-hidden="true"></i></span><span>Approved runs</span><strong><?php echo e(number_format($summary->approvedCommissionRuns)); ?></strong><small>Approved total: <?php echo e($summary->approvedCommissionTotal); ?></small></article>
</section>

<section class="people-ops-grid is-wide-left" aria-label="Commission run controls">
    <article class="people-ops-panel" id="generate-commission-run">
        <header class="people-ops-panel-head"><div><h2>Generate commission run</h2><p>Calculate one persisted run from an active rule and accounting period.</p></div></header>
        <div class="people-ops-panel-body">
            <?php if($abilities['canGenerateCommissionRun']): ?>
                <form method="POST" action="<?php echo e(route('payroll.commission-runs.store')); ?>" class="people-form-grid">
                    <?php echo csrf_field(); ?>
                    <label class="people-field is-wide"><span>Commission rule</span><select class="people-control" name="commission_rule_id" required><option value="">Select active rule</option><?php $__currentLoopData = $commissionRuleOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($rule['id']); ?>" <?php if((string)old('commission_rule_id') === (string)$rule['id']): echo 'selected'; endif; ?>><?php echo e($rule['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['commission_rule_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Period year</span><input class="people-control" type="number" name="period_year" min="2020" max="2100" value="<?php echo e(old('period_year', now()->year)); ?>" required><?php $__errorArgs = ['period_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Period month</span><input class="people-control" type="number" name="period_month" min="1" max="12" value="<?php echo e(old('period_month', now()->month)); ?>" required><?php $__errorArgs = ['period_month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field is-wide"><span>Generation note</span><textarea class="people-control" name="note" maxlength="500" rows="3"><?php echo e(old('note')); ?></textarea></label>
                    <div class="people-modal-actions is-wide"><button class="people-button is-primary" type="submit"><i class="fa-solid fa-play" aria-hidden="true"></i>Generate commission run</button></div>
                </form>
            <?php else: ?>
                <div class="people-ops-empty"><i class="fa-solid fa-lock" aria-hidden="true"></i><strong>Generation unavailable</strong><span>Your role can review commission runs but cannot generate one.</span></div>
            <?php endif; ?>
        </div>
    </article>
    <article class="people-ops-panel">
        <header class="people-ops-panel-head"><div><h2>Run filters</h2><p>Filter by lifecycle, rule, or accounting period.</p></div></header>
        <div class="people-ops-panel-body"><form method="GET" action="<?php echo e(route('payroll.commission-runs.index')); ?>" class="people-form-grid">
            <label class="people-field"><span>Status</span><select class="people-control" name="status"><option value="">All statuses</option><?php $__currentLoopData = $commissionRunStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($status['value']); ?>" <?php if(request('status') === $status['value']): echo 'selected'; endif; ?>><?php echo e($status['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="people-field"><span>Rule</span><select class="people-control" name="commission_rule_id"><option value="">All active rules</option><?php $__currentLoopData = $commissionRuleOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($rule['id']); ?>" <?php if((string)request('commission_rule_id') === (string)$rule['id']): echo 'selected'; endif; ?>><?php echo e($rule['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="people-field"><span>Year</span><input class="people-control" type="number" name="period_year" min="2020" max="2100" value="<?php echo e(request('period_year')); ?>"></label>
            <label class="people-field"><span>Month</span><input class="people-control" type="number" name="period_month" min="1" max="12" value="<?php echo e(request('period_month')); ?>"></label>
            <div class="people-modal-actions is-wide"><button class="people-button" type="submit">Apply filters</button><a class="people-button" href="<?php echo e(route('payroll.commission-runs.index')); ?>">Clear</a></div>
        </form></div>
    </article>
</section>

<section class="people-ops-panel has-mobile-cards" aria-labelledby="commission-runs-title">
    <header class="people-ops-panel-head"><div><h2 id="commission-runs-title">Commission runs</h2><p><?php echo e($commissionRuns->total()); ?> run<?php echo e($commissionRuns->total() === 1 ? '' : 's'); ?> in this authorized register.</p></div></header>
    <div class="people-ops-table-wrap"><table class="people-ops-table"><caption>Commission run register</caption><thead><tr><th scope="col">Run</th><th scope="col">Rule / period</th><th scope="col">Status</th><th scope="col" class="is-number">Items</th><th scope="col" class="is-number">Source</th><th scope="col" class="is-number">Eligible</th><th scope="col" class="is-number">Commission</th><th scope="col">Control</th><th scope="col" class="is-actions">Action</th></tr></thead><tbody>
        <?php $__empty_1 = true; $__currentLoopData = $commissionRuns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $run): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr><td><strong><?php echo e($run->runNumber); ?></strong></td><td><?php echo e($run->ruleLabel); ?><small><?php echo e($run->period); ?> / <?php echo e($run->dateRange); ?></small></td><td><span class="people-status is-<?php echo e($run->status === 'approved' ? 'success' : ($run->status === 'rejected' ? 'danger' : 'warning')); ?>"><?php echo e($run->statusLabel); ?></span></td><td class="is-number"><?php echo e(number_format($run->itemCount)); ?></td><td class="is-number"><?php echo e($run->sourceTotal); ?></td><td class="is-number"><?php echo e($run->eligibleTotal); ?></td><td class="is-number"><strong><?php echo e($run->commissionTotal); ?></strong></td><td><?php echo e($run->generatedBy); ?><?php if($run->approvedBy): ?><small>Approved by <?php echo e($run->approvedBy); ?></small><?php endif; ?></td><td class="is-actions">
                <?php if($run->canApprove): ?><form method="POST" action="<?php echo e(route('payroll.commission-runs.approve', $run->id)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><label class="people-field"><span class="sr-only">Approval note for <?php echo e($run->runNumber); ?></span><input class="people-control" name="decision_note" maxlength="500" placeholder="Approval note"></label><button class="people-ops-action-link" type="submit">Approve</button></form><?php endif; ?>
                <?php if($run->canReject): ?><form method="POST" action="<?php echo e(route('payroll.commission-runs.reject', $run->id)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><label class="people-field"><span class="sr-only">Rejection reason for <?php echo e($run->runNumber); ?></span><input class="people-control" name="decision_note" maxlength="500" placeholder="Required rejection reason" required></label><button class="people-ops-action-link is-danger" type="submit">Reject</button></form><?php endif; ?>
                <?php if(! $run->canApprove && ! $run->canReject): ?><span class="people-subtext">No permitted action</span><?php endif; ?>
            </td></tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="9"><div class="people-ops-empty"><i class="fa-solid fa-coins" aria-hidden="true"></i><strong>No commission runs found</strong><span>Clear filters or generate the first permitted commission run.</span></div></td></tr>
        <?php endif; ?>
    </tbody></table></div>
    <div class="people-ops-mobile-list">
        <?php $__empty_1 = true; $__currentLoopData = $commissionRuns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $run): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="people-ops-mobile-card"><header class="people-ops-mobile-card-head"><div><strong><?php echo e($run->runNumber); ?></strong><small class="people-subtext"><?php echo e($run->ruleLabel); ?></small></div><span class="people-status is-<?php echo e($run->status === 'approved' ? 'success' : ($run->status === 'rejected' ? 'danger' : 'warning')); ?>"><?php echo e($run->statusLabel); ?></span></header><dl class="people-ops-mobile-facts"><div><dt>Period</dt><dd><?php echo e($run->period); ?></dd></div><div><dt>Items</dt><dd><?php echo e($run->itemCount); ?></dd></div><div><dt>Commission</dt><dd><?php echo e($run->commissionTotal); ?></dd></div><div><dt>Generated by</dt><dd><?php echo e($run->generatedBy); ?></dd></div></dl></article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><div class="people-ops-empty"><strong>No commission runs found</strong><span>Clear filters or generate the first permitted commission run.</span></div><?php endif; ?>
    </div>
    <div class="people-pagination"><?php echo e($commissionRuns->withQueryString()->links()); ?></div>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/payroll/workspace/partials/commission_runs.blade.php ENDPATH**/ ?>