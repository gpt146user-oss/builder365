

<?php $__env->startSection('title', 'After-Sales Tickets - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $ticketCount = $tickets->total();
        $openCount = $tickets->getCollection()->whereIn('status', ['open', 'assigned', 'in_progress'])->count();
        $criticalCount = $tickets->getCollection()->where('priority', 'critical')->count();
        $overdueCount = $tickets->getCollection()
            ->filter(fn ($ticket) => in_array($ticket->status, ['open', 'assigned', 'in_progress'], true) && $ticket->sla_due_at && $ticket->sla_due_at->isPast())
            ->count();
    ?>

    <div class="blade-workspace" aria-labelledby="after-sales-tickets-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">After-Sales & Maintenance</p>
                <h1 id="after-sales-tickets-title">Service Ticket SLA Workspace</h1>
                <p>
                    Workspace for complaint capture, buyer scoping, SLA monitoring,
                    assignment, resolution, closure and after-sales activity history.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(url('/')); ?>">Dashboard</a>
                <a href="<?php echo e(route('after-sales.work-orders.index')); ?>">Work Orders</a>
                <a href="<?php echo e(route('maintenance.dues.index')); ?>">Maintenance Dues</a>
                <a href="<?php echo e(route('after-sales.tickets.index')); ?>">Reset filters</a>
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

        <section class="blade-dashboard-kpis" aria-label="Ticket KPIs">
            <article class="blade-dashboard-kpi">
                <span>Total Tickets</span>
                <strong><?php echo e(number_format($ticketCount)); ?></strong>
                <small>Ticket register</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Active</span>
                <strong><?php echo e(number_format($openCount)); ?></strong>
                <small>Current page</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Critical</span>
                <strong><?php echo e(number_format($criticalCount)); ?></strong>
                <small>Current page</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>SLA Overdue</span>
                <strong><?php echo e(number_format($overdueCount)); ?></strong>
                <small>Current page</small>
            </article>
        </section>

        <section class="blade-workspace-grid">
            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Create</span>
                        <h2>Raise service ticket</h2>
                    </div>
                    <small><?php echo e($canCreateTicket ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateTicket): ?>
                    <form method="POST" action="<?php echo e(route('after-sales.tickets.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>
                        <label class="blade-form-wide">
                            Confirmed booking / unit
                            <select name="booking_id" required>
                                <option value="">Select confirmed booking</option>
                                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($booking->id); ?>" <?php if((int) old('booking_id') === (int) $booking->id): echo 'selected'; endif; ?>>
                                        <?php echo e($booking->booking_code); ?>

                                        <?php if($booking->unit): ?>
                                            · <?php echo e($booking->unit->unit_code); ?>

                                        <?php endif; ?>
                                        <?php if($booking->customer): ?>
                                            · <?php echo e($booking->customer->name); ?>

                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Category
                            <select name="category" required>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('category', 'maintenance') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Priority
                            <select name="priority" required>
                                <?php $__currentLoopData = $priorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('priority', 'medium') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <?php if (! ($isBuyerPortalUser)): ?>
                            <label>
                                Source
                                <select name="source">
                                    <?php $__currentLoopData = $sources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value); ?>" <?php if(old('source', 'phone') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </label>
                        <?php endif; ?>

                        <label class="blade-form-wide">
                            Subject
                            <input type="text" name="subject" value="<?php echo e(old('subject')); ?>" maxlength="255" required>
                        </label>

                        <label class="blade-form-wide">
                            Description
                            <textarea name="description" rows="4" required><?php echo e(old('description')); ?></textarea>
                        </label>

                        <button type="submit" class="blade-primary-action">Raise ticket</button>
                    </form>
                <?php else: ?>
                    <p class="blade-muted">You can view tickets but cannot create new after-sales complaints from this role.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Ticket filters</h2>
                    </div>
                    <small><?php echo e(number_format($ticketCount)); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('after-sales.tickets.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                    <?php if (! ($isBuyerPortalUser)): ?>
                        <label>
                            Project
                            <select name="project_id">
                                <option value="">All projects</option>
                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($project->id); ?>" <?php if(($filters['project_id'] ?? null) == $project->id): echo 'selected'; endif; ?>>
                                        <?php echo e($project->code); ?> · <?php echo e($project->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>
                        <label>
                            Customer
                            <select name="customer_id">
                                <option value="">All customers</option>
                                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($customer->id); ?>" <?php if(($filters['customer_id'] ?? null) == $customer->id): echo 'selected'; endif; ?>>
                                        <?php echo e($customer->code); ?> · <?php echo e($customer->name); ?>

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
                    <?php endif; ?>
                    <label>
                        Status
                        <select name="status">
                            <option value="">All statuses</option>
                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? null) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <label>
                        Priority
                        <select name="priority">
                            <option value="">All priorities</option>
                            <?php $__currentLoopData = $priorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['priority'] ?? null) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <label>
                        Category
                        <select name="category">
                            <option value="">All categories</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['category'] ?? null) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
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
                    <h2>Ticket SLA register</h2>
                </div>
                <small><?php echo e($tickets->firstItem() ?? 0); ?>-<?php echo e($tickets->lastItem() ?? 0); ?> of <?php echo e($tickets->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Ticket</th>
                            <th scope="col">Customer / unit</th>
                            <th scope="col">Category</th>
                            <th scope="col">SLA</th>
                            <th scope="col">Workflow</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($ticket->ticket_number); ?></strong>
                                    <span><?php echo e($ticket->subject); ?></span>
                                    <small><?php echo e($ticket->source); ?> · raised by <?php echo e($ticket->raisedBy?->name ?? '—'); ?></small>
                                </td>
                                <td>
                                    <strong><?php echo e($ticket->customer?->name ?? '—'); ?></strong>
                                    <span><?php echo e($ticket->booking?->booking_code ?? '—'); ?></span>
                                    <small><?php echo e($ticket->unit?->unit_code ?? 'No unit'); ?></small>
                                </td>
                                <td>
                                    <strong><?php echo e($categories[$ticket->category] ?? ucfirst($ticket->category)); ?></strong>
                                    <span><?php echo e($priorities[$ticket->priority] ?? ucfirst($ticket->priority)); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($ticket->sla_due_at?->format('d M Y H:i') ?? '—'); ?></strong>
                                    <span>
                                        <?php if(in_array($ticket->status, ['open', 'assigned', 'in_progress'], true) && $ticket->sla_due_at?->isPast()): ?>
                                            Overdue
                                        <?php else: ?>
                                            <?php echo e($ticket->first_response_due_at?->format('d M Y H:i') ?? '—'); ?>

                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td>
                                    <strong><?php echo e($ticket->assignedTo?->name ?? 'Unassigned'); ?></strong>
                                    <span><?php echo e(count($ticket->workOrders ?? [])); ?> work order(s)</span>
                                    <small><?php echo e(count($ticket->workflow_history ?? [])); ?> event(s)</small>
                                </td>
                                <td><span class="blade-status-pill"><?php echo e($statuses[$ticket->status] ?? ucfirst($ticket->status)); ?></span></td>
                                <td>
                                    <div class="blade-row-actions">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assign', $ticket)): ?>
                                            <form method="POST" action="<?php echo e(route('after-sales.tickets.assign', $ticket)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <select name="assigned_to_user_id" required>
                                                    <option value="">Assignee</option>
                                                    <?php $__currentLoopData = $assignees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($assignee->id); ?>"><?php echo e($assignee->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <input type="text" name="note" placeholder="Assignment note">
                                                <button type="submit">Assign</button>
                                            </form>
                                        <?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('resolve', $ticket)): ?>
                                            <form method="POST" action="<?php echo e(route('after-sales.tickets.resolve', $ticket)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <input type="text" name="resolution_summary" placeholder="Resolution summary" required>
                                                <button type="submit">Resolve</button>
                                            </form>
                                        <?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('close', $ticket)): ?>
                                            <form method="POST" action="<?php echo e(route('after-sales.tickets.close', $ticket)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <input type="number" name="customer_rating" min="1" max="5" placeholder="Rating">
                                                <input type="text" name="note" placeholder="Closure note">
                                                <button type="submit">Close</button>
                                            </form>
                                        <?php endif; ?>

                                        <?php if(! auth()->user()->can('assign', $ticket) && ! auth()->user()->can('resolve', $ticket) && ! auth()->user()->can('close', $ticket)): ?>
                                            <span class="blade-muted">No action</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No after-sales tickets match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination"><?php echo e($tickets->links()); ?></div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\after-sales\tickets\index.blade.php ENDPATH**/ ?>