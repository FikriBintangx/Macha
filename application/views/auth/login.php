<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 
    $CI =& get_instance();
    $CI->load->model('M_settings');
    $shop_logo = $CI->M_settings->get_setting('shop_logo');
    if(!empty($shop_logo)): 
?>
    <link rel="icon" type="image/x-icon" href="<?= base_url('uploads/'.$shop_logo) ?>">
<?php endif; ?>
<title>Autentikasi | <?= $CI->M_settings->get_setting('shop_name') ?: 'MariMatcha' ?></title>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<style>
    :root {
        --green-dark: #102416;
        --green-main: #1B3B25;
        --green-light: #53725D;
        --tertiary: #8BAA7C;
        --accent: #fbbf24;
        --white: #ffffff;
        --glass: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.1);
        --transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: 'Outfit', sans-serif;
        background: var(--green-dark); /* Restored the brand green */
        color: var(--white);
        min-height: 100vh;
        overflow: hidden;
        display: flex;
    }

    /* ─── SPLIT LAYOUT ─── */
    .auth-wrapper {
        display: flex;
        width: 100%;
        height: 100vh;
        position: relative;
        overflow: hidden;
    }

    /* SILHOUETTE BACKGROUND PATTERN (GRID STYLE) */
    .auth-silhouette {
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        user-select: none;
        overflow: hidden;
        padding: 20px;
        opacity: 0.15; /* Adjusted for green-on-green visibility */
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .silhouette-row {
        display: flex;
        gap: 20px;
        white-space: nowrap;
    }
    .silhouette-text {
        font-size: 4rem;
        font-weight: 900;
        color: var(--tertiary); /* Silhouette text is now matcha green */
        letter-spacing: 5px;
        text-transform: uppercase;
    }

    /* LEFT VISUAL PANEL */
    .auth-visual {
        flex: 1.2;
        background: transparent;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 80px;
        z-index: 1;
    }

    .brand-entrance {
        opacity: 0;
        transform: translateY(30px);
    }
    .auth-brand-lg {
        font-size: 3.5rem;
        font-weight: 950;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 20px;
        letter-spacing: -2px;
    }
    .auth-brand-lg i { color: var(--tertiary); }
    .auth-tagline-lg {
        font-size: 1.2rem;
        color: rgba(255,255,255,0.6);
        max-width: 400px;
        line-height: 1.6;
        margin-bottom: 40px;
    }

    /* Floating Particles */
    .leaf-particle {
        position: absolute;
        font-size: 2rem;
        opacity: 0.15;
        pointer-events: none;
    }

    /* RIGHT FORM PANEL */
    .auth-content {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 10;
        background: rgba(0,0,0,0.2); /* Subtle overlay for the form side to differentiate */
        padding: 40px;
        backdrop-filter: blur(5px);
    }

    /* GLASS CARD */
    .glass-card {
        width: 100%;
        max-width: 450px;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid var(--glass-border);
        border-radius: 35px;
        padding: 50px;
        box-shadow: 0 40px 100px rgba(0,0,0,0.4);
        position: relative;
        overflow: hidden;
    }

    /* FORM CONTAINERS */
    .auth-section {
        display: none;
        position: relative;
    }
    .auth-section.active { display: block; }

    .auth-header { margin-bottom: 35px; }
    .auth-title { font-size: 2.2rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 8px; }
    .auth-subtitle { color: rgba(255,255,255,0.5); font-size: 0.95rem; font-weight: 500; }

    /* INPUT STYLES */
    .input-group { margin-bottom: 24px; position: relative; }
    .input-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--tertiary);
        margin-bottom: 10px;
        margin-left: 5px;
    }
    .input-field-wrap { position: relative; }
    .auth-input {
        width: 100%;
        background: rgba(255,255,255,0.9); /* Lighter background for better contrast with black text */
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 18px;
        padding: 18px 25px 18px 55px;
        color: #000; /* Text is now black */
        font-family: inherit;
        font-size: 1rem;
        outline: none;
        transition: var(--transition);
    }
    .auth-input:focus {
        background: #ffffff;
        border-color: var(--tertiary);
        box-shadow: 0 0 20px rgba(139, 170, 124, 0.2);
    }
    .input-icon {
        position: absolute;
        left: 22px;
        top: 50%;
        transform: translateY(-50%);
        color: #000; /* Icons are now black */
        opacity: 0.5;
        font-size: 1.1rem;
        transition: var(--transition);
    }
    .auth-input:focus ~ .input-icon { 
        color: var(--green-dark); 
        opacity: 1;
    }

    /* BUTTONS */
    .btn-premium {
        width: 100%;
        background: var(--tertiary);
        color: var(--green-dark);
        border: none;
        border-radius: 100px;
        padding: 18px;
        font-size: 1.1rem;
        font-weight: 800;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin-top: 10px;
        box-shadow: 0 15px 30px rgba(139, 170, 124, 0.3);
    }
    .btn-premium:hover {
        transform: translateY(-5px);
        background: #fff;
        box-shadow: 0 20px 40px rgba(255, 255, 255, 0.2);
    }
    .btn-premium:active { transform: translateY(-2px); }

    /* LINKS & FOOTER */
    .auth-links-row {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        font-size: 0.85rem;
    }
    .text-link {
        color: rgba(255,255,255,0.4);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }
    .text-link:hover { color: var(--tertiary); }

    .auth-footer {
        margin-top: 35px;
        text-align: center;
        font-size: 0.9rem;
        color: rgba(255,255,255,0.4);
    }
    .highlight-link {
        color: var(--tertiary);
        text-decoration: none;
        font-weight: 800;
        margin-left: 5px;
    }
    .highlight-link:hover { text-decoration: underline; }

    /* NOTIFICATIONS */
    .notif-bar {
        position: absolute;
        top: 0; left: 0; width: 100%;
        padding: 15px;
        text-align: center;
        font-size: 0.85rem;
        font-weight: 700;
        transform: translateY(-100%);
        transition: var(--transition);
    }
    .notif-bar.error { background: rgba(239, 68, 68, 0.8); color: #fff; }
    .notif-bar.success { background: rgba(16, 185, 129, 0.8); color: #fff; }
    .notif-bar.show { transform: translateY(0); }

    /* RESPONSIVE */
    @media (max-width: 991px) {
        .auth-visual { display: none; }
        .auth-content { background: var(--green-dark); }
        .glass-card { padding: 35px 25px; border-radius: 25px; }
    }

    /* PASS STRENGTH */
    .strength-meter {
        height: 4px;
        background: rgba(255,255,255,0.05);
        margin-top: 8px;
        border-radius: 10px;
        overflow: hidden;
        display: none;
    }
    .strength-bar { height: 100%; width: 0; transition: width 0.3s ease; }
</style>
</head>
<body>

<div class="auth-wrapper">
    <!-- SILHOUETTE PATTERN (GRID) -->
    <div class="auth-silhouette" id="silhouetteGrid">
        <?php for($i=0; $i<15; $i++): ?>
            <div class="silhouette-row">
                <?php for($j=0; $j<10; $j++): ?>
                    <div class="silhouette-text">MATCHA</div>
                <?php endfor; ?>
            </div>
        <?php endfor; ?>
    </div>

    <!-- LEFT VISUAL -->
    <div class="auth-visual">
        <div class="brand-entrance">
            <div class="auth-brand-lg">
                <?php $shop_logo = $this->M_settings->get_setting('shop_logo'); ?>
                <?php if(!empty($shop_logo)): ?>
                    <img src="<?= base_url('uploads/'.$shop_logo) ?>" alt="Logo" style="height: 80px; width: auto; object-fit: contain;">
                <?php else: ?>
                    <i class="fa-solid fa-leaf"></i>
                <?php endif; ?>
                <span>MariMatcha</span>
            </div>
            <p class="auth-tagline-lg">Rasakan kemurnian matcha premium dari pegunungan Jepang, kini hadir di depan pintu Anda. Gabung bersama 5.000+ pelanggan setia kami.</p>
            
            <div class="visual-features" style="display: flex; gap: 40px; margin-top: 20px;">
                <div style="opacity: 0.6;"><i class="fa-solid fa-award me-2"></i> Premium Grade</div>
                <div style="opacity: 0.6;"><i class="fa-solid fa-truck-fast me-2"></i> Fast Delivery</div>
                <div style="opacity: 0.6;"><i class="fa-solid fa-shield-halved me-2"></i> Secure Pay</div>
            </div>
        </div>

        <!-- Particles -->
        <div class="leaf-particle" style="top: 15%; right: 10%;"><i class="fa-solid fa-leaf"></i></div>
        <div class="leaf-particle" style="bottom: 25%; left: 15%;"><i class="fa-solid fa-leaf"></i></div>
    </div>

    <!-- RIGHT CONTENT -->
    <div class="auth-content">
        <div class="glass-card" id="mainCard">
            <!-- NOTIF -->
            <div class="notif-bar <?= $this->session->flashdata('error') ? 'error show' : '' ?>" id="notifErr">
                <?= $this->session->flashdata('error') ?>
            </div>
            <div class="notif-bar success <?= $this->session->flashdata('success') ? 'show' : '' ?>" id="notifOk">
                <?= $this->session->flashdata('success') ?>
            </div>

            <!-- LOGIN SECTION -->
            <div class="auth-section active" id="loginSec">
                <div class="auth-header">
                    <h1 class="auth-title">Welcome Back 👋</h1>
                    <p class="auth-subtitle">Silakan masuk ke akun MariMatcha kamu.</p>
                </div>

                <form action="<?= base_url('auth/process') ?>" method="POST">
                    <div class="input-group">
                        <label class="input-label">Username</label>
                        <div class="input-field-wrap">
                            <input type="text" name="username" class="auth-input" placeholder="Masukkan username" required>
                            <i class="fa-solid fa-user input-icon"></i>
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Password</label>
                        <div class="input-field-wrap">
                            <input type="password" name="password" id="loginPass" class="auth-input" placeholder="••••••••" required>
                            <i class="fa-solid fa-lock input-icon"></i>
                            <i class="fa-solid fa-eye input-icon" style="left: auto; right: 20px; cursor: pointer; pointer-events: auto;" onclick="togglePass('loginPass', this)"></i>
                        </div>
                    </div>

                    <div class="auth-links-row">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; cursor: pointer; opacity: 0.7;">
                            <input type="checkbox" style="accent-color: var(--tertiary);"> Ingat saya
                        </label>
                        <a href="javascript:void(0)" onclick="switchForm('forgot')" class="text-link">Lupa password?</a>
                    </div>

                    <button type="submit" class="btn-premium">
                        <span>Masuk Sekarang</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>

                <div class="auth-footer">
                    Belum punya akun? <a href="javascript:void(0)" onclick="switchForm('register')" class="highlight-link">Daftar sekarang</a>
                </div>
            </div>

            <!-- REGISTER SECTION -->
            <div class="auth-section" id="registerSec">
                <div class="auth-header">
                    <h1 class="auth-title">Join Us! 🍃</h1>
                    <p class="auth-subtitle">Buat akun gratis dan mulai belanja.</p>
                </div>

                <form action="<?= base_url('auth/do_register') ?>" method="POST" onsubmit="return validateRegister()">
                    <div class="input-group">
                        <label class="input-label">Nama Lengkap</label>
                        <div class="input-field-wrap">
                            <input type="text" name="full_name" class="auth-input" placeholder="Nama lengkap kamu" required>
                            <i class="fa-solid fa-id-card input-icon"></i>
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Username</label>
                        <div class="input-field-wrap">
                            <input type="text" name="username" class="auth-input" placeholder="Pilih username" required>
                            <i class="fa-solid fa-at input-icon"></i>
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Password</label>
                        <div class="input-field-wrap">
                            <input type="password" name="password" id="regPass" class="auth-input" placeholder="Min. 6 karakter" required oninput="checkStrength(this.value)">
                            <i class="fa-solid fa-key input-icon"></i>
                            <div class="strength-meter" id="meterWrap"><div class="strength-bar" id="meter"></div></div>
                        </div>
                    </div>

                    <button type="submit" class="btn-premium">
                        <span>Buat Akun</span>
                        <i class="fa-solid fa-user-plus"></i>
                    </button>
                </form>

                <div class="auth-footer">
                    Sudah punya akun? <a href="javascript:void(0)" onclick="switchForm('login')" class="highlight-link">Login di sini</a>
                </div>
            </div>

            <!-- FORGOT SECTION -->
            <div class="auth-section" id="forgotSec">
                <div class="auth-header">
                    <h1 class="auth-title">Reset Password 🔐</h1>
                    <p class="auth-subtitle">Kami akan membantu memulihkan akun kamu.</p>
                </div>

                <form action="<?= base_url('auth/process_forgot') ?>" method="POST">
                    <div class="input-group">
                        <label class="input-label">Username atau Email</label>
                        <div class="input-field-wrap">
                            <input type="text" name="identity" class="auth-input" placeholder="Masukkan identitas akun" required>
                            <i class="fa-solid fa-envelope input-icon"></i>
                        </div>
                    </div>

                    <p style="font-size: 0.8rem; color: rgba(255,255,255,0.4); margin: 10px 0 20px;">Instruksi reset akan dikirimkan jika akun ditemukan dalam database kami.</p>

                    <button type="submit" class="btn-premium">
                        <span>Kirim Instruksi</span>
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>

                <div class="auth-footer">
                    Tiba-tiba ingat? <a href="javascript:void(0)" onclick="switchForm('login')" class="highlight-link">Kembali Login</a>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Handle initial form state from controller
        const initialForm = "<?= $form_type ?? 'login' ?>";
        if (initialForm !== 'login') {
            document.querySelectorAll('.auth-section').forEach(s => s.classList.remove('active'));
            document.getElementById(initialForm + 'Sec').classList.add('active');
        }

        // Entrance Animations
        gsap.to('.brand-entrance', { opacity: 1, y: 0, duration: 0.8, ease: "expo.out", delay: 0.3 });
        gsap.from('.glass-card', { opacity: 0, y: 50, scale: 0.95, duration: 1, ease: "expo.out" });
        
        // Silhouette Motion (Grid Sliding Effect)
        gsap.utils.toArray('.silhouette-row').forEach((row, i) => {
            gsap.to(row, {
                x: i % 2 === 0 ? "-=100" : "+=100",
                duration: 15,
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
        });

        // Floating Leaves
        gsap.utils.toArray('.leaf-particle').forEach(leaf => {
            gsap.to(leaf, {
                y: "random(-50, 50)",
                x: "random(-30, 30)",
                rotation: "random(-90, 90)",
                duration: "random(3, 6)",
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut"
            });
        });

        // Auto hide notif
        setTimeout(() => {
            document.querySelectorAll('.notif-bar').forEach(n => n.classList.remove('show'));
        }, 5000);
    });

    function switchForm(target) {
        const current = document.querySelector('.auth-section.active');
        const next = document.getElementById(target + 'Sec');
        
        if (current === next) return;

        const tl = gsap.timeline();
        tl.to(current, { opacity: 0, scale: 0.95, filter: "blur(10px)", duration: 0.3, ease: "power2.in", onComplete: () => {
            current.classList.remove('active');
            next.classList.add('active');
        }});
        tl.fromTo(next, { opacity: 0, scale: 1.05, filter: "blur(10px)" }, { opacity: 1, scale: 1, filter: "blur(0px)", duration: 0.5, ease: "expo.out" });
    }

    function togglePass(id, icon) {
        const input = document.getElementById(id);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    function checkStrength(v) {
        const meter = document.getElementById('meter');
        const wrap = document.getElementById('meterWrap');
        if (!v) { wrap.style.display = 'none'; return; }
        wrap.style.display = 'block';
        
        let score = 0;
        if (v.length >= 6) score++;
        if (/[A-Z]/.test(v) && /\d/.test(v)) score++;
        if (/[^A-Za-z0-9]/.test(v)) score++;

        const colors = ['#ef4444', '#f59e0b', '#10b981'];
        const widths = ['33%', '66%', '100%'];
        
        meter.style.width = widths[score-1] || '10%';
        meter.style.background = colors[score-1] || '#ef4444';
    }

    function validateRegister() {
        const pass = document.getElementById('regPass').value;
        if (pass.length < 6) {
            showNotif('Password minimal 6 karakter', 'error');
            return false;
        }
        return true;
    }

    function showNotif(msg, type) {
        const n = document.getElementById('notifErr');
        n.innerText = msg;
        n.className = 'notif-bar show ' + type;
        setTimeout(() => n.classList.remove('show'), 4000);
    }
</script>

</body>
</html>

