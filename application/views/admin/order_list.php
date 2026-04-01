<div class="row">
    <div class="col-12">
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-success"><i class="bi bi-box-seam me-2"></i>Kelola Pesanan Online</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>No. Invoice</th>
                                <th>Pelanggan</th>
                                <th>Pengiriman</th>
                                <th>Total Bayar</th>
                                <th>Bukti Transfer</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($orders)): ?>
                                <?php foreach($orders as $o): ?>
                                    <tr>
                                        <td><?= date('d/m/Y H:i', strtotime($o['created_at'])) ?></td>
                                        <td class="fw-bold"><?= $o['invoice_no'] ?></td>
                                        <td><?= $o['user_name'] ? $o['user_name'] : $o['customer_name'] ?></td>
                                        <td style="min-width:200px">
                                            <div style="font-size: .85rem;">
                                                <div class="mb-1">
                                                    <a href="https://wa.me/62<?= ltrim($o['phone'], '0') ?>" target="_blank" class="text-success fw-bold text-decoration-none">
                                                        <i class="bi bi-whatsapp"></i> <?= $o['phone'] ?>
                                                    </a>
                                                </div>
                                                <div class="text-muted mb-1" style="max-width: 250px; line-height: 1.3">
                                                    <i class="bi bi-geo-alt"></i> <?= $o['address'] ?>
                                                </div>
                                                <?php if(!empty($o['google_maps_link'])): ?>
                                                    <div>
                                                        <a href="<?= $o['google_maps_link'] ?>" target="_blank" class="btn btn-xs btn-outline-danger py-0 px-2 border-0" style="font-size: .75rem; font-weight: 700;">
                                                            <i class="bi bi-map"></i> Lihat di Maps
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="fw-bold text-success">Rp <?= number_format($o['total_price'],0,',','.') ?></td>
                                        <td>
                                            <?php if(!empty($o['payment_proof'])): ?>
                                                <a href="<?= base_url('uploads/payments/'.$o['payment_proof']) ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-image"></i> Lihat Bukti
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted fst-italic">Belum Upload</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php 
                                            // Badge mapping
                                            $class = 'bg-secondary';
                                            $text = ucfirst($o['status']);
                                            if($o['status'] == 'pending') { $class = 'bg-danger'; $text = 'Menunggu'; }
                                            if($o['status'] == 'paid') { $class = 'bg-warning text-dark'; $text = 'Sudah Bayar'; }
                                            if($o['status'] == 'shipped') { $class = 'bg-primary'; $text = 'Dikirim'; }
                                            if($o['status'] == 'completed') { $class = 'bg-success'; $text = 'Selesai'; }
                                            if($o['status'] == 'canceled') { $class = 'bg-dark'; $text = 'Batal'; }
                                            ?>
                                            <span class="badge <?= $class ?>"><?= $text ?></span>
                                        </td>
                                        <td>
                                            <!-- Dropdown Aksi -->
                                            <div class="dropdown">
                                              <button class="btn btn-sm btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Update Status
                                              </button>
                                              <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="<?= site_url('order/update_status/'.$o['id'].'/pending') ?>">Set Pending (Menunggu)</a></li>
                                                <li><a class="dropdown-item" href="<?= site_url('order/update_status/'.$o['id'].'/paid') ?>">Set Paid (Validasi Pembayaran)</a></li>
                                                <li><a class="dropdown-item" href="<?= site_url('order/update_status/'.$o['id'].'/shipped') ?>">Set Shipped (Dikirim)</a></li>
                                                <li><a class="dropdown-item" href="<?= site_url('order/update_status/'.$o['id'].'/completed') ?>">Set Completed (Selesai)</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="<?= site_url('order/update_status/'.$o['id'].'/canceled') ?>">Batalkan Pesanan</a></li>
                                              </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada pesanan online.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
