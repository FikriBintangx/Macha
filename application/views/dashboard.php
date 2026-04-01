<?php
// Hitung revenue hari ini
$today = date('Y-m-d');
$this->db->where("DATE(created_at)", $today)->where('status !=', 'canceled');
$revenue_today = $this->db->select_sum('total_price')->get('sales')->row()->total_price ?? 0;

// Total revenue bulan ini
$this->db->where("MONTH(created_at) = MONTH(NOW())")->where('status !=', 'canceled');
$revenue_month = $this->db->select_sum('total_price')->get('sales')->row()->total_price ?? 0;

// Total pesanan pending
$orders_pending = $this->db->where('status', 'pending')->count_all_results('sales');

// Pesanan hari ini
$orders_today = $this->db->where("DATE(created_at)", $today)->count_all_results('sales');

// Low stock items
$this->db->where('stock <=', 5)->order_by('stock', 'ASC')->limit(8);
$low_stock_items = $this->db->get('products')->result_array();

// Pesanan terbaru
$this->db->select('sales.*, users.full_name as customer')
         ->from('sales')
         ->join('users', 'users.id = sales.user_id', 'left')
         ->order_by('sales.created_at', 'DESC')
         ->limit(8);
$recent_orders = $this->db->get()->result_array();
?>

<div class="row g-4 mb-4">
    <!-- PRIORITAS: PANTAUAN ORDER (Sesuai Permintaan User) -->
    <div class="col-12">
        <div class="cc border-success" style="border-top: 5px solid var(--green-main)!important;">
            <div class="cc-header bg-light">
                <span class="cc-title"><i class="bi bi-activity me-2 text-success"></i>Pantauan Order Real-Time</span>
                <div class="d-flex gap-2">
                    <span class="badge sb-pending d-flex align-items-center"><?= $orders_pending ?> Menunggu</span>
                    <a href="<?= current_url() ?>" class="btn btn-sm btn-outline-success"><i class="bi bi-arrow-clockwise"></i> Refresh</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Waktu</th>
                            <th>No. Order</th>
                            <th>Pelanggan</th>
                            <th>Metode</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-center">Aksi Cepat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recent_orders)): ?>
                            <?php foreach ($recent_orders as $o): ?>
                            <?php 
                                $status_map = [
                                    'pending'   => ['sb-pending',   'Menunggu'],
                                    'paid'      => ['sb-paid',      'Sudah Bayar'],
                                    'shipped'   => ['sb-shipped',   'Dikirim'],
                                    'completed' => ['sb-completed', 'Selesai'],
                                    'canceled'  => ['sb-canceled',  'Batal'],
                                ];
                                $sm = $status_map[$o['status']] ?? ['sb-pending', ucfirst($o['status'])]; 
                            ?>
                            <tr class="<?= $o['status'] == 'pending' ? 'bg-light-warning' : '' ?>">
                                <td class="text-muted small"><?= date('H:i', strtotime($o['created_at'])) ?></td>
                                <td><span class="fw-bold text-success"><?= $o['invoice_no'] ?></span></td>
                                <td>
                                    <div class="fw-bold"><?= htmlspecialchars($o['customer'] ?? 'Guest') ?></div>
                                    <div class="small text-muted"><?= $o['phone'] ?></div>
                                </td>
                                <td>
                                    <span class="badge <?= $o['payment_method'] == 'Cash' ? 'bg-info text-dark' : 'bg-danger' ?> opacity-75">
                                        <?= $o['payment_method'] ?>
                                    </span>
                                </td>
                                <td class="fw-bold text-success">Rp <?= number_format($o['total_price'], 0, ',', '.') ?></td>
                                <td><span class="sbadge <?= $sm[0] ?>"><?= $sm[1] ?></span></td>
                                <td class="text-center">
                                    <?php if($o['status'] != 'completed' && $o['status'] != 'canceled'): ?>
                                        <a href="<?= site_url('order/update_status/'.$o['id'].'/completed') ?>" class="btn btn-sm btn-success rounded-pill px-3 fw-bold shadow-sm">
                                            <i class="bi bi-check2-circle me-1"></i> Selesai
                                        </a>
                                    <?php else: ?>
                                        <i class="bi bi-check-all text-success fs-5" title="Sudah Selesai"></i>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center py-5">Belum ada order masuk hari ini.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="cc-footer p-2 text-center bg-light">
                <a href="<?= site_url('order') ?>" class="small text-success text-decoration-none fw-bold">Lihat Semua Riwayat Pesanan →</a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Stat Cards (Diperkecil) -->
    <div class="col-6 col-md-3">
        <div class="stat-card sc-green p-3">
            <div class="sc-label small">Revenue Hari Ini</div>
            <div class="sc-num fs-4">Rp <?= number_format($revenue_today, 0, ',', '.') ?></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card sc-amber p-3">
            <div class="sc-label small">Order Menunggu</div>
            <div class="sc-num fs-4"><?= $orders_pending ?> Order</div>
        </div>
    </div>
    <!-- ... -->
</div>

    <!-- Sidebar Kanan -->
    <div class="col-xl-4">
        <div class="row g-4 h-100 align-content-start">

            <!-- Realtime Clock -->
            <div class="col-12">
                <div class="clock-display">
                    <div class="clock-time" id="rt-clock"><?= date('H:i:s') ?></div>
                    <div class="clock-date" id="rt-date"><?= date('l, d F Y') ?></div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-12">
                <div class="cc">
                    <div class="cc-header"><span class="cc-title"><i class="bi bi-lightning-fill me-2 text-warning"></i>Aksi Cepat</span></div>
                    <div class="p-3 d-grid gap-2">
                        <a href="<?= site_url('product/add') ?>" class="qa-btn qa-primary">
                            <div class="qa-icon" style="background:rgba(255,255,255,.2)"><i class="bi bi-plus-lg text-white"></i></div>
                            Tambah Produk Baru
                        </a>
                        <a href="<?= site_url('order') ?>" class="qa-btn qa-outline">
                            <div class="qa-icon" style="background:#fef3c7"><i class="bi bi-bag-heart" style="color:#d97706"></i></div>
                            Kelola Pesanan <?php if($orders_pending > 0): ?><span class="nav-badge ms-auto"><?= $orders_pending ?></span><?php endif; ?>
                        </a>
                        <a href="<?= site_url('report/daily') ?>" class="qa-btn qa-outline">
                            <div class="qa-icon" style="background:#dbeafe"><i class="bi bi-calendar-check" style="color:#1d4ed8"></i></div>
                            Laporan Hari Ini
                        </a>
                        <a href="<?= site_url('settings') ?>" class="qa-btn qa-outline">
                            <div class="qa-icon" style="background:#f3f4f6"><i class="bi bi-gear" style="color:#6b7280"></i></div>
                            Pengaturan Toko
                        </a>
                    </div>
                </div>
            </div>

            <!-- Low Stock Warning -->
            <div class="col-12">
                <div class="cc">
                    <div class="cc-header">
                        <span class="cc-title"><i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i>Stok Menipis</span>
                        <a href="<?= site_url('product') ?>" class="text-success" style="font-size:.82rem;text-decoration:none;font-weight:600">Kelola →</a>
                    </div>
                    <?php if (!empty($low_stock_items)): ?>
                        <?php foreach ($low_stock_items as $ls): ?>
                        <div class="ls-item">
                            <div class="ls-dot <?= $ls['stock'] == 0 ? 'dot-danger' : 'dot-warn' ?>"></div>
                            <div>
                                <div class="ls-name"><?= htmlspecialchars($ls['name']) ?></div>
                                <div style="font-size:.75rem;color:#8aa898">SKU: <?= $ls['sku'] ?? '-' ?></div>
                            </div>
                            <div class="ls-stock <?= $ls['stock'] == 0 ? 'text-danger' : 'text-warning' ?>"><?= $ls['stock'] ?> pcs</div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-4 text-muted" style="font-size:.87rem">
                            <i class="bi bi-check-circle-fill text-success d-block fs-3 mb-2"></i>
                            Semua stok aman! 🎉
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Realtime clock
    function rtClock() {
        const now = new Date();
        const pad = n => String(n).padStart(2,'0');
        document.getElementById('rt-clock').textContent =
            `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
        const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        document.getElementById('rt-date').textContent =
            `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
    }
    setInterval(rtClock, 1000);
    rtClock();
</script>
