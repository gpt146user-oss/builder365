<div
    <?php echo e($attributes->class(['people-workspace', 'is-self-service' => $selfService])); ?>

    role="region"
    aria-label="People workspace"
    x-data="peopleWorkspace"
    data-create-open="<?php echo e($openCreate ? '1' : '0'); ?>"
    x-on:keydown.escape.window="handlePeopleEscape"
    x-on:resize.window="handlePeopleResize"
>
    <?php if (! ($selfService)): ?>
        <button
            type="button"
            class="people-rail-toggle"
            x-ref="railTrigger"
            x-on:click="togglePeopleRail"
            x-bind:aria-expanded="railExpanded"
            aria-controls="people-workspace-rail"
        >
            <i class="fa-solid fa-users" aria-hidden="true"></i>
            <span>People workspace</span>
        </button>

        <button
            type="button"
            class="people-rail-backdrop"
            x-show="railOpen"
            x-cloak
            x-on:click="closePeopleRail"
            aria-label="Close People workspace navigation"
        ></button>

        <?php echo $__env->make('hr.partials.people-workspace-rail', [
            'activePeopleSection' => $active,
            'peopleLinks' => $navigationLinks,
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    <main class="people-main" id="people-main-content">
        <header class="people-page-header">
            <div class="people-page-heading">
                <p class="people-eyebrow"><?php echo e($eyebrow); ?></p>
                <h1><?php echo e($title); ?></h1>
                <?php if($description): ?><p><?php echo e($description); ?></p><?php endif; ?>
            </div>

            <?php if(isset($actions)): ?>
                <div class="people-page-actions" aria-label="Page actions"><?php echo e($actions); ?></div>
            <?php endif; ?>
        </header>

        <?php echo e($slot); ?>

    </main>
</div>
<?php /**PATH /home/developer/public_html/builder360/resources/views/components/hr/people-workspace.blade.php ENDPATH**/ ?>