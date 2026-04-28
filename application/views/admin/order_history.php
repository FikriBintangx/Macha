<style>
/* ── RIWAYAT ORDER RESPONSIVE CARD-STACK ── */
@media (max-width: 768px) {
    .riwayat-card-table table,
    .riwayat-card-table thead,
    .riwayat-card-table tbody,
    .riwayat-card-table th,
    .riwayat-card-table td,
    .riwayat-card-table tr { display: block; width: 100%; }

    .riwayat-card-table thead tr { display: none; }

    .riwayat-card-table .order-row {
        background: #fff;
        border: 1px solid #edf2ed;
        border-radius: 16px;
        margin-bottom: 14px;
        padding: 4px 0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .riwayat-card-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 16px !important;
        border-bottom: 1px solid #f5f9f5 !important;
        font-size: 0.9rem;
    }
    .riwayat-card-table td:last-child { border-bottom: none !important; }
    .riwayat-card-table td::before {
        content: attr(data-label);
        font-size: 0.7rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #8aa898;
        flex-shrink: 0;
        margin-right: 10px;
    }
}
</style>

<div class="row">
    <div class="col-12">
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" style="border-radius: 12px;" role="alert">
                <i class="bi bi-check-circle-fill me-2 text-success"></i><span class="fw-medium"><?= $this->session->flashdata('success') ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php
        $uniqueCustomers = [];
        if (!empty($orders)) {
            foreach ($orders as $r) {
                $cname = trim($r['user_name'] ?: $r['customer_name']);
                if ($cname == '') $cname = 'Pelanggan Anonim';
                $uniqueCustomers[$cname] = $cname;
            }
            ksort($uniqueCustomers);
        }
        ?>

        <!-- FILTER BAR -->
        <div class="card border-0 shadow-sm mb-4 bg-white" style="border-radius: 16px;">
            <div class="card-body p-3">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3 col-lg-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light text-secondary border-secondary-subtle"><i class="bi bi-calendar-event"></i></span>
                            <input type="date" id="dateFilter" class="form-control border-secondary-subtle fw-semibold text-secondary" value="<?= $date_filter ?>">
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
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
                    <div class="col-md-5 col-lg-7">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light text-secondary border-end-0 border-secondary-subtle"><i class="bi bi-search"></i></span>
                            <input type="text" id="smartFilter" class="form-control border-start-0 ps-0 border-secondary-subtle fw-semibold" placeholder="Ketik invoice, alamat, atau status...">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm bg-white" style="border-radius: 16px;">
            <div class="card-header bg-white p-4 pb-2 border-bottom-0 rounded-top">
                <h5 class="mb-0 text-success fw-bold"><i class="bi bi-clock-history me-2"></i>Riwayat Order (Online)</h5>
                <p class="text-muted small mb-0 mt-1">Daftar semua pesanan online yang pernah masuk.</p>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive riwayat-card-table">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-secondary fw-semibold small px-4 py-3 border-0">TANGGAL</th>
                                <th class="text-secondary fw-semibold small py-3 border-0">INVOICE</th>
                                <th class="text-secondary fw-semibold small py-3 border-0">PELANGGAN</th>
                                <th class="text-secondary fw-semibold small py-3 border-0">PENGIRIMAN</th>
                                <th class="text-secondary fw-semibold small py-3 border-0">TOTAL BAYAR</th>
                                <th class="text-secondary fw-semibold small py-3 border-0">BUKTI</th>
                                <th class="text-secondary fw-semibold small py-3 text-center border-0">STATUS</th>
                                <th class="text-secondary fw-semibold small py-3 text-center border-0 pe-4">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0" id="orderTbody">
                            <?php if(!empty($orders)): ?>
                                <?php foreach($orders as $o): ?>
                                    <tr class="order-row" style="transition: all 0.2s;">
                                        <td class="px-4 py-3" data-label="TANGGAL">
                                            <div class="fw-bold text-dark" style="font-size: 0.95rem;"><?= date('d M Y', strtotime($o['created_at'])) ?></div>
                                            <div class="text-muted small"><?= date('H:i', strtotime($o['created_at'])) ?></div>
                                        </td>
                                        <td class="py-3" data-label="INVOICE">
                                            <span class="badge bg-white text-dark border px-2 py-1 shadow-sm" style="font-family: monospace; font-size: 0.8rem;"><?= $o['invoice_no'] ?></span>
                                        </td>
                                        <td class="py-3" data-label="PELANGGAN">
                                            <div class="text-dark fw-bold customer-name-item" style="font-size: 0.95rem;">
                                                <?= htmlspecialchars($o['user_name'] ? $o['user_name'] : $o['customer_name']) ?>
                                            </div>
                                        </td>
                                        <td class="py-3" data-label="PENGIRIMAN">
                                            <div class="small fw-bold text-success mb-1"><?= htmlspecialchars($o['phone']) ?></div>
                                            <div class="text-secondary small" style="max-width: 200px; line-height: 1.3"><?= htmlspecialchars(substr($o['address'], 0, 50)) ?>...</div>
                                        </td>
                                        <td class="fw-bold text-success text-nowrap py-3" data-label="TOTAL">
                                            Rp <?= number_format($o['total_price'],0,',','.') ?>
                                        </td>
                                        <td class="py-3" data-label="BUKTI">
                                            <?php if(!empty($o['payment_proof'])): ?>
                                                <button type="button" onclick="showProof('<?= base_url('uploads/payments/'.$o['payment_proof']) ?>')" class="btn btn-sm btn-light border text-info p-2 rounded-circle shadow-sm" title="Lihat Bukti"><i class="bi bi-image"></i></button>
                                            <?php else: ?>
                                                <span class="text-muted opacity-50" style="font-size: 0.75rem; font-style: italic;">None</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center py-3" data-label="STATUS">
                                            <?php 
                                            $st = $o['status'];
                                            $bclass = 'bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25';
                                            $btext = ucfirst($st);
                                            if($st == 'pending') { $bclass = 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25'; $btext = 'Menunggu'; }
                                            if($st == 'paid') { $bclass = 'bg-warning bg-opacity-10 text-warning-emphasis border border-warning border-opacity-50'; $btext = 'Dibayar'; }
                                            if($st == 'shipped') { $bclass = 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25'; $btext = 'Siap/Dikirim'; }
                                            if($st == 'completed') { $bclass = 'bg-success bg-opacity-10 text-success border border-success border-opacity-25'; $btext = 'Selesai'; }
                                            if($st == 'canceled') { $bclass = 'bg-dark bg-opacity-10 text-dark border border-dark border-opacity-25'; $btext = 'Batal'; }
                                            ?>
                                            <span class="badge <?= $bclass ?> rounded-pill px-3 py-2 fw-bold" style="font-size: 0.75rem; letter-spacing: 0.3px;"><?= $btext ?></span>
                                        </td>
                                        <td class="pe-4 py-3 text-center" data-label="AKSI">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <?php if($o['status'] != 'completed'): ?>
                                                    <a href="<?= site_url('order/update_status/'.$o['id'].'/completed') ?>" class="btn btn-sm btn-light border rounded-pill px-3 fw-bold" style="font-size: 0.8rem;" title="Tandai Selesai"><i class="bi bi-check2 text-success me-1"></i>Selesai</a>
                                                <?php endif; ?>
                                                <?php if(in_array($o['status'], ['pending', 'canceled'])): ?>
                                                    <a href="<?= site_url('order/delete/'.$o['id']) ?>" 
                                                       class="btn btn-sm btn-light border p-2 rounded-circle shadow-sm" 
                                                       title="Hapus Pesanan"
                                                       onclick="return confirm('⚠️ Hapus pesanan #<?= $o['invoice_no'] ?>?\n\nStok produk akan dikembalikan.\nTindakan ini tidak dapat dibatalkan.')">
                                                        <i class="bi bi-trash3-fill text-danger"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="btn btn-sm btn-light border p-2 rounded-circle disabled" title="Transaksi resmi tidak bisa dihapus" style="opacity:0.3;cursor:not-allowed;">
                                                        <i class="bi bi-lock-fill text-muted"></i>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">Belum ada riwayat order.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const userFilter = document.getElementById('userFilter');
        const smartFilter = document.getElementById('smartFilter');
        const dateFilter = document.getElementById('dateFilter');

        function applyFilters() {
            const selectedUser = userFilter.value.toLowerCase().trim();
            const keyword = smartFilter.value.toLowerCase().trim();
            const orderRows = document.querySelectorAll('.order-row');

            console.log('Applying filters (order_history):', {
                totalRows: orderRows.length,
                selectedUser: selectedUser,
                keyword: keyword
            });

            // First, make sure all rows are visible
            orderRows.forEach(row => {
                row.style.display = "table-row";
            });

            let visibleCount = 0;
            orderRows.forEach(row => {
                const customerNameNode = row.querySelector('.customer-name-item');
                const customerName = customerNameNode ? customerNameNode.innerText.toLowerCase() : "";
                const rowText = row.innerText.toLowerCase();

                const matchesUser = selectedUser === "" || customerName.includes(selectedUser);
                const matchesKeyword = keyword === "" || rowText.includes(keyword);

                if (matchesUser && matchesKeyword) {
                    row.style.display = "table-row";
                    visibleCount++;
                } else {
                    row.style.display = "none";
                }
            });

            console.log('Visible rows after filtering:', visibleCount);
        }

        // Ensure all rows are visible initially
        const initialRows = document.querySelectorAll('.order-row');
        initialRows.forEach(row => {
            row.style.display = "table-row";
        });

        // Apply filters on page load
        applyFilters();

        dateFilter.addEventListener('change', function() {
            window.location.href = "<?= site_url('order/history') ?>?date=" + this.value;
        });

        userFilter.addEventListener('change', applyFilters);
        smartFilter.addEventListener('input', applyFilters);
    });
</script>

<!-- Modal Image Bukti -->
<div class="modal fade" id="modalProof" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-header border-0 d-flex justify-content-end p-0 mb-2">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1); background-color: rgba(255,255,255,0.8); border-radius: 50%; padding: 10px;"></button>
            </div>
            <div class="modal-body p-0 text-center">
                <img id="proofImg" src="" alt="Bukti Transfer" class="img-fluid rounded-4 shadow-lg" style="max-height: 80vh; border: 4px solid #fff;">
            </div>
        </div>
    </div>
</div>

<script>
    function showProof(url) {
        document.getElementById('proofImg').src = url;
        new bootstrap.Modal(document.getElementById('modalProof')).show();
    }
</script>
