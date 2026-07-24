<?php $__env->startSection('title', 'Lead Activities - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<div class="blade-workspace" aria-labelledby="lead-activities-title">
    <header class="blade-workspace-header">
        <div>
            <p class="blade-dashboard-eyebrow">Sales &amp; CRM</p>
            <h1 id="lead-activities-title">Lead Activities</h1>
            <p>Record calls, emails, campaign responses and follow-ups against available leads.</p>
        </div>
        <nav class="blade-workspace-actions" aria-label="Lead activity workspace actions">
            <a href="<?php echo e(route('crm.campaigns.index')); ?>">Marketing Campaigns</a>
            <a href="<?php echo e(route('crm.leads.index')); ?>">Lead Management</a>
            <a href="<?php echo e(route('crm.lead-activities.index')); ?>">Reset filters</a>
        </nav>
    </header>

    <?php if(session('status')): ?><section class="blade-alert blade-alert-success" role="status"><?php echo e(session('status')); ?></section><?php endif; ?>
    <?php if($errors->any()): ?><section class="blade-alert blade-alert-error" role="alert"><strong>The activity was not recorded.</strong><ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></section><?php endif; ?>

    <section class="blade-workspace-grid">
        <article class="blade-dashboard-card">
            <div class="blade-dashboard-section-title"><div><span class="blade-dashboard-label">Filters</span><h2>Activity register</h2></div><small><?php echo e($activities->total()); ?> record(s)</small></div>
            <form method="GET" action="<?php echo e(route('crm.lead-activities.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                <label>Search<input type="search" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" maxlength="120" placeholder="Number, subject or details"></label>
                <label>Activity type<select name="activity_type"><option value="">All types</option><?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(($filters['activity_type'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label>Project<select name="project_id"><option value="">All projects</option><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($project->id); ?>" <?php if((string) ($filters['project_id'] ?? '') === (string) $project->id): echo 'selected'; endif; ?>><?php echo e($project->code); ?> · <?php echo e($project->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label>Campaign<select name="marketing_campaign_id"><option value="">All campaigns</option><?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($campaign->id); ?>" <?php if((string) ($filters['marketing_campaign_id'] ?? '') === (string) $campaign->id): echo 'selected'; endif; ?>><?php echo e($campaign->campaign_code); ?> · <?php echo e($campaign->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label>Date from<input type="date" name="date_from" value="<?php echo e($filters['date_from'] ?? ''); ?>"></label>
                <label>Date to<input type="date" name="date_to" value="<?php echo e($filters['date_to'] ?? ''); ?>"></label>
                <button type="submit" class="blade-secondary-action">Apply filters</button>
            </form>
        </article>

        <?php if($canCreate): ?>
            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title"><div><span class="blade-dashboard-label">New Activity</span><h2>Record interaction</h2></div></div>
                <form method="POST" action="<?php echo e(route('crm.lead-activities.store')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                    <?php echo csrf_field(); ?>
                    <label>Lead<select name="lead_id" required><option value="">Select lead</option><?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($lead->id); ?>" <?php if((string) old('lead_id') === (string) $lead->id): echo 'selected'; endif; ?>><?php echo e($lead->lead_code); ?> · <?php echo e($lead->customer?->name ?? 'Customer unavailable'); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                    <label>Campaign<select name="marketing_campaign_id"><option value="">Use lead campaign</option><?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($campaign->id); ?>" <?php if((string) old('marketing_campaign_id') === (string) $campaign->id): echo 'selected'; endif; ?>><?php echo e($campaign->campaign_code); ?> · <?php echo e($campaign->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                    <label>Type<select name="activity_type" required><?php $__currentLoopData = ['note' => 'Note', 'call' => 'Call', 'email' => 'Email', 'campaign_response' => 'Campaign response', 'follow_up' => 'Follow-up']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(old('activity_type') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                    <label>Activity time<input type="datetime-local" name="activity_at" value="<?php echo e(old('activity_at')); ?>"></label>
                    <label>Subject<input name="subject" value="<?php echo e(old('subject')); ?>" maxlength="255" required></label>
                    <label>Outcome<input name="outcome" value="<?php echo e(old('outcome')); ?>" maxlength="80"></label>
                    <label>Next follow-up<input type="datetime-local" name="next_follow_up_at" value="<?php echo e(old('next_follow_up_at')); ?>"></label>
                    <label class="blade-filter-span">Details<textarea name="description" maxlength="5000" rows="3"><?php echo e(old('description')); ?></textarea></label>
                    <button type="submit" class="blade-primary-action">Record activity</button>
                </form>
            </article>
        <?php endif; ?>
    </section>

    <section class="blade-dashboard-card">
        <div class="blade-dashboard-section-title"><div><span class="blade-dashboard-label">Timeline</span><h2>Lead activity history</h2></div><small><?php echo e($activities->firstItem() ?? 0); ?>-<?php echo e($activities->lastItem() ?? 0); ?> of <?php echo e($activities->total()); ?></small></div>
        <div class="blade-dashboard-table-wrap">
            <table class="blade-dashboard-table">
                <thead><tr><th>Activity</th><th>Lead</th><th>Type</th><th>Subject</th><th>Campaign</th><th>Owner</th><th>Follow-up</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($activity->activity_number); ?></strong><br><small><?php echo e($activity->activity_at?->format('d M Y, h:i A')); ?></small></td>
                            <td><?php echo e($activity->lead?->lead_code); ?><br><small><?php echo e($activity->lead?->customer?->name ?? 'Customer unavailable'); ?></small></td>
                            <td><span class="blade-status-pill"><?php echo e($types[$activity->activity_type] ?? ucfirst(str_replace('_', ' ', $activity->activity_type))); ?></span></td>
                            <td><?php echo e($activity->subject); ?><?php if($activity->outcome): ?><br><small><?php echo e($activity->outcome); ?></small><?php endif; ?></td>
                            <td><?php echo e($activity->marketingCampaign?->campaign_code ?? '—'); ?></td>
                            <td><?php echo e($activity->actor?->name ?? 'System'); ?></td>
                            <td><?php echo e($activity->next_follow_up_at?->format('d M Y, h:i A') ?? '—'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="7"><div class="blade-empty-state"><strong>No lead activities found</strong><p>Adjust the filters or record the next customer interaction.</p></div></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo e($activities->links()); ?>

    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/crm/marketing/activities.blade.php ENDPATH**/ ?>