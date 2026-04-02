<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h4 class="fw-bold" style="color: var(--macha-dark);">
                        <i class="fa-solid fa-plus-circle me-2"></i>Tambah Produk Baru
                    </h4>
                    <p class="text-muted small">Pilih gambar dari koleksi atau unggah baru.</p>
                </div>
                
                <div class="card-body p-4">
                    <form action="<?= base_url('product/save'); ?>" method="post" enctype="multipart/form-data">
                        
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        
                        <input type="hidden" name="image_preset" id="imagePreset" value="">

                        <div class="row g-4">
                            <!-- Left Column: Product Details -->
                            <div class="col-md-6">
                                <div class="card border border-light-subtle rounded-4 p-4 h-100 shadow-none bg-light bg-opacity-10">
                                    <h6 class="fw-bold mb-4 text-secondary border-bottom pb-2">Detail Produk</h6>
                                    
                                    <div class="mb-4">
                                        <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">SKU / KODE PRODUK</label>
                                        <input type="text" name="sku" class="form-control rounded-3 py-2 border-light-subtle" placeholder="Contoh: MC-001">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">NAMA PRODUK</label>
                                        <input type="text" name="name" class="form-control rounded-3 py-2 border-light-subtle" placeholder="Masukkan nama varian" required>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">KATEGORI</label>
                                        <select name="category_id" class="form-select rounded-3 py-2 border-light-subtle" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            <?php foreach($categories as $cat): ?>
                                                <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">HARGA (RP)</label>
                                            <input type="number" name="price" class="form-control rounded-3 py-2 border-light-subtle" placeholder="0" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">STOK AWAL</label>
                                            <input type="number" name="stock" class="form-control rounded-3 py-2 border-light-subtle" placeholder="0" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Image Selection -->
                            <div class="col-md-6">
                                <div class="card border border-light-subtle rounded-4 p-4 h-100 shadow-none bg-light bg-opacity-10">
                                    <h6 class="fw-bold mb-4 text-success border-bottom border-success border-opacity-25 pb-2">
                                        <i class="fa-solid fa-folder-open me-2"></i>KOLEKSI DARI FOLDER UPLOADS
                                    </h6>
                                    
                                    <div class="preset-grid mb-4" id="presetGrid">
                                        <?php 
                                        $upload_path = FCPATH . 'uploads/';
                                        $files = array_diff(scandir($upload_path), array('.', '..'));
                                        $image_files = array_filter($files, function($f) use ($upload_path) {
                                            return is_file($upload_path . $f) && preg_match('/\.(jpg|jpeg|png|webp)$/i', $f);
                                        });
                                        // Take latest 12 images
                                        $image_files = array_reverse(array_slice($image_files, -12));
                                        
                                        foreach($image_files as $img):
                                        ?>
                                        <div class="preset-item" onclick="selectPreset('<?= $img ?>', this)" title="<?= $img ?>">
                                            <div class="preset-img-box shadow-sm">
                                                <img src="<?= base_url('uploads/'.$img) ?>" alt="Preset">
                                            </div>
                                            <div class="preset-name"><?= $img ?></div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">ATAU UNGGAH BARU</label>
                                        <input type="file" name="image" id="imageInput" class="form-control rounded-3 border-light-subtle" accept="image/*">
                                    </div>

                                    <div id="previewArea" class="preview-container p-3 border rounded-4 text-center bg-white" 
                                         style="border-style: dashed !important; border-width: 2px; min-height: 200px; display: flex; align-items: center; justify-content: center;">
                                        
                                        <img id="imagePreview" src="#" alt="Preview" 
                                             style="display: none; max-width: 100%; max-height: 160px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                        
                                        <div id="placeholderText" class="text-muted">
                                            <i class="fa-solid fa-image fs-1 d-block mb-2" style="color: #cbd5e0;"></i>
                                            <p class="mb-0 small fw-bold">Pratinjau Foto</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 pt-4 border-top">
                            <a href="<?= base_url('product'); ?>" class="btn btn-light rounded-pill px-4 text-secondary fw-bold">Batal</a>
                            <button type="submit" class="btn btn-macha rounded-pill px-5 flex-grow-1 shadow-sm fw-bold py-2">
                                <i class="fa-solid fa-check-circle me-2"></i>Simpan ke Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .preset-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 12px;
        max-height: 280px;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 5px;
        scrollbar-width: thin;
    }
    .preset-item {
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
    }
    .preset-img-box {
        width: 100%;
        aspect-ratio: 1/1;
        border-radius: 12px;
        overflow: hidden;
        border: 3px solid transparent;
        background: #fff;
    }
    .preset-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .preset-item .preset-name {
        font-size: 0.65rem;
        color: #888;
        margin-top: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .preset-item:hover .preset-img-box {
        transform: translateY(-3px);
        border-color: rgba(40, 90, 72, 0.2);
    }
    .preset-item.active .preset-img-box {
        border-color: #285A48;
        box-shadow: 0 4px 12px rgba(40, 90, 72, 0.2);
    }
    .preset-item.active .preset-name {
        color: #285A48;
        font-weight: 700;
    }
    .btn-macha { background: #285A48; color: white; border: none; }
    .btn-macha:hover { background: #1B3B25; color: white; }
    .tracking-wider { letter-spacing: 0.05em; }
</style>

<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const placeholderText = document.getElementById('placeholderText');
    const imagePreset = document.getElementById('imagePreset');

    function selectPreset(filename, element) {
        document.querySelectorAll('.preset-item').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
        
        imagePreset.value = filename;
        imageInput.value = ""; 

        // Update Gambar Preview
        imagePreview.src = "<?= base_url('uploads/'); ?>" + filename;
        imagePreview.style.display = 'block';
        placeholderText.style.display = 'none';
    }

    imageInput.onchange = evt => {
        const [file] = imageInput.files;
        if (file) {
            document.querySelectorAll('.preset-item').forEach(el => el.classList.remove('active'));
            imagePreset.value = "";

            imagePreview.src = URL.createObjectURL(file);
            imagePreview.style.display = 'block';
            placeholderText.style.display = 'none';
        }
    };
</script>
