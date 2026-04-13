<!DOCTYPE html>
<html lang="id">
<head>
    <title><?= $title ?> | MariMatcha</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <?php 
        $pending_count = $this->db->where('status', 'pending')->count_all_results('sales');
        $notif_orders  = $this->db->where('status', 'pending')->order_by('created_at', 'DESC')->limit(5)->get('sales')->result_array();
    ?>
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
            z-index: 10000; /* Must be higher than overlay (9990) */
            transition: transform .3s cubic-bezier(0.4, 0, 0.2, 1);
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
            width: 50px; height: 50px;
            background: #fff;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
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

        .sidebar-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.45);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 9990; /* High, but lower than sidebar (10000) and ios-navbar (10001) */
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .sidebar-overlay.show { display: block; opacity: 1; }

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
        
        /* ─── NOTIFICATION DROPDOWN ─── */
        .notif-dropdown {
            position: absolute;
            top: 55px;
            right: 0;
            width: 320px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            border: 1px solid #eef2ee;
            display: none;
            flex-direction: column;
            z-index: 1001;
            overflow: hidden;
            animation: slideIn .3s ease;
        }
        @keyframes slideIn { from { transform: translateY(10px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .notif-dropdown.show { display: flex; }
        .notif-header { padding: 15px 20px; background: #f8fbf8; border-bottom: 1px solid #edf1ed; font-weight: 700; font-size: .9rem; display: flex; justify-content: space-between; align-items: center; }
        .notif-body { max-height: 350px; overflow-y: auto; }
        .notif-item { padding: 12px 20px; display: flex; gap: 12px; border-bottom: 1px solid #f9fbf9; text-decoration: none; color: inherit; transition: .2s; }
        .notif-item:hover { background: #f4faf6; }
        .notif-icon { width: 36px; height: 36px; border-radius: 10px; background: #fff3f3; color: #e63946; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .notif-info .title { font-weight: 600; font-size: .85rem; display: block; margin-bottom: 2px; }
        .notif-info .time { font-size: .7rem; color: #8aa898; }
        .notif-footer { padding: 12px; text-align: center; border-top: 1px solid #edf1ed; }
        .notif-footer a { font-size: .75rem; font-weight: 700; color: var(--green-main); text-decoration: none; }

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

        /* ─── FLOATING CAPSULE NAVBAR (MOBILE) ─── */
        /* ─── FLOATING CAPSULE NAVBAR (MOBILE) ─── */
        .ios-navbar {
            display: none;
            position: fixed;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(20, 41, 26, 0.95);
            backdrop-filter: blur(25px) saturate(200%);
            -webkit-backdrop-filter: blur(25px) saturate(200%);
            padding: 8px 12px;
            border-radius: 100px;
            z-index: 10001;
            box-shadow: 0 15px 45px rgba(0,0,0,0.5), inset 0 1px 1px rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.1);
            width: auto;
            min-width: 300px;
            justify-content: space-around;
            align-items: center;
            gap: 5px;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
        }
        .ios-navbar.hide-nav {
            transform: translateX(-50%) translateY(120px);
            opacity: 0;
            pointer-events: none;
        }
        .ios-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            padding: 10px 15px;
            border-radius: 50px;
        }
        .ios-nav-item i {
            font-size: 1.35rem;
            display: block;
            transition: all 0.3s ease;
        }
        /* Floating label above the pill */
        .ios-nav-item span {
            position: absolute;
            top: -35px;
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            background: rgba(45, 106, 79, 0.9);
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 8px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            white-space: nowrap;
            pointer-events: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .ios-nav-item span::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            transform: translateX(-50%);
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid rgba(45, 106, 79, 0.9);
        }

        /* Hover & Active Tooltip */
        .ios-nav-item:hover span, .ios-nav-item.active span {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }

        /* Selected / Active State */
        .ios-nav-item.active {
            color: #fff;
            background: rgba(255,255,255,0.1);
        }
        .ios-nav-item.active i {
            color: #52b788;
            transform: scale(1.1);
            filter: drop-shadow(0 0 8px rgba(82,183,136,0.6));
        }
        .ios-nav-item.active::after {
            content: '';
            position: absolute;
            bottom: 4px;
            width: 5px;
            height: 5px;
            background: #52b788;
            border-radius: 50%;
            box-shadow: 0 0 10px #52b788;
        }

        /* ─── RESPONSIVE OVERHAUL ─── */
        @media (max-width: 768px) {
            :root { --sidebar-w: 0px; }
            .sidebar { 
                transform: translateX(-100%);
                box-shadow: 20px 0 50px rgba(0,0,0,0.3);
            }
            .sidebar.open { transform: translateX(0); }
            
            .topbar {
                left: 0;
                padding: 0 15px;
                height: 60px;
                background: rgba(255,255,255,0.98);
                backdrop-filter: blur(10px);
            }
            .topbar .page-title, .topbar .user-info, .topbar .avatar { display: none; }
            .topbar-actions { margin-left: auto; gap: 8px; }
            .topbar-btn { width: 42px; height: 42px; background: #f8fbf8; }

            .main-content { 
                margin-left: 0; 
                margin-top: 60px; 
                padding: 20px 15px; 
                padding-bottom: 110px; 
            }

            .ios-navbar { display: flex; }
            .page-header-mobile {
                display: block !important;
                margin-bottom: 25px;
                padding: 10px 0;
            }
            .page-header-mobile h4 { font-size: 1.6rem; letter-spacing: -0.5px; }
            
            /* UI SCALE FIXES */
            .stat-card .sc-num { font-size: 1.6rem; }
            .stat-card { padding: 18px; margin-bottom: 12px; }
            .stat-card .sc-label { font-size: 0.75rem; }
            .stat-card .sc-sub { font-size: 0.7rem; }
            
            .row.g-4 > [class*="col-"] { margin-bottom: 0; }
            .row.mb-5 .col-md-3 { width: 50%; } /* 2x2 Grid for stat cards */

            .cc-header { padding: 18px 20px; flex-direction: column; align-items: flex-start; gap: 12px; }
            .cc-title { font-size: 1.1rem; }
            .qa-btn { padding: 18px; font-size: 1rem; }

            /* ─── RESPONSIVE CARD TABLE PATTERN ─── */
            .responsive-card-table table, 
            .responsive-card-table thead, 
            .responsive-card-table tbody, 
            .responsive-card-table th, 
            .responsive-card-table td, 
            .responsive-card-table tr { 
                display: block; 
            }
            .responsive-card-table thead tr { 
                position: absolute; 
                top: -9999px; 
                left: -9999px; 
            }
            .responsive-card-table tr { 
                border: 1px solid #edf2ed;
                border-radius: 16px;
                margin-bottom: 15px;
                padding: 15px;
                background: #fff;
                box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            }
            .responsive-card-table td { 
                border: none !important;
                padding: 10px 0 !important;
                position: relative;
                padding-left: 45% !important;
                text-align: right;
                min-height: 40px;
                font-size: 0.9rem;
            }
            .responsive-card-table td:before { 
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 40%;
                text-align: left;
                font-weight: 700;
                color: #8aa898;
                text-transform: uppercase;
                font-size: 0.7rem;
                letter-spacing: 0.5px;
            }
            .responsive-card-table td:last-child {
                border-top: 1px solid #f5faf5 !important;
                margin-top: 10px;
                padding-top: 15px !important;
                text-align: center;
                padding-left: 0 !important;
            }
            .responsive-card-table td:last-child:before { display: none; }
        }
        .page-header-mobile { display: none; }
    </style>
</head>
<body>

    <!-- SIDEBAR OVERLAY -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- IOS FLOATING BAR (MOBILE) -->
    <nav class="ios-navbar">
        <a href="<?= site_url('dashboard') ?>" class="ios-nav-item <?= ($this->uri->segment(1) == 'dashboard') ? 'active' : '' ?>">
            <i class="bi bi-grid-fill"></i>
            <span>Beranda</span>
        </a>
        <a href="<?= site_url('order') ?>" class="ios-nav-item <?= ($this->uri->segment(1) == 'order' && $this->uri->segment(2) == '') ? 'active' : '' ?>">
            <i class="bi bi-receipt"></i>
            <span>Order</span>
            <?php if(isset($pending_count) && $pending_count > 0): ?>
                <span class="position-absolute border border-light rounded-pill bg-danger" style="top: 0px; right: 8px; font-size: 0.5rem; padding: 1px 4px;">
                    <?= $pending_count ?>
                </span>
            <?php endif; ?>
        </a>
        <a href="<?= site_url('product') ?>" class="ios-nav-item <?= ($this->uri->segment(1) == 'product') ? 'active' : '' ?>">
            <i class="bi bi-cup-straw"></i>
            <span>Produk</span>
        </a>
        <a href="<?= site_url('report') ?>" class="ios-nav-item <?= ($this->uri->segment(1) == 'report') ? 'active' : '' ?>">
            <i class="bi bi-bar-chart-fill"></i>
            <span>Laporan</span>
        </a>
        <a href="<?= site_url('settings') ?>" class="ios-nav-item <?= ($this->uri->segment(1) == 'settings') ? 'active' : '' ?>">
            <i class="bi bi-gear-fill"></i>
            <span>Sistem</span>
        </a>
    </nav>

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
                <h5>MariMatcha</h5>
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
                    <a href="<?= site_url('order') ?>" class="nav-link <?= ($this->uri->segment(1) == 'order' && $this->uri->segment(2) == '') ? 'active' : '' ?>">
                        <i class="bi bi-pc-display-horizontal"></i> Kasir Online
                        <?php if ($pending_count > 0): ?>
                            <span class="nav-badge"><?= $pending_count ?></span>
                        <?php endif; ?>
                    </a>
                </li>



                <div class="nav-section">Laporan</div>
                <li class="nav-item">
                    <a href="<?= site_url('report/daily') ?>" class="nav-link <?= ($this->uri->segment(1) == 'report' && $this->uri->segment(2) == 'daily') ? 'active' : '' ?>">
                        <i class="bi bi-calendar-check-fill"></i> Laporan Hari Ini
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('report/pending') ?>" class="nav-link <?= ($this->uri->segment(1) == 'report' && $this->uri->segment(2) == 'pending') ? 'active' : '' ?>">
                        <i class="bi bi-clock-history"></i> Laporan Pending
                        <?php if($pending_count > 0): ?>
                            <span class="nav-badge"><?= $pending_count ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('report') ?>" class="nav-link <?= ($this->uri->segment(1) == 'report' && $this->uri->segment(2) == '') ? 'active' : '' ?>">
                        <i class="bi bi-person-badge-fill"></i> Laporan User
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('order/history') ?>" class="nav-link <?= ($this->uri->segment(1) == 'order' && $this->uri->segment(2) == 'history') ? 'active' : '' ?>">
                        <i class="bi bi-file-earmark-text-fill"></i> Laporan Order
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
        <?php /*
        <button class="topbar-btn d-md-none border-0" onclick="toggleSidebar()" style="width:38px;height:38px">
            <i class="bi bi-list fs-5"></i>
        </button>
        */ ?>
        <div class="page-title"><?= $title ?></div>
        <div class="topbar-actions">
            <div class="position-relative">
                <button onclick="toggleNotif()" class="topbar-btn" title="Notifikasi">
                    <i class="bi bi-bell-fill"></i>
                    <?php if($pending_count > 0): ?>
                    <span class="notif-dot"></span>
                    <?php endif; ?>
                </button>
                
                <!-- NOTIFICATION DROPDOWN -->
                <div class="notif-dropdown" id="notifDropdown">
                    <div class="notif-header">
                        Pesanan Masuk
                        <span class="badge rounded-pill bg-danger" style="font-size: .65rem;"><?= $pending_count ?> Baru</span>
                    </div>
                    <div class="notif-body">
                        <?php if(empty($notif_orders)): ?>
                            <div class="p-4 text-center text-muted small">Tidak ada pesanan tertunda</div>
                        <?php else: ?>
                            <?php foreach($notif_orders as $no): ?>
                            <a href="<?= site_url('order?date='.date('Y-m-d', strtotime($no['created_at']))) ?>" class="notif-item">
                                <div class="notif-icon"><i class="bi bi-clock-fill"></i></div>
                                <div class="notif-info">
                                    <span class="title">Pesanan <?= $no['invoice_no'] ?></span>
                                    <span class="d-block small text-dark fw-bold"><?= $no['customer_name'] ?> (Rp <?= number_format($no['total_price'], 0, ',', '.') ?>)</span>
                                    <span class="time"><?= date('d M, H:i', strtotime($no['created_at'])) ?></span>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="notif-footer">
                        <a href="<?= site_url('order') ?>">LIHAT SEMUA PESANAN</a>
                    </div>
                </div>
            </div>
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
        <div class="page-header-mobile">
            <h4 class="fw-bold mb-0 text-success"><?= $title ?></h4>
            <div class="small text-muted opacity-75">MariMatcha Admin Panel</div>
        </div>
        <?php if(isset($content)) $this->load->view($content); ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const iosNav = document.querySelector('.ios-navbar');
            
            sidebar.classList.toggle('open');
            if (sidebar.classList.contains('open')) {
                overlay.classList.add('show');
                document.body.style.overflow = 'hidden'; // Stop scrolling
                if(iosNav) iosNav.classList.add('hide-nav'); // Hide pill bar when sidebar open
            } else {
                overlay.classList.remove('show');
                document.body.style.overflow = ''; // Resume scrolling
                if(iosNav) iosNav.classList.remove('hide-nav');
            }
        }

        // Auto-hide Pill Bar on Scroll
        let lastScrollY = window.scrollY;
        window.addEventListener('scroll', () => {
            const iosNav = document.querySelector('.ios-navbar');
            if(!iosNav) return;

            // Only trigger if sidebar is not open
            const sidebar = document.getElementById('sidebar');
            if(sidebar && sidebar.classList.contains('open')) return;

            if (window.scrollY > lastScrollY && window.scrollY > 100) {
                // Scrolling Down -> Hide
                iosNav.classList.add('hide-nav');
            } else {
                // Scrolling Up -> Show
                iosNav.classList.remove('hide-nav');
            }
            lastScrollY = window.scrollY;
        });

        // Toggle Notifications
        function toggleNotif() {
            const dropdown = document.getElementById('notifDropdown');
            dropdown.classList.toggle('show');
            
            // Close when clicking outside
            document.addEventListener('click', function closeNotif(e) {
                if (!e.target.closest('.topbar-actions')) {
                    dropdown.classList.remove('show');
                    document.removeEventListener('click', closeNotif);
                }
            });
        }
    </script>
</body>
</html>
