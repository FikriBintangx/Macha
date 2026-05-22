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
        transition: width 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                    height 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                    top 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                    border-radius 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                    padding 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: width, height, top, border-radius, padding;
        border: 1px solid rgba(255,255,255,0.08);
        z-index: 1050;
        position: fixed;
        top: 25px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 50px;
        width: 90%;
        max-width: 1000px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        overflow: hidden;
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

    /* SCROLLED / SHRINK STATE */
    .navbar-macha.scrolled:not(:hover) {
        width: 90%;
        max-width: 330px;
        height: 60px;
        top: 15px;
        border-radius: 40px;
        padding: 0 25px;
    }
    
    .navbar-macha.scrolled:not(:hover).notif-active {
        width: 95%;
        max-width: 480px;
    }

    .navbar-macha.scrolled:not(:hover) .hide-on-scroll {
        opacity: 0;
        visibility: hidden;
        max-width: 0;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden;
    }

    .navbar-macha.scrolled:not(:hover) .btn-macha-outline span {
        display: none;
    }
    
    .navbar-macha.scrolled:not(:hover) .btn-macha-outline {
        padding: 8px 12px;
    }

    .hide-on-scroll {
        transition: opacity 0.3s ease, visibility 0.3s, max-width 0.4s cubic-bezier(0.16, 1, 0.3, 1);
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
    .navbar-macha.scrolled:not(:hover) .navbar-brand img {
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
        width: 320px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        display: none;
        overflow: hidden;
        z-index: 1100;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .search-result-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 18px;
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
            width: 95%;
            top: 15px;
            height: 60px;
        }
        .nav-content-default { padding: 0 25px; }
        .navbar-macha.scrolled:not(:hover) { width: 95%; }
        .nav-links-wrap, .search-container, .brand-text { display: none !important; }
        .right-actions .btn-macha-filled span { display: none; }
        .breadcrumb-area { margin-top: 85px; }
    }

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
            <!-- Brand -->
            <a class="navbar-brand" href="<?= base_url() ?>">
                <?php if(!empty($global_shop_logo)): ?>
                    <img src="<?= base_url('uploads/'.$global_shop_logo) ?>" alt="Logo">
                <?php else: ?>
                    <i class="fa-solid fa-leaf" style="color: var(--tertiary); font-size: 1.5rem;"></i>
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
                    <div class="search-input-group">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                        <input type="text" id="navSearchInput" placeholder="Cari menu..." autocomplete="off">
                    </div>
                    <div id="navSearchResults" class="search-results-dropdown"></div>
                </div>

                <!-- Cart -->
                <a href="<?= site_url('shop/cart') ?>" class="btn-macha-outline">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="hide-on-scroll">Keranjang</span>
                </a>

                <!-- Auth -->
                <?php if($session_userid): ?>
                    <a href="<?= site_url('user/profile') ?>" class="btn-macha-filled hide-on-scroll">
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

    // Scroll Effect - Dynamic Island Shrink
    let ticking = false;
    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                if(window.scrollY > 50) {
                    nav.classList.add('scrolled');
                } else {
                    nav.classList.remove('scrolled');
                }
                ticking = false;
            });
            ticking = true;
        }
    });

    // Predictive Search Logic
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(debounce);
            const q = this.value.trim();

            if(q.length < 2) {
                resultsDiv.style.display = 'none';
                return;
            }

            debounce = setTimeout(() => {
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
                                    <a href="javascript:void(0)" class="search-result-item" onclick="handleSearchClick(event, ${item.id})">
                                        <img src="${img}" class="search-result-img" onerror="this.src='https://ui-avatars.com/api/?name=Matcha&background=f4faf6&color=1B3B25'">
                                        <div class="search-result-info">
                                            <span class="name">${item.name}</span>
                                            <span class="price">${item.price_formatted}</span>
                                        </div>
                                    </a>
                                `;
                            });
                            resultsDiv.innerHTML = html;
                            resultsDiv.style.display = 'block';
                        } else {
                            resultsDiv.innerHTML = '<div class="p-3 text-center text-muted small">Menu tidak ditemukan</div>';
                            resultsDiv.style.display = 'block';
                        }
                    })
                    .catch(e => console.error("Search Error:", e));
            }, 300);
        });
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

    <?php if($has_notif): ?>
    window.showDynamicIslandNotif('<?= addslashes($notif_msg) ?>', '<?= $notif_type ?>');
    <?php endif; ?>
});
</script>
