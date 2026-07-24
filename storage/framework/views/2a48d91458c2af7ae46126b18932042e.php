

<?php $__env->startSection('title', 'Handover Snags - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<div class="blade-workspace" aria-labelledby="handover-snags-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Possession and Snag Management</p>
                <h1 id="handover-snags-title">Handover Snags</h1>
                <p>
                    Workspace for reporting possession snags, severity tracking,
                    target resolution dates, resolution notes and automatic handover readiness refresh.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('possession.handovers.index')); ?>">Handovers</a>
                <a href="<?php echo e(route('maintenance.societies.index')); ?>">Society Ops</a>
                <a href="<?php echo e(route('possession.snags.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status"><?php echo e(session('status')); ?></section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Snag action was not saved.</strong>
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
                        <h2>Report handover snag</h2>
                    </div>
                    <small><?php echo e($canReportSnag ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canReportSnag): ?>
                    <form method="POST" action="<?php echo e(route('possession.snags.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <label class="blade-form-wide">
                            Open handover
                            <select name="possession_handover_id" required>
                                <option value="">Select handover</option>
                                <?php $__currentLoopData = $handovers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $handover): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($handover->id); ?>" <?php if((string) old('possession_handover_id') === (string) $handover->id): echo 'selected'; endif; ?>>
                                        <?php echo e($handover->handover_number); ?> - <?php echo e($handover->booking?->booking_code ?? 'Booking missing'); ?> - <?php echo e($handover->customer?->name ?? 'Customer missing'); ?> - <?php echo e($handover->unit?->unit_code ?? 'No unit'); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Area
                            <input type="text" name="area" value="<?php echo e(old('area')); ?>" maxlength="120" required placeholder="Living Room, Bedroom, Balcony">
                        </label>

                        <label>
                            Category
                            <input type="text" name="category" value="<?php echo e(old('category')); ?>" maxlength="120" required placeholder="Civil, Electrical, Plumbing">
                        </label>

                        <label>
                            Severity
                            <select name="severity" required>
                                <?php $__currentLoopData = $severities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('severity', 'medium') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Target resolution date
                            <input type="date" name="target_resolution_on" value="<?php echo e(old('target_resolution_on')); ?>" min="<?php echo e(now()->toDateString()); ?>">
                        </label>

                        <label class="blade-form-wide">
                            Description
                            <textarea name="description" required maxlength="5000" rows="3" placeholder="Describe the snag and verification expectation."><?php echo e(old('description')); ?></textarea>
                        </label>

                        <button type="submit" class="blade-primary-action">Report snag</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view handover snags but cannot report new snags.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Snag filters</h2>
                    </div>
                    <small><?php echo e($snags->total()); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('possession.snags.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                    <label>
                        Handover
                        <select name="possession_handover_id">
                            <option value="">All handovers</option>
                            <?php $__currentLoopData = $handovers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $handover): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($handover->id); ?>" <?php if((string) ($filters['possession_handover_id'] ?? '') === (string) $handover->id): echo 'selected'; endif; ?>><?php echo e($handover->handover_number); ?></option>
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
                        Severity
                        <select name="severity">
                            <option value="">All severities</option>
                            <?php $__currentLoopData = $severities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['severity'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>

                <p class="blade-workspace-note">
                    Open snags block possession handover letter issue and completion until resolved.
                </p>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Snag register</h2>
                </div>
                <small><?php echo e($snags->firstItem() ?? 0); ?>-<?php echo e($snags->lastItem() ?? 0); ?> of <?php echo e($snags->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Snag</th>
                            <th scope="col">Handover</th>
                            <th scope="col">Issue</th>
                            <th scope="col">Resolution</th>
                            <th scope="col">People</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $snags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $snag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($snag->snag_number); ?></strong>
                                    <span><?php echo e($snag->area); ?></span>
                                    <span><?php echo e($snag->category); ?></span>
                                    <span><?php echo e($severities[$snag->severity] ?? str($snag->severity)->headline()); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($snag->handover?->handover_number ?? 'Handover missing'); ?></strong>
                                    <span><?php echo e($snag->handover?->booking?->booking_code ?? 'Booking missing'); ?></span>
                                    <span><?php echo e($snag->handover?->unit?->unit_code ?? 'No unit'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($snag->description); ?></strong>
                                    <span>Target <?php echo e($snag->target_resolution_on?->format('d M Y') ?? 'Not set'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($snag->resolution_notes ?? 'Resolution pending'); ?></strong>
                                    <span><?php echo e($snag->resolved_at?->format('d M Y H:i') ?? 'Open'); ?></span>
                                </td>
                                <td>
                                    <strong>Reported by <?php echo e($snag->reportedBy?->name ?? 'User missing'); ?></strong>
                                    <span>Resolved by <?php echo e($snag->resolvedBy?->name ?? 'Pending'); ?></span>
                                </td>
                                <td><?php echo e($statuses[$snag->status] ?? str($snag->status)->headline()); ?></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('resolve', $snag)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Resolve</summary>
                                            <form method="POST" action="<?php echo e(route('possession.snags.resolve', $snag)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <textarea name="resolution_notes" required maxlength="5000" rows="2" placeholder="Resolution notes"></textarea>
                                                <button type="submit" class="blade-primary-action">Resolve snag</button>
                                            </form>
                                        </details>
                                    <?php else: ?>
                                        <span>No action</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No snags match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination"><?php echo e($snags->links()); ?></div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/possession/snags/index.blade.php ENDPATH**/ ?>