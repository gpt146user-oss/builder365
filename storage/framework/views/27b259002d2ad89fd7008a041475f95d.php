<?php $__env->startSection('title', 'My Bookings - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<div class="blade-workspace" aria-labelledby="buyer-bookings-title">
    <header class="blade-workspace-header">
        <div><p class="blade-dashboard-eyebrow">Buyer Portal</p><h1 id="buyer-bookings-title">My Bookings</h1><p>Booking, project, unit and payment schedule details available to your account.</p></div>
        <?php echo $__env->make('buyer.partials.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </header>
    <section class="blade-dashboard-card">
        <form method="GET" action="<?php echo e(route('buyer.bookings.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
            <label>Status<select name="status"><option value="">All statuses</option><?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <button class="blade-secondary-action" type="submit">Apply filter</button>
            <a class="blade-secondary-action" href="<?php echo e(route('buyer.bookings.index')); ?>">Reset</a>
        </form>
    </section>
    <section class="blade-dashboard-card">
        <div class="blade-dashboard-section-title"><div><span class="blade-dashboard-label">Bookings</span><h2>Booking register</h2></div><small><?php echo e($records->total()); ?> record(s)</small></div>
        <div class="blade-dashboard-table-wrap"><table class="blade-dashboard-table"><thead><tr><th>Booking</th><th>Project</th><th>Unit</th><th>Booked On</th><th>Net Receivable</th><th>Status</th></tr></thead><tbody>
        <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><strong><?php echo e($booking->booking_code); ?></strong></td><td><?php echo e($booking->project?->name ?? '—'); ?></td><td><?php echo e($booking->unit?->unit_code ?? '—'); ?></td><td><?php echo e($booking->booked_on?->format('d M Y') ?? '—'); ?></td><td>₹<?php echo e(number_format((float) $booking->net_receivable, 2)); ?></td><td><span class="blade-status-pill"><?php echo e($statuses[$booking->status] ?? ucfirst($booking->status)); ?></span></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="6">No bookings are available for this account.</td></tr><?php endif; ?>
        </tbody></table></div><div class="blade-pagination"><?php echo e($records->links()); ?></div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\buyer\bookings.blade.php ENDPATH**/ ?>