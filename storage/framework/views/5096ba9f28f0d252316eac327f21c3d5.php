

<?php $__env->startSection('title', 'Role Administration - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $activeCount = $roles->getCollection()->where('is_active', true)->count();
        $globalCount = $roles->getCollection()->where('scope_level', 'global')->count();
        $wildcardCount = $roles->getCollection()->filter(fn ($role) => in_array('*', $role->permissions ?? [], true))->count();
    ?>

    <div class="blade-workspace" aria-labelledby="role-admin-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Administration</p>
                <h1 id="role-admin-title">Role Administration</h1>
                <p>
                    Workspace for role creation, permission assignment,
                    access control, active/inactive status and role change history.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Admin navigation">
                <a href="<?php echo e(url('/')); ?>">Dashboard</a>
                <a href="<?php echo e(route('admin.users.index')); ?>">Users</a>
                <a href="<?php echo e(route('governance.audit-events.index')); ?>">Activity History</a>
                <a href="<?php echo e(route('admin.roles.index')); ?>">Reset filters</a>
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

        <section class="blade-dashboard-kpis" aria-label="Role KPIs">
            <article class="blade-dashboard-kpi">
                <span>Total Roles</span>
                <strong><?php echo e(number_format($roles->total())); ?></strong>
                <small>Role register</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Active</span>
                <strong><?php echo e(number_format($activeCount)); ?></strong>
                <small>Current page</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Global Scope</span>
                <strong><?php echo e(number_format($globalCount)); ?></strong>
                <small>Current page</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Wildcard</span>
                <strong><?php echo e(number_format($wildcardCount)); ?></strong>
                <small>Current page</small>
            </article>
        </section>

        <section class="blade-workspace-grid">
            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Create</span>
                        <h2>Create role</h2>
                    </div>
                    <small><?php echo e($canCreateRole ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateRole): ?>
                    <form method="POST" action="<?php echo e(route('admin.roles.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>
                        <label>
                            Slug
                            <input type="text" name="slug" value="<?php echo e(old('slug')); ?>" maxlength="80" placeholder="site_ops_viewer" required>
                        </label>
                        <label>
                            Name
                            <input type="text" name="name" value="<?php echo e(old('name')); ?>" maxlength="120" required>
                        </label>
                        <label>
                            Scope level
                            <select name="scope_level" required>
                                <?php $__currentLoopData = $scopeLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('scope_level', 'company') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>
                        <label>
                            Status
                            <select name="is_active">
                                <option value="1" <?php if(old('is_active', '1') === '1'): echo 'selected'; endif; ?>>Active</option>
                                <option value="0" <?php if(old('is_active') === '0'): echo 'selected'; endif; ?>>Inactive</option>
                            </select>
                        </label>
                        <label class="blade-form-wide">
                            Permissions
                            <select name="permissions[]" multiple required>
                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($permission); ?>" <?php if(in_array($permission, old('permissions', []), true)): echo 'selected'; endif; ?>><?php echo e($permission); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small>Use Ctrl/Cmd to select multiple permissions. Non-global admins can grant only their own permissions.</small>
                        </label>
                        <button type="submit" class="blade-primary-action">Create role</button>
                    </form>
                <?php else: ?>
                    <p class="blade-muted">This role can view roles but cannot create new access profiles.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Role filters</h2>
                    </div>
                    <small><?php echo e(number_format($roles->total())); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('admin.roles.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                    <label>
                        Scope
                        <select name="scope_level">
                            <option value="">All scopes</option>
                            <?php $__currentLoopData = $scopeLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['scope_level'] ?? null) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <label>
                        Status
                        <select name="is_active">
                            <option value="">All statuses</option>
                            <option value="1" <?php if((string) ($filters['is_active'] ?? '') === '1'): echo 'selected'; endif; ?>>Active</option>
                            <option value="0" <?php if((string) ($filters['is_active'] ?? '') === '0'): echo 'selected'; endif; ?>>Inactive</option>
                        </select>
                    </label>
                    <label>
                        Search
                        <input type="search" name="search" value="<?php echo e($filters['search'] ?? ''); ?>" placeholder="Slug or name">
                    </label>
                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Management</span>
                    <h2>Role register</h2>
                </div>
                <small><?php echo e($roles->firstItem() ?? 0); ?>-<?php echo e($roles->lastItem() ?? 0); ?> of <?php echo e($roles->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Role</th>
                            <th scope="col">Scope</th>
                            <th scope="col">Permissions</th>
                            <th scope="col">Users</th>
                            <th scope="col">Status</th>
                            <th scope="col">Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($role->name); ?></strong>
                                    <span><?php echo e($role->slug); ?></span>
                                </td>
                                <td><?php echo e($scopeLevels[$role->scope_level] ?? $role->scope_level); ?></td>
                                <td>
                                    <span><?php echo e(count($role->permissions ?? [])); ?> permission(s)</span>
                                    <small><?php echo e(\Illuminate\Support\Str::limit(implode(', ', $role->permissions ?? []), 120)); ?></small>
                                </td>
                                <td><?php echo e(number_format((int) ($role->users_count ?? 0))); ?></td>
                                <td><span class="blade-status-pill"><?php echo e($role->is_active ? 'Active' : 'Inactive'); ?></span></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $role)): ?>
                                        <form method="POST" action="<?php echo e(route('admin.roles.update', $role)); ?>" class="blade-form-grid">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <label>
                                                Name
                                                <input type="text" name="name" value="<?php echo e(old('name', $role->name)); ?>" maxlength="120" required>
                                            </label>
                                            <label>
                                                Scope
                                                <select name="scope_level" required>
                                                    <?php $__currentLoopData = $scopeLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($value); ?>" <?php if($role->scope_level === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </label>
                                            <label>
                                                Status
                                                <select name="is_active" required>
                                                    <option value="1" <?php if($role->is_active): echo 'selected'; endif; ?>>Active</option>
                                                    <option value="0" <?php if(! $role->is_active): echo 'selected'; endif; ?>>Inactive</option>
                                                </select>
                                            </label>
                                            <label class="blade-form-wide">
                                                Permissions
                                                <select name="permissions[]" multiple required>
                                                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($permission); ?>" <?php if(in_array($permission, $role->permissions ?? [], true)): echo 'selected'; endif; ?>><?php echo e($permission); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </label>
                                            <button type="submit" class="blade-secondary-action">Update role</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="blade-muted">No update access</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6">No roles found for the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php echo e($roles->links()); ?>

        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\admin\roles\index.blade.php ENDPATH**/ ?>