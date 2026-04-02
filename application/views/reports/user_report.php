<div class="row align-items-center mb-4 g-3">
    <div class="col-md-auto col-12 text-center text-md-start">
        <h4 class="text-success fw-bold m-0"><i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan Penjualan</h4>
    </div>
    <div class="col-md-auto col-12 ms-md-auto text-center">
        <div class="d-flex gap-2 justify-content-center">
            <button onclick="exportToExcel()" class="btn btn-success btn-sm shadow-sm px-3 d-flex align-items-center">
                <i class="bi bi-file-earmark-spreadsheet me-2"></i> Excel
            </button>
            <button onclick="window.print()" class="btn btn-danger btn-sm shadow-sm px-3 d-flex align-items-center">
                <i class="bi bi-file-earmark-pdf me-2"></i> PDF
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
<div class="card border-0 shadow-sm mb-4 bg-white" style="border-radius: 16px;">
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
                    <input type="text" id="smartFilter" class="form-control border-start-0 ps-0 border-secondary-subtle fw-semibold" placeholder="Invoice atau nama...">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
    <div class="card-body p-0">
        <div class="table-responsive responsive-card-table">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Waktu Transaksi</th>
                        <th>No. Invoice</th>
                        <th>Nama Pelanggan</th>
                        <th>Metode Bayar</th> 
                        <th class="text-end">Total Harga</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="reportTbody">
                    <?php 
                    $totalSemua = 0; 
                    if(!empty($reports)):
                        // Kelompokkan berdasar nama pelanggan
                        $groupedReports = [];
                        foreach($reports as $r) {
                            $cname = trim($r['customer_name']);
                            if($cname == '') $cname = 'Pelanggan Anonim';
                            $groupedReports[$cname][] = $r;
                        }

                        $gId = 0;
                        foreach($groupedReports as $cname => $transactions):
                            $gId++;
                            $groupTotal = array_sum(array_column($transactions, 'total_price'));
                            $totalSemua += $groupTotal;
                    ?>
                    <!-- Baris Header Grup -->
                    <tr class="group-header cursor-pointer collapsed-group" style="background-color: #f8fbf8; cursor: pointer; border-left: 4px solid #198754;" data-group-id="<?= $gId ?>">
                        <td colspan="4" class="py-3 border-bottom-0">
                            <i class="bi bi-chevron-down me-2 toggle-icon d-inline-block text-success fw-bold" style="transition: transform 0.2s; transform: rotate(-90deg);"></i>
                            <strong class="text-dark fs-6 customer-group-name"><?= htmlspecialchars($cname) ?></strong> 
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill ms-2 px-2 trx-count"><?= count($transactions) ?> trx</span>
                        </td>
                        <td class="text-end fw-bold text-success group-total py-3 align-middle border-bottom-0 fs-6" data-original-total="<?= $groupTotal ?>">Rp <?= number_format($groupTotal, 0, ',', '.') ?></td>
                        <td class="py-3 border-bottom-0 text-center text-muted"><i class="bi bi-folder2"></i></td>
                    </tr>
                    
                    <!-- Baris Isi Transaksi Detail -->
                    <?php foreach($transactions as $r): ?>
                    <tr class="trx-row group-child-<?= $gId ?> bg-white" data-group-id="<?= $gId ?>" style="display: none;">
                        <td class="small ps-md-5 align-middle text-muted" data-label="WAKTU">
                            <i class="bi bi-clock me-1 opacity-50"></i> <?= date('d/m/Y • H:i', strtotime($r['created_at'])) ?>
                        </td>
                        <td class="align-middle" data-label="INVOICE">
                            <span class="badge bg-light text-dark border px-2 py-1"><i class="bi bi-receipt text-muted me-1"></i><?= $r['invoice_no'] ?></span>
                        </td>
                        <td class="align-middle" data-label="PELANGGAN">
                            <span class="text-secondary small customer-name-item"><i class="bi bi-person text-muted me-1"></i> <?= htmlspecialchars($r['customer_name'] ?: 'Pelanggan Anonim') ?></span>
                        </td>
                        <td class="align-middle" data-label="METODE">
                            <span class="badge <?= $r['payment_method'] == 'QRIS' ? 'bg-primary' : 'bg-success' ?> bg-opacity-10 <?= $r['payment_method'] == 'QRIS' ? 'text-primary' : 'text-success' ?> border-0 rounded-pill px-3 py-2">
                                <?= $r['payment_method'] == 'QRIS' ? '<i class="bi bi-qr-code-scan me-1"></i>' : '<i class="bi bi-cash me-1"></i>' ?> <?= $r['payment_method'] ?>
                            </span>
                        </td>
                        <td class="text-end fw-semibold align-middle text-dark trx-price" data-label="TOTAL" data-price="<?= $r['total_price'] ?>">Rp <?= number_format($r['total_price'], 0, ',', '.') ?></td>
                        <td class="text-center align-middle" data-label="AKSI">
                            <button onclick="window.open('<?= site_url('report/print_struk/'.$r['invoice_no']) ?>', '_blank', 'width=340,height=600')" class="btn btn-sm btn-white border shadow-sm text-primary rounded-pill px-4 py-2">
                                <i class="bi bi-printer me-1"></i> Cetak Struk
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5 cards-empty">
                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                            Belum ada data transaksi.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="table-dark d-none d-md-table-footer">
                    <tr>
                        <td colspan="4" class="text-center fw-bold">TOTAL OMZET KESELURUHAN</td>
                        <td class="text-end fw-bold" id="totalFilter">Rp <?= number_format($totalSemua, 0, ',', '.') ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <h6 class="small text-uppercase opacity-75">Tips Laporan</h6>
                <p class="mb-0 small">Gunakan tombol <strong>Struk</strong> untuk mencetak bukti transaksi satuan pelanggan.</p>
            </div>
        </div>
    </div>
</div>

<?php if($this->session->flashdata('notif_struk')): ?>
<script>
    // Memunculkan alert window pop-up agar kasir langsung sadar
    setTimeout(function() {
        alert("<?= $this->session->flashdata('notif_struk'); ?>");
    }, 500);
</script>
<?php endif; ?>

<script>
    // Fitur JS Smart Filter Kombinasi + Accordion Grouping
    const smartFilter = document.getElementById('smartFilter');
    const startDate = document.getElementById('startDate');
    const endDate = document.getElementById('endDate');
    const userFilter = document.getElementById('userFilter');

    // Accordion UI Logic
    document.querySelectorAll('.group-header').forEach(header => {
        header.addEventListener('click', function() {
            let groupId = this.getAttribute('data-group-id');
            let icon = this.querySelector('.toggle-icon');
            let children = document.querySelectorAll('.group-child-' + groupId);
            
            let isHidden = this.classList.contains('collapsed-group');
            if (isHidden) {
                // expand
                this.classList.remove('collapsed-group');
                icon.style.transform = "rotate(0deg)";
                children.forEach(c => {
                    if(!c.hasAttribute('data-filtered')) c.style.display = '';
                });
            } else {
                // collapse
                this.classList.add('collapsed-group');
                icon.style.transform = "rotate(-90deg)";
                children.forEach(c => c.style.display = 'none');
            }
        });
    });

    function applyFilters() {
        let keyword = smartFilter.value.toLowerCase();
        let startVal = startDate.value; 
        let endVal = endDate.value;     
        let selectedUser = userFilter.value.toLowerCase();
        
        let startTimestamp = startVal ? new Date(startVal).setHours(0,0,0,0) : null;
        let endTimestamp = endVal ? new Date(endVal).setHours(23,59,59,999) : null;

        let totalKeseluruhan = 0;
        let groups = document.querySelectorAll('.group-header');

        groups.forEach(groupRow => {
            let groupId = groupRow.getAttribute('data-group-id');
            let children = document.querySelectorAll('.group-child-' + groupId);
            let groupVisibleCount = 0;
            let groupVisibleSum = 0;

            children.forEach(row => {
                let rowText = row.innerText.toLowerCase();
                let matchesKeyword = rowText.includes(keyword);

                let matchesUser = true;
                if (selectedUser !== "") {
                    let cellName = row.querySelector('.customer-name-item');
                    if(cellName && !cellName.innerText.toLowerCase().includes(selectedUser)) {
                        matchesUser = false;
                    }
                }

                let dateText = row.querySelector('td:nth-child(1)').innerText.trim();
                let day = parseInt(dateText.substring(0, 2), 10);
                let month = parseInt(dateText.substring(3, 5), 10) - 1; 
                let year = parseInt(dateText.substring(6, 10), 10);
                let rowTimestamp = new Date(year, month, day).getTime();
                
                let matchesDate = true;
                if (startTimestamp && rowTimestamp < startTimestamp) matchesDate = false;
                if (endTimestamp && rowTimestamp > endTimestamp) matchesDate = false;

                if (matchesKeyword && matchesDate && matchesUser) {
                    row.removeAttribute('data-filtered');
                    if (!groupRow.classList.contains('collapsed-group')) {
                        row.style.display = '';
                    }
                    let priceClean = parseInt(row.querySelector('.trx-price').getAttribute('data-price')) || 0;
                    groupVisibleSum += priceClean;
                    groupVisibleCount++;
                    totalKeseluruhan += priceClean;
                } else {
                    row.setAttribute('data-filtered', 'true');
                    row.style.display = 'none';
                }
            });

            // Update Group Header Visibility & Count
            if (groupVisibleCount > 0) {
                groupRow.style.display = '';
                groupRow.querySelector('.group-total').innerText = 'Rp ' + groupVisibleSum.toLocaleString('id-ID');
                groupRow.querySelector('.trx-count').innerText = groupVisibleCount + ' trx';
            } else {
                groupRow.style.display = 'none';
            }
        });

        let totalElement = document.getElementById('totalFilter');
        if(totalElement) {
            totalElement.innerText = 'Rp ' + totalKeseluruhan.toLocaleString('id-ID');
        }
    }

    // Export ke CSV (Excel)
    function exportToExcel() {
        let rows = document.querySelectorAll('#reportTbody tr');
        let csvContent = "data:text/csv;charset=utf-8,";
        
        csvContent += "Waktu Transaksi,No Invoice,Nama Pelanggan,Metode Bayar,Total Harga (Rp)\n";

        rows.forEach(row => {
            // Hanya export row yg tidak di-hidden oleh filter
            if (row.classList.contains('trx-row') && row.style.display !== 'none') {
                let cols = row.querySelectorAll('td');
                if(cols.length >= 5) {
                    let date = cols[0].innerText.trim();
                    let inv = cols[1].innerText.trim();
                    let cust = cols[2].innerText.trim().replace('↳', '').trim();
                    let method = cols[3].innerText.trim().replace('📱', '').replace('💵', '').trim();
                    let price = cols[4].innerText.trim().replace(/[^0-9]/g, ''); 
                    
                    csvContent += `"${date}","${inv}","${cust}","${method}","${price}"\n`;
                }
            }
        });

        // Add overall total at bottom
        let totalVal = document.getElementById('totalFilter') ? document.getElementById('totalFilter').innerText.replace(/[^0-9]/g, '') : "0";
        csvContent += `,,,TOTAL OMZET (Rp),${totalVal}\n`;

        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "Laporan_Penjualan_Macha.csv");
        document.body.appendChild(link); // Dibutuhkan firefox mod compatibility
        link.click();
        document.body.removeChild(link);
    }

    smartFilter.addEventListener('keyup', applyFilters);
    startDate.addEventListener('change', applyFilters);
    endDate.addEventListener('change', applyFilters);
    userFilter.addEventListener('change', applyFilters);
</script>
