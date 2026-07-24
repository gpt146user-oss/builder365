<section class="people-ops-grid is-wide-left" aria-label="Employee asset controls">
    <article class="people-ops-panel" id="asset-form">
        <header class="people-ops-panel-head">
            <div><h2>Register employee asset</h2><p>Add an asset to the governed company inventory.</p></div>
        </header>
        <div class="people-ops-panel-body">
            <?php if($abilities['canCreateAsset']): ?>
                <form method="POST" action="<?php echo e(route('hr.assets.store')); ?>" class="people-form-grid" x-data="serverFormState" x-on:submit="beginSubmit" x-bind:aria-busy="busyAria" data-idle-label="Register asset" data-busy-label="Registering…">
                    <?php echo csrf_field(); ?>
                    <?php if($companies->count() > 1): ?>
                        <label class="people-field"><span>Company</span><select class="people-control" name="company_id" required><option value="">Select company</option><?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($company->id); ?>" <?php if((string) old('company_id') === (string) $company->id): echo 'selected'; endif; ?>><?php echo e($company->code); ?> - <?php echo e($company->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['company_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <?php elseif($companies->first()): ?>
                        <input type="hidden" name="company_id" value="<?php echo e($companies->first()->id); ?>">
                    <?php endif; ?>
                    <label class="people-field"><span>Asset code</span><input class="people-control" name="asset_code" value="<?php echo e(old('asset_code')); ?>" maxlength="40" pattern="[A-Z0-9-]+" required placeholder="AST-1001"><?php $__errorArgs = ['asset_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Category</span><select class="people-control" name="category" required><option value="">Select category</option><?php $__currentLoopData = $assetCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($category); ?>" <?php if(old('category') === $category): echo 'selected'; endif; ?>><?php echo e($category); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Asset name</span><input class="people-control" name="name" value="<?php echo e(old('name')); ?>" maxlength="160" required placeholder="Device or equipment name"><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Serial number</span><input class="people-control" name="serial_number" value="<?php echo e(old('serial_number')); ?>" maxlength="120" placeholder="Optional manufacturer serial"><?php $__errorArgs = ['serial_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Condition</span><select class="people-control" name="condition"><?php $__currentLoopData = $assetConditions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($condition); ?>" <?php if(old('condition', 'good') === $condition): echo 'selected'; endif; ?>><?php echo e(ucfirst($condition)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['condition'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <label class="people-field"><span>Estimated value (INR)</span><input class="people-control" type="number" name="estimated_value" value="<?php echo e(old('estimated_value', 0)); ?>" min="0" step="0.01"><?php $__errorArgs = ['estimated_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                    <div class="people-modal-actions is-wide"><button type="submit" class="people-button is-primary" x-bind:disabled="busy"><span x-text="submitLabel">Register asset</span></button></div>
                </form>
            <?php else: ?>
                <div class="people-ops-empty"><i class="fa-solid fa-lock" aria-hidden="true"></i><strong>Asset registration unavailable</strong><span>Your role can review authorized assets but cannot add inventory.</span></div>
            <?php endif; ?>
        </div>
    </article>

    <article class="people-ops-panel">
        <header class="people-ops-panel-head"><div><h2>Asset filters</h2><p>Filter the authorized inventory without changing company scope.</p></div></header>
        <div class="people-ops-panel-body">
            <form method="GET" action="<?php echo e(route('hr.assets.index')); ?>" class="people-form-grid">
                <label class="people-field is-wide"><span>Search</span><input class="people-control" name="search" value="<?php echo e(request('search')); ?>" maxlength="120" placeholder="Asset code, name, or serial number"></label>
                <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id"><option value="">All employees</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string) request('employee_id') === (string) $employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Category</span><select class="people-control" name="category"><option value="">All categories</option><?php $__currentLoopData = $assetCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($category); ?>" <?php if(request('category') === $category): echo 'selected'; endif; ?>><?php echo e($category); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Status</span><select class="people-control" name="status"><option value="">All statuses</option><?php $__currentLoopData = $assetStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($status); ?>" <?php if(request('status') === $status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <div class="people-modal-actions is-wide"><button class="people-button" type="submit">Apply filters</button><a class="people-button" href="<?php echo e(route('hr.assets.index')); ?>">Clear</a></div>
            </form>
        </div>
    </article>
</section>

<section class="people-ops-panel has-mobile-cards" aria-labelledby="employee-assets-title">
    <header class="people-ops-panel-head"><div><h2 id="employee-assets-title">Employee assets</h2><p><?php echo e($assets->total()); ?> asset<?php echo e($assets->total() === 1 ? '' : 's'); ?> match the selected filters.</p></div></header>
    <div class="people-ops-table-wrap">
        <table class="people-ops-table">
            <caption>Employee asset register</caption>
            <thead><tr><th scope="col">Asset</th><th scope="col">Category / serial</th><th scope="col">Custodian</th><th scope="col">Condition</th><th scope="col">Status / dates</th><th scope="col">Value / history</th><th scope="col" class="is-actions">Action</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($asset->assetCode); ?></strong><small><?php echo e($asset->name); ?></small></td>
                        <td><?php echo e($asset->category); ?><small><?php echo e($asset->serialNumber); ?></small></td>
                        <td><div class="people-ops-identity"><span class="people-avatar"><?php echo e($asset->employeeInitial); ?></span><div><strong><?php echo e($asset->employeeName); ?></strong><small><?php echo e($asset->employeeCode); ?> / <?php echo e($asset->employeeContext); ?></small></div></div></td>
                        <td><span class="people-status is-<?php echo e($asset->conditionTone); ?>"><?php echo e($asset->conditionLabel); ?></span></td>
                        <td><span class="people-status is-<?php echo e($asset->statusTone); ?>"><?php echo e($asset->statusLabel); ?></span><small>Assigned: <?php echo e($asset->assignedOn); ?></small><small>Recovered: <?php echo e($asset->recoveredOn); ?></small></td>
                        <td><?php echo e($asset->estimatedValue); ?><small><?php echo e($asset->workflowNote); ?></small><small><?php echo e($asset->workflowActor); ?> / <?php echo e($asset->workflowAt); ?></small></td>
                        <td class="is-actions">
                            <?php echo $__env->make('hr.operations.partials.asset-actions', ['asset' => $asset], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7"><div class="people-ops-empty"><i class="fa-solid fa-laptop" aria-hidden="true"></i><strong>No employee assets found</strong><span>Clear the filters or register a new asset when permitted.</span></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="people-ops-mobile-list">
        <?php $__empty_1 = true; $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="people-ops-mobile-card">
                <div class="people-ops-mobile-card-head"><strong><?php echo e($asset->assetCode); ?> / <?php echo e($asset->name); ?></strong><span class="people-status is-<?php echo e($asset->statusTone); ?>"><?php echo e($asset->statusLabel); ?></span></div>
                <dl class="people-ops-mobile-facts"><div><dt>Category / serial</dt><dd><?php echo e($asset->category); ?> / <?php echo e($asset->serialNumber); ?></dd></div><div><dt>Custodian</dt><dd><?php echo e($asset->employeeName); ?> / <?php echo e($asset->employeeCode); ?></dd></div><div><dt>Condition</dt><dd><?php echo e($asset->conditionLabel); ?></dd></div><div><dt>Estimated value</dt><dd><?php echo e($asset->estimatedValue); ?></dd></div><div><dt>Assigned</dt><dd><?php echo e($asset->assignedOn); ?></dd></div><div><dt>Recovered</dt><dd><?php echo e($asset->recoveredOn); ?></dd></div></dl>
                <p><?php echo e($asset->workflowNote); ?> / <?php echo e($asset->workflowActor); ?> / <?php echo e($asset->workflowAt); ?></p>
                <div class="people-ops-mobile-actions">
                    <?php echo $__env->make('hr.operations.partials.asset-actions', ['asset' => $asset], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="people-ops-empty"><strong>No employee assets found</strong><span>Clear the filters or register a new asset when permitted.</span></div>
        <?php endif; ?>
    </div>
    <div class="people-pagination"><?php echo e($assets->withQueryString()->links()); ?></div>
</section>
<?php /**PATH /home/developer/public_html/builder360/resources/views/hr/operations/partials/assets.blade.php ENDPATH**/ ?>