<?php $__env->startSection('title', 'HR Settings - Builder360 ERP-CRM'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $settings = $workspace['settings'];
    $filters = $workspace['filters'];
    $summary = $workspace['summary'];
    $tabs = $workspace['tabs'];
    $activeTab = $filters['tab'] ?? 'overview';
    $activeFilters = collect(['search' => 'Search', 'status' => 'Status'])->filter(fn (string $label, string $key): bool => filled($filters[$key] ?? null));
?>

<?php if (isset($component)) { $__componentOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b46c749cdd3ead475dfb1495ff30ad9 = $attributes; } ?>
<?php $component = App\View\Components\Hr\PeopleWorkspace::resolve(['title' => 'HR Settings','description' => 'Review HR, payroll, and approval-workflow rules governed through maker-checker System Settings.','active' => 'settings'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-workspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Hr\PeopleWorkspace::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <?php if($workspace['canViewRoles']): ?>
            <a class="people-button" href="<?php echo e(route('admin.roles.index')); ?>">
                <i class="fa-solid fa-user-shield" aria-hidden="true"></i> Role permissions
            </a>
        <?php endif; ?>
        <a class="people-button<?php echo e($workspace['canManage'] ? ' is-primary' : ''); ?>" href="<?php echo e(route('settings.system-settings.index')); ?>">
            <i class="fa-solid fa-sliders" aria-hidden="true"></i> <?php echo e($workspace['canManage'] ? 'Create governed draft' : 'Open governed register'); ?>

        </a>
     <?php $__env->endSlot(); ?>

    <?php if(session('status')): ?>
        <section class="people-alert is-success" role="status"><?php echo e(session('status')); ?></section>
    <?php endif; ?>

    <nav class="people-ops-tabs" aria-label="HR setting categories">
        <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a
                href="<?php echo e(route('hr.settings.index', array_filter(['tab' => $key, 'search' => $filters['search'] ?? null, 'status' => $filters['status'] ?? null]))); ?>"
                class="<?php echo \Illuminate\Support\Arr::toCssClasses(['is-active' => $activeTab === $key]); ?>"
                <?php if($activeTab === $key): ?> aria-current="page" <?php endif; ?>
            ><?php echo e($label); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>

    <section class="people-ops-kpis is-four" aria-label="HR setting summary">
        <article class="people-ops-kpi is-info"><span class="people-ops-kpi-icon"><i class="fa-solid fa-sliders" aria-hidden="true"></i></span><span>Visible versions</span><strong><?php echo e(number_format((int) ($summary['total'] ?? 0))); ?></strong><small>Within the selected category and search</small></article>
        <article class="people-ops-kpi is-warning"><span class="people-ops-kpi-icon"><i class="fa-solid fa-pen-ruler" aria-hidden="true"></i></span><span>Draft</span><strong><?php echo e(number_format((int) ($summary['draft'] ?? 0))); ?></strong><small>Awaiting governed review</small></article>
        <article class="people-ops-kpi is-success"><span class="people-ops-kpi-icon"><i class="fa-solid fa-circle-check" aria-hidden="true"></i></span><span>Active</span><strong><?php echo e(number_format((int) ($summary['active'] ?? 0))); ?></strong><small>Effective approved versions</small></article>
        <article class="people-ops-kpi"><span class="people-ops-kpi-icon"><i class="fa-solid fa-box-archive" aria-hidden="true"></i></span><span>Archived</span><strong><?php echo e(number_format((int) ($summary['archived'] ?? 0))); ?></strong><small>Retained configuration history</small></article>
    </section>

    <section class="people-alert" role="note">
        <strong>One-company governed configuration.</strong>
        This hub does not edit settings in browser state. Changes are created as drafts and become active only through the existing authorized approval workflow.
    </section>

    <section class="people-ops-panel has-mobile-cards" aria-labelledby="hr-settings-register-title">
        <header class="people-ops-panel-head">
            <div><h2 id="hr-settings-register-title">HR configuration register</h2><p><?php echo e(number_format($settings->total())); ?> setting version<?php echo e($settings->total() === 1 ? '' : 's'); ?> match the current filters.</p></div>
            <?php if($workspace['canApprove']): ?><span class="people-count">Approver access</span><?php endif; ?>
        </header>

        <form method="GET" action="<?php echo e(route('hr.settings.index')); ?>" class="people-ops-filterbar" aria-label="Filter HR settings">
            <input type="hidden" name="tab" value="<?php echo e($activeTab); ?>">
            <label class="people-field">
                <span>Search settings</span>
                <input class="people-control" type="search" name="search" maxlength="120" value="<?php echo e($filters['search'] ?? ''); ?>" placeholder="Label, key or description">
            </label>
            <label class="people-field">
                <span>Status</span>
                <select class="people-control" name="status">
                    <option value="">All statuses</option>
                    <?php $__currentLoopData = ['draft' => 'Draft', 'active' => 'Active', 'archived' => 'Archived']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>" <?php if(($filters['status'] ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </label>
            <div class="people-page-actions">
                <button class="people-button" type="submit"><i class="fa-solid fa-filter" aria-hidden="true"></i> Apply</button>
                <a class="people-button" href="<?php echo e(route('hr.settings.index', ['tab' => $activeTab])); ?>">Clear</a>
            </div>
        </form>

        <?php if($activeFilters->isNotEmpty()): ?>
            <nav class="people-filter-chips" aria-label="Active HR setting filters">
                <span>Active filters</span>
                <?php $__currentLoopData = $activeFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a class="people-filter-chip" href="<?php echo e(route('hr.settings.index', request()->except([$key, 'page']))); ?>" aria-label="Remove <?php echo e($label); ?> filter">
                        <?php echo e($label); ?>: <?php echo e($filters[$key]); ?> <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <a class="people-filter-chip" href="<?php echo e(route('hr.settings.index', ['tab' => $activeTab])); ?>">Clear all</a>
            </nav>
        <?php endif; ?>

        <div class="people-ops-table-wrap">
            <table class="people-ops-table">
                <caption>HR, payroll, and approval workflow setting versions</caption>
                <thead><tr><th scope="col">Setting</th><th scope="col">Category / scope</th><th scope="col">Version / effective</th><th scope="col">Configuration</th><th scope="col">Maker / checker</th><th scope="col">Status</th><th scope="col" class="is-actions">Action</th></tr></thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($setting->label); ?></strong><small><?php echo e($setting->settingKey); ?></small></td>
                            <td><?php echo e(str($setting->settingGroup)->headline()); ?><small><?php echo e($setting->scopeLabel); ?></small></td>
                            <td><?php echo e($setting->versionLabel); ?><small><?php echo e($setting->effectiveLabel); ?></small></td>
                            <td><?php echo e($setting->typeLabel); ?><small><?php echo e($setting->valueSummary); ?></small></td>
                            <td><?php echo e($setting->makerLabel); ?><small><?php echo e($setting->checkerLabel); ?></small></td>
                            <td><span class="people-status <?php echo e($setting->statusTone); ?>"><?php echo e($setting->statusLabel); ?></span></td>
                            <td class="is-actions"><a class="people-button" href="<?php echo e(route('settings.system-settings.index', ['setting_key' => $setting->settingKey, 'status' => $setting->status === 'draft' ? 'draft' : null])); ?>"><?php echo e($setting->canApprove ? 'Review draft' : 'Open history'); ?></a></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="7"><?php if (isset($component)) { $__componentOriginal3abc64969eeeba849011f1a920d3a3ce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hr.people-state','data' => ['type' => 'filtered','icon' => 'fa-sliders','title' => 'No HR settings match these filters','message' => 'Clear the filters or open the governed System Settings register if your role permits it.','compact' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hr.people-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'filtered','icon' => 'fa-sliders','title' => 'No HR settings match these filters','message' => 'Clear the filters or open the governed System Settings register if your role permits it.','compact' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $attributes = $__attributesOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__attributesOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce)): ?>
<?php $component = $__componentOriginal3abc64969eeeba849011f1a920d3a3ce; ?>
<?php unset($__componentOriginal3abc64969eeeba849011f1a920d3a3ce); ?>
<?php endif; ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="people-ops-mobile-list" aria-label="HR setting cards">
            <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="people-ops-mobile-card">
                    <div class="people-ops-mobile-card-head"><strong><?php echo e($setting->label); ?></strong><span class="people-status <?php echo e($setting->statusTone); ?>"><?php echo e($setting->statusLabel); ?></span></div>
                    <dl class="people-ops-mobile-facts">
                        <div><dt>Key</dt><dd><?php echo e($setting->settingKey); ?></dd></div>
                        <div><dt>Scope</dt><dd><?php echo e($setting->scopeLabel); ?></dd></div>
                        <div><dt>Version</dt><dd><?php echo e($setting->versionLabel); ?> &middot; <?php echo e($setting->effectiveLabel); ?></dd></div>
                        <div><dt>Configuration</dt><dd><?php echo e($setting->valueSummary); ?></dd></div>
                    </dl>
                    <div class="people-card-action"><a class="people-button" href="<?php echo e(route('settings.system-settings.index', ['setting_key' => $setting->settingKey, 'status' => $setting->status === 'draft' ? 'draft' : null])); ?>"><?php echo e($setting->canApprove ? 'Review draft' : 'Open history'); ?></a></div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <footer class="people-pagination">
            <span>Showing <?php echo e($settings->firstItem() ?? 0); ?>&ndash;<?php echo e($settings->lastItem() ?? 0); ?> of <?php echo e(number_format($settings->total())); ?></span>
            <?php echo e($settings->links()); ?>

        </footer>
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

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views/hr/settings/index.blade.php ENDPATH**/ ?>