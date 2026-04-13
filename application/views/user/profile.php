<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya | MariMatcha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --green-ultra: #102416;
            --green-dark:  #102416;
            --green-main:  #1B3B25;
            --green-soft:  #53725D;
            --cream:       #F5F5F0;
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
            border: 2px solid var(--green-main);
            color: var(--green-main);
            border-radius: 50px;
            padding: 7px 18px;
            font-weight: 600;
            font-size: .85rem;
            text-decoration: none;
            transition: .25s;
            background: transparent;
        }
        .nav-pill:hover { background: var(--green-main); color: #fff; }

        /* ── PROFILE CARD ── */
        .profile-card {
            background: #fff;
            border-radius: 20px;
            border: 1.5px solid #edf1ed;
            overflow: hidden;
            box-shadow: 0 10px 32px rgba(45,90,39,.05);
            padding: 32px;
        }
        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            padding-bottom: 24px;
            border-bottom: 1.5px dashed #edf1ed;
        }
        .p-avatar-wrap {
            position: relative;
            width: 100px; height: 100px;
            flex-shrink: 0;
        }
        .p-avatar {
            width: 100%; height: 100%;
            border-radius: 24px;
            background: var(--green-main);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.5rem;
            font-weight: 800;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 8px 20px rgba(0,0,0,.1);
        }
        .p-avatar-edit {
            position: absolute;
            bottom: -5px; right: -5px;
            width: 32px; height: 32px;
            background: #fff;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--green-main);
            box-shadow: 0 4px 10px rgba(0,0,0,.15);
            cursor: pointer;
            border: 2px solid #fff;
            transition: .2s;
        }
        .p-avatar-edit:hover { background: var(--green-main); color: #fff; transform: scale(1.1); }

        .p-info h4 { font-weight: 800; margin: 0; color: var(--green-ultra); }
        .p-info p { margin: 4px 0 0; color: #8aa898; font-size: .9rem; font-weight: 500; }
        
        /* ── FORMS ── */
        .form-label { font-weight: 700; color: var(--green-ultra); font-size: .9rem; }
        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 2px solid #edf1ed;
            background: #fafcfb;
            font-weight: 500;
            color: var(--green-ultra);
            transition: .2s;
        }
        .form-control:focus {
            border-color: var(--green-soft);
            box-shadow: 0 0 0 4px rgba(83,114,93,.1);
            background: #fff;
        }
        
        .btn-act-primary { 
            background: var(--green-main); 
            color: #fff; border-radius: 50px; padding: 12px 28px; width: 100%; font-weight: 700; border: none; font-size: 1rem; transition: .2s; box-shadow: 0 4px 15px rgba(27,59,37,.2);
        }
        .btn-act-primary:hover { background: var(--green-ultra); transform: translateY(-2px); box-shadow: 0 8px 20px rgba(27,59,37,.3); color: #fff;}

        /* ── FLASH ── */
        .flash-success { background: #e6f4ea; border: none; border-left: 4px solid var(--green-main); border-radius: 14px; color: #2e6b3e; padding: 14px 20px; margin-bottom: 20px; }
        .flash-error { background: #fce4ec; border: none; border-left: 4px solid #e53e3e; border-radius: 14px; color: #880e4f; padding: 14px 20px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-macha fixed-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fa-solid fa-leaf me-2" style="color:var(--green-main)"></i>MariMatcha
            </a>
            <div class="d-flex gap-2 align-items-center">
                <a href="<?= base_url('user') ?>" class="nav-pill" style="border:none; color:var(--green-soft)"><i class="fa-solid fa-arrow-left me-1"></i>Kembali</a>
            </div>
        </div>
    </nav>

    <div class="container py-3 mb-5" style="max-width:700px">
        
        <!-- Flash Messages -->
        <?php if($this->session->flashdata('success')): ?>
            <div class="flash-success"><i class="fa-solid fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
            <div class="flash-error"><i class="fa-solid fa-xmark-circle me-2"></i><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <div class="profile-card">
            <div class="profile-header">
                <div class="p-avatar-wrap">
                    <?php if(!empty($user['profile_image']) && $user['profile_image'] != 'default_user.png'): ?>
                        <img src="<?= base_url('uploads/profile/'.$user['profile_image']) ?>" class="p-avatar" id="avatarPreview">
                    <?php else: ?>
                        <div class="p-avatar" id="avatarInitial"><?= strtoupper(substr($user['full_name'] ?? 'M', 0, 1)) ?></div>
                        <img src="" class="p-avatar d-none" id="avatarPreview">
                    <?php endif; ?>
                    <label for="profileInput" class="p-avatar-edit">
                        <i class="fa-solid fa-camera"></i>
                    </label>
                </div>
                <div class="p-info">
                    <h4>Profil Pengaturan Terpadu</h4>
                    <p>Kelola data pribadi, alamat pengiriman, dan keamanan akun Anda</p>
                </div>
            </div>

            <form action="<?= base_url('user/update_profile') ?>" method="POST" enctype="multipart/form-data">
                <input type="file" id="profileInput" name="image" class="d-none" accept="image/*" onchange="previewImage(this)">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-transparent text-muted" style="border-radius: 12px 0 0 12px; border-color: #edf1ed;"><i class="fa-regular fa-user"></i></span>
                            <input type="text" name="full_name" class="form-control border-start-0 ps-0" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Username / ID Login</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-transparent text-muted" style="border-radius: 12px 0 0 12px; border-color: #edf1ed;"><i class="fa-solid fa-at"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0 text-muted" value="<?= htmlspecialchars($user['username'] ?? '') ?>" disabled style="background:#f4f7f4; cursor:not-allowed;">
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Nomor WhatsApp / HP</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-transparent text-muted" style="border-radius: 12px 0 0 12px; border-color: #edf1ed;"><i class="fa-solid fa-phone"></i></span>
                            <input type="text" name="phone" class="form-control border-start-0 ps-0" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="Misal: 081234567890">
                        </div>
                        <div class="form-text mt-1 text-muted" style="font-size:.8rem"><i class="fa-solid fa-circle-info me-1"></i>Akan Anda gunakan juga saat proses checkout pesanan.</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Alamat Lengkap Pengiriman Default</label>
                        <textarea name="address" rows="3" class="form-control" placeholder="Tuliskan nama blok, RT/RW, gang, atau detail lainnya yang memudahkan pengantar kurir..." style="border-radius:12px;"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                        <div class="form-text mt-1 text-muted" style="font-size:.8rem"><i class="fa-solid fa-circle-info me-1"></i>Akan digunakan otomatis sebagai alamat tujuan pengiriman saat checkout.</div>
                    </div>

                    <div class="col-12 mt-5">
                        <h6 class="fw-bold text-danger mb-3"><i class="fa-solid fa-lock me-2"></i>Keamanan Akun</h6>
                        <label class="form-label">Ubah Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-transparent text-muted" style="border-radius: 12px 0 0 12px; border-color: #edf1ed;"><i class="fa-solid fa-key"></i></span>
                            <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="Biarkan kosong jika tidak ingin mengubah password">
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <button type="submit" class="btn-act-primary"><i class="fa-solid fa-save me-2"></i>Simpan Perubahan Profil</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById('avatarPreview');
                    var initial = document.getElementById('avatarInitial');
                    
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    if(initial) initial.classList.add('d-none');
                }
                reader.readAsDataURL(input.files[0]);
                
                // Animasi kecil saat ganti
                document.querySelector('.p-avatar-wrap').style.transform = 'scale(1.05)';
                setTimeout(() => { document.querySelector('.p-avatar-wrap').style.transform = 'scale(1)'; }, 300);
            }
        }
    </script>
</body>
</html>
