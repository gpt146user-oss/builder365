<?php $__env->startSection('title', 'Employee Master - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Employee Master','description' => 'Manage employee identity, work placement, reporting relationships, and authorized records.','active' => 'employees','openCreate' => $errors->any()] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if($abilities['canExport']): ?>
            <a class="people-button" href="<?php echo e(route('hr.employees.export', array_filter(request()->only(['company_id', 'branch_id', 'project_id', 'department', 'designation', 'status', 'search'])) + ['format' => 'csv'])); ?>">
                <i class="fa-solid fa-download" aria-hidden="true"></i> Export register
            </a>
        <?php endif; ?>
        <?php if($abilities['canCreate']): ?>
            <a href="#create-employee" class="people-button is-primary" x-on:click.prevent="openCreateEmployee">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> Add employee
            </a>
        <?php endif; ?>
     <?php $__env->endSlot(); ?>

    <?php if(session('status')): ?>
        <section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <section class="people-alert is-danger" role="alert" tabindex="-1" aria-labelledby="employee-errors-title">
            <strong id="employee-errors-title">Please correct the highlighted employee fields.</strong>
            <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </section>
    <?php endif; ?>

    <section class="people-directory" aria-labelledby="employee-register-title">
        <header class="people-directory-head">
            <div><h2 id="employee-register-title">Employee Directory</h2><p>Employees available within your company and role scope.</p></div>
            <span class="people-count"><?php echo e(number_format($employees->total())); ?> <?php echo e(str('employee')->plural($employees->total())); ?></span>
        </header>

        <form method="GET" action="<?php echo e(route('hr.employees.index')); ?>" class="people-filter-form" aria-label="Filter employee directory">
            <label class="people-control-wrap">
                <span class="sr-only">Search employees</span><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                <input class="people-control" type="search" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search name, code, email, role or department">
            </label>
            <label><span class="sr-only">Department</span><select class="people-control" name="department"><option value="">All departments</option><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($department); ?>" <?php if(request('department') === $department): echo 'selected'; endif; ?>><?php echo e($department); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label><span class="sr-only">Designation</span><select class="people-control" name="designation"><option value="">All designations</option><?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($designation); ?>" <?php if(request('designation') === $designation): echo 'selected'; endif; ?>><?php echo e($designation); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label><span class="sr-only">Branch</span><select class="people-control" name="branch_id"><option value="">All branches</option><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($branch->id); ?>" <?php if((string) request('branch_id') === (string) $branch->id): echo 'selected'; endif; ?>><?php echo e($branch->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label><span class="sr-only">Project</span><select class="people-control" name="project_id"><option value="">All projects</option><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($project->id); ?>" <?php if((string) request('project_id') === (string) $project->id): echo 'selected'; endif; ?>><?php echo e($project->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label><span class="sr-only">Status</span><select class="people-control" name="status"><option value="">All statuses</option><?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(request('status') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <button type="submit" class="people-button"><i class="fa-solid fa-filter" aria-hidden="true"></i> Apply</button>
        </form>

        <?php if($activeFilters !== []): ?>
            <nav class="people-filter-chips" aria-label="Active employee filters">
                <span>Active filters</span>
                <?php $__currentLoopData = $activeFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a class="people-filter-chip" href="<?php echo e(route('hr.employees.index', request()->except([$filter->key, 'page']))); ?>" aria-label="Remove <?php echo e($filter->label); ?> filter">
                        <?php echo e($filter->label); ?>: <?php echo e($filter->value); ?> <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <a class="people-filter-chip" href="<?php echo e(route('hr.employees.index')); ?>">Clear all</a>
            </nav>
        <?php endif; ?>

        <?php if($employees->isEmpty()): ?>
            <?php if (isset($component)) { $__componentOriginal3abc64969eeeba849011f1a920d3a3ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.people-state','data' => ['type' => $activeFilters !== [] ? 'filtered' : 'empty','icon' => $activeFilters !== [] ? null : 'fa-user-group','title' => $activeFilters !== [] ? 'No employees match these filters' : 'No employees are available','message' => $activeFilters !== [] ? 'Clear or adjust the directory filters to broaden the results.' : 'Employee records will appear here when they are created within your company scope.','actionUrl' => $activeFilters !== [] ? route('hr.employees.index') : null,'actionLabel' => $activeFilters !== [] ? 'Clear filters' : null,'ariaLabel' => 'No employees found']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeFilters !== [] ? 'filtered' : 'empty'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeFilters !== [] ? null : 'fa-user-group'),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeFilters !== [] ? 'No employees match these filters' : 'No employees are available'),'message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeFilters !== [] ? 'Clear or adjust the directory filters to broaden the results.' : 'Employee records will appear here when they are created within your company scope.'),'action-url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeFilters !== [] ? route('hr.employees.index') : null),'action-label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeFilters !== [] ? 'Clear filters' : null),'aria-label' => 'No employees found']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $attributes = $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $component = $__componentOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?>
        <?php else: ?>
            <?php echo $__env->make('hr.employees.partials.directory-register', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>

        <footer class="people-pagination">
            <span>Showing <?php echo e(number_format($employees->firstItem() ?? 0)); ?>-<?php echo e(number_format($employees->lastItem() ?? 0)); ?> of <?php echo e(number_format($employees->total())); ?></span>
            <?php echo e($employees->withQueryString()->links()); ?>

        </footer>
    </section>

    <?php if($abilities['canCreate']): ?>
        <?php echo $__env->make('hr.employees.partials.create-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\hr\employees\index.blade.php ENDPATH**/ ?>