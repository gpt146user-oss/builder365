<?php if($abilities['canManage']): ?>
    <?php ($initialCycleDays = max(1, min(31, (int) old('cycle_days', 7)))); ?>
    <section class="people-ops-panel people-roster-create">
        <header class="people-ops-panel-head">
            <div>
                <h2>Create reusable rotation</h2>
                <p>Define one deterministic cycle item per day. Generation never duplicates an existing occurrence.</p>
            </div>
            <span class="people-status is-info">Versioned</span>
        </header>
        <form
            class="people-ops-panel-body people-form-grid"
            method="POST"
            action="<?php echo e(route('hr.attendance-rotation-rules.store')); ?>"
            data-disable-on-submit
            x-data="rotationPatternEditor"
            data-initial-cycle-days="<?php echo e($initialCycleDays); ?>"
        >
            <?php echo csrf_field(); ?>
            <label class="people-field">
                Rule name
                <input class="people-control" name="name" value="<?php echo e(old('name')); ?>" required maxlength="160">
            </label>
            <label class="people-field">
                Employee
                <select class="people-control" name="employee_id" required>
                    <option value="">Select employee</option>
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($employee->id); ?>" <?php if(old('employee_id') == $employee->id): echo 'selected'; endif; ?>><?php echo e($employee->name); ?> &middot; <?php echo e($employee->department ?: 'No department'); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>
            <label class="people-field">
                Anchor date
                <input class="people-control" type="date" name="anchor_date" value="<?php echo e(old('anchor_date', now()->startOfWeek()->toDateString())); ?>" required>
            </label>
            <label class="people-field">
                Generation horizon
                <input class="people-control" type="number" name="generation_horizon_days" value="<?php echo e(old('generation_horizon_days', 90)); ?>" min="1" max="366" required>
            </label>
            <label class="people-field">
                Cycle length
                <input class="people-control" type="number" name="cycle_days" value="<?php echo e($initialCycleDays); ?>" min="1" max="31" required x-on:input="updateCycleDays">
                <small>Choose between 1 and 31 days.</small>
            </label>

            <fieldset class="people-rotation-pattern is-wide">
                <legend x-ref="cycleLabel"><?php echo e($initialCycleDays); ?>-day rotation pattern</legend>
                <p>Choose a working shift, weekly off, or holiday for each cycle day.</p>
                <div class="people-rotation-days" x-ref="days" x-on:change="normalizeDay">
                    <?php for($day = 0; $day < $initialCycleDays; $day++): ?>
                        <div class="people-rotation-day" data-rotation-day>
                            <strong data-day-label>Day <?php echo e($day + 1); ?></strong>
                            <label class="people-field">
                                <span class="sr-only">Day <?php echo e($day + 1); ?> type</span>
                                <select class="people-control" name="pattern[<?php echo e($day); ?>][type]" required data-day-type>
                                    <option value="shift" <?php if(old("pattern.$day.type", 'shift') === 'shift'): echo 'selected'; endif; ?>>Working shift</option>
                                    <option value="off" <?php if(old("pattern.$day.type") === 'off'): echo 'selected'; endif; ?>>Weekly off</option>
                                    <option value="holiday" <?php if(old("pattern.$day.type") === 'holiday'): echo 'selected'; endif; ?>>Holiday</option>
                                </select>
                            </label>
                            <label class="people-field">
                                <span class="sr-only">Day <?php echo e($day + 1); ?> shift</span>
                                <select class="people-control" name="pattern[<?php echo e($day); ?>][attendance_shift_id]" data-day-shift>
                                    <option value="">No shift</option>
                                    <?php $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($shift->id); ?>" <?php if(old("pattern.$day.attendance_shift_id") == $shift->id): echo 'selected'; endif; ?>><?php echo e($shift->code); ?> &middot; <?php echo e($shift->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </label>
                        </div>
                    <?php endfor; ?>
                </div>
                <template x-ref="dayTemplate">
                    <div class="people-rotation-day" data-rotation-day>
                        <strong data-day-label>Day</strong>
                        <label class="people-field">
                            <span class="sr-only">Rotation day type</span>
                            <select class="people-control" required data-day-type>
                                <option value="shift">Working shift</option>
                                <option value="off">Weekly off</option>
                                <option value="holiday">Holiday</option>
                            </select>
                        </label>
                        <label class="people-field">
                            <span class="sr-only">Rotation day shift</span>
                            <select class="people-control" data-day-shift>
                                <option value="">No shift</option>
                                <?php $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($shift->id); ?>"><?php echo e($shift->code); ?> &middot; <?php echo e($shift->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>
                    </div>
                </template>
            </fieldset>
            <div class="people-form-actions is-wide">
                <button class="people-button is-primary" type="submit"><i class="fa-solid fa-rotate" aria-hidden="true"></i> Create rotation</button>
            </div>
        </form>
    </section>
<?php endif; ?>

<section class="people-ops-panel has-mobile-cards">
    <header class="people-ops-panel-head">
        <div><h2>Rotation rules</h2><p>Rules generate dated entries only into draft rosters.</p></div>
        <span class="people-count"><?php echo e($rotations->total()); ?> rules</span>
    </header>
    <div class="people-ops-table-wrap">
        <table class="people-ops-table">
            <caption>Attendance rotation rules</caption>
            <thead><tr><th scope="col">Employee / rule</th><th scope="col">Anchor</th><th scope="col">Cycle</th><th scope="col">Horizon</th><th scope="col">Status</th><th scope="col">Generate into draft</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $rotations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rotation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><strong><?php echo e($rotation->employee->name); ?></strong><small><?php echo e($rotation->name); ?></small></td>
                        <td><?php echo e($rotation->anchor_date->format('d M Y')); ?></td>
                        <td><?php echo e($rotation->cycle_days); ?> days</td>
                        <td><?php echo e($rotation->generation_horizon_days); ?> days</td>
                        <td><span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['people-status', 'is-success' => $rotation->status === 'active', 'is-warning' => $rotation->status === 'paused']); ?>"><?php echo e(str($rotation->status)->headline()); ?></span></td>
                        <td>
                            <?php if($abilities['canManage'] && $rotation->status === 'active' && $draftRosters->isNotEmpty()): ?>
                                <details class="people-compact-menu">
                                    <summary class="people-button">Generate</summary>
                                    <div>
                                        <?php $__currentLoopData = $draftRosters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $draft): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <form method="POST" action="<?php echo e(route('hr.attendance-rotation-rules.generate', [$rotation, $draft])); ?>">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="lock_version" value="<?php echo e($draft->lock_version); ?>">
                                                <button type="submit"><?php echo e($draft->name); ?><small><?php echo e($draft->period_start->format('d M')); ?> &ndash; <?php echo e($draft->period_end->format('d M Y')); ?></small></button>
                                            </form>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </details>
                            <?php else: ?>
                                <span class="people-muted">Unavailable</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6"><div class="people-ops-empty"><i class="fa-solid fa-rotate" aria-hidden="true"></i><strong>No rotation rules</strong><span>Create an employee rotation to generate dated roster occurrences.</span></div></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="people-ops-mobile-list">
        <?php $__currentLoopData = $rotations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rotation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="people-ops-mobile-card">
                <header class="people-ops-mobile-card-head"><div><strong><?php echo e($rotation->employee->name); ?></strong><small><?php echo e($rotation->name); ?></small></div><span class="people-status is-success"><?php echo e(str($rotation->status)->headline()); ?></span></header>
                <dl class="people-ops-mobile-facts"><div><dt>Anchor</dt><dd><?php echo e($rotation->anchor_date->format('d M Y')); ?></dd></div><div><dt>Cycle</dt><dd><?php echo e($rotation->cycle_days); ?> days</dd></div><div><dt>Horizon</dt><dd><?php echo e($rotation->generation_horizon_days); ?> days</dd></div></dl>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="people-pagination"><span>Showing <?php echo e($rotations->firstItem() ?? 0); ?> to <?php echo e($rotations->lastItem() ?? 0); ?> of <?php echo e($rotations->total()); ?></span><?php echo e($rotations->links()); ?></div>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\attendance\rosters\rotations.blade.php ENDPATH**/ ?>