<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pesanan | MariMacha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root{--gd:#102416;--gm:#1B3B25;--gl:#53725D;--cream:#F5F5F0;--accent:#fbbf24;}
        body{font-family:'Outfit',sans-serif;background:var(--cream);padding:32px 0 72px;position:relative;}
        
        /* DECORATIVE WATERMARK */
        body::before {
            content:''; position:fixed; inset:0; 
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
            opacity: 0.03; pointer-events: none; z-index: -1;
        }

        .nota-paper{max-width:700px;margin:0 auto;background:#fff;border-radius:28px;box-shadow:0 24px 80px rgba(0,0,0,.12);overflow:hidden;position:relative;animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);}
        @keyframes slideUp { from {opacity:0; transform: translateY(30px);} to {opacity:1; transform: translateY(0);} }
        
        .nota-header{background:linear-gradient(135deg,var(--gd) 0%,#0f3024 50%,var(--gm) 100%);color:#fff;padding:36px 40px;position:relative;overflow:hidden;}
        .nota-header::after {
            content:''; position:absolute; top:0; left:0; right:0; bottom:0;
            background: radial-gradient(circle at 20% 150%, rgba(83, 114, 93, 0.4), transparent 50%);
        }
        
        .nota-header::before{content:'🌿';position:absolute;right:-10px;bottom:-20px;font-size:10rem;opacity:.05;z-index:1;}
        .nota-header .logo{font-size:1.6rem;font-weight:900;letter-spacing:-.5px;position:relative;z-index:2;}
        .nota-header .invoice-num{font-size:.88rem;opacity:.7;margin-top:6px;letter-spacing:.5px;position:relative;z-index:2;}
        
        /* STATUS BADGES + PULSE */
        .status-badge{position:absolute;top:36px;right:40px;padding:9px 22px;border-radius:50px;font-weight:800;font-size:.88rem;border:2px solid rgba(255,255,255,.3);backdrop-filter:blur(8px);z-index:2;}
        .status-pending{background:rgba(251,191,36,.2);border-color:rgba(251,191,36,.5);color:#fbbf24;animation: pulseGlow 2s infinite;}
        @keyframes pulseGlow { 0% {box-shadow: 0 0 0 0 rgba(251,191,36,0.4);} 70% {box-shadow: 0 0 0 10px rgba(251,191,36,0);} 100% {box-shadow: 0 0 0 0 rgba(251,191,36,0);} }
        
        .status-paid,.status-completed{background:rgba(149,213,178,.2);border-color:rgba(149,213,178,.5);color:#a7f3d0;}
        .status-shipped{background:rgba(96,165,250,.2);border-color:rgba(96,165,250,.5);color:#93c5fd;}
        .status-canceled{background:rgba(239,68,68,.2);border-color:rgba(239,68,68,.5);color:#fca5a5;}
        
        /* PROGRESS STEPPER */
        .order-stepper { display: flex; justify-content: space-between; padding: 30px 40px; background: #fafdfb; border-bottom: 1.5px solid #f0f4f1; }
        .step-item { flex: 1; text-align: center; position: relative; }
        .step-item::after { content: ''; position: absolute; top: 15px; left: 50%; width: 100%; height: 2px; background: #e8ede8; z-index: 1; }
        .step-item:last-child::after { display: none; }
        .step-circle { width: 32px; height: 32px; border-radius: 50%; background: #fff; border: 2.5px solid #e8ede8; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 800; position: relative; z-index: 2; color: #aaa; transition: .3s; }
        .step-item.active .step-circle { border-color: var(--gm); color: var(--gm); background: #f0faf4; box-shadow: 0 0 0 5px rgba(27,77,62,0.08); }
        .step-item.done .step-circle { background: var(--gm); border-color: var(--gm); color: #fff; }
        .step-item.done::after { background: var(--gm); }
        .step-label { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: #aaa; transition: .3s; }
        .step-item.active .step-label, .step-item.done .step-label { color: var(--gd); }

        .nota-body{padding:36px 40px;}
        .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:32px;}
        .info-box{background:#f8fdf8;border:1.5px solid #e8f0e8;border-radius:16px;padding:16px 20px;transition:.3s;}
        .info-box:hover{border-color:var(--gl);transform:translateY(-2px);box-shadow: 0 5px 15px rgba(0,0,0,0.03);}
        .info-box label{font-size:.72rem;text-transform:uppercase;letter-spacing:1px;color:#8aa898;font-weight:700;display:block;margin-bottom:4px;}
        .info-box span{font-weight:800;color:var(--gd);font-size:.95rem;}
        
        .nota-table{width:100%;border-collapse:collapse;margin-bottom:28px;}
        .nota-table thead tr{background:var(--gd);color:#fff;}
        .nota-table thead th{padding:14px 16px;font-weight:800;font-size:.82rem;text-align:left;letter-spacing:.5px;}
        .nota-table thead th:last-child{text-align:right;}
        .nota-table tbody tr{border-bottom:1px solid #f0ede8; transition:.2s;}
        .nota-table tbody tr:hover{background:#fafdf8;}
        .nota-table tbody td{padding:14px 16px;font-size:.92rem;color:var(--gd);}
        .nota-table tbody td:last-child{text-align:right;font-weight:800;color:var(--gm);}
        .nota-table tfoot tr{background:linear-gradient(135deg,#f0faf4,#e8f5e9);}
        .nota-table tfoot td{padding:16px;font-weight:900;font-size:1rem;color:var(--gd);}
        .nota-table tfoot td:last-child{text-align:right;font-size:1.2rem;color:var(--gm);}
        
        .payment-box{background:linear-gradient(135deg,#fffbf2,#fef3c7);border:2px solid #fde68a;border-radius:24px;padding:22px 24px;margin-bottom:24px;position:relative;}
        .payment-box::before { content: '⚠️'; position:absolute; right: 20px; top: 20px; font-size: 1.5rem; opacity: 0.2; }
        .payment-box h6{font-weight:900;color:#92400e;margin-bottom:18px;font-size:1rem;display:flex;align-items:center;gap:8px;}
        .rek-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;padding:8px 0;border-bottom:1px solid rgba(146,64,14,0.05);}
        .rek-row:last-child{border-bottom:none;}
        .rek-row .label{font-size:.85rem;color:#7a9080;font-weight:600;}
        .rek-row .value{font-weight:800;color:var(--gd);}
        .rek-row .rek-number{font-size:1.1rem;font-weight:900;letter-spacing:1px;color:var(--gd);font-family:monospace;}
        
        .copy-btn{background:var(--gm);color:#fff;border:none;border-radius:10px;padding:6px 14px;font-size:.78rem;font-weight:800;cursor:pointer;transition:.2s;display:flex;align-items:center;gap:6px;}
        .copy-btn:hover{background:var(--gd);transform:scale(1.05);}
        
        .wa-confirm-box{background:linear-gradient(135deg,#e7f8f0,#d1fae5);border:2px solid #6ee7b7;border-radius:24px;padding:24px;text-align:center;margin-bottom:24px;}
        .wa-confirm-box p{margin:0 0 16px;font-size:.92rem;color:#064e3b;font-weight:700;line-height:1.6;}
        .btn-wa-confirm{background:linear-gradient(135deg,#25d366,#128c7e);color:#fff;border-radius:50px;padding:15px 36px;font-weight:900;text-decoration:none;display:inline-flex;align-items:center;gap:12px;transition:.3s;box-shadow:0 8px 25px rgba(37,211,102,.3);font-size:1rem;}
        .btn-wa-confirm:hover{transform:translateY(-4px);box-shadow:0 15px 35px rgba(37,211,102,.4);color:#fff;filter:brightness(1.1);}
        
        .nota-actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:20px;}
        .btn-action{flex:1;min-width:140px;text-align:center;padding:15px 20px;border-radius:50px;font-weight:800;text-decoration:none;border:none;cursor:pointer;transition:.3s;font-size:.88rem;display:flex;justify-content:center;align-items:center;gap:10px;box-shadow: 0 4px 15px rgba(0,0,0,0.05);}
        .btn-action-primary{background:linear-gradient(135deg,var(--gd),var(--gm));color:#fff;box-shadow:0 8px 25px rgba(27,77,62,0.25);}
        .btn-action-primary:hover{transform:translateY(-3px);box-shadow:0 12px 35px rgba(27,77,62,0.35);color:#fff;}
        .btn-action-outline{background:#fff;border:2px solid #e8ede8;color:var(--gl);}
        .btn-action-outline:hover{border-color:var(--gm);color:var(--gm);background:#f9fbf9;transform:translateY(-2px);}
        .btn-action-print{background:#f0faf5;color:var(--gd);border:2px solid var(--gl);opacity:0.8;}
        .btn-action-print:hover{opacity:1;transform:translateY(-2px);}

        .nota-footer{padding:24px 40px 36px;border-top:2px dashed #eef2ef;text-align:center;background:#fafdfb;}
        .nota-footer p{color:#8aa898;font-size:.82rem;margin:4px 0;font-weight:600;}
        .pay-countdown{background:rgba(217,119,6,.08);padding:8px 16px;border-radius:50px;display:inline-block;margin-top:16px;font-size:.8rem;color:#92400e;font-weight:800;}
        .pay-countdown span{color:#d97706;font-family:monospace;font-size:1rem;}

        @media print {
            body { background: #E8E8E3 !important; padding: 20px !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .nota-paper { 
                box-shadow: 0 0 20px rgba(0,0,0,0.1) !important; 
                border: 1px solid #ddd !important; 
                border-radius: 28px !important; 
                max-width: 100% !important;
                margin: 0 auto !important;
                background: #fff !important;
            }
            .nota-actions, .wa-confirm-box, .pay-countdown, .order-stepper { display: none !important; }
            .nota-header { border-radius: 28px 28px 0 0 !important; }
        }
        @media(max-width:560px){.nota-header{padding:24px 20px;}.order-stepper{padding:20px;}.nota-body{padding:24px 20px;}.info-grid{grid-template-columns:1fr;}.nota-footer{padding:20px;}}
    </style>
</head>
<body>

    <div class="container">
        <div class="nota-paper">
            <!-- Header -->
            <div class="nota-header">
                <div class="logo"><i class="fa-solid fa-leaf me-2"></i>MariMacha</div>
                <div class="invoice-num">Nota / Invoice Pesanan</div>
                <?php
                    $status_map=[
                        'pending'   =>['label'=>'⏳ Menunggu Bayar',   'cls'=>'status-pending'],
                        'paid'      =>['label'=>'✅ Sudah Dibayar',     'cls'=>'status-paid'],
                        'shipped'   =>['label'=>'🚚 Sedang Dikirim',   'cls'=>'status-shipped'],
                        'completed' =>['label'=>'✅ Selesai',           'cls'=>'status-paid'],
                        'canceled'  =>['label'=>'❌ Dibatalkan',        'cls'=>'status-canceled'],
                    ];
                    $s=$order['status']??'pending';
                    $sm=$status_map[$s]??['label'=>ucfirst($s),'cls'=>'status-pending'];
                ?>
                <div class="status-badge <?=$sm['cls']?>"><?=$sm['label']?></div>
            </div>
            <!-- Stepper -->
            <div class="order-stepper">
                <div class="step-item <?= ($s == 'pending' || $s == 'paid' || $s == 'shipped' || $s == 'completed') ? 'done' : '' ?>">
                    <div class="step-circle"><?= ($s != 'pending') ? '<i class="fa-solid fa-check"></i>' : '1' ?></div>
                    <div class="step-label">Dipesan</div>
                </div>
                <div class="step-item <?= ($s == 'paid' || $s == 'shipped' || $s == 'completed') ? 'done' : (($s == 'pending') ? 'active' : '') ?>">
                    <div class="step-circle"><?= ($s == 'paid' || $s == 'shipped' || $s == 'completed') ? '<i class="fa-solid fa-check"></i>' : '2' ?></div>
                    <div class="step-label">Bayar</div>
                </div>
                <div class="step-item <?= ($s == 'shipped' || $s == 'completed') ? 'done' : (($s == 'paid') ? 'active' : '') ?>">
                    <div class="step-circle"><?= ($s == 'shipped' || $s == 'completed') ? '<i class="fa-solid fa-check"></i>' : '3' ?></div>
                    <div class="step-label">Proses</div>
                </div>
                <div class="step-item <?= ($s == 'completed') ? 'done' : (($s == 'shipped') ? 'active' : '') ?>">
                    <div class="step-circle"><i class="fa-solid fa-truck"></i></div>
                    <div class="step-label">Kirim</div>
                </div>
            </div>

            <!-- Body -->
            <div class="nota-body">
                <!-- Info Grid -->
                <div class="info-grid">
                    <div class="info-box">
                        <label>No. Invoice</label>
                        <span><?= htmlspecialchars($order['invoice_no']) ?></span>
                    </div>
                    <div class="info-box">
                        <label>Tanggal Pesan</label>
                        <span><?= date('d M Y, H:i', strtotime($order['created_at'])) ?> WIB</span>
                    </div>
                    <div class="info-box">
                        <label>Nama Pelanggan</label>
                        <span><?= htmlspecialchars($order['customer_name']) ?></span>
                    </div>
                    <div class="info-box">
                        <label>Metode Pembayaran</label>
                        <span class="text-success" style="font-size: 1.1rem;"><i class="fa-solid fa-credit-card me-1"></i> <?= htmlspecialchars($order['payment_method'] ?: 'QRIS (BCA/E-Wallet)') ?></span>
                    </div>
                    <div class="info-box">
                        <label>Nomor WhatsApp</label>
                        <span><i class="fa-brands fa-whatsapp me-1 text-success"></i><?= htmlspecialchars($order['phone'] ?? '-') ?></span>
                    </div>
                    <div class="info-box" style="grid-column: span 2;">
                        <label>Alamat Pengiriman</label>
                        <span><i class="fa-solid fa-location-dot me-1 text-danger"></i><?= htmlspecialchars($order['address'] ?? '-') ?></span>
                        <?php if(!empty($order['google_maps_link'])): ?>
                            <div class="mt-2">
                                <a href="<?= $order['google_maps_link'] ?>" target="_blank" class="btn btn-sm btn-outline-danger py-0 px-2" style="font-size: .7rem; font-weight: 800; border-radius: 50px;">
                                    <i class="fa-solid fa-map-marked-alt me-1"></i>Lihat Lokasi di Google Maps
                                </a>
                             </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Items Table -->
                <table class="nota-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th style="text-align:center">Qty</th>
                            <th style="text-align:right">Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($details)): ?>
                            <?php foreach($details as $d): ?>
                            <tr>
                                <td><?= htmlspecialchars($d['product_name']) ?></td>
                                <td style="text-align:center"><?= $d['qty'] ?></td>
                                <td style="text-align:right">Rp <?= number_format($d['price'],0,',','.') ?></td>
                                <td>Rp <?= number_format($d['subtotal'],0,',','.') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" style="text-align:center;color:#aaa;padding:20px">Detail produk tidak tersedia</td></tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">TOTAL PEMBAYARAN</td>
                            <td>Rp <?= number_format($order['total_price'],0,',','.') ?></td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Payment Info (only if pending) -->
                <?php if($order['status'] == 'pending'): ?>
                <div class="payment-box">
                    <h6><i class="fa-solid fa-circle-exclamation me-2"></i>Segera Selesaikan Pembayaran</h6>
                    <div class="rek-row">
                        <span class="label">Transfer ke <?= ($order['payment_method'] == 'GoPay') ? 'E-Wallet' : 'Bank BCA' ?></span>
                        <div class="d-flex align-items-center gap-2">
                            <span class="rek-number" id="rek-no"><?= ($order['payment_method'] == 'GoPay') ? '0812-3456-7890' : '1234567890' ?></span>
                            <button class="copy-btn" onclick="copyText('rek-no')"><i class="fa-regular fa-copy"></i> Salin</button>
                        </div>
                    </div>
                    <div class="rek-row">
                        <span class="label">Atas Nama</span>
                        <span class="value">MariMacha Premium</span>
                    </div>
                    <div class="rek-row">
                        <span class="label">Jumlah Transfer</span>
                        <div class="d-flex align-items-center gap-2">
                            <span class="value" id="total-pay" style="color:var(--gm);font-size:1.15rem;font-weight:900">Rp <?= number_format($order['total_price'],0,',','.') ?></span>
                            <button class="copy-btn" style="background:var(--gl)" onclick="copyText('total-pay')"><i class="fa-regular fa-copy"></i> Salin</button>
                        </div>
                    </div>
                    <center>
                        <div id="payCountdown" class="pay-countdown">⏰ Bayar sebelum: <span>00:00:00</span></div>
                    </center>
                </div>

                <!-- WA Confirm -->
                <div class="wa-confirm-box">
                    <p>Pesanan Anda sudah kami terima! Kirim bukti transfer via WhatsApp agar admin bisa langsung memproses pesanan ✨</p>
                    <?php 
                        $invoice_url = base_url('shop/invoice/'.$order['id']);
                        $wa_msg = urlencode("Halo MariMacha! Saya ingin konfirmasi pembayaran untuk:\n\n📌 No Invoice: " . $order['invoice_no'] . "\n💰 Total: Rp " . number_format($order['total_price'],0,',','.') . "\n\n🌐 Lacak Pesanan Melalui Website:\n" . $invoice_url . "\n\nTerima kasih!");
                    ?>
                    <a href="https://wa.me/<?= $admin_phone ?>?text=<?= $wa_msg ?>" target="_blank" class="btn-wa-confirm">
                        <i class="fa-brands fa-whatsapp"></i> Konfirmasi via WhatsApp
                    </a>
                </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="nota-actions">
                    <?php if($order['status'] == 'pending'): ?>
                    <a href="<?= base_url('user/payment/'.$order['id']) ?>" class="btn-action btn-action-primary">
                        <i class="fa-solid fa-upload me-2"></i>Upload Bukti Bayar
                    </a>
                    <?php endif; ?>
                    <a href="<?= base_url('user') ?>" class="btn-action btn-action-outline">
                        <i class="fa-solid fa-list me-2"></i>Semua Pesanan
                    </a>
                    <button onclick="window.print()" class="btn-action btn-action-print">
                        <i class="fa-solid fa-print me-2"></i>Cetak Nota
                    </button>
                    <a href="<?= base_url('shop') ?>" class="btn-action btn-action-outline">
                        <i class="fa-solid fa-bag-shopping me-2"></i>Belanja Lagi
                    </a>
                </div>
            </div>

            <div class="nota-footer">
                <p>Terima kasih telah berbelanja di <strong>MariMacha</strong> 🌿 | Citra Raya, Tangerang, Banten</p>
                <p>WA: <?= substr($admin_phone,0,2) ?>-<?= substr($admin_phone,2,4) ?>-<?= substr($admin_phone,6,4) ?>-<?= substr($admin_phone,10) ?> | IG: @marimatcha_panongan</p>
            </div>
        </div>
    </div>

    <script>
    function copyText(id){
        var el = document.getElementById(id);
        var text = el.textContent.replace('Rp ', '').replace(/\./g, '').trim();
        navigator.clipboard.writeText(text).then(function(){
            var btn = el.nextElementSibling;
            var original = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Tersalin';
            setTimeout(function(){ btn.innerHTML = original; }, 2000);
        });
    }
    <?php if((($order['status']??'') == 'pending') || (($order['status']??'') == 'paid')):?>
    // Payment countdown (24 hours from created_at)
    var deadline=new Date('<?=date('Y-m-d\TH:i:s',strtotime($order['created_at']??'now')+86400)?>').getTime();
    function tick(){
        var diff=deadline-Date.now();
        if(diff<=0){document.getElementById('payCountdown')&&(document.getElementById('payCountdown').innerHTML='⚠️ Batas waktu habis!');return;}
        var h=Math.floor(diff/3600000),m=Math.floor((diff%3600000)/60000),s=Math.floor((diff%60000)/1000);
        var el=document.getElementById('payCountdown');
        if(el)el.innerHTML='⏰ Bayar sebelum: <span>'+(h<10?'0':'')+h+':'+(m<10?'0':'')+m+':'+(s<10?'0':'')+s+'</span>';
        setTimeout(tick,1000);
    }
    tick();
    <?php endif;?>

    // --- AUTO REDIRECT WA JIKA BARU CHECKOUT ---
    <?php if($this->session->flashdata('success')): ?>
    document.addEventListener('DOMContentLoaded', function() {
        // Rangkai rincian produk
        let itemsCode = "";
        <?php foreach($details as $index => $d): ?>
            itemsCode += "- <?= htmlspecialchars($d['product_name']) ?> (<?= $d['qty'] ?>x)\n";
        <?php endforeach; ?>

        // 🌐 Klik buka pesan WA dengan URL pelacakan web
        let invoiceUrl = "<?= base_url('shop/invoice/'.$order['id']) ?>";
        let msg = "Halo MariMacha! Saya ingin Konfirmasi Pesanan Baru:\n\n";
        msg += "📌 *No Invoice:* <?= $order['invoice_no'] ?>\n";
        msg += "👤 *Nama:* <?= htmlspecialchars($order['customer_name']) ?>\n";
        msg += "🛍️ *Pesanan:*\n" + itemsCode + "\n";
        msg += "💰 *Total Harga:* Rp <?= number_format($order['total_price'],0,',','.') ?>\n";
        msg += "📍 *Alamat:* <?= htmlspecialchars($order['address']) ?>\n";
        msg += "💳 *Metode:* <?= htmlspecialchars($order['payment_method']) ?>\n\n";
        msg += "🌐 *Lacak melalui website:*\n" + invoiceUrl + "\n\n";
        msg += "Mohon segera diproses ya, terima kasih! ✨";

        // Encode URI
        let encodedMsg = encodeURIComponent(msg);
        let waLink = "https://wa.me/<?= $admin_phone ?>?text=" + encodedMsg;

        // Beri delay 2 detik agar user sempat baca nota sebentar
        setTimeout(function() {
            window.open(waLink, '_blank');
        }, 2500);
    });
    <?php endif; ?>
    </script>
</body>
</html>
