

<?php $__env->startSection('title', 'Maintenance Dues - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $money = fn ($amount) => 'Rs. '.number_format((float) ($amount ?? 0), 2);
    ?>

    <div class="blade-workspace" aria-labelledby="maintenance-dues-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Maintenance Billing</p>
                <h1 id="maintenance-dues-title">Maintenance Dues</h1>
                <p>
                    Workspace for raising unit-wise maintenance dues, buyer reminders,
                    part/full payment recording, balance tracking and collection activity history.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('maintenance.societies.index')); ?>">Societies</a>
                <a href="<?php echo e(route('maintenance.handover-items.index')); ?>">Common Area Handover</a>
                <a href="<?php echo e(route('finance.collections.index')); ?>">Collections</a>
                <a href="<?php echo e(route('maintenance.dues.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status"><?php echo e(session('status')); ?></section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Maintenance due action was not saved.</strong>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </section>
        <?php endif; ?>

        <section class="blade-workspace-grid">
            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Create</span>
                        <h2>Raise maintenance due</h2>
                    </div>
                    <small><?php echo e($canCreateDue ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateDue): ?>
                    <form method="POST" action="<?php echo e(route('maintenance.dues.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <label class="blade-form-wide">
                            Booking / unit
                            <select name="booking_id" required>
                                <option value="">Select active booking</option>
                                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($booking->id); ?>" <?php if((string) old('booking_id') === (string) $booking->id): echo 'selected'; endif; ?>>
                                        <?php echo e($booking->booking_code); ?> - <?php echo e($booking->customer?->name ?? 'Customer missing'); ?> - <?php echo e($booking->project?->code ?? 'No project'); ?> - <?php echo e($booking->unit?->unit_code ?? 'No unit'); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Period start
                            <input type="date" name="period_start_on" value="<?php echo e(old('period_start_on', now()->startOfMonth()->toDateString())); ?>" required>
                        </label>

                        <label>
                            Period end
                            <input type="date" name="period_end_on" value="<?php echo e(old('period_end_on', now()->endOfMonth()->toDateString())); ?>" required>
                        </label>

                        <label>
                            Due on
                            <input type="date" name="due_on" value="<?php echo e(old('due_on', now()->addDays(15)->toDateString())); ?>" required>
                        </label>

                        <label>
                            Amount
                            <input type="number" name="amount" value="<?php echo e(old('amount')); ?>" min="1" step="0.01" required>
                        </label>

                        <button type="submit" class="blade-primary-action">Raise due</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view maintenance dues but cannot raise new dues.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Due filters</h2>
                    </div>
                    <small><?php echo e($dues->total()); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('maintenance.dues.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                    <label>
                        Project
                        <select name="project_id">
                            <option value="">All projects</option>
                            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($project->id); ?>" <?php if((string) ($filters['project_id'] ?? '') === (string) $project->id): echo 'selected'; endif; ?>><?php echo e($project->code); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <label>
                        Customer
                        <select name="customer_id">
                            <option value="">All customers</option>
                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($customer->id); ?>" <?php if((string) ($filters['customer_id'] ?? '') === (string) $customer->id): echo 'selected'; endif; ?>>
                                    <?php echo e($customer->code); ?> - <?php echo e($customer->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <label>
                        Status
                        <select name="status">
                            <option value="">All statuses</option>
                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
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
                    <h2>Maintenance due register</h2>
                </div>
                <small><?php echo e($dues->firstItem() ?? 0); ?>-<?php echo e($dues->lastItem() ?? 0); ?> of <?php echo e($dues->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Due</th>
                            <th scope="col">Booking / customer</th>
                            <th scope="col">Period</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Workflow</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $dues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $due): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($due->due_number); ?></strong>
                                    <span><?php echo e($due->project?->code ?? 'No project'); ?></span>
                                    <span><?php echo e($due->unit?->unit_code ?? 'No unit'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($due->booking?->booking_code ?? 'Booking missing'); ?></strong>
                                    <span><?php echo e($due->customer?->name ?? 'Customer missing'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($due->period_start_on?->format('d M Y')); ?> to <?php echo e($due->period_end_on?->format('d M Y')); ?></strong>
                                    <span>Due <?php echo e($due->due_on?->format('d M Y') ?? 'Due date missing'); ?></span>
                                    <span>Reminder <?php echo e($due->last_reminded_at?->format('d M Y H:i') ?? 'Not sent'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($money($due->amount)); ?></strong>
                                    <span>Paid <?php echo e($money($due->paid_amount)); ?></span>
                                    <span>Balance <?php echo e($money($due->balance_amount)); ?></span>
                                    <span><?php echo e($due->payment_reference ?? 'Payment reference pending'); ?></span>
                                </td>
                                <td>
                                    <strong>Raised by <?php echo e($due->raisedBy?->name ?? 'User missing'); ?></strong>
                                    <span>Paid by <?php echo e($due->paidBy?->name ?? 'Pending'); ?></span>
                                    <span><?php echo e($due->paid_at?->format('d M Y H:i') ?? 'Payment pending'); ?></span>
                                </td>
                                <td><?php echo e($statuses[$due->status] ?? str($due->status)->headline()); ?></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('remind', $due)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Remind</summary>
                                            <form method="POST" action="<?php echo e(route('maintenance.dues.remind', $due)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <textarea name="note" maxlength="1000" rows="2" placeholder="Reminder note"></textarea>
                                                <button type="submit" class="blade-secondary-action">Record reminder</button>
                                            </form>
                                        </details>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('markPaid', $due)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Mark paid</summary>
                                            <form method="POST" action="<?php echo e(route('maintenance.dues.mark-paid', $due)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <input type="number" name="paid_amount" value="<?php echo e($due->balance_amount); ?>" min="0.01" max="<?php echo e($due->balance_amount); ?>" step="0.01" required>
                                                <input type="text" name="payment_reference" required maxlength="120" placeholder="Payment reference / UTR">
                                                <input type="date" name="paid_at" max="<?php echo e(now()->toDateString()); ?>">
                                                <textarea name="note" maxlength="1000" rows="2" placeholder="Payment note"></textarea>
                                                <button type="submit" class="blade-primary-action">Record payment</button>
                                            </form>
                                        </details>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('remind', $due)): ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('markPaid', $due)): ?>
                                            <span>No action</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No maintenance dues match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination"><?php echo e($dues->links()); ?></div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\maintenance\dues\index.blade.php ENDPATH**/ ?>