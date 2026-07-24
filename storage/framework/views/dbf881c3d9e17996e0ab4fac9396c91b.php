<section class="people-ops-stack" data-recruitment-surface="candidates">
    <?php if($abilities['canCreateCandidate']): ?>
        <details id="recruitment-create" class="people-ops-panel" <?php if($errors->any()): ?> open <?php endif; ?>><summary class="people-ops-panel-head"><div><h2>Create candidate</h2><p>Add a candidate only to an open company-scoped requisition.</p></div><span class="people-button"><i class="fa-solid fa-plus" aria-hidden="true"></i> Candidate</span></summary>
            <form method="POST" action="<?php echo e(route('recruitment.candidates.store')); ?>" class="people-form-grid people-ops-panel-body"><?php echo csrf_field(); ?>
                <label class="people-field">Open requisition<select name="job_opening_id" required><option value="">Select open job</option><?php $__currentLoopData = $openOpeningOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opening): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($opening->id); ?>" <?php if((string)old('job_opening_id') === (string)$opening->id): echo 'selected'; endif; ?>><?php echo e($opening->opening_code); ?> · <?php echo e($opening->title); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field">Candidate name<input name="name" value="<?php echo e(old('name')); ?>" maxlength="255" required></label>
                <label class="people-field">Email<input type="email" name="email" value="<?php echo e(old('email')); ?>" maxlength="255" required></label>
                <label class="people-field">Phone<input name="phone" value="<?php echo e(old('phone')); ?>" maxlength="30" required></label>
                <label class="people-field">Source<select name="source" required><?php $__currentLoopData = $sources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($source); ?>" <?php if(old('source', 'LinkedIn') === $source): echo 'selected'; endif; ?>><?php echo e($source); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field">Current company<input name="current_company" value="<?php echo e(old('current_company')); ?>" maxlength="255"></label>
                <label class="people-field">Experience years<input type="number" name="experience_years" value="<?php echo e(old('experience_years', 0)); ?>" min="0" max="60" step="0.01" required></label>
                <label class="people-field">Current CTC<input type="number" name="current_ctc" value="<?php echo e(old('current_ctc')); ?>" min="0" step="0.01"></label>
                <label class="people-field">Expected CTC<input type="number" name="expected_ctc" value="<?php echo e(old('expected_ctc')); ?>" min="0" step="0.01"></label>
                <label class="people-field">Notice period days<input type="number" name="notice_period_days" value="<?php echo e(old('notice_period_days')); ?>" min="0" max="365"></label>
                <label class="people-field">Skill<input name="skills[]" value="<?php echo e(old('skills.0')); ?>" maxlength="80"></label>
                <label class="people-field is-wide">Notes<textarea name="notes" maxlength="5000"><?php echo e(old('notes')); ?></textarea></label>
                <div class="people-field is-wide"><button class="people-button is-primary" type="submit">Create candidate</button></div>
            </form>
        </details>
    <?php endif; ?>

    <form method="GET" action="<?php echo e(route('recruitment.candidates.index')); ?>" class="people-ops-filterbar">
        <label class="people-field">Search<input type="search" name="search" value="<?php echo e($filters['search'] ?? ''); ?>" maxlength="120" placeholder="Name, email, phone, or code"></label>
        <label class="people-field">Stage<select name="stage"><option value="">All stages</option><?php $__currentLoopData = $candidateStages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(($filters['stage'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
        <label class="people-field">Source<select name="source"><option value="">All sources</option><?php $__currentLoopData = $sources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($source); ?>" <?php if(($filters['source'] ?? '') === $source): echo 'selected'; endif; ?>><?php echo e($source); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
        <button class="people-button" type="submit"><i class="fa-solid fa-filter" aria-hidden="true"></i> Apply</button><?php if(array_filter($filters)): ?><a class="people-button" href="<?php echo e(route('recruitment.candidates.index')); ?>">Clear</a><?php endif; ?>
    </form>

    <article class="people-ops-panel has-mobile-cards"><header class="people-ops-panel-head"><div><h2>Candidate pipeline</h2><p>Stage changes remain controlled by recruitment, interview, offer, and conversion workflows.</p></div><small><?php echo e($candidates->firstItem() ?? 0); ?>–<?php echo e($candidates->lastItem() ?? 0); ?> of <?php echo e($candidates->total()); ?></small></header>
        <div class="people-ops-table-wrap"><table class="people-ops-table"><caption>Recruitment candidates</caption><thead><tr><th scope="col">Candidate</th><th scope="col">Opening</th><th scope="col">Source</th><th scope="col">Experience</th><th scope="col">Stage</th><th scope="col">Owner</th><th scope="col">Actions</th></tr></thead><tbody>
        <?php $__empty_1 = true; $__currentLoopData = $candidates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $candidate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><div class="people-ops-identity"><span class="people-avatar"><?php echo e($candidate->initials); ?></span><div><strong><?php echo e($candidate->name); ?></strong><small><?php echo e($candidate->code); ?> · <?php echo e($candidate->email); ?></small></div></div></td><td><?php echo e($candidate->openingTitle); ?><small><?php echo e($candidate->openingCode); ?> · <?php echo e($candidate->department); ?></small></td><td><?php echo e($candidate->source); ?><small><?php echo e($candidate->currentCompany); ?></small></td><td><?php echo e($candidate->experience); ?><?php if($candidate->ctcSummary): ?><small><?php echo e($candidate->ctcSummary); ?></small><?php endif; ?></td><td><span class="people-status <?php echo e($candidate->stageTone); ?>"><?php echo e($candidate->stageLabel); ?></span><small><?php echo e($candidate->interviewCount); ?> interviews · <?php echo e($candidate->offerStatus); ?></small></td><td><?php echo e($candidate->owner); ?></td><td class="is-actions">
            <?php if($candidate->allowedStages): ?><form method="POST" action="<?php echo e(route('recruitment.candidates.stage', $candidate->id)); ?>" class="people-ops-list-actions"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><label class="people-field"><span class="sr-only">New stage for <?php echo e($candidate->name); ?></span><select name="stage" required><?php $__currentLoopData = $candidate->allowedStages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>"><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label><input name="transition_note" maxlength="2000" placeholder="Transition note"><button class="people-button" type="submit">Update</button></form><?php elseif($candidate->canConvert): ?><span class="people-status is-warning">Ready for conversion</span><?php else: ?><span class="people-status is-muted">Workflow controlled</span><?php endif; ?>
        </td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="7"><div class="people-ops-empty"><i class="fa-solid fa-user-group" aria-hidden="true"></i><strong>No candidates found</strong><span>Change the filters or add a candidate to an open requisition.</span></div></td></tr><?php endif; ?>
        </tbody></table></div>
        <div class="people-ops-mobile-list">
            <?php $__empty_1 = true; $__currentLoopData = $candidates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $candidate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="people-ops-mobile-card">
                    <header class="people-ops-mobile-card-head"><div class="people-ops-identity"><span class="people-avatar"><?php echo e($candidate->initials); ?></span><div><strong><?php echo e($candidate->name); ?></strong><small><?php echo e($candidate->code); ?> · <?php echo e($candidate->email); ?></small></div></div><span class="people-status <?php echo e($candidate->stageTone); ?>"><?php echo e($candidate->stageLabel); ?></span></header>
                    <dl class="people-ops-mobile-facts"><div><dt>Opening</dt><dd><?php echo e($candidate->openingTitle); ?></dd></div><div><dt>Source</dt><dd><?php echo e($candidate->source); ?></dd></div><div><dt>Experience</dt><dd><?php echo e($candidate->experience); ?></dd></div><div><dt>Owner</dt><dd><?php echo e($candidate->owner); ?></dd></div></dl>
                    <div class="people-ops-mobile-actions">
                        <?php if($candidate->allowedStages): ?>
                            <form method="POST" action="<?php echo e(route('recruitment.candidates.stage', $candidate->id)); ?>" class="people-ops-list-actions">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <label class="people-field"><span class="sr-only">New stage for <?php echo e($candidate->name); ?></span><select name="stage" required><?php $__currentLoopData = $candidate->allowedStages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>"><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                                <label class="people-field"><span class="sr-only">Transition note for <?php echo e($candidate->name); ?></span><input name="transition_note" maxlength="2000" placeholder="Transition note"></label>
                                <button class="people-button is-primary" type="submit">Update stage</button>
                            </form>
                        <?php elseif($candidate->canConvert): ?>
                            <span class="people-status is-warning">Ready for conversion</span>
                        <?php else: ?>
                            <span class="people-status is-muted">Workflow controlled</span>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="people-ops-empty"><strong>No candidates found</strong><span>Change the filters or add a candidate to an open requisition.</span></div>
            <?php endif; ?>
        </div>
        <div class="people-pagination"><?php echo e($candidates->links()); ?></div>
    </article>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\recruitment\workspace\partials\candidates.blade.php ENDPATH**/ ?>