<?php $__env->startSection('page-title', 'Items'); ?>

<?php $__env->startSection('dashboard-content'); ?>
<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold">Items Table</h5>
                <small class="text-muted">View inventory & availability</small>
            </div>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('operator.items.export.excel')); ?>" class="btn btn-success btn-sm">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </a>
                <a href="<?php echo e(route('operator.items.export.pdf')); ?>" class="btn btn-danger btn-sm">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Available</th>
                        <th class="text-center">Lending Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><span class="badge bg-light text-dark"><?php echo e($item->category->name ?? '-'); ?></span></td>
                        <td class="fw-semibold"><?php echo e($item->name); ?></td>
                        <td class="text-center"><?php echo e($item->total); ?></td>
                        <td class="text-center">
                            <span class="badge <?php echo e($item->available > 0 ? 'bg-success' : 'bg-danger'); ?>">
                                <?php echo e($item->available); ?>

                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary"><?php echo e($item->active_lending_count); ?></span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">No items found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Alya.Pratiwi\laragon\www\12309515---Alya-Nurcahya---Inventaris\resources\views/operator/items.blade.php ENDPATH**/ ?>