<?php $__env->startSection('content'); ?>
<div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="row justify-content-center w-100">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <!-- Card Login -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <!-- Logo & Title -->
                    <div class="text-center mb-4">
                        <div class="bg-primary-100 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 70px; height: 70px;">
                            <i class="bi bi-box-seam fs-1 text-primary-600"></i>
                        </div>
                        <h2 class="fw-bold mb-2">Welcome Back</h2>
                        <p class="text-muted">Sign in to continue to your account</p>
                    </div>

                    <!-- Error Alert -->
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Login Form -->
                    <form action="<?php echo e(route('login')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-1"></i> Email Address
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-envelope text-muted"></i>
                                </span>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="form-control border-start-0 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('email')); ?>"
                                       placeholder="name@example.com"
                                       required>
                            </div>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                <i class="bi bi-lock me-1"></i> Password
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock text-muted"></i>
                                </span>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control border-start-0"
                                       placeholder="Enter your password"
                                       required>
                                <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label small" for="remember">Remember me</label>
                            </div>
                            <a href="#" class="text-decoration-none small">Forgot password?</a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mb-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                        </button>

                        <!-- Divider -->
                        <div class="text-center position-relative my-3">
                            <hr class="text-muted">
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">or</span>
                        </div>

                        <!-- Register Link -->
                        <div class="text-center">
                            <p class="mb-0 text-muted">
                                Don't have an account?
                                <a href="<?php echo e(route('register')); ?>" class="text-decoration-none fw-semibold">
                                    Create Account
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer Text -->
            <div class="text-center mt-4">
                <p class="text-muted small">
                    <i class="bi bi-shield-check"></i> Secure login with SSL encryption
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Styles */
    .btn-primary {
        background: linear-gradient(135deg, #4f61f7 0%, #6c5ce7 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(79, 97, 247, 0.3);
        background: linear-gradient(135deg, #5c6df8 0%, #7b6ee8 100%);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 30px 40px -15px rgba(0, 0, 0, 0.15) !important;
    }

    .form-control, .input-group-text {
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #4f61f7;
        box-shadow: 0 0 0 3px rgba(79, 97, 247, 0.1);
    }

    .input-group:focus-within .input-group-text {
        border-color: #4f61f7;
        background-color: #f8f9ff;
    }

    .form-check-input:checked {
        background-color: #4f61f7;
        border-color: #4f61f7;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .card-body {
            padding: 1.5rem !important;
        }
    }
</style>

<?php $__env->startSection('scripts'); ?>
<script>
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    if (togglePassword && password) {
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            const icon = this.querySelector('i');
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    }

    // Auto dismiss alert after 5 seconds
    const alert = document.querySelector('.alert');
    if (alert) {
        setTimeout(() => {
            alert.classList.remove('show');
            setTimeout(() => alert.remove(), 150);
        }, 5000);
    }
</script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Alya.Pratiwi\laragon\www\12309515---Alya-Nurcahya---Inventaris\resources\views/auth/login.blade.php ENDPATH**/ ?>