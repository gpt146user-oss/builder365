

<?php $__env->startSection('title', 'Partner Portal - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
        $scope = $summary['scope'] ?? ['partners' => [], 'partner_ids' => []];
        $metrics = $summary['metrics'] ?? [];
        $partners = collect($scope['partners'] ?? []);
        $leadStageSummary = collect($summary['lead_stage_summary'] ?? []);
        $leads = collect($summary['my_leads'] ?? []);
        $siteVisits = collect($summary['site_visits'] ?? []);
        $bookings = collect($summary['bookings'] ?? []);
        $collections = collect($summary['collections_follow_up'] ?? []);
        $commissionSummary = $summary['commission_summary'] ?? ['items' => []];
        $commissionItems = collect($commissionSummary['items'] ?? []);
        $documents = collect($summary['documents'] ?? []);
    ?>

    <div class="blade-workspace" aria-labelledby="partner-portal-title">
        <header class="blade-workspace-header">
            <div>
                <p class="blade-dashboard-eyebrow">Partner Channel</p>
                <h1 id="partner-portal-title">Partner Portal</h1>
                <p>
                    Secure partner workspace for available leads, site visits, bookings,
                    collection follow-up, commission visibility and booking/partner document downloads.
                </p>
            </div>
            <?php echo $__env->make('partner.partials.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </header>

        <section class="blade-dashboard-kpis" aria-label="Partner portal KPIs">
            <article class="blade-dashboard-kpi">
                <span>Total Leads</span>
                <strong><?php echo e(number_format((int) ($metrics['leads'] ?? 0))); ?></strong>
                <small><?php echo e(number_format((int) ($metrics['open_leads'] ?? 0))); ?> open</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Site Visits</span>
                <strong><?php echo e(number_format((int) ($metrics['site_visits'] ?? 0))); ?></strong>
                <small>Available visits</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Bookings</span>
                <strong><?php echo e(number_format((int) ($metrics['bookings'] ?? 0))); ?></strong>
                <small>Partner-attributed</small>
            </article>
            <article class="blade-dashboard-kpi">
                <span>Open Collections</span>
                <strong>₹<?php echo e(number_format((float) ($metrics['open_collection_amount'] ?? 0), 2)); ?></strong>
                <small>Follow-up amount</small>
            </article>
        </section>

        <section class="blade-workspace-grid">
            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Scope</span>
                        <h2>Partner profile scope</h2>
                    </div>
                    <small><?php echo e($partners->count()); ?> active</small>
                </div>
                <div class="blade-list">
                    <?php $__empty_1 = true; $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="blade-list-row">
                            <div>
                                <strong><?php echo e($partner['code']); ?> · <?php echo e($partner['name']); ?></strong>
                                <span><?php echo e($partner['type']); ?> · <?php echo e($partner['status']); ?></span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="blade-muted">No active partner record is linked to this login.</p>
                    <?php endif; ?>
                </div>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Pipeline</span>
                        <h2>Lead stage summary</h2>
                    </div>
                    <small><?php echo e($leadStageSummary->count()); ?> stage(s)</small>
                </div>
                <div class="blade-dashboard-table-wrap">
                    <table class="blade-dashboard-table">
                        <thead>
                            <tr>
                                <th scope="col">Stage</th>
                                <th scope="col">Leads</th>
                                <th scope="col">Expected Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $leadStageSummary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><strong><?php echo e($stage['stage']); ?></strong></td>
                                    <td><?php echo e(number_format((int) $stage['lead_count'])); ?></td>
                                    <td>₹<?php echo e(number_format((float) $stage['expected_value_total'], 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="3">No lead stages found for this partner.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Leads</span>
                    <h2>My leads</h2>
                </div>
                <small><?php echo e($leads->count()); ?> shown</small>
            </div>
            <div class="blade-dashboard-table-wrap">
                <table class="blade-dashboard-table">
                    <thead>
                        <tr>
                            <th scope="col">Lead</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Project</th>
                            <th scope="col">Value</th>
                            <th scope="col">Stage</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($lead['lead_code']); ?></strong>
                                    <span><?php echo e($lead['source']); ?></span>
                                </td>
                                <td><?php echo e($lead['customer'] ?? '—'); ?></td>
                                <td><?php echo e($lead['project'] ?? '—'); ?></td>
                                <td>₹<?php echo e(number_format((float) $lead['expected_value'], 2)); ?></td>
                                <td><?php echo e($lead['stage']); ?></td>
                                <td><span class="blade-status-pill"><?php echo e($leadStatuses[$lead['status']] ?? $lead['status']); ?></span></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="6">No leads found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="blade-workspace-grid">
            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Site Visits</span>
                        <h2>Upcoming and recent visits</h2>
                    </div>
                    <small><?php echo e($siteVisits->count()); ?> shown</small>
                </div>
                <div class="blade-dashboard-table-wrap">
                    <table class="blade-dashboard-table">
                        <thead>
                            <tr>
                                <th scope="col">Visit</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Project</th>
                                <th scope="col">Schedule</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $siteVisits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($visit['visit_number']); ?></strong>
                                        <span><?php echo e($visit['visit_mode']); ?></span>
                                    </td>
                                    <td><?php echo e($visit['customer'] ?? '—'); ?></td>
                                    <td><?php echo e($visit['project'] ?? '—'); ?></td>
                                    <td><?php echo e($visit['scheduled_at'] ?? '—'); ?></td>
                                    <td><span class="blade-status-pill"><?php echo e($visit['status']); ?></span></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="5">No site visits found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Bookings</span>
                        <h2>Attributed bookings</h2>
                    </div>
                    <small><?php echo e($bookings->count()); ?> shown</small>
                </div>
                <div class="blade-dashboard-table-wrap">
                    <table class="blade-dashboard-table">
                        <thead>
                            <tr>
                                <th scope="col">Booking</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Net Receivable</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($booking['booking_code']); ?></strong>
                                        <span><?php echo e($booking['project'] ?? '—'); ?></span>
                                    </td>
                                    <td><?php echo e($booking['customer'] ?? '—'); ?></td>
                                    <td><?php echo e($booking['unit'] ?? '—'); ?></td>
                                    <td>₹<?php echo e(number_format((float) $booking['net_receivable'], 2)); ?></td>
                                    <td><span class="blade-status-pill"><?php echo e($bookingStatuses[$booking['status']] ?? $booking['status']); ?></span></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="5">No bookings found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </article>
        </section>

        <section class="blade-workspace-grid">
            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Collections</span>
                        <h2>Collection follow-up</h2>
                    </div>
                    <small><?php echo e($collections->count()); ?> milestone(s)</small>
                </div>
                <div class="blade-dashboard-table-wrap">
                    <table class="blade-dashboard-table">
                        <thead>
                            <tr>
                                <th scope="col">Milestone</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Due</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $collections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($collection['booking_code']); ?></strong>
                                        <span><?php echo e($collection['milestone']); ?></span>
                                    </td>
                                    <td><?php echo e($collection['customer'] ?? '—'); ?></td>
                                    <td><?php echo e($collection['due_on'] ?? '—'); ?></td>
                                    <td>₹<?php echo e(number_format((float) $collection['amount'], 2)); ?></td>
                                    <td><span class="blade-status-pill"><?php echo e($collection['status']); ?></span></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="5">No collection follow-up milestones found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="blade-dashboard-card">
                <div class="blade-dashboard-section-title">
                    <div>
                        <span class="blade-dashboard-label">Commission</span>
                        <h2>Commission summary</h2>
                    </div>
                    <small><?php echo e(number_format((int) ($commissionSummary['total_items'] ?? 0))); ?> item(s)</small>
                </div>
                <dl class="blade-definition-list">
                    <div>
                        <dt>Approved</dt>
                        <dd>₹<?php echo e(number_format((float) ($commissionSummary['approved_amount'] ?? 0), 2)); ?></dd>
                    </div>
                    <div>
                        <dt>Pending</dt>
                        <dd>₹<?php echo e(number_format((float) ($commissionSummary['pending_amount'] ?? 0), 2)); ?></dd>
                    </div>
                    <div>
                        <dt>Paid / Payroll Included</dt>
                        <dd>₹<?php echo e(number_format((float) ($commissionSummary['paid_amount'] ?? 0), 2)); ?></dd>
                    </div>
                </dl>
                <div class="blade-list">
                    <?php $__empty_1 = true; $__currentLoopData = $commissionItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="blade-list-row">
                            <div>
                                <strong><?php echo e($item['run_number'] ?? 'Commission Item'); ?> · <?php echo e($item['period']); ?></strong>
                                <span><?php echo e($item['booking_code'] ?? $item['lead_code'] ?? '—'); ?> · ₹<?php echo e(number_format((float) $item['commission_amount'], 2)); ?></span>
                            </div>
                            <span class="blade-status-pill"><?php echo e($commissionStatuses[$item['status']] ?? $item['status']); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="blade-muted">No commission items found.</p>
                    <?php endif; ?>
                </div>
            </article>
        </section>

        <section class="blade-dashboard-card">
            <div class="blade-dashboard-section-title">
                <div>
                    <span class="blade-dashboard-label">Documents</span>
                    <h2>Partner-visible documents</h2>
                </div>
                <small><?php echo e($documents->count()); ?> shown</small>
            </div>
            <div class="blade-list">
                <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="blade-list-row">
                        <div>
                            <strong><?php echo e($document['document_number']); ?> · <?php echo e($document['title']); ?></strong>
                            <span><?php echo e($document['category'] ?? 'Document'); ?> · <?php echo e($document['owner_type']); ?> · v<?php echo e($document['version']); ?></span>
                        </div>
                        <a href="<?php echo e($document['download_url']); ?>">Download</a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="blade-muted">No partner-visible approved documents found.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/partner/summary.blade.php ENDPATH**/ ?>