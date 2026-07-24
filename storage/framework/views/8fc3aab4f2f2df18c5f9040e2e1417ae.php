<?php
    $counts = $summary['counts'] ?? [];
    $byCategory = collect($summary['by_category'] ?? []);
    $activeCategory = $filters['category'] ?? null;
    $activeStatus = $filters['status'] ?? null;
    $activeSeverity = $filters['severity'] ?? null;
    $baseFilters = array_filter($filters, fn ($value) => $value !== null && $value !== '');
    $filterUrl = fn (array $overrides = []): string => route('notifications.index', array_filter(array_merge($baseFilters, $overrides), fn ($value) => $value !== null && $value !== ''));
?>

<?php $__env->startSection('title', 'Notifications | Builder360'); ?>

<?php $__env->startSection('content'); ?>
    <section class="b360-page-head">
        <div>
            <p class="b360-eyebrow">Overview / Notifications</p>
            <h1 id="notification-center-title">Notifications</h1>
            <p>Secure workflow inbox for real workflow notifications, reminders and alerts.</p>
        </div>
        <div class="b360-head-actions">
            <a class="b360-secondary-btn" href="<?php echo e(route('notifications.index', $baseFilters)); ?>"><i class="fa-solid fa-rotate"></i> Refresh</a>
            <form method="POST" action="<?php echo e(route('notifications.read-all')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <?php $__currentLoopData = ['q', 'category', 'severity', 'date_from', 'date_to']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(! empty($filters[$field])): ?>
                        <input type="hidden" name="<?php echo e($field); ?>" value="<?php echo e($filters[$field]); ?>">
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <button class="b360-secondary-btn" type="submit" <?php if(((int) ($counts['unread'] ?? 0)) === 0): echo 'disabled'; endif; ?>>
                    <i class="fa-solid fa-check"></i>
                    <?php echo e(((int) ($counts['unread'] ?? 0)) > 0 ? 'Mark all read' : 'All read'); ?>

                </button>
            </form>
        </div>
    </section>

    <section class="b360-stat-grid" aria-label="Notification metrics">
        <?php $__currentLoopData = [
            ['label' => 'Total', 'value' => $counts['total'] ?? 0, 'sub' => 'all notifications', 'icon' => 'fa-bell', 'tone' => 'b-violet', 'url' => $filterUrl(['status' => null, 'severity' => null])],
            ['label' => 'Unread', 'value' => $counts['unread'] ?? 0, 'sub' => 'needs attention', 'icon' => 'fa-bell', 'tone' => 'b-orange', 'url' => $filterUrl(['status' => 'unread', 'severity' => null])],
            ['label' => 'Critical Unread', 'value' => $counts['critical_unread'] ?? 0, 'sub' => 'priority alerts', 'icon' => 'fa-triangle-exclamation', 'tone' => 'b-red', 'url' => $filterUrl(['status' => 'unread', 'severity' => 'critical'])],
            ['label' => 'Archived', 'value' => $counts['archived'] ?? 0, 'sub' => 'saved notifications', 'icon' => 'fa-box-archive', 'tone' => 'b-blue', 'url' => $filterUrl(['status' => 'archived', 'severity' => null])],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metric): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a class="b360-stat-card" href="<?php echo e($metric['url']); ?>">
                <span class="b360-card-icon <?php echo e($metric['tone']); ?>"><i class="fa-solid <?php echo e($metric['icon']); ?>"></i></span>
                <span class="b360-stat-label"><?php echo e($metric['label']); ?></span>
                <strong><?php echo e(number_format((int) $metric['value'])); ?></strong>
                <small><?php echo e($metric['sub']); ?></small>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </section>

    <section class="b360-panel b360-filter-panel">
        <form method="GET" action="<?php echo e(route('notifications.index')); ?>" class="b360-filter-grid b360-notification-filter-grid">
            <label class="b360-search-field">
                <span>Search</span>
                <span class="b360-input-icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" placeholder="Search notifications">
                </span>
            </label>
            <label>
                <span>Status</span>
                <select name="status" class="form-select">
                    <option value="">All statuses</option>
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>" <?php if($activeStatus === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>
            <label>
                <span>Severity</span>
                <select name="severity" class="form-select">
                    <option value="">All severities</option>
                    <?php $__currentLoopData = $severities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>" <?php if($activeSeverity === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>
            <label>
                <span>From</span>
                <input class="form-control" type="date" name="date_from" value="<?php echo e($filters['date_from'] ?? ''); ?>">
            </label>
            <label>
                <span>To</span>
                <input class="form-control" type="date" name="date_to" value="<?php echo e($filters['date_to'] ?? ''); ?>">
            </label>
            <div class="b360-filter-actions">
                <button class="b360-primary-btn" type="submit"><i class="fa-solid fa-filter"></i> Apply</button>
                <a class="b360-secondary-btn" href="<?php echo e(route('notifications.index')); ?>">Clear</a>
            </div>
        </form>
    </section>

    <nav class="b360-tabs" aria-label="Notification categories">
        <a href="<?php echo e($filterUrl(['category' => null])); ?>" class="b360-tab <?php echo e($activeCategory === null ? 'is-active' : ''); ?>" <?php if($activeCategory === null): ?> aria-current="page" <?php endif; ?>>
            All <span><?php echo e(number_format((int) ($counts['total'] ?? 0))); ?></span>
        </a>
        <?php $__currentLoopData = $byCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $categoryValue = $category['category'] ?? ''; ?>
            <a href="<?php echo e($filterUrl(['category' => $categoryValue])); ?>" class="b360-tab <?php echo e($activeCategory === $categoryValue ? 'is-active' : ''); ?>" <?php if($activeCategory === $categoryValue): ?> aria-current="page" <?php endif; ?>>
                <?php echo e(str($categoryValue)->headline()); ?> <span><?php echo e(number_format((int) ($category['count'] ?? 0))); ?></span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>

    <section class="b360-notification-list" aria-labelledby="notification-center-title">
        <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="b360-notification-card <?php echo e($notification->status === 'unread' ? 'is-unread' : ''); ?>">
                <span class="b360-card-icon <?php echo e($notification->severity === 'critical' ? 'b-red' : ($notification->severity === 'warning' ? 'b-orange' : 'b-violet')); ?>">
                    <i class="fa-solid fa-bell"></i>
                </span>
                <div class="b360-notification-copy">
                    <div class="b360-notification-title">
                        <strong><?php echo e($notification->title); ?></strong>
                        <span class="b360-badge b-slate"><?php echo e(str($notification->category)->headline()); ?></span>
                    </div>
                    <p><?php echo e($notification->body); ?></p>
                    <small><?php echo e($notification->notification_number); ?> · <?php echo e($notification->created_at?->diffForHumans() ?? 'Recently'); ?></small>
                </div>
                <div class="b360-notification-actions">
                    <span class="b360-badge <?php echo e($notification->status === 'unread' ? 'b-orange' : 'b-slate'); ?>"><?php echo e(str($notification->status)->headline()); ?></span>
                    <?php if($notification->action_url): ?>
                        <a class="b360-small-btn b360-small-btn-primary" href="<?php echo e($notification->action_url); ?>">Open</a>
                    <?php endif; ?>
                    <?php if($notification->status === 'unread'): ?>
                        <form method="POST" action="<?php echo e(route('notifications.read', $notification)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button class="b360-small-btn" type="submit">Mark read</button>
                        </form>
                    <?php endif; ?>
                    <?php if($notification->status !== 'archived'): ?>
                        <form method="POST" action="<?php echo e(route('notifications.archive', $notification)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button class="b360-small-btn" type="submit">Archive</button>
                        </form>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <article class="b360-panel b360-empty b360-large-empty">
                <i class="fa-regular fa-bell-slash"></i>
                <strong>No notifications found</strong>
                <span>No notifications match the selected filters.</span>
            </article>
        <?php endif; ?>
    </section>

    <?php if($notifications->hasPages()): ?>
        <nav class="b360-pagination" aria-label="Notification pagination">
            <?php if($notifications->onFirstPage()): ?>
                <span aria-disabled="true">Previous</span>
            <?php else: ?>
                <a href="<?php echo e($notifications->previousPageUrl()); ?>">Previous</a>
            <?php endif; ?>
            <span>Page <?php echo e($notifications->currentPage()); ?> of <?php echo e($notifications->lastPage()); ?></span>
            <?php if($notifications->hasMorePages()): ?>
                <a href="<?php echo e($notifications->nextPageUrl()); ?>">Next</a>
            <?php else: ?>
                <span aria-disabled="true">Next</span>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/notifications/index.blade.php ENDPATH**/ ?>