<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label',
    'align' => 'right',
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
    'label',
    'align' => 'right',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div <?php echo e($attributes->class(['b360-dropdown'])); ?> x-data="togglePanel" x-on:keydown.escape.window="closePanel">
    <button type="button" class="blade-secondary-action" x-ref="trigger" x-on:click="togglePanel" x-bind:aria-expanded="openState" aria-haspopup="menu">
        <?php echo e($label); ?>

    </button>
    <div class="b360-dropdown-menu is-<?php echo e($align); ?>" x-ref="panel" x-show="open" x-cloak tabindex="-1" role="menu">
        <?php echo e($slot); ?>

    </div>
</div>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/components/ui/dropdown.blade.php ENDPATH**/ ?>