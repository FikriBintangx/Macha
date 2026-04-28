<style>
    .user-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #edf2f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .user-table thead th {
        background: #f8faf9;
        color: #64748b;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 16px;
        border: none;
    }
    .user-table td {
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f3;
    }
    .avatar-circle {
        width: 40px;
        height: 40px;
        background: #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #475569;
        overflow: hidden;
    }
    .avatar-circle img { width: 100%; height: 100%; object-fit: cover; }
    
    .role-badge {
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .role-admin { background: rgba(16, 185, 129, 0.1); color: #059669; }
    .role-owner { background: rgba(139, 92, 246, 0.1); color: #6d28d9; }
    .role-staff { background: rgba(59, 130, 246, 0.1); color: #2563eb; }
    .role-user { background: rgba(100, 116, 139, 0.1); color: #475569; }

    .btn-action {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
        border: none;
        background: #f8faf9;
    }
    .btn-action:hover { transform: translateY(-2px); }
</style>

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

        <div class="user-card">
            <div class="p-4 d-flex justify-content-between align-items-center border-bottom">
                <div>
                    <h5 class="fw-bold m-0 text-dark"><?= $title ?></h5>
                    <p class="small text-muted m-0">Total: <?= count($users) ?> orang terdaftar</p>
                </div>
                <?php if($type == 'staff'): ?>
                    <button class="btn btn-success rounded-pill px-4 fw-bold" onclick="openUserModal()">
                        <i class="bi bi-person-plus-fill me-2"></i> Tambah Staff
                    </button>
                <?php endif; ?>
            </div>
            
            <div class="table-responsive">
                <table class="table user-table mb-0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Username</th>
                            <th>Kontak</th>
                            <th>Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $u): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle">
                                        <?php if($u['profile_image'] && $u['profile_image'] != 'default_user.png'): ?>
                                            <img src="<?= base_url('uploads/profile/'.$u['profile_image']) ?>" alt="">
                                        <?php else: ?>
                                            <?= strtoupper(substr($u['full_name'], 0, 1)) ?>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($u['full_name']) ?></div>
                                        <div class="small text-muted"><?= $u['address'] ?: 'Alamat belum diisi' ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><code class="text-primary"><?= $u['username'] ?></code></td>
                            <td>
                                <div class="small fw-bold"><?= $u['phone'] ?: '-' ?></div>
                            </td>
                            <td>
                                <span class="role-badge role-<?= $u['role'] ?>"><?= $u['role'] ?></span>
                            </td>
                            <td class="text-center">
                                <?php if($u['role'] !== 'user'): ?>
                                <button class="btn-action text-primary me-1" onclick="editUser(<?= htmlspecialchars(json_encode($u)) ?>)" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <?php endif; ?>
                                <?php if($u['id'] != $this->session->userdata('userid')): ?>
                                <a href="<?= site_url('admin_users/delete/'.$u['id']) ?>" class="btn-action text-danger" onclick="return confirm('Hapus user ini?')" title="Hapus">
                                    <i class="bi bi-trash3-fill"></i>
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($users)): ?>
                            <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada data user.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal User -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold text-success" id="userModalTitle">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-modal="modal" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= site_url('admin_users/save') ?>" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="userId">
                    <input type="hidden" name="redirect_url" value="<?= current_url() ?>">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Full Name</label>
                        <input type="text" name="full_name" id="userFullName" class="form-control rounded-3" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Username</label>
                            <input type="text" name="username" id="userUsername" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Role</label>
                            <select name="role" id="userRole" class="form-select rounded-3">
                                <option value="user">Pelanggan (User)</option>
                                <option value="staff">Staff</option>
                                <option value="admin">Admin</option>
                                <option value="owner">Owner</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Phone</label>
                        <input type="text" name="phone" id="userPhone" class="form-control rounded-3">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Address</label>
                        <textarea name="address" id="userAddress" class="form-control rounded-3" rows="2"></textarea>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold" id="passLabel">Password</label>
                        <input type="password" name="password" id="userPassword" class="form-control rounded-3" placeholder="Kosongkan jika tidak ingin ganti">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-bold">Simpan Data User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let userModal;
    document.addEventListener('DOMContentLoaded', function() {
        userModal = new bootstrap.Modal(document.getElementById('userModal'));
    });

    function openUserModal() {
        document.getElementById('userModalTitle').innerText = 'Tambah User Baru';
        document.getElementById('userId').value = '';
        document.getElementById('userFullName').value = '';
        document.getElementById('userUsername').value = '';
        document.getElementById('userUsername').readOnly = false;
        document.getElementById('userPhone').value = '';
        document.getElementById('userAddress').value = '';
        document.getElementById('userRole').value = 'staff';
        document.getElementById('passLabel').innerText = 'Password';
        document.getElementById('userPassword').required = true;
        userModal.show();
    }

    function editUser(data) {
        document.getElementById('userModalTitle').innerText = 'Edit User';
        document.getElementById('userId').value = data.id;
        document.getElementById('userFullName').value = data.full_name;
        document.getElementById('userUsername').value = data.username;
        document.getElementById('userUsername').readOnly = true;
        document.getElementById('userPhone').value = data.phone;
        document.getElementById('userAddress').value = data.address;
        document.getElementById('userRole').value = data.role;
        document.getElementById('passLabel').innerText = 'Ganti Password (Opsional)';
        document.getElementById('userPassword').required = false;
        userModal.show();
    }
</script>
