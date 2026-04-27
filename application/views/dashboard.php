<?php
/**
 * Dashboard View - Fixed CSS Robustness
 */

$rev_month_str = $revenue_month >= 1000000 
    ? 'Rp ' . number_format($revenue_month / 1000000, 1, ',', '.') . 'jt' 
    : 'Rp ' . number_format($revenue_month, 0, ',', '.');
?>

<style>
    /* Premium Dashboard Styles */
    body {
        background-color: #f1f5f9 !important; /* Force a light grey background for cards to pop */
    }
    
    .glass-card {
        background-color: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 16px !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
        transition: all 0.3s ease !important;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .glass-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    }
    
    .metric-card {
        padding: 1.5rem;
        position: relative;
    }
    
    .metric-title {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .metric-value {
        font-size: 1.875rem;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.25;
        margin-bottom: 0.25rem;
    }
    
    .metric-subtitle {
        font-size: 0.875rem;
        color: #64748b;
    }
    
    .text-success-custom { color: #10b981 !important; }
    .text-primary-custom { color: #3b82f6 !important; }
    .text-warning-custom { color: #f59e0b !important; }
    .text-purple-custom { color: #8b5cf6 !important; }

    .section-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #ffffff;
    }
    
    .section-title {
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .list-item-premium {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .item-img-wrap {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background-color: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        border: 1px solid #e2e8f0;
    }
    
    .item-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
    
    .item-details { flex: 1; }
    .item-name { font-weight: 600; color: #1e293b; font-size: 0.875rem; }
    .item-meta { font-size: 0.75rem; color: #64748b; }
    
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    
    .chart-container {
        padding: 1rem;
        height: 350px;
    }
</style>

<div class="container-fluid py-4">
    <!-- Operational Status Alert -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="glass-card p-3 d-flex align-items-center justify-content-between border-start border-4 <?= $is_open ? 'border-success' : 'border-danger' ?>">
                <div class="d-flex align-items-center gap-3">
                    <div class="status-indicator <?= $is_open ? 'bg-success' : 'bg-danger' ?> shadow-sm" style="width:12px; height:12px; border-radius:50%; animation: pulse 2s infinite;"></div>
                    <div>
                        <h6 class="fw-bold m-0"><?= $is_open ? 'Toko Sedang Buka' : 'Toko Sedang Tutup' ?></h6>
                        <small class="text-muted">Mode: <strong id="current-shop-status"><?= strtoupper($shop_status) ?></strong></small>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button onclick="toggleShopStatus()" class="btn btn-sm btn-primary rounded-pill px-3">
                        <i class="bi bi-power me-1"></i> Toggle Manual
                    </button>
                    <a href="<?= site_url('settings') ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Pengaturan Jam</a>
                </div>
            </div>
        </div>
    </div>

    <script>
    function toggleShopStatus() {
        if(!confirm('Ubah status operasional toko sekarang?')) return;
        
        fetch('<?= site_url("dashboard/toggle_shop_status") ?>')
        .then(res => res.json())
        .then(res => {
            if(res.success) {
                location.reload();
            } else {
                alert('Gagal mengubah status.');
            }
        });
    }
    </script>

    <!-- Header Stats -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="glass-card metric-card">
                <div class="metric-title">Omset Hari Ini</div>
                <div class="metric-value text-success-custom">Rp <?= number_format($revenue_today, 0, ',', '.') ?></div>
                <div class="metric-subtitle">
                    Bulan ini: <span class="fw-bold text-success-custom"><?= $rev_month_str ?></span>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="glass-card metric-card">
                <div class="metric-title">Pesanan Hari Ini</div>
                <div class="metric-value text-primary-custom"><?= $orders_today ?></div>
                <div class="metric-subtitle">Total transaksi hari ini</div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="glass-card metric-card">
                <div class="metric-title">Menunggu Konfirmasi</div>
                <div class="metric-value text-warning-custom"><?= $orders_pending ?></div>
                <div class="metric-subtitle">Pesanan butuh tindakan</div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="glass-card metric-card">
                <div class="metric-title">Katalog Produk</div>
                <div class="metric-value text-purple-custom"><?= $total_products ?></div>
                <div class="metric-subtitle">Item menu aktif</div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Chart -->
        <div class="col-xl-8">
            <div class="glass-card">
                <div class="section-header">
                    <h5 class="section-title"><i class="bi bi-graph-up text-success-custom"></i> Tren Penjualan</h5>
                    <span class="badge bg-success bg-opacity-10 text-success-custom border border-success border-opacity-25 rounded-pill">7 Hari Terakhir</span>
                </div>
                <div class="chart-container">
                    <canvas id="mainDashboardChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Stock -->
        <div class="col-xl-4">
            <div class="glass-card">
                <div class="section-header">
                    <h5 class="section-title"><i class="bi bi-box text-warning-custom"></i> Stok Menipis</h5>
                </div>
                <div class="p-0">
                    <?php if (!empty($low_stock_items)): ?>
                        <?php foreach ($low_stock_items as $ls): ?>
                        <div class="list-item-premium">
                            <div class="item-img-wrap">
                                <?php if(!empty($ls['image'])): ?>
                                    <img src="<?= base_url('uploads/'.$ls['image']) ?>" alt="">
                                <?php else: ?>
                                    <i class="bi bi-cup-hot text-muted"></i>
                                <?php endif; ?>
                            </div>
                            <div class="item-details">
                                <div class="item-name"><?= htmlspecialchars($ls['name']) ?></div>
                                <div class="item-meta">Stok: <span class="text-danger fw-bold"><?= $ls['stock'] ?></span></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="p-5 text-center text-muted">
                            <i class="bi bi-check2-circle fs-1 text-success d-block mb-2"></i>
                            Stok aman terjaga
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Best Sellers -->
        <div class="col-xl-6">
            <div class="glass-card">
                <div class="section-header">
                    <h5 class="section-title"><i class="bi bi-trophy text-warning-custom"></i> Produk Terlaris</h5>
                </div>
                <div class="p-0">
                    <?php if (!empty($top_products)): ?>
                        <?php foreach ($top_products as $index => $tp): ?>
                        <div class="list-item-premium">
                            <div class="fw-bold text-muted" style="width: 20px;">#<?= $index + 1 ?></div>
                            <div class="item-img-wrap">
                                <?php if(!empty($tp['image'])): ?>
                                    <img src="<?= base_url('uploads/'.$tp['image']) ?>" alt="">
                                <?php else: ?>
                                    <i class="bi bi-cup-straw text-muted"></i>
                                <?php endif; ?>
                            </div>
                            <div class="item-details">
                                <div class="item-name"><?= htmlspecialchars($tp['name']) ?></div>
                                <div class="item-meta">Terjual <?= $tp['total_sold'] ?> porsi</div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="p-5 text-center text-muted">Belum ada penjualan</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="col-xl-6">
            <div class="glass-card">
                <div class="section-header">
                    <h5 class="section-title"><i class="bi bi-clock-history text-primary-custom"></i> Transaksi Terakhir</h5>
                </div>
                <div class="p-0">
                    <?php if (!empty($recent_transactions)): ?>
                        <?php foreach ($recent_transactions as $rt): ?>
                        <div class="list-item-premium">
                            <div class="item-details">
                                <div class="item-name"><?= htmlspecialchars($rt['customer_name'] ?: 'Guest') ?></div>
                                <div class="item-meta"><?= $rt['invoice_no'] ?> • <?= date('H:i', strtotime($rt['created_at'])) ?></div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-dark">Rp <?= number_format($rt['total_price'], 0, ',', '.') ?></div>
                                <div class="small text-muted"><?= strtoupper($rt['status']) ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="p-5 text-center text-muted">Belum ada transaksi</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('mainDashboardChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_column($recent_7_days, 'label')) ?>,
                datasets: [{
                    label: 'Omset',
                    data: <?= json_encode(array_column($recent_7_days, 'revenue')) ?>,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.05)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }, {
                    label: 'Pesanan',
                    data: <?= json_encode(array_column($recent_7_days, 'count')) ?>,
                    borderColor: '#3b82f6',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
});
</script>
