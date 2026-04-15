<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InventarisKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a1a2e;
            --accent: #4f46e5;
            --accent-light: #818cf8;
            --surface: #ffffff;
            --surface-2: #f8f7ff;
            --text: #1a1a2e;
            --text-muted: #6b7280;
            --border: rgba(79, 70, 229, 0.12);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--surface);
            color: var(--text);
            margin: 0;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 14px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.2rem;
            color: var(--primary) !important;
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-icon {
            width: 32px;
            height: 32px;
            background: var(--accent);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 15px;
        }

        .btn-nav-login {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-muted);
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .btn-nav-login:hover { background: var(--surface-2); color: var(--primary); }

        .btn-nav-register {
            font-size: 14px;
            font-weight: 600;
            color: white;
            text-decoration: none;
            padding: 8px 20px;
            background: var(--accent);
            border-radius: 8px;
            transition: all 0.2s;
        }
        .btn-nav-register:hover { background: #4338ca; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(79,70,229,0.3); }

        /* ── HERO ── */
        .hero {
            padding: 96px 0 80px;
            background: var(--surface);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 480px;
            height: 480px;
            background: radial-gradient(circle, rgba(79,70,229,0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -40px;
            left: -40px;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(129,140,248,0.06) 0%, transparent 70%);
            pointer-events: none;
        }

        .badge-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(79,70,229,0.08);
            color: var(--accent);
            font-size: 12.5px;
            font-weight: 600;
            padding: 5px 14px;
            border-radius: 100px;
            letter-spacing: 0.3px;
            margin-bottom: 24px;
            border: 1px solid rgba(79,70,229,0.2);
        }

        .hero h1 {
            font-size: clamp(2.2rem, 5vw, 3.4rem);
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -1.2px;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .hero h1 span {
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.05rem;
            color: var(--text-muted);
            line-height: 1.7;
            max-width: 500px;
            margin: 0 auto 36px;
        }

        .btn-hero-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--accent);
            color: white;
            font-weight: 600;
            font-size: 15px;
            padding: 13px 28px;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(79,70,229,0.35);
        }
        .btn-hero-primary:hover { background: #4338ca; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(79,70,229,0.4); color: white; }

        .btn-hero-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: var(--text);
            font-weight: 600;
            font-size: 15px;
            padding: 13px 28px;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid var(--border);
        }
        .btn-hero-secondary:hover { background: var(--surface-2); transform: translateY(-2px); color: var(--text); }

        /* ── STATS BAR ── */
        .stats-bar {
            background: var(--primary);
            padding: 28px 0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.7rem;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
        }

        .stat-label {
            font-size: 12.5px;
            color: rgba(255,255,255,0.5);
            font-weight: 500;
            margin-top: 2px;
        }

        .stat-divider {
            width: 1px;
            height: 40px;
            background: rgba(255,255,255,0.1);
        }

        /* ── FEATURES ── */
        .features {
            padding: 96px 0;
            background: var(--surface-2);
        }

        .section-label {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 12px;
        }

        .section-title {
            font-size: clamp(1.6rem, 3vw, 2.2rem);
            font-weight: 800;
            letter-spacing: -0.8px;
            color: var(--primary);
            margin-bottom: 12px;
        }

        .section-sub {
            font-size: 1rem;
            color: var(--text-muted);
            max-width: 460px;
            margin: 0 auto 56px;
            line-height: 1.65;
        }

        .feature-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 32px 28px;
            height: 100%;
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            opacity: 0;
            transition: opacity 0.25s;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(79,70,229,0.1);
            border-color: rgba(79,70,229,0.25);
        }

        .feature-card:hover::before { opacity: 1; }

        .feature-icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .icon-indigo { background: rgba(79,70,229,0.1); color: var(--accent); }
        .icon-green  { background: rgba(16,185,129,0.1); color: #059669; }
        .icon-amber  { background: rgba(245,158,11,0.1); color: #d97706; }

        .feature-card h5 {
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: -0.2px;
            margin-bottom: 10px;
            color: var(--primary);
        }

        .feature-card p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.65;
            margin: 0;
        }

        /* ── HOW IT WORKS ── */
        .how-it-works {
            padding: 96px 0;
        }

        .step-number {
            width: 36px;
            height: 36px;
            background: var(--accent);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 20px 0;
            border-bottom: 1px solid var(--border);
        }

        .step-item:last-child { border-bottom: none; }

        .step-text h6 {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 4px;
            color: var(--primary);
        }

        .step-text p {
            font-size: 13.5px;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.6;
        }

        .mockup-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 20px 60px rgba(79,70,229,0.1);
        }

        .mockup-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border);
        }

        .dot { width: 10px; height: 10px; border-radius: 50%; }
        .dot-red { background: #f87171; }
        .dot-yellow { background: #fbbf24; }
        .dot-green { background: #34d399; }

        .mockup-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 6px;
            transition: background 0.2s;
        }
        .mockup-row:hover { background: var(--surface-2); }

        .mockup-row-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .mockup-row-title { font-size: 13px; font-weight: 600; color: var(--primary); }
        .mockup-row-sub { font-size: 11px; color: var(--text-muted); }

        .badge-stock {
            margin-left: auto;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 100px;
        }

        .badge-green { background: rgba(16,185,129,0.1); color: #059669; }
        .badge-red   { background: rgba(239,68,68,0.1); color: #dc2626; }
        .badge-amber { background: rgba(245,158,11,0.1); color: #d97706; }

        /* ── CTA ── */
        .cta-section {
            background: var(--primary);
            padding: 80px 0;
            text-align: center;
        }

        .cta-section h2 {
            font-size: clamp(1.7rem, 3vw, 2.4rem);
            font-weight: 800;
            letter-spacing: -1px;
            color: white;
            margin-bottom: 14px;
        }

        .cta-section p {
            color: rgba(255,255,255,0.55);
            font-size: 1rem;
            margin-bottom: 36px;
        }

        .btn-cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: var(--accent);
            font-weight: 700;
            font-size: 15px;
            padding: 14px 32px;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.2); color: var(--accent); }

        /* ── FOOTER ── */
        footer {
            background: #0f0f1a;
            color: rgba(255,255,255,0.4);
            padding: 24px 0;
            text-align: center;
            font-size: 13px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="container d-flex align-items-center justify-content-between">
        <a class="navbar-brand" href="#">
            <div class="brand-icon"><i class="bi bi-box-seam-fill"></i></div>
            InventarisKu
        </a>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('login') }}" class="btn-nav-login">Masuk</a>
            <a href="{{ route('register') }}" class="btn-nav-register">Daftar Gratis</a>
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="hero">
    <div class="container text-center position-relative">
        <div class="badge-tag">
            <i class="bi bi-stars"></i> Sistem Inventaris Modern
        </div>
        <h1>Kelola Inventaris<br><span>Lebih Mudah & Efisien</span></h1>
        <p>Satu platform untuk manajemen item, peminjaman barang, dan request perbaikan. Semua terpantau secara real-time.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('register') }}" class="btn-hero-primary">
                Mulai Sekarang <i class="bi bi-arrow-right"></i>
            </a>
            <a href="{{ route('login') }}" class="btn-hero-secondary">
                <i class="bi bi-box-arrow-in-right"></i> Sudah punya akun?
            </a>
        </div>
    </div>
</section>

<!-- Stats Bar -->
<div class="stats-bar">
    <div class="container">
        <div class="row align-items-center justify-content-center g-0">
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Berbasis Web</div>
                </div>
            </div>
            <div class="col-auto d-none d-md-flex"><div class="stat-divider"></div></div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">Real-time</div>
                    <div class="stat-label">Tracking Peminjaman</div>
                </div>
            </div>
            <div class="col-auto d-none d-md-flex"><div class="stat-divider"></div></div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">Export</div>
                    <div class="stat-label">Laporan Excel & CSV</div>
                </div>
            </div>
            <div class="col-auto d-none d-md-flex"><div class="stat-divider"></div></div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">Multi</div>
                    <div class="stat-label">Kategori Item</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features -->
<section class="features">
    <div class="container">
        <div class="text-center">
            <div class="section-label">Fitur Unggulan</div>
            <h2 class="section-title">Semua yang Kamu Butuhkan</h2>
            <p class="section-sub">Dirancang untuk mempermudah pengelolaan aset dan barang organisasi atau perusahaanmu.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon-wrap icon-indigo"><i class="bi bi-boxes"></i></div>
                    <h5>Manajemen Item</h5>
                    <p>Catat, kategorikan, dan pantau stok barang dengan mudah. Mendukung penambahan item secara massal.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon-wrap icon-green"><i class="bi bi-arrow-left-right"></i></div>
                    <h5>Tracking Peminjaman</h5>
                    <p>Pantau status peminjaman secara real-time. Catat siapa yang meminjam, kapan, dan kapan dikembalikan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon-wrap icon-amber"><i class="bi bi-tools"></i></div>
                    <h5>Request Perbaikan</h5>
                    <p>Kelola permintaan perbaikan barang dengan alur yang jelas dari pengajuan hingga selesai.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="how-it-works">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <div class="section-label">Cara Kerja</div>
                <h2 class="section-title">Sederhana,<br>Tapi Powerful</h2>
                <p style="color: var(--text-muted); font-size: 14.5px; line-height: 1.7; margin-bottom: 36px;">Mulai kelola inventaris dalam hitungan menit tanpa setup yang rumit.</p>

                <div class="step-item">
                    <div class="step-number">1</div>
                    <div class="step-text">
                        <h6>Daftar & Masuk</h6>
                        <p>Buat akun gratis dan login ke dashboard InventarisKu.</p>
                    </div>
                </div>
                <div class="step-item">
                    <div class="step-number">2</div>
                    <div class="step-text">
                        <h6>Tambahkan Item</h6>
                        <p>Input data barang beserta kategori, jumlah, dan informasi lainnya.</p>
                    </div>
                </div>
                <div class="step-item">
                    <div class="step-number">3</div>
                    <div class="step-text">
                        <h6>Kelola & Pantau</h6>
                        <p>Catat peminjaman, request perbaikan, dan ekspor laporan kapan saja.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="mockup-card">
                    <div class="mockup-header">
                        <div class="dot dot-red"></div>
                        <div class="dot dot-yellow"></div>
                        <div class="dot dot-green"></div>
                        <span style="font-size: 12px; color: var(--text-muted); margin-left: 8px; font-weight: 500;">Daftar Inventaris</span>
                    </div>

                    <div class="mockup-row">
                        <div class="mockup-row-icon icon-indigo"><i class="bi bi-laptop"></i></div>
                        <div>
                            <div class="mockup-row-title">Laptop Dell XPS 15</div>
                            <div class="mockup-row-sub">Elektronik · Stok: 8 unit</div>
                        </div>
                        <span class="badge-stock badge-green">Tersedia</span>
                    </div>
                    <div class="mockup-row">
                        <div class="mockup-row-icon icon-amber"><i class="bi bi-camera-video"></i></div>
                        <div>
                            <div class="mockup-row-title">Kamera Sony A7 III</div>
                            <div class="mockup-row-sub">Elektronik · Stok: 2 unit</div>
                        </div>
                        <span class="badge-stock badge-amber">Terbatas</span>
                    </div>
                    <div class="mockup-row">
                        <div class="mockup-row-icon" style="background: rgba(239,68,68,0.1); color: #dc2626;"><i class="bi bi-projector"></i></div>
                        <div>
                            <div class="mockup-row-title">Proyektor Epson EB</div>
                            <div class="mockup-row-sub">AV · Stok: 0 unit</div>
                        </div>
                        <span class="badge-stock badge-red">Habis</span>
                    </div>
                    <div class="mockup-row">
                        <div class="mockup-row-icon icon-green"><i class="bi bi-mouse2"></i></div>
                        <div>
                            <div class="mockup-row-title">Mouse Logitech MX</div>
                            <div class="mockup-row-sub">Periferal · Stok: 15 unit</div>
                        </div>
                        <span class="badge-stock badge-green">Tersedia</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container">
        <h2>Siap Mulai Kelola Inventaris?</h2>
        <p>Gratis untuk digunakan. Tidak perlu kartu kredit.</p>
        <a href="{{ route('register') }}" class="btn-cta">
            <i class="bi bi-rocket-takeoff-fill"></i> Daftar Sekarang
        </a>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <p class="mb-0">&copy; 2024 InventarisKu &mdash; Sistem Manajemen Inventaris</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
