<?php $__env->startSection('title', 'Compliance Center - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Compliance Center','description' => 'Compliance Rules are governed through maker-checker approval and effective-dated versions using verified statutory values only.','active' => 'compliance'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> <a class="people-button" href="<?php echo e(route('hr.policy-acknowledgements.index')); ?>"><i class="fa-solid fa-file-signature" aria-hidden="true"></i> Policy acknowledgements</a> <?php $__env->endSlot(); ?>

    <?php if(session('status')): ?><section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section><?php endif; ?>
    <?php if($errors->any()): ?><section class="people-alert is-danger" role="alert" aria-labelledby="compliance-errors-title" tabindex="-1"><strong id="compliance-errors-title">Please correct the highlighted compliance fields.</strong><ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></section><?php endif; ?>

    <section class="people-ops-kpis" aria-label="Compliance rule summary">
        <?php $__currentLoopData = [
            ['Rule versions', $summary->total, 'fa-shield-halved', ''],
            ['Drafts awaiting review', $summary->draft, 'fa-hourglass-half', 'is-warning'],
            ['Active versions', $summary->active, 'fa-circle-check', 'is-success'],
            ['Archived versions', $summary->archived, 'fa-box-archive', ''],
            ['Validation required', $summary->verificationRequired, 'fa-magnifying-glass-chart', 'is-warning'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value, $icon, $tone]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="people-ops-kpi <?php echo e($tone); ?>"><span class="people-ops-kpi-icon"><i class="fa-solid <?php echo e($icon); ?>" aria-hidden="true"></i></span><span><?php echo e($label); ?></span><strong><?php echo e(number_format($value)); ?></strong><small>Authorized compliance scope</small></article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </section>

    <?php if($abilities['canCreate']): ?>
        <details class="people-edit-details" <?php if($errors->any()): ?> open <?php endif; ?>>
            <summary>Create governed compliance rule draft</summary>
            <form method="POST" action="<?php echo e(route('hr.compliance-rule-settings.store')); ?>" class="people-form-grid people-edit-form" x-data="serverFormState" x-on:submit="beginSubmit" x-bind:aria-busy="busyAria" data-idle-label="Create draft for approval" data-busy-label="Creating draft…"><?php echo csrf_field(); ?>
                <?php if (isset($component)) { $__componentOriginal5ee006ce6757c21855df609df2a8580f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5ee006ce6757c21855df609df2a8580f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.company-context','data' => ['companies' => $companies]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.company-context'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['companies' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($companies)]); ?>
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
                <label class="people-field"><span>Rule type</span><select class="people-control" name="setting_key" required><option value="">Select rule type</option><?php $__currentLoopData = $settingKeys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(old('setting_key')===$value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['setting_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field"><span>Rule label</span><input class="people-control" name="label" value="<?php echo e(old('label')); ?>" maxlength="255" required><?php $__errorArgs = ['label'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field"><span>Effective from</span><input class="people-control" type="date" name="effective_from" value="<?php echo e(old('effective_from')); ?>" required><?php $__errorArgs = ['effective_from'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field"><span>Approval step</span><input class="people-control" name="value[approval_chain][0]" value="<?php echo e(old('value.approval_chain.0')); ?>" placeholder="Authorized approval role" required><?php $__errorArgs = ['value.approval_chain'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field"><span>Statutory validation</span><select class="people-control" name="value[statutory_validation_required]" required><option value="">Select requirement</option><option value="1" <?php if(old('value.statutory_validation_required')==='1'): echo 'selected'; endif; ?>>Required</option><option value="0" <?php if(old('value.statutory_validation_required')==='0'): echo 'selected'; endif; ?>>Not required</option></select></label>
                <label class="people-field"><span>Applicability</span><input class="people-control" name="value[applicability]" value="<?php echo e(old('value.applicability')); ?>" placeholder="Enter approved applicability"></label>
                <label class="people-field"><span>Wage basis</span><input class="people-control" name="value[wage_basis]" value="<?php echo e(old('value.wage_basis')); ?>" placeholder="Enter verified wage basis"></label>
                <label class="people-field"><span>Calculation method</span><input class="people-control" name="value[calculation_method]" value="<?php echo e(old('value.calculation_method')); ?>" placeholder="Enter approved calculation method"></label>
                <label class="people-field"><span>Default rate</span><input class="people-control" type="number" min="0" step="0.0001" name="value[rates][default]" value="<?php echo e(old('value.rates.default')); ?>" placeholder="No prototype default"></label>
                <label class="people-field"><span>Financial year</span><input class="people-control" name="value[financial_year]" value="<?php echo e(old('value.financial_year')); ?>" placeholder="e.g. 2026-2027"></label>
                <label class="people-field"><span>Form 16 template version</span><input class="people-control" name="value[form16_template_version]" value="<?php echo e(old('value.form16_template_version')); ?>"></label>
                <label class="people-field"><span>Payroll year locked</span><select class="people-control" name="value[payroll_year_locked]"><option value="">Not specified</option><option value="0" <?php if(old('value.payroll_year_locked')==='0'): echo 'selected'; endif; ?>>No</option><option value="1" <?php if(old('value.payroll_year_locked')==='1'): echo 'selected'; endif; ?>>Yes</option></select></label>
                <label class="people-field"><span>GST transaction type</span><input class="people-control" name="value[supported_transaction_types][0]" value="<?php echo e(old('value.supported_transaction_types.0')); ?>"></label>
                <label class="people-field"><span>GST default tax rate</span><input class="people-control" type="number" min="0" step="0.01" name="value[default_tax_rates][standard]" value="<?php echo e(old('value.default_tax_rates.standard')); ?>"></label>
                <label class="people-field"><span>Leave encashment method</span><select class="people-control" name="value[encashment_formula]"><option value="">Select approved method</option><option value="daily_basic_rate" <?php if(old('value.encashment_formula')==='daily_basic_rate'): echo 'selected'; endif; ?>>Daily basic rate</option><option value="daily_gross_rate" <?php if(old('value.encashment_formula')==='daily_gross_rate'): echo 'selected'; endif; ?>>Daily gross rate</option><option value="fixed_policy_rate" <?php if(old('value.encashment_formula')==='fixed_policy_rate'): echo 'selected'; endif; ?>>Fixed policy rate</option></select></label>
                <label class="people-field is-wide"><span>Description</span><textarea class="people-control" name="description" maxlength="5000" rows="3"><?php echo e(old('description')); ?></textarea><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <div class="people-alert is-danger is-wide" role="note"><strong>Verified values only.</strong> Builder360 does not infer statutory rates, applicability, formulas, or legal effective dates from the prototype.</div>
                <div class="people-modal-actions is-wide"><button class="people-button is-primary" type="submit" x-bind:disabled="busy"><span x-text="submitLabel">Create draft for approval</span></button></div>
            </form>
        </details>
    <?php endif; ?>

    <section class="people-ops-panel has-mobile-cards" aria-labelledby="compliance-register-title">
        <header class="people-ops-panel-head"><div><h2 id="compliance-register-title">Versioned rule register</h2><p><?php echo e(number_format($settings->total())); ?> rule version<?php echo e($settings->total() === 1 ? '' : 's'); ?> match the selected filters.</p></div></header>
        <form method="GET" action="<?php echo e(route('hr.compliance-rule-settings.index')); ?>" class="people-ops-filterbar" aria-label="Filter compliance rules">
            <label class="people-field"><span>Rule type</span><select class="people-control" name="setting_key"><option value="">All rule types</option><?php $__currentLoopData = $settingKeys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(request('setting_key')===$value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="people-field"><span>Status</span><select class="people-control" name="status"><option value="">All statuses</option><?php $__currentLoopData = ['draft'=>'Draft','active'=>'Active','archived'=>'Archived']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(request('status')===$value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <div class="people-modal-actions"><button class="people-button" type="submit">Apply filters</button><a class="people-button" href="<?php echo e(route('hr.compliance-rule-settings.index')); ?>">Clear</a></div>
        </form>
        <div class="people-ops-table-wrap"><table class="people-ops-table"><caption>Compliance rule versions</caption><thead><tr><th scope="col">Rule</th><th scope="col">Version / scope</th><th scope="col">Effective date</th><th scope="col">Maker / checker</th><th scope="col">Validation</th><th scope="col">Status</th><th scope="col" class="is-actions">Action</th></tr></thead><tbody>
            <?php $__empty_1 = true; $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr><td><strong><?php echo e($setting->label); ?></strong><small><?php echo e($setting->settingType); ?></small></td><td>v<?php echo e($setting->version); ?><small><?php echo e($setting->scope); ?></small></td><td><?php echo e($setting->effectiveFrom); ?></td><td><?php echo e($setting->createdBy); ?><small><?php echo e($setting->approvalState); ?></small></td><td><?php echo e($setting->verificationLabel); ?><small><?php echo e($setting->sourceAuthority); ?> / <?php echo e($setting->sourceReference); ?><?php if($setting->verifiedBy): ?> / Verified by <?php echo e($setting->verifiedBy); ?><?php endif; ?></small></td><td><span class="people-status <?php echo e($setting->statusTone); ?>"><?php echo e($setting->statusLabel); ?></span></td><td class="is-actions"><?php echo $__env->make('hr.compliance.partials.rule-actions', ['setting' => $setting, 'actionContext' => 'desktop'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td></tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="7"><div class="people-ops-empty"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i><strong>No compliance rule versions found</strong><span>Clear the filters or create a governed draft if your role permits it.</span></div></td></tr><?php endif; ?>
        </tbody></table></div>
        <div class="people-ops-mobile-list"><?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><article class="people-ops-mobile-card"><div class="people-ops-mobile-card-head"><strong><?php echo e($setting->label); ?> / v<?php echo e($setting->version); ?></strong><span class="people-status <?php echo e($setting->statusTone); ?>"><?php echo e($setting->statusLabel); ?></span></div><dl class="people-ops-mobile-facts"><div><dt>Rule type</dt><dd><?php echo e($setting->settingType); ?></dd></div><div><dt>Scope</dt><dd><?php echo e($setting->scope); ?></dd></div><div><dt>Effective</dt><dd><?php echo e($setting->effectiveFrom); ?></dd></div><div><dt>Verification</dt><dd><?php echo e($setting->verificationLabel); ?></dd></div><div><dt>Official source</dt><dd><?php echo e($setting->sourceAuthority); ?> / <?php echo e($setting->sourceReference); ?></dd></div><div><dt>Approval</dt><dd><?php echo e($setting->approvalState); ?></dd></div></dl><div class="people-ops-mobile-actions"><?php echo $__env->make('hr.compliance.partials.rule-actions', ['setting' => $setting, 'actionContext' => 'mobile'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div></article><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
        <div class="people-pagination"><?php echo e($settings->withQueryString()->links()); ?></div>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/developer/public_html/builder360/resources/views/hr/compliance/index.blade.php ENDPATH**/ ?>