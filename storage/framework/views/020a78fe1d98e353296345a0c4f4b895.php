<?php
    $isOverdue    = $task->due_at && $task->due_at->isPast() && ! in_array($task->status, ['completed', 'cancelled'], true);
    $checklist    = collect($task->checklist ?? []);
    $doneChecklist = $checklist->filter(fn ($row) => (bool) ($row['done'] ?? false))->count();
?>


<article
    class="tm-card"
    data-task-id="<?php echo e($task->id); ?>"
    data-status="<?php echo e($task->status); ?>"
    data-lock-version="<?php echo e($task->lock_version ?? 0); ?>"
    data-allowed-targets='<?php echo json_encode(array_values($allowedTargets ?? []), 15, 512) ?>'
>
    <?php if(! empty($allowedTargets)): ?>
        <button
            type="button"
            class="tm-card-drag-handle"
            draggable="true"
            x-on:dragstart="beginDrag"
            x-on:dragend="endDrag"
            aria-label="Move <?php echo e($task->task_number); ?> to another permitted status"
            title="Drag to move task">
            <i class="fa-solid fa-grip-vertical" aria-hidden="true"></i>
        </button>
    <?php endif; ?>
    <a class="tm-card-link"
       href="<?php echo e(route('collaboration.tasks.index', $taskQuery(['task_id' => $task->id]))); ?>"
       aria-label="Open <?php echo e($task->task_number); ?> <?php echo e($task->title); ?>"
       draggable="false">

        <div class="tm-card-top">
            <span class="tm-card-id"><?php echo e($task->task_number); ?></span>
            <span class="tm-pri tm-pri-<?php echo e($task->priority); ?>">
                <span class="pdot"></span><?php echo e($priorities[$task->priority] ?? $task->priority); ?>

            </span>
        </div>

        <h3 class="tm-card-title"><?php echo e($task->title); ?></h3>

        <div class="tm-card-tags">
            <?php if($task->module_context): ?>
                <span class="tm-tag"><?php echo e(str_replace('_', ' ', $task->module_context)); ?></span>
            <?php endif; ?>
            <?php if($task->project): ?>
                <span class="tm-tag"><?php echo e($task->project->code); ?></span>
            <?php endif; ?>
        </div>

        <footer class="tm-card-foot">
            <span class="tm-card-meta <?php echo e($isOverdue ? 'due-over' : ''); ?>">
                <i class="fa-regular fa-calendar"></i>
                <?php echo e($task->due_at?->format('d M') ?? 'No due date'); ?>

            </span>
            <?php if($checklist->isNotEmpty()): ?>
                <span class="tm-subprog">
                    <span class="tm-miniring" style="--p:<?php echo e(round($doneChecklist / max(1, $checklist->count()) * 100)); ?>"></span>
                    <?php echo e($doneChecklist); ?>/<?php echo e($checklist->count()); ?>

                </span>
            <?php endif; ?>
            <span class="tm-card-owner" title="<?php echo e($task->assignedTo?->name ?? 'Unassigned'); ?>">
                <?php echo e(strtoupper(substr($task->assignedTo?->name ?? 'U', 0, 1))); ?>

            </span>
        </footer>
    </a>

    <?php if(! empty($allowedTargets)): ?>
        <form id="task-board-status-<?php echo e($task->id); ?>" class="tm-board-status-form" method="POST" action="<?php echo e(route('collaboration.tasks.status.update', $task)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <input type="hidden" name="status" value="">
            <input type="hidden" name="lock_version" value="<?php echo e($task->lock_version); ?>">
            <input type="hidden" name="note" value="Status changed from Board view.">
        </form>
    <?php endif; ?>
</article>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\collaboration\tasks\partials\task-card.blade.php ENDPATH**/ ?>