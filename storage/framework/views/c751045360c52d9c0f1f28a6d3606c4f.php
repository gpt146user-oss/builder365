

<?php $__env->startSection('title', 'Site Visits - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $projectOptions = $leads
            ->pluck('project')
            ->filter()
            ->unique('id')
            ->sortBy('code')
            ->values();
    ?>

    <div class="blade-workspace" aria-labelledby="site-visits-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Sales and CRM</p>
                <h1 id="site-visits-title">Site Visits</h1>
                <p>
                    Workspace for site visit planning, assignee conflict validation,
                    attendee capture, completion outcomes, cancellation and follow-up updates.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('crm.leads.index')); ?>">Lead Management</a>
                <a href="<?php echo e(route('crm.lead-qualifications.index')); ?>">Lead Qualification</a>
                <a href="<?php echo e(route('crm.site-visits.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status">
                <?php echo e(session('status')); ?>

            </section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Site visit action was not saved.</strong>
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
                        <h2>Schedule site visit</h2>
                    </div>
                    <small><?php echo e($canSchedule ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canSchedule): ?>
                    <form method="POST" action="<?php echo e(route('crm.site-visits.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <label>
                            Lead
                            <select name="lead_id" required>
                                <option value="">Select lead</option>
                                <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($lead->id); ?>" <?php if((string) old('lead_id', $filters['lead_id'] ?? '') === (string) $lead->id): echo 'selected'; endif; ?>>
                                        <?php echo e($lead->lead_code); ?> · <?php echo e($lead->customer?->name ?? 'Customer pending'); ?> · <?php echo e($lead->project?->code ?? 'No project'); ?>

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
                                        <?php echo e($assignee->name); ?> · <?php echo e($assignee->email); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Scheduled at
                            <input type="datetime-local" name="scheduled_at" value="<?php echo e(old('scheduled_at')); ?>" required>
                        </label>

                        <label>
                            Duration minutes
                            <input type="number" name="duration_minutes" value="<?php echo e(old('duration_minutes', 60)); ?>" min="15" max="480" step="15">
                        </label>

                        <label>
                            Visit mode
                            <select name="visit_mode" required>
                                <?php $__currentLoopData = $visitModes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('visit_mode', 'site') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Location
                            <input type="text" name="meeting_location" value="<?php echo e(old('meeting_location')); ?>" maxlength="255" placeholder="Site office / sales gallery">
                        </label>

                        <label class="blade-form-wide">
                            Meeting URL
                            <input type="url" name="meeting_url" value="<?php echo e(old('meeting_url')); ?>" maxlength="1024" placeholder="For virtual meetings">
                        </label>

                        <label class="blade-form-wide">
                            Agenda
                            <textarea name="agenda" maxlength="5000" rows="3" placeholder="Visit agenda, inventory to show, discussion points."><?php echo e(old('agenda')); ?></textarea>
                        </label>

                        <label>
                            Attendee name
                            <input type="text" name="attendees[0][name]" value="<?php echo e(old('attendees.0.name')); ?>" maxlength="255" placeholder="Customer / family / advisor">
                        </label>

                        <label>
                            Attendee phone
                            <input type="text" name="attendees[0][phone]" value="<?php echo e(old('attendees.0.phone')); ?>" maxlength="40">
                        </label>

                        <label>
                            Attendee role
                            <input type="text" name="attendees[0][role]" value="<?php echo e(old('attendees.0.role', 'Buyer')); ?>" maxlength="80">
                        </label>

                        <button type="submit" class="blade-primary-action">Schedule visit</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view site visits but cannot schedule new visits.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Visit filters</h2>
                    </div>
                    <small><?php echo e($visits->total()); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('crm.site-visits.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                    <label>
                        Lead
                        <select name="lead_id">
                            <option value="">All leads</option>
                            <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($lead->id); ?>" <?php if((string) ($filters['lead_id'] ?? '') === (string) $lead->id): echo 'selected'; endif; ?>>
                                    <?php echo e($lead->lead_code); ?> · <?php echo e($lead->customer?->name ?? 'Customer pending'); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>

                    <label>
                        Project
                        <select name="project_id">
                            <option value="">All projects</option>
                            <?php $__currentLoopData = $projectOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($project->id); ?>" <?php if((string) ($filters['project_id'] ?? '') === (string) $project->id): echo 'selected'; endif; ?>>
                                    <?php echo e($project->code); ?> · <?php echo e($project->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>

                    <label>
                        Assignee
                        <select name="assigned_to_user_id">
                            <option value="">All assignees</option>
                            <?php $__currentLoopData = $assignees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($assignee->id); ?>" <?php if((string) ($filters['assigned_to_user_id'] ?? '') === (string) $assignee->id): echo 'selected'; endif; ?>>
                                    <?php echo e($assignee->name); ?>

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
                        Mode
                        <select name="visit_mode">
                            <option value="">All modes</option>
                            <?php $__currentLoopData = $visitModes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['visit_mode'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>

                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>

                <div class="blade-workspace-note">
                    Scheduling, rescheduling and completion use the configured workflow engine, including assignee time-conflict validation.
                </div>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Site visit calendar/list</h2>
                </div>
                <small><?php echo e($visits->firstItem() ?? 0); ?>-<?php echo e($visits->lastItem() ?? 0); ?> of <?php echo e($visits->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Visit</th>
                            <th scope="col">Lead / customer</th>
                            <th scope="col">Schedule</th>
                            <th scope="col">Mode</th>
                            <th scope="col">Assigned</th>
                            <th scope="col">Status</th>
                            <th scope="col">Outcome</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $visits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($visit->visit_number); ?></strong>
                                    <span><?php echo e($visit->project?->code ?? 'No project'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($visit->lead?->lead_code ?? 'Lead missing'); ?></strong>
                                    <span><?php echo e($visit->customer?->name ?? 'Customer pending'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($visit->scheduled_at?->format('d M Y H:i') ?? 'Not scheduled'); ?></strong>
                                    <span><?php echo e($visit->duration_minutes ?? 60); ?> minutes</span>
                                </td>
                                <td>
                                    <strong><?php echo e($visitModes[$visit->visit_mode] ?? str($visit->visit_mode)->headline()); ?></strong>
                                    <span><?php echo e($visit->meeting_location ?? $visit->meeting_url ?? 'Venue pending'); ?></span>
                                </td>
                                <td><?php echo e($visit->assignedTo?->name ?? 'Self / unassigned'); ?></td>
                                <td><?php echo e($statuses[$visit->status] ?? str($visit->status)->headline()); ?></td>
                                <td>
                                    <strong><?php echo e($visit->outcome ? str($visit->outcome)->headline() : 'Pending'); ?></strong>
                                    <span><?php echo e($visit->next_follow_up_at?->format('d M Y H:i') ?? 'No next follow-up'); ?></span>
                                </td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $visit)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Update</summary>
                                            <form method="POST" action="<?php echo e(route('crm.site-visits.update', $visit)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <select name="assigned_to_user_id">
                                                    <option value="">Assign to me</option>
                                                    <?php $__currentLoopData = $assignees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($assignee->id); ?>" <?php if($visit->assigned_to_user_id === $assignee->id): echo 'selected'; endif; ?>><?php echo e($assignee->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <input type="datetime-local" name="scheduled_at" value="<?php echo e($visit->scheduled_at?->format('Y-m-d\TH:i')); ?>" required>
                                                <input type="number" name="duration_minutes" value="<?php echo e($visit->duration_minutes ?? 60); ?>" min="15" max="480" step="15">
                                                <select name="visit_mode" required>
                                                    <?php $__currentLoopData = $visitModes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($value); ?>" <?php if($visit->visit_mode === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <input type="text" name="meeting_location" value="<?php echo e($visit->meeting_location); ?>" maxlength="255" placeholder="Location">
                                                <textarea name="agenda" maxlength="5000" rows="2" placeholder="Agenda"><?php echo e($visit->agenda); ?></textarea>
                                                <button type="submit" class="blade-secondary-action">Save</button>
                                            </form>
                                        </details>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('complete', $visit)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Complete</summary>
                                            <form method="POST" action="<?php echo e(route('crm.site-visits.complete', $visit)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <select name="outcome" required>
                                                    <?php $__currentLoopData = $outcomes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <textarea name="outcome_notes" required maxlength="5000" rows="2" placeholder="Outcome notes"></textarea>
                                                <input type="datetime-local" name="next_follow_up_at">
                                                <button type="submit" class="blade-primary-action">Complete</button>
                                            </form>
                                        </details>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cancel', $visit)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Cancel</summary>
                                            <form method="POST" action="<?php echo e(route('crm.site-visits.cancel', $visit)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <textarea name="reason" required maxlength="1000" rows="2" placeholder="Cancellation reason"></textarea>
                                                <button type="submit" class="blade-secondary-action">Cancel visit</button>
                                            </form>
                                        </details>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('update', $visit)): ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('complete', $visit)): ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('cancel', $visit)): ?>
                                                <span>No action</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8">No site visits match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination">
                <?php echo e($visits->links()); ?>

            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/developer/public_html/builder360/resources/views/crm/site-visits/index.blade.php ENDPATH**/ ?>