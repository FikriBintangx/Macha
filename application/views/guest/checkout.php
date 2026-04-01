<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | MariMacha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root{--gd:#102416;--gm:#1B3B25;--gl:#53725D;--cream:#F5F5F0;--dark:#0A140D;--txt:#1B3B25;}
        body{font-family:'Outfit',sans-serif;background:var(--cream);padding-top:72px;color:var(--txt); animation: fadeIn 0.4s ease-in;}
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .navbar-macha{background:rgba(255,255,255,.97);backdrop-filter:blur(16px);box-shadow:0 2px 20px rgba(45,90,39,.08);padding:13px 0;}
        .navbar-brand{font-weight:900;font-size:1.5rem;color:var(--gd)!important;letter-spacing:-.5px;}

        /* PROGRESS STEPS */
        .steps-bar{background:#fff;padding:24px 0;border-bottom:2px solid #edf1ed;margin-bottom:32px;}
        .steps{display:flex;justify-content:center;align-items:center;gap:0;}
        .step{display:flex;align-items:center;gap:10px;}
        .step-circle{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.9rem;transition:.3s;border:2px solid transparent;}
        .step.done .step-circle{background:var(--gm);color:#fff;border-color:var(--gm);box-shadow:0 4px 12px rgba(64,145,108,.3);}
        .step.active .step-circle{background:var(--gd);color:#fff;border-color:var(--gd);box-shadow:0 0 0 6px rgba(27,77,62,.15), 0 6px 16px rgba(27,77,62,.4);transform:scale(1.12);}
        .step.inactive .step-circle{background:#f0f4f0;color:#aaa;border-color:#e8ede8;}
        .step-label{font-size:.85rem;font-weight:700;color:#aaa;}
        .step.done .step-label,.step.active .step-label{color:var(--gd);}
        .step-line{width:60px;height:3px;background:#e8ede8;margin:0 10px;border-radius:4px;overflow:hidden;}
        .step-line-fill{height:100%;background:linear-gradient(90deg,var(--gm),var(--gl));width:0%;transition:width .8s ease;}
        .step.done+.step-line .step-line-fill{width:100%;}

        /* CARD COMMON */
        .form-card{background:#fff;border-radius:24px;box-shadow:0 8px 30px rgba(0,0,0,.04);padding:32px;margin-bottom:24px;border:1px solid rgba(0,0,0,.02);}
        .form-card h5{font-weight:900;color:var(--gd);margin-bottom:24px;padding-bottom:14px;border-bottom:2px solid var(--cream);display:flex;align-items:center;gap:12px;}
        .form-label{font-weight:700;color:#4a6050;font-size:.88rem;margin-bottom:6px;}
        .form-control{border:2px solid #e8ede8;border-radius:14px;padding:14px 18px;font-family:'Outfit',sans-serif;font-size:.95rem;transition:.25s;background:#f9fbf9;}
        .form-control:focus{border-color:var(--gm);background:#fff;box-shadow:0 0 0 4px rgba(64,145,108,.1);outline:none;}
        .form-control.valid{border-color:var(--gl);background:#f0faf4;}
        .form-control.invalid{border-color:#e63946;background:#fff5f5;animation: shake 0.3s;}
        @keyframes shake { 0%,100% {transform:translateX(0);} 25% {transform:translateX(-5px);} 75% {transform:translateX(5px);} }

        /* PAYMENT */
        .pay-option{border:2px solid #e8ede8;border-radius:18px;padding:18px 22px;cursor:pointer;transition:.3s;display:flex;align-items:center;gap:16px;margin-bottom:12px;position:relative;background:#fff;}
        .pay-option:hover{border-color:var(--gl);transform:translateX(5px);}
        .pay-option.selected{border-color:var(--gm);background:linear-gradient(135deg,#f0faf4,#fff);box-shadow:0 4px 20px rgba(64,145,108,.12);}
        .pay-option.selected::after{content:'✓';position:absolute;right:22px;top:50%;transform:translateY(-50%);background:var(--gm);color:#fff;width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:900;}
        .pay-option input[type=radio]{display:none;}
        .pay-icon{width:48px;height:48px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;}

        /* QRIS MODAL */
        .qris-modal { position:fixed; inset:0; background:rgba(0,0,0,0.85); z-index:2000; display:none; align-items:center; justify-content:center; padding:20px; backdrop-filter:blur(5px); }
        .qris-content { background:#fff; border-radius:32px; padding:32px; max-width:420px; width:100%; text-align:center; position:relative; box-shadow:0 25px 50px -12px rgba(0,0,0,0.5); }
        .qris-img { width:220px; height:220px; margin:20px auto; border: 8px solid #f0faf4; border-radius: 20px; padding: 10px; background: #fff; }
        .qris-logo { width:120px; margin-bottom:15px; }

        /* REKENING */
        /* ... removed old ... */

        /* SUMMARY SIDEBAR */
        .summary-card{background:linear-gradient(165deg,var(--gd),#0d2a1f);color:#fff;border-radius:28px;padding:32px;position:sticky;top:90px;box-shadow:0 15px 45px rgba(27,77,62,.25);overflow:hidden;}
        .summary-card::before{content:'';position:absolute;top:-50px;right:-50px;width:150px;height:150px;background:rgba(255,255,255,.03);border-radius:50%;}
        .summary-card h5{font-weight:900;margin-bottom:24px;display:flex;align-items:center;gap:10px;color:var(--gl);}
        .summary-row{display:flex;justify-content:space-between;padding:10px 0;font-size:.92rem;border-bottom:1px solid rgba(255,255,255,.07);}
        .summary-total{display:flex;justify-content:space-between;font-size:1.4rem;font-weight:900;margin-top:20px;color:var(--gl);}
        
        .btn-pay{background:#fff;color:var(--gd);border-radius:50px;padding:18px;font-weight:900;font-size:1.05rem;width:100%;border:none;cursor:pointer;margin-top:24px;transition:.3s;box-shadow:0 10px 25px rgba(0,0,0,.2);display:flex;align-items:center;justify-content:center;gap:10px;}
        .btn-pay:hover{background:var(--gl);color:var(--gd);transform:translateY(-3px);box-shadow:0 15px 35px rgba(0,0,0,.3);}
        .btn-pay:active{transform:translateY(0);}
        .btn-pay:disabled{background:#4a6050!important;color:rgba(255,255,255,.4)!important;cursor:not-allowed;box-shadow:none;}
        
        .urgency-box{background:rgba(251,191,36,.1);border:1px solid rgba(251,191,36,.25);border-radius:14px;padding:12px;margin-top:20px;text-align:center;font-size:.85rem;color:#fbbf24;font-weight:700;}
        .trust-row{display:flex;justify-content:center;gap:12px;margin-top:20px;opacity:.6;}
        .trust-item{font-size:.7rem;font-weight:700;display:flex;align-items:center;gap:4px;}
        
        /* NOTE OPTIONS */
        .note-options{display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:10px;margin-bottom:15px;}
        .note-check-label{border:1.5px solid #e8ede8;border-radius:12px;padding:8px 12px;font-size:.82rem;font-weight:700;color:var(--gl);cursor:pointer;transition:.2s;display:flex;align-items:center;gap:8px;background:#fff;}
        .note-check-label:hover{border-color:var(--gl);background:#f9fbf9;}
        .note-check-label input{display:none;}
        .note-check-label.active{background:var(--gm);color:#fff;border-color:var(--gm);box-shadow:0 4px 10px rgba(27,77,62,.2);}
    </style>
</head>
<body>

    <nav class="navbar navbar-macha fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fa-solid fa-leaf me-2" style="color:var(--green-main)"></i>MariMacha
            </a>
            <a href="<?= base_url('shop/cart') ?>" class="text-muted text-decoration-none" style="font-size:.9rem">
                <i class="fa-solid fa-arrow-left me-1"></i>Kembali ke Keranjang
            </a>
        </div>
    </nav>

    <!-- Steps -->
    <div class="steps-bar">
        <div class="steps">
            <div class="step done" id="s1">
                <div class="step-circle"><i class="fa-solid fa-check"></i></div>
                <span class="step-label">Keranjang</span>
            </div>
            <div class="step-line"><div class="step-line-fill" id="line1"></div></div>
            <div class="step active" id="s2">
                <div class="step-circle">2</div>
                <span class="step-label">Checkout</span>
            </div>
            <div class="step-line"><div class="step-line-fill" id="line2"></div></div>
            <div class="step inactive" id="s3">
                <div class="step-circle">3</div>
                <span class="step-label">Selesai</span>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row g-4">
            <!-- Left: Form -->
            <div class="col-lg-7">
                <form id="checkoutForm" action="<?= base_url('shop/process_checkout') ?>" method="post">



                    <!-- Informasi Pengiriman -->
                    <div class="form-card">
                        <h5><i class="fa-solid fa-truck-fast me-2"></i>Informasi Pengiriman</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Penerima</label>
                                <input type="text" name="customer_name" class="form-control" value="<?= htmlspecialchars($user['full_name'] ?? $this->session->userdata('full_name')) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor WhatsApp</label>
                                <input type="text" name="phone" id="phone_field" class="form-control" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="08xxxxxxxxxx" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alamat Lengkap (Opsional)</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Isi alamat jika ingin pesanan diantar atau sebagai patokan pickup"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label d-flex justify-content-between">
                                    <span>Lokasi Google Maps (Opsional)</span>
                                    <button type="button" class="btn btn-sm btn-outline-success border-0 p-0" onclick="getLocation()" style="font-size: .8rem; font-weight: 700;">
                                        <i class="fa-solid fa-location-dot me-1"></i>Bagikan Lokasi Saya
                                    </button>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-2 border-end-0" style="border-radius: 14px 0 0 14px;"><i class="fa-solid fa-link text-muted"></i></span>
                                    <input type="text" name="google_maps_link" id="google_maps_link" class="form-control border-start-0" style="border-radius: 0 14px 14px 0;" placeholder="https://maps.google.com/..." value="">
                                </div>
                                <small class="text-muted mt-2 d-block" style="font-size: .75rem;">
                                    <i class="fa-solid fa-circle-info me-1"></i>Klik "Bagikan Lokasi Saya" agar kurir lebih mudah menemukan rumah Anda.
                                </small>
                            </div>
                            <div class="col-12 mt-4">
                                <label class="form-label">Pilih Catatan Cepat (Klik untuk menambah)</label>
                                <div class="note-options" id="noteRecs">
                                    <label class="note-check-label" onclick="toggleNote(this, 'Less Ice')">
                                        <i class="fa-solid fa-snowflake"></i> Less Ice
                                    </label>
                                    <label class="note-check-label" onclick="toggleNote(this, 'Extra Ice')">
                                        <i class="fa-solid fa-ice-cream"></i> Extra Ice
                                    </label>
                                    <label class="note-check-label" onclick="toggleNote(this, 'No Ice')">
                                        <i class="fa-solid fa-ban"></i> No Ice
                                    </label>
                                    <label class="note-check-label" onclick="toggleNote(this, 'Less Sugar')">
                                        <i class="fa-solid fa-cubes-stacked"></i> Less Sugar
                                    </label>
                                    <label class="note-check-label" onclick="toggleNote(this, 'Extra Sugar')">
                                        <i class="fa-solid fa-plus"></i> Extra Sugar
                                    </label>
                                    <label class="note-check-label" onclick="toggleNote(this, 'No Sugar')">
                                        <i class="fa-solid fa-droplet-slash"></i> No Sugar
                                    </label>
                                    <label class="note-check-label" onclick="toggleNote(this, 'Extra Creamy')">
                                        <i class="fa-solid fa-cloud"></i> Extra Creamy
                                    </label>
                                    <label class="note-check-label" onclick="toggleNote(this, 'Hot Only')">
                                        <i class="fa-solid fa-mug-hot"></i> Hot Only
                                    </label>
                                    <label class="note-check-label" onclick="toggleNote(this, 'Pisah Es')">
                                        <i class="fa-solid fa-box-open"></i> Pisah Es
                                    </label>
                                    <label class="note-check-label" onclick="toggleNote(this, 'Sedikit Creamy')">
                                        <i class="fa-solid fa-water"></i> Light Creamy
                                    </label>
                                    
                                    <?php 
                                    // DYNAMIC TOPPING RECS based on cart items
                                    $has_strawberry = false;
                                    $has_chocolate = false;
                                    $has_boba = false;
                                    
                                    foreach($cart as $item) {
                                        $name = strtolower($item['name']);
                                        if (strpos($name, 'strawberry') !== false) $has_strawberry = true;
                                        if (strpos($name, 'choco') !== false || strpos($name, 'coklat') !== false) $has_chocolate = true;
                                        if (strpos($name, 'boba') !== false) $has_boba = true;
                                    }

                                    if($has_strawberry): ?>
                                    <label class="note-check-label" onclick="toggleNote(this, 'Extra Strawberry')">
                                        <i class="fa-solid fa-strawberry"></i> Extra Strawberry
                                    </label>
                                    <?php endif; ?>

                                    <?php if($has_chocolate): ?>
                                    <label class="note-check-label" onclick="toggleNote(this, 'Extra Choco')">
                                        <i class="fa-solid fa-cookie"></i> Extra Choco
                                    </label>
                                    <?php endif; ?>

                                    <?php if($has_boba): ?>
                                    <label class="note-check-label" onclick="toggleNote(this, 'Extra Boba')">
                                        <i class="fa-solid fa-circle"></i> Extra Boba
                                    </label>
                                    <?php endif; ?>
                                </div>
                                <label class="form-label">Catatan Tambahan (Lainnya)</label>
                                <textarea name="notes" id="notesField" class="form-control" rows="2" placeholder="Contoh: Titip di depan gerbang ya.."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="form-card">
                        <h5><i class="fa-solid fa-wallet me-2" style="color:var(--green-main)"></i>Metode Pembayaran</h5>

                        <label class="pay-option selected" id="optQRIS" onclick="selectPay(this,'QRIS')">
                            <input type="radio" name="payment_method" value="QRIS" checked>
                            <div class="pay-icon" style="background:#DE000015;color:#DE0000"><i class="fa-solid fa-qrcode"></i></div>
                            <div>
                                <div style="font-weight:700;color:var(--green-dark)">QRIS (Gopay/OVO/Dana/BCA)</div>
                                <div style="font-size:.82rem;color:#7a9080">Scan QR & Upload Bukti Transfer</div>
                            </div>
                        </label>

                        <label class="pay-option" id="optCash" onclick="selectPay(this,'Cash')">
                            <input type="radio" name="payment_method" value="Cash">
                            <div class="pay-icon" style="background:#53725D20;color:#53725D"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                            <div>
                                <div style="font-weight:700;color:var(--green-dark)">Bayar di Tempat (Cash / Pickup)</div>
                                <div style="font-size:.82rem;color:#7a9080">Bayar saat ambil / Pesanan dibikin setelah bayar</div>
                            </div>
                        </label>

                        <!-- Info Payment -->
                        <div id="paymentInfoArea">
                            <div class="rekening-card" id="qrisInfo" style="background:#f0fdf4; border:2.5px solid var(--gm); border-radius:18px; padding:24px; margin-top:20px; text-align:center;">
                                <div class="mb-3">
                                    <span class="badge bg-success px-3 py-2 rounded-pill mb-2">METODE TERPILIH</span>
                                    <h6 class="fw-bold mb-1">Pembayaran Digital (QRIS)</h6>
                                    <p class="text-muted small">Scan QR di bawah ini untuk membayar cepat</p>
                                </div>
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=Marimacha_QRIS_Payment" alt="QRIS Marimacha" class="img-fluid rounded-4 shadow-sm mb-3" style="width:200px; border:6px solid #fff;">
                                <div class="alert alert-warning py-2 px-3 rounded-pill d-inline-block" style="font-size:.8rem; font-weight:700;">
                                    <i class="fa-solid fa-camera me-1"></i> Scan QR & Simpan Bukti Bayar
                                </div>
                            </div>

                            <div class="rekening-card d-none" id="cashInfo" style="background:#fffcf0; border:2.5px dashed #d97706; border-radius:18px; padding:24px; margin-top:20px;">
                                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color:#92400e">
                                    <i class="fa-solid fa-store"></i> Aturan Bayar di Tempat
                                </h6>
                                <ul class="list-unstyled mb-0" style="font-size:.88rem; color:#92400e; line-height:1.6">
                                    <li class="mb-2">✅ Dapatkan <strong>No. Order</strong> setelah checkout ini.</li>
                                    <li class="mb-2">✅ Tunjukkan No. Order ke kasir saat datang ke kedai.</li>
                                    <li class="mb-1">⚠️ <strong>PENTING:</strong> Pesanan baru diproses/dibikin SETELAH Anda bayar di tempat untuk menghindari pembatalan sepihak.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Right: Order Summary -->
            <div class="col-lg-5">
                <div class="summary-card">
                    <h5><i class="fa-solid fa-receipt me-2"></i>Ringkasan Pesanan</h5>
                    <?php foreach($cart as $item): ?>
                    <div class="summary-row py-3" style="border-bottom:1px solid rgba(255,255,255,.1);">
                        <div class="d-flex justify-content-between align-items-start w-100">
                            <div>
                                <div style="font-weight:800; font-size:1rem; color:#fff;"><?= htmlspecialchars($item['name']) ?></div>
                                <div style="font-size:0.75rem; color:var(--gl); font-weight:700;">
                                    <?php if(!empty($item['preferences'])): ?>
                                        <i class="fa-solid fa-check-double me-1"></i><?= $item['preferences'] ?>
                                    <?php endif; ?>
                                </div>
                                <div class="mt-1" style="font-size:0.8rem; opacity:0.7;">Qty: <?= $item['qty'] ?> × Rp <?= number_format($item['price'],0,',','.') ?></div>
                            </div>
                            <div style="font-weight:900; color:var(--gl); text-align:right;">
                                Rp <?= number_format($item['subtotal'],0,',','.') ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <div class="summary-row">
                        <span>Ongkos Kirim</span>
                        <span style="opacity:.7">Dibahas via WA</span>
                    </div>
                    <div class="summary-total">
                        <span>Total Bayar</span>
                        <span>Rp <?= number_format($total,0,',','.') ?></span>
                    </div>

                    <button type="submit" form="checkoutForm" class="btn-pay" id="btnPay">
                        <span><i class="fa-solid fa-lock me-2"></i>Selesaikan Pesanan</span>
                    </button>
                    <div class="trust-row">
                        <div class="trust-item"><i class="fa-solid fa-shield-halved"></i>Aman & Terenkripsi</div>
                        <div class="trust-item"><i class="fa-solid fa-clock"></i>Proses Cepat</div>
                        <div class="trust-item"><i class="fa-solid fa-headset"></i>Support 24/7</div>
                    </div>
                    <div class="urgency-box" id="urgencyBox">
                        ⏰ Harga berlaku: <span id="urgencyTimer">09:59</span>
                    </div>
                    <div style="margin-top:16px;padding:14px;background:rgba(255,255,255,.08);border-radius:14px;font-size:.82rem;line-height:1.7;color:rgba(255,255,255,.7)">
                        <i class="fa-solid fa-circle-info me-1"></i>
                        Setelah checkout, upload bukti transfer di <strong style="color:#fff">Akun Saya</strong>. Admin verifikasi dalam 1×24 jam.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // STEP LINE ANIMATION
    setTimeout(function(){document.getElementById('line1').style.width='100%';},300);
    // PAYMENT
    function selectPay(el,key){
        document.querySelectorAll('.pay-option').forEach(function(o){o.classList.remove('selected');});
        el.classList.add('selected');
        
        // EXPLICITLY CHECK THE RADIO BUTTON (FIX BUG)
        const radio = el.querySelector('input[type="radio"]');
        if(radio) {
            radio.checked = true;
            // Trigger change event if needed
            radio.dispatchEvent(new Event('change'));
        }

        const qris = document.getElementById('qrisInfo');
        const cash = document.getElementById('cashInfo');
        
        if(key === 'QRIS') {
            qris.classList.remove('d-none');
            cash.classList.add('d-none');
        } else {
            qris.classList.add('d-none');
            cash.classList.remove('d-none');
        }
    }
    // REAL-TIME VALIDATION
    document.querySelectorAll('.form-control[required]').forEach(function(inp){
        inp.addEventListener('blur',function(){
            if(inp.value.trim().length>1){inp.classList.add('valid');inp.classList.remove('invalid');}
            else{inp.classList.add('invalid');inp.classList.remove('valid');}
        });
    });
    // PREVENT DOUBLE SUBMIT
    document.getElementById('checkoutForm').addEventListener('submit',function(){
        var btn=document.getElementById('btnPay');
        btn.disabled=true;
        btn.innerHTML='<span><i class="fa-solid fa-spinner fa-spin me-2"></i>Memproses pesanan...</span>';
    });
    function getLocation() {
        if (navigator.geolocation) {
            const btn = document.querySelector('[onclick="getLocation()"]');
            const addressField = document.querySelector('textarea[name="address"]');
            const originalHtml = btn.innerHTML;
            const originalPlaceholder = addressField.placeholder;
            
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i>Mencari Lokasi...';
            btn.disabled = true;
            addressField.placeholder = "Mengekstrak alamat otomatis...";
            addressField.classList.add('loading-addr');

            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const link = `https://www.google.com/maps?q=${lat},${lng}`;
                document.getElementById('google_maps_link').value = link;

                // REVERSE GEOCODING via Nominatim (OpenStreetMap) - Free & No Key Required
                fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`, {
                    headers: { 'Accept-Language': 'id' }
                })
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        // Clean up the address string (take first few parts for better UI)
                        const addrParts = data.display_name.split(',');
                        // Usually: Shop/Building, Road, District, City, Province, Postcode, Country
                        // We take the first 4-5 parts for a concise "Complete Address"
                        const condensedAddr = addrParts.slice(0, 5).join(',').trim();
                        addressField.value = condensedAddr;
                        addressField.classList.add('valid');
                    }
                })
                .catch(err => console.error("Reverse Geocode Error:", err))
                .finally(() => {
                    btn.innerHTML = '<i class="fa-solid fa-check-circle me-1"></i>Lokasi Berhasil';
                    btn.classList.replace('btn-outline-success', 'btn-success');
                    addressField.placeholder = originalPlaceholder;
                    addressField.classList.remove('loading-addr');
                    
                    setTimeout(() => {
                        btn.innerHTML = originalHtml;
                        btn.disabled = false;
                        btn.classList.replace('btn-success', 'btn-outline-success');
                    }, 3000);
                });

            }, function(error) {
                let msg = "Gagal mendapatkan lokasi: " + error.message;
                if(error.message.includes("secure origins")) {
                    msg = "Fitur 'Ambil Lokasi' WAJIB menggunakan HTTPS (SSL).\n\nSilakan aktifkan SSL/HTTPS (Gembok Hijau) di cPanel agar fitur ini aktif secara otomatis.";
                }
                alert(msg);
                btn.innerHTML = originalHtml;
                btn.disabled = false;
                addressField.placeholder = originalPlaceholder;
                addressField.classList.remove('loading-addr');
            }, {
                enableHighAccuracy: true,
                timeout: 8000,
                maximumAge: 0
            });
        } else {
            alert("Geolocation tidak didukung oleh browser Anda.");
        }
    }
    // URGENCY COUNTDOWN
    var sec=599;
    var timer=setInterval(function(){
        if(sec<=0){clearInterval(timer);document.getElementById('urgencyBox').textContent='⚠️ Sesi habis, refresh halaman';return;}
        var m=Math.floor(sec/60),s=sec%60;
        document.getElementById('urgencyTimer').textContent=(m<10?'0':'')+m+':'+(s<10?'0':'')+s;
        sec--;
    },1000);
    function toggleNote(el, text) {
        const field = document.getElementById('notesField');
        el.classList.toggle('active');
        
        let currentNotes = field.value.split(',').map(s => s.trim()).filter(s => s.length > 0);
        
        if (el.classList.contains('active')) {
            if (!currentNotes.includes(text)) currentNotes.push(text);
        } else {
            currentNotes = currentNotes.filter(s => s !== text);
        }
        
        field.value = currentNotes.join(', ');
        field.classList.add('valid'); // Trigger visual success
    }
    </script>
</body>
</html>
