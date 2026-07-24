<?php $__env->startSection('title', 'Employee Documents - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'Employee Documents','description' => $employee ? $employee->employee_code.' · '.$employee->name : 'Track private employee document versions, approvals, and expiry dates.','active' => 'documents'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if($employee): ?><a class="people-button" href="<?php echo e(route('hr.employees.show', $employee)); ?>"><i class="fa-solid fa-user" aria-hidden="true"></i> Employee 360</a><?php endif; ?>
        <a class="people-button" href="<?php echo e(route('documents.index')); ?>"><i class="fa-solid fa-folder-tree" aria-hidden="true"></i> Document workspace</a>
     <?php $__env->endSlot(); ?>

    <?php if(session('status')): ?><section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section><?php endif; ?>
    <?php if($errors->any()): ?>
        <section class="people-alert is-danger" role="alert" aria-labelledby="document-errors-title" tabindex="-1"><strong id="document-errors-title">Please correct the highlighted document fields.</strong><ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></section>
    <?php endif; ?>

    <section class="people-ops-kpis" aria-label="Document summary">
        <?php $__currentLoopData = [
            ['Total records', $summary->total, 'fa-folder-open', ''],
            ['Awaiting approval', $summary->submitted, 'fa-hourglass-half', 'is-warning'],
            ['Approved', $summary->approved, 'fa-circle-check', 'is-success'],
            ['Expiring in 30 days', $summary->expiringSoon, 'fa-calendar-exclamation', 'is-warning'],
            ['Expired', $summary->expired, 'fa-triangle-exclamation', 'is-danger'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value, $icon, $tone]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="people-ops-kpi <?php echo e($tone); ?>"><span class="people-ops-kpi-icon"><i class="fa-solid <?php echo e($icon); ?>" aria-hidden="true"></i></span><span><?php echo e($label); ?></span><strong><?php echo e(number_format($value)); ?></strong><small>Authorized document scope</small></article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </section>

    <?php if($employee && $abilities['canSubmit']): ?>
        <details class="people-edit-details" <?php if($errors->any()): ?> open <?php endif; ?>>
            <summary>Upload employee document</summary>
            <form method="POST" action="<?php echo e(route('hr.employees.documents.store', $employee)); ?>" enctype="multipart/form-data" class="people-form-grid people-edit-form" x-data="serverFormState" x-on:submit="beginSubmit" x-bind:aria-busy="busyAria" data-idle-label="Submit document" data-busy-label="Uploading…">
                <?php echo csrf_field(); ?>
                <label class="people-field"><span>Category</span><select class="people-control" name="document_category_id" required><option value="">Select category</option><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($category->id); ?>" <?php if((string) old('document_category_id') === (string) $category->id): echo 'selected'; endif; ?>><?php echo e($category->code); ?> · <?php echo e($category->name); ?><?php echo e($category->expiry_required ? ' / expiry required' : ''); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select><?php $__errorArgs = ['document_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field"><span>Document title</span><input class="people-control" name="title" value="<?php echo e(old('title')); ?>" maxlength="255" required><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field"><span>Issue date</span><input class="people-control" type="date" name="issue_date" value="<?php echo e(old('issue_date')); ?>" max="<?php echo e(now()->toDateString()); ?>"><?php $__errorArgs = ['issue_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field"><span>Expiry date</span><input class="people-control" type="date" name="expires_on" value="<?php echo e(old('expires_on')); ?>"><?php $__errorArgs = ['expires_on'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <label class="people-field is-wide"><span>Private document file</span><input class="people-control" type="file" name="document_file" required><small>Downloads remain protected by the document visibility policy.</small><?php $__errorArgs = ['document_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="people-field-error"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></label>
                <div class="people-modal-actions is-wide"><button class="people-button is-primary" type="submit" x-bind:disabled="busy"><span x-text="submitLabel">Submit document</span></button></div>
            </form>
        </details>
    <?php endif; ?>

    <section class="people-ops-panel has-mobile-cards" aria-labelledby="document-register-title">
        <header class="people-ops-panel-head"><div><h2 id="document-register-title">Document register</h2><p><?php echo e(number_format($documents->total())); ?> document<?php echo e($documents->total() === 1 ? '' : 's'); ?> match the current filters.</p></div></header>
        <form method="GET" action="<?php echo e($employee ? route('hr.employees.documents.index', $employee) : route('hr.employee-documents.index')); ?>" class="people-ops-filterbar" aria-label="Filter employee documents">
            <?php if (! ($employee)): ?>
                <label class="people-field"><span>Search</span><input class="people-control" type="search" name="search" value="<?php echo e(request('search')); ?>" placeholder="Document, employee or department"></label>
                <label class="people-field"><span>Employee</span><select class="people-control" name="employee_id"><option value="">All visible employees</option><?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($row->id); ?>" <?php if((string) request('employee_id') === (string) $row->id): echo 'selected'; endif; ?>><?php echo e($row->employee_code); ?> · <?php echo e($row->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
                <label class="people-field"><span>Category</span><select class="people-control" name="document_category_id"><option value="">All categories</option><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($category->id); ?>" <?php if((string) request('document_category_id') === (string) $category->id): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <?php endif; ?>
            <label class="people-field"><span>Status</span><select class="people-control" name="status"><option value="">All statuses</option><?php $__currentLoopData = ['submitted' => 'Submitted', 'approved' => 'Approved', 'rejected' => 'Rejected', 'archived' => 'Archived']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(request('status') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <label class="people-field"><span>Versions</span><select class="people-control" name="current_only"><option value="1" <?php if(request('current_only', '1') === '1'): echo 'selected'; endif; ?>>Current only</option><option value="0" <?php if(request('current_only') === '0'): echo 'selected'; endif; ?>>Current and previous</option></select></label>
            <label class="people-field"><span>Expiry window</span><select class="people-control" name="expires_within_days"><option value="">Any expiry</option><?php $__currentLoopData = [30, 60, 90]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $days): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($days); ?>" <?php if(request('expires_within_days') === (string) $days): echo 'selected'; endif; ?>>Next <?php echo e($days); ?> days</option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></label>
            <div class="people-modal-actions"><button class="people-button" type="submit">Apply filters</button><a class="people-button" href="<?php echo e($employee ? route('hr.employees.documents.index', $employee) : route('hr.employee-documents.index')); ?>">Clear</a></div>
        </form>

        <div class="people-ops-table-wrap">
            <table class="people-ops-table"><caption>Private employee document register</caption><thead><tr><th scope="col">Document</th><?php if (! ($employee)): ?><th scope="col">Employee</th><?php endif; ?><th scope="col">Category / version</th><th scope="col">Issue / expiry</th><th scope="col">Private file</th><th scope="col">Status</th><th scope="col" class="is-actions">Action</th></tr></thead><tbody>
            <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><strong><?php echo e($document->documentNumber); ?></strong><small><?php echo e($document->title); ?></small></td>
                    <?php if (! ($employee)): ?><td><div class="people-ops-identity"><span class="people-avatar"><?php echo e($document->employeeInitial); ?></span><div><strong><?php echo e($document->employeeName); ?></strong><small><?php echo e($document->employeeCode); ?> / <?php echo e($document->employeeContext); ?></small></div></div></td><?php endif; ?>
                    <td><?php echo e($document->category); ?><small>v<?php echo e($document->version); ?> / <?php echo e($document->isCurrent ? 'Current' : 'Previous'); ?></small></td>
                    <td><?php echo e($document->issueDate); ?><small><span class="people-status <?php echo e($document->expiryTone); ?>"><?php echo e($document->expiryState); ?></span> <?php echo e($document->expiryDate); ?></small></td>
                    <td><?php echo e($document->filename); ?><small><?php echo e($document->fileSize); ?></small></td>
                    <td><span class="people-status <?php echo e($document->statusTone); ?>"><?php echo e($document->statusLabel); ?></span></td>
                    <td class="is-actions"><?php echo $__env->make('hr.documents.partials.document-actions', ['document' => $document, 'actionContext' => 'desktop'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="<?php echo e($employee ? 6 : 7); ?>"><div class="people-ops-empty"><i class="fa-solid fa-folder-open" aria-hidden="true"></i><strong>No employee documents found</strong><span>Clear the filters or submit an authorized employee document.</span></div></td></tr><?php endif; ?>
            </tbody></table>
        </div>
        <div class="people-ops-mobile-list"><?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><article class="people-ops-mobile-card"><div class="people-ops-mobile-card-head"><strong><?php echo e($document->documentNumber); ?> / <?php echo e($document->title); ?></strong><span class="people-status <?php echo e($document->statusTone); ?>"><?php echo e($document->statusLabel); ?></span></div><dl class="people-ops-mobile-facts"><div><dt>Employee</dt><dd><?php echo e($document->employeeName); ?></dd></div><div><dt>Category</dt><dd><?php echo e($document->category); ?> / v<?php echo e($document->version); ?></dd></div><div><dt>Expiry</dt><dd><?php echo e($document->expiryDate); ?> / <?php echo e($document->expiryState); ?></dd></div><div><dt>File</dt><dd><?php echo e($document->filename); ?> / <?php echo e($document->fileSize); ?></dd></div></dl><div class="people-ops-mobile-actions"><?php echo $__env->make('hr.documents.partials.document-actions', ['document' => $document, 'actionContext' => 'mobile'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div></article><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
        <div class="people-pagination"><?php echo e($documents->withQueryString()->links()); ?></div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9)): ?>
<?php $attributes = $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9; ?>
<?php unset($__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9)): ?>
<?php $component = $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9; ?>
<?php unset($__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/hr/documents/index.blade.php ENDPATH**/ ?>