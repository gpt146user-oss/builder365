

<?php $__env->startSection('title', 'Audit Trail - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $writeCount = $events->getCollection()->whereIn('request_method', ['POST', 'PATCH', 'PUT', 'DELETE'])->count();
        $userCount = $events->getCollection()->pluck('user_id')->filter()->unique()->count();
        $auditableCount = $events->getCollection()->whereNotNull('auditable_type')->count();
    ?>

    <div class="blade-workspace" aria-labelledby="audit-trail-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Administration</p>
                <h1 id="audit-trail-title">Audit Trail</h1>
                <p>
                    Audit register for critical business events, actor tracking,
                    request evidence, record linkage, filterable review and CSV export.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Audit navigation">
                <a href="<?php echo e(url('/')); ?>">Dashboard</a>
                <a href="<?php echo e(route('admin.users.index')); ?>">Users</a>
                <a href="<?php echo e(route('settings.system-settings.index')); ?>">Settings</a>
                <a href="<?php echo e(route('governance.audit-events.export', $filters)); ?>">Export CSV</a>
                <a href="<?php echo e(route('governance.audit-events.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if($errors->any()): ?>
            <div class="blade-alert blade-alert-danger">
                <strong>Check the highlighted inputs.</strong>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <section class="blade-dashboard-kpis" aria-label="Audit KPIs">
            <article class="blade-dashboard-kpi">
                <span>Total Events</span>
                <strong><?php echo e(number_format($events->total())); ?></strong>
                <small>Activity register</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Write Actions</span>
                <strong><?php echo e(number_format($writeCount)); ?></strong>
                <small>Current page</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Actors</span>
                <strong><?php echo e(number_format($userCount)); ?></strong>
                <small>Current page</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Linked Records</span>
                <strong><?php echo e(number_format($auditableCount)); ?></strong>
                <small>Current page</small>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Controls</span>
                    <h2>Audit filters</h2>
                </div>
                <small><?php echo e(number_format($events->total())); ?> event(s)</small>
            </div>

            <form method="GET" action="<?php echo e(route('governance.audit-events.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                <label>
                    Event type
                    <select name="event_type">
                        <option value="">All event types</option>
                        <?php $__currentLoopData = $eventTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eventType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($eventType); ?>" <?php if(($filters['event_type'] ?? null) === $eventType): echo 'selected'; endif; ?>><?php echo e($eventType); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>
                <label>
                    Actor
                    <select name="user_id">
                        <option value="">All users</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($actor->id); ?>" <?php if(($filters['user_id'] ?? null) == $actor->id): echo 'selected'; endif; ?>><?php echo e($actor->name); ?> · <?php echo e($actor->email); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>
                <label>
                    Auditable type
                    <select name="auditable_type">
                        <option value="">All record types</option>
                        <?php $__currentLoopData = $auditableTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auditableType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($auditableType); ?>" <?php if(($filters['auditable_type'] ?? null) === $auditableType): echo 'selected'; endif; ?>><?php echo e(class_basename($auditableType)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>
                <label>
                    Auditable ID
                    <input type="number" name="auditable_id" min="1" value="<?php echo e($filters['auditable_id'] ?? ''); ?>">
                </label>
                <label>
                    Method
                    <select name="request_method">
                        <option value="">All methods</option>
                        <?php $__currentLoopData = $requestMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php if(strtoupper($filters['request_method'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>
                <label>
                    Request ID
                    <input type="text" name="request_id" value="<?php echo e($filters['request_id'] ?? ''); ?>" maxlength="120">
                </label>
                <label>
                    From
                    <input type="date" name="date_from" value="<?php echo e($filters['date_from'] ?? ''); ?>">
                </label>
                <label>
                    To
                    <input type="date" name="date_to" value="<?php echo e($filters['date_to'] ?? ''); ?>">
                </label>
                <label>
                    Search
                    <input type="search" name="search" value="<?php echo e($filters['search'] ?? ''); ?>" maxlength="120" placeholder="Event or action">
                </label>
                <button type="submit" class="blade-secondary-action">Apply filters</button>
            </form>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Evidence</span>
                    <h2>Audit event register</h2>
                </div>
                <small><?php echo e($events->firstItem() ?? 0); ?>-<?php echo e($events->lastItem() ?? 0); ?> of <?php echo e($events->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Event</th>
                            <th scope="col">Actor</th>
                            <th scope="col">Record</th>
                            <th scope="col">Request</th>
                            <th scope="col">Metadata</th>
                            <th scope="col">When</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($event->event_type); ?></strong>
                                    <span><?php echo e($event->action); ?></span>
                                </td>
                                <td>
                                    <span><?php echo e($event->user?->name ?? 'System'); ?></span>
                                    <small><?php echo e($event->user?->email); ?></small>
                                    <small><?php echo e($event->user?->role?->slug); ?></small>
                                </td>
                                <td>
                                    <?php if($event->auditable_type): ?>
                                        <span><?php echo e(class_basename($event->auditable_type)); ?> #<?php echo e($event->auditable_id); ?></span>
                                        <small><?php echo e($event->auditable_type); ?></small>
                                    <?php else: ?>
                                        <span class="blade-muted">No record link</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span><?php echo e($event->request_method ?? 'N/A'); ?> <?php echo e($event->request_path); ?></span>
                                    <small><?php echo e($event->request_id); ?></small>
                                    <small><?php echo e($event->ip_address); ?></small>
                                </td>
                                <td>
                                    <small><?php echo e(\Illuminate\Support\Str::limit(json_encode($event->metadata ?? [], JSON_UNESCAPED_SLASHES), 160)); ?></small>
                                </td>
                                <td><?php echo e($event->created_at?->format('d M Y, h:i A')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6">No audit events found for the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php echo e($events->links()); ?>

        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/developer/public_html/builder360/resources/views/governance/audit-events/index.blade.php ENDPATH**/ ?>