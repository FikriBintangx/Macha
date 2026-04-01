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

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-secondary">Nama Produk</label>
                                    <input type="text" name="name" class="form-control rounded-3 py-2" placeholder="Contoh: Matcha Berry" required>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label fw-bold text-secondary">Harga (Rp)</label>
                                        <input type="number" name="price" class="form-control rounded-3 py-2" placeholder="0" required>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label fw-bold text-secondary">Stok</label>
                                        <input type="number" name="stock" class="form-control rounded-3 py-2" placeholder="0" required>
                                    </div>
                                </div>

                                <label class="form-label fw-bold text-success"><i class="fa-solid fa-images me-1"></i> Koleksi Tersedia:</label>
                                <div class="d-flex gap-3 p-3 border rounded-4 bg-light shadow-sm mb-3">
                                    
                                    <div class="preset-option text-center" onclick="selectPreset('maca1.jpg', this)" style="min-width: 100px; cursor: pointer;">
                                        <div class="img-wrapper rounded-3 border bg-white p-1 mb-1 shadow-sm">
                                            <img src="<?= base_url('uploads/maca1.jpg'); ?>" 
                                                 class="img-fluid rounded-2" 
                                                 style="height: 80px; width: 100%; object-fit: cover;"
                                                 onerror="this.src='https://placehold.co/80x80?text=GAMBAR+TIDAK+ADA';">
                                        </div>
                                        <small class="fw-bold text-muted">maca1.jpg</small>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary">Atau Unggah Foto Baru</label>
                                <input type="file" name="image" id="imageInput" class="form-control rounded-3 mb-3" accept="image/*">
                                
                                <div id="previewArea" class="preview-container p-3 border rounded-4 text-center" 
                                     style="background: #fdfdfd; border-style: dashed !important; border-width: 2px; min-height: 250px; display: flex; align-items: center; justify-content: center;">
                                    
                                    <img id="imagePreview" src="#" alt="Preview" 
                                         style="display: none; max-width: 100%; max-height: 220px; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                                    
                                    <div id="placeholderText" class="text-muted">
                                        <i class="fa-solid fa-camera-retro fs-1 d-block mb-2" style="color: #cbd5e0;"></i>
                                        <p class="mb-0 small fw-bold">Pratinjau Gambar</p>
                                        <span class="small text-secondary">Pilih dari koleksi atau file</span>
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
    .preset-option .img-wrapper { transition: all 0.3s ease; border: 2px solid transparent !important; }
    .preset-option.active .img-wrapper { border-color: #588157 !important; background: #e8f5e9; transform: translateY(-5px); }
    .preset-option.active small { color: #588157 !important; font-weight: 800; }
    .btn-macha { background: #588157; color: white; border: none; }
    .btn-macha:hover { background: #3a5a40; color: white; }
</style>

<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const placeholderText = document.getElementById('placeholderText');
    const imagePreset = document.getElementById('imagePreset');

    function selectPreset(filename, element) {
        document.querySelectorAll('.preset-option').forEach(el => el.classList.remove('active'));
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
            document.querySelectorAll('.preset-option').forEach(el => el.classList.remove('active'));
            imagePreset.value = "";

            imagePreview.src = URL.createObjectURL(file);
            imagePreview.style.display = 'block';
            placeholderText.style.display = 'none';
        }
    };
</script>
