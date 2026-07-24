<?php $__env->startSection('title', 'Company Email Accounts | Builder360'); ?>

<?php $__env->startPush('styles'); ?>
<style>
  .b360-content {
        padding: 6px !important;
    }
    /* ═══════════════════════════════════════════════
    MAILBOX ACCOUNTS — ARCTIC CLARITY
    White + Light Blue · System fonts · CSP-safe
    ═══════════════════════════════════════════════ */
    :root {
    --ac-bg:          #F0F4FA;
    --ac-surface:     #FFFFFF;
    --ac-surface-2:   #F7F9FC;
    --ac-border:      #E2E8F2;
    --ac-border-2:    #C7D5EA;
    --ac-blue-50:     #EEF4FF;
    --ac-blue-100:    #DBEAFE;
    --ac-blue-200:    #BFDBFE;
    --ac-blue-500:    #3B82F6;
    --ac-blue-600:    #2563EB;
    --ac-blue-700:    #1D4ED8;
    --ac-accent:      #2563EB;
    --ac-accent-soft: #EEF4FF;
    --ac-text:        #0F172A;
    --ac-text-2:      #334155;
    --ac-text-3:      #64748B;
    --ac-text-muted:  #94A3B8;
    --ac-success:     #10B981;
    --ac-warning:     #F59E0B;
    --ac-danger:      #EF4444;
    --ac-shadow-sm:   0 2px 8px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    --ac-shadow-md:   0 4px 16px rgba(0,0,0,0.08), 0 2px 4px rgba(0,0,0,0.04);
    --r-sm: 8px; --r-md: 12px; --r-lg: 16px;
    --font: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .mac-wrap * { box-sizing: border-box; margin: 0; padding: 0; }
    .mac-wrap { font-family: var(--font); -webkit-font-smoothing: antialiased; color: var(--ac-text); }

    /* ── Page shell ── */
    .mac-wrap {
    background: var(--ac-bg);
    min-height: 100vh;
    padding: 32px 28px 48px;
    }

    /* ── Page heading ── */
    .mac-page-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 28px;
    flex-wrap: wrap;
    }
    .mac-page-head-copy { display: flex; flex-direction: column; gap: 4px; }
    .mac-eyebrow {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .1em;
    color: var(--ac-accent);
    margin-bottom: 2px;
    }
    .mac-eyebrow::before {
    content: '';
    display: inline-block; width: 14px; height: 2px;
    background: var(--ac-accent); border-radius: 2px;
    }
    .mac-page-head h1 {
    font-size: 22px; font-weight: 700;
    color: var(--ac-text); line-height: 1.25;
    }
    .mac-page-head p {
    font-size: 13.5px; color: var(--ac-text-muted); line-height: 1.5; margin-top: 2px;
    }

    /* ── Buttons ── */
    .mac-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 8px 18px; border-radius: var(--r-md);
    font-size: 13px; font-weight: 600; font-family: var(--font);
    text-decoration: none; cursor: pointer;
    border: 1px solid var(--ac-border-2);
    background: var(--ac-surface); color: var(--ac-text-2);
    transition: all .15s; white-space: nowrap;
    }
    .mac-btn:hover { background: var(--ac-blue-50); border-color: var(--ac-blue-200); color: var(--ac-accent); text-decoration: none; }
    .mac-btn-primary {
    background: var(--ac-accent); color: #fff;
    border-color: var(--ac-accent);
    box-shadow: 0 2px 8px rgba(37,99,235,0.22);
    }
    .mac-btn-primary:hover { background: var(--ac-blue-700); border-color: var(--ac-blue-700); color: #fff; box-shadow: 0 4px 14px rgba(37,99,235,0.30); text-decoration: none; }
    .mac-btn-danger { color: var(--ac-danger); border-color: #FCA5A5; background: #FFF5F5; }
    .mac-btn-danger:hover { background: #FEE2E2; border-color: #F87171; color: var(--ac-danger); }

    /* ── Two-column grid ── */
    .mac-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    align-items: start;
    }
    @media (max-width: 960px) { .mac-grid { grid-template-columns: 1fr; } }

    /* ── Panel ── */
    .mac-panel {
    background: var(--ac-surface);
    border: 1px solid var(--ac-border);
    border-radius: var(--r-lg);
    overflow: hidden;
    box-shadow: var(--ac-shadow-sm);
    }
    .mac-panel-top-line {
    height: 3px;
    background: linear-gradient(90deg, var(--ac-blue-600), #60a5fa);
    }
    .mac-panel-head {
    padding: 20px 22px 16px;
    border-bottom: 1px solid var(--ac-border);
    background: var(--ac-surface-2);
    }
    .mac-panel-head h2 { font-size: 14.5px; font-weight: 700; color: var(--ac-text); margin-bottom: 2px; }
    .mac-panel-head p  { font-size: 12.5px; color: var(--ac-text-muted); line-height: 1.45; }

    /* ── Account list ── */
    .mac-acct-list { display: flex; flex-direction: column; }

    .mac-acct-card {
    padding: 16px 22px;
    border-bottom: 1px solid var(--ac-border);
    transition: background .13s;
    }
    .mac-acct-card:last-child { border-bottom: none; }
    .mac-acct-card:hover { background: var(--ac-surface-2); }

    .mac-acct-row {
    display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
    }

    /* Status dot */
    .mac-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--ac-border-2); flex-shrink: 0;
    }
    .mac-dot.is-active { background: var(--ac-success); box-shadow: 0 0 0 3px rgba(16,185,129,.15); }

    .mac-acct-info { flex: 1; min-width: 0; }
    .mac-acct-info strong { display: block; font-size: 14px; font-weight: 600; color: var(--ac-text); }
    .mac-acct-info small  { display: block; font-size: 12px; color: var(--ac-text-muted); margin-top: 1px; }
    .mac-acct-info span   { display: block; font-size: 11.5px; color: var(--ac-text-3); margin-top: 2px; }

    /* Status pill */
    .mac-pill {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px; border-radius: 20px;
    font-size: 11px; font-weight: 600;
    background: var(--ac-blue-50); color: var(--ac-blue-600);
    border: 1px solid var(--ac-blue-200);
    white-space: nowrap; flex-shrink: 0;
    }
    .mac-pill.is-active { background: rgba(16,185,129,.1); color: #059669; border-color: rgba(16,185,129,.25); }
    .mac-pill::before { content: ''; display: inline-block; width: 5px; height: 5px; border-radius: 50%; background: currentColor; }

    /* Manage access accordion */
    .mac-access-details {
    margin-top: 12px;
    border: 1px solid var(--ac-border);
    border-radius: var(--r-md);
    overflow: hidden;
    }
    .mac-access-details summary {
    display: flex; align-items: center; gap: 8px;
    padding: 9px 14px;
    cursor: pointer; list-style: none;
    font-size: 12.5px; font-weight: 600; color: var(--ac-accent);
    background: var(--ac-blue-50);
    transition: background .13s;
    user-select: none;
    }
    .mac-access-details summary::-webkit-details-marker { display: none; }
    .mac-access-details summary:hover { background: var(--ac-blue-100); }
    .mac-access-details summary i { font-size: 10px; transition: transform .2s; margin-left: auto; color: var(--ac-text-muted); }
    .mac-access-details[open] summary i { transform: rotate(180deg); }
    .mac-access-details[open] summary { border-bottom: 1px solid var(--ac-border); }

    .mac-access-body { padding: 16px 18px; background: var(--ac-surface); }

    /* ── Form grid ── */
    .mac-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px 16px;
    }
    .mac-form-grid label {
    display: flex; flex-direction: column; gap: 5px;
    font-size: 12px; font-weight: 600; color: var(--ac-text-2);
    }
    .mac-form-wide { grid-column: 1 / -1; }

    .mac-form-grid input,
    .mac-form-grid select,
    .mac-form-grid textarea {
    height: 36px;
    padding: 0 12px;
    background: var(--ac-surface);
    border: 1px solid var(--ac-border);
    border-radius: var(--r-sm);
    font-size: 13px; color: var(--ac-text);
    font-family: var(--font); outline: none;
    transition: border-color .15s, box-shadow .15s;
    width: 100%;
    }
    .mac-form-grid textarea { height: auto; padding: 10px 12px; resize: vertical; }
    .mac-form-grid input:focus,
    .mac-form-grid select:focus,
    .mac-form-grid textarea:focus {
    border-color: var(--ac-blue-500);
    box-shadow: 0 0 0 3px rgba(37,99,235,0.10);
    background: var(--ac-surface);
    }
    .mac-form-grid input::placeholder,
    .mac-form-grid textarea::placeholder { color: var(--ac-text-muted); }
    .mac-form-grid small { font-size: 11px; color: var(--ac-text-muted); font-weight: 400; margin-top: 2px; }

    /* Checkbox row */
    .mac-checkbox-row {
    display: flex !important; flex-direction: row !important;
    align-items: center; gap: 8px;
    font-size: 13px !important; font-weight: 500 !important;
    color: var(--ac-text-2) !important; cursor: pointer;
    padding: 4px 0;
    }
    .mac-checkbox-row input[type="checkbox"] {
    width: 15px; height: 15px;
    accent-color: var(--ac-accent);
    flex-shrink: 0; cursor: pointer;
    /* override height from generic input rule */
    height: 15px !important; padding: 0 !important;
    }

    /* Form actions row */
    .mac-form-actions {
    display: flex; align-items: center; gap: 8px;
    padding-top: 4px;
    }

    /* Assign form — inside accordion */
    .mac-assign-form { margin-bottom: 16px; }
    .mac-assign-form .mac-form-grid { grid-template-columns: 1fr 1fr; }

    /* Assignee list */
    .mac-assignee-list {
    display: flex; flex-direction: column; gap: 6px;
    padding-top: 12px;
    border-top: 1px solid var(--ac-border);
    margin-top: 4px;
    }
    .mac-assignee-row {
    display: flex; align-items: center; justify-content: space-between;
    gap: 10px; padding: 8px 12px;
    background: var(--ac-surface-2);
    border: 1px solid var(--ac-border);
    border-radius: var(--r-sm);
    }
    .mac-assignee-row strong { display: block; font-size: 13px; font-weight: 600; color: var(--ac-text); }
    .mac-assignee-row small  { display: block; font-size: 11.5px; color: var(--ac-text-muted); margin-top: 1px; }

    /* Owner badge */
    .mac-owner-badge {
    font-size: 10px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em;
    padding: 3px 9px; border-radius: 20px;
    background: var(--ac-blue-50); color: var(--ac-blue-600);
    border: 1px solid var(--ac-blue-200);
    flex-shrink: 0;
    }

    /* Empty state */
    .mac-empty {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    gap: 8px; padding: 40px 24px; text-align: center;
    }
    .mac-empty-icon {
    width: 52px; height: 52px; border-radius: 14px;
    background: var(--ac-blue-50);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: var(--ac-blue-500); margin-bottom: 4px;
    }
    .mac-empty strong { font-size: 14px; font-weight: 700; color: var(--ac-text); }
    .mac-empty span   { font-size: 13px; color: var(--ac-text-muted); max-width: 240px; line-height: 1.5; }

    /* Section divider label */
    .mac-section-sep {
    display: flex; align-items: center; gap: 10px;
    padding: 14px 22px 10px;
    font-size: 10px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .1em;
    color: var(--ac-text-muted);
    border-bottom: 1px solid var(--ac-border);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="mac-wrap">

  
  <header class="mac-page-head">
    <div class="mac-page-head-copy">
      <span class="mac-eyebrow">Mailbox</span>
      <h1>Company email accounts</h1>
      <p>Open an assigned company mailbox or connect an IMAP and SMTP account.</p>
    </div>
    <?php if($accounts->isNotEmpty()): ?>
      <a class="mac-btn" href="<?php echo e(route('mailbox.index')); ?>">
        <i class="fa-solid fa-inbox" style="font-size:12px"></i>
        Open mailbox
      </a>
    <?php endif; ?>
  </header>

  <div class="mac-grid">

    
    <section class="mac-panel">
      <div class="mac-panel-top-line"></div>
      <header class="mac-panel-head">
        <h2>Available accounts</h2>
        <p>You only see company mailboxes assigned to your account.</p>
      </header>

      <div class="mac-acct-list">
        <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

          <article class="mac-acct-card">
            
            <div class="mac-acct-row">
              <span class="mac-dot <?php echo e($account->status === 'active' ? 'is-active' : ''); ?>"></span>
              <div class="mac-acct-info">
                <strong><?php echo e($account->name); ?></strong>
                <small><?php echo e($account->email); ?></small>
                <span><?php echo e($account->emails_count); ?> messages &middot; <?php echo e($account->unread_count); ?> unread</span>
              </div>
              <span class="mac-pill <?php echo e($account->status === 'active' ? 'is-active' : ''); ?>">
                <?php echo e(str($account->status)->headline()); ?>

              </span>
              <a class="mac-btn" href="<?php echo e(route('mailbox.external.show', $account)); ?>">
                <i class="fa-solid fa-arrow-right" style="font-size:11px"></i>
                Open
              </a>
            </div>

            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $account)): ?>
              <details class="mac-access-details">
                <summary>
                  <i class="fa-solid fa-users" style="font-size:11px; margin-right:2px; color:var(--ac-accent)"></i>
                  Manage access
                  <i class="fa-solid fa-chevron-down"></i>
                </summary>
                <div class="mac-access-body">

                  
                  <div class="mac-assign-form">
                    <form method="POST"
                          action="<?php echo e(route('mailbox.accounts.assignments.store', $account)); ?>"
                          class="mac-form-grid">
                      <?php echo csrf_field(); ?>
                      <label class="mac-form-wide">
                        Employee
                        <select name="user_id" required>
                          <option value="">Select employee</option>
                          <?php $__currentLoopData = $assignableUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $person): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($person->id); ?>">
                              <?php echo e($person->name); ?> &middot; <?php echo e($person->role?->name ?? 'Employee'); ?>

                            </option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                      </label>

                      <label class="mac-checkbox-row">
                        <input type="hidden" name="can_view" value="0">
                        <input type="checkbox" name="can_view" value="1" checked>
                        View
                      </label>
                      <label class="mac-checkbox-row">
                        <input type="hidden" name="can_send" value="0">
                        <input type="checkbox" name="can_send" value="1">
                        Send
                      </label>
                      <label class="mac-checkbox-row">
                        <input type="hidden" name="can_manage" value="0">
                        <input type="checkbox" name="can_manage" value="1">
                        Manage account
                      </label>
                      <label class="mac-checkbox-row">
                        <input type="hidden" name="is_default" value="0">
                        <input type="checkbox" name="is_default" value="1">
                        Default account
                      </label>

                      <div class="mac-form-actions mac-form-wide">
                        <button type="submit" class="mac-btn mac-btn-primary">
                          <i class="fa-solid fa-user-plus" style="font-size:11px"></i>
                          Assign access
                        </button>
                      </div>
                    </form>
                  </div>

                  
                  <?php if($account->assignments->isNotEmpty()): ?>
                    <div class="mac-assignee-list">
                      <?php $__currentLoopData = $account->assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mac-assignee-row">
                          <div>
                            <strong><?php echo e($assignment->user?->name); ?></strong>
                            <small>
                              <?php echo e(collect([
                                   $assignment->can_view    ? 'View'    : null,
                                   $assignment->can_send    ? 'Send'    : null,
                                   $assignment->can_manage  ? 'Manage'  : null,
                                   $assignment->is_default  ? 'Default' : null,
                                 ])->filter()->join(' · ')); ?>

                            </small>
                          </div>
                          <?php if($assignment->user_id !== $account->user_id): ?>
                            <form method="POST"
                                  action="<?php echo e(route('mailbox.accounts.assignments.destroy', [$account, $assignment])); ?>"
                                  onsubmit="return confirm('Remove this mailbox assignment?')">
                              <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                              <button type="submit" class="mac-btn mac-btn-danger" style="padding:5px 12px;font-size:12px">
                                <i class="fa-solid fa-trash" style="font-size:10px"></i>
                                Remove
                              </button>
                            </form>
                          <?php else: ?>
                            <span class="mac-owner-badge">Owner</span>
                          <?php endif; ?>
                        </div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                  <?php endif; ?>

                </div>
              </details>
            <?php endif; ?>
          </article>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="mac-empty">
            <div class="mac-empty-icon"><i class="fa-regular fa-envelope"></i></div>
            <strong>Connect company email account</strong>
            <span>An assigned IMAP and SMTP account is required before Mailbox can send or receive email.</span>
          </div>
        <?php endif; ?>
      </div>
    </section>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', App\Models\MailboxAccount::class)): ?>
      <section class="mac-panel">
        <div class="mac-panel-top-line"></div>
        <header class="mac-panel-head">
          <h2>Connect account</h2>
          <p>Use a company mailbox and an app password when the provider requires multi-factor authentication.</p>
        </header>

        <div style="padding:20px 22px 24px">
          <form method="POST" action="<?php echo e(route('mailbox.accounts.store')); ?>" class="mac-form-grid">
            <?php echo csrf_field(); ?>

            
            <label>
              Account name
              <input name="name" required maxlength="120"
                     value="<?php echo e(old('name')); ?>" placeholder="Sales mailbox">
            </label>
            <label>
              Email address
              <input type="email" name="email" required
                     value="<?php echo e(old('email')); ?>" placeholder="sales@company.com">
            </label>

            
            <div class="mac-form-wide" style="border-top:1px solid var(--ac-border);padding-top:14px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--ac-text-muted)">
              IMAP (incoming)
            </div>
            <label>
              IMAP host
              <input name="imap_host" required value="<?php echo e(old('imap_host')); ?>" placeholder="imap.example.com">
            </label>
            <label>
              IMAP port
              <input type="number" name="imap_port" required min="1" max="65535" value="<?php echo e(old('imap_port', 993)); ?>">
            </label>
            <label>
              IMAP security
              <select name="imap_encryption">
                <option value="ssl">SSL</option>
                <option value="tls">TLS</option>
                <option value="">None</option>
              </select>
            </label>
            <label class="mac-checkbox-row" style="align-self:flex-end;padding-bottom:6px">
              <input type="hidden" name="imap_validate_cert" value="0">
              <input type="checkbox" name="imap_validate_cert" value="1" checked>
              Verify server certificate
            </label>

            
            <div class="mac-form-wide" style="border-top:1px solid var(--ac-border);padding-top:14px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--ac-text-muted)">
              SMTP (outgoing)
            </div>
            <label>
              SMTP host
              <input name="smtp_host" required value="<?php echo e(old('smtp_host')); ?>" placeholder="smtp.example.com">
            </label>
            <label>
              SMTP port
              <input type="number" name="smtp_port" required min="1" max="65535" value="<?php echo e(old('smtp_port', 587)); ?>">
            </label>
            <label>
              SMTP security
              <select name="smtp_encryption">
                <option value="tls">TLS</option>
                <option value="ssl">SSL</option>
                <option value="">None</option>
              </select>
            </label>

            
            <div class="mac-form-wide" style="border-top:1px solid var(--ac-border);padding-top:14px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--ac-text-muted)">
              Credentials
            </div>
            <label>
              Username
              <input name="username" required autocomplete="username" value="<?php echo e(old('username')); ?>">
            </label>
            <label>
              Sync interval
              <select name="sync_interval_minutes">
                <option value="5">Every 5 minutes</option>
                <option value="10">Every 10 minutes</option>
                <option value="15">Every 15 minutes</option>
                <option value="30">Every 30 minutes</option>
              </select>
            </label>
            <label class="mac-form-wide">
              Password or app password
              <input type="password" name="secret" required autocomplete="new-password">
              <small>The connection is tested before the account is saved.</small>
            </label>

            
            <div class="mac-form-wide" style="border-top:1px solid var(--ac-border);padding-top:14px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--ac-text-muted)">
              Email signature
            </div>
            <label class="mac-form-wide">
              Signature (optional)
              <textarea name="signature" rows="4" maxlength="5000"
                        placeholder="Name&#10;Title&#10;Company"><?php echo e(old('signature')); ?></textarea>
            </label>

            
            <div class="mac-form-actions mac-form-wide" style="padding-top:4px">
              <button type="submit" class="mac-btn mac-btn-primary">
                <i class="fa-solid fa-plug" style="font-size:11px"></i>
                Test and connect
              </button>
            </div>

          </form>
        </div>
      </section>

    <?php else: ?>
      <section class="mac-panel">
        <div class="mac-panel-top-line"></div>
        <div class="mac-empty" style="padding:60px 24px">
          <div class="mac-empty-icon"><i class="fa-solid fa-lock"></i></div>
          <strong>No mailbox assigned</strong>
          <span>Ask your administrator to assign a company email account to you.</span>
        </div>
      </section>
    <?php endif; ?>

  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-classic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\mailbox\accounts\index.blade.php ENDPATH**/ ?>