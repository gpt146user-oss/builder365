<?php $__env->startSection('title', 'HR Command Center - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $summary = $dashboard['summary'] ?? [];
    $approvalInbox = $dashboard['approvalInbox'] ?? [];
    $departmentHeadcount = $dashboard['departmentHeadcount'] ?? [];
    $lifecycleDue = $dashboard['lifecycleDue'] ?? [];
    $complianceRisk = $dashboard['complianceRisk'] ?? [];
    $abilities = $dashboard['abilities'] ?? [];
    // Presentation fails closed if the read-model contract is ever incomplete.
    // The command-center Action remains the authority that supplies these flags.
    $canViewAttendance = (bool) ($abilities['canViewAttendance'] ?? false);
    $canViewPayroll = (bool) ($abilities['canViewPayroll'] ?? false);
    $canViewRecruitment = (bool) ($abilities['canViewRecruitment'] ?? false);
    $canViewCompliance = (bool) ($abilities['canViewCompliance'] ?? false);
    $canViewLifecycle = (bool) (($abilities['canViewConfirmations'] ?? false) || ($abilities['canViewSettlements'] ?? false));
?>

<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'HR Command Center','description' => 'Company-scoped workforce operations, approvals, lifecycle work, and compliance signals.','active' => 'dashboard'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a class="people-button" href="<?php echo e(route('hr.employees.index')); ?>">
            <i class="fa-solid fa-address-card" aria-hidden="true"></i> Employee Master
        </a>
     <?php $__env->endSlot(); ?>

    <?php if(session('status')): ?>
        <section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section>
    <?php endif; ?>

    <section class="people-command-kpis" aria-label="HR command summary">
        <article class="people-command-kpi is-accent">
            <span class="people-command-kpi-icon"><i class="fa-solid fa-user-group" aria-hidden="true"></i></span>
            <div><span>Total Employees</span><strong><?php echo e(number_format((int) ($summary['total_headcount'] ?? 0))); ?></strong><small><?php echo e(number_format((int) ($summary['active_headcount'] ?? 0))); ?> active</small></div>
        </article>

        <article class="people-command-kpi is-info">
            <span class="people-command-kpi-icon"><i class="fa-solid fa-calendar-check" aria-hidden="true"></i></span>
            <div>
                <span>Attendance Today</span>
                <?php if($canViewAttendance && ($summary['attendance_today_percent'] ?? null) !== null): ?>
                    <strong><?php echo e(number_format((float) $summary['attendance_today_percent'], 1)); ?>%</strong>
                    <small><?php echo e(number_format((int) ($summary['attendance_present_today'] ?? 0))); ?> of <?php echo e(number_format((int) ($summary['attendance_marked_today'] ?? 0))); ?> marked records</small>
                <?php elseif($canViewAttendance): ?>
                    <strong>-</strong><small>No attendance marked today</small>
                <?php else: ?>
                    <strong class="people-restricted-value"><i class="fa-solid fa-lock" aria-hidden="true"></i></strong><small>Restricted for this role</small>
                <?php endif; ?>
            </div>
        </article>

        <article class="people-command-kpi is-success">
            <span class="people-command-kpi-icon"><i class="fa-solid fa-money-check-dollar" aria-hidden="true"></i></span>
            <div>
                <span>Latest Payroll</span>
                <?php if($canViewPayroll && array_key_exists('latest_payroll_net_payable', $summary)): ?>
                    <strong><?php echo e($summary['latest_payroll_net_payable'] !== null ? 'INR '.number_format((float) $summary['latest_payroll_net_payable'], 2) : '-'); ?></strong>
                    <small><?php echo e($summary['latest_payroll_label'] ?? 'No approved payroll run'); ?></small>
                <?php else: ?>
                    <strong class="people-restricted-value"><i class="fa-solid fa-lock" aria-hidden="true"></i></strong><small>Restricted for this role</small>
                <?php endif; ?>
            </div>
        </article>

        <article class="people-command-kpi is-warning">
            <span class="people-command-kpi-icon"><i class="fa-solid fa-list-check" aria-hidden="true"></i></span>
            <div><span>Pending Approvals</span><strong><?php echo e(number_format((int) ($summary['pending_approvals'] ?? 0))); ?></strong><small>Items visible to your role</small></div>
        </article>

        <article class="people-command-kpi is-purple">
            <span class="people-command-kpi-icon"><i class="fa-solid fa-briefcase" aria-hidden="true"></i></span>
            <div>
                <span>Open Positions</span>
                <?php if($canViewRecruitment): ?>
                    <strong><?php echo e(number_format((int) ($summary['open_positions'] ?? 0))); ?></strong><small>Authorized active job openings</small>
                <?php else: ?>
                    <strong class="people-restricted-value"><i class="fa-solid fa-lock" aria-hidden="true"></i></strong><small>Restricted for this role</small>
                <?php endif; ?>
            </div>
        </article>

        <article class="people-command-kpi is-danger">
            <span class="people-command-kpi-icon"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i></span>
            <div>
                <span>Compliance Alerts</span>
                <?php if($canViewCompliance): ?>
                    <strong><?php echo e(number_format((int) ($summary['compliance_alerts'] ?? 0))); ?></strong><small>Required active-setting exceptions</small>
                <?php else: ?>
                    <strong class="people-restricted-value"><i class="fa-solid fa-lock" aria-hidden="true"></i></strong><small>Restricted for this role</small>
                <?php endif; ?>
            </div>
        </article>
    </section>

    <section class="people-command-layout">
        <article class="people-command-panel is-approvals" aria-labelledby="approval-inbox-title">
            <header class="people-command-panel-head">
                <div><span class="people-panel-icon is-warning"><i class="fa-solid fa-list-check" aria-hidden="true"></i></span><div><h2 id="approval-inbox-title">Approval Inbox</h2><p>Open HR decisions available to your role.</p></div></div>
                <span class="people-count"><?php echo e(number_format(count($approvalInbox))); ?></span>
            </header>
            <?php $__empty_1 = true; $__currentLoopData = $approvalInbox; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php $itemUrl = $item['url'] ?? null; ?>
                <?php if($itemUrl): ?>
                    <a href="<?php echo e($itemUrl); ?>" class="people-command-row">
                <?php else: ?>
                    <div class="people-command-row">
                <?php endif; ?>
                    <span class="people-command-row-icon"><i class="fa-solid <?php echo e($item['icon'] ?? 'fa-inbox'); ?>" aria-hidden="true"></i></span>
                    <span class="people-command-row-copy">
                        <strong><?php echo e($item['subject'] ?? $item['title'] ?? $item['reference'] ?? 'Approval item'); ?></strong>
                        <small><?php echo e($item['type'] ?? 'HR'); ?><?php if(filled($item['owner'] ?? null)): ?> &middot; <?php echo e($item['owner']); ?><?php endif; ?></small>
                    </span>
                    <span class="people-command-row-meta"><span class="people-status is-warning"><?php echo e(str_replace('_', ' ', ucfirst($item['status'] ?? 'pending'))); ?></span><small><?php echo e($item['relative_time'] ?? $item['age'] ?? ''); ?></small></span>
                <?php if($itemUrl): ?>
                    </a>
                <?php else: ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php if (isset($component)) { $__componentOriginal3abc64969eeeba849011f1a920d3a3ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.people-state','data' => ['title' => 'No pending approvals','message' => 'New items that require your decision will appear here.','icon' => 'fa-circle-check']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No pending approvals','message' => 'New items that require your decision will appear here.','icon' => 'fa-circle-check']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $attributes = $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $component = $__componentOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?>
            <?php endif; ?>
        </article>

        <article class="people-command-panel" aria-labelledby="department-headcount-title">
            <header class="people-command-panel-head">
                <div><span class="people-panel-icon"><i class="fa-solid fa-chart-column" aria-hidden="true"></i></span><div><h2 id="department-headcount-title">Department Headcount</h2><p>Active workforce distribution.</p></div></div>
            </header>
            <div class="people-headcount-list">
                <?php $__empty_1 = true; $__currentLoopData = $departmentHeadcount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="people-headcount-row">
                        <div><strong><?php echo e($row['department'] ?? 'Unassigned'); ?></strong><span><?php echo e(number_format((int) ($row['employees'] ?? 0))); ?> employees</span></div>
                        <progress value="<?php echo e((int) ($row['employees'] ?? 0)); ?>" max="<?php echo e(max(1, (int) ($summary['total_headcount'] ?? 1))); ?>" aria-label="<?php echo e($row['department'] ?? 'Unassigned'); ?> headcount"></progress>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php if (isset($component)) { $__componentOriginal3abc64969eeeba849011f1a920d3a3ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.people-state','data' => ['title' => 'No department records','message' => 'Department distribution will appear when employees are available.','icon' => 'fa-users-slash']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No department records','message' => 'Department distribution will appear when employees are available.','icon' => 'fa-users-slash']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $attributes = $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $component = $__componentOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?>
                <?php endif; ?>
            </div>
        </article>

        <article class="people-command-panel" aria-labelledby="lifecycle-due-title">
            <header class="people-command-panel-head">
                <div><span class="people-panel-icon is-purple"><i class="fa-solid fa-arrows-spin" aria-hidden="true"></i></span><div><h2 id="lifecycle-due-title">Lifecycle Due</h2><p>Confirmation and separation work requiring attention.</p></div></div>
            </header>
            <?php if(! $canViewLifecycle): ?>
                <?php if (isset($component)) { $__componentOriginal3abc64969eeeba849011f1a920d3a3ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.people-state','data' => ['type' => 'restricted','title' => 'Lifecycle data is restricted','message' => 'Your current role cannot view these records.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'restricted','title' => 'Lifecycle data is restricted','message' => 'Your current role cannot view these records.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $attributes = $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $component = $__componentOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?>
            <?php else: ?>
                <?php $__empty_1 = true; $__currentLoopData = $lifecycleDue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php $itemUrl = $item['url'] ?? null; ?>
                    <?php if($itemUrl): ?>
                        <a href="<?php echo e($itemUrl); ?>" class="people-command-row is-compact">
                    <?php else: ?>
                        <div class="people-command-row is-compact">
                    <?php endif; ?>
                        <span class="people-command-row-icon"><i class="fa-solid <?php echo e($item['icon'] ?? 'fa-user-clock'); ?>" aria-hidden="true"></i></span>
                        <span class="people-command-row-copy"><strong><?php echo e($item['employee'] ?? 'Employee'); ?></strong><small><?php echo e($item['event'] ?? 'Lifecycle event'); ?><?php if(filled($item['owner'] ?? null)): ?> &middot; <?php echo e($item['owner']); ?><?php endif; ?></small></span>
                        <span class="people-command-row-meta"><strong><?php echo e($item['due_label'] ?? $item['due'] ?? 'No due date'); ?></strong><small><?php echo e(str_replace('_', ' ', ucfirst($item['status'] ?? 'open'))); ?></small></span>
                    <?php if($itemUrl): ?>
                        </a>
                    <?php else: ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php if (isset($component)) { $__componentOriginal3abc64969eeeba849011f1a920d3a3ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.people-state','data' => ['title' => 'No lifecycle work due','message' => 'Upcoming confirmation and separation items will appear here.','icon' => 'fa-calendar-check']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No lifecycle work due','message' => 'Upcoming confirmation and separation items will appear here.','icon' => 'fa-calendar-check']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $attributes = $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $component = $__componentOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </article>

        <article class="people-command-panel" aria-labelledby="compliance-risk-title">
            <header class="people-command-panel-head">
                <div><span class="people-panel-icon is-danger"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i></span><div><h2 id="compliance-risk-title">Compliance &amp; Risk</h2><p>Configuration health, not statutory calculation advice.</p></div></div>
            </header>
            <?php if(! $canViewCompliance): ?>
                <?php if (isset($component)) { $__componentOriginal3abc64969eeeba849011f1a920d3a3ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.people-state','data' => ['type' => 'restricted','title' => 'Compliance data is restricted','message' => 'Your current role cannot view these records.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'restricted','title' => 'Compliance data is restricted','message' => 'Your current role cannot view these records.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $attributes = $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $component = $__componentOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?>
            <?php else: ?>
                <?php $__empty_1 = true; $__currentLoopData = $complianceRisk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $riskTone = in_array(($item['tone'] ?? ''), ['success', 'warning', 'danger', 'info'], true) ? $item['tone'] : (($item['verification'] ?? '') === 'active' ? 'success' : 'danger');
                    ?>
                    <div class="people-command-row is-compact">
                        <span class="people-command-row-icon is-<?php echo e($riskTone); ?>"><i class="fa-solid <?php echo e($riskTone === 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation'); ?>" aria-hidden="true"></i></span>
                        <span class="people-command-row-copy"><strong><?php echo e($item['name'] ?? $item['key'] ?? 'Configuration item'); ?></strong><small><?php echo e($item['company'] ?? 'Company'); ?><?php if(filled($item['effective'] ?? null)): ?> &middot; <?php echo e($item['effective']); ?><?php endif; ?></small></span>
                        <span class="people-command-row-meta"><span class="people-status is-<?php echo e($riskTone); ?>"><?php echo e(str_replace('_', ' ', ucfirst($item['verification'] ?? 'review'))); ?></span><small><?php echo e($item['version'] ?? ''); ?></small></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php if (isset($component)) { $__componentOriginal3abc64969eeeba849011f1a920d3a3ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.people-state','data' => ['title' => 'No compliance exceptions','message' => 'No missing active HR settings were found for your company scope.','icon' => 'fa-shield-circle-check']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No compliance exceptions','message' => 'No missing active HR settings were found for your company scope.','icon' => 'fa-shield-circle-check']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $attributes = $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $component = $__componentOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </article>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9)): ?>
<?php $attributes = $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9; ?>
<?php unset($__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9)): ?>
<?php $component = $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9; ?>
<?php unset($__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\dashboard\index.blade.php ENDPATH**/ ?>