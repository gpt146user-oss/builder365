<?php if (isset($component)) { $__componentOriginal17e1d856121687ce90b748b5990193ab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal17e1d856121687ce90b748b5990193ab = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.responsive-register','data' => ['class' => 'people-register-shell','label' => 'Employee directory results']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.responsive-register'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'people-register-shell','label' => 'Employee directory results']); ?>
     <?php $__env->slot('desktop', null, []); ?> 
        <table class="people-register">
            <caption>Employees matching the current directory filters</caption>
            <thead>
                <tr>
                    <th scope="col">Employee</th>
                    <th scope="col">Department</th>
                    <th scope="col">Company / Site</th>
                    <th scope="col">Grade</th>
                    <th scope="col">Attendance</th>
                    <th scope="col">Net Salary</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php ($row = $directoryRows->get($employee->id)); ?>
                    <tr>
                        <td>
                            <div class="people-identity">
                                <?php if (isset($component)) { $__componentOriginal2252ef3298868bc9de4c534a2a83a2a2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.user-avatar','data' => ['user' => $employee->user,'label' => $row->name,'class' => 'people-avatar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.user-avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($employee->user),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($row->name),'class' => 'people-avatar']); ?>
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
                                <div>
                                    <a href="<?php echo e(route('hr.employees.show', $employee)); ?>" aria-label="Open employee profile for <?php echo e($row->name); ?>"><?php echo e($row->name); ?></a>
                                    <span class="people-subtext"><?php echo e($row->employeeCode); ?> - <?php echo e($row->designation); ?></span>
                                </div>
                            </div>
                        </td>
                        <td><?php echo e($row->department); ?><span class="people-subtext"><?php echo e($row->manager); ?></span></td>
                        <td><?php echo e($row->company); ?><span class="people-subtext"><?php echo e($row->branch); ?> / <?php echo e($row->project); ?></span></td>
                        <td><?php echo e($row->grade ?? 'Not recorded'); ?></td>
                        <td><div class="people-attendance"><small><?php echo e($row->attendanceLabel); ?></small></div></td>
                        <td>
                            <?php if(! $abilities['canViewCompensation']): ?>
                                <span class="people-compensation is-restricted">Restricted</span>
                            <?php elseif($row->latestApprovedNetSalary !== null): ?>
                                <span class="people-compensation">INR <?php echo e(number_format($row->latestApprovedNetSalary, 2)); ?></span>
                            <?php else: ?>
                                <span class="people-compensation is-restricted">No approved payroll</span>
                            <?php endif; ?>
                        </td>
                        <td><span class="people-status is-<?php echo e($row->statusTone); ?>"><?php echo e($row->statusLabel); ?></span></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('mobile', null, []); ?> 
        <div class="people-mobile-cards">
            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php ($row = $directoryRows->get($employee->id)); ?>
                <article class="people-employee-card">
                    <div class="people-card-head">
                        <div class="people-identity">
                            <?php if (isset($component)) { $__componentOriginal2252ef3298868bc9de4c534a2a83a2a2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2252ef3298868bc9de4c534a2a83a2a2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.user-avatar','data' => ['user' => $employee->user,'label' => $row->name,'class' => 'people-avatar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.user-avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($employee->user),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($row->name),'class' => 'people-avatar']); ?>
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
                            <div><strong><?php echo e($row->name); ?></strong><span class="people-subtext"><?php echo e($row->employeeCode); ?> - <?php echo e($row->designation); ?></span></div>
                        </div>
                        <span class="people-status is-<?php echo e($row->statusTone); ?>"><?php echo e($row->statusLabel); ?></span>
                    </div>
                    <dl class="people-card-facts">
                        <div><dt>Department</dt><dd><?php echo e($row->department); ?></dd></div>
                        <div><dt>Company / site</dt><dd><?php echo e($row->company); ?><span class="people-subtext"><?php echo e($row->branch); ?></span></dd></div>
                        <div><dt>Grade</dt><dd><?php echo e($row->grade ?? 'Not recorded'); ?></dd></div>
                        <div><dt>Attendance</dt><dd><?php echo e($row->attendanceLabel); ?></dd></div>
                        <div><dt>Manager</dt><dd><?php echo e($row->manager); ?></dd></div>
                        <div><dt>Net salary</dt><dd><?php if(! $abilities['canViewCompensation']): ?> Restricted <?php elseif($row->latestApprovedNetSalary !== null): ?> INR <?php echo e(number_format($row->latestApprovedNetSalary, 2)); ?> <?php else: ?> No approved payroll <?php endif; ?></dd></div>
                    </dl>
                    <div class="people-card-action"><a class="people-button" href="<?php echo e(route('hr.employees.show', $employee)); ?>" aria-label="Open employee profile for <?php echo e($row->name); ?>">View Employee 360</a></div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
     <?php $__env->endSlot(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal17e1d856121687ce90b748b5990193ab)): ?>
<?php $attributes = $__attributesOriginal17e1d856121687ce90b748b5990193ab; ?>
<?php unset($__attributesOriginal17e1d856121687ce90b748b5990193ab); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal17e1d856121687ce90b748b5990193ab)): ?>
<?php $component = $__componentOriginal17e1d856121687ce90b748b5990193ab; ?>
<?php unset($__componentOriginal17e1d856121687ce90b748b5990193ab); ?>
<?php endif; ?>
<?php /**PATH /home/developer/public_html/builder360/resources/views/hr/employees/partials/directory-register.blade.php ENDPATH**/ ?>