<section class="people-ops-grid is-wide-left" aria-label="Leave balance processing">
    <article class="people-ops-panel">
        <header class="people-ops-panel-head"><div><h2>Leave processing run</h2><p>Generate a governed preview before any ledger posting.</p></div></header>
        <div class="people-ops-panel-body">
            <?php if($abilities['canCreateProcessingRun']): ?>
                <form method="POST" action="<?php echo e(route('hr.leave-processing-runs.store')); ?>" class="people-form-grid">
                    <?php echo csrf_field(); ?>
                    <?php if (isset($component)) { $__componentOriginal5ee006ce6757c21855df609df2a8580f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5ee006ce6757c21855df609df2a8580f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.company-context','data' => ['companies' => $companies,'placeholder' => 'Use my company']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.company-context'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['companies' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($companies),'placeholder' => 'Use my company']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5ee006ce6757c21855df609df2a8580f)): ?>
<?php $attributes = $__attributesOriginal5ee006ce6757c21855df609df2a8580f; ?>
<?php unset($__attributesOriginal5ee006ce6757c21855df609df2a8580f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5ee006ce6757c21855df609df2a8580f)): ?>
<?php $component = $__componentOriginal5ee006ce6757c21855df609df2a8580f; ?>
<?php unset($__componentOriginal5ee006ce6757c21855df609df2a8580f); ?>
<?php endif; ?>
                    <label class="people-field"><span>Period year</span><input class="people-control" type="number" name="period_year" min="2000" max="2100" value="<?php echo e(old('period_year', now()->year)); ?>" required><?php $__errorArgs = ['period_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Processing type</span><select class="people-control" name="processing_type" required><?php $__currentLoopData = $processingTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($type['value']); ?>" <?php if(old('processing_type', 'monthly_accrual') === $type['value']): echo 'selected'; endif; ?>><?php echo e($type['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['processing_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <input type="hidden" name="is_dry_run" value="1">
                    <label class="people-field is-wide"><span>Preview note</span><textarea class="people-control" name="note" rows="3" maxlength="1000" placeholder="Reason or context for this preview"><?php echo e(old('note')); ?></textarea><?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <div class="people-modal-actions is-wide"><button type="submit" class="people-button is-primary">Generate processing preview</button></div>
                </form>
            <?php else: ?>
                <div class="people-ops-empty"><i class="fa-solid fa-lock" aria-hidden="true"></i><strong>Processing unavailable</strong><span>Your role cannot create leave processing previews.</span></div>
            <?php endif; ?>
        </div>
    </article>
    <article class="people-ops-panel">
        <header class="people-ops-panel-head"><div><h2>Processing safeguards</h2><p>Existing server-authoritative controls applied to every run.</p></div></header>
        <ul class="people-ops-checklist">
            <li><i class="fa-solid fa-check" aria-hidden="true"></i><span>Active policy scope captured in the preview</span><strong>Server validated</strong></li>
            <li><i class="fa-solid fa-check" aria-hidden="true"></i><span>Eligible employees and leave balances evaluated</span><strong>Preview first</strong></li>
            <li><i class="fa-solid fa-check" aria-hidden="true"></i><span>Duplicate period and processing type blocked</span><strong>Idempotent</strong></li>
            <li><i class="fa-solid fa-check" aria-hidden="true"></i><span>Posting requires separate authorized action</span><strong>Audited</strong></li>
        </ul>
    </article>
</section>

<section class="people-ops-panel" aria-labelledby="leave-processing-title">
    <header class="people-ops-panel-head"><div><h2 id="leave-processing-title">Leave processing runs</h2><p>Persisted previews and posted runs; no values are calculated in the browser.</p></div></header>
    <div class="people-ops-panel-body"><form method="GET" action="<?php echo e(route('hr.leave-processing-runs.index')); ?>" class="people-ops-filterbar"><label class="people-field"><span>Year</span><input class="people-control" type="number" name="period_year" min="2000" max="2100" value="<?php echo e(request('period_year')); ?>"></label><label class="people-field"><span>Type</span><select class="people-control" name="processing_type"><option value="">All types</option><?php $__currentLoopData = $processingTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($type['value']); ?>" <?php if(request('processing_type') === $type['value']): echo 'selected'; endif; ?>><?php echo e($type['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label><label class="people-field"><span>Status</span><select class="people-control" name="status"><option value="">All statuses</option><?php $__currentLoopData = $processingStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($status['value']); ?>" <?php if(request('status') === $status['value']): echo 'selected'; endif; ?>><?php echo e($status['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label><button class="people-button" type="submit">Apply filters</button><a class="people-button" href="<?php echo e(route('hr.leave-processing-runs.index')); ?>">Clear</a></form></div>
    <div class="people-ops-table-wrap">
        <table class="people-ops-table">
            <caption>Leave processing run history</caption>
            <thead><tr><th scope="col">Run</th><th scope="col">Year / type</th><th scope="col">Status</th><th scope="col">Persisted summary</th><th scope="col">Created / posted</th><th scope="col" class="is-actions">Action</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $processingRuns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $run): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($run->runNumber); ?></strong></td>
                        <td><?php echo e($run->periodYear); ?><small><?php echo e($run->processingTypeLabel); ?></small></td>
                        <td><span class="people-status is-<?php echo e($run->status); ?>"><?php echo e($run->statusLabel); ?></span></td>
                        <td><?php echo e($run->employeeCount); ?> employees / <?php echo e($run->lineCount); ?> lines<small>Accrual <?php echo e($run->accrualDays); ?> / Carry <?php echo e($run->carryForwardDays); ?> / Lapse <?php echo e($run->lapseDays); ?></small></td>
                        <td><?php echo e($run->createdBy); ?><small><?php echo e($run->createdAt); ?></small><?php if($run->postedBy): ?><small>Posted by <?php echo e($run->postedBy); ?><?php echo e($run->postedAt ? ' / '.$run->postedAt : ''); ?></small><?php endif; ?></td>
                        <td class="is-actions"><?php if($run->canPost): ?><form method="POST" action="<?php echo e(route('hr.leave-processing-runs.post', $run->id)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><input class="people-control" name="note" maxlength="1000" placeholder="Posting note"><button class="people-ops-action-link" type="submit">Post run</button></form><?php else: ?><span class="people-subtext">No action</span><?php endif; ?></td>
                    </tr>
                    <tr class="people-processing-detail-row">
                        <td colspan="6">
                            <details class="people-processing-details">
                                <summary>Persisted preview details</summary>
                                <div class="people-processing-details-body">
                                    <section aria-label="Rules captured for this run">
                                        <h3>Rules captured for this run</h3>
                                        <?php if($run->rulesSnapshot): ?>
                                            <dl class="people-processing-rules">
                                                <div><dt>Setting</dt><dd><?php echo e($run->rulesSnapshot->settingKey); ?></dd></div>
                                                <div><dt>Monthly accrual</dt><dd><?php echo e($run->rulesSnapshot->monthlyAccrualLabel); ?></dd></div>
                                                <div><dt>Year-end processing</dt><dd><?php echo e($run->rulesSnapshot->yearEndLabel); ?></dd></div>
                                                <div><dt>Encashment tax</dt><dd><?php echo e($run->rulesSnapshot->encashmentTaxRate); ?></dd></div>
                                                <div class="is-wide"><dt>Encashment formula</dt><dd><?php echo e($run->rulesSnapshot->encashmentFormula); ?></dd></div>
                                            </dl>
                                            <?php if($run->rulesSnapshot->leaveTypes !== []): ?>
                                                <div class="people-processing-rule-list" aria-label="Leave type rules">
                                                    <?php $__currentLoopData = $run->rulesSnapshot->leaveTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <article>
                                                            <strong><?php echo e($rule->code); ?></strong>
                                                            <span><?php echo e($rule->annualEntitlementDays); ?> days annual entitlement</span>
                                                            <small>Carry forward <?php echo e($rule->carryForwardLabel); ?> / maximum <?php echo e($rule->maxCarryForwardDays); ?> days / Encashment <?php echo e($rule->encashmentLabel); ?></small>
                                                        </article>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <p class="people-subtext">No persisted rule snapshot is available for this historical run.</p>
                                        <?php endif; ?>
                                    </section>
                                    <section aria-label="Persisted employee processing lines">
                                        <h3>Persisted employee processing lines</h3>
                                        <?php if($run->lineItems !== []): ?>
                                            <div class="people-processing-lines" role="list">
                                                <?php $__currentLoopData = $run->lineItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <article role="listitem">
                                                        <strong><?php echo e($line->employeeName); ?></strong>
                                                        <span><?php echo e($line->employeeCode); ?> / <?php echo e($line->leaveTypeCode); ?></span>
                                                        <small>Opening <?php echo e($line->openingBalanceDays); ?> / Available before <?php echo e($line->availableBeforeDays); ?> / Accrual <?php echo e($line->accrualDays); ?> / Carry <?php echo e($line->carryForwardDays); ?> / Lapse <?php echo e($line->lapseDays); ?></small>
                                                    </article>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php else: ?>
                                            <p class="people-subtext">No persisted line items are available for this historical run.</p>
                                        <?php endif; ?>
                                    </section>
                                </div>
                            </details>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6"><div class="people-ops-empty"><strong>No leave processing runs found</strong><span>Create a preview or clear the selected filters.</span></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="people-pagination"><?php echo e($processingRuns->withQueryString()->links()); ?></div>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/hr/leave/partials/processing.blade.php ENDPATH**/ ?>