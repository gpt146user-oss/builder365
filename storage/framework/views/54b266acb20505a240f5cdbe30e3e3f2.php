<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-theme="<?php echo e($theme ?? 'light'); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Builder360 ERP CRM'); ?></title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/enterprise.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body
    class="b360-classic"
    x-data="builderShell"
    x-bind:class="navigationClasses"
    x-on:keydown.escape.window="handleEscape"
    x-on:resize.window="handleResize"
>
    <div class="b360-shell">
        <?php echo $__env->make('builder360.classic.partials.sidebar', ['shell' => $shell], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <button type="button" class="b360-nav-backdrop" x-on:click="closeNavigation" aria-label="Close navigation" tabindex="-1"></button>

        <div class="b360-main">
            <?php echo $__env->make('builder360.classic.partials.topbar', ['shell' => $shell], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <main class="b360-content">
                <?php echo $__env->make('builder360.classic.partials.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/layouts/builder360-classic.blade.php ENDPATH**/ ?>