

<?php $__env->startSection('title', 'Login — Builder360 ERP CRM'); ?>

<?php $__env->startSection('content'); ?>
<main style="min-height:100vh;display:grid;place-items:center;background:var(--bg);padding:24px">
        <section class="card" style="width:min(100%,440px);padding:28px">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:22px">
                <div class="sb-logo" style="position:static">B</div>
                <div>
                    <h1 style="margin:0;font-size:24px">Builder360 Login</h1>
                    <p style="margin:4px 0 0;color:var(--muted)">Secure ERP–CRM workspace access</p>
                </div>
            </div>

            <form method="POST" action="<?php echo e(route('login.store')); ?>" novalidate>
                <?php echo csrf_field(); ?>

                <label style="display:block;margin-bottom:14px">
                    <span style="display:block;font-weight:700;margin-bottom:6px">Email</span>
                    <input
                        name="email"
                        type="email"
                        value="<?php echo e(old('email')); ?>"
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
                    <span style="display:block;font-weight:700;margin-bottom:6px">Password</span>
                    <input
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
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

                <label style="display:flex;align-items:center;gap:8px;margin-bottom:18px;color:var(--muted);font-size:14px">
                    <input name="remember" type="checkbox" value="1">
                    Remember this device
                </label>

                <button class="btn btn-primary" type="submit" style="width:100%;justify-content:center">
                    Login to Builder360
                </button>

                <div style="margin-top:14px;text-align:center">
                    <a href="<?php echo e(route('password.request')); ?>" style="color:var(--accent);font-weight:700;text-decoration:none">
                        Forgot password?
                    </a>
                </div>
            </form>

        </section>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.builder360-auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/developer/public_html/builder360/resources/views/auth/login.blade.php ENDPATH**/ ?>