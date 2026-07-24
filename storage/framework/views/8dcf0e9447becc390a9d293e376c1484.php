<section
    id="create-employee"
    class="people-modal <?php echo e($errors->any() ? 'is-open' : ''); ?>"
    x-bind:class="createModalClasses"
    x-bind:aria-hidden="createAriaHidden"
    aria-hidden="<?php echo e($errors->any() ? 'false' : 'true'); ?>"
    aria-labelledby="create-employee-title"
>
    <a class="people-modal-backdrop" href="<?php echo e(route('hr.employees.index')); ?>" x-on:click.prevent="closeCreateEmployee" aria-label="Close create employee dialog"></a>

    <form
        method="POST"
        action="<?php echo e(route('hr.employees.store')); ?>"
        class="people-modal-panel"
        role="dialog"
        aria-modal="true"
        aria-labelledby="create-employee-title"
        aria-describedby="create-employee-description"
        x-ref="createDialog"
        x-on:submit="submitEmployeeForm"
        x-bind:aria-busy="submitting"
        x-on:keydown="trapCreateFocus"
    >
        <?php echo csrf_field(); ?>
        <header class="people-modal-head">
            <div class="people-modal-title">
                <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                <div>
                    <h2 id="create-employee-title">Create employee record</h2>
                    <p id="create-employee-description">Create an employee identity and initial work placement.</p>
                </div>
            </div>
            <a href="<?php echo e(route('hr.employees.index')); ?>" class="people-icon-button" x-on:click.prevent="closeCreateEmployee" aria-label="Close create employee dialog">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </a>
        </header>

        <div class="people-modal-body">
            <?php if (isset($component)) { $__componentOriginal5ee006ce6757c21855df609df2a8580f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5ee006ce6757c21855df609df2a8580f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.company-context','data' => ['companies' => $companies,'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.company-context'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['companies' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($companies),'required' => true]); ?>
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

            <div class="people-form-grid">
                <label class="people-field" for="employee-code">
                    <span>Employee code *</span>
                    <input id="employee-code" class="people-control" name="employee_code" value="<?php echo e(old('employee_code')); ?>" maxlength="32" placeholder="EMP-0045" required autocomplete="off" <?php if($errors->has('employee_code')): ?> aria-invalid="true" aria-describedby="employee-code-error" <?php endif; ?>>
                    <?php $__errorArgs = ['employee_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="employee-code-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="people-field" for="employee-name">
                    <span>Employee name *</span>
                    <input id="employee-name" class="people-control" name="name" value="<?php echo e(old('name')); ?>" maxlength="255" required autocomplete="name" <?php if($errors->has('name')): ?> aria-invalid="true" aria-describedby="employee-name-error" <?php endif; ?>>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="employee-name-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="people-field" for="employee-designation">
                    <span>Designation *</span>
                    <input id="employee-designation" class="people-control" name="designation" value="<?php echo e(old('designation')); ?>" list="employee-designations" maxlength="120" required <?php if($errors->has('designation')): ?> aria-invalid="true" aria-describedby="employee-designation-error" <?php endif; ?>>
                    <datalist id="employee-designations"><?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($designation); ?>"><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></datalist>
                    <?php $__errorArgs = ['designation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="employee-designation-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="people-field" for="employee-department">
                    <span>Department *</span>
                    <input id="employee-department" class="people-control" name="department" value="<?php echo e(old('department')); ?>" list="employee-departments" maxlength="120" required <?php if($errors->has('department')): ?> aria-invalid="true" aria-describedby="employee-department-error" <?php endif; ?>>
                    <datalist id="employee-departments"><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($department); ?>"><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></datalist>
                    <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="employee-department-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="people-field" for="employee-branch">
                    <span>Branch / site</span>
                    <select id="employee-branch" class="people-control" name="branch_id" <?php if($errors->has('branch_id')): ?> aria-invalid="true" aria-describedby="employee-branch-error" <?php endif; ?>>
                        <option value="">No branch assignment</option>
                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($branch->id); ?>" <?php if((string) old('branch_id') === (string) $branch->id): echo 'selected'; endif; ?>><?php echo e($branch->code); ?> - <?php echo e($branch->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['branch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="employee-branch-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="people-field" for="employee-project">
                    <span>Primary project</span>
                    <select id="employee-project" class="people-control" name="project_id" <?php if($errors->has('project_id')): ?> aria-invalid="true" aria-describedby="employee-project-error" <?php endif; ?>>
                        <option value="">All-project employee</option>
                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($project->id); ?>" <?php if((string) old('project_id') === (string) $project->id): echo 'selected'; endif; ?>><?php echo e($project->code); ?> - <?php echo e($project->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['project_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="employee-project-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="people-field" for="employee-manager">
                    <span>Reporting manager</span>
                    <select id="employee-manager" class="people-control" name="manager_employee_id" <?php if($errors->has('manager_employee_id')): ?> aria-invalid="true" aria-describedby="employee-manager-error" <?php endif; ?>>
                        <option value="">No reporting manager</option>
                        <?php $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($manager->id); ?>" <?php if((string) old('manager_employee_id') === (string) $manager->id): echo 'selected'; endif; ?>><?php echo e($manager->employee_code); ?> - <?php echo e($manager->name); ?><?php echo e($manager->designation ? ' / '.$manager->designation : ''); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['manager_employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="employee-manager-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="people-field" for="employee-user">
                    <span>Application user</span>
                    <select id="employee-user" class="people-control" name="user_id" <?php if($errors->has('user_id')): ?> aria-invalid="true" aria-describedby="employee-user-error" <?php endif; ?>>
                        <option value="">No login linked</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($user->id); ?>" <?php if((string) old('user_id') === (string) $user->id): echo 'selected'; endif; ?>><?php echo e($user->name); ?> - <?php echo e($user->email); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="employee-user-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="people-field" for="employee-type">
                    <span>Employment type *</span>
                    <select id="employee-type" class="people-control" name="employment_type" required <?php if($errors->has('employment_type')): ?> aria-invalid="true" aria-describedby="employee-type-error" <?php endif; ?>>
                        <?php $__currentLoopData = $employmentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(old('employment_type', 'full_time') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['employment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="employee-type-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="people-field" for="employee-status">
                    <span>Status *</span>
                    <select id="employee-status" class="people-control" name="status" required <?php if($errors->has('status')): ?> aria-invalid="true" aria-describedby="employee-status-error" <?php endif; ?>>
                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(old('status', 'active') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="employee-status-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="people-field" for="employee-grade">
                    <span>Grade</span>
                    <input id="employee-grade" class="people-control" name="grade" value="<?php echo e(old('grade')); ?>" maxlength="16" <?php if($errors->has('grade')): ?> aria-invalid="true" aria-describedby="employee-grade-error" <?php endif; ?>>
                    <?php $__errorArgs = ['grade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="employee-grade-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="people-field" for="employee-joined">
                    <span>Joining date</span>
                    <input id="employee-joined" type="date" class="people-control" name="joined_on" value="<?php echo e(old('joined_on')); ?>" max="<?php echo e(now()->toDateString()); ?>" <?php if($errors->has('joined_on')): ?> aria-invalid="true" aria-describedby="employee-joined-error" <?php endif; ?>>
                    <?php $__errorArgs = ['joined_on'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="employee-joined-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="people-field" for="employee-state">
                    <span>Statutory state code</span>
                    <input id="employee-state" class="people-control" name="statutory_state" value="<?php echo e(old('statutory_state')); ?>" maxlength="8" placeholder="MH" <?php if($errors->has('statutory_state')): ?> aria-invalid="true" aria-describedby="employee-state-error" <?php endif; ?>>
                    <?php $__errorArgs = ['statutory_state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="employee-state-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <?php if($abilities['canViewCompensation']): ?>
                    <label class="people-field" for="employee-ctc">
                        <span>Monthly CTC</span>
                        <input id="employee-ctc" type="number" class="people-control" name="monthly_ctc" value="<?php echo e(old('monthly_ctc')); ?>" min="0" step="0.01" <?php if($errors->has('monthly_ctc')): ?> aria-invalid="true" aria-describedby="employee-ctc-error" <?php endif; ?>>
                        <small>Visible only to authorized HR and payroll roles.</small>
                        <?php $__errorArgs = ['monthly_ctc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="people-field-error" id="employee-ctc-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                <?php endif; ?>
            </div>
        </div>

        <footer class="people-modal-foot">
            <p>Required fields are marked with an asterisk.</p>
            <div class="people-modal-actions">
                <a href="<?php echo e(route('hr.employees.index')); ?>" class="people-button" x-on:click.prevent="closeCreateEmployee">Cancel</a>
                <button type="submit" class="people-button is-primary" x-bind:disabled="submitting">
                    <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                    <span x-text="submitLabel">Create employee</span>
                </button>
            </div>
        </footer>
    </form>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\employees\partials\create-form.blade.php ENDPATH**/ ?>