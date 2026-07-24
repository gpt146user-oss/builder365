<?php $__env->startSection('title', 'Exit Interviews - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Exit Interviews','description' => 'Schedule employee feedback, protect confidential responses, and track authorized HR follow-up actions.','active' => 'lifecycle'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if($abilities['canCreate']): ?><a class="people-button is-primary" href="#schedule-exit-interview"><i class="fa-solid fa-plus" aria-hidden="true"></i> Schedule interview</a><?php endif; ?>
     <?php $__env->endSlot(); ?>

    <?php echo $__env->make('hr.lifecycle.partials.navigation', ['activeLifecycleSection' => 'exit'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if(session('status')): ?><section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section><?php endif; ?>
    <?php if($errors->any()): ?><section class="people-alert is-danger" role="alert" tabindex="-1"><strong>Please correct the highlighted exit interview fields.</strong><ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></section><?php endif; ?>

    <section class="people-ops-kpis" aria-label="Exit interview summary">
        <article class="people-ops-kpi"><span class="people-ops-kpi-icon is-indigo"><i class="fa-solid fa-comments" aria-hidden="true"></i></span><div><strong><?php echo e($summary['total']); ?></strong><span>Total interviews</span></div></article>
        <article class="people-ops-kpi"><span class="people-ops-kpi-icon is-blue"><i class="fa-solid fa-calendar-day" aria-hidden="true"></i></span><div><strong><?php echo e($summary['status_counts']['scheduled'] ?? 0); ?></strong><span>Scheduled</span></div></article>
        <article class="people-ops-kpi"><span class="people-ops-kpi-icon is-amber"><i class="fa-solid fa-hourglass-half" aria-hidden="true"></i></span><div><strong><?php echo e($summary['status_counts']['submitted'] ?? 0); ?></strong><span>Awaiting HR review</span></div></article>
        <article class="people-ops-kpi"><span class="people-ops-kpi-icon is-green"><i class="fa-solid fa-circle-check" aria-hidden="true"></i></span><div><strong><?php echo e($summary['status_counts']['reviewed'] ?? 0); ?></strong><span>Reviewed</span></div></article>
        <article class="people-ops-kpi"><span class="people-ops-kpi-icon is-red"><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i></span><div><strong><?php echo e($summary['open_action_items']); ?></strong><span>Open actions</span></div></article>
    </section>

    <?php if($abilities['canCreate']): ?>
        <details class="people-ops-panel" id="schedule-exit-interview" <?php if($errors->any()): ?> open <?php endif; ?>>
            <summary class="people-ops-panel-head"><div><h2>Schedule exit interview</h2><p>Link the interview to an authorized employee and, when available, their final settlement.</p></div></summary>
            <div class="people-ops-panel-body"><form method="POST" action="<?php echo e(route('hr.exit-interviews.store')); ?>" class="people-form-grid"><?php echo csrf_field(); ?>
                <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id" required><option value="">Select employee</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string)old('employee_id')===(string)$employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> · <?php echo e($employee->name); ?><?php echo e($employee->department ? ' · '.$employee->department : ''); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field"><span>Final settlement</span><select class="people-control" name="employee_separation_settlement_id"><option value="">No linked settlement</option><?php $__currentLoopData = $settlements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $settlement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($settlement->id); ?>" <?php if((string)old('employee_separation_settlement_id')===(string)$settlement->id): echo 'selected'; endif; ?>><?php echo e($settlement->settlement_number); ?> · <?php echo e($settlement->employee?->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['employee_separation_settlement_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field"><span>Interview due on</span><input class="people-control" type="date" name="interview_due_on" value="<?php echo e(old('interview_due_on')); ?>" required><?php $__errorArgs = ['interview_due_on'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field is-wide"><span>Scheduling note</span><textarea class="people-control" name="note" maxlength="1000"><?php echo e(old('note')); ?></textarea><?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <button class="people-button is-primary" type="submit">Schedule interview</button>
            </form></div>
        </details>
    <?php endif; ?>

    <section class="people-ops-panel has-mobile-cards" aria-labelledby="exit-interview-register-title">
        <header class="people-ops-panel-head"><div><h2 id="exit-interview-register-title">Exit interview register</h2><p><?php echo e($interviews->total()); ?> authorized interview<?php echo e($interviews->total() === 1 ? '' : 's'); ?>.</p></div><a class="people-button" href="<?php echo e(route('hr.exit-interviews.summary', request()->query())); ?>">Summary data</a></header>
        <div class="people-ops-panel-body"><form method="GET" action="<?php echo e(route('hr.exit-interviews.index')); ?>" class="people-ops-filterbar" aria-label="Filter exit interviews">
            <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id"><option value="">All visible employees</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($employee->id); ?>" <?php if((string)request('employee_id')===(string)$employee->id): echo 'selected'; endif; ?>><?php echo e($employee->employee_code); ?> · <?php echo e($employee->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="people-field"><span>Status</span><select class="people-control" name="status"><option value="">All statuses</option><?php $__currentLoopData = ['scheduled'=>'Scheduled','submitted'=>'Submitted','reviewed'=>'Reviewed','archived'=>'Archived']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(request('status')===$value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="people-field"><span>Reason</span><select class="people-control" name="separation_reason"><option value="">All reasons</option><?php $__currentLoopData = ['career_growth','compensation','relocation','manager_issue','work_environment','health','retirement','contract_end','personal','other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(request('separation_reason')===$value): echo 'selected'; endif; ?>><?php echo e(str_replace('_',' ',ucfirst($value))); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="people-field"><span>From</span><input class="people-control" type="date" name="from" value="<?php echo e(request('from')); ?>"></label>
            <label class="people-field"><span>To</span><input class="people-control" type="date" name="to" value="<?php echo e(request('to')); ?>"></label>
            <button class="people-button is-primary">Apply</button><a class="people-button" href="<?php echo e(route('hr.exit-interviews.index')); ?>">Clear</a>
        </form></div>

        <div class="people-ops-table-wrap"><table class="people-ops-table"><caption>Employee exit interviews</caption><thead><tr><th scope="col">Interview</th><th scope="col">Employee</th><th scope="col">Schedule</th><th scope="col">Ratings</th><th scope="col">Reason / rehire</th><th scope="col">Status</th><th scope="col">Action</th></tr></thead><tbody>
        <?php $__empty_1 = true; $__currentLoopData = $interviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interview): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> <?php ($actions=$interviewActions[$interview->id]??[]); ?>
            <tr>
                <td><strong><?php echo e($interview->interview_number); ?></strong><small><?php echo e(count($interview->risk_flags ?? [])); ?> risk flag(s)</small></td>
                <td><span class="people-ops-identity"><strong><?php echo e($interview->employee?->name); ?></strong><small><?php echo e($interview->employee?->employee_code); ?> · <?php echo e($interview->employee?->department ?: 'No department'); ?></small></span></td>
                <td><?php echo e($interview->interview_due_on?->format('d M Y') ?? 'Not set'); ?><small><?php echo e($interview->submitted_at?->format('d M Y H:i') ?? 'Not submitted'); ?></small></td>
                <td>Overall <?php echo e($interview->overall_experience_rating ?? 'Not rated'); ?><small>Manager <?php echo e($interview->manager_relationship_rating ?? 'Not rated'); ?></small></td>
                <td><?php echo e($interview->separation_reason ? str_replace('_',' ',ucfirst($interview->separation_reason)) : 'Awaiting response'); ?><small>Rehire: <?php echo e($interview->rehire_recommendation ? ucfirst($interview->rehire_recommendation) : 'Not recorded'); ?></small></td>
                <td><span class="people-status is-<?php echo e($interview->status === 'reviewed' ? 'success' : ($interview->status === 'archived' ? 'neutral' : 'warning')); ?>"><?php echo e(ucfirst($interview->status)); ?></span></td>
                <td>
                    <?php if($actions['canSubmit']??false): ?><details><summary class="people-ops-action-link">Submit feedback</summary><?php echo $__env->make('hr.exit-interviews.partials.submit-form', ['interview' => $interview], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></details><?php endif; ?>
                    <?php if($actions['canReview']??false): ?><details><summary class="people-ops-action-link">HR review</summary><?php echo $__env->make('hr.exit-interviews.partials.review-form', ['interview' => $interview], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></details><?php endif; ?>
                    <?php if (! (($actions['canSubmit']??false)||($actions['canReview']??false))): ?><span class="people-subtext">No action</span><?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="7"><div class="people-ops-empty"><strong>No exit interviews found</strong><span>Clear the filters or schedule an authorized interview.</span></div></td></tr><?php endif; ?>
        </tbody></table></div>

        <div class="people-ops-mobile-list"><?php $__empty_1 = true; $__currentLoopData = $interviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interview): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> <?php ($actions=$interviewActions[$interview->id]??[]); ?><article class="people-ops-mobile-card"><header class="people-ops-mobile-card-head"><span class="people-ops-identity"><strong><?php echo e($interview->employee?->name); ?></strong><small><?php echo e($interview->interview_number); ?> · <?php echo e($interview->employee?->employee_code); ?></small></span><span class="people-status is-info"><?php echo e(ucfirst($interview->status)); ?></span></header><dl class="people-ops-mobile-facts"><div><dt>Due</dt><dd><?php echo e($interview->interview_due_on?->format('d M Y') ?? 'Not set'); ?></dd></div><div><dt>Reason</dt><dd><?php echo e($interview->separation_reason ? str_replace('_',' ',ucfirst($interview->separation_reason)) : 'Pending'); ?></dd></div><div><dt>Open actions</dt><dd><?php echo e(count($interview->action_items ?? [])); ?></dd></div></dl><?php if(($actions['canSubmit']??false)||($actions['canReview']??false)): ?><div class="people-ops-mobile-actions"><?php if($actions['canSubmit']??false): ?><details><summary class="people-button">Submit feedback</summary><?php echo $__env->make('hr.exit-interviews.partials.submit-form', ['interview' => $interview], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></details><?php endif; ?> <?php if($actions['canReview']??false): ?><details><summary class="people-button">HR review</summary><?php echo $__env->make('hr.exit-interviews.partials.review-form', ['interview' => $interview], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></details><?php endif; ?></div><?php endif; ?></article><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><div class="people-ops-empty"><strong>No exit interviews found</strong></div><?php endif; ?></div>
        <?php echo e($interviews->withQueryString()->links()); ?>

    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9)): ?>
<?php $attributes = $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9; ?>
<?php unset($__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9)): ?>
<?php $component = $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9; ?>
<?php unset($__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\exit-interviews\index.blade.php ENDPATH**/ ?>