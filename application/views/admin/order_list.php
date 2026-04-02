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
                            <input type="text" id="smartFilter" class="form-control border-start-0 ps-0 border-secondary-subtle fw-semibold" placeholder="Cari dalam daftar ini...">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm bg-white" style="border-radius: 16px;">
            <div class="card-header bg-white p-4 pb-2 border-bottom-0 rounded-top">
                <h5 class="mb-0 text-success fw-bold"><i class="bi bi-box-seam me-2"></i>Pesanan Masuk</h5>
                <p class="text-muted small mb-0 mt-1">Daftar pesanan online khusus tanggal <?= date('d M Y', strtotime($date_filter)) ?>.</p>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-secondary fw-semibold small px-4 py-3 border-0">JAM</th>
                                <th class="text-secondary fw-semibold small py-3 border-0">INVOICE</th>
                                <th class="text-secondary fw-semibold small py-3 border-0">PELANGGAN</th>
                                <th class="text-secondary fw-semibold small py-3 border-0">PENGIRIMAN</th>
                                <th class="text-secondary fw-semibold small py-3 border-0">TOTAL</th>
                                <th class="text-secondary fw-semibold small py-3 border-0">BUKTI</th>
                                <th class="text-secondary fw-semibold small py-3 text-center border-0">STATUS</th>
                                <th class="text-secondary fw-semibold small py-3 text-center border-0 pe-4">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0" id="orderTbody">
                            <?php if(!empty($orders)): ?>
                                <?php foreach($orders as $o): ?>
                                    <tr class="order-row" style="transition: all 0.2s;">
                                        <td class="px-4 py-3 fw-bold text-dark"><?= date('H:i', strtotime($o['created_at'])) ?></td>
                                        <td class="py-3">
                                            <span class="badge bg-light text-dark border px-2 py-1 shadow-sm"><?= $o['invoice_no'] ?></span>
                                        </td>
                                        <td class="py-3">
                                            <div class="text-dark fw-medium customer-name-item" style="font-size: 0.95rem;">
                                                <?= htmlspecialchars($o['user_name'] ? $o['user_name'] : $o['customer_name']) ?>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <a href="https://wa.me/62<?= ltrim($o['phone'], '0') ?>" target="_blank" class="text-success fw-bold small text-decoration-none">
                                                <i class="bi bi-whatsapp"></i> <?= htmlspecialchars($o['phone']) ?>
                                            </a>
                                            <div class="text-secondary small text-truncate" style="max-width: 150px;"><?= htmlspecialchars($o['address']) ?></div>
                                        </td>
                                        <td class="fw-bold text-success text-nowrap py-3">
                                            Rp <?= number_format($o['total_price'],0,',','.') ?>
                                        </td>
                                        <td class="py-3">
                                            <?php if(!empty($o['payment_proof'])): ?>
                                                <a href="<?= base_url('uploads/payments/'.$o['payment_proof']) ?>" target="_blank" class="btn btn-xs btn-outline-info p-1"><i class="bi bi-image"></i></a>
                                            <?php else: ?>
                                                <small class="text-muted italic">None</small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center py-3">
                                            <?php 
                                            $class = 'bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25';
                                            $text = ucfirst($o['status']);
                                            if($o['status'] == 'pending') { $class = 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25'; $text = 'Menunggu'; }
                                            if($o['status'] == 'paid') { $class = 'bg-warning bg-opacity-10 text-warning-emphasis border border-warning border-opacity-50'; $text = 'Sudah Bayar'; }
                                            if($o['status'] == 'shipped') { $class = 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25'; $text = 'Dikirim'; }
                                            if($o['status'] == 'completed') { $class = 'bg-success bg-opacity-10 text-success border border-success border-opacity-25'; $text = 'Selesai'; }
                                            ?>
                                            <span class="badge <?= $class ?> rounded-pill px-2 py-1 fw-semibold" style="font-size: 0.75rem;"><?= $text ?></span>
                                        </td>
                                        <td class="pe-4 py-3 text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light border dropdown-toggle fw-medium p-1 px-2 rounded-pill shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-gear"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius: 12px; font-size: 0.85rem;">
                                                    <li><a class="dropdown-item py-2" href="<?= site_url('order/update_status/'.$o['id'].'/paid') ?>"><i class="bi bi-check-circle text-warning me-2"></i>Validasi Bayar</a></li>
                                                    <li><a class="dropdown-item py-2" href="<?= site_url('order/update_status/'.$o['id'].'/shipped') ?>"><i class="bi bi-truck text-primary me-2"></i>Sedang Dikirim</a></li>
                                                    <li><a class="dropdown-item py-2" href="<?= site_url('order/update_status/'.$o['id'].'/completed') ?>"><i class="bi bi-check2-all text-success me-2"></i>Pesanan Selesai</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger py-2" href="<?= site_url('order/update_status/'.$o['id'].'/canceled') ?>"><i class="bi bi-x-circle me-2"></i>Batalkan</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                                        <p class="mb-0">Belum ada pesanan masuk hari ini.</p>
                                    </td>
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
            const customerNameNode = row.querySelector('.customer-name-item');
            const customerName = customerNameNode ? customerNameNode.innerText.toLowerCase() : "";
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
        window.location.href = "<?= site_url('order') ?>?date=" + this.value;
    });

    userFilter.addEventListener('change', applyFilters);
    smartFilter.addEventListener('input', applyFilters);
</script>
