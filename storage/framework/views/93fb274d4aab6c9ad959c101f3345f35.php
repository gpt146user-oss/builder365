<section class="people-ops-stack" data-recruitment-surface="openings">
    <?php if($abilities['canCreateOpening']): ?>
        <details id="recruitment-create" class="people-ops-panel" <?php if($errors->any()): ?> open <?php endif; ?>>
            <summary class="people-ops-panel-head">
                <div><h2>Create job opening</h2><p>Submit a company-scoped requisition for independent approval.</p></div>
                <span class="people-button"><i class="fa-solid fa-plus" aria-hidden="true"></i> Requisition</span>
            </summary>
            <form method="POST" action="<?php echo e(route('recruitment.job-openings.store')); ?>" class="people-form-grid people-ops-panel-body">
                <?php echo csrf_field(); ?>
                <?php if (isset($component)) { $__componentOriginal5ee006ce6757c21855df609df2a8580f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5ee006ce6757c21855df609df2a8580f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.company-context','data' => ['companies' => $companies,'selected' => old('company_id', $companies->first()?->id),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.company-context'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['companies' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($companies),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('company_id', $companies->first()?->id)),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5ee006ce6757c21855df609df2a8580f)): ?>
<?php $attributes = $__attributesOriginal5ee006ce6757c21855df609df2a8580f; ?>
<?php unset($__attributesOriginal5ee006ce6757c21855df609df2a8580f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5ee006ce6757c21855df609df2a8580f)): ?>
<?php $component = $__componentOriginal5ee006ce6757c21855df609df2a8580f; ?>
<?php unset($__componentOriginal5ee006ce6757c21855df609df2a8580f); ?>
<?php endif; ?>
                <label class="people-field">Branch<select name="branch_id"><option value="">No branch</option><?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($branch->id); ?>" <?php if((string) old('branch_id') === (string) $branch->id): echo 'selected'; endif; ?>><?php echo e($branch->code); ?> · <?php echo e($branch->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field">Project<select name="project_id"><option value="">No project</option><?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($project->id); ?>" <?php if((string) old('project_id') === (string) $project->id): echo 'selected'; endif; ?>><?php echo e($project->code); ?> · <?php echo e($project->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field">Title<input name="title" value="<?php echo e(old('title')); ?>" maxlength="255" required></label>
                <label class="people-field">Department<input name="department" value="<?php echo e(old('department')); ?>" maxlength="120" required></label>
                <label class="people-field">Designation<input name="designation" value="<?php echo e(old('designation')); ?>" maxlength="120" required></label>
                <label class="people-field">Positions<input type="number" name="positions" value="<?php echo e(old('positions', 1)); ?>" min="1" max="200" required></label>
                <label class="people-field">Employment type<select name="employment_type" required><?php $__currentLoopData = $employmentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(old('employment_type', 'full_time') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field">Work location<input name="work_location" value="<?php echo e(old('work_location')); ?>" maxlength="255"></label>
                <label class="people-field">Minimum CTC<input type="number" name="budget_min_ctc" value="<?php echo e(old('budget_min_ctc')); ?>" min="0" step="0.01"></label>
                <label class="people-field">Maximum CTC<input type="number" name="budget_max_ctc" value="<?php echo e(old('budget_max_ctc')); ?>" min="0" step="0.01"></label>
                <label class="people-field">Target hiring date<input type="date" name="target_hiring_date" value="<?php echo e(old('target_hiring_date')); ?>" min="<?php echo e(now()->toDateString()); ?>"></label>
                <label class="people-field">Required skill<input name="required_skills[]" value="<?php echo e(old('required_skills.0')); ?>" maxlength="120"></label>
                <label class="people-field is-wide">Business justification<textarea name="business_justification" maxlength="2000"><?php echo e(old('business_justification')); ?></textarea></label>
                <div class="people-field is-wide"><button class="people-button is-primary" type="submit">Submit requisition</button></div>
            </form>
        </details>
    <?php endif; ?>

    <form method="GET" action="<?php echo e(route('recruitment.job-openings.index')); ?>" class="people-ops-filterbar">
        <label class="people-field">Status<select name="status"><option value="">All statuses</option><?php $__currentLoopData = $openingStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
        <label class="people-field">Department<select name="department"><option value="">All departments</option><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($department); ?>" <?php if(($filters['department'] ?? '') === $department): echo 'selected'; endif; ?>><?php echo e($department); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
        <label class="people-field">Rows<select name="per_page"><?php $__currentLoopData = [15,25,50,100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($size); ?>" <?php if((int)($filters['per_page'] ?? 15) === $size): echo 'selected'; endif; ?>><?php echo e($size); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
        <button class="people-button" type="submit"><i class="fa-solid fa-filter" aria-hidden="true"></i> Apply</button>
        <?php if(array_filter($filters)): ?><a class="people-button" href="<?php echo e(route('recruitment.job-openings.index')); ?>">Clear</a><?php endif; ?>
    </form>

    <article class="people-ops-panel has-mobile-cards">
        <header class="people-ops-panel-head"><div><h2>Job openings</h2><p>Approved and pending requisitions in your authorized scope.</p></div><small><?php echo e($openings->firstItem() ?? 0); ?>–<?php echo e($openings->lastItem() ?? 0); ?> of <?php echo e($openings->total()); ?></small></header>
        <div class="people-ops-table-wrap"><table class="people-ops-table"><caption>Recruitment job openings</caption><thead><tr><th scope="col">Opening</th><th scope="col">Department</th><th scope="col">Positions</th><th scope="col">Target</th><th scope="col">Status</th><th scope="col">Owner</th><th scope="col">Actions</th></tr></thead><tbody>
        <?php $__empty_1 = true; $__currentLoopData = $openings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opening): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr><td><strong><?php echo e($opening->code); ?></strong><small><?php echo e($opening->title); ?> · <?php echo e($opening->designation); ?></small><?php if($opening->budgetRange): ?><small><?php echo e($opening->budgetRange); ?></small><?php endif; ?></td><td><?php echo e($opening->department); ?><small><?php echo e($opening->employmentType); ?> · <?php echo e($opening->location); ?></small></td><td><?php echo e($opening->positions); ?></td><td><?php echo e($opening->targetDate); ?></td><td><span class="people-status <?php echo e($opening->statusTone); ?>"><?php echo e($opening->statusLabel); ?></span></td><td><?php echo e($opening->createdBy); ?><small><?php echo e($opening->reviewedBy); ?></small></td><td class="is-actions">
                <?php if($opening->canApprove || $opening->canReject): ?><div class="people-ops-list-actions">
                    <?php if($opening->canApprove): ?><form method="POST" action="<?php echo e(route('recruitment.job-openings.approve', $opening->id)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><button class="people-ops-action-link" type="submit">Approve</button></form><?php endif; ?>
                    <?php if($opening->canReject): ?><form method="POST" action="<?php echo e(route('recruitment.job-openings.reject', $opening->id)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><input type="hidden" name="review_note" value="Rejected from requisition register"><button class="people-ops-action-link is-danger" type="submit">Reject</button></form><?php endif; ?>
                </div><?php else: ?><span class="people-status is-muted"><?php echo e($opening->status === 'pending_approval' ? 'Review unavailable' : 'No action'); ?></span><?php endif; ?>
            </td></tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="7"><div class="people-ops-empty"><i class="fa-solid fa-briefcase" aria-hidden="true"></i><strong>No job openings found</strong><span>Change the filters or create an authorized requisition.</span></div></td></tr><?php endif; ?>
        </tbody></table></div>
        <div class="people-ops-mobile-list">
            <?php $__empty_1 = true; $__currentLoopData = $openings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opening): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="people-ops-mobile-card">
                    <header class="people-ops-mobile-card-head"><div class="people-ops-identity"><span class="people-avatar"><?php echo e(mb_substr($opening->code, -2)); ?></span><div><strong><?php echo e($opening->title); ?></strong><small><?php echo e($opening->code); ?> · <?php echo e($opening->department); ?></small></div></div><span class="people-status <?php echo e($opening->statusTone); ?>"><?php echo e($opening->statusLabel); ?></span></header>
                    <dl class="people-ops-mobile-facts"><div><dt>Designation</dt><dd><?php echo e($opening->designation); ?></dd></div><div><dt>Positions</dt><dd><?php echo e($opening->positions); ?></dd></div><div><dt>Target</dt><dd><?php echo e($opening->targetDate); ?></dd></div><div><dt>Owner</dt><dd><?php echo e($opening->createdBy); ?></dd></div></dl>
                    <?php if($opening->canApprove || $opening->canReject): ?>
                        <div class="people-ops-mobile-actions">
                            <?php if($opening->canApprove): ?><form method="POST" action="<?php echo e(route('recruitment.job-openings.approve', $opening->id)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><button class="people-button is-primary" type="submit">Approve</button></form><?php endif; ?>
                            <?php if($opening->canReject): ?><form method="POST" action="<?php echo e(route('recruitment.job-openings.reject', $opening->id)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?><input type="hidden" name="review_note" value="Rejected from requisition register"><button class="people-button is-danger" type="submit">Reject</button></form><?php endif; ?>
                        </div>
                    <?php elseif($opening->status === 'pending_approval'): ?>
                        <p class="people-subtext">Review unavailable for your role.</p>
                    <?php endif; ?>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="people-ops-empty"><strong>No job openings found</strong><span>Change the filters or create an authorized requisition.</span></div>
            <?php endif; ?>
        </div>
        <div class="people-pagination"><?php echo e($openings->links()); ?></div>
    </article>
</section>
<?php /**PATH /home/developer/public_html/builder360/resources/views/recruitment/workspace/partials/openings.blade.php ENDPATH**/ ?>