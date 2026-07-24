

<?php $__env->startSection('title', 'Buyer Portal - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $customer = $summary['customer'] ?? null;
        $bookings = collect($summary['recent_bookings'] ?? []);
        $paymentSchedule = collect($summary['payment_schedule'] ?? []);
        $receipts = collect($summary['recent_receipts'] ?? []);
        $documents = collect($summary['documents'] ?? []);
        $tickets = collect($summary['service_tickets'] ?? []);
        $nextDue = $summary['next_due'] ?? null;
    ?>

    <div class="blade-workspace" aria-labelledby="buyer-portal-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Customer Channel</p>
                <h1 id="buyer-portal-title">Buyer Portal</h1>
                <p>
                    Secure buyer workspace for booking visibility, payment schedule,
                    approved receipts, approved documents, service tickets and customer self-service actions.
                </p>
            </div>
            <?php echo $__env->make('buyer.partials.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

        <?php if (! ($customer)): ?>
            <section class="blade-dashboard-card">
                <h2>No linked customer profile</h2>
                <p class="blade-muted">This buyer login does not have a customer record linked to it.</p>
            </section>
        <?php else: ?>
            <section class="blade-dashboard-kpis" aria-label="Buyer portal KPIs">
                <article class="blade-dashboard-kpi">
                    <span>Bookings</span>
                    <strong><?php echo e(number_format((int) ($summary['bookings_count'] ?? 0))); ?></strong>
                    <small><?php echo e($customer['code'] ?? 'Customer'); ?></small>
                </article>
                <article class="blade-dashboard-kpi">
                    <span>Outstanding</span>
                    <strong>₹<?php echo e(number_format((float) ($summary['outstanding_amount'] ?? 0), 2)); ?></strong>
                    <small>Scheduled less approved receipts</small>
                </article>
                <article class="blade-dashboard-kpi">
                    <span>Paid Receipts</span>
                    <strong>₹<?php echo e(number_format((float) ($summary['approved_receipts_total'] ?? 0), 2)); ?></strong>
                    <small>Approved collections</small>
                </article>
                <article class="blade-dashboard-kpi">
                    <span>Open Tickets</span>
                    <strong><?php echo e(number_format((int) ($summary['open_tickets_count'] ?? 0))); ?></strong>
                    <small>Active complaints</small>
                </article>
            </section>

            <section class="blade-workspace-grid">
                <article class="blade-dashboard-card">
                    <div class="blade-dashboard-section-title">
                        <div>
                            <span class="blade-dashboard-label">Profile</span>
                            <h2><?php echo e($customer['name']); ?></h2>
                        </div>
                        <small><?php echo e($customer['status']); ?></small>
                    </div>
                    <dl class="blade-definition-list">
                        <div>
                            <dt>Customer Code</dt>
                            <dd><?php echo e($customer['code']); ?></dd>
                        </div>
                        <div>
                            <dt>Email</dt>
                            <dd><?php echo e($customer['email']); ?></dd>
                        </div>
                        <div>
                            <dt>Phone</dt>
                            <dd><?php echo e($customer['phone']); ?></dd>
                        </div>
                        <div>
                            <dt>Next Due</dt>
                            <dd>
                                <?php if($nextDue): ?>
                                    <?php echo e($nextDue['booking_code']); ?> · <?php echo e($nextDue['milestone']); ?> ·
                                    ₹<?php echo e(number_format((float) $nextDue['amount'], 2)); ?> due <?php echo e($nextDue['due_on']); ?>

                                <?php else: ?>
                                    No pending milestone due found.
                                <?php endif; ?>
                            </dd>
                        </div>
                    </dl>
                </article>

                <article class="blade-dashboard-card">
                    <div class="blade-dashboard-section-title">
                        <div>
                            <span class="blade-dashboard-label">Self Service</span>
                            <h2>Raise service ticket</h2>
                        </div>
                        <small>Buyer access</small>
                    </div>
                    <form method="POST" action="<?php echo e(route('buyer.service-tickets.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>
                        <label class="blade-form-wide">
                            Booking / unit
                            <select name="booking_id" required>
                                <option value="">Select your booking</option>
                                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($booking['id']); ?>" <?php if((int) old('booking_id') === (int) $booking['id']): echo 'selected'; endif; ?>>
                                        <?php echo e($booking['booking_code']); ?>

                                        <?php if($booking['unit'] ?? null): ?>
                                            · <?php echo e($booking['unit']['unit_code'] ?? 'Unit'); ?>

                                        <?php endif; ?>
                                        <?php if($booking['project'] ?? null): ?>
                                            · <?php echo e($booking['project']['name'] ?? 'Project'); ?>

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

                        <label class="blade-form-wide">
                            Subject
                            <input type="text" name="subject" value="<?php echo e(old('subject')); ?>" maxlength="255" required>
                        </label>

                        <label class="blade-form-wide">
                            Description
                            <textarea name="description" rows="4" required><?php echo e(old('description')); ?></textarea>
                        </label>

                        <button type="submit" class="blade-primary-action">Submit service ticket</button>
                    </form>
                </article>
            </section>

            <section class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Bookings</span>
                        <h2>Recent booking and unit details</h2>
                    </div>
                    <small><?php echo e($bookings->count()); ?> shown</small>
                </div>
                <div class="blade-dashboard-table-wrap">
                    <table class="blade-dashboard-table">
                        <thead>
                            <tr>
                                <th scope="col">Booking</th>
                                <th scope="col">Project</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Value</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($booking['booking_code']); ?></strong>
                                        <span><?php echo e($booking['booked_on'] ?? '—'); ?></span>
                                    </td>
                                    <td>
                                        <strong><?php echo e($booking['project']['name'] ?? '—'); ?></strong>
                                        <span><?php echo e($booking['project']['city'] ?? '—'); ?></span>
                                    </td>
                                    <td>
                                        <strong><?php echo e($booking['unit']['unit_code'] ?? '—'); ?></strong>
                                        <span><?php echo e($booking['unit']['unit_type'] ?? '—'); ?></span>
                                    </td>
                                    <td>₹<?php echo e(number_format((float) ($booking['net_receivable'] ?? 0), 2)); ?></td>
                                    <td><span class="blade-status-pill"><?php echo e($booking['status']); ?></span></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="5">No bookings found for this buyer.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="blade-workspace-grid">
                <article class="blade-dashboard-card">
                    <div class="blade-dashboard-section-title">
                        <div>
                            <span class="blade-dashboard-label">Payments</span>
                            <h2>Payment schedule</h2>
                        </div>
                        <small><?php echo e($paymentSchedule->count()); ?> milestone(s)</small>
                    </div>
                    <div class="blade-dashboard-table-wrap">
                        <table class="blade-dashboard-table">
                            <thead>
                                <tr>
                                    <th scope="col">Milestone</th>
                                    <th scope="col">Due</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $paymentSchedule; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo e($schedule['booking_code']); ?></strong>
                                            <span><?php echo e($schedule['milestone']); ?></span>
                                        </td>
                                        <td><?php echo e($schedule['due_on'] ?? '—'); ?></td>
                                        <td>₹<?php echo e(number_format((float) $schedule['amount'], 2)); ?></td>
                                        <td><span class="blade-status-pill"><?php echo e($schedule['status']); ?></span></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr><td colspan="4">No payment milestones found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </article>

                <article class="blade-dashboard-card">
                    <div class="blade-dashboard-section-title">
                        <div>
                            <span class="blade-dashboard-label">Receipts</span>
                            <h2>Approved receipts</h2>
                        </div>
                        <small><?php echo e($receipts->count()); ?> shown</small>
                    </div>
                    <div class="blade-dashboard-table-wrap">
                        <table class="blade-dashboard-table">
                            <thead>
                                <tr>
                                    <th scope="col">Receipt</th>
                                    <th scope="col">Booking</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $receipts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $receipt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo e($receipt['receipt_number']); ?></strong>
                                            <span><?php echo e($receipt['payment_mode']); ?></span>
                                        </td>
                                        <td><?php echo e($receipt['booking_code'] ?? '—'); ?></td>
                                        <td><?php echo e($receipt['receipt_date'] ?? '—'); ?></td>
                                        <td>₹<?php echo e(number_format((float) $receipt['amount'], 2)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr><td colspan="4">No approved receipts found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </article>
            </section>

            <section class="blade-workspace-grid">
                <article class="blade-dashboard-card">
                    <div class="blade-dashboard-section-title">
                        <div>
                            <span class="blade-dashboard-label">Documents</span>
                            <h2>Approved documents</h2>
                        </div>
                        <small><?php echo e(number_format((int) ($summary['documents_count'] ?? 0))); ?> available</small>
                    </div>
                    <div class="blade-list">
                        <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="blade-list-row">
                                <div>
                                    <strong><?php echo e($document['document_number']); ?> · <?php echo e($document['title']); ?></strong>
                                    <span><?php echo e($document['category'] ?? 'Document'); ?> · v<?php echo e($document['version']); ?></span>
                                </div>
                                <a href="<?php echo e($document['download_url']); ?>">Download</a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="blade-muted">No approved customer or booking documents found.</p>
                        <?php endif; ?>
                    </div>
                </article>
            </section>

            <section class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Support</span>
                        <h2>Service ticket status</h2>
                    </div>
                    <small><?php echo e($tickets->count()); ?> shown</small>
                </div>
                <div class="blade-dashboard-table-wrap">
                    <table class="blade-dashboard-table">
                        <thead>
                            <tr>
                                <th scope="col">Ticket</th>
                                <th scope="col">Category</th>
                                <th scope="col">Priority</th>
                                <th scope="col">SLA</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($ticket['ticket_number']); ?></strong>
                                        <span><?php echo e($ticket['subject']); ?></span>
                                    </td>
                                    <td><?php echo e($categories[$ticket['category']] ?? $ticket['category']); ?></td>
                                    <td><?php echo e($priorities[$ticket['priority']] ?? $ticket['priority']); ?></td>
                                    <td><?php echo e($ticket['sla_due_at'] ?? '—'); ?></td>
                                    <td><span class="blade-status-pill"><?php echo e($ticketStatuses[$ticket['status']] ?? $ticket['status']); ?></span></td>
                                    <td>
                                        <?php if($ticket['status'] === 'resolved'): ?>
                                            <form method="POST" action="<?php echo e(route('buyer.service-tickets.close', $ticket['id'])); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <input type="number" name="customer_rating" min="1" max="5" placeholder="Rating" required>
                                                <input type="text" name="note" placeholder="Closure note">
                                                <button type="submit">Close</button>
                                            </form>
                                        <?php else: ?>
                                            <span class="blade-muted">No action</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="6">No service tickets found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/buyer/summary.blade.php ENDPATH**/ ?>