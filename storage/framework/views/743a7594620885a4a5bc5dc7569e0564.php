<?php $__env->startSection('page-title', 'Manage Categories'); ?>

<?php $__env->startSection('dashboard-content'); ?>
<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-0">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h5 class="fw-bold mb-0">Categories Table</h5>
                <p class="text-muted small mb-0 mt-1">Manage system categories and divisions</p>
            </div>
            <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <svg width="14" height="14" fill="none" stroke="currentColor" class="me-1" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Category
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-muted small text-uppercase fw-bold">
                        <th width="50" class="text-center">#</th>
                        <th>Category Name</th>
                        <th>Division PJ</th>
                        <th width="80" class="text-center">Items</th>
                        <th width="140" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-center text-muted"><?php echo e($index + 1); ?></td>
                        <td class="fw-semibold"><?php echo e($category->name); ?></td>
                        <td>
                            <?php
                                $badgeClass = match($category->division_pj) {
                                    'Sarpras' => 'bg-primary',
                                    'Tata Usaha' => 'bg-purple',
                                    'tefa' => 'bg-warning text-dark',
                                    default => 'bg-secondary'
                                };
                            ?>
                            <span class="badge <?php echo e($badgeClass); ?>"><?php echo e($category->division_pj); ?></span>
                        </td>
                        <td class="text-center fw-bold"><?php echo e(number_format($category->items->count())); ?></td>
                        <td class="text-center">
                            <button type="button" 
                                    class="btn btn-outline-primary btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal<?php echo e($category->id); ?>">
                                Edit
                            </button>
                            <form action="<?php echo e(route('admin.categories.destroy', $category->id)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?> 
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" 
                                        class="btn btn-outline-danger btn-sm" 
                                        onclick="return confirm('Delete this category? All items in this category will also be deleted.')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?php echo e($category->id); ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content border-0 shadow-lg">
                                <div class="modal-header border-0 bg-light">
                                    <h5 class="modal-title fw-bold">Edit Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="<?php echo e(route('admin.categories.update', $category->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?> 
                                    <?php echo method_field('PUT'); ?>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Category Name</label>
                                            <input type="text" 
                                                   name="name" 
                                                   value="<?php echo e(old('name', $category->name)); ?>" 
                                                   class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   placeholder="Enter category name"
                                                   required>
                                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Division PJ</label>
                                            <select name="division_pj" 
                                                    class="form-select <?php $__errorArgs = ['division_pj'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                    required>
                                                <option value="Sarpras" <?php echo e(old('division_pj', $category->division_pj) == 'Sarpras' ? 'selected' : ''); ?>>Sarpras</option>
                                                <option value="Tata Usaha" <?php echo e(old('division_pj', $category->division_pj) == 'Tata Usaha' ? 'selected' : ''); ?>>Tata Usaha</option>
                                                <option value="tefa" <?php echo e(old('division_pj', $category->division_pj) == 'tefa' ? 'selected' : ''); ?>>tefa</option>
                                            </select>
                                            <?php $__errorArgs = ['division_pj'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted">
                                <svg width="64" height="64" fill="none" stroke="currentColor" class="mb-3 opacity-25" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="mb-0 fw-semibold">No categories recorded</p>
                                <small>Click "Add Category" to create one</small>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 bg-light">
                <h5 class="modal-title fw-bold">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin.categories.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category Name</label>
                        <input type="text" 
                               name="name" 
                               value="<?php echo e(old('name')); ?>" 
                               class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               placeholder="e.g., Electronics, Furniture, etc."
                               required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Division PJ</label>
                        <select name="division_pj" 
                                class="form-select <?php $__errorArgs = ['division_pj'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                required>
                            <option value="" disabled <?php echo e(old('division_pj') ? '' : 'selected'); ?>>Select Division</option>
                            <option value="Sarpras" <?php echo e(old('division_pj') == 'Sarpras' ? 'selected' : ''); ?>>Sarpras</option>
                            <option value="Tata Usaha" <?php echo e(old('division_pj') == 'Tata Usaha' ? 'selected' : ''); ?>>Tata Usaha</option>
                            <option value="tefa" <?php echo e(old('division_pj') == 'tefa' ? 'selected' : ''); ?>>tefa</option>
                        </select>
                        <?php $__errorArgs = ['division_pj'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark">Register Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.bg-purple {
    background-color: #9333ea;
}
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
}
</style>
<?php $__env->stopSection(); ?>

<!-- <?php $__env->startSection('scripts'); ?>
<script>
    // Auto show modal if there are validation errors
    <?php if($errors->any()): ?>
        <?php if(session('edit_fail_id')): ?>
            var myModal = new bootstrap.Modal(document.getElementById('editModal<?php echo e(session('edit_fail_id')); ?>'));
        <?php else: ?>
            var myModal = new bootstrap.Modal(document.getElementById('addCategoryModal'));
        <?php endif; ?>
        myModal.show();
    <?php endif; ?>
</script>
<?php $__env->stopSection(); ?> -->
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Alya.Pratiwi\laragon\www\12309515---Alya-Nurcahya---Inventaris\resources\views/admin/categories.blade.php ENDPATH**/ ?>