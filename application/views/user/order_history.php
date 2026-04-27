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
            --green-ultra: #1b4d3e;
            --green-dark:  #2d5a27;
            --green-main:  #4a7c59;
            --green-soft:  #95d5b2;
            --cream:       #f5f0e8;
            --card-bg:     #ffffff;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(160deg, #f0f4f1 0%, #f5f0e8 100%);
            min-height: 100vh;
            padding-top: 80px;
            color: #1a2e25;
        }

        /* ── NAVBAR ── */
        .navbar-macha {
            background: rgba(255,255,255,.96);
            backdrop-filter: blur(16px);
            box-shadow: 0 2px 24px rgba(45,90,39,.08);
            padding: 12px 0;
        }
        .navbar-brand { font-weight: 800; color: var(--green-ultra) !important; font-size: 1.4rem; text-decoration: none; }
        .nav-pill {
            background: #fff;
            border: 1.5px solid #e9ede9;
            color: var(--green-main);
            border-radius: 50px;
            padding: 8px 18px;
            font-weight: 700;
            font-size: .85rem;
            text-decoration: none;
            transition: .25s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }
        .nav-pill:hover { background: #f0f7f2; color: var(--green-dark); border-color: var(--green-main); transform: translateY(-1px); }
        .nav-pill-danger { border-color: #fecaca; color: #dc2626; background: #fff; }
        .nav-pill-danger:hover { background: #fee2e2; color: #b91c1c; border-color: #f87171; }

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
        .flash-success { background: #e6f4ea; border: none; border-left: 4px solid var(--green-main); border-radius: 14px; color: #2e6b3e; padding: 14px 20px; margin-bottom: 20px; }
        .flash-error { background: #fce4ec; border: none; border-left: 4px solid #e53e3e; border-radius: 14px; color: #880e4f; padding: 14px 20px; margin-bottom: 20px; }

        /* SKELETON LOADING */
        #skeleton-loader { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #fff; z-index: 9999; padding: 20px; display: flex; flex-direction: column; gap: 20px; }
        .sk-hero { height: 180px; border-radius: 24px; background: #f0f4f1; }
        .sk-chips { display: flex; gap: 12px; }
        .sk-chip { flex: 1; height: 80px; border-radius: 14px; background: #f8faf9; }
        .sk-card { height: 120px; border-radius: 20px; background: #fcfdfc; }
        .sk-anim { background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: sk-loading 1.5s infinite; }
        @keyframes sk-loading { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    </style>
</head>
<body>
    <!-- SKELETON OVERLAY -->
    <div id="skeleton-loader">
        <div class="sk-hero sk-anim"></div>
        <div class="sk-chips">
            <div class="sk-chip sk-anim"></div>
            <div class="sk-chip sk-anim"></div>
            <div class="sk-chip sk-anim"></div>
        </div>
        <div class="sk-card sk-anim"></div>
        <div class="sk-card sk-anim"></div>
    </div>

    <!-- NAVBAR -->
    <nav class="navbar navbar-macha fixed-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fa-solid fa-leaf me-2" style="color:var(--green-main)"></i>MariMatcha
            </a>
            <div class="d-flex gap-2 align-items-center">
                <a href="<?= site_url('shop') ?>" class="nav-pill"><i class="fa-solid fa-bag-shopping"></i>Belanja</a>
                <a href="<?= site_url('auth/logout') ?>" class="nav-pill nav-pill-danger"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
            </div>
        </div>
    </nav>

    <div class="container py-3 mb-5" style="max-width:860px">

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
            <div class="d-flex gap-2 flex-wrap">
                <a href="#" onclick="document.querySelector('[data-filter=\'profile-settings\']').click(); return false;" class="btn-shop-hero" style="background:rgba(255,255,255,0.15); color:#fff; border:1.5px solid rgba(255,255,255,0.3); backdrop-filter:blur(4px);">
                    <i class="fa-solid fa-user-circle"></i>Profil
                </a>
                <a href="<?= site_url('shop') ?>" class="btn-shop-hero" style="background:#fff; color:var(--green-ultra); border:none; box-shadow:0 8px 20px rgba(0,0,0,0.1);">
                    <i class="fa-solid fa-bag-shopping"></i>Belanja
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
            <div class="chip" style="background: linear-gradient(135deg, #fff 0%, #f0fdf4 100%); border-color: #bbf7d0;">
                <div class="chip-icon" style="background:var(--green-main); color:#fff;"><i class="fa-solid fa-star"></i></div>
                <div>
                    <div class="chip-num text-success"><?= number_format($user['points'] ?? 0, 0, ',', '.') ?></div>
                    <div class="chip-label">Macha Points</div>
                </div>
            </div>
            <div class="chip">
                <div class="chip-icon" style="background:#e8f4ee"><i class="fa-solid fa-receipt" style="color:var(--green-main)"></i></div>
                <div>
                    <div class="chip-num"><?= $total_orders ?></div>
                    <div class="chip-label">Total Pesanan</div>
                </div>
            </div>
            <div class="chip">
                <div class="chip-icon" style="background:#fef3c7"><i class="fa-solid fa-clock" style="color:#d97706"></i></div>
                <div>
                    <div class="chip-num"><?= $pending_orders ?></div>
                    <div class="chip-label">Menunggu Bayar</div>
                </div>
            </div>
            <div class="chip">
                <div class="chip-icon" style="background:#dcfce7"><i class="fa-solid fa-check" style="color:#16a34a"></i></div>
                <div>
                    <div class="chip-num"><?= $done_orders ?></div>
                    <div class="chip-label">Selesai</div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs" id="filterTabs">
            <div class="ftab active" data-filter="all"><i class="fa-solid fa-list me-1"></i>Semua (<?= $total_orders ?>)</div>
            <div class="ftab" data-filter="pending">⏳ Pending (<?= $pending_orders ?>)</div>
            <div class="ftab" data-filter="paid">✅ Diterima</div>
            <div class="ftab" data-filter="shipped">🔥 Dimasak</div>
            <div class="ftab" data-filter="completed">🎉 Selesai (<?= $done_orders ?>)</div>
            <div class="ftab" data-filter="profile-settings" style="margin-left:auto; border-color:var(--green-main); color:var(--green-main);"><i class="fa-solid fa-user-gear me-1"></i>Pengaturan Akun</div>
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
                <div class="order-card" data-status="<?= $o['status'] ?>">
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

        <!-- PROFILE SETTINGS TAB CONTENT -->
        <div id="profileSettings" style="display:none; animation: fadeIn .4s ease;">
            <div class="profile-card" style="background:#fff; border-radius:24px; border:none; padding:40px; box-shadow:0 12px 40px rgba(27,77,62,0.06); position:relative; overflow:hidden;">
                
                <!-- Decorative background accent -->
                <div style="position:absolute; top:0; right:0; width:150px; height:150px; background:radial-gradient(circle, rgba(149,213,178,0.15) 0%, rgba(255,255,255,0) 70%); border-radius:50%; transform:translate(30%, -30%); pointer-events:none;"></div>

                <div class="profile-header d-flex flex-column flex-md-row align-items-center gap-4" style="margin-bottom:35px; padding-bottom:30px; border-bottom:1px solid #f0f4f1;">
                    <div class="position-relative">
                        <?php if(!empty($user['profile_image']) && $user['profile_image'] != 'default_user.png'): ?>
                            <img src="<?= base_url('uploads/profile/'.$user['profile_image']) ?>" style="width:100px; height:100px; border-radius:24px; object-fit:cover; border:4px solid #fff; box-shadow: 0 8px 20px rgba(0,0,0,.1);">
                        <?php else: ?>
                            <div class="p-avatar shadow-sm" style="width:100px; height:100px; border-radius:24px; background:linear-gradient(135deg, var(--green-main), var(--green-dark)); color:#fff; display:flex; align-items:center; justify-content:center; font-size:2.5rem; font-weight:800; border:4px solid #fff; box-shadow: 0 4px 12px rgba(45,90,39,0.15) !important;">
                                <?= strtoupper(substr($user['full_name'] ?? 'M', 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                        <a href="<?= base_url('user/profile') ?>" class="btn btn-sm btn-light position-absolute bottom-0 end-0 rounded-circle shadow-sm" style="width:30px; height:30px; display:flex; align-items:center; justify-content:center; border:2px solid #fff;">
                            <i class="fa-solid fa-camera text-success" style="font-size:12px"></i>
                        </a>
                    </div>
                    <div class="p-info text-center text-md-start">
                        <h4 style="font-weight:800; color:var(--green-ultra); margin:0; font-size: 1.6rem; letter-spacing: -0.5px;">Pengaturan Terpadu</h4>
                        <p style="margin:6px 0 0; color:#6b8e7b; font-size:.95rem; font-weight:400;">Kelola data pribadi, preferensi logistik, dan kredensial keamanan Anda.</p>
                    </div>
                </div>

                <form action="<?= base_url('user/update_profile') ?>" method="POST">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight:600; color:var(--green-ultra); font-size:.85rem; letter-spacing: 0.5px; text-transform:uppercase; margin-bottom:8px;">Nama Lengkap</label>
                            <div class="input-group" style="box-shadow: 0 2px 6px rgba(0,0,0,0.02); border-radius:14px;">
                                <span class="input-group-text border-end-0 bg-white" style="border-radius:14px 0 0 14px; border:2px solid #e9eee9; color:var(--green-main);"><i class="fa-regular fa-user"></i></span>
                                <input type="text" name="full_name" class="form-control border-start-0 ps-0" style="border-radius:0 14px 14px 0; border:2px solid #e9eee9; font-weight:500; padding:14px;" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" style="font-weight:600; color:var(--green-ultra); font-size:.85rem; letter-spacing: 0.5px; text-transform:uppercase; margin-bottom:8px;">Username / ID Login</label>
                            <div class="input-group" style="box-shadow: 0 2px 6px rgba(0,0,0,0.02); border-radius:14px;">
                                <span class="input-group-text border-end-0" style="border-radius:14px 0 0 14px; border:2px solid #e9eee9; border-right:none; background:#f9fbf9; color:#a2b1a6;"><i class="fa-solid fa-at"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" style="border-radius:0 14px 14px 0; border:2px solid #e9eee9; border-left:none; background:#f9fbf9; color:#8ea395; font-weight:500; padding:14px; cursor:not-allowed;" value="<?= htmlspecialchars($user['username'] ?? '') ?>" disabled>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label" style="font-weight:600; color:var(--green-ultra); font-size:.85rem; letter-spacing: 0.5px; text-transform:uppercase; margin-bottom:8px;">Nomor WhatsApp / Telepon</label>
                            <div class="input-group" style="box-shadow: 0 2px 6px rgba(0,0,0,0.02); border-radius:14px;">
                                <span class="input-group-text border-end-0 bg-white" style="border-radius:14px 0 0 14px; border:2px solid #e9eee9; color:var(--green-main);"><i class="fa-solid fa-phone"></i></span>
                                <input type="text" name="phone" class="form-control border-start-0 ps-0" style="border-radius:0 14px 14px 0; border:2px solid #e9eee9; font-weight:500; padding:14px;" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="Misal: 0812...">
                            </div>
                            <div class="form-text mt-2" style="font-size:.85rem; color:#7d9e8b;"><i class="fa-solid fa-bolt me-1 text-warning"></i>Sinkronisasi otomatis di ringkasan checkout Anda.</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label" style="font-weight:600; color:var(--green-ultra); font-size:.85rem; letter-spacing: 0.5px; text-transform:uppercase; margin-bottom:8px;">Alamat Pengiriman Default</label>
                            <textarea name="address" rows="3" class="form-control" style="border-radius:14px; border:2px solid #e9eee9; padding:16px; font-weight:500; box-shadow: 0 2px 6px rgba(0,0,0,0.02); resize:none;" placeholder="Tuliskan nama blok, jalan, rincian lokasi..."><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                        </div>

                        <div class="col-12 mt-5">
                            <div style="background:linear-gradient(90deg, #fff7f7, #fff); border-left:4px solid #f87171; border-radius:12px; padding:20px; box-shadow:0 4px 15px rgba(248,113,113,0.05);">
                                <h6 class="fw-bold mb-3" style="color:#b91c1c;"><i class="fa-solid fa-shield-halved me-2"></i>Kredensial Keamanan</h6>
                                <label class="form-label" style="font-weight:600; color:#7f1d1d; font-size:.85rem; letter-spacing: 0.5px; text-transform:uppercase; margin-bottom:8px;">Setel Password Baru</label>
                                <div class="input-group" style="border-radius:14px;">
                                    <span class="input-group-text border-end-0 bg-white" style="border-radius:14px 0 0 14px; border:2px solid #fee2e2; color:#f87171;"><i class="fa-solid fa-key"></i></span>
                                    <input type="password" name="password" class="form-control border-start-0 ps-0" style="border-radius:0 14px 14px 0; border:2px solid #fee2e2; padding:14px; font-weight:500;" placeholder="Abaikan field ini jika tidak ingin mengubah sandi">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 text-end">
                        <button type="submit" class="btn-act btn-act-primary" style="padding:14px 34px; font-size:1.05rem; letter-spacing:0.5px; box-shadow: 0 8px 25px rgba(74,124,89,0.3); border-radius:50px;">
                            Simpan Profil <i class="fa-solid fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
            <style>
                @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
                .form-control:focus { box-shadow: none !important; border-color: var(--green-soft) !important; background: #fff !important; }
                .input-group:focus-within { box-shadow: 0 0 0 4px rgba(149,213,178,0.2) !important; border-radius: 14px; }
                .input-group:focus-within .input-group-text, .input-group:focus-within .form-control { border-color: var(--green-main) !important; }
            </style>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Filter tabs
        document.querySelectorAll('.ftab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.ftab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                
                const filter = tab.dataset.filter;
                
                if(filter === 'profile-settings') {
                    document.getElementById('orderList') ? document.getElementById('orderList').style.display = 'none' : '';
                    const emptyState = document.querySelector('.empty-state');
                    if(emptyState) emptyState.style.display = 'none';
                    document.getElementById('profileSettings').style.display = 'block';
                } else {
                    document.getElementById('profileSettings').style.display = 'none';
                    const emptyState = document.querySelector('.empty-state');
                    if(emptyState) emptyState.style.display = 'block';
                    if(document.getElementById('orderList')) {
                        document.getElementById('orderList').style.display = 'block';
                        document.querySelectorAll('.order-card').forEach(card => {
                            card.style.display = (filter === 'all' || card.dataset.status === filter) ? 'block' : 'none';
                        });
                    }
                }
            });
        });
    </script>
    <script>
        window.addEventListener('load', function() {
            const sk = document.getElementById('skeleton-loader');
            if(sk) {
                setTimeout(() => {
                    sk.style.transition = 'opacity 0.6s ease';
                    sk.style.opacity = '0';
                    setTimeout(() => sk.style.display = 'none', 600);
                }, 500);
            }
        });
    </script>
</body>
</html>
