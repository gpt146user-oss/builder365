

<?php $__env->startSection('title', 'Data Imports - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $previewCount = $batches->getCollection()->where('status', \App\Models\DataImportBatch::STATUS_PREVIEW)->count();
        $postedCount = $batches->getCollection()->where('status', \App\Models\DataImportBatch::STATUS_POSTED)->count();
        $invalidRows = $batches->getCollection()->sum('invalid_rows');
    ?>

    <div class="blade-workspace" aria-labelledby="data-imports-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Administration</p>
                <h1 id="data-imports-title">Data Import Center</h1>
                <p>
                    Workspace for CSV import preview, row validation,
                    duplicate/file checksum control, reconciliation summary, error reporting and controlled posting.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Settings navigation">
                <a href="<?php echo e(url('/')); ?>">Dashboard</a>
                <a href="<?php echo e(route('settings.system-settings.index')); ?>">System Settings</a>
                <a href="<?php echo e(route('admin.users.index')); ?>">Users</a>
                <a href="<?php echo e(route('governance.audit-events.index')); ?>">Activity History</a>
                <a href="<?php echo e(route('settings.data-imports.index')); ?>">Reset filters</a>
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

        <section class="blade-dashboard-kpis" aria-label="Import KPIs">
            <article class="blade-dashboard-kpi">
                <span>Total Batches</span>
                <strong><?php echo e(number_format($batches->total())); ?></strong>
                <small>Import register</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Preview</span>
                <strong><?php echo e(number_format($previewCount)); ?></strong>
                <small>Awaiting post/review</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Posted</span>
                <strong><?php echo e(number_format($postedCount)); ?></strong>
                <small>Current page</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Invalid Rows</span>
                <strong><?php echo e(number_format($invalidRows)); ?></strong>
                <small>Current page</small>
            </article>
        </section>

        <section class="blade-workspace-grid">
            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Preview</span>
                        <h2>Upload CSV for validation</h2>
                    </div>
                    <small><?php echo e($canCreateImport ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateImport): ?>
                    <form method="POST" action="<?php echo e(route('settings.data-imports.preview')); ?>" enctype="multipart/form-data" class="blade-form-grid">
                        <?php echo csrf_field(); ?>
                        <?php if (isset($component)) { $__componentOriginal5ee006ce6757c21855df609df2a8580f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5ee006ce6757c21855df609df2a8580f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.company-context','data' => ['companies' => $companies,'placeholder' => 'Select company if required']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.company-context'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['companies' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($companies),'placeholder' => 'Select company if required']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5ee006ce6757c21855df609df2a8580f)): ?>
<?php $attributes = $__attributesOriginal5ee006ce6757c21855df609df2a8580f; ?>
<?php unset($__attributesOriginal5ee006ce6757c21855df609df2a8580f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5ee006ce6757c21855df609df2a8580f)): ?>
<?php $component = $__componentOriginal5ee006ce6757c21855df609df2a8580f; ?>
<?php unset($__componentOriginal5ee006ce6757c21855df609df2a8580f); ?>
<?php endif; ?>
                        <label>
                            Import type
                            <select name="import_type" required>
                                <?php $__currentLoopData = $importTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('import_type') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>
                        <label class="blade-form-wide">
                            CSV source file
                            <input type="file" name="source_file" accept=".csv,.txt,text/csv,text/plain" required>
                            <small>CSV/TXT only. Max 512 KB. Preview validates every row before posting.</small>
                        </label>
                        <label class="blade-form-wide">
                            Note
                            <textarea name="note" rows="3" maxlength="1000"><?php echo e(old('note')); ?></textarea>
                        </label>
                        <button type="submit" class="blade-primary-action">Generate preview</button>
                    </form>
                <?php else: ?>
                    <p class="blade-muted">This role can view imports but cannot upload new data batches.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Import filters</h2>
                    </div>
                    <small><?php echo e(number_format($batches->total())); ?> batch(es)</small>
                </div>

                <form method="GET" action="<?php echo e(route('settings.data-imports.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                    <?php if (isset($component)) { $__componentOriginal5ee006ce6757c21855df609df2a8580f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5ee006ce6757c21855df609df2a8580f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.company-context','data' => ['companies' => $companies,'selected' => $filters['company_id'] ?? null,'placeholder' => 'All companies']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.company-context'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['companies' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($companies),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filters['company_id'] ?? null),'placeholder' => 'All companies']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5ee006ce6757c21855df609df2a8580f)): ?>
<?php $attributes = $__attributesOriginal5ee006ce6757c21855df609df2a8580f; ?>
<?php unset($__attributesOriginal5ee006ce6757c21855df609df2a8580f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5ee006ce6757c21855df609df2a8580f)): ?>
<?php $component = $__componentOriginal5ee006ce6757c21855df609df2a8580f; ?>
<?php unset($__componentOriginal5ee006ce6757c21855df609df2a8580f); ?>
<?php endif; ?>
                    <label>
                        Import type
                        <select name="import_type">
                            <option value="">All types</option>
                            <?php $__currentLoopData = $importTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['import_type'] ?? null) === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
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
                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Imports</span>
                    <h2>Import batch register</h2>
                </div>
                <small><?php echo e($batches->firstItem() ?? 0); ?>-<?php echo e($batches->lastItem() ?? 0); ?> of <?php echo e($batches->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Batch</th>
                            <th scope="col">Rows</th>
                            <th scope="col">Reconciliation</th>
                            <th scope="col">Errors</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($batch->import_number); ?></strong>
                                    <span><?php echo e($importTypes[$batch->import_type] ?? $batch->import_type); ?></span>
                                    <small><?php echo e($batch->source_filename); ?> · <?php echo e($batch->company?->code); ?></small>
                                    <small>Created by <?php echo e($batch->createdBy?->name ?? 'System'); ?></small>
                                </td>
                                <td>
                                    <span>Total: <?php echo e(number_format((int) $batch->total_rows)); ?></span>
                                    <small>Valid: <?php echo e(number_format((int) $batch->valid_rows)); ?> · Invalid: <?php echo e(number_format((int) $batch->invalid_rows)); ?></small>
                                </td>
                                <td>
                                    <small><?php echo e(\Illuminate\Support\Str::limit(json_encode($batch->reconciliation_summary ?? [], JSON_UNESCAPED_SLASHES), 180)); ?></small>
                                </td>
                                <td>
                                    <?php if(($batch->error_report ?? []) !== []): ?>
                                        <?php $__currentLoopData = collect($batch->error_report)->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <small>Row <?php echo e($error['row_number'] ?? '?'); ?>: <?php echo e(\Illuminate\Support\Str::limit(implode('; ', $error['errors'] ?? []), 100)); ?></small>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <span class="blade-muted">No row errors</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="blade-status-pill"><?php echo e($statuses[$batch->status] ?? $batch->status); ?></span>
                                    <?php if($batch->posted_at): ?>
                                        <small>Posted <?php echo e($batch->posted_at->format('d M Y, h:i A')); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('post', $batch)): ?>
                                        <?php if($batch->status === \App\Models\DataImportBatch::STATUS_PREVIEW && (int) $batch->invalid_rows === 0): ?>
                                            <form method="POST" action="<?php echo e(route('settings.data-imports.post', $batch)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <input type="text" name="note" placeholder="Posting note" maxlength="1000">
                                                <button type="submit" class="blade-primary-action">Post import</button>
                                            </form>
                                        <?php elseif($batch->status === \App\Models\DataImportBatch::STATUS_PREVIEW): ?>
                                            <span class="blade-muted">Resolve invalid rows before posting</span>
                                        <?php else: ?>
                                            <span class="blade-muted">No posting action</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="blade-muted">No post access</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6">No import batches found for the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php echo e($batches->links()); ?>

        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\settings\data-imports\index.blade.php ENDPATH**/ ?>