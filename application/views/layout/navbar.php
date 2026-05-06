<!-- 
    MARIMATCHA PREMIUM GLOBAL NAVBAR 
    Conceptualized for Organic Minimalism & High Performance
-->
<?php
$ci =& get_instance();
$ci->load->model('M_settings');
$global_shop_logo = $ci->M_settings->get_setting('shop_logo');
$is_open = $ci->M_settings->is_shop_open();
$session_userid = $ci->session->userdata('userid'); // Gunakan 'userid' sesuai Auth.php
?>
<style>
    :root {
        --navbar-height: 85px;
        --green-dark: #1B3B25;
        --green-main: #2D5A3F;
        --green-light: #4A7A5C;
        --cream: #FDFCF8;
    }
    .navbar-macha {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        height: var(--navbar-height);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        border-bottom: 1px solid rgba(0,0,0,0.03);
        z-index: 1050;
    }
    .navbar-macha.scrolled {
        height: 70px;
        background: rgba(255, 255, 255, 0.98);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    
    .navbar-brand img {
        height: 45px;
        transition: height 0.4s ease;
    }
    .navbar-macha.scrolled .navbar-brand img {
        height: 38px;
    }

    .nav-link-macha {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--green-light) !important;
        padding: 8px 12px !important;
        transition: all 0.3s ease;
        position: relative;
        white-space: nowrap;
    }
    .nav-link-macha:hover, .nav-link-macha.active {
        color: var(--green-dark) !important;
    }
    .nav-link-macha::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: var(--green-main);
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }
    .nav-link-macha:hover::after { width: 20px; }

    /* Search Bar Styling */
    .search-container {
        position: relative;
        margin: 0 15px;
    }
    .search-input-group {
        background: #f1f5f2;
        border-radius: 50px;
        padding: 6px 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1.5px solid transparent;
        transition: all 0.3s ease;
    }
    .search-input-group:focus-within {
        background: #fff;
        border-color: var(--green-main);
        box-shadow: 0 5px 20px rgba(27, 59, 37, 0.08);
    }
    .search-input-group input {
        border: none;
        background: transparent;
        outline: none;
        font-size: 0.85rem;
        font-weight: 600;
        width: 140px;
        transition: width 0.3s ease;
    }
    .search-input-group input:focus { width: 200px; }
    .search-icon { color: var(--green-light); font-size: 0.85rem; }

    .search-results-dropdown {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        width: 100%;
        min-width: 320px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        display: none;
        overflow: hidden;
        z-index: 1100;
        border: 1px solid rgba(27, 59, 37, 0.08);
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
    .search-result-item:last-child { border-bottom: none; }
    .search-result-item:hover { background: #f4faf6; }
    .search-result-img { width: 45px; height: 45px; border-radius: 10px; object-fit: cover; }
    .search-result-info .name { display: block; font-weight: 800; font-size: 0.9rem; margin-bottom: 2px; }
    .search-result-info .price { font-size: 0.75rem; color: var(--green-main); font-weight: 700; }

    /* Buttons */
    .btn-macha-outline {
        border: 2px solid var(--green-main);
        color: var(--green-main);
        font-weight: 800;
        border-radius: 50px;
        padding: 8px 22px;
        transition: all 0.3s ease;
        text-decoration: none !important;
    }
    .btn-macha-outline:hover {
        background: var(--green-main);
        color: #fff;
    }
    .btn-macha-filled {
        background: var(--green-dark);
        color: #fff !important;
        font-weight: 800;
        border-radius: 50px;
        padding: 10px 24px;
        transition: all 0.3s ease;
        text-decoration: none !important;
    }
    .btn-macha-filled:hover {
        background: var(--green-main);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27, 59, 37, 0.2);
    }

    /* Breadcrumbs */
    .breadcrumb-area {
        background: #fff;
        padding: 10px 0;
        margin-top: var(--navbar-height);
        border-bottom: 1px solid #f0f4f1;
    }
    .breadcrumb-item { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .breadcrumb-item a { color: var(--green-light); text-decoration: none; }
    .breadcrumb-item.active { color: var(--green-main); }

    @media (max-width: 991px) {
        .navbar-macha { height: auto; padding: 10px 0; }
        .navbar-collapse { 
            background: #fff; margin-top: 15px; padding: 25px; 
            border-radius: 25px; box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }
        .search-container { margin: 15px 0; }
        .search-input-group input { width: 100% !important; }
        .breadcrumb-area { margin-top: 0; }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-macha fixed-top" id="mainNav">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url() ?>">
            <?php if(!empty($global_shop_logo)): ?>
                <img src="<?= base_url('uploads/'.$global_shop_logo) ?>" alt="Logo" class="me-2" style="height: 45px; width: auto; object-fit: contain;">
            <?php else: ?>
                <i class="fa-solid fa-leaf text-success me-2 fs-3"></i>
            <?php endif; ?>
            <span class="fw-bold fs-4" style="color: var(--green-dark); letter-spacing: -0.5px;">MariMatcha</span>
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <i class="fa-solid fa-bars-staggered fs-3" style="color: var(--green-dark);"></i>
        </button>

        <!-- Content -->
        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav mx-auto align-items-center">
                <li class="nav-item"><a class="nav-link nav-link-macha" href="<?= base_url() ?>">Beranda</a></li>
                <li class="nav-item"><a class="nav-link nav-link-macha" href="<?= base_url('shop') ?>">Katalog</a></li>
                <li class="nav-item"><a class="nav-link nav-link-macha" href="<?= base_url('#tentang') ?>">Tentang</a></li>
                <li class="nav-item"><a class="nav-link nav-link-macha" href="<?= base_url('#cara-pesan') ?>">Cara Pesan</a></li>
            </ul>

            <div class="d-flex align-items-center flex-column flex-lg-row gap-3">
                <!-- Predictive Search -->
                <div class="search-container">
                    <div class="search-input-group">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                        <input type="text" id="navSearchInput" placeholder="Cari menu..." autocomplete="off">
                    </div>
                    <div id="navSearchResults" class="search-results-dropdown"></div>
                </div>

                <!-- Cart & Auth -->
                <div class="d-flex align-items-center gap-2">
                    <a href="<?= site_url('shop/cart') ?>" class="btn-macha-outline d-flex align-items-center gap-2">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="d-none d-xl-inline">Keranjang</span>
                    </a>

                    <?php if($session_userid): ?>
                        <a href="<?= site_url('user/profile') ?>" class="btn-macha-filled">
                            <i class="fa-solid fa-circle-user me-1"></i> Akun
                        </a>
                        <a href="<?= site_url('auth/logout') ?>" class="text-danger ms-2" title="Logout">
                            <i class="fa-solid fa-right-from-bracket fs-5"></i>
                        </a>
                    <?php else: ?>
                        <a href="<?= site_url('auth') ?>" class="btn-macha-filled">Login</a>
                    <?php endif; ?>
                </div>
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

    // Scroll Effect
    window.addEventListener('scroll', () => {
        if(window.scrollY > 50) nav.classList.add('scrolled');
        else nav.classList.remove('scrolled');
    });

    // Predictive Search Logic
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

    // Close on click outside
    document.addEventListener('click', (e) => {
        if(!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
            resultsDiv.style.display = 'none';
        }
    });

    // Handle Click (Buka Modal Detail)
    window.handleSearchClick = function(e, id) {
        e.preventDefault();
        resultsDiv.style.display = 'none';
        searchInput.value = '';
        
        // Cek jika fungsi showDetail ada (halaman shop)
        if(typeof window.showDetail === 'function') {
            window.showDetail(id);
        } else {
            // Jika tidak di halaman shop, redirect ke shop dengan parameter detail
            window.location.href = "<?= site_url('shop') ?>?detail=" + id;
        }
    };
});
</script>
