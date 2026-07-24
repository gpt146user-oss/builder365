

<?php $__env->startSection('title', 'Society Formation - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<div class="blade-workspace" aria-labelledby="societies-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">After-Sales and Society Operations</p>
                <h1 id="societies-title">Society Formation</h1>
                <p>
                    Workspace for society or association formation, registration progress,
                    committee details, handover stage tracking and status update history.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('maintenance.handover-items.index')); ?>">Common Area Handover</a>
                <a href="<?php echo e(route('maintenance.dues.index')); ?>">Maintenance Dues</a>
                <a href="<?php echo e(route('possession.handovers.index')); ?>">Possession</a>
                <a href="<?php echo e(route('maintenance.societies.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status"><?php echo e(session('status')); ?></section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Society action was not saved.</strong>
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
                        <h2>Create society formation</h2>
                    </div>
                    <small><?php echo e($canCreateSociety ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateSociety): ?>
                    <form method="POST" action="<?php echo e(route('maintenance.societies.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <label class="blade-form-wide">
                            Project
                            <select name="project_id" required>
                                <option value="">Select active project</option>
                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($project->id); ?>" <?php if((string) old('project_id') === (string) $project->id): echo 'selected'; endif; ?>>
                                        <?php echo e($project->code); ?> - <?php echo e($project->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label class="blade-form-wide">
                            Society / association name
                            <input type="text" name="society_name" value="<?php echo e(old('society_name')); ?>" maxlength="255" required>
                        </label>

                        <label>
                            Association type
                            <select name="association_type">
                                <?php $__currentLoopData = $associationTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('association_type', 'cooperative_society') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Total units
                            <input type="number" name="total_units" value="<?php echo e(old('total_units')); ?>" min="1" max="10000" required>
                        </label>

                        <label>
                            Occupied units
                            <input type="number" name="occupied_units" value="<?php echo e(old('occupied_units', 0)); ?>" min="0" max="10000">
                        </label>

                        <label>
                            Status
                            <select name="status">
                                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('status', 'draft') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Progress %
                            <input type="number" name="progress_percent" value="<?php echo e(old('progress_percent')); ?>" min="0" max="100">
                        </label>

                        <label>
                            Application filed on
                            <input type="date" name="application_filed_on" value="<?php echo e(old('application_filed_on')); ?>" max="<?php echo e(now()->toDateString()); ?>">
                        </label>

                        <label>
                            Registered on
                            <input type="date" name="registered_on" value="<?php echo e(old('registered_on')); ?>" max="<?php echo e(now()->toDateString()); ?>">
                        </label>

                        <label>
                            Target handover on
                            <input type="date" name="target_handover_on" value="<?php echo e(old('target_handover_on')); ?>">
                        </label>

                        <label>
                            Registration number
                            <input type="text" name="registration_number" value="<?php echo e(old('registration_number')); ?>" maxlength="120">
                        </label>

                        <label>
                            Current stage
                            <input type="text" name="current_stage" value="<?php echo e(old('current_stage')); ?>" maxlength="120">
                        </label>

                        <label class="blade-form-wide">
                            Next step
                            <input type="text" name="next_step" value="<?php echo e(old('next_step')); ?>" maxlength="255">
                        </label>

                        <button type="submit" class="blade-primary-action">Create society</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view society records but cannot create them.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Society filters</h2>
                    </div>
                    <small><?php echo e($societies->total()); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('maintenance.societies.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
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
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Society formation register</h2>
                </div>
                <small><?php echo e($societies->firstItem() ?? 0); ?>-<?php echo e($societies->lastItem() ?? 0); ?> of <?php echo e($societies->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Formation</th>
                            <th scope="col">Project</th>
                            <th scope="col">Progress</th>
                            <th scope="col">Registration</th>
                            <th scope="col">Workflow</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $societies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $society): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($society->formation_number); ?></strong>
                                    <span><?php echo e($society->society_name); ?></span>
                                    <span><?php echo e($associationTypes[$society->association_type] ?? str($society->association_type)->headline()); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($society->project?->code ?? 'Project missing'); ?></strong>
                                    <span><?php echo e($society->project?->name ?? 'Project missing'); ?></span>
                                    <span><?php echo e($society->occupied_units); ?> / <?php echo e($society->total_units); ?> occupied</span>
                                </td>
                                <td>
                                    <strong><?php echo e($society->progress_percent); ?>%</strong>
                                    <span><?php echo e($society->current_stage); ?></span>
                                    <span><?php echo e($society->next_step ?? 'Next step not captured'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($society->registration_number ?? 'Registration pending'); ?></strong>
                                    <span>Filed <?php echo e($society->application_filed_on?->format('d M Y') ?? 'Not filed'); ?></span>
                                    <span>Registered <?php echo e($society->registered_on?->format('d M Y') ?? 'Pending'); ?></span>
                                    <span>Target handover <?php echo e($society->target_handover_on?->format('d M Y') ?? 'Not set'); ?></span>
                                </td>
                                <td>
                                    <strong>Created by <?php echo e($society->createdBy?->name ?? 'User missing'); ?></strong>
                                    <span>Updated by <?php echo e($society->updatedBy?->name ?? 'Pending'); ?></span>
                                </td>
                                <td><?php echo e($statuses[$society->status] ?? str($society->status)->headline()); ?></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $society)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Update status</summary>
                                            <form method="POST" action="<?php echo e(route('maintenance.societies.status', $society)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <select name="status" required>
                                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($value); ?>" <?php if($society->status === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <input type="number" name="progress_percent" value="<?php echo e($society->progress_percent); ?>" min="0" max="100" required>
                                                <input type="text" name="current_stage" value="<?php echo e($society->current_stage); ?>" maxlength="120" placeholder="Current stage">
                                                <input type="text" name="next_step" value="<?php echo e($society->next_step); ?>" maxlength="255" placeholder="Next step">
                                                <input type="text" name="registration_number" value="<?php echo e($society->registration_number); ?>" maxlength="120" placeholder="Registration number">
                                                <textarea name="note" maxlength="1000" rows="2" placeholder="Status update note"></textarea>
                                                <button type="submit" class="blade-primary-action">Update society</button>
                                            </form>
                                        </details>
                                    <?php else: ?>
                                        <span>No action</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No society records match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination"><?php echo e($societies->links()); ?></div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/maintenance/societies/index.blade.php ENDPATH**/ ?>