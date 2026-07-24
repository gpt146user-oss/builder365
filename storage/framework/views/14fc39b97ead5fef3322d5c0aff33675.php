<?php $__env->startSection('title', 'Builder360 ERP CRM'); ?>

<?php $__env->startSection('content'); ?>
    <section class="blade-dashboard-card">
        <div class="blade-dashboard-section-title">
            <div>
                <span class="blade-dashboard-label">Builder360 ERP CRM</span>
                <h1>Builder360 Workspace</h1>
            </div>
        </div>
        <p class="b360-muted">The approved Builder360 workspace is available from the main dashboard.</p>
        <a class="blade-primary-action" href="<?php echo e(route('builder360.dashboard')); ?>">Open dashboard</a>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\builder360.blade.php ENDPATH**/ ?>