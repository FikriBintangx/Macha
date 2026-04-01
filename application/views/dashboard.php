<?php
// Hitung revenue hari ini & bulan ini untuk header stats
$today = date('Y-m-d');
$revenue_today = $this->db->where("DATE(created_at)", $today)->where('status !=', 'canceled')->select_sum('total_price')->get('sales')->row()->total_price ?? 0;
$revenue_month = $this->db->where("MONTH(created_at) = MONTH(NOW())")->where('status !=', 'canceled')->select_sum('total_price')->get('sales')->row()->total_price ?? 0;
$orders_pending = $this->db->where('status', 'pending')->count_all_results('sales');
$total_products = $this->M_product->get_all() ? count($this->M_product->get_all()) : 0;

// Data untuk tabel & widget
$this->db->select('sales.*, users.full_name as customer')->from('sales')->join('users', 'users.id = sales.user_id', 'left')->order_by('sales.created_at', 'DESC')->limit(10);
$recent_orders = $this->db->get()->result_array();

$this->db->where('stock <=', 5)->order_by('stock', 'ASC')->limit(5);
$low_stock_items = $this->db->get('products')->result_array();
?>

<!-- ─── HEADER STATS (Berjejer di Paling Atas) ─── -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="stat-card sc-green">
            <div class="sc-icon"><i class="bi bi-wallet2"></i></div>
            <div class="sc-label">Revenue Hari Ini</div>
            <div class="sc-num">Rp <?= number_format($revenue_today, 0, ',', '.') ?></div>
            <div class="sc-sub">Bulan ini: Rp <?= number_format($revenue_month/1000000, 1) ?>jt</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card sc-amber">
            <div class="sc-icon"><i class="bi bi-clock-history"></i></div>
            <div class="sc-label">Order Pending</div>
            <div class="sc-num"><?= $orders_pending ?></div>
            <div class="sc-sub">Butuh segera dikonfirmasi</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card sc-blue">
            <div class="sc-icon"><i class="bi bi-box-seam"></i></div>
            <div class="sc-label">Total Menu</div>
            <div class="sc-num"><?= $total_products ?></div>
            <div class="sc-sub">Menu aktif di katalog</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card sc-purple">
            <div class="sc-icon"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="sc-label">Order Hari Ini</div>
            <?php $count_today = $this->db->where("DATE(created_at)", $today)->count_all_results('sales'); ?>
            <div class="sc-num"><?= $count_today ?></div>
            <div class="sc-sub">Pesanan masuk sejak subuh</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- ─── LEFT: ORDER MONITORING ─── -->
    <div class="col-xl-8">
        <div class="cc h-100 shadow-sm border-0">
            <div class="cc-header">
                <span class="cc-title fs-5"><i class="bi bi-kanban me-2 text-success"></i>Trafik Order Terakhir</span>
                <a href="<?= current_url() ?>" class="btn btn-sm btn-light border"><i class="bi bi-arrow-clockwise"></i></a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>No. Order</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recent_orders)): foreach ($recent_orders as $o): 
                            $status_map = [
                                'pending'   => ['sb-pending',   'Dipesan'],
                                'paid'      => ['sb-paid',      'Dibayar'],
                                'shipped'   => ['sb-shipped',   'Dikirim'],
                                'completed' => ['sb-completed', 'Selesai'],
                                'canceled'  => ['sb-canceled',  'Batal'],
                            ];
                            $sm = $status_map[$o['status']] ?? ['sb-pending', ucfirst($o['status'])]; 
                        ?>
                        <tr>
                            <td>
                                <div class="fw-bold text-dark"><?= $o['invoice_no'] ?></div>
                                <div class="small text-muted"><?= date('H:i', strtotime($o['created_at'])) ?> WIB</div>
                            </td>
                            <td>
                                <div class="fw-semibold"><?= htmlspecialchars($o['customer'] ?? 'Guest') ?></div>
                                <div class="small text-muted"><?= $o['phone'] ?></div>
                            </td>
                            <td class="fw-bold text-success">Rp <?= number_format($o['total_price'], 0, ',', '.') ?></td>
                            <td><span class="sbadge <?= $sm[0] ?>"><?= $sm[1] ?></span></td>
                            <td>
                                <?php if($o['status'] == 'pending'): ?>
                                    <a href="<?= site_url('order/update_status/'.$o['id'].'/paid') ?>" class="btn btn-sm btn-outline-success"><i class="bi bi-check-lg"></i></a>
                                <?php elseif($o['status'] == 'paid'): ?>
                                    <a href="<?= site_url('order/update_status/'.$o['id'].'/shipped') ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-send"></i></a>
                                <?php else: ?>
                                    <i class="bi bi-check-all text-success fs-5"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada aktivitas transaksi...</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="cc-footer p-3 text-center border-top">
                <a href="<?= site_url('order') ?>" class="small text-success text-decoration-none fw-bold">Buka Semua Pesanan <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- ─── RIGHT: WIDGETS ─── -->
    <div class="col-xl-4">
        <div class="row g-4">
            <!-- Clock & Date -->
            <div class="col-12">
                <div class="clock-display shadow-sm">
                    <div class="clock-time" id="rt-clock"><?= date('H:i:s') ?></div>
                    <div class="clock-date" id="rt-date"><?= date('l, d F Y') ?></div>
                </div>
            </div>

            <!-- Dashboard Actions -->
            <div class="col-12">
                <div class="cc shadow-sm border-0">
                    <div class="cc-header"><span class="cc-title"><i class="bi bi-lightning-charge-fill me-2 text-warning"></i>Kendali Cepat</span></div>
                    <div class="p-3 d-grid gap-3">
                        <a href="<?= site_url('product/add') ?>" class="qa-btn qa-primary">
                            <div class="qa-icon"><i class="bi bi-plus-lg"></i></div>
                            Rilis Menu Baru
                        </a>
                        <a href="<?= site_url('sales') ?>" class="qa-btn qa-outline">
                            <div class="qa-icon" style="background:#e8f4ee"><i class="bi bi-calculator" style="color:#2d6a4f"></i></div>
                            Buka Layar Kasir
                        </a>
                        <a href="<?= site_url('report/daily') ?>" class="qa-btn qa-outline">
                            <div class="qa-icon" style="background:#fff7ed"><i class="bi bi-briefcase" style="color:#ea580c"></i></div>
                            Laporan Keuangan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Inventory Watch -->
            <div class="col-12">
                <div class="cc shadow-sm border-0">
                    <div class="cc-header">
                        <span class="cc-title"><i class="bi bi-shield-exclamation me-2 text-danger"></i>Inventory Watch</span>
                        <span class="badge bg-danger rounded-pill"><?= count($low_stock_items) ?> Menu</span>
                    </div>
                    <?php if (!empty($low_stock_items)): foreach ($low_stock_items as $ls): ?>
                    <div class="ls-item px-3 py-3">
                        <div class="ls-dot <?= $ls['stock'] == 0 ? 'dot-danger' : 'dot-warn' ?>"></div>
                        <div>
                            <div class="ls-name"><?= htmlspecialchars($ls['name']) ?></div>
                            <div class="small text-muted"><?= $ls['sku'] ?? 'No SKU' ?></div>
                        </div>
                        <div class="ls-stock <?= $ls['stock'] == 0 ? 'text-danger fw-bold' : '' ?>"><?= $ls['stock'] ?> porsi</div>
                    </div>
                    <?php endforeach; else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-hand-thumbs-up-fill text-success fs-2 d-block mb-2"></i>
                        <div class="small fw-bold">Inventory Aman Terkendali!</div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function rtClock() {
        const now = new Date();
        const pad = n => String(n).padStart(2,'0');
        const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        
        if(document.getElementById('rt-clock')) {
            document.getElementById('rt-clock').textContent = `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
        }
        if(document.getElementById('rt-date')) {
            document.getElementById('rt-date').textContent = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
        }
    }
    setInterval(rtClock, 1000);
    rtClock();
</script>
