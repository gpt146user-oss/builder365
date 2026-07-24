

<?php $__env->startSection('title', 'Document Repository - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $submittedCount = $documents->getCollection()->where('status', 'submitted')->count();
        $approvedCount = $documents->getCollection()->where('status', 'approved')->count();
        $expiringCount = $documents->getCollection()->filter(fn ($document) => $document->isExpiringWithin(30))->count();
        $expiredCount = $documents->getCollection()->filter(fn ($document) => $document->isExpired())->count();
    ?>

    <div class="blade-workspace" aria-labelledby="document-repository-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Document Management</p>
                <h1 id="document-repository-title">Document Repository</h1>
                <p>
                    Secure document repository for controlled document uploads, category rules,
                    versioning, expiry tracking, role-based approval, secure downloads and activity history.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Document navigation">
                <a href="<?php echo e(url('/')); ?>">Dashboard</a>
                <a href="<?php echo e(route('documents.categories.index')); ?>">Document Categories</a>
                <a href="<?php echo e(route('documents.index', ['expires_within_days' => 30])); ?>">Expiring in 30 days</a>
                <a href="<?php echo e(route('documents.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <div class="blade-alert blade-alert-success"><?php echo e(session('status')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="blade-alert blade-alert-danger">
                <strong>Check the highlighted inputs.</strong>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <section class="blade-dashboard-kpis" aria-label="Document KPIs">
            <article class="blade-dashboard-kpi">
                <span>Total Documents</span>
                <strong><?php echo e(number_format($documents->total())); ?></strong>
                <small>Document register</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Submitted</span>
                <strong><?php echo e(number_format($submittedCount)); ?></strong>
                <small>Current page</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Approved</span>
                <strong><?php echo e(number_format($approvedCount)); ?></strong>
                <small>Current page</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Expiry Attention</span>
                <strong><?php echo e(number_format($expiringCount + $expiredCount)); ?></strong>
                <small>Expiring/expired on page</small>
            </article>
        </section>

        <section class="blade-workspace-grid">
            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Upload</span>
                        <h2>Submit managed document</h2>
                    </div>
                    <small><?php echo e($canCreateDocument ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateDocument): ?>
                    <form method="POST" action="<?php echo e(route('documents.store')); ?>" enctype="multipart/form-data" class="blade-form-grid">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="_return_to" value="documents.index">
                        <input type="hidden" name="storage_disk" value="local">
                        <input type="hidden" name="metadata[source]" value="document_repository_blade">
                        <label class="blade-form-wide">
                            Document category
                            <select name="document_category_id" required>
                                <option value="">Select category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php if((int) old('document_category_id') === (int) $category->id): echo 'selected'; endif; ?>>
                                        <?php echo e($category->code); ?> · <?php echo e($category->name); ?> · <?php echo e($category->owner_type); ?>

                                        <?php if($category->expiry_required): ?>
                                            · expiry required
                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>
                        <label class="blade-form-wide">
                            Title
                            <input type="text" name="title" value="<?php echo e(old('title')); ?>" maxlength="255" required>
                        </label>
                        <label>
                            Owner type
                            <select name="owner_type" required>
                                <option value="">Select owner type</option>
                                <?php $__currentLoopData = $ownerTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('owner_type') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>
                        <label>
                            Owner record
                            <select name="owner_id" required>
                                <option value="">Select owner after matching owner type</option>
                                <optgroup label="Projects">
                                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($project->id); ?>" <?php if((int) old('owner_id') === (int) $project->id && old('owner_type') === 'project'): echo 'selected'; endif; ?>>
                                            #<?php echo e($project->id); ?> · <?php echo e($project->code); ?> · <?php echo e($project->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </optgroup>
                                <optgroup label="Bookings">
                                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($booking->id); ?>" <?php if((int) old('owner_id') === (int) $booking->id && old('owner_type') === 'booking'): echo 'selected'; endif; ?>>
                                            #<?php echo e($booking->id); ?> · <?php echo e($booking->booking_code); ?> <?php if($booking->customer): ?> · <?php echo e($booking->customer->name); ?> <?php endif; ?>
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </optgroup>
                                <optgroup label="Customers">
                                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($customer->id); ?>" <?php if((int) old('owner_id') === (int) $customer->id && old('owner_type') === 'customer'): echo 'selected'; endif; ?>>
                                            #<?php echo e($customer->id); ?> · <?php echo e($customer->code); ?> · <?php echo e($customer->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </optgroup>
                                <optgroup label="Employees">
                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($employee->id); ?>" <?php if((int) old('owner_id') === (int) $employee->id && old('owner_type') === 'employee'): echo 'selected'; endif; ?>>
                                            #<?php echo e($employee->id); ?> · <?php echo e($employee->employee_code); ?> · <?php echo e($employee->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </optgroup>
                            </select>
                            <small>Owner type and owner record must match; validation blocks mismatches.</small>
                        </label>
                        <label>
                            Issue date
                            <input type="date" name="issue_date" value="<?php echo e(old('issue_date')); ?>">
                        </label>
                        <label>
                            Expiry date
                            <input type="date" name="expires_on" value="<?php echo e(old('expires_on')); ?>">
                        </label>
                        <label class="blade-form-wide">
                            Document file
                            <input type="file" name="document_file" required>
                            <small>Allowed file type and size are enforced by configured document policy.</small>
                        </label>
                        <button type="submit" class="blade-primary-action">Submit document</button>
                    </form>
                <?php else: ?>
                    <p class="blade-muted">This role can view documents but cannot submit new managed documents.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Repository filters</h2>
                    </div>
                    <small><?php echo e(number_format($documents->total())); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('documents.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                    <label>
                        Owner type
                        <select name="owner_type">
                            <option value="">All owner types</option>
                            <?php $__currentLoopData = $ownerTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['owner_type'] ?? null) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <label>
                        Category
                        <select name="document_category_id">
                            <option value="">All categories</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php if(($filters['document_category_id'] ?? null) == $category->id): echo 'selected'; endif; ?>><?php echo e($category->code); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <label>
                        Status
                        <select name="status">
                            <option value="">All statuses</option>
                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? null) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <label>
                        Versions
                        <select name="current_only">
                            <option value="1" <?php if((string) ($filters['current_only'] ?? '1') === '1'): echo 'selected'; endif; ?>>Current only</option>
                            <option value="0" <?php if((string) ($filters['current_only'] ?? '1') === '0'): echo 'selected'; endif; ?>>All versions</option>
                        </select>
                    </label>
                    <label>
                        Expires within days
                        <input type="number" name="expires_within_days" min="1" max="3650" value="<?php echo e($filters['expires_within_days'] ?? ''); ?>">
                    </label>
                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Repository</span>
                    <h2>Document register</h2>
                </div>
                <small><?php echo e($documents->firstItem() ?? 0); ?>-<?php echo e($documents->lastItem() ?? 0); ?> of <?php echo e($documents->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Document</th>
                            <th scope="col">Owner</th>
                            <th scope="col">Category</th>
                            <th scope="col">Version</th>
                            <th scope="col">Expiry</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($document->document_number); ?></strong>
                                    <span><?php echo e($document->title); ?></span>
                                    <small><?php echo e($document->original_filename); ?> · <?php echo e(number_format((int) $document->file_size_bytes)); ?> bytes</small>
                                </td>
                                <td>
                                    <span><?php echo e($ownerTypes[$document->owner_type] ?? $document->owner_type); ?></span>
                                    <small>Record #<?php echo e($document->owner_id); ?></small>
                                </td>
                                <td>
                                    <span><?php echo e($document->category?->code ?? 'Uncategorised'); ?></span>
                                    <small><?php echo e($document->category?->name); ?></small>
                                </td>
                                <td>
                                    <span>v<?php echo e($document->version); ?></span>
                                    <small><?php echo e($document->is_current ? 'Current' : 'Historical'); ?></small>
                                </td>
                                <td>
                                    <?php if($document->expires_on): ?>
                                        <span><?php echo e($document->expires_on->format('d M Y')); ?></span>
                                        <?php if($document->isExpired()): ?>
                                            <small>Expired</small>
                                        <?php elseif($document->isExpiringWithin(30)): ?>
                                            <small>Expiring within 30 days</small>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span>No expiry</span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="blade-status-pill"><?php echo e($statuses[$document->status] ?? $document->status); ?></span></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view', $document)): ?>
                                        <a href="<?php echo e(route('documents.download', $document)); ?>" class="blade-secondary-action">Download</a>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve', $document)): ?>
                                        <form method="POST" action="<?php echo e(route('documents.approve', $document)); ?>" class="blade-inline-form">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <input type="hidden" name="_return_to" value="documents.index">
                                            <input type="text" name="approval_note" placeholder="Approval note" maxlength="2000">
                                            <button type="submit" class="blade-primary-action">Approve</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No documents found for the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php echo e($documents->links()); ?>

        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/developer/public_html/builder360/resources/views/documents/managed-documents/index.blade.php ENDPATH**/ ?>