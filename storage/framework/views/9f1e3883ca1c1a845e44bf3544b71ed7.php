

<?php $__env->startSection('title', 'Project Approvals - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<div class="blade-workspace" aria-labelledby="project-approvals-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Legal and Approvals</p>
                <h1 id="project-approvals-title">Project Approval Register</h1>
                <p>
                    Workspace for authority approvals, application numbers,
                    approval validity, document references, required-for usage and independent verification.
                    This is an operational tracking register only and is not legal advice.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('legal.rera-registrations.index')); ?>">RERA</a>
                <a href="<?php echo e(route('legal.compliance-obligations.index')); ?>">Compliance Calendar</a>
                <a href="<?php echo e(route('documents.index')); ?>">Documents</a>
                <a href="<?php echo e(route('legal.project-approvals.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status"><?php echo e(session('status')); ?></section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Project approval action was not saved.</strong>
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
                        <h2>Record project approval</h2>
                    </div>
                    <small><?php echo e($canCreateApproval ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateApproval): ?>
                    <form method="POST" action="<?php echo e(route('legal.project-approvals.store')); ?>" class="blade-form-grid">
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

                        <label>
                            Approval code
                            <input type="text" name="approval_code" value="<?php echo e(old('approval_code')); ?>" maxlength="80" required>
                        </label>

                        <label>
                            Approval type
                            <select name="approval_type" required>
                                <?php $__currentLoopData = $approvalTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('approval_type', 'Commencement Certificate') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Authority name
                            <input type="text" name="authority_name" value="<?php echo e(old('authority_name')); ?>" maxlength="160" required>
                        </label>

                        <label>
                            Application number
                            <input type="text" name="application_number" value="<?php echo e(old('application_number')); ?>" maxlength="120">
                        </label>

                        <label>
                            Status
                            <select name="status" required>
                                <option value="applied" <?php if(old('status', 'applied') === 'applied'): echo 'selected'; endif; ?>>Applied</option>
                                <option value="approved" <?php if(old('status') === 'approved'): echo 'selected'; endif; ?>>Approved</option>
                            </select>
                        </label>

                        <label>
                            Applied on
                            <input type="date" name="applied_on" value="<?php echo e(old('applied_on')); ?>">
                        </label>

                        <label>
                            Approved on
                            <input type="date" name="approved_on" value="<?php echo e(old('approved_on')); ?>">
                        </label>

                        <label>
                            Expires on
                            <input type="date" name="expires_on" value="<?php echo e(old('expires_on')); ?>">
                        </label>

                        <label>
                            Required for
                            <input type="text" name="required_for" value="<?php echo e(old('required_for')); ?>" maxlength="160" placeholder="Occupation certificate, launch, handover">
                        </label>

                        <label class="blade-form-wide">
                            Document reference
                            <input type="text" name="document_reference" value="<?php echo e(old('document_reference')); ?>" maxlength="255">
                        </label>

                        <fieldset class="blade-form-wide blade-fieldset">
                            <legend>Conditions</legend>
                            <div class="blade-form-grid">
                                <label>
                                    Condition 1
                                    <input type="text" name="conditions[0]" value="<?php echo e(old('conditions.0')); ?>" maxlength="500">
                                </label>
                                <label>
                                    Condition 2
                                    <input type="text" name="conditions[1]" value="<?php echo e(old('conditions.1')); ?>" maxlength="500">
                                </label>
                            </div>
                        </fieldset>

                        <button type="submit" class="blade-primary-action">Record approval</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view project approvals but cannot create approval records.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Approval filters</h2>
                    </div>
                    <small><?php echo e($approvals->total()); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('legal.project-approvals.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
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
                        Approval type
                        <input type="text" name="approval_type" value="<?php echo e($filters['approval_type'] ?? ''); ?>" maxlength="120">
                    </label>
                    <label>
                        Expiring within days
                        <input type="number" name="expires_within_days" value="<?php echo e($filters['expires_within_days'] ?? ''); ?>" min="0" max="3650">
                    </label>
                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>

                <p class="blade-workspace-note">Verification is blocked for the same user who recorded the approval.</p>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Project approvals</h2>
                </div>
                <small><?php echo e($approvals->firstItem() ?? 0); ?>-<?php echo e($approvals->lastItem() ?? 0); ?> of <?php echo e($approvals->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Approval</th>
                            <th scope="col">Project</th>
                            <th scope="col">Dates</th>
                            <th scope="col">Document / conditions</th>
                            <th scope="col">Workflow</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $approvals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $approval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($approval->approval_code); ?></strong>
                                    <span><?php echo e($approval->approval_type); ?></span>
                                    <span><?php echo e($approval->authority_name); ?></span>
                                    <span><?php echo e($approval->application_number ?? 'No application number'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($approval->project?->code ?? 'Project missing'); ?></strong>
                                    <span><?php echo e($approval->project?->name ?? 'Project missing'); ?></span>
                                    <span>Required for: <?php echo e($approval->required_for ?? 'Not specified'); ?></span>
                                </td>
                                <td>
                                    <strong>Applied <?php echo e($approval->applied_on?->format('d M Y') ?? 'Not captured'); ?></strong>
                                    <span>Approved <?php echo e($approval->approved_on?->format('d M Y') ?? 'Not captured'); ?></span>
                                    <span>Expires <?php echo e($approval->expires_on?->format('d M Y') ?? 'Not captured'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($approval->document_reference ?? 'No document reference'); ?></strong>
                                    <?php $__empty_2 = true; $__currentLoopData = ($approval->conditions ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <span><?php echo e($condition); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <span>No conditions captured</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong>Responsible <?php echo e($approval->responsibleUser?->name ?? 'User missing'); ?></strong>
                                    <span>Verified by <?php echo e($approval->verifiedBy?->name ?? 'Pending'); ?></span>
                                    <span><?php echo e($approval->verified_at?->format('d M Y H:i') ?? 'Decision pending'); ?></span>
                                </td>
                                <td><?php echo e($statuses[$approval->status] ?? str($approval->status)->headline()); ?></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('verify', $approval)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Verify</summary>
                                            <form method="POST" action="<?php echo e(route('legal.project-approvals.verify', $approval)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <textarea name="verification_note" maxlength="2000" rows="2" placeholder="Verification note"></textarea>
                                                <button type="submit" class="blade-primary-action">Verify approval</button>
                                            </form>
                                        </details>
                                    <?php else: ?>
                                        <span>No action</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No project approvals match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination"><?php echo e($approvals->links()); ?></div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/legal/project-approvals/index.blade.php ENDPATH**/ ?>