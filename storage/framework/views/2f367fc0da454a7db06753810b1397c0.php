

<?php $__env->startSection('title', 'Customer Collections - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $money = fn ($amount) => 'Rs. '.number_format((float) ($amount ?? 0), 2);
    ?>

    <div class="blade-workspace" aria-labelledby="collections-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Finance and Operations</p>
                <h1 id="collections-title">Customer Collections</h1>
                <p>
                    Workspace for receipt capture, booking milestone linkage,
                    submitted-to-approved workflow, payment schedule update, filters and CSV export.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('sales.bookings.index')); ?>">Sales Booking</a>
                <a href="<?php echo e(route('finance.dashboard')); ?>">Finance Dashboard</a>
                <a href="<?php echo e(route('finance.collections.export', request()->query())); ?>">Export CSV</a>
                <a href="<?php echo e(route('finance.collections.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status">
                <?php echo e(session('status')); ?>

            </section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Collection action was not saved.</strong>
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
                        <h2>Capture receipt</h2>
                    </div>
                    <small><?php echo e($canCreateReceipt ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateReceipt): ?>
                    <form method="POST" action="<?php echo e(route('finance.collections.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <label class="blade-form-wide">
                            Booking
                            <select name="booking_id" required>
                                <option value="">Select booking</option>
                                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($booking->id); ?>" <?php if((string) old('booking_id') === (string) $booking->id): echo 'selected'; endif; ?>>
                                        <?php echo e($booking->booking_code); ?> - <?php echo e($booking->customer?->name ?? 'Customer missing'); ?> - <?php echo e($booking->project?->code ?? 'No project'); ?> - <?php echo e($booking->unit?->unit_code ?? 'No unit'); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label class="blade-form-wide">
                            Payment schedule
                            <select name="booking_payment_schedule_id">
                                <option value="">Unallocated receipt</option>
                                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $booking->paymentSchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($schedule->id); ?>" <?php if((string) old('booking_payment_schedule_id') === (string) $schedule->id): echo 'selected'; endif; ?>>
                                            <?php echo e($booking->booking_code); ?> - <?php echo e($schedule->sequence); ?>. <?php echo e($schedule->milestone); ?> - <?php echo e($money($schedule->amount)); ?> - <?php echo e(str($schedule->status)->headline()); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Receipt date
                            <input type="date" name="receipt_date" value="<?php echo e(old('receipt_date', now()->toDateString())); ?>" max="<?php echo e(now()->toDateString()); ?>" required>
                        </label>

                        <label>
                            Payment mode
                            <select name="payment_mode" required>
                                <?php $__currentLoopData = $paymentModes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('payment_mode', 'neft') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Instrument / reference no.
                            <input type="text" name="instrument_number" value="<?php echo e(old('instrument_number')); ?>" maxlength="120" placeholder="Required except cash">
                        </label>

                        <label>
                            Bank name
                            <input type="text" name="bank_name" value="<?php echo e(old('bank_name')); ?>" maxlength="255">
                        </label>

                        <label>
                            Amount
                            <input type="number" name="amount" value="<?php echo e(old('amount')); ?>" min="1" step="0.01" required>
                        </label>

                        <label>
                            TDS / tax deducted
                            <input type="number" name="tax_deducted_amount" value="<?php echo e(old('tax_deducted_amount', 0)); ?>" min="0" step="0.01">
                        </label>

                        <label class="blade-form-wide">
                            Notes
                            <textarea name="notes" maxlength="2000" rows="3" placeholder="Bank statement reference, collection remarks or approval context."><?php echo e(old('notes')); ?></textarea>
                        </label>

                        <button type="submit" class="blade-primary-action">Submit receipt</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view collections but cannot capture receipts.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Milestones</span>
                        <h2>Open booking schedules</h2>
                    </div>
                    <small><?php echo e($bookings->count()); ?> active booking(s)</small>
                </div>

                <div class="blade-dashboard-table-wrap">
                    <table class="blade-dashboard-table">
                        <thead>
                            <tr>
                                <th scope="col">Booking</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Net receivable</th>
                                <th scope="col">Schedule</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($booking->booking_code); ?></strong>
                                        <span><?php echo e($booking->project?->code ?? 'No project'); ?> / <?php echo e($booking->unit?->unit_code ?? 'No unit'); ?></span>
                                    </td>
                                    <td><?php echo e($booking->customer?->name ?? 'Customer missing'); ?></td>
                                    <td><?php echo e($money($booking->net_receivable)); ?></td>
                                    <td>
                                        <?php $__empty_2 = true; $__currentLoopData = $booking->paymentSchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                            <span><?php echo e($schedule->sequence); ?>. <?php echo e($schedule->milestone); ?> - <?php echo e($money($schedule->amount)); ?> - <?php echo e(str($schedule->status)->headline()); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                            <span>No payment schedule</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4">No active confirmed bookings are available for collection capture.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Controls</span>
                    <h2>Collection filters</h2>
                </div>
                <small><?php echo e($receipts->total()); ?> record(s)</small>
            </div>

            <form method="GET" action="<?php echo e(route('finance.collections.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                <label>
                    Project
                    <select name="project_id">
                        <option value="">All projects</option>
                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($project->id); ?>" <?php if((string) ($filters['project_id'] ?? '') === (string) $project->id): echo 'selected'; endif; ?>>
                                <?php echo e($project->code); ?> - <?php echo e($project->name); ?>

                            </option>
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
                    Booking
                    <select name="booking_id">
                        <option value="">All bookings</option>
                        <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($booking->id); ?>" <?php if((string) ($filters['booking_id'] ?? '') === (string) $booking->id): echo 'selected'; endif; ?>>
                                <?php echo e($booking->booking_code); ?>

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

                <label>
                    Payment mode
                    <select name="payment_mode">
                        <option value="">All modes</option>
                        <?php $__currentLoopData = $paymentModes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php if(($filters['payment_mode'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>

                <label>
                    From
                    <input type="date" name="date_from" value="<?php echo e($filters['date_from'] ?? ''); ?>">
                </label>

                <label>
                    To
                    <input type="date" name="date_to" value="<?php echo e($filters['date_to'] ?? ''); ?>">
                </label>

                <button type="submit" class="blade-secondary-action">Apply filters</button>
            </form>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Collection receipt register</h2>
                </div>
                <small><?php echo e($receipts->firstItem() ?? 0); ?>-<?php echo e($receipts->lastItem() ?? 0); ?> of <?php echo e($receipts->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Receipt</th>
                            <th scope="col">Booking / customer</th>
                            <th scope="col">Mode</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Collected / approved</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $receipts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $receipt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($receipt->receipt_number); ?></strong>
                                    <span><?php echo e($receipt->receipt_date?->format('d M Y') ?? 'Date pending'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($receipt->booking?->booking_code ?? 'Booking missing'); ?></strong>
                                    <span><?php echo e($receipt->customer?->name ?? 'Customer missing'); ?></span>
                                    <span><?php echo e($receipt->paymentSchedule?->milestone ?? 'Unallocated'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($paymentModes[$receipt->payment_mode] ?? str($receipt->payment_mode)->headline()); ?></strong>
                                    <span><?php echo e($receipt->instrument_number ?? 'No instrument'); ?></span>
                                    <span><?php echo e($receipt->bank_name ?? 'No bank'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($money($receipt->amount)); ?></strong>
                                    <span>TDS: <?php echo e($money($receipt->tax_deducted_amount)); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($receipt->collectedBy?->name ?? 'Collector missing'); ?></strong>
                                    <span><?php echo e($receipt->approvedBy?->name ?? 'Approval pending'); ?></span>
                                </td>
                                <td><?php echo e($statuses[$receipt->status] ?? str($receipt->status)->headline()); ?></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve', $receipt)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Approve</summary>
                                            <form method="POST" action="<?php echo e(route('finance.collections.approve', $receipt)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <textarea name="note" maxlength="1000" rows="2" placeholder="Approval note"></textarea>
                                                <button type="submit" class="blade-primary-action">Approve receipt</button>
                                            </form>
                                        </details>
                                    <?php else: ?>
                                        <span>No action</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No collection receipts match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination">
                <?php echo e($receipts->links()); ?>

            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\finance\collections\index.blade.php ENDPATH**/ ?>