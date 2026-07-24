

<?php $__env->startSection('title', 'Payment Requests - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $money = fn ($amount) => 'Rs. '.number_format((float) ($amount ?? 0), 2);
    ?>

    <div class="blade-workspace" aria-labelledby="payment-requests-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Finance and Customer Collections</p>
                <h1 id="payment-requests-title">Buyer Payment Requests</h1>
                <p>
                    Workspace for creating buyer payment links from active bookings,
                    tracking simulated/configured gateway status, cancelling requested links and reconciling paid receipts.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('finance.dashboard')); ?>">Finance Dashboard</a>
                <a href="<?php echo e(route('finance.collections.index')); ?>">Collections</a>
                <a href="<?php echo e(route('sales.bookings.index')); ?>">Bookings</a>
                <a href="<?php echo e(route('finance.payment-requests.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status"><?php echo e(session('status')); ?></section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Payment request action was not saved.</strong>
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
                        <h2>Create buyer payment link</h2>
                    </div>
                    <small><?php echo e($canCreatePaymentRequest ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreatePaymentRequest): ?>
                    <form method="POST" action="<?php echo e(route('finance.payment-requests.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <label class="blade-form-wide">
                            Booking
                            <select name="booking_id" required>
                                <option value="">Select active booking</option>
                                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($booking->id); ?>" <?php if((string) old('booking_id') === (string) $booking->id): echo 'selected'; endif; ?>>
                                        <?php echo e($booking->booking_code); ?> - <?php echo e($booking->customer?->name ?? 'Customer missing'); ?> - <?php echo e($booking->project?->code ?? 'No project'); ?> - <?php echo e($money($booking->net_receivable)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label class="blade-form-wide">
                            Payment schedule
                            <select name="booking_payment_schedule_id">
                                <option value="">Booking-level request</option>
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
                            Amount
                            <input type="number" name="amount" value="<?php echo e(old('amount')); ?>" min="1" step="0.01" required>
                        </label>

                        <label>
                            Expiry date/time
                            <input type="datetime-local" name="expires_at" value="<?php echo e(old('expires_at')); ?>">
                        </label>

                        <label class="blade-form-wide">
                            Purpose
                            <input type="text" name="purpose" value="<?php echo e(old('purpose')); ?>" maxlength="160" required placeholder="Slab completion milestone payment link">
                        </label>

                        <button type="submit" class="blade-primary-action">Create payment request</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view payment requests but cannot create buyer payment links.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Payment request filters</h2>
                    </div>
                    <small><?php echo e($paymentRequests->total()); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('finance.payment-requests.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
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
                        Booking
                        <select name="booking_id">
                            <option value="">All bookings</option>
                            <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($booking->id); ?>" <?php if((string) ($filters['booking_id'] ?? '') === (string) $booking->id): echo 'selected'; endif; ?>><?php echo e($booking->booking_code); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>

                    <label>
                        Search
                        <input type="search" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" maxlength="120" placeholder="Request, gateway ref, purpose">
                    </label>

                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>

                <p class="blade-workspace-note">
                    Gateway provider is read from system configuration. Browser users cannot override it from the form.
                </p>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Payment request register</h2>
                </div>
                <small><?php echo e($paymentRequests->firstItem() ?? 0); ?>-<?php echo e($paymentRequests->lastItem() ?? 0); ?> of <?php echo e($paymentRequests->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Request</th>
                            <th scope="col">Booking / customer</th>
                            <th scope="col">Gateway</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Timeline</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $paymentRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentRequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($paymentRequest->request_number); ?></strong>
                                    <span><?php echo e($paymentRequest->purpose); ?></span>
                                    <span><?php echo e($paymentRequest->paymentSchedule?->milestone ?? 'Booking-level request'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($paymentRequest->booking?->booking_code ?? 'Booking missing'); ?></strong>
                                    <span><?php echo e($paymentRequest->customer?->name ?? 'Customer missing'); ?></span>
                                    <span><?php echo e($paymentRequest->project?->code ?? 'No project'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e(str($paymentRequest->gateway_provider)->headline()); ?></strong>
                                    <span><?php echo e($paymentRequest->gateway_reference); ?></span>
                                    <span><?php echo e($paymentRequest->gateway_payload['simulation_notice'] ?? 'Configured gateway mode'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($money($paymentRequest->amount)); ?></strong>
                                    <span><?php echo e($paymentRequest->currency); ?></span>
                                    <span>Receipt <?php echo e($paymentRequest->collectionReceipt?->receipt_number ?? 'Pending'); ?></span>
                                </td>
                                <td>
                                    <strong>Created by <?php echo e($paymentRequest->createdBy?->name ?? 'User missing'); ?></strong>
                                    <span>Expires <?php echo e($paymentRequest->expires_at?->format('d M Y H:i') ?? 'Default expiry'); ?></span>
                                    <span>Paid <?php echo e($paymentRequest->paid_at?->format('d M Y H:i') ?? 'Pending'); ?></span>
                                </td>
                                <td><?php echo e($statuses[$paymentRequest->status] ?? str($paymentRequest->status)->headline()); ?></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cancel', $paymentRequest)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Cancel</summary>
                                            <form method="POST" action="<?php echo e(route('finance.payment-requests.cancel', $paymentRequest)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <textarea name="reason" required maxlength="500" rows="2" placeholder="Cancellation reason"></textarea>
                                                <button type="submit" class="blade-secondary-action">Cancel request</button>
                                            </form>
                                        </details>
                                    <?php else: ?>
                                        <span>No action</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No payment requests match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination"><?php echo e($paymentRequests->links()); ?></div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/finance/payment-requests/index.blade.php ENDPATH**/ ?>