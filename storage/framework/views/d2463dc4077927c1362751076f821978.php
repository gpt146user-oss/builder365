<?php $__env->startSection('title', 'Company Administration - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $activeCount = $companies->getCollection()->where('status', 'active')->count();
        $projectCount = $companies->getCollection()->sum('projects_count');
        $userCount = $companies->getCollection()->sum('users_count');
    ?>

    <div class="blade-workspace" aria-labelledby="company-admin-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Administration</p>
                <h1 id="company-admin-title">Company Administration</h1>
                <p>Create companies and review their branches, projects, users and operating status.</p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Admin navigation">
                <a href="<?php echo e(url('/')); ?>">Dashboard</a>
                <a href="<?php echo e(route('admin.users.index')); ?>">Users</a>
                <a href="<?php echo e(route('admin.roles.index')); ?>">Roles</a>
                <a href="<?php echo e(route('settings.data-imports.index')); ?>">Data Imports</a>
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

        <section class="blade-dashboard-kpis" aria-label="Company KPIs">
            <article class="blade-dashboard-kpi"><span>Companies</span><strong><?php echo e(number_format($companies->total())); ?></strong><small>Company register</small></article>
            <article class="blade-dashboard-kpi"><span>Active</span><strong><?php echo e(number_format($activeCount)); ?></strong><small>Current page</small></article>
            <article class="blade-dashboard-kpi"><span>Projects</span><strong><?php echo e(number_format($projectCount)); ?></strong><small>Current page</small></article>
            <article class="blade-dashboard-kpi"><span>Users</span><strong><?php echo e(number_format($userCount)); ?></strong><small>Current page</small></article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div><span class="blade-dashboard-label">Create</span><h2>Add company</h2></div>
                <small>Required fields are marked</small>
            </div>
            <form method="POST" action="<?php echo e(route('admin.companies.store')); ?>" class="blade-form-grid">
                <?php echo csrf_field(); ?>
                <label>Company code<input type="text" name="code" value="<?php echo e(old('code')); ?>" maxlength="24" placeholder="B360X" required></label>
                <label>Company name<input type="text" name="name" value="<?php echo e(old('name')); ?>" maxlength="255" required></label>
                <label>Legal name<input type="text" name="legal_name" value="<?php echo e(old('legal_name')); ?>" maxlength="255"></label>
                <label>State code<input type="text" name="state" value="<?php echo e(old('state')); ?>" maxlength="8" placeholder="MH" required></label>
                <label>Status<select name="status"><option value="active" <?php if(old('status', 'active') === 'active'): echo 'selected'; endif; ?>>Active</option><option value="inactive" <?php if(old('status') === 'inactive'): echo 'selected'; endif; ?>>Inactive</option></select></label>
                <button type="submit" class="blade-primary-action">Create company</button>
            </form>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div><span class="blade-dashboard-label">Companies</span><h2>Company register</h2></div>
                <small><?php echo e($companies->firstItem() ?? 0); ?>-<?php echo e($companies->lastItem() ?? 0); ?> of <?php echo e($companies->total()); ?></small>
            </div>
            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead><tr><th scope="col">Company</th><th scope="col">State</th><th scope="col">Branches</th><th scope="col">Projects</th><th scope="col">Users</th><th scope="col">Status</th></tr></thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><strong><?php echo e($company->code); ?></strong><span><?php echo e($company->name); ?></span><small><?php echo e($company->legal_name ?: 'Legal name not recorded'); ?></small></td>
                                <td><?php echo e($company->state); ?></td>
                                <td><?php echo e(number_format($company->branches_count)); ?></td>
                                <td><?php echo e(number_format($company->projects_count)); ?></td>
                                <td><?php echo e(number_format($company->users_count)); ?></td>
                                <td><span class="blade-status-pill"><?php echo e(ucfirst($company->status)); ?></span></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="6">No companies are available.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php echo e($companies->links()); ?>

        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\admin\companies\index.blade.php ENDPATH**/ ?>