<?php $__env->startSection('title', 'Sales Analytics - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<div class="blade-workspace" aria-labelledby="sales-analytics-title">
    <header class="blade-workspace-header">
        <div>
            <p class="blade-dashboard-eyebrow">Sales &amp; CRM</p>
            <h1 id="sales-analytics-title">Sales Funnel &amp; Performance</h1>
            <p>Conversion, source, project, campaign and team performance from available sales records.</p>
        </div>
        <nav class="blade-workspace-actions" aria-label="Sales analytics actions">
            <a href="<?php echo e(route('crm.leads.index')); ?>">Lead Management</a>
            <a href="<?php echo e(route('crm.campaigns.index')); ?>">Marketing</a>
            <a href="<?php echo e(route('sales.bookings.index')); ?>">Bookings</a>
        </nav>
    </header>

    <section class="blade-dashboard-card">
        <div class="blade-dashboard-section-title"><div><span class="blade-dashboard-label">Period &amp; Project</span><h2>Analytics filters</h2></div></div>
        <form method="GET" action="<?php echo e(route('crm.analytics.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
            <label>Project<select name="project_id"><option value="">All projects</option><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($project->id); ?>" <?php if((string) ($filters['project_id'] ?? '') === (string) $project->id): echo 'selected'; endif; ?>><?php echo e($project->code); ?> · <?php echo e($project->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label>Date from<input type="date" name="date_from" value="<?php echo e($filters['date_from'] ?? ''); ?>"></label>
            <label>Date to<input type="date" name="date_to" value="<?php echo e($filters['date_to'] ?? ''); ?>"></label>
            <button type="submit" class="blade-secondary-action">Apply filters</button>
            <a href="<?php echo e(route('crm.analytics.index')); ?>" class="blade-secondary-action">Reset</a>
        </form>
    </section>

    <section class="blade-dashboard-card">
        <div class="blade-dashboard-section-title"><div><span class="blade-dashboard-label">Conversion Overview</span><h2>Current sales position</h2></div></div>
        <div class="blade-dashboard-metrics">
            <div class="blade-dashboard-metric"><span>Total leads</span><strong><?php echo e(number_format($report['summary']['leads'])); ?></strong></div>
            <div class="blade-dashboard-metric"><span>Qualified</span><strong><?php echo e(number_format($report['summary']['qualified'])); ?></strong><small><?php echo e(number_format($report['summary']['qualification_rate'], 1)); ?>%</small></div>
            <div class="blade-dashboard-metric"><span>Site visits</span><strong><?php echo e(number_format($report['summary']['site_visits'])); ?></strong></div>
            <div class="blade-dashboard-metric"><span>Bookings</span><strong><?php echo e(number_format($report['summary']['bookings'])); ?></strong><small><?php echo e(number_format($report['summary']['booking_conversion'], 1)); ?>% conversion</small></div>
        </div>
    </section>

    <section class="blade-workspace-grid">
        <article class="blade-dashboard-card">
            <div class="blade-dashboard-section-title"><div><span class="blade-dashboard-label">Sales Funnel</span><h2>Stage conversion</h2></div></div>
            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table"><thead><tr><th>Stage</th><th>Records</th><th>Conversion from leads</th></tr></thead><tbody>
                <?php $__currentLoopData = $report['funnel']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><td><strong><?php echo e($row['label']); ?></strong></td><td><?php echo e(number_format($row['value'])); ?></td><td><?php echo e(number_format($row['rate'], 1)); ?>%</td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody></table>
            </div>
        </article>

        <article class="blade-dashboard-card">
            <div class="blade-dashboard-section-title"><div><span class="blade-dashboard-label">Sources</span><h2>Source conversion</h2></div></div>
            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table"><thead><tr><th>Source</th><th>Leads</th><th>Won</th><th>Conversion</th></tr></thead><tbody>
                <?php $__empty_1 = true; $__currentLoopData = $report['sources']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><strong><?php echo e($row['label']); ?></strong></td><td><?php echo e($row['leads']); ?></td><td><?php echo e($row['won']); ?></td><td><?php echo e(number_format($row['conversion'], 1)); ?>%</td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="4">No source records are available for the selected filters.</td></tr><?php endif; ?>
                </tbody></table>
            </div>
        </article>
    </section>

    <section class="blade-workspace-grid">
        <article class="blade-dashboard-card">
            <div class="blade-dashboard-section-title"><div><span class="blade-dashboard-label">Team Performance</span><h2>Lead owners</h2></div></div>
            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table"><thead><tr><th>Owner</th><th>Leads</th><th>Won</th><th>Conversion</th><th>Pipeline</th></tr></thead><tbody>
                <?php $__empty_1 = true; $__currentLoopData = $report['team']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><strong><?php echo e($row['label']); ?></strong></td><td><?php echo e($row['leads']); ?></td><td><?php echo e($row['won']); ?></td><td><?php echo e(number_format($row['conversion'], 1)); ?>%</td><td>₹<?php echo e(number_format($row['pipeline'], 0)); ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="5">No team performance records are available.</td></tr><?php endif; ?>
                </tbody></table>
            </div>
        </article>

        <article class="blade-dashboard-card">
            <div class="blade-dashboard-section-title"><div><span class="blade-dashboard-label">Project Conversion</span><h2>Project performance</h2></div></div>
            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table"><thead><tr><th>Project</th><th>Leads</th><th>Won</th><th>Conversion</th></tr></thead><tbody>
                <?php $__empty_1 = true; $__currentLoopData = $report['projects']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><strong><?php echo e($row['code']); ?></strong><br><small><?php echo e($row['label']); ?></small></td><td><?php echo e($row['leads']); ?></td><td><?php echo e($row['won']); ?></td><td><?php echo e(number_format($row['conversion'], 1)); ?>%</td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="4">No project conversion records are available.</td></tr><?php endif; ?>
                </tbody></table>
            </div>
        </article>
    </section>

    <section class="blade-dashboard-card">
        <div class="blade-dashboard-section-title"><div><span class="blade-dashboard-label">Marketing Metrics</span><h2>Campaign conversion</h2></div><a href="<?php echo e(route('crm.campaigns.index')); ?>">Open campaigns</a></div>
        <div class="blade-dashboard-table-wrap">
            <table class="blade-dashboard-table"><thead><tr><th>Campaign</th><th>Source</th><th>Status</th><th>Leads</th><th>Won</th><th>Conversion</th></tr></thead><tbody>
            <?php $__empty_1 = true; $__currentLoopData = $report['campaigns']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><strong><?php echo e($row['code']); ?></strong><br><small><?php echo e($row['label']); ?></small></td><td><?php echo e($row['source']); ?></td><td><span class="blade-status-pill"><?php echo e(ucfirst($row['status'])); ?></span></td><td><?php echo e($row['leads']); ?></td><td><?php echo e($row['won']); ?></td><td><?php echo e(number_format($row['conversion'], 1)); ?>%</td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="6">No campaign metrics are available for the selected filters.</td></tr><?php endif; ?>
            </tbody></table>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/developer/public_html/builder360/resources/views/crm/analytics/index.blade.php ENDPATH**/ ?>