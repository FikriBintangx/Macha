<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja | MariMacha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root{--gd:#102416;--gm:#1B3B25;--gl:#53725D;--cream:#F5F5F0;}
        *{box-sizing:border-box;}
        body{font-family:'Outfit',sans-serif;background:var(--cream);padding-top:72px;}
        .navbar-macha{background:rgba(255,255,255,.97);backdrop-filter:blur(16px);box-shadow:0 2px 20px rgba(45,90,39,.08);padding:13px 0;}
        .navbar-brand{font-weight:900;font-size:1.5rem;color:var(--gd)!important;letter-spacing:-.5px;}
        .btn-ol{border:2px solid var(--gm);color:var(--gm);border-radius:50px;padding:8px 18px;font-weight:700;text-decoration:none;font-size:.9rem;transition:.25s;display:inline-flex;align-items:center;gap:6px;}
        .btn-ol:hover{background:var(--gm);color:#fff;}
        /* CART */
        .cart-section{background:#fff;border-radius:24px;box-shadow:0 6px 24px rgba(0,0,0,.05);overflow:hidden;}
        .cart-header{background:linear-gradient(135deg,var(--gd),#0f3024);color:#fff;padding:24px 28px;display:flex;align-items:center;justify-content:space-between;}
        .cart-header h4{font-weight:900;margin:0;display:flex;align-items:center;gap:10px;}
        .cart-badge{background:rgba(255,255,255,.2);border:1px solid rgba(255,255,255,.3);border-radius:50px;padding:3px 12px;font-size:.82rem;font-weight:700;}
        .cart-item{display:flex;align-items:center;gap:16px;padding:18px 24px;border-bottom:1px solid #f0f0f0;transition:.3s;position:relative;overflow:hidden;}
        .cart-item::before{content:'';position:absolute;left:0;top:0;bottom:0;width:3px;background:transparent;transition:.25s;}
        .cart-item:hover::before{background:var(--gm);}
        .cart-item:hover{background:#fafcf9;}
        .cart-item:last-child{border-bottom:none;}
        .cart-img{width:72px;height:72px;object-fit:cover;border-radius:16px;flex-shrink:0;background:#eef3eb;}
        .cart-emoji{width:72px;height:72px;border-radius:16px;flex-shrink:0;background:linear-gradient(135deg,#e8f5e9,#f0faf2);display:flex;align-items:center;justify-content:center;font-size:2.2rem;}
        .item-info{flex:1;min-width:0;}
        .item-name{font-weight:800;font-size:.98rem;color:var(--gd);margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
        .item-meta{font-size:.82rem;color:#8a9e8a;font-weight:600;}
        .item-subtotal{font-weight:900;font-size:1rem;color:var(--gm);white-space:nowrap;text-align:right;}
        .qty-ctrl{display:flex;align-items:center;gap:8px;margin-top:8px;}
        .qty-btn{width:28px;height:28px;border-radius:50%;border:2px solid var(--gm);background:transparent;color:var(--gm);font-weight:800;cursor:pointer;transition:.2s;display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:1rem;}
        .qty-btn:hover{background:var(--gm);color:#fff;}
        .qty-num{font-weight:800;font-size:1rem;min-width:24px;text-align:center;color:var(--gd);}
        .btn-delete{color:#e63946;text-decoration:none;padding:6px 10px;border-radius:10px;transition:.2s;display:inline-flex;align-items:center;gap:4px;font-size:.8rem;font-weight:700;border:1.5px solid transparent;}
        .btn-delete:hover{background:#fff5f5;border-color:#fecdd3;color:#e63946;}
        
        /* CUSTOMIZATION DRAWER */
        .item-drawer{height:0;opacity:0;overflow:hidden;transition:all 0.8s cubic-bezier(0.4, 0, 0.2, 1);background:#fafdfb;border-top:1px dashed transparent;margin:0 -24px;padding:0 24px;display:flex;flex-wrap:wrap;gap:8px;}
        .cart-item:hover .item-drawer{height:auto;opacity:1;padding-top:15px;padding-bottom:20px;border-top-color:#e0eedf;margin-top:12px;box-shadow:inset 0 4px 12px rgba(0,0,0,0.02);}
        .drawer-title{width:100%;font-size:.7rem;font-weight:800;color:var(--gl);text-transform:uppercase;letter-spacing:1px;margin-bottom:10px;display:flex;align-items:center;gap:6px;transition: transform 0.6s ease; transform: translateY(10px); }
        .cart-item:hover .drawer-title{ transform: translateY(0); }
        .opt-chip{background:#fff;border:1.5px solid #edf2ed;padding:6px 12px;border-radius:50px;font-size:0.75rem;font-weight:700;color:var(--gd);cursor:pointer;transition:.2s;display:flex;align-items:center;gap:6px;user-select:none;}
        .opt-chip:hover{border-color:var(--gm);background:#f0faf4;}
        .opt-chip.active{background:var(--gm);color:#fff;border-color:var(--gm);box-shadow:0 4px 10px rgba(27,77,62,.2);}
        .opt-chip i{font-size:.8rem;opacity:.8;}
        
        /* SUMMARY */
        .summary-card{background:linear-gradient(160deg,var(--gd),#0f3024);color:#fff;border-radius:24px;padding:28px;position:sticky;top:88px;}
        .summary-card h4{font-weight:900;margin-bottom:20px;font-size:1.1rem;}
        .summary-row{display:flex;justify-content:space-between;margin-bottom:10px;font-size:.9rem;color:rgba(255,255,255,.8);}
        .summary-total{display:flex;justify-content:space-between;font-size:1.2rem;font-weight:900;padding-top:16px;border-top:1px solid rgba(255,255,255,.15);margin-top:8px;color:var(--gl);}
        .btn-checkout{background:linear-gradient(135deg,#fff,#f0fdf4);color:var(--gd);border-radius:50px;padding:16px;font-weight:900;font-size:1rem;width:100%;text-align:center;text-decoration:none;display:flex;justify-content:center;align-items:center;gap:8px;margin-top:20px;transition:.3s;box-shadow:0 8px 24px rgba(0,0,0,.2);border:none;font-family:'Outfit',sans-serif;}
        .btn-checkout:hover{transform:translateY(-3px);box-shadow:0 14px 32px rgba(0,0,0,.25);color:var(--gd);}
        .btn-lanjut{background:rgba(255,255,255,.08);color:rgba(255,255,255,.8);border-radius:50px;padding:12px;font-size:.88rem;width:100%;text-align:center;text-decoration:none;display:flex;justify-content:center;align-items:center;gap:8px;margin-top:10px;transition:.25s;border:1px solid rgba(255,255,255,.15);font-family:'Outfit',sans-serif;}
        .btn-lanjut:hover{background:rgba(255,255,255,.15);color:#fff;}
        /* EMPTY */
        .empty-cart{padding:72px 24px;text-align:center;}
        .empty-icon-wrap{width:100px;height:100px;background:linear-gradient(135deg,#e8f5e9,#f0faf2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-size:3rem;animation:float-cart 3s ease-in-out infinite;}
        @keyframes float-cart{0%,100%{transform:translateY(0);}50%{transform:translateY(-10px);}}
        .btn-mulai{background:linear-gradient(135deg,var(--gm),var(--gl));color:#fff;border-radius:50px;padding:14px 36px;font-weight:800;text-decoration:none;display:inline-flex;align-items:center;gap:8px;margin-top:20px;transition:.3s;box-shadow:0 8px 24px rgba(64,145,108,.35);}
        .btn-mulai:hover{transform:translateY(-3px);color:#fff;}
        /* ITEM IN FLASH */
        .cart-item.removing{opacity:0;transform:translateX(60px);pointer-events:none;}
        .flash-msg{border-radius:14px;padding:14px 18px;border:none;border-left:4px solid var(--gm);background:#f0faf4;color:#2d6a4f;font-weight:600;margin-bottom:20px;display:flex;align-items:center;gap:10px;}
        .flash-msg.err{border-left-color:#e63946;background:#fff5f5;color:#9b1c1c;}
        /* OVERLAY */
        .page-overlay{position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(255,255,255,.8);backdrop-filter:blur(4px);z-index:9999;display:none;align-items:center;justify-content:center;flex-direction:column;}
        .page-overlay.show{display:flex;animation:fadeOverlay .3s ease;}
        @keyframes fadeOverlay{from{opacity:0;}to{opacity:1;}}
        .spinner-macha{width:50px;height:50px;border:4px solid var(--cream);border-top:4px solid var(--gm);border-radius:50%;animation:spin 1s linear infinite;margin-bottom:16px;}
        @keyframes spin{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}

        /* --- RESPONSIVE FIXES --- */
        @media (max-width: 768px) {
            body{padding-top: 60px;}
            .navbar-macha{padding: 8px 0;}
            .btn-ol{padding: 6px 12px; font-size: 0.8rem;}
            .btn-ol span{display:none;} /* Hilangkan teks "Lanjut Belanja" jika terlalu sempit */

            .cart-header{padding: 16px 20px;}
            .cart-header h4{font-size: 1.1rem;}
            
            .cart-item{padding: 15px; flex-direction: column; align-items: flex-start;}
            .cart-item-main{flex-direction: row !important; align-items: flex-start !important; width: 100%;}
            .cart-img{width: 80px; height: 80px; border-radius: 12px;}
            
            .item-info{padding-right: 0;}
            .item-name{font-size: 0.9rem; white-space: normal; -webkit-line-clamp: 2; display: -webkit-box; -webkit-box-orient: vertical;}
            .item-subtotal{text-align: left; margin-top: 10px; font-size: 0.95rem; display: block;}
            
            .item-drawer{
                height: auto; 
                opacity: 1; 
                margin: 10px 0 0 0; 
                padding: 15px; 
                border-radius: 15px;
                border-top: 1px solid #eee;
                display: flex;
            }
            .opt-chip{padding: 5px 10px; font-size: 0.7rem;}
            
            .summary-card{margin-top: 20px; position: static; padding: 20px;}
        }

        @media (max-width: 480px) {
            .cart-img{width: 65px; height: 65px;}
            .qty-num{min-width: 20px; font-size: 0.9rem;}
            .qty-btn{width: 24px; height: 24px; font-size: 0.8rem;}
            .btn-checkout{padding: 14px; font-size: 0.95rem;}
        }
    </style>
</head>
<body>
    <div class="page-overlay" id="pageOverlay">
        <div class="spinner-macha"></div>
        <div style="color:var(--gd);font-weight:700;">Memperbarui...</div>
    </div>

    <nav class="navbar navbar-macha fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= base_url() ?>">
                <?php if(!empty($shop_logo)): ?>
                    <img src="<?= base_url('uploads/'.$shop_logo) ?>" alt="Logo" style="height: 30px; width: auto; object-fit: contain; margin-right: 8px;">
                <?php else: ?>
                    <i class="fa-solid fa-leaf me-2" style="color:var(--gm)"></i>
                <?php endif; ?>
                <span>MariMacha</span>
                
                <?php if(isset($shop_status)): ?>
                    <div style="display: inline-flex; align-items: center; gap: 6px; padding: 3px 12px; background: #fff; border: 2px solid var(--gm); color: #000; border-radius: 50px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-left:10px;">
                        <div style="width: 7px; height: 7px; border-radius: 50%; background: <?= $shop_status == 'open' ? '#25D366' : '#e63946' ?>; box-shadow: 0 0 8px <?= $shop_status == 'open' ? '#25D366' : '#e63946' ?>;"></div>
                        <?= $shop_status == 'open' ? 'Buka' : 'Tutup' ?>
                    </div>
                <?php endif; ?>
            </a>
            <a href="<?= base_url('shop') ?>" class="btn-ol"><i class="fa-solid fa-arrow-left"></i><span>Lanjut Belanja</span></a>
        </div>
    </nav>

    <div class="container mb-5">
        <!-- Flash messages -->
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert" style="background:#fde8e8;border:none;border-left:4px solid #e53e3e;border-radius:12px;color:#9b1c1c;margin-bottom:20px">
                <i class="fa-solid fa-triangle-exclamation me-2"></i><?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="cart-section">
                <div class="cart-header">
                        <h4><i class="fa-solid fa-cart-shopping"></i>Keranjang
                            <?php if(!empty($cart)):?>
                            <span class="cart-badge"><?= count($cart) ?> item</span>
                            <?php endif;?>
                        </h4>
                        <?php if(!empty($cart)):?>
                        <span style="opacity:.65;font-size:.82rem">Total: Rp <?= number_format($total,0,',','.') ?></span>
                        <?php endif;?>
                    </div>

                    <?php if(!empty($cart)): ?>
                        <?php foreach($cart as $id => $item): ?>
                        <div class="cart-item" data-id="<?= $id ?>">
                            <?php $img = !empty($item['image']) ? base_url('uploads/'.$item['image']) : 'https://images.unsplash.com/photo-1563822249548-9a72b6353cd1?q=80&w=200&auto=format&fit=crop'; ?>
                            <div class="d-flex align-items-center w-100 gap-3 cart-item-main">
                                <img src="<?= $img ?>" class="cart-img" alt="<?= htmlspecialchars($item['name']) ?>"
                                     onerror="this.src='https://images.unsplash.com/photo-1563822249548-9a72b6353cd1?q=80&w=200&auto=format&fit=crop'">
                                <div class="item-info">
                                    <div class="item-name"><?= htmlspecialchars($item['name']) ?></div>
                                    <div class="item-meta">Rp <?= number_format($item['price'],0,',','.') ?> / pcs</div>
                                    <!-- Display Preferences -->
                                    <div id="pref-<?= $id ?>" class="mt-1" style="font-size:0.75rem; color:var(--gl); font-weight:700;">
                                        <?= !empty($item['preferences']) ? '<i class="fa-solid fa-check-double me-1"></i>' . $item['preferences'] : '' ?>
                                    </div>
                                    <div class="qty-ctrl">
                                        <?php if($item['qty'] > 1): ?>
                                        <a href="<?= base_url('shop/decrease_cart/'.$id) ?>" class="qty-btn" title="Kurangi">−</a>
                                        <?php else: ?>
                                        <span class="qty-btn" style="opacity:0.4; pointer-events:none; cursor:not-allowed;">−</span>
                                        <?php endif; ?>
                                        <span class="qty-num"><?= $item['qty'] ?></span>
                                        <a href="<?= base_url('shop/increase_cart/'.$id) ?>" class="qty-btn" title="Tambah">+</a>
                                    </div>
                                </div>
                                <div>
                                    <div class="item-subtotal">Rp <?= number_format($item['subtotal'],0,',','.') ?></div>
                                    <div class="text-end mt-2">
                                        <a href="<?= base_url('shop/remove_cart/'.$id) ?>" class="btn-delete" title="Hapus"
                                           onclick="return confirm('Hapus <?= htmlspecialchars($item['name']) ?> dari keranjang?')">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Customization Drawer (Hover) -->
                            <div class="item-drawer">
                                <div class="drawer-title"><i class="fa-solid fa-wand-magic-sparkles"></i> Kustomisasi Minuman</div>
                                <?php 
                                $prefs = isset($item['preferences']) ? explode(', ', $item['preferences']) : [];
                                $options = [
                                    ['Less Ice', 'snowflake'], ['Extra Ice', 'cube'], ['No Ice', 'ban'],
                                    ['Less Sugar', 'cubes-stacked'], ['Extra Sugar', 'plus'], ['No Sugar', 'droplet-slash'],
                                    ['Extra Creamy', 'cloud'], ['Less Creamy', 'water'], ['Hot Only', 'mug-hot'], ['Pisah Es', 'box-open']
                                ];
                                foreach($options as $opt): 
                                    $isActive = in_array($opt[0], $prefs);
                                ?>
                                    <div class="opt-chip <?= $isActive ? 'active' : '' ?>" onclick="toggleOpt(this, '<?= $opt[0] ?>', '<?= $id ?>')">
                                        <i class="fa-solid fa-<?= $opt[1] ?>"></i> <?= $opt[0] ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-cart">
                            <div class="empty-icon-wrap" style="width: 140px; height: 140px; background: transparent; animation: float-cart 4s ease-in-out infinite;">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="url(#cartGrad)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="width:100%; height:100%;">
        <defs>
            <linearGradient id="cartGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="var(--gm)" />
                <stop offset="100%" stop-color="var(--gl)" />
            </linearGradient>
        </defs>
        <circle cx="9" cy="21" r="1"></circle>
        <circle cx="20" cy="21" r="1"></circle>
        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
    </svg>
</div>
                            <h4 style="color:var(--gd);font-weight:800;margin-bottom:8px">Keranjang Masih Kosong</h4>
                            <p style="color:#8aa898;font-size:.95rem">Yuk mulai pilih minuman matcha favoritmu!</p>
                            <a href="<?= base_url('shop') ?>" class="btn-mulai">
                                <i class="fa-solid fa-bag-shopping"></i>Mulai Belanja
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Summary -->
            <div class="col-lg-4">
                <div class="summary-card">
                    <h4><i class="fa-solid fa-receipt me-2"></i>Ringkasan</h4>
                    <?php if(!empty($cart)): ?>
                        <?php foreach($cart as $id => $item): ?>
                        <div class="summary-row" id="summary-row-<?= $id ?>">
                            <div class="d-flex flex-column" style="flex:1;">
                                <span class="fw-bold"><?= htmlspecialchars($item['name']) ?> x<?= $item['qty'] ?></span>
                                <span id="summary-pref-<?= $id ?>" class="small text-white opacity-75" style="font-size:0.7rem; line-height:1.2;">
                                    <?php 
                                    if(!empty($item['preferences'])) {
                                        $p_list = explode(', ', $item['preferences']);
                                        $iconMap = [
                                            'Less Ice' => 'snowflake', 'Extra Ice' => 'cube', 'No Ice' => 'ban',
                                            'Less Sugar' => 'cubes-stacked', 'Extra Sugar' => 'plus', 'No Sugar' => 'droplet-slash',
                                            'Extra Creamy' => 'cloud', 'Less Creamy' => 'water', 'Hot Only' => 'mug-hot', 'Pisah Es' => 'box-open'
                                        ];
                                        foreach($p_list as $pl) {
                                            $icon = $iconMap[$pl] ?? 'check';
                                            echo '<i class="fa-solid fa-'.$icon.' me-1"></i>'.$pl.' ';
                                        }
                                    }
                                    ?>
                                </span>
                            </div>
                            <span class="text-end fw-bold text-white-50">Rp <?= number_format($item['subtotal'],0,',','.') ?></span>
                        </div>
                        <?php endforeach; ?>
                        <div class="summary-total">
                            <span>Total Bayar</span>
                            <span>Rp <?= number_format($total,0,',','.') ?></span>
                        </div>
                        <a href="<?= base_url('shop/checkout') ?>" class="btn-checkout" onclick="this.innerHTML='<i class=\'fa-solid fa-spinner fa-spin\'></i> Memproses...'; this.style.pointerEvents='none';">
                                <i class="fa-solid fa-lock"></i>Lanjut Checkout
                            </a>
                    <?php else: ?>
                        <div class="summary-total"><span>Total</span><span>Rp 0</span></div>
                        <button class="btn-checkout" disabled style="opacity:.5;cursor:not-allowed;">Keranjang Kosong</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- RECOMMENDED / MORE PRODUCTS GRID -->
    <div class="container mb-5 pb-4">
        <hr style="border-color: #d1ddd4; margin: 40px 0;">
        <h4 style="font-weight:800; color:var(--gd); margin-bottom:24px;">
            <i class="fa-solid fa-mug-hot text-success me-2"></i>Tambah Pesanan Lainnya
        </h4>
        <div class="row g-4">
            <?php 
            $emojis=['🍵','☕','🧋','🍃','🌿','🥤'];
            if(!empty($products)):
                foreach($products as $i => $p): 
                    // Cek jika produk sudah ada di keranjang, mungkin kasih tulisan atau skip? 
                    // Kita tampilkan saja semua, jadi user gampang nambah kuantitas.
            ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div style="background:#fff; border-radius:20px; box-shadow:0 6px 20px rgba(0,0,0,0.04); padding:16px; height:100%; display:flex; flex-direction:column; transition:transform 0.3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                    
                    <div style="background:#eef3eb; border-radius:14px; height:140px; display:flex; align-items:center; justify-content:center; margin-bottom:16px; overflow:hidden;">
                        <?php if(!empty($p['image']) && $p['image'] != 'default.jpg'): ?>
                            <img src="<?= base_url('uploads/'.$p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" style="width:100%; height:100%; object-fit:cover;">
                        <?php else: ?>
                            <div style="font-size:3.5rem;"><?= $emojis[$i % count($emojis)] ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div style="font-size:0.75rem; color:#8aa898; font-weight:600; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px;"><?= htmlspecialchars($p['category_name']??'Matcha') ?></div>
                    <div style="font-size:1.05rem; font-weight:800; color:var(--gd); margin-bottom:12px; line-height:1.3; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;"><?= htmlspecialchars($p['name']) ?></div>
                    
                    <div style="margin-top:auto; display:flex; align-items:center; justify-content:space-between;">
                        <span style="font-weight:800; color:var(--gm);">Rp <?= number_format($p['price'],0,',','.') ?></span>
                        
                        <?php if($p['stock'] > 0): ?>
                            <a href="<?= base_url('shop/add_to_cart/'.$p['id']) ?>" 
                               class="btn btn-sm" 
                               style="background:var(--gm); color:#fff; border-radius:10px; padding:6px 12px; font-weight:700;"
                               onclick="document.getElementById('pageOverlay').classList.add('show');">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                        <?php else: ?>
                            <span class="badge bg-secondary rounded-pill">Habis</span>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.qty-btn').forEach(function(btn){
            btn.addEventListener('click', function(e){
                if(this.style.pointerEvents !== 'none'){
                    document.getElementById('pageOverlay').classList.add('show');
                }
            });
        });
        // Toggle Option functionality with AJAX
        function toggleOpt(el, text, itemId) {
            el.classList.toggle('active');
            
            const formData = new FormData();
            formData.append('id', itemId);
            formData.append('preference', text);
            
            fetch('<?= base_url("shop/update_item_preference") ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    // Update main list
                    const prefDisplay = document.getElementById('pref-' + itemId);
                    prefDisplay.innerHTML = data.preferences ? '<i class="fa-solid fa-check-double me-1"></i>' + data.preferences : '';
                    
                    // Update Summary Card with icons
                    const summaryPref = document.getElementById('summary-pref-' + itemId);
                    if(summaryPref) {
                        if(!data.preferences) {
                            summaryPref.innerHTML = '';
                        } else {
                            const iconMap = {
                                'Less Ice': 'snowflake', 'Extra Ice': 'cube', 'No Ice': 'ban',
                                'Less Sugar': 'cubes-stacked', 'Extra Sugar': 'plus', 'No Sugar': 'droplet-slash',
                                'Extra Creamy': 'cloud', 'Less Creamy': 'water', 'Hot Only': 'mug-hot', 'Pisah Es': 'box-open'
                            };
                            const prefs = data.preferences.split(', ');
                            let html = '';
                            prefs.forEach(p => {
                                const icon = iconMap[p] || 'check';
                                html += `<i class="fa-solid fa-${icon} me-1"></i>${p} `;
                            });
                            summaryPref.innerHTML = html;
                        }
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
