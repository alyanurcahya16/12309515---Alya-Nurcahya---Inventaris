<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lending List</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        h2 { text-align: center; margin-bottom: 5px; }
        p.sub { text-align: center; color: #666; margin-top: 0; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #343a40; color: white; padding: 7px 8px; text-align: left; }
        td { padding: 6px 8px; border-bottom: 1px solid #dee2e6; }
        tr:nth-child(even) td { background-color: #f8f9fa; }
        .badge-returned { color: #198754; font-weight: bold; }
        .badge-not { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Lending List</h2>
    <p class="sub">Generated on <?php echo e(now()->setTimezone('Asia/Jakarta')->format('d M Y, H:i')); ?></p>
    <table>
        <thead>
            <tr>
                <th width="30">#</th>
                <th>Item</th>
                <th width="50">Total</th>
                <th>Borrower</th>
                <th>Note</th>
                <th>Date & Time</th>
                <th>Returned</th>
                <th>Edited By</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $lendings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td><?php echo e($l->item->name ?? '-'); ?></td>
                <td><?php echo e($l->total); ?></td>
                <td><?php echo e($l->user); ?></td>
                <td><?php echo e($l->note ?? '-'); ?></td>
                <td><?php echo e($l->datetime ? \Carbon\Carbon::parse($l->datetime)->setTimezone('Asia/Jakarta')->format('d M Y, H:i') : '-'); ?></td>
                <td>
                    <?php if($l->returned && $l->return_date): ?>
                        <span class="badge-returned">
                            <?php echo e(\Carbon\Carbon::parse($l->return_date)->setTimezone('Asia/Jakarta')->format('d M Y, H:i')); ?>

                        </span>
                    <?php else: ?>
                        <span class="badge-not">Not Returned</span>
                    <?php endif; ?>
                </td>
                <td><?php echo e($l->edited_by ?? '-'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" style="text-align:center">No lending records found</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\Users\Alya.Pratiwi\laragon\www\12309515---Alya-Nurcahya---Inventaris\resources\views/operator/exports/lendings-pdf.blade.php ENDPATH**/ ?>