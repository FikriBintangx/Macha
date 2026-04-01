<!DOCTYPE html>
<html lang="id">
<head>
    <title><?= $title ?> | MariMacha</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-w: 260px;
            --green-ultra: #102416;
            --green-dark:  #102416;
            --green-main:  #1B3B25;
            --green-light: #53725D;
            --cream:       #F5F5F0;
            --sidebar-bg:  #1B3B25;
            --sidebar-sec: #53725D;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Outfit', sans-serif;
            display: flex;
            min-height: 100vh;
            background: var(--cream);
            color: #1a2e25;
        }

        /* ─── SIDEBAR ─── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            color: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 1000;
            transition: width .3s ease;
            overflow: hidden;
        }
        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #fff;
        }
        .sidebar-brand:hover { color: #fff; }
        .brand-icon {
            width: 40px; height: 40px;
            background: #fff;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            color: var(--green-main);
            flex-shrink: 0;
            overflow: hidden;
        }
        .brand-text h5 { font-weight: 800; font-size: 1.1rem; margin: 0; }
        .brand-text small { color: rgba(255,255,255,.5); font-size: .72rem; }

        .sidebar-scroll { flex: 1; overflow-y: auto; overflow-x: hidden; padding: 16px 12px; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 4px; }

        .nav-section {
            font-size: .68rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255,255,255,.35);
            padding: 16px 14px 6px;
            font-weight: 600;
        }
        .nav-item { list-style: none; margin-bottom: 2px; }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 12px;
            color: rgba(255,255,255,.65) !important;
            text-decoration: none;
            font-weight: 500;
            font-size: .9rem;
            transition: all .2s ease;
            position: relative;
        }
        .nav-link i { font-size: 1.05rem; width: 20px; flex-shrink: 0; }
        .nav-link:hover {
            background: rgba(255,255,255,.08);
            color: #fff !important;
        }
        .nav-link.active {
            background: linear-gradient(135deg, var(--green-main), #52b788);
            color: #fff !important;
            box-shadow: 0 4px 14px rgba(64,145,108,.35);
        }
        .nav-badge {
            margin-left: auto;
            background: #e63946;
            color: #fff;
            font-size: .65rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
        }
        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,.08);
        }
        .nav-link.logout { color: rgba(239,68,68,.8) !important; }
        .nav-link.logout:hover { background: rgba(239,68,68,.12); color: #ef4444 !important; }

        /* ─── TOPBAR ─── */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-w);
            right: 0;
            height: 68px;
            background: #fff;
            border-bottom: 1px solid #e9ede9;
            display: flex;
            align-items: center;
            padding: 0 28px;
            z-index: 900;
            gap: 16px;
        }
        .page-title { font-weight: 700; font-size: 1.1rem; color: #1a2e25; flex: 1; }
        .topbar-actions { display: flex; align-items: center; gap: 12px; }
        .topbar-btn {
            width: 38px; height: 38px;
            border-radius: 10px;
            border: 1px solid #e5ebe5;
            background: #f8fbf8;
            display: flex; align-items: center; justify-content: center;
            color: #6b9080;
            cursor: pointer;
            transition: .2s;
            text-decoration: none;
            position: relative;
        }
        .topbar-btn:hover { background: #e8f4ee; color: var(--green-main); }
        .notif-dot {
            position: absolute;
            top: 6px; right: 6px;
            width: 8px; height: 8px;
            background: #e63946;
            border-radius: 50%;
            border: 2px solid #fff;
        }
        .avatar {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--green-main), var(--green-light));
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: .9rem;
            cursor: pointer;
        }
        .user-info { text-align: right; }
        .user-info .name { font-weight: 700; font-size: .88rem; color: #1a2e25; }
        .user-info .role { font-size: .73rem; color: #8aa898; }

        /* ─── MAIN CONTENT ─── */
        .main-content {
            margin-left: var(--sidebar-w);
            margin-top: 68px;
            flex: 1;
            padding: 28px;
            min-height: calc(100vh - 68px);
        }

        /* ─── STAT CARDS ─── */
        .stat-card {
            border-radius: 18px;
            padding: 24px;
            color: #fff;
            position: relative;
            overflow: hidden;
            border: none;
            transition: transform .25s, box-shadow .25s;
        }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(0,0,0,.15); }
        .stat-card .sc-icon {
            position: absolute;
            right: -12px; bottom: -12px;
            font-size: 5.5rem;
            opacity: .14;
        }
        .stat-card .sc-label { font-size: .72rem; text-transform: uppercase; letter-spacing: 1.5px; opacity: .8; font-weight: 600; margin-bottom: 8px; }
        .stat-card .sc-num { font-size: 2.2rem; font-weight: 800; line-height: 1; }
        .stat-card .sc-sub { font-size: .78rem; opacity: .75; margin-top: 6px; }
        .sc-green  { background: linear-gradient(135deg, #1b4d3e, #40916c); }
        .sc-red    { background: linear-gradient(135deg, #9b2335, #e63946); }
        .sc-amber  { background: linear-gradient(135deg, #7c4b00, #d4a017); }
        .sc-blue   { background: linear-gradient(135deg, #1a4971, #2196f3); }
        .sc-purple { background: linear-gradient(135deg, #4a1a7a, #8b5cf6); }

        /* ─── CONTENT CARD ─── */
        .cc {
            background: #fff;
            border-radius: 18px;
            border: 1px solid #e9ede9;
            overflow: hidden;
        }
        .cc-header {
            padding: 18px 22px;
            border-bottom: 1px solid #f1f5f1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .cc-title { font-weight: 700; font-size: .95rem; color: #1a2e25; }
        .cc-body { padding: 0; }

        /* ─── TABLE ─── */
        .table { margin: 0; }
        .table thead th {
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #8aa898;
            font-weight: 600;
            background: #f8fbf8;
            border-bottom: 1px solid #edf1ed;
            padding: 12px 18px;
        }
        .table tbody tr { border-bottom: 1px solid #f5f8f5; }
        .table tbody tr:last-child { border-bottom: none; }
        .table tbody td { padding: 14px 18px; vertical-align: middle; color: #2c3e30; }
        .table tbody tr:hover td { background: #fafcfa; }

        /* ─── STATUS BADGES ─── */
        .sbadge { padding: 4px 12px; border-radius: 50px; font-size: .73rem; font-weight: 700; }
        .sb-pending   { background: #fff3e0; color: #e65100; }
        .sb-paid      { background: #e3f2fd; color: #1565c0; }
        .sb-shipped   { background: #e8f5e9; color: #2e7d32; }
        .sb-completed { background: #e0f7fa; color: #006064; }
        .sb-canceled  { background: #fce4ec; color: #880e4f; }

        /* ─── QUICK ACTION ─── */
        .qa-btn {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            border-radius: 14px;
            text-decoration: none;
            transition: .2s;
            font-weight: 600;
            font-size: .9rem;
            border: 1.5px solid transparent;
        }
        .qa-btn .qa-icon {
            width: 42px; height: 42px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        .qa-primary {
            background: linear-gradient(135deg, var(--green-dark), var(--green-main));
            color: #fff;
            box-shadow: 0 6px 18px rgba(64,145,108,.3);
        }
        .qa-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(64,145,108,.4); color: #fff; }
        .qa-outline {
            background: #f8fbf8;
            border-color: #dce8dc;
            color: #2d5a40;
        }
        .qa-outline:hover { background: #e8f4ee; border-color: var(--green-main); color: var(--green-dark); }

        /* ─── LOW STOCK ITEM ─── */
        .ls-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 22px;
            border-bottom: 1px solid #f5f8f5;
        }
        .ls-item:last-child { border-bottom: none; }
        .ls-dot {
            width: 10px;height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .dot-danger { background: #e63946; }
        .dot-warn   { background: #f4a261; }
        .ls-name { font-weight: 600; font-size: .9rem; }
        .ls-stock { margin-left: auto; font-weight: 800; font-size: .9rem; }

        /* ─── REALTIME CLOCK ─── */
        .clock-display {
            background: linear-gradient(135deg, var(--green-ultra), var(--green-dark));
            border-radius: 14px;
            padding: 14px 20px;
            color: #fff;
            text-align: center;
        }
        .clock-time { font-size: 1.8rem; font-weight: 800; letter-spacing: 2px; }
        .clock-date { font-size: .78rem; opacity: .7; margin-top: 2px; }

        /* ─── ORDER QUICK VIEW ─── */
        .oqv-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 22px;
            border-bottom: 1px solid #f5f8f5;
        }
        .oqv-item:last-child { border-bottom: none; }
        .oqv-avatar {
            width: 34px; height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, #e8f4ee, #c4e0cc);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .8rem;
            color: var(--green-dark);
            flex-shrink: 0;
        }

        /* ─── SCROLLBAR ─── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #c8d8c8; border-radius: 4px; }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .topbar { left: 0; }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <a href="<?= base_url() ?>" class="sidebar-brand">
            <div class="brand-icon">
                <?php $shop_logo = $this->M_settings->get_setting('shop_logo'); ?>
                <?php if(!empty($shop_logo)): ?>
                    <img src="<?= base_url('uploads/'.$shop_logo) ?>" alt="Logo" style="width:100%; height:100%; object-fit:cover;">
                <?php else: ?>
                    <i class="bi bi-box-seam-fill"></i>
                <?php endif; ?>
            </div>
            <div class="brand-text">
                <h5>MariMacha</h5>
                <small>Admin Panel</small>
            </div>
        </a>

        <div class="sidebar-scroll">
            <ul class="nav flex-column">
                <div class="nav-section">Utama</div>
                <li class="nav-item">
                    <a href="<?= site_url('dashboard') ?>" class="nav-link <?= ($this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '') ? 'active' : '' ?>">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>
                </li>

                <div class="nav-section">Produk & Stok</div>
                <li class="nav-item">
                    <a href="<?= site_url('product') ?>" class="nav-link <?= ($this->uri->segment(1) == 'product' && $this->uri->segment(2) == '') ? 'active' : '' ?>">
                        <i class="bi bi-cup-hot-fill"></i> Manajemen Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('product/add') ?>" class="nav-link <?= ($this->uri->segment(1) == 'product' && $this->uri->segment(2) == 'add') ? 'active' : '' ?>">
                        <i class="bi bi-plus-circle-fill"></i> Tambah Produk
                    </a>
                </li>

                <div class="nav-section">Transaksi</div>
                <li class="nav-item">
                    <a href="<?= site_url('order') ?>" class="nav-link <?= ($this->uri->segment(1) == 'order') ? 'active' : '' ?>">
                        <i class="bi bi-bag-heart-fill"></i> Pesanan Online
                        <?php
                            $pending_count = $this->db->where('status', 'pending')->count_all_results('sales');
                            if ($pending_count > 0): ?>
                            <span class="nav-badge"><?= $pending_count ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('sales') ?>" class="nav-link <?= ($this->uri->segment(1) == 'sales') ? 'active' : '' ?>">
                        <i class="bi bi-cart-check-fill"></i> Kasir (POS)
                    </a>
                </li>

                <div class="nav-section">Laporan</div>
                <li class="nav-item">
                    <a href="<?= site_url('report') ?>" class="nav-link <?= ($this->uri->segment(1) == 'report' && $this->uri->segment(2) == '') ? 'active' : '' ?>">
                        <i class="bi bi-bar-chart-line-fill"></i> Laporan Semua
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('report/daily') ?>" class="nav-link <?= ($this->uri->segment(1) == 'report' && $this->uri->segment(2) == 'daily') ? 'active' : '' ?>">
                        <i class="bi bi-calendar-check-fill"></i> Laporan Hari Ini
                    </a>
                </li>

                <div class="nav-section">Sistem</div>
                <li class="nav-item">
                    <a href="<?= site_url('settings') ?>" class="nav-link <?= ($this->uri->segment(1) == 'settings') ? 'active' : '' ?>">
                        <i class="bi bi-gear-fill"></i> Pengaturan Toko
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?= base_url() ?>" class="nav-link" target="_blank">
                        <i class="bi bi-shop"></i> Lihat Toko
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('auth/logout') ?>" class="nav-link logout">
                        <i class="bi bi-box-arrow-left"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- TOPBAR -->
    <header class="topbar">
        <button class="topbar-btn d-md-none border-0" onclick="toggleSidebar()" style="width:38px;height:38px">
            <i class="bi bi-list fs-5"></i>
        </button>
        <div class="page-title"><?= $title ?></div>
        <div class="topbar-actions">
            <a href="<?= site_url('order') ?>" class="topbar-btn" title="Pesanan Baru">
                <i class="bi bi-bell-fill"></i>
                <?php if($pending_count > 0): ?>
                <span class="notif-dot"></span>
                <?php endif; ?>
            </a>
            <a href="<?= base_url('shop') ?>" class="topbar-btn" title="Lihat Toko">
                <i class="bi bi-shop"></i>
            </a>
            <div class="user-info">
                <div class="name"><?= htmlspecialchars($this->session->userdata('full_name')) ?></div>
                <div class="role">Administrator</div>
            </div>
            <div class="avatar"><?= strtoupper(substr($this->session->userdata('full_name'), 0, 1)) ?></div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <?php if(isset($content)) $this->load->view($content); ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }
    </script>
</body>
</html>
