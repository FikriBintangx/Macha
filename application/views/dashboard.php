<?php
// Hitung revenue hari ini & bulan ini untuk header stats
$today = date('Y-m-d');
$revenue_today = $this->db->where("DATE(created_at)", $today)->where('status !=', 'canceled')->select_sum('total_price')->get('sales')->row()->total_price ?? 0;
$revenue_month = $this->db->where("MONTH(created_at) = MONTH(NOW())")->where('status !=', 'canceled')->select_sum('total_price')->get('sales')->row()->total_price ?? 0;
$orders_pending = $this->db->where('status', 'pending')->count_all_results('sales');
$total_products = $this->M_product->get_all() ? count($this->M_product->get_all()) : 0;

// Data untuk chart 7 hari terakhir
$recent_7_days = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $count = $this->db->where("DATE(created_at)", $date)->count_all_results('sales');
    $revenue = $this->db->where("DATE(created_at)", $date)->where('status !=', 'canceled')->select_sum('total_price')->get('sales')->row()->total_price ?? 0;
    $recent_7_days[] = [
        'label'      => date('d M', strtotime($date)),
        'full_date'  => $date,
        'count'      => $count,
        'revenue'    => $revenue
    ];
}

// Data Stok (Data)
$this->db->where('stock <=', 5)->order_by('stock', 'ASC')->limit(10);
$low_stock_items = $this->db->get('products')->result_array();
?>

<!-- ─── HEADER STATS (Berjejer di Paling Atas) ─── -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card sc-green shadow-sm">
            <div class="sc-icon"><i class="bi bi-wallet2"></i></div>
            <div class="sc-label">Revenue Hari Ini</div>
            <div class="sc-num">Rp <?= number_format($revenue_today, 0, ',', '.') ?></div>
            <div class="sc-sub">Bulan ini: Rp <?= number_format($revenue_month/1000000, 1) ?>jt</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card sc-amber shadow-sm">
            <div class="sc-icon"><i class="bi bi-clock-history"></i></div>
            <div class="sc-label">Order Pending</div>
            <div class="sc-num"><?= $orders_pending ?></div>
            <div class="sc-sub">Butuh konfirmasi kasir</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card sc-blue shadow-sm">
            <div class="sc-icon"><i class="bi bi-box-seam"></i></div>
            <div class="sc-label">Katalog Menu</div>
            <div class="sc-num"><?= $total_products ?></div>
            <div class="sc-sub">Item aktif tersedia</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card sc-purple shadow-sm">
            <div class="sc-icon"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="sc-label">Order Hari Ini</div>
            <?php $count_today = $this->db->where("DATE(created_at)", $today)->count_all_results('sales'); ?>
            <div class="sc-num"><?= $count_today ?></div>
            <div class="sc-sub">Pesanan masuk hari ini</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- ─── DATA VISUALIZATION (FLOWCHART/CHART) ─── -->
    <div class="col-xl-8">
        <div class="cc shadow-sm border-0" style="min-height: 500px;">
            <div class="cc-header d-flex justify-content-between align-items-center bg-white border-0 p-4 pb-0">
                <div>
                    <h5 class="fw-bold text-success mb-0"><i class="bi bi-diagram-3-fill me-2"></i>Alur & Trafik Order</h5>
                    <p class="text-muted small mb-0">Visualisasi data pesanan sepekan terakhir.</p>
                </div>
                <div class="d-flex gap-2">
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10 px-3 py-2 rounded-pill">
                        Total: <?= array_sum(array_column($recent_7_days, 'count')) ?> Order
                    </span>
                </div>
            </div>
            <div class="p-4">
                <div style="height: 380px; position: relative;">
                    <canvas id="orderChart"></canvas>
                </div>
            </div>
            <div class="cc-footer p-4 pt-0 border-0 bg-white">
                <div class="row g-3">
                    <div class="col-4">
                        <div class="p-3 bg-light rounded-4 text-center">
                            <div class="small text-muted mb-1">Rata-rata</div>
                            <div class="fw-bold h5 mb-0 text-success"><?= number_format(array_sum(array_column($recent_7_days, 'count'))/7, 1) ?></div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 bg-light rounded-4 text-center">
                            <div class="small text-muted mb-1">Status</div>
                            <div class="fw-bold h5 mb-0 text-primary">Normal</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 bg-light rounded-4 text-center">
                            <div class="small text-muted mb-1">Peak Day</div>
                            <div class="fw-bold h5 mb-0 text-warning">Sabtu</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ─── SIDE DATA (INVENTORY/STOCK) ─── -->
    <div class="col-xl-4">
        <div class="cc shadow-sm border-0 h-100">
            <div class="cc-header bg-white border-0 p-4 pb-0">
                <h5 class="fw-bold text-success mb-0"><i class="bi bi-database-fill-check me-2"></i>Data Persediaan</h5>
                <p class="text-muted small mb-0">Status stok produk saat ini.</p>
            </div>
            <div class="p-4">
                <div class="clock-display mb-4 shadow-sm" style="background: linear-gradient(135deg, #1B3B25, #2d6a4f);">
                    <div class="clock-time" id="rt-clock" style="font-size: 1.5rem;"><?= date('H:i:s') ?></div>
                    <div class="clock-date" id="rt-date" style="font-size: 0.7rem;"><?= date('l, d F Y') ?></div>
                </div>

                <div class="inventory-list">
                    <?php if (!empty($low_stock_items)): foreach ($low_stock_items as $ls): ?>
                    <div class="d-flex align-items-center gap-3 mb-3 p-2 border-bottom border-light">
                        <div class="ls-dot <?= $ls['stock'] == 0 ? 'dot-danger' : 'dot-warn' ?>"></div>
                        <div class="flex-grow-1">
                            <div class="fw-bold small"><?= htmlspecialchars($ls['name']) ?></div>
                            <div class="text-muted" style="font-size: 0.7rem;"><?= $ls['sku'] ?: 'No SKU' ?></div>
                        </div>
                        <div class="fw-bold small <?= $ls['stock'] == 0 ? 'text-danger' : '' ?>"><?= $ls['stock'] ?> Porsi</div>
                    </div>
                    <?php endforeach; else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-check-circle-fill text-success fs-1 mb-2"></i>
                        <p class="small fw-bold mb-0">Semua Stok Aman</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('orderChart');
    
    const orderChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_column($recent_7_days, 'label')) ?>,
            datasets: [
            {
                label: 'Jumlah Pesanan',
                data: <?= json_encode(array_column($recent_7_days, 'count')) ?>,
                borderColor: '#1B3B25',
                backgroundColor: 'rgba(27, 59, 37, 0.05)',
                borderWidth: 4,
                fill: true,
                tension: 0.4,
                yAxisID: 'y',
                pointBackgroundColor: '#fff',
                pointBorderColor: '#1B3B25',
                pointBorderWidth: 3,
                pointRadius: 6
            },
            {
                label: 'Omset (Rp)',
                data: <?= json_encode(array_column($recent_7_days, 'revenue')) ?>,
                borderColor: '#fbbf24',
                backgroundColor: 'rgba(251, 191, 36, 0.05)',
                borderWidth: 4,
                fill: true,
                tension: 0.4,
                yAxisID: 'y1',
                pointBackgroundColor: '#fff',
                pointBorderColor: '#fbbf24',
                pointBorderWidth: 3,
                pointRadius: 6
            }]
        },
        options: {
            onClick: (event, elements) => {
                if (elements.length > 0) {
                    const index = elements[0].index;
                    const fullDates = <?= json_encode(array_column($recent_7_days, 'full_date')) ?>;
                    const selectedDate = fullDates[index];
                    window.location.href = `<?= site_url('order/history') ?>?date=${selectedDate}`;
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: { position: 'top', align: 'end', labels: { usePointStyle: true, font: { weight: 'bold' } } },
                tooltip: {
                    backgroundColor: '#1a2e25',
                    padding: 15,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    cornerRadius: 12,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            if (context.datasetIndex === 1) {
                                label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            } else {
                                label += context.parsed.y;
                            }
                            return label;
                        },
                        footer: function() {
                            return '(Klik untuk detail)';
                        }
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    beginAtZero: true,
                    ticks: { color: '#1B3B25', font: { weight: 'bold' } },
                    grid: { borderDash: [5, 5], color: 'rgba(0,0,0,0.05)' },
                    title: { display: true, text: 'Pesanan' }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    beginAtZero: true,
                    grid: { drawOnChartArea: false },
                    ticks: {
                        color: '#fbbf24',
                        font: { weight: 'bold' },
                        callback: function(value) {
                            return 'Rp ' + (value/1000) + 'k';
                        }
                    },
                    title: { display: true, text: 'Omset' }
                },
                x: {
                    ticks: { color: '#94a3b8' },
                    grid: { display: false }
                }
            },
            onHover: (event, elements) => {
                event.native.target.style.cursor = elements.length > 0 ? 'pointer' : 'default';
            }
        }
    });

    function rtClock() {
        const now = new Date();
        const pad = n => String(n).padStart(2,'0');
        const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
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

    // GSAP Dashboard Entrance
    document.addEventListener('DOMContentLoaded', () => {
        gsap.from(".stat-card", {
            y: 30,
            opacity: 0,
            duration: 0.8,
            stagger: 0.1,
            ease: "back.out(1.7)"
        });
        
        gsap.from(".cc", {
            y: 40,
            opacity: 0,
            duration: 1,
            delay: 0.4,
            ease: "power4.out"
        });
    });
</script>
