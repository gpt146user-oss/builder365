

<?php $__env->startSection('title', 'Set New Password — Builder360 ERP CRM'); ?>

<?php $__env->startSection('content'); ?>
<main style="min-height:100vh;display:grid;place-items:center;background:var(--bg);padding:24px">
        <section class="card" style="width:min(100%,480px);padding:28px">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:22px">
                <div class="sb-logo" style="position:static">B</div>
                <div>
                    <h1 style="margin:0;font-size:24px">Set New Password</h1>
                    <p style="margin:4px 0 0;color:var(--muted)">Use the reset link to create a stronger Builder360 password.</p>
                </div>
            </div>

            <form method="POST" action="<?php echo e(route('password.store')); ?>" novalidate>
                <?php echo csrf_field(); ?>

                <input type="hidden" name="token" value="<?php echo e($token); ?>">

                <label style="display:block;margin-bottom:14px">
                    <span style="display:block;font-weight:700;margin-bottom:6px">Email</span>
                    <input
                        name="email"
                        type="email"
                        value="<?php echo e(old('email', $email)); ?>"
                        required
                        autofocus
                        autocomplete="username"
                        style="width:100%;padding:12px 14px;border:1px solid var(--line);border-radius:12px;background:var(--surface);color:var(--text)"
                    >
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="display:block;margin-top:6px;color:var(--red);font-size:13px"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label style="display:block;margin-bottom:14px">
                    <span style="display:block;font-weight:700;margin-bottom:6px">New Password</span>
                    <input
                        name="password"
                        type="password"
                        required
                        autocomplete="new-password"
                        style="width:100%;padding:12px 14px;border:1px solid var(--line);border-radius:12px;background:var(--surface);color:var(--text)"
                    >
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="display:block;margin-top:6px;color:var(--red);font-size:13px"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label style="display:block;margin-bottom:18px">
                    <span style="display:block;font-weight:700;margin-bottom:6px">Confirm New Password</span>
                    <input
                        name="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        style="width:100%;padding:12px 14px;border:1px solid var(--line);border-radius:12px;background:var(--surface);color:var(--text)"
                    >
                </label>

                <button class="btn btn-primary" type="submit" style="width:100%;justify-content:center">
                    Reset password
                </button>
            </form>

            <div style="margin-top:18px;padding:12px;border:1px solid var(--line);border-radius:12px;background:var(--surface-2);font-size:13px;color:var(--muted)">
                Password must be at least 10 characters and include uppercase, lowercase, number and symbol characters.
            </div>
        </section>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Mataji\Desktop\Codex1\Builder360\laravel-builder360\resources\views\auth\reset-password.blade.php ENDPATH**/ ?>