<div class="container py-4">
    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-auto col-12 text-center text-md-start">
            <h3 class="fw-bold text-success mb-0">Daftar Permintaan & Pengiriman Supply</h3>
            <p class="text-muted small mb-0">Kelola dan pantau status pengadaan bahan dari supplier.</p>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert" style="background:#dcfce7; color:#15803d;">
            <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert" style="background:#fee2e2; color:#b91c1c;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-body p-0">
            <div class="table-responsive responsive-card-table">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold">ID Req</th>
                            <th class="py-3 text-uppercase small fw-bold">Supplier</th>
                            <th class="py-3 text-uppercase small fw-bold">Bahan / Produk</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Jumlah</th>
                            <th class="py-3 text-uppercase small fw-bold">Catatan</th>
                            <th class="py-3 text-uppercase small fw-bold">Tanggal</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Status</th>
                            <th class="pe-4 py-3 text-uppercase small fw-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($requests)) : ?>
                            <?php foreach ($requests as $r) : ?>
                                <tr>
                                    <td class="ps-4" data-label="ID REQ">
                                        <span class="badge bg-light text-dark font-monospace border">#REQ-<?= str_pad($r['id'], 4, '0', STR_PAD_LEFT) ?></span>
                                    </td>
                                    <td data-label="SUPPLIER">
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($r['supplier_name'] ?? 'Unknown') ?></div>
                                    </td>
                                    <td data-label="BAHAN / PRODUK">
                                        <div class="fw-bold text-success"><?= htmlspecialchars($r['product_name']) ?></div>
                                    </td>
                                    <td class="text-center" data-label="JUMLAH">
                                        <span class="fw-bold"><?= $r['quantity'] ?></span>
                                    </td>
                                    <td data-label="CATATAN">
                                        <small class="text-muted"><?= !empty($r['notes']) ? htmlspecialchars($r['notes']) : '-' ?></small>
                                    </td>
                                    <td data-label="TANGGAL">
                                        <small><?= date('d M Y, H:i', strtotime($r['created_at'])) ?></small>
                                    </td>
                                    <td class="text-center" data-label="STATUS">
                                        <?php 
                                        $badge_class = 'bg-secondary';
                                        $status_label = ucfirst($r['status']);
                                        if ($r['status'] == 'pending') {
                                            $badge_class = 'bg-warning text-dark';
                                            $status_label = 'Menunggu';
                                        } elseif ($r['status'] == 'approved') {
                                            $badge_class = 'bg-info text-white';
                                            $status_label = 'Disetujui';
                                        } elseif ($r['status'] == 'rejected') {
                                            $badge_class = 'bg-danger text-white';
                                            $status_label = 'Ditolak';
                                        } elseif ($r['status'] == 'processing') {
                                            $badge_class = 'bg-primary text-white';
                                            $status_label = 'Diproses';
                                        } elseif ($r['status'] == 'shipped') {
                                            $badge_class = 'bg-info bg-opacity-20 text-info border border-info';
                                            $status_label = 'Dikirim';
                                        } elseif ($r['status'] == 'completed') {
                                            $badge_class = 'bg-success text-white';
                                            $status_label = 'Selesai';
                                        }
                                        ?>
                                        <span class="badge <?= $badge_class ?> rounded-pill px-3">
                                            <?= $status_label ?>
                                        </span>
                                        
                                        <?php if (!empty($r['tracking_number'])): ?>
                                            <div class="mt-1 small text-muted">
                                                <small><?= htmlspecialchars($r['courier'] ?? 'Kurir') ?>: <strong><?= htmlspecialchars($r['tracking_number']) ?></strong></small>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center pe-4" data-label="AKSI">
                                        <?php if ($r['status'] == 'shipped') : ?>
                                            <a href="<?= base_url('admin_suppliers/complete_supply_request/'.$r['id']) ?>" 
                                               class="btn btn-sm btn-success rounded-pill px-3 fw-bold"
                                               onclick="return confirm('Konfirmasi bahwa barang pasokan sudah sampai dan diterima dengan baik?')">
                                                <i class="bi bi-box-seam me-1"></i> Terima Pasokan
                                            </a>
                                        <?php elseif ($r['status'] == 'pending') : ?>
                                            <a href="<?= base_url('admin_suppliers/cancel_supply_request/'.$r['id']) ?>" 
                                               class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                               onclick="return confirm('Batalkan permintaan supply ini?')">
                                                Batalkan
                                            </a>
                                        <?php else : ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-chat-left-quote fs-1 d-block mb-2"></i>
                                    Belum ada permintaan supply yang dibuat.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
