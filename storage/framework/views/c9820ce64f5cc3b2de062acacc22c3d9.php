

<?php $__env->startSection('title', 'RERA Registrations - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<div class="blade-workspace" aria-labelledby="rera-registrations-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Legal and RERA Tracking</p>
                <h1 id="rera-registrations-title">RERA Registration Register</h1>
                <p>
                    Workspace for project-wise RERA registration tracking,
                    validity reminders, document references, maker-checker verification and audit history.
                    This is a tracking register only and is not legal advice.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('legal.project-approvals.index')); ?>">Project Approvals</a>
                <a href="<?php echo e(route('legal.compliance-obligations.index')); ?>">Compliance Calendar</a>
                <a href="<?php echo e(route('documents.index')); ?>">Documents</a>
                <a href="<?php echo e(route('legal.rera-registrations.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status"><?php echo e(session('status')); ?></section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>RERA action was not saved.</strong>
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
                        <h2>Submit RERA registration</h2>
                    </div>
                    <small><?php echo e($canCreateRegistration ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateRegistration): ?>
                    <form method="POST" action="<?php echo e(route('legal.rera-registrations.store')); ?>" class="blade-form-grid">
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
                            Registration number
                            <input type="text" name="registration_number" value="<?php echo e(old('registration_number')); ?>" maxlength="80" required>
                        </label>

                        <label>
                            Authority name
                            <input type="text" name="authority_name" value="<?php echo e(old('authority_name', 'MahaRERA')); ?>" maxlength="160" required>
                        </label>

                        <label>
                            State code
                            <input type="text" name="state_code" value="<?php echo e(old('state_code', 'MH')); ?>" maxlength="10" required>
                        </label>

                        <label>
                            Registered on
                            <input type="date" name="registered_on" value="<?php echo e(old('registered_on', now()->toDateString())); ?>" required>
                        </label>

                        <label>
                            Expires on
                            <input type="date" name="expires_on" value="<?php echo e(old('expires_on')); ?>">
                        </label>

                        <label class="blade-form-wide">
                            Document reference
                            <input type="text" name="document_reference" value="<?php echo e(old('document_reference')); ?>" maxlength="255" placeholder="Managed document reference or authority certificate number">
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

                        <button type="submit" class="blade-primary-action">Submit RERA registration</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view RERA registrations but cannot submit new registrations.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>RERA filters</h2>
                    </div>
                    <small><?php echo e($registrations->total()); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('legal.rera-registrations.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
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
                        Expiring within days
                        <input type="number" name="expires_within_days" value="<?php echo e($filters['expires_within_days'] ?? ''); ?>" min="0" max="3650">
                    </label>
                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>

                <p class="blade-workspace-note">
                    RERA dates, authority records and statutory correctness must be validated by the client or appointed legal expert before production reliance.
                </p>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>RERA registrations</h2>
                </div>
                <small><?php echo e($registrations->firstItem() ?? 0); ?>-<?php echo e($registrations->lastItem() ?? 0); ?> of <?php echo e($registrations->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Registration</th>
                            <th scope="col">Project</th>
                            <th scope="col">Validity</th>
                            <th scope="col">Documents / conditions</th>
                            <th scope="col">Workflow</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($registration->registration_number); ?></strong>
                                    <span><?php echo e($registration->authority_name); ?></span>
                                    <span>State <?php echo e($registration->state_code); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($registration->project?->code ?? 'Project missing'); ?></strong>
                                    <span><?php echo e($registration->project?->name ?? 'Project missing'); ?></span>
                                </td>
                                <td>
                                    <strong>Registered <?php echo e($registration->registered_on?->format('d M Y') ?? 'Pending'); ?></strong>
                                    <span>Expires <?php echo e($registration->expires_on?->format('d M Y') ?? 'Not captured'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($registration->document_reference ?? 'No document reference'); ?></strong>
                                    <?php $__empty_2 = true; $__currentLoopData = ($registration->conditions ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <span><?php echo e($condition); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <span>No conditions captured</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong>Submitted by <?php echo e($registration->createdBy?->name ?? 'User missing'); ?></strong>
                                    <span>Verified by <?php echo e($registration->verifiedBy?->name ?? 'Pending'); ?></span>
                                    <span><?php echo e($registration->verified_at?->format('d M Y H:i') ?? 'Decision pending'); ?></span>
                                </td>
                                <td><?php echo e($statuses[$registration->status] ?? str($registration->status)->headline()); ?></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('verify', $registration)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Verify</summary>
                                            <form method="POST" action="<?php echo e(route('legal.rera-registrations.verify', $registration)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <textarea name="verification_note" maxlength="2000" rows="2" placeholder="Verification note" aria-label="RERA verification note"></textarea>
                                                <button type="submit" class="blade-primary-action">Verify RERA</button>
                                            </form>
                                        </details>
                                    <?php else: ?>
                                        <span>No action</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No RERA registrations match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination"><?php echo e($registrations->links()); ?></div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/developer/public_html/builder360/resources/views/legal/rera-registrations/index.blade.php ENDPATH**/ ?>