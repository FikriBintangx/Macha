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
                        <th>Item Pesanan</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($reports)): ?>
                        <?php foreach($reports as $r): ?>
                        <tr>
                            <td><?= date('H:i', strtotime($r['created_at'])) ?> WIB</td>
                            <td><?= $r['invoice_no'] ?></td>
                            <td class="small"><?= htmlspecialchars($r['item_details'] ?? '-') ?></td>
                            <td class="fw-bold">Rp <?= number_format($r['total_price'], 0, ',', '.') ?></td>
                            <td>
                                <?php 
                                $st = $r['status'];
                                $class = 'bg-secondary';
                                $text = ucfirst($st);
                                if($st == 'pending') { $class = 'bg-danger'; $text = 'Pending'; }
                                if($st == 'paid') { $class = 'bg-warning text-dark'; $text = 'Dibayar'; }
                                if($st == 'shipped') { $class = 'bg-primary'; $text = 'Dikirim'; }
                                if($st == 'completed') { $class = 'bg-success'; $text = 'Selesai'; }
                                ?>
                                <span class="badge <?= $class ?>"><?= $text ?></span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button onclick="window.open('<?= site_url('report/print_struk/'.$r['invoice_no']) ?>', '_blank', 'width=340,height=600')" class="btn btn-sm btn-outline-primary px-2 py-1">
                                        <i class="bi bi-printer"></i>
                                    </button>
                                    <?php if(in_array($r['status'], ['pending', 'canceled'])): ?>
                                        <a href="<?= site_url('order/delete/'.$r['id']) ?>" 
                                           class="btn btn-sm btn-outline-danger px-2 py-1"
                                           onclick="return confirm('⚠️ Hapus pesanan?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
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
