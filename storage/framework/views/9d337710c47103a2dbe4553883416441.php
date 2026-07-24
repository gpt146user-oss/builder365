<?php $__env->startSection('title', $workspacePageTitle); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('hr.operations.partials.people-workspace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/developer/public_html/builder360/resources/views/hr/operations/workspace.blade.php ENDPATH**/ ?>