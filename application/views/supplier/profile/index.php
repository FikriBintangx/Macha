<style>
.pf-card { background:#fff; border:1px solid #e2e8f0; border-radius:18px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.07); overflow:hidden; }
.pf-label { font-size:0.8rem; font-weight:700; color:#64748b; display:block; margin-bottom:0.4rem; }
.pf-input { width:100%; border:1px solid #e2e8f0; border-radius:12px; padding:10px 14px; font-size:0.875rem; color:#1a2e25; font-family:'Outfit',sans-serif; outline:none; transition:border-color 0.2s; background:#fff; }
.pf-input:focus { border-color:#8BAA7C; box-shadow:0 0 0 3px rgba(139,170,124,0.12); }
.pf-input:disabled { background:#f8fafc; color:#94a3b8; cursor:not-allowed; }
</style>

<!-- Page Header -->
<div style="margin-bottom:1.5rem;">
    <h4 style="font-weight:800; color:#1a2e25; margin-bottom:0.2rem;">Profile</h4>
    <p style="color:#64748b; font-size:0.875rem; margin:0;">Kelola informasi perusahaan dan akun Anda.</p>
</div>

<?php if ($this->session->flashdata('success')): ?>
    <div style="background:rgba(139,170,124,0.15); color:#1B3B25; border:1px solid rgba(139,170,124,0.3); padding:1rem 1.25rem; border-radius:14px; margin-bottom:1.25rem; display:flex; align-items:center; gap:10px;">
        <i class="fas fa-circle-check" style="color:#8BAA7C;"></i>
        <span style="font-size:0.875rem; font-weight:500;"><?= $this->session->flashdata('success') ?></span>
    </div>
<?php endif; ?>

<div class="row g-4">
    <!-- Avatar / Logo card -->
    <div class="col-lg-3">
        <div class="pf-card" style="padding:1.5rem; text-align:center;">
            <!-- Avatar -->
            <?php if (!empty($supplier['logo'])): ?>
                <img src="<?= base_url('uploads/'.$supplier['logo']) ?>" style="width:90px; height:90px; border-radius:50%; object-fit:cover; border:3px solid #8BAA7C; display:block; margin:0 auto 1rem;">
            <?php else: ?>
                <div style="width:90px; height:90px; border-radius:50%; background:linear-gradient(135deg,#1B3B25,#53725D); display:flex; align-items:center; justify-content:center; margin:0 auto 1rem; color:#fff; font-size:2.2rem; font-weight:800;">
                    <?= strtoupper(substr($supplier['name'] ?? 'S', 0, 1)) ?>
                </div>
            <?php endif; ?>
            <div style="font-weight:700; color:#1a2e25; font-size:1rem; margin-bottom:0.25rem;"><?= htmlspecialchars($supplier['name'] ?? '-') ?></div>
            <div style="font-size:0.8rem; color:#94a3b8;">Supplier Partner</div>
            <div style="margin-top:1.25rem; padding-top:1rem; border-top:1px solid #f1f5f9; font-size:0.78rem; color:#64748b;">
                <i class="fas fa-envelope" style="color:#8BAA7C; margin-right:6px;"></i>
                <?= htmlspecialchars($supplier['email'] ?? '-') ?>
            </div>
            <?php if (!empty($supplier['phone'])): ?>
            <div style="margin-top:0.5rem; font-size:0.78rem; color:#64748b;">
                <i class="fas fa-phone" style="color:#8BAA7C; margin-right:6px;"></i>
                <?= htmlspecialchars($supplier['phone']) ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="col-lg-9">
        <div class="pf-card">
            <div style="padding:1rem 1.25rem; border-bottom:1px solid #f1f5f9;">
                <h6 style="font-weight:700; color:#1e293b; font-size:0.95rem; margin:0;">
                    <i class="fas fa-edit" style="color:#8BAA7C; margin-right:6px;"></i> Edit Profile
                </h6>
            </div>
            <div style="padding:1.5rem;">
                <form action="<?= base_url('supplier/profile/update') ?>" method="post" enctype="multipart/form-data">

                    <!-- Upload Logo -->
                    <div style="margin-bottom:1.25rem;">
                        <label class="pf-label">Upload Logo / Photo</label>
                        <input type="file" name="logo" accept="image/*" class="pf-input" style="padding:7px 12px; cursor:pointer;">
                        <small style="color:#94a3b8; font-size:0.75rem;">Format: JPG, PNG. Maks 2MB.</small>
                    </div>

                    <div class="row g-3">
                        <!-- Company Name -->
                        <div class="col-md-6">
                            <label class="pf-label">Company Name <span style="color:#dc2626;">*</span></label>
                            <input type="text" name="name" value="<?= htmlspecialchars($supplier['name'] ?? '') ?>" class="pf-input" required>
                        </div>

                        <!-- Email (disabled) -->
                        <div class="col-md-6">
                            <label class="pf-label">Email Address <span style="color:#94a3b8; font-weight:400; font-size:0.72rem;">(tidak bisa diubah)</span></label>
                            <input type="email" value="<?= htmlspecialchars($supplier['email'] ?? '') ?>" class="pf-input" disabled>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label class="pf-label">Phone Number</label>
                            <input type="text" name="phone" value="<?= htmlspecialchars($supplier['phone'] ?? '') ?>" class="pf-input" placeholder="08xx-xxxx-xxxx">
                        </div>

                        <!-- Address -->
                        <div class="col-md-6">
                            <label class="pf-label">Address</label>
                            <input type="text" name="address" value="<?= htmlspecialchars($supplier['address'] ?? '') ?>" class="pf-input" placeholder="Alamat perusahaan">
                        </div>
                    </div>

                    <hr style="border:none; border-top:1px solid #f1f5f9; margin:1.5rem 0;">

                    <!-- Change Password -->
                    <div style="margin-bottom:1.5rem;">
                        <label class="pf-label">Ganti Password <span style="color:#94a3b8; font-weight:400; font-size:0.72rem;">(kosongkan jika tidak ingin ganti)</span></label>
                        <input type="password" name="password" class="pf-input" placeholder="Password baru...">
                    </div>

                    <div style="display:flex; justify-content:flex-end;">
                        <button type="submit" style="
                            background:#1B3B25; color:#fff; border:none;
                            border-radius:12px; padding:10px 24px;
                            font-size:0.9rem; font-weight:700; cursor:pointer;
                            font-family:'Outfit',sans-serif; transition:all 0.2s;
                            box-shadow:0 4px 12px rgba(27,59,37,0.2);
                        " onmouseover="this.style.background='#53725D';" onmouseout="this.style.background='#1B3B25';">
                            <i class="fas fa-save" style="margin-right:6px;"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
