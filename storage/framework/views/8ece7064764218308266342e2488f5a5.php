

<?php $__env->startSection('title', 'Lead Qualification - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<div class="blade-workspace" aria-labelledby="lead-qualification-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Sales and CRM</p>
                <h1 id="lead-qualification-title">Lead Qualification</h1>
                <p>
                    Workspace for lead quality scoring, condition-based qualification,
                    score-band routing, checks, activity history and company-level qualification records.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('crm.lead-qualifications.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status">
                <?php echo e(session('status')); ?>

            </section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Lead qualification was not saved.</strong>
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
                        <span class="blade-dashboard-label">Rule source</span>
                        <h2>Quality score configuration</h2>
                    </div>
                    <small>
                        <?php echo e($rules['source'] ?? 'application_default'); ?>

                        <?php if(! empty($rules['version'])): ?>
                            · v<?php echo e($rules['version']); ?>

                        <?php endif; ?>
                    </small>
                </div>

                <div class="blade-score-grid">
                    <?php $__currentLoopData = ($rules['criteria'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $criterionKey => $criterion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="blade-score-card">
                            <strong><?php echo e($criterion['label'] ?? str($criterionKey)->replace('_', ' ')->title()); ?></strong>
                            <span>Max <?php echo e($criterion['max_points'] ?? 0); ?> points</span>
                            <ul>
                                <?php $__currentLoopData = ($criterion['options'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($option['label'] ?? $option['value']); ?>: <?php echo e($option['points'] ?? 0); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="blade-band-list" aria-label="Score bands">
                    <?php $__currentLoopData = ($rules['bands'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $band): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <strong><?php echo e($band['label'] ?? 'Score Band'); ?></strong>
                            <span><?php echo e($band['min_score'] ?? 0); ?>+ points routes to <?php echo e($band['status_hint'] ?? 'nurture'); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <?php if($canManageScoring): ?>
                    <p class="blade-workspace-note">
                        Criteria, conditions, weights and score bands are managed in
                        <a href="<?php echo e($scoringUrl); ?>">Scoring Logic</a> through its approval-controlled rule lifecycle.
                    </p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Create</span>
                        <h2>Run lead qualification</h2>
                    </div>
                    <small><?php echo e($canQualify ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canQualify): ?>
                    <form method="POST" action="<?php echo e(route('crm.lead-qualifications.store')); ?>" class="blade-form-grid">
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
                            Result status
                            <select name="status" required>
                                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('status', 'qualified') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <?php $__currentLoopData = ($rules['criteria'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $criterionKey => $criterion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label>
                                <?php echo e($criterion['label'] ?? str($criterionKey)->replace('_', ' ')->title()); ?>

                                <select name="quality_conditions[<?php echo e($criterionKey); ?>]" required>
                                    <option value="">Select condition</option>
                                    <?php $__currentLoopData = ($criterion['options'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($option['value']); ?>" <?php if(old("quality_conditions.{$criterionKey}") === ($option['value'] ?? null)): echo 'selected'; endif; ?>>
                                            <?php echo e($option['label'] ?? $option['value']); ?> · <?php echo e($option['points'] ?? 0); ?> pts
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <label>
                            Preferred configuration
                            <input type="text" name="preferred_configuration" value="<?php echo e(old('preferred_configuration')); ?>" maxlength="80" placeholder="2 BHK, 3 BHK, duplex">
                        </label>

                        <label>
                            Verified budget min
                            <input type="number" name="verified_budget_min" value="<?php echo e(old('verified_budget_min')); ?>" min="0" step="0.01">
                        </label>

                        <label>
                            Verified budget max
                            <input type="number" name="verified_budget_max" value="<?php echo e(old('verified_budget_max')); ?>" min="0" step="0.01">
                        </label>

                        <label>
                            Expected booking date
                            <input type="date" name="expected_booking_date" value="<?php echo e(old('expected_booking_date')); ?>">
                        </label>

                        <label class="blade-form-wide">
                            Decision notes
                            <textarea name="decision_notes" required maxlength="5000" rows="4" placeholder="Record verification notes, fitment reason, next action and routing justification."><?php echo e(old('decision_notes')); ?></textarea>
                        </label>

                        <button type="submit" class="blade-primary-action">Save qualification</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">You can view qualification records, but your role cannot create new qualifications.</p>
                <?php endif; ?>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Qualification records</h2>
                </div>
                <small><?php echo e($qualifications->total()); ?> record(s)</small>
            </div>

            <form method="GET" action="<?php echo e(route('crm.lead-qualifications.index')); ?>" class="blade-filter-grid">
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
                    Status
                    <select name="status">
                        <option value="">All statuses</option>
                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>
                <label>
                    Minimum score
                    <input type="number" name="min_score" min="0" max="100" value="<?php echo e($filters['min_score'] ?? ''); ?>">
                </label>
                <label>
                    Expected from
                    <input type="date" name="expected_from" value="<?php echo e($filters['expected_from'] ?? ''); ?>">
                </label>
                <label>
                    Expected to
                    <input type="date" name="expected_to" value="<?php echo e($filters['expected_to'] ?? ''); ?>">
                </label>
                <button type="submit" class="blade-secondary-action">Apply filters</button>
            </form>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Qualification</th>
                            <th scope="col">Lead</th>
                            <th scope="col">Score</th>
                            <th scope="col">Band</th>
                            <th scope="col">Status</th>
                            <th scope="col">Budget</th>
                            <th scope="col">Expected booking</th>
                            <th scope="col">Qualified by</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $qualifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qualification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $qualityScore = is_array($qualification->metadata) ? ($qualification->metadata['quality_score'] ?? []) : [];
                                $band = is_array($qualityScore) ? ($qualityScore['band'] ?? []) : [];
                                $currentScore = $leadScores[$qualification->lead_id] ?? null;
                                $isCurrentQualificationScore = $currentScore
                                    && (int) ($currentScore->metadata['qualification_id'] ?? 0) === (int) $qualification->id;
                            ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($qualification->qualification_number); ?></strong>
                                    <span><?php echo e($qualification->qualified_at?->format('d M Y H:i') ?? 'Pending timestamp'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($qualification->lead?->lead_code ?? 'Lead missing'); ?></strong>
                                    <span><?php echo e($qualification->lead?->customer?->name ?? 'Customer pending'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($isCurrentQualificationScore ? $currentScore->score : $qualification->score); ?></strong>
                                    <?php if($isCurrentQualificationScore): ?>
                                        <span>Rule v<?php echo e($currentScore->ruleVersion); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($isCurrentQualificationScore ? str($currentScore->band)->headline() : ($band['label'] ?? 'Unclassified')); ?></td>
                                <td><?php echo e(str($qualification->status)->headline()); ?></td>
                                <td>
                                    <?php if($qualification->verified_budget_min || $qualification->verified_budget_max): ?>
                                        <?php echo e(number_format((float) $qualification->verified_budget_min, 2)); ?>

                                        -
                                        <?php echo e(number_format((float) $qualification->verified_budget_max, 2)); ?>

                                    <?php else: ?>
                                        Not verified
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($qualification->expected_booking_date?->format('d M Y') ?? 'Not set'); ?></td>
                                <td><?php echo e($qualification->qualifiedBy?->name ?? 'System'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8">No lead qualification records match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination">
                <?php echo e($qualifications->links()); ?>

            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\crm\lead-qualifications\index.blade.php ENDPATH**/ ?>