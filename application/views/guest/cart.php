<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja | MariMatcha</title>
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
            padding-top: 100px;
        }

        /* ─── NAVBAR REFINED (Identical to Shop) ─── */
        .navbar-macha {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
            padding: 12px 0;
        }
        .navbar-brand { font-weight: 900; font-size: 1.6rem; color: var(--green-dark) !important; letter-spacing: -1px; }
        
        .shop-status-pill {
            display: inline-flex;
            align-items: center; gap: 6px; padding: 4px 12px; background: var(--white);
            border: 2px solid var(--green-main); color: var(--green-dark) !important;
            border-radius: 50px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; margin-left: 15px;
        }
        .status-dot { width: 8px; height: 8px; border-radius: 50%; }
        .status-dot.open { background: #25D366; box-shadow: 0 0 10px #25D366; }
        .status-dot.closed { background: #e63946; }
        
        .btn-nav-premium {
            background: var(--white); color: var(--green-main) !important;
            border: 1.5px solid var(--green-main); padding: 8px 18px; border-radius: 50px;
            font-weight: 700; font-size: 0.85rem; display: flex; align-items: center; gap: 8px; transition: var(--transition); text-decoration: none !important;
        }
        .btn-nav-premium:hover { background: var(--green-main); color: var(--white) !important; }

        /* ─── CART WRAPPER ─── */
        .cart-container { padding-bottom: 100px; }
        .section-title { font-weight: 950; font-size: clamp(1.5rem, 4vw, 2.2rem); color: var(--green-dark); margin-bottom: 30px; letter-spacing: -1px; }
        .section-title i { color: var(--tertiary); margin-right: 12px; }

        /* ─── ITEM LIST ─── */
        .cart-card {
            background: var(--white);
            border-radius: 32px;
            padding: 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.01);
            margin-bottom: 16px;
            transition: var(--transition);
            position: relative;
            will-change: transform, opacity;
        }
        .cart-card:hover { transform: scale(1.005); box-shadow: 0 20px 60px rgba(0,0,0,0.06); }
        
        .item-row { display: flex; align-items: center; gap: 20px; }
        .item-img {
            width: 110px; height: 110px; border-radius: 24px;
            object-fit: cover; background: #f8fcf9;
        }
        .item-info { flex: 1; }
        .item-name { font-weight: 900; font-size: 1.2rem; color: var(--green-dark); margin-bottom: 4px; }
        .item-price { font-weight: 700; color: var(--tertiary); font-size: 0.9rem; }
        
        .qty-control {
            display: flex; align-items: center; gap: 14px; margin-top: 15px;
            background: #f8fcf9; padding: 6px; border-radius: 50px; width: fit-content;
        }
        .qty-btn {
            width: 34px; height: 34px; border-radius: 50%; border: none;
            background: var(--white); color: var(--green-main); font-weight: 900;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06); transition: var(--transition);
            text-decoration: none !important;
        }
        .qty-btn:hover { background: var(--green-main); color: var(--white); transform: scale(1.1); }
        .qty-val { font-weight: 950; font-size: 1rem; min-width: 25px; text-align: center; }

        .btn-remove {
            position: absolute; top: 24px; right: 24px;
            background: #fff5f5; color: #e63946; border: none;
            width: 40px; height: 40px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            transition: var(--transition); text-decoration: none !important;
        }
        .btn-remove:hover { background: #e63946; color: var(--white); transform: rotate(10deg); }

        /* ─── CUSTOMIZATION DRAWER ─── */
        .pref-wrap { margin-top: 20px; display: flex; flex-wrap: wrap; gap: 8px; border-top: 1px dashed #edf2ed; padding-top: 15px; }
        .pref-pill {
            background: #f8fcf9; padding: 8px 16px; border-radius: 50px;
            font-size: 0.75rem; font-weight: 800; color: var(--green-light);
            cursor: pointer; transition: var(--transition); border: 1.5px solid transparent;
        }
        .pref-pill:hover { border-color: var(--tertiary); background: var(--white); }
        .pref-pill.active { background: var(--green-main); color: var(--white); border-color: var(--green-main); box-shadow: 0 6px 15px rgba(27, 59, 37, 0.2); }

        /* ─── SUMMARY SIDEBAR ─── */
        .summary-glass {
            background: var(--green-dark);
            color: var(--white);
            border-radius: 40px;
            padding: 40px;
            position: sticky;
            top: 120px;
            box-shadow: 0 40px 80px rgba(16, 36, 22, 0.25);
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.05);
        }
        .summary-glass::after {
            content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.03) 0%, transparent 70%);
            pointer-events: none;
        }
        .summary-glass h4 { font-weight: 900; font-size: 1.5rem; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }
        .summary-item { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 0.95rem; opacity: 0.7; }
        .summary-total {
            display: flex; justify-content: space-between; align-items: center;
            margin-top: 30px; padding-top: 25px; border-top: 2px dashed rgba(255,255,255,0.15);
        }
        .summary-total span:first-child { font-weight: 700; font-size: 1.1rem; opacity: 0.9; }
        .summary-total .price { font-weight: 950; font-size: 1.8rem; color: var(--tertiary); letter-spacing: -1px; }

        .btn-checkout-premium {
            background: var(--white); color: var(--green-dark);
            border: none; border-radius: 22px; padding: 20px; width: 100%;
            font-weight: 900; font-size: 1.1rem; margin-top: 35px;
            display: flex; align-items: center; justify-content: center; gap: 12px;
            transition: var(--transition); text-decoration: none !important;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .btn-checkout-premium:hover { background: var(--tertiary); color: var(--white); transform: translateY(-8px); box-shadow: 0 20px 45px rgba(0,0,0,0.15); }

        /* ─── RECOMMENDATIONS ─── */
        .reco-card-premium {
            background: var(--white);
            border-radius: 20px;
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 16px;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }
        .reco-card-premium:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(16, 36, 22, 0.08);
            border-color: #d1e5d1;
        }
        .reco-img-mini {
            width: 75px; height: 75px;
            border-radius: 16px;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            flex-shrink: 0;
            background: #f8fcf9;
        }
        .reco-info {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .reco-name-premium {
            font-weight: 800;
            color: var(--green-dark);
            font-size: 0.95rem;
            margin-bottom: 4px;
            line-height: 1.2;
        }
        .reco-price-premium {
            font-weight: 900;
            color: var(--green-soft);
            font-size: 0.9rem;
        }
        .btn-add-ajax {
            width: 36px; height: 36px;
            border-radius: 12px;
            background: var(--cream);
            color: var(--green-main);
            border: none;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.3s ease;
        }
        .btn-add-ajax:hover {
            background: var(--green-main);
            color: var(--white);
            transform: scale(1.1);
        }

        /* ─── UTILS ─── */
        .invisible-init { opacity: 0; transform: translateY(30px); }
        .page-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255,255,255,0.85); backdrop-filter: blur(12px);
            z-index: 2500; display: none; align-items: center; justify-content: center;
        }
        .page-overlay.show { display: flex; }

        @media (max-width: 768px) {
            .summary-glass { margin-top: 30px; position: static; padding: 30px; }
        }

        /* ─── iOS FLOATING BAR (GUEST) ─── */
        .ios-navbar-guest {
            position: fixed;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 8px 15px;
            border-radius: 50px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
            z-index: 9000;
            border: 1px solid rgba(255,255,255,0.2);
            width: max-content;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .ios-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none !important;
            color: #6b8e7b;
            padding: 8px 12px;
            border-radius: 20px;
            transition: all 0.3s ease;
            min-width: 60px;
        }

        .ios-nav-item i { font-size: 1.2rem; margin-bottom: 4px; transition: 0.3s; }
        .ios-nav-item span { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.8; }
        
        .ios-nav-item:hover, .ios-nav-item.active { color: var(--green-dark); background: rgba(27, 59, 37, 0.05); }
        .ios-nav-item.active i { transform: translateY(-2px); color: var(--green-main); }
        .ios-nav-item.active span { opacity: 1; color: var(--green-main); }

        @media (min-width: 992px) {
            .ios-navbar-guest { display: none; }
        }
    </style>
</head>
<body>
    <div class="page-overlay" id="pageOverlay">
        <div class="text-center">
            <div class="spinner-grow text-success mb-3" style="width: 3rem; height: 3rem;" role="status"></div>
            <div class="fw-black text-success">HARAP TUNGGU...</div>
        </div>
    </div>

    <!-- NAVBAR (Fixed Spacing & Spacing Bug Fix) -->
    <?php $this->load->view('layout/navbar'); ?>

    <div class="container cart-container">
        <!-- Flash Messages -->
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger border-0 rounded-4 mb-4 fw-bold shadow-sm"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- CART ITEMS LEFT -->
            <div class="col-lg-8">
                <h1 class="section-title"><i class="fa-solid fa-cart-arrow-down"></i>Tas Belanja</h1>
                
                <?php if(!empty($cart)): ?>
                    <?php foreach($cart as $id => $item): ?>
                    <div class="cart-card invisible-init">
                        <a href="<?= base_url('shop/remove_cart/'.$id) ?>" class="btn-remove" onclick="return confirm('Hapus item dari keranjang?')">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>
                        <div class="item-row">
                            <img src="<?= !empty($item['image']) ? base_url('uploads/'.$item['image']) : 'https://images.unsplash.com/photo-1563822249548-9a72b6353cd1?q=80&w=200&auto=format&fit=crop' ?>" 
                                 class="item-img" alt="Product" onerror="this.src='https://images.unsplash.com/photo-1563822249548-9a72b6353cd1?q=80&w=200&auto=format&fit=crop'">
                            <div class="item-info">
                                <div class="item-name"><?= htmlspecialchars($item['name']) ?></div>
                                <div class="item-price">Rp <?= number_format($item['price'],0,',','.') ?> / item</div>
                                
                                <div id="pref-display-<?= $id ?>" class="mt-2 text-success fw-bold" style="font-size: 0.75rem;">
                                    <?= !empty($item['preferences']) ? '<i class="fa-solid fa-sparkles me-1"></i>' . $item['preferences'] : '' ?>
                                </div>

                                <div class="qty-control">
                                    <a href="<?= base_url('shop/decrease_cart/'.$id) ?>" class="qty-btn" onclick="document.getElementById('pageOverlay').classList.add('show')"><i class="fa-solid fa-minus"></i></a>
                                    <span class="qty-val"><?= $item['qty'] ?></span>
                                    <a href="<?= base_url('shop/increase_cart/'.$id) ?>" class="qty-btn" onclick="document.getElementById('pageOverlay').classList.add('show')"><i class="fa-solid fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="text-end d-none d-md-block">
                                <div class="fw-black" style="font-size: 1.4rem; color: var(--green-main); letter-spacing: -0.5px;">Rp <?= number_format($item['subtotal'],0,',','.') ?></div>
                            </div>
                        </div>

                        <!-- Preferences Selection -->
                        <div class="pref-wrap">
                            <?php 
                            $curr_prefs = isset($item['preferences']) ? explode(', ', $item['preferences']) : [];
                            $opts = [
                                ['Less Ice', 'snowflake'], ['Extra Ice', 'cube'], ['No Ice', 'ban'],
                                ['Less Sugar', 'cubes-stacked'], ['Extra Sugar', 'plus'], ['No Sugar', 'droplet-slash'],
                                ['Extra Creamy', 'cloud'], ['Less Creamy', 'water'], ['Hot Only', 'mug-hot'], ['Pisah Es', 'box-open']
                            ];
                            foreach($opts as $o): 
                                $active = in_array($o[0], $curr_prefs);
                            ?>
                                <div class="pref-pill <?= $active ? 'active' : '' ?>" onclick="togglePref(this, '<?= $o[0] ?>', '<?= $id ?>')">
                                    <i class="fa-solid fa-<?= $o[1] ?> me-1"></i> <?= $o[0] ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div style="font-size: 6rem; opacity: 0.2;">🍃</div>
                        <h4 class="fw-black mt-3">Keranjangmu Sedang Beristirahat</h4>
                        <p class="text-muted">Isi dengan matcha favoritmu untuk memulai hari yang segar!</p>
                        <a href="<?= base_url('shop') ?>" class="btn-nav-premium px-5 py-3 mt-3 d-inline-flex">Buka Katalog</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- SUMMARY RIGHT SIDE -->
            <div class="col-lg-4">
                <div class="summary-glass">
                    <h4><i class="fa-solid fa-receipt opacity-50"></i> Ringkasan</h4>
                    <?php if(!empty($cart)): ?>
                        <?php foreach($cart as $id => $item): ?>
                        <div class="summary-item">
                            <span><?= htmlspecialchars($item['name']) ?> (x<?= $item['qty'] ?>)</span>
                            <span class="fw-bold">Rp <?= number_format($item['subtotal'],0,',','.') ?></span>
                        </div>
                        <?php endforeach; ?>
                        
                        <div class="summary-total">
                            <span>Total Estimasi</span>
                            <span class="price">Rp <?= number_format($total,0,',','.') ?></span>
                        </div>
                        
                        <a href="<?= base_url('shop/checkout') ?>" class="btn-checkout-premium" id="btnCheckout">
                            <i class="fa-solid fa-lock-keyhole"></i> Pembayaran Aman
                        </a>
                        <p class="text-center mt-3 opacity-50 small mb-0"><i class="fa-solid fa-shield-halved me-1"></i> Pembayaran Terenkripsi & Aman</p>
                    <?php else: ?>
                        <div class="text-center py-4 opacity-50">Belum ada item untuk diringkas.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- RECOMMENDATIONS SECTION -->
        <?php if(!empty($products)): ?>
        <div class="mt-5 pt-5">
            <h4 class="fw-black mb-4" style="color: var(--green-dark);"><i class="fa-solid fa-wand-magic-sparkles text-success me-2"></i>Tambah Pesanan Lainnya</h4>
            <div class="row g-3 g-md-4">
                <?php foreach(array_slice($products, 0, 4) as $p): ?>
                <div class="col-12 col-md-6 invisible-init">
                    <div class="reco-card-premium">
                        <img src="<?= !empty($p['image']) && $p['image'] != 'default.jpg' ? base_url('uploads/'.$p['image']) : 'https://images.unsplash.com/photo-1563822249548-9a72b6353cd1?q=80&w=200&auto=format&fit=crop' ?>" 
                             class="reco-img-mini" alt="Reco" onerror="this.src='https://images.unsplash.com/photo-1563822249548-9a72b6353cd1?q=80&w=200&auto=format&fit=crop'">
                        
                        <div class="reco-info">
                            <div class="reco-name-premium"><?= htmlspecialchars($p['name']) ?></div>
                            <div class="reco-price-premium">Rp <?= number_format($p['price'],0,',','.') ?></div>
                        </div>

                        <button type="button" class="btn-add-ajax" onclick="window.addToCartAjax(<?= $p['id'] ?>, this)">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            gsap.registerPlugin(ScrollTrigger);
            
            // Entrance Animations
            gsap.to(".invisible-init", {
                opacity: 1, y: 0, duration: 1, stagger: 0.15, ease: "power4.out"
            });

            // Toggle Preference AJAX
            window.togglePref = function(el, pref, itemId) {
                el.classList.toggle('active');
                
                const formData = new FormData();
                formData.append('id', itemId);
                formData.append('preference', pref);
                
                fetch('<?= base_url("shop/update_item_preference") ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        const display = document.getElementById('pref-display-' + itemId);
                        display.innerHTML = data.preferences ? '<i class="fa-solid fa-sparkles me-1"></i>' + data.preferences : '';
                        
                        // Feedback animation
                        gsap.fromTo(el, { scale: 0.95 }, { scale: 1, duration: 0.2, ease: "back.out(2)" });
                    }
                });
            };

            // Add To Cart AJAX
            window.addToCartAjax = function(productId, btn) {
                const ogHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i>';
                btn.disabled = true;

                fetch('<?= base_url("shop/add_to_cart/") ?>' + productId, {
                    method: 'GET'
                }).then(res => {
                    if(res.ok) {
                        btn.innerHTML = '<i class="fa-solid fa-check"></i>';
                        btn.classList.add('bg-success', 'text-white');
                        setTimeout(() => window.location.reload(), 600);
                    } else {
                        btn.innerHTML = ogHtml;
                        btn.disabled = false;
                    }
                }).catch(e => {
                    btn.innerHTML = ogHtml;
                    btn.disabled = false;
                });
            };

            const btnCheckout = document.getElementById('btnCheckout');
            if(btnCheckout) {
                btnCheckout.addEventListener('click', function() {
                    this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Keamanan Pembayaran...';
                    this.style.pointerEvents = 'none';
                    this.style.opacity = '0.7';
                });
            }

            // Auto-hide Nav on Scroll
            let lastScrollY = window.scrollY;
            window.addEventListener('scroll', () => {
                const iosNav = document.getElementById('iosNav');
                if (!iosNav) return;
                if (window.scrollY > lastScrollY && window.scrollY > 100) {
                    gsap.to(iosNav, { y: 100, opacity: 0, duration: 0.3 });
                } else {
                    gsap.to(iosNav, { y: 0, opacity: 1, duration: 0.3 });
                }
                lastScrollY = window.scrollY;
            });
        });
    </script>

    <!-- iOS FLOATING BAR -->
    <nav class="ios-navbar-guest" id="iosNav">
        <a href="<?= base_url(); ?>" class="ios-nav-item">
            <i class="fa-solid fa-house"></i>
            <span>Home</span>
        </a>
        <a href="<?= base_url('shop'); ?>" class="ios-nav-item">
            <i class="fa-solid fa-mug-hot"></i>
            <span>Menu</span>
        </a>
        <a href="<?= base_url(); ?>#ulasan" class="ios-nav-item">
            <i class="fa-solid fa-star"></i>
            <span>Ulasan</span>
        </a>
        <a href="<?= base_url('shop/cart'); ?>" class="ios-nav-item active">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>Cart</span>
            <?php 
                $cart_count = (isset($this->cart)) ? $this->cart->total_items() : 0;
            ?>
            <span class="fc-badge" style="<?= $cart_count > 0 ? 'display:flex; position:absolute; top:-5px; right:-5px; background:#e63946; color:#fff; border-radius:50%; min-width:18px; height:18px; font-size:0.6rem; align-items:center; justify-content:center; border:2px solid #fff;' : 'display:none' ?>"><?= $cart_count ?></span>
        </a>
        <?php if ($this->session->userdata('userid')): ?>
            <a href="<?= ($this->session->userdata('role') == 'admin') ? base_url('dashboard') : base_url('user'); ?>" class="ios-nav-item">
                <i class="fa-solid fa-user-circle"></i>
                <span>Akun</span>
            </a>
        <?php else: ?>
            <a href="<?= base_url('auth'); ?>" class="ios-nav-item">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span>Masuk</span>
            </a>
        <?php endif; ?>
    </nav>
</body>
</html>
