<?php $__env->startSection('title', $employee->name.' - Employee Profile - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Employee 360','description' => $selfService ? 'Your administrator-managed employment information and authorized records.' : 'A permission-aware view of employee placement, lifecycle, and related records.','eyebrow' => $selfService ? 'My workplace' : 'People / Employee profile','active' => 'employees','selfService' => $selfService] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if($selfService): ?>
            <a class="people-button" href="<?php echo e(route('hr.employees.me')); ?>"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Self Service</a>
        <?php else: ?>
            <a class="people-button" href="<?php echo e(route('hr.employees.index')); ?>"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Employee directory</a>
        <?php endif; ?>
     <?php $__env->endSlot(); ?>

    <?php if(session('status')): ?><section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section><?php endif; ?>
    <?php if($errors->any()): ?>
        <section class="people-alert is-danger" role="alert" tabindex="-1" aria-labelledby="profile-errors-title">
            <strong id="profile-errors-title">Please correct the highlighted employee fields.</strong>
            <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </section>
    <?php endif; ?>

    <section class="people-profile-hero" aria-labelledby="employee-profile-name">
        <?php if (isset($component)) { $__componentOriginal2252ef3298868bc9de4c534a2a83a2a2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.user-avatar','data' => ['user' => $employee->user,'label' => $employee->name,'class' => 'people-profile-avatar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.user-avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($employee->user),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($employee->name),'class' => 'people-profile-avatar']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2)): ?>
<?php $attributes = $__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2; ?>
<?php unset($__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2252ef3298868bc9de4c534a2a83a2a2)): ?>
<?php $component = $__componentOriginal2252ef3298868bc9de4c534a2a83a2a2; ?>
<?php unset($__componentOriginal2252ef3298868bc9de4c534a2a83a2a2); ?>
<?php endif; ?>
        <div class="people-profile-copy">
            <h2 id="employee-profile-name"><?php echo e($employee->name); ?></h2>
            <p><?php echo e($employee->employee_code); ?> - <?php echo e($employee->designation); ?> - <?php echo e($employee->department); ?></p>
            <p><?php echo e($employee->company?->name); ?><?php echo e($employee->branch ? ' / '.$employee->branch->name : ''); ?></p>
        </div>
        <span class="people-status is-<?php echo e(['active' => 'success', 'on_notice' => 'warning', 'separated' => 'danger'][$employee->status] ?? 'muted'); ?>"><?php echo e($statuses[$employee->status] ?? ucfirst($employee->status)); ?></span>
    </section>

    <?php if (isset($component)) { $__componentOriginald7d6991c6f8cbf6e7a6895c044edeaa1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald7d6991c6f8cbf6e7a6895c044edeaa1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.employee-profile-navigation','data' => ['links' => $profileNavigation,'active' => 'overview']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.employee-profile-navigation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($profileNavigation),'active' => 'overview']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald7d6991c6f8cbf6e7a6895c044edeaa1)): ?>
<?php $attributes = $__attributesOriginald7d6991c6f8cbf6e7a6895c044edeaa1; ?>
<?php unset($__attributesOriginald7d6991c6f8cbf6e7a6895c044edeaa1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald7d6991c6f8cbf6e7a6895c044edeaa1)): ?>
<?php $component = $__componentOriginald7d6991c6f8cbf6e7a6895c044edeaa1; ?>
<?php unset($__componentOriginald7d6991c6f8cbf6e7a6895c044edeaa1); ?>
<?php endif; ?>

    <?php if($selfService): ?>
        <section class="people-quick-actions" aria-label="Employee quick actions">
            <a href="<?php echo e(route('hr.attendance-regularizations.index')); ?>"><i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i><strong>Regularize attendance</strong><span>Request a correction</span></a>
            <a href="<?php echo e(route('hr.leave-requests.index')); ?>"><i class="fa-solid fa-plane-departure" aria-hidden="true"></i><strong>Apply leave</strong><span>View balances and requests</span></a>
            <a href="<?php echo e(route('hr.expense-claims.index')); ?>"><i class="fa-solid fa-receipt" aria-hidden="true"></i><strong>New claim</strong><span>Submit an expense claim</span></a>
            <a href="<?php echo e(route('hr.helpdesk-tickets.index')); ?>"><i class="fa-solid fa-headset" aria-hidden="true"></i><strong>HR request</strong><span>Contact the HR service desk</span></a>
        </section>
    <?php endif; ?>

    <section class="people-kpis" aria-label="Employee record summary">
        <article class="people-kpi"><span>Direct reports</span><strong><?php echo e($employee->direct_reports_count); ?></strong><small>Employees reporting here</small></article>
        <article class="people-kpi"><span>Attendance records</span><strong><?php echo e($employee->attendance_records_count); ?></strong><small>Recorded work days</small></article>
        <article class="people-kpi"><span>Leave requests</span><strong><?php echo e($employee->leave_requests_count); ?></strong><small>Leave history records</small></article>
        <article class="people-kpi"><span>Performance reviews</span><strong><?php echo e($employee->performance_reviews_count); ?></strong><small>Review records</small></article>
    </section>

    <section class="people-profile-grid">
        <article class="people-panel">
            <header class="people-panel-head"><h2>Current placement</h2><i class="fa-solid fa-id-card" aria-hidden="true"></i></header>
            <dl class="people-facts">
                <div><dt>Employment type</dt><dd><?php echo e($employmentTypes[$employee->employment_type] ?? str_replace('_', ' ', ucfirst($employee->employment_type))); ?></dd></div>
                <div><dt>Branch</dt><dd><?php echo e($employee->branch?->name ?? 'Not assigned'); ?></dd></div>
                <div><dt>Primary project</dt><dd><?php echo e($employee->project?->name ?? 'All projects'); ?></dd></div>
                <div><dt>Reporting manager</dt><dd><?php echo e($employee->manager?->name ?? 'Not assigned'); ?></dd></div>
                <div><dt>Joining date</dt><dd><?php echo e($employee->joined_on?->format('d M Y') ?? 'Not recorded'); ?></dd></div>
                <div><dt>Grade</dt><dd><?php echo e($employee->grade ?? 'Not recorded'); ?></dd></div>
                <div><dt>Login account</dt><dd><?php echo e($employee->user?->email ?? 'No login linked'); ?></dd></div>
                <?php if($abilities['canViewPayroll']): ?><div><dt>Monthly CTC</dt><dd><?php echo e($employee->monthly_ctc !== null ? 'INR '.number_format((float) $employee->monthly_ctc, 2) : 'Not recorded'); ?></dd></div><?php endif; ?>
            </dl>
        </article>

        <article class="people-panel">
            <header class="people-panel-head"><h2>Employee lifecycle</h2><i class="fa-solid fa-arrows-spin" aria-hidden="true"></i></header>
            <dl class="people-facts">
                <div><dt>Documents</dt><dd><?php echo e($employee->managed_documents_count); ?></dd></div>
                <div><dt>Assigned assets</dt><dd><?php echo e($employee->assets_count); ?></dd></div>
                <div><dt>Confirmation cases</dt><dd><?php echo e($employee->confirmation_cases_count); ?></dd></div>
                <div><dt>Separation records</dt><dd><?php echo e($employee->separation_settlements_count); ?></dd></div>
                <div><dt>Expense claims</dt><dd><?php echo e($employee->expense_claims_count); ?></dd></div>
                <div><dt>Loans</dt><dd><?php echo e($employee->loans_count); ?></dd></div>
                <?php if($abilities['canViewPayroll']): ?><div><dt>Payroll records</dt><dd><?php echo e($employee->payroll_run_items_count); ?></dd></div><?php endif; ?>
            </dl>
        </article>
    </section>

    <?php if($abilities['canUpdate']): ?>
        <details class="people-edit-details" <?php if($errors->any()): ?> open <?php endif; ?>>
            <summary>Update employee record</summary>
            <form
                method="POST"
                action="<?php echo e(route('hr.employees.update', $employee)); ?>"
                class="people-form-grid people-edit-form"
                x-data="serverFormState"
                x-on:submit="beginSubmit"
                x-bind:aria-busy="busyAria"
                data-idle-label="Save changes"
                data-busy-label="Saving changes…"
            >
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <input type="hidden" name="lock_version" value="<?php echo e($employee->lock_version); ?>">
                <?php $__errorArgs = ['lock_version'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="people-field is-wide"><span class="people-field-error" role="alert" tabindex="-1"><?php echo e($message); ?></span></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <label class="people-field" for="profile-code"><span>Employee code *</span><input id="profile-code" class="people-control" name="employee_code" value="<?php echo e(old('employee_code', $employee->employee_code)); ?>" maxlength="32" required <?php if($errors->has('employee_code')): ?> aria-invalid="true" aria-describedby="profile-code-error" <?php endif; ?>><?php $__errorArgs = ['employee_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="profile-code-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field" for="profile-name"><span>Employee name *</span><input id="profile-name" class="people-control" name="name" value="<?php echo e(old('name', $employee->name)); ?>" maxlength="255" required <?php if($errors->has('name')): ?> aria-invalid="true" aria-describedby="profile-name-error" <?php endif; ?>><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="profile-name-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field" for="profile-designation"><span>Designation *</span><input id="profile-designation" class="people-control" name="designation" value="<?php echo e(old('designation', $employee->designation)); ?>" maxlength="120" required <?php if($errors->has('designation')): ?> aria-invalid="true" aria-describedby="profile-designation-error" <?php endif; ?>><?php $__errorArgs = ['designation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="profile-designation-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field" for="profile-department"><span>Department *</span><input id="profile-department" class="people-control" name="department" value="<?php echo e(old('department', $employee->department)); ?>" maxlength="120" required <?php if($errors->has('department')): ?> aria-invalid="true" aria-describedby="profile-department-error" <?php endif; ?>><?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="profile-department-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field" for="profile-branch"><span>Branch</span><select id="profile-branch" class="people-control" name="branch_id" <?php if($errors->has('branch_id')): ?> aria-invalid="true" aria-describedby="profile-branch-error" <?php endif; ?>><option value="">No branch assignment</option><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($branch->id); ?>" <?php if((string) old('branch_id', $employee->branch_id) === (string) $branch->id): echo 'selected'; endif; ?>><?php echo e($branch->code); ?> - <?php echo e($branch->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['branch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="profile-branch-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field" for="profile-project"><span>Primary project</span><select id="profile-project" class="people-control" name="project_id" <?php if($errors->has('project_id')): ?> aria-invalid="true" aria-describedby="profile-project-error" <?php endif; ?>><option value="">All-project employee</option><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($project->id); ?>" <?php if((string) old('project_id', $employee->project_id) === (string) $project->id): echo 'selected'; endif; ?>><?php echo e($project->code); ?> - <?php echo e($project->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['project_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="profile-project-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field" for="profile-manager"><span>Reporting manager</span><select id="profile-manager" class="people-control" name="manager_employee_id" <?php if($errors->has('manager_employee_id')): ?> aria-invalid="true" aria-describedby="profile-manager-error" <?php endif; ?>><option value="">No reporting manager</option><?php $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($manager->id); ?>" <?php if((string) old('manager_employee_id', $employee->manager_employee_id) === (string) $manager->id): echo 'selected'; endif; ?>><?php echo e($manager->employee_code); ?> - <?php echo e($manager->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['manager_employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="profile-manager-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field" for="profile-user"><span>Application user</span><select id="profile-user" class="people-control" name="user_id" <?php if($errors->has('user_id')): ?> aria-invalid="true" aria-describedby="profile-user-error" <?php endif; ?>><option value="">No login linked</option><?php if($employee->user): ?><option value="<?php echo e($employee->user->id); ?>" selected><?php echo e($employee->user->name); ?> - <?php echo e($employee->user->email); ?></option><?php endif; ?> <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if($user->id !== $employee->user_id): ?><option value="<?php echo e($user->id); ?>" <?php if((string) old('user_id') === (string) $user->id): echo 'selected'; endif; ?>><?php echo e($user->name); ?> - <?php echo e($user->email); ?></option><?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="profile-user-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field" for="profile-type"><span>Employment type *</span><select id="profile-type" class="people-control" name="employment_type" required <?php if($errors->has('employment_type')): ?> aria-invalid="true" aria-describedby="profile-type-error" <?php endif; ?>><?php $__currentLoopData = $employmentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(old('employment_type', $employee->employment_type) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['employment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="profile-type-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field" for="profile-status"><span>Status *</span><select id="profile-status" class="people-control" name="status" required <?php if($errors->has('status')): ?> aria-invalid="true" aria-describedby="profile-status-error" <?php endif; ?>><?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(old('status', $employee->status) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="profile-status-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field" for="profile-grade"><span>Grade</span><input id="profile-grade" class="people-control" name="grade" value="<?php echo e(old('grade', $employee->grade)); ?>" maxlength="16" <?php if($errors->has('grade')): ?> aria-invalid="true" aria-describedby="profile-grade-error" <?php endif; ?>><?php $__errorArgs = ['grade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="profile-grade-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field" for="profile-joined"><span>Joining date</span><input id="profile-joined" type="date" class="people-control" name="joined_on" value="<?php echo e(old('joined_on', $employee->joined_on?->toDateString())); ?>" max="<?php echo e(now()->toDateString()); ?>" <?php if($errors->has('joined_on')): ?> aria-invalid="true" aria-describedby="profile-joined-error" <?php endif; ?>><?php $__errorArgs = ['joined_on'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="profile-joined-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field" for="profile-state"><span>Statutory state code</span><input id="profile-state" class="people-control" name="statutory_state" value="<?php echo e(old('statutory_state', $employee->statutory_state)); ?>" maxlength="8" <?php if($errors->has('statutory_state')): ?> aria-invalid="true" aria-describedby="profile-state-error" <?php endif; ?>><?php $__errorArgs = ['statutory_state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="profile-state-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <?php if($abilities['canViewPayroll']): ?><label class="people-field" for="profile-ctc"><span>Monthly CTC</span><input id="profile-ctc" type="number" class="people-control" name="monthly_ctc" value="<?php echo e(old('monthly_ctc', $employee->monthly_ctc)); ?>" min="0" step="0.01" <?php if($errors->has('monthly_ctc')): ?> aria-invalid="true" aria-describedby="profile-ctc-error" <?php endif; ?>><?php $__errorArgs = ['monthly_ctc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="profile-ctc-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label><?php endif; ?>
                <div class="people-field is-wide"><button type="submit" class="people-button is-primary" x-bind:disabled="busy"><span x-text="submitLabel">Save changes</span></button></div>
            </form>
        </details>
    <?php else: ?>
        <section class="people-alert" role="note"><i class="fa-solid fa-lock" aria-hidden="true"></i> This profile is available in read-only mode for your current access.</section>
    <?php endif; ?>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/developer/public_html/builder360/resources/views/hr/employees/show.blade.php ENDPATH**/ ?>