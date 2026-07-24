<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => $workspaceTitle,'description' => $workspaceDescription,'eyebrow' => 'Employee Operations Workspace','active' => $activeRegister] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if($activeRegister === 'assets' && $abilities['canCreateAsset']): ?>
            <a class="people-button is-primary" href="#asset-form"><i class="fa-solid fa-plus" aria-hidden="true"></i> Register asset</a>
        <?php elseif($activeRegister === 'claims' && $abilities['canCreateClaim']): ?>
            <a class="people-button is-primary" href="#claim-form"><i class="fa-solid fa-plus" aria-hidden="true"></i> Submit expense claim</a>
        <?php elseif($activeRegister === 'loans' && $abilities['canCreateLoan']): ?>
            <a class="people-button is-primary" href="#loan-form"><i class="fa-solid fa-plus" aria-hidden="true"></i> Request employee loan</a>
        <?php elseif($activeRegister === 'helpdesk' && $abilities['canCreateTicket']): ?>
            <a class="people-button is-primary" href="#helpdesk-form"><i class="fa-solid fa-plus" aria-hidden="true"></i> Raise HR ticket</a>
        <?php endif; ?>
     <?php $__env->endSlot(); ?>

    <?php if(session('status')): ?>
        <section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <section class="people-alert is-danger" role="alert" tabindex="-1">
            <strong>Please correct the highlighted employee operations fields.</strong>
            <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </section>
    <?php endif; ?>

    <nav class="people-ops-tabs" aria-label="Employee Operations sections">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewAny', \App\Models\EmployeeAsset::class)): ?>
            <a href="<?php echo e(route('hr.assets.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'assets']); ?>" <?php if($activeRegister === 'assets'): ?> aria-current="page" <?php endif; ?>><i class="fa-solid fa-laptop" aria-hidden="true"></i> Employee assets</a>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewAny', \App\Models\ExpenseClaim::class)): ?>
            <a href="<?php echo e(route('hr.expense-claims.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'claims']); ?>" <?php if($activeRegister === 'claims'): ?> aria-current="page" <?php endif; ?>><i class="fa-solid fa-receipt" aria-hidden="true"></i> Expense claims</a>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewAny', \App\Models\EmployeeLoan::class)): ?>
            <a href="<?php echo e(route('hr.loans.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'loans']); ?>" <?php if($activeRegister === 'loans'): ?> aria-current="page" <?php endif; ?>><i class="fa-solid fa-hand-holding-dollar" aria-hidden="true"></i> Employee loans</a>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewAny', \App\Models\HrHelpdeskTicket::class)): ?>
            <a href="<?php echo e(route('hr.helpdesk-tickets.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeRegister === 'helpdesk']); ?>" <?php if($activeRegister === 'helpdesk'): ?> aria-current="page" <?php endif; ?>><i class="fa-solid fa-headset" aria-hidden="true"></i> HR helpdesk tickets</a>
        <?php endif; ?>
    </nav>

    <?php if($activeRegister === 'assets' && $assetSummary): ?>
        <section class="people-ops-kpis" aria-label="Employee asset summary">
            <?php $__currentLoopData = [
                ['Total assets', $assetSummary->total, 'fa-laptop', ''],
                ['Available', $assetSummary->available, 'fa-box-open', 'is-success'],
                ['Assigned', $assetSummary->assigned, 'fa-user-check', 'is-info'],
                ['Recovered', $assetSummary->recovered, 'fa-rotate-left', 'is-success'],
                ['Lost', $assetSummary->lost, 'fa-triangle-exclamation', 'is-danger'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value, $icon, $tone]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="people-ops-kpi <?php echo e($tone); ?>"><span class="people-ops-kpi-icon"><i class="fa-solid <?php echo e($icon); ?>" aria-hidden="true"></i></span><span><?php echo e($label); ?></span><strong><?php echo e($value); ?></strong><small>Complete authorized register</small></article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </section>
    <?php elseif($activeRegister === 'claims' && $claimSummary): ?>
        <section class="people-ops-kpis" aria-label="Expense claim summary">
            <?php $__currentLoopData = [
                ['Total claims', $claimSummary->total, 'fa-receipt', ''],
                ['Submitted', $claimSummary->submitted, 'fa-hourglass-half', 'is-warning'],
                ['Approved', $claimSummary->approved, 'fa-circle-check', 'is-info'],
                ['Paid', $claimSummary->paid, 'fa-indian-rupee-sign', 'is-success'],
                ['Rejected', $claimSummary->rejected, 'fa-circle-xmark', 'is-danger'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value, $icon, $tone]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="people-ops-kpi <?php echo e($tone); ?>"><span class="people-ops-kpi-icon"><i class="fa-solid <?php echo e($icon); ?>" aria-hidden="true"></i></span><span><?php echo e($label); ?></span><strong><?php echo e($value); ?></strong><small>Complete authorized register</small></article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </section>
    <?php elseif($activeRegister === 'loans' && $loanSummary): ?>
        <section class="people-ops-kpis" aria-label="Employee loan summary">
            <?php $__currentLoopData = [
                ['Total loans', $loanSummary->total, 'fa-hand-holding-dollar', ''],
                ['Submitted', $loanSummary->submitted, 'fa-hourglass-half', 'is-warning'],
                ['Approved', $loanSummary->approved, 'fa-circle-check', 'is-info'],
                ['Disbursed', $loanSummary->disbursed, 'fa-money-bill-transfer', 'is-success'],
                ['Closed', $loanSummary->closed, 'fa-lock', ''],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value, $icon, $tone]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="people-ops-kpi <?php echo e($tone); ?>"><span class="people-ops-kpi-icon"><i class="fa-solid <?php echo e($icon); ?>" aria-hidden="true"></i></span><span><?php echo e($label); ?></span><strong><?php echo e($value); ?></strong><small>Complete authorized register</small></article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </section>
    <?php elseif($activeRegister === 'helpdesk' && $helpdeskSummary): ?>
        <section class="people-ops-kpis" aria-label="HR helpdesk summary">
            <?php $__currentLoopData = [
                ['Total tickets', $helpdeskSummary->total, 'fa-headset', ''],
                ['Open', $helpdeskSummary->open, 'fa-inbox', ''],
                ['Assigned', $helpdeskSummary->assigned, 'fa-user-check', 'is-warning'],
                ['Resolved', $helpdeskSummary->resolved, 'fa-circle-check', 'is-info'],
                ['Critical', $helpdeskSummary->critical, 'fa-triangle-exclamation', 'is-danger'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value, $icon, $tone]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="people-ops-kpi <?php echo e($tone); ?>"><span class="people-ops-kpi-icon"><i class="fa-solid <?php echo e($icon); ?>" aria-hidden="true"></i></span><span><?php echo e($label); ?></span><strong><?php echo e($value); ?></strong><small>Complete authorized register</small></article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </section>
    <?php endif; ?>

    <?php echo $__env->make('hr.operations.partials.'.$activeRegister, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/hr/operations/partials/people-workspace.blade.php ENDPATH**/ ?>