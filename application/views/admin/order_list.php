<div class="row">
    <div class="col-12">
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" style="border-radius: 12px;" role="alert">
                <i class="bi bi-check-circle-fill me-2 text-success"></i><span class="fw-medium"><?= $this->session->flashdata('success') ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm bg-white" style="border-radius: 16px;">
            <div class="card-header bg-white p-4 pb-2 border-bottom-0 rounded-top">
                <h5 class="mb-0 text-success fw-bold"><i class="bi bi-box-seam me-2"></i>Kelola Pesanan Online</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-secondary fw-semibold small px-4 py-3 border-0">TANGGAL</th>
                                <th class="text-secondary fw-semibold small py-3 border-0">INVOICE</th>
                                <th class="text-secondary fw-semibold small py-3 border-0">PELANGGAN</th>
                                <th class="text-secondary fw-semibold small py-3 border-0">PENGIRIMAN</th>
                                <th class="text-secondary fw-semibold small py-3 border-0">TOTAL BAYAR</th>
                                <th class="text-secondary fw-semibold small py-3 border-0">BUKTI TRANSFER</th>
                                <th class="text-secondary fw-semibold small py-3 text-center border-0">STATUS</th>
                                <th class="text-secondary fw-semibold small py-3 text-center border-0 pe-4">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            <?php if(!empty($orders)): ?>
                                <?php foreach($orders as $o): ?>
                                    <tr style="transition: all 0.2s;">
                                        <td class="px-4 py-3">
                                            <div class="fw-bold text-dark" style="font-size: 0.95rem;"><?= date('d M Y', strtotime($o['created_at'])) ?></div>
                                            <div class="text-muted small"><i class="bi bi-clock me-1 opacity-50"></i><?= date('H:i', strtotime($o['created_at'])) ?></div>
                                        </td>
                                        <td class="py-3">
                                            <span class="badge bg-light text-dark border px-2 py-1 shadow-sm"><i class="bi bi-receipt text-muted me-1"></i><?= $o['invoice_no'] ?></span>
                                        </td>
                                        <td class="py-3">
                                            <div class="text-dark fw-medium" style="font-size: 0.95rem;">
                                                <i class="bi bi-person text-muted me-1"></i><?= htmlspecialchars($o['user_name'] ? $o['user_name'] : $o['customer_name']) ?>
                                            </div>
                                        </td>
                                        <td class="py-3" style="min-width: 260px;">
                                            <div class="d-flex align-items-start gap-2">
                                                <div class="mt-1"><i class="bi bi-geo-alt-fill text-danger opacity-75"></i></div>
                                                <div>
                                                    <a href="https://wa.me/62<?= ltrim($o['phone'], '0') ?>" target="_blank" class="text-success fw-bold text-decoration-none d-block mb-1" style="font-size: 0.9rem;">
                                                        <i class="bi bi-whatsapp"></i> <?= htmlspecialchars($o['phone']) ?>
                                                    </a>
                                                    <div class="text-secondary small" style="line-height: 1.4;"><?= htmlspecialchars($o['address']) ?></div>
                                                    <?php if(!empty($o['google_maps_link'])): ?>
                                                        <a href="<?= $o['google_maps_link'] ?>" target="_blank" class="mt-2 d-inline-block text-primary text-decoration-none small fw-semibold bg-primary bg-opacity-10 px-2 py-1 rounded" style="transition: all 0.2s;">
                                                            <i class="bi bi-map me-1"></i> Buka di Maps
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-bold text-success text-nowrap py-3" style="font-size: 1.05rem;">
                                            Rp <?= number_format($o['total_price'],0,',','.') ?>
                                        </td>
                                        <td class="py-3">
                                            <?php if(!empty($o['payment_proof'])): ?>
                                                <a href="<?= base_url('uploads/payments/'.$o['payment_proof']) ?>" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3 shadow-sm fw-medium d-inline-flex align-items-center gap-1">
                                                    <i class="bi bi-image"></i> Lihat Bukti
                                                </a>
                                            <?php else: ?>
                                                <span class="badge bg-light text-secondary border px-2 py-1 shadow-sm">Belum Upload</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center py-3">
                                            <?php 
                                            $class = 'bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25';
                                            $text = ucfirst($o['status']);
                                            $icon = 'bi-circle';
                                            if($o['status'] == 'pending') { 
                                                $class = 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25'; 
                                                $text = 'Menunggu'; $icon = 'bi-clock-history'; 
                                            }
                                            if($o['status'] == 'paid') { 
                                                $class = 'bg-warning bg-opacity-10 text-warning-emphasis border border-warning border-opacity-50'; 
                                                $text = 'Sudah Bayar'; $icon = 'bi-check-circle'; 
                                            }
                                            if($o['status'] == 'shipped') { 
                                                $class = 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25'; 
                                                $text = 'Dikirim'; $icon = 'bi-truck'; 
                                            }
                                            if($o['status'] == 'completed') { 
                                                $class = 'bg-success bg-opacity-10 text-success border border-success border-opacity-25'; 
                                                $text = 'Selesai'; $icon = 'bi-check2-all'; 
                                            }
                                            if($o['status'] == 'canceled') { 
                                                $class = 'bg-dark bg-opacity-10 text-dark border border-dark border-opacity-25'; 
                                                $text = 'Batal'; $icon = 'bi-x-circle'; 
                                            }
                                            ?>
                                            <span class="badge <?= $class ?> rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-1 shadow-sm"><i class="bi <?= $icon ?>"></i> <?= $text ?></span>
                                        </td>
                                        <td class="pe-4 py-3 text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light border dropdown-toggle fw-medium px-3 rounded-pill shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-gear me-1"></i> Aksi
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius: 12px; font-size: 0.9rem;">
                                                    <li><h6 class="dropdown-header">Ubah Status Pesanan</h6></li>
                                                    <li><a class="dropdown-item py-2" href="<?= site_url('order/update_status/'.$o['id'].'/pending') ?>"><i class="bi bi-clock-history text-danger me-2"></i>Set Menunggu (Pending)</a></li>
                                                    <li><a class="dropdown-item py-2" href="<?= site_url('order/update_status/'.$o['id'].'/paid') ?>"><i class="bi bi-check-circle text-warning me-2"></i>Set Pembayaran Valid</a></li>
                                                    <li><a class="dropdown-item py-2" href="<?= site_url('order/update_status/'.$o['id'].'/shipped') ?>"><i class="bi bi-truck text-primary me-2"></i>Set Sedang Dikirim</a></li>
                                                    <li><a class="dropdown-item py-2" href="<?= site_url('order/update_status/'.$o['id'].'/completed') ?>"><i class="bi bi-check2-all text-success me-2"></i>Set Selesai</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger py-2 fw-medium" href="<?= site_url('order/update_status/'.$o['id'].'/canceled') ?>"><i class="bi bi-x-circle me-2"></i>Batalkan Pesanan</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                                        <p class="mb-0">Belum ada pesanan online.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
