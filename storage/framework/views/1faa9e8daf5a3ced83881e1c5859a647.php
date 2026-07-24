

<?php $__env->startSection('title', 'System Settings - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $draftCount = $settings->getCollection()->where('status', 'draft')->count();
        $activeCount = $settings->getCollection()->where('status', 'active')->count();
        $archivedCount = $settings->getCollection()->where('status', 'archived')->count();
    ?>

    <div class="blade-workspace" aria-labelledby="system-settings-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Administration</p>
                <h1 id="system-settings-title">System Settings</h1>
                <p>
                    Workspace for configurable business rules, policy versions,
                    approval-controlled activation, effective dates and settings change history.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Settings navigation">
                <a href="<?php echo e(url('/')); ?>">Dashboard</a>
                <a href="<?php echo e(route('admin.roles.index')); ?>">Roles</a>
                <a href="<?php echo e(route('admin.users.index')); ?>">Users</a>
                <a href="<?php echo e(route('governance.audit-events.index')); ?>">Activity History</a>
                <a href="<?php echo e(route('settings.system-settings.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <div class="blade-alert blade-alert-success"><?php echo e(session('status')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="blade-alert blade-alert-danger">
                <strong>Check the highlighted inputs.</strong>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <section class="blade-dashboard-kpis" aria-label="Settings KPIs">
            <article class="blade-dashboard-kpi">
                <span>Total Settings</span>
                <strong><?php echo e(number_format($settings->total())); ?></strong>
                <small>Settings register</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Draft</span>
                <strong><?php echo e(number_format($draftCount)); ?></strong>
                <small>Needs approval</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Active</span>
                <strong><?php echo e(number_format($activeCount)); ?></strong>
                <small>Current page</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Archived</span>
                <strong><?php echo e(number_format($archivedCount)); ?></strong>
                <small>Historical versions</small>
            </article>
        </section>

        <section class="blade-workspace-grid">
            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Draft</span>
                        <h2>Create setting draft</h2>
                    </div>
                    <small><?php echo e($canCreateSetting ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateSetting): ?>
                    <form
                        method="POST"
                        action="<?php echo e(route('settings.system-settings.store')); ?>"
                        class="blade-form-grid"
                        x-data="serverFormState"
                        x-on:submit="beginSubmit"
                        x-bind:aria-busy="busyAria"
                        data-idle-label="Create draft"
                        data-busy-label="Creating draft…"
                    >
                        <?php echo csrf_field(); ?>
                        <?php if (isset($component)) { $__componentOriginal5ee006ce6757c21855df609df2a8580f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5ee006ce6757c21855df609df2a8580f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.company-context','data' => ['companies' => $companies,'label' => 'Company access','placeholder' => 'Actor company default']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.company-context'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['companies' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($companies),'label' => 'Company access','placeholder' => 'Actor company default']); ?>
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
                        <label>
                            Group
                            <input type="text" name="setting_group" value="<?php echo e(old('setting_group')); ?>" maxlength="80" placeholder="after_sales" required>
                        </label>
                        <label>
                            Key
                            <input type="text" name="setting_key" value="<?php echo e(old('setting_key')); ?>" maxlength="160" placeholder="after_sales.sla_hours" required>
                        </label>
                        <label>
                            Label
                            <input type="text" name="label" value="<?php echo e(old('label')); ?>" maxlength="255" required>
                        </label>
                        <label>
                            Value type
                            <select name="value_type" required>
                                <?php $__currentLoopData = $valueTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('value_type', 'object') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>
                        <label>
                            Effective from
                            <input type="date" name="effective_from" value="<?php echo e(old('effective_from')); ?>">
                        </label>
                        <label class="blade-form-wide">
                            Description
                            <textarea name="description" rows="3"><?php echo e(old('description')); ?></textarea>
                        </label>
                        <label class="blade-form-wide">
                            Value
                            <textarea name="value" rows="8" required><?php echo e(old('value', "{\n  \"value\": true\n}")); ?></textarea>
                            <small>For JSON/object/array value types, enter valid JSON. Special settings such as lead scoring and task templates are deeply validated.</small>
                        </label>
                        <button type="submit" class="blade-primary-action" x-bind:disabled="busy"><span x-text="submitLabel">Create draft</span></button>
                    </form>
                <?php else: ?>
                    <p class="blade-muted">This role can view settings but cannot create configuration drafts.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Setting filters</h2>
                    </div>
                    <small><?php echo e(number_format($settings->total())); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('settings.system-settings.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                    <label>
                        Group
                        <select name="setting_group">
                            <option value="">All groups</option>
                            <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($group); ?>" <?php if(($filters['setting_group'] ?? null) === $group): echo 'selected'; endif; ?>><?php echo e($group); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <label>
                        Key
                        <select name="setting_key">
                            <option value="">All keys</option>
                            <?php $__currentLoopData = $keys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>" <?php if(($filters['setting_key'] ?? null) === $key): echo 'selected'; endif; ?>><?php echo e($key); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <label>
                        Status
                        <select name="status">
                            <option value="">All statuses</option>
                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? null) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <label>
                        Scope key
                        <input type="text" name="scope_key" value="<?php echo e($filters['scope_key'] ?? ''); ?>" placeholder="global or company:1">
                    </label>
                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Configuration</span>
                    <h2>Setting register</h2>
                </div>
                <small><?php echo e($settings->firstItem() ?? 0); ?>-<?php echo e($settings->lastItem() ?? 0); ?> of <?php echo e($settings->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Setting</th>
                            <th scope="col">Scope</th>
                            <th scope="col">Version</th>
                            <th scope="col">Effective</th>
                            <th scope="col">Value</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($setting->label); ?></strong>
                                    <span><?php echo e($setting->setting_key); ?></span>
                                    <small><?php echo e($setting->setting_group); ?></small>
                                </td>
                                <td>
                                    <span><?php echo e($setting->scope_key); ?></span>
                                    <small><?php echo e($setting->company?->name ?? 'Global'); ?></small>
                                </td>
                                <td>
                                    <span>v<?php echo e($setting->version); ?></span>
                                    <small><?php echo e($setting->value_type); ?></small>
                                </td>
                                <td>
                                    <span><?php echo e($setting->effective_from?->format('d M Y') ?? 'Immediate'); ?></span>
                                    <?php if($setting->effective_to): ?>
                                        <small>to <?php echo e($setting->effective_to->format('d M Y')); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small><?php echo e(\Illuminate\Support\Str::limit(json_encode($setting->value, JSON_UNESCAPED_SLASHES), 140)); ?></small>
                                </td>
                                <td><span class="blade-status-pill"><?php echo e($statuses[$setting->status] ?? $setting->status); ?></span></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve', $setting)): ?>
                                        <form
                                            method="POST"
                                            action="<?php echo e(route('settings.system-settings.approve', $setting)); ?>"
                                            class="blade-inline-form"
                                            x-data="serverFormState"
                                            x-on:submit="beginSubmit"
                                            x-bind:aria-busy="busyAria"
                                            data-idle-label="Approve"
                                            data-busy-label="Approving…"
                                        >
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <input type="text" name="note" placeholder="Approval note" maxlength="1000">
                                            <button type="submit" class="blade-primary-action" x-bind:disabled="busy"><span x-text="submitLabel">Approve</span></button>
                                        </form>
                                    <?php else: ?>
                                        <span class="blade-muted">No approval action</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No settings found for the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php echo e($settings->links()); ?>

        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/developer/public_html/builder360/resources/views/settings/system-settings/index.blade.php ENDPATH**/ ?>