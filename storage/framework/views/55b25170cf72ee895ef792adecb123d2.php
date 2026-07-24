    <?php if (isset($component)) { $__componentOriginal17e1d856121687ce90b748b5990193ab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal17e1d856121687ce90b748b5990193ab = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.responsive-register','data' => ['label' => 'Orders']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.responsive-register'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Orders']); ?>
         <?php $__env->slot('desktop', null, []); ?> <table><tr><td>ORD-1</td></tr></table> <?php $__env->endSlot(); ?>
         <?php $__env->slot('mobile', null, []); ?> <article>ORD-1</article> <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal17e1d856121687ce90b748b5990193ab)): ?>
<?php $attributes = $__attributesOriginal17e1d856121687ce90b748b5990193ab; ?>
<?php unset($__attributesOriginal17e1d856121687ce90b748b5990193ab); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal17e1d856121687ce90b748b5990193ab)): ?>
<?php $component = $__componentOriginal17e1d856121687ce90b748b5990193ab; ?>
<?php unset($__componentOriginal17e1d856121687ce90b748b5990193ab); ?>
<?php endif; ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\storage\framework\views/649de496330a6f9eeecc1c5bd64d2744.blade.php ENDPATH**/ ?>