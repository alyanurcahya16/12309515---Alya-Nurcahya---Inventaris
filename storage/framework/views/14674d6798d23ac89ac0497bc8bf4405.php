<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Items List</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 5px; }
        p.sub { text-align: center; color: #666; margin-top: 0; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #343a40; color: white; padding: 8px; text-align: left; }
        td { padding: 7px 8px; border-bottom: 1px solid #dee2e6; }
        tr:nth-child(even) td { background-color: #f8f9fa; }
        .badge-available { color: #198754; font-weight: bold; }
        .badge-empty { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Items List</h2>
    <p class="sub">Generated on <?php echo e(now()->setTimezone('Asia/Jakarta')->format('d M Y, H:i')); ?></p>
    <table>
        <thead>
            <tr>
                <th width="40">#</th>
                <th>Category</th>
                <th>Name</th>
                <th width="60" style="text-align:center">Total</th>
                <th width="80" style="text-align:center">Available</th>
                <th width="100" style="text-align:center">Lending Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td><?php echo e($item->category->name ?? '-'); ?></td>
                <td><?php echo e($item->name); ?></td>
                <td style="text-align:center"><?php echo e($item->total); ?></td>
                <td style="text-align:center">
                    <span class="<?php echo e($item->available > 0 ? 'badge-available' : 'badge-empty'); ?>">
                        <?php echo e($item->available); ?>

                    </span>
                </td>
                <td style="text-align:center"><?php echo e($item->active_lending_count); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" style="text-align:center">No items found</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\Users\Alya.Pratiwi\laragon\www\12309515---Alya-Nurcahya---Inventaris\resources\views/operator/exports/items-pdf.blade.php ENDPATH**/ ?>