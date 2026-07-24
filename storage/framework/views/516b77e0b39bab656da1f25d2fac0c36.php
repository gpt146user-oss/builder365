

<?php $__env->startSection('title', 'Maintenance Work Orders - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $workOrderCount = $workOrders->total();
        $scheduledCount = $workOrders->getCollection()->where('status', 'scheduled')->count();
        $plannedCount = $workOrders->getCollection()->where('status', 'planned')->count();
        $completedCount = $workOrders->getCollection()->where('status', 'completed')->count();
    ?>

    <div class="blade-workspace" aria-labelledby="after-sales-work-orders-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">After-Sales & Maintenance</p>
                <h1 id="after-sales-work-orders-title">Maintenance Work Orders</h1>
                <p>
                    Workspace for creating, scheduling, assigning and completing maintenance
                    work orders linked to service tickets and project units.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(url('/')); ?>">Dashboard</a>
                <a href="<?php echo e(route('after-sales.tickets.index')); ?>">Service Tickets</a>
                <a href="<?php echo e(route('maintenance.handover-items.index')); ?>">Common Area Handover</a>
                <a href="<?php echo e(route('after-sales.work-orders.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <div class="blade-alert blade-alert-success"><?php echo e(session('status')); ?></div>
        <?php endif; ?>

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

        <section class="blade-dashboard-kpis" aria-label="Work order KPIs">
            <article class="blade-dashboard-kpi">
                <span>Total Work Orders</span>
                <strong><?php echo e(number_format($workOrderCount)); ?></strong>
                <small>Work order register</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Planned</span>
                <strong><?php echo e(number_format($plannedCount)); ?></strong>
                <small>Current page</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Scheduled</span>
                <strong><?php echo e(number_format($scheduledCount)); ?></strong>
                <small>Current page</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Completed</span>
                <strong><?php echo e(number_format($completedCount)); ?></strong>
                <small>Current page</small>
            </article>
        </section>

        <section class="blade-workspace-grid">
            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Create</span>
                        <h2>Create maintenance work order</h2>
                    </div>
                    <small><?php echo e($canCreateWorkOrder ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateWorkOrder): ?>
                    <form method="POST" action="<?php echo e(route('after-sales.work-orders.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>
                        <label class="blade-form-wide">
                            Active service ticket
                            <select name="service_ticket_id" required>
                                <option value="">Select open ticket</option>
                                <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($ticket->id); ?>" <?php if((int) old('service_ticket_id') === (int) $ticket->id): echo 'selected'; endif; ?>>
                                        <?php echo e($ticket->ticket_number); ?> · <?php echo e($ticket->subject); ?>

                                        <?php if($ticket->unit): ?>
                                            · <?php echo e($ticket->unit->unit_code); ?>

                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Assign to
                            <select name="assigned_to_user_id">
                                <option value="">Use ticket assignee</option>
                                <?php $__currentLoopData = $assignees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($assignee->id); ?>" <?php if((int) old('assigned_to_user_id') === (int) $assignee->id): echo 'selected'; endif; ?>>
                                        <?php echo e($assignee->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Vendor
                            <select name="vendor_id">
                                <option value="">Internal team</option>
                                <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($vendor->id); ?>" <?php if((int) old('vendor_id') === (int) $vendor->id): echo 'selected'; endif; ?>>
                                        <?php echo e($vendor->vendor_code); ?> · <?php echo e($vendor->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Scheduled on
                            <input type="date" name="scheduled_on" value="<?php echo e(old('scheduled_on', now()->addDay()->toDateString())); ?>">
                        </label>

                        <label>
                            Estimated cost
                            <input type="number" name="estimated_cost" value="<?php echo e(old('estimated_cost', 0)); ?>" min="0" step="0.01">
                        </label>

                        <label class="blade-form-wide">
                            Scope of work
                            <textarea name="scope_of_work" rows="4" required><?php echo e(old('scope_of_work')); ?></textarea>
                        </label>

                        <button type="submit" class="blade-primary-action">Create work order</button>
                    </form>
                <?php else: ?>
                    <p class="blade-muted">You can view maintenance work orders but cannot create them from this role.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Work-order filters</h2>
                    </div>
                    <small><?php echo e(number_format($workOrderCount)); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('after-sales.work-orders.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                    <label>
                        Service ticket
                        <select name="service_ticket_id">
                            <option value="">All tickets</option>
                            <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($ticket->id); ?>" <?php if(($filters['service_ticket_id'] ?? null) == $ticket->id): echo 'selected'; endif; ?>>
                                    <?php echo e($ticket->ticket_number); ?> · <?php echo e($ticket->subject); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <label>
                        Assignee
                        <select name="assigned_to_user_id">
                            <option value="">All assignees</option>
                            <?php $__currentLoopData = $assignees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($assignee->id); ?>" <?php if(($filters['assigned_to_user_id'] ?? null) == $assignee->id): echo 'selected'; endif; ?>>
                                    <?php echo e($assignee->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <label>
                        Status
                        <select name="status">
                            <option value="">All statuses</option>
                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? null) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Maintenance work-order register</h2>
                </div>
                <small><?php echo e($workOrders->firstItem() ?? 0); ?>-<?php echo e($workOrders->lastItem() ?? 0); ?> of <?php echo e($workOrders->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Work order</th>
                            <th scope="col">Ticket / unit</th>
                            <th scope="col">Ownership</th>
                            <th scope="col">Schedule</th>
                            <th scope="col">Cost</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $workOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($workOrder->work_order_number); ?></strong>
                                    <span><?php echo e($workOrder->scope_of_work); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($workOrder->serviceTicket?->ticket_number ?? '—'); ?></strong>
                                    <span><?php echo e($workOrder->serviceTicket?->subject ?? '—'); ?></span>
                                    <small><?php echo e($workOrder->unit?->unit_code ?? 'No unit'); ?></small>
                                </td>
                                <td>
                                    <strong><?php echo e($workOrder->assignedTo?->name ?? 'Unassigned'); ?></strong>
                                    <span><?php echo e($workOrder->vendor?->name ?? 'Internal team'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($workOrder->scheduled_on?->format('d M Y') ?? 'Not scheduled'); ?></strong>
                                    <span>Completed <?php echo e($workOrder->completed_at?->format('d M Y H:i') ?? '—'); ?></span>
                                </td>
                                <td>
                                    <strong>₹<?php echo e(number_format((float) $workOrder->estimated_cost, 2)); ?></strong>
                                    <span>Actual ₹<?php echo e(number_format((float) $workOrder->actual_cost, 2)); ?></span>
                                </td>
                                <td><span class="blade-status-pill"><?php echo e($statuses[$workOrder->status] ?? ucfirst($workOrder->status)); ?></span></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('complete', $workOrder)): ?>
                                        <form method="POST" action="<?php echo e(route('after-sales.work-orders.complete', $workOrder)); ?>" class="blade-inline-form">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <input type="text" name="completion_notes" placeholder="Completion notes" required>
                                            <input type="number" name="actual_cost" value="<?php echo e($workOrder->estimated_cost); ?>" min="0" step="0.01">
                                            <button type="submit">Complete</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="blade-muted">No action</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No maintenance work orders match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination"><?php echo e($workOrders->links()); ?></div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\after-sales\work-orders\index.blade.php ENDPATH**/ ?>