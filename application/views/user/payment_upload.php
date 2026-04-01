<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Bukti Bayar | MariMacha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --green-dark:#102416; --green-main:#1B3B25; --cream:#F5F5F0; }
        body { font-family:'Outfit',sans-serif; background:var(--cream); padding-top:80px; }
        .navbar-macha { background:rgba(255,255,255,.97); backdrop-filter:blur(12px); box-shadow:0 2px 20px rgba(45,90,39,.08); padding:14px 0; }
        .navbar-brand { font-weight:800; color:var(--green-dark) !important; font-size:1.4rem; }
        
        .upload-card { background:#fff; border-radius:24px; box-shadow:0 10px 36px rgba(0,0,0,.07); overflow:hidden; }
        .upload-header { background:linear-gradient(135deg, var(--green-dark), var(--green-main)); color:#fff; padding:28px 32px; }
        .upload-header h4 { font-weight:800; margin:0; }
        .upload-body { padding:32px; }

        /* Amount box */
        .amount-box { background:linear-gradient(135deg, #e8f5e2, #f0f7ec); border:2px solid #c8e6c9; border-radius:16px; padding:20px 24px; text-align:center; margin-bottom:24px; }
        .amount-box .label { font-size:.85rem; color:#7a9080; margin-bottom:4px; }
        .amount-box .amount { font-size:2rem; font-weight:800; color:var(--green-dark); }

        /* Rekening list */
        .rek-list { border-radius:16px; overflow:hidden; border:2px solid #e8ede8; margin-bottom:24px; }
        .rek-item { display:flex; align-items:center; justify-content:space-between; padding:16px 20px; border-bottom:1px solid #f0ede8; gap:12px; }
        .rek-item:last-child { border-bottom:none; }
        .rek-icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.2rem; flex-shrink:0; }
        .rek-info .bank-name { font-weight:700; color:var(--green-dark); }
        .rek-info .rek-no { font-size:1.05rem; font-weight:800; letter-spacing:1px; color:var(--green-main); }
        .rek-info .atas-nama { font-size:.8rem; color:#8a9e8a; }
        .copy-btn { background:var(--green-main); color:#fff; border:none; border-radius:8px; padding:6px 14px; font-size:.8rem; font-weight:600; cursor:pointer; white-space:nowrap; transition:.2s; }
        .copy-btn:hover { background:var(--green-dark); }

        /* File upload */
        .file-zone { border:3px dashed #c8d8c0; border-radius:16px; padding:36px 20px; text-align:center; cursor:pointer; transition:.25s; background:#fafcf9; }
        .file-zone:hover { border-color:var(--green-main); background:#f0f7f1; }
        .file-zone input[type=file] { display:none; }
        .file-zone .zone-icon { font-size:2.5rem; color:var(--green-light); margin-bottom:12px; }
        .file-zone p { color:#8a9e8a; margin:0; font-size:.9rem; }
        .file-name { font-size:.85rem; color:var(--green-main); font-weight:600; margin-top:10px; }

        .btn-submit { background:var(--green-dark); color:#fff; border:none; border-radius:50px; padding:16px; width:100%; font-size:1rem; font-weight:800; cursor:pointer; transition:.25s; margin-top:20px; }
        .btn-submit:hover { background:var(--green-main); transform:translateY(-2px); }
        .btn-back { color:var(--green-main); text-decoration:none; font-weight:600; font-size:.9rem; }
        .btn-back:hover { color:var(--green-dark); }

        .flash-err { background:#fde8e8; border-left:4px solid #e53e3e; border-radius:12px; padding:14px 20px; color:#9b1c1c; margin-bottom:20px; border:none; }
    </style>
</head>
<body>

    <nav class="navbar navbar-macha fixed-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fa-solid fa-leaf me-2" style="color:var(--green-main)"></i>MariMacha
            </a>
            <a href="<?= base_url('user') ?>" class="btn-back"><i class="fa-solid fa-arrow-left me-1"></i>Kembali</a>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <?php if($this->session->flashdata('error')): ?>
                    <div class="flash-err"><i class="fa-solid fa-triangle-exclamation me-2"></i><?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>

                <div class="upload-card">
                    <div class="upload-header">
                        <h4><i class="fa-solid fa-upload me-2"></i>Upload Bukti Pembayaran</h4>
                        <div style="opacity:.8;font-size:.9rem;margin-top:4px">Invoice: <?= htmlspecialchars($order['invoice_no']) ?></div>
                    </div>
                    <div class="upload-body">

                        <!-- Jumlah -->
                        <div class="amount-box">
                            <div class="label">Total yang harus dibayar</div>
                            <div class="amount">Rp <?= number_format($order['total_price'],0,',','.') ?></div>
                        </div>

                        <!-- Rekening -->
                        <p style="font-weight:700;color:var(--green-dark);margin-bottom:12px"><i class="fa-solid fa-building-columns me-2"></i>Transfer ke Salah Satu Rekening</p>
                        <div class="rek-list">
                            <div class="rek-item">
                                <div class="rek-icon" style="background:#0066AE20;color:#0066AE"><i class="fa-solid fa-building-columns"></i></div>
                                <div class="rek-info flex-grow-1">
                                    <div class="bank-name">BCA</div>
                                    <div class="rek-no" id="bca-no">1234567890</div>
                                    <div class="atas-nama">A.N MariMacha</div>
                                </div>
                                <button class="copy-btn" onclick="copyNo('bca-no', this)">Salin</button>
                            </div>
                            <div class="rek-item">
                                <div class="rek-icon" style="background:#E6A80020;color:#E6A800"><i class="fa-solid fa-building-columns"></i></div>
                                <div class="rek-info flex-grow-1">
                                    <div class="bank-name">Mandiri</div>
                                    <div class="rek-no" id="mandiri-no">0987654321</div>
                                    <div class="atas-nama">A.N MariMacha</div>
                                </div>
                                <button class="copy-btn" onclick="copyNo('mandiri-no', this)">Salin</button>
                            </div>
                            <div class="rek-item">
                                <div class="rek-icon" style="background:#00AED620;color:#00AED6"><i class="fa-brands fa-google-pay"></i></div>
                                <div class="rek-info flex-grow-1">
                                    <div class="bank-name">GoPay / OVO / Dana</div>
                                    <div class="rek-no" id="gopay-no">081234567890</div>
                                    <div class="atas-nama">A.N MariMacha</div>
                                </div>
                                <button class="copy-btn" onclick="copyNo('gopay-no', this)">Salin</button>
                            </div>
                        </div>

                        <!-- Enhanced Confirmation Form -->
                        <form action="<?= base_url('user/upload_payment') ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="sales_id" value="<?= $order['id'] ?>">
                            <input type="hidden" name="expected_nominal" value="<?= $order['total_price'] ?>">

                            <div class="mb-4">
                                <label class="form-label" style="font-weight:700;color:var(--green-dark);">1. Pilih Bank Tujuan Transfer</label>
                                <select name="bank_dest" class="form-select" required style="border-radius:12px; padding:12px; border:2px solid #e8ede8;">
                                    <option value="">-- Pilih Bank --</option>
                                    <option value="BCA">BCA (1234567890)</option>
                                    <option value="Mandiri">Mandiri (0987654321)</option>
                                    <option value="GOPAY">GoPay/OVO/Dana (081234567890)</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" style="font-weight:700;color:var(--green-dark);">2. Masukkan Nominal yang Ditransfer</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background:#f0faef; border-color:#e8ede8; font-weight:700;">Rp</span>
                                    <input type="number" name="nominal" class="form-control" placeholder="Contoh: 55000" value="<?= $order['total_price'] ?>" required style="border-radius:0 12px 12px 0; padding:12px; border:2px solid #e8ede8; border-left:none;">
                                </div>
                                <div class="form-text text-danger" style="font-size:.8rem; font-weight:600;">*Harus sesuai dengan total tagihan untuk konfirmasi otomatis</div>
                            </div>

                            <p style="font-weight:700;color:var(--green-dark);margin-bottom:12px"><i class="fa-solid fa-image me-2"></i>3. Upload Foto/Screenshot Bukti Transfer</p>
                            
                            <div class="file-zone mb-3" onclick="document.getElementById('payFile').click()">
                                <input type="file" id="payFile" name="payment_proof" accept="image/*,.pdf" required
                                       onchange="document.getElementById('fName').textContent='📎 '+this.files[0].name">
                                <div class="zone-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                                <p>Klik untuk memilih file<br><small>JPG, PNG, atau PDF – Maks 2MB</small></p>
                                <div class="file-name" id="fName"></div>
                            </div>

                            <button type="submit" class="btn-submit">
                                <i class="fa-solid fa-shield-check me-2"></i>Verifikasi Pembayaran
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <a href="<?= base_url('shop/invoice/'.$order['id']) ?>" class="btn-back">
                                <i class="fa-solid fa-receipt me-1"></i>Lihat Nota Pesanan
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function copyNo(id, btn) {
            const no = document.getElementById(id).textContent;
            navigator.clipboard.writeText(no).then(() => {
                const orig = btn.textContent;
                btn.textContent = '✓ Tersalin!';
                setTimeout(() => btn.textContent = orig, 2500);
            });
        }
    </script>
</body>
</html>
