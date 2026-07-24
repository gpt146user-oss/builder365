

<?php $__env->startSection('title', 'Procurement Workspace - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<div class="blade-workspace" aria-labelledby="procurement-workspace-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Material, Store and Procurement</p>
                <h1 id="procurement-workspace-title">Procurement Workspace</h1>
                <p>
                    Workspace for vendor master, material requisitions, approval workflow,
                    stock register, low-stock visibility, pending delivery and store valuation.
                </p>
            </div>
            <nav class="blade-workspace-actions" aria-label="Workspace actions">
                <a href="<?php echo e(route('builder360.dashboard')); ?>">Dashboard</a>
                <a href="<?php echo e(route('procurement.dashboard')); ?>">Procurement dashboard</a>
                <a href="<?php echo e(route('procurement.vendors.index')); ?>">Vendors</a>
                <a href="<?php echo e(route('procurement.requisitions.index')); ?>">Requisitions</a>
                <a href="<?php echo e(route('procurement.stock-items.index')); ?>">Stock</a>
            </nav>
        </header>

        <?php if(session('status')): ?>
            <section class="blade-alert blade-alert-success" role="status">
                <?php echo e(session('status')); ?>

            </section>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <section class="blade-alert blade-alert-error" role="alert">
                <strong>Procurement action was not completed.</strong>
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
                        <span class="blade-dashboard-label">Procurement Dashboard</span>
                        <h2>Material and purchase summary</h2>
                    </div>
                    <small>Live records</small>
                </div>

                <div class="blade-dashboard-metrics">
                    <div class="blade-dashboard-metric">
                        <span>Active vendors</span>
                        <strong><?php echo e(number_format((int) data_get($dashboard, 'summary.active_vendors', 0))); ?></strong>
                    </div>
                    <div class="blade-dashboard-metric">
                        <span>Submitted PRs</span>
                        <strong><?php echo e(number_format((int) data_get($dashboard, 'summary.requisitions.submitted', 0))); ?></strong>
                    </div>
                    <div class="blade-dashboard-metric">
                        <span>PO total</span>
                        <strong><?php echo e(number_format((float) data_get($dashboard, 'summary.purchase_orders.total_amount', 0), 2)); ?></strong>
                    </div>
                    <div class="blade-dashboard-metric">
                        <span>Stock value</span>
                        <strong><?php echo e(number_format((float) data_get($dashboard, 'summary.stock.stock_value', 0), 2)); ?></strong>
                    </div>
                    <div class="blade-dashboard-metric">
                        <span>Low stock</span>
                        <strong><?php echo e(number_format((int) data_get($dashboard, 'summary.stock.low_stock_items', 0))); ?></strong>
                    </div>
                    <div class="blade-dashboard-metric">
                        <span>Pending delivery</span>
                        <strong><?php echo e(number_format((float) data_get($dashboard, 'summary.pending_delivery.amount', 0), 2)); ?></strong>
                    </div>
                </div>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Controls</span>
                        <h2>Dashboard filters</h2>
                    </div>
                    <small>Company-level</small>
                </div>

                <form method="GET" action="<?php echo e(route('procurement.dashboard')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                    <label>
                        Project
                        <select name="project_id">
                            <option value="">All projects</option>
                            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($project->id); ?>" <?php if((string) ($filters['project_id'] ?? '') === (string) $project->id): echo 'selected'; endif; ?>>
                                    <?php echo e($project->code); ?> &middot; <?php echo e($project->name); ?>

                                </option>
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

                    <button type="submit" class="blade-secondary-action">Apply filters</button>
                </form>

                <p class="blade-workspace-note">
                    Dashboard figures come from vendors, purchase requisitions, purchase orders, goods receipts and stock items available to the selected company.
                </p>
            </article>
        </section>

        <section class="blade-workspace-grid">
            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Create</span>
                        <h2>Vendor master</h2>
                    </div>
                    <small><?php echo e($canCreateVendor ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateVendor): ?>
                    <form method="POST" action="<?php echo e(route('procurement.vendors.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <?php if (isset($component)) { $__componentOriginal5ee006ce6757c21855df609df2a8580f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5ee006ce6757c21855df609df2a8580f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.company-context','data' => ['companies' => $companies,'placeholder' => 'Use my company']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.company-context'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['companies' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($companies),'placeholder' => 'Use my company']); ?>
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
                            Vendor code
                            <input type="text" name="vendor_code" value="<?php echo e(old('vendor_code')); ?>" maxlength="40" required>
                        </label>

                        <label>
                            Vendor name
                            <input type="text" name="name" value="<?php echo e(old('name')); ?>" maxlength="255" required>
                        </label>

                        <label>
                            Vendor type
                            <select name="vendor_type" required>
                                <?php $__currentLoopData = $vendorTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('vendor_type', 'material') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Contact person
                            <input type="text" name="contact_name" value="<?php echo e(old('contact_name')); ?>" maxlength="120">
                        </label>

                        <label>
                            Email
                            <input type="email" name="email" value="<?php echo e(old('email')); ?>" maxlength="255">
                        </label>

                        <label>
                            Phone
                            <input type="text" name="phone" value="<?php echo e(old('phone')); ?>" maxlength="30">
                        </label>

                        <label>
                            GSTIN
                            <input type="text" name="gstin" value="<?php echo e(old('gstin')); ?>" maxlength="15">
                        </label>

                        <label>
                            PAN
                            <input type="text" name="pan" value="<?php echo e(old('pan')); ?>" maxlength="10">
                        </label>

                        <label>
                            City
                            <input type="text" name="address[city]" value="<?php echo e(old('address.city')); ?>" maxlength="120">
                        </label>

                        <label>
                            State
                            <input type="text" name="address[state]" value="<?php echo e(old('address.state')); ?>" maxlength="120">
                        </label>

                        <button type="submit" class="blade-primary-action">Create vendor</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view vendors but cannot create vendor masters.</p>
                <?php endif; ?>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Submit</span>
                        <h2>Purchase requisition</h2>
                    </div>
                    <small><?php echo e($canCreateRequisition ? 'Authorized' : 'Read only'); ?></small>
                </div>

                <?php if($canCreateRequisition): ?>
                    <form method="POST" action="<?php echo e(route('procurement.requisitions.store')); ?>" class="blade-form-grid">
                        <?php echo csrf_field(); ?>

                        <label>
                            Project
                            <select name="project_id" required>
                                <option value="">Select project</option>
                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($project->id); ?>" <?php if((string) old('project_id', $projects->first()?->id) === (string) $project->id): echo 'selected'; endif; ?>>
                                        <?php echo e($project->code); ?> &middot; <?php echo e($project->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Department
                            <input type="text" name="department" value="<?php echo e(old('department', 'Construction')); ?>" maxlength="120" required>
                        </label>

                        <label>
                            Required by
                            <input type="date" name="required_by" value="<?php echo e(old('required_by', now()->addDays(7)->toDateString())); ?>" min="<?php echo e(now()->toDateString()); ?>" required>
                        </label>

                        <label>
                            Priority
                            <select name="priority" required>
                                <?php $__currentLoopData = $priorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php if(old('priority', 'normal') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>

                        <label>
                            Item code
                            <input type="text" name="items[0][item_code]" value="<?php echo e(old('items.0.item_code')); ?>" maxlength="80" required>
                        </label>

                        <label>
                            Description
                            <input type="text" name="items[0][description]" value="<?php echo e(old('items.0.description')); ?>" maxlength="255" required>
                        </label>

                        <label>
                            Unit
                            <input type="text" name="items[0][unit]" value="<?php echo e(old('items.0.unit', 'nos')); ?>" maxlength="40" required>
                        </label>

                        <label>
                            Quantity
                            <input type="number" name="items[0][quantity]" value="<?php echo e(old('items.0.quantity')); ?>" min="0.01" step="0.001" required>
                        </label>

                        <label>
                            Estimated rate
                            <input type="number" name="items[0][estimated_rate]" value="<?php echo e(old('items.0.estimated_rate')); ?>" min="0" step="0.01" required>
                        </label>

                        <label>
                            Purpose
                            <textarea name="purpose" maxlength="5000"><?php echo e(old('purpose')); ?></textarea>
                        </label>

                        <button type="submit" class="blade-primary-action">Submit requisition</button>
                    </form>
                <?php else: ?>
                    <p class="blade-workspace-note">Your role can view purchase requisitions but cannot submit new requisitions.</p>
                <?php endif; ?>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Controls</span>
                    <h2>Vendor filters</h2>
                </div>
                <small><?php echo e($vendors->total()); ?> vendor record(s)</small>
            </div>

            <form method="GET" action="<?php echo e(route('procurement.vendors.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                <label>
                    Search
                    <input type="search" name="search" value="<?php echo e($filters['search'] ?? ''); ?>" maxlength="120" placeholder="Vendor name, code or GSTIN">
                </label>

                <label>
                    Type
                    <select name="vendor_type">
                        <option value="">All types</option>
                        <?php $__currentLoopData = $vendorTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php if(($filters['vendor_type'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>

                <label>
                    Status
                    <select name="status">
                        <option value="">All statuses</option>
                        <?php $__currentLoopData = $vendorStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>

                <button type="submit" class="blade-secondary-action">Apply filters</button>
            </form>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Vendor master</h2>
                </div>
                <small><?php echo e($vendors->firstItem() ?? 0); ?>-<?php echo e($vendors->lastItem() ?? 0); ?> of <?php echo e($vendors->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Vendor</th>
                            <th scope="col">Type</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Tax references</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($vendor->vendor_code); ?></strong>
                                    <span><?php echo e($vendor->name); ?></span>
                                    <?php if($vendorScore = ($vendorScores[$vendor->id] ?? null)): ?>
                                        <span>Performance: <?php echo e($vendorScore->score); ?> / 100 · <?php echo e(str($vendorScore->band)->headline()); ?></span>
                                        <span>Rule v<?php echo e($vendorScore->ruleVersion); ?> · <?php echo e($vendorScore->calculatedAt->format('d M Y H:i')); ?></span>
                                    <?php else: ?>
                                        <span>Performance score not calculated</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($vendorTypes[$vendor->vendor_type] ?? str($vendor->vendor_type)->headline()); ?></td>
                                <td>
                                    <strong><?php echo e($vendor->contact_name ?? 'Contact pending'); ?></strong>
                                    <span><?php echo e($vendor->phone ?? $vendor->email ?? 'No contact'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($vendor->gstin ?? 'GSTIN pending'); ?></strong>
                                    <span>PAN last 4: <?php echo e($vendor->pan_last4 ?? 'NA'); ?></span>
                                </td>
                                <td><?php echo e($vendorStatuses[$vendor->status] ?? str($vendor->status)->headline()); ?></td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $vendor)): ?>
                                        <details class="blade-row-actions blade-scoring-evidence">
                                            <summary>Performance evidence</summary>
                                            <form method="POST" action="<?php echo e(route('procurement.vendors.performance-score.update', $vendor)); ?>" class="blade-inline-form blade-scoring-evidence-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <?php
                                                    $vendorInputs = $vendor->scoring_inputs ?? [];
                                                    $vendorEvidenceFields = [
                                                        'acceptance_rate' => 'Acceptance rate',
                                                        'quality' => 'Quality',
                                                        'on_time_delivery' => 'On-time delivery',
                                                        'fulfillment' => 'Fulfillment',
                                                        'price_competitiveness' => 'Price competitiveness',
                                                        'documentation' => 'Documentation compliance',
                                                        'responsiveness' => 'Service responsiveness',
                                                        'issue_resolution' => 'Issue resolution',
                                                    ];
                                                ?>
                                                <?php $__currentLoopData = $vendorEvidenceFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evidenceKey => $evidenceLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <label>
                                                        <?php echo e($evidenceLabel); ?>

                                                        <input type="number" name="<?php echo e($evidenceKey); ?>" value="<?php echo e($vendorInputs[$evidenceKey] ?? ''); ?>" min="0" max="100" step="0.01" required>
                                                    </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <p class="blade-workspace-note">Enter verified values from 0 to 100. Saving recalculates the active Vendor Performance rule.</p>
                                                <button type="submit" class="blade-secondary-action">Calculate vendor score</button>
                                            </form>
                                        </details>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('updateStatus', $vendor)): ?>
                                        <form method="POST" action="<?php echo e(route('procurement.vendors.status.update', $vendor)); ?>" class="blade-inline-form">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <label>
                                                Status
                                                <select name="status" required>
                                                    <?php $__currentLoopData = $vendorStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($value); ?>" <?php if($vendor->status === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </label>
                                            <input type="text" name="reason" value="<?php echo e(old('reason')); ?>" maxlength="1000" placeholder="Reason required unless active" aria-label="Vendor status reason">
                                            <button type="submit" class="blade-secondary-action">Update status</button>
                                        </form>
                                    <?php else: ?>
                                        <span>Read only</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6">No vendors match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination">
                <?php echo e($vendors->links()); ?>

            </div>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Controls</span>
                    <h2>Requisition filters</h2>
                </div>
                <small><?php echo e($requisitions->total()); ?> requisition record(s)</small>
            </div>

            <form method="GET" action="<?php echo e(route('procurement.requisitions.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                <label>
                    Project
                    <select name="project_id">
                        <option value="">All projects</option>
                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($project->id); ?>" <?php if((string) ($filters['project_id'] ?? '') === (string) $project->id): echo 'selected'; endif; ?>>
                                <?php echo e($project->code); ?> &middot; <?php echo e($project->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>

                <label>
                    Status
                    <select name="status">
                        <option value="">All statuses</option>
                        <?php $__currentLoopData = $requisitionStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>

                <button type="submit" class="blade-secondary-action">Apply filters</button>
            </form>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Purchase requisitions</h2>
                </div>
                <small><?php echo e($requisitions->firstItem() ?? 0); ?>-<?php echo e($requisitions->lastItem() ?? 0); ?> of <?php echo e($requisitions->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Requisition</th>
                            <th scope="col">Project</th>
                            <th scope="col">Need</th>
                            <th scope="col">Items</th>
                            <th scope="col">Estimate</th>
                            <th scope="col">Status</th>
                            <th scope="col">Requester / Approver</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $requisitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requisition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $firstItem = collect($requisition->items ?? [])->first();
                            ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($requisition->requisition_number); ?></strong>
                                    <span><?php echo e(str($requisition->priority)->headline()); ?> priority</span>
                                </td>
                                <td>
                                    <strong><?php echo e($requisition->project?->code ?? 'No project'); ?></strong>
                                    <span><?php echo e($requisition->project?->name ?? 'Project missing'); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($requisition->department); ?></strong>
                                    <span>Required <?php echo e($requisition->required_by?->format('d M Y')); ?></span>
                                </td>
                                <td>
                                    <?php if($firstItem): ?>
                                        <strong><?php echo e($firstItem['item_code'] ?? 'Item'); ?></strong>
                                        <span><?php echo e($firstItem['quantity'] ?? 0); ?> <?php echo e($firstItem['unit'] ?? 'unit'); ?> &middot; <?php echo e($firstItem['description'] ?? ''); ?></span>
                                    <?php else: ?>
                                        No items
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e(number_format((float) $requisition->estimated_total, 2)); ?></td>
                                <td><?php echo e($requisitionStatuses[$requisition->status] ?? str($requisition->status)->headline()); ?></td>
                                <td>
                                    <strong><?php echo e($requisition->requestedBy?->name ?? 'Unknown'); ?></strong>
                                    <span><?php echo e($requisition->approvedBy?->name ?? 'Approval pending'); ?></span>
                                </td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve', $requisition)): ?>
                                        <form method="POST" action="<?php echo e(route('procurement.requisitions.approve', $requisition)); ?>" class="blade-inline-form">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <input type="text" name="note" value="<?php echo e(old('note')); ?>" maxlength="1000" placeholder="Approval note" aria-label="Purchase requisition approval note">
                                            <button type="submit" class="blade-primary-action">Approve PR</button>
                                        </form>
                                    <?php else: ?>
                                        <span><?php echo e($requisition->status === 'submitted' ? 'Approval unavailable' : 'Closed'); ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8">No purchase requisitions match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination">
                <?php echo e($requisitions->links()); ?>

            </div>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Controls</span>
                    <h2>Stock filters</h2>
                </div>
                <small><?php echo e($stockItems->total()); ?> stock item(s)</small>
            </div>

            <form method="GET" action="<?php echo e(route('procurement.stock-items.index')); ?>" class="blade-filter-grid blade-filter-grid-compact">
                <label>
                    Project
                    <select name="project_id">
                        <option value="">All projects</option>
                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($project->id); ?>" <?php if((string) ($filters['project_id'] ?? '') === (string) $project->id): echo 'selected'; endif; ?>>
                                <?php echo e($project->code); ?> &middot; <?php echo e($project->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>

                <label>
                    Store type
                    <select name="store_type">
                        <option value="">All stores</option>
                        <?php $__currentLoopData = $storeTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php if(($filters['store_type'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>

                <label>
                    Item code
                    <input type="search" name="item_code" value="<?php echo e($filters['item_code'] ?? ''); ?>" maxlength="80">
                </label>

                <label>
                    Low stock only
                    <select name="low_stock">
                        <option value="">No</option>
                        <option value="1" <?php if((string) ($filters['low_stock'] ?? '') === '1'): echo 'selected'; endif; ?>>Yes</option>
                    </select>
                </label>

                <button type="submit" class="blade-secondary-action">Apply filters</button>
            </form>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Register</span>
                    <h2>Stock register</h2>
                </div>
                <small><?php echo e($stockItems->firstItem() ?? 0); ?>-<?php echo e($stockItems->lastItem() ?? 0); ?> of <?php echo e($stockItems->total()); ?></small>
            </div>

            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Project</th>
                            <th scope="col">Store</th>
                            <th scope="col">On hand</th>
                            <th scope="col">Minimum</th>
                            <th scope="col">Average rate</th>
                            <th scope="col">Stock value</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $stockItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stockItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($stockItem->item_code); ?></strong>
                                    <span><?php echo e($stockItem->description); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo e($stockItem->project?->code ?? 'No project'); ?></strong>
                                    <span><?php echo e($stockItem->project?->name ?? 'Project missing'); ?></span>
                                </td>
                                <td><?php echo e($storeTypes[$stockItem->store_type] ?? str($stockItem->store_type)->headline()); ?></td>
                                <td><?php echo e(number_format((float) $stockItem->on_hand_quantity, 3)); ?> <?php echo e($stockItem->unit); ?></td>
                                <td><?php echo e(number_format((float) $stockItem->minimum_stock_quantity, 3)); ?> <?php echo e($stockItem->unit); ?></td>
                                <td><?php echo e(number_format((float) $stockItem->average_rate, 4)); ?></td>
                                <td><?php echo e(number_format((float) $stockItem->stock_value, 2)); ?></td>
                                <td>
                                    <strong><?php echo e($stockStatuses[$stockItem->status] ?? str($stockItem->status)->headline()); ?></strong>
                                    <?php if($stockItem->isBelowMinimum()): ?>
                                        <span>Low stock alert</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8">No stock items match the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="blade-pagination">
                <?php echo e($stockItems->links()); ?>

            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\procurement\workspace\index.blade.php ENDPATH**/ ?>