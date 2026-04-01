<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami | Macha Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --macha-dark: #3a5a40;
            --macha-primary: #588157;
            --macha-alert: #a3b18a;
            --macha-bg: #f4f6f0;
            --text-dark: #2c3e2e;
        }
        body { font-family: 'Outfit', sans-serif; background-color: var(--macha-bg); color: var(--text-dark); display: flex; flex-direction: column; min-height: 100vh; }
        
        /* Navbar */
        .navbar-macha { background-color: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); box-shadow: 0 4px 20px rgba(88, 129, 87, 0.08); padding: 15px 0; }
        .navbar-brand { font-weight: 700; color: var(--macha-dark) !important; font-size: 24px; }
        .nav-link { font-weight: 500; color: var(--text-dark) !important; transition: 0.3s; margin: 0 10px; }
        .nav-link:hover, .nav-link.active { color: var(--macha-primary) !important; }
        .btn-macha { background: var(--macha-primary); color: white; font-weight: 600; border-radius: 25px; padding: 10px 25px; border: 2px solid var(--macha-primary); transition: 0.3s; text-decoration: none; display: inline-block; }
        .btn-macha:hover { background: var(--macha-dark); border-color: var(--macha-dark); color: white; }
        .btn-outline-macha { border: 2px solid var(--macha-primary); color: var(--macha-primary); font-weight: 600; border-radius: 25px; padding: 10px 25px; transition: 0.3s; text-decoration: none; display: inline-block; }
        .btn-outline-macha:hover { background: var(--macha-primary); color: white; }

        /* Footer */
        footer { padding: 15px 0; border-top: 1px solid #eaeaea; font-size: 0.85rem; color: #777; background: #fff; margin-top: auto; }
        .footer-link { color: #777; font-weight: 500; text-decoration: none; transition: 0.3s; }
        .footer-link:hover { color: var(--macha-primary); }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-macha fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url(); ?>"><i class="fa-solid fa-leaf text-success me-2"></i>MariMacha</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('shop') ?>">Katalog Produk</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url('tentang') ?>">Tentang Kami</a></li>
                </ul>
                <div class="d-flex">
                    <?php if($this->session->userdata('userid')): ?>
                        <a href="<?= base_url('shop/cart') ?>" class="btn btn-outline-macha me-2"><i class="fa-solid fa-cart-shopping"></i></a>
                        <?php if($this->session->userdata('role') == 'user'): ?>
                            <a href="<?= base_url('user') ?>" class="btn btn-macha">Akun Saya</a>
                        <?php else: ?>
                            <a href="<?= base_url('dashboard') ?>" class="btn btn-macha">Dashboard Admin</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?= base_url('auth/register') ?>" class="btn btn-outline-macha me-2">Daftar</a>
                        <a href="<?= base_url('auth') ?>" class="btn btn-macha">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div style="padding-top: 100px;">
        <section class="py-5 bg-white mb-5 rounded-bottom-4 shadow-sm mx-auto" style="max-width: 1200px;">
            <div class="container py-4">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <img src="https://images.unsplash.com/photo-1563822249548-9a72b6353d2e?q=80&w=800&auto=format&fit=crop" class="img-fluid rounded-4 shadow" alt="Toko Marimacha">
                    </div>
                    <div class="col-md-6 ps-md-5">
                        <h2 class="fw-bold mb-4" style="color: var(--macha-dark) !important;">Tentang Kami</h2>
                        <p class="fs-5 text-muted mb-4">Kami percaya bahwa secangkir matcha bukan sekadar minuman, melainkan sebuah seni dan ketenangan. Macha Premium didedikasikan untuk menghadirkan cita rasa teh hijau Jepang autentik untuk menemani momen spesial Anda.</p>
                        <div class="d-flex align-items-start mb-3 p-4 rounded-4" style="background-color: var(--macha-bg);">
                            <i class="fa-solid fa-store fs-2 me-3 mt-1" style="color: var(--macha-primary);"></i>
                            <div>
                                <h5 class="fw-bold mb-2">Kunjungi Outlet Fisik Kami</h5>
                                <p class="mb-0 text-muted" style="line-height: 1.6;"><strong>Outlet Marimacha</strong><br><?= nl2br(htmlentities($shop_address)) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer class="text-center">
        <div class="container">
            <p class="mb-0 text-muted small">&copy; <?= date('Y') ?> <strong>Marimacha Premium</strong>. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
