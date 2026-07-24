<?php ($activeLifecycleSection = $activeLifecycleSection ?? 'tracker'); ?>
<nav class="people-ops-tabs" aria-label="Employee Lifecycle sections">
    <a href="<?php echo e(route('hr.lifecycle.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeLifecycleSection === 'tracker']); ?>" <?php if($activeLifecycleSection === 'tracker'): ?> aria-current="page" <?php endif; ?>>
        <i class="fa-solid fa-route" aria-hidden="true"></i> Lifecycle tracker
    </a>
    <a href="<?php echo e(route('hr.confirmation-cases.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeLifecycleSection === 'confirmation']); ?>" <?php if($activeLifecycleSection === 'confirmation'): ?> aria-current="page" <?php endif; ?>>
        <i class="fa-solid fa-user-check" aria-hidden="true"></i> Confirmation
    </a>
    <a href="<?php echo e(route('hr.separation-settlements.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeLifecycleSection === 'separation']); ?>" <?php if($activeLifecycleSection === 'separation'): ?> aria-current="page" <?php endif; ?>>
        <i class="fa-solid fa-file-invoice-dollar" aria-hidden="true"></i> Full &amp; Final
    </a>
    <a href="<?php echo e(route('hr.exit-interviews.index')); ?>" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeLifecycleSection === 'exit']); ?>" <?php if($activeLifecycleSection === 'exit'): ?> aria-current="page" <?php endif; ?>>
        <i class="fa-regular fa-comments" aria-hidden="true"></i> Exit interviews
    </a>
</nav>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/hr/lifecycle/partials/navigation.blade.php ENDPATH**/ ?>