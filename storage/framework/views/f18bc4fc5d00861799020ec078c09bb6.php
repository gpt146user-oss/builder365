

<?php $__env->startSection('title', 'GST Return Periods - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $money = fn ($amount) => 'Rs. '.number_format((float) ($amount ?? 0), 2);
    ?>

    <div class="blade-workspace" aria-labelledby="gst-return-periods-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Finance and Compliance</p>
                <h1 id="gst-return-periods-title">GST Return Periods</h1>
                <p>
                    Workspace for preparing GST monthly return periods from approved entries,
                    approving them through maker-checker workflow and locking periods after filing review.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('finance.dashboard')); ?>">Finance Dashboard</a>
                <a href="<?php echo e(route('finance.gst-entries.index')); ?>">GST Entries</a>
                <a href="<?php echo e(route('finance.gst-return-periods.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status"><?php echo e(session('status')); ?></section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>GST return action was not saved.</strong>
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
                        <span class="blade-dashboard-label">Prepare</span>
                        <h2>Create return period</h2>
                    </div>
                    <small><?php echo e($canPreparePeriod ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canPreparePeriod): ?>
                    <form method="POST" action="<?php echo e(route('finance.gst-return-periods.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <label>
                            Period year
                            <input type="number" name="period_year" value="<?php echo e(old('period_year', now()->year)); ?>" min="2020" max="2100" required>
                        </label>

                        <label>
                            Period month
                            <input type="number" name="period_month" value="<?php echo e(old('period_month', now()->month)); ?>" min="1" max="12" required>
                        </label>

                        <label class="blade-form-wide">
                            Preparation note
                            <textarea name="note" maxlength="500" rows="3" placeholder="Return preparation context, reconciliation note or filing reference."><?php echo e(old('note')); ?></textarea>
                        </label>

                        <button type="submit" class="blade-primary-action">Prepare GST return</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view GST return periods but cannot prepare new periods.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Return period filters</h2>
                    </div>
                    <small><?php echo e($periods->total()); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('finance.gst-return-periods.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
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
                        Year
                        <input type="number" name="period_year" value="<?php echo e($filters['period_year'] ?? ''); ?>" min="2020" max="2100">
                    </label>
                    <label>
                        Month
                        <input type="number" name="period_month" value="<?php echo e($filters['period_month'] ?? ''); ?>" min="1" max="12">
                    </label>
                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>

                <p class="blade-workspace-note">
                    Preparing a return requires approved GST entries for the selected month.
                    Locking a period also locks approved entries for that month.
                </p>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>GST return period register</h2>
                </div>
                <small><?php echo e($periods->firstItem() ?? 0); ?>-<?php echo e($periods->lastItem() ?? 0); ?> of <?php echo e($periods->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Return</th>
                            <th scope="col">Period</th>
                            <th scope="col">Entries</th>
                            <th scope="col">Tax summary</th>
                            <th scope="col">Workflow</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($period->return_number); ?></strong>
                                    <span><?php echo e($period->period_start?->format('d M Y')); ?> to <?php echo e($period->period_end?->format('d M Y')); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e(sprintf('%04d-%02d', $period->period_year, $period->period_month)); ?></strong>
                                    <span>Company <?php echo e($period->company?->code ?? $period->company_id); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($period->entry_count); ?> approved entry(s)</strong>
                                    <span>Output <?php echo e($period->summary['output_entry_count'] ?? 0); ?></span>
                                    <span>Input <?php echo e($period->summary['input_entry_count'] ?? 0); ?></span>
                                </td>
                                <td>
                                    <strong>Payable <?php echo e($money($period->net_tax_payable)); ?></strong>
                                    <span>Output <?php echo e($money($period->output_tax_total)); ?></span>
                                    <span>ITC <?php echo e($money($period->input_tax_credit_total)); ?></span>
                                </td>
                                <td>
                                    <strong>Prepared by <?php echo e($period->preparedBy?->name ?? 'User missing'); ?></strong>
                                    <span>Approved by <?php echo e($period->approvedBy?->name ?? 'Pending'); ?></span>
                                    <span>Locked by <?php echo e($period->lockedBy?->name ?? 'Pending'); ?></span>
                                </td>
                                <td><?php echo e($statuses[$period->status] ?? str($period->status)->headline()); ?></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve', $period)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Approve</summary>
                                            <form method="POST" action="<?php echo e(route('finance.gst-return-periods.approve', $period)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <textarea name="note" maxlength="500" rows="2" placeholder="Approval note"></textarea>
                                                <button type="submit" class="blade-primary-action">Approve return</button>
                                            </form>
                                        </details>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lock', $period)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Lock</summary>
                                            <form method="POST" action="<?php echo e(route('finance.gst-return-periods.lock', $period)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <textarea name="note" maxlength="500" rows="2" placeholder="Lock note"></textarea>
                                                <button type="submit" class="blade-primary-action">Lock return</button>
                                            </form>
                                        </details>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('approve', $period)): ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('lock', $period)): ?>
                                            <span>No action</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No GST return periods match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination"><?php echo e($periods->links()); ?></div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/finance/gst-return-periods/index.blade.php ENDPATH**/ ?>