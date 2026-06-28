<div class="container py-4">
    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-auto col-12 text-center text-md-start">
            <h3 class="fw-bold text-success mb-0">Bahan Produk dari Supplier</h3>
            <p class="text-muted small mb-0">Lihat semua bahan dan produk yang ditawarkan oleh supplier.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-body p-0">
            <div class="table-responsive responsive-card-table">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold">Gambar</th>
                            <th class="py-3 text-uppercase small fw-bold">Produk</th>
                            <th class="py-3 text-uppercase small fw-bold">Supplier</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Kategori</th>
                            <th class="py-3 text-uppercase small fw-bold text-end">Harga</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Stok</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Status</th>
                            <th class="pe-4 py-3 text-uppercase small fw-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)) : ?>
                            <?php foreach ($products as $p) : ?>
                                <tr>
                                    <td class="ps-4" data-label="GAMBAR">
                                        <?php if (!empty($p['image'])): ?>
                                            <img src="<?= base_url('uploads/' . $p['image']) ?>" alt="img" class="rounded-3 shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded-3 shadow-sm bg-light d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="PRODUK">
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($p['product_name']) ?></div>
                                    </td>
                                    <td data-label="SUPPLIER">
                                        <div class="fw-bold text-primary"><?= htmlspecialchars($p['supplier_name'] ?? 'Unknown') ?></div>
                                    </td>
                                    <td class="text-center" data-label="KATEGORI">
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">
                                            <?= htmlspecialchars($p['category']) ?>
                                        </span>
                                    </td>
                                    <td class="text-end fw-bold text-success" data-label="HARGA">
                                        Rp <?= number_format($p['price'], 0, ',', '.') ?> <span class="text-muted fw-normal small">/ <?= htmlspecialchars($p['unit']) ?></span>
                                    </td>
                                    <td class="text-center" data-label="STOK">
                                        <?php if($p['stock'] <= 10): ?>
                                            <span class="badge bg-warning text-dark rounded-pill px-3"><?= $p['stock'] ?></span>
                                        <?php else: ?>
                                            <span class="text-dark fw-bold"><?= $p['stock'] ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center" data-label="STATUS">
                                        <?php if ($p['status'] == 'active'): ?>
                                            <span class="badge bg-success rounded-pill px-3">Tersedia</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger rounded-pill px-3">Habis</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center pe-4" data-label="AKSI">
                                        <button class="btn btn-sm btn-success rounded-pill px-3 fw-bold" onclick="openRequestModal(<?= $p['supplier_id'] ?>, '<?= addslashes($p['supplier_name'] ?? '') ?>', '<?= addslashes($p['product_name']) ?>')">
                                            <i class="bi bi-envelope me-1"></i> Minta Supply
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Belum ada data bahan dari supplier.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Minta Supply -->
<div class="modal fade" id="requestSupplyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold text-success"><i class="bi bi-envelope-plus me-2"></i>Buat Permintaan Supply</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin_suppliers/create_supply_request') ?>" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="supplier_id" id="reqSupplierId">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Nama Supplier</label>
                        <input type="text" id="reqSupplierName" class="form-control rounded-3" readonly style="background-color: #f8f9fa;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Nama Produk/Bahan</label>
                        <input type="text" name="product_name" id="reqProductName" class="form-control rounded-3" readonly style="background-color: #f8f9fa;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Jumlah Permintaan <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" class="form-control rounded-3" min="1" value="10" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold small text-muted">Catatan Tambahan</label>
                        <textarea name="notes" class="form-control rounded-3" rows="3" placeholder="Tulis instruksi atau spesifikasi bahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">Kirim Permintaan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openRequestModal(supplierId, supplierName, productName) {
    document.getElementById('reqSupplierId').value = supplierId;
    document.getElementById('reqSupplierName').value = supplierName;
    document.getElementById('reqProductName').value = productName;
    
    var myModal = new bootstrap.Modal(document.getElementById('requestSupplyModal'));
    myModal.show();
}
</script>
