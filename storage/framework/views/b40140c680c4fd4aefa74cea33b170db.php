<?php
    use App\Services\Builder360\Builder360Bootstrap;
    use App\Support\Builder360ModuleNavigation;

    $builder360NavigationBootstrap = $builder360NavigationBootstrap
        ?? $bootstrap
        ?? (auth()->check() ? app(Builder360Bootstrap::class)->forUser(auth()->user()) : []);

    $builder360NavigationModules = collect($builder360NavigationBootstrap['modules'] ?? []);
?>

<aside class="sidebar blade-dashboard-sidebar" aria-label="Primary module navigation">
    <div class="sb-brand">
        <div class="sb-logo" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 21h18" />
                <path d="M5 21V7l7-4 7 4v14" />
                <path d="M9 21v-8h6v8" />
                <path d="M8 9h.01M12 9h.01M16 9h.01" />
            </svg>
        </div>
        <div>
            <div class="sb-brand-name">Builder360</div>
            <div class="sb-brand-sub">Construction ERP · CRM</div>
        </div>
    </div>

    <div class="sb-search" aria-label="Module search placeholder">
        <span>Search modules</span>
        <kbd>/</kbd>
    </div>

    <nav class="sb-nav blade-sidebar-nav">
        <?php $__empty_1 = true; $__currentLoopData = $builder360NavigationModules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <section class="blade-sidebar-group" aria-labelledby="blade-sidebar-group-<?php echo e(\Illuminate\Support\Str::slug($group['group'] ?? 'modules')); ?>">
                <h2 class="sb-group-label" id="blade-sidebar-group-<?php echo e(\Illuminate\Support\Str::slug($group['group'] ?? 'modules')); ?>"><?php echo e($group['group'] ?? 'Modules'); ?></h2>
                <?php $__currentLoopData = ($group['items'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $moduleRoute = $item['route'] ?? $item['slug'] ?? null;
                        $url = Builder360ModuleNavigation::urlFor($moduleRoute, $builder360NavigationBootstrap);
                        $isActive = Builder360ModuleNavigation::isActive($moduleRoute);
                        $moduleName = $item['name'] ?? $item['slug'] ?? 'Module';
                        $moduleInitial = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($moduleName, 0, 1));
                    ?>

                    <?php if($url): ?>
                        <a href="<?php echo e($url); ?>" class="<?php echo e($isActive ? 'blade-sidebar-link is-active' : 'blade-sidebar-link nav-item'); ?>" <?php if($isActive): ?> aria-current="page" <?php endif; ?>>
                            <span class="ni-ic" aria-hidden="true"><?php echo e($moduleInitial); ?></span>
                            <span class="nav-label"><?php echo e($moduleName); ?></span>
                        </a>
                    <?php else: ?>
                        <span class="nav-item blade-sidebar-link is-disabled" aria-disabled="true">
                            <span class="ni-ic" aria-hidden="true"><?php echo e($moduleInitial); ?></span>
                            <span class="nav-label"><?php echo e($moduleName); ?></span>
                        </span>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </section>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="faint" style="padding: 12px;">No authorized modules are available for this account.</p>
        <?php endif; ?>
    </nav>

    <div class="sb-foot">
        <span class="badge b-accent">Builder360 workspace</span>
    </div>
</aside>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\partials\builder360-module-sidebar.blade.php ENDPATH**/ ?>