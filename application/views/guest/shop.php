<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<?php 
    $CI =& get_instance();
    $CI->load->model('M_settings');
    $shop_logo = $CI->M_settings->get_setting('shop_logo');
    if(!empty($shop_logo)): 
?>
    <link rel="icon" type="image/x-icon" href="<?= base_url('uploads/'.$shop_logo) ?>">
<?php endif; ?>
<title>Katalog Menu | <?= $CI->M_settings->get_setting('shop_name') ?: 'MariMatcha' ?></title>
<meta name="description" content="Pilih minuman matcha premium favoritmu. Berbagai varian tersedia, fresh setiap hari.">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css"/>
<script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
<style>
  :root {
    --green-dark: #102416;
    --green-main: #1B3B25;
    --green-light: #53725D;
    --tertiary: #8BAA7C;
    --cream: #F5F5F0;
    --white: #ffffff;
    --text: #1B3B25;
    --transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  html, body { width: 100%; max-width: 100%; overflow-x: hidden; }
  body { font-family: 'Outfit', sans-serif; background: var(--cream); color: var(--text); }

  .shop-banner {
    background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-main) 100%);
    padding: 100px 0 80px;
    position: relative; overflow: hidden; color: var(--white); text-align: center;
  }
  .shop-banner h1 { font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 900; margin-bottom: 15px; position: relative; z-index: 1; }
  .shop-banner p { font-size: 1.1rem; opacity: 0.8; max-width: 600px; margin: 0 auto; position: relative; z-index: 1; }

  .sticky-filters {
    position: sticky; top: 95px; z-index: 100;
    width: max-content;
    max-width: 90%;
    margin: -35px auto 40px; /* Overlap banner slightly */
    background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    border-radius: 50px; padding: 10px 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    border: 1px solid rgba(255,255,255,1);
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .sticky-filters.scrolled {
    padding: 8px 12px;
    background: rgba(255, 255, 255, 0.98);
    box-shadow: 0 5px 20px rgba(0,0,0,0.12);
    transform: scale(0.95);
  }
  
  .filter-scroll {
    overflow-x: auto;
    white-space: nowrap;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none;  /* IE and Edge */
    padding-bottom: 2px;
  }
  .filter-scroll::-webkit-scrollbar {
    display: none; /* Chrome, Safari */
  }
  .filter-pill {
    padding: 8px 24px; border-radius: 50px; background: var(--white); border: 1px solid rgba(0,0,0,0.1);
    color: var(--green-main); font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: var(--transition);
    flex-shrink: 0;
  }
  .sticky-filters.scrolled .filter-pill {
    padding: 6px 16px;
    font-size: 0.75rem;
  }
  .filter-pill.active { background: var(--green-main); color: var(--white); box-shadow: 0 10px 20px rgba(27, 59, 37, 0.2); }

  .product-card {
    background: var(--white); border-radius: 28px; overflow: hidden; transition: var(--transition);
    height: 100%; display: flex; flex-direction: column; border: 1px solid rgba(0,0,0,0.03);
  }
  .product-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
  .product-img-wrap { position: relative; height: 260px; overflow: hidden; background: #f8faf8; }
  .product-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
  .product-card:hover .product-img-wrap img { transform: scale(1.1); }
  
  .product-badge { position: absolute; top: 15px; left: 15px; padding: 6px 14px; border-radius: 50px; background: rgba(255,255,255,0.9); font-size: 0.7rem; font-weight: 800; z-index: 2; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
  .best-seller-tag { position: absolute; top: 15px; right: 15px; background: linear-gradient(135deg, #f59e0b, #fbbf24); color:#fff; font-size:0.65rem; font-weight:900; padding:6px 12px; border-radius:50px; z-index:2; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3); }

  .product-body { padding: 24px; flex-grow: 1; display: flex; flex-direction: column; }
  .product-cat { font-size: 0.75rem; font-weight: 700; color: var(--tertiary); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; display: block; }
  .product-name { font-size: 1.25rem; font-weight: 800; color: var(--green-dark); margin-bottom: 12px; line-height: 1.3; }
  .product-price { font-size: 1.4rem; font-weight: 900; color: var(--green-main); margin-bottom: 20px; }

  .btn-detail-macha { width: 50px; height: 50px; border-radius: 16px; border: 2px solid var(--green-main); color: var(--green-main); background: transparent; transition: var(--transition); display: flex; align-items: center; justify-content: center; }
  .btn-detail-macha:hover { background: var(--green-main); color: var(--white); transform: rotate(15deg); }
  .btn-premium-cart { height: 50px; border-radius: 16px; background: var(--green-dark); color: var(--white); border: none; font-weight: 800; transition: var(--transition); padding: 0 20px; display: flex; align-items: center; justify-content: center; gap: 8px; }
  .btn-premium-cart:hover:not(:disabled) { background: var(--green-main); box-shadow: 0 10px 20px rgba(0,0,0,0.15); transform: scale(1.02); }
  .btn-premium-cart:disabled { opacity: 0.5; cursor: not-allowed; filter: grayscale(1); }

  .emoji-placeholder { width: 100%; height: 100%; display: none; align-items: center; justify-content: center; font-size: 5rem; background: #f8fcf9; }
  
  .modal-img-container img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.8s ease; }
  @media (max-width: 991px) {
      .modal-img-container { height: 35vh; min-height: 250px; }
  }
  @media (min-width: 992px) {
      .modal-img-container { height: 100%; min-height: 400px; }
  }
  .star-btn { cursor:pointer; font-size:1.6rem; transition: 0.2s; color:#d1d5db; }
  .star-btn.fa-solid { color:#f59e0b; }
  
  .ios-navbar-guest {
    position: fixed; bottom: 0; left: 0; transform: none;
    background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 0;
    padding: 10px 5px; display: flex; justify-content: space-evenly; align-items: center; width: 100%; max-width: none; z-index: 1040; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); border-top: 1px solid rgba(255,255,255,0.2); gap: 2px;
  }
  .ios-nav-item { display: flex; flex-direction: column; align-items: center; color: var(--green-light); text-decoration: none; font-size: 0.6rem; font-weight: 700; transition: all 0.3s ease; position: relative; padding: 6px 2px; border-radius: 20px; gap: 3px; flex: 1; text-align: center; }
  .ios-nav-item i { font-size: 1.3rem; margin-bottom: 2px; transition: all 0.3s ease; }
  .ios-nav-item.active { background: rgba(27, 59, 37, 0.08); color: var(--green-main); }
  .ios-nav-item.active i { transform: translateY(-2px) scale(1.05); }
  .fc-badge { position: absolute; top: 0px; right: 5px; background: #e53e3e; color: white; font-size: 0.65rem; padding: 2px 6px; border-radius: 50%; font-weight: 800; min-width: 20px; height: 20px; text-align: center; display: flex; align-items: center; justify-content: center; border: 2px solid #fff; }

  .toast-wrap { position: fixed; top: 30px; left: 50%; transform: translateX(-50%); z-index: 9999; }
  .toast-custom { background: var(--green-dark); color: white; padding: 16px 30px; border-radius: 50px; font-weight: 800; box-shadow: 0 15px 40px rgba(0,0,0,0.2); display: flex; align-items: center; border-left: 5px solid var(--tertiary); animation: slideDown 0.5s ease; }
  .toast-custom.err { border-left-color: #ff4757; }
  @keyframes slideDown { from { transform: translateY(-50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

  /* ─── MOBILE/PORTRAIT ONLY NAV ─── */
  @media (min-width: 992px) {
    .ios-navbar-guest { display: none !important; }
  }
  @media (orientation: landscape) and (max-height: 500px) {
    .ios-navbar-guest { display: none !important; }
  }
  
  /* ─── RESPONSIVE CARD FIX ─── */
  @media (max-width: 767px) {
    .product-body { padding: 15px; }
    .product-img-wrap { height: 180px; }
    .product-name { font-size: 1.05rem; margin-bottom: 8px; }
    .product-price { font-size: 1.15rem; margin-bottom: 12px; }
    .btn-detail-macha { width: 40px; height: 40px; border-radius: 12px; }
    .btn-premium-cart { height: 40px; border-radius: 12px; padding: 0 10px; font-size: 0.8rem; }
    .btn-premium-cart i { margin-right: 4px; }
  }
  @media (max-width: 380px) {
    .btn-premium-cart span { display: none; }
    .btn-premium-cart { justify-content: center; padding: 0; }
  }
</style>
</head>
<body>

<?php $this->load->view('layout/navbar'); ?>

<div class="shop-banner">
    <h1>Koleksi Premium</h1>
    <p>Rasakan kemurnian matcha Jepang terbaik yang dipilih khusus untuk kesegaran harimu.</p>
    <button class="btn btn-outline-light rounded-pill mt-3 px-4 fw-bold shadow-sm" id="btnTour" style="position: relative; z-index: 2;">
        <i class="fa-solid fa-map-location-dot me-2"></i>Panduan Menu
    </button>
</div>

<div class="sticky-filters">
    <div class="filter-group d-flex gap-2 filter-scroll">
        <button class="filter-pill active" data-cat="Semua">Semua Menu</button>
        <?php foreach($categories as $c): ?>
            <button class="filter-pill" data-cat="<?= htmlspecialchars($c['category_name']) ?>"><?= htmlspecialchars($c['category_name']) ?></button>
        <?php endforeach; ?>
    </div>
</div>

<div class="container product-grid">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h5 class="fw-bold mb-0" style="color: var(--green-dark);">
                <span id="resultInfo"><?= count($products??[]) ?> Produk Ditemukan</span>
            </h5>
        </div>
    </div>

    <div class="row g-3 g-md-4" id="productGrid">
    <?php
    $emojis=['🍵','☕','🧋','🍃','🌿','🥤','🫖','🍶'];
    if(!empty($products)):
    foreach($products as $i=>$p):
    $is_f=!empty($p['is_featured'])&&$p['is_featured']==1;
    ?>
    <div class="col-6 col-md-4 col-lg-3 prod-item" 
         data-name="<?= strtolower(htmlspecialchars($p['name'])) ?>" 
         data-cat="<?= htmlspecialchars($p['category_name']??'Matcha') ?>">
        <div class="product-card">
            <div class="product-img-wrap" onclick="window.showDetail(<?= $p['id'] ?>)" style="cursor:pointer;">
                <span class="product-badge <?=$p['stock']>0?'':'text-danger'?>">
                    <i class="fa-solid <?=$p['stock']>0?'fa-circle-check':'fa-circle-xmark'?> me-1"></i>
                    <?=$p['stock']>0?'Tersedia':'Habis'?>
                </span>
                <?php if($is_f):?><div class="best-seller-tag">BEST SELLER</div><?php endif;?>
                
                <?php if(!empty($p['image'])&&$p['image']!='default.jpg'):?>
                    <img src="<?= base_url('uploads/'.$p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" 
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="emoji-placeholder"><?=$emojis[$i%count($emojis)]?></div>
                <?php else:?>
                    <div class="emoji-placeholder" style="display:flex;"><?=$emojis[$i%count($emojis)]?></div>
                <?php endif;?>
            </div>
            <div class="product-body">
                <div class="product-header">
                    <span class="product-cat"><?= htmlspecialchars($p['category_name']??'Matcha') ?></span>
                    <h3 class="product-name"><?= htmlspecialchars($p['name']) ?></h3>
                </div>
                <div class="product-price">Rp <?= number_format($p['price'], 0, ',', '.') ?></div>
                
                <div class="d-flex gap-2 mt-auto pt-3">
                    <button type="button" class="btn btn-detail-macha" onclick="window.showDetail(<?= $p['id'] ?>)" title="Lihat Detail">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                    <button type="button" class="btn btn-premium-cart flex-grow-1" 
                            onclick="window.addToCart(<?= $p['id'] ?>, this)"
                            <?= $p['stock'] <= 0 || $shop_status == 'closed' ? 'disabled' : '' ?>>
                        <i class="fa-solid fa-cart-plus"></i>
                        <span><?= $shop_status == 'closed' ? 'Tutup' : ($p['stock'] <= 0 ? 'Habis' : 'Tambah') ?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach;
    else:?>
    <div class="col-12"><div class="empty-state"><span class="empty-icon">🍵</span><h4>Belum ada produk</h4><p>Admin sedang menyiapkan menu terbaik untukmu.</p></div></div>
    <?php endif;?>
    </div>

    <div id="noResults" style="display:none; text-align:center; padding:100px 0;">
        <i class="fa-solid fa-magnifying-glass mb-3" style="font-size: 3rem; color: var(--tertiary);"></i>
        <h4 style="font-weight: 800; color: var(--green-dark);">Pencarian Tidak Ditemukan</h4>
        <p style="color: var(--green-light);">Coba kata kunci lain atau kategori yang berbeda.</p>
    </div>
</div>

<footer class="text-center py-5">
    <p class="mb-0" style="font-size:.85rem; color:#8aa898">© <?=date('Y')?> <strong style="color:var(--gd)">MariMatcha</strong>. Dibuat dengan ❤️</p>
</footer>

<!-- MODAL DETAIL PRODUK -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 overflow-hidden" style="border-radius: 35px; box-shadow: 0 30px 100px rgba(0,0,0,0.25);">
            <div class="modal-body p-0 position-relative">
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal" style="position:absolute; top:25px; right:25px; z-index:100; background:white; border:none; width:45px; height:45px; border-radius:50%; display:flex; align-items:center; justify-content:center; color:var(--green-dark); cursor:pointer; box-shadow:0 10px 20px rgba(0,0,0,0.1);">
                    <i class="fa-solid fa-xmark fs-5"></i>
                </button>
                
                <div class="row g-0">
                    <div class="col-lg-6">
                        <div id="modalImgWrap" class="modal-img-container" style="background:#f8faf9; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                            <!-- Injected via JS -->
                        </div>
                    </div>
                    <div class="col-lg-6 bg-white">
                        <div class="p-4 d-flex flex-column h-100">
                            <div class="mb-4">
                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold mb-3" style="font-size: 0.7rem; letter-spacing: 1.5px; text-transform:uppercase;">Premium Matcha Series</span>
                                <h2 id="modalName" class="display-5 fw-900 mb-3" style="color: var(--green-dark); line-height: 1.1; letter-spacing:-1.5px;"></h2>
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div id="modalStars" class="fs-4 text-warning"></div>
                                    <span id="modalAvgText" class="text-muted fw-bold small"></span>
                                </div>
                                <div id="modalPrice" class="display-6 fw-950 text-success mb-3" style="letter-spacing:-1px;"></div>
                                <div class="mb-3">
                                    <h6 class="fw-bold text-uppercase text-muted mb-1" style="font-size:0.75rem; letter-spacing:1px;">Deskripsi</h6>
                                    <p id="modalDesc" class="text-secondary mb-0" style="font-size: 1.05rem; line-height: 1.5;"></p>
                                </div>
                                <div id="modalStock" class="d-inline-block px-3 py-2 bg-light rounded-3 border fw-bold text-dark small mb-3"></div>
                            </div>

                            <div class="mt-auto pt-3 border-top">
                                <?php if($this->session->userdata('userid')): ?>
                                    <div class="rating-input-wrap mb-3">
                                        <h6 class="fw-bold mb-2">Beri Penilaian Rasa</h6>
                                        <div class="d-flex gap-2 mb-2">
                                            <?php for($i=1;$i<=5;$i++): ?>
                                                <i class="fa-regular fa-star star-btn fs-3" data-rate="<?= $i ?>" style="cursor:pointer; color:#f59e0b; transition: transform 0.2s;"></i>
                                            <?php endfor; ?>
                                            <input type="hidden" id="rateValue" value="0">
                                        </div>
                                        <textarea id="rateComment" class="form-control border-0 shadow-none p-2 mb-2" rows="2" placeholder="Tulis review singkatmu..." style="background:#f8faf9; border-radius:12px; font-size:0.9rem;"></textarea>
                                        <button type="button" class="btn btn-success w-100 rounded-pill fw-bold" onclick="window.submitRating()" style="height:45px; background:var(--green-main); border:none;">Kirim Review</button>
                                    </div>
                                <?php else: ?>
                                    <div class="p-2 rounded-4 mb-3 text-center" style="background:#fffcf5; border:1px dashed #f59e0b;">
                                        <p class="small text-muted mb-0">Silakan <a href="<?= site_url('auth') ?>" class="fw-bold text-success">Login</a> untuk memberikan penilaian.</p>
                                    </div>
                                <?php endif; ?>

                                <button id="modalCartBtn" type="button" class="btn btn-dark w-100 rounded-pill px-4 fw-bold d-flex align-items-center justify-content-center gap-2" onclick="window.addToCartFromModal()" style="height:55px; font-size:1.05rem;">
                                    <i class="fa-solid fa-cart-plus fs-5"></i>
                                    <span>Tambah ke Keranjang</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<nav class="ios-navbar-guest" id="iosNav">
    <a href="<?= base_url(); ?>" class="ios-nav-item">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
    </a>
    <a href="<?= base_url('shop'); ?>" class="ios-nav-item active">
        <i class="fa-solid fa-mug-hot"></i>
        <span>Menu</span>
    </a>
    <a href="<?= base_url(); ?>#ulasan" class="ios-nav-item">
        <i class="fa-solid fa-star"></i>
        <span>Ulasan</span>
    </a>
    <a href="<?= base_url('shop/cart'); ?>" class="ios-nav-item">
        <i class="fa-solid fa-cart-shopping"></i>
        <span>Cart</span>
        <?php $cart_count = (isset($this->cart)) ? $this->cart->total_items() : 0; ?>
        <span class="fc-badge" style="<?= $cart_count > 0 ? 'display:flex' : 'display:none' ?>"><?= $cart_count ?></span>
    </a>
    <?php if ($this->session->userdata('userid')): ?>
        <a href="<?= ($this->session->userdata('role') == 'admin') ? site_url('dashboard') : site_url('user'); ?>" class="ios-nav-item">
            <i class="fa-solid fa-user-circle"></i>
            <span>Akun</span>
        </a>
    <?php else: ?>
        <a href="<?= site_url('auth'); ?>" class="ios-nav-item">
            <i class="fa-solid fa-right-to-bracket"></i>
            <span>Masuk</span>
        </a>
    <?php endif; ?>
</nav>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
    const pModal = new bootstrap.Modal(document.getElementById('productModal'));
    
    function showToast(msg, type) {
        if (typeof window.showDynamicIslandNotif === 'function') {
            window.showDynamicIslandNotif(msg, type);
        } else {
            const t = document.createElement('div');
            t.className = 'toast-wrap';
            t.innerHTML = `<div class="toast-custom ${type==='error'?'err':''}"><i class="fa-solid fa-circle-info me-2"></i> ${msg}</div>`;
            document.body.appendChild(t);
            setTimeout(() => {
                t.style.opacity = '0';
                setTimeout(() => t.remove(), 500);
            }, 3000);
        }
    }

    function syncCartBadge(count) {
        const badges = document.querySelectorAll('.fc-badge, .btn-hdr-out .badge');
        badges.forEach(b => {
            b.textContent = count;
            b.style.display = count > 0 ? 'flex' : 'none';
        });
    }

    window.showDetail = function(id) {
        if(!id) return;
        const imgWrap = document.getElementById('modalImgWrap');
        if(!imgWrap) return;
        imgWrap.innerHTML = '<div class="fa-2x py-5 text-center"><i class="fa-solid fa-spinner fa-spin text-success"></i></div>';
        pModal.show();
        
        fetch('<?= site_url("shop/get_product_details/") ?>' + id)
            .then(r => r.json())
            .then(res => {
                if(res.status === 'success') {
                    let d = res.data;
                    document.getElementById('modalName').textContent = d.name;
                    document.getElementById('modalDesc').textContent = d.description || 'Minuman matcha segar dengan resep rahasia yang autentik.';
                    document.getElementById('modalPrice').textContent = 'Rp ' + d.price;
                    document.getElementById('modalStock').textContent = 'Tersedia ' + d.stock + ' Porsi';
                    
                    imgWrap.innerHTML = (d.image && d.image !== 'default') 
                        ? `<img src="${d.image}" alt="${d.name}" style="width:100%; height:100%; object-fit:cover;">`
                        : `<div class="py-5 text-center" style="font-size:8rem;">🍵</div>`;

                    let sHtml = '';
                    for(let i=1; i<=5; i++) {
                        sHtml += `<i class="fa-star ${i <= Math.round(d.avg_rating) ? 'fa-solid' : 'fa-regular'}" style="color:#f59e0b"></i> `;
                    }
                    document.getElementById('modalStars').innerHTML = sHtml;
                    document.getElementById('modalAvgText').textContent = `${d.avg_rating} / 5.0 (${d.total_rating} Review)`;
                    document.getElementById('productModal').dataset.productId = d.id;

                    const box = document.getElementById('rateComment');
                    const btn = document.querySelector('button[onclick="window.submitRating()"]');
                    const stars = document.querySelectorAll('.star-btn');
                    
                    if(d.user_rating) {
                        document.getElementById('rateValue').value = d.user_rating.rating;
                        if(box) { box.value = d.user_rating.comment; box.readOnly = true; box.style.background = '#f9fbf9'; }
                        if(btn) btn.style.display = 'none';
                        stars.forEach(s => {
                            const r = parseInt(s.dataset.rate);
                            s.classList.toggle('fa-solid', r <= d.user_rating.rating);
                            s.classList.toggle('fa-regular', r > d.user_rating.rating);
                            s.style.pointerEvents = 'none';
                        });
                    } else {
                        document.getElementById('rateValue').value = '0';
                        if(box) { box.value = ''; box.readOnly = false; box.style.background = '#fff'; }
                        if(btn) btn.style.display = 'block';
                        stars.forEach(s => { s.classList.replace('fa-solid', 'fa-regular'); s.style.pointerEvents = 'auto'; });
                    }
                }
            });
    };

    window.addToCart = function(id, btn) {
        if(!id) return;
        const original = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
        fetch('<?= site_url("shop/add_to_cart_ajax/") ?>' + id, { method: 'POST' })
            .then(r => r.json())
            .then(res => {
                if(res.status === 'redirect') {
                    window.location.href = res.url;
                    return;
                }
                if(res.status === 'success') {
                    showToast(res.message, 'success');
                    syncCartBadge(res.cart_count);
                    confetti({ particleCount: 100, spread: 70, origin: { y: 0.6 } });
                } else { showToast(res.message, 'error'); }
            })
            .finally(() => { btn.disabled = false; btn.innerHTML = original; });
    };

    window.addToCartFromModal = function() {
        const id = document.getElementById('productModal').dataset.productId;
        window.addToCart(id, document.getElementById('modalCartBtn'));
    };

    window.filterProducts = function() {
        const activeNode = document.querySelector('.filter-pill.active');
        if(!activeNode) return;
        const active = activeNode.dataset.cat.trim().toLowerCase();
        const items = document.querySelectorAll('.prod-item');
        let count = 0;
        items.forEach(el => {
            const cat = el.dataset.cat.trim().toLowerCase();
            if(active === 'semua' || cat === active) {
                el.style.display = 'block'; count++;
                gsap.to(el, { opacity: 1, y: 0, duration: 0.4 });
            } else { el.style.display = 'none'; }
        });
        const rText = document.getElementById('resultInfo');
        if(rText) rText.textContent = count + ' Produk Ditemukan';
        document.getElementById('noResults').style.display = count === 0 ? 'block' : 'none';
    };

    window.submitRating = function() {
        const id = document.getElementById('productModal').dataset.productId;
        const r = document.getElementById('rateValue').value;
        const c = document.getElementById('rateComment').value;
        if(r == 0) { showToast('Pilih rating bintang dulu ya!', 'error'); return; }
        const btn = document.querySelector('button[onclick="window.submitRating()"]');
        btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
        const fd = new FormData();
        fd.append('product_id', id); fd.append('rating', r); fd.append('comment', c);
        fetch('<?= site_url("shop/submit_rating") ?>', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(res => {
                if(res.status === 'success') {
                    showToast(res.message, 'success');
                    setTimeout(() => window.showDetail(id), 1000);
                } else { showToast(res.message, 'error'); btn.disabled = false; btn.innerHTML = 'Kirim Review'; }
            });
    };

    document.addEventListener("DOMContentLoaded", function() {
        gsap.registerPlugin(ScrollTrigger);
        const params = new URLSearchParams(window.location.search);
        if(params.get('detail')) setTimeout(() => window.showDetail(params.get('detail')), 500);

        document.querySelectorAll('.filter-pill').forEach(p => {
            p.addEventListener('click', function() {
                document.querySelectorAll('.filter-pill').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                window.filterProducts();
            });
        });

        gsap.set(".prod-item", { opacity: 0, y: 30 });
        ScrollTrigger.batch(".prod-item", {
            onEnter: batch => gsap.to(batch, { opacity: 1, y: 0, duration: 0.8, stagger: 0.1, ease: "power2.out" }),
            start: "top 95%"
        });

        document.querySelectorAll('.star-btn').forEach(s => {
            s.addEventListener('click', function() {
                const v = parseInt(this.dataset.rate);
                document.getElementById('rateValue').value = v;
                document.querySelectorAll('.star-btn').forEach(star => {
                    const r = parseInt(star.dataset.rate);
                    star.classList.toggle('fa-solid', r <= v);
                    star.classList.toggle('fa-regular', r > v);
                });
            });
        });

        let lastY = window.scrollY;
        window.addEventListener('scroll', () => {
            // iOS Nav hidden on scroll down
            const nav = document.getElementById('iosNav');
            if(nav) {
                if(window.scrollY > lastY && window.scrollY > 100) gsap.to(nav, { y: 100, opacity: 0 });
                else gsap.to(nav, { y: 0, opacity: 1 });
            }
            
            // Sticky Filters Shrink
            const filters = document.querySelector('.sticky-filters');
            if(filters) {
                if(window.scrollY > 150) filters.classList.add('scrolled');
                else filters.classList.remove('scrolled');
            }
            
            lastY = window.scrollY;
        });
    });

    // ─── TOUR DRIVER.JS ───
    const driver = window.driver.js.driver;
    const tourDriver = driver({
      showProgress: true,
      animate: true,
      nextBtnText: 'Lanjut',
      prevBtnText: 'Kembali',
      doneBtnText: 'Selesai',
      steps: [
        { popover: { title: 'Selamat Datang! 🍵', description: 'Mari kita kenali cara memesan minuman favoritmu di MariMatcha.' } },
        { element: '.sticky-filters', popover: { title: 'Kategori Menu', description: 'Kamu bisa memfilter minuman berdasarkan kategori seperti Best Seller, Coffee, dll di sini.', side: "bottom", align: 'center' } },
        { element: '.prod-card:first-child', popover: { title: 'Detail Produk', description: 'Klik foto minuman untuk melihat deskripsi lengkap dan memberikan review atau melihat review pelanggan lain!', side: "right", align: 'start' } },
        { element: '.prod-card:first-child .btn-add-cart', popover: { title: 'Masukkan Keranjang', description: 'Pilih produk yang kamu inginkan dan klik tombol ini. Jangan lupa untuk mengatur preferensi (Less Sugar, Extra Ice, dll) nanti di Keranjang!', side: "bottom", align: 'center' } },
        { element: '#iosNav', popover: { title: 'Navigasi Pintar', description: 'Gunakan navigasi di bawah ini untuk berpindah halaman atau melihat Keranjang kamu saat di HP.', side: "top", align: 'center' } }
      ]
    });

    document.getElementById('btnTour').addEventListener('click', () => {
        tourDriver.drive();
    });
</script>
</body>
</html>
