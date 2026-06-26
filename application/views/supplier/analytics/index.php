<!-- Page Header -->
<div style="margin-bottom:1.5rem;">
    <h4 style="font-weight:800; color:#1a2e25; margin-bottom:0.2rem;">Analytics</h4>
    <p style="color:#64748b; font-size:0.875rem; margin:0;">Performa bulanan produk dan permintaan Anda.</p>
</div>

<div class="row g-4">
    <!-- Monthly Requests Chart -->
    <div class="col-lg-6">
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:18px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.07); overflow:hidden;">
            <div style="padding:1rem 1.25rem; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">
                <h6 style="font-weight:700; color:#1e293b; font-size:0.95rem; margin:0;">
                    <i class="fas fa-chart-bar" style="color:#8BAA7C; margin-right:6px;"></i> Monthly Requests
                </h6>
                <span style="background:rgba(139,170,124,0.12); color:#53725D; padding:3px 12px; border-radius:999px; font-size:0.72rem; font-weight:700;">12 Bulan Terakhir</span>
            </div>
            <div style="padding:1.25rem;">
                <canvas id="chartRequests" height="220"></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly Supply Chart -->
    <div class="col-lg-6">
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:18px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.07); overflow:hidden;">
            <div style="padding:1rem 1.25rem; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">
                <h6 style="font-weight:700; color:#1e293b; font-size:0.95rem; margin:0;">
                    <i class="fas fa-boxes" style="color:#3b82f6; margin-right:6px;"></i> Monthly Supply
                </h6>
                <span style="background:rgba(59,130,246,0.1); color:#1e40af; padding:3px 12px; border-radius:999px; font-size:0.72rem; font-weight:700;">12 Bulan Terakhir</span>
            </div>
            <div style="padding:1.25rem;">
                <canvas id="chartSupply" height="220"></canvas>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="col-12">
        <div class="row g-4">
            <?php
            $total_req = array_sum($monthly_requests);
            $total_sup = array_sum($monthly_supply);
            $peak_req  = max($monthly_requests);
            $peak_sup  = max($monthly_supply);
            $months    = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            ?>
            <div class="col-md-3">
                <div style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:1.25rem; box-shadow:0 2px 4px rgba(0,0,0,0.05);">
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#94a3b8; font-weight:700; margin-bottom:0.5rem;">Total Requests (Tahun ini)</div>
                    <div style="font-size:2rem; font-weight:800; color:#1B3B25;"><?= $total_req ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:1.25rem; box-shadow:0 2px 4px rgba(0,0,0,0.05);">
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#94a3b8; font-weight:700; margin-bottom:0.5rem;">Total Supply (Tahun ini)</div>
                    <div style="font-size:2rem; font-weight:800; color:#3b82f6;"><?= $total_sup ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:1.25rem; box-shadow:0 2px 4px rgba(0,0,0,0.05);">
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#94a3b8; font-weight:700; margin-bottom:0.5rem;">Peak Requests</div>
                    <div style="font-size:2rem; font-weight:800; color:#8BAA7C;"><?= $peak_req ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:1.25rem; box-shadow:0 2px 4px rgba(0,0,0,0.05);">
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#94a3b8; font-weight:700; margin-bottom:0.5rem;">Peak Supply</div>
                    <div style="font-size:2rem; font-weight:800; color:#d97706;"><?= $peak_sup ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const months = <?= json_encode($months) ?>;
const reqData = <?= json_encode(array_values($monthly_requests)) ?>;
const supData = <?= json_encode(array_values($monthly_supply)) ?>;

new Chart(document.getElementById('chartRequests'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'Requests',
            data: reqData,
            backgroundColor: 'rgba(139,170,124,0.25)',
            borderColor: '#53725D',
            borderWidth: 2,
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8', font: { family: 'Outfit' } } },
            x: { grid: { display: false }, ticks: { color: '#64748b', font: { family: 'Outfit' } } }
        }
    }
});

new Chart(document.getElementById('chartSupply'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'Supply',
            data: supData,
            backgroundColor: 'rgba(59,130,246,0.18)',
            borderColor: '#3b82f6',
            borderWidth: 2,
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8', font: { family: 'Outfit' } } },
            x: { grid: { display: false }, ticks: { color: '#64748b', font: { family: 'Outfit' } } }
        }
    }
});
</script>
