<?php
    use App\Support\Builder360ModuleNavigation;

    $summary = $approvalPayload['summary'] ?? [];
    $availableFilters = $approvalPayload['filters'] ?? [];
    $rows = collect($approvalPayload['rows'] ?? []);
    $pagination = $approvalPayload['pagination'] ?? [];
    $activeTab = $approvalFilters['tab'] ?? 'pending';
    $tabs = [
        'pending' => ['label' => 'Pending', 'count' => $summary['pending'] ?? 0],
        'high_priority' => ['label' => 'High Priority', 'count' => $summary['high_priority'] ?? 0],
        'actionable' => ['label' => 'Actionable', 'count' => $summary['actionable'] ?? 0],
        'restricted' => ['label' => 'Restricted', 'count' => $summary['restricted'] ?? 0],
        'approved' => ['label' => 'Approved', 'count' => $summary['approved'] ?? 0],
    ];
    $filterQuery = array_filter($approvalFilters, fn ($value) => $value !== null && $value !== '');
    $tabUrl = fn (string $tab): string => route('builder360.approvals.index', array_merge($filterQuery, ['tab' => $tab, 'page' => null]));
    $openUrl = function (array $row): ?string {
        $url = Builder360ModuleNavigation::urlFor($row['open_route'] ?? null, []);
        $filters = array_filter($row['open_route_filter'] ?? [], fn ($value) => $value !== null && $value !== '');

        return $url && $filters ? $url.(str_contains($url, '?') ? '&' : '?').http_build_query($filters) : $url;
    };
?>

<?php $__env->startSection('title', 'Approval Center | Builder360'); ?>

<?php $__env->startSection('content'); ?>
    <section class="b360-page-head">
        <div>
            <p class="b360-eyebrow">Overview / Approvals</p>
            <h1>Approval Center</h1>
            <p>Review approval records available to your role and selected project.</p>
        </div>
        <?php if(empty($approvalPayload['restricted'])): ?>
            <div class="b360-head-actions">
                <a class="b360-secondary-btn" href="<?php echo e(route('builder360.approvals.index', $filterQuery)); ?>">
                    <i class="fa-solid fa-rotate"></i> Refresh
                </a>
                <a class="b360-secondary-btn" href="<?php echo e(route('builder360.approvals.export', $filterQuery)); ?>">
                    <i class="fa-solid fa-download"></i> Export CSV
                </a>
            </div>
        <?php endif; ?>
    </section>

    <?php if(! empty($approvalPayload['restricted'])): ?>
        <section class="b360-panel b360-restricted-panel">
            <span class="b360-card-icon b-red"><i class="fa-solid fa-shield-halved"></i></span>
            <h2>Approval Center is not available for this role</h2>
            <p>Use the available sidebar options for your current role.</p>
            <a class="b360-primary-btn" href="<?php echo e(route('builder360.dashboard')); ?>">Return to Dashboard</a>
        </section>
    <?php else: ?>
        <section class="b360-stat-grid b360-approval-stat-grid" aria-label="Approval metrics">
            <?php $__currentLoopData = [
                ['tab' => 'pending', 'label' => 'Pending', 'value' => $summary['pending'] ?? 0, 'sub' => 'records awaiting decision', 'tone' => 'b-orange', 'icon' => 'fa-clock'],
                ['tab' => 'high_priority', 'label' => 'High Priority', 'value' => $summary['high_priority'] ?? 0, 'sub' => 'urgent approval records', 'tone' => 'b-red', 'icon' => 'fa-fire'],
                ['tab' => 'actionable', 'label' => 'Actionable', 'value' => $summary['actionable'] ?? 0, 'sub' => 'available actions for this role', 'tone' => 'b-green', 'icon' => 'fa-check'],
                ['tab' => 'approved', 'label' => 'Approved', 'value' => $summary['approved'] ?? 0, 'sub' => 'recently approved records', 'tone' => 'b-blue', 'icon' => 'fa-box-archive'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metric): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($tabUrl($metric['tab'])); ?>" class="b360-stat-card <?php echo e($activeTab === $metric['tab'] ? 'is-selected' : ''); ?>">
                    <span class="b360-card-icon <?php echo e($metric['tone']); ?>"><i class="fa-solid <?php echo e($metric['icon']); ?>"></i></span>
                    <span class="b360-stat-label"><?php echo e($metric['label']); ?></span>
                    <strong><?php echo e(number_format((int) $metric['value'])); ?></strong>
                    <small><?php echo e($metric['sub']); ?></small>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </section>

        <section class="b360-panel b360-filter-panel">
            <form method="GET" action="<?php echo e(route('builder360.approvals.index')); ?>" class="b360-filter-grid">
                <input type="hidden" name="tab" value="<?php echo e($activeTab); ?>">
                <label class="b360-search-field">
                    <span>Search</span>
                    <span class="b360-input-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="search" name="q" value="<?php echo e($approvalFilters['q'] ?? ''); ?>" placeholder="Search approvals, numbers, modules, people">
                    </span>
                </label>
                <label>
                    <span>Module</span>
                    <select name="module" class="form-select">
                        <option value="">All modules</option>
                        <?php $__currentLoopData = ($availableFilters['modules'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($module); ?>" <?php if(($approvalFilters['module'] ?? null) === $module): echo 'selected'; endif; ?>><?php echo e($module); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>
                <label>
                    <span>Priority</span>
                    <select name="priority" class="form-select">
                        <option value="">All priorities</option>
                        <?php $__currentLoopData = ['high' => 'High', 'med' => 'Medium', 'low' => 'Low']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php if(($approvalFilters['priority'] ?? null) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>
                <label>
                    <span>Status</span>
                    <select name="status" class="form-select">
                        <option value="">All statuses</option>
                        <?php $__currentLoopData = ($availableFilters['statuses'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($status); ?>" <?php if(($approvalFilters['status'] ?? null) === $status): echo 'selected'; endif; ?>><?php echo e(str($status)->headline()); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>
                <div class="b360-filter-actions">
                    <button class="b360-primary-btn" type="submit"><i class="fa-solid fa-filter"></i> Apply</button>
                    <a class="b360-secondary-btn" href="<?php echo e(route('builder360.approvals.index', ['tab' => $activeTab])); ?>">Clear</a>
                </div>
            </form>
        </section>

        <nav class="b360-tabs" aria-label="Approval states">
            <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab => $definition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($tabUrl($tab)); ?>" class="b360-tab <?php echo e($activeTab === $tab ? 'is-active' : ''); ?>" <?php if($activeTab === $tab): ?> aria-current="page" <?php endif; ?>>
                    <?php echo e($definition['label']); ?>

                    <span><?php echo e(number_format((int) $definition['count'])); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>

        <section class="b360-panel b360-table-panel">
            <div class="table-responsive">
                <table class="table b360-table b360-approval-table align-middle">
                    <thead>
                        <tr>
                            <th>Request</th>
                            <th>Type</th>
                            <th>Raised By</th>
                            <th>Amount</th>
                            <th>Age</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php $recordUrl = $openUrl($row); ?>
                            <tr>
                                <td>
                                    <?php if($recordUrl): ?>
                                        <a class="b360-record-link" href="<?php echo e($recordUrl); ?>"><?php echo e($row['number'] ?? 'Approval'); ?></a>
                                    <?php else: ?>
                                        <strong><?php echo e($row['number'] ?? 'Approval'); ?></strong>
                                    <?php endif; ?>
                                    <small><?php echo e($row['description'] ?? ''); ?></small>
                                </td>
                                <td><span class="b360-badge b-blue"><?php echo e($row['type'] ?? 'Record'); ?></span><small><?php echo e($row['source_module'] ?? ''); ?></small></td>
                                <td><?php echo e($row['raised_by'] ?? '—'); ?></td>
                                <td><strong><?php echo e($row['amount_display'] ?? '—'); ?></strong></td>
                                <td><?php echo e($row['age'] ?? '—'); ?></td>
                                <td><span class="b360-badge <?php echo e(($row['priority'] ?? '') === 'high' ? 'b-red' : 'b-orange'); ?>"><?php echo e(str($row['priority'] ?? 'normal')->headline()); ?></span></td>
                                <td><span class="b360-badge b-slate"><?php echo e(str($row['status'] ?? 'pending')->headline()); ?></span></td>
                                <td>
                                    <div class="b360-row-actions justify-content-end">
                                        <?php if($recordUrl): ?>
                                            <a href="<?php echo e($recordUrl); ?>" class="b360-small-btn">Open</a>
                                        <?php endif; ?>
                                        <?php if(! empty($row['can_approve']) || ! empty($row['can_reject'])): ?>
                                            <details class="b360-decision-menu">
                                                <summary class="b360-small-btn b360-small-btn-primary">Decide</summary>
                                                <div class="b360-decision-popover">
                                                    <strong><?php echo e($row['number'] ?? 'Approval'); ?></strong>
                                                    <small><?php echo e($row['type'] ?? 'Approval record'); ?> · <?php echo e($row['amount_display'] ?? 'No amount'); ?></small>
                                                    <?php if(! empty($row['can_reject']) && ! empty($row['reject_url'])): ?>
                                                        <form method="POST" action="<?php echo e($row['reject_url']); ?>" class="b360-decision-form">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PATCH'); ?>
                                                            <label>
                                                                <span>Rejection note</span>
                                                                <input class="form-control" name="<?php echo e($row['reject_payload_key'] ?? 'note'); ?>" maxlength="500" required>
                                                            </label>
                                                            <button class="b360-danger-btn" type="submit">Reject</button>
                                                        </form>
                                                    <?php endif; ?>
                                                    <?php if(! empty($row['can_approve']) && ! empty($row['approve_url'])): ?>
                                                        <form method="POST" action="<?php echo e($row['approve_url']); ?>" class="b360-decision-form">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PATCH'); ?>
                                                            <label>
                                                                <span>Approval note</span>
                                                                <input class="form-control" name="<?php echo e($row['approve_payload_key'] ?? 'note'); ?>" maxlength="500">
                                                            </label>
                                                            <button class="b360-primary-btn" type="submit">Approve</button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </details>
                                        <?php else: ?>
                                            <span class="b360-muted">View only</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8">
                                    <div class="b360-empty">
                                        <i class="fa-solid fa-box-open"></i>
                                        <strong>No <?php echo e(str($activeTab)->replace('_', ' ')); ?> approvals</strong>
                                        <span>No approval records match the selected filters.</span>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </section>

        <?php if(($pagination['last_page'] ?? 1) > 1): ?>
            <nav class="b360-pagination" aria-label="Approval pagination">
                <?php for($page = 1; $page <= (int) $pagination['last_page']; $page++): ?>
                    <a href="<?php echo e(route('builder360.approvals.index', array_merge($filterQuery, ['page' => $page]))); ?>" class="<?php echo e((int) ($pagination['page'] ?? 1) === $page ? 'is-active' : ''); ?>"><?php echo e($page); ?></a>
                <?php endfor; ?>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\builder360\classic\approvals\index.blade.php ENDPATH**/ ?>