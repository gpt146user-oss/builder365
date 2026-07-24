

<?php $__env->startSection('title', 'Compliance Obligations - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<div class="blade-workspace" aria-labelledby="compliance-obligations-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Legal Compliance Calendar</p>
                <h1 id="compliance-obligations-title">Compliance Obligations</h1>
                <p>
                    Workspace for project and company compliance tasks,
                    due-date monitoring, priority, assignment, evidence capture, completion workflow and audit history.
                    This is a tracking register only and is not legal, tax or labour-law advice.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('legal.rera-registrations.index')); ?>">RERA</a>
                <a href="<?php echo e(route('legal.project-approvals.index')); ?>">Project Approvals</a>
                <a href="<?php echo e(route('documents.index')); ?>">Documents</a>
                <a href="<?php echo e(route('legal.compliance-obligations.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status"><?php echo e(session('status')); ?></section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Compliance obligation action was not saved.</strong>
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
                        <h2>Create compliance obligation</h2>
                    </div>
                    <small><?php echo e($canCreateObligation ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateObligation): ?>
                    <form method="POST" action="<?php echo e(route('legal.compliance-obligations.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <label>
                            Project
                            <select name="project_id">
                                <option value="">Company-level obligation</option>
                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($project->id); ?>" <?php if((string) old('project_id') === (string) $project->id): echo 'selected'; endif; ?>>
                                        <?php echo e($project->code); ?> - <?php echo e($project->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Assigned to
                            <select name="assigned_to_user_id">
                                <option value="">Assign to me</option>
                                <?php $__currentLoopData = $assignees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($assignee->id); ?>" <?php if((string) old('assigned_to_user_id') === (string) $assignee->id): echo 'selected'; endif; ?>>
                                        <?php echo e($assignee->name); ?> - <?php echo e($assignee->email); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label class="blade-form-wide">
                            Title
                            <input type="text" name="title" value="<?php echo e(old('title')); ?>" maxlength="255" required>
                        </label>

                        <label>
                            Compliance type
                            <input type="text" name="compliance_type" value="<?php echo e(old('compliance_type', 'RERA Quarterly Filing')); ?>" maxlength="120" required>
                        </label>

                        <label>
                            Due on
                            <input type="date" name="due_on" value="<?php echo e(old('due_on', now()->addDays(30)->toDateString())); ?>" required>
                        </label>

                        <label>
                            Frequency
                            <select name="frequency" required>
                                <?php $__currentLoopData = $frequencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('frequency', 'one_time') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Priority
                            <select name="priority" required>
                                <?php $__currentLoopData = $priorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('priority', 'normal') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label class="blade-form-wide">
                            Notes
                            <textarea name="notes" maxlength="5000" rows="3" placeholder="Requirement, authority, filing or internal instruction."><?php echo e(old('notes')); ?></textarea>
                        </label>

                        <button type="submit" class="blade-primary-action">Create obligation</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view obligations but cannot create new obligations.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Compliance filters</h2>
                    </div>
                    <small><?php echo e($obligations->total()); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('legal.compliance-obligations.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
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
                    <label>
                        Compliance type
                        <input type="text" name="compliance_type" value="<?php echo e($filters['compliance_type'] ?? ''); ?>" maxlength="120">
                    </label>
                    <label>
                        Due within days
                        <input type="number" name="due_within_days" value="<?php echo e($filters['due_within_days'] ?? ''); ?>" min="0" max="3650">
                    </label>
                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>

                <p class="blade-workspace-note">
                    Completion requires an evidence document/reference. Use the Documents module for versioned document storage.
                </p>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Compliance obligation register</h2>
                </div>
                <small><?php echo e($obligations->firstItem() ?? 0); ?>-<?php echo e($obligations->lastItem() ?? 0); ?> of <?php echo e($obligations->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Obligation</th>
                            <th scope="col">Scope</th>
                            <th scope="col">Due / priority</th>
                            <th scope="col">Assignment</th>
                            <th scope="col">Evidence</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $obligations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $obligation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($obligation->obligation_number); ?></strong>
                                    <span><?php echo e($obligation->title); ?></span>
                                    <span><?php echo e($obligation->compliance_type); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($obligation->project?->code ?? 'Company level'); ?></strong>
                                    <span><?php echo e($obligation->project?->name ?? 'No project scope'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($obligation->due_on?->format('d M Y') ?? 'Due date missing'); ?></strong>
                                    <span><?php echo e($frequencies[$obligation->frequency] ?? str($obligation->frequency)->headline()); ?></span>
                                    <span><?php echo e($priorities[$obligation->priority] ?? str($obligation->priority)->headline()); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($obligation->assignedTo?->name ?? 'Unassigned'); ?></strong>
                                    <span>Completed by <?php echo e($obligation->completedBy?->name ?? 'Pending'); ?></span>
                                    <span><?php echo e($obligation->completed_at?->format('d M Y H:i') ?? 'Open'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($obligation->evidence_document_reference ?? 'Evidence pending'); ?></strong>
                                    <span><?php echo e($obligation->notes ?? 'No notes'); ?></span>
                                </td>
                                <td><?php echo e($statuses[$obligation->status] ?? str($obligation->status)->headline()); ?></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('complete', $obligation)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Complete</summary>
                                            <form method="POST" action="<?php echo e(route('legal.compliance-obligations.complete', $obligation)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <input type="text" name="evidence_document_reference" required maxlength="255" placeholder="Evidence document/reference">
                                                <textarea name="notes" maxlength="5000" rows="2" placeholder="Completion notes"></textarea>
                                                <button type="submit" class="blade-primary-action">Complete obligation</button>
                                            </form>
                                        </details>
                                    <?php else: ?>
                                        <span>No action</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No compliance obligations match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination"><?php echo e($obligations->links()); ?></div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\legal\compliance-obligations\index.blade.php ENDPATH**/ ?>