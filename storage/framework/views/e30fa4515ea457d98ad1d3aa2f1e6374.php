

<?php $__env->startSection('title', 'Common Area Handover - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<div class="blade-workspace" aria-labelledby="handover-items-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Society Operations</p>
                <h1 id="handover-items-title">Common Area Handover</h1>
                <p>
                    Workspace for common-area facility checklist progress,
                    snag summaries, responsible users and sign-off before society handover.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('maintenance.societies.index')); ?>">Societies</a>
                <a href="<?php echo e(route('maintenance.dues.index')); ?>">Maintenance Dues</a>
                <a href="<?php echo e(route('maintenance.handover-items.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status"><?php echo e(session('status')); ?></section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Common-area handover action was not saved.</strong>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </section>
        <?php endif; ?>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Controls</span>
                    <h2>Handover item filters</h2>
                </div>
                <small><?php echo e($items->total()); ?> record(s)</small>
            </div>

            <form method="GET" action="<?php echo e(route('maintenance.handover-items.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
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
                    Society
                    <select name="society_formation_id">
                        <option value="">All societies</option>
                        <?php $__currentLoopData = $societies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $society): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($society->id); ?>" <?php if((string) ($filters['society_formation_id'] ?? '') === (string) $society->id): echo 'selected'; endif; ?>>
                                <?php echo e($society->formation_number); ?> - <?php echo e($society->society_name); ?>

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
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Common-area handover checklist</h2>
                </div>
                <small><?php echo e($items->firstItem() ?? 0); ?>-<?php echo e($items->lastItem() ?? 0); ?> of <?php echo e($items->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Project / society</th>
                            <th scope="col">Checklist</th>
                            <th scope="col">Snags</th>
                            <th scope="col">Ownership</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($item->item_number); ?></strong>
                                    <span><?php echo e($item->facility_name); ?></span>
                                    <span><?php echo e($item->category); ?></span>
                                    <span>Target <?php echo e($item->target_completion_on?->format('d M Y') ?? 'Not set'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($item->project?->code ?? 'Project missing'); ?></strong>
                                    <span><?php echo e($item->societyFormation?->formation_number ?? 'Society missing'); ?></span>
                                    <span><?php echo e($item->societyFormation?->society_name ?? 'Society missing'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($item->checklist_completed); ?> / <?php echo e($item->checklist_total); ?></strong>
                                    <span><?php echo e($item->checklist_total > 0 ? round(($item->checklist_completed / $item->checklist_total) * 100) : 0); ?>% complete</span>
                                </td>
                                <td>
                                    <?php $__empty_2 = true; $__currentLoopData = ($item->snag_summary ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <span><?php echo e(str($key)->headline()); ?>: <?php echo e(is_scalar($value) ? $value : json_encode($value)); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <span>No snag summary</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong>Responsible <?php echo e($item->responsibleUser?->name ?? 'Unassigned'); ?></strong>
                                    <span>Signed off by <?php echo e($item->signedOffBy?->name ?? 'Pending'); ?></span>
                                    <span><?php echo e($item->signed_off_on?->format('d M Y') ?? 'Sign-off pending'); ?></span>
                                </td>
                                <td><?php echo e($statuses[$item->status] ?? str($item->status)->headline()); ?></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $item)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Update</summary>
                                            <form method="POST" action="<?php echo e(route('maintenance.handover-items.update', $item)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <input type="number" name="checklist_completed" value="<?php echo e($item->checklist_completed); ?>" min="0" max="<?php echo e($item->checklist_total); ?>" required>
                                                <select name="status" required>
                                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($value); ?>" <?php if($item->status === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <textarea name="note" maxlength="1000" rows="2" placeholder="Checklist update note"></textarea>
                                                <button type="submit" class="blade-primary-action">Update item</button>
                                            </form>
                                        </details>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('signOff', $item)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Sign off</summary>
                                            <form method="POST" action="<?php echo e(route('maintenance.handover-items.sign-off', $item)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <textarea name="note" maxlength="1000" rows="2" placeholder="Sign-off note"></textarea>
                                                <button type="submit" class="blade-primary-action">Sign off</button>
                                            </form>
                                        </details>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('update', $item)): ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('signOff', $item)): ?>
                                            <span>No action</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No common-area handover items match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination"><?php echo e($items->links()); ?></div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/maintenance/handover-items/index.blade.php ENDPATH**/ ?>