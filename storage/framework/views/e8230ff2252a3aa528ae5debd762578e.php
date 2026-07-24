

<?php $__env->startSection('title', 'Possession Handovers - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $money = fn ($amount) => 'Rs. '.number_format((float) ($amount ?? 0), 2);
    ?>

    <div class="blade-workspace" aria-labelledby="possession-handovers-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Possession and Handover</p>
                <h1 id="possession-handovers-title">Possession Handovers</h1>
                <p>
                    Workspace for possession eligibility, final payment checks,
                    handover checklist, possession letter issue, snag blockers and completion status.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('sales.bookings.index')); ?>">Bookings</a>
                <a href="<?php echo e(route('finance.collections.index')); ?>">Collections</a>
                <a href="<?php echo e(route('possession.snags.index')); ?>">Snags</a>
                <a href="<?php echo e(route('possession.handovers.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status"><?php echo e(session('status')); ?></section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Possession handover action was not saved.</strong>
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
                        <h2>Initiate possession handover</h2>
                    </div>
                    <small><?php echo e($canCreateHandover ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateHandover): ?>
                    <form method="POST" action="<?php echo e(route('possession.handovers.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <label class="blade-form-wide">
                            Confirmed booking
                            <select name="booking_id" required>
                                <option value="">Select booking without existing handover</option>
                                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($booking->id); ?>" <?php if((string) old('booking_id') === (string) $booking->id): echo 'selected'; endif; ?>>
                                        <?php echo e($booking->booking_code); ?> - <?php echo e($booking->customer?->name ?? 'Customer missing'); ?> - <?php echo e($booking->project?->code ?? 'No project'); ?> - <?php echo e($booking->unit?->unit_code ?? 'No unit'); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Target handover date
                            <input type="date" name="target_handover_on" value="<?php echo e(old('target_handover_on')); ?>">
                        </label>

                        <p class="blade-form-wide blade-workspace-note">
                            Initial handover uses the configured default checklist. Update checklist after initiation once finance, document, inspection and key-readiness checks are confirmed.
                        </p>

                        <button type="submit" class="blade-primary-action">Initiate handover</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view handovers but cannot initiate new handovers.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Handover filters</h2>
                    </div>
                    <small><?php echo e($handovers->total()); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('possession.handovers.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
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

                <p class="blade-workspace-note">
                    Completion is blocked until financial outstanding is zero, required checklist items are completed, open snags are resolved and possession letter reference matches.
                </p>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Handover register</h2>
                </div>
                <small><?php echo e($handovers->firstItem() ?? 0); ?>-<?php echo e($handovers->lastItem() ?? 0); ?> of <?php echo e($handovers->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Handover</th>
                            <th scope="col">Booking / customer</th>
                            <th scope="col">Eligibility</th>
                            <th scope="col">Checklist</th>
                            <th scope="col">Workflow</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $handovers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $handover): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($handover->handover_number); ?></strong>
                                    <span>Target <?php echo e($handover->target_handover_on?->format('d M Y') ?? 'Not set'); ?></span>
                                    <span>Actual <?php echo e($handover->actual_handover_on?->format('d M Y') ?? 'Pending'); ?></span>
                                    <span>Letter <?php echo e($handover->possession_letter_reference ?? 'Not issued'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($handover->booking?->booking_code ?? 'Booking missing'); ?></strong>
                                    <span><?php echo e($handover->customer?->name ?? 'Customer missing'); ?></span>
                                    <span><?php echo e($handover->project?->code ?? 'No project'); ?> / <?php echo e($handover->unit?->unit_code ?? 'No unit'); ?></span>
                                </td>
                                <td>
                                    <strong>Outstanding <?php echo e($money($handover->financial_outstanding)); ?></strong>
                                    <?php $__empty_2 = true; $__currentLoopData = ($handover->blockers ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blocker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <span><?php echo e($blocker['message'] ?? $blocker['code'] ?? 'Blocker'); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <span>No blockers</span>
                                    <?php endif; ?>
                                    <span>Open snags <?php echo e($handover->snags->where('status', 'open')->count()); ?></span>
                                </td>
                                <td>
                                    <?php $__empty_2 = true; $__currentLoopData = ($handover->checklist ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <span>
                                            <?php echo e(($item['completed'] ?? false) ? '✓' : '□'); ?>

                                            <?php echo e($item['label'] ?? $item['code'] ?? 'Checklist item'); ?>

                                            <?php echo e(($item['required'] ?? false) ? '(Required)' : '(Optional)'); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <span>No checklist captured</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong>Initiated by <?php echo e($handover->initiatedBy?->name ?? 'User missing'); ?></strong>
                                    <span>Completed by <?php echo e($handover->completedBy?->name ?? 'Pending'); ?></span>
                                    <span><?php echo e($handover->completed_at?->format('d M Y H:i') ?? 'Completion pending'); ?></span>
                                </td>
                                <td><?php echo e($statuses[$handover->status] ?? str($handover->status)->headline()); ?></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $handover)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Checklist</summary>
                                            <form method="POST" action="<?php echo e(route('possession.handovers.checklist.update', $handover)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <?php $__currentLoopData = ($handover->checklist ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <input type="hidden" name="checklist[<?php echo e($index); ?>][code]" value="<?php echo e($item['code'] ?? 'item_'.$index); ?>">
                                                    <input type="hidden" name="checklist[<?php echo e($index); ?>][label]" value="<?php echo e($item['label'] ?? 'Checklist item '.($index + 1)); ?>">
                                                    <input type="hidden" name="checklist[<?php echo e($index); ?>][required]" value="<?php echo e((int) (bool) ($item['required'] ?? true)); ?>">
                                                    <input type="hidden" name="checklist[<?php echo e($index); ?>][completed]" value="0">
                                                    <label class="blade-checkbox-row">
                                                        <input type="checkbox" name="checklist[<?php echo e($index); ?>][completed]" value="1" <?php if((bool) ($item['completed'] ?? false)): echo 'checked'; endif; ?>>
                                                        <?php echo e($item['label'] ?? $item['code'] ?? 'Checklist item'); ?>

                                                    </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <button type="submit" class="blade-primary-action">Update checklist</button>
                                            </form>
                                        </details>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('issueLetter', $handover)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Issue letter</summary>
                                            <form method="POST" action="<?php echo e(route('possession.handovers.letter.issue', $handover)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <input type="text" name="possession_letter_reference" required maxlength="255" placeholder="Possession letter reference">
                                                <button type="submit" class="blade-primary-action">Issue possession letter</button>
                                            </form>
                                        </details>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('complete', $handover)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Complete</summary>
                                            <form method="POST" action="<?php echo e(route('possession.handovers.complete', $handover)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <input type="date" name="actual_handover_on" value="<?php echo e(now()->toDateString()); ?>" max="<?php echo e(now()->toDateString()); ?>" required>
                                                <input type="text" name="possession_letter_reference" value="<?php echo e($handover->possession_letter_reference); ?>" required maxlength="255" placeholder="Issued possession letter reference">
                                                <button type="submit" class="blade-primary-action">Complete handover</button>
                                            </form>
                                        </details>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('update', $handover)): ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('issueLetter', $handover)): ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('complete', $handover)): ?>
                                                <span>No action</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No handovers match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination"><?php echo e($handovers->links()); ?></div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/developer/public_html/builder360/resources/views/possession/handovers/index.blade.php ENDPATH**/ ?>