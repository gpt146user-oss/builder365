

<?php $__env->startSection('title', 'Prospect Inquiries - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<div class="blade-workspace" aria-labelledby="prospect-inquiries-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Customer Channels</p>
                <h1 id="prospect-inquiries-title">Prospect Inquiry Management</h1>
                <p>
                    Workspace for website, mobile, phone, email and partner inquiries with
                    company-level filtering, duplicate review, sales assignment, lead conversion and closure control.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('crm.leads.index')); ?>">Lead Management</a>
                <a href="<?php echo e(route('crm.prospect-inquiries.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status">
                <?php echo e(session('status')); ?>

            </section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Prospect inquiry action was not completed.</strong>
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
                        <span class="blade-dashboard-label">Live Register</span>
                        <h2>Inquiry status summary</h2>
                    </div>
                    <small><?php echo e($inquiries->total()); ?> filtered record(s)</small>
                </div>

                <div class="blade-dashboard-metrics">
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="blade-dashboard-metric">
                            <span><?php echo e($label); ?></span>
                            <strong><?php echo e(number_format((int) ($metrics[$status] ?? 0))); ?></strong>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <p class="blade-workspace-note">
                    Counts are shown from available prospect inquiries. Authorized CRM users can assign,
                    convert and close records from this workspace.
                </p>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Inquiry filters</h2>
                    </div>
                    <small>Company-level</small>
                </div>

                <form method="GET" action="<?php echo e(route('crm.prospect-inquiries.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                    <label>
                        Search
                        <input type="search" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" maxlength="120" placeholder="Inquiry no, name, email or phone">
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
                        Project
                        <select name="project_id">
                            <option value="">All projects</option>
                            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($project->id); ?>" <?php if((string) ($filters['project_id'] ?? '') === (string) $project->id): echo 'selected'; endif; ?>>
                                    <?php echo e($project->code); ?> &middot; <?php echo e($project->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>

                    <label>
                        Assigned to
                        <select name="assigned_to_user_id">
                            <option value="">Anyone</option>
                            <?php $__currentLoopData = $assignees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($assignee->id); ?>" <?php if((string) ($filters['assigned_to_user_id'] ?? '') === (string) $assignee->id): echo 'selected'; endif; ?>>
                                    <?php echo e($assignee->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>

                    <label>
                        Source
                        <select name="source">
                            <option value="">All sources</option>
                            <?php $__currentLoopData = $sources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($source); ?>" <?php if(($filters['source'] ?? '') === $source): echo 'selected'; endif; ?>><?php echo e($source); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>

                    <label>
                        Channel
                        <select name="channel">
                            <option value="">All channels</option>
                            <?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $channel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($channel); ?>" <?php if(($filters['channel'] ?? '') === $channel): echo 'selected'; endif; ?>><?php echo e(str($channel)->replace('_', ' ')->headline()); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>

                    <label>
                        Created from
                        <input type="date" name="created_from" value="<?php echo e($filters['created_from'] ?? ''); ?>">
                    </label>

                    <label>
                        Created to
                        <input type="date" name="created_to" value="<?php echo e($filters['created_to'] ?? ''); ?>">
                    </label>

                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>

                <div class="blade-workspace-note">
                    Only projects and assignees available to your company can be selected.
                </div>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Prospect inquiry queue</h2>
                </div>
                <small><?php echo e($inquiries->firstItem() ?? 0); ?>-<?php echo e($inquiries->lastItem() ?? 0); ?> of <?php echo e($inquiries->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Inquiry</th>
                            <th scope="col">Prospect</th>
                            <th scope="col">Project</th>
                            <th scope="col">Source</th>
                            <th scope="col">Budget</th>
                            <th scope="col">Status</th>
                            <th scope="col">Owner</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $inquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $isClosed = $inquiry->isClosed();
                                $canAct = $canManage && ! $isClosed;
                            ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($inquiry->inquiry_number); ?></strong>
                                    <span><?php echo e($inquiry->company?->code ?? 'Company missing'); ?> &middot; <?php echo e($inquiry->created_at?->format('d M Y H:i')); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($inquiry->name); ?></strong>
                                    <span><?php echo e($inquiry->phone ?? $inquiry->email ?? 'Contact pending'); ?></span>
                                    <?php if($inquiry->message): ?>
                                        <span><?php echo e(str($inquiry->message)->limit(90)); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo e($inquiry->project?->code ?? 'No project'); ?></strong>
                                    <span><?php echo e($inquiry->project?->name ?? 'Project not selected'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($inquiry->source); ?></strong>
                                    <span><?php echo e(str($inquiry->channel)->replace('_', ' ')->headline()); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($inquiry->budget_max ? number_format((float) $inquiry->budget_max, 2) : 'Max NA'); ?></strong>
                                    <span><?php echo e($inquiry->budget_min ? number_format((float) $inquiry->budget_min, 2) : 'Min NA'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($statuses[$inquiry->status] ?? str($inquiry->status)->headline()); ?></strong>
                                    <?php if($inquiry->duplicateOf): ?>
                                        <span>Duplicate of <?php echo e($inquiry->duplicateOf->inquiry_number); ?></span>
                                    <?php endif; ?>
                                    <?php if($inquiry->convertedLead): ?>
                                        <span>Lead <?php echo e($inquiry->convertedLead->lead_code); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($inquiry->assignedTo?->name ?? 'Unassigned'); ?></td>
                                <td>
                                    <?php if($canAct): ?>
                                        <div class="blade-table-action-stack">
                                            <form method="POST" action="<?php echo e(route('crm.prospect-inquiries.assign', $inquiry)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <label>
                                                    Assign owner
                                                    <select name="assigned_to_user_id" required>
                                                        <option value="">Select user</option>
                                                        <?php $__currentLoopData = $assignees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if((int) $assignee->company_id === (int) $inquiry->company_id): ?>
                                                                <option value="<?php echo e($assignee->id); ?>" <?php if((int) old('assigned_to_user_id', $inquiry->assigned_to_user_id) === (int) $assignee->id): echo 'selected'; endif; ?>>
                                                                    <?php echo e($assignee->name); ?>

                                                                </option>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </label>
                                                <input type="text" name="note" value="<?php echo e(old('note')); ?>" maxlength="1000" placeholder="Assignment note">
                                                <button type="submit" class="blade-secondary-action">Assign</button>
                                            </form>

                                            <?php if($inquiry->status !== \App\Models\ProspectInquiry::STATUS_DUPLICATE): ?>
                                                <form method="POST" action="<?php echo e(route('crm.prospect-inquiries.convert', $inquiry)); ?>" class="blade-inline-form">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <label>
                                                        Expected value
                                                        <input type="number" name="expected_value" value="<?php echo e(old('expected_value', $inquiry->budget_max ?? $inquiry->budget_min ?? 0)); ?>" min="0" step="0.01">
                                                    </label>
                                                    <label>
                                                        Lead stage
                                                        <select name="stage">
                                                            <?php $__currentLoopData = ['New', 'Qualified', 'Site Visit Planned', 'Negotiation']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($stage); ?>" <?php if(old('stage', 'New') === $stage): echo 'selected'; endif; ?>><?php echo e($stage); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </label>
                                                    <label>
                                                        Follow-up
                                                        <input type="datetime-local" name="follow_up_at" value="<?php echo e(old('follow_up_at')); ?>">
                                                    </label>
                                                    <label>
                                                        Campaign
                                                        <select name="marketing_campaign_id">
                                                            <option value="">No attribution</option>
                                                            <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if((int) $campaign->company_id === (int) $inquiry->company_id && ($campaign->project_id === null || (int) $campaign->project_id === (int) $inquiry->project_id)): ?>
                                                                    <option value="<?php echo e($campaign->id); ?>" <?php if((string) old('marketing_campaign_id') === (string) $campaign->id): echo 'selected'; endif; ?>>
                                                                        <?php echo e($campaign->campaign_code); ?> &middot; <?php echo e($campaign->name); ?>

                                                                    </option>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </label>
                                                    <input type="text" name="note" value="<?php echo e(old('note')); ?>" maxlength="1000" placeholder="Conversion note">
                                                    <button type="submit" class="blade-primary-action">Convert to lead</button>
                                                </form>
                                            <?php else: ?>
                                                <p class="blade-workspace-note">
                                                    Duplicate inquiries must be reviewed or closed before conversion.
                                                </p>
                                            <?php endif; ?>

                                            <form method="POST" action="<?php echo e(route('crm.prospect-inquiries.close', $inquiry)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <label>
                                                    Closure status
                                                    <select name="status" required>
                                                        <option value="<?php echo e(\App\Models\ProspectInquiry::STATUS_CLOSED_UNQUALIFIED); ?>">Closed - unqualified</option>
                                                        <option value="<?php echo e(\App\Models\ProspectInquiry::STATUS_CLOSED_DUPLICATE); ?>">Closed - duplicate</option>
                                                    </select>
                                                </label>
                                                <input type="text" name="reason" value="<?php echo e(old('reason')); ?>" maxlength="1000" placeholder="Required closure reason" required>
                                                <button type="submit" class="blade-secondary-action">Close</button>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <span><?php echo e($isClosed ? 'Closed' : 'Read only'); ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8">No prospect inquiries match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination">
                <?php echo e($inquiries->links()); ?>

            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\crm\prospect-inquiries\index.blade.php ENDPATH**/ ?>