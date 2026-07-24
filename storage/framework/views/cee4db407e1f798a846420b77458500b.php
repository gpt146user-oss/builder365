<?php $__env->startSection('title', 'Employee Profile Details - Builder360 ERP-CRM'); ?>
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Employee Profile Details','description' => $employee->employee_code.' - '.$employee->name.' - '.$employee->designation,'eyebrow' => 'People / Employee 360','active' => 'employees'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> <a class="people-button" href="<?php echo e(route('hr.employees.index')); ?>"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Employee directory</a> <?php $__env->endSlot(); ?>
    <?php if(session('status')): ?><section class="blade-alert blade-alert-success" role="status"><?php echo e(session('status')); ?></section><?php endif; ?>
    <?php if($errors->any()): ?><section class="blade-alert blade-alert-danger" role="alert" tabindex="-1"><strong>Please correct the highlighted profile fields.</strong><ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></section><?php endif; ?>
    <?php if (isset($component)) { $__componentOriginald7d6991c6f8cbf6e7a6895c044edeaa1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald7d6991c6f8cbf6e7a6895c044edeaa1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.employee-profile-navigation','data' => ['links' => $profileNavigation,'active' => 'work-profile']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.employee-profile-navigation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['links' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($profileNavigation),'active' => 'work-profile']); ?>
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
    <section class="blade-card"><div class="blade-card-header"><div><p class="blade-eyebrow">Personal and employment context</p><h2>Profile sections</h2></div></div>
    <?php if($abilities['canUpdate']): ?><form method="POST" action="<?php echo e(route('hr.employees.profile-sections.update',$employee)); ?>" class="blade-form-grid" x-data="{ emergency: <?php echo e(data_get($sections,'emergency.0.name') ? 'true' : 'false'); ?>, family: <?php echo e(data_get($sections,'family.0.name') ? 'true' : 'false'); ?>, education: <?php echo e(data_get($sections,'education.0.qualification') ? 'true' : 'false'); ?>, experience: <?php echo e(data_get($sections,'experience.0.company') ? 'true' : 'false'); ?> }"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
        <label>Date of birth<input type="date" name="sections[personal][dob]" value="<?php echo e(old('sections.personal.dob',data_get($sections,'personal.dob'))); ?>" max="<?php echo e(now()->subDay()->toDateString()); ?>"></label><label>Gender<input name="sections[personal][gender]" value="<?php echo e(old('sections.personal.gender',data_get($sections,'personal.gender'))); ?>" maxlength="40"></label><label>Marital status<input name="sections[personal][marital]" value="<?php echo e(old('sections.personal.marital',data_get($sections,'personal.marital'))); ?>" maxlength="40"></label><label>Blood group<input name="sections[personal][blood]" value="<?php echo e(old('sections.personal.blood',data_get($sections,'personal.blood'))); ?>" maxlength="10"></label><label>Mobile<input name="sections[personal][mobile]" value="<?php echo e(old('sections.personal.mobile',data_get($sections,'personal.mobile'))); ?>" maxlength="30"></label><label>Personal email<input type="email" name="sections[personal][email]" value="<?php echo e(old('sections.personal.email',data_get($sections,'personal.email'))); ?>"></label>
        <label class="blade-form-wide"><input type="checkbox" x-model="emergency"> Add emergency contact</label><label x-show="emergency">Emergency contact name<input name="sections[emergency][0][name]" :disabled="!emergency" value="<?php echo e(old('sections.emergency.0.name',data_get($sections,'emergency.0.name'))); ?>" maxlength="120"></label><label x-show="emergency">Emergency relation<input name="sections[emergency][0][relation]" :disabled="!emergency" value="<?php echo e(old('sections.emergency.0.relation',data_get($sections,'emergency.0.relation'))); ?>" maxlength="80"></label><label x-show="emergency">Emergency phone<input name="sections[emergency][0][phone]" :disabled="!emergency" value="<?php echo e(old('sections.emergency.0.phone',data_get($sections,'emergency.0.phone'))); ?>" maxlength="30"></label>
        <label class="blade-form-wide"><input type="checkbox" x-model="family"> Add family member</label><label x-show="family">Family member<input name="sections[family][0][name]" :disabled="!family" value="<?php echo e(old('sections.family.0.name',data_get($sections,'family.0.name'))); ?>" maxlength="120"></label><label x-show="family">Family relation<input name="sections[family][0][relation]" :disabled="!family" value="<?php echo e(old('sections.family.0.relation',data_get($sections,'family.0.relation'))); ?>" maxlength="80"></label><label x-show="family">Dependent<select name="sections[family][0][dependent]" :disabled="!family"><option value="0">No</option><option value="1" <?php if((bool)old('sections.family.0.dependent',data_get($sections,'family.0.dependent'))): echo 'selected'; endif; ?>>Yes</option></select></label>
        <label class="blade-form-wide"><input type="checkbox" x-model="education"> Add education record</label><label x-show="education">Qualification<input name="sections[education][0][qualification]" :disabled="!education" value="<?php echo e(old('sections.education.0.qualification',data_get($sections,'education.0.qualification'))); ?>" maxlength="160"></label><label x-show="education">Institute<input name="sections[education][0][institute]" :disabled="!education" value="<?php echo e(old('sections.education.0.institute',data_get($sections,'education.0.institute'))); ?>" maxlength="180"></label><label x-show="education">Completion year<input type="number" min="1950" max="<?php echo e(now()->year+1); ?>" name="sections[education][0][year]" :disabled="!education" value="<?php echo e(old('sections.education.0.year',data_get($sections,'education.0.year'))); ?>"></label>
        <label class="blade-form-wide"><input type="checkbox" x-model="experience"> Add prior experience</label><label x-show="experience">Previous company<input name="sections[experience][0][company]" :disabled="!experience" value="<?php echo e(old('sections.experience.0.company',data_get($sections,'experience.0.company'))); ?>" maxlength="180"></label><label x-show="experience">Previous role<input name="sections[experience][0][role]" :disabled="!experience" value="<?php echo e(old('sections.experience.0.role',data_get($sections,'experience.0.role'))); ?>" maxlength="160"></label><label x-show="experience">Experience from<input type="date" name="sections[experience][0][from]" :disabled="!experience" value="<?php echo e(old('sections.experience.0.from',data_get($sections,'experience.0.from'))); ?>"></label><label x-show="experience">Experience to<input type="date" name="sections[experience][0][to]" :disabled="!experience" value="<?php echo e(old('sections.experience.0.to',data_get($sections,'experience.0.to'))); ?>"></label>
        <button class="blade-primary-action">Save profile details</button>
    </form><?php else: ?><p class="blade-workspace-note">These profile details are available in read-only mode for your current access.</p><dl class="blade-profile-list"><?php $__currentLoopData = ($sections['personal']??[]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div><dt><?php echo e(str_replace('_',' ',ucfirst($label))); ?></dt><dd><?php echo e(is_scalar($value)?$value:'Recorded'); ?></dd></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></dl><?php endif; ?>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/developer/public_html/builder360/resources/views/hr/employees/profile-sections.blade.php ENDPATH**/ ?>