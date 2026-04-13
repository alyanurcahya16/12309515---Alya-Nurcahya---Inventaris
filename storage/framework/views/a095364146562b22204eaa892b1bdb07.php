<?php $__env->startSection('page-title', 'Lendings'); ?>

<?php $__env->startSection('dashboard-content'); ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Lending List</h4>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('operator.lendings.export.excel')); ?>" class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
            <a href="<?php echo e(route('operator.lendings.export.pdf')); ?>" class="btn btn-danger btn-sm">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addLendingModal">
                + Add Lending
            </button>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Total</th>
                            <th>Name</th>
                            <th>Note</th>
                            <th>Date & Time</th>
                            <th>Returned</th>
                            <th>Edited By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $lendings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td><?php echo e($l->item->name ?? '-'); ?></td>
                                <td><?php echo e($l->total ?? '-'); ?></td>
                                <td><?php echo e($l->user ?? '-'); ?></td>
                                <td><?php echo e($l->note ?? '-'); ?></td>
                                <td><?php echo e($l->datetime ? \Carbon\Carbon::parse($l->datetime)->setTimezone('Asia/Jakarta')->format('d M Y, H:i') : '-'); ?>

                                </td>

                                
                                <td>
                                    <?php if($l->returned && $l->return_date): ?>
                                        <span class="badge bg-success">
                                            <?php echo e(\Carbon\Carbon::parse($l->return_date)->setTimezone('Asia/Jakarta')->format('d M Y, H:i')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Not Returned</span>
                                    <?php endif; ?>
                                </td>

                                
                                <td><?php echo e($l->edited_by ?? '-'); ?></td>

                                
                                <td>
                                    <?php if(!$l->returned): ?>
                                        <form action="<?php echo e(route('operator.lendings.return', $l->id)); ?>" method="POST"
                                            class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="btn btn-success btn-sm">Return</button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>Returned</button>
                                    <?php endif; ?>

                                    <form action="<?php echo e(route('operator.lendings.destroy', $l->id)); ?>" method="POST"
                                        class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this lending record?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">No lending records found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Add Lending -->
    <div class="modal fade" id="addLendingModal" tabindex="-1" aria-labelledby="addLendingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLendingModalLabel">Add New Lending</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('operator.lendings.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div id="items-wrapper">

                            <div class="item-group border rounded p-3 mb-3 position-relative">

                                
                                <button type="button"
                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-item d-none">
                                    ✕
                                </button>

                                <div class="mb-3">
                                    <label class="form-label">Item Name</label>
                                    <select class="form-select" name="item_id[]" required>
                                        <option value="" disabled selected>Select Item</option>
                                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item->id); ?>">
                                                <?php echo e($item->name); ?> (Available: <?php echo e($item->available ?? 0); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Total Quantity</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="total[]" min="1"
                                            value="1" required>
                                        <span class="input-group-text">Unit(s)</span>
                                    </div>
                                </div>

                            </div>

                        </div>

                        
                        <button type="button" id="add-item" class="btn btn-outline-primary w-100 mb-3">
                            + More Item
                        </button>

                        <div class="mb-3">
                            <label for="user" class="form-label">Borrower Name</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="user"
                                name="user" value="<?php echo e(old('user')); ?>" placeholder="Enter full name" required>
                            <?php $__errorArgs = ['user'];
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
                            <label for="note" class="form-label">Note <span class="text-muted">(Optional)</span></label>
                            <textarea class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="note" name="note" rows="2"
                                placeholder="Any additional information..."><?php echo e(old('note')); ?></textarea>
                            <?php $__errorArgs = ['note'];
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
                            <label for="datetime" class="form-label">Date & Time</label>
                            <input type="datetime-local" class="form-control <?php $__errorArgs = ['datetime'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="datetime" name="datetime" value="<?php echo e(old('datetime', date('Y-m-d\TH:i'))); ?>"
                                required>
                            <?php $__errorArgs = ['datetime'];
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Lending</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        let index = 1;

        document.getElementById('add-item').addEventListener('click', function() {
            let wrapper = document.getElementById('items-wrapper');

            let html = `
    <div class="item-row mb-3 border p-3 rounded">
        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Item Name</label>
                <select class="form-select" name="items[${index}][item_id]" required>
                    <option value="">Select Item</option>
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($item->id); ?>">
                            <?php echo e($item->name); ?> (Available: <?php echo e($item->available ?? 0); ?>)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Total</label>
                <input type="number" class="form-control" name="items[${index}][total]" min="1" required>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-item">X</button>
            </div>
        </div>
    </div>
    `;

            wrapper.insertAdjacentHTML('beforeend', html);
            index++;
        });

        // REMOVE ITEM
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.closest('.item-row').remove();
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Alya.Pratiwi\laragon\www\12309515---Alya-Nurcahya---Inventaris\resources\views/operator/lendings.blade.php ENDPATH**/ ?>