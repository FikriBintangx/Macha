<!DOCTYPE html>
<?php
$CI =& get_instance();
$CI->load->model('M_settings');
$pending_count = 0;
$notif_orders = [];
$shop_logo = $CI->M_settings->get_setting('shop_logo');

if (isset($CI->db)) {
    /** @var CI_DB_query_builder $db */
    $db = $CI->db;
    $pending_count = $db->where('status', 'pending')->count_all_results('sales');
    $notif_orders = $db->where('status', 'pending')->order_by('created_at', 'DESC')->limit(5)->get('sales')->result_array();
}
?>

<html lang="id">

<head>
    <title><?= $title ?> | <?= $this->M_settings->get_setting('shop_name') ?: 'MariMatcha' ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if(!empty($shop_logo)): ?>
        <link rel="icon" type="image/x-icon" href="<?= base_url('uploads/'.$shop_logo) ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- UI Enhancement Dependencies -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <style>
        :root {
            --sidebar-w: 260px;
            --green-ultra: #102416;
            --green-dark: #102416;
            --green-main: #1B3B25;
            --green-light: #53725D;
            --tertiary: #8BAA7C;
            --cream: #F5F5F0;
            --sidebar-bg: #1B3B25;
            --sidebar-sec: #53725D;
            --glass: rgba(255, 255, 255, 0.7);

            /* Spacing Tokens */
            --space-micro: 4px;
            --space-sm: 8px;
            --space-md: 16px;
            --space-lg: 24px;
            --space-xl: 32px;

            /* Radius Tokens */
            --radius-sm: 10px;
            --radius-md: 18px;
            --radius-lg: 28px;
            --radius-xl: 35px;
            
            /* Typography Tokens */
            --text-xs: 0.75rem;
            --text-sm: 0.875rem;
            --text-md: 1rem;
            --text-lg: 1.25rem;
            --text-xl: 2rem;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            overflow-x: hidden;
            width: 100%;
            max-width: 100%;
        }

        body {
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            background: var(--cream);
            background-image: url("https://www.transparenttextures.com/patterns/p6.png");
            /* Subtle Paper Texture */
            color: #1a2e25;
            display: flex;
            flex-direction: column;
        }

        /* ─── SIDEBAR ─── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            color: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 10000;
            transition: transform .3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #fff;
        }

        .sidebar-brand:hover {
            color: #fff;
        }

        .brand-icon {
            width: 50px;
            height: 50px;
            background: #fff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: var(--green-main);
            flex-shrink: 0;
            overflow: hidden;
        }

        .brand-text h5 {
            font-weight: 800;
            font-size: 1.1rem;
            margin: 0;
        }

        .brand-text small {
            color: rgba(255, 255, 255, .5);
            font-size: .72rem;
        }

        .sidebar-scroll {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 16px 12px;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .15);
            border-radius: 4px;
        }

        .nav-section {
            font-size: .68rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, .35);
            padding: 16px 14px 6px;
            font-weight: 600;
        }

        .nav-item {
            list-style: none;
            margin-bottom: 2px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 12px;
            color: rgba(255, 255, 255, .65) !important;
            text-decoration: none;
            font-weight: 500;
            font-size: .9rem;
            transition: all .2s ease;
            position: relative;
        }

        .nav-link i {
            font-size: 1.05rem;
            width: 20px;
            flex-shrink: 0;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, .08);
            color: #fff !important;
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.08);
            color: #fff !important;
            box-shadow: inset 4px 0 0 var(--tertiary), inset 15px 0 20px rgba(139, 170, 124, 0.05);
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
            border-top: 1px solid rgba(255, 255, 255, .08);
        }

        .nav-link.logout {
            color: rgba(239, 68, 68, .8) !important;
        }

        .nav-link.logout:hover {
            background: rgba(239, 68, 68, .12);
            color: #ef4444 !important;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 9990;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        /* ─── TOPBAR ─── */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-w);
            right: 0;
            height: 68px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(233, 237, 233, 0.5);
            display: flex;
            align-items: center;
            padding: 0 28px;
            z-index: 900;
            gap: 16px;
        }

        .page-title {
            font-weight: 800;
            font-size: 1.2rem;
            color: #1a2e25;
            flex: 1;
            letter-spacing: -0.5px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid #e5ebe5;
            background: #f8fbf8;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b9080;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            text-decoration: none;
            position: relative;
        }

        .topbar-btn:hover {
            background: #e8f4ee;
            color: var(--green-main);
            transform: scale(1.08);
        }

        .notif-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background: #e63946;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--green-main), var(--green-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: .9rem;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .user-info {
            text-align: right;
        }

        .user-info .name {
            font-weight: 700;
            font-size: .88rem;
            color: #1a2e25;
        }

        .user-info .role {
            font-size: .73rem;
            color: #8aa898;
        }

        /* ─── COMMAND PALETTE (Alt+K) ─── */
        #commandPalette .modal-content {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 24px;
        }

        .search-input-group {
            background: #f1f5f2;
            border-radius: 16px;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-input-group input {
            background: transparent;
            border: none;
            width: 100%;
            font-size: 1.1rem;
            outline: none;
        }

        .command-item {
            padding: 12px 20px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: #333;
            transition: 0.2s;
            margin-bottom: 5px;
        }

        .command-item:hover {
            background: var(--green-main);
            color: #fff;
            transform: translateX(5px);
        }

        .command-item i {
            width: 24px;
            text-align: center;
        }

        .kb-hint {
            font-size: 0.7rem;
            background: #eee;
            padding: 2px 6px;
            border-radius: 4px;
            color: #666;
            font-family: monospace;
        }

        /* ─── FLOATING ACTION BUTTON ─── */
        .fab-container {
            position: fixed;
            bottom: 40px;
            right: 40px;
            z-index: 998;
            display: flex;
            flex-direction: column-reverse;
            gap: 15px;
            transition: all 0.3s ease;
        }

        .fab-main {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--green-main);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(27, 59, 37, 0.4);
            cursor: pointer;
            border: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            font-size: 1.5rem;
        }

        .fab-main:hover {
            transform: scale(1.1) rotate(90deg);
            background: var(--green-dark);
        }

        .fab-label {
            position: absolute;
            right: 70px;
            background: #333;
            color: #fff;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .fab-main:hover+.fab-label {
            opacity: 1;
            right: 80px;
        }

        @media (max-width: 768px) {
            .fab-container {
                bottom: 100px;
                right: 20px;
            }
        }

        /* ─── NOTIFICATION DROPDOWN ─── */
        .notif-dropdown {
            position: absolute;
            top: 55px;
            right: 0;
            width: 320px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.5);
            display: none;
            flex-direction: column;
            z-index: 1001;
            overflow: hidden;
            transform-origin: top right;
        }

        .notif-header {
            padding: 15px 20px;
            background: #f8fbf8;
            border-bottom: 1px solid #edf1ed;
            font-weight: 700;
            font-size: .9rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notif-body {
            max-height: 350px;
            overflow-y: auto;
        }

        .notif-item {
            padding: 12px 20px;
            display: flex;
            gap: 12px;
            border-bottom: 1px solid #f9fbf9;
            text-decoration: none;
            color: inherit;
            transition: .2s;
        }

        .notif-item:hover {
            background: #f4faf6;
        }

        .notif-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #fff3f3;
            color: #e63946;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notif-info .title {
            font-weight: 600;
            font-size: .85rem;
            display: block;
            margin-bottom: 2px;
        }

        .notif-info .time {
            font-size: .7rem;
            color: #8aa898;
        }

        .notif-footer {
            padding: 12px;
            text-align: center;
            border-top: 1px solid #edf1ed;
        }

        .notif-footer a {
            font-size: .75rem;
            font-weight: 700;
            color: var(--green-main);
            text-decoration: none;
        }

        /* ─── MAIN CONTENT ─── */
        .main-content {
            margin-left: var(--sidebar-w);
            margin-top: 68px;
            width: calc(100% - var(--sidebar-w));
            padding: 28px;
            min-height: calc(100vh - 138px);
            /* Account for topbar and potential footer */
            background: var(--cream);
        }


        /* ─── STAT CARDS ─── */
        .stat-card {
            border-radius: var(--radius-md);
            padding: var(--space-lg);
            color: #fff;
            position: relative;
            overflow: hidden;
            border: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .stat-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            z-index: 10;
        }

        .stat-card .sc-icon {
            position: absolute;
            right: -12px;
            bottom: -12px;
            font-size: 5.5rem;
            opacity: .14;
        }

        .stat-card .sc-label {
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            opacity: .8;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .stat-card .sc-num {
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1;
        }

        .sc-green {
            background: linear-gradient(135deg, #1b4d3e, #40916c);
        }

        .sc-red {
            background: linear-gradient(135deg, #9b2335, #e63946);
        }

        .sc-amber {
            background: linear-gradient(135deg, #7c4b00, #d4a017);
        }

        /* ─── RESPONSIVE OVERHAUL ─── */
        @media (max-width: 768px) {
            :root {
                --sidebar-w: 0px;
            }

            .sidebar {
                transform: translateX(-100%);
                box-shadow: 20px 0 50px rgba(0, 0, 0, 0.3);
            }

            .sidebar.open {
                transform: translateX(0);
                z-index: 10001;
            }

            .topbar {
                left: 0;
                padding: 0 15px;
                height: 60px;
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(10px);
                z-index: 9999;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 15px;
                padding-top: 80px;
                min-height: calc(100vh - 100px);
            }

            .page-title {
                font-size: 1rem;
            }

            /* Responsive Tables (Card Stack Pattern) */
            .responsive-card-table table, 
            .responsive-card-table thead, 
            .responsive-card-table tbody, 
            .responsive-card-table th, 
            .responsive-card-table td, 
            .responsive-card-table tr { 
                display: block !important; 
                width: 100% !important; 
            }

            .responsive-card-table thead tr { 
                display: none !important; 
            }

            .responsive-card-table tr {
                background: #fff;
                border: 1px solid rgba(0,0,0,0.05);
                border-radius: 16px;
                margin-bottom: 15px;
                padding: 10px 0;
                box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            }

            .responsive-card-table td {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                padding: 10px 20px !important;
                border-bottom: 1px solid rgba(0,0,0,0.03) !important;
                text-align: right;
            }

            .responsive-card-table td:last-child {
                border-bottom: none !important;
            }

            .responsive-card-table td::before {
                content: attr(data-label);
                float: left;
                font-weight: 800;
                text-transform: uppercase;
                font-size: 0.7rem;
                color: var(--green-light);
                opacity: 0.7;
            }

            .stat-card {
                padding: 18px;
            }
            .stat-card .sc-num {
                font-size: 1.8rem;
            }

            .topbar .page-title,
            .topbar .user-info,
            .topbar .avatar {
                display: none;
            }

            .topbar-actions {
                margin-left: auto;
                gap: 8px;
            }
        }

        .page-header-mobile {
            display: none;
        }

        .ios-navbar {
            display: none;
        }

        @media (max-width: 768px) {
            .ios-navbar {
                display: flex;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                height: 70px;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border-top: 1px solid rgba(0,0,0,0.05);
                z-index: 9995;
                padding: 0 15px;
                justify-content: space-around;
                align-items: center;
                box-shadow: 0 -10px 25px rgba(0,0,0,0.05);
            }

            .page-header-mobile {
                display: block;
                margin-bottom: 25px;
                padding: 10px 0;
            }

            .page-header-mobile h4 {
                font-size: 1.6rem;
                letter-spacing: -0.5px;
                font-weight: 800;
                color: var(--green-main);
            }
        }

        .page-header-mobile {
            display: none;
        }

        /* SKELETON LOADER */


        /* ── GLOBAL TABLE ALIGNMENT FIX ── */
        .table th,
        .table td {
            text-align: center !important;
            vertical-align: middle !important;
            color: #212529 !important;
        }

        .table td[data-label="GAMBAR"],
        .table td[data-label="PRODUK & SKU"] {
            text-align: left !important;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>



    <!-- IOS NAVBAR (MOBILE) -->
    <nav class="ios-navbar">
        <a href="<?= site_url('dashboard') ?>"
            class="ios-nav-item <?= ($this->uri->segment(1) == 'dashboard') ? 'active' : '' ?>">
            <i class="bi bi-grid-fill"></i>
            <span>Beranda</span>
        </a>
        <a href="<?= site_url('order') ?>"
            class="ios-nav-item <?= ($this->uri->segment(1) == 'order') ? 'active' : '' ?>">
            <i class="bi bi-receipt"></i>
            <span>Order</span>
        </a>
        <a href="<?= site_url('product') ?>"
            class="ios-nav-item <?= ($this->uri->segment(1) == 'product') ? 'active' : '' ?>">
            <i class="bi bi-cup-straw"></i>
            <span>Produk</span>
        </a>
        <a href="<?= site_url('report') ?>"
            class="ios-nav-item <?= ($this->uri->segment(1) == 'report') ? 'active' : '' ?>">
            <i class="bi bi-bar-chart-fill"></i>
            <span>Laporan</span>
        </a>
        <a href="<?= site_url('settings') ?>"
            class="ios-nav-item <?= ($this->uri->segment(1) == 'settings') ? 'active' : '' ?>">
            <i class="bi bi-gear-fill"></i>
            <span>Sistem</span>
        </a>
    </nav>
    
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- MAIN WRAPPER -->
    <div class="d-flex w-100 h-100">

        <!-- SIDEBAR COMPONENT -->
        <aside class="sidebar" id="adminSidebar">
            <a href="<?= base_url() ?>" class="sidebar-brand">
            <div class="brand-icon">
                <?php if (!empty($shop_logo)): ?>
                    <img src="<?= base_url('uploads/' . $shop_logo) ?>" alt="Logo"
                        style="width:100%; height:100%; object-fit:contain; background: white; border-radius: 8px; padding: 4px;">
                <?php else: ?>
                    <i class="bi bi-box-seam-fill"></i>
                <?php endif; ?>
            </div>
            <div class="brand-text">
                <h5 class="mb-0"><?= $this->M_settings->get_setting('shop_name') ?: 'MariMatcha' ?></h5>
                <small class="opacity-75">Admin Panel</small>
            </div>
        </a>

        <div class="sidebar-scroll">
            <ul class="nav flex-column">
                <div class="nav-section">Utama</div>
                <li class="nav-item">
                    <a href="<?= site_url('dashboard') ?>"
                        class="nav-link <?= ($this->uri->segment(1) == 'dashboard') ? 'active' : '' ?>">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>
                </li>

                <div class="nav-section">Katalog & Menu</div>
                <li class="nav-item">
                    <a href="<?= site_url('product') ?>"
                        class="nav-link <?= ($this->uri->segment(1) == 'product' && $this->uri->segment(2) == '') ? 'active' : '' ?>">
                        <i class="bi bi-cup-hot-fill"></i> Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('product/add') ?>"
                        class="nav-link <?= ($this->uri->segment(1) == 'product' && $this->uri->segment(2) == 'add') ? 'active' : '' ?>">
                        <i class="bi bi-plus-circle-fill"></i> Tambah Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('settings?tab=categories') ?>"
                        class="nav-link <?= ($this->input->get('tab') == 'categories') ? 'active' : '' ?>">
                        <i class="bi bi-tags-fill"></i> Kategori
                    </a>
                </li>

                <div class="nav-section">Transaksi</div>
                <li class="nav-item">
                    <a href="<?= site_url('order') ?>"
                        class="nav-link <?= ($this->uri->segment(1) == 'order' && $this->uri->segment(2) == '') ? 'active' : '' ?>">
                        <i class="bi bi-pc-display-horizontal"></i> Kasir Online
                        <?php if ($pending_count > 0): ?>
                            <span class="nav-badge"><?= $pending_count ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('order/history') ?>"
                        class="nav-link <?= ($this->uri->segment(1) == 'order' && $this->uri->segment(2) == 'history') ? 'active' : '' ?>">
                        <i class="bi bi-receipt-cutoff"></i> Riwayat
                    </a>
                </li>

                <div class="nav-section">Users</div>
                <li class="nav-item">
                    <a href="<?= site_url('admin_users') ?>"
                        class="nav-link <?= ($this->uri->segment(1) == 'admin_users' && $this->uri->segment(2) == '') ? 'active' : '' ?>">
                        <i class="bi bi-person-gear"></i> Admin & Staff
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('admin_users/customers') ?>"
                        class="nav-link <?= ($this->uri->segment(1) == 'admin_users' && $this->uri->segment(2) == 'customers') ? 'active' : '' ?>">
                        <i class="bi bi-people-fill"></i> Pelanggan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('admin_suppliers') ?>"
                        class="nav-link <?= ($this->uri->segment(1) == 'admin_suppliers') ? 'active' : '' ?>">
                        <i class="bi bi-truck"></i> Supplier
                    </a>
                </li>

                <div class="nav-section">Laporan</div>
                <li class="nav-item">
                    <a href="<?= site_url('report/daily') ?>"
                        class="nav-link <?= ($this->uri->segment(2) == 'daily') ? 'active' : '' ?>">
                        <i class="bi bi-calendar-check-fill"></i> Hari Ini
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('report/pending') ?>"
                        class="nav-link <?= ($this->uri->segment(2) == 'pending') ? 'active' : '' ?>">
                        <i class="bi bi-clock-history"></i> Pending
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('report') ?>"
                        class="nav-link <?= ($this->uri->segment(1) == 'report' && $this->uri->segment(2) == '') ? 'active' : '' ?>">
                        <i class="bi bi-person-badge-fill"></i> Analisa
                    </a>
                </li>

                <div class="nav-section">Sistem</div>
                <li class="nav-item">
                    <a href="<?= site_url('settings') ?>"
                        class="nav-link <?= ($this->uri->segment(1) == 'settings' && !$this->input->get('tab')) ? 'active' : '' ?>">
                        <i class="bi bi-gear-fill"></i> Identitas
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('settings?tab=payment-methods') ?>"
                        class="nav-link <?= ($this->input->get('tab') == 'payment-methods') ? 'active' : '' ?>">
                        <i class="bi bi-credit-card-2-back-fill"></i> Metode Bayar
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('settings?tab=order-types') ?>"
                        class="nav-link <?= ($this->input->get('tab') == 'order-types') ? 'active' : '' ?>">
                        <i class="bi bi-truck-flatbed"></i> Tipe Order
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <a href="<?= site_url('auth/logout') ?>" class="nav-link logout">
                <i class="bi bi-box-arrow-left"></i> Logout
            </a>
        </div>
    </aside>

    <!-- TOPBAR -->
        <header class="topbar">
            <!-- Mobile Toggle -->
            <button id="mobileSidebarToggle" class="topbar-btn d-md-none me-2">
                <i class="bi bi-list fs-4"></i>
            </button>
            
            <div class="page-title"><?= $title ?></div>

            <div class="topbar-actions">
            <button onclick="toggleNotif()" class="topbar-btn">
                <i class="bi bi-bell-fill"></i>
                <?php if ($pending_count > 0): ?><span class="notif-dot"></span><?php endif; ?>
            </button>
            <div class="user-info d-none d-md-block">
                <div class="name"><?= htmlspecialchars($this->session->userdata('full_name') ?? 'Admin') ?></div>
                <div class="role">Administrator</div>
            </div>
            <div class="avatar"><?= strtoupper(substr($this->session->userdata('full_name') ?? 'A', 0, 1)) ?></div>
        </div>

        <!-- NOTIF DROPDOWN -->
        <div class="notif-dropdown" id="notifDropdown">
            <div class="notif-header">Notifikasi</div>
            <div class="notif-body">
                <?php if (empty($notif_orders)): ?>
                    <div class="p-4 text-center small text-muted">Tidak ada pesanan baru</div>
                <?php else: ?>
                    <?php foreach ($notif_orders as $no): ?>
                        <a href="<?= site_url('order') ?>" class="notif-item">
                            <div class="notif-icon"><i class="bi bi-clock-fill"></i></div>
                            <div class="notif-info">
                                <span class="title">Pesanan <?= $no['invoice_no'] ?></span>
                                <span class="time"><?= date('H:i', strtotime($no['created_at'])) ?></span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <div class="page-header-mobile">
            <h4 class="fw-bold mb-0 text-success"><?= $title ?></h4>
        </div>
        <?php if (isset($content))
            $this->load->view($content); ?>
    </main>

    <!-- COMMAND PALETTE -->
    <div class="modal fade" id="commandPalette" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="search-input-group mb-4">
                        <i class="bi bi-search"></i>
                        <input type="text" id="cmdSearch" placeholder="Cari menu (Alt+K)...">
                    </div>
                    <div class="command-list">
                        <a href="<?= site_url('dashboard') ?>" class="command-item"><i class="bi bi-grid"></i>
                            Dashboard</a>
                        <a href="<?= site_url('product') ?>" class="command-item"><i class="bi bi-cup"></i> Produk</a>
                        <a href="<?= site_url('order') ?>" class="command-item"><i class="bi bi-pc-display"></i>
                            Kasir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
         <!-- Global UI Scripts -->
    <script>
        function toggleNotif() {
            const drop = document.getElementById('notifDropdown');
            drop.style.display = (drop.style.display === 'flex') ? 'none' : 'flex';
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Sidebar Toggle Logic
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggleBtn = document.getElementById('mobileSidebarToggle');

            if (toggleBtn && sidebar && overlay) {
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.add('open');
                    overlay.classList.add('show');
                });
                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('show');
                });
            }

            // Command Palette Activation
            const paletteTrigger = document.getElementById('commandPaletteTrigger');
        if (paletteEl) {
            const cmdModal = new bootstrap.Modal(paletteEl);
            window.addEventListener('keydown', (e) => {
                if (e.altKey && e.key === 'k') {
                    e.preventDefault();
                    cmdModal.show();
                    setTimeout(() => document.getElementById('cmdSearch').focus(), 400);
                }
            });
        }
        });
    </script>
    </body>

</html>