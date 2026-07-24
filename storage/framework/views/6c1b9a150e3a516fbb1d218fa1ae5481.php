<?php $__env->startSection('title', 'Marketing Campaigns - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<div class="blade-workspace" aria-labelledby="marketing-campaigns-title">
    <header class="blade-workspace-header">
        <div>
            <p class="blade-dashboard-eyebrow">Sales &amp; CRM</p>
            <h1 id="marketing-campaigns-title">Marketing Campaigns</h1>
            <p>Plan campaigns, monitor lead and booking outcomes, and control campaign status from one workspace.</p>
        </div>
        <nav class="blade-workspace-actions" aria-label="Marketing workspace actions">
            <a href="<?php echo e(route('crm.leads.index')); ?>">Lead Management</a>
            <a href="<?php echo e(route('crm.lead-activities.index')); ?>">Lead Activities</a>
            <a href="<?php echo e(route('crm.campaigns.index')); ?>">Reset filters</a>
        </nav>
    </header>

    <?php if(session('status')): ?>
        <section class="blade-alert blade-alert-success" role="status"><?php echo e(session('status')); ?></section>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <section class="blade-alert blade-alert-error" role="alert">
            <strong>The campaign action was not completed.</strong>
            <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </section>
    <?php endif; ?>

    <section class="blade-dashboard-card">
        <div class="blade-dashboard-section-title">
            <div><span class="blade-dashboard-label">Campaign Register</span><h2>Current campaign position</h2></div>
            <small><?php echo e($campaigns->total()); ?> filtered record(s)</small>
        </div>
        <div class="blade-dashboard-metrics">
            <div class="blade-dashboard-metric"><span>Total campaigns</span><strong><?php echo e(number_format($summary['total'])); ?></strong></div>
            <div class="blade-dashboard-metric"><span>Active</span><strong><?php echo e(number_format($summary['active'])); ?></strong></div>
            <div class="blade-dashboard-metric"><span>Draft</span><strong><?php echo e(number_format($summary['draft'])); ?></strong></div>
            <div class="blade-dashboard-metric"><span>Planned budget</span><strong>₹<?php echo e(number_format($summary['budget'], 0)); ?></strong></div>
        </div>
    </section>

    <section class="blade-workspace-grid">
        <article class="blade-dashboard-card">
            <div class="blade-dashboard-section-title"><div><span class="blade-dashboard-label">Filters</span><h2>Find campaigns</h2></div></div>
            <form method="GET" action="<?php echo e(route('crm.campaigns.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                <label>Search<input type="search" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" maxlength="120" placeholder="Code, campaign or source"></label>
                <label>Status<select name="status"><option value="">All statuses</option><?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label>Channel<select name="channel"><option value="">All channels</option><?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(($filters['channel'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label>Project<select name="project_id"><option value="">All projects</option><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($project->id); ?>" <?php if((string) ($filters['project_id'] ?? '') === (string) $project->id): echo 'selected'; endif; ?>><?php echo e($project->code); ?> · <?php echo e($project->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label>Start from<input type="date" name="date_from" value="<?php echo e($filters['date_from'] ?? ''); ?>"></label>
                <label>Start to<input type="date" name="date_to" value="<?php echo e($filters['date_to'] ?? ''); ?>"></label>
                <button type="submit" class="blade-secondary-action">Apply filters</button>
            </form>
        </article>

        <?php if($canCreate): ?>
            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title"><div><span class="blade-dashboard-label">New Campaign</span><h2>Create campaign</h2></div></div>
                <form method="POST" action="<?php echo e(route('crm.campaigns.store')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                    <?php echo csrf_field(); ?>
                    <label>Company<select name="company_id" required><?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($company->id); ?>" <?php if((string) old('company_id', $companies->first()?->id) === (string) $company->id): echo 'selected'; endif; ?>><?php echo e($company->code); ?> · <?php echo e($company->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                    <label>Project<select name="project_id"><option value="">Company-wide</option><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($project->id); ?>" <?php if((string) old('project_id') === (string) $project->id): echo 'selected'; endif; ?>><?php echo e($project->code); ?> · <?php echo e($project->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                    <label>Campaign name<input name="name" value="<?php echo e(old('name')); ?>" maxlength="255" required></label>
                    <label>Channel<select name="channel" required><?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(old('channel') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                    <label>Source<input name="source" value="<?php echo e(old('source')); ?>" maxlength="80" required></label>
                    <label>Status<select name="status"><option value="draft">Draft</option><option value="active" <?php if(old('status') === 'active'): echo 'selected'; endif; ?>>Active</option></select></label>
                    <label>Start date<input type="date" name="start_on" value="<?php echo e(old('start_on', now()->toDateString())); ?>" required></label>
                    <label>End date<input type="date" name="end_on" value="<?php echo e(old('end_on')); ?>"></label>
                    <label>Budget<input type="number" name="budget_amount" value="<?php echo e(old('budget_amount', 0)); ?>" min="0" step="0.01"></label>
                    <label>Target leads<input type="number" name="target_leads" value="<?php echo e(old('target_leads', 0)); ?>" min="0"></label>
                    <label>Target bookings<input type="number" name="target_bookings" value="<?php echo e(old('target_bookings', 0)); ?>" min="0"></label>
                    <button type="submit" class="blade-primary-action">Create campaign</button>
                </form>
            </article>
        <?php endif; ?>
    </section>

    <section class="blade-dashboard-card">
        <div class="blade-dashboard-section-title"><div><span class="blade-dashboard-label">Performance</span><h2>Campaign outcomes</h2></div><small><?php echo e($campaigns->firstItem() ?? 0); ?>-<?php echo e($campaigns->lastItem() ?? 0); ?> of <?php echo e($campaigns->total()); ?></small></div>
        <div class="blade-dashboard-table-wrap">
            <table class="blade-dashboard-table">
                <thead><tr><th>Campaign</th><th>Project</th><th>Channel</th><th>Status</th><th>Leads</th><th>Bookings</th><th>Conversion</th><th>Budget</th><th>Action</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($campaign->campaign_code); ?></strong><br><small><?php echo e($campaign->name); ?></small></td>
                            <td><?php echo e($campaign->project?->code ?? 'Company-wide'); ?></td>
                            <td><?php echo e($channels[$campaign->channel] ?? ucfirst(str_replace('_', ' ', $campaign->channel))); ?><br><small><?php echo e($campaign->source); ?></small></td>
                            <td><span class="blade-status-pill"><?php echo e($statuses[$campaign->status] ?? ucfirst($campaign->status)); ?></span></td>
                            <td><?php echo e(number_format($campaign->metrics['total_leads'])); ?></td>
                            <td><?php echo e(number_format($campaign->metrics['bookings'])); ?></td>
                            <td><?php echo e(number_format($campaign->metrics['conversion_rate'], 1)); ?>%</td>
                            <td>₹<?php echo e(number_format((float) $campaign->budget_amount, 0)); ?></td>
                            <td>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $campaign)): ?>
                                    <?php if($campaign->status !== 'archived'): ?>
                                        <form method="POST" action="<?php echo e(route('crm.campaigns.status.update', $campaign)); ?>" class="blade-inline-form">
                                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                            <select name="status" aria-label="New status for <?php echo e($campaign->campaign_code); ?>">
                                                <?php $__currentLoopData = ['active' => 'Active', 'paused' => 'Paused', 'completed' => 'Completed', 'archived' => 'Archived']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if($campaign->status === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <button type="submit">Update</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="blade-muted">Closed</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="9"><div class="blade-empty-state"><strong>No campaigns found</strong><p>Adjust the filters or create a campaign.</p></div></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo e($campaigns->links()); ?>

    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/crm/marketing/campaigns.blade.php ENDPATH**/ ?>