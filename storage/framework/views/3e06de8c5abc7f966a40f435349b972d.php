<aside
    id="people-workspace-rail"
    class="people-rail"
    x-ref="peopleRail"
    x-bind:class="peopleRailClasses"
    tabindex="-1"
    aria-label="People workspace navigation"
>
    
    <div class="people-rail-head">
        <span class="people-rail-icon" aria-hidden="true"><i class="fa-solid fa-users"></i></span>
        <div><strong>People Workspace</strong><small>Company HR operations</small></div>
        <button type="button" x-on:click="closePeopleRail" aria-label="Close People workspace navigation"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
    </div>

    <nav class="people-rail-nav">
        <p>People operations</p>
        <?php $__currentLoopData = $peopleLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a
                href="<?php echo e(route($link->route)); ?>"
                class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activePeopleSection === $link->key]); ?>"
                <?php if($activePeopleSection === $link->key): ?> aria-current="page" <?php endif; ?>
            >
                <i class="fa-solid <?php echo e($link->icon); ?>" aria-hidden="true"></i>
                <span><?php echo e($link->label); ?></span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>

    <div class="people-rail-foot">
        <i class="fa-solid fa-building-shield" aria-hidden="true"></i>
        <div><strong>One company</strong><small>Access is role and company scoped</small></div>
    </div>
</aside>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/hr/partials/people-workspace-rail.blade.php ENDPATH**/ ?>