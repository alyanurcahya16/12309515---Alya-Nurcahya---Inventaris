<?php $__env->startSection('page-title', 'Edit Operator'); ?>

<?php $__env->startSection('dashboard-content'); ?>
<div class="container-fluid">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0 fw-semibold">Edit Account</h5>
        </div>

        <div class="card-body">

            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('operator.users.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="row">

                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="<?php echo e($user->name); ?>"
                               required>
                    </div>

                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="<?php echo e($user->email); ?>"
                               required>
                    </div>

                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">
                            New Password <small class="text-muted">(optional)</small>
                        </label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Leave blank if not changing">
                    </div>

                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-primary px-4">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Alya.Pratiwi\laragon\www\12309515---Alya-Nurcahya---Inventaris\resources\views/operator/users/edit.blade.php ENDPATH**/ ?>