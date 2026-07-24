

<?php $__env->startSection('title', 'Construction Progress - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<div class="blade-workspace" aria-labelledby="construction-progress-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Construction Operations</p>
                <h1 id="construction-progress-title">Construction Progress Workspace</h1>
                <p>
                    Workspace for project milestones, planned versus actual progress,
                    daily site reports, manpower, safety observations, blockers and approval control.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('construction.milestones.index')); ?>">Milestones</a>
                <a href="<?php echo e(route('construction.daily-progress-reports.index')); ?>">Daily reports</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status">
                <?php echo e(session('status')); ?>

            </section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Construction action was not completed.</strong>
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
                        <span class="blade-dashboard-label">Milestones</span>
                        <h2>Progress summary</h2>
                    </div>
                    <small><?php echo e($milestones->total()); ?> milestone record(s)</small>
                </div>

                <div class="blade-dashboard-metrics">
                    <?php $__currentLoopData = $milestoneStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="blade-dashboard-metric">
                            <span><?php echo e($label); ?></span>
                            <strong><?php echo e(number_format((int) ($milestoneMetrics[$status] ?? 0))); ?></strong>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Daily Progress Reports</span>
                        <h2>Approval summary</h2>
                    </div>
                    <small><?php echo e($dailyReports->total()); ?> DPR record(s)</small>
                </div>

                <div class="blade-dashboard-metrics">
                    <?php $__currentLoopData = $dailyReportStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="blade-dashboard-metric">
                            <span><?php echo e($label); ?></span>
                            <strong><?php echo e(number_format((int) ($dailyReportMetrics[$status] ?? 0))); ?></strong>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </article>
        </section>

        <section class="blade-workspace-grid">
            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Create</span>
                        <h2>New construction milestone</h2>
                    </div>
                    <small><?php echo e($canCreateMilestone ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateMilestone): ?>
                    <form method="POST" action="<?php echo e(route('construction.milestones.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <label>
                            Project
                            <select name="project_id" required>
                                <option value="">Select project</option>
                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($project->id); ?>" <?php if((string) old('project_id', $projects->first()?->id) === (string) $project->id): echo 'selected'; endif; ?>>
                                        <?php echo e($project->code); ?> &middot; <?php echo e($project->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Milestone code
                            <input type="text" name="milestone_code" value="<?php echo e(old('milestone_code')); ?>" maxlength="40" required>
                        </label>

                        <label>
                            Milestone name
                            <input type="text" name="name" value="<?php echo e(old('name')); ?>" maxlength="255" required>
                        </label>

                        <label>
                            Phase
                            <input type="text" name="phase" value="<?php echo e(old('phase')); ?>" maxlength="120" required>
                        </label>

                        <label>
                            Planned start
                            <input type="date" name="planned_start_on" value="<?php echo e(old('planned_start_on')); ?>" required>
                        </label>

                        <label>
                            Planned end
                            <input type="date" name="planned_end_on" value="<?php echo e(old('planned_end_on')); ?>" required>
                        </label>

                        <label>
                            Weight %
                            <input type="number" name="weight_percent" value="<?php echo e(old('weight_percent')); ?>" min="0" max="100" step="0.01" required>
                        </label>

                        <button type="submit" class="blade-primary-action">Create milestone</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view construction milestones but cannot create new milestones.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Submit</span>
                        <h2>Daily progress report</h2>
                    </div>
                    <small><?php echo e($canCreateDailyReport ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateDailyReport): ?>
                    <form method="POST" action="<?php echo e(route('construction.daily-progress-reports.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <label>
                            Project
                            <select name="project_id" required>
                                <option value="">Select project</option>
                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($project->id); ?>" <?php if((string) old('project_id', $projects->first()?->id) === (string) $project->id): echo 'selected'; endif; ?>>
                                        <?php echo e($project->code); ?> &middot; <?php echo e($project->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Report date
                            <input type="date" name="report_date" value="<?php echo e(old('report_date', now()->toDateString())); ?>" max="<?php echo e(now()->toDateString()); ?>" required>
                        </label>

                        <label>
                            Weather
                            <input type="text" name="weather" value="<?php echo e(old('weather')); ?>" maxlength="120" placeholder="Clear / rainy / cloudy">
                        </label>

                        <label>
                            Manpower count
                            <input type="number" name="manpower_count" value="<?php echo e(old('manpower_count', 0)); ?>" min="0" max="50000" required>
                        </label>

                        <label>
                            Milestone
                            <select name="progress_items[0][milestone_id]" required>
                                <option value="">Select milestone</option>
                                <?php $__currentLoopData = $milestoneOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $milestone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($milestone->id); ?>" <?php if((string) old('progress_items.0.milestone_id') === (string) $milestone->id): echo 'selected'; endif; ?>>
                                        <?php echo e($milestone->milestone_code); ?> &middot; <?php echo e($milestone->name); ?> &middot; <?php echo e(number_format((float) $milestone->progress_percent, 2)); ?>%
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Progress %
                            <input type="number" name="progress_items[0][progress_percent]" value="<?php echo e(old('progress_items.0.progress_percent')); ?>" min="0" max="100" step="0.01" required>
                        </label>

                        <label>
                            Work done
                            <textarea name="progress_items[0][work_done]" maxlength="1000" required><?php echo e(old('progress_items.0.work_done')); ?></textarea>
                        </label>

                        <label>
                            Work summary
                            <textarea name="work_summary" maxlength="8000" required><?php echo e(old('work_summary')); ?></textarea>
                        </label>

                        <label>
                            Safety observations
                            <textarea name="safety_observations" maxlength="5000"><?php echo e(old('safety_observations')); ?></textarea>
                        </label>

                        <label>
                            Quality observations
                            <textarea name="quality_observations" maxlength="5000"><?php echo e(old('quality_observations')); ?></textarea>
                        </label>

                        <label>
                            Blockers / delay reasons
                            <textarea name="blockers" maxlength="5000"><?php echo e(old('blockers')); ?></textarea>
                        </label>

                        <button type="submit" class="blade-primary-action">Submit DPR</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view daily reports but cannot submit new reports.</p>
                <?php endif; ?>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Controls</span>
                    <h2>Milestone filters</h2>
                </div>
                <small>Company-level</small>
            </div>

            <form method="GET" action="<?php echo e(route('construction.milestones.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
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
                    Status
                    <select name="status">
                        <option value="">All statuses</option>
                        <?php $__currentLoopData = $milestoneStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>

                <label>
                    Phase
                    <select name="phase">
                        <option value="">All phases</option>
                        <?php $__currentLoopData = $phases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($phase); ?>" <?php if(($filters['phase'] ?? '') === $phase): echo 'selected'; endif; ?>><?php echo e($phase); ?></option>
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
                    <h2>Construction milestones</h2>
                </div>
                <small><?php echo e($milestones->firstItem() ?? 0); ?>-<?php echo e($milestones->lastItem() ?? 0); ?> of <?php echo e($milestones->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Milestone</th>
                            <th scope="col">Project</th>
                            <th scope="col">Phase</th>
                            <th scope="col">Plan</th>
                            <th scope="col">Actual</th>
                            <th scope="col">Weight</th>
                            <th scope="col">Progress</th>
                            <th scope="col">Owner</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $milestones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $milestone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($milestone->milestone_code); ?></strong>
                                    <span><?php echo e($milestone->name); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($milestone->project?->code ?? 'No project'); ?></strong>
                                    <span><?php echo e($milestone->project?->name ?? 'Project missing'); ?></span>
                                </td>
                                <td><?php echo e($milestone->phase); ?></td>
                                <td>
                                    <strong><?php echo e($milestone->planned_start_on?->format('d M Y')); ?></strong>
                                    <span><?php echo e($milestone->planned_end_on?->format('d M Y')); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($milestone->actual_start_on?->format('d M Y') ?? 'Not started'); ?></strong>
                                    <span><?php echo e($milestone->actual_end_on?->format('d M Y') ?? 'Not completed'); ?></span>
                                </td>
                                <td><?php echo e(number_format((float) $milestone->weight_percent, 2)); ?>%</td>
                                <td>
                                    <strong><?php echo e(number_format((float) $milestone->progress_percent, 2)); ?>%</strong>
                                    <span><?php echo e($milestoneStatuses[$milestone->status] ?? str($milestone->status)->headline()); ?></span>
                                </td>
                                <td><?php echo e($milestone->createdBy?->name ?? 'System'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8">No milestones match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination">
                <?php echo e($milestones->links()); ?>

            </div>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Controls</span>
                    <h2>Daily report filters</h2>
                </div>
                <small>Approval workflow</small>
            </div>

            <form method="GET" action="<?php echo e(route('construction.daily-progress-reports.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
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
                    Status
                    <select name="status">
                        <option value="">All statuses</option>
                        <?php $__currentLoopData = $dailyReportStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>

                <label>
                    From
                    <input type="date" name="date_from" value="<?php echo e($filters['date_from'] ?? ''); ?>">
                </label>

                <label>
                    To
                    <input type="date" name="date_to" value="<?php echo e($filters['date_to'] ?? ''); ?>">
                </label>

                <button type="submit" class="blade-secondary-action">Apply filters</button>
            </form>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Daily progress reports</h2>
                </div>
                <small><?php echo e($dailyReports->firstItem() ?? 0); ?>-<?php echo e($dailyReports->lastItem() ?? 0); ?> of <?php echo e($dailyReports->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">DPR</th>
                            <th scope="col">Project</th>
                            <th scope="col">Summary</th>
                            <th scope="col">Manpower</th>
                            <th scope="col">Progress line</th>
                            <th scope="col">Status</th>
                            <th scope="col">Prepared / Approved</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $dailyReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $firstProgress = collect($report->progress_items ?? [])->first();
                            ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($report->report_number); ?></strong>
                                    <span><?php echo e($report->report_date?->format('d M Y')); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($report->project?->code ?? 'No project'); ?></strong>
                                    <span><?php echo e($report->project?->name ?? 'Project missing'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e(str($report->work_summary)->limit(80)); ?></strong>
                                    <?php if($report->blockers): ?>
                                        <span>Blocker: <?php echo e(str($report->blockers)->limit(70)); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e(number_format($report->manpower_count)); ?></td>
                                <td>
                                    <?php if($firstProgress): ?>
                                        <strong><?php echo e($firstProgress['milestone_code'] ?? 'Milestone'); ?> &middot; <?php echo e(number_format((float) ($firstProgress['progress_percent'] ?? 0), 2)); ?>%</strong>
                                        <span><?php echo e(str($firstProgress['work_done'] ?? 'Work details unavailable')->limit(80)); ?></span>
                                    <?php else: ?>
                                        No progress line
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($dailyReportStatuses[$report->status] ?? str($report->status)->headline()); ?></td>
                                <td>
                                    <strong><?php echo e($report->preparedBy?->name ?? 'Unknown'); ?></strong>
                                    <span><?php echo e($report->approvedBy?->name ?? 'Approval pending'); ?></span>
                                </td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve', $report)): ?>
                                        <div class="blade-table-action-stack">
                                            <form method="POST" action="<?php echo e(route('construction.daily-progress-reports.approve', $report)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <input type="text" name="note" value="<?php echo e(old('note')); ?>" maxlength="1000" placeholder="Approval note">
                                                <button type="submit" class="blade-primary-action">Approve DPR</button>
                                            </form>

                                            <form method="POST" action="<?php echo e(route('construction.daily-progress-reports.reject', $report)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <input type="text" name="reason" value="<?php echo e(old('reason')); ?>" maxlength="2000" placeholder="Required rejection reason" required>
                                                <button type="submit" class="blade-secondary-action">Reject DPR</button>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <span><?php echo e($report->status === 'submitted' ? 'Approval unavailable' : 'Closed'); ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8">No daily progress reports match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination">
                <?php echo e($dailyReports->links()); ?>

            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\construction\progress\index.blade.php ENDPATH**/ ?>