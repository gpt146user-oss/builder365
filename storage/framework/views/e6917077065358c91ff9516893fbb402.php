<section class="people-ops-stack" data-recruitment-surface="pipeline">
    <form method="GET" action="<?php echo e(route('recruitment.pipeline.index')); ?>" class="people-ops-filterbar">
        <label class="people-field">Search<input type="search" name="search" value="<?php echo e($filters['search'] ?? ''); ?>" maxlength="120" placeholder="Name, email, phone, or candidate code"></label>
        <label class="people-field">Source<select name="source"><option value="">All sources</option><?php $__currentLoopData = $sources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($source); ?>" <?php if(($filters['source'] ?? '') === $source): echo 'selected'; endif; ?>><?php echo e($source); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
        <label class="people-field">Cards per stage<select name="per_page"><?php $__currentLoopData = [15, 25, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($size); ?>" <?php if((int)($filters['per_page'] ?? 15) === $size): echo 'selected'; endif; ?>><?php echo e($size); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
        <button class="people-button" type="submit"><i class="fa-solid fa-filter" aria-hidden="true"></i> Apply</button>
        <?php if(array_filter($filters)): ?><a class="people-button" href="<?php echo e(route('recruitment.pipeline.index')); ?>">Clear</a><?php endif; ?>
    </form>

    <article class="people-ops-panel">
        <header class="people-ops-panel-head">
            <div><h2>Candidate pipeline</h2><p>Authorized candidates are grouped by their persisted workflow stage. Stage changes use the same server policy as the candidate register.</p></div>
            <small><?php echo e(number_format(collect($pipelineColumns)->sum(fn ($column): int => $column->total))); ?> matching candidates</small>
        </header>

        <div class="people-pipeline-viewport" tabindex="0" aria-label="Candidate pipeline columns">
            <div class="people-pipeline-track">
                <?php $__currentLoopData = $pipelineColumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <section class="people-pipeline-column" aria-labelledby="pipeline-stage-<?php echo e($column->stage); ?>">
                        <header class="people-pipeline-column-head">
                            <span class="people-pipeline-stage-dot <?php echo e($column->tone); ?>" aria-hidden="true"></span>
                            <h3 id="pipeline-stage-<?php echo e($column->stage); ?>"><?php echo e($column->label); ?></h3>
                            <span class="people-pipeline-count" aria-label="<?php echo e($column->total); ?> candidates"><?php echo e($column->total); ?></span>
                        </header>
                        <div class="people-pipeline-column-body">
                            <?php $__empty_1 = true; $__currentLoopData = $column->candidates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $candidate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <article class="people-pipeline-card">
                                    <header>
                                        <span class="people-avatar"><?php echo e($candidate->initials); ?></span>
                                        <div><h4><?php echo e($candidate->name); ?></h4><p><?php echo e($candidate->code); ?> · <?php echo e($candidate->source); ?></p></div>
                                    </header>
                                    <dl>
                                        <div><dt>Opening</dt><dd><?php echo e($candidate->openingTitle); ?></dd></div>
                                        <div><dt>Department</dt><dd><?php echo e($candidate->department); ?></dd></div>
                                        <div><dt>Owner</dt><dd><?php echo e($candidate->owner); ?></dd></div>
                                        <div><dt>Progress</dt><dd><?php echo e($candidate->interviewCount); ?> interviews · <?php echo e($candidate->offerStatus); ?></dd></div>
                                    </dl>
                                    <?php if($candidate->allowedStages): ?>
                                        <form method="POST" action="<?php echo e(route('recruitment.candidates.stage', $candidate->id)); ?>" class="people-pipeline-action">
                                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                            <input type="hidden" name="return_to" value="pipeline">
                                            <label class="people-field"><span class="sr-only">Move <?php echo e($candidate->name); ?> to</span><select name="stage" required><?php $__currentLoopData = $candidate->allowedStages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>"><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                                            <label class="people-field"><span class="sr-only">Transition note for <?php echo e($candidate->name); ?></span><input name="transition_note" maxlength="2000" placeholder="Transition note"></label>
                                            <button class="people-button is-primary" type="submit">Move candidate</button>
                                        </form>
                                    <?php elseif($candidate->canConvert): ?>
                                        <span class="people-status is-warning">Ready for conversion</span>
                                    <?php else: ?>
                                        <span class="people-status is-muted">Workflow controlled</span>
                                    <?php endif; ?>
                                </article>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="people-pipeline-empty"><span>No candidates match this stage and the active filters.</span></div>
                            <?php endif; ?>

                            <?php if($column->candidates->count() < $column->total): ?>
                                <a class="people-button people-pipeline-more" href="<?php echo e(route('recruitment.candidates.index', array_filter([
                                    'stage' => $column->stage,
                                    'source' => $filters['source'] ?? null,
                                    'search' => $filters['search'] ?? null,
                                    'per_page' => $column->limit,
                                ], fn ($value): bool => $value !== null && $value !== ''))); ?>">
                                    View all <?php echo e($column->total); ?>

                                </a>
                            <?php endif; ?>
                        </div>
                    </section>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </article>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/recruitment/workspace/partials/pipeline.blade.php ENDPATH**/ ?>