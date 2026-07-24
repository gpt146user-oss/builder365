<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name',
    'label',
    'hint' => null,
    'required' => false,
    'for' => null,
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
    'name',
    'label',
    'hint' => null,
    'required' => false,
    'for' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php ($errorName = ltrim((string) preg_replace('/\[([^\]]+)\]/', '.$1', $name), '.')); ?>

<div <?php echo e($attributes->class(['b360-field'])); ?>>
    <label for="<?php echo e($for ?? $name); ?>">
        <?php echo e($label); ?>

        <?php if($required): ?><span class="b360-required" aria-hidden="true">*</span><?php endif; ?>
    </label>
    <?php echo e($slot); ?>

    <?php if($hint): ?><small class="b360-field-hint"><?php echo e($hint); ?></small><?php endif; ?>
    <?php if(isset($errors) && $errors->has($errorName)): ?>
        <span class="b360-field-error" role="alert"><?php echo e($errors->first($errorName)); ?></span>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\components\forms\field.blade.php ENDPATH**/ ?>