<?php
    use App\Support\Builder360ModuleNavigation;

    $dashboard = $page->dashboard;
    $navigationContext = $page->navigationContext;
    $period = $dashboard['period'] ?? ($navigationContext['active_dashboard_period'] ?? []);
    $stats = collect($dashboard['stats'] ?? []);
    $quickActions = collect($dashboard['quick_actions'] ?? []);
    $sections = collect($dashboard['sections'] ?? []);
    $alerts = collect($dashboard['alerts'] ?? []);
    $tables = collect($dashboard['tables'] ?? []);

    $dashboardUrl = function (?string $route, array $filters = []) use ($navigationContext): ?string {
        $url = Builder360ModuleNavigation::urlFor($route, $navigationContext);

        if (! $url) {
            return null;
        }

        $filters = array_filter($filters, fn ($value) => $value !== null && $value !== '');

        return $filters ? $url.(str_contains($url, '?') ? '&' : '?').http_build_query($filters) : $url;
    };
?>

<?php $__env->startSection('title', ($dashboard['title'] ?? 'Dashboard').' | Builder360'); ?>
<style>
    .shell { height: 100vh; overflow: hidden; display: flex; }
.main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
.content { flex: 1; overflow-y: auto; }
    </style>
<?php $__env->startSection('content'); ?>
    <section class="b360-page-head">
        <div>
            <h1><?php echo e($dashboard['title'] ?? 'Dashboard'); ?></h1>
            <p><?php echo e($dashboard['subtitle'] ?? 'Live business view for your role.'); ?></p>
        </div>

        <div class="b360-head-actions">
            <form method="POST" action="<?php echo e(route('builder360.dashboard-context.store')); ?>" class="b360-period-form" x-data="periodSelector" data-period-key="<?php echo e($period['key'] ?? 'current_month'); ?>">
                <?php echo csrf_field(); ?>
                <label for="dashboard-period-key">Period</label>
                <select id="dashboard-period-key" name="period_key" x-model="periodKey">
                    <?php $__currentLoopData = ($period['options'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periodOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($periodOption['key']); ?>" <?php if(($period['key'] ?? 'current_month') === $periodOption['key']): echo 'selected'; endif; ?>>
                            <?php echo e($periodOption['label']); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <span class="b360-custom-period" x-show="customPeriod" x-cloak>
                    <input type="date" name="date_from" value="<?php echo e(($period['key'] ?? '') === 'custom' ? ($period['date_from'] ?? '') : ''); ?>" x-bind:required="customPeriod" aria-label="Period start date">
                    <input type="date" name="date_to" value="<?php echo e(($period['key'] ?? '') === 'custom' ? ($period['date_to'] ?? '') : ''); ?>" x-bind:required="customPeriod" aria-label="Period end date">
                </span>
                <button type="submit">Apply</button>
            </form>

            <?php if(! empty($dashboard['primary_route'])): ?>
                <?php $primaryUrl = $dashboardUrl($dashboard['primary_route'], []); ?>
                <?php if($primaryUrl): ?>
                    <a class="b360-primary-btn" href="<?php echo e($primaryUrl); ?>">
                        <i class="fa-solid fa-chevron-right"></i>
                        <?php echo e($dashboard['primary_label'] ?? 'Open'); ?>

                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>

    <?php if($quickActions->isNotEmpty()): ?>
        <section class="b360-quick-actions" aria-label="Quick actions">
            <?php $__currentLoopData = $quickActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $actionUrl = $dashboardUrl($action['route'] ?? null, $action['route_filter'] ?? []); ?>
                <?php if($actionUrl): ?>
                    <a href="<?php echo e($actionUrl); ?>" class="b360-quick-action">
                        <i class="fa-solid fa-arrow-right"></i>
                        <?php echo e($action['label'] ?? 'Open'); ?>

                    </a>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </section>
    <?php endif; ?>

    <section class="b360-stat-grid" aria-label="Dashboard metrics">
        <?php $__empty_1 = true; $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $statUrl = ! empty($stat['is_actionable']) ? $dashboardUrl($stat['route'] ?? null, $stat['route_filter'] ?? []) : null; ?>
            <?php if($statUrl): ?>
                <a class="b360-stat-card" href="<?php echo e($statUrl); ?>">
            <?php else: ?>
                <article class="b360-stat-card">
            <?php endif; ?>
                    <span class="b360-card-icon <?php echo e($stat['tone'] ?? 'b-blue'); ?>">
                        <i class="fa-solid fa-chart-simple"></i>
                    </span>
                    <span class="b360-stat-label"><?php echo e($stat['label'] ?? 'Metric'); ?></span>
                    <strong><?php echo e($stat['value'] ?? '—'); ?></strong>
                    <small><?php echo e($stat['sub'] ?? ''); ?></small>
            <?php if($statUrl): ?>
                </a>
            <?php else: ?>
                </article>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <article class="b360-empty">No dashboard metrics are available for this role.</article>
        <?php endif; ?>
    </section>

    <section class="b360-dashboard-grid">
        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="b360-panel">
                <header class="b360-panel-head">
                    <div>
                        <h2><?php echo e($section['title'] ?? 'Records'); ?></h2>
                        <p><?php echo e($section['sub'] ?? ''); ?></p>
                    </div>
                    <?php $sectionUrl = $dashboardUrl($section['route'] ?? null, $section['route_filter'] ?? []); ?>
                    <?php if($sectionUrl): ?>
                        <a href="<?php echo e($sectionUrl); ?>">View all <i class="fa-solid fa-chevron-right"></i></a>
                    <?php endif; ?>
                </header>

                <div class="b360-row-list">
                    <?php $__empty_1 = true; $__currentLoopData = ($section['rows'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php $rowUrl = ! empty($row['is_actionable']) ? $dashboardUrl($row['route'] ?? null, $row['route_filter'] ?? []) : null; ?>
                        <?php if($rowUrl): ?>
                            <a class="b360-data-row" href="<?php echo e($rowUrl); ?>">
                        <?php else: ?>
                            <div class="b360-data-row">
                        <?php endif; ?>
                                <span>
                                    <strong><?php echo e($row['label'] ?? 'Record'); ?></strong>
                                    <small><?php echo e($row['sub'] ?? ''); ?></small>
                                </span>
                                <em><?php echo e($row['value'] ?? ''); ?></em>
                        <?php if($rowUrl): ?>
                            </a>
                        <?php else: ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="b360-empty"><?php echo e($section['empty'] ?? 'No records are available for your selected view.'); ?></div>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if($alerts->isNotEmpty()): ?>
            <article class="b360-panel">
                <header class="b360-panel-head">
                    <div>
                        <h2>Alerts</h2>
                        <p>Items that may need attention.</p>
                    </div>
                </header>
                <div class="b360-row-list">
                    <?php $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="b360-data-row">
                            <span>
                                <strong><?php echo e($alert['label'] ?? 'Alert'); ?></strong>
                                <small><?php echo e($alert['sub'] ?? ''); ?></small>
                            </span>
                            <em><?php echo e($alert['value'] ?? ''); ?></em>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </article>
        <?php endif; ?>
    </section>

    <?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <section class="b360-panel b360-table-panel">
            <header class="b360-panel-head">
                <div>
                    <h2><?php echo e($table['title'] ?? 'Table'); ?></h2>
                    <p><?php echo e($table['sub'] ?? ''); ?></p>
                </div>
            </header>

            <div class="table-responsive">
                <table class="table b360-table align-middle">
                    <thead>
                        <tr>
                            <?php $__currentLoopData = ($table['columns'] ?? ['Item', 'Details', 'Value']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e($column); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = ($table['rows'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($row['label'] ?? 'Record'); ?></strong>
                                </td>
                                <td><?php echo e($row['sub'] ?? ''); ?></td>
                                <td><?php echo e($row['value'] ?? ''); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="<?php echo e(count($table['columns'] ?? ['Item', 'Details', 'Value'])); ?>"><?php echo e($table['empty'] ?? 'No records are available for your selected view.'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/developer/public_html/builder360/resources/views/builder360/classic/dashboard.blade.php ENDPATH**/ ?>