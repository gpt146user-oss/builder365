<section class="logic-simulation-grid" aria-label="Available non-mutating simulations">
    <article class="logic-simulation-card logic-simulation-card-wide">
        <span class="logic-simulation-icon"><i class="fa-solid fa-user-check" aria-hidden="true"></i></span>
        <div>
            <h2>Performance score simulation</h2>
            <p>Enter normalized criterion scores from 0 to 100 and preview the selected governed formula version. Simulations remain separate from employee reviews and score evidence.</p>
        </div>

        <?php if(! $page->capabilities['managePerformance']): ?>
            <span class="logic-restricted-state">Your role cannot run performance simulations.</span>
        <?php elseif(count($page->performanceSimulationRules) === 0): ?>
            <span class="logic-restricted-state is-warning">No Employee Performance rule version is available in your authorized company scope.</span>
        <?php else: ?>
            <div class="logic-simulation-pack-list">
                <?php $__currentLoopData = $page->performanceSimulationRules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php ($performanceRuleOpen = (int) old('performance_simulation_rule_id') === $rule->id || (int) data_get($performanceSimulation ?? [], 'rule_id') === $rule->id); ?>
                    <details class="logic-simulation-pack" <?php if($performanceRuleOpen): ?> open <?php endif; ?>>
                        <summary>
                            <span>
                                <strong><?php echo e($rule->name); ?></strong>
                                <small>Version <?php echo e($rule->version); ?> &middot; <?php echo e($rule->status); ?></small>
                            </span>
                            <?php if (isset($component)) { $__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.badge','data' => ['tone' => 'neutral']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tone' => 'neutral']); ?><?php echo e(count($rule->criteria)); ?> criteria <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4)): ?>
<?php $attributes = $__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4; ?>
<?php unset($__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4)): ?>
<?php $component = $__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4; ?>
<?php unset($__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4); ?>
<?php endif; ?>
                        </summary>
                        <form method="POST" action="<?php echo e(route('scoring.performance-simulations.store', $rule->id)); ?>" class="logic-simulation-form">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="performance_simulation_rule_id" value="<?php echo e($rule->id); ?>">

                            <div class="logic-performance-criteria" aria-label="Normalized performance criterion scores">
                                <?php $__currentLoopData = $rule->criteria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $criterion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php ($criterionErrorKey = 'criterion_scores.'.$criterion['key']); ?>
                                    <?php ($criterionRequired = $criterion['required'] || $criterion['missing_data_behavior'] === 'block'); ?>
                                    <div class="logic-performance-criterion">
                                        <div class="logic-performance-criterion-meta">
                                            <label for="performance_criterion_<?php echo e($rule->id); ?>_<?php echo e($criterion['key']); ?>">
                                                <?php echo e($criterion['label']); ?>

                                                <?php if($criterionRequired): ?><span aria-hidden="true">*</span><?php endif; ?>
                                            </label>
                                            <small><?php echo e(number_format($criterion['weight'], 2)); ?>% weight</small>
                                        </div>
                                        <input
                                            class="b360-control <?php $__errorArgs = [$criterionErrorKey];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="performance_criterion_<?php echo e($rule->id); ?>_<?php echo e($criterion['key']); ?>"
                                            name="criterion_scores[<?php echo e($criterion['key']); ?>]"
                                            type="number"
                                            min="0"
                                            max="100"
                                            step="0.01"
                                            inputmode="decimal"
                                            value="<?php echo e(old($criterionErrorKey)); ?>"
                                            placeholder="0-100"
                                            <?php if($criterionRequired): ?> required <?php endif; ?>
                                            <?php $__errorArgs = [$criterionErrorKey];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> aria-invalid="true" aria-describedby="performance_criterion_error_<?php echo e($rule->id); ?>_<?php echo e($criterion['key']); ?>" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        >
                                        <?php $__errorArgs = [$criterionErrorKey];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="blade-field-error" id="performance_criterion_error_<?php echo e($rule->id); ?>_<?php echo e($criterion['key']); ?>" role="alert"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <?php $__errorArgs = ['criterion_scores'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="blade-field-error" role="alert"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <p class="logic-simulation-guard"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> This preview cannot create or update a performance review, scoring snapshot, final rating, PIP, promotion, bonus, or training decision.</p>
                            <div class="blade-form-actions">
                                <?php if (isset($component)) { $__componentOriginala84921e8a2bb1be3d0148785a93a50d8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala84921e8a2bb1be3d0148785a93a50d8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.action','data' => ['type' => 'submit','variant' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.action'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'primary']); ?>Run performance simulation <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala84921e8a2bb1be3d0148785a93a50d8)): ?>
<?php $attributes = $__attributesOriginala84921e8a2bb1be3d0148785a93a50d8; ?>
<?php unset($__attributesOriginala84921e8a2bb1be3d0148785a93a50d8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala84921e8a2bb1be3d0148785a93a50d8)): ?>
<?php $component = $__componentOriginala84921e8a2bb1be3d0148785a93a50d8; ?>
<?php unset($__componentOriginala84921e8a2bb1be3d0148785a93a50d8); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginala84921e8a2bb1be3d0148785a93a50d8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala84921e8a2bb1be3d0148785a93a50d8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.action','data' => ['href' => route('scoring.index', ['view' => 'performance'])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.action'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('scoring.index', ['view' => 'performance']))]); ?>Open performance rules <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala84921e8a2bb1be3d0148785a93a50d8)): ?>
<?php $attributes = $__attributesOriginala84921e8a2bb1be3d0148785a93a50d8; ?>
<?php unset($__attributesOriginala84921e8a2bb1be3d0148785a93a50d8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala84921e8a2bb1be3d0148785a93a50d8)): ?>
<?php $component = $__componentOriginala84921e8a2bb1be3d0148785a93a50d8; ?>
<?php unset($__componentOriginala84921e8a2bb1be3d0148785a93a50d8); ?>
<?php endif; ?>
                            </div>
                        </form>
                    </details>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </article>

    <article class="logic-simulation-card logic-simulation-card-wide">
        <span class="logic-simulation-icon"><i class="fa-solid fa-indian-rupee-sign" aria-hidden="true"></i></span>
        <div>
            <h2>Statutory payroll impact</h2>
            <p>Run deterministic what-if calculations against a governed draft or active pack. Every result is non-authoritative and never creates or changes payroll, attendance, or statutory records.</p>
        </div>

        <?php if(! $page->capabilities['simulateStatutory']): ?>
            <span class="logic-restricted-state">Your role cannot run statutory simulations.</span>
        <?php elseif(count($page->variablePacks) === 0): ?>
            <span class="logic-restricted-state is-warning">No governed statutory pack is available in your authorized company scope.</span>
        <?php else: ?>
            <div class="logic-simulation-pack-list">
                <?php $__currentLoopData = $page->variablePacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pack): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <details class="logic-simulation-pack" <?php if(old('simulation_setting_id') == $pack->id): ?> open <?php endif; ?>>
                        <summary>
                            <span><strong><?php echo e($pack->label); ?></strong><small><?php echo e($pack->settingKey); ?> · v<?php echo e($pack->version); ?> · <?php echo e($pack->status); ?></small></span>
                            <?php if (isset($component)) { $__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.badge','data' => ['tone' => $pack->verified ? 'success' : 'warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tone' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pack->verified ? 'success' : 'warning')]); ?><?php echo e($pack->verified ? 'Source verified' : 'Not payroll-authoritative'); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4)): ?>
<?php $attributes = $__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4; ?>
<?php unset($__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4)): ?>
<?php $component = $__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4; ?>
<?php unset($__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4); ?>
<?php endif; ?>
                        </summary>
                        <form method="POST" action="<?php echo e(route('hr.compliance-rule-settings.simulate', $pack->id)); ?>" class="logic-simulation-form">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="return_to" value="logic_center">
                            <input type="hidden" name="simulation_setting_id" value="<?php echo e($pack->id); ?>">

                            <?php if (isset($component)) { $__componentOriginal788c5626c9f4f85906027b3ea3343fab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal788c5626c9f4f85906027b3ea3343fab = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.field','data' => ['name' => 'simulation_state_'.e($pack->id).'','label' => 'Employee statutory state','hint' => 'Use the governed work-location state code, for example MH.','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'simulation_state_'.e($pack->id).'','label' => 'Employee statutory state','hint' => 'Use the governed work-location state code, for example MH.','required' => true]); ?>
                                <?php if (isset($component)) { $__componentOriginal4fb6044c7ed6b655352043ff774efcd0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4fb6044c7ed6b655352043ff774efcd0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input','data' => ['name' => 'statutory_state','id' => 'simulation_state_'.e($pack->id).'','value' => old('statutory_state'),'maxlength' => '8','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'statutory_state','id' => 'simulation_state_'.e($pack->id).'','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('statutory_state')),'maxlength' => '8','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4fb6044c7ed6b655352043ff774efcd0)): ?>
<?php $attributes = $__attributesOriginal4fb6044c7ed6b655352043ff774efcd0; ?>
<?php unset($__attributesOriginal4fb6044c7ed6b655352043ff774efcd0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4fb6044c7ed6b655352043ff774efcd0)): ?>
<?php $component = $__componentOriginal4fb6044c7ed6b655352043ff774efcd0; ?>
<?php unset($__componentOriginal4fb6044c7ed6b655352043ff774efcd0); ?>
<?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal788c5626c9f4f85906027b3ea3343fab)): ?>
<?php $attributes = $__attributesOriginal788c5626c9f4f85906027b3ea3343fab; ?>
<?php unset($__attributesOriginal788c5626c9f4f85906027b3ea3343fab); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal788c5626c9f4f85906027b3ea3343fab)): ?>
<?php $component = $__componentOriginal788c5626c9f4f85906027b3ea3343fab; ?>
<?php unset($__componentOriginal788c5626c9f4f85906027b3ea3343fab); ?>
<?php endif; ?>

                            <div class="logic-simulation-components" aria-label="Earnings components in rupees">
                                <span class="logic-field-label">Component inputs (₹)</span>
                                <?php $__currentLoopData = [['BASIC', ''], ['', ''], ['', '']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => [$defaultCode, $defaultAmount]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="logic-simulation-component-row">
                                        <label class="sr-only" for="simulation_code_<?php echo e($pack->id); ?>_<?php echo e($index); ?>">Component <?php echo e($index + 1); ?> code</label>
                                        <input class="b360-control" id="simulation_code_<?php echo e($pack->id); ?>_<?php echo e($index); ?>" name="component_codes[]" value="<?php echo e(old('component_codes.'.$index, $defaultCode)); ?>" placeholder="Component code" <?php if($index === 0): ?> required <?php endif; ?>>
                                        <label class="sr-only" for="simulation_amount_<?php echo e($pack->id); ?>_<?php echo e($index); ?>">Component <?php echo e($index + 1); ?> amount in rupees</label>
                                        <input class="b360-control" id="simulation_amount_<?php echo e($pack->id); ?>_<?php echo e($index); ?>" name="component_amounts[]" value="<?php echo e(old('component_amounts.'.$index, $defaultAmount)); ?>" inputmode="decimal" placeholder="Amount in rupees" <?php if($index === 0): ?> required <?php endif; ?>>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <div class="logic-simulation-context">
                                <?php if (isset($component)) { $__componentOriginal788c5626c9f4f85906027b3ea3343fab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal788c5626c9f4f85906027b3ea3343fab = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.field','data' => ['name' => 'simulation_employment_type_'.e($pack->id).'','label' => 'Employment type','hint' => 'Required only when this pack limits population.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'simulation_employment_type_'.e($pack->id).'','label' => 'Employment type','hint' => 'Required only when this pack limits population.']); ?>
                                    <?php if (isset($component)) { $__componentOriginal4fb6044c7ed6b655352043ff774efcd0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4fb6044c7ed6b655352043ff774efcd0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input','data' => ['name' => 'employee_context[employment_type]','id' => 'simulation_employment_type_'.e($pack->id).'','value' => old('employee_context.employment_type'),'maxlength' => '100']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'employee_context[employment_type]','id' => 'simulation_employment_type_'.e($pack->id).'','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('employee_context.employment_type')),'maxlength' => '100']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4fb6044c7ed6b655352043ff774efcd0)): ?>
<?php $attributes = $__attributesOriginal4fb6044c7ed6b655352043ff774efcd0; ?>
<?php unset($__attributesOriginal4fb6044c7ed6b655352043ff774efcd0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4fb6044c7ed6b655352043ff774efcd0)): ?>
<?php $component = $__componentOriginal4fb6044c7ed6b655352043ff774efcd0; ?>
<?php unset($__componentOriginal4fb6044c7ed6b655352043ff774efcd0); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal788c5626c9f4f85906027b3ea3343fab)): ?>
<?php $attributes = $__attributesOriginal788c5626c9f4f85906027b3ea3343fab; ?>
<?php unset($__attributesOriginal788c5626c9f4f85906027b3ea3343fab); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal788c5626c9f4f85906027b3ea3343fab)): ?>
<?php $component = $__componentOriginal788c5626c9f4f85906027b3ea3343fab; ?>
<?php unset($__componentOriginal788c5626c9f4f85906027b3ea3343fab); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal788c5626c9f4f85906027b3ea3343fab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal788c5626c9f4f85906027b3ea3343fab = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.field','data' => ['name' => 'simulation_department_'.e($pack->id).'','label' => 'Department']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'simulation_department_'.e($pack->id).'','label' => 'Department']); ?>
                                    <?php if (isset($component)) { $__componentOriginal4fb6044c7ed6b655352043ff774efcd0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4fb6044c7ed6b655352043ff774efcd0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input','data' => ['name' => 'employee_context[department]','id' => 'simulation_department_'.e($pack->id).'','value' => old('employee_context.department'),'maxlength' => '160']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'employee_context[department]','id' => 'simulation_department_'.e($pack->id).'','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('employee_context.department')),'maxlength' => '160']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4fb6044c7ed6b655352043ff774efcd0)): ?>
<?php $attributes = $__attributesOriginal4fb6044c7ed6b655352043ff774efcd0; ?>
<?php unset($__attributesOriginal4fb6044c7ed6b655352043ff774efcd0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4fb6044c7ed6b655352043ff774efcd0)): ?>
<?php $component = $__componentOriginal4fb6044c7ed6b655352043ff774efcd0; ?>
<?php unset($__componentOriginal4fb6044c7ed6b655352043ff774efcd0); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal788c5626c9f4f85906027b3ea3343fab)): ?>
<?php $attributes = $__attributesOriginal788c5626c9f4f85906027b3ea3343fab; ?>
<?php unset($__attributesOriginal788c5626c9f4f85906027b3ea3343fab); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal788c5626c9f4f85906027b3ea3343fab)): ?>
<?php $component = $__componentOriginal788c5626c9f4f85906027b3ea3343fab; ?>
<?php unset($__componentOriginal788c5626c9f4f85906027b3ea3343fab); ?>
<?php endif; ?>
                            </div>

                            <p class="logic-simulation-guard"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> Simulation remains non-authoritative even when the selected pack is active. Payroll uses only independently verified, approved, effective packs and finalized attendance.</p>
                            <div class="blade-form-actions"><?php if (isset($component)) { $__componentOriginala84921e8a2bb1be3d0148785a93a50d8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala84921e8a2bb1be3d0148785a93a50d8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.action','data' => ['type' => 'submit','variant' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.action'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'primary']); ?>Run non-authoritative simulation <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala84921e8a2bb1be3d0148785a93a50d8)): ?>
<?php $attributes = $__attributesOriginala84921e8a2bb1be3d0148785a93a50d8; ?>
<?php unset($__attributesOriginala84921e8a2bb1be3d0148785a93a50d8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala84921e8a2bb1be3d0148785a93a50d8)): ?>
<?php $component = $__componentOriginala84921e8a2bb1be3d0148785a93a50d8; ?>
<?php unset($__componentOriginala84921e8a2bb1be3d0148785a93a50d8); ?>
<?php endif; ?></div>
                        </form>
                    </details>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </article>

    <article class="logic-simulation-card logic-simulation-card-wide">
        <span class="logic-simulation-icon"><i class="fa-solid fa-calendar-days" aria-hidden="true"></i></span>
        <div><h2>Roster generation impact</h2><p>Preview rotations, conflicts, rest-period checks and coverage without publishing or changing attendance.</p></div>
        <?php if(! $page->capabilities['manageRosters']): ?>
            <span class="logic-restricted-state">Your role cannot run roster impact simulations.</span>
        <?php elseif(count($page->rosterSimulationRules) === 0): ?>
            <span class="logic-restricted-state is-warning">No active attendance rotation is available in your authorized company scope.</span>
        <?php else: ?>
            <div class="logic-simulation-pack-list">
                <?php $__currentLoopData = $page->rosterSimulationRules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rotation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php ($rosterRuleOpen = (int) old('attendance_rotation_rule_id') === $rotation->id || (int) data_get($rosterSimulation ?? [], 'rotation_rule_id') === $rotation->id); ?>
                    <details class="logic-simulation-pack" <?php if($rosterRuleOpen): ?> open <?php endif; ?>>
                        <summary>
                            <span>
                                <strong><?php echo e($rotation->name); ?></strong>
                                <small><?php echo e($rotation->employeeName); ?> (<?php echo e($rotation->employeeCode); ?>) &middot; <?php echo e($rotation->cycleDays); ?>-day cycle</small>
                            </span>
                            <?php if (isset($component)) { $__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.badge','data' => ['tone' => 'neutral']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tone' => 'neutral']); ?><?php echo e(str($rotation->status)->headline()); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4)): ?>
<?php $attributes = $__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4; ?>
<?php unset($__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4)): ?>
<?php $component = $__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4; ?>
<?php unset($__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4); ?>
<?php endif; ?>
                        </summary>
                        <form method="POST" action="<?php echo e(route('scoring.roster-simulations.store', $rotation->id)); ?>" class="logic-simulation-form">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="attendance_rotation_rule_id" value="<?php echo e($rotation->id); ?>">
                            <div class="logic-simulation-context">
                                <?php if (isset($component)) { $__componentOriginal788c5626c9f4f85906027b3ea3343fab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal788c5626c9f4f85906027b3ea3343fab = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.field','data' => ['name' => 'roster_simulation_start_'.e($rotation->id).'','label' => 'Preview from','hint' => 'Anchor: '.e($rotation->anchorDate).'','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'roster_simulation_start_'.e($rotation->id).'','label' => 'Preview from','hint' => 'Anchor: '.e($rotation->anchorDate).'','required' => true]); ?>
                                    <?php if (isset($component)) { $__componentOriginal4fb6044c7ed6b655352043ff774efcd0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4fb6044c7ed6b655352043ff774efcd0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input','data' => ['type' => 'date','name' => 'start_date','id' => 'roster_simulation_start_'.e($rotation->id).'','value' => old('attendance_rotation_rule_id') == $rotation->id ? old('start_date') : now()->toDateString(),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','name' => 'start_date','id' => 'roster_simulation_start_'.e($rotation->id).'','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('attendance_rotation_rule_id') == $rotation->id ? old('start_date') : now()->toDateString()),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4fb6044c7ed6b655352043ff774efcd0)): ?>
<?php $attributes = $__attributesOriginal4fb6044c7ed6b655352043ff774efcd0; ?>
<?php unset($__attributesOriginal4fb6044c7ed6b655352043ff774efcd0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4fb6044c7ed6b655352043ff774efcd0)): ?>
<?php $component = $__componentOriginal4fb6044c7ed6b655352043ff774efcd0; ?>
<?php unset($__componentOriginal4fb6044c7ed6b655352043ff774efcd0); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal788c5626c9f4f85906027b3ea3343fab)): ?>
<?php $attributes = $__attributesOriginal788c5626c9f4f85906027b3ea3343fab; ?>
<?php unset($__attributesOriginal788c5626c9f4f85906027b3ea3343fab); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal788c5626c9f4f85906027b3ea3343fab)): ?>
<?php $component = $__componentOriginal788c5626c9f4f85906027b3ea3343fab; ?>
<?php unset($__componentOriginal788c5626c9f4f85906027b3ea3343fab); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal788c5626c9f4f85906027b3ea3343fab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal788c5626c9f4f85906027b3ea3343fab = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.field','data' => ['name' => 'roster_simulation_end_'.e($rotation->id).'','label' => 'Preview through','hint' => 'Maximum governed horizon: '.e($rotation->generationHorizonDays).' days','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'roster_simulation_end_'.e($rotation->id).'','label' => 'Preview through','hint' => 'Maximum governed horizon: '.e($rotation->generationHorizonDays).' days','required' => true]); ?>
                                    <?php if (isset($component)) { $__componentOriginal4fb6044c7ed6b655352043ff774efcd0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4fb6044c7ed6b655352043ff774efcd0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input','data' => ['type' => 'date','name' => 'end_date','id' => 'roster_simulation_end_'.e($rotation->id).'','value' => old('attendance_rotation_rule_id') == $rotation->id ? old('end_date') : now()->addDays(min(13, $rotation->generationHorizonDays - 1))->toDateString(),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','name' => 'end_date','id' => 'roster_simulation_end_'.e($rotation->id).'','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('attendance_rotation_rule_id') == $rotation->id ? old('end_date') : now()->addDays(min(13, $rotation->generationHorizonDays - 1))->toDateString()),'required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4fb6044c7ed6b655352043ff774efcd0)): ?>
<?php $attributes = $__attributesOriginal4fb6044c7ed6b655352043ff774efcd0; ?>
<?php unset($__attributesOriginal4fb6044c7ed6b655352043ff774efcd0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4fb6044c7ed6b655352043ff774efcd0)): ?>
<?php $component = $__componentOriginal4fb6044c7ed6b655352043ff774efcd0; ?>
<?php unset($__componentOriginal4fb6044c7ed6b655352043ff774efcd0); ?>
<?php endif; ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal788c5626c9f4f85906027b3ea3343fab)): ?>
<?php $attributes = $__attributesOriginal788c5626c9f4f85906027b3ea3343fab; ?>
<?php unset($__attributesOriginal788c5626c9f4f85906027b3ea3343fab); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal788c5626c9f4f85906027b3ea3343fab)): ?>
<?php $component = $__componentOriginal788c5626c9f4f85906027b3ea3343fab; ?>
<?php unset($__componentOriginal788c5626c9f4f85906027b3ea3343fab); ?>
<?php endif; ?>
                            </div>
                            <?php if(old('attendance_rotation_rule_id') == $rotation->id): ?>
                                <?php $__errorArgs = ['attendance_rotation_rule_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="blade-field-error" role="alert"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="blade-field-error" role="alert"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="blade-field-error" role="alert"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php endif; ?>
                            <p class="logic-simulation-guard"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i> This preview reads effective rule packs and published schedules but cannot create, publish, lock, or change a roster, attendance record, payable day, or payroll input.</p>
                            <div class="blade-form-actions">
                                <?php if (isset($component)) { $__componentOriginala84921e8a2bb1be3d0148785a93a50d8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala84921e8a2bb1be3d0148785a93a50d8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.action','data' => ['type' => 'submit','variant' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.action'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'primary']); ?>Run roster simulation <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala84921e8a2bb1be3d0148785a93a50d8)): ?>
<?php $attributes = $__attributesOriginala84921e8a2bb1be3d0148785a93a50d8; ?>
<?php unset($__attributesOriginala84921e8a2bb1be3d0148785a93a50d8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala84921e8a2bb1be3d0148785a93a50d8)): ?>
<?php $component = $__componentOriginala84921e8a2bb1be3d0148785a93a50d8; ?>
<?php unset($__componentOriginala84921e8a2bb1be3d0148785a93a50d8); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginala84921e8a2bb1be3d0148785a93a50d8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala84921e8a2bb1be3d0148785a93a50d8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.action','data' => ['href' => route('scoring.index', ['view' => 'roster'])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.action'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('scoring.index', ['view' => 'roster']))]); ?>Open roster rules <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala84921e8a2bb1be3d0148785a93a50d8)): ?>
<?php $attributes = $__attributesOriginala84921e8a2bb1be3d0148785a93a50d8; ?>
<?php unset($__attributesOriginala84921e8a2bb1be3d0148785a93a50d8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala84921e8a2bb1be3d0148785a93a50d8)): ?>
<?php $component = $__componentOriginala84921e8a2bb1be3d0148785a93a50d8; ?>
<?php unset($__componentOriginala84921e8a2bb1be3d0148785a93a50d8); ?>
<?php endif; ?>
                            </div>
                        </form>
                    </details>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </article>
</section>

<?php if($page->capabilities['managePerformance'] && is_array($performanceSimulation ?? null)): ?>
    <?php ($performanceComponents = (array) data_get($performanceSimulation, 'component_scores', [])); ?>
    <?php if (isset($component)) { $__componentOriginaldae4cd48acb67888a4631e1ba48f2f93 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldae4cd48acb67888a4631e1ba48f2f93 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.card','data' => ['id' => 'performance-simulation-result','title' => 'Non-authoritative performance simulation','eyebrow' => 'What-if result','meta' => ''.e(data_get($performanceSimulation, 'rule_name')).' &middot; v'.e(data_get($performanceSimulation, 'rule_version')).' &middot; '.e(str((string) data_get($performanceSimulation, 'rule_status'))->headline()).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'performance-simulation-result','title' => 'Non-authoritative performance simulation','eyebrow' => 'What-if result','meta' => ''.e(data_get($performanceSimulation, 'rule_name')).' &middot; v'.e(data_get($performanceSimulation, 'rule_version')).' &middot; '.e(str((string) data_get($performanceSimulation, 'rule_status'))->headline()).'']); ?>
        <div class="logic-simulation-result-guard" role="status">
            <i class="fa-solid fa-flask" aria-hidden="true"></i>
            <span><strong>This result cannot affect an employee review.</strong> It mutated <?php echo e(data_get($performanceSimulation, 'mutated_records', 0)); ?> records and is retained only for this response.</span>
        </div>
        <section class="logic-simulation-result-grid" aria-label="Performance simulation result">
            <?php $__currentLoopData = [
                ['Calculated score', data_get($performanceSimulation, 'total_score', '0.00').'/100'],
                ['Rating band', data_get($performanceSimulation, 'band_label', 'Not assigned')],
                ['Passing threshold', data_get($performanceSimulation, 'passing') ? 'Met' : 'Not met'],
                ['PIP threshold', data_get($performanceSimulation, 'pip_recommended') ? 'Triggered' : 'Not triggered'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article><span><?php echo e($label); ?></span><strong><?php echo e($value); ?></strong></article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </section>

        <?php if (isset($component)) { $__componentOriginal17e1d856121687ce90b748b5990193ab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal17e1d856121687ce90b748b5990193ab = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.responsive-register','data' => ['label' => 'Performance formula trace']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.responsive-register'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Performance formula trace']); ?>
             <?php $__env->slot('desktop', null, []); ?> 
                <table class="blade-data-table">
                    <caption class="sr-only">Performance score calculation trace for the selected rule version</caption>
                    <thead><tr><th scope="col">Criterion</th><th scope="col">Input</th><th scope="col">Applied weight</th><th scope="col">Normalized</th><th scope="col">Contribution</th></tr></thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $performanceComponents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $criterionKey => $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><strong><?php echo e(data_get($component, 'label', str((string) $criterionKey)->headline())); ?></strong><small><?php echo e($criterionKey); ?></small></td>
                                <td><?php echo e(number_format((float) data_get($performanceSimulation, 'criterion_scores.'.$criterionKey, 0), 2)); ?></td>
                                <td><?php echo e(number_format((float) data_get($performanceSimulation, 'applied_weights.'.$criterionKey, 0), 2)); ?>%</td>
                                <td><?php echo e(number_format((float) data_get($component, 'normalized_score', 0), 2)); ?></td>
                                <td><?php echo e(number_format((float) data_get($component, 'weighted_contribution', 0), 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="5">No criterion calculation lines were returned.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
             <?php $__env->endSlot(); ?>
             <?php $__env->slot('mobile', null, []); ?> 
                <div class="b360-mobile-register">
                    <?php $__empty_1 = true; $__currentLoopData = $performanceComponents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $criterionKey => $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <article>
                            <strong><?php echo e(data_get($component, 'label', str((string) $criterionKey)->headline())); ?></strong>
                            <span>Input <?php echo e(number_format((float) data_get($performanceSimulation, 'criterion_scores.'.$criterionKey, 0), 2)); ?> &middot; Weight <?php echo e(number_format((float) data_get($performanceSimulation, 'applied_weights.'.$criterionKey, 0), 2)); ?>%</span>
                            <small>Normalized <?php echo e(number_format((float) data_get($component, 'normalized_score', 0), 2)); ?> &middot; Contribution <?php echo e(number_format((float) data_get($component, 'weighted_contribution', 0), 2)); ?></small>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php if (isset($component)) { $__componentOriginal3607a477fdef7402bc742abad5df9c51 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3607a477fdef7402bc742abad5df9c51 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.empty-state','data' => ['title' => 'No calculation lines','description' => 'The selected rule returned no criterion calculations.','icon' => 'fa-circle-info']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No calculation lines','description' => 'The selected rule returned no criterion calculations.','icon' => 'fa-circle-info']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3607a477fdef7402bc742abad5df9c51)): ?>
<?php $attributes = $__attributesOriginal3607a477fdef7402bc742abad5df9c51; ?>
<?php unset($__attributesOriginal3607a477fdef7402bc742abad5df9c51); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3607a477fdef7402bc742abad5df9c51)): ?>
<?php $component = $__componentOriginal3607a477fdef7402bc742abad5df9c51; ?>
<?php unset($__componentOriginal3607a477fdef7402bc742abad5df9c51); ?>
<?php endif; ?>
                    <?php endif; ?>
                </div>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal17e1d856121687ce90b748b5990193ab)): ?>
<?php $attributes = $__attributesOriginal17e1d856121687ce90b748b5990193ab; ?>
<?php unset($__attributesOriginal17e1d856121687ce90b748b5990193ab); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal17e1d856121687ce90b748b5990193ab)): ?>
<?php $component = $__componentOriginal17e1d856121687ce90b748b5990193ab; ?>
<?php unset($__componentOriginal17e1d856121687ce90b748b5990193ab); ?>
<?php endif; ?>

        <?php if(count((array) data_get($performanceSimulation, 'mandatory_failures', [])) > 0): ?>
            <div class="logic-simulation-failures" role="alert">
                <strong>Mandatory conditions not met</strong>
                <ul>
                    <?php $__currentLoopData = (array) data_get($performanceSimulation, 'mandatory_failures', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $failure): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($failure); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <dl class="logic-simulation-evidence">
            <div><dt>Rule checksum</dt><dd><code><?php echo e(data_get($performanceSimulation, 'rule_checksum', '-')); ?></code></dd></div>
            <div><dt>Input hash</dt><dd><code><?php echo e(data_get($performanceSimulation, 'input_hash', '-')); ?></code></dd></div>
            <div><dt>Result hash</dt><dd><code><?php echo e(data_get($performanceSimulation, 'result_hash', '-')); ?></code></dd></div>
        </dl>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldae4cd48acb67888a4631e1ba48f2f93)): ?>
<?php $attributes = $__attributesOriginaldae4cd48acb67888a4631e1ba48f2f93; ?>
<?php unset($__attributesOriginaldae4cd48acb67888a4631e1ba48f2f93); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldae4cd48acb67888a4631e1ba48f2f93)): ?>
<?php $component = $__componentOriginaldae4cd48acb67888a4631e1ba48f2f93; ?>
<?php unset($__componentOriginaldae4cd48acb67888a4631e1ba48f2f93); ?>
<?php endif; ?>
<?php endif; ?>

<?php if($page->capabilities['manageRosters'] && is_array($rosterSimulation ?? null)): ?>
    <?php if (isset($component)) { $__componentOriginaldae4cd48acb67888a4631e1ba48f2f93 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldae4cd48acb67888a4631e1ba48f2f93 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.card','data' => ['id' => 'roster-simulation-result','title' => 'Non-authoritative roster impact simulation','eyebrow' => 'What-if result','meta' => ''.e(data_get($rosterSimulation, 'rotation_name')).' &middot; '.e(data_get($rosterSimulation, 'employee_name')).' &middot; '.e(data_get($rosterSimulation, 'timezone')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'roster-simulation-result','title' => 'Non-authoritative roster impact simulation','eyebrow' => 'What-if result','meta' => ''.e(data_get($rosterSimulation, 'rotation_name')).' &middot; '.e(data_get($rosterSimulation, 'employee_name')).' &middot; '.e(data_get($rosterSimulation, 'timezone')).'']); ?>
        <div class="logic-simulation-result-guard" role="status">
            <i class="fa-solid fa-flask" aria-hidden="true"></i>
            <span><strong>This result cannot affect a roster or attendance.</strong> It mutated <?php echo e(data_get($rosterSimulation, 'mutated_records', 0)); ?> records and is retained only for this response.</span>
        </div>
        <section class="logic-simulation-result-grid" aria-label="Roster impact totals">
            <?php $__currentLoopData = [
                ['Preview days', data_get($rosterSimulation, 'counts.days', 0)],
                ['Working shifts', data_get($rosterSimulation, 'counts.shift_days', 0)],
                ['Off days and holidays', data_get($rosterSimulation, 'counts.off_days', 0) + data_get($rosterSimulation, 'counts.holidays', 0)],
                ['Blocking findings', data_get($rosterSimulation, 'counts.blocking_findings', 0)],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article><span><?php echo e($label); ?></span><strong><?php echo e($value); ?></strong></article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </section>

        <?php if (isset($component)) { $__componentOriginal17e1d856121687ce90b748b5990193ab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal17e1d856121687ce90b748b5990193ab = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.responsive-register','data' => ['label' => 'Roster impact preview']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.responsive-register'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Roster impact preview']); ?>
             <?php $__env->slot('desktop', null, []); ?> 
                <table class="blade-data-table">
                    <caption class="sr-only">Non-mutating roster impact preview by work date</caption>
                    <thead><tr><th scope="col">Work date</th><th scope="col">Cycle day</th><th scope="col">Assignment</th><th scope="col">Local schedule</th><th scope="col">Impact</th></tr></thead>
                    <tbody>
                        <?php $__currentLoopData = (array) data_get($rosterSimulation, 'days', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><strong><?php echo e($day['day_label']); ?></strong><small><?php echo e($day['date']); ?></small></td>
                                <td><?php echo e($day['cycle_index']); ?></td>
                                <td><?php echo e($day['shift_name'] ?? str((string) $day['entry_type'])->headline()); ?> <?php if($day['shift_code']): ?><small><?php echo e($day['shift_code']); ?></small><?php endif; ?></td>
                                <td><?php echo e($day['starts_at_local'] ?? '-'); ?> <?php if($day['ends_at_local']): ?><small>to <?php echo e($day['ends_at_local']); ?></small><?php endif; ?></td>
                                <td>
                                    <?php if(count($day['finding_codes']) === 0): ?>
                                        <?php if (isset($component)) { $__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.badge','data' => ['tone' => 'success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tone' => 'success']); ?>Clear <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4)): ?>
<?php $attributes = $__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4; ?>
<?php unset($__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4)): ?>
<?php $component = $__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4; ?>
<?php unset($__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4); ?>
<?php endif; ?>
                                    <?php else: ?>
                                        <?php $__currentLoopData = $day['finding_codes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if (isset($component)) { $__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.badge','data' => ['tone' => $code === 'authoritative_match' ? 'neutral' : 'danger']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tone' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($code === 'authoritative_match' ? 'neutral' : 'danger')]); ?><?php echo e(str($code)->replace('_', ' ')->headline()); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4)): ?>
<?php $attributes = $__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4; ?>
<?php unset($__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4)): ?>
<?php $component = $__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4; ?>
<?php unset($__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4); ?>
<?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
             <?php $__env->endSlot(); ?>
             <?php $__env->slot('mobile', null, []); ?> 
                <div class="b360-mobile-register">
                    <?php $__currentLoopData = (array) data_get($rosterSimulation, 'days', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article><strong><?php echo e($day['day_label']); ?></strong><span><?php echo e($day['shift_name'] ?? str((string) $day['entry_type'])->headline()); ?></span><small><?php echo e($day['starts_at_local'] ?? 'No working hours'); ?> &middot; <?php echo e(count($day['finding_codes'])); ?> finding(s)</small></article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal17e1d856121687ce90b748b5990193ab)): ?>
<?php $attributes = $__attributesOriginal17e1d856121687ce90b748b5990193ab; ?>
<?php unset($__attributesOriginal17e1d856121687ce90b748b5990193ab); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal17e1d856121687ce90b748b5990193ab)): ?>
<?php $component = $__componentOriginal17e1d856121687ce90b748b5990193ab; ?>
<?php unset($__componentOriginal17e1d856121687ce90b748b5990193ab); ?>
<?php endif; ?>

        <?php if(count((array) data_get($rosterSimulation, 'findings', [])) > 0): ?>
            <div class="logic-simulation-failures" role="status">
                <strong>Simulation findings</strong>
                <ul><?php $__currentLoopData = (array) data_get($rosterSimulation, 'findings', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $finding): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><strong><?php echo e($finding['date']); ?></strong> &mdash; <?php echo e($finding['message']); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
            </div>
        <?php endif; ?>
        <dl class="logic-simulation-evidence">
            <div><dt>Input hash</dt><dd><code><?php echo e(data_get($rosterSimulation, 'input_hash', '-')); ?></code></dd></div>
            <div><dt>Result hash</dt><dd><code><?php echo e(data_get($rosterSimulation, 'result_hash', '-')); ?></code></dd></div>
        </dl>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldae4cd48acb67888a4631e1ba48f2f93)): ?>
<?php $attributes = $__attributesOriginaldae4cd48acb67888a4631e1ba48f2f93; ?>
<?php unset($__attributesOriginaldae4cd48acb67888a4631e1ba48f2f93); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldae4cd48acb67888a4631e1ba48f2f93)): ?>
<?php $component = $__componentOriginaldae4cd48acb67888a4631e1ba48f2f93; ?>
<?php unset($__componentOriginaldae4cd48acb67888a4631e1ba48f2f93); ?>
<?php endif; ?>
<?php endif; ?>

<?php if(is_array($statutorySimulation ?? null)): ?>
    <?php ($simulationResult = (array) data_get($statutorySimulation, 'result', [])); ?>
    <?php if (isset($component)) { $__componentOriginaldae4cd48acb67888a4631e1ba48f2f93 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldae4cd48acb67888a4631e1ba48f2f93 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.card','data' => ['id' => 'statutory-simulation-result','title' => 'Non-authoritative statutory simulation','eyebrow' => 'What-if result','meta' => ''.e(data_get($statutorySimulation, 'setting_label')).' · v'.e(data_get($statutorySimulation, 'setting_version')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'statutory-simulation-result','title' => 'Non-authoritative statutory simulation','eyebrow' => 'What-if result','meta' => ''.e(data_get($statutorySimulation, 'setting_label')).' · v'.e(data_get($statutorySimulation, 'setting_version')).'']); ?>
        <div class="logic-simulation-result-guard" role="status">
            <i class="fa-solid fa-flask" aria-hidden="true"></i>
            <span><strong>This result cannot affect payroll.</strong> It mutated <?php echo e($simulationResult['mutated_records'] ?? 0); ?> records and is retained only for this response.</span>
        </div>
        <section class="logic-simulation-result-grid" aria-label="Simulation totals">
            <?php $__currentLoopData = [
                ['Gross', $simulationResult['gross_display'] ?? '0.00'],
                ['Deductions', $simulationResult['deduction_display'] ?? '0.00'],
                ['Employer contribution', $simulationResult['employer_contribution_display'] ?? '0.00'],
                ['Net', $simulationResult['net_display'] ?? '0.00'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article><span><?php echo e($label); ?></span><strong>₹<?php echo e($value); ?></strong></article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </section>
        <?php if (isset($component)) { $__componentOriginal17e1d856121687ce90b748b5990193ab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal17e1d856121687ce90b748b5990193ab = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.responsive-register','data' => ['label' => 'Statutory simulation lines']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.responsive-register'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Statutory simulation lines']); ?>
             <?php $__env->slot('desktop', null, []); ?> 
                <table class="blade-data-table">
                    <caption class="sr-only">Calculated statutory simulation lines</caption>
                    <thead><tr><th scope="col">Line</th><th scope="col">Jurisdiction</th><th scope="col">Method</th><th scope="col">Basis</th><th scope="col">Amount</th></tr></thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = (array) ($simulationResult['lines'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr><td><strong><?php echo e($line['component_name']); ?></strong><small><?php echo e($line['component_code']); ?> · <?php echo e(str($line['line_type'])->headline()); ?></small></td><td><?php echo e(strtoupper($line['jurisdiction_code'])); ?></td><td><?php echo e(str($line['method'])->headline()); ?></td><td>₹<?php echo e($line['basis_display']); ?></td><td>₹<?php echo e($line['amount_display']); ?></td></tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="5">No governed statutory line applied to the supplied state and population context.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
             <?php $__env->endSlot(); ?>
             <?php $__env->slot('mobile', null, []); ?> 
                <div class="b360-mobile-register">
                    <?php $__empty_1 = true; $__currentLoopData = (array) ($simulationResult['lines'] ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <article><strong><?php echo e($line['component_name']); ?></strong><span><?php echo e($line['component_code']); ?> · <?php echo e(strtoupper($line['jurisdiction_code'])); ?></span><small>Basis ₹<?php echo e($line['basis_display']); ?> · Amount ₹<?php echo e($line['amount_display']); ?></small></article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php if (isset($component)) { $__componentOriginal3607a477fdef7402bc742abad5df9c51 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3607a477fdef7402bc742abad5df9c51 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.empty-state','data' => ['title' => 'No applicable calculation lines','description' => 'The pack did not apply to the supplied state and population context.','icon' => 'fa-circle-info']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No applicable calculation lines','description' => 'The pack did not apply to the supplied state and population context.','icon' => 'fa-circle-info']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3607a477fdef7402bc742abad5df9c51)): ?>
<?php $attributes = $__attributesOriginal3607a477fdef7402bc742abad5df9c51; ?>
<?php unset($__attributesOriginal3607a477fdef7402bc742abad5df9c51); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3607a477fdef7402bc742abad5df9c51)): ?>
<?php $component = $__componentOriginal3607a477fdef7402bc742abad5df9c51; ?>
<?php unset($__componentOriginal3607a477fdef7402bc742abad5df9c51); ?>
<?php endif; ?>
                    <?php endif; ?>
                </div>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal17e1d856121687ce90b748b5990193ab)): ?>
<?php $attributes = $__attributesOriginal17e1d856121687ce90b748b5990193ab; ?>
<?php unset($__attributesOriginal17e1d856121687ce90b748b5990193ab); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal17e1d856121687ce90b748b5990193ab)): ?>
<?php $component = $__componentOriginal17e1d856121687ce90b748b5990193ab; ?>
<?php unset($__componentOriginal17e1d856121687ce90b748b5990193ab); ?>
<?php endif; ?>
        <dl class="logic-simulation-evidence">
            <div><dt>State</dt><dd><?php echo e($simulationResult['statutory_state'] ?? '—'); ?></dd></div>
            <div><dt>Input hash</dt><dd><code><?php echo e($simulationResult['input_hash'] ?? '—'); ?></code></dd></div>
            <div><dt>Result hash</dt><dd><code><?php echo e($simulationResult['result_hash'] ?? '—'); ?></code></dd></div>
        </dl>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldae4cd48acb67888a4631e1ba48f2f93)): ?>
<?php $attributes = $__attributesOriginaldae4cd48acb67888a4631e1ba48f2f93; ?>
<?php unset($__attributesOriginaldae4cd48acb67888a4631e1ba48f2f93); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldae4cd48acb67888a4631e1ba48f2f93)): ?>
<?php $component = $__componentOriginaldae4cd48acb67888a4631e1ba48f2f93; ?>
<?php unset($__componentOriginaldae4cd48acb67888a4631e1ba48f2f93); ?>
<?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/scoring/partials/logic-simulation.blade.php ENDPATH**/ ?>