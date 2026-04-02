<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gd: #102416;
            --gm: #1B3B25;
            --gl: #53725D;
            --cream: #F5F5F0;
            --white: #ffffff;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background: var(--cream);
            color: var(--gd);
            padding: 40px 0;
        }
        .nota-box {
            background: var(--white);
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            max-width: 800px;
            margin: 0 auto;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
        }
        .nota-header {
            background: linear-gradient(135deg, var(--gd), var(--gm));
            color: #fff;
            padding: 40px;
            text-align: center;
            position: relative;
        }
        .nota-logo {
            width: 80px;
            height: 80px;
            background: #fff;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            padding: 10px;
        }
        .nota-logo img {
            max-width: 100%;
            height: auto;
        }
        .nota-body {
            padding: 40px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px dashed #eee;
        }
        .info-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: #8aa898;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        .info-value {
            font-weight: 600;
            font-size: 1rem;
        }
        .table-nota th {
            background: #fafcf9;
            color: var(--gl);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border-top: none;
        }
        .table-nota td {
            vertical-align: middle;
            padding: 15px 12px;
            border-color: #f0f4f0;
        }
        .total-row {
            background: #f8faf8;
            font-weight: 800;
            font-size: 1.1rem;
        }
        .pay-instructions {
            background: #f0faf4;
            border-radius: 16px;
            padding: 25px;
            margin-top: 30px;
            border: 2px dashed var(--gl);
        }
        .btn-print {
            background: var(--gd);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 700;
            transition: 0.3s;
        }
        .btn-print:hover {
            background: #000;
            transform: translateY(-2px);
            color: #fff;
        }
        .btn-back {
            color: var(--gl);
            text-decoration: none;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        @media print {
            body { background: #fff; padding: 0; }
            .nota-box { box-shadow: none; border: none; max-width: 100%; border-radius: 0; }
            .btn-actions, footer { display: none !important; }
            .pay-instructions { border: 1px solid #ddd; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="nota-box">
        <div class="nota-header">
            <div class="nota-logo">
                <?php if($shop_logo): ?>
                    <img src="<?= base_url('uploads/'.$shop_logo) ?>" alt="Logo">
                <?php else: ?>
                    <i class="fa-solid fa-leaf fa-2x text-success"></i>
                <?php endif; ?>
            </div>
            <h2 class="fw-bold mb-1">Nota Pesanan</h2>
            <p class="mb-0 opacity-75">Invoice: <?= $sales['invoice_no'] ?></p>
        </div>

        <div class="nota-body">
            <div class="info-grid">
                <div>
                    <div class="info-label">Dikirim Kepada</div>
                    <div class="info-value"><?= htmlspecialchars($sales['customer_name']) ?></div>
                    <div class="info-value small text-muted"><?= $sales['phone'] ?></div>
                    <div class="info-value small text-muted"><?= nl2br(htmlspecialchars($sales['address'])) ?></div>
                </div>
                <div class="text-end">
                    <div class="info-label">Tanggal Pesanan</div>
                    <div class="info-value"><?= date('d M Y, H:i', strtotime($sales['created_at'])) ?></div>
                    <div class="mt-2">
                        <div class="info-label">Metode Bayar</div>
                        <span class="badge bg-success rounded-pill"><?= $sales['payment_method'] ?></span>
                    </div>
                </div>
            </div>

            <table class="table table-nota mb-0">
                <thead>
                    <tr>
                        <th>Menu Pesanan</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Harga</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($details as $d): ?>
                    <tr>
                        <td>
                            <div class="fw-bold"><?= htmlspecialchars($d['product_name']) ?></div>
                            <?php if(!empty($d['item_notes'])): ?>
                                <div class="small text-muted italic">"<?= $d['item_notes'] ?>"</div>
                            <?php endif; ?>
                        </td>
                        <td class="text-center"><?= $d['qty'] ?></td>
                        <td class="text-end">Rp <?= number_format($d['price'], 0, ',', '.') ?></td>
                        <td class="text-end">Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="total-row">
                        <td colspan="3" class="text-end">Total Pembayaran</td>
                        <td class="text-end text-success">Rp <?= number_format($sales['total_price'], 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>

            <?php 
                $payment_desc = "";
                foreach($payment_methods as $pm) {
                    if($pm['method_name'] == $sales['payment_method']) {
                        $payment_desc = $pm['description'];
                        break;
                    }
                }
            ?>

            <?php if(!empty($payment_desc)): ?>
            <div class="pay-instructions">
                <h6 class="fw-bold"><i class="fa-solid fa-circle-info me-2"></i>Instruksi Pembayaran</h6>
                <div class="small text-secondary mb-0">
                    <?= $payment_desc ?>
                </div>
                <p class="small text-muted mt-2 mb-0">
                    *Harap simpan nota ini dan kirimkan bukti transfer melalui menu <strong>Akun Saya</strong> atau WhatsApp Admin.
                </p>
            </div>
            <?php endif; ?>

            <div class="mt-5 pt-4 border-top btn-actions d-flex justify-content-between align-items-center">
                <a href="<?= base_url('shop') ?>" class="btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Kembali Belanja
                </a>
                <div class="d-flex gap-2">
                    <button onclick="window.print()" class="btn-print">
                        <i class="fa-solid fa-print me-2"></i> Cetak Nota
                    </button>
                    <?php if($this->session->userdata('userid')): ?>
                    <a href="<?= base_url('user') ?>" class="btn btn-outline-success rounded-pill fw-bold px-4">
                        <i class="fa-solid fa-user me-2"></i> Akun Saya
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center mt-5">
        <p class="small text-muted"><?= $shop_address ?></p>
        <p class="small text-muted opacity-50">&copy; <?= date('Y') ?> MariMacha - Terimakasih telah berlangganan!</p>
    </footer>
</div>

</body>
</html>
