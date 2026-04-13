<?php $__env->startSection('role-name', 'Administrator'); ?>
<?php $__env->startSection('page-title', 'Dashboard Overview'); ?>

<?php $__env->startSection('dashboard-content'); ?>
<!-- Welcome Section -->
<div class="card bg-gradient-primary text-white mb-4 border-0">
    <div class="card-body py-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">Welcome back, Administrator!</h4>
                <p class="text-white text-opacity-75 mb-0">Here's what's happening with your inventory today.</p>
            </div>
            <div class="d-none d-md-block">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="avatar-lg bg-primary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center">
                        <svg width="28" height="28" fill="none" stroke="currentColor" class="text-primary" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div>
                    <span class="text-muted text-uppercase fw-bold small">Jenis Barang</span>
                    <h2 class="fw-bold mt-1 mb-0"><?php echo e(number_format($stats['total_items'])); ?></h2>
                    <div class="mt-2">
                        <span class="badge bg-success bg-opacity-10 text-success">+12%</span>
                        <span class="text-muted small ms-1">from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="avatar-lg bg-success bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center">
                        <svg width="28" height="28" fill="none" stroke="currentColor" class="text-success" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <span class="text-muted text-uppercase fw-bold small">Total Stok</span>
                    <h2 class="fw-bold mt-1 mb-0"><?php echo e(number_format($stats['total_qty'])); ?></h2>
                    <div class="mt-2">
                        <span class="badge bg-warning bg-opacity-10 text-warning">+5%</span>
                        <span class="text-muted small ms-1">from last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="avatar-lg bg-info bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center">
                        <svg width="28" height="28" fill="none" stroke="currentColor" class="text-info" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <span class="text-muted text-uppercase fw-bold small">Total Kategori</span>
                    <h2 class="fw-bold mt-1 mb-0"><?php echo e(number_format($stats['categories'])); ?></h2>
                    <div class="mt-2">
                        <span class="badge bg-primary bg-opacity-10 text-primary">+2</span>
                        <span class="text-muted small ms-1">new this month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="avatar-lg bg-purple bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center">
                        <svg width="28" height="28" fill="none" stroke="currentColor" class="text-purple" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <span class="text-muted text-uppercase fw-bold small">Admin Aktif</span>
                    <h2 class="fw-bold mt-1 mb-0"><?php echo e(number_format($stats['users'] ?? 0)); ?></h2>
                    <div class="mt-2">
                        <span class="badge bg-secondary bg-opacity-10 text-secondary">Active</span>
                        <span class="text-muted small ms-1">system users</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity & Quick Actions -->
<div class="row g-4">
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Recent Items</h6>
                    <a href="<?php echo e(route('admin.items.index')); ?>" class="text-decoration-none small">View All →</a>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless">
                        <thead class="text-muted small">
                            <tr>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $recentItems = App\Models\Item::with('category')->latest()->take(5)->get();
                            ?>
                            <?php $__empty_1 = true; $__currentLoopData = $recentItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="fw-semibold"><?php echo e($item->name); ?></td>
                                <td><span class="badge bg-light text-dark"><?php echo e($item->category->name); ?></span></td>
                                <td><?php echo e(number_format($item->total)); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" class="text-muted text-center py-3">No items found</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?php echo e(route('admin.items.index')); ?>" class="btn btn-outline-primary text-start py-3">
                        <svg width="20" height="20" fill="none" stroke="currentColor" class="me-2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Item
                    </a>
                    <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-outline-success text-start py-3">
                        <svg width="20" height="20" fill="none" stroke="currentColor" class="me-2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Manage Categories
                    </a>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-info text-start py-3">
                        <svg width="20" height="20" fill="none" stroke="currentColor" class="me-2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Manage Users
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-lg {
    width: 56px;
    height: 56px;
}
.bg-gradient-primary {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
}
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.01) !important;
}
.text-purple {
    color: #9333ea;
}
.bg-purple {
    background-color: #9333ea;
}
.bg-opacity-10 {
    --bs-bg-opacity: 0.1;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Alya.Pratiwi\laragon\www\12309515---Alya-Nurcahya---Inventaris\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>