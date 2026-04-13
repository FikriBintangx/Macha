<style>
    /* VARIABLES (Sophisticated Green Theme) */
    :root {
        --gd: #05261a;
        --gm: #1b4332;
        --gl: #52b788;
        --gx: #d8f3dc;
        --cream: #fafdfb;
        --txt: #1a2e25;
        --muted: #6c757d;
        --border: #e9ecef;
    }

    body {
        background-color: #f4f7f6;
        color: var(--txt);
    }

    /* PREMIUM CARD */
    .premium-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #edf2f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .premium-header {
        background: #fff;
        padding: 24px 32px;
        display: flex;
        align-items: center;
        gap: 16px;
        border-bottom: 2px solid #f8faf9;
    }
    .header-icon {
        width: 48px; height: 48px;
        background: linear-gradient(135deg, var(--gm), #2d6a4f);
        color: #fff;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        box-shadow: 0 5px 15px rgba(27,67,50,0.2);
    }
    .premium-title { font-weight: 800; font-size: 1.4rem; color: var(--gd); margin: 0; }
    .premium-desc { font-size: 0.88rem; color: var(--muted); margin: 0; }

    /* PREMIUM TABS (Pill Button Style - User Request) */
    .settings-nav {
        background: #f1f3f2;
        padding: 12px 24px;
        border-bottom: 2px solid #e0e6e2;
        display: flex;
        gap: 12px;
    }
    .settings-nav .nav-link {
        border: none !important;
        padding: 10px 24px;
        font-weight: 700;
        font-size: 0.9rem;
        color: #000 !important; /* Always Black Text */
        background: #fff;
        border-radius: 12px !important;
        transition: all 0.3s;
        box-shadow: 0 4px 8px rgba(0,0,0,0.04);
        opacity: 0.9;
    }
    .settings-nav .nav-link:hover {
        background: #e1e8e4;
        opacity: 1;
    }
    .settings-nav .nav-link.active {
        color: #000 !important; /* Black Text as requested */
        background: #52b788 !important; /* Bright Green BG */
        opacity: 1;
        box-shadow: 0 4px 15px rgba(82,183,136,0.25);
    }

    .premium-body { padding: 40px 32px; }

    /* TABLES & ALERTS */
    .table thead th { background: #f8faf9; color: var(--muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; padding: 12px 16px; border: none; }
    .table td { border-bottom: 1px solid #f1f5f3; padding: 16px; vertical-align: middle; }
    
    .p-control { background: #fbfdfc; border: 2px solid #edf1ef; border-radius: 12px; padding: 12px 16px; transition: all 0.3s; width: 100%; }
    .p-control:focus { border-color: var(--gl); background: #fff; box-shadow: 0 0 0 4px rgba(82,183,136,0.1); outline: none; }
    .p-label { font-weight: 700; color: #000; font-size: 0.92rem; margin-bottom: 10px; display: flex; align-items: center; gap: 8px; }

    .btn-save { background: var(--gm); color: #fff; border-radius: 12px; font-weight: 700; padding: 12px 32px; box-shadow: 0 4px 12px rgba(27,67,50,0.25); border: none; }
    .btn-save:hover { background: #2d6a4f; color: #fff; transform: translateY(-2px); }

    /* CUSTOM FILE UPLOAD FIX */
    .file-upload-wrap {
        border: 2px dashed #c4d9cc;
        border-radius: 16px;
        background: #f8fbfa;
        padding: 24px;
        text-align: center;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    .file-input {
        position: absolute;
        top: 0; left: 0; 
        width: 100%; height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 10;
    }
    .file-btn {
        background: #fff;
        border: 2px solid #dce8dc;
        border-radius: 10px;
        padding: 8px 16px;
        font-weight: 600;
        color: var(--gm);
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
        position: relative;
        z-index: 5;
    }
</style>

<div class="row g-4 justify-content-center pt-2 pb-5">
    <div class="col-lg-10 col-xl-9">
        
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 16px; border:none; background:#d1e7dd; color:#0f5132; box-shadow:0 4px 15px rgba(20,80,40,0.1);">
                <i class="bi bi-check-circle-fill me-2"></i><strong>Berhasil!</strong> <?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 16px; border:none; background:#f8d7da; color:#842029; box-shadow:0 4px 15px rgba(132,32,41,0.1);">
                <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Gagal!</strong> <?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="premium-card">
            <div class="premium-header">
                <div class="header-icon">
                    <i class="bi bi-gear-wide-connected"></i>
                </div>
                <div>
                    <h2 class="premium-title">Pusat Pengaturan & Master Data</h2>
                    <p class="premium-desc">Kelola identitas website, kategori menu, tipe pesanan, hingga metode pembayaran.</p>
                </div>
            </div>

            <!-- TAB NAV -->
            <ul class="nav settings-nav" id="settingsTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">Identitas Toko</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button" role="tab">Kategori Menu</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="order-types-tab" data-bs-toggle="tab" data-bs-target="#order-types" type="button" role="tab">Tipe Pesanan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="payment-methods-tab" data-bs-toggle="tab" data-bs-target="#payment-methods" type="button" role="tab">Metode Bayar</button>
                </li>
            </ul>

            <div class="premium-body">
                <!-- FLASH MESSAGES -->
                <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius:12px;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                        <div><?= $this->session->flashdata('success') ?></div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius:12px;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                        <div><?= $this->session->flashdata('error') ?></div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <div class="tab-content pt-2" id="settingsTabContent">
                
                <!-- TAB 1: GENERAL -->
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <form action="<?= base_url('settings/update') ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-5">
                            <label class="p-label pb-2"><i class="bi bi-patch-check-fill text-success opacity-75"></i> Logo Utama Website</label>
                            <div class="d-flex align-items-center gap-4">
                                <?php if(!empty($shop_logo)): ?>
                                    <div class="img-preview mt-0" style="width:70px;height:70px;flex-shrink:0;border-radius:12px;">
                                        <img src="<?= base_url('uploads/'.$shop_logo) ?>" alt="Logo" id="preview_logo" style="width:100%;height:100%;max-height:100%;object-fit:cover;">
                                    </div>
                                <?php else: ?>
                                    <div class="img-preview mt-0" style="width:70px;height:70px;flex-shrink:0;border-radius:12px;display:flex;align-items:center;justify-content:center;background:#f0f4f1;" id="preview_logo_wrap">
                                        <img src="" alt="Logo" id="preview_logo" style="width:100%;height:100%;max-height:100%;object-fit:cover;display:none;">
                                        <i class="bi bi-image text-muted fs-4"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="file-upload-wrap flex-grow-1" style="padding:16px;">
                                    <input type="file" name="shop_logo" id="shop_logo" class="file-input" accept="image/*" onchange="previewLogo(this, 'preview_logo')">
                                    <span class="fw-bold text-dark d-block mb-1">Upload Logo Baru</span>
                                    <span class="btn file-btn mt-0"><i class="bi bi-arrow-up-circle"></i> Pilih Logo</span>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="shop_status" class="p-label"><i class="bi bi-shop text-success opacity-75"></i> Status Website (Buka/Tutup)</label>
                                <select name="shop_status" id="shop_status" class="form-control p-control">
                                    <option value="open" <?= $shop_status == 'open' ? 'selected' : '' ?>>🟢 Buka (User Bisa Pesan)</option>
                                    <option value="closed" <?= $shop_status == 'closed' ? 'selected' : '' ?>>🔴 Tutup (Hanya Lihat Menu)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="whatsapp_number" class="p-label"><i class="bi bi-whatsapp text-success opacity-75"></i> Nomor WhatsApp Admin</label>
                                <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control p-control" placeholder="Contoh: 628123456789" value="<?= set_value('whatsapp_number', $whatsapp_number ?? '') ?>">
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="shop_address" class="p-label"><i class="bi bi-geo-alt-fill text-success opacity-75"></i> Alamat Fisik Toko</label>
                            <textarea name="shop_address" id="shop_address" class="form-control p-control" rows="4" placeholder="Misal: Jl. Mawar No. 12, Kota Hijau..." required><?= set_value('shop_address', $shop_address ?? '') ?></textarea>
                        </div>

                        <div class="row g-4 mb-5">
                             <div class="col-md-4 border-end" style="border-color: #f0f4f1 !important;">
                                <label class="p-label"><i class="bi bi-qr-code text-success opacity-75"></i> Barcode QRIS</label>
                                <div class="file-upload-wrap mt-2">
                                    <input type="file" name="qris_barcode" id="qris_barcode" class="file-input" accept="image/*" onchange="previewImg(this, 'preview_qris')">
                                    <i class="bi bi-upc-scan text-success fs-1 opacity-50"></i>
                                    <span class="btn file-btn"><i class="bi bi-folder2-open"></i> Pilih Berkas</span>
                                </div>
                                <?php if(!empty($qris_barcode)): ?>
                                    <div class="img-preview mt-3" style="width:100px; height:auto; overflow:hidden;">
                                        <img src="<?= base_url('uploads/'.$qris_barcode) ?>" alt="QRIS Barcode" id="preview_qris" style="width:100%; height:auto;">
                                    </div>
                                <?php else: ?>
                                    <div class="img-preview mt-3" id="preview_qris_wrap" style="display:none;">
                                        <img src="" alt="QRIS Barcode" id="preview_qris" style="width:100px; height:auto;">
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4 border-end" style="border-color: #f0f4f1 !important;">
                                <label class="p-label"><i class="bi bi-images text-success opacity-75"></i> Foto Story 1</label>
                                <div class="file-upload-wrap mt-2">
                                    <input type="file" name="story_img_1" id="story_img_1" class="file-input" accept="image/*" onchange="previewImg(this, 'preview1')">
                                    <i class="bi bi-cloud-arrow-up text-success fs-1 opacity-50"></i>
                                    <span class="btn file-btn"><i class="bi bi-folder2-open"></i> Pilih Berkas</span>
                                </div>
                                <?php if(!empty($story_img_1)): ?><div class="img-preview mt-3"><img src="<?= base_url('uploads/'.$story_img_1) ?>" alt="Story 1" id="preview1"></div><?php endif; ?>
                            </div>
                            <div class="col-md-4">
                                <label class="p-label"><i class="bi bi-images text-success opacity-75"></i> Foto Story 2</label>
                                <div class="file-upload-wrap mt-2">
                                    <input type="file" name="story_img_2" id="story_img_2" class="file-input" accept="image/*" onchange="previewImg(this, 'preview2')">
                                    <i class="bi bi-cloud-arrow-up text-success fs-1 opacity-50"></i>
                                    <span class="btn file-btn"><i class="bi bi-folder2-open"></i> Pilih Berkas</span>
                                </div>
                                <?php if(!empty($story_img_2)): ?><div class="img-preview mt-3"><img src="<?= base_url('uploads/'.$story_img_2) ?>" alt="Story 2" id="preview2"></div><?php endif; ?>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-save px-5"><i class="bi bi-check2-circle"></i> Simpan Identitas</button>

                    </form>
                </div>

                <!-- TAB 2: CATEGORIES -->
                <div class="tab-pane fade" id="categories" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <h6 class="fw-bold m-0"><i class="bi bi-tags me-2"></i>Daftar Kategori</h6>
                            <button class="btn btn-outline-danger btn-sm rounded-pill px-3 d-none" id="bulkDeleteCategories" onclick="bulkDelete('categories')"><i class="bi bi-trash"></i> Hapus Terpilih</button>
                        </div>
                        <button type="button" class="btn btn-success btn-sm rounded-pill px-3 fw-bold" onclick="openModal('categories')"><i class="bi bi-plus-lg"></i> Tambah Kategori</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="tableCategories">
                            <thead><tr><th width="40"><input type="checkbox" onchange="checkAll(this, 'categories')"></th><th>ID</th><th>Nama Kategori</th><th class="text-center">Aksi</th></tr></thead>
                            <tbody>
                                <?php foreach($categories as $c): ?>
                                <tr>
                                    <td><input type="checkbox" class="check-item-categories" value="<?= $c['id'] ?>" onchange="toggleBulkBtn('categories')"></td>
                                    <td><?= $c['id'] ?></td>
                                    <td class="fw-bold"><?= htmlspecialchars($c['category_name']) ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-light border-0 shadow-sm mx-1" onclick="editModal('categories', <?= $c['id'] ?>, '<?= addslashes($c['category_name']) ?>')"><i class="bi bi-pencil-square text-primary"></i></button>
                                        <button class="btn btn-sm btn-light border-0 shadow-sm mx-1" onclick="deleteMaster('categories', <?= $c['id'] ?>)"><i class="bi bi-trash3-fill text-danger"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 3: ORDER TYPES -->
                <div class="tab-pane fade" id="order-types" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <h6 class="fw-bold m-0"><i class="bi bi-truck me-2"></i>Tipe Pesanan</h6>
                            <button class="btn btn-outline-danger btn-sm rounded-pill px-3 d-none" id="bulkDeleteOrderTypes" onclick="bulkDelete('order_types')"><i class="bi bi-trash"></i> Hapus Terpilih</button>
                        </div>
                        <button type="button" class="btn btn-success btn-sm rounded-pill px-3 fw-bold" onclick="openModal('order_types')"><i class="bi bi-plus-lg"></i> Tambah Tipe</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead><tr><th width="40"><input type="checkbox" onchange="checkAll(this, 'order_types')"></th><th>ID</th><th>Nama Tipe</th><th>Kode (Unik)</th><th class="text-center">Aksi</th></tr></thead>
                            <tbody>
                                <?php foreach($order_types as $o): ?>
                                <tr>
                                    <td><input type="checkbox" class="check-item-order_types" value="<?= $o['id'] ?>" onchange="toggleBulkBtn('order_types')"></td>
                                    <td><?= $o['id'] ?></td>
                                    <td class="fw-bold text-success"><?= htmlspecialchars($o['type_name']) ?></td>
                                    <td><code class="px-2 py-1 bg-light rounded text-dark border"><?= $o['type_code'] ?></code></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-light border-0 shadow-sm mx-1" onclick="editModal('order_types', <?= $o['id'] ?>, '<?= addslashes($o['type_name']) ?>', '<?= $o['type_code'] ?>')"><i class="bi bi-pencil-square text-primary"></i></button>
                                        <button class="btn btn-sm btn-light border-0 shadow-sm mx-1" onclick="deleteMaster('order_types', <?= $o['id'] ?>)"><i class="bi bi-trash3-fill text-danger"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 4: PAYMENT METHODS -->
                <div class="tab-pane fade" id="payment-methods" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <h6 class="fw-bold m-0"><i class="bi bi-wallet2 me-2"></i>Metode Pembayaran</h6>
                            <button class="btn btn-outline-danger btn-sm rounded-pill px-3 d-none" id="bulkDeletePayments" onclick="bulkDelete('payment_methods')"><i class="bi bi-trash"></i> Hapus Terpilih</button>
                        </div>
                        <button type="button" class="btn btn-success btn-sm rounded-pill px-3 fw-bold" onclick="openModal('payment_methods')"><i class="bi bi-plus-lg"></i> Tambah Metode</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead><tr><th width="40"><input type="checkbox" onchange="checkAll(this, 'payment_methods')"></th><th>ID</th><th>Nama Metode</th><th>Kode</th><th>Keterangan / No Rek</th><th class="text-center">Aksi</th></tr></thead>
                            <tbody>
                                <?php foreach($payment_types as $p): ?>
                                <tr>
                                    <td><input type="checkbox" class="check-item-payment_methods" value="<?= $p['id'] ?>" onchange="toggleBulkBtn('payment_methods')"></td>
                                    <td><?= $p['id'] ?></td>
                                    <td class="fw-bold text-success"><?= htmlspecialchars($p['method_name']) ?></td>
                                    <td><code class="px-2 py-1 bg-light rounded text-dark border"><?= $p['method_code'] ?></code></td>
                                    <td><small><?= htmlspecialchars($p['description'] ?? '-') ?></small></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-light border-0 shadow-sm mx-1" onclick="editModal('payment_methods', <?= $p['id'] ?>, '<?= addslashes($p['method_name']) ?>', '<?= $p['method_code'] ?>', '<?= addslashes($p['description'] ?? '') ?>')"><i class="bi bi-pencil-square text-primary"></i></button>
                                        <button class="btn btn-sm btn-light border-0 shadow-sm mx-1" onclick="deleteMaster('payment_methods', <?= $p['id'] ?>)"><i class="bi bi-trash3-fill text-danger"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal CRUD Master -->
<div class="modal fade" id="modalMaster" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold text-success" id="modalTitle">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formMaster" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="masterId">
                    <div class="mb-3">
                        <label class="p-label" id="labelName">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="masterName" class="form-control p-control" required placeholder="Contoh: Fruit Series / Delivery">
                    </div>
                    <div class="mb-3 d-none" id="wrapCode">
                        <label class="p-label">Kode Unik (Inggris/Kecil) <span class="text-danger">*</span></label>
                        <input type="text" name="code" id="masterCode" class="form-control p-control" placeholder="Contoh: takeaway atau cod">
                    </div>
                    <div class="mb-1 d-none" id="wrapDesc">
                        <label class="p-label">Keterangan / Nomor Rekening</label>
                        <textarea name="desc" id="masterDesc" class="form-control p-control" rows="3" placeholder="Contoh: BCA 1234567890 a/n MariMacha"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-save w-100"><i class="bi bi-check-circle-fill me-2"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="formDelete" method="POST" class="d-none">
    <input type="hidden" name="id" id="deleteId">
    <input type="hidden" name="action" value="delete">
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize Modal properly
        const masterModalEl = document.getElementById('modalMaster');
        let modalMasterInstance;
        
        if (masterModalEl) {
            modalMasterInstance = new bootstrap.Modal(masterModalEl);
        }

        const formMaster = document.getElementById('formMaster');
        const masterTitle = document.getElementById('modalTitle');
        const wrapCode = document.getElementById('wrapCode');
        const wrapDesc = document.getElementById('wrapDesc');
        const btnSaveMaster = formMaster ? formMaster.querySelector('.btn-save') : null;

        window.openModal = function(table) {
            console.log("Opening Add Modal for:", table);
            if (!formMaster) return;
            formMaster.action = "<?= base_url('settings/crud/') ?>" + table;
            masterTitle.innerHTML = '<i class="bi bi-plus-circle me-2"></i> Tambah ' + table.replace('_', ' ');
            document.getElementById('masterId').value = "";
            document.getElementById('masterName').value = "";
            document.getElementById('masterCode').value = "";
            document.getElementById('masterDesc').value = "";
            
            if(table !== 'categories') {
                wrapCode.classList.remove('d-none');
                wrapDesc.classList.remove('d-none');
            } else {
                wrapCode.classList.add('d-none');
                wrapDesc.classList.add('d-none');
            }
            
            if (modalMasterInstance) modalMasterInstance.show();
        };

        window.editModal = function(table, id, name, code = '', desc = '') {
            console.log("Opening Edit Modal for:", table, "ID:", id);
            if (!formMaster) return;
            formMaster.action = "<?= base_url('settings/crud/') ?>" + table;
            masterTitle.innerHTML = '<i class="bi bi-pencil-square me-2"></i> Edit ' + table.replace('_', ' ');
            document.getElementById('masterId').value = id;
            document.getElementById('masterName').value = name;
            document.getElementById('masterCode').value = code;
            document.getElementById('masterDesc').value = desc;

            if(table !== 'categories') {
                wrapCode.classList.remove('d-none');
                wrapDesc.classList.remove('d-none');
            } else {
                wrapCode.classList.add('d-none');
                wrapDesc.classList.add('d-none');
            }

            if (modalMasterInstance) modalMasterInstance.show();
        };

        if (formMaster) {
            formMaster.onsubmit = function() {
                if (btnSaveMaster) {
                    btnSaveMaster.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Menyimpan...';
                    btnSaveMaster.disabled = true;
                }
            };
        }

        window.deleteMaster = function(table, id) {
            if(confirm('⚠️ PERINGATAN: Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.')) {
                const form = document.getElementById('formDelete');
                form.action = "<?= base_url('settings/crud/') ?>" + table;
                document.getElementById('deleteId').value = id;
                form.submit();
            }
        };

        window.checkAll = function(trigger, table) {
            const checks = document.querySelectorAll('.check-item-' + table);
            checks.forEach(c => c.checked = trigger.checked);
            window.toggleBulkBtn(table);
        };

        window.toggleBulkBtn = function(table) {
            const count = document.querySelectorAll('.check-item-' + table + ':checked').length;
            const btnId = (table === 'categories') ? 'bulkDeleteCategories' : 
                         (table === 'order_types') ? 'bulkDeleteOrderTypes' : 'bulkDeletePayments';
            const btn = document.getElementById(btnId);
            if(btn) {
                if(count > 0) btn.classList.remove('d-none');
                else btn.classList.add('d-none');
            }
        };

        window.bulkDelete = function(table) {
            const selected = Array.from(document.querySelectorAll('.check-item-' + table + ':checked')).map(c => c.value);
            if(selected.length === 0) return;
            
            if(confirm('🔥 HAPUS MASSAL: Anda memilih ' + selected.length + ' data. Yakin ingin menghapus semuanya?')) {
                const form = document.getElementById('formDelete');
                form.action = "<?= base_url('settings/crud/') ?>" + table;
                document.getElementById('deleteId').value = selected.join(',');
                form.submit();
            }
        };

        // TAB PERSISTENCE ON RELOAD
        const urlParams = new URLSearchParams(window.location.search);
        const tabParam  = urlParams.get('tab');
        if (tabParam) {
            const tabBtn = document.querySelector(`[data-bs-target="#${tabParam}"]`);
            if (tabBtn) {
                try {
                    const tabInstance = new bootstrap.Tab(tabBtn);
                    tabInstance.show();
                } catch(e) { console.error("Tab activation error:", e); }
            }
        }
    });
</script>

    </div>
</div>

<script>
function previewImg(input, imgId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var imgEl = document.getElementById(imgId);
            imgEl.src = e.target.result;
            let wrap = document.getElementById(imgId + '_wrap');
            if(wrap) wrap.style.display = 'inline-block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function previewLogo(input, imgId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var imgEl = document.getElementById(imgId);
            imgEl.src = e.target.result;
            imgEl.style.display = 'block';
            let wrap = document.getElementById(imgId + '_wrap');
            if(wrap) {
                wrap.style.background = 'transparent';
                let icon = wrap.querySelector('i');
                if(icon) icon.style.display = 'none';
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
