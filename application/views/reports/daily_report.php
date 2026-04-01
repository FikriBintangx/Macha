<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-success">Laporan Harian Macha</h3>
            <p class="text-muted small">Menampilkan data transaksi tanggal: <strong><?= $date ?></strong></p>
        </div>
        <a href="<?= site_url('dashboard') ?>" class="btn btn-light rounded-pill"> Kembali ke Dashboard</a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Waktu</th>
                        <th>No. Nota</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($reports)): ?>
                        <?php foreach($reports as $r): ?>
                        <tr>
                            <td><?= date('H:i', strtotime($r['created_at'])) ?> WIB</td>
                            <td><?= $r['invoice_no'] ?></td>
                            <td class="fw-bold">Rp <?= number_format($r['total_price'], 0, ',', '.') ?></td>
                            <td><span class="badge bg-success">Selesai</span></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted small italic">
                                Belum ada transaksi yang tercatat untuk hari ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
