<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger border-0 shadow-sm mb-4 rounded-4 animate__animated animate__shakeX">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-octagon-fill fs-4 me-3"></i>
                        <div>
                            <p class="mb-0 fw-bold">Terjadi Kesalahan!</p>
                            <small><?= $this->session->flashdata('error'); ?></small>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3">
                            <i class="bi bi-plus-circle-fill text-success fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-dark">Tambah Produk Baru</h4>
                            <p class="text-muted small mb-0">Manajemen inventaris Macha UMKM</p>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form action="<?= site_url('product/save'); ?>" method="post" enctype="multipart/form-data" id="formProduct">
                        
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="image_preset" id="imagePreset" value="">

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="bg-light p-4 rounded-4 h-100 border border-white shadow-sm">
                                    <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Detail Produk</h6>
                                    
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">SKU / KODE PRODUK</label>
                                        <input type="text" name="sku" class="form-control border-0 shadow-sm" placeholder="Contoh: MC-001" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">NAMA PRODUK</label>
                                        <input type="text" name="name" class="form-control border-0 shadow-sm" placeholder="Masukkan nama varian" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">DESKRIPSI PRODUK</label>
                                        <textarea name="description" class="form-control border-0 shadow-sm" rows="3" placeholder="Tuliskan detail rasa, komposisi, atau rincian lainnya..."></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">KATEGORI</label>
                                        <select name="category_id" class="form-select border-0 shadow-sm" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            <?php foreach($categories as $c): ?>
                                                <option value="<?= $c['id'] ?>"><?= $c['category_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label small fw-bold">HARGA (RP)</label>
                                            <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                                <span class="input-group-text border-0 bg-white small">Rp</span>
                                                <input type="number" name="price" class="form-control border-0" min="0" placeholder="0" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-bold">STOK AWAL</label>
                                            <input type="number" name="stock" class="form-control border-0 shadow-sm fw-bold text-success" min="0" placeholder="0" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="p-2 h-100">
                                    <label class="form-label small fw-bold text-success mb-2">
                                        <i class="bi bi-folder-fill me-1"></i> KOLEKSI DARI FOLDER UPLOADS
                                    </label>
                                    
                                    <div class="d-flex gap-2 p-2 border rounded-4 bg-white shadow-sm mb-4 overflow-auto custom-scroll" style="height: 120px;">
                                        <?php 
                                        // LOGIKA OTOMATIS: Membaca file di folder uploads
                                        $path = FCPATH . 'uploads/';
                                        $images = glob($path . "*.{jpg,jpeg,png,webp}", GLOB_BRACE);
                                        
                                        if (!empty($images)):
                                            foreach($images as $img):
                                                $filename = basename($img);
                                        ?>
                                            <div class="preset-option" onclick="selectPreset('<?= $filename ?>', this)" title="<?= $filename ?>">
                                                <div class="img-container">
                                                    <img src="<?= base_url('uploads/' . $filename); ?>" alt="Product">
                                                </div>
                                                <span class="name-label"><?= $filename ?></span>
                                            </div>
                                        <?php 
                                            endforeach;
                                        else: 
                                        ?>
                                            <div class="small text-muted p-4 w-100 text-center">Folder /uploads/ kosong.</div>
                                        <?php endif; ?>
                                    </div>

                                    <label class="form-label small fw-bold text-secondary mb-2">ATAU UNGGAH BARU</label>
                                    <input type="file" name="image" id="imageInput" class="form-control rounded-3 shadow-sm mb-3" accept="image/*">
                                    
                                    <div id="previewArea" class="rounded-4 d-flex flex-column align-items-center justify-content-center border-2" 
                                         style="border-style: dashed !important; border-color: #ced4da; min-height: 160px; background: #fafafa;">
                                        
                                        <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 90%; max-height: 140px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                        
                                        <div id="placeholderText" class="text-center">
                                            <i class="bi bi-image-fill fs-1 text-light-emphasis"></i>
                                            <p class="mb-0 small text-muted">Pratinjau Foto</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 pt-4 mt-4 border-top">
                            <a href="<?= site_url('product'); ?>" class="btn btn-light rounded-pill px-4 fw-bold text-muted border">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-macha rounded-pill px-5 flex-grow-1 shadow-sm fw-bold py-2">
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i> SIMPAN PRODUK KE DATABASE
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Tema Warna Macha */
    :root { --macha: #588157; --macha-hover: #3a5a40; }
    .btn-macha { background: var(--macha); color: white; border: none; transition: 0.3s; }
    .btn-macha:hover { background: var(--macha-hover); color: white; transform: translateY(-2px); }

    /* Gaya Card Gambar Koleksi */
    .preset-option { 
        min-width: 80px; 
        cursor: pointer; 
        transition: 0.2s; 
        border-radius: 10px; 
        padding: 4px;
        text-align: center;
    }
    .preset-option .img-container { 
        width: 70px; 
        height: 70px; 
        overflow: hidden; 
        border-radius: 8px; 
        border: 2px solid #eee;
        background: white;
    }
    .preset-option img { width: 100%; height: 100%; object-fit: cover; }
