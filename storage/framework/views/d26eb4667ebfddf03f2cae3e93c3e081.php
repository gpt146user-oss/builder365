<form method="POST" action="<?php echo e(route('hr.exit-interviews.review',$interview)); ?>" class="people-form-grid"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
    <label class="people-field is-wide"><span>HR review notes</span><textarea class="people-control" name="hr_review_notes" required></textarea></label>
    <label class="people-field"><span>Action owner</span><input class="people-control" name="action_items[0][owner]"></label>
    <label class="people-field"><span>Follow-up action</span><input class="people-control" name="action_items[0][action]"></label>
    <label class="people-field"><span>Action due date</span><input class="people-control" type="date" name="action_items[0][due_on]"></label>
    <button class="people-button is-primary" type="submit">Complete HR review</button>
</form>
<?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/hr/exit-interviews/partials/review-form.blade.php ENDPATH**/ ?>