

<?php $__env->startSection('title', 'GST Entries - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $money = fn ($amount) => 'Rs. '.number_format((float) ($amount ?? 0), 2);
    ?>

    <div class="blade-workspace" aria-labelledby="gst-entries-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Finance and Compliance</p>
                <h1 id="gst-entries-title">GST Entry Register</h1>
                <p>
                    Workspace for GST input/output entries, period scoping,
                    maker-checker approval, locked-period protection and compliance activity history.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('finance.dashboard')); ?>">Finance Dashboard</a>
                <a href="<?php echo e(route('finance.vouchers.index')); ?>">Vouchers</a>
                <a href="<?php echo e(route('finance.gst-return-periods.index')); ?>">Return Periods</a>
                <a href="<?php echo e(route('finance.gst-entries.index')); ?>">Reset filters</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status"><?php echo e(session('status')); ?></section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>GST entry action was not saved.</strong>
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
                        <h2>Submit GST entry</h2>
                    </div>
                    <small><?php echo e($canCreateEntry ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateEntry): ?>
                    <form method="POST" action="<?php echo e(route('finance.gst-entries.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <label>
                            Project
                            <select name="project_id">
                                <option value="">Company-level GST entry</option>
                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($project->id); ?>" <?php if((string) old('project_id') === (string) $project->id): echo 'selected'; endif; ?>>
                                        <?php echo e($project->code); ?> - <?php echo e($project->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Document date
                            <input type="date" name="document_date" value="<?php echo e(old('document_date', now()->toDateString())); ?>" required>
                        </label>

                        <label>
                            Document number
                            <input type="text" name="document_number" value="<?php echo e(old('document_number')); ?>" maxlength="80" required>
                        </label>

                        <label>
                            Transaction type
                            <select name="transaction_type" required>
                                <?php $__currentLoopData = $transactionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('transaction_type', 'output') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Party name
                            <input type="text" name="party_name" value="<?php echo e(old('party_name')); ?>" maxlength="180" required>
                        </label>

                        <label>
                            Party GSTIN
                            <input type="text" name="party_gstin" value="<?php echo e(old('party_gstin')); ?>" maxlength="20" placeholder="27AABCP9876H1Z7">
                        </label>

                        <label>
                            Place of supply state
                            <input type="text" name="place_of_supply_state" value="<?php echo e(old('place_of_supply_state', 'MH')); ?>" minlength="2" maxlength="2" required>
                        </label>

                        <label>
                            HSN / SAC
                            <input type="text" name="hsn_sac" value="<?php echo e(old('hsn_sac')); ?>" maxlength="20">
                        </label>

                        <label>
                            Taxable amount
                            <input type="number" name="taxable_amount" value="<?php echo e(old('taxable_amount')); ?>" min="0.01" step="0.01" required>
                        </label>

                        <label>
                            Tax rate %
                            <input type="number" name="tax_rate" value="<?php echo e(old('tax_rate', 18)); ?>" min="0" max="40" step="0.01" required>
                        </label>

                        <label>
                            CGST
                            <input type="number" name="cgst_amount" value="<?php echo e(old('cgst_amount', 0)); ?>" min="0" step="0.01">
                        </label>

                        <label>
                            SGST
                            <input type="number" name="sgst_amount" value="<?php echo e(old('sgst_amount', 0)); ?>" min="0" step="0.01">
                        </label>

                        <label>
                            IGST
                            <input type="number" name="igst_amount" value="<?php echo e(old('igst_amount', 0)); ?>" min="0" step="0.01">
                        </label>

                        <label>
                            Cess
                            <input type="number" name="cess_amount" value="<?php echo e(old('cess_amount', 0)); ?>" min="0" step="0.01">
                        </label>

                        <button type="submit" class="blade-primary-action">Submit GST entry</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view GST entries but cannot create new entries.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>GST filters</h2>
                    </div>
                    <small><?php echo e($entries->total()); ?> record(s)</small>
                </div>

                <form method="GET" action="<?php echo e(route('finance.gst-entries.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
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
                        <select name="transaction_type">
                            <option value="">All types</option>
                            <?php $__currentLoopData = $transactionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>" <?php if(($filters['transaction_type'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
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
                        Year
                        <input type="number" name="period_year" value="<?php echo e($filters['period_year'] ?? ''); ?>" min="2020" max="2100">
                    </label>
                    <label>
                        Month
                        <input type="number" name="period_month" value="<?php echo e($filters['period_month'] ?? ''); ?>" min="1" max="12">
                    </label>
                    <label>
                        Search
                        <input type="search" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" maxlength="120" placeholder="Entry, document, party, GSTIN">
                    </label>
                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>

                <p class="blade-workspace-note">
                    Component tax must match taxable amount and tax rate within configured tolerance.
                    Production filing remains subject to client-appointed tax expert validation.
                </p>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>GST entries</h2>
                </div>
                <small><?php echo e($entries->firstItem() ?? 0); ?>-<?php echo e($entries->lastItem() ?? 0); ?> of <?php echo e($entries->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Entry</th>
                            <th scope="col">Party / document</th>
                            <th scope="col">Period / project</th>
                            <th scope="col">Tax values</th>
                            <th scope="col">Workflow</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($entry->entry_number); ?></strong>
                                    <span><?php echo e($transactionTypes[$entry->transaction_type] ?? str($entry->transaction_type)->headline()); ?></span>
                                    <span><?php echo e($entry->document_date?->format('d M Y') ?? 'Date pending'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($entry->party_name); ?></strong>
                                    <span><?php echo e($entry->document_number); ?></span>
                                    <span><?php echo e($entry->party_gstin ?? 'GSTIN not captured'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e(sprintf('%04d-%02d', $entry->period_year, $entry->period_month)); ?></strong>
                                    <span><?php echo e($entry->project?->code ?? 'Company level'); ?></span>
                                    <span>State <?php echo e($entry->place_of_supply_state); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($money($entry->total_tax_amount)); ?></strong>
                                    <span>Taxable <?php echo e($money($entry->taxable_amount)); ?></span>
                                    <span>CGST <?php echo e($money($entry->cgst_amount)); ?> / SGST <?php echo e($money($entry->sgst_amount)); ?></span>
                                    <span>IGST <?php echo e($money($entry->igst_amount)); ?> / Cess <?php echo e($money($entry->cess_amount)); ?></span>
                                </td>
                                <td>
                                    <strong>Created by <?php echo e($entry->createdBy?->name ?? 'User missing'); ?></strong>
                                    <span>Approved by <?php echo e($entry->approvedBy?->name ?? 'Pending'); ?></span>
                                    <span><?php echo e($entry->approved_at?->format('d M Y H:i') ?? 'Decision pending'); ?></span>
                                </td>
                                <td><?php echo e($statuses[$entry->status] ?? str($entry->status)->headline()); ?></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve', $entry)): ?>
                                        <details class="blade-row-actions">
                                            <summary>Approve</summary>
                                            <form method="POST" action="<?php echo e(route('finance.gst-entries.approve', $entry)); ?>" class="blade-inline-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <textarea name="note" maxlength="500" rows="2" placeholder="Approval note"></textarea>
                                                <button type="submit" class="blade-primary-action">Approve GST entry</button>
                                            </form>
                                        </details>
                                    <?php else: ?>
                                        <span>No action</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7">No GST entries match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination"><?php echo e($entries->links()); ?></div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/finance/gst-entries/index.blade.php ENDPATH**/ ?>