<?php $__env->startSection('page-title', 'Manage Items'); ?>

<?php $__env->startSection('dashboard-content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 fw-bold">Items Table</h5>
                    <small class="text-muted">Manage inventory items with repair and lending status</small>
                </div>
                <div class="d-flex gap-2">
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Export
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo e(route('admin.items.export.excel')); ?>">
                                <i class="bi bi-file-earmark-excel"></i> Export to Excel
                            </a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('admin.items.export.pdf')); ?>">
                                <i class="bi bi-file-earmark-pdf"></i> Export to PDF
                            </a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">
                        + Add Item
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="itemsTable">
                    <thead class="table-light">
                        <tr>
                            <th width="40" class="text-center">
                                <small>#</small>
                            </th>
                            <th class="text-start">
                                <small>Category</small>
                            </th>
                            <th class="text-start">
                                <small>Item Name</small>
                            </th>
                            <th width="110" class="text-center">
                                <small>Total Stock</small>
                            </th>
                            <th width="100" class="text-center">
                                <small>Repair</small>
                            </th>
                            <th width="130" class="text-center">
                                <small>Active Lending</small>
                            </th>
                            <th width="140" class="text-center">
                                <small>Actions</small>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center text-muted"><?php echo e($index + 1); ?></td>
                                <td class="text-start">
                                    <span class="badge bg-light text-dark"><?php echo e($item->category->name); ?></span>
                                </td>
                                <td class="fw-semibold"><?php echo e($item->name); ?></td>
                                <td class="text-center fw-bold text-primary"><?php echo e(number_format($item->total)); ?></td>

                                
                                <td class="text-center">
                                    <?php
                                        $repairCount = isset($repairCounts[$item->category->name])
                                            ? $repairCounts[$item->category->name]
                                            : 0;
                                    ?>
                                    <?php if($repairCount > 0): ?>
                                        <span class="badge bg-danger">
                                            🔧 <?php echo e($repairCount); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">
                                            ✓ 0
                                        </span>
                                    <?php endif; ?>
                                </td>

                                
                                <td class="text-center">
                                    <?php
                                        $activeLending = $item->active_lending_count ?? 0;
                                    ?>
                                    <?php if($activeLending > 0): ?>
                                        <span class="badge bg-warning">
                                            📤 <?php echo e($activeLending); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-success">
                                            ✓ Tersedia
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editItemModal<?php echo e($item->id); ?>">
                                            Edit
                                        </button>
                                        <form action="<?php echo e(route('admin.items.destroy', $item->id)); ?>" method="POST"
                                            class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Delete this item?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            

                            <!-- Edit Item Modal -->
                            <div class="modal fade" id="editItemModal<?php echo e($item->id); ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Item</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="<?php echo e(route('admin.items.update', $item->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Category</label>
                                                    <select name="category_id"
                                                        class="form-select <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        required>
                                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($category->id); ?>"
                                                                <?php echo e(old('category_id', $item->category_id) == $category->id ? 'selected' : ''); ?>>
                                                                <?php echo e($category->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <?php $__errorArgs = ['category_id'];
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
                                                    <label class="form-label">Item Name</label>
                                                    <input type="text" name="name"
                                                        value="<?php echo e(old('name', $item->name)); ?>"
                                                        class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
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
                                                    <label class="form-label">Total Stock</label>
                                                    <input type="number" name="total"
                                                        value="<?php echo e(old('total', $item->total)); ?>"
                                                        class="form-control <?php $__errorArgs = ['total'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                                    <?php $__errorArgs = ['total'];
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
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <div class="py-4">
                                        <i class="bi bi-box" style="font-size: 40px;"></i>
                                        <p class="mb-0 mt-2">No items found</p>
                                    </div>
                                </td>

                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Item Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Register New Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('admin.items.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Item Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Quantity</label>
                            <input type="number" name="total" value="10" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-dark">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Auto show modal if there are validation errors
    <?php if($errors->any()): ?>
        <?php if(session('edit_item_fail_id')): ?>
            var myModal = new bootstrap.Modal(document.getElementById('editItemModal<?php echo e(session('edit_item_fail_id')); ?>'));
        <?php else: ?>
            var myModal = new bootstrap.Modal(document.getElementById('addItemModal'));
        <?php endif; ?>
        myModal.show();
    <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Alya.Pratiwi\laragon\www\12309515---Alya-Nurcahya---Inventaris\resources\views/admin/items.blade.php ENDPATH**/ ?>