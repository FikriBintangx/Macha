<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login | MariMatcha</title>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
*{box-sizing:border-box;margin:0;padding:0;}
:root{--gd:#1b4d3e;--gm:#40916c;--gl:#95d5b2;--cream:#f5f0e8;}
body{font-family:'Outfit',sans-serif;min-height:100vh;display:flex;align-items:stretch;background:#0a1a12;}

/* SPLIT LAYOUT */
.auth-left{flex:1;position:relative;overflow:hidden;display:none;}
@media(min-width:900px){.auth-left{display:flex;align-items:center;justify-content:center;}}
.auth-left-bg{position:absolute;inset:0;background:linear-gradient(160deg,#0a1a12 0%,#0f3024 40%,#1b4d3e 70%,#40916c 100%);}
.auth-left-overlay{position:relative;z-index:2;padding:60px;color:#fff;text-align:center;}
.auth-brand{font-size:2rem;font-weight:900;color:#fff;margin-bottom:8px;letter-spacing:-.5px;}
.auth-brand i{color:var(--gl);margin-right:10px;}
.auth-tagline{color:rgba(255,255,255,.6);font-size:1rem;margin-bottom:48px;}
.auth-features{display:flex;flex-direction:column;gap:16px;text-align:left;max-width:280px;margin:0 auto;}
.auth-feat{display:flex;align-items:center;gap:14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:16px;padding:16px 20px;backdrop-filter:blur(8px);}
.feat-icon{width:40px;height:40px;border-radius:12px;background:rgba(149,213,178,.15);display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;}
.feat-text{font-size:.88rem;color:rgba(255,255,255,.8);font-weight:600;line-height:1.4;}
.auth-deco{position:absolute;font-size:20rem;opacity:.04;pointer-events:none;user-select:none;bottom:-80px;right:-60px;}

/* RIGHT PANEL */
.auth-right{width:100%;max-width:480px;background:#fff;display:flex;align-items:center;justify-content:center;padding:40px 32px;min-height:100vh;position:relative;}
@media(min-width:900px){.auth-right{width:480px;flex-shrink:0;min-height:100vh;}}
.auth-card{width:100%;max-width:400px;}
.auth-logo-mobile{display:flex;align-items:center;gap:10px;font-size:1.5rem;font-weight:900;color:var(--gd);margin-bottom:32px;justify-content:center;}
.auth-logo-mobile i{color:var(--gm);}
@media(min-width:900px){.auth-logo-mobile{display:none;}}
.auth-title{font-size:1.8rem;font-weight:900;color:var(--gd);margin-bottom:6px;letter-spacing:-.5px;}
.auth-sub{font-size:.9rem;color:#9aab9a;margin-bottom:32px;font-weight:500;}

/* FLASH MESSAGES */
.flash-box{border-radius:14px;padding:13px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:.88rem;font-weight:600;border-left:4px solid;}
.flash-err{background:#fff5f5;border-color:#e63946;color:#9b1c1c;}
.flash-ok{background:#f0faf4;border-color:var(--gm);color:#1b4d3e;}

/* FORM */
.field-wrap{position:relative;margin-bottom:16px;}
.field-label{font-size:.82rem;font-weight:700;color:#4a6050;margin-bottom:7px;display:block;letter-spacing:.3px;}
.field-input{width:100%;border:2px solid #e8ede8;border-radius:14px;padding:14px 48px 14px 18px;font-family:'Outfit',sans-serif;font-size:.95rem;transition:.25s;background:#fafcf9;outline:none;color:var(--gd);}
.field-input:focus{border-color:var(--gm);background:#fff;box-shadow:0 0 0 3px rgba(64,145,108,.1);}
.field-input.valid{border-color:var(--gm);}
.field-input.invalid{border-color:#e63946;}
.field-icon{position:absolute;right:16px;top:50%;transform:translateY(-50%);color:#a8c5a0;pointer-events:none;}
.field-icon.clickable{pointer-events:all;cursor:pointer;transition:.2s;}
.field-icon.clickable:hover{color:var(--gm);}
.field-check{position:absolute;right:44px;top:50%;transform:translateY(-50%);color:var(--gm);font-size:.85rem;opacity:0;transition:.2s;}
.field-input.valid~.field-check{opacity:1;}

/* PASSWORD STRENGTH */
.pwd-strength{margin-top:6px;height:3px;border-radius:4px;background:#eee;overflow:hidden;display:none;}
.pwd-bar{height:100%;width:0%;border-radius:4px;transition:.4s;}

/* SUBMIT BUTTON */
.btn-auth{width:100%;background:linear-gradient(135deg,var(--gd),var(--gm));color:#fff;border:none;border-radius:14px;padding:16px;font-family:'Outfit',sans-serif;font-size:1rem;font-weight:800;cursor:pointer;transition:.3s;position:relative;overflow:hidden;letter-spacing:.3px;margin-top:4px;}
.btn-auth::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,var(--gm),var(--gl));opacity:0;transition:.3s;}
.btn-auth:hover::before{opacity:1;}
.btn-auth span{position:relative;z-index:1;}
.btn-auth:disabled{opacity:.6;cursor:not-allowed;}

/* DIVIDER */
.auth-divider{display:flex;align-items:center;gap:12px;margin:20px 0;color:#ccc;font-size:.82rem;}
.auth-divider::before,.auth-divider::after{content:'';flex:1;height:1px;background:#eee;}

/* LINKS */
.auth-link{color:var(--gm);font-weight:700;text-decoration:none;transition:.2s;}
.auth-link:hover{color:var(--gd);}
.auth-footer{text-align:center;margin-top:24px;font-size:.88rem;color:#9aab9a;}

/* SHOW PASSWORD */
#togglePwd,#togglePwd2{color:#a8c5a0;}

/* RIPPLE */
.ripple-a{position:absolute;border-radius:50%;background:rgba(255,255,255,.3);transform:scale(0);animation:rip .5s linear;pointer-events:none;}
@keyframes rip{to{transform:scale(5);opacity:0;}}

/* BACK LINK */
.back-link{display:inline-flex;align-items:center;gap:7px;color:#9aab9a;font-size:.85rem;font-weight:600;text-decoration:none;margin-bottom:28px;transition:.2s;}
.back-link:hover{color:var(--gm);}
</style>
</head>
<body>

<!-- LEFT PANEL (desktop) -->
<div class="auth-left">
<div class="auth-left-bg"></div>
<div class="auth-left-overlay">
<div class="auth-brand"><i class="fa-solid fa-leaf"></i>MariMatcha</div>
<div class="auth-tagline">Minuman Matcha Premium Indonesia</div>
<div class="auth-features">
<div class="auth-feat"><div class="feat-icon">🍵</div><div class="feat-text">100+ Varian minuman matcha premium</div></div>
<div class="auth-feat"><div class="feat-icon">🚀</div><div class="feat-text">Pengiriman cepat ke seluruh Indonesia</div></div>
<div class="auth-feat"><div class="feat-icon">🌿</div><div class="feat-text">Bahan 100% halal & tanpa pengawet</div></div>
<div class="auth-feat"><div class="feat-icon">⭐</div><div class="feat-text">Rating 4.9 dari 1200+ pelanggan puas</div></div>
</div>
</div>
<div class="auth-deco">🍵</div>
</div>

<!-- RIGHT PANEL -->
<div class="auth-right">
<div class="auth-card">
<!-- Mobile Brand -->
<div class="auth-logo-mobile"><i class="fa-solid fa-leaf"></i>MariMatcha</div>

<!-- Back to home -->
<a href="<?= base_url() ?>" class="back-link"><i class="fa-solid fa-arrow-left"></i>Kembali ke Beranda</a>

<h1 class="auth-title">Selamat Datang 👋</h1>
<p class="auth-sub">Masuk ke akun MariMatcha kamu</p>

<!-- Flash -->
<?php if($this->session->flashdata('error')):?>
<div class="flash-box flash-err"><i class="fa-solid fa-circle-exclamation"></i><?=$this->session->flashdata('error')?></div>
<?php endif;?>
<?php if($this->session->flashdata('success')):?>
<div class="flash-box flash-ok"><i class="fa-solid fa-check-circle"></i><?=$this->session->flashdata('success')?></div>
<?php endif;?>

<form action="<?= base_url('auth/process') ?>" method="post" id="loginForm">
<div class="field-wrap">
<label class="field-label" for="username">Username</label>
<input type="text" id="username" name="username" class="field-input" placeholder="Masukkan username kamu" required autocomplete="username">
<i class="fa-solid fa-user field-icon"></i>
<i class="fa-solid fa-check field-check"></i>
</div>

<div class="field-wrap">
<label class="field-label" for="password">Password</label>
<input type="password" id="password" name="password" class="field-input" placeholder="••••••••" required autocomplete="current-password" style="padding-right:80px;">
<i class="fa-solid fa-eye field-icon clickable" id="togglePwd" onclick="togglePass('password','togglePwd')"></i>
<i class="fa-solid fa-check field-check"></i>
</div>

<div style="text-align:right;margin:-8px 0 20px;">
<a href="<?= base_url('auth/forgot') ?>" class="auth-link" style="font-size:.83rem;">Lupa password?</a>
</div>

<button type="submit" class="btn-auth" id="btnLogin">
<span><i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Masuk</span>
</button>
</form>

<div class="auth-divider">atau</div>
<div class="auth-footer">
Belum punya akun? <a href="<?= base_url('auth/register') ?>" class="auth-link">Daftar sekarang</a>
</div>
</div>
</div>

<script>
function togglePass(id, iconId) {
    var inp = document.getElementById(id);
    var ico = document.getElementById(iconId);
    if (inp.type === 'password') {
        inp.type = 'text';
        ico.className = 'fa-solid fa-eye-slash field-icon clickable';
    } else {
        inp.type = 'password';
        ico.className = 'fa-solid fa-eye field-icon clickable';
    }
}
// Validation glow
document.querySelectorAll('.field-input').forEach(function(inp) {
    inp.addEventListener('input', function() {
        if (inp.value.trim().length > 0) { inp.classList.add('valid'); inp.classList.remove('invalid'); }
        else { inp.classList.remove('valid'); }
    });
});
// Ripple
document.getElementById('btnLogin').addEventListener('click', function(e) {
    var r = this.getBoundingClientRect(), sz = Math.max(r.width, r.height);
    var rp = document.createElement('span'); rp.className = 'ripple-a';
    rp.style.cssText = 'width:'+sz+'px;height:'+sz+'px;left:'+(e.clientX-r.left-sz/2)+'px;top:'+(e.clientY-r.top-sz/2)+'px;';
    this.appendChild(rp); setTimeout(function(){rp.remove();}, 600);
});
// Submit loading
document.getElementById('loginForm').addEventListener('submit', function() {
    var btn = document.getElementById('btnLogin');
    btn.disabled = true;
    btn.innerHTML = '<span><i class="fa-solid fa-spinner fa-spin me-2"></i>Masuk...</span>';
});
</script>
</body>
</html>
