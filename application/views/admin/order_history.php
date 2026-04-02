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
                <div class="table-responsive">
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
                                        <td class="px-4 py-3">
                                            <div class="fw-bold text-dark" style="font-size: 0.95rem;"><?= date('d M Y', strtotime($o['created_at'])) ?></div>
                                            <div class="text-muted small"><?= date('H:i', strtotime($o['created_at'])) ?></div>
                                        </td>
                                        <td class="py-3">
                                            <span class="badge bg-light text-dark border px-2 py-1 shadow-sm"><?= $o['invoice_no'] ?></span>
                                        </td>
                                        <td class="py-3">
                                            <div class="text-dark fw-medium customer-name-item" style="font-size: 0.95rem;">
                                                <?= htmlspecialchars($o['user_name'] ? $o['user_name'] : $o['customer_name']) ?>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <div class="small fw-bold text-success mb-1"><?= htmlspecialchars($o['phone']) ?></div>
                                            <div class="text-secondary small" style="max-width: 200px; line-height: 1.3"><?= htmlspecialchars(substr($o['address'], 0, 50)) ?>...</div>
                                        </td>
                                        <td class="fw-bold text-success text-nowrap py-3">
                                            Rp <?= number_format($o['total_price'],0,',','.') ?>
                                        </td>
                                        <td class="py-3">
                                            <?php if(!empty($o['payment_proof'])): ?>
                                                <a href="<?= base_url('uploads/payments/'.$o['payment_proof']) ?>" target="_blank" class="text-info"><i class="bi bi-file-earmark-image fs-5"></i></a>
                                            <?php else: ?>
                                                <i class="bi bi-x-circle text-muted opacity-50"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center py-3">
                                            <?php 
                                            $class = 'bg-secondary';
                                            if($o['status'] == 'pending') $class = 'bg-danger';
                                            if($o['status'] == 'paid') $class = 'bg-warning text-dark';
                                            if($o['status'] == 'shipped') $class = 'bg-primary';
                                            if($o['status'] == 'completed') $class = 'bg-success';
                                            ?>
                                            <span class="badge <?= $class ?> rounded-pill px-2 py-1" style="font-size: 0.7rem;"><?= ucfirst($o['status']) ?></span>
                                        </td>
                                        <td class="pe-4 py-3 text-center">
                                            <a href="<?= site_url('order/update_status/'.$o['id'].'/completed') ?>" class="btn btn-sm btn-light border p-1" title="Selesai"><i class="bi bi-check2 text-success"></i></a>
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
    const userFilter = document.getElementById('userFilter');
    const smartFilter = document.getElementById('smartFilter');
    const orderRows = document.querySelectorAll('.order-row');

    function applyFilters() {
        const selectedUser = userFilter.value.toLowerCase();
        const keyword = smartFilter.value.toLowerCase();

        orderRows.forEach(row => {
            const customerName = row.querySelector('.customer-name-item').innerText.toLowerCase();
            const rowText = row.innerText.toLowerCase();

            const matchesUser = selectedUser === "" || customerName.includes(selectedUser);
            const matchesKeyword = rowText.includes(keyword);

            if (matchesUser && matchesKeyword) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    const dateFilter = document.getElementById('dateFilter');
    
    dateFilter.addEventListener('change', function() {
        window.location.href = "<?= site_url('order/history') ?>?date=" + this.value;
    });

    userFilter.addEventListener('change', applyFilters);
    smartFilter.addEventListener('input', applyFilters);
</script>
