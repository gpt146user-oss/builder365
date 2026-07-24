<?php if($abilities['canManage']): ?>
    <section class="people-ops-grid is-wide-left">
        <article class="people-ops-panel" id="roster-create">
            <header class="people-ops-panel-head"><div><h2>Create dated roster</h2><p>Draft entries do not affect attendance until publication.</p></div><span class="people-status is-muted">Draft first</span></header>
            <form class="people-ops-panel-body people-form-grid" method="POST" action="<?php echo e(route('hr.attendance-rosters.store')); ?>" data-disable-on-submit>
                <?php echo csrf_field(); ?>
                <label class="people-field is-wide">Roster name<input class="people-control" name="name" value="<?php echo e(old('name')); ?>" required maxlength="160"></label>
                <label class="people-field">Period start<input class="people-control" type="date" name="period_start" value="<?php echo e(old('period_start', now()->startOfWeek()->toDateString())); ?>" required></label>
                <label class="people-field">Period end<input class="people-control" type="date" name="period_end" value="<?php echo e(old('period_end', now()->endOfWeek()->toDateString())); ?>" required></label>
                <label class="people-field is-wide">Governed timezone <small>Resolved again from the active rule pack for the selected period start.</small><input class="people-control" value="<?php echo e($governedTimezone); ?>" readonly aria-readonly="true"></label>
                <div class="people-form-actions is-wide"><button class="people-button is-primary" type="submit"><i class="fa-solid fa-plus" aria-hidden="true"></i> Create draft</button></div>
            </form>
        </article>

        <article class="people-ops-panel">
            <header class="people-ops-panel-head"><div><h2>Effective shift assignment</h2><p>Overlapping active assignments are rejected.</p></div><span class="people-status is-info">Effective dated</span></header>
            <form class="people-ops-panel-body people-form-grid" method="POST" action="<?php echo e(route('hr.attendance-shift-assignments.store')); ?>" data-disable-on-submit>
                <?php echo csrf_field(); ?>
                <label class="people-field is-wide">Employee<select class="people-control" name="employee_id" required><option value="">Select employee</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if(old('employee_id') == $employee->id): echo 'selected'; endif; ?>><?php echo e($employee->name); ?> · <?php echo e($employee->department ?: 'No department'); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field is-wide">Shift<select class="people-control" name="attendance_shift_id" required><option value="">Select shift</option><?php $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($shift->id); ?>" <?php if(old('attendance_shift_id') == $shift->id): echo 'selected'; endif; ?>><?php echo e($shift->code); ?> · <?php echo e($shift->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field">Effective from<input class="people-control" type="date" name="effective_from" value="<?php echo e(old('effective_from', now()->toDateString())); ?>" required></label>
                <label class="people-field">Effective to<input class="people-control" type="date" name="effective_to" value="<?php echo e(old('effective_to')); ?>"></label>
                <div class="people-form-actions is-wide"><button class="people-button is-primary" type="submit"><i class="fa-solid fa-user-clock" aria-hidden="true"></i> Assign shift</button></div>
            </form>
        </article>
    </section>
<?php endif; ?>

<section class="people-roster-list" aria-label="Dated attendance rosters">
    <?php $__empty_1 = true; $__currentLoopData = $rosters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roster): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <article class="people-ops-panel people-roster-card">
            <header class="people-ops-panel-head">
                <div><h2><?php echo e($roster->name); ?></h2><p><?php echo e($roster->period_start->format('d M Y')); ?> – <?php echo e($roster->period_end->format('d M Y')); ?> · <?php echo e($roster->timezone); ?></p></div>
                <div class="people-roster-badges"><span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['people-status', 'is-muted' => $roster->status === 'draft', 'is-info' => $roster->status === 'published', 'is-success' => $roster->status === 'locked', 'is-danger' => $roster->status === 'cancelled']); ?>"><?php echo e(str($roster->status)->headline()); ?></span><span class="people-count"><?php echo e($roster->entries_count); ?> entries</span></div>
            </header>

            <?php if($roster->relationLoaded('entries') && $roster->entries->isNotEmpty()): ?>
                <div class="people-ops-table-wrap"><table class="people-ops-table people-roster-entry-table"><caption>Entries in <?php echo e($roster->name); ?></caption><thead><tr><th scope="col">Employee</th><th scope="col">Work date</th><th scope="col">Assignment</th><th scope="col">Source</th></tr></thead><tbody>
                <?php $__currentLoopData = $roster->entries->sortBy(fn($entry) => $entry->work_date->format('Y-m-d').'-'.$entry->employee->name); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr><td><strong><?php echo e($entry->employee->name); ?></strong><small><?php echo e($entry->employee->department ?: 'No department'); ?></small></td><td><?php echo e($entry->work_date->format('d M Y')); ?></td><td><?php echo e($entry->entry_type === 'shift' ? ($entry->shift?->code.' · '.$entry->shift?->name) : str($entry->entry_type)->headline()); ?></td><td><span class="people-status is-muted"><?php echo e(str($entry->source)->headline()); ?></span></td></tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody></table></div>
            <?php else: ?>
                <div class="people-ops-empty"><i class="fa-solid fa-calendar-plus" aria-hidden="true"></i><strong>No roster entries</strong><span>Add manual entries or generate them from an active rotation.</span></div>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage', $roster)): ?>
                <details class="people-roster-details"><summary>Add roster entry</summary><form class="people-form-grid" method="POST" action="<?php echo e(route('hr.attendance-rosters.entries.store', $roster)); ?>" data-disable-on-submit><?php echo csrf_field(); ?><input type="hidden" name="lock_version" value="<?php echo e($roster->lock_version); ?>"><label class="people-field is-wide">Employee<select class="people-control" name="employee_id" required><option value="">Select employee</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>"><?php echo e($employee->name); ?> · <?php echo e($employee->department ?: 'No department'); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label><label class="people-field">Work date<input class="people-control" type="date" name="work_date" min="<?php echo e($roster->period_start->toDateString()); ?>" max="<?php echo e($roster->period_end->toDateString()); ?>" required></label><label class="people-field">Entry type<select class="people-control" name="entry_type" required><option value="shift">Working shift</option><option value="off">Weekly off</option><option value="holiday">Holiday</option></select></label><label class="people-field is-wide">Shift <small>Leave blank for an off day or holiday.</small><select class="people-control" name="attendance_shift_id"><option value="">No working shift</option><?php $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($shift->id); ?>"><?php echo e($shift->code); ?> · <?php echo e($shift->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label><div class="people-form-actions is-wide"><button class="people-button is-primary" type="submit">Add entry</button></div></form></details>
            <?php endif; ?>

            <footer class="people-roster-actions">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('publish', $roster)): ?><form method="POST" action="<?php echo e(route('hr.attendance-rosters.publish', $roster)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><input type="hidden" name="lock_version" value="<?php echo e($roster->lock_version); ?>"><button class="people-button is-primary" type="submit"><i class="fa-solid fa-paper-plane" aria-hidden="true"></i> Publish</button></form><?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lock', $roster)): ?><form method="POST" action="<?php echo e(route('hr.attendance-rosters.lock', $roster)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><input type="hidden" name="lock_version" value="<?php echo e($roster->lock_version); ?>"><button class="people-button is-primary" type="submit"><i class="fa-solid fa-lock" aria-hidden="true"></i> Lock</button></form><?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('reopen', $roster)): ?><form class="people-roster-cancel" method="POST" action="<?php echo e(route('hr.attendance-rosters.reopen', $roster)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><input type="hidden" name="lock_version" value="<?php echo e($roster->lock_version); ?>"><label class="people-field"><span class="sr-only">Roster reopen reason</span><input class="people-control" name="status_note" placeholder="Required reopen reason" required maxlength="2000"></label><button class="people-button is-secondary" type="submit"><i class="fa-solid fa-lock-open" aria-hidden="true"></i> Reopen roster</button></form><?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cancel', $roster)): ?><form class="people-roster-cancel" method="POST" action="<?php echo e(route('hr.attendance-rosters.cancel', $roster)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><input type="hidden" name="lock_version" value="<?php echo e($roster->lock_version); ?>"><label class="people-field"><span class="sr-only">Cancellation reason</span><input class="people-control" name="status_note" placeholder="Required cancellation reason" required maxlength="2000"></label><button class="people-button is-danger" type="submit">Cancel roster</button></form><?php endif; ?>
            </footer>
        </article>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <section class="people-ops-panel"><div class="people-ops-empty"><i class="fa-solid fa-calendar-days" aria-hidden="true"></i><strong>No rosters yet</strong><span>Create a dated roster to begin governed scheduling.</span></div></section>
    <?php endif; ?>
</section>

<div class="people-pagination"><span>Showing <?php echo e($rosters->firstItem() ?? 0); ?> to <?php echo e($rosters->lastItem() ?? 0); ?> of <?php echo e($rosters->total()); ?></span><?php echo e($rosters->links()); ?></div>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/hr/attendance/rosters/rosters.blade.php ENDPATH**/ ?>