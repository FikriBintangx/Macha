<div class="container py-5">
    <?php if($this->session->flashdata('welcome_msg')): ?>
        <div class="alert alert-primary border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-heart-fill me-2 text-danger"></i> <?= $this->session->flashdata('welcome_msg'); ?>
        </div>
    <?php endif; ?>

    <div class="text-center mb-5">
        <h2 class="fw-bold text-success">Menu Macha UMKM</h2>
        <p class="text-muted">Pilih minuman favoritmu dan nikmati kesegarannya!</p>
    </div>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <img src="<?= base_url('uploads/maca1.jpg'); ?>" class="card-img-top" style="height: 200px; object-fit: cover;" onerror="this.src='https://placehold.co/400x400?text=Macha';">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-1 text-dark">Matcha Strawberry</h6>
                    <p class="text-success fw-bold mb-2">Rp 15.000</p>
                    <button class="btn btn-success w-100 rounded-pill btn-sm">
                        <i class="bi bi-cart-plus me-1"></i> Tambah Ke Keranjang
                    </button>
                </div>
            </div>
        </div>
        </div>
</div>
