<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        /* Pengaturan ukuran kertas kasir (thermal) */
        @page { size: auto;  margin: 0mm; }
        
        body { 
            font-family: 'Courier New', Courier, monospace; 
            width: 280px; /* Ukuran standar kertas thermal */
            margin: 0 auto; 
            padding: 10px;
            color: #000;
            font-size: 12px;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        
        hr { 
            border: 0;
            border-top: 1px dashed #000; 
            margin: 10px 0;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }

        .item-name {
            padding-top: 5px;
            display: block;
        }

        .item-detail {
            padding-bottom: 5px;
        }

        /* Menghilangkan header/footer browser saat print */
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print();">
    <div class="text-center">
        <h3 style="margin-bottom: 5px;">MACHA UMKM</h3>
        <p style="margin: 0;">Minuman Macha Paling Segar!</p>
        <p style="margin: 0;">Jl. Raya Macha No. 1, Kota Kamu</p>
    </div>

    <hr>

    <table style="line-height: 1.5;">
        <tr>
            <td>No. Inv</td>
            <td>: <?= $sales['invoice_no'] ?></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: <?= date('d/m/Y H:i', strtotime($sales['created_at'])) ?></td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td>: <?= $sales['cashier'] ?></td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td>: <?= $sales['customer_name'] ?></td>
        </tr>
    </table>

    <hr>

    <table>
        <?php foreach($details as $d): ?>
        <tr>
            <td colspan="2" class="item-name fw-bold"><?= strtoupper($d['product_name']) ?></td>
        </tr>
        <tr>
            <td class="item-detail"><?= $d['qty'] ?> x <?= number_format($d['price'], 0, ',', '.') ?></td>
            <td class="text-right item-detail">Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <hr>

    <table style="font-size: 14px;">
        <tr>
            <td class="fw-bold">GRAND TOTAL</td>
            <td class="text-right fw-bold">Rp <?= number_format($sales['total_price'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td style="font-size: 11px;">Metode Bayar</td>
            <td class="text-right" style="font-size: 11px;"><?= $sales['payment_method'] ?></td>
        </tr>
    </table>

    <hr>

    <div class="text-center">
        <p>-- TERIMA KASIH --</p>
        <p style="font-style: italic; font-size: 10px;">Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.</p>
        <p>Selamat Menikmati Macha Anda!</p>
    </div>

    <div class="no-print text-center" style="margin-top: 20px;">
        <button onclick="window.print()">Cetak Ulang</button>
        <button onclick="window.close()">Tutup Halaman</button>
    </div>
</body>
</html>
