

<?php $__env->startSection('title', 'Unit Inventory - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $money = fn ($amount) => 'Rs. '.number_format((float) ($amount ?? 0), 2);
    ?>

    <div class="blade-workspace" aria-labelledby="unit-inventory-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Projects and Inventory</p>
                <h1 id="unit-inventory-title">Unit Inventory</h1>
                <p>
                    Workspace for project-wise unit availability, pricing snapshot,
                    booking reference, filters and CSV availability export.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('inventory.unit-price-versions.index')); ?>">Unit Pricing</a>
                <a href="<?php echo e(route('sales.bookings.index')); ?>">Sales Booking</a>
                <a href="<?php echo e(route('inventory.units.export', array_merge(request()->query(), ['format' => 'csv']))); ?>">Export CSV</a>
                <a href="<?php echo e(route('inventory.units.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Unit inventory filters were not applied.</strong>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </section>
        <?php endif; ?>

        <section class="blade-dashboard-grid">
            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="blade-dashboard-card">
                    <span class="blade-dashboard-label"><?php echo e($label); ?></span>
                    <strong><?php echo e((int) ($summary[$value] ?? 0)); ?></strong>
                    <small>Available units</small>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Controls</span>
                    <h2>Availability filters</h2>
                </div>
                <small><?php echo e($units->total()); ?> record(s)</small>
            </div>

            <form method="GET" action="<?php echo e(route('inventory.units.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
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
                    Unit type
                    <select name="unit_type">
                        <option value="">All types</option>
                        <?php $__currentLoopData = $unitTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unitType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($unitType); ?>" <?php if(($filters['unit_type'] ?? '') === $unitType): echo 'selected'; endif; ?>><?php echo e($unitType); ?></option>
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
                    <h2>Unit availability register</h2>
                </div>
                <small><?php echo e($units->firstItem() ?? 0); ?>-<?php echo e($units->lastItem() ?? 0); ?> of <?php echo e($units->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Unit</th>
                            <th scope="col">Project</th>
                            <th scope="col">Structure</th>
                            <th scope="col">Area</th>
                            <th scope="col">Price snapshot</th>
                            <th scope="col">Booking reference</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($unit->unit_code); ?></strong>
                                    <span><?php echo e($unit->unit_type); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($unit->project?->code ?? 'No project'); ?></strong>
                                    <span><?php echo e($unit->project?->name ?? 'Project missing'); ?></span>
                                    <span><?php echo e($unit->project?->city ?? 'City pending'); ?></span>
                                </td>
                                <td>
                                    <strong>Tower <?php echo e($unit->tower); ?></strong>
                                    <span>Floor <?php echo e($unit->floor); ?> / Unit <?php echo e($unit->unit_number); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e(number_format((float) $unit->saleable_area_sqft, 2)); ?> saleable sq.ft.</strong>
                                    <span><?php echo e(number_format((float) $unit->carpet_area_sqft, 2)); ?> carpet sq.ft.</span>
                                </td>
                                <td>
                                    <strong><?php echo e($money($unit->total_price)); ?></strong>
                                    <span>Base rate: <?php echo e($money($unit->base_rate)); ?></span>
                                    <span>Tax: <?php echo e($money($unit->tax_amount)); ?></span>
                                </td>
                                <td>
                                    <?php if($unit->activeBooking): ?>
                                        <strong><?php echo e($unit->activeBooking->booking_code); ?></strong>
                                        <span><?php echo e(str($unit->activeBooking->status)->headline()); ?></span>
                                    <?php else: ?>
                                        <span>No active booking</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo e($statuses[$unit->status] ?? str($unit->status)->headline()); ?></strong>
                                    <span><?php echo e($unit->isBookable() ? 'Bookable' : 'Not bookable'); ?></span>
                                    <?php if($unit->reserved_until): ?>
                                        <span>Reserved until <?php echo e($unit->reserved_until->format('d M Y H:i')); ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No units match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination">
                <?php echo e($units->links()); ?>

            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\inventory\units\index.blade.php ENDPATH**/ ?>