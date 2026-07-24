<?php $__env->startSection('title', 'Document Categories - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<div class="blade-workspace" aria-labelledby="document-categories-title">
    <header class="blade-workspace-header">
        <div>
            <p class="blade-dashboard-eyebrow">Document Management</p>
            <h1 id="document-categories-title">Document Categories</h1>
            <p>Review document ownership, expiry, reminder, and retention requirements used across the document repository.</p>
        </div>
        <nav class="blade-workspace-actions" aria-label="Document category navigation">
            <a href="<?php echo e(route('documents.index')); ?>">Document Repository</a>
            <a href="<?php echo e(route('documents.categories.index')); ?>" class="is-active" aria-current="page">Categories</a>
        </nav>
    </header>

    <section class="blade-card" aria-labelledby="category-filter-title">
        <div class="blade-card-header">
            <div>
                <p class="blade-dashboard-eyebrow">Category register</p>
                <h2 id="category-filter-title">Available categories</h2>
            </div>
            <small><?php echo e(number_format($categories->total())); ?> categor<?php echo e($categories->total() === 1 ? 'y' : 'ies'); ?></small>
        </div>

        <form method="GET" action="<?php echo e(route('documents.categories.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
            <label>
                Owner type
                <select name="owner_type">
                    <option value="">All owner types</option>
                    <?php $__currentLoopData = $ownerTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>" <?php if(($filters['owner_type'] ?? null) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>
            <button type="submit" class="blade-secondary-action">Apply filter</button>
            <a href="<?php echo e(route('documents.categories.index')); ?>" class="blade-secondary-action">Reset</a>
        </form>

        <div class="blade-table-wrap">
            <table class="blade-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Owner</th>
                        <th>Expiry control</th>
                        <th>Reminder</th>
                        <th>Retention</th>
                        <th>Documents</th>
                        <th>Availability</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($category->code); ?></strong><br><span><?php echo e($category->name); ?></span></td>
                            <td><?php echo e($ownerTypes[$category->owner_type] ?? ucfirst($category->owner_type)); ?></td>
                            <td><?php echo e($category->expiry_required ? 'Required' : 'Optional'); ?></td>
                            <td><?php echo e(number_format($category->reminder_days_before_expiry)); ?> day(s) before expiry</td>
                            <td><?php echo e(number_format($category->retention_years)); ?> year(s)</td>
                            <td><?php echo e(number_format($category->documents_count)); ?></td>
                            <td>
                                <span class="blade-status-pill">
                                    <?php echo e($category->company ? $category->company->code : 'Company-wide'); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="7">No document categories are available for the selected owner type.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php echo e($categories->withQueryString()->links()); ?>

    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\documents\categories\index.blade.php ENDPATH**/ ?>