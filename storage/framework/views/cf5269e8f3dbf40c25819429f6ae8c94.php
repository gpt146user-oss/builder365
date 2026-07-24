<?php if (isset($component)) { $__componentOriginaldae4cd48acb67888a4631e1ba48f2f93 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldae4cd48acb67888a4631e1ba48f2f93 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.card','data' => ['id' => 'logic-variable-packs','title' => 'Governed variable packs','eyebrow' => 'Effective-dated configuration','meta' => ''.e(count($page->variablePacks)).' versions']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'logic-variable-packs','title' => 'Governed variable packs','eyebrow' => 'Effective-dated configuration','meta' => ''.e(count($page->variablePacks)).' versions']); ?>
    <?php if(count($page->variablePacks) === 0): ?>
        <?php if (isset($component)) { $__componentOriginal3607a477fdef7402bc742abad5df9c51 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3607a477fdef7402bc742abad5df9c51 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.empty-state','data' => ['title' => 'No governed variable packs found','description' => 'Create a draft through the approved settings workflow. No default statutory rate will be inferred or activated.','icon' => 'fa-shield-halved']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No governed variable packs found','description' => 'Create a draft through the approved settings workflow. No default statutory rate will be inferred or activated.','icon' => 'fa-shield-halved']); ?>
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
    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginal17e1d856121687ce90b748b5990193ab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal17e1d856121687ce90b748b5990193ab = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.responsive-register','data' => ['label' => 'Governed variable pack versions']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.responsive-register'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Governed variable pack versions']); ?>
             <?php $__env->slot('desktop', null, []); ?> 
                <table class="blade-data-table">
                    <caption class="sr-only">Governed statutory, payroll, attendance and roster variable packs</caption>
                    <thead>
                        <tr>
                            <th scope="col">Variable pack</th>
                            <th scope="col">Version</th>
                            <th scope="col">Status</th>
                            <th scope="col">Effective period</th>
                            <th scope="col">Official source</th>
                            <th scope="col">Checksum</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $page->variablePacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pack): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><strong><?php echo e($pack->label); ?></strong><small><?php echo e($pack->settingKey); ?> &middot; <?php echo e($pack->domain); ?></small></td>
                                <td>v<?php echo e($pack->version); ?></td>
                                <td>
                                    <?php if (isset($component)) { $__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.badge','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?><?php echo e($pack->status); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4)): ?>
<?php $attributes = $__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4; ?>
<?php unset($__attributesOriginalab7baa01105b3dfe1e0cf1dfc58879b4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4)): ?>
<?php $component = $__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4; ?>
<?php unset($__componentOriginalab7baa01105b3dfe1e0cf1dfc58879b4); ?>
<?php endif; ?>
                                    <?php if($pack->requiresVerification): ?>
                                        <small><?php echo e($pack->verified ? 'Official source verified' : 'Verification required'); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($pack->effectivePeriod); ?></td>
                                <td><strong><?php echo e($pack->sourceAuthority); ?></strong><small><?php echo e($pack->sourceReference); ?></small></td>
                                <td><code><?php echo e($pack->checksum); ?></code></td>
                                <td>
                                    <div class="blade-inline-actions">
                                        <?php if($pack->reviewUrl): ?>
                                            <?php if (isset($component)) { $__componentOriginala84921e8a2bb1be3d0148785a93a50d8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala84921e8a2bb1be3d0148785a93a50d8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.action','data' => ['href' => $pack->reviewUrl]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.action'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pack->reviewUrl)]); ?>Review <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala84921e8a2bb1be3d0148785a93a50d8)): ?>
<?php $attributes = $__attributesOriginala84921e8a2bb1be3d0148785a93a50d8; ?>
<?php unset($__attributesOriginala84921e8a2bb1be3d0148785a93a50d8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala84921e8a2bb1be3d0148785a93a50d8)): ?>
<?php $component = $__componentOriginala84921e8a2bb1be3d0148785a93a50d8; ?>
<?php unset($__componentOriginala84921e8a2bb1be3d0148785a93a50d8); ?>
<?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php if(count($pack->variables) > 0): ?>
                                <tr class="logic-variable-detail-row">
                                    <td colspan="7">
                                        <dl class="logic-variable-grid" aria-label="<?php echo e($pack->label); ?> normalized variables">
                                            <?php $__currentLoopData = $pack->variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div><dt><?php echo e($variable['label']); ?></dt><dd><?php echo e($variable['value']); ?></dd></div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </dl>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
             <?php $__env->endSlot(); ?>
             <?php $__env->slot('mobile', null, []); ?> 
                <div class="b360-mobile-register">
                    <?php $__currentLoopData = $page->variablePacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pack): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article>
                            <strong><?php echo e($pack->label); ?></strong>
                            <span>v<?php echo e($pack->version); ?> &middot; <?php echo e($pack->status); ?></span>
                            <small><?php echo e($pack->effectivePeriod); ?></small>
                            <small>
                                <?php if($pack->requiresVerification): ?>
                                    <?php echo e($pack->verified ? 'Verified source' : 'Verification required'); ?> &middot;
                                <?php endif; ?>
                                <?php echo e($pack->checksum); ?>

                            </small>
                            <?php if(count($pack->variables) > 0): ?>
                                <dl class="logic-variable-grid" aria-label="<?php echo e($pack->label); ?> normalized variables">
                                    <?php $__currentLoopData = $pack->variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div><dt><?php echo e($variable['label']); ?></dt><dd><?php echo e($variable['value']); ?></dd></div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </dl>
                            <?php endif; ?>
                            <?php if($pack->reviewUrl): ?>
                                <?php if (isset($component)) { $__componentOriginala84921e8a2bb1be3d0148785a93a50d8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala84921e8a2bb1be3d0148785a93a50d8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.action','data' => ['href' => $pack->reviewUrl]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.action'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pack->reviewUrl)]); ?>Review <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala84921e8a2bb1be3d0148785a93a50d8)): ?>
<?php $attributes = $__attributesOriginala84921e8a2bb1be3d0148785a93a50d8; ?>
<?php unset($__attributesOriginala84921e8a2bb1be3d0148785a93a50d8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala84921e8a2bb1be3d0148785a93a50d8)): ?>
<?php $component = $__componentOriginala84921e8a2bb1be3d0148785a93a50d8; ?>
<?php unset($__componentOriginala84921e8a2bb1be3d0148785a93a50d8); ?>
<?php endif; ?>
                            <?php endif; ?>
                        </article>
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
    <?php endif; ?>
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
<?php /**PATH /home/developer/public_html/builder360/resources/views/scoring/partials/logic-variable-packs.blade.php ENDPATH**/ ?>