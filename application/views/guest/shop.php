<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Katalog Menu | MariMacha</title>
<meta name="description" content="Pilih minuman matcha premium favoritmu. Berbagai varian tersedia, fresh setiap hari.">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root {
  --gd: #102416; /* Blackish Green */
  --gm: #1B3B25; /* Primary */
  --gl: #53725D; /* Secondary */
  --tertiary: #8BAA7C; /* Tertiary */
  --cream: #F5F5F0; /* Neutral */
  --dark: #0A140D; /* Near Black */
  --txt: #1B3B25; /* Primary Forest Text */
}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Outfit',sans-serif;background:var(--cream);padding-top:72px; animation: fadeIn 0.6s ease-in-out;}
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
/* NAVBAR */
.navbar-macha{background:rgba(255,255,255,.97);backdrop-filter:blur(16px);box-shadow:0 2px 20px rgba(45,90,39,.08);padding:13px 0;}
.navbar-brand{font-weight:900;font-size:1.5rem;color:var(--gd)!important;letter-spacing:-.5px;}
.nav-link{font-weight:600;color:var(--txt)!important;margin:0 4px;transition:.25s;position:relative;padding-bottom:4px!important;}
.nav-link::after{content:'';position:absolute;left:50%;right:50%;bottom:0;height:2.5px;background:var(--gm);border-radius:4px;transition:.25s;}
.nav-link:hover{color:var(--gm)!important;}
.nav-link:hover::after,.nav-link.active-nav::after{left:0;right:0;}
.nav-link.active-nav{color:var(--gm)!important;font-weight:700;}
.navbar-nav .nav-link.active{color:var(--txt)!important;}
.btn-hdr{background:var(--gm);color:#fff;border-radius:50px;padding:9px 20px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:.25s;border:2px solid var(--gm);}
.btn-hdr:hover{background:var(--gd);border-color:var(--gd);color:#fff;}
.btn-hdr-out{border:2px solid var(--gm);color:var(--gm);border-radius:50px;padding:9px 20px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:.25s;}
.btn-hdr-out:hover{background:var(--gm);color:#fff;}

/* PAGE BANNER */
.page-banner{background:linear-gradient(135deg,var(--gd) 0%,#0f3024 40%,var(--gm) 100%);padding:64px 0 56px;text-align:center;color:#fff;position:relative;overflow:hidden;}
.page-banner::before{content:'🍵';position:absolute;right:-20px;top:50%;transform:translateY(-50%);font-size:12rem;opacity:.05;}
.page-banner::after{content:'🌿';position:absolute;left:-20px;bottom:-20px;font-size:10rem;opacity:.04;}
.page-banner h1{font-size:clamp(1.8rem,4vw,2.8rem);font-weight:900;letter-spacing:-1px;}
.page-banner p{opacity:.8;margin-top:10px;font-size:1rem;}
.banner-chips{display:flex;justify-content:center;gap:10px;flex-wrap:wrap;margin-top:20px;}
.banner-chip{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:50px;padding:6px 16px;font-size:.8rem;font-weight:600;color:rgba(255,255,255,.9);backdrop-filter:blur(4px);}

/* SEARCH BAR */
.search-section{background:#fff;border-bottom:1px solid #edf1ed;padding:18px 0;position:sticky;top:72px;z-index:100;box-shadow:0 2px 12px rgba(0,0,0,.04);}
.search-wrap{position:relative;max-width:480px;}
.search-input{width:100%;border:2px solid #e0e8e0;border-radius:50px;padding:11px 48px 11px 20px;font-family:'Outfit',sans-serif;font-size:.95rem;outline:none;transition:.25s;background:#f9fbf9;}
.search-input:focus{border-color:var(--gm);background:#fff;box-shadow:0 0 0 3px rgba(64,145,108,.1);}
.search-icon{position:absolute;right:16px;top:50%;transform:translateY(-50%);color:#8aa898;pointer-events:none;}
.filter-chips{display:flex;gap:8px;flex-wrap:wrap;margin-top:12px;}
.filter-chip{border:2px solid #e0e8e0;background:#fff;color:#6b9080;border-radius:50px;padding:6px 16px;font-size:.82rem;font-weight:700;cursor:pointer;transition:.2s;display:inline-flex;align-items:center;gap:6px;}
.filter-chip:hover,.filter-chip.active{border-color:var(--gm);background:var(--gm);color:#fff;}
.sort-select{border:2px solid #e0e8e0;border-radius:50px;padding:8px 16px;font-family:'Outfit',sans-serif;font-size:.85rem;font-weight:600;color:var(--gd);outline:none;cursor:pointer;transition:.2s;}
.sort-select:focus{border-color:var(--gm);}

/* PRODUCT GRID */
.prod-card{background:#fff;border-radius:24px;overflow:hidden;transition:.35s;height:100%;box-shadow:0 4px 16px rgba(0,0,0,.05);display:flex;flex-direction:column;border:2px solid transparent;position:relative;}
.prod-card:hover{transform:translateY(-8px);box-shadow:0 20px 48px rgba(45,90,39,.14);border-color:rgba(64,145,108,.15);}
.prod-img-wrap{height:200px;overflow:hidden;position:relative;background:linear-gradient(135deg,#e8f5e9,#f0faf2);}
.prod-img-wrap img{width:100%;height:100%;object-fit:cover;transition:.5s;}
.prod-card:hover .prod-img-wrap img{transform:scale(1.08);}
.prod-img-emoji{width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:5rem;}
.prod-badge{position:absolute;top:12px;left:12px;font-size:.72rem;font-weight:700;padding:4px 12px;border-radius:50px;}
.badge-ada{background:rgba(64,145,108,.9);color:#fff;backdrop-filter:blur(4px);}
.badge-habis{background:rgba(220,38,38,.9);color:#fff;backdrop-filter:blur(4px);}
.badge-featured{position:absolute;top:12px;right:12px;font-size:.68rem;font-weight:800;padding:4px 10px;border-radius:50px;background:linear-gradient(135deg,#f59e0b,#fbbf24);color:#fff;}
.prod-body{padding:20px;flex:1;display:flex;flex-direction:column;}
.prod-cat{font-size:.7rem;text-transform:uppercase;letter-spacing:1.5px;color:#9ab0a0;font-weight:700;margin-bottom:4px;}
.prod-name{font-size:1rem;font-weight:800;color:var(--gd);margin-bottom:6px;line-height:1.3;}
.prod-price{font-size:1.15rem;font-weight:900;color:var(--gm);margin-bottom:8px;}
.prod-stock-wrap{margin-bottom:12px;}
.prod-stock-bar{height:3px;background:#edf1ed;border-radius:4px;margin-bottom:4px;}
.prod-stock-fill{height:3px;border-radius:4px;background:linear-gradient(90deg,var(--gm),var(--gl));transition:width 1.2s ease;}
.prod-stock-txt{font-size:.72rem;color:#8aa898;font-weight:600;}
.btn-cart{background:var(--gd);color:#fff;border-radius:50px;padding:10px 0;font-weight:700;width:100%;text-decoration:none;text-align:center;display:flex;justify-content:center;align-items:center;gap:8px;margin-top:auto;border:none;transition:.25s;position:relative;overflow:hidden;font-family:'Outfit',sans-serif;font-size:.9rem;}
.btn-cart::before{content:'';position:absolute;bottom:0;left:0;right:0;height:0;background:var(--gm);transition:.3s;z-index:0;border-radius:inherit;}
.btn-cart:hover::before{height:100%;}
.btn-cart span,.btn-cart i{position:relative;z-index:1;}
.btn-cart:hover{color:#fff;}
.btn-cart.is-loading {pointer-events:none; opacity:0.9;}
.btn-cart.is-loading .spinner-icon {display:inline-block !important;}
.btn-cart.is-loading .normal-icon {display:none !important;}
.btn-cart.is-loading .txt-loading {display:inline-block !important;}
.btn-cart.is-loading .txt-normal {display:none !important;}
.btn-cart-out{background:transparent;border:2px solid var(--gm);color:var(--gm);border-radius:50px;padding:10px 0;font-weight:700;width:100%;text-align:center;display:flex;justify-content:center;align-items:center;gap:8px;margin-top:auto;cursor:pointer;transition:.25s;font-family:'Outfit',sans-serif;font-size:.9rem;text-decoration:none;}
.btn-cart-out:hover{background:var(--gm);color:#fff;}
.btn-cart-dis{background:#f0f0f0;border:2px solid #e0e0e0;color:#bbb;border-radius:50px;padding:10px 0;font-weight:700;width:100%;text-align:center;display:flex;justify-content:center;align-items:center;gap:8px;margin-top:auto;cursor:not-allowed;font-size:.9rem;}

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

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-macha fixed-top">
<div class="container">
<a class="navbar-brand" href="<?= base_url() ?>"><i class="fa-solid fa-leaf me-2" style="color:var(--gm)"></i>MariMacha</a>
<button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
<i class="fa-solid fa-bars" style="color:var(--gd)"></i></button>
<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav mx-auto gap-1">
<li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Beranda</a></li>
<li class="nav-item"><a class="nav-link active-nav" href="<?= base_url('shop') ?>">Katalog</a></li>
<li class="nav-item"><a class="nav-link" href="<?= base_url() ?>#tentang">Tentang</a></li>
<li class="nav-item"><a class="nav-link" href="<?= base_url() ?>#cara-pesan">Cara Pesan</a></li>
</ul>
<div class="d-flex align-items-center gap-2">
<?php $cart=$this->session->userdata('cart')??[];$cc=count($cart);?>
<?php if($this->session->userdata('role') != 'admin'): ?>
<a href="<?= base_url('shop/cart') ?>" class="btn-hdr-out position-relative">
<i class="fa-solid fa-cart-shopping"></i>
<?php if($cc>0):?><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:.6rem"><?=$cc?></span><?php endif;?>
Keranjang</a>
<?php endif; ?>
<?php if($this->session->userdata('userid')):?>
<a href="<?= ($this->session->userdata('role')=='admin')?base_url('dashboard'):base_url('user') ?>" class="btn-hdr"><i class="fa-solid fa-user"></i>Akun</a>
<?php else:?>
<a href="<?= base_url('auth') ?>" class="btn-hdr">Login</a>
<?php endif;?>
</div></div></div></nav>

<!-- PAGE BANNER -->
<div class="page-banner">
<h1><i class="fa-solid fa-mug-hot me-2"></i>Katalog Menu</h1>
<p>Pilih minuman matcha favoritmu — fresh setiap hari, dibuat dengan cinta</p>
<div class="banner-chips">
<span class="banner-chip">🌿 <?= count($products ?? []) ?> Varian</span>
<span class="banner-chip">⭐ 4.9 Rating</span>
<span class="banner-chip">🔥 Best Seller Hari Ini</span>
</div>
</div>

<!-- SEARCH + FILTER -->
<div class="search-section">
<div class="container">
<div class="d-flex align-items-center gap-3 flex-wrap">
<div class="search-wrap flex-grow-1" style="max-width:380px;">
<input type="text" class="search-input" id="searchInput" placeholder="🔍 Cari menu matcha...">
<i class="fa-solid fa-magnifying-glass search-icon"></i>
</div>
<select class="sort-select" id="sortSelect">
<option value="default">Urutkan: Default</option>
<option value="price-asc">Harga: Murah dulu</option>
<option value="price-desc">Harga: Mahal dulu</option>
<option value="name-asc">Nama: A–Z</option>
<option value="stock-desc">Stok Terbanyak</option>
</select>
</div>
<?php
$cats=['Semua'];
if(!empty($products)){foreach($products as $p){if(!empty($p['category_name'])&&!in_array($p['category_name'],$cats))$cats[]=$p['category_name'];}}
?>
<div class="filter-chips mt-2">
<?php foreach($cats as $i=>$c):?>
<button class="filter-chip <?=$i===0?'active':''?>" data-cat="<?=$c?>"><?=$c?></button>
<?php endforeach;?>
</div>
</div>
</div>

<!-- PRODUCTS -->
<div class="container py-4">
<div class="result-info" id="resultInfo"><?= count($products??[]) ?> produk ditemukan</div>
<div class="row g-4" id="productGrid">
<?php
$emojis=['🍵','☕','🧋','🍃','🌿','🥤','🫖','🍶'];
if(!empty($products)):
foreach($products as $i=>$p):
$pct=min(100,max(8,($p['stock']/50)*100));
$is_f=!empty($p['is_featured'])&&$p['is_featured']==1;
?>
<div class="col-6 col-md-4 col-lg-3 prod-item"
     data-name="<?=strtolower(htmlspecialchars($p['name']))?>"
     data-cat="<?=htmlspecialchars($p['category_name']??'Matcha')?>"
     data-price="<?=$p['price']?>"
     data-stock="<?=$p['stock']?>">
<div class="prod-card" style="transition-delay:<?=$i*.05?>s">
<div class="prod-img-wrap">
<span class="prod-badge <?=$p['stock']>0?'badge-ada':'badge-habis'?>"><?=$p['stock']>0?'✓ Tersedia':'Habis'?></span>
<?php if($is_f):?><span class="badge-featured">⭐ Unggulan</span><?php endif;?>
<?php if(!empty($p['image'])&&$p['image']!='default.jpg'):?>
<img src="<?= base_url('uploads/'.$p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" loading="lazy"
     onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
<div class="prod-img-emoji" style="display:none"><?=$emojis[$i%count($emojis)]?></div>
<?php else:?>
<div class="prod-img-emoji"><?=$emojis[$i%count($emojis)]?></div>
<?php endif;?>
</div>
<div class="prod-body">
<div class="prod-cat"><?=htmlspecialchars($p['category_name']??'Matcha')?></div>
<div class="prod-name"><?=htmlspecialchars($p['name'])?></div>
<div class="prod-price">Rp <?=number_format($p['price'],0,',','.')?></div>
<div class="prod-stock-wrap">
<div class="prod-stock-bar"><div class="prod-stock-fill" style="width:0%" data-w="<?=$pct?>%"></div></div>
<div class="prod-stock-txt"><?=$p['stock']<=5&&$p['stock']>0?'⚠️ Sisa '.$p['stock'].' pcs':'Stok: '.$p['stock'].' pcs'?></div>
</div>
<?php if($p['stock']>0):?>
<div class="d-flex flex-column gap-2 mt-auto">
    <button type="button" class="btn-cart-out w-100" onclick="showDetail(<?= $p['id'] ?>)">
        <i class="fa-solid fa-eye"></i><span>Detail</span>
    </button>
    <?php if($this->session->userdata('userid')):?>
        <?php if($this->session->userdata('role') == 'admin'): ?>
            <div class="btn-cart-out w-100"><i class="fa-solid fa-lock"></i><span>Mode Kelola Menu</span></div>
        <?php else: ?>
            <a href="<?= base_url('shop/add_to_cart/'.$p['id']) ?>" class="btn-cart w-100" onclick="this.classList.add('is-loading');" style="height: 44px;">
                <i class="fa-solid fa-cart-plus normal-icon"></i>
                <i class="fa-solid fa-spinner fa-spin spinner-icon" style="display:none;"></i>
                <span class="txt-normal">Tambah</span>
                <span class="txt-loading" style="display:none;">Memproses...</span>
            </a>
        <?php endif; ?>
    <?php else:?>
    <a href="<?= base_url('auth') ?>" class="btn-cart-out w-100"><i class="fa-solid fa-lock"></i><span>Login untuk pesan</span></a>
    <?php endif;?>
</div>
<?php else:?>
<div class="btn-cart-dis"><i class="fa-solid fa-ban"></i><span>Stok Habis</span></div>
<?php endif;?>
</div>
</div>
</div>
<?php endforeach;
else:?>
<div class="col-12"><div class="empty-state"><span class="empty-icon">🍵</span><h4 style="color:var(--gd)">Belum ada produk</h4><p style="color:#8aa898">Admin sedang menyiapkan menu.</p></div></div>
<?php endif;?>
</div>
<div id="noResults"><span style="font-size:3rem;display:block;margin-bottom:12px">🔍</span>Tidak ada produk yang cocok</div>
</div>

<footer class="text-center"><p class="mb-0" style="font-size:.85rem;color:#8aa898">© <?=date('Y')?> <strong style="color:var(--gd)">MariMacha</strong>. Dibuat dengan ❤️</p></footer>

<!-- MODAL DETAIL PRODUK -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0" style="border-radius:28px; overflow:hidden;">
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-5">
                        <div id="modalImgWrap" style="height:100%; min-height:300px; background:#eef3eb; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                            <img id="modalImg" src="" style="width:100%; height:100%; object-fit:cover;">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="p-4 p-lg-5">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h3 id="modalName" class="fw-black mb-0" style="font-weight:900; color:var(--gd);">Produk</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="mb-3">
                                <span id="modalPrice" class="h4 fw-bold text-success">Rp 0</span>
                                <span class="ms-2 text-muted small" id="modalStock">Stok: 0</span>
                            </div>
                            
                            <!-- Average Rating Display -->
                            <div class="d-flex align-items-center mb-4 gap-2">
                                <div id="modalStars" class="text-warning"></div>
                                <span id="modalAvgText" class="fw-bold" style="font-size:.9rem; color:var(--gl);">0 (0 Penilaian)</span>
                            </div>

                            <h6 class="fw-bold small text-uppercase letter-spacing-1 mb-2" style="color:var(--gl);">Deskripsi</h6>
                            <p id="modalDesc" class="text-secondary small mb-4" style="line-height:1.6;">Deskripsi...</p>

                            <!-- Rating Action Section (Hanya untuk yang sudah login) -->
                            <?php if($this->session->userdata('userid')): ?>
                            <div class="rating-box p-3 rounded-4 mb-4" style="background:#f8faf8; border:1px solid #edf2ed;">
                                <h6 class="fw-bold small mb-2">Beri Penilaian Rasa</h6>
                                <div class="star-rating mb-2" id="starInput">
                                    <i class="fa-star fa-regular star-btn" data-rate="1"></i>
                                    <i class="fa-star fa-regular star-btn" data-rate="2"></i>
                                    <i class="fa-star fa-regular star-btn" data-rate="3"></i>
                                    <i class="fa-star fa-regular star-btn" data-rate="4"></i>
                                    <i class="fa-star fa-regular star-btn" data-rate="5"></i>
                                </div>
                                <input type="hidden" id="rateValue" value="0">
                                <textarea id="rateComment" class="form-control form-control-sm border-0 mb-2" rows="2" placeholder="Tulis komentar kamu..." style="background:#fff; border-radius:12px;"></textarea>
                                <button type="button" onclick="submitRating()" class="btn btn-sm btn-success rounded-pill px-3 fw-bold">Kirim Rating</button>
                            </div>
                            <?php else: ?>
                            <div class="rating-box p-3 rounded-4 mb-4 text-center" style="background:#fff7ed; border:1px solid #ffedd5;">
                                <p class="small text-secondary mb-2"><i class="fa-solid fa-lock me-1"></i> Suka dengan rasa produk ini? Login untuk memberikan penilaian.</p>
                                <a href="<?= base_url('auth') ?>" class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-bold">Login Sekarang</a>
                            </div>
                            <?php endif; ?>

                            <div class="d-grid">
                            <div id="modalOrderActions">
                                <?php if($this->session->userdata('role') == 'admin'): ?>
                                    <div class="btn-cart-dis py-3 text-center w-100" style="background:#eef3eb; color:#8aa898; cursor:default;">
                                        <i class="fa-solid fa-lock me-2"></i> Mode Kelola Menu
                                    </div>
                                <?php elseif($this->session->userdata('userid')): ?>
                                    <a id="modalCartLink" href="#" class="btn-cart py-3">
                                        <i class="fa-solid fa-cart-plus me-2"></i> Tambah ke Keranjang
                                    </a>
                                <?php else: ?>
                                    <a href="<?= base_url('auth') ?>" class="btn-cart-out py-3 text-center">
                                        <i class="fa-solid fa-lock me-2"></i> Login untuk memesan
                                    </a>
                                <?php endif; ?>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.star-btn { cursor:pointer; font-size:1.5rem; transition:.2s; color:#ccc; }
.star-btn.active, .star-btn:hover { color:#f59e0b; }
.star-btn.fa-solid { color:#f59e0b; }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// TOAST AUTO HIDE
var tw=document.getElementById('toastWrap');
if(tw)setTimeout(function(){tw.style.opacity='0';tw.style.transition='opacity .5s';setTimeout(function(){tw.remove();},600);},3500);

// CARD REVEAL (IntersectionObserver)
var ioCards=new IntersectionObserver(function(entries){
  entries.forEach(function(e){if(e.isIntersecting){e.target.querySelector('.prod-card').classList.add('visible');ioCards.unobserve(e.target);}});
},{threshold:.1});
document.querySelectorAll('.prod-item').forEach(function(el){ioCards.observe(el);});

// STOCK BARS
var ioBar=new IntersectionObserver(function(entries){
  entries.forEach(function(e){if(e.isIntersecting){e.target.querySelectorAll('.prod-stock-fill').forEach(function(b){b.style.width=b.dataset.w;});ioBar.unobserve(e.target);}});
},{threshold:.2});
document.querySelectorAll('.prod-item').forEach(function(el){ioBar.observe(el);});

// RIPPLE
document.querySelectorAll('.btn-cart,.btn-cart-out').forEach(function(btn){
  btn.addEventListener('click',function(e){
    var r=btn.getBoundingClientRect(),sz=Math.max(r.width,r.height);
    var rp=document.createElement('span');rp.className='ripple-c';
    rp.style.cssText='width:'+sz+'px;height:'+sz+'px;left:'+(e.clientX-r.left-sz/2)+'px;top:'+(e.clientY-r.top-sz/2)+'px;';
    btn.appendChild(rp);setTimeout(function(){rp.remove();},600);
  });
});

// SEARCH & FILTER
var items=document.querySelectorAll('.prod-item');
var ri=document.getElementById('resultInfo');
var ng=document.getElementById('noResults');
function filterProducts(){
  var q=document.getElementById('searchInput').value.toLowerCase().trim();
  var activeCat=document.querySelector('.filter-chip.active').dataset.cat;
  var sort=document.getElementById('sortSelect').value;
  var arr=Array.from(items);
  var vis=[];
  arr.forEach(function(el){
    var name=el.dataset.name;
    var cat=el.dataset.cat;
    var matchQ=!q||name.includes(q);
    var matchC=activeCat==='Semua'||cat===activeCat;
    el.style.display=(matchQ&&matchC)?'':'none';
    if(matchQ&&matchC)vis.push(el);
  });
  // Sort
  var grid=document.getElementById('productGrid');
  vis.sort(function(a,b){
    if(sort==='price-asc')return+a.dataset.price-+b.dataset.price;
    if(sort==='price-desc')return+b.dataset.price-+a.dataset.price;
    if(sort==='name-asc')return a.dataset.name.localeCompare(b.dataset.name);
    if(sort==='stock-desc')return+b.dataset.stock-+a.dataset.stock;
    return 0;
  });
  vis.forEach(function(el){grid.appendChild(el);});
  ri.textContent=vis.length+' produk ditemukan';
  ng.style.display=vis.length===0?'block':'none';
}
document.getElementById('searchInput').addEventListener('input',filterProducts);
document.getElementById('sortSelect').addEventListener('change',filterProducts);
document.querySelectorAll('.filter-chip').forEach(function(c){
  c.addEventListener('click',function(){
    document.querySelectorAll('.filter-chip').forEach(function(x){x.classList.remove('active');});
    c.classList.add('active');
    filterProducts();
  });
});

// DETAIL MODAL LOGIC
var pModal = new bootstrap.Modal(document.getElementById('productModal'));
function showDetail(id) {
    document.getElementById('modalImgWrap').innerHTML = '<div class="fa-3x"><i class="fa-solid fa-spinner fa-spin text-success"></i></div>';
    pModal.show();
    
    fetch('<?= base_url("shop/get_product_details/") ?>' + id)
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                let d = res.data;
                document.getElementById('modalName').textContent = d.name;
                document.getElementById('modalDesc').textContent = d.description;
                document.getElementById('modalPrice').textContent = 'Rp ' + d.price;
                document.getElementById('modalStock').textContent = 'Stok: ' + d.stock;
                document.getElementById('modalCartLink').href = '<?= base_url("shop/add_to_cart/") ?>' + d.id;
                
                // Show Image
                if(d.image !== 'default') {
                    document.getElementById('modalImgWrap').innerHTML = `<img src="${d.image}" style="width:100%; height:100%; object-fit:cover;">`;
                } else {
                    document.getElementById('modalImgWrap').innerHTML = `<div style="font-size:6rem">🍵</div>`;
                }

                // Show Average Rating
                let starsHtml = '';
                for(let i=1; i<=5; i++) {
                    starsHtml += `<i class="fa-star ${i <= Math.round(d.avg_rating) ? 'fa-solid' : 'fa-regular'}"></i>`;
                }
                document.getElementById('modalStars').innerHTML = starsHtml;
                document.getElementById('modalAvgText').textContent = `${d.avg_rating} (${d.total_rating} Penilaian)`;
                
                // Set Product ID for rating input
                document.getElementById('productModal').dataset.productId = d.id;
                // Reset Star Input
                document.querySelectorAll('.star-btn').forEach(s => s.classList.replace('fa-solid','fa-regular'));
                document.querySelectorAll('.star-btn').forEach(s => s.classList.remove('active'));
                document.getElementById('rateValue').value = 0;
                document.getElementById('rateComment').value = '';
            }
        });
}

// STAR INPUT LOGIC
document.querySelectorAll('.star-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        let rate = this.dataset.rate;
        document.getElementById('rateValue').value = rate;
        document.querySelectorAll('.star-btn').forEach(s => {
            if(s.dataset.rate <= rate) {
                s.classList.replace('fa-regular', 'fa-solid');
                s.classList.add('active');
            } else {
                s.classList.replace('fa-solid', 'fa-regular');
                s.classList.remove('active');
            }
        });
    });
});

function submitRating() {
    let pid = document.getElementById('productModal').dataset.productId;
    let rate = document.getElementById('rateValue').value;
    let comment = document.getElementById('rateComment').value;
    let name = "<?= htmlspecialchars($this->session->userdata('full_name') ?: 'Guest') ?>";

    if(rate == 0) { alert('Tolong pilih bintangnya dulu ya!'); return; }

    const formData = new FormData();
    formData.append('product_id', pid);
    formData.append('rating', rate);
    formData.append('comment', comment);
    formData.append('full_name', name);

    fetch('<?= base_url("shop/submit_rating") ?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        alert(res.message);
        if(res.status === 'success') {
            showDetail(pid); // Refresh details
        }
    });
}
</script>
</body>
</html>
