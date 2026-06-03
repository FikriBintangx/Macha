<style>
    .supplier-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #edf2f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .supplier-table thead th {
        background: #f8faf9;
        color: #64748b;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 16px;
        border: none;
    }
    .supplier-table td {
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f3;
    }
    
    .status-badge {
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-active { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16,185,129,0.2); }
    .status-inactive { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.2); }

    .btn-action {
        width: 36px; height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s;
        border: 1px solid #edf2f0;
        background: #f8faf9;
        text-decoration: none;
    }
    .btn-action:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.08); }
</style>

<div class="container py-4">
<div class="row g-4 mb-5">
    <div class="col-12">
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" style="border-radius:12px;">
                <i class="bi bi-check-circle-fill me-2"></i> <?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" style="border-radius:12px;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="supplier-card">
            <div class="p-4 d-flex justify-content-between align-items-center border-bottom">
                <div>
                    <h5 class="fw-bold m-0 text-dark"><?= $title ?></h5>
                    <p class="small text-muted m-0">Total: <?= count($suppliers) ?> supplier terdaftar</p>
                </div>
                <button class="btn btn-success rounded-pill px-4 fw-bold" onclick="openSupplierModal()">
                    <i class="bi bi-person-plus-fill me-2"></i> Tambah Supplier
                </button>
            </div>
            
            <div class="table-responsive responsive-card-table">
                <table class="table supplier-table mb-0">
                    <thead>
                        <tr>
                            <th>Nama Supplier</th>
                            <th>Email (Login)</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($suppliers as $s): ?>
                        <tr>
                            <td data-label="NAMA SUPPLIER">
                                <div class="fw-bold text-dark"><?= htmlspecialchars($s['name']) ?></div>
                                <div class="small text-muted"><?= $s['address'] ?: 'Alamat belum diisi' ?></div>
                            </td>
                            <td data-label="EMAIL"><code class="text-primary"><?= htmlspecialchars($s['email']) ?></code></td>
                            <td data-label="KONTAK">
                                <div class="small fw-bold"><?= htmlspecialchars($s['phone']) ?: '-' ?></div>
                            </td>
                            <td data-label="STATUS">
                                <span class="status-badge status-<?= $s['status'] ?>"><?= $s['status'] ?></span>
                            </td>
                            <td class="text-center" data-label="AKSI">
                                <button class="btn-action text-primary me-1" onclick="editSupplier(<?= htmlspecialchars(json_encode($s)) ?>)" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <a href="<?= site_url('admin_suppliers/delete/'.$s['id']) ?>" class="btn-action text-danger" onclick="return confirm('Hapus supplier ini?')" title="Hapus">
                                    <i class="bi bi-trash3-fill"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($suppliers)): ?>
                            <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada data supplier.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Supplier -->
<div class="modal fade" id="supplierModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold text-success" id="supplierModalTitle">Tambah Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('admin_suppliers/save') ?>" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="supplierId">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama / PT Supplier</label>
                        <input type="text" name="name" id="supplierName" class="form-control rounded-3" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Email (Untuk Login)</label>
                            <input type="email" name="email" id="supplierEmail" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" id="supplierStatus" class="form-select rounded-3">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">No. Telp / WA</label>
                        <input type="text" name="phone" id="supplierPhone" class="form-control rounded-3">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alamat</label>
                        <textarea name="address" id="supplierAddress" class="form-control rounded-3" rows="2"></textarea>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold" id="passLabel">Password</label>
                        <input type="password" name="password" id="supplierPassword" class="form-control rounded-3" placeholder="Isi untuk ganti/buat password">
                        <small class="text-muted" style="font-size: 0.7rem;">Wajib diisi untuk supplier baru. Kosongkan jika tidak ingin ganti password.</small>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-bold">Simpan Data Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>

<script>
    let supplierModal;
    document.addEventListener('DOMContentLoaded', function() {
        supplierModal = new bootstrap.Modal(document.getElementById('supplierModal'));
    });

    function openSupplierModal() {
        document.getElementById('supplierModalTitle').innerText = 'Tambah Supplier Baru';
        document.getElementById('supplierId').value = '';
        document.getElementById('supplierName').value = '';
        document.getElementById('supplierEmail').value = '';
        document.getElementById('supplierEmail').readOnly = false;
        document.getElementById('supplierPhone').value = '';
        document.getElementById('supplierAddress').value = '';
        document.getElementById('supplierStatus').value = 'active';
        document.getElementById('passLabel').innerText = 'Password';
        document.getElementById('supplierPassword').required = true;
        supplierModal.show();
    }

    function editSupplier(data) {
        document.getElementById('supplierModalTitle').innerText = 'Edit Supplier';
        document.getElementById('supplierId').value = data.id;
        document.getElementById('supplierName').value = data.name;
        document.getElementById('supplierEmail').value = data.email;
        document.getElementById('supplierEmail').readOnly = true;
        document.getElementById('supplierPhone').value = data.phone;
        document.getElementById('supplierAddress').value = data.address;
        document.getElementById('supplierStatus').value = data.status;
        document.getElementById('passLabel').innerText = 'Ganti Password (Opsional)';
        document.getElementById('supplierPassword').required = false;
        supplierModal.show();
    }
</script>
