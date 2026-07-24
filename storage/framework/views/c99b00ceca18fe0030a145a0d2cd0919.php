

<?php $__env->startSection('title', 'Project Master - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $money = fn ($amount) => 'Rs. '.number_format((float) ($amount ?? 0), 2);
        $percent = fn ($amount) => rtrim(rtrim(number_format((float) ($amount ?? 0), 2), '0'), '.').'%';
    ?>

    <div class="blade-workspace" aria-labelledby="project-master-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Projects</p>
                <h1 id="project-master-title">Project Master</h1>
                <p>
                    Workspace for project master data, branch/company access,
                    dates, budget, ROI, team assignment, unit/bookings summary and cost-ROI export.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('inventory.units.index')); ?>">Unit Inventory</a>
                <a href="<?php echo e(route('inventory.unit-price-versions.index')); ?>">Unit Pricing</a>
                <a href="<?php echo e(route('projects.cost-roi.export', array_merge(request()->query(), ['format' => 'csv']))); ?>">Export Cost/ROI CSV</a>
                <a href="<?php echo e(route('projects.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status">
                <?php echo e(session('status')); ?>

            </section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Project action was not saved.</strong>
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
                        <h2>Create project master</h2>
                    </div>
                    <small><?php echo e($canCreateProject ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateProject): ?>
                    <form method="POST" action="<?php echo e(route('projects.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <?php if (isset($component)) { $__componentOriginal5ee006ce6757c21855df609df2a8580f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5ee006ce6757c21855df609df2a8580f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.company-context','data' => ['companies' => $companies,'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.company-context'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['companies' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($companies),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5ee006ce6757c21855df609df2a8580f)): ?>
<?php $attributes = $__attributesOriginal5ee006ce6757c21855df609df2a8580f; ?>
<?php unset($__attributesOriginal5ee006ce6757c21855df609df2a8580f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5ee006ce6757c21855df609df2a8580f)): ?>
<?php $component = $__componentOriginal5ee006ce6757c21855df609df2a8580f; ?>
<?php unset($__componentOriginal5ee006ce6757c21855df609df2a8580f); ?>
<?php endif; ?>

                        <label>
                            Branch
                            <select name="branch_id">
                                <option value="">No branch</option>
                                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($branch->id); ?>" <?php if((string) old('branch_id') === (string) $branch->id): echo 'selected'; endif; ?>>
                                        <?php echo e($branch->code); ?> - <?php echo e($branch->name); ?> - <?php echo e($branch->city); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Project code
                            <input type="text" name="code" value="<?php echo e(old('code')); ?>" maxlength="32" pattern="[A-Z0-9-]+" placeholder="SKY-PUN" required>
                        </label>

                        <label>
                            Project name
                            <input type="text" name="name" value="<?php echo e(old('name')); ?>" maxlength="255" required>
                        </label>

                        <label>
                            Project type
                            <select name="project_type" required>
                                <?php $__currentLoopData = $projectTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('project_type', 'residential') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Status
                            <select name="status" required>
                                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('status', 'planned') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            City
                            <input type="text" name="city" value="<?php echo e(old('city')); ?>" maxlength="120" required>
                        </label>

                        <label>
                            State code
                            <input type="text" name="state" value="<?php echo e(old('state', 'MH')); ?>" maxlength="2" pattern="[A-Z]{2}" required>
                        </label>

                        <label>
                            Budget amount
                            <input type="number" name="budget_amount" value="<?php echo e(old('budget_amount', 0)); ?>" min="0" step="0.01">
                        </label>

                        <label>
                            Target ROI %
                            <input type="number" name="target_roi_percent" value="<?php echo e(old('target_roi_percent', 0)); ?>" min="0" max="999.99" step="0.01">
                        </label>

                        <label>
                            Starts on
                            <input type="date" name="starts_on" value="<?php echo e(old('starts_on')); ?>">
                        </label>

                        <label>
                            Ends on
                            <input type="date" name="ends_on" value="<?php echo e(old('ends_on')); ?>">
                        </label>

                        <button type="submit" class="blade-primary-action">Create project</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view projects but cannot create master records.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Project filters</h2>
                    </div>
                    <small><?php echo e($projects->total()); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('projects.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                    <?php if (isset($component)) { $__componentOriginal5ee006ce6757c21855df609df2a8580f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5ee006ce6757c21855df609df2a8580f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.company-context','data' => ['companies' => $companies,'selected' => $filters['company_id'] ?? null,'placeholder' => 'All companies']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.company-context'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['companies' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($companies),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filters['company_id'] ?? null),'placeholder' => 'All companies']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5ee006ce6757c21855df609df2a8580f)): ?>
<?php $attributes = $__attributesOriginal5ee006ce6757c21855df609df2a8580f; ?>
<?php unset($__attributesOriginal5ee006ce6757c21855df609df2a8580f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5ee006ce6757c21855df609df2a8580f)): ?>
<?php $component = $__componentOriginal5ee006ce6757c21855df609df2a8580f; ?>
<?php unset($__componentOriginal5ee006ce6757c21855df609df2a8580f); ?>
<?php endif; ?>

                    <label>
                        Branch
                        <select name="branch_id">
                            <option value="">All branches</option>
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>" <?php if((string) ($filters['branch_id'] ?? '') === (string) $branch->id): echo 'selected'; endif; ?>>
                                    <?php echo e($branch->code); ?>

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
                        Type
                        <select name="project_type">
                            <option value="">All types</option>
                            <?php $__currentLoopData = $projectTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['project_type'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>

                    <label>
                        Search
                        <input type="search" name="search" value="<?php echo e($filters['search'] ?? ''); ?>" maxlength="120" placeholder="Code, name, city">
                    </label>

                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>

                <p class="blade-workspace-note">
                    Cost/ROI export uses project, unit, booking, collection, procurement and construction data.
                </p>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Project master register</h2>
                </div>
                <small><?php echo e($projects->firstItem() ?? 0); ?>-<?php echo e($projects->lastItem() ?? 0); ?> of <?php echo e($projects->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Project</th>
                            <th scope="col">Scope</th>
                            <th scope="col">Timeline</th>
                            <th scope="col">Budget / ROI</th>
                            <th scope="col">Activity summary</th>
                            <th scope="col">Team</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($project->code); ?></strong>
                                    <span><?php echo e($project->name); ?></span>
                                    <span><?php echo e($projectTypes[$project->project_type] ?? str($project->project_type)->headline()); ?> / <?php echo e($statuses[$project->status] ?? str($project->status)->headline()); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($project->company?->code ?? 'Company missing'); ?></strong>
                                    <span><?php echo e($project->branch?->code ?? 'No branch'); ?></span>
                                    <span><?php echo e($project->city); ?>, <?php echo e($project->state); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($project->starts_on?->format('d M Y') ?? 'Start pending'); ?></strong>
                                    <span><?php echo e($project->ends_on?->format('d M Y') ?? 'End pending'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($money($project->budget_amount)); ?></strong>
                                    <span>Target ROI: <?php echo e($percent($project->target_roi_percent)); ?></span>
                                    <?php if($healthScore = ($projectHealthScores[$project->id] ?? null)): ?>
                                        <span>Health: <?php echo e($healthScore->score); ?> / 100 · <?php echo e(str($healthScore->band)->headline()); ?></span>
                                        <span>Rule v<?php echo e($healthScore->ruleVersion); ?> · <?php echo e($healthScore->calculatedAt->format('d M Y H:i')); ?></span>
                                    <?php else: ?>
                                        <span>Health score not calculated</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo e((int) $project->units_count); ?> units</strong>
                                    <span><?php echo e((int) $project->bookings_count); ?> bookings</span>
                                    <span>Revenue: <?php echo e($money($project->booked_revenue_sum)); ?></span>
                                    <span>Collections: <?php echo e($money($project->approved_collections_sum)); ?></span>
                                </td>
                                <td>
                                    <?php $__empty_2 = true; $__currentLoopData = $project->teamAssignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <span>
                                            <?php echo e($assignment->user?->name ?? 'User missing'); ?> -
                                            <?php echo e($assignment->role_label); ?> -
                                            <?php echo e(str($assignment->status)->headline()); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <span>No team assignment</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $project)): ?>
                                        <details class="blade-row-actions blade-scoring-evidence">
                                            <summary>Health evidence</summary>
                                            <form method="POST" action="<?php echo e(route('projects.health-score.update', $project)); ?>" class="blade-inline-form blade-scoring-evidence-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <?php ($healthInputs = $project->scoring_inputs ?? []); ?>
                                                <?php $__currentLoopData = [
                                                    'construction_progress' => 'Construction progress',
                                                    'sales_progress' => 'Sales progress',
                                                    'collection_progress' => 'Collection progress',
                                                    'budget_control' => 'Budget control',
                                                    'schedule_variance' => 'Schedule adherence',
                                                    'inventory_health' => 'Inventory health',
                                                    'approval_delays' => 'Approval timeliness',
                                                    'procurement_delays' => 'Procurement timeliness',
                                                    'receivables' => 'Receivables health',
                                                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evidenceKey => $evidenceLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label>
                                                        <?php echo e($evidenceLabel); ?>

                                                        <input type="number" name="<?php echo e($evidenceKey); ?>" value="<?php echo e($healthInputs[$evidenceKey] ?? ''); ?>" min="0" max="100" step="0.01" required>
                                                    </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <p class="blade-workspace-note">Enter verified values from 0 to 100. Saving recalculates the score using the active Project Health rule.</p>
                                                <button type="submit" class="blade-secondary-action">Calculate health score</button>
                                            </form>
                                        </details>

                                        <details class="blade-row-actions">
                                            <summary>Edit</summary>
                                            <form method="POST" action="<?php echo e(route('projects.update', $project)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <?php if (isset($component)) { $__componentOriginal5ee006ce6757c21855df609df2a8580f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5ee006ce6757c21855df609df2a8580f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.company-context','data' => ['companies' => $companies,'selected' => $project->company_id,'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.company-context'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['companies' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($companies),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($project->company_id),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5ee006ce6757c21855df609df2a8580f)): ?>
<?php $attributes = $__attributesOriginal5ee006ce6757c21855df609df2a8580f; ?>
<?php unset($__attributesOriginal5ee006ce6757c21855df609df2a8580f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5ee006ce6757c21855df609df2a8580f)): ?>
<?php $component = $__componentOriginal5ee006ce6757c21855df609df2a8580f; ?>
<?php unset($__componentOriginal5ee006ce6757c21855df609df2a8580f); ?>
<?php endif; ?>
                                                <select name="branch_id">
                                                    <option value="">No branch</option>
                                                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($branch->id); ?>" <?php if($project->branch_id === $branch->id): echo 'selected'; endif; ?>><?php echo e($branch->code); ?> - <?php echo e($branch->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <input type="text" name="code" value="<?php echo e($project->code); ?>" maxlength="32" required>
                                                <input type="text" name="name" value="<?php echo e($project->name); ?>" maxlength="255" required>
                                                <select name="project_type" required>
                                                    <?php $__currentLoopData = $projectTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($value); ?>" <?php if($project->project_type === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <select name="status" required>
                                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($value); ?>" <?php if($project->status === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <input type="text" name="city" value="<?php echo e($project->city); ?>" maxlength="120" required>
                                                <input type="text" name="state" value="<?php echo e($project->state); ?>" maxlength="2" required>
                                                <input type="number" name="budget_amount" value="<?php echo e($project->budget_amount); ?>" min="0" step="0.01">
                                                <input type="number" name="target_roi_percent" value="<?php echo e($project->target_roi_percent); ?>" min="0" max="999.99" step="0.01">
                                                <input type="date" name="starts_on" value="<?php echo e($project->starts_on?->toDateString()); ?>">
                                                <input type="date" name="ends_on" value="<?php echo e($project->ends_on?->toDateString()); ?>">
                                                <button type="submit" class="blade-secondary-action">Save project</button>
                                            </form>
                                        </details>
                                    <?php endif; ?>

                                    <?php if($canManageProjectTeam): ?>
                                        <details class="blade-row-actions">
                                            <summary>Assign team</summary>
                                            <form method="POST" action="<?php echo e(route('projects.team-assignments.store', $project)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <select name="user_id" required>
                                                    <option value="">Select user</option>
                                                    <?php $__currentLoopData = $assignableUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignableUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($assignableUser->id); ?>"><?php echo e($assignableUser->name); ?> - <?php echo e($assignableUser->email); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <select name="employee_id">
                                                    <option value="">No employee profile</option>
                                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->employee_code); ?> - <?php echo e($employee->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <input type="text" name="role_label" maxlength="120" placeholder="Role label" required>
                                                <input type="text" name="department" maxlength="120" placeholder="Department">
                                                <select name="access_level" required>
                                                    <?php $__currentLoopData = $accessLevels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <input type="date" name="starts_on">
                                                <input type="date" name="ends_on">
                                                <textarea name="notes" maxlength="2000" rows="2" placeholder="Assignment notes"></textarea>
                                                <button type="submit" class="blade-primary-action">Assign</button>
                                            </form>
                                        </details>
                                    <?php endif; ?>

                                    <?php $__currentLoopData = $project->teamAssignments->where('status', 'active'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $assignment)): ?>
                                            <form method="POST" action="<?php echo e(route('projects.team-assignments.destroy', [$project, $assignment])); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="blade-secondary-action">Revoke <?php echo e($assignment->user?->name); ?></button>
                                            </form>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('update', $project)): ?>
                                        <?php if(! $canManageProjectTeam): ?>
                                            <span>No action</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No projects match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination">
                <?php echo e($projects->links()); ?>

            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/projects/index.blade.php ENDPATH**/ ?>