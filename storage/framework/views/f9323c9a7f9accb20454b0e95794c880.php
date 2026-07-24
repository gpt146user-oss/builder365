<?php $__env->startSection('title', 'Builder360 ERP CRM'); ?>

<?php $__env->startSection('content'); ?>
    <main style="min-height:100vh;display:grid;place-items:center;padding:24px">
        <section class="card" style="width:min(100%,560px);padding:30px">
            <div style="display:flex;align-items:center;gap:14px;margin-bottom:22px">
                <div class="sb-logo">B</div>
                <div>
                    <h1 style="margin:0;font-size:26px">Builder360 Workspace</h1>
                    <p style="margin:5px 0 0;color:var(--muted)">ERP and CRM operations in one secured workspace.</p>
                </div>
            </div>
            <a class="btn btn-primary" href="<?php echo e(auth()->check() ? route('builder360.dashboard') : route('login')); ?>">
                <?php echo e(auth()->check() ? 'Open Builder360' : 'Login'); ?>

            </a>
        </section>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\welcome.blade.php ENDPATH**/ ?>