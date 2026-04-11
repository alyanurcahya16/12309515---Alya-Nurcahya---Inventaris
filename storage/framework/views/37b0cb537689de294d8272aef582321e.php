<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?> - Inventaris</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
        }

        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            width: 260px;
            height: calc(100vh - 70px);
            background: white;
            border-right: 1px solid #e2e8f0;
            overflow-y: auto;
            z-index: 1030;
            transition: transform 0.3s ease;
            scrollbar-width: thin;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .main-content {
            margin-left: 260px;
            margin-top: 70px;
            /* 🔥 penting supaya tidak ketabrak navbar */
            transition: margin 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        .nav-link-custom {
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            color: #475569;
            font-weight: 600;
            transition: all 0.2s;
        }

        .nav-link-custom:hover {
            background-color: #f1f5f9;
            color: #3b82f6;
        }

        .nav-link-custom.active {
            background-color: #eff6ff;
            color: #3b82f6;
        }

        .nav-link-custom i {
            width: 24px;
            margin-right: 12px;
        }

        .section-title {
            font-size: 0.7rem;
            letter-spacing: 0.1em;
            color: #94a3b8;
            font-weight: 700;
        }

        .navbar-custom {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 1.5rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
        }


        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>

    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body>
    <?php $user = Auth::user(); ?>

    <!-- Navbar -->
    <nav class="navbar-custom fixed-top">
        <div class="container-fluid d-flex justify-content-between align-items-center">

            <!-- LEFT SIDE -->
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-link text-dark p-0 d-md-none" id="sidebarToggle">
                    <i class="bi bi-list fs-3"></i>
                </button>

                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary rounded-3 p-2">
                        <i class="bi bi-box-seam text-white fs-5"></i>
                    </div>
                    <div>
                        <h1 class="fs-5 fw-bold mb-0">Inventaris</h1>
                        <small class="text-muted">Sistem manajemen aset</small>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="d-none d-sm-flex flex-column text-end me-2">
                    <span class="fw-semibold text-dark lh-1"><?php echo e($user->name); ?></span>
                    <small class="text-muted">Status: Online</small>
                </div>

                <div class="dropdown">
                    <button class="btn btn-link p-0" type="button" data-bs-toggle="dropdown">
                        <img class="avatar"
                            src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name ?? 'U')); ?>&background=0284c7&color=fff&bold=true">
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                        <li><a class="dropdown-item" href="#">
                                <i class="bi bi-person me-2"></i> Profile
                            </a></li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form action="<?php echo e(route('logout')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </nav>

   <aside class="sidebar" id="sidebar">
    <div class="p-4 pt-5">
        <ul class="nav flex-column gap-2">
            <li>
                <a href="/<?php echo e(auth()->user()->role); ?>/dashboard" class="nav-link-custom d-flex align-items-center <?php echo e(request()->is(auth()->user()->role.'/dashboard') ? 'active' : ''); ?>">
                    <i class="bi bi-house-door fs-5"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="mt-3">
                <div class="section-title mb-2 px-3">ITEMS DATA</div>
            </li>

            <?php if(auth()->user()->role === 'admin'): ?>
                <li>
                    <a href="/admin/categories" class="nav-link-custom d-flex align-items-center <?php echo e(request()->is('admin/categories') ? 'active' : ''); ?>">
                        <i class="bi bi-tags fs-5"></i>
                        <span>Categories</span>
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <a href="/operator/lendings" class="nav-link-custom d-flex align-items-center <?php echo e(request()->is('operator/lendings') ? 'active' : ''); ?>">
                        <i class="bi bi-journal-check fs-5"></i>
                        <span>Lendings</span>
                    </a>
                </li>
            <?php endif; ?>

            <li>
                <a href="/<?php echo e(auth()->user()->role); ?>/items" class="nav-link-custom d-flex align-items-center <?php echo e(request()->is(auth()->user()->role.'/items') ? 'active' : ''); ?>">
                    <i class="bi bi-box fs-5"></i>
                    <span>Items</span>
                </a>
            </li>

            <li class="mt-3">
                <div class="section-title mb-2 px-3">ACCOUNTS</div>
            </li>

            <!-- Dropdown Users -->
            <li class="nav-item dropdown">
                <a href="#" class="nav-link-custom d-flex align-items-center dropdown-toggle <?php echo e(request()->is(auth()->user()->role.'/users*') ? 'active' : ''); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-people fs-5"></i>
                    <span>Users</span>
                </a>
                <ul class="dropdown-menu px-2 py-2">
                    <li>
                        <a class="dropdown-item <?php echo e(request()->is('admin/users-admin') ? 'active' : ''); ?>" href="/admin/users-admin">
                            Admin
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item <?php echo e(request()->is('admin/users-user') ? 'active' : ''); ?>" href="/admin/users-user">
                            Operator
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="container-fluid p-4" style="margin-top: 70px;">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <i class="bi bi-house-door me-1"></i>
                        <a href="/admin/dashboard" class="text-decoration-none">Dashboard</a>
                    </li>
                    <?php echo $__env->yieldContent('breadcrumb'); ?>
                </ol>
            </nav>

            <!-- Page Header -->
            <div class="mb-4">
                <h2 class="fw-bold mb-1"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h2>
                <p class="text-muted">Selamat datang di panel kontrol Inventaris. Pilih menu untuk mulai mengelola data.</p>
            </div>

            <!-- Content -->
            <?php echo $__env->yieldContent('dashboard-content'); ?>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar toggle for mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');

            if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
                if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    </script>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html><?php /**PATH C:\laragon\www\Inventaris\resources\views/layouts/dashboard.blade.php ENDPATH**/ ?>