<h1><?php echo e($change === 'cancel' ? 'Event cancelled' : 'Calendar invitation'); ?></h1>
<p><strong><?php echo e($event->title); ?></strong></p>
<p><?php echo e($event->starts_at->setTimezone($event->timezone)->format('D, d M Y g:i A T')); ?> – <?php echo e($event->ends_at->setTimezone($event->timezone)->format('g:i A T')); ?></p>
<?php if($event->location): ?><p>Location: <?php echo e($event->location); ?></p><?php endif; ?>
<?php if($change !== 'cancel'): ?><p><a href="<?php echo e($responseUrl); ?>">Respond to this invitation</a></p><?php endif; ?>
<p>This link shows invitation details only and does not provide Builder360 access.</p>
<?php /**PATH D:\builder360\resources\views/mail/calendar-invitation.blade.php ENDPATH**/ ?>