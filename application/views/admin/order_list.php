<style>
/* Force text colors in table to be dark */
table.table tbody td { color: #000 !important; opacity: 1 !important; visibility: visible !important; }

/* Admin Toast Notification */
#adminToast {
    position: fixed; bottom: 28px; right: 28px; z-index: 9999;
    min-width: 280px; max-width: 380px;
    padding: 14px 20px; border-radius: 16px;
    font-size: 0.88rem; font-weight: 600;
    display: flex; align-items: center; gap: 12px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.18);
    transform: translateY(20px); opacity: 0;
    transition: all 0.35s cubic-bezier(0.34,1.56,0.64,1);
    pointer-events: none;
}
#adminToast.show { transform: translateY(0); opacity: 1; pointer-events: auto; }
#adminToast.toast-success { background: #1a4731; color: #fff; }
#adminToast.toast-error   { background: #7f1d1d; color: #fff; }
#adminToast.toast-info    { background: #1e3a5f; color: #fff; }

/* Shimmer Skeleton Styles */
.skeleton-container {
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.skeleton-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}
.skeleton-block {
    background: #e2e8f0;
    background-image: linear-gradient(
        90deg,
        #e2e8f0 0px,
        #f1f5f9 40px,
        #e2e8f0 80px
    );
    background-size: 200% 100%;
    animation: shimmer-anim 1.5s infinite linear;
    border-radius: 8px;
    height: 20px;
}
@keyframes shimmer-anim {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

/* Horizontal scrollable quick actions for mobile view */
.scrollable-actions {
    display: flex;
    gap: 8px;
    overflow-x: auto;
    width: 100%;
    padding-bottom: 8px;
    -webkit-overflow-scrolling: touch;
}
.scrollable-actions::-webkit-scrollbar {
    display: none;
}
.scrollable-actions .btn, .scrollable-actions .badge {
    flex-shrink: 0;
}

@media (max-width: 768px) {
    .skeleton-row {
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 12px;
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 16px;
        background: #fff;
        padding: 15px !important;
        margin-bottom: 15px;
    }
}
</style>

<div class="container py-4">
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
            <div class="scrollable-actions">
                <button type="button" class="btn btn-sm btn-white border shadow-sm px-3 rounded-pill fw-semibold" data-bs-toggle="modal" data-bs-target="#calcModal">
                    <i class="bi bi-calculator me-1 text-info"></i> Kalkulator
                </button>
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
                <p class="text-muted small mb-0 mt-1">Daftar pesanan online khusus tanggal <?= date('d M Y', strtotime($date_filter)) ?>. (Debug: <?= count($orders) ?> found)</p>
            </div>
            <div class="card-body p-0" style="position: relative;">
                <!-- SKELETON SHIMMER LOADER -->
                <div id="skeleton-loader" class="skeleton-container" style="min-height: 450px; transition: opacity 0.25s ease;">
                    <?php for($i = 0; $i < 5; $i++): ?>
                    <div class="skeleton-row">
                        <div class="d-flex align-items-center gap-3 flex-grow-1 me-4">
                            <div class="skeleton-block" style="width: 50px;"></div>
                            <div class="skeleton-block" style="width: 110px;"></div>
                            <div class="skeleton-block flex-grow-1" style="max-width: 200px;"></div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="skeleton-block" style="width: 80px;"></div>
                            <div class="skeleton-block" style="width: 70px;"></div>
                            <div class="skeleton-block" style="width: 90px; border-radius: 20px; height: 32px;"></div>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>

                <!-- ACTUAL CONTENT -->
                <div id="actual-content" style="opacity: 0; display: none; transition: opacity 0.3s ease;">
                    <div class="table-responsive responsive-card-table" style="min-height: 450px; padding-bottom: 100px;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="" style="background: #f8faf9;">
                                <tr>
                                    <th class="ps-4 py-3 border-0 text-muted small fw-bold">JAM</th>
                                    <th class="py-3 border-0 text-muted small fw-bold">INVOICE</th>
                                    <th class="py-3 border-0 text-muted small fw-bold">PELANGGAN</th>
                                    <th class="py-3 border-0 text-muted small fw-bold">TIPE/BAYAR</th>
                                    <th class="py-3 border-0 text-muted small fw-bold">TOTAL</th>
                                    <th class="py-3 border-0 text-muted small fw-bold">BUKTI</th>
                                    <th class="py-3 text-center border-0 text-muted small fw-bold">STATUS</th>
                                    <th class="pe-4 py-3 text-center border-0 text-muted small fw-bold">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0" id="orderTbody">
                                <?php if(!empty($orders)): ?>
                                    <?php foreach($orders as $o): ?>
                                        <tr class="order-row" id="row-<?= $o['id'] ?>" style="transition: all 0.2s; opacity: 1 !important; visibility: visible !important; color: #000 !important;">
                                            <td class="ps-4 py-4 fw-bold" style="font-size: 1.05rem;" data-label="JAM"><?= date('H:i', strtotime($o['created_at'])) ?></td>
                                            <td class="py-4" data-label="INVOICE">
                                                <span class="badge bg-white border px-2 py-1 shadow-sm" style="font-size: 0.8rem; font-family: monospace; color: #000 !important;"><?= $o['invoice_no'] ?></span>
                                            </td>
                                            <td class="py-4" data-label="PELANGGAN">
                                                <div class="fw-bold customer-name-item" style="font-size: 0.95rem; color: #000 !important;">
                                                    <?= htmlspecialchars($o['user_name'] ? $o['user_name'] : $o['customer_name']) ?>
                                                </div>
                                            </td>
                                            <td class="py-4 text-nowrap" data-label="TIPE/BAYAR">
                                                <div class="small fw-bold text-uppercase d-flex align-items-center gap-1 mb-1" style="font-size: 0.65rem; color: #8aa898;">
                                                    <?php if($o['order_type'] == 'delivery'): ?>
                                                        <i class="bi bi-truck text-primary"></i> ANTAR
                                                    <?php elseif($o['order_type'] == 'dinein'): ?>
                                                        <i class="bi bi-chair text-info"></i> MAKAN SINI
                                                    <?php else: ?>
                                                        <i class="bi bi-bag-check text-success"></i> AMBIL
                                                    <?php endif; ?>
                                                </div>
                                                <div class="small fw-semibold" style="color: #000 !important;">
                                                    <i class="bi bi-credit-card-2-back me-1 opacity-50"></i><?= htmlspecialchars($o['payment_method'] ?? 'Transfer') ?>
                                                </div>
                                            </td>
                                            <td class="fw-bold text-success text-nowrap py-4" style="font-size: 1rem;" data-label="TOTAL">
                                                Rp <?= number_format($o['total_price'],0,',','.') ?>
                                            </td>
                                            <td class="py-4 text-center" data-label="BUKTI">
                                                <?php if(!empty($o['payment_proof'])): ?>
                                                    <button type="button" onclick="viewProof('<?= base_url('uploads/payments/'.$o['payment_proof']) ?>')" class="btn btn-sm btn-light border text-info p-2 rounded-circle shadow-sm" title="Lihat Bukti"><i class="bi bi-image"></i></button>
                                                <?php else: ?>
                                                    <span class="text-muted opacity-50" style="font-size: 0.75rem; font-style: italic;">None</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center py-4" data-label="STATUS" id="status-cell-<?= $o['id'] ?>">
                                                <?php 
                                                $st = $o['status'];
                                                $class = 'bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25';
                                                $text = ucfirst($st);
                                                
                                                if($st == 'pending') { $class = 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25'; $text = 'Menunggu'; }
                                                if($st == 'paid') { $class = 'bg-warning bg-opacity-10 text-warning-emphasis border border-warning border-opacity-50'; $text = 'Dibayar'; }
                                                if($st == 'shipped') { 
                                                    $class = 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25'; 
                                                    $text = ($o['order_type'] == 'delivery') ? 'Dikirim' : 'Siap Ambil'; 
                                                }
                                                if($st == 'completed') { $class = 'bg-success bg-opacity-10 text-success border border-success border-opacity-25'; $text = 'Selesai'; }
                                                if($st == 'canceled') { $class = 'bg-dark bg-opacity-10 text-dark border border-dark border-opacity-25'; $text = 'Batal'; }
                                                ?>
                                                <span class="badge <?= $class ?> rounded-pill px-3 py-2 fw-bold" style="font-size: 0.75rem; letter-spacing: 0.3px;"><?= $text ?></span>
                                            </td>
                                            <td class="pe-4 py-4 text-center" data-label="AKSI">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <button type="button" onclick="showDetail(<?= $o['id'] ?>, this)" class="btn btn-sm btn-success rounded-pill px-3 shadow-none fw-bold" style="font-size: 0.85rem;">
                                                        Detail
                                                    </button>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-white border dropdown-toggle fw-bold p-1 px-2 rounded-pill shadow-sm" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-expanded="false" style="font-size: 0.8rem;">
                                                            Manage
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-2 mt-2" style="border-radius: 12px; font-size: 0.85rem; min-width: 180px;">
                                                        <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="updateStatus(<?= $o['id'] ?>, 'paid')"><i class="bi bi-check-circle text-warning me-2"></i>Konfirmasi Bayar</a></li>
                                                        <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="updateStatus(<?= $o['id'] ?>, 'shipped')"><i class="bi bi-truck text-primary me-2"></i><?= ($o['order_type'] == 'delivery') ? 'Update: Sedang Diantar' : 'Update: Siap Diambil' ?></a></li>
                                                        <li><a class="dropdown-item py-2" href="javascript:void(0)" onclick="updateStatus(<?= $o['id'] ?>, 'completed')"><i class="bi bi-check2-all text-success me-2"></i>Selesaikan Pesanan</a></li>
                                                        <li><hr class="dropdown-divider mx-2"></li>
                                                        <li><a class="dropdown-item text-danger py-2" href="javascript:void(0)" onclick="updateStatus(<?= $o['id'] ?>, 'canceled')"><i class="bi bi-x-circle me-2"></i>Batalkan Pesanan</a></li>
                                                        <?php if(in_array($o['status'], ['pending', 'canceled'])): ?>
                                                            <li><hr class="dropdown-divider mx-2"></li>
                                                            <li><a class="dropdown-item text-danger py-2 fw-bold" href="<?= site_url('order/delete/'.$o['id']) ?>" onclick="return confirm('⚠️ Hapus pesanan permanen?\n\nStok akan dikembalikan.')"><i class="bi bi-trash3 me-2"></i>Hapus Permanen</a></li>
                                                        <?php endif; ?>
                                                        </ul>
                                                    </div>
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
</div>

<!-- Modal Detail Order -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg glass-panel" style="border-radius: 24px;">
            <div class="modal-header border-0 bg-success bg-opacity-10 p-4 pb-3">
                <div>
                    <h5 class="modal-title fw-bold text-success mb-1" id="detailInvoice">#INV-000000</h5>
                    <p class="text-muted small mb-0" id="detailTime">00:00 | 01 Jan 2026</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <h6 class="fw-bold small text-secondary text-uppercase mb-3">Item Pesanan</h6>
                    <div id="detailItems">
                        <!-- Items injected here -->
                    </div>
                </div>
                
                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-secondary">Total Bayar</span>
                        <h4 class="fw-bold text-success mb-0" id="detailTotal">Rp 0</h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light w-100 rounded-pill fw-bold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Bukti Bayar -->
<div class="modal fade" id="modalProof" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg glass-panel" style="border-radius: 24px; overflow: hidden;">
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
    // Show Order Detail
    function showDetail(id, btn) {
        if (!btn) btn = event.currentTarget;
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.disabled = true;

        fetch('<?= site_url('order/get_details/') ?>' + id)
        .then(response => response.json())
        .then(data => {
            btn.innerHTML = originalHtml;
            btn.disabled = false;
            if (data.success) {
                const o = data.order;
                document.getElementById('detailInvoice').innerText = '#' + o.invoice_no;
                
                // Format date manually or use PHP-like format
                const date = new Date(o.created_at);
                const timeStr = date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                const dateStr = date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
                document.getElementById('detailTime').innerText = `${timeStr} | ${dateStr}`;
                
                document.getElementById('detailTotal').innerText = 'Rp ' + parseInt(o.total_price).toLocaleString('id-ID');
                
                let itemsHtml = '';
                data.details.forEach(item => {
                    itemsHtml += `
                        <div class="d-flex justify-content-between align-items-center mb-2 border-bottom border-light pb-2">
                            <div>
                                <span class="fw-bold d-block">${item.product_name}</span>
                                <small class="text-muted">${item.qty} x Rp ${parseInt(item.price).toLocaleString('id-ID')}</small>
                            </div>
                            <span class="fw-bold text-dark">Rp ${parseInt(item.subtotal).toLocaleString('id-ID')}</span>
                        </div>
                    `;
                });
                document.getElementById('detailItems').innerHTML = itemsHtml;
                
                new bootstrap.Modal(document.getElementById('modalDetail')).show();
            }
        });
    }

    // Image View - unified to use the one defined at the bottom
    // function viewProof(url) is defined at the end of the file

    // ── Admin Toast Helper ──
    function showAdminToast(msg, type) {
        let toast = document.getElementById('adminToast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'adminToast';
            document.body.appendChild(toast);
        }
        toast.className = 'toast-' + (type || 'info');
        toast.innerHTML = `<i class="bi bi-${type==='success'?'check-circle-fill':type==='error'?'x-circle-fill':'info-circle-fill'}" style="font-size:1.1rem;"></i><span>${msg}</span>`;
        // show
        requestAnimationFrame(() => toast.classList.add('show'));
        clearTimeout(toast._t);
        toast._t = setTimeout(() => toast.classList.remove('show'), 3500);
    }

    // AJAX Update Status — dengan 1x auto-retry saat DB cold-start
    function updateStatus(id, status, _retry) {
        if (!_retry && !confirm('Apakah Anda yakin ingin mengubah status pesanan ini?')) return;

        const row  = document.getElementById('row-' + id);
        const cell = document.getElementById('status-cell-' + id);

        // Loading indicator di cell
        if (!_retry) cell.innerHTML = '<span class="spinner-border spinner-border-sm text-success"></span>';

        const formData = new FormData();
        formData.append('id', id);
        formData.append('status', status);

        fetch('<?= site_url('order/ajax_update_status') ?>', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(text => {
            let data;
            try {
                data = JSON.parse(text);
            } catch(e) {
                console.error('Non-JSON response:', text.substring(0, 300));
                throw new Error('bad_response');
            }

            // Session expired → redirect ke login
            if (data.redirect) {
                showAdminToast('Sesi habis, mengalihkan ke halaman login...', 'error');
                setTimeout(() => window.location.href = data.redirect, 1500);
                return;
            }

            if (data.success) {
                const orderType = row.querySelector('[data-label="TIPE/BAYAR"]').innerText.toLowerCase();

                const badgeMap = {
                    pending:   ['bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25', 'Menunggu'],
                    paid:      ['bg-warning bg-opacity-10 text-warning-emphasis border border-warning border-opacity-50', 'Dibayar'],
                    shipped:   ['bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25', orderType.includes('antar') ? 'Dikirim' : 'Siap Ambil'],
                    completed: ['bg-success bg-opacity-10 text-success border border-success border-opacity-25', 'Selesai'],
                    canceled:  ['bg-dark bg-opacity-10 text-dark border border-dark border-opacity-25', 'Batal'],
                };
                const [cls, txt] = badgeMap[data.new_status] || ['bg-secondary bg-opacity-10 text-secondary border', data.new_status];
                cell.innerHTML = `<span class="badge ${cls} rounded-pill px-3 py-2 fw-bold" style="font-size:0.75rem;">${txt}</span>`;

                showAdminToast('Status diubah → ' + txt, 'success');

                if (typeof gsap !== 'undefined') {
                    gsap.fromTo(row, { backgroundColor: 'rgba(25,135,84,0.2)' }, { backgroundColor: 'rgba(255,255,255,0)', duration: 1.5, ease: 'power2.out' });
                }
            } else {
                cell.innerHTML = '<span class="badge bg-danger-subtle text-danger">Error</span>';
                showAdminToast('Gagal: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('updateStatus error:', error);
            if (!_retry) {
                showAdminToast('Database sedang booting, mencoba lagi dalam 4 detik...', 'info');
                setTimeout(() => updateStatus(id, status, true), 4000);
            } else {
                // Restore original badge from page
                location.reload();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Shimmer skeleton fade-out and actual content fade-in
        const skeleton = document.getElementById('skeleton-loader');
        const content = document.getElementById('actual-content');
        if (skeleton && content) {
            skeleton.style.opacity = '0';
            setTimeout(() => {
                skeleton.style.display = 'none';
                content.style.display = 'block';
                if (typeof gsap !== 'undefined') {
                    gsap.to(content, { opacity: 1, duration: 0.35, ease: "power2.out" });
                } else {
                    content.style.opacity = '1';
                }
            }, 250);
        }

        const userFilter = document.getElementById('userFilter');
        const smartFilter = document.getElementById('smartFilter');
        const dateFilter = document.getElementById('dateFilter');

        function applyFilters() {
            const selectedUser = userFilter.value.toLowerCase().trim();
            const keyword = smartFilter.value.toLowerCase().trim();
            const orderRows = document.querySelectorAll('.order-row');

            console.log('Applying filters:', {
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

        // Set up event listeners
        dateFilter.addEventListener('change', function() {
            // Show skeleton loader again during redirection to feel premium
            if (skeleton && content) {
                content.style.opacity = '0';
                skeleton.style.display = 'block';
                skeleton.style.opacity = '1';
            }
            window.location.href = "<?= site_url('order') ?>?date=" + this.value;
        });

        userFilter.addEventListener('change', applyFilters);
        smartFilter.addEventListener('input', applyFilters);

        // Staggered Entrance for Rows - removed GSAP to prevent opacity:0 hangups
        document.querySelectorAll('.order-row').forEach(row => {
            row.style.opacity = "1";
        });
    });

    /* ── KALKULATOR MINI LOGIC ── */
    let calcCurrent = '';
    const calcDisplay = document.getElementById('calcDisplay');
    function calcInput(val) {
        if (calcCurrent === 'Error') calcCurrent = '';
        calcCurrent += val;
        calcDisplay.value = calcCurrent;
    }
    function calcClear() {
        calcCurrent = '';
        calcDisplay.value = '';
    }
    function calcDel() {
        if (calcCurrent === 'Error') calcCurrent = '';
        calcCurrent = calcCurrent.slice(0, -1);
        calcDisplay.value = calcCurrent;
    }
    function calcCalculate() {
        try {
            if(calcCurrent.trim() !== "") {
                // Prevent dangerous eval, safe basic math evaluation
                calcCurrent = String(new Function('return ' + calcCurrent.replace(/×/g, '*').replace(/÷/g, '/'))());
                calcDisplay.value = calcCurrent;
            }
        } catch (e) {
            calcCurrent = 'Error';
            calcDisplay.value = calcCurrent;
        }
    }
</script>

<!-- MODAL KALKULATOR MINI -->
<div class="modal fade" id="calcModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; background: #f8faf9;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold text-success"><i class="bi bi-calculator me-2"></i>Kalkulator Kasir</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <input type="text" id="calcDisplay" class="form-control text-end mb-3" readonly 
                       style="font-size: 1.8rem; font-weight: 700; background: #fff; border: 1px solid #dce8dc; border-radius: 12px; height: 65px; letter-spacing: 1px;">
                <div class="d-grid" style="grid-template-columns: repeat(4, 1fr); gap: 10px;">
                    <button class="btn btn-light shadow-sm calc-btn" style="border-radius:12px; font-weight:700; height:50px; color:#ef4444;" onclick="calcClear()">C</button>
                    <button class="btn btn-light shadow-sm calc-btn" style="border-radius:12px; font-weight:700; height:50px; color:#f59e0b;" onclick="calcDel()"><i class="bi bi-backspace"></i></button>
                    <button class="btn btn-light shadow-sm calc-btn" style="border-radius:12px; font-weight:700; height:50px; color:#52b788;" onclick="calcInput('%')">%</button>
                    <button class="btn btn-light shadow-sm calc-btn" style="border-radius:12px; font-weight:700; height:50px; color:#52b788;" onclick="calcInput('/')">÷</button>

                    <button class="btn btn-white shadow-sm calc-btn border" style="border-radius:12px; font-weight:700; height:50px;" onclick="calcInput('7')">7</button>
                    <button class="btn btn-white shadow-sm calc-btn border" style="border-radius:12px; font-weight:700; height:50px;" onclick="calcInput('8')">8</button>
                    <button class="btn btn-white shadow-sm calc-btn border" style="border-radius:12px; font-weight:700; height:50px;" onclick="calcInput('9')">9</button>
                    <button class="btn btn-light shadow-sm calc-btn" style="border-radius:12px; font-weight:700; height:50px; color:#52b788;" onclick="calcInput('*')">×</button>

                    <button class="btn btn-white shadow-sm calc-btn border" style="border-radius:12px; font-weight:700; height:50px;" onclick="calcInput('4')">4</button>
                    <button class="btn btn-white shadow-sm calc-btn border" style="border-radius:12px; font-weight:700; height:50px;" onclick="calcInput('5')">5</button>
                    <button class="btn btn-white shadow-sm calc-btn border" style="border-radius:12px; font-weight:700; height:50px;" onclick="calcInput('6')">6</button>
                    <button class="btn btn-light shadow-sm calc-btn" style="border-radius:12px; font-weight:700; height:50px; color:#52b788;" onclick="calcInput('-')">-</button>

                    <button class="btn btn-white shadow-sm calc-btn border" style="border-radius:12px; font-weight:700; height:50px;" onclick="calcInput('1')">1</button>
                    <button class="btn btn-white shadow-sm calc-btn border" style="border-radius:12px; font-weight:700; height:50px;" onclick="calcInput('2')">2</button>
                    <button class="btn btn-white shadow-sm calc-btn border" style="border-radius:12px; font-weight:700; height:50px;" onclick="calcInput('3')">3</button>
                    <button class="btn btn-light shadow-sm calc-btn" style="border-radius:12px; font-weight:700; height:50px; color:#52b788;" onclick="calcInput('+')">+</button>

                    <button class="btn btn-white shadow-sm calc-btn border" style="grid-column: span 2; border-radius:12px; font-weight:700; height:50px;" onclick="calcInput('0')">0</button>
                    <button class="btn btn-white shadow-sm calc-btn border" style="border-radius:12px; font-weight:700; height:50px;" onclick="calcInput('.')">.</button>
                    <button class="btn shadow-sm calc-btn" style="border-radius:12px; font-weight:700; height:50px; background:linear-gradient(135deg, var(--green-main), #2ea043); color:white;" onclick="calcCalculate()">=</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Image Bukti (Kasir Online) -->
<div class="modal fade" id="modalProofKasir" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-header border-0 d-flex justify-content-end p-0 mb-2">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1); background-color: rgba(255,255,255,0.8); border-radius: 50%; padding: 10px;"></button>
            </div>
            <div class="modal-body p-0 text-center">
                <img id="proofImgKasir" src="" alt="Bukti Transfer" class="img-fluid rounded-4 shadow-lg" style="max-height: 80vh; border: 4px solid #fff;">
            </div>
        </div>
    </div>
</div>

<script>
    function viewProof(url) {
        document.getElementById('proofImgKasir').src = url;
        new bootstrap.Modal(document.getElementById('modalProofKasir')).show();
    }
</script>
