

<?php $__env->startSection('title', 'Sales Booking - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $quote = session('quote');
        $money = fn ($amount) => 'Rs. '.number_format((float) ($amount ?? 0), 2);
    ?>

    <div class="blade-workspace" aria-labelledby="sales-booking-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Sales and CRM</p>
                <h1 id="sales-booking-title">Sales Booking</h1>
                <p>
                    Workspace for booking quote preview, customer and unit selection,
                    payment schedule capture, booking confirmation, audit trail generation and unit status update.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('crm.leads.index')); ?>">Lead Management</a>
                <a href="<?php echo e(route('crm.lead-qualifications.index')); ?>">Lead Qualification</a>
                <a href="<?php echo e(route('crm.site-visits.index')); ?>">Site Visits</a>
                <a href="<?php echo e(route('sales.bookings.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status">
                <?php echo e(session('status')); ?>

            </section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Booking action was not saved.</strong>
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
                        <span class="blade-dashboard-label">Quote</span>
                        <h2>Booking quote preview</h2>
                    </div>
                    <small><?php echo e($bookableUnits->count()); ?> bookable unit(s)</small>
                </div>

                <form method="POST" action="<?php echo e(route('sales.booking-quotes.store')); ?>" class="blade-form-grid">
                    <?php echo csrf_field(); ?>

                    <label class="blade-form-wide">
                        Unit
                        <select name="project_unit_id" required>
                            <option value="">Select available unit</option>
                            <?php $__currentLoopData = $bookableUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($unit->id); ?>" <?php if((string) old('project_unit_id') === (string) $unit->id): echo 'selected'; endif; ?>>
                                    <?php echo e($unit->unit_code); ?> - <?php echo e($unit->project?->code ?? 'No project'); ?> - <?php echo e($unit->unit_type); ?> - <?php echo e($money($unit->total_price)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>

                    <label>
                        Quoted on
                        <input type="date" name="quoted_on" value="<?php echo e(old('quoted_on', now()->toDateString())); ?>">
                    </label>

                    <label>
                        Discount amount
                        <input type="number" name="discount_amount" value="<?php echo e(old('discount_amount', 0)); ?>" min="0" step="0.01">
                    </label>

                    <button type="submit" class="blade-secondary-action">Preview quote</button>
                </form>

                <?php if(is_array($quote)): ?>
                    <div class="blade-workspace-note">
                        Quote source: <?php echo e(str($quote['source'] ?? 'not_available')->headline()); ?>

                    </div>

                    <div class="blade-dashboard-table-wrap">
                        <table class="blade-dashboard-table">
                            <tbody>
                                <tr>
                                    <th scope="row">Unit</th>
                                    <td><?php echo e($quote['unit']['unit_code'] ?? 'Not available'); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Price code</th>
                                    <td><?php echo e($quote['price_code'] ?? 'Snapshot pricing'); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Gross before tax</th>
                                    <td><?php echo e($money($quote['gross_price_before_tax'] ?? 0)); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Discount</th>
                                    <td><?php echo e($money($quote['discount_amount'] ?? 0)); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Tax amount</th>
                                    <td><?php echo e($money($quote['tax_amount'] ?? 0)); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Net payable</th>
                                    <td><strong><?php echo e($money($quote['total_payable'] ?? 0)); ?></strong></td>
                                </tr>
                                <tr>
                                    <th scope="row">Discount approval</th>
                                    <td><?php echo e(($quote['requires_discount_approval'] ?? false) ? 'Required' : 'Not required'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="blade-workspace-note">
                        Use Preview quote before booking to verify effective price, discount, tax and net receivable.
                    </p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Create</span>
                        <h2>Create booking</h2>
                    </div>
                    <small><?php echo e($canCreateBooking ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateBooking): ?>
                    <form method="POST" action="<?php echo e(route('sales.bookings.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <label class="blade-form-wide">
                            Unit
                            <select name="project_unit_id" required>
                                <option value="">Select available unit</option>
                                <?php $__currentLoopData = $bookableUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($unit->id); ?>" <?php if((string) old('project_unit_id') === (string) $unit->id): echo 'selected'; endif; ?>>
                                        <?php echo e($unit->unit_code); ?> - <?php echo e($unit->project?->code ?? 'No project'); ?> - <?php echo e($unit->unit_type); ?> - <?php echo e($money($unit->total_price)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label class="blade-form-wide">
                            Lead
                            <select name="lead_id">
                                <option value="">Direct booking / no lead</option>
                                <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($lead->id); ?>" <?php if((string) old('lead_id') === (string) $lead->id): echo 'selected'; endif; ?>>
                                        <?php echo e($lead->lead_code); ?> - <?php echo e($lead->customer?->name ?? 'Customer pending'); ?> - <?php echo e($lead->project?->code ?? 'No project'); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label class="blade-form-wide">
                            Customer
                            <select name="customer_id" required>
                                <option value="">Select customer</option>
                                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($customer->id); ?>" <?php if((string) old('customer_id') === (string) $customer->id): echo 'selected'; endif; ?>>
                                        <?php echo e($customer->code); ?> - <?php echo e($customer->name); ?> - <?php echo e($customer->phone ?? 'No phone'); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Channel partner / broker
                            <select name="partner_id">
                                <option value="">No partner</option>
                                <?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($partner->id); ?>" <?php if((string) old('partner_id') === (string) $partner->id): echo 'selected'; endif; ?>>
                                        <?php echo e($partner->code); ?> - <?php echo e($partner->name); ?> - <?php echo e(str($partner->partner_type)->headline()); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Booking date
                            <input type="date" name="booked_on" value="<?php echo e(old('booked_on', now()->toDateString())); ?>">
                        </label>

                        <label>
                            Booking amount
                            <input type="number" name="booking_amount" value="<?php echo e(old('booking_amount')); ?>" min="0" step="0.01" required>
                        </label>

                        <label>
                            Discount amount
                            <input type="number" name="discount_amount" value="<?php echo e(old('discount_amount', 0)); ?>" min="0" step="0.01">
                        </label>

                        <fieldset class="blade-form-wide blade-fieldset">
                            <legend>Payment schedule</legend>
                            <div class="blade-form-grid">
                                <?php $__currentLoopData = [
                                    ['sequence' => 1, 'milestone' => 'Booking Amount', 'percentage' => 10],
                                    ['sequence' => 2, 'milestone' => 'Agreement', 'percentage' => 20],
                                    ['sequence' => 3, 'milestone' => 'Possession', 'percentage' => 70],
                                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <input type="hidden" name="payment_schedule[<?php echo e($index); ?>][sequence]" value="<?php echo e(old("payment_schedule.$index.sequence", $schedule['sequence'])); ?>">

                                    <label>
                                        Milestone <?php echo e($schedule['sequence']); ?>

                                        <input type="text" name="payment_schedule[<?php echo e($index); ?>][milestone]" value="<?php echo e(old("payment_schedule.$index.milestone", $schedule['milestone'])); ?>" maxlength="120">
                                    </label>

                                    <label>
                                        Percentage
                                        <input type="number" name="payment_schedule[<?php echo e($index); ?>][percentage]" value="<?php echo e(old("payment_schedule.$index.percentage", $schedule['percentage'])); ?>" min="0" max="100" step="0.01">
                                    </label>

                                    <label>
                                        Due date
                                        <input type="date" name="payment_schedule[<?php echo e($index); ?>][due_on]" value="<?php echo e(old("payment_schedule.$index.due_on")); ?>">
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </fieldset>

                        <button type="submit" class="blade-primary-action">Confirm booking</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view bookings but cannot create new bookings.</p>
                <?php endif; ?>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Controls</span>
                    <h2>Booking filters</h2>
                </div>
                <small><?php echo e($bookings->total()); ?> record(s)</small>
            </div>

            <form method="GET" action="<?php echo e(route('sales.bookings.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
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
                    Status
                    <select name="status">
                        <option value="">All statuses</option>
                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
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

                <button type="submit" class="blade-secondary-action">Apply filters</button>
            </form>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Booking register</h2>
                </div>
                <small><?php echo e($bookings->firstItem() ?? 0); ?>-<?php echo e($bookings->lastItem() ?? 0); ?> of <?php echo e($bookings->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Booking</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Project / unit</th>
                            <th scope="col">Booked by</th>
                            <th scope="col">Commercials</th>
                            <th scope="col">Payment schedule</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($booking->booking_code); ?></strong>
                                    <span><?php echo e($booking->booked_on?->format('d M Y') ?? 'Date pending'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($booking->customer?->name ?? 'Customer missing'); ?></strong>
                                    <span><?php echo e($booking->lead?->lead_code ?? 'No linked lead'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($booking->project?->code ?? 'No project'); ?></strong>
                                    <span><?php echo e($booking->unit?->unit_code ?? 'No unit'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($booking->bookedBy?->name ?? 'User missing'); ?></strong>
                                    <span><?php echo e($booking->partner?->name ?? 'No partner'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($money($booking->net_receivable)); ?></strong>
                                    <span>Booking: <?php echo e($money($booking->booking_amount)); ?></span>
                                    <span>Discount: <?php echo e($money($booking->discount_amount)); ?></span>
                                </td>
                                <td>
                                    <?php $__empty_2 = true; $__currentLoopData = $booking->paymentSchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <span>
                                            <?php echo e($schedule->sequence); ?>. <?php echo e($schedule->milestone); ?> -
                                            <?php echo e($schedule->percentage ? rtrim(rtrim(number_format((float) $schedule->percentage, 2), '0'), '.') . '%' : $money($schedule->amount)); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <span>No schedule</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($statuses[$booking->status] ?? str($booking->status)->headline()); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No bookings match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination">
                <?php echo e($bookings->links()); ?>

            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/sales/bookings/index.blade.php ENDPATH**/ ?>