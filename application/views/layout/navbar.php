<!-- 
    MARIMATCHA PREMIUM GLOBAL NAVBAR 
    Conceptualized for Organic Minimalism & High Performance
-->
<?php
$ci =& get_instance();
$ci->load->model('M_settings');
$global_shop_logo = $ci->M_settings->get_setting('shop_logo');
$is_open = $ci->M_settings->is_shop_open();
?>
<style>
    :root {
        --navbar-height: 85px;
    }
    .navbar-macha {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        height: var(--navbar-height);
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        border-bottom: 1px solid rgba(0,0,0,0.03);
    }
    .navbar-macha.scrolled {
        height: 70px;
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    
    /* Brand & Status Fix */
    .navbar-brand-wrap { display: flex; align-items: center; gap: 15px; }
    .navbar-brand-text {
        font-weight: 950; font-size: 1.5rem; color: var(--green-dark);
        letter-spacing: -1px; margin: 0; line-height: 1;
    }
    
    .shop-status-pill {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 6px 14px; border-radius: 50px;
        background: var(--white); border: 1.5px solid #edf2ed;
        font-size: 0.65rem; font-weight: 900; text-transform: uppercase;
        color: var(--green-dark); box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    }
    .status-dot { width: 8px; height: 8px; border-radius: 50%; position: relative; }
    .status-dot.open { background: #22c55e; }
    .status-dot.open::after {
        content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: #22c55e; border-radius: 50%; animation: pulse-green 2s infinite;
    }
    .status-dot.closed { background: #ef4444; }

    @keyframes pulse-green {
        0% { transform: scale(1); opacity: 0.8; }
        100% { transform: scale(3); opacity: 0; }
    }

    /* Navigation Links */
    .nav-link-macha {
        font-weight: 700; font-size: 0.9rem; color: var(--green-light) !important;
        padding: 8px 16px !important; transition: all 0.3s ease;
        position: relative;
    }
    .nav-link-macha:hover, .nav-link-macha.active { color: var(--green-dark) !important; }
    .nav-link-macha::after {
        content: ''; position: absolute; bottom: 0; left: 50%; width: 0; height: 2px;
        background: var(--green-main); transition: all 0.3s ease; transform: translateX(-50%);
    }
    .nav-link-macha:hover::after { width: 20px; }

    /* Action Buttons */
    .btn-nav-premium {
        background: var(--white); color: var(--green-main) !important;
        border: 1.5px solid var(--green-main); padding: 10px 22px; border-radius: 50px;
        font-weight: 800; font-size: 0.85rem; display: flex; align-items: center; gap: 10px;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); text-decoration: none !important;
    }
    .btn-nav-premium:hover {
        background: var(--green-main); color: var(--white) !important;
        transform: translateY(-3px); box-shadow: 0 10px 20px rgba(27, 59, 37, 0.15);
    }
    
    .btn-nav-filled {
        background: var(--green-dark); color: var(--white) !important;
        padding: 10px 24px; border-radius: 50px; font-weight: 800; font-size: 0.85rem;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); text-decoration: none !important;
    }
    .btn-nav-filled:hover {
        background: var(--green-main); transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(16, 36, 22, 0.2);
    }

    /* Cart Badge Custom */
    .cart-badge-premium {
        background: #ef4444; color: white; font-size: 0.65rem;
        padding: 4px 8px; border-radius: 50px;
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
        margin-left: 4px; display: inline-flex; align-items: center; justify-content: center;
    }

    @media (max-width: 991px) {
        .navbar-macha { height: auto; padding: 15px 0; }
        .navbar-collapse { 
            background: var(--white); margin-top: 15px; padding: 20px; 
            border-radius: 25px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-macha fixed-top" id="mainGlobalNav">
    <div class="container">
        <!-- BRAND AREA -->
        <a class="navbar-brand p-0" href="<?= base_url() ?>">
            <div class="navbar-brand-wrap">
                <?php if(!empty($global_shop_logo)): ?>
                    <img src="<?= base_url('uploads/'.$global_shop_logo) ?>" alt="Logo" style="height: 45px; width: auto; object-fit: contain; mix-blend-mode: multiply;">
                <?php else: ?>
                    <i class="fa-solid fa-leaf" style="color:var(--green-main); font-size: 1.8rem;"></i>
                <?php endif; ?>
                <div class="d-flex flex-column">
                    <h1 class="navbar-brand-text">MariMatcha</h1>
                </div>
                
                <div class="shop-status-pill d-none d-sm-inline-flex">
                    <div class="status-dot <?= $is_open ? 'open' : 'closed' ?>"></div>
                    <?= $is_open ? 'Buka' : 'Tutup' ?>
                </div>
            </div>
        </a>

        <!-- MOBILE TOGGLE -->
        <button class="navbar-toggler border-0 p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <i class="fa-solid fa-bars-staggered" style="color:var(--green-dark); font-size:1.4rem"></i>
        </button>

        <!-- NAV CONTENT -->
        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link nav-link-macha" href="<?= base_url() ?>">Beranda</a></li>
                <li class="nav-item"><a class="nav-link nav-link-macha" href="<?= base_url('shop') ?>">Katalog</a></li>
                <li class="nav-item"><a class="nav-link nav-link-macha" href="<?= base_url('#tentang') ?>">Tentang</a></li>
                <li class="nav-item"><a class="nav-link nav-link-macha" href="<?= base_url('#cara-pesan') ?>">Cara Pesan</a></li>
            </ul>

            <div class="d-flex align-items-center gap-2 flex-nowrap mt-3 mt-lg-0">
                <?php $cart = $this->session->userdata('cart') ?? []; $cc = count($cart); ?>
                
                <?php if($this->session->userdata('role') != 'admin'): ?>
                <a href="<?= base_url('shop/cart') ?>" class="btn-nav-premium px-3">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="d-none d-lg-inline">Keranjang</span>
                    <?php if ($cc > 0): ?>
                        <span class="badge cart-badge-premium"><?= $cc ?></span>
                    <?php endif; ?>
                </a>
                <?php endif; ?>

                <?php if ($this->session->userdata('userid')): ?>
                    <div class="d-flex gap-2 flex-nowrap">
                        <a href="<?= ($this->session->userdata('role') == 'admin') ? base_url('dashboard') : base_url('user'); ?>" class="btn-nav-filled px-3">
                            <i class="fa-solid fa-circle-user"></i> <span class="d-none d-md-inline">Akun</span>
                        </a>
                        <a href="<?= base_url('auth/logout') ?>" class="btn-nav-premium px-3 text-danger border-danger" title="Logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="d-flex gap-2 flex-nowrap">
                        <a href="<?= base_url('auth') ?>" class="btn-nav-premium px-3">Masuk</a>
                        <a href="<?= base_url('auth/register') ?>" class="btn-nav-filled px-3">Daftar</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
    window.addEventListener('scroll', function() {
        const nav = document.getElementById('mainGlobalNav');
        if (window.scrollY > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    });
</script>
