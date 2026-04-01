<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-success mb-0">Daftar Menu Macha</h3>
        <p class="text-muted small">Kelola produk, harga, dan stok inventaris Anda di sini.</p>
    </div>
    <a href="<?= site_url('product/add') ?>" class="btn btn-success rounded-pill px-4 shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Produk Baru
    </a>
</div>

<?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-3">
        <i class="bi bi-check-circle-fill me-2"></i> <?= $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold">Gambar</th>
                        <th class="py-3 text-uppercase small fw-bold">Produk & SKU</th>
                        <th class="py-3 text-uppercase small fw-bold text-center">Kategori</th>
                        <th class="py-3 text-uppercase small fw-bold text-end">Harga Jual</th>
                        <th class="py-3 text-uppercase small fw-bold text-center">Stok</th>
                        <th class="pe-4 py-3 text-uppercase small fw-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)) : ?>
                        <?php foreach ($products as $p) : ?>
                            <tr>
                                <td class="ps-4">
                                    <img src="<?= base_url('uploads/' . $p['image']) ?>" 
                                         alt="img" class="rounded-3 shadow-sm" 
                                         style="width: 50px; height: 50px; object-fit: cover;"
                                         onerror="this.src='https://placehold.co/100x100?text=No+Img'">
                                </td>
                                <td>
                                    <div class="fw-bold text-dark"><?= $p['name'] ?></div>
                                    <div class="text-muted small">SKU: <?= $p['sku'] ?></div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">
                                        <?= $p['category_name'] ?>
                                    </span>
                                </td>
                                <td class="text-end fw-bold text-success">
                                    Rp <?= number_format($p['price'], 0, ',', '.') ?>
                                </td>
                                <td class="text-center">
                                    <?php if($p['stock'] <= 5): ?>
                                        <span class="badge bg-danger rounded-pill px-3">Tersisa <?= $p['stock'] ?></span>
                                    <?php else: ?>
                                        <span class="text-dark"><?= $p['stock'] ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="btn-group shadow-sm rounded-3">
                                        <a href="<?= site_url('product/edit/' . $p['id']) ?>" 
                                           class="btn btn-white btn-sm border-end" title="Edit Data">
                                            <i class="bi bi-pencil-square text-warning"></i>
                                        </a>
                                        <a href="<?= site_url('product/delete/' . $p['id']) ?>" 
                                           class="btn btn-white btn-sm" 
                                           onclick="return confirm('Hapus produk <?= $p['name'] ?> dari sistem?')" 
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
