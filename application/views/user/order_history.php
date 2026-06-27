<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Saya | MariMatcha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --green-ultra: #102416;
            --green-dark:  #102416;
            --green-main:  #1B3B25;
            --green-soft:  #53725D;
            --cream:       #F5F5F0; /* Premium Organic Cream */
            --card-bg:     #ffffff;
            --glass: rgba(255, 255, 255, 0.7);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--cream);
            min-height: 100vh;
            padding-top: 95px;
            color: #1a2e25;
            display: flex;
            flex-direction: column;
        }

        /* ── PROFILE HERO ── */
        .user-hero {
            background: linear-gradient(135deg, var(--green-ultra) 0%, var(--green-main) 100%);
            border-radius: 24px;
            padding: 32px;
            color: #fff;
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            position: relative;
            overflow: hidden;
        }
        .user-hero::before {
            content: '🌿';
            position: absolute;
            right: 40px; top: 50%;
            transform: translateY(-50%);
            font-size: 6rem;
            opacity: .12;
            pointer-events: none;
        }
        .uh-avatar {
            width: 70px; height: 70px;
            border-radius: 20px;
            background: rgba(255,255,255,.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem;
            font-weight: 800;
            border: 3px solid rgba(255,255,255,.4);
            flex-shrink: 0;
            object-fit: cover;
            box-shadow: 0 8px 24px rgba(0,0,0,.15);
        }

        .uh-info h4 { font-weight: 800; margin: 0; font-size: 1.35rem; }
        .uh-info p { margin: 4px 0 0; opacity: .8; font-size: .88rem; }
        .uh-left { display: flex; align-items: center; gap: 16px; }
        .btn-shop-hero {
            background: #fff;
            color: var(--green-ultra);
            border-radius: 50px;
            padding: 10px 22px;
            font-weight: 700;
            text-decoration: none;
            font-size: .88rem;
            transition: .25s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }
        .btn-shop-hero:hover { background: #e8f4e8; transform: translateY(-2px); }

        /* ── SUMMARY CHIPS ── */
        .summary-chips {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }
        .chip {
            background: #fff;
            border-radius: 14px;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1.5px solid #e9ede9;
            flex: 1;
            min-width: 140px;
            transition: .2s;
        }
        .chip:hover { border-color: var(--green-main); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.06); }
        .chip-icon {
            width: 40px; height: 40px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        .chip-num { font-size: 1.4rem; font-weight: 800; color: var(--green-ultra); line-height: 1; }
        .chip-label { font-size: .73rem; color: #8aa898; font-weight: 600; margin-top: 2px; }

        /* ── FILTER TABS ── */
        .filter-tabs {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .ftab {
            border: 1.5px solid #dce8dc;
            border-radius: 50px;
            padding: 7px 18px;
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            transition: .2s;
            background: #fff;
            color: #6b9080;
        }
        .ftab:hover, .ftab.active { background: var(--green-dark); color: #fff; border-color: var(--green-dark); }

        /* ── ORDER CARDS ── */
        .order-card {
            background: #fff;
            border-radius: 20px;
            border: 1.5px solid #edf1ed;
            margin-bottom: 14px;
            overflow: hidden;
            transition: .25s;
        }
        .order-card:hover {
            box-shadow: 0 10px 32px rgba(45,90,39,.1);
            border-color: #c8dcc8;
            transform: translateY(-2px);
        }
        .order-head {
            padding: 16px 22px;
            border-bottom: 1px solid #f0ede8;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .invoice-no { font-weight: 800; color: var(--green-ultra); font-size: .92rem; }
        .order-date { font-size: .78rem; color: #8a9e8a; margin-top: 2px; }
        .order-body { padding: 16px 22px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; }
        .order-total { font-size: 1.2rem; font-weight: 800; color: var(--green-main); }
        .order-method { font-size: .78rem; color: #8aa898; margin-top: 2px; }
        .order-actions { display: flex; gap: 8px; flex-wrap: wrap; }

        .btn-act {
            border-radius: 50px;
            padding: 8px 18px;
            font-size: .82rem;
            font-weight: 700;
            text-decoration: none;
            transition: .2s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-act-primary { background: var(--green-dark); color: #fff; }
        .btn-act-primary:hover { background: var(--green-main); color: #fff; transform: translateY(-1px); }
        .btn-act-outline { background: transparent; border: 2px solid var(--green-main); color: var(--green-main); }
        .btn-act-outline:hover { background: var(--green-main); color: #fff; }
        .btn-act-amber { background: transparent; border: 2px solid #d97706; color: #d97706; }
        .btn-act-amber:hover { background: #d97706; color: #fff; }

        /* ── STATUS BADGES ── */
        .sbadge { padding: 5px 14px; border-radius: 50px; font-size: .75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px; }
        .sb-pending   { background: #fff3e0; color: #e65100; }
        .sb-paid      { background: #e3f2fd; color: #1565c0; }
        .sb-shipped   { background: #e8f5e9; color: #2e7d32; }
        .sb-completed { background: #e0f7fa; color: #006064; }
        .sb-canceled  { background: #fce4ec; color: #880e4f; }

        /* ── PROGRESS TRACKER ── */
        .order-progress { padding: 12px 22px 16px; border-top: 1px solid #f0ede8; }
        .progress-steps { display: flex; align-items: center; gap: 0; }
        .ps-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            position: relative;
        }
        .ps-step::before {
            content: '';
            position: absolute;
            top: 14px;
            left: 50%; right: -50%;
            height: 2px;
            background: #dce8dc;
            z-index: 0;
        }
        .ps-step:last-child::before { display: none; }
        .ps-dot {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: #e8eee8;
            border: 2px solid #dce8dc;
            display: flex; align-items: center; justify-content: center;
            font-size: .75rem;
            font-weight: 700;
            color: #8aa898;
            z-index: 1;
            position: relative;
        }
        .ps-dot.done { background: var(--green-main); border-color: var(--green-main); color: #fff; }
        .ps-dot.current { background: #fff; border-color: var(--green-main); color: var(--green-main); box-shadow: 0 0 0 3px rgba(74,124,89,.15); }
        .ps-label { font-size: .65rem; font-weight: 600; color: #8aa898; margin-top: 6px; text-align: center; }
        .ps-step.done .ps-label { color: var(--green-main); }

        /* ── EMPTY STATE ── */
        .empty-state {
            background: #fff;
            border-radius: 22px;
            padding: 72px 20px;
            text-align: center;
            border: 1.5px solid #edf1ed;
        }
        .empty-icon-circle {
            width: 96px; height: 96px;
            background: linear-gradient(135deg, #f0f7f2, #e0f0e8);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 24px;
            font-size: 2.5rem;
        }

        /* ── FLASH ── */
        .flash-error { background: #fce4ec; border: none; border-left: 4px solid #e53e3e; border-radius: 14px; color: #880e4f; padding: 14px 20px; margin-bottom: 20px; }

        /* ─── SKELETON LOADING SYSTEM ─── */
        .skel-loading { position: relative; overflow: hidden; }
        .skel-shimmer {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
            transform: translateX(-100%);
            animation: skel-shimmer 1.5s infinite;
            z-index: 10;
        }
        @keyframes skel-shimmer { 100% { transform: translateX(100%); } }

        .skel-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: #f0f3f1; z-index: 9; border-radius: inherit;
        }
        .loaded .skel-overlay, .loaded .skel-shimmer { display: none !important; }
    </style>
</head>
<body>
    <!-- PREMIUM WAVY SPLASH SCREEN -->
    <div id="macha-splash" style="position:fixed; top:0; left:0; width:100%; height:100%; background:var(--green-ultra); z-index:20000; display:flex; align-items:center; justify-content:center; overflow:hidden;">
        <!-- Background Waves (Animated) -->
        <div class="splash-waves-bg">
            <svg class="wave-svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path id="wave-path" fill="rgba(27, 59, 37, 0.5)" d="M0,192L48,197.3C96,203,192,213,288,192C384,171,480,117,576,112C672,107,768,149,864,165.3C960,181,1056,171,1152,149.3C1248,128,1344,96,1392,80L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>

        <div style="text-align:center; position:relative; z-index:2;">
            <div id="splash-logo-box" style="width:130px; height:130px; background:#fff; border-radius:35px; display:flex; align-items:center; justify-content:center; margin:0 auto 30px; box-shadow:0 25px 60px rgba(0,0,0,0.4); position:relative; overflow:hidden;">
                <?php 
                    $ci =& get_instance();
                    $ci->load->model('M_settings');
                    $sl = $ci->M_settings->get_setting('shop_logo');
                    if(!empty($sl)): 
                ?>
                    <img src="<?= base_url('uploads/'.$sl) ?>" style="width:90px; height:90px; object-fit:contain; mix-blend-mode:multiply;">
                <?php else: ?>
                    <i class="fa-solid fa-leaf" style="color:var(--green-main); font-size:3.5rem;"></i>
                <?php endif; ?>
                <div class="shine-effect"></div>
            </div>
            
            <div class="loader-container">
                <div id="splash-bar" class="loader-bar"></div>
            </div>
            <div id="splash-text" class="loader-text">Brewing Your Premium Matcha</div>
        </div>
    </div>

    <style>
        .splash-waves-bg {
            position: absolute;
            bottom: 0; left: 0; width: 100%; height: 60%;
            pointer-events: none;
            opacity: 0.3;
        }
        .wave-svg { width: 100%; height: 100%; }
        .shine-effect {
            position: absolute; top: 0; left: -100%; width: 50%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transform: skewX(-20deg); animation: shine 2.5s infinite;
        }
        @keyframes shine { 0% { left: -100%; } 100% { left: 200%; } }
        
        .loader-container {
            width: 180px; height: 3px; background: rgba(255,255,255,0.08);
            border-radius: 10px; margin: 0 auto; overflow: hidden;
        }
        .loader-bar { width: 0%; height: 100%; background: #8BAA7C; box-shadow: 0 0 15px rgba(139,170,124,0.6); }
        .loader-text {
            color: rgba(255,255,255,0.6); font-size: 0.75rem; 
            text-transform: uppercase; letter-spacing: 4px; 
            margin-top: 20px; font-weight: 800;
        }
    </style>

    <!-- NAVBAR -->
    <?php $this->load->view('layout/navbar'); ?>

    <div class="container py-3 flex-grow-1" style="max-width:1200px">

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('success')): ?>
            <div class="flash-success"><i class="fa-solid fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
            <div class="flash-error"><i class="fa-solid fa-xmark-circle me-2"></i><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <!-- Profile Hero -->
        <div class="user-hero">
            <div class="uh-left">
                <?php if(!empty($user['profile_image']) && $user['profile_image'] != 'default_user.png'): ?>
                    <img src="<?= base_url('uploads/profile/'.$user['profile_image']) ?>" class="uh-avatar">
                <?php else: ?>
                    <div class="uh-avatar"><?= strtoupper(substr($user['full_name'], 0, 1)) ?></div>
                <?php endif; ?>
                <div class="uh-info">
                    <h4>Hai, <?= htmlspecialchars($this->session->userdata('full_name')) ?>! 👋</h4>
                    <p>Semoga harimu menyenangkan dan penuh rasa matcha! ☕</p>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap" style="position: relative; z-index: 2;">
                <a href="<?= site_url('shop') ?>" class="btn-shop-hero" style="background:#fff; color:var(--green-ultra); border:none; box-shadow:0 8px 20px rgba(0,0,0,0.1);">
                    <i class="fa-solid fa-bag-shopping"></i>Belanja Sekarang
                </a>
            </div>
        </div>

        <!-- Summary Chips -->
        <?php
        $total_orders    = count($orders);
        $total_spent     = array_sum(array_column($orders, 'total_price'));
        $pending_orders  = count(array_filter($orders, function($o) { return $o['status'] == 'pending'; }));
        $done_orders     = count(array_filter($orders, function($o) { return $o['status'] == 'completed'; }));
        ?>
        <div class="summary-chips">
            <div class="chip skel-loading" style="background: linear-gradient(135deg, #fff 0%, #f0fdf4 100%); border-color: #bbf7d0;">
                <div class="skel-overlay"></div><div class="skel-shimmer"></div>
                <div class="chip-icon" style="background:var(--green-main); color:#fff;"><i class="fa-solid fa-star"></i></div>
                <div>
                    <div class="chip-num text-success"><?= number_format($user['points'] ?? 0, 0, ',', '.') ?></div>
                    <div class="chip-label">Macha Points</div>
                </div>
            </div>
            <div class="chip skel-loading">
                <div class="skel-overlay"></div><div class="skel-shimmer"></div>
                <div class="chip-icon" style="background:#e8f4ee"><i class="fa-solid fa-receipt" style="color:var(--green-main)"></i></div>
                <div>
                    <div class="chip-num"><?= $total_orders ?></div>
                    <div class="chip-label">Total Pesanan</div>
                </div>
            </div>
            <div class="chip skel-loading">
                <div class="skel-overlay"></div><div class="skel-shimmer"></div>
                <div class="chip-icon" style="background:#fef3c7"><i class="fa-solid fa-clock" style="color:#d97706"></i></div>
                <div>
                    <div class="chip-num"><?= $pending_orders ?></div>
                    <div class="chip-label">Menunggu Bayar</div>
                </div>
            </div>
            <div class="chip skel-loading">
                <div class="skel-overlay"></div><div class="skel-shimmer"></div>
                <div class="chip-icon" style="background:#dcfce7"><i class="fa-solid fa-check" style="color:#16a34a"></i></div>
                <div>
                    <div class="chip-num"><?= $done_orders ?></div>
                    <div class="chip-label">Selesai</div>
                </div>
            </div>
        </div>

        <!-- Two Column Unified Layout -->
        <div class="row g-4 mt-2">
            <!-- Left Column: Profil Settings -->
            <div class="col-lg-5 col-12">
                <div class="profile-card" style="background: linear-gradient(135deg, var(--green-main) 0%, var(--green-dark) 100%); border-radius:24px; border:none; padding:30px; box-shadow:0 10px 32px rgba(16,36,22,0.15); position:relative; overflow:hidden; color:#fff;">
                    <div style="position:absolute; top:0; right:0; width:120px; height:120px; background:radial-gradient(circle, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0) 70%); border-radius:50%; transform:translate(30%, -30%); pointer-events:none;"></div>
                    
                    <div class="profile-header d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid rgba(255,255,255,0.15);">
                        <div class="position-relative p-avatar-wrap">
                            <?php if(!empty($user['profile_image']) && $user['profile_image'] != 'default_user.png'): ?>
                                <img src="<?= base_url('uploads/profile/'.$user['profile_image']) ?>" style="width:80px; height:80px; border-radius:20px; object-fit:cover; border:3px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,.1);" id="avatarPreview">
                            <?php else: ?>
                                <div class="uh-avatar" style="width:80px; height:80px; border-radius:20px; font-size:2rem; background:linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.05)); color:#fff; border:3px solid #fff; box-shadow:0 4px 10px rgba(0,0,0,0.1);" id="avatarInitial"><?= strtoupper(substr($user['full_name'] ?? 'M', 0, 1)) ?></div>
                                <img src="" style="width:80px; height:80px; border-radius:20px; object-fit:cover; border:3px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,.1);" class="d-none" id="avatarPreview">
                            <?php endif; ?>
                            <label for="profileInput" class="p-avatar-edit" style="position:absolute; bottom:-5px; right:-5px; width:28px; height:28px; background:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; color:var(--green-main); box-shadow:0 4px 8px rgba(0,0,0,0.15); cursor:pointer; border:2px solid #fff; transition:.2s;">
                                <i class="fa-solid fa-camera" style="font-size:11px"></i>
                            </label>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-white" style="font-size: 1.2rem; letter-spacing: -0.3px;">Profil Pengaturan Terpadu</h5>
                            <p class="text-white-50 small mb-0" style="font-size:0.8rem; opacity:0.85;">Kelola data pribadi & alamat pengiriman</p>
                        </div>
                    </div>

                    <form action="<?= base_url('user/update_profile') ?>" method="POST" enctype="multipart/form-data">
                        <input type="file" id="profileInput" name="image" class="d-none" accept="image/*" onchange="previewImage(this)">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label" style="font-weight:600; color:rgba(255,255,255,0.9); font-size:.8rem; letter-spacing: 0.5px; text-transform:uppercase; margin-bottom:4px;">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0 bg-white" style="border-radius: 12px 0 0 12px; border:2px solid #edf1ed; color:var(--green-main);"><i class="fa-regular fa-user"></i></span>
                                    <input type="text" name="full_name" class="form-control border-start-0 ps-0" style="border-radius:0 12px 12px 0; border:2px solid #edf1ed; padding:10px; font-weight:500; font-size:.9rem;" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>" required>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label" style="font-weight:600; color:rgba(255,255,255,0.9); font-size:.8rem; letter-spacing: 0.5px; text-transform:uppercase; margin-bottom:4px;">Username / ID Login</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0 bg-transparent text-white-50" style="border-radius: 12px 0 0 12px; border:2px solid rgba(255,255,255,0.25); color:rgba(255,255,255,0.6);"><i class="fa-solid fa-at"></i></span>
                                    <input type="text" class="form-control border-start-0 ps-0 text-white-50" style="border-radius:0 12px 12px 0; border:2px solid rgba(255,255,255,0.25); background:rgba(255,255,255,0.15); cursor:not-allowed; padding:10px; font-weight:500; font-size:.9rem;" value="<?= htmlspecialchars($user['username'] ?? '') ?>" disabled>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label" style="font-weight:600; color:rgba(255,255,255,0.9); font-size:.8rem; letter-spacing: 0.5px; text-transform:uppercase; margin-bottom:4px;">Nomor WhatsApp / HP</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0 bg-white" style="border-radius: 12px 0 0 12px; border:2px solid #edf1ed; color:var(--green-main);"><i class="fa-solid fa-phone"></i></span>
                                    <input type="text" name="phone" class="form-control border-start-0 ps-0" style="border-radius:0 12px 12px 0; border:2px solid #edf1ed; padding:10px; font-weight:500; font-size:.9rem;" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="Misal: 0812...">
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label" style="font-weight:600; color:rgba(255,255,255,0.9); font-size:.8rem; letter-spacing: 0.5px; text-transform:uppercase; margin-bottom:4px;">Alamat Lengkap Pengiriman Default</label>
                                <textarea name="address" rows="3" class="form-control" style="border-radius:12px; border:2px solid #edf1ed; padding:12px; resize:none; font-weight:500; font-size:.9rem;" placeholder="Tuliskan nama blok, RT/RW, gang, atau detail lainnya..."><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                            </div>

                            <div class="col-12 mt-3 pt-3 border-top" style="border-top-color: rgba(255,255,255,0.15) !important;">
                                <label class="form-label" style="font-weight:600; color:#ff8787; font-size:.8rem; letter-spacing: 0.5px; text-transform:uppercase; margin-bottom:4px;"><i class="fa-solid fa-lock me-1"></i>Ubah Password Baru (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0 bg-white" style="border-radius: 12px 0 0 12px; border:2px solid #fee2e2; color:#f87171;"><i class="fa-solid fa-key"></i></span>
                                    <input type="password" name="password" class="form-control border-start-0 ps-0" style="border-radius:0 12px 12px 0; border:2px solid #fee2e2; padding:10px; font-weight:500; font-size:.9rem;" placeholder="Kosongkan jika tidak ingin diubah">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-light w-100 rounded-pill fw-bold" style="background:#fff; color:var(--green-dark); border:none; padding:12px; font-size:.95rem; box-shadow: 0 4px 15px rgba(0,0,0,.15); transition:.2s;">
                                <i class="fa-solid fa-save me-1"></i> Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: Histori -->
            <div class="col-lg-7 col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0" style="color:var(--green-ultra);"><i class="fa-solid fa-clock-rotate-left text-success me-1"></i> Riwayat Pesanan</h5>
                </div>
                
                <!-- Filter Tabs -->
                <div class="filter-tabs" id="filterTabs" style="margin-bottom: 20px;">
                    <div class="ftab active" data-filter="all">Semua (<?= $total_orders ?>)</div>
                    <div class="ftab" data-filter="pending">⏳ Pending (<?= $pending_orders ?>)</div>
                    <div class="ftab" data-filter="paid">✅ Diterima</div>
                    <div class="ftab" data-filter="shipped">🔥 Dimasak</div>
                    <div class="ftab" data-filter="completed">🎉 Selesai</div>
                </div>

                <!-- ORDER CARDS -->
                <?php if (!empty($orders)): ?>
                    <?php
                    $status_map = [
                        'pending'   => ['sb-pending',   'Menunggu Bayar',   'fa-clock',           1],
                        'paid'      => ['sb-paid',       'Pesanan Diterima', 'fa-check-circle',    2],
                        'shipped'   => ['sb-shipped',    'Sedang Dimasak',   'fa-fire-burner',     3],
                        'completed' => ['sb-completed',  'Selesai',          'fa-flag-checkered',  4],
                        'canceled'  => ['sb-canceled',   'Dibatalkan',       'fa-ban',             0],
                    ];
                    $step_labels = ['Pesan', 'Diterima', 'Dimasak', 'Selesai'];
                    ?>
                    <div id="orderList">
                    <?php foreach ($orders as $o): ?>
                        <?php $sm = $status_map[$o['status']] ?? ['sb-pending', ucfirst($o['status']), 'fa-circle', 1]; ?>
                        <div class="order-card skel-loading" data-status="<?= $o['status'] ?>">
                            <div class="skel-overlay"></div><div class="skel-shimmer"></div>
                            <div class="order-head">
                                <div>
                                    <div class="invoice-no"><i class="fa-solid fa-file-invoice me-1" style="color:var(--green-main)"></i><?= htmlspecialchars($o['invoice_no']) ?></div>
                                    <div class="order-date"><i class="fa-regular fa-calendar me-1"></i><?= date('d M Y, H:i', strtotime($o['created_at'])) ?> WIB</div>
                                </div>
                                <span class="sbadge <?= $sm[0] ?>">
                                    <i class="fa-solid <?= $sm[2] ?>"></i> <?= $sm[1] ?>
                                </span>
                            </div>

                            <!-- Progress tracker (hanya jika tidak canceled) -->
                            <?php if ($o['status'] !== 'canceled'): ?>
                            <div class="order-progress">
                                <div class="progress-steps">
                                    <?php for ($s = 1; $s <= 4; $s++): ?>
                                    <div class="ps-step <?= $sm[3] >= $s ? 'done' : ($sm[3] + 1 == $s ? 'current' : '') ?>">
                                        <div class="ps-dot <?= $sm[3] >= $s ? 'done' : ($sm[3] + 1 == $s ? 'current' : '') ?>">
                                            <?php if ($sm[3] >= $s): ?><i class="fa-solid fa-check" style="font-size:.6rem"></i><?php else: ?><?= $s ?><?php endif; ?>
                                        </div>
                                        <div class="ps-label"><?= $step_labels[$s-1] ?></div>
                                    </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="order-body">
                                <div>
                                    <div class="order-total">Rp <?= number_format($o['total_price'], 0, ',', '.') ?></div>
                                    <div class="order-method"><i class="fa-solid fa-wallet me-1"></i>via <?= htmlspecialchars($o['payment_method'] ?? '-') ?></div>
                                </div>
                                <div class="order-actions">
                                    <a href="<?= base_url('shop/invoice/'.$o['id']) ?>" class="btn-act btn-act-primary">
                                        <i class="fa-solid fa-receipt"></i> Lihat Nota
                                    </a>
                                    <?php if ($o['status'] == 'pending'): ?>
                                    <a href="<?= base_url('user/payment/'.$o['id']) ?>" class="btn-act btn-act-amber">
                                        <i class="fa-solid fa-upload"></i> Upload Bukti
                                    </a>
                                    <?php elseif ($o['status'] == 'completed'): ?>
                                    <a href="<?= site_url('shop/reorder/'.$o['id']) ?>" class="btn-act btn-act-outline">
                                        <i class="fa-solid fa-rotate-left"></i> Pesan Lagi
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>

                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon-circle">🛍️</div>
                        <h5 style="color:var(--green-ultra);font-weight:800;margin-bottom:8px">Belum Ada Pesanan</h5>
                        <p class="text-muted mb-4" style="font-size:.9rem">Kamu belum pernah memesan. Yuk mulai nikmati matcha sekarang!</p>
                        <a href="<?= base_url('shop') ?>" class="btn-act btn-act-primary" style="font-size:.95rem;padding:12px 28px">
                            <i class="fa-solid fa-bag-shopping"></i> Mulai Belanja
                        </a>
                    </div>
                <?php endif; ?>
                
                <div id="emptyFilteredState" class="empty-state animate-fade" style="display:none; padding: 40px 20px;">
                    <div class="empty-icon-circle" style="width: 70px; height: 70px; font-size: 1.8rem;">🍵</div>
                    <h6 style="color:var(--green-ultra);font-weight:800;margin-bottom:4px">Tidak Ada Transaksi</h6>
                    <p class="text-muted small mb-0">Belum ada pesanan dengan status ini.</p>
                </div>
            </div>
        </div>

        <style>
            .profile-card { transition: all 0.3s ease; }
            .form-control:focus { box-shadow: none !important; border-color: var(--green-soft) !important; background: #fff !important; }
            .input-group:focus-within { box-shadow: 0 0 0 3px rgba(149,213,178,0.25) !important; border-radius: 12px; }
            .input-group:focus-within .input-group-text, .input-group:focus-within .form-control { border-color: var(--green-main) !important; }
            .p-avatar-edit:hover { background: var(--green-main) !important; color:#fff !important; transform: scale(1.1); }
            @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
            .animate-fade { animation: fadeIn 0.4s ease; }
        </style>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Filter tabs
        document.querySelectorAll('.ftab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.ftab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                
                const filter = tab.dataset.filter;
                let visibleCount = 0;
                
                if(document.getElementById('orderList')) {
                    document.querySelectorAll('.order-card').forEach(card => {
                        const show = (filter === 'all' || card.dataset.status === filter);
                        card.style.display = show ? 'block' : 'none';
                        if (show) visibleCount++;
                    });
                    
                    const emptyState = document.querySelector('.empty-state');
                    const emptyFilteredState = document.getElementById('emptyFilteredState');
                    
                    if (emptyState) {
                        if (filter === 'all' && visibleCount === 0) {
                            emptyState.style.display = 'block';
                            if (emptyFilteredState) emptyFilteredState.style.display = 'none';
                        } else {
                            emptyState.style.display = 'none';
                            if (emptyFilteredState) {
                                emptyFilteredState.style.display = (visibleCount === 0) ? 'block' : 'none';
                            }
                        }
                    }
                }
            });
        });

        // Image Preview logic
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById('avatarPreview');
                    var initial = document.getElementById('avatarInitial');
                    
                    if (preview) {
                        preview.src = e.target.result;
                        preview.classList.remove('d-none');
                    }
                    if (initial) {
                        initial.classList.add('d-none');
                    }
                }
                reader.readAsDataURL(input.files[0]);
                
                const wrap = document.querySelector('.p-avatar-wrap');
                if (wrap) {
                    wrap.style.transform = 'scale(1.05)';
                    setTimeout(() => { wrap.style.transform = 'scale(1)'; }, 300);
                }
            }
        }
    </script>
    <script>
        // Skeleton Loader Handler
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.querySelectorAll('.skel-loading').forEach(el => el.classList.add('loaded'));
            }, 800); // Micro-delay for premium feel
        });
    </script>
    <!-- COMMAND PALETTE MODAL -->
    <div class="modal fade" id="commandPalette" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-2xl" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border-radius: 24px;">
                <div class="modal-body p-4">
                    <div class="search-input-group mb-4" style="background: #f1f5f2; border-radius: 16px; padding: 12px 20px; display: flex; align-items: center; gap: 15px;">
                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                        <input type="text" id="cmdSearch" placeholder="Ketik untuk mencari (Alt+K)..." style="background: transparent; border: none; width: 100%; font-size: 1.1rem; outline: none;">
                    </div>
                    <div class="command-list" id="cmdList">
                        <div class="small text-muted mb-3 px-3 uppercase fw-bold" style="letter-spacing:1px; font-size: 0.7rem;">Navigasi Cepat</div>
                        <a href="<?= base_url(); ?>" class="command-item" style="padding: 12px 20px; border-radius: 14px; display: flex; align-items: center; gap: 15px; text-decoration: none; color: #333; transition: 0.2s;">
                            <i class="fa-solid fa-house"></i>
                            <span>Halaman Depan</span>
                        </a>
                        <a href="<?= base_url('shop'); ?>" class="command-item" style="padding: 12px 20px; border-radius: 14px; display: flex; align-items: center; gap: 15px; text-decoration: none; color: #333; transition: 0.2s;">
                            <i class="fa-solid fa-mug-hot"></i>
                            <span>Lanjut Belanja</span>
                        </a>
                        <a href="<?= base_url('user'); ?>" class="command-item" style="padding: 12px 20px; border-radius: 14px; display: flex; align-items: center; gap: 15px; text-decoration: none; color: #333; transition: 0.2s;">
                            <i class="fa-solid fa-user-gear"></i>
                            <span>Pengaturan Akun</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .command-item:hover { background: var(--green-main); color: #fff; transform: translateX(5px); }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- REFINED IMMERSIVE ZOOM PASS-THROUGH ---
            const splashTl = gsap.timeline({
                onComplete: () => {
                    document.getElementById('macha-splash').style.display = 'none';
                }
            });

            // Gentle background pulse
            gsap.to("#wave-path", {
                duration: 5,
                attr: { d: "M0,160L48,181.3C96,203,192,245,288,234.7C384,224,480,160,576,133.3C672,107,768,117,864,138.7C960,160,1056,192,1152,197.3C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z" },
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });

            splashTl.to("#splash-bar", {
                width: "100%",
                duration: 1.8,
                ease: "power2.inOut"
            })
            .to(".loader-container, .loader-text", {
                opacity: 0,
                y: -10,
                duration: 0.4,
                ease: "power2.in"
            }, "-=0.2")
            .to("#splash-logo-box", {
                scale: 25,          // Deeper zoom
                opacity: 0,
                duration: 1.4,
                ease: "power4.in"
            }, "-=0.1")
            .to("#macha-splash", {
                scale: 1.5,
                filter: "blur(60px)", 
                opacity: 0,
                duration: 1.2,
                ease: "power4.inOut"
            }, "-=1.1")
            .from(".user-hero", {
                scale: 1.05,        // Subtle scale-down for smoothness
                opacity: 0,
                filter: "blur(15px)",
                duration: 1.5,
                ease: "power3.out"
            }, "-=0.9")
            .from(".summary-chips .chip", {
                y: 30,
                opacity: 0,
                duration: 0.8,
                stagger: 0.08,
                ease: "power2.out"
            }, "-=0.8");

            // --- DASHBOARD INTERACTIVITY ---

            // Command Palette (Alt+K)
            const paletteEl = document.getElementById('commandPalette');
            if (paletteEl) {
                const cmdModal = new bootstrap.Modal(paletteEl);
                const cmdSearch = document.getElementById('cmdSearch');

                window.addEventListener('keydown', (e) => {
                    if (e.altKey && e.key === 'k') {
                        e.preventDefault();
                        cmdModal.show();
                        if (cmdSearch) setTimeout(() => cmdSearch.focus(), 500);
                    }
                });

                if (cmdSearch) {
                    cmdSearch.addEventListener('input', function() {
                        const q = this.value.toLowerCase();
                        document.querySelectorAll('.command-item').forEach(item => {
                            const text = item.innerText.toLowerCase();
                            item.style.display = text.includes(q) ? 'flex' : 'none';
                        });
                    });
                }
            }
        });
    </script>
    <footer class="text-center py-4" style="color:#8aa898; font-size:0.85rem; border-top:1px solid #dce8dc; margin-top:auto;">
        &copy; <?= date('Y') ?> MariMatcha. All rights reserved.
    </footer>
</body>
</html>
