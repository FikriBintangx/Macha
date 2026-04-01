<style>
    /* VARIABLES (Matching wrapper.php) */
    :root {
        --gd: #05261a;
        --gm: #40916c;
        --gl: #95d5b2;
        --cream: #f0f4f1;
        --txt: #1a2e25;
    }

    /* PREMIUM CARD */
    .premium-card {
        background: #fff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 40px rgba(45, 90, 39, 0.06);
        overflow: hidden;
    }
    .premium-header {
        background: linear-gradient(135deg, #ffffff, #f9fbf9);
        border-bottom: 2px solid #edf1ed;
        padding: 24px 32px;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .header-icon {
        width: 46px; 
        height: 46px;
        background: linear-gradient(135deg, var(--gm), #2d6a4f);
        color: #fff;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        box-shadow: 0 6px 16px rgba(64,145,108,0.25);
    }
    .premium-title {
        margin: 0;
        font-weight: 800;
        font-size: 1.25rem;
        color: var(--gd);
        letter-spacing: -0.3px;
    }
    .premium-desc {
        margin: 0;
        font-size: 0.85rem;
        color: #8aa898;
        font-weight: 500;
    }

    .premium-body {
        padding: 36px 32px;
    }

    /* PREMIUM INPUTS */
    .p-label {
        font-weight: 700;
        color: #2c3e30;
        font-size: 0.95rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .p-control {
        border: 2px solid #e5ebe5;
        border-radius: 16px;
        padding: 14px 18px;
        font-family: inherit;
        font-size: 0.95rem;
        background: #f9fbf9;
        transition: all 0.3s ease;
        color: var(--txt);
    }
    .p-control:focus {
        border-color: var(--gm);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(64,145,108,0.15);
        outline: none;
    }
    .p-help {
        font-size: 0.82rem;
        color: #7b998a;
        margin-top: 8px;
        display: flex;
        gap: 6px;
        align-items: flex-start;
    }

    /* CUSTOM FILE UPLOAD */
    .file-upload-wrap {
        border: 2px dashed #c4d9cc;
        border-radius: 16px;
        background: #f4f8f5;
        padding: 24px;
        text-align: center;
        transition: all 0.3s;
        position: relative;
    }
    .file-upload-wrap:hover {
        border-color: var(--gm);
        background: #eef5f1;
    }
    .file-input {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    .file-btn {
        background: #fff;
        border: 2px solid #dce8dc;
        border-radius: 10px;
        padding: 8px 16px;
        font-weight: 600;
        color: var(--gm);
        font-size: 0.85rem;
        pointer-events: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    }

    /* PREVIEW IMG */
    .img-preview {
        margin-top: 16px;
        border-radius: 16px;
        overflow: hidden;
        border: 2px solid #e9ede9;
        display: inline-block;
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        background: #fff;
        padding: 4px;
    }
    .img-preview img {
        display: block;
        max-height: 140px;
        border-radius: 12px;
        object-fit: cover;
    }

    /* BUTTONS */
    .btn-save {
        background: linear-gradient(135deg, var(--gm), #2d6a4f);
        color: #fff;
        border-radius: 14px;
        padding: 14px 28px;
        font-weight: 700;
        font-size: 1rem;
        border: none;
        box-shadow: 0 6px 20px rgba(64,145,108,0.3);
        transition: all 0.25s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(64,145,108,0.4);
        color: #fff;
    }
    .btn-back {
        background: #f0f4f1;
        color: #4a6050;
        border-radius: 14px;
        padding: 14px 28px;
        font-weight: 600;
        border: 1px solid #dce5df;
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-back:hover {
        background: #e2ebe4;
        color: var(--gd);
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
                    <i class="bi bi-shop-window"></i>
                </div>
                <div>
                    <h2 class="premium-title">Identitas Toko & Website</h2>
                    <p class="premium-desc">Kelola profil toko fisik dan foto pengantar (*storytelling*) yang tampil di Beranda.</p>
                </div>
            </div>

            <div class="premium-body">
                <form action="<?= base_url('settings/update') ?>" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-5">
                        <label class="p-label pb-2">
                            <i class="bi bi-patch-check-fill text-success opacity-75"></i> Logo Utama Website (Opsional)
                        </label>
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
                        <div class="p-help mt-2">Dianjurkan format PNG transparan atau SVG. Maksimal 1MB. Ini akan menggantikan <i class="fa-solid fa-leaf text-success"></i> MariMacha di seluruh halaman.</div>
                    </div>

                    <div class="mb-5">
                        <label for="shop_address" class="p-label">
                            <i class="bi bi-geo-alt-fill text-success opacity-75"></i> Alamat Fisik Toko
                        </label>
                        <textarea name="shop_address" id="shop_address" class="form-control p-control" rows="4" placeholder="Misal: Jl. Mawar No. 12, Kota Hijau..." required><?= set_value('shop_address', $shop_address ?? '') ?></textarea>
                        <div class="p-help">
                            <i class="bi bi-info-circle-fill pt-1"></i>
                            <span>Alamat ini akan ditampilkan secara publik pada section <strong>Tentang Kami</strong> di Beranda pembeli.</span>
                        </div>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6 border-end" style="border-color: #f0f4f1 !important;">
                            <label class="p-label">
                                <i class="bi bi-images text-success opacity-75"></i> Foto Story 1 (Bahan Baku)
                            </label>
                            
                            <div class="file-upload-wrap mt-2">
                                <input type="file" name="story_img_1" id="story_img_1" class="file-input" accept="image/*" onchange="previewImg(this, 'preview1')">
                                <i class="bi bi-cloud-arrow-up text-success fs-1 opacity-50"></i>
                                <h6 class="mt-3 mb-1 fw-bold text-dark">Klik atau Drop Foto di Sini</h6>
                                <span class="btn file-btn"><i class="bi bi-folder2-open"></i> Pilih Berkas</span>
                            </div>
                            <div class="p-help mt-3">Disarankan rasio kotak 1:1 (contoh: 500x500px). Maksimal 2MB.</div>

                            <?php if(!empty($story_img_1)): ?>
                                <div class="img-preview mt-3">
                                    <img src="<?= base_url('uploads/'.$story_img_1) ?>" alt="Story 1" id="preview1">
                                </div>
                            <?php else: ?>
                                <div class="img-preview mt-3" style="display:none;" id="preview1_wrap">
                                    <img src="" alt="Story 1" id="preview1">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <label class="p-label">
                                <i class="bi bi-images text-success opacity-75"></i> Foto Story 2 (Proses)
                            </label>
                            
                            <div class="file-upload-wrap mt-2">
                                <input type="file" name="story_img_2" id="story_img_2" class="file-input" accept="image/*" onchange="previewImg(this, 'preview2')">
                                <i class="bi bi-cloud-arrow-up text-success fs-1 opacity-50"></i>
                                <h6 class="mt-3 mb-1 fw-bold text-dark">Klik atau Drop Foto di Sini</h6>
                                <span class="btn file-btn"><i class="bi bi-folder2-open"></i> Pilih Berkas</span>
                            </div>
                            <div class="p-help mt-3">Dianjurkan resolusi yang senada dengan Foto 1 agar estetik.</div>

                            <?php if(!empty($story_img_2)): ?>
                                <div class="img-preview mt-3">
                                    <img src="<?= base_url('uploads/'.$story_img_2) ?>" alt="Story 2" id="preview2">
                                </div>
                            <?php else: ?>
                                <div class="img-preview mt-3" style="display:none;" id="preview2_wrap">
                                    <img src="" alt="Story 2" id="preview2">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <hr style="border-color: #e5ebe5; margin-bottom: 30px;">

                    <div class="d-flex align-items-center gap-3">
                        <button type="submit" class="btn btn-save">
                            <i class="bi bi-check2-circle"></i> Simpan Perubahan
                        </button>
                        <a href="<?= base_url('dashboard') ?>" class="btn btn-back">Batal</a>
                    </div>

                </form>
            </div>
        </div>

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
