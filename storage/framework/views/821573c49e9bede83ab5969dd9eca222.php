

<?php $__env->startSection('title', 'Finance Dashboard - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $money = fn ($amount) => 'Rs. '.number_format((float) ($amount ?? 0), 2);
    ?>

    <div class="blade-workspace" aria-labelledby="finance-dashboard-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Finance and Operations</p>
                <h1 id="finance-dashboard-title">Finance Dashboard</h1>
                <p>
                    Dashboard for cash position, receivables, payables,
                    GST summary, approval counts, forecasts and recent finance activity.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('finance.vouchers.index')); ?>">Financial Vouchers</a>
                <a href="<?php echo e(route('finance.collections.index')); ?>">Collections</a>
                <a href="<?php echo e(route('finance.gst-entries.index')); ?>">GST Entries</a>
                <a href="<?php echo e(route('finance.dashboard')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Finance dashboard filters were not applied.</strong>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </section>
        <?php endif; ?>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Controls</span>
                    <h2>Finance filters</h2>
                </div>
                <small>Live finance records</small>
            </div>

            <form method="GET" action="<?php echo e(route('finance.dashboard')); ?>" class="blade-filter-grid blade-filter-grid-compact">
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
                    Project
                    <select name="project_id">
                        <option value="">All projects</option>
                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($project->id); ?>" <?php if((string) ($filters['project_id'] ?? '') === (string) $project->id): echo 'selected'; endif; ?>>
                                <?php echo e($project->code); ?> - <?php echo e($project->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>

                <label>
                    From
                    <input type="date" name="date_from" value="<?php echo e($filters['date_from'] ?? $dashboard['period']['date_from'] ?? ''); ?>">
                </label>

                <label>
                    To
                    <input type="date" name="date_to" value="<?php echo e($filters['date_to'] ?? $dashboard['period']['date_to'] ?? ''); ?>">
                </label>

                <label>
                    Forecast days
                    <input type="number" name="forecast_days" value="<?php echo e($filters['forecast_days'] ?? $dashboard['period']['forecast_days'] ?? 90); ?>" min="1" max="180">
                </label>

                <button type="submit" class="blade-secondary-action">Apply filters</button>
            </form>
        </section>

        <section class="blade-dashboard-grid">
            <article class="blade-dashboard-card">
                <span class="blade-dashboard-label">Net cash position</span>
                <strong><?php echo e($money($dashboard['cash_position']['net_cash_position'] ?? 0)); ?></strong>
                <small>As of <?php echo e($dashboard['cash_position']['as_of_date'] ?? 'n/a'); ?></small>
            </article>
            <article class="blade-dashboard-card">
                <span class="blade-dashboard-label">Period net flow</span>
                <strong><?php echo e($money($dashboard['period_summary']['net_period_flow'] ?? 0)); ?></strong>
                <small>Collections + receipt vouchers - payment vouchers</small>
            </article>
            <article class="blade-dashboard-card">
                <span class="blade-dashboard-label">Schedule outstanding</span>
                <strong><?php echo e($money($dashboard['receivables']['schedule_outstanding'] ?? 0)); ?></strong>
                <small>Due next 30 days: <?php echo e($money($dashboard['receivables']['due_next_30_days'] ?? 0)); ?></small>
            </article>
            <article class="blade-dashboard-card">
                <span class="blade-dashboard-label">Forecast outflow</span>
                <strong><?php echo e($money($dashboard['payables']['forecast_outflow'] ?? 0)); ?></strong>
                <small>Submitted payment vouchers and approved liabilities</small>
            </article>
            <article class="blade-dashboard-card">
                <span class="blade-dashboard-label">GST tax amount</span>
                <strong><?php echo e($money($dashboard['gst']['total_tax_amount'] ?? 0)); ?></strong>
                <small><?php echo e((int) ($dashboard['gst']['approved_entry_count'] ?? 0)); ?> approved GST entries</small>
            </article>
            <article class="blade-dashboard-card">
                <span class="blade-dashboard-label">Approval queue</span>
                <strong><?php echo e((int) ($dashboard['approvals']['submitted_finance_vouchers'] ?? 0)); ?></strong>
                <small>Submitted finance vouchers</small>
            </article>
        </section>

        <section class="blade-workspace-grid">
            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Receivables</span>
                        <h2>Aging buckets</h2>
                    </div>
                </div>

                <div class="blade-dashboard-table-wrap">
                    <table class="blade-dashboard-table">
                        <tbody>
                            <?php $__currentLoopData = ($dashboard['receivables']['aging_buckets'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bucket => $amount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th scope="row"><?php echo e(str($bucket)->headline()); ?></th>
                                    <td><?php echo e($money($amount)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">GST</span>
                        <h2>Approved GST by transaction type</h2>
                    </div>
                </div>

                <div class="blade-dashboard-table-wrap">
                    <table class="blade-dashboard-table">
                        <thead>
                            <tr>
                                <th scope="col">Type</th>
                                <th scope="col">Entries</th>
                                <th scope="col">Taxable</th>
                                <th scope="col">Tax</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = ($dashboard['gst']['by_transaction_type'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e(str($row['transaction_type'] ?? 'n/a')->headline()); ?></td>
                                    <td><?php echo e((int) ($row['entry_count'] ?? 0)); ?></td>
                                    <td><?php echo e($money($row['taxable_amount'] ?? 0)); ?></td>
                                    <td><?php echo e($money($row['total_tax_amount'] ?? 0)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4">No approved GST entries in the selected period.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </article>
        </section>

        <section class="blade-workspace-grid">
            <?php $__currentLoopData = [
                'collections' => 'Recent collections',
                'vouchers' => 'Recent vouchers',
                'payment_requests' => 'Recent payment requests',
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="blade-dashboard-card">
                    <div class="blade-dashboard-section-title">
                        <div>
                            <span class="blade-dashboard-label">Activity</span>
                            <h2><?php echo e($title); ?></h2>
                        </div>
                    </div>

                    <div class="blade-dashboard-table-wrap">
                        <table class="blade-dashboard-table">
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = ($dashboard['recent_activity'][$key] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo e($row['receipt_number'] ?? $row['voucher_number'] ?? $row['request_number'] ?? 'Record'); ?></strong>
                                            <span><?php echo e($row['status'] ?? 'n/a'); ?> / <?php echo e($row['project'] ?? 'No project'); ?></span>
                                        </td>
                                        <td><?php echo e($money($row['amount'] ?? 0)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="2">No recent activity.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\finance\dashboard.blade.php ENDPATH**/ ?>