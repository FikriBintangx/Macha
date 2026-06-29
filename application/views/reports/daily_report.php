<?php
    $CI =& get_instance();
    $CI->load->model('M_settings');
    $shop_logo = $CI->M_settings->get_setting('shop_logo');
?>
<div class="row align-items-center mb-4 g-3 d-print-none">
    <div class="col-md-auto col-12 text-center text-md-start">
        <div class="d-flex align-items-center">
            <?php if(!empty($shop_logo)): ?>
                <img src="<?= base_url('uploads/'.$shop_logo) ?>" alt="Logo" style="height: 40px; margin-right: 15px; border-radius: 8px;">
            <?php endif; ?>
            <h4 class="text-success fw-bold m-0"><i class="bi bi-calendar-check-fill me-2"></i> Laporan Harian & Keseluruhan</h4>
        </div>
    </div>
    <div class="col-md-auto col-12 ms-md-auto text-center">
        <div class="d-flex gap-2 justify-content-center">
            <button onclick="exportToExcel()" class="btn btn-success btn-sm shadow-sm px-3 d-flex align-items-center">
                <i class="bi bi-file-earmark-spreadsheet me-2"></i> Excel
            </button>
            <button onclick="window.print()" class="btn btn-danger btn-sm shadow-sm px-3 d-flex align-items-center">
                <i class="bi bi-file-earmark-pdf me-2"></i> PDF / Cetak
            </button>
        </div>
    </div>
</div>

<?php
$uniqueCustomers = [];
if (!empty($reports)) {
    foreach ($reports as $r) {
        $cname = trim($r['customer_name']);
        if ($cname == '') $cname = 'Pelanggan Anonim';
        $uniqueCustomers[$cname] = $cname;
    }
    ksort($uniqueCustomers);
}
?>

<!-- Filter Card (d-print-none) -->
<div class="card border-0 shadow-sm mb-4 bg-white d-print-none" style="border-radius: 16px;">
    <div class="card-body p-3">
        <div class="row g-2">
            <div class="col-md-6 col-lg-5">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light text-secondary border-secondary-subtle px-2">Periode</span>
                    <input type="date" id="startDate" class="form-control border-secondary-subtle text-secondary fw-semibold">
                    <span class="input-group-text bg-light text-secondary border-secondary-subtle">Sd</span>
                    <input type="date" id="endDate" class="form-control border-secondary-subtle text-secondary fw-semibold">
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light text-secondary border-secondary-subtle"><i class="bi bi-person-lines-fill"></i></span>
                    <select id="userFilter" class="form-select border-secondary-subtle fw-semibold text-secondary">
                        <option value="">Semua Pelanggan</option>
                        <?php foreach($uniqueCustomers as $c): ?>
                            <option value="<?= htmlspecialchars($c) ?>"><?= htmlspecialchars($c) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light text-secondary border-end-0 border-secondary-subtle"><i class="bi bi-search"></i></span>
                    <input type="text" id="smartFilter" class="form-control border-start-0 ps-0 border-secondary-subtle fw-semibold" placeholder="Cari invoice, item, atau nama...">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Printable Header -->
<div class="d-none d-print-block mb-4">
    <div class="text-center pb-3 border-bottom">
        <h3 class="fw-bold text-dark m-0"><?= $this->M_settings->get_setting('shop_name') ?: 'MariMatcha' ?></h3>
        <p class="m-0 text-muted small">Laporan Penjualan Transaksi</p>
        <p class="m-0 small text-secondary fw-semibold mt-1">Periode: <span id="printPeriodText">-</span></p>
    </div>
</div>

<!-- Table Card -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
    <div class="card-body p-0">
        <div class="table-responsive responsive-card-table">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3 text-start">Waktu Transaksi</th>
                        <th>No. Invoice</th>
                        <th>Pelanggan</th>
                        <th>Items / Menu</th>
                        <th>Metode Bayar</th> 
                        <th>Status</th> 
                        <th class="text-end pe-3">Total Harga</th>
                        <th class="text-center d-print-none">Aksi</th>
                    </tr>
                </thead>
                <tbody id="reportTbody">
                    <?php 
                    $totalSemua = 0; 
                    if(!empty($reports)):
                        foreach($reports as $r):
                            $totalSemua += $r['total_price'];
                            $cname = trim($r['customer_name']);
                            if ($cname == '') $cname = 'Pelanggan Anonim';
                    ?>
                    <tr class="trx-row bg-white" data-customer="<?= htmlspecialchars($cname) ?>" data-date="<?= date('Y-m-d', strtotime($r['created_at'])) ?>">
                        <td class="small ps-3 text-start text-muted" data-label="WAKTU">
                            <i class="bi bi-clock me-1 opacity-50"></i> <?= date('d/m/Y • H:i', strtotime($r['created_at'])) ?>
                        </td>
                        <td class="align-middle" data-label="INVOICE">
                            <span class="badge bg-light text-dark border px-2 py-1"><i class="bi bi-receipt text-muted me-1"></i><?= $r['invoice_no'] ?></span>
                        </td>
                        <td class="align-middle" data-label="PELANGGAN">
                            <span class="text-secondary small customer-name-item"><i class="bi bi-person text-muted me-1"></i> <?= htmlspecialchars($cname) ?></span>
                        </td>
                        <td class="align-middle text-start" data-label="ITEMS">
                            <small class="text-muted"><?= htmlspecialchars($r['item_details'] ?? '-') ?></small>
                        </td>
                        <td class="align-middle" data-label="METODE">
                            <?php 
                            $is_online = (stripos($r['payment_method'], 'QRIS') !== false || stripos($r['payment_method'], 'Online') !== false);
                            ?>
                            <span class="badge <?= $is_online ? 'bg-primary' : 'bg-success' ?> bg-opacity-10 <?= $is_online ? 'text-primary' : 'text-success' ?> border-0 rounded-pill px-3 py-2">
                                <?= $is_online ? '<i class="bi bi-qr-code-scan me-1"></i>' : '<i class="bi bi-cash me-1"></i>' ?> <?= htmlspecialchars($r['payment_method']) ?>
                            </span>
                        </td>
                        <td class="align-middle" data-label="STATUS">
                            <?php 
                            $st = $r['status'];
                            $class = 'bg-secondary';
                            $text = ucfirst($st);
                            if($st == 'pending') { $class = 'bg-danger'; $text = 'Pending'; }
                            if($st == 'paid') { $class = 'bg-warning text-dark'; $text = 'Dibayar'; }
                            if($st == 'shipped') { $class = 'bg-primary'; $text = 'Dikirim'; }
                            if($st == 'completed') { $class = 'bg-success'; $text = 'Selesai'; }
                            ?>
                            <span class="badge <?= $class ?> bg-opacity-10 text-dark border rounded-pill px-2 py-1"><?= $text ?></span>
                        </td>
                        <td class="text-end fw-semibold pe-3 text-dark trx-price" data-label="TOTAL" data-price="<?= $r['total_price'] ?>">Rp <?= number_format($r['total_price'], 0, ',', '.') ?></td>
                        <td class="text-center align-middle d-print-none" data-label="AKSI">
                            <div class="d-flex gap-1 justify-content-center">
                                <button onclick="window.open('<?= site_url('report/print_struk/'.$r['invoice_no']) ?>', '_blank', 'width=340,height=600')" class="btn btn-sm btn-white border shadow-sm text-primary rounded-pill px-3 py-2">
                                    <i class="bi bi-printer me-1"></i> Cetak
                                </button>
                                <?php if(in_array($r['status'], ['pending', 'canceled'])): ?>
                                    <a href="<?= site_url('order/delete/'.$r['id']) ?>" 
                                       class="btn btn-sm btn-white border shadow-sm text-danger rounded-pill px-3 py-2"
                                       onclick="return confirm('⚠️ Hapus pesanan #<?= $r['invoice_no'] ?>?\n\nStok akan dikembalikan dan data akan dihapus permanen.')">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-white border shadow-sm text-muted rounded-pill px-3 py-2" disabled title="Pesanan sukses tidak bisa dihapus">
                                        <i class="bi bi-lock-fill"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr class="empty-row">
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                            Belum ada data transaksi.
                        </td>
                    </tr>
                    <?php endif; ?>
                    
                    <!-- Empty message hidden by default -->
                    <tr id="noResultsRow" style="display: none;">
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-search fs-1 d-block mb-3 opacity-50"></i>
                            Tidak ada transaksi yang cocok dengan filter.
                        </td>
                    </tr>
                </tbody>
                <tfoot class="table-dark">
                    <tr>
                        <td colspan="6" class="text-center fw-bold py-3">TOTAL OMZET KESELURUHAN</td>
                        <td class="text-end fw-bold pe-3 py-3" id="totalFilter">Rp <?= number_format($totalSemua, 0, ',', '.') ?></td>
                        <td class="d-print-none"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<style>
@media print {
    body {
        background: #white !important;
        background-image: none !important;
        color: #000 !important;
    }
    .main-content {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }
    .card {
        box-shadow: none !important;
        border: none !important;
    }
    .table th {
        background-color: #f8f9fa !important;
        color: #000 !important;
        border-bottom: 2px solid #000 !important;
    }
    .table td {
        border-bottom: 1px solid #ddd !important;
    }
    #totalFilter {
        color: #000 !important;
    }
}
</style>

<script>
    const smartFilter = document.getElementById('smartFilter');
    const startDate = document.getElementById('startDate');
    const endDate = document.getElementById('endDate');
    const userFilter = document.getElementById('userFilter');
    const noResultsRow = document.getElementById('noResultsRow');

    // Default to today's date for "Laporan Hari Ini"
    const todayStr = new Date().toISOString().split('T')[0];
    startDate.value = todayStr;
    endDate.value = todayStr;

    function applyFilters() {
        let keyword = smartFilter.value.toLowerCase();
        let startVal = startDate.value; 
        let endVal = endDate.value;     
        let selectedUser = userFilter.value;
        
        let startTimestamp = startVal ? new Date(startVal).setHours(0,0,0,0) : null;
        let endTimestamp = endVal ? new Date(endVal).setHours(23,59,59,999) : null;

        // Update print header text
        const printPeriodText = document.getElementById('printPeriodText');
        if (printPeriodText) {
            if (startVal && endVal) {
                printPeriodText.innerText = startVal.split('-').reverse().join('/') + ' s.d ' + endVal.split('-').reverse().join('/');
            } else if (startVal) {
                printPeriodText.innerText = 'Mulai ' + startVal.split('-').reverse().join('/');
            } else if (endVal) {
                printPeriodText.innerText = 'Sampai ' + endVal.split('-').reverse().join('/');
            } else {
                printPeriodText.innerText = 'Semua Periode';
            }
        }

        let totalKeseluruhan = 0;
        let visibleCount = 0;
        let rows = document.querySelectorAll('#reportTbody tr.trx-row');

        rows.forEach(row => {
            let rowText = row.innerText.toLowerCase();
            let matchesKeyword = rowText.includes(keyword);

            let matchesUser = true;
            if (selectedUser !== "") {
                let customerName = row.getAttribute('data-customer');
                if (customerName !== selectedUser) {
                    matchesUser = false;
                }
            }

            let rowDateStr = row.getAttribute('data-date');
            let rowTimestamp = new Date(rowDateStr).getTime();
            
            let matchesDate = true;
            if (startTimestamp && rowTimestamp < startTimestamp) matchesDate = false;
            if (endTimestamp && rowTimestamp > endTimestamp) matchesDate = false;

            if (matchesKeyword && matchesDate && matchesUser) {
                row.style.display = '';
                let priceClean = parseInt(row.querySelector('.trx-price').getAttribute('data-price')) || 0;
                totalKeseluruhan += priceClean;
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Toggle no results row
        if (visibleCount === 0 && rows.length > 0) {
            noResultsRow.style.display = '';
        } else {
            noResultsRow.style.display = 'none';
        }

        let totalElement = document.getElementById('totalFilter');
        if (totalElement) {
            totalElement.innerText = 'Rp ' + totalKeseluruhan.toLocaleString('id-ID');
        }
    }

    // Export to Excel CSV
    function exportToExcel() {
        let rows = document.querySelectorAll('#reportTbody tr.trx-row');
        let csvContent = "data:text/csv;charset=utf-8,";
        
        csvContent += "Waktu Transaksi,No Invoice,Nama Pelanggan,Items,Metode Bayar,Status,Total Harga (Rp)\n";

        rows.forEach(row => {
            if (row.style.display !== 'none') {
                let cols = row.querySelectorAll('td');
                if(cols.length >= 7) {
                    let date = cols[0].innerText.trim();
                    let inv = cols[1].innerText.trim();
                    let cust = cols[2].innerText.trim();
                    let items = cols[3].innerText.trim().replace(/"/g, '""');
                    let method = cols[4].innerText.trim();
                    let status = cols[5].innerText.trim();
                    let price = cols[6].innerText.trim().replace(/[^0-9]/g, ''); 
                    
                    csvContent += `"${date}","${inv}","${cust}","${items}","${method}","${status}","${price}"\n`;
                }
            }
        });

        let totalVal = document.getElementById('totalFilter') ? document.getElementById('totalFilter').innerText.replace(/[^0-9]/g, '') : "0";
        csvContent += `,,,,,TOTAL OMZET (Rp),${totalVal}\n`;

        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "Laporan_Penjualan_Harian_Macha.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    smartFilter.addEventListener('keyup', applyFilters);
    startDate.addEventListener('change', applyFilters);
    endDate.addEventListener('change', applyFilters);
    userFilter.addEventListener('change', applyFilters);

    // Initial filter run on page load
    applyFilters();
</script>
