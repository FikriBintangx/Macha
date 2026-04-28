<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Katalog Menu | MariMatcha</title>
<meta name="description" content="Pilih minuman matcha premium favoritmu. Berbagai varian tersedia, fresh setiap hari.">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
  body {
    font-family: 'Outfit', sans-serif;
    background: var(--cream);
    color: var(--text);
    overflow-x: hidden;
    padding-top: 80px;
  }

  /* ─── PREMIUM BANNER ─── */
  .shop-banner {
    background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-main) 100%);
    padding: 100px 0 80px;
    position: relative;
    overflow: hidden;
    color: var(--white);
    text-align: center;
  }
  .shop-banner::before {
    content: 'MATCHA';
    position: absolute;
    top: 50%; left: 50%; transform: translate(-50%, -50%);
    font-size: 15vw; font-weight: 950; opacity: 0.03; letter-spacing: 20px;
  }
  .shop-banner h1 { font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 900; margin-bottom: 15px; position: relative; z-index: 1; }
  .shop-banner p { font-size: 1.1rem; opacity: 0.8; max-width: 600px; margin: 0 auto; position: relative; z-index: 1; }

  /* ─── STICKY FILTER BAR ─── */
  .sticky-filters {
    position: sticky;
    top: 80px;
    z-index: 100;
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 15px 0;
  }
  .filter-scroll {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    padding-bottom: 5px;
    scrollbar-width: none; /* Hide for Firefox */
  }
  .filter-scroll::-webkit-scrollbar { display: none; } /* Hide for Chrome */

  .filter-pill {
    white-space: nowrap;
    padding: 8px 24px;
    border-radius: 50px;
    background: var(--white);
    border: 1px solid rgba(0,0,0,0.1);
    color: var(--green-main);
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    transition: var(--transition);
  }
  .filter-pill.active {
    background: var(--green-main);
    color: var(--white);
    border-color: var(--green-main);
    box-shadow: 0 10px 20px rgba(27, 59, 37, 0.2);
  }

  /* ─── PRODUCT GRID ─── */
  .product-grid {
    padding: 40px 0 100px;
  }
  .product-card {
    background: var(--white);
    border-radius: 28px;
    overflow: hidden;
    transition: var(--transition);
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(0,0,0,0.03);
    will-change: transform, opacity;
  }
  .product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 60px rgba(16, 36, 22, 0.12);
  }
  .product-img-wrap {
    height: 240px;
    position: relative;
    overflow: hidden;
    background: #f8fcf9;
  }
  .product-img-wrap img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .product-card:hover img { transform: scale(1.1); }
  
  .product-badge {
    position: absolute;
    top: 15px; left: 15px;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);
    padding: 5px 15px;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 800;
    color: var(--green-dark);
    z-index: 2;
  }

  .product-body {
    padding: 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
  }
  .product-cat { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--tertiary); letter-spacing: 1px; margin-bottom: 5px; }
  .product-name { font-size: 1.15rem; font-weight: 900; color: var(--green-dark); margin-bottom: 8px; line-height: 1.2; }
  .product-price { font-size: 1.25rem; font-weight: 950; color: var(--green-main); margin-bottom: 15px; }

  .btn-premium-cart {
    background: var(--green-dark);
    color: var(--white);
    border: none;
    padding: 14px;
    border-radius: 20px;
    font-weight: 800;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: var(--transition);
    width: 100%;
    margin-top: auto;
  }
  .btn-premium-cart:hover {
    background: var(--green-main);
    transform: scale(1.02);
  }

  /* ─── UTILS ─── */
  .invisible-init { opacity: 0; transform: translateY(30px); }

  @media (max-width: 768px) {
    .product-img-wrap { height: 180px; }
    .product-body { padding: 15px; }
    .product-name { font-size: 1rem; }
    .sticky-filters { top: 72px; }
  }9rem;}

/* RESULT COUNT */
.result-info{padding:16px 0 8px;font-size:.88rem;color:#8aa898;font-weight:600;}

/* EMPTY STATE */
.empty-state{text-align:center;padding:80px 20px;}
.empty-icon{font-size:5rem;margin-bottom:16px;display:block;animation:float-empty 3s ease-in-out infinite;}
@keyframes float-empty{0%,100%{transform:translateY(0);}50%{transform:translateY(-12px);}}

/* TOAST */
.toast-wrap{position:fixed;top:90px;right:24px;z-index:9999;}
.toast-custom{background:#fff;border-left:4px solid var(--gm);border-radius:14px;box-shadow:0 8px 28px rgba(0,0,0,.1);padding:14px 20px;display:flex;align-items:center;gap:12px;font-family:'Outfit',sans-serif;font-weight:600;animation:toast-in .4s ease;}
.toast-custom.err{border-left-color:#e63946;}
@keyframes toast-in{from{opacity:0;transform:translateX(40px);}to{opacity:1;transform:translateX(0);}}

/* FLOATING CART */
.floating-cart{position:fixed;bottom:28px;right:28px;width:56px;height:56px;border-radius:50%;background:var(--gd);color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.3rem;text-decoration:none;box-shadow:0 8px 25px rgba(45,90,39,.4);z-index:999;transition:.25s;}
.floating-cart:hover{background:var(--gm);color:#fff;transform:scale(1.1);}
.fc-badge{position:absolute;top:-4px;right:-4px;background:#e63946;color:#fff;border-radius:50%;width:20px;height:20px;font-size:.65rem;font-weight:800;display:flex;align-items:center;justify-content:center;animation:pulse-badge 2s infinite;}
@keyframes pulse-badge{0%{box-shadow:0 0 0 0 rgba(230,57,70,.6);}70%{box-shadow:0 0 0 8px rgba(230,57,70,0);}100%{box-shadow:0 0 0 0 rgba(230,57,70,0);}}

/* CARD REVEAL */
.prod-card{opacity:0;transform:translateY(24px);transition:.5s cubic-bezier(.16,1,.3,1);}
.prod-card.visible{opacity:1;transform:translateY(0);}

/* RIPPLE */
.btn-cart,.btn-cart-out{cursor:pointer;}
.ripple-c{position:absolute;border-radius:50%;background:rgba(255,255,255,.35);transform:scale(0);animation:rip .5s linear;pointer-events:none;}
@keyframes rip{to{transform:scale(5);opacity:0;}}

/* NO RESULTS */
#noResults{display:none;text-align:center;padding:60px 20px;color:#8aa898;}

footer{background:#fff;border-top:1px solid #e8ede8;padding:24px 0;}

@media(max-width:576px){
.prod-img-wrap{height:160px;}
.search-section .d-flex{flex-direction:column;gap:8px;}
}
</style>
</head>
<body>

<!-- TOAST -->
<?php if($this->session->flashdata('success')):?>
<div class="toast-wrap" id="toastWrap">
<div class="toast-custom"><i class="fa-solid fa-check-circle" style="color:var(--gm);font-size:1.2rem"></i><?=$this->session->flashdata('success')?></div>
</div>
<!-- Confetti Celebration -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var duration = 2000;
    var end = Date.now() + duration;
    (function frame() {
        confetti({ particleCount: 4, angle: 60, spread: 55, origin: { x: 0 }, colors: ['#40916c', '#84cc9d', '#ffffff'] });
        confetti({ particleCount: 4, angle: 120, spread: 55, origin: { x: 1 }, colors: ['#40916c', '#84cc9d', '#ffffff'] });
        if (Date.now() < end) requestAnimationFrame(frame);
    }());
});
</script>
<?php elseif($this->session->flashdata('error')):?>
<div class="toast-wrap" id="toastWrap">
<div class="toast-custom err"><i class="fa-solid fa-circle-exclamation" style="color:#e63946;font-size:1.2rem"></i><?=$this->session->flashdata('error')?></div>
</div>
<?php endif;?>

<?php $this->load->view('layout/navbar'); ?>

<!-- PAGE BANNER -->
<div class="shop-banner">
    <h1>Koleksi Premium</h1>
    <p>Rasakan kemurnian matcha Jepang terbaik yang dipilih khusus untuk kesegaran harimu.</p>
</div>

<!-- STICKY FILTER BAR -->
<div class="sticky-filters">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <div class="filter-scroll flex-grow-1" id="filterScroll">
                <button class="filter-pill active" data-cat="Semua">Semua Menu</button>
                <?php foreach($categories as $c): ?>
                    <button class="filter-pill" data-cat="<?= htmlspecialchars($c['category_name']) ?>"><?= htmlspecialchars($c['category_name']) ?></button>
                <?php endforeach; ?>
            </div>
            <div class="d-none d-md-block">
                <select class="sort-select border-0 bg-transparent fw-bold" id="sortSelect" style="outline:none; cursor:pointer; font-size: 0.85rem; color: var(--green-main);">
                    <option value="default">Urutkan: Terbaru</option>
                    <option value="price-asc">Harga Terendah</option>
                    <option value="price-desc">Harga Tertinggi</option>
                    <option value="stock-desc">Stok Terbanyak</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- PRODUCTS SECTION -->
<div class="container product-grid">
    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <div class="result-info" id="resultInfo" style="font-weight: 700; color: var(--green-light);"><?= count($products??[]) ?> Produk Ditemukan</div>
        <div class="search-wrap" style="position:relative; max-width: 250px; width: 100%;">
            <input type="text" class="form-control border-0 bg-white rounded-pill px-4" id="searchInput" placeholder="Cari menu..." style="font-size: 0.85rem; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <i class="fa-solid fa-magnifying-glass" style="position:absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--tertiary); font-size: 0.8rem;"></i>
        </div>
    </div>

    <div class="row g-3 g-md-4" id="productGrid">
    <?php
    $emojis=['🍵','☕','🧋','🍃','🌿','🥤','🫖','🍶'];
    if(!empty($products)):
    foreach($products as $i=>$p):
    $pct=min(100,max(8,($p['stock']/50)*100));
    $is_f=!empty($p['is_featured'])&&$p['is_featured']==1;
    ?>
    <div class="col-6 col-md-4 col-lg-3 prod-item invisible-init"
         data-name="<?=strtolower(htmlspecialchars($p['name']))?>"
         data-cat="<?=htmlspecialchars($p['category_name']??'Matcha')?>"
         data-price="<?=$p['price']?>"
         data-stock="<?=$p['stock']?>">
        <div class="product-card">
            <div class="product-img-wrap" onclick="showDetail(<?= $p['id'] ?>)" style="cursor:pointer;">
                <span class="product-badge <?=$p['stock']>0?'':'text-danger'?>">
                    <i class="fa-solid <?=$p['stock']>0?'fa-circle-check':'fa-circle-xmark'?> me-1"></i>
                    <?=$p['stock']>0?'Tersedia':'Habis'?>
                </span>
                <?php if($is_f):?><div style="position:absolute; top:15px; right:15px; z-index:2; background: linear-gradient(135deg, #f59e0b, #fbbf24); color:#fff; font-size:0.65rem; font-weight:900; padding:4px 10px; border-radius:50px; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);">BEST SELLER</div><?php endif;?>
                
                <?php if(!empty($p['image'])&&$p['image']!='default.jpg'):?>
                    <img src="<?= base_url('uploads/'.$p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" loading="lazy"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div style="display:none; width:100%; height:100%; align-items:center; justify-content:center; font-size:5rem; background:#f8fcf9;"><?=$emojis[$i%count($emojis)]?></div>
                <?php else:?>
                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:5rem; background:#f8fcf9;"><?=$emojis[$i%count($emojis)]?></div>
                <?php endif;?>
            </div>
            <div class="product-body">
                <div class="product-cat"><?=htmlspecialchars($p['category_name']??'Matcha')?></div>
                <h3 class="product-name"><?=htmlspecialchars($p['name'])?></h3>
                <div class="product-price">Rp <?=number_format($p['price'],0,',','.')?></div>
                
                <?php if($p['stock']>0):?>
                    <div class="d-flex flex-column gap-2 mt-auto">
                        <?php if($shop_status == 'closed'): ?>
                            <div class="btn-premium-cart" style="background:#f1f5f2; color:#8aa898; cursor:not-allowed;">
                                <i class="fa-solid fa-clock"></i><span>Toko Tutup</span>
                            </div>
                        <?php elseif($this->session->userdata('role') == 'admin'): ?>
                            <div class="btn-premium-cart" style="background:#f1f5f2; color:#8aa898; cursor:default;">
                                <i class="fa-solid fa-lock"></i><span>Mode Kelola</span>
                            </div>
                        <?php else: ?>
                            <button type="button" class="btn-premium-cart" onclick="addToCart(<?= $p['id'] ?>, this)">
                                <i class="fa-solid fa-cart-plus"></i><span>Tambah</span>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php else:?>
                    <div class="btn-premium-cart" style="background:#fdf2f2; color:#e63946; cursor:not-allowed;">
                        <i class="fa-solid fa-ban"></i><span>Stok Habis</span>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
    <?php endforeach;
    else:?>
    <div class="col-12"><div class="empty-state"><span class="empty-icon">🍵</span><h4 style="color:var(--green-dark)">Belum ada produk</h4><p style="color:var(--green-light)">Admin sedang menyiapkan menu terbaik untukmu.</p></div></div>
    <?php endif;?>
    </div>
    <div id="noResults" style="display:none; text-align:center; padding:100px 0;">
        <i class="fa-solid fa-magnifying-glass mb-3" style="font-size: 3rem; color: var(--tertiary);"></i>
        <h4 style="font-weight: 800; color: var(--green-dark);">Pencarian Tidak Ditemukan</h4>
        <p style="color: var(--green-light);">Coba kata kunci lain atau kategori yang berbeda.</p>
    </div>
</div>

<footer class="text-center"><p class="mb-0" style="font-size:.85rem;color:#8aa898">© <?=date('Y')?> <strong style="color:var(--gd)">MariMatcha</strong>. Dibuat dengan ❤️</p></footer>

<!-- MODAL DETAIL PRODUK -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0" style="border-radius:40px; overflow:hidden; box-shadow: 0 40px 100px rgba(16, 36, 22, 0.3);">
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-5">
                        <div id="modalImgWrap" style="height:100%; min-height:400px; background:linear-gradient(135deg, #f8fcf9 0%, #eef3eb 100%); display:flex; align-items:center; justify-content:center; overflow:hidden; position:relative;">
                            <img id="modalImg" src="" style="width:100%; height:100%; object-fit:cover; transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);">
                        </div>
                    </div>
                    <div class="col-md-7" style="background: var(--white);">
                        <div class="p-4 p-lg-5 position-relative">
                            <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" style="top:30px; right:30px; z-index:10; background-color:rgba(0,0,0,0.05); padding:12px; border-radius:50%;"></button>
                            
                            <div class="mb-4">
                                <h3 id="modalName" class="fw-black mb-1" style="font-size: 2rem; color: var(--green-dark); letter-spacing: -1px;">Produk</h3>
                                <div class="d-flex align-items-center gap-3">
                                    <span id="modalPrice" class="h3 fw-black mb-0" style="color: var(--green-main);">Rp 0</span>
                                    <span class="badge bg-light text-success rounded-pill px-3" id="modalStock" style="font-weight: 800;">Stok: 0</span>
                                </div>
                            </div>
                            
                            <!-- Average Rating Display -->
                            <div class="d-flex align-items-center mb-4 gap-2 py-2 px-3 rounded-pill" style="background: #fff8eb; width: fit-content;">
                                <div id="modalStars" class="text-warning d-flex gap-1" style="font-size: 0.9rem;"></div>
                                <span id="modalAvgText" class="fw-black" style="font-size: 0.85rem; color: #b45309;">0 (0 Penilaian)</span>
                            </div>

                            <div class="mb-4">
                                <h6 class="fw-black small text-uppercase letter-spacing-1 mb-2" style="color: var(--tertiary);">Deskripsi Produk</h6>
                                <p id="modalDesc" class="text-secondary" style="line-height:1.6; font-size: 0.95rem;">Deskripsi...</p>
                            </div>

                            <!-- Rating Action Section -->
                            <?php if($this->session->userdata('userid')): ?>
                                <?php if($this->session->userdata('role') != 'admin'): ?>
                                <div class="rating-box p-4 rounded-4 mb-4" style="background:rgba(245, 245, 240, 0.5); border:1.5px solid #edf2ed; backdrop-filter: blur(10px);">
                                    <h6 class="fw-black small mb-3 text-success">Beri Penilaian Rasa</h6>
                                    <div class="star-rating mb-3 d-flex gap-2" id="starInput">
                                        <i class="fa-star fa-regular star-btn" data-rate="1"></i>
                                        <i class="fa-star fa-regular star-btn" data-rate="2"></i>
                                        <i class="fa-star fa-regular star-btn" data-rate="3"></i>
                                        <i class="fa-star fa-regular star-btn" data-rate="4"></i>
                                        <i class="fa-star fa-regular star-btn" data-rate="5"></i>
                                    </div>
                                    <input type="hidden" id="rateValue" value="0">
                                    <textarea id="rateComment" class="form-control border-0 mb-3 shadow-sm" rows="2" placeholder="Apa pendapatmu tentang rasa ini?" style="border-radius:15px; padding:12px; font-size:0.9rem;"></textarea>
                                    <button type="button" onclick="submitRating()" class="btn btn-success w-100 rounded-pill py-2 fw-black shadow-sm" style="background: var(--green-main); border:none;">Kirim Penilaian</button>
                                </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="p-4 rounded-4 mb-4 text-center" style="background:#fff7ed; border:1.5px dashed #fed7aa;">
                                    <p class="small text-muted mb-3"><i class="fa-solid fa-lock me-2 text-warning"></i> Login untuk memberikan penilaian produk ini.</p>
                                    <a href="<?= base_url('auth') ?>" class="btn btn-sm btn-warning rounded-pill px-4 fw-black text-white" style="background: #f59e0b; border:none;">Login Sekarang</a>
                                </div>
                            <?php endif; ?>

                            <div id="modalOrderActions">
                                <?php if($shop_status == 'closed'): ?>
                                    <div class="py-3 text-center w-100 rounded-pill" style="background:#f1f5f2; color:#8aa898; font-weight:800;">
                                        <i class="fa-solid fa-clock me-2"></i> TOKO SEDANG TUTUP
                                    </div>
                                <?php elseif($this->session->userdata('role') == 'admin'): ?>
                                    <div class="py-3 text-center w-100 rounded-pill" style="background:#eef3eb; color:#8aa898; font-weight:800;">
                                        <i class="fa-solid fa-lock me-2"></i> MODE KELOLA MENU
                                    </div>
                                <?php else: ?>
                                    <button id="modalCartBtn" type="button" class="btn btn-success w-100 py-3 rounded-pill fw-black shadow-lg" 
                                            onclick="addToCartFromModal()" style="background: var(--green-dark); border:none; font-size: 1.1rem; letter-spacing: -0.5px;">
                                        <i class="fa-solid fa-cart-plus me-2"></i> Tambah ke Keranjang
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.star-btn { cursor:pointer; font-size:1.6rem; transition: var(--transition); color:#d1d5db; }
.star-btn.active, .star-btn:hover { color:#f59e0b; transform: scale(1.2); }
.star-btn.fa-solid { color:#f59e0b; }
.fw-black { font-weight: 900; }

@media (max-width: 768px) {
    #modalImgWrap { min-height: 250px; }
    .modal-content { border-radius: 30px; }
}
</style>

<!-- GSAP & ScrollTrigger -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        gsap.registerPlugin(ScrollTrigger);

        // 1. Entrance Animations
        const tl = gsap.timeline();
        tl.from(".shop-banner h1", { y: 50, opacity: 0, duration: 1, ease: "power4.out" })
          .from(".shop-banner p", { y: 20, opacity: 0, duration: 0.8, ease: "power4.out" }, "-=0.6")
          .from(".sticky-filters", { y: -20, opacity: 0, duration: 0.6, ease: "power2.out" }, "-=0.4");

        // 2. Product Grid Staggered Reveal
        function initScrollAnimations() {
            gsap.utils.toArray('.prod-item').forEach((item, i) => {
                gsap.to(item, {
                    opacity: 1,
                    y: 0,
                    duration: 0.8,
                    ease: "power3.out",
                    scrollTrigger: {
                        trigger: item,
                        start: "top 90%",
                        toggleActions: "play none none reverse",
                        once: true // Performance: only animate once
                    }
                });
            });
        }
        initScrollAnimations();

        // 3. Search & Filter Logic (Optimized)
        const items = document.querySelectorAll('.prod-item');
        const ri = document.getElementById('resultInfo');
        const ng = document.getElementById('noResults');
        const grid = document.getElementById('productGrid');

        function filterProducts() {
            const q = document.getElementById('searchInput').value.toLowerCase().trim();
            const activeCat = document.querySelector('.filter-pill.active').dataset.cat;
            const sort = document.getElementById('sortSelect').value;
            
            let visibleCount = 0;
            const visibleItems = [];

            items.forEach(el => {
                const name = el.dataset.name;
                const cat = el.dataset.cat;
                const matchQ = !q || name.includes(q);
                const matchC = activeCat === 'Semua' || cat === activeCat;

                if (matchQ && matchC) {
                    el.style.display = '';
                    visibleCount++;
                    visibleItems.push(el);
                    // Re-trigger GSAP for newly visible items if they haven't animated yet
                    gsap.to(el, { opacity: 1, y: 0, duration: 0.4 });
                } else {
                    el.style.display = 'none';
                }
            });

            // Sorting
            visibleItems.sort((a, b) => {
                if(sort === 'price-asc') return +a.dataset.price - +b.dataset.price;
                if(sort === 'price-desc') return +b.dataset.price - +a.dataset.price;
                if(sort === 'stock-desc') return +b.dataset.stock - +a.dataset.stock;
                return 0; // Default: Order by database sequence
            });

            visibleItems.forEach(el => grid.appendChild(el));
            ri.textContent = visibleCount + ' Produk Ditemukan';
            ng.style.display = visibleCount === 0 ? 'block' : 'none';
            ScrollTrigger.refresh();
        }

        document.getElementById('searchInput').addEventListener('input', filterProducts);
        document.getElementById('sortSelect').addEventListener('change', filterProducts);
        document.querySelectorAll('.filter-pill').forEach(pill => {
            pill.addEventListener('click', function() {
                document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
                this.classList.add('active');
                filterProducts();
                
                // Scroll pill into view on mobile
                this.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
            });
        });

        // 4. Modal Logic
        const pModal = new bootstrap.Modal(document.getElementById('productModal'));
        window.showDetail = function(id) {
            document.getElementById('modalImgWrap').innerHTML = '<div class="fa-2x"><i class="fa-solid fa-spinner fa-spin text-success"></i></div>';
            pModal.show();
            
            fetch('<?= base_url("shop/get_product_details/") ?>' + id)
                .then(res => res.json())
                .then(res => {
                    if(res.status === 'success') {
                        let d = res.data;
                        document.getElementById('modalName').textContent = d.name;
                        document.getElementById('modalDesc').textContent = d.description || 'Minuman matcha segar dengan resep rahasia.';
                        document.getElementById('modalPrice').textContent = 'Rp ' + d.price;
                        document.getElementById('modalStock').textContent = 'Stok: ' + d.stock;
                        
                        if(d.image && d.image !== 'default') {
                            document.getElementById('modalImgWrap').innerHTML = `<img src="${d.image}" style="width:100%; height:100%; object-fit:cover;">`;
                        } else {
                            document.getElementById('modalImgWrap').innerHTML = `<div style="font-size:6rem">🍵</div>`;
                        }

                        let starsHtml = '';
                        for(let i=1; i<=5; i++) {
                            starsHtml += `<i class="fa-star ${i <= Math.round(d.avg_rating) ? 'fa-solid' : 'fa-regular'}" style="color:#f59e0b"></i>`;
                        }
                        document.getElementById('modalStars').innerHTML = starsHtml;
                        document.getElementById('modalAvgText').textContent = `${d.avg_rating} (${d.total_rating} Penilaian)`;
                        document.getElementById('productModal').dataset.productId = d.id;

                        // Check if user has rated this product (Read-Only Mode)
                        const userRatingBox = document.getElementById('rateComment');
                        const ratingBtn = document.querySelector('button[onclick="submitRating()"]');
                        const starBtns = document.querySelectorAll('.star-btn');
                        
                        if (userRatingBox) {
                            if (d.user_rating) {
                                document.getElementById('rateValue').value = d.user_rating.rating;
                                userRatingBox.value = d.user_rating.comment;
                                userRatingBox.readOnly = true;
                                userRatingBox.style.background = '#f9fbf9';
                                userRatingBox.style.opacity = '0.7';
                                
                                starBtns.forEach(s => {
                                    s.classList.remove('fa-solid', 'active');
                                    s.classList.add('fa-regular');
                                    if (parseInt(s.dataset.rate) <= d.user_rating.rating) {
                                        s.classList.remove('fa-regular');
                                        s.classList.add('fa-solid', 'active');
                                    }
                                    s.style.pointerEvents = 'none'; // Read-only
                                    s.style.opacity = '0.7';
                                });
                                
                                if (ratingBtn) {
                                    ratingBtn.style.display = 'none';
                                }
                            } else {
                                document.getElementById('rateValue').value = '0';
                                userRatingBox.value = '';
                                userRatingBox.readOnly = false;
                                userRatingBox.style.background = '#fff';
                                userRatingBox.style.opacity = '1';
                                
                                starBtns.forEach(s => {
                                    s.classList.remove('fa-solid', 'active');
                                    s.classList.add('fa-regular');
                                    s.style.pointerEvents = 'auto'; // Clickable
                                    s.style.opacity = '1';
                                });
                                
                                if (ratingBtn) {
                                    ratingBtn.style.display = 'block';
                                    ratingBtn.disabled = false;
                                    ratingBtn.innerHTML = 'Kirim Penilaian';
                                    ratingBtn.style.background = 'var(--green-main)';
                                    ratingBtn.style.color = '#fff';
                                }
                            }
                        }
                    }
                });
        };

        // Star Rating Click Logic
        const stars = document.querySelectorAll('.star-btn');
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const val = parseInt(this.dataset.rate);
                document.getElementById('rateValue').value = val;
                stars.forEach(s => {
                    if (parseInt(s.dataset.rate) <= val) {
                        s.classList.remove('fa-regular');
                        s.classList.add('fa-solid', 'active');
                    } else {
                        s.classList.remove('fa-solid', 'active');
                        s.classList.add('fa-regular');
                    }
                });
            });
        });

        // Submit Rating Function
        window.submitRating = function() {
            const pid = document.getElementById('productModal').dataset.productId;
            const rate = document.getElementById('rateValue').value;
            const comment = document.getElementById('rateComment').value;
            const btn = document.querySelector('button[onclick="submitRating()"]');

            if (rate == 0) {
                showToast('Pilih jumlah bintang terlebih dahulu.', 'error');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';

            const formData = new FormData();
            formData.append('product_id', pid);
            formData.append('rating', rate);
            formData.append('comment', comment);

            fetch('<?= base_url("shop/submit_rating") ?>', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if(res.status === 'success') {
                    showToast(res.message, 'success');
                    btn.innerHTML = '<i class="fa-solid fa-check-circle me-2"></i> Penilaian Anda Disimpan';
                    btn.style.background = '#8aa898';
                    document.getElementById('rateComment').readOnly = true;
                    stars.forEach(s => s.style.pointerEvents = 'none');
                    
                    // Refresh data produk agar average rating langsung update
                    setTimeout(() => showDetail(pid), 1000);
                } else {
                    showToast(res.message, 'error');
                    btn.disabled = false;
                    btn.innerHTML = 'Kirim Penilaian';
                }
            })
            .catch(err => {
                showToast('Terjadi kesalahan.', 'error');
                btn.disabled = false;
                btn.innerHTML = 'Kirim Penilaian';
            });
        };

        // 5. Cart Logic (AJAX)
        window.addToCart = function(id, btn) {
            if(btn) {
                btn.disabled = true;
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

                fetch('<?= base_url("shop/add_to_cart_ajax/") ?>' + id, { method: 'POST' })
                    .then(res => res.json())
                    .then(res => {
                        if(res.status === 'success') {
                            showToast(res.message, 'success');
                            const badge = document.querySelector('.btn-hdr-out .badge');
                            if(badge) badge.textContent = res.cart_count;
                            
                            confetti({
                                particleCount: 80,
                                spread: 60,
                                origin: { y: 0.8 },
                                colors: ['#102416', '#1B3B25', '#8BAA7C']
                            });
                        } else {
                            showToast(res.message, 'error');
                        }
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                    });
            }
        };

        function showToast(msg, type) {
            const wrap = document.createElement('div');
            wrap.className = 'toast-wrap';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-circle-exclamation';
            const color = type === 'success' ? '#1B3B25' : '#e63946';
            wrap.innerHTML = `<div class="toast-custom ${type==='error'?'err':''}">
                <i class="fa-solid ${icon}" style="color:${color}"></i> ${msg}
            </div>`;
            document.body.appendChild(wrap);
            setTimeout(() => {
                wrap.style.opacity = '0';
                setTimeout(() => wrap.remove(), 600);
            }, 3000);
        }
    });
</script>
</body>
</html>
