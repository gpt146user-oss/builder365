

<?php $__env->startSection('title', 'Financial Vouchers - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $money = fn ($amount) => 'Rs. '.number_format((float) ($amount ?? 0), 2);
    ?>

    <div class="blade-workspace" aria-labelledby="financial-vouchers-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Finance and Operations</p>
                <h1 id="financial-vouchers-title">Financial Vouchers</h1>
                <p>
                    Workspace for voucher entry, balanced debit/credit lines,
                    project/company access, approval/rejection workflow, tax summary and status transition history.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('finance.dashboard')); ?>">Finance Dashboard</a>
                <a href="<?php echo e(route('finance.collections.index')); ?>">Collections</a>
                <a href="<?php echo e(route('finance.vouchers.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status">
                <?php echo e(session('status')); ?>

            </section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Voucher action was not saved.</strong>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </section>
        <?php endif; ?>

        <section class="blade-workspace-grid">
            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Create</span>
                        <h2>Submit voucher</h2>
                    </div>
                    <small><?php echo e($canCreateVoucher ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateVoucher): ?>
                    <form method="POST" action="<?php echo e(route('finance.vouchers.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <?php if (isset($component)) { $__componentOriginal5ee006ce6757c21855df609df2a8580f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5ee006ce6757c21855df609df2a8580f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.company-context','data' => ['companies' => $companies,'placeholder' => 'Use selected project or company']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.company-context'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['companies' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($companies),'placeholder' => 'Use selected project or company']); ?>
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
                            Project
                            <select name="project_id">
                                <option value="">Company-level voucher</option>
                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($project->id); ?>" <?php if((string) old('project_id') === (string) $project->id): echo 'selected'; endif; ?>>
                                        <?php echo e($project->code); ?> - <?php echo e($project->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Voucher type
                            <select name="voucher_type" required>
                                <?php $__currentLoopData = $voucherTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('voucher_type', 'journal') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Voucher date
                            <input type="date" name="voucher_date" value="<?php echo e(old('voucher_date', now()->toDateString())); ?>" required>
                        </label>

                        <label>
                            Reference number
                            <input type="text" name="reference_number" value="<?php echo e(old('reference_number')); ?>" maxlength="120">
                        </label>

                        <label>
                            Currency
                            <input type="text" name="currency" value="<?php echo e(old('currency', 'INR')); ?>" maxlength="3">
                        </label>

                        <label class="blade-form-wide">
                            Narration
                            <textarea name="narration" maxlength="5000" rows="3" required><?php echo e(old('narration')); ?></textarea>
                        </label>

                        <fieldset class="blade-form-wide blade-fieldset">
                            <legend>Debit line</legend>
                            <div class="blade-form-grid">
                                <input type="hidden" name="lines[0][line_type]" value="debit">
                                <label>
                                    Account code
                                    <input type="text" name="lines[0][account_code]" value="<?php echo e(old('lines.0.account_code', 'EXPENSE')); ?>" maxlength="64" required>
                                </label>
                                <label>
                                    Account name
                                    <input type="text" name="lines[0][account_name]" value="<?php echo e(old('lines.0.account_name', 'Expense Account')); ?>" maxlength="255" required>
                                </label>
                                <label>
                                    Amount
                                    <input type="number" name="lines[0][amount]" value="<?php echo e(old('lines.0.amount')); ?>" min="0.01" step="0.01" required>
                                </label>
                                <label>
                                    Project
                                    <select name="lines[0][project_id]">
                                        <option value="">Use voucher project</option>
                                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($project->id); ?>" <?php if((string) old('lines.0.project_id') === (string) $project->id): echo 'selected'; endif; ?>><?php echo e($project->code); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </label>
                                <label>
                                    Tax rate %
                                    <input type="number" name="lines[0][tax_rate]" value="<?php echo e(old('lines.0.tax_rate', 0)); ?>" min="0" max="100" step="0.01">
                                </label>
                                <label>
                                    Tax amount
                                    <input type="number" name="lines[0][tax_amount]" value="<?php echo e(old('lines.0.tax_amount', 0)); ?>" min="0" step="0.01">
                                </label>
                            </div>
                        </fieldset>

                        <fieldset class="blade-form-wide blade-fieldset">
                            <legend>Credit line</legend>
                            <div class="blade-form-grid">
                                <input type="hidden" name="lines[1][line_type]" value="credit">
                                <label>
                                    Account code
                                    <input type="text" name="lines[1][account_code]" value="<?php echo e(old('lines.1.account_code', 'BANK')); ?>" maxlength="64" required>
                                </label>
                                <label>
                                    Account name
                                    <input type="text" name="lines[1][account_name]" value="<?php echo e(old('lines.1.account_name', 'Bank Account')); ?>" maxlength="255" required>
                                </label>
                                <label>
                                    Amount
                                    <input type="number" name="lines[1][amount]" value="<?php echo e(old('lines.1.amount')); ?>" min="0.01" step="0.01" required>
                                </label>
                                <label>
                                    Project
                                    <select name="lines[1][project_id]">
                                        <option value="">Use voucher project</option>
                                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($project->id); ?>" <?php if((string) old('lines.1.project_id') === (string) $project->id): echo 'selected'; endif; ?>><?php echo e($project->code); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </label>
                                <label class="blade-form-wide">
                                    Description
                                    <input type="text" name="lines[1][description]" value="<?php echo e(old('lines.1.description')); ?>" maxlength="1000">
                                </label>
                            </div>
                        </fieldset>

                        <button type="submit" class="blade-primary-action">Submit voucher</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view vouchers but cannot create new vouchers.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Voucher filters</h2>
                    </div>
                    <small><?php echo e($vouchers->total()); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('finance.vouchers.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                    <label>
                        Status
                        <select name="status">
                            <option value="">All statuses</option>
                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <label>
                        Type
                        <select name="voucher_type">
                            <option value="">All types</option>
                            <?php $__currentLoopData = $voucherTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['voucher_type'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <label>
                        Project
                        <select name="project_id">
                            <option value="">All projects</option>
                            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($project->id); ?>" <?php if((string) ($filters['project_id'] ?? '') === (string) $project->id): echo 'selected'; endif; ?>><?php echo e($project->code); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                    <label>
                        From
                        <input type="date" name="date_from" value="<?php echo e($filters['date_from'] ?? ''); ?>">
                    </label>
                    <label>
                        To
                        <input type="date" name="date_to" value="<?php echo e($filters['date_to'] ?? ''); ?>">
                    </label>
                    <label>
                        Search
                        <input type="search" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" maxlength="120" placeholder="Voucher, ref, narration">
                    </label>
                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>

                <p class="blade-workspace-note">
                    Voucher submission and approval use the configured finance workflow. Debit and credit totals must balance.
                </p>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Voucher register</h2>
                </div>
                <small><?php echo e($vouchers->firstItem() ?? 0); ?>-<?php echo e($vouchers->lastItem() ?? 0); ?> of <?php echo e($vouchers->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Voucher</th>
                            <th scope="col">Scope</th>
                            <th scope="col">Commercials</th>
                            <th scope="col">Lines</th>
                            <th scope="col">Workflow</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voucher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($voucher->voucher_number); ?></strong>
                                    <span><?php echo e($voucherTypes[$voucher->voucher_type] ?? str($voucher->voucher_type)->headline()); ?></span>
                                    <span><?php echo e($voucher->voucher_date?->format('d M Y') ?? 'Date pending'); ?></span>
                                    <span><?php echo e($voucher->reference_number ?? 'No reference'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($voucher->company?->code ?? 'Company missing'); ?></strong>
                                    <span><?php echo e($voucher->project?->code ?? 'Company level'); ?></span>
                                </td>
                                <td>
                                    <strong>Debit <?php echo e($money($voucher->total_debit)); ?></strong>
                                    <span>Credit <?php echo e($money($voucher->total_credit)); ?></span>
                                    <span>Tax <?php echo e($money($voucher->tax_summary['total_tax_amount'] ?? 0)); ?></span>
                                </td>
                                <td>
                                    <?php $__empty_2 = true; $__currentLoopData = $voucher->lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <span>
                                            <?php echo e($line->line_number); ?>.
                                            <?php echo e(str($line->line_type)->headline()); ?>

                                            <?php echo e($line->account_code); ?> -
                                            <?php echo e($money($line->amount)); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <span>No lines</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong>Created by <?php echo e($voucher->createdBy?->name ?? 'User missing'); ?></strong>
                                    <span>Approved by <?php echo e($voucher->approvedBy?->name ?? 'Pending'); ?></span>
                                    <span><?php echo e($voucher->approved_at?->format('d M Y H:i') ?? $voucher->rejected_at?->format('d M Y H:i') ?? 'Decision pending'); ?></span>
                                </td>
                                <td><?php echo e($statuses[$voucher->status] ?? str($voucher->status)->headline()); ?></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve', $voucher)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Approve</summary>
                                            <form method="POST" action="<?php echo e(route('finance.vouchers.approve', $voucher)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <textarea name="note" maxlength="1000" rows="2" placeholder="Approval note"></textarea>
                                                <button type="submit" class="blade-primary-action">Approve voucher</button>
                                            </form>
                                        </details>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('reject', $voucher)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Reject</summary>
                                            <form method="POST" action="<?php echo e(route('finance.vouchers.reject', $voucher)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <textarea name="reason" required maxlength="1000" rows="2" placeholder="Rejection reason"></textarea>
                                                <button type="submit" class="blade-secondary-action">Reject voucher</button>
                                            </form>
                                        </details>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('approve', $voucher)): ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('reject', $voucher)): ?>
                                            <span>No action</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No vouchers match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination">
                <?php echo e($vouchers->links()); ?>

            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/finance/vouchers/index.blade.php ENDPATH**/ ?>