

<?php $__env->startSection('title', 'Unit Pricing - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $money = fn ($amount) => 'Rs. '.number_format((float) ($amount ?? 0), 2);
    ?>

    <div class="blade-workspace" aria-labelledby="unit-pricing-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Projects and Inventory</p>
                <h1 id="unit-pricing-title">Unit Pricing</h1>
                <p>
                    Workspace for effective-dated unit price versions,
                    charge break-up, tax calculation, workflow audit and approval segregation.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('inventory.units.index')); ?>">Unit Inventory</a>
                <a href="<?php echo e(route('sales.bookings.index')); ?>">Sales Booking</a>
                <a href="<?php echo e(route('inventory.unit-price-versions.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status">
                <?php echo e(session('status')); ?>

            </section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Unit price action was not saved.</strong>
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
                        <h2>Draft price version</h2>
                    </div>
                    <small><?php echo e($canCreateVersion ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateVersion): ?>
                    <form method="POST" action="<?php echo e(route('inventory.unit-price-versions.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <label class="blade-form-wide">
                            Unit
                            <select name="project_unit_id" required>
                                <option value="">Select unit</option>
                                <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($unit->id); ?>" <?php if((string) old('project_unit_id') === (string) $unit->id): echo 'selected'; endif; ?>>
                                        <?php echo e($unit->unit_code); ?> - <?php echo e($unit->project?->code ?? 'No project'); ?> - <?php echo e($unit->unit_type); ?> - <?php echo e(number_format((float) $unit->saleable_area_sqft, 2)); ?> sq.ft.
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Effective from
                            <input type="date" name="effective_from" value="<?php echo e(old('effective_from', now()->toDateString())); ?>" required>
                        </label>

                        <label>
                            Effective to
                            <input type="date" name="effective_to" value="<?php echo e(old('effective_to')); ?>">
                        </label>

                        <label>
                            Base rate
                            <input type="number" name="base_rate" value="<?php echo e(old('base_rate')); ?>" min="0.01" step="0.01" required>
                        </label>

                        <label>
                            Floor premium
                            <input type="number" name="floor_premium" value="<?php echo e(old('floor_premium', 0)); ?>" min="0" step="0.01">
                        </label>

                        <label>
                            Location premium
                            <input type="number" name="location_premium" value="<?php echo e(old('location_premium', 0)); ?>" min="0" step="0.01">
                        </label>

                        <label>
                            Parking charges
                            <input type="number" name="parking_charges" value="<?php echo e(old('parking_charges', 0)); ?>" min="0" step="0.01">
                        </label>

                        <label>
                            Other charges
                            <input type="number" name="other_charges" value="<?php echo e(old('other_charges', 0)); ?>" min="0" step="0.01">
                        </label>

                        <label>
                            Tax rate %
                            <input type="number" name="tax_rate_percent" value="<?php echo e(old('tax_rate_percent', 5)); ?>" min="0" max="100" step="0.0001">
                        </label>

                        <fieldset class="blade-form-wide blade-fieldset">
                            <legend>Charge break-up</legend>
                            <div class="blade-form-grid">
                                <label>
                                    Clubhouse / amenity charge
                                    <input type="number" name="charge_breakup[clubhouse]" value="<?php echo e(old('charge_breakup.clubhouse', 0)); ?>" min="0" step="0.01">
                                </label>

                                <label>
                                    Legal / documentation charge
                                    <input type="number" name="charge_breakup[legal]" value="<?php echo e(old('charge_breakup.legal', 0)); ?>" min="0" step="0.01">
                                </label>
                            </div>
                        </fieldset>

                        <button type="submit" class="blade-primary-action">Draft price version</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view unit pricing but cannot draft new price versions.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Price version filters</h2>
                    </div>
                    <small><?php echo e($versions->total()); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('inventory.unit-price-versions.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
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
                        Unit
                        <select name="project_unit_id">
                            <option value="">All units</option>
                            <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($unit->id); ?>" <?php if((string) ($filters['project_unit_id'] ?? '') === (string) $unit->id): echo 'selected'; endif; ?>>
                                    <?php echo e($unit->unit_code); ?>

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
                        Effective on
                        <input type="date" name="effective_on" value="<?php echo e($filters['effective_on'] ?? ''); ?>">
                    </label>

                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>

                <p class="blade-workspace-note">
                    Pricing calculations are performed by the configured pricing engine.
                    Approval retires overlapping active versions without changing historical bookings.
                </p>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Unit price version register</h2>
                </div>
                <small><?php echo e($versions->firstItem() ?? 0); ?>-<?php echo e($versions->lastItem() ?? 0); ?> of <?php echo e($versions->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Price version</th>
                            <th scope="col">Project / unit</th>
                            <th scope="col">Effective period</th>
                            <th scope="col">Commercials</th>
                            <th scope="col">Workflow</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $versions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $version): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($version->price_code); ?></strong>
                                    <span>Version <?php echo e($version->version_number); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($version->project?->code ?? 'No project'); ?></strong>
                                    <span><?php echo e($version->unit?->unit_code ?? 'No unit'); ?> / <?php echo e($version->unit?->unit_type ?? 'No type'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($version->effective_from?->format('d M Y') ?? 'Start pending'); ?></strong>
                                    <span><?php echo e($version->effective_to?->format('d M Y') ?? 'Open ended'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($money($version->total_price)); ?></strong>
                                    <span>Base: <?php echo e($money($version->base_price)); ?></span>
                                    <span>Gross: <?php echo e($money($version->gross_price_before_tax)); ?></span>
                                    <span>Tax: <?php echo e($money($version->tax_amount)); ?> @ <?php echo e(rtrim(rtrim(number_format((float) $version->tax_rate_percent, 4), '0'), '.')); ?>%</span>
                                </td>
                                <td>
                                    <strong>Created by <?php echo e($version->createdBy?->name ?? 'User missing'); ?></strong>
                                    <span>Approved by <?php echo e($version->approvedBy?->name ?? 'Pending'); ?></span>
                                    <span><?php echo e($version->approved_at?->format('d M Y H:i') ?? 'Approval pending'); ?></span>
                                </td>
                                <td><?php echo e($statuses[$version->status] ?? str($version->status)->headline()); ?></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve', $version)): ?>
                                        <?php if($version->status === 'draft'): ?>
                                            <details class="blade-row-actions">
                                                <summary>Approve</summary>
                                                <form method="POST" action="<?php echo e(route('inventory.unit-price-versions.approve', $version)); ?>" class="blade-inline-form">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <textarea name="note" maxlength="500" rows="2" placeholder="Approval note"></textarea>
                                                    <button type="submit" class="blade-primary-action">Approve version</button>
                                                </form>
                                            </details>
                                        <?php else: ?>
                                            <span>No action</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span>No action</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No price versions match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination">
                <?php echo e($versions->links()); ?>

            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\inventory\unit-price-versions\index.blade.php ENDPATH**/ ?>