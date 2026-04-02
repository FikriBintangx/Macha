<div class="row">
    <div class="col-12">
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" style="border-radius: 12px;" role="alert">
                <i class="bi bi-check-circle-fill me-2 text-success"></i><span class="fw-medium"><?= $this->session->flashdata('success') ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- MONITORING HEADER & QUICK ACTIONS -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bold text-success mb-1"><i class="bi bi-pc-display-horizontal me-2"></i>Kasir Online monitoring</h4>
                <p class="text-muted small mb-0">Pemantauan orderan masuk secara real-time.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= site_url('product') ?>" class="btn btn-sm btn-white border shadow-sm px-3 rounded-pill fw-semibold">
                    <i class="bi bi-pencil-square me-1 text-primary"></i> Ubah Produk
                </a>
                <a href="<?= site_url('product') ?>" class="btn btn-sm btn-white border shadow-sm px-3 rounded-pill fw-semibold">
                    <i class="bi bi-box-seam me-1 text-warning"></i> Edit Stok
                </a>
                <div class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill d-flex align-items-center">
                    <span class="spinner-grow spinner-grow-sm me-2" role="status"></span>
                    Live Monitoring
                </div>
            </div>
        </div>

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
                <div class="row g-2 align-items-center">
                    <div class="col-md-3 col-6">
                        <div class="input-group input-group-sm h-100">
                            <span class="input-group-text bg-light text-secondary border-secondary-subtle px-2"><i class="bi bi-calendar-event"></i></span>
                            <input type="date" id="dateFilter" class="form-control border-secondary-subtle fw-semibold text-secondary" value="<?= $date_filter ?>">
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="input-group input-group-sm h-100">
                            <span class="input-group-text bg-light text-secondary border-secondary-subtle px-2"><i class="bi bi-person"></i></span>
                            <select id="userFilter" class="form-select border-secondary-subtle fw-semibold text-secondary">
                                <option value="">Pelanggan</option>
                                <?php foreach($uniqueCustomers as $c): ?>
                                    <option value="<?= htmlspecialchars($c) ?>"><?= htmlspecialchars($c) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="input-group input-group-sm h-100">
                            <span class="input-group-text bg-light text-secondary border-end-0 border-secondary-subtle"><i class="bi bi-search"></i></span>
                            <input type="text" id="smartFilter" class="form-control border-start-0 ps-0 border-secondary-subtle fw-semibold" placeholder="Nama / Invoice...">
                        </div>
                    </div>
                    <div class="col-md-2 col-12 ms-auto">
                        <button onclick="location.reload()" class="btn btn-success btn-sm w-100 rounded-pill shadow-sm py-2">
                            Refresh Data
                        </button>
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
                <div class="table-responsive responsive-card-table">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3 border-0">JAM</th>
                                <th class="py-3 border-0">INVOICE</th>
                                <th class="py-3 border-0">PELANGGAN</th>
                                <th class="py-3 border-0">PENGIRIMAN</th>
                                <th class="py-3 border-0">TOTAL</th>
                                <th class="py-3 border-0">BUKTI</th>
                                <th class="py-3 text-center border-0">STATUS</th>
                                <th class="py-3 text-center border-0 pe-4">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0" id="orderTbody">
                            <?php if(!empty($orders)): ?>
                                <?php foreach($orders as $o): ?>
                                    <tr class="order-row" id="row-<?= $o['id'] ?>" style="transition: all 0.2s;">
                                        <td class="px-4 py-3 fw-bold text-dark" data-label="JAM"><?= date('H:i', strtotime($o['created_at'])) ?></td>
                                        <td class="py-3" data-label="INVOICE">
                                            <span class="badge bg-light text-dark border px-2 py-1 shadow-sm"><?= $o['invoice_no'] ?></span>
                                        </td>
                                        <td class="py-3" data-label="PELANGGAN">
                                            <div class="text-dark fw-medium customer-name-item" style="font-size: 0.95rem;">
                                                <?= htmlspecialchars($o['user_name'] ? $o['user_name'] : $o['customer_name']) ?>
                                            </div>
                                        </td>
                                        <td class="py-3" data-label="PENGIRIMAN">
                                            <a href="https://wa.me/62<?= ltrim($o['phone'], '0') ?>" target="_blank" class="text-success fw-bold small text-decoration-none">
                                                <i class="bi bi-whatsapp"></i> <?= htmlspecialchars($o['phone']) ?>
                                            </a>
                                            <div class="text-secondary small text-truncate d-inline-block d-md-block ms-2 ms-md-0" style="max-width: 150px;"><?= htmlspecialchars($o['address']) ?></div>
                                        </td>
                                        <td class="fw-bold text-success text-nowrap py-3" data-label="TOTAL">
                                            Rp <?= number_format($o['total_price'],0,',','.') ?>
                                        </td>
                                        <td class="py-3" data-label="BUKTI">
                                            <?php if(!empty($o['payment_proof'])): ?>
                                                <button type="button" onclick="viewProof('<?= base_url('uploads/payments/'.$o['payment_proof']) ?>')" class="btn btn-xs btn-outline-info p-1"><i class="bi bi-image"></i></button>
                                            <?php else: ?>
                                                <small class="text-muted italic">None</small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center py-3" data-label="STATUS" id="status-cell-<?= $o['id'] ?>">
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
                                        <td class="pe-4 py-3 text-center" data-label="AKSI">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light border dropdown-toggle fw-medium p-1 px-2 rounded-pill shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-gear"></i> Manage
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius: 12px; font-size: 0.85rem;">
                                                    <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="updateStatus(<?= $o['id'] ?>, 'paid')"><i class="bi bi-check-circle text-warning me-2"></i>Validasi Bayar</a></li>
                                                    <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="updateStatus(<?= $o['id'] ?>, 'shipped')"><i class="bi bi-truck text-primary me-2"></i>Sedang Dikirim</a></li>
                                                    <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="updateStatus(<?= $o['id'] ?>, 'completed')"><i class="bi bi-check2-all text-success me-2"></i>Pesanan Selesai</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger py-2" href="javascript:void(0)" onclick="updateStatus(<?= $o['id'] ?>, 'canceled')"><i class="bi bi-x-circle me-2"></i>Batalkan</a></li>
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

<!-- Modal Bukti Bayar -->
<div class="modal fade" id="modalProof" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header border-0 bg-light p-3">
                <h6 class="modal-title fw-bold text-success"><i class="bi bi-image me-2"></i>Bukti Pembayaran</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 text-center bg-dark">
                <img id="imageProofDisplay" src="" class="img-fluid" style="max-height: 80vh; object-fit: contain;">
            </div>
            <div class="modal-footer border-0 p-2 justify-content-center">
                <button type="button" class="btn btn-sm btn-white border px-4 rounded-pill" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Image View
    function viewProof(url) {
        document.getElementById('imageProofDisplay').src = url;
        new bootstrap.Modal(document.getElementById('modalProof')).show();
    }

    // AJAX Update Status
    function updateStatus(id, status) {
        if (!confirm('Apakah Anda yakin ingin mengubah status pesanan ini?')) return;

        const formData = new FormData();
        formData.append('id', id);
        formData.append('status', status);

        fetch('<?= site_url('order/ajax_update_status') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update specific row status cell with new badge
                const cell = document.getElementById('status-cell-' + id);
                let badgeClass = 'bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25';
                let statusText = data.new_status.charAt(0).toUpperCase() + data.new_status.slice(1);

                if (data.new_status === 'pending') { badgeClass = 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25'; statusText = 'Menunggu'; }
                if (data.new_status === 'paid') { badgeClass = 'bg-warning bg-opacity-10 text-warning-emphasis border border-warning border-opacity-50'; statusText = 'Sudah Bayar'; }
                if (data.new_status === 'shipped') { badgeClass = 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25'; statusText = 'Dikirim'; }
                if (data.new_status === 'completed') { badgeClass = 'bg-success bg-opacity-10 text-success border border-success border-opacity-25'; statusText = 'Selesai'; }
                if (data.new_status === 'canceled') { badgeClass = 'bg-dark bg-opacity-10 text-dark border border-dark border-opacity-25'; statusText = 'Dibatalkan'; }

                cell.innerHTML = `<span class="badge ${badgeClass} rounded-pill px-2 py-1 fw-semibold" style="font-size: 0.75rem;">${statusText}</span>`;
                
                // Optional: Flash the row
                const row = document.getElementById('row-' + id);
                row.style.backgroundColor = '#e8f5e9';
                setTimeout(() => row.style.backgroundColor = '', 1000);
            } else {
                alert('Gagal memperbarui status: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan jaringan.');
        });
    }

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
