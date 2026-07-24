<?php $__env->startSection('title', 'Employee Self Service - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $summary = $selfService['summary'] ?? [];
    $recentAttendance = $selfService['recentAttendance'] ?? [];
    $myActions = $selfService['myActions'] ?? [];
    $quickActions = $selfService['quickActions'] ?? [];
    $leaveBalances = $selfService['leaveBalances'] ?? [];
    $abilities = $selfService['abilities'] ?? [];
?>

<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Employee Self Service','description' => 'Welcome back, '.$employee->name.'. Your attendance, leave, payroll, and HR actions in one place.','eyebrow' => 'My workplace','active' => 'employees','selfService' => true] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a class="people-button" href="<?php echo e(route('hr.employees.me.tax-inputs.edit')); ?>"><i class="fa-solid fa-file-invoice" aria-hidden="true"></i> Tax declarations</a>
        <a class="people-button" href="<?php echo e(route('hr.employees.me.profile')); ?>"><i class="fa-solid fa-id-card" aria-hidden="true"></i> View my profile</a>
     <?php $__env->endSlot(); ?>

    <?php if(session('status')): ?>
        <section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section>
    <?php endif; ?>

    <section class="people-ess-hero" aria-labelledby="ess-employee-name">
        <?php if (isset($component)) { $__componentOriginal2252ef3298868bc9de4c534a2a83a2a2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.user-avatar','data' => ['user' => $employee->user,'label' => $employee->name,'class' => 'people-ess-avatar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.user-avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($employee->user),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($employee->name),'class' => 'people-ess-avatar']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2)): ?>
<?php $attributes = $__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2; ?>
<?php unset($__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2252ef3298868bc9de4c534a2a83a2a2)): ?>
<?php $component = $__componentOriginal2252ef3298868bc9de4c534a2a83a2a2; ?>
<?php unset($__componentOriginal2252ef3298868bc9de4c534a2a83a2a2); ?>
<?php endif; ?>
        <div class="people-ess-identity">
            <span>Employee dashboard</span>
            <h2 id="ess-employee-name"><?php echo e($employee->name); ?></h2>
            <p><?php echo e($employee->employee_code); ?> &middot; <?php echo e($employee->designation); ?> &middot; <?php echo e($employee->department); ?></p>
        </div>
        <span class="people-status is-<?php echo e(['active' => 'success', 'probation' => 'warning', 'on_notice' => 'warning', 'separated' => 'danger'][$employee->status] ?? 'muted'); ?>"><?php echo e(str_replace('_', ' ', ucfirst($employee->status))); ?></span>
    </section>

    <section class="people-ess-kpis" aria-label="My employment summary">
        <article class="people-ess-kpi is-info">
            <span class="people-command-kpi-icon"><i class="fa-solid fa-calendar-check" aria-hidden="true"></i></span>
            <div><span>Attendance</span><strong><?php echo e(($summary['attendance_percent'] ?? null) !== null ? number_format((float) $summary['attendance_percent'], 1).'%' : '-'); ?></strong><small><?php echo e((int) ($summary['attendance_marked_days'] ?? 0) > 0 ? number_format((int) ($summary['attendance_present_days'] ?? 0)).' of '.number_format((int) $summary['attendance_marked_days']).' recorded days' : 'No records this month'); ?></small></div>
        </article>
        <article class="people-ess-kpi is-success">
            <span class="people-command-kpi-icon"><i class="fa-solid fa-plane-departure" aria-hidden="true"></i></span>
            <div><span>Leave Available</span><strong><?php echo e(number_format((float) ($summary['leave_available_days'] ?? 0), 2)); ?></strong><small>Days across active leave types</small></div>
        </article>
        <article class="people-ess-kpi is-purple">
            <span class="people-command-kpi-icon"><i class="fa-solid fa-file-invoice-dollar" aria-hidden="true"></i></span>
            <div><span>Latest Payslip</span><strong><?php echo e($summary['latest_payslip_period'] ?? '-'); ?></strong><small><?php echo e($summary['latest_payslip_status'] ?? 'No approved payroll'); ?></small></div>
        </article>
        <article class="people-ess-kpi is-warning">
            <span class="people-command-kpi-icon"><i class="fa-solid fa-inbox" aria-hidden="true"></i></span>
            <div><span>Open Requests</span><strong><?php echo e(number_format((int) ($summary['open_requests'] ?? 0))); ?></strong><small>Items awaiting completion</small></div>
        </article>
    </section>

    <section class="people-ess-section" aria-labelledby="quick-actions-title">
        <header class="people-ess-section-head"><div><h2 id="quick-actions-title">Quick Actions</h2><p>Start an authorized self-service request.</p></div></header>
        <?php if($quickActions !== []): ?>
            <div class="people-ess-quick-actions">
                <?php $__currentLoopData = $quickActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(blank($action['url'] ?? null)) continue; ?>
                    <a href="<?php echo e($action['url']); ?>">
                        <span><i class="fa-solid <?php echo e($action['icon'] ?? 'fa-arrow-up-right-from-square'); ?>" aria-hidden="true"></i></span>
                        <strong><?php echo e($action['label'] ?? 'Open workspace'); ?></strong>
                        <small><?php echo e($action['description'] ?? 'Continue in Builder360'); ?></small>
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <?php if (isset($component)) { $__componentOriginal3abc64969eeeba849011f1a920d3a3ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.people-state','data' => ['type' => 'restricted','title' => 'No self-service actions available','message' => 'Your current role has no request actions enabled.','compact' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'restricted','title' => 'No self-service actions available','message' => 'Your current role has no request actions enabled.','compact' => true]); ?>
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
    </section>

    <section class="people-ess-grid">
        <article class="people-ess-section" aria-labelledby="my-attendance-title">
            <header class="people-ess-section-head"><div><h2 id="my-attendance-title">My Attendance</h2><p>Your most recent recorded attendance days.</p></div><?php if(($abilities['canViewAttendanceRegularizations'] ?? false)): ?><a href="<?php echo e(route('hr.attendance-records.index')); ?>">View attendance <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a><?php endif; ?></header>
            <?php if($recentAttendance !== []): ?>
                <div class="people-attendance-strip" role="list" aria-label="Recent attendance">
                    <?php $__currentLoopData = $recentAttendance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $attendanceTone = in_array(($record['tone'] ?? ''), ['success', 'warning', 'danger', 'info', 'muted'], true)
                                ? $record['tone']
                                : match ($record['status'] ?? '') { 'present', 'holiday', 'weekly_off' => 'success', 'late', 'half_day', 'on_leave' => 'warning', 'absent' => 'danger', default => 'muted' };
                        ?>
                        <div class="people-attendance-day is-<?php echo e($attendanceTone); ?>" role="listitem">
                            <span><?php echo e($record['day_label'] ?? $record['work_date'] ?? 'Day'); ?></span>
                            <strong><?php echo e($record['status_code'] ?? strtoupper(substr((string) ($record['status'] ?? '-'), 0, 2))); ?></strong>
                            <small><?php echo e(str_replace('_', ' ', ucfirst($record['status'] ?? 'not marked'))); ?></small>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal3abc64969eeeba849011f1a920d3a3ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.people-state','data' => ['title' => 'No attendance records yet','message' => 'Attendance entries will appear here after they are recorded for you.','icon' => 'fa-calendar-xmark']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No attendance records yet','message' => 'Attendance entries will appear here after they are recorded for you.','icon' => 'fa-calendar-xmark']); ?>
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

        <article class="people-ess-section" aria-labelledby="my-actions-title">
            <header class="people-ess-section-head"><div><h2 id="my-actions-title">My Actions</h2><p>Items that need your attention.</p></div></header>
            <?php $__empty_1 = true; $__currentLoopData = $myActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php $actionUrl = $action['url'] ?? null; ?>
                <?php if($actionUrl): ?>
                    <a href="<?php echo e($actionUrl); ?>" class="people-ess-action-row">
                <?php else: ?>
                    <div class="people-ess-action-row">
                <?php endif; ?>
                    <span class="people-command-row-icon"><i class="fa-solid <?php echo e($action['icon'] ?? 'fa-circle-exclamation'); ?>" aria-hidden="true"></i></span>
                    <span><strong><?php echo e($action['title'] ?? $action['label'] ?? 'Action required'); ?></strong><small><?php echo e($action['description'] ?? $action['meta'] ?? ''); ?></small></span>
                    <?php if(filled($action['status'] ?? null)): ?><span class="people-status is-<?php echo e(in_array(($action['tone'] ?? ''), ['success', 'warning', 'danger', 'info'], true) ? $action['tone'] : 'warning'); ?>"><?php echo e(str_replace('_', ' ', ucfirst($action['status']))); ?></span><?php elseif($actionUrl): ?><i class="fa-solid fa-chevron-right" aria-hidden="true"></i><?php endif; ?>
                <?php if($actionUrl): ?>
                    </a>
                <?php else: ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php if (isset($component)) { $__componentOriginal3abc64969eeeba849011f1a920d3a3ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.people-state','data' => ['title' => 'No pending actions','message' => 'You have no employee actions waiting for attention.','icon' => 'fa-circle-check']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No pending actions','message' => 'You have no employee actions waiting for attention.','icon' => 'fa-circle-check']); ?>
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

        <article class="people-ess-section is-wide" aria-labelledby="leave-balances-title">
            <header class="people-ess-section-head"><div><h2 id="leave-balances-title">Leave Balances</h2><p>Current-year availability from your authorized leave ledger.</p></div><?php if(($abilities['canViewLeaveRequests'] ?? false)): ?><a href="<?php echo e(route('hr.leave-balances.index')); ?>">View balances <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a><?php endif; ?></header>
            <?php if($leaveBalances !== []): ?>
                <div class="people-leave-balance-grid">
                    <?php $__currentLoopData = $leaveBalances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $balance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article><span><?php echo e($balance['code'] ?? 'Leave'); ?></span><strong><?php echo e(number_format((float) ($balance['available_days'] ?? 0), 2)); ?></strong><small><?php echo e($balance['name'] ?? 'Available days'); ?><?php if((float) ($balance['pending_days'] ?? 0) > 0): ?> &middot; <?php echo e(number_format((float) $balance['pending_days'], 2)); ?> pending <?php endif; ?></small></article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal3abc64969eeeba849011f1a920d3a3ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.people-state','data' => ['title' => 'No leave balances available','message' => 'Balances will appear after a leave ledger is available for the current year.','icon' => 'fa-calendar-minus','compact' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No leave balances available','message' => 'Balances will appear after a leave ledger is available for the current year.','icon' => 'fa-calendar-minus','compact' => true]); ?>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\employees\self-service.blade.php ENDPATH**/ ?>