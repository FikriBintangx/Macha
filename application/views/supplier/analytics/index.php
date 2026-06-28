<?php
$months_label = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
$total_req = array_sum($monthly_requests);
$total_sup = array_sum($monthly_supply);
$peak_req  = max($monthly_requests ?: [0]);
$peak_sup  = max($monthly_supply ?: [0]);
$peak_req_month = $months_label[array_search($peak_req, $monthly_requests) ?: 0];
$peak_sup_month = $months_label[array_search($peak_sup, $monthly_supply) ?: 0];
$supplier_name  = $this->session->userdata('supplier_name') ?? 'Supplier';
?>
<style>
@media print {
    body * { visibility: hidden; }
    #printArea, #printArea * { visibility: visible; }
    #printArea { position: fixed; top: 0; left: 0; width: 100%; padding: 24px; background: #fff; }
    .no-print { display: none !important; }
}
</style>

<!-- Page Header -->
<div style="margin-bottom:1.5rem; display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:12px;">
    <div>
        <h4 style="font-weight:800; color:#1a2e25; margin-bottom:0.2rem;">Analytics</h4>
        <p style="color:#64748b; font-size:0.875rem; margin:0;">Performa bulanan produk dan permintaan Anda.</p>
    </div>
    <button id="btnPrint" onclick="printReport()"
        style="display:inline-flex; align-items:center; gap:8px; background:#1B3B25; color:#fff; border:none; border-radius:12px; padding:10px 20px; font-size:0.875rem; font-weight:700; cursor:pointer; font-family:'Outfit',sans-serif; transition:background 0.2s;"
        onmouseover="this.style.background='#53725D'" onmouseout="this.style.background='#1B3B25'">
        <i class="fas fa-print"></i> Cetak Laporan
    </button>
</div>

<div class="row g-4" id="mainCharts">
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
                    <div style="font-size:0.75rem; color:#94a3b8; margin-top:2px;"><?= $peak_req_month ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:1.25rem; box-shadow:0 2px 4px rgba(0,0,0,0.05);">
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#94a3b8; font-weight:700; margin-bottom:0.5rem;">Peak Supply</div>
                    <div style="font-size:2rem; font-weight:800; color:#d97706;"><?= $peak_sup ?></div>
                    <div style="font-size:0.75rem; color:#94a3b8; margin-top:2px;"><?= $peak_sup_month ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ═══ PRINT AREA (hidden on screen, visible on print) ═══ -->
<div id="printArea" style="display:none;">
    <div style="font-family:'Outfit',Arial,sans-serif; color:#1a2e25; max-width:900px; margin:0 auto;">
        <!-- Header -->
        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:3px solid #1B3B25; padding-bottom:16px; margin-bottom:24px;">
            <div>
                <div style="font-size:1.5rem; font-weight:800; color:#1B3B25;">Laporan Analytics Supplier</div>
                <div style="font-size:0.85rem; color:#64748b; margin-top:4px;">
                    <?= htmlspecialchars($supplier_name) ?> &mdash; Tahun <?= date('Y') ?>
                </div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:1.2rem; font-weight:800; color:#1B3B25;">MariMatcha</div>
                <div style="font-size:0.75rem; color:#94a3b8;">Dicetak: <?= date('d M Y, H:i') ?></div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:28px;">
            <div style="background:#f8faf8; border:1px solid #e2e8f0; border-radius:12px; padding:14px; text-align:center;">
                <div style="font-size:0.65rem; text-transform:uppercase; letter-spacing:0.08em; color:#94a3b8; font-weight:700;">Total Requests</div>
                <div style="font-size:1.8rem; font-weight:800; color:#1B3B25;"><?= $total_req ?></div>
            </div>
            <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:12px; padding:14px; text-align:center;">
                <div style="font-size:0.65rem; text-transform:uppercase; letter-spacing:0.08em; color:#94a3b8; font-weight:700;">Total Supply</div>
                <div style="font-size:1.8rem; font-weight:800; color:#3b82f6;"><?= $total_sup ?></div>
            </div>
            <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; padding:14px; text-align:center;">
                <div style="font-size:0.65rem; text-transform:uppercase; letter-spacing:0.08em; color:#94a3b8; font-weight:700;">Peak Requests</div>
                <div style="font-size:1.8rem; font-weight:800; color:#8BAA7C;"><?= $peak_req ?></div>
                <div style="font-size:0.7rem; color:#94a3b8;"><?= $peak_req_month ?></div>
            </div>
            <div style="background:#fffbeb; border:1px solid #fde68a; border-radius:12px; padding:14px; text-align:center;">
                <div style="font-size:0.65rem; text-transform:uppercase; letter-spacing:0.08em; color:#94a3b8; font-weight:700;">Peak Supply</div>
                <div style="font-size:1.8rem; font-weight:800; color:#d97706;"><?= $peak_sup ?></div>
                <div style="font-size:0.7rem; color:#94a3b8;"><?= $peak_sup_month ?></div>
            </div>
        </div>

        <!-- Charts side by side -->
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:28px;">
            <div style="border:1px solid #e2e8f0; border-radius:12px; overflow:hidden;">
                <div style="background:#f8faf8; padding:10px 14px; border-bottom:1px solid #e2e8f0; font-weight:700; font-size:0.85rem; color:#1B3B25;">Monthly Requests</div>
                <div style="padding:12px;"><canvas id="printChartReq" height="160"></canvas></div>
            </div>
            <div style="border:1px solid #e2e8f0; border-radius:12px; overflow:hidden;">
                <div style="background:#f8faf8; padding:10px 14px; border-bottom:1px solid #e2e8f0; font-weight:700; font-size:0.85rem; color:#1B3B25;">Monthly Supply</div>
                <div style="padding:12px;"><canvas id="printChartSup" height="160"></canvas></div>
            </div>
        </div>

        <!-- Data Table -->
        <table style="width:100%; border-collapse:collapse; font-size:0.82rem;">
            <thead>
                <tr style="background:#1B3B25; color:#fff;">
                    <th style="padding:10px 14px; text-align:left; font-weight:700;">Bulan</th>
                    <th style="padding:10px 14px; text-align:center; font-weight:700;">Requests</th>
                    <th style="padding:10px 14px; text-align:center; font-weight:700;">Supply</th>
                    <th style="padding:10px 14px; text-align:center; font-weight:700;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($months_label as $i => $m): ?>
                <tr style="<?= $i % 2 === 0 ? 'background:#f8faf8;' : 'background:#fff;' ?>">
                    <td style="padding:9px 14px; font-weight:600; color:#1B3B25;"><?= $m ?></td>
                    <td style="padding:9px 14px; text-align:center;"><?= $monthly_requests[$i] ?? 0 ?></td>
                    <td style="padding:9px 14px; text-align:center;"><?= $monthly_supply[$i] ?? 0 ?></td>
                    <td style="padding:9px 14px; text-align:center; font-size:0.75rem; color:#94a3b8;">
                        <?php
                        $r = $monthly_requests[$i] ?? 0;
                        $s = $monthly_supply[$i] ?? 0;
                        if ($r == 0 && $s == 0) echo '-';
                        elseif ($r > 0 && $s == 0) echo '<span style="color:#d97706;">⚠ Belum dikirim</span>';
                        elseif ($s >= $r) echo '<span style="color:#16a34a;">✓ Terpenuhi</span>';
                        else echo '<span style="color:#dc2626;">✗ Kurang</span>';
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr style="background:#1B3B25; color:#fff; font-weight:800;">
                    <td style="padding:10px 14px;">TOTAL</td>
                    <td style="padding:10px 14px; text-align:center;"><?= $total_req ?></td>
                    <td style="padding:10px 14px; text-align:center;"><?= $total_sup ?></td>
                    <td style="padding:10px 14px;"></td>
                </tr>
            </tbody>
        </table>

        <!-- Footer -->
        <div style="margin-top:32px; border-top:1px solid #e2e8f0; padding-top:16px; display:flex; justify-content:space-between; font-size:0.72rem; color:#94a3b8;">
            <span>MariMatcha Supplier Portal &mdash; Laporan ini dibuat secara otomatis.</span>
            <span>Halaman 1 dari 1</span>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const months  = <?= json_encode($months_label) ?>;
const reqData = <?= json_encode(array_values($monthly_requests)) ?>;
const supData = <?= json_encode(array_values($monthly_supply)) ?>;

const chartCfg = (data, color, borderColor) => ({
    type: 'bar',
    data: {
        labels: months,
        datasets: [{ data, backgroundColor: color, borderColor, borderWidth: 2, borderRadius: 8 }]
    },
    options: {
        responsive: true,
        animation: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8', font: { family: 'Outfit' } } },
            x: { grid: { display: false }, ticks: { color: '#64748b', font: { family: 'Outfit' } } }
        }
    }
});

const mainReqChart = new Chart(document.getElementById('chartRequests'), chartCfg(reqData, 'rgba(139,170,124,0.25)', '#53725D'));
const mainSupChart = new Chart(document.getElementById('chartSupply'),    chartCfg(supData, 'rgba(59,130,246,0.18)', '#3b82f6'));

let printChartsReady = false;

function printReport() {
    // Show print area, render print charts once
    document.getElementById('printArea').style.display = 'block';

    if (!printChartsReady) {
        new Chart(document.getElementById('printChartReq'), chartCfg(reqData, 'rgba(139,170,124,0.3)', '#53725D'));
        new Chart(document.getElementById('printChartSup'), chartCfg(supData, 'rgba(59,130,246,0.22)', '#3b82f6'));
        printChartsReady = true;
    }

    // Small delay so canvas renders before print dialog
    setTimeout(() => {
        window.print();
        document.getElementById('printArea').style.display = 'none';
    }, 400);
}
</script>
