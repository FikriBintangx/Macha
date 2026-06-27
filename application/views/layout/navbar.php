<!-- 
    MARIMATCHA PREMIUM DYNAMIC ISLAND NAVBAR 
-->
<?php
$ci =& get_instance();
$ci->load->model('M_settings');
$global_shop_logo = $ci->M_settings->get_setting('shop_logo');
$is_open = $ci->M_settings->is_shop_open();
$session_userid = $ci->session->userdata('userid'); // Gunakan 'userid' sesuai Auth.php

$has_notif = false;
$notif_type = '';
$notif_msg = '';
if ($ci->session->flashdata('success')) {
    $has_notif = true;
    $notif_type = 'success';
    $notif_msg = $ci->session->flashdata('success');
} elseif ($ci->session->flashdata('error')) {
    $has_notif = true;
    $notif_type = 'error';
    $notif_msg = $ci->session->flashdata('error');
}
?>
<style>
    :root {
        --navbar-height: 75px;
        --green-dark: #1B3B25;
        --green-main: #2D5A3F;
        --tertiary: #8BAA7C;
        --cream: #FDFCF8;
    }

    .navbar-macha {
        background: rgba(16, 36, 22, 0.95) !important; /* Dark Capsule */
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        height: var(--navbar-height);
        transition: width 1.2s cubic-bezier(0.25, 1, 0.5, 1),
                    height 1.2s cubic-bezier(0.25, 1, 0.5, 1),
                    top 1.2s cubic-bezier(0.25, 1, 0.5, 1),
                    border-radius 1.2s cubic-bezier(0.25, 1, 0.5, 1),
                    padding 1.2s cubic-bezier(0.25, 1, 0.5, 1);
        will-change: width, height, top, border-radius, padding;
        border: 1px solid rgba(255,255,255,0.08);
        z-index: 1050;
        position: fixed;
        top: 25px;
        left: 50% !important;
        transform: translateX(-50%) !important;
        margin: 0 !important;
        border-radius: 50px;
        width: 90%;
        max-width: 1000px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        /* overflow: hidden; Dihapus agar dropdown tidak terpotong */
        padding: 0 !important;
    }

    .nav-slot-wrapper {
        position: relative;
        width: 100%;
        height: 100%;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .nav-content-default {
        width: 100%;
        height: 100%;
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        padding: 0 35px;
    }

    .nav-notification-slot {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        color: #fff;
        font-weight: 700;
        font-size: 0.95rem;
        background: transparent;
    }

    /* SCROLLED / SHRINK STATE - DISABLED */
    
    .navbar-macha.notif-active {
        width: 95% !important;
        max-width: 480px !important;
        height: 60px !important;
        border-radius: 40px !important;
        padding: 0 25px !important;
    }
    
    .navbar-macha.confirm-active {
        width: 95% !important;
        max-width: 480px !important;
        height: 60px !important;
        border-radius: 40px !important;
        padding: 0 25px !important;
    }

    .navbar-macha.notif-active .hide-on-scroll,
    .navbar-macha.confirm-active .hide-on-scroll {
        opacity: 0;
        visibility: hidden;
        max-width: 0;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden;
    }

    .navbar-macha.notif-active .btn-macha-outline span,
    .navbar-macha.confirm-active .btn-macha-outline span {
        display: none;
    }
    
    .navbar-macha.notif-active .btn-macha-outline,
    .navbar-macha.confirm-active .btn-macha-outline {
        padding: 8px 12px;
    }

    .hide-on-scroll {
        transition: opacity 0.8s ease, visibility 0.8s, max-width 1.2s cubic-bezier(0.25, 1, 0.5, 1);
        opacity: 1;
        visibility: visible;
        max-width: 600px; /* Arbitrary large max-width for transition */
        white-space: nowrap;
    }

    /* BRAND LOGO */
    .navbar-brand {
        display: flex;
        align-items: center;
        color: #fff !important;
        margin-right: auto;
    }
    .navbar-brand img {
        height: 40px;
        border-radius: 50px;
        transition: height 0.4s ease;
    }
    .navbar-macha.notif-active .navbar-brand img,
    .navbar-macha.confirm-active .navbar-brand img {
        height: 35px;
    }
    .brand-text {
        color: #fff !important; 
        letter-spacing: -0.5px;
        margin-left: 10px;
    }

    /* LINKS */
    .nav-links-wrap {
        display: flex;
        gap: 5px;
        align-items: center;
        margin: 0 auto;
    }
    .nav-link-macha {
        font-weight: 600;
        font-size: 0.9rem;
        color: rgba(255,255,255,0.7) !important;
        padding: 8px 16px !important;
        transition: all 0.3s ease;
        position: relative;
        text-decoration: none;
    }
    .nav-link-macha:hover, .nav-link-macha.active {
        color: var(--tertiary) !important;
    }
    .nav-link-macha::after {
        content: '';
        position: absolute;
        bottom: 2px;
        left: 50%;
        width: 0;
        height: 2px;
        background: var(--tertiary);
        transition: all 0.3s ease;
        transform: translateX(-50%);
        border-radius: 2px;
    }
    .nav-link-macha:hover::after { width: 15px; }

    /* SEARCH BAR */
    .search-container {
        position: relative;
        margin-right: 15px;
    }
    .search-input-group {
        background: rgba(255,255,255,0.1);
        border-radius: 50px;
        padding: 6px 15px;
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid transparent;
        transition: all 0.3s ease;
    }
    .search-input-group:focus-within {
        background: rgba(255,255,255,0.15);
        border-color: var(--tertiary);
    }
    .search-input-group input {
        border: none;
        background: transparent;
        outline: none;
        font-size: 0.85rem;
        color: #fff;
        width: 100px;
        transition: width 0.3s ease;
    }
    .search-input-group input::placeholder { color: rgba(255,255,255,0.5); }
    .search-input-group input:focus { width: 160px; }
    .search-icon { color: rgba(255,255,255,0.7); font-size: 0.85rem; }

    /* SEARCH DROPDOWN */
    .search-results-dropdown {
        position: absolute;
        top: calc(100% + 15px);
        right: 0;
        z-index: 1100;
        border: 1px solid rgba(0,0,0,0.05);
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        width: 300px;
        max-width: 90vw;
        overflow: hidden;
        display: none; /* hidden by default */
    }
    .search-result-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 15px;
        text-decoration: none !important;
        color: var(--green-dark);
        transition: all 0.2s ease;
        border-bottom: 1px solid #f0f4f1;
    }
    .search-result-item:hover { background: #f4faf6; }
    .search-result-img { width: 45px; height: 45px; border-radius: 10px; object-fit: cover; }
    .search-result-info .name { display: block; font-weight: 800; font-size: 0.9rem; margin-bottom: 2px; }
    .search-result-info .price { font-size: 0.75rem; color: var(--green-main); font-weight: 700; }

    /* BUTTONS */
    .right-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: auto;
    }
    .btn-macha-outline {
        border: 1px solid rgba(255,255,255,0.3);
        color: #fff;
        font-weight: 700;
        font-size: 0.85rem;
        border-radius: 50px;
        padding: 8px 18px;
        transition: all 0.3s ease;
        text-decoration: none !important;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-macha-outline:hover {
        background: var(--tertiary);
        border-color: var(--tertiary);
        color: var(--green-dark);
    }
    .btn-macha-filled {
        background: var(--tertiary);
        color: var(--green-dark) !important;
        font-weight: 800;
        font-size: 0.85rem;
        border-radius: 50px;
        padding: 8px 18px;
        transition: all 0.3s ease;
        text-decoration: none !important;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .btn-macha-filled:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(139, 170, 124, 0.4);
        background: #fff;
    }

    /* BREADCRUMBS */
    .breadcrumb-area {
        background: transparent;
        padding: 10px 0;
        margin-top: 100px;
    }
    .breadcrumb-item { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .breadcrumb-item a { color: var(--green-light); text-decoration: none; }
    .breadcrumb-item.active { color: var(--green-main); }

    /* MOBILE OVERRIDES */
    @media (max-width: 991px) {
        .navbar-macha {
            width: calc(100% - 30px) !important;
            top: 15px !important;
            height: 60px !important;
            left: 15px !important;
            right: 15px !important;
            transform: none !important;
            margin: 0 !important;
        }
        
        /* CART MENU SPECIAL LAYOUT: DISTRACTION-FREE CART */
        body.cart-page-body .navbar-macha {
            display: none !important;
        }
        body.cart-page-body .navbar-macha.confirm-active {
            display: flex !important;
            z-index: 9999 !important;
        }
        body.cart-page-body .breadcrumb-area {
            margin-top: 20px !important;
        }
        body.cart-page-body .search-results-dropdown {
            top: auto !important;
            bottom: calc(100% + 15px) !important;
        }

        .nav-content-default { padding: 0 15px; justify-content: space-between; }
        
        .nav-links-wrap, .brand-text { display: none !important; }
        
        .search-container { display: block !important; margin-right: 0; }
        
        .search-input-group { background: transparent; padding: 6px; cursor: pointer; display: flex; align-items: center; }
        .search-input-group input { width: 0; padding: 0; opacity: 0; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .search-input-group:focus-within { background: rgba(255,255,255,0.15); border-radius: 50px; padding: 6px 12px; }
        .search-input-group:focus-within input { width: 130px; padding-left: 8px; opacity: 1; }

        .right-actions .btn-macha-filled span,
        .right-actions .btn-macha-outline span { display: none !important; }
        .right-actions .text-danger { display: none !important; }
        .breadcrumb-area { margin-top: 85px; }
        .mobile-menu-btn { display: flex !important; }
    }
    .mobile-menu-btn {
        display: none;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: transparent;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
    }
    
    /* MOBILE FULLSCREEN MENU */
    .mobile-fullscreen-menu {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100vh;
        background: rgba(16, 36, 22, 0.98);
        backdrop-filter: blur(15px);
        z-index: 1040;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        pointer-events: none;
        transition: 0.4s ease;
    }
    .mobile-fullscreen-menu.open {
        opacity: 1;
        pointer-events: all;
    }
    .mobile-fullscreen-menu a {
        color: #fff;
        font-size: 1.8rem;
        font-weight: 700;
        text-decoration: none;
        margin: 15px 0;
        transition: 0.2s;
    }
    .mobile-fullscreen-menu a:hover { color: var(--tertiary); }

    /* ─── DRIVER.JS CUSTOM THEME (MARIMATCHA PREMIUM) ─── */
    .driver-popover {
        border-radius: 20px !important;
        padding: 20px !important;
        background: #ffffff !important;
        color: var(--green-dark) !important;
        font-family: 'Outfit', sans-serif !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(0, 0, 0, 0.05) !important;
        max-width: 320px !important;
        border: none !important;
    }
    
    .driver-popover-title {
        font-size: 1.15rem !important;
        font-weight: 700 !important;
        color: var(--green-dark) !important;
        margin-bottom: 8px !important;
        line-height: 1.4 !important;
        letter-spacing: 0px !important;
    }
    
    .driver-popover-description {
        font-size: 0.9rem !important;
        font-weight: 400 !important;
        color: rgba(27, 59, 37, 0.7) !important;
        line-height: 1.5 !important;
        margin-bottom: 20px !important;
    }
    
    .driver-popover-footer {
        margin-top: 0 !important;
        padding-top: 15px !important;
        border-top: 1px solid rgba(0, 0, 0, 0.05) !important;
        background: transparent !important;
        display: flex !important;
        align-items: center !important;
    }
    
    .driver-popover-btn, .driver-popover-footer button {
        border-radius: 10px !important;
        padding: 8px 14px !important;
        font-weight: 600 !important;
        font-family: 'Outfit', sans-serif !important;
        text-shadow: none !important;
        -webkit-text-stroke: 0 !important;
        border: none !important;
        transition: all 0.2s ease !important;
        font-size: 0.85rem !important;
        cursor: pointer !important;
    }
    
    .driver-popover-next-btn {
        background: var(--green-dark) !important;
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(27, 59, 37, 0.2) !important;
        text-shadow: none !important;
    }
    .driver-popover-next-btn:hover { background: var(--tertiary) !important; transform: translateY(-2px) !important; }
    
    .driver-popover-prev-btn {
        background: #f0f3f1 !important;
        color: var(--green-dark) !important;
        margin-right: 10px !important;
    }
    .driver-popover-prev-btn:hover { background: #e0e6e2 !important; }
    
    .driver-popover-close-btn {
        color: rgba(27, 59, 37, 0.3) !important;
        top: 20px !important;
        right: 20px !important;
    }
    .driver-popover-close-btn:hover { color: #e53e3e !important; }
    
    .driver-popover-progress-text {
        font-weight: 800 !important;
        font-size: 0.8rem !important;
        color: var(--tertiary) !important;
        background: rgba(139, 170, 124, 0.1) !important;
        padding: 4px 10px !important;
        border-radius: 50px !important;
    }
    
    /* Arrow styling */
    .driver-popover-arrow { border-color: #fdfcf8 !important; }
</style>

<nav class="navbar-macha" id="mainNav">
    <div class="nav-slot-wrapper" id="navSlotWrapper">
        <div class="nav-content-default" id="navContentDefault">
            <!-- Mobile Menu Btn -->
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- Brand -->
            <a class="navbar-brand" href="<?= base_url() ?>">
                <?php if(!empty($global_shop_logo)): ?>
                    <img src="<?= base_url('uploads/'.$global_shop_logo) ?>" alt="Logo" class="d-none d-lg-block">
                <?php else: ?>
                    <i class="fa-solid fa-leaf d-none d-lg-block" style="color: var(--tertiary); font-size: 1.5rem;"></i>
                <?php endif; ?>
                <span class="fw-bold fs-5 brand-text hide-on-scroll"><?= $this->M_settings->get_setting('shop_name') ?: 'MariMatcha' ?></span>
            </a>

            <!-- Center Links -->
            <div class="nav-links-wrap hide-on-scroll">
                <a class="nav-link-macha" href="<?= base_url() ?>">Beranda</a>
                <a class="nav-link-macha" href="<?= base_url('shop') ?>">Katalog</a>
                <a class="nav-link-macha" href="<?= base_url('#tentang') ?>">Tentang</a>
            </div>

            <!-- Right Actions -->
            <div class="right-actions">
                <!-- Predictive Search -->
                <div class="search-container hide-on-scroll">
                    <label class="search-input-group" for="navSearchInput">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                        <input type="text" id="navSearchInput" placeholder="Cari menu..." autocomplete="off">
                    </label>
                    <div id="navSearchResults" class="search-results-dropdown"></div>
                </div>

                <!-- Cart -->
                <?php if($ci->session->userdata('role') !== 'admin'): ?>
                <a href="<?= site_url('shop/cart') ?>" class="btn-macha-outline">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="hide-on-scroll">Keranjang</span>
                </a>
                <?php endif; ?>

                <!-- Auth -->
                <?php if($session_userid): ?>
                    <a href="<?= site_url('user') ?>" class="btn-macha-filled hide-on-scroll">
                        <i class="fa-solid fa-circle-user"></i> <span>Akun</span>
                    </a>
                    <a href="<?= site_url('auth/logout') ?>" class="text-danger ms-2 hide-on-scroll" title="Logout" style="text-decoration:none;">
                        <i class="fa-solid fa-right-from-bracket fs-5"></i>
                    </a>
                <?php else: ?>
                    <a href="<?= site_url('auth') ?>" class="btn-macha-filled hide-on-scroll">
                        <i class="fa-solid fa-user"></i> <span>Login</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

    </div>
</nav>

<!-- Breadcrumbs -->
<?php 
$s1 = $ci->uri->segment(1);
$s2 = $ci->uri->segment(2);
if(!empty($s1) && !in_array($s1, ['auth', 'dashboard', 'report'])): 
?>
<div class="breadcrumb-area">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                <?php if($s1 == 'shop'): ?>
                    <li class="breadcrumb-item <?= empty($s2) ? 'active' : '' ?>">
                        <?= empty($s2) ? 'Katalog' : '<a href="'.base_url('shop').'">Katalog</a>' ?>
                    </li>
                    <?php if($s2 == 'cart'): ?>
                        <li class="breadcrumb-item active">Keranjang</li>
                    <?php elseif($s2 == 'checkout'): ?>
                        <li class="breadcrumb-item active">Checkout</li>
                    <?php endif; ?>
                <?php elseif($s1 == 'user'): ?>
                    <li class="breadcrumb-item active">Profil</li>
                <?php endif; ?>
            </ol>
        </nav>
    </div>
</div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('navSearchInput');
    const resultsDiv = document.getElementById('navSearchResults');
    const nav = document.getElementById('mainNav');
    let debounce;

    // Scroll Effect - Dynamic Island Shrink Disabled (Navbar remains expanded)

    // Hover logic with delay to prevent stuttering
    let hoverTimeout;
    if (nav) {
        nav.addEventListener('mouseenter', () => {
            clearTimeout(hoverTimeout);
            nav.classList.add('is-hovered');
        });
        nav.addEventListener('mouseleave', () => {
            hoverTimeout = setTimeout(() => {
                nav.classList.remove('is-hovered');
            }, 150); // Mencegah stutter jika kursor lepas sedikit karena animasi size
        });
    }

    // Predictive Search Logic
    let currentFocus = -1;
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(debounce);
            const q = this.value.trim();
            currentFocus = -1; // Reset focus on input

            if(q.length < 2) {
                resultsDiv.style.display = 'none';
                resultsDiv.innerHTML = '';
                return;
            }

            // Tampilkan state loading
            resultsDiv.innerHTML = '<div class="p-3 text-center text-muted small"><i class="fa-solid fa-spinner fa-spin"></i> Mencari...</div>';
            resultsDiv.style.display = 'block';

            debounce = setTimeout(() => {
                // Pastikan input masih valid setelah delay
                if(searchInput.value.trim().length < 2) {
                    resultsDiv.style.display = 'none';
                    return;
                }

                fetch(`<?= site_url('shop/search_ajax') ?>?q=${encodeURIComponent(q)}`)
                    .then(r => r.json())
                    .then(data => {
                        if(data && data.length > 0) {
                            let html = '';
                            data.forEach(item => {
                                const img = (item.image && item.image !== 'default') 
                                    ? `<?= base_url('uploads/') ?>${item.image}` 
                                    : `https://ui-avatars.com/api/?name=${encodeURIComponent(item.name)}&background=f4faf6&color=1B3B25`;
                                
                                html += `
                                    <a href="javascript:void(0)" class="search-result-item" onclick="handleSearchClick(event, ${item.id})" data-id="${item.id}">
                                        <img src="${img}" class="search-result-img" onerror="this.src='https://ui-avatars.com/api/?name=Matcha&background=f4faf6&color=1B3B25'">
                                        <div class="search-result-info">
                                            <span class="name">${item.name}</span>
                                            <span class="price">${item.price_formatted}</span>
                                        </div>
                                    </a>
                                `;
                            });
                            resultsDiv.innerHTML = html;
                        } else {
                            resultsDiv.innerHTML = '<div class="p-3 text-center text-muted small">Menu tidak ditemukan</div>';
                        }
                    })
                    .catch(e => {
                        console.error("Search Error:", e);
                        resultsDiv.innerHTML = '<div class="p-3 text-center text-danger small"><i class="fa-solid fa-circle-exclamation"></i> Gagal mengambil data</div>';
                    });
            }, 300);
        });

        // Keyboard Navigation (Atas/Bawah/Enter)
        searchInput.addEventListener('keydown', function(e) {
            const items = resultsDiv.querySelectorAll('.search-result-item');
            if(items.length === 0) return;

            if(e.key === 'ArrowDown') {
                e.preventDefault();
                currentFocus++;
                addActive(items);
            } else if(e.key === 'ArrowUp') {
                e.preventDefault();
                currentFocus--;
                addActive(items);
            } else if(e.key === 'Enter') {
                e.preventDefault();
                if(currentFocus > -1) {
                    if(items[currentFocus]) items[currentFocus].click();
                } else if(items.length > 0) {
                    items[0].click(); // Auto-select pertama jika tekan enter
                }
            }
        });

        function addActive(items) {
            if(!items) return false;
            removeActive(items);
            if(currentFocus >= items.length) currentFocus = 0;
            if(currentFocus < 0) currentFocus = (items.length - 1);
            items[currentFocus].classList.add('active');
            items[currentFocus].style.background = '#f4faf6'; 
            // Auto-scroll ke item yang aktif
            items[currentFocus].scrollIntoView({ block: "nearest" });
        }

        function removeActive(items) {
            for(let i = 0; i < items.length; i++) {
                items[i].classList.remove('active');
                items[i].style.background = '';
            }
        }
    }

    // Close on click outside
    document.addEventListener('click', (e) => {
        if(searchInput && !searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
            resultsDiv.style.display = 'none';
        }
    });

    // Handle Click (Buka Modal Detail)
    window.handleSearchClick = function(e, id) {
        e.preventDefault();
        resultsDiv.style.display = 'none';
        searchInput.value = '';
        
        if(typeof window.showDetail === 'function') {
            window.showDetail(id);
        } else {
            window.location.href = "<?= site_url('shop') ?>?detail=" + id;
        }
    };

    // Reusable Dynamic Island Notification Function
    window.showDynamicIslandNotif = function(msg, type) {
        const nav = document.getElementById('mainNav');
        const navSlotWrapper = document.getElementById('navSlotWrapper');
        const navContentDefault = document.getElementById('navContentDefault');
        if(!navSlotWrapper || !navContentDefault) return;
        
        // Add active class to expand width if shrunk
        if(nav) nav.classList.add('notif-active');
        
        // Remove existing if any to prevent overlapping logic
        let existingSlot = document.getElementById('dynamicNotifSlot');
        let existingClone = document.getElementById('navContentDefaultClone');
        if (existingSlot) existingSlot.remove();
        if (existingClone) existingClone.remove();
        
        // Reset transform instantly just in case an animation is running
        navSlotWrapper.style.transition = 'none';
        navSlotWrapper.style.transform = 'translateY(0)';
        nav.style.overflow = 'hidden'; // Tambahkan overflow hidden agar animasi tidak tembus
        // Force reflow
        void navSlotWrapper.offsetWidth;

        // Restore transition
        navSlotWrapper.style.transition = 'transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)';

        // Create the notification slot element dynamically
        const notifSlot = document.createElement('div');
        notifSlot.id = 'dynamicNotifSlot';
        notifSlot.className = 'nav-notification-slot';
        
        const iconColor = type === 'success' ? '#4ade80' : '#f87171';
        const iconClass = type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation';
        
        notifSlot.innerHTML = `
            <div style="display:flex; align-items:center; gap:10px;">
                <i class="fa-solid ${iconClass}" style="color: ${iconColor};"></i>
                <span>${msg}</span>
            </div>
            <button class="btnHideNotifDynamic" style="background: rgba(255,255,255,0.1); border: none; color: rgba(255,255,255,0.9); width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; position: absolute; right: 25px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        `;
        navSlotWrapper.appendChild(notifSlot);

        let notifHideTimeout;
        const btnHide = notifSlot.querySelector('.btnHideNotifDynamic');
        
        btnHide.addEventListener('mouseenter', function() { this.style.background = 'rgba(255,255,255,0.4)'; this.style.transform = 'scale(1.1)'; });
        btnHide.addEventListener('mouseleave', function() { this.style.background = 'rgba(255,255,255,0.2)'; this.style.transform = 'scale(1)'; });

        function hideDynamicNotification() {
            navSlotWrapper.style.transform = 'translateY(-200%)';
            setTimeout(() => {
                navSlotWrapper.style.transition = 'none';
                navSlotWrapper.style.transform = 'translateY(0)';
                const clone = document.getElementById('navContentDefaultClone');
                if(clone) clone.remove();
                if(notifSlot) notifSlot.remove();
                
                setTimeout(() => {
                    navSlotWrapper.style.transition = 'transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                    if(nav) nav.classList.remove('notif-active');
                    nav.style.overflow = ''; // Kembalikan overflow agar search dropdown tampil
                }, 50);
            }, 600);
        }

        btnHide.addEventListener('click', () => {
            clearTimeout(notifHideTimeout);
            hideDynamicNotification();
        });
        
        // Execute animation sequence
        setTimeout(() => {
            // Step 1: Roll up to show the notification
            navSlotWrapper.style.transform = 'translateY(-100%)';
            
            // Clone the main navbar below the notification to complete the loop
            const clone = navContentDefault.cloneNode(true);
            clone.id = 'navContentDefaultClone';
            clone.style.position = 'absolute';
            clone.style.top = '200%';
            clone.style.left = '0';
            clone.style.width = '100%';
            clone.style.height = '100%';
            navSlotWrapper.appendChild(clone);
            
            // Revert back after 3 seconds
            notifHideTimeout = setTimeout(() => {
                hideDynamicNotification();
            }, 3500);
        }, 50);
    };

    // Reusable Dynamic Island Confirmation Function (Option 2)
    window.showDynamicIslandConfirm = function(msg, onConfirm, onCancel) {
        const nav = document.getElementById('mainNav');
        const navSlotWrapper = document.getElementById('navSlotWrapper');
        const navContentDefault = document.getElementById('navContentDefault');
        if(!nav || !navSlotWrapper || !navContentDefault) {
            if(confirm(msg)) { if(onConfirm) onConfirm(); } else { if(onCancel) onCancel(); }
            return;
        }
        
        // Add confirm-active class to expand
        nav.classList.add('confirm-active');
        
        // Remove existing if any
        let existingSlot = document.getElementById('dynamicConfirmSlot');
        let existingClone = document.getElementById('navContentDefaultCloneConfirm');
        if (existingSlot) existingSlot.remove();
        if (existingClone) existingClone.remove();
        
        navSlotWrapper.style.transition = 'none';
        navSlotWrapper.style.transform = 'translateY(0)';
        nav.style.overflow = 'hidden';
        void navSlotWrapper.offsetWidth; // force reflow
        navSlotWrapper.style.transition = 'transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)';

        // Create the confirm slot element
        const confirmSlot = document.createElement('div');
        confirmSlot.id = 'dynamicConfirmSlot';
        confirmSlot.className = 'nav-notification-slot';
        confirmSlot.style.justifyContent = 'space-between';
        confirmSlot.style.padding = '0 25px';
        confirmSlot.style.width = '100%';
        
        confirmSlot.innerHTML = `
            <div style="display:flex; align-items:center; gap:10px; color:#fff; font-size:0.9rem; font-weight:700;">
                <i class="fa-solid fa-circle-question" style="color: var(--tertiary);"></i>
                <span>${msg}</span>
            </div>
            <div style="display:flex; gap:10px;">
                <button class="btnConfirmYes" style="background: #22c55e; border: none; color: #fff; padding: 6px 16px; border-radius: 20px; font-weight: 800; font-size: 0.8rem; cursor: pointer; transition: all 0.2s;">Ya</button>
                <button class="btnConfirmNo" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 6px 16px; border-radius: 20px; font-weight: 800; font-size: 0.8rem; cursor: pointer; transition: all 0.2s;">Batal</button>
            </div>
        `;
        navSlotWrapper.appendChild(confirmSlot);

        const btnYes = confirmSlot.querySelector('.btnConfirmYes');
        const btnNo = confirmSlot.querySelector('.btnConfirmNo');

        btnYes.addEventListener('mouseenter', function() { this.style.transform = 'scale(1.05)'; this.style.background = '#15803d'; });
        btnYes.addEventListener('mouseleave', function() { this.style.transform = 'scale(1)'; this.style.background = '#22c55e'; });
        btnNo.addEventListener('mouseenter', function() { this.style.transform = 'scale(1.05)'; this.style.background = 'rgba(255,255,255,0.2)'; });
        btnNo.addEventListener('mouseleave', function() { this.style.transform = 'scale(1)'; this.style.background = 'rgba(255,255,255,0.1)'; });

        function hideConfirm() {
            navSlotWrapper.style.transform = 'translateY(-200%)';
            setTimeout(() => {
                navSlotWrapper.style.transition = 'none';
                navSlotWrapper.style.transform = 'translateY(0)';
                const clone = document.getElementById('navContentDefaultCloneConfirm');
                if(clone) clone.remove();
                if(confirmSlot) confirmSlot.remove();
                
                setTimeout(() => {
                    navSlotWrapper.style.transition = 'transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                    nav.classList.remove('confirm-active');
                    nav.style.overflow = '';
                }, 50);
            }, 600);
        }

        btnYes.addEventListener('click', () => {
            hideConfirm();
            if (onConfirm) onConfirm();
        });

        btnNo.addEventListener('click', () => {
            hideConfirm();
            if (onCancel) onCancel();
        });

        setTimeout(() => {
            navSlotWrapper.style.transform = 'translateY(-100%)';
            
            const clone = navContentDefault.cloneNode(true);
            clone.id = 'navContentDefaultCloneConfirm';
            clone.style.position = 'absolute';
            clone.style.top = '200%';
            clone.style.left = '0';
            clone.style.width = '100%';
            clone.style.height = '100%';
            navSlotWrapper.appendChild(clone);
        }, 50);
    };

    <?php if($has_notif): ?>
    window.showDynamicIslandNotif('<?= addslashes($notif_msg) ?>', '<?= $notif_type ?>');
    <?php endif; ?>
});
</script>

<!-- Mobile Fullscreen Menu -->
<div class="mobile-fullscreen-menu" id="mobileMenu">
    <a href="<?= base_url() ?>">Beranda</a>
    <a href="<?= base_url('shop') ?>">Katalog</a>
    <a href="<?= base_url('#tentang') ?>">Tentang</a>
    <?php if($session_userid): ?>
        <a href="<?= site_url('user') ?>">Akun Saya</a>
        <a href="<?= site_url('auth/logout') ?>" class="text-danger">Logout</a>
    <?php else: ?>
        <a href="<?= site_url('auth') ?>">Login</a>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    if(mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('open');
            const icon = mobileMenuBtn.querySelector('i');
            if(icon) {
                if(mobileMenu.classList.contains('open')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-xmark');
                } else {
                    icon.classList.remove('fa-xmark');
                    icon.classList.add('fa-bars');
                }
            }
        });
        const links = mobileMenu.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('open');
                const icon = mobileMenuBtn.querySelector('i');
                if(icon) {
                    icon.classList.remove('fa-xmark');
                    icon.classList.add('fa-bars');
                }
                
            });
        });
    }
});
</script>
