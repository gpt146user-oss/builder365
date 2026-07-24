<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => null,
    'eyebrow' => null,
    'meta' => null,
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
    'title' => null,
    'eyebrow' => null,
    'meta' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<article <?php echo e($attributes->class(['blade-dashboard-card'])); ?>>
    <?php if($title || $eyebrow || $meta || isset($actions)): ?>
        <header class="blade-dashboard-section-title">
            <div>
                <?php if($eyebrow): ?><span class="blade-dashboard-label"><?php echo e($eyebrow); ?></span><?php endif; ?>
                <?php if($title): ?><h2><?php echo e($title); ?></h2><?php endif; ?>
            </div>
            <?php if(isset($actions)): ?>
                <div class="blade-workspace-actions"><?php echo e($actions); ?></div>
            <?php elseif($meta): ?>
                <small><?php echo e($meta); ?></small>
            <?php endif; ?>
        </header>
    <?php endif; ?>
    <?php echo e($slot); ?>

</article>
<?php /**PATH /home/developer/public_html/builder360/resources/views/components/ui/card.blade.php ENDPATH**/ ?>