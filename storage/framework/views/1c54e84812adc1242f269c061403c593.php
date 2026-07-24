<?php $__env->startSection('title', 'Employee Tax Input Review - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $money = static fn (int $minor): string => sprintf('%d.%02d', intdiv($minor, 100), $minor % 100);
    $tone = static fn (string $status): string => match ($status) {
        'locked' => 'success', 'verified' => 'info', 'submitted' => 'warning', default => 'muted',
    };
?>

<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Employee tax input review','description' => 'Independent Payroll and Compliance review of employee declarations. Formula variables and statutory packs remain in Scoring Logic.','eyebrow' => 'Payroll governance','active' => 'payroll'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a class="people-button" href="<?php echo e(route('payroll.runs.index')); ?>"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Payroll workspace</a>
     <?php $__env->endSlot(); ?>

    <?php if(session('status')): ?><section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section><?php endif; ?>
    <?php if($errors->any()): ?>
        <section class="people-alert is-danger" role="alert" tabindex="-1"><strong>The tax-input workflow was not updated.</strong><ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($message); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></section>
    <?php endif; ?>

    <section class="people-ops-panel">
        <form method="GET" action="<?php echo e(route('payroll.employee-tax-profiles.index')); ?>" class="people-ops-filterbar">
            <label class="people-field"><span>Status</span><select class="people-control" name="status"><option value="">All statuses</option><?php $__currentLoopData = ['draft','submitted','verified','locked']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($status); ?>" <?php if(($filters['status'] ?? '') === $status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="people-field"><span>Financial year</span><input class="people-control" name="financial_year" value="<?php echo e($filters['financial_year'] ?? ''); ?>" placeholder="YYYY-YY" inputmode="numeric"></label>
            <button class="people-button" type="submit"><i class="fa-solid fa-filter" aria-hidden="true"></i> Apply</button>
            <?php if(array_filter($filters)): ?><a class="people-button" href="<?php echo e(route('payroll.employee-tax-profiles.index')); ?>">Clear</a><?php endif; ?>
        </form>
        <div class="people-ops-table-wrap">
            <table class="people-ops-table">
                <caption>Employee tax input versions available to the current reviewer</caption>
                <thead><tr><th scope="col">Employee</th><th scope="col">Financial year</th><th scope="col">Regime code</th><th scope="col">Version</th><th scope="col">Declarations</th><th scope="col">Status</th><th scope="col">Updated</th><th scope="col" class="is-actions">Action</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $taxProfiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($profile->employee?->name ?? 'Unavailable employee'); ?></strong><small><?php echo e($profile->employee?->employee_code ?? '-'); ?></small></td>
                            <td><?php echo e($profile->financial_year); ?></td><td><?php echo e($profile->regime_code); ?></td><td>v<?php echo e($profile->version); ?></td><td><?php echo e($profile->declarations_count); ?></td>
                            <td><span class="people-status is-<?php echo e($tone($profile->status)); ?>"><?php echo e(ucfirst($profile->status)); ?></span></td>
                            <td><?php echo e($profile->updated_at?->timezone(config('app.timezone'))->format('d M Y, h:i A')); ?></td>
                            <td class="is-actions"><a class="people-button" href="<?php echo e(route('payroll.employee-tax-profiles.show', $profile)); ?>" aria-label="Review tax inputs for <?php echo e($profile->employee?->name ?? 'employee'); ?>">Review</a></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="8">No employee tax profiles match the current filters.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="people-ops-panel-body"><?php echo e($taxProfiles->links()); ?></div>
    </section>

    <?php if($selectedTaxProfile): ?>
        <?php $inputPayload = $selectedTaxProfile->input_payload ?? []; ?>
        <section class="people-ops-panel" aria-labelledby="selected-tax-profile-title">
            <header class="people-ops-panel-head">
                <div><h2 id="selected-tax-profile-title"><?php echo e($selectedTaxProfile->employee?->name); ?> &middot; <?php echo e($selectedTaxProfile->financial_year); ?></h2><p>Version <?php echo e($selectedTaxProfile->version); ?> &middot; lock <?php echo e($selectedTaxProfile->lock_version); ?> &middot; checksum <?php echo e(substr($selectedTaxProfile->input_checksum, 0, 16)); ?>&hellip;</p></div>
                <span class="people-status is-<?php echo e($tone($selectedTaxProfile->status)); ?>"><?php echo e(ucfirst($selectedTaxProfile->status)); ?></span>
            </header>
            <div class="people-ops-panel-body people-form-grid">
                <div class="people-field"><span>Regime code</span><strong><?php echo e($selectedTaxProfile->regime_code); ?></strong></div>
                <div class="people-field"><span>Previous employer income</span><strong>INR <?php echo e($money((int) ($inputPayload['previous_employer_income_minor'] ?? 0))); ?></strong></div>
                <div class="people-field"><span>Previous employer TDS</span><strong>INR <?php echo e($money((int) ($inputPayload['previous_employer_tds_minor'] ?? 0))); ?></strong></div>
                <div class="people-field"><span>Projected other income</span><strong>INR <?php echo e($money((int) ($inputPayload['projected_other_income_minor'] ?? 0))); ?></strong></div>
                <?php if($selectedTaxProfile->supersedes): ?><div class="people-field is-wide"><span>Amendment history</span><strong>Supersedes locked version <?php echo e($selectedTaxProfile->supersedes->version); ?></strong></div><?php endif; ?>
            </div>

            <div class="people-ops-table-wrap">
                <table class="people-ops-table"><caption>Employee tax declaration decisions</caption><thead><tr><th scope="col">Category</th><th scope="col">Type</th><th scope="col" class="is-number">Declared</th><th scope="col" class="is-number">Verified</th><th scope="col">Proof</th><th scope="col">Decision</th></tr></thead><tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $selectedTaxProfile->declarations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $declaration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($declaration->category_code); ?></strong></td><td><?php echo e(str_replace('_', ' ', ucfirst($declaration->declaration_type))); ?></td>
                            <td class="is-number">INR <?php echo e($money((int) data_get($declaration->amount_payload, 'declared_minor', 0))); ?></td>
                            <td class="is-number">INR <?php echo e($money((int) data_get($declaration->amount_payload, 'verified_minor', 0))); ?></td>
                            <td><?php if($declaration->proofDocument): ?> <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view', $declaration->proofDocument)): ?><a href="<?php echo e(route('documents.download', $declaration->proofDocument)); ?>"><?php echo e($declaration->proofDocument->title); ?></a><small>Pinned v<?php echo e(data_get($declaration->metadata, 'proof_snapshot.version', $declaration->proofDocument->version)); ?> &middot; <?php echo e(substr((string) data_get($declaration->metadata, 'proof_snapshot.checksum_sha256', $declaration->proofDocument->checksum_sha256), 0, 12)); ?>&hellip;</small><?php else: ?> Restricted <?php endif; ?> <?php elseif(data_get($declaration->metadata, 'proof_snapshot')): ?> Pinned proof <?php echo e(data_get($declaration->metadata, 'proof_snapshot.document_number', '#'.data_get($declaration->metadata, 'proof_snapshot.managed_document_id'))); ?><small>Original private document is no longer current; the locked checksum trace remains preserved.</small><?php else: ?> No proof <?php endif; ?></td>
                            <td><span class="people-status is-<?php echo e($declaration->status === 'verified' ? 'success' : ($declaration->status === 'rejected' ? 'danger' : 'warning')); ?>"><?php echo e(ucfirst($declaration->status)); ?></span><?php if($declaration->decision_note): ?><small><?php echo e($declaration->decision_note); ?></small><?php endif; ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6">This employee submitted no declaration rows. Income inputs still require independent review.</td></tr>
                    <?php endif; ?>
                </tbody></table>
            </div>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('verify', $selectedTaxProfile)): ?>
                <form method="POST" action="<?php echo e(route('payroll.employee-tax-profiles.verify', $selectedTaxProfile)); ?>" class="people-ops-panel-body">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <input type="hidden" name="lock_version" value="<?php echo e($selectedTaxProfile->lock_version); ?>">
                    <h3>Independent declaration decisions</h3>
                    <p class="people-muted">Every declaration must be verified or rejected. Rejections require a reason.</p>
                    <div class="people-form-grid">
                        <?php $__currentLoopData = $selectedTaxProfile->declarations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $declaration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <fieldset class="people-ops-panel is-wide">
                                <input type="hidden" name="decisions[<?php echo e($index); ?>][category_code]" value="<?php echo e($declaration->category_code); ?>">
                                <header class="people-ops-panel-head"><div><h2><?php echo e($declaration->category_code); ?></h2><p>Declared INR <?php echo e($money((int) data_get($declaration->amount_payload, 'declared_minor', 0))); ?></p></div></header>
                                <div class="people-ops-panel-body people-form-grid">
                                    <label class="people-field"><span>Decision</span><select class="people-control" name="decisions[<?php echo e($index); ?>][status]"><option value="verified" <?php if(old("decisions.$index.status", 'verified') === 'verified'): echo 'selected'; endif; ?>>Verify</option><option value="rejected" <?php if(old("decisions.$index.status") === 'rejected'): echo 'selected'; endif; ?>>Reject</option></select></label>
                                    <label class="people-field"><span>Verified amount (INR)</span><input class="people-control" name="decisions[<?php echo e($index); ?>][verified_amount]" inputmode="decimal" value="<?php echo e(old("decisions.$index.verified_amount", $money((int) data_get($declaration->amount_payload, 'declared_minor', 0)))); ?>"></label>
                                    <label class="people-field is-wide"><span>Decision note</span><textarea class="people-control people-textarea" name="decisions[<?php echo e($index); ?>][decision_note]" maxlength="1000"><?php echo e(old("decisions.$index.decision_note")); ?></textarea><?php $__errorArgs = ["decisions.$index.decision_note"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                                </div>
                            </fieldset>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="people-form-actions"><button class="people-button is-primary" type="submit"><i class="fa-solid fa-user-check" aria-hidden="true"></i> Verify tax inputs</button></div>
                </form>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lock', $selectedTaxProfile)): ?>
                <form method="POST" action="<?php echo e(route('payroll.employee-tax-profiles.lock', $selectedTaxProfile)); ?>" class="people-ops-panel-body people-form-actions">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <input type="hidden" name="lock_version" value="<?php echo e($selectedTaxProfile->lock_version); ?>">
                    <button class="people-button is-primary" type="submit"><i class="fa-solid fa-lock" aria-hidden="true"></i> Lock verified version</button>
                </form>
            <?php endif; ?>

            <div class="people-ops-table-wrap">
                <table class="people-ops-table"><caption>Employee tax input workflow history</caption><thead><tr><th scope="col">Event</th><th scope="col">When</th><th scope="col">Note</th></tr></thead><tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $selectedTaxProfile->workflow_history ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr><td><?php echo e(str_replace('_', ' ', ucfirst($entry['event'] ?? 'updated'))); ?></td><td><?php if(filled($entry['at'] ?? null)): ?><time datetime="<?php echo e($entry['at']); ?>"><?php echo e($entry['at']); ?></time><?php else: ?> - <?php endif; ?></td><td><?php echo e($entry['note'] ?? '-'); ?></td></tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="3">No workflow entries are available.</td></tr><?php endif; ?>
                </tbody></table>
            </div>
        </section>
    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginal3abc64969eeeba849011f1a920d3a3ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.people-state','data' => ['title' => 'Select a tax profile','message' => 'Choose Review to inspect encrypted employee inputs and perform an authorized independent decision.','icon' => 'fa-file-shield']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Select a tax profile','message' => 'Choose Review to inspect encrypted employee inputs and perform an authorized independent decision.','icon' => 'fa-file-shield']); ?>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\payroll\employee-tax-profiles\index.blade.php ENDPATH**/ ?>