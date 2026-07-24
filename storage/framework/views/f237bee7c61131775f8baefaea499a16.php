<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id',
    'title',
    'trigger',
    'description' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'id',
    'title',
    'trigger',
    'description' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div x-data="togglePanel" x-on:keydown.escape.window="closePanel">
    <?php if (isset($component)) { $__componentOriginala84921e8a2bb1be3d0148785a93a50d8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala84921e8a2bb1be3d0148785a93a50d8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.action','data' => ['type' => 'button','xRef' => 'trigger','xOn:click' => 'openPanel','xBind:ariaExpanded' => 'openState','ariaHaspopup' => 'dialog','ariaControls' => ''.e($id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.action'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','x-ref' => 'trigger','x-on:click' => 'openPanel','x-bind:aria-expanded' => 'openState','aria-haspopup' => 'dialog','aria-controls' => ''.e($id).'']); ?>
        <?php echo e($trigger); ?>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala84921e8a2bb1be3d0148785a93a50d8)): ?>
<?php $attributes = $__attributesOriginala84921e8a2bb1be3d0148785a93a50d8; ?>
<?php unset($__attributesOriginala84921e8a2bb1be3d0148785a93a50d8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala84921e8a2bb1be3d0148785a93a50d8)): ?>
<?php $component = $__componentOriginala84921e8a2bb1be3d0148785a93a50d8; ?>
<?php unset($__componentOriginala84921e8a2bb1be3d0148785a93a50d8); ?>
<?php endif; ?>
    <div class="b360-modal-layer" x-show="open" x-cloak>
        <button type="button" class="b360-modal-backdrop" x-on:click="closePanel" aria-label="Close <?php echo e($title); ?>"></button>
        <aside id="<?php echo e($id); ?>" class="b360-drawer-panel" x-ref="panel" tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="<?php echo e($id); ?>-title">
            <header class="b360-modal-head">
                <div>
                    <h2 id="<?php echo e($id); ?>-title"><?php echo e($title); ?></h2>
                    <?php if($description): ?><p><?php echo e($description); ?></p><?php endif; ?>
                </div>
                <button type="button" class="b360-icon-btn" x-on:click="closePanel" aria-label="Close <?php echo e($title); ?>">×</button>
            </header>
            <div class="b360-modal-body"><?php echo e($slot); ?></div>
        </aside>
    </div>
</div>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\components\ui\drawer.blade.php ENDPATH**/ ?>