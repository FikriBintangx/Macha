<div style="margin-bottom:1.5rem; display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h4 style="font-weight:800; color:#1a2e25; margin-bottom:0.2rem;">Edit Product</h4>
        <p style="color:#64748b; font-size:0.875rem; margin:0;">Perbarui informasi produk katalog supplier Anda.</p>
    </div>
    <a href="<?= base_url('supplier/products') ?>" style="
        background:#f1f5f9; color:#475569; padding:9px 18px; border-radius:12px;
        text-decoration:none; font-size:0.85rem; font-weight:700;
        display:inline-flex; align-items:center; gap:8px; transition:all 0.2s;
    " onmouseover="this.style.background='#e2e8f0';" onmouseout="this.style.background='#f1f5f9';">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border:1px solid #e2e8f0 !important; border-radius:18px; background:#fff;">
    <div class="card-header bg-white border-0 py-3 px-4" style="border-bottom:1px solid #f1f5f9 !important;">
        <h6 class="fw-bold mb-0 text-dark" style="font-size:0.95rem;">
            <i class="fas fa-edit me-2 text-warning"></i> Detail Informasi Produk
        </h6>
    </div>
    <div class="card-body p-4">
        <form action="<?= base_url('supplier/products/update/'.$product['id']) ?>" method="post" enctype="multipart/form-data">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required class="form-control rounded-3">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small">Kategori</label>
                    <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>" class="form-control rounded-3">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small">Stok</label>
                    <input type="number" name="stock" value="<?= $product['stock'] ?>" min="0" class="form-control rounded-3">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small">Satuan Unit</label>
                    <input type="text" name="unit" value="<?= htmlspecialchars($product['unit']) ?>" class="form-control rounded-3">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small">Harga (Rp) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required class="form-control rounded-3">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-muted small">Status</label>
                    <select name="status" class="form-select rounded-3">
                        <option value="active" <?= $product['status'] == 'active' ? 'selected' : '' ?>>Available</option>
                        <option value="inactive" <?= $product['status'] == 'inactive' ? 'selected' : '' ?>>Out of Stock</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-muted small">Deskripsi Produk</label>
                <textarea name="description" rows="4" class="form-control rounded-3"><?= htmlspecialchars($product['description']) ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-muted small d-block">Gambar Produk</label>
                <?php if($product['image']): ?>
                    <div class="mb-3">
                        <img src="<?= base_url('uploads/'.$product['image']) ?>" alt="current" class="rounded-3 shadow-sm border" style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="text-xs text-muted mt-1">Gambar saat ini</div>
                    </div>
                <?php endif; ?>
                <input type="file" name="image" class="form-control rounded-3">
                <small class="text-muted mt-1 d-block">Kosongkan jika tidak ingin mengubah gambar.</small>
            </div>

            <div class="d-flex justify-content-end gap-2 pt-2 border-top" style="border-top: 1px solid #f1f5f9 !important;">
                <a href="<?= base_url('supplier/products') ?>" class="btn btn-light rounded-pill px-4">Batal</a>
                <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" style="background:#1B3B25; border-color:#1B3B25;">
                    <i class="fas fa-save me-1"></i> Perbarui Produk
                </button>
            </div>
        </form>
    </div>
</div>
