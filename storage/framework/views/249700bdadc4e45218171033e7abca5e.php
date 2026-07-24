<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'href' => null,
    'variant' => 'secondary',
    'type' => 'button',
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
    'href' => null,
    'variant' => 'secondary',
    'type' => 'button',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $classes = match ($variant) {
        'primary' => 'blade-primary-action',
        'danger' => 'blade-danger-action',
        default => 'blade-secondary-action',
    };
?>

<?php if($href): ?>
    <a href="<?php echo e($href); ?>" <?php echo e($attributes->class([$classes])); ?>><?php echo e($slot); ?></a>
<?php else: ?>
    <button type="<?php echo e($type); ?>" <?php echo e($attributes->class([$classes])); ?>><?php echo e($slot); ?></button>
<?php endif; ?>
<?php /**PATH /home/developer/public_html/builder360/resources/views/components/ui/action.blade.php ENDPATH**/ ?>