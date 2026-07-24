<?php $__env->startSection('title', 'My Tax Inputs - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'My tax declarations','description' => 'Declare employee tax inputs and attach only your existing private proof documents. Statutory formulas remain governed separately.','eyebrow' => 'Employee Self Service','active' => 'employees','selfService' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a class="people-button" href="<?php echo e(route('hr.employees.me')); ?>"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Self service</a>
     <?php $__env->endSlot(); ?>

    <?php if(session('status')): ?>
        <section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <section class="people-alert is-danger" role="alert" tabindex="-1">
            <strong>Tax inputs were not saved.</strong>
            <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($message); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </section>
    <?php endif; ?>

    <section class="people-ops-panel">
        <header class="people-ops-panel-head">
            <div>
                <h2><?php echo e($employee->name); ?> &middot; <?php echo e($employee->employee_code); ?></h2>
                <p>Financial year <?php echo e($financialYear); ?>. Amounts are stored as encrypted integer minor units.</p>
            </div>
            <?php if($taxProfile): ?>
                <span class="people-status is-<?php echo e($statusTone); ?>"><?php echo e($statusLabel); ?> &middot; v<?php echo e($taxProfile->version); ?></span>
            <?php endif; ?>
        </header>
        <div class="people-ops-panel-body">
            <form method="GET" action="<?php echo e(route('hr.employees.me.tax-inputs.edit')); ?>" class="people-inline-form" aria-label="Select financial year">
                <label class="people-field">
                    <span>Financial year</span>
                    <input class="people-control" name="financial_year" value="<?php echo e($financialYear); ?>" inputmode="numeric" pattern="\d{4}-\d{2}" aria-describedby="financial-year-help">
                    <small id="financial-year-help">Use YYYY-YY, for example 2026-27.</small>
                </label>
                <button class="people-button" type="submit">Open year</button>
            </form>
        </div>
    </section>

    <?php if($isLocked): ?>
        <section class="people-alert" role="note">
            Locked version <?php echo e($taxProfile->version); ?> is immutable. Saving creates version <?php echo e($amendmentVersion); ?> as a governed amendment and preserves this locked record and checksum.
        </section>
    <?php elseif($isReadOnly): ?>
        <section class="people-alert" role="note">This version is <?php echo e(strtolower($statusLabel)); ?> and is read-only while Payroll or Compliance completes the independent review.</section>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('hr.employees.me.tax-inputs.update')); ?>" class="people-ops-panel" novalidate>
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="hidden" name="financial_year" value="<?php echo e($financialYear); ?>">
        <?php if($taxProfile): ?><input type="hidden" name="lock_version" value="<?php echo e($taxProfile->lock_version); ?>"><?php endif; ?>

        <header class="people-ops-panel-head">
            <div><h2>Income and regime inputs</h2><p>These are personal payroll inputs, not statutory rate or slab settings.</p></div>
        </header>
        <div class="people-ops-panel-body people-form-grid">
            <label class="people-field">
                <span>Tax regime code</span>
                <input class="people-control" name="regime_code" value="<?php echo e(old('regime_code', $regimeCodeInput)); ?>" maxlength="64" pattern="[A-Za-z0-9_-]{2,64}" <?php if(! $editable): echo 'disabled'; endif; ?> aria-invalid="<?php echo e($errors->has('regime_code') ? 'true' : 'false'); ?>">
                <small>Stable code from the governed payroll configuration; no rate is edited here.</small>
                <?php $__errorArgs = ['regime_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </label>
            <label class="people-field">
                <span>Previous employer income (INR)</span>
                <input class="people-control" type="text" inputmode="decimal" name="previous_employer_income" value="<?php echo e(old('previous_employer_income', $previousEmployerIncomeInput)); ?>" <?php if(! $editable): echo 'disabled'; endif; ?> aria-invalid="<?php echo e($errors->has('previous_employer_income') ? 'true' : 'false'); ?>">
                <?php $__errorArgs = ['previous_employer_income'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </label>
            <label class="people-field">
                <span>Previous employer TDS (INR)</span>
                <input class="people-control" type="text" inputmode="decimal" name="previous_employer_tds" value="<?php echo e(old('previous_employer_tds', $previousEmployerTdsInput)); ?>" <?php if(! $editable): echo 'disabled'; endif; ?> aria-invalid="<?php echo e($errors->has('previous_employer_tds') ? 'true' : 'false'); ?>">
                <?php $__errorArgs = ['previous_employer_tds'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </label>
            <label class="people-field">
                <span>Projected other income (INR)</span>
                <input class="people-control" type="text" inputmode="decimal" name="projected_other_income" value="<?php echo e(old('projected_other_income', $projectedOtherIncomeInput)); ?>" <?php if(! $editable): echo 'disabled'; endif; ?> aria-invalid="<?php echo e($errors->has('projected_other_income') ? 'true' : 'false'); ?>">
                <?php $__errorArgs = ['projected_other_income'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </label>
        </div>

        <header class="people-ops-panel-head">
            <div><h2>Declarations and proofs</h2><p>Blank rows are ignored. Category codes must be stable and unique for this version.</p></div>
        </header>
        <div class="people-ops-table-wrap">
            <table class="people-ops-table">
                <caption>Employee tax declarations for <?php echo e($financialYear); ?></caption>
                <thead><tr><th scope="col">Category code</th><th scope="col">Type</th><th scope="col" class="is-number">Declared amount (INR)</th><th scope="col">Private proof</th></tr></thead>
                <tbody>
                    <?php $__currentLoopData = old('declarations', $declarationRows); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <input class="people-control" name="declarations[<?php echo e($index); ?>][category_code]" value="<?php echo e($row['category_code'] ?? ''); ?>" maxlength="64" placeholder="e.g. DECLARATION_CODE" <?php if(! $editable): echo 'disabled'; endif; ?> aria-label="Declaration <?php echo e($index + 1); ?> category code" aria-invalid="<?php echo e($errors->has("declarations.$index.category_code") ? 'true' : 'false'); ?>">
                                <?php $__errorArgs = ["declarations.$index.category_code"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </td>
                            <td>
                                <select class="people-control" name="declarations[<?php echo e($index); ?>][declaration_type]" <?php if(! $editable): echo 'disabled'; endif; ?> aria-label="Declaration <?php echo e($index + 1); ?> type">
                                    <option value="">Select type</option>
                                    <?php $__currentLoopData = ['deduction' => 'Deduction', 'exemption' => 'Exemption', 'other_income' => 'Other income']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value); ?>" <?php if(($row['declaration_type'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ["declarations.$index.declaration_type"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </td>
                            <td class="is-number">
                                <input class="people-control" type="text" inputmode="decimal" name="declarations[<?php echo e($index); ?>][declared_amount]" value="<?php echo e($row['declared_amount'] ?? ''); ?>" placeholder="0.00" <?php if(! $editable): echo 'disabled'; endif; ?> aria-label="Declaration <?php echo e($index + 1); ?> amount">
                                <?php $__errorArgs = ["declarations.$index.declared_amount"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </td>
                            <td>
                                <select class="people-control" name="declarations[<?php echo e($index); ?>][managed_document_id]" <?php if(! $editable): echo 'disabled'; endif; ?> aria-label="Declaration <?php echo e($index + 1); ?> proof document">
                                    <option value="">No proof selected</option>
                                    <?php $__currentLoopData = $proofOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($document['id']); ?>" <?php if((string) ($row['managed_document_id'] ?? '') === (string) $document['id']): echo 'selected'; endif; ?>><?php echo e($document['label']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ["declarations.$index.managed_document_id"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <?php if($editable): ?>
            <div class="people-ops-panel-body people-form-actions">
                <button class="people-button is-primary" type="submit"><i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> <?php echo e($saveButtonLabel); ?></button>
            </div>
        <?php endif; ?>
    </form>

    <?php if($canSubmit): ?>
        <section class="people-ops-panel">
            <header class="people-ops-panel-head"><div><h2>Submit for verification</h2><p>Submission freezes editing until an independent Payroll or Compliance reviewer completes the decision.</p></div></header>
            <form method="POST" action="<?php echo e(route('hr.employees.me.tax-inputs.submit', $taxProfile)); ?>" class="people-ops-panel-body people-form-actions">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <input type="hidden" name="lock_version" value="<?php echo e($taxProfile->lock_version); ?>">
                <button class="people-button is-primary" type="submit"><i class="fa-solid fa-paper-plane" aria-hidden="true"></i> Submit tax inputs</button>
            </form>
        </section>
    <?php endif; ?>

    <?php if($taxProfile): ?>
        <section class="people-ops-panel">
            <header class="people-ops-panel-head"><div><h2>Governance trace</h2><p>Version <?php echo e($taxProfile->version); ?> &middot; checksum <?php echo e($checksumPrefix); ?>&hellip;</p></div></header>
            <div class="people-ops-table-wrap">
                <table class="people-ops-table"><caption>Tax input workflow history</caption><thead><tr><th scope="col">Event</th><th scope="col">When</th><th scope="col">Note</th></tr></thead><tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $workflowRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr><td><strong><?php echo e($entry['event_label']); ?></strong></td><td><?php if($entry['at']): ?><time datetime="<?php echo e($entry['at']); ?>"><?php echo e($entry['at']); ?></time><?php else: ?> - <?php endif; ?></td><td><?php echo e($entry['note']); ?></td></tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="3">No workflow entries are available.</td></tr>
                    <?php endif; ?>
                </tbody></table>
            </div>
        </section>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/hr/employees/tax-inputs.blade.php ENDPATH**/ ?>