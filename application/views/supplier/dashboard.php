<style>
    /* Supplier Dashboard - matches admin panel style */
    .s-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -1px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .s-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(27,59,37,0.1);
    }
    .s-metric-label {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 0.4rem;
    }
    .s-metric-value {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 0.3rem;
    }
    .s-metric-sub {
        font-size: 0.82rem;
        color: #94a3b8;
    }
    .s-metric-link {
        font-size: 0.78rem;
        font-weight: 700;
        color: #8BAA7C;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 0.75rem;
        transition: gap 0.2s;
    }
    .s-metric-link:hover { gap: 8px; color: #53725D; }
    .color-green  { color: #1B3B25; }
    .color-matcha { color: #8BAA7C; }
    .color-slate  { color: #3b82f6; }
    .color-amber  { color: #d97706; }
    .s-icon-wrap {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
    }
    .icon-green  { background: rgba(27,59,37,0.08);  color: #1B3B25; }
    .icon-matcha { background: rgba(139,170,124,0.15); color: #53725D; }
    .icon-slate  { background: rgba(59,130,246,0.1);  color: #3b82f6; }
    .icon-amber  { background: rgba(217,119,6,0.1);   color: #d97706; }
    .s-table th {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #94a3b8;
        font-weight: 700;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .s-table td {
        padding: 0.85rem 1rem;
        font-size: 0.875rem;
        color: #1e293b;
        border-bottom: 1px solid #f8fafc;
        vertical-align: middle;
    }
    .s-table tr:last-child td { border-bottom: none; }
    .s-table tr:hover td { background: #f8faf8; }
    .s-badge {
        display: inline-block;
        padding: 0.2rem 0.65rem;
        border-radius: 9999px;
        font-size: 0.7rem;
        font-weight: 700;
    }
    .badge-pending    { background: #fef9c3; color: #92400e; }
    .badge-approved   { background: #dcfce7; color: #166534; }
    .badge-rejected   { background: #fee2e2; color: #991b1b; }
    .badge-processing { background: #dbeafe; color: #1e40af; }
    .badge-shipped    { background: #ede9fe; color: #5b21b6; }
    .badge-completed  { background: #d1fae5; color: #065f46; }
    .badge-default    { background: #f1f5f9; color: #64748b; }
    .stock-dot {
        width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0;
    }
    .dot-ok  { background: #8BAA7C; }
    .dot-low { background: #d97706; }
    .dot-out { background: #dc2626; }
    .stock-chip {
        font-size: 0.72rem; font-weight: 700;
        padding: 0.2rem 0.6rem; border-radius: 999px;
    }
    .chip-low { background: #fef9c3; color: #92400e; }
    .chip-out { background: #fee2e2; color: #991b1b; }
    .s-section-head {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex; justify-content: space-between; align-items: center;
    }
    .s-section-title { font-weight: 700; color: #1e293b; font-size: 0.95rem; margin: 0; }
    .s-view-all {
        font-size: 0.78rem; font-weight: 700;
        color: #8BAA7C; text-decoration: none;
        display: inline-flex; align-items: center; gap: 4px;
        transition: gap 0.2s;
    }
    .s-view-all:hover { gap: 8px; color: #53725D; }
</style>

<!-- Page Header -->
<div style="margin-bottom: 1.5rem;">
    <h4 style="font-weight: 800; color: #1a2e25; margin-bottom: 0.25rem;">
        Selamat Datang, <?= htmlspecialchars($this->session->userdata('supplier_name') ?? 'Supplier') ?>!
    </h4>
    <p style="color: #64748b; font-size: 0.875rem; margin: 0;">
        Pantau performa, kelola produk, dan tinjau permintaan pengiriman barang.
    </p>
</div>

<!-- Stat Cards -->
<div class="row g-4 mb-4">
    <!-- Total Products -->
    <div class="col-xl-3 col-md-6">
        <div class="s-card" style="padding: 1.25rem;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
                <div class="s-icon-wrap icon-green"><i class="fas fa-box"></i></div>
                <span class="s-badge" style="background: rgba(27,59,37,0.08); color:#1B3B25;">Katalog</span>
            </div>
            <div class="s-metric-label">Total Products</div>
            <div class="s-metric-value color-green"><?= $stats['total_products'] ?></div>
            <div class="s-metric-sub">Produk terdaftar</div>
            <a href="<?= base_url('supplier/products') ?>" class="s-metric-link">Lihat Detail <i class="fas fa-arrow-right" style="font-size:0.65rem;"></i></a>
        </div>
    </div>

    <!-- Pending Requests -->
    <div class="col-xl-3 col-md-6">
        <div class="s-card" style="padding: 1.25rem;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
                <div class="s-icon-wrap icon-amber"><i class="fas fa-clock"></i></div>
                <span class="s-badge badge-pending">Menunggu</span>
            </div>
            <div class="s-metric-label">Pending Requests</div>
            <div class="s-metric-value color-amber"><?= $stats['pending_requests'] ?></div>
            <div class="s-metric-sub">Permintaan menunggu</div>
            <a href="<?= base_url('supplier/requests') ?>" class="s-metric-link">Lihat Detail <i class="fas fa-arrow-right" style="font-size:0.65rem;"></i></a>
        </div>
    </div>

    <!-- Approved Requests -->
    <div class="col-xl-3 col-md-6">
        <div class="s-card" style="padding: 1.25rem;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
                <div class="s-icon-wrap icon-matcha"><i class="fas fa-check-circle"></i></div>
                <span class="s-badge badge-approved">Disetujui</span>
            </div>
            <div class="s-metric-label">Approved Requests</div>
            <div class="s-metric-value color-matcha"><?= $stats['approved_requests'] ?></div>
            <div class="s-metric-sub">Permintaan disetujui</div>
            <a href="<?= base_url('supplier/requests') ?>" class="s-metric-link">Lihat Detail <i class="fas fa-arrow-right" style="font-size:0.65rem;"></i></a>
        </div>
    </div>

    <!-- Total Shipments -->
    <div class="col-xl-3 col-md-6">
        <div class="s-card" style="padding: 1.25rem;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
                <div class="s-icon-wrap icon-slate"><i class="fas fa-truck"></i></div>
                <span class="s-badge" style="background:#dbeafe; color:#1e40af;">Pengiriman</span>
            </div>
            <div class="s-metric-label">Total Shipments</div>
            <div class="s-metric-value color-slate"><?= $stats['total_shipments'] ?></div>
            <div class="s-metric-sub">Total pengiriman</div>
            <a href="<?= base_url('supplier/shipments') ?>" class="s-metric-link">Lihat Detail <i class="fas fa-arrow-right" style="font-size:0.65rem;"></i></a>
        </div>
    </div>
</div>

<!-- Bottom Section -->
<div class="row g-4">
    <!-- Recent Requests Table -->
    <div class="col-lg-8">
        <div class="s-card">
            <div class="s-section-head">
                <h6 class="s-section-title"><i class="fas fa-list-alt" style="color:#8BAA7C; margin-right:6px;"></i> Recent Requests</h6>
                <a href="<?= base_url('supplier/requests') ?>" class="s-view-all">View All <i class="fas fa-arrow-right" style="font-size:0.65rem;"></i></a>
            </div>
            <div style="overflow-x: auto;">
                <table class="s-table w-100" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Date</th>
                            <th style="text-align:right;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recent_requests)): ?>
                        <tr>
                            <td colspan="4" style="text-align:center; padding:2rem; color:#94a3b8;">
                                <i class="fas fa-inbox" style="font-size:1.5rem; margin-bottom:0.5rem; display:block; opacity:0.4;"></i>
                                Belum ada permintaan
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($recent_requests as $req): ?>
                        <?php
                            $badgeClass = [
                                'pending'    => 'badge-pending',
                                'approved'   => 'badge-approved',
                                'rejected'   => 'badge-rejected',
                                'processing' => 'badge-processing',
                                'shipped'    => 'badge-shipped',
                                'completed'  => 'badge-completed',
                            ][$req['status']] ?? 'badge-default';
                        ?>
                        <tr>
                            <td style="font-weight:600;"><?= htmlspecialchars($req['product_name']) ?></td>
                            <td style="font-weight:700; color:#1B3B25;"><?= $req['quantity'] ?></td>
                            <td style="color:#94a3b8; font-size:0.8rem;"><?= date('M d, Y', strtotime($req['created_at'])) ?></td>
                            <td style="text-align:right;"><span class="s-badge <?= $badgeClass ?>"><?= ucfirst($req['status']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Stock Warning -->
    <div class="col-lg-4">
        <div class="s-card" style="height: 100%;">
            <div class="s-section-head">
                <h6 class="s-section-title"><i class="fas fa-exclamation-triangle" style="color:#d97706; margin-right:6px;"></i> Stok Menipis</h6>
            </div>
            <div style="padding: 0.5rem 0;">
                <?php 
                $low_stock = array_filter($products, function($p) { return $p['stock'] < 10; });
                if (empty($low_stock)): ?>
                <div style="text-align:center; padding: 2rem; color:#94a3b8;">
                    <i class="fas fa-check-circle" style="font-size:1.5rem; color:#8BAA7C; margin-bottom:0.5rem; display:block;"></i>
                    Semua stok mencukupi
                </div>
                <?php else: ?>
                <?php foreach (array_slice($low_stock, 0, 6) as $p): ?>
                <div style="display:flex; align-items:center; justify-content:space-between; padding:0.75rem 1.25rem; border-bottom:1px solid #f8fafc;">
                    <div style="display:flex; align-items:center; gap:0.65rem;">
                        <div class="stock-dot <?= $p['stock'] == 0 ? 'dot-out' : 'dot-low' ?>"></div>
                        <span style="font-weight:600; font-size:0.85rem; color:#1e293b;"><?= htmlspecialchars($p['product_name']) ?></span>
                    </div>
                    <span class="stock-chip <?= $p['stock'] == 0 ? 'chip-out' : 'chip-low' ?>">
                        Stok: <?= $p['stock'] ?>
                    </span>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
