<div class="row align-items-center mb-4 g-3">
    <div class="col-md-auto col-12 text-center text-md-start">
        <h3 class="fw-bold text-success mb-0">Daftar Menu Macha</h3>
        <p class="text-muted small mb-0">Kelola produk, harga, dan stok inventaris Anda di sini.</p>
    </div>
    <div class="col-md-auto col-12 ms-md-auto text-center">
        <a href="<?= site_url('product/add') ?>" class="btn btn-success rounded-pill px-4 shadow-sm w-100 w-md-auto">
            <i class="bi bi-plus-lg me-1"></i> Tambah Produk Baru
        </a>
    </div>
</div>

<?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
        <i class="bi bi-check-circle-fill me-2"></i> <?= $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
    <div class="card-body p-0">
        <div class="table-responsive responsive-card-table">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold">Gambar</th>
                        <th class="py-3 text-uppercase small fw-bold">Produk & SKU</th>
                        <th class="py-3 text-uppercase small fw-bold text-center">Kategori</th>
                        <th class="py-3 text-uppercase small fw-bold text-end">Harga Jual</th>
                        <th class="py-3 text-uppercase small fw-bold text-center">Stok</th>
                        <th class="py-3 text-uppercase small fw-bold text-center">Best Seller</th>
                        <th class="pe-4 py-3 text-uppercase small fw-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)) : ?>
                        <?php foreach ($products as $p) : ?>
                            <tr>
                                <td class="ps-4" data-label="GAMBAR">
                                    <img src="<?= base_url('uploads/' . $p['image']) ?>" 
                                         alt="img" class="rounded-3 shadow-sm" 
                                         style="width: 50px; height: 50px; object-fit: cover;"
                                         onerror="this.src='https://placehold.co/100x100?text=No+Img'">
                                </td>
                                <td data-label="PRODUK & SKU">
                                    <div class="fw-bold text-dark"><?= $p['name'] ?></div>
                                    <div class="text-muted small">SKU: <?= $p['sku'] ?></div>
                                </td>
                                <td class="text-center" data-label="KATEGORI">
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">
                                        <?= $p['category_name'] ?>
                                    </span>
                                </td>
                                <td class="text-end fw-bold text-success" data-label="HARGA JUAL">
                                    Rp <?= number_format($p['price'], 0, ',', '.') ?>
                                </td>
                                <td class="text-center" data-label="STOK">
                                    <?php if($p['stock'] <= 5): ?>
                                        <span class="badge bg-danger rounded-pill px-3">Tersisa <?= $p['stock'] ?></span>
                                    <?php else: ?>
                                        <span class="text-dark fw-bold"><?= $p['stock'] ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center" data-label="BEST SELLER">
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input best-seller-toggle" type="checkbox" 
                                               id="bs-<?= $p['id'] ?>" 
                                               data-id="<?= $p['id'] ?>"
                                               <?= $p['is_featured'] ? 'checked' : '' ?>>
                                    </div>
                                </td>
                                <td class="text-center pe-4" data-label="AKSI">
                                    <div class="btn-group shadow-sm rounded-3">
                                        <a href="<?= site_url('product/edit/' . $p['id']) ?>" 
                                           class="btn btn-white btn-sm border-end" title="Edit Data">
                                            <i class="bi bi-pencil-square text-warning"></i>
                                        </a>
                                        <a href="<?= site_url('product/delete/' . $p['id']) ?>" 
                                           class="btn btn-white btn-sm" 
                                           onclick="return confirm('PERHATIAN: Produk tidak bisa dihapus jika ada pesanan pending.\n\nHapus produk <?= $p['name'] ?> sekarang?')" 
                                           title="Hapus Produk">
                                            <i class="bi bi-trash3-fill text-danger"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada data produk terdaftar.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.best-seller-toggle').forEach(el => {
    el.addEventListener('change', function() {
        const id = this.dataset.id;
        const status = this.checked;
        
        fetch('<?= site_url("product/toggle_featured/") ?>' + id)
        .then(res => res.json())
        .then(res => {
            if(res.status !== 'success') {
                alert(res.message);
                this.checked = !status; // Revert
            }
        })
        .catch(err => {
            alert('Terjadi kesalahan koneksi.');
            this.checked = !status; // Revert
        });
    });
});
</script>
