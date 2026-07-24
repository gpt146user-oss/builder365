<?php $__env->startSection('title', 'Employee Lifecycle - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Employee Lifecycle','description' => 'Track persisted employee movements, confirmation, separation, and exit interview milestones in your authorized scope.','active' => 'lifecycle'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php echo $__env->make('hr.lifecycle.partials.navigation', ['activeLifecycleSection' => 'tracker'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <section class="people-ops-kpis" aria-label="Employee Lifecycle summary">
        <article class="people-ops-kpi is-info"><span class="people-ops-kpi-icon"><i class="fa-solid fa-route" aria-hidden="true"></i></span><span>Lifecycle events</span><strong><?php echo e($lifecycleSummary->totalEvents); ?></strong><small>Persisted events in the selected scope</small></article>
        <article class="people-ops-kpi is-purple"><span class="people-ops-kpi-icon"><i class="fa-solid fa-arrows-left-right" aria-hidden="true"></i></span><span>Pending movements</span><strong><?php echo e($lifecycleSummary->pendingMovements); ?></strong><small>Awaiting an authorized decision</small></article>
        <article class="people-ops-kpi is-warning"><span class="people-ops-kpi-icon"><i class="fa-solid fa-user-clock" aria-hidden="true"></i></span><span>Open confirmations</span><strong><?php echo e($lifecycleSummary->openConfirmations); ?></strong><small>Not confirmed or rejected</small></article>
        <article class="people-ops-kpi is-danger"><span class="people-ops-kpi-icon"><i class="fa-solid fa-person-walking-arrow-right" aria-hidden="true"></i></span><span>Open settlements</span><strong><?php echo e($lifecycleSummary->openSeparations); ?></strong><small>Full &amp; Final is not completed</small></article>
        <article class="people-ops-kpi is-success"><span class="people-ops-kpi-icon"><i class="fa-regular fa-comments" aria-hidden="true"></i></span><span>Open exit interviews</span><strong><?php echo e($lifecycleSummary->openExitInterviews); ?></strong><small>Scheduled or submitted interviews</small></article>
    </section>

    <section class="people-ops-panel" aria-labelledby="lifecycle-tracker-heading">
        <header class="people-ops-panel-head">
            <div><h2 id="lifecycle-tracker-heading">Lifecycle tracker</h2><p>Every row is derived from an existing authorized HR record.</p></div>
        </header>
        <div class="people-ops-panel-body">
            <form method="GET" action="<?php echo e(route('hr.lifecycle.index')); ?>" class="people-ops-filterbar" aria-label="Filter lifecycle events">
                <label class="people-field"><span>Stage</span><select class="people-control" name="stage">
                    <?php $__currentLoopData = ['all' => 'All stages', 'movements' => 'Movements', 'confirmation' => 'Confirmation', 'separation' => 'Full & Final', 'exit' => 'Exit interviews']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>" <?php if(($filters['stage'] ?? 'all') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select></label>
                <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id"><option value="">All employees</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee['id']); ?>" <?php if((string)($filters['employee_id'] ?? '') === (string)$employee['id']): echo 'selected'; endif; ?>><?php echo e($employee['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Department</span><select class="people-control" name="department"><option value="">All departments</option><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($department); ?>" <?php if(($filters['department'] ?? '') === $department): echo 'selected'; endif; ?>><?php echo e($department); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <button class="people-button is-primary" type="submit"><i class="fa-solid fa-filter" aria-hidden="true"></i> Apply</button>
                <a class="people-button" href="<?php echo e(route('hr.lifecycle.index')); ?>">Clear all</a>
            </form>

            <?php if($lifecycleEvents->isEmpty()): ?>
                <div class="people-ops-empty" role="status"><i class="fa-solid fa-route" aria-hidden="true"></i><strong>No lifecycle events found</strong><span>Change the filters or create records through the authorized lifecycle workflows.</span></div>
            <?php else: ?>
                <div class="people-ops-table-wrap">
                    <table class="people-ops-table">
                        <caption class="sr-only">Authorized employee lifecycle events</caption>
                        <thead><tr><th scope="col">Employee</th><th scope="col">Milestone</th><th scope="col">Reference</th><th scope="col">Date</th><th scope="col">Status</th><th scope="col">Action</th></tr></thead>
                        <tbody>
                        <?php $__currentLoopData = $lifecycleEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><span class="people-ops-identity"><strong><?php echo e($event->employeeName); ?></strong><small><?php echo e($event->employeeCode); ?> · <?php echo e($event->designation); ?> · <?php echo e($event->department); ?></small></span></td>
                                <td><?php echo e($event->eventTypeLabel); ?></td>
                                <td><?php echo e($event->number); ?></td>
                                <td><time datetime="<?php echo e($event->eventDate); ?>"><?php echo e($event->eventDateLabel); ?></time></td>
                                <td><span class="people-status is-<?php echo e($event->statusTone); ?>"><?php echo e($event->statusLabel); ?></span></td>
                                <td><a class="people-ops-action-link" href="<?php echo e($event->url); ?>" aria-label="Open <?php echo e($event->eventTypeLabel); ?> for <?php echo e($event->employeeName); ?>">Open <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="people-ops-mobile-list" aria-label="Employee lifecycle event cards">
                    <?php $__currentLoopData = $lifecycleEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="people-ops-mobile-card">
                            <header class="people-ops-mobile-card-head"><span class="people-ops-identity"><strong><?php echo e($event->employeeName); ?></strong><small><?php echo e($event->employeeCode); ?> · <?php echo e($event->department); ?></small></span><span class="people-status is-<?php echo e($event->statusTone); ?>"><?php echo e($event->statusLabel); ?></span></header>
                            <dl class="people-ops-mobile-facts"><div><dt>Milestone</dt><dd><?php echo e($event->eventTypeLabel); ?></dd></div><div><dt>Reference</dt><dd><?php echo e($event->number); ?></dd></div><div><dt>Date</dt><dd><?php echo e($event->eventDateLabel); ?></dd></div></dl>
                            <a class="people-ops-action-link" href="<?php echo e($event->url); ?>">Open workflow <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <?php echo e($lifecycleEvents->links()); ?>

            <?php endif; ?>
        </div>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\lifecycle\index.blade.php ENDPATH**/ ?>