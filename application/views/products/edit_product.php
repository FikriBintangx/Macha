<div class="row justify-content-center animate__animated animate__fadeIn">
    <div class="col-md-8">
        <div class="d-flex align-items-center mb-4">
            <a href="<?= site_url('product') ?>" class="btn btn-white shadow-sm rounded-circle me-3">
                <i class="bi bi-arrow-left text-success"></i>
            </a>
            <div>
                <h3 class="fw-bold text-success mb-0">Edit Produk</h3>
                <p class="text-muted small mb-0">Perbarui informasi detail menu Macha Anda.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="<?= site_url('product/update/' . $product['id']) ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">

                    <div class="row">
                        <div class="col-md-4 mb-4 text-center border-end pe-4">
                            <label class="form-label small fw-bold d-block text-start mb-3" style="color:#2d5a27">📸 Foto Produk</label>

                            <!-- Preview Current / New Image -->
                            <div style="position:relative;">
                                <img id="imgPreview"
                                     src="<?= base_url('uploads/' . $product['image']) ?>"
                                     class="rounded-4 shadow-sm img-fluid w-100"
                                     style="height:180px;object-fit:cover;border:3px solid #e0e8e0;transition:.25s;"
                                     onerror="this.src='https://placehold.co/200x200/e8f5e9/2d5a27?text=No+Image'">
                                <!-- Badge new indicator -->
                                <div id="newPhotoTag" style="display:none;position:absolute;top:8px;left:8px;background:#40916c;color:#fff;border-radius:50px;padding:3px 10px;font-size:.7rem;font-weight:800;">✓ Foto Baru</div>
                            </div>

                            <!-- Drop Zone -->
                            <div id="dropZone"
                                 style="margin-top:14px;border:2.5px dashed #a8d5b5;border-radius:16px;padding:18px 12px;cursor:pointer;transition:.25s;background:#f8fdf8;"
                                 onclick="document.getElementById('imageInput').click()"
                                 ondragover="event.preventDefault();this.style.borderColor='#40916c';this.style.background='#e8f5e9';"
                                 ondragleave="this.style.borderColor='#a8d5b5';this.style.background='#f8fdf8';"
                                 ondrop="handleDrop(event)">
                                <div style="font-size:1.8rem;margin-bottom:6px;">📁</div>
                                <div id="dropLabel" style="font-size:.8rem;color:#6b9080;font-weight:600;line-height:1.4">
                                    Klik atau drag foto baru di sini<br>
                                    <span style="font-size:.72rem;color:#aaa">JPG, PNG, WEBP • Max 2MB</span>
                                </div>
                            </div>

                            <!-- Hidden Input -->
                            <input type="file" id="imageInput" name="image" accept="image/*" style="display:none;" onchange="previewImg(this)">

                            <!-- Remove new photo button -->
                            <button type="button" id="removeNewPhoto" style="display:none;margin-top:8px;background:transparent;border:1.5px solid #e63946;color:#e63946;border-radius:50px;padding:4px 14px;font-size:.78rem;font-weight:700;cursor:pointer;width:100%;transition:.2s;" onclick="removeNewPhoto()">
                                🗑️ Batal ganti foto
                            </button>

                            <script>
                            function previewImg(input) {
                                if(!input.files||!input.files[0])return;
                                var f=input.files[0];
                                if(f.size>2*1024*1024){alert('Ukuran foto max 2MB!');input.value='';return;}
                                var reader=new FileReader();
                                reader.onload=function(e){
                                    document.getElementById('imgPreview').src=e.target.result;
                                    document.getElementById('imgPreview').style.borderColor='#40916c';
                                    document.getElementById('newPhotoTag').style.display='block';
                                    document.getElementById('dropLabel').innerHTML='<strong style="color:#2d5a27">'+f.name+'</strong><br><span style="font-size:.72rem;color:#8aa898">'+(f.size/1024).toFixed(0)+' KB</span>';
                                    document.getElementById('dropZone').style.borderColor='#40916c';
                                    document.getElementById('dropZone').style.background='#e8f5e9';
                                    document.getElementById('removeNewPhoto').style.display='block';
                                };
                                reader.readAsDataURL(f);
                            }
                            function handleDrop(e){
                                e.preventDefault();
                                document.getElementById('dropZone').style.borderColor='#a8d5b5';
                                document.getElementById('dropZone').style.background='#f8fdf8';
                                var files=e.dataTransfer.files;
                                if(files.length){
                                    var dt=new DataTransfer();
                                    dt.items.add(files[0]);
                                    var inp=document.getElementById('imageInput');
                                    inp.files=dt.files;
                                    previewImg(inp);
                                }
                            }
                            function removeNewPhoto(){
                                document.getElementById('imageInput').value='';
                                document.getElementById('imgPreview').src='<?= base_url('uploads/' . $product['image']) ?>';
                                document.getElementById('imgPreview').style.borderColor='#e0e8e0';
                                document.getElementById('newPhotoTag').style.display='none';
                                document.getElementById('dropLabel').innerHTML='Klik atau drag foto baru di sini<br><span style="font-size:.72rem;color:#aaa">JPG, PNG, WEBP • Max 2MB</span>';
                                document.getElementById('dropZone').style.borderColor='#a8d5b5';
                                document.getElementById('dropZone').style.background='#f8fdf8';
                                document.getElementById('removeNewPhoto').style.display='none';
                            }
                            </script>
                        </div>

                        <div class="col-md-8">
                            <?php if(array_key_exists('sku', $product) && $product['sku']): ?>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">SKU / Kode Produk</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted small">#</span>
                                    <input type="text" name="sku" class="form-control bg-light" value="<?= $product['sku'] ?>">
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Nama Produk</label>
                                <input type="text" name="name" class="form-control shadow-none" value="<?= $product['name'] ?>" placeholder="Contoh: Matcha Latte Strawberry" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Kategori</label>
                                <select name="category_id" class="form-select shadow-none" required>
                                    <?php foreach($categories as $c): ?>
                                        <option value="<?= $c['id'] ?>" <?= $c['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                            <?= $c['category_name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small">Harga (Rp)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light small">Rp</span>
                                        <input type="number" name="price" class="form-control shadow-none fw-bold text-success" 
                                               value="<?= $product['price'] ?>" min="0" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small">Stok</label>
                                    <input type="number" name="stock" class="form-control shadow-none fw-bold <?= $product['stock'] <= 5 ? 'text-danger' : 'text-primary' ?>" 
                                           value="<?= $product['stock'] ?>" min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-25">

                    <!-- ✨ SECTION: FEATURED DI LANDING PAGE -->
                    <div class="p-4 rounded-4 mb-4" style="background:linear-gradient(135deg,#f0faf5,#e8f5e9);border:2px solid #c8e6c9;">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div style="background:#2d6a4f;border-radius:12px;width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0" style="color:#1b4d3e">Tampil di Landing Page</h6>
                                <small class="text-muted">Produk ini akan muncul sebagai konten utama di halaman beranda.</small>
                            </div>
                        </div>

                        <!-- Toggle Featured -->
                        <div class="d-flex align-items-center justify-content-between p-3 bg-white rounded-3 mb-3 shadow-sm">
                            <div>
                                <div class="fw-bold" style="color:#2d5a27">Aktifkan sebagai Produk Unggulan</div>
                                <small class="text-muted">Muncul di section scroll storytelling beranda</small>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="isFeatured"
                                    value="1" <?= (!empty($product['is_featured']) && $product['is_featured'] == 1) ? 'checked' : '' ?>
                                    style="width:48px;height:26px;cursor:pointer;">
                            </div>
                        </div>

                        <!-- Highlight Label -->
                        <div class="mb-3">
                            <label class="form-label fw-bold small">🏷️ Label Unggulan</label>
                            <input type="text" name="highlight_label" class="form-control shadow-none"
                                placeholder="Contoh: 🔥 Best Seller  /  ✨ Paling Disukai  /  🆕 Baru Hadir"
                                value="<?= htmlspecialchars($product['highlight_label'] ?? '') ?>">
                            <div class="form-text">Label kecil yang muncul di atas nama produk di landing page.</div>
                        </div>

                        <!-- Feature Tag (chip kecil) -->
                        <div class="mb-3">
                            <label class="form-label fw-bold small">🎯 Tag Keunggulan</label>
                            <input type="text" name="feature_tag" class="form-control shadow-none"
                                placeholder="Contoh: Tanpa Gula  /  Rendah Kalori  /  Cocok untuk Diet"
                                value="<?= htmlspecialchars($product['feature_tag'] ?? '') ?>">
                            <div class="form-text">Chip kecil yang menunjukkan keunggulan utama produk.</div>
                        </div>

                        <!-- Highlight Description -->
                        <div class="mb-0">
                            <label class="form-label fw-bold small">📝 Deskripsi Highlight</label>
                            <textarea name="highlight_desc" class="form-control shadow-none" rows="3"
                                placeholder="Contoh: Matcha premium grade-A dengan rasa coklat yang lembut dan creamy. Sempurna untuk kamu yang suka rasa yang kaya dan tidak terlalu manis."
                                ><?= htmlspecialchars($product['highlight_desc'] ?? '') ?></textarea>
                            <div class="form-text">Kalimat pendek yang tampil di landing page saat user scroll ke produk ini.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= site_url('product') ?>" class="btn btn-light rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-success rounded-pill px-5 shadow-sm">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    // Mencegah input angka negatif secara real-time
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('input', function() {
            if (this.value < 0) this.value = 0;
        });
    });

    // Validasi saat submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const stock = document.getElementsByName('stock')[0].value;
        const price = document.getElementsByName('price')[0].value;

        if (stock < 0 || price < 0) {
            e.preventDefault();
            Swal.fire('Error', 'Harga dan Stok tidak boleh bernilai negatif.', 'error'); // Jika pakai SweetAlert
        }
    });
</script>
