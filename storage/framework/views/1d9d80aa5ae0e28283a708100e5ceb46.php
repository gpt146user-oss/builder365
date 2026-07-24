<section class="logic-readiness-grid" aria-label="Logic Center readiness">
    <?php $__currentLoopData = [
        ['Governed variable packs', $page->readiness['variablePacks'], 'Versioned System Settings and statutory packs', 'fa-box-archive', 'is-info'],
        ['Active packs', $page->readiness['activePacks'], 'Effective versions available in the current company scope', 'fa-circle-check', 'is-success'],
        ['Awaiting verification', $page->readiness['unverifiedPacks'], 'Cannot become authoritative for statutory payroll', 'fa-triangle-exclamation', 'is-warning'],
        ['Draft packs', $page->readiness['draftPacks'], 'Maker-checker review remains outstanding', 'fa-pen-ruler', 'is-muted'],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value, $detail, $icon, $tone]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <article class="logic-readiness-card <?php echo e($tone); ?>">
            <span class="logic-readiness-icon"><i class="fa-solid <?php echo e($icon); ?>" aria-hidden="true"></i></span>
            <span><?php echo e($label); ?></span>
            <strong><?php echo e($value); ?></strong>
            <small><?php echo e($detail); ?></small>
        </article>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</section>

<?php if($page->readiness['unverifiedPacks'] > 0): ?>
    <div class="logic-guard-notice" role="status">
        <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
        <span><strong>Authoritative calculation guard is active.</strong> Unverified statutory packs can be reviewed and simulated, but cannot affect payroll until official-source evidence and independent approval are recorded.</span>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/scoring/partials/logic-overview.blade.php ENDPATH**/ ?>