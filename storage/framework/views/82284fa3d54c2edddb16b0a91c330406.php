<?php if($abilities['canCreateShift']): ?>
    <details class="people-ops-panel" id="shift-form" <?php if($errors->any()): ?> open <?php endif; ?>>
        <summary class="people-ops-panel-head"><div><h2>Create shift definition</h2><p>Configure stored timing thresholds used by attendance processing.</p></div><span class="people-button is-primary"><i class="fa-solid fa-plus" aria-hidden="true"></i> New shift</span></summary>
        <form method="POST" action="<?php echo e(route('hr.attendance-shifts.store')); ?>" class="people-ops-panel-body">
            <?php echo csrf_field(); ?>
            <?php if (isset($component)) { $__componentOriginal5ee006ce6757c21855df609df2a8580f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5ee006ce6757c21855df609df2a8580f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.company-context','data' => ['companies' => $companies,'placeholder' => 'Use my company']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.company-context'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['companies' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($companies),'placeholder' => 'Use my company']); ?>
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
            <div class="people-ops-controls-grid">
                <label class="people-field">Code<input class="people-control" name="code" value="<?php echo e(old('code')); ?>" maxlength="32" required placeholder="DAY_GENERAL"><?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field">Name<input class="people-control" name="name" value="<?php echo e(old('name')); ?>" maxlength="255" required placeholder="General day shift"><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field">Starts at<input class="people-control" type="time" name="starts_at" value="<?php echo e(old('starts_at')); ?>" required><?php $__errorArgs = ['starts_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field">Ends at<input class="people-control" type="time" name="ends_at" value="<?php echo e(old('ends_at')); ?>" required><?php $__errorArgs = ['ends_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field">Late grace minutes<input class="people-control" type="number" name="late_grace_minutes" min="0" max="240" value="<?php echo e(old('late_grace_minutes', 0)); ?>" required></label>
                <label class="people-field">Early-leave grace minutes<input class="people-control" type="number" name="early_leave_grace_minutes" min="0" max="240" value="<?php echo e(old('early_leave_grace_minutes', 0)); ?>" required></label>
                <label class="people-field">Half-day threshold minutes<input class="people-control" type="number" name="half_day_threshold_minutes" min="1" max="1440" value="<?php echo e(old('half_day_threshold_minutes', 240)); ?>" required></label>
                <label class="people-field">Full-day threshold minutes<input class="people-control" type="number" name="full_day_threshold_minutes" min="1" max="1440" value="<?php echo e(old('full_day_threshold_minutes', 480)); ?>" required></label>
                <label class="people-field">Shift type<select class="people-control" name="rules[shift_type]"><option value="">Not specified</option><?php $__currentLoopData = $shiftTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($type['value']); ?>" <?php if(old('rules.shift_type') === $type['value']): echo 'selected'; endif; ?>><?php echo e($type['label']); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field">Weekly-off policy<input class="people-control" name="rules[weekly_off_policy]" maxlength="120" value="<?php echo e(old('rules.weekly_off_policy')); ?>" placeholder="Configured policy name"></label>
            </div>
            <input type="hidden" name="is_overnight" value="0">
            <label class="people-field"><span><input type="checkbox" name="is_overnight" value="1" <?php if(old('is_overnight')): echo 'checked'; endif; ?>> Overnight shift</span></label>
            <label class="people-field"><span><input type="checkbox" name="rules[overtime_enabled]" value="1" <?php if(old('rules.overtime_enabled')): echo 'checked'; endif; ?>> Overtime rule enabled</span></label>
            <label class="people-field"><span><input type="checkbox" name="rules[geofence_required]" value="1" <?php if(old('rules.geofence_required')): echo 'checked'; endif; ?>> Geofence required</span></label>
            <details class="people-ops-panel" <?php if($errors->has('segments') || $errors->has('segments.*')): ?> open <?php endif; ?>>
                <summary class="people-ops-panel-head"><div><h3>Split-shift working segments</h3><p>Required only when Shift type is Split. Blank rows are ignored.</p></div></summary>
                <div class="people-ops-panel-body people-ops-controls-grid">
                    <?php for($segmentIndex = 0; $segmentIndex < 4; $segmentIndex++): ?>
                        <label class="people-field">Segment <?php echo e($segmentIndex + 1); ?> label
                            <input class="people-control" name="segments[<?php echo e($segmentIndex); ?>][label]" maxlength="80" value="<?php echo e(old("segments.$segmentIndex.label")); ?>" placeholder="<?php echo e($segmentIndex === 0 ? 'Morning' : ($segmentIndex === 1 ? 'Afternoon' : 'Optional')); ?>">
                            <?php $__errorArgs = ["segments.$segmentIndex.label"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </label>
                        <label class="people-field">Segment <?php echo e($segmentIndex + 1); ?> starts
                            <input class="people-control" type="time" name="segments[<?php echo e($segmentIndex); ?>][starts_at]" value="<?php echo e(old("segments.$segmentIndex.starts_at")); ?>">
                            <?php $__errorArgs = ["segments.$segmentIndex.starts_at"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </label>
                        <label class="people-field">Segment <?php echo e($segmentIndex + 1); ?> ends
                            <input class="people-control" type="time" name="segments[<?php echo e($segmentIndex); ?>][ends_at]" value="<?php echo e(old("segments.$segmentIndex.ends_at")); ?>">
                            <?php $__errorArgs = ["segments.$segmentIndex.ends_at"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </label>
                    <?php endfor; ?>
                    <?php $__errorArgs = ['segments'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </details>
            <button class="people-button is-primary" type="submit"><i class="fa-solid fa-floppy-disk" aria-hidden="true"></i> Save shift</button>
        </form>
    </details>
<?php endif; ?>

<section class="people-ops-panel">
    <header class="people-ops-panel-head"><div><h2>Shift definitions</h2><p>Active timing and attendance threshold rules in your authorized company scope.</p></div><span class="people-count"><?php echo e($shifts->total()); ?> shifts</span></header>

    <div class="people-shift-grid">
        <?php $__empty_1 = true; $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="people-shift-card">
                <header class="people-shift-card-head"><span class="people-shift-card-icon"><i class="fa-regular fa-clock" aria-hidden="true"></i></span><span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['people-status', 'is-purple' => $shift->overnight, 'is-success' => ! $shift->overnight]); ?>"><?php echo e($shift->overnight ? 'Overnight' : 'Same day'); ?></span></header>
                <h2><?php echo e($shift->name); ?></h2>
                <strong class="people-shift-time"><?php echo e($shift->timing); ?></strong>
                <p><?php echo e($shift->code); ?> / Late grace <?php echo e($shift->lateGraceMinutes); ?> min / Early grace <?php echo e($shift->earlyLeaveGraceMinutes); ?> min</p>
                <p>Half day <?php echo e($shift->halfDayThresholdMinutes); ?> min / Full day <?php echo e($shift->fullDayThresholdMinutes); ?> min</p>
                <?php if($shift->segments): ?>
                    <ol aria-label="Split-shift working segments">
                        <?php $__currentLoopData = $shift->segments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $segment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($segment['label'] ?: 'Segment '.$segment['sequence']); ?>: <?php echo e($segment['timing']); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ol>
                <?php endif; ?>
                <div class="people-shift-meta"><span><?php echo e($shift->activeAssignments); ?> active assignments</span><span><?php echo e($shift->rules ? count($shift->rules).' optional rules' : 'No optional rules'); ?></span></div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="people-ops-empty"><i class="fa-regular fa-clock" aria-hidden="true"></i><strong>No active shift definitions</strong><span>Create a shift only when its approved timing and attendance thresholds are known.</span></div>
        <?php endif; ?>
    </div>

    <div class="people-pagination"><span>Showing <?php echo e($shifts->firstItem() ?? 0); ?> to <?php echo e($shifts->lastItem() ?? 0); ?> of <?php echo e($shifts->total()); ?></span><?php echo e($shifts->withQueryString()->links()); ?></div>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\attendance\partials\shifts.blade.php ENDPATH**/ ?>