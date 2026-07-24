<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'empty',
    'title',
    'message',
    'icon' => null,
    'compact' => false,
    'actionUrl' => null,
    'actionLabel' => null,
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
    'type' => 'empty',
    'title',
    'message',
    'icon' => null,
    'compact' => false,
    'actionUrl' => null,
    'actionLabel' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $states = [
        'empty' => ['icon' => 'fa-inbox', 'role' => 'status'],
        'filtered' => ['icon' => 'fa-filter-circle-xmark', 'role' => 'status'],
        'restricted' => ['icon' => 'fa-lock', 'role' => 'note'],
        'retry' => ['icon' => 'fa-rotate-right', 'role' => 'alert'],
        'conflict' => ['icon' => 'fa-triangle-exclamation', 'role' => 'alert'],
        'error' => ['icon' => 'fa-circle-exclamation', 'role' => 'alert'],
        'warning' => ['icon' => 'fa-triangle-exclamation', 'role' => 'alert'],
        'success' => ['icon' => 'fa-circle-check', 'role' => 'status'],
        'loading' => ['icon' => 'fa-spinner', 'role' => 'status'],
    ];
    $state = $states[$type] ?? $states['empty'];
    $stateType = array_key_exists($type, $states) ? $type : 'empty';
?>

<section
    <?php echo e($attributes->class(['people-panel-empty', 'people-state', 'is-'.$stateType, 'is-compact' => $compact])); ?>

    role="<?php echo e($state['role']); ?>"
    <?php if(in_array($stateType, ['retry', 'conflict', 'error', 'warning'], true)): ?> tabindex="-1" <?php endif; ?>
    <?php if($stateType === 'loading'): ?> aria-busy="true" aria-live="polite" <?php endif; ?>
    <?php if($stateType === 'success'): ?> aria-live="polite" <?php endif; ?>
    data-people-state="<?php echo e($stateType); ?>"
>
    <i class="fa-solid <?php echo e($icon ?: $state['icon']); ?>" aria-hidden="true"></i>
    <strong><?php echo e($title); ?></strong>
    <span><?php echo e($message); ?></span>
    <?php if($actionUrl && $actionLabel): ?>
        <a class="people-button" href="<?php echo e($actionUrl); ?>"><?php echo e($actionLabel); ?></a>
    <?php endif; ?>
</section>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\components\hr\people-state.blade.php ENDPATH**/ ?>