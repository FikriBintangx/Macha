<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Daftar Akun | MariMatcha</title>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
*{box-sizing:border-box;margin:0;padding:0;}
:root{--gd:#1b4d3e;--gm:#40916c;--gl:#95d5b2;--cream:#f5f0e8;}
body{font-family:'Outfit',sans-serif;min-height:100vh;display:flex;align-items:stretch;background:#0a1a12;}
.auth-left{flex:1;position:relative;overflow:hidden;display:none;}
@media(min-width:900px){.auth-left{display:flex;align-items:center;justify-content:center;}}
.auth-left-bg{position:absolute;inset:0;background:linear-gradient(160deg,#0a1a12 0%,#0f3024 40%,#40916c 100%);}
.auth-left-overlay{position:relative;z-index:2;padding:60px;color:#fff;text-align:center;}
.auth-brand{font-size:2rem;font-weight:900;color:#fff;margin-bottom:8px;letter-spacing:-.5px;}
.auth-brand i{color:var(--gl);margin-right:10px;}
.auth-tagline{color:rgba(255,255,255,.6);font-size:1rem;margin-bottom:48px;}
.steps-visual{display:flex;flex-direction:column;gap:20px;max-width:260px;margin:0 auto;text-align:left;}
.sv-item{display:flex;align-items:flex-start;gap:14px;}
.sv-num{width:32px;height:32px;border-radius:50%;background:rgba(149,213,178,.2);border:2px solid rgba(149,213,178,.4);color:var(--gl);font-weight:900;font-size:.9rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.sv-text strong{display:block;color:#fff;font-size:.9rem;font-weight:700;}
.sv-text span{font-size:.8rem;color:rgba(255,255,255,.55);}
.auth-deco{position:absolute;font-size:20rem;opacity:.04;pointer-events:none;bottom:-80px;right:-60px;}
.auth-right{width:100%;max-width:480px;background:#fff;display:flex;align-items:center;justify-content:center;padding:40px 32px;min-height:100vh;}
@media(min-width:900px){.auth-right{width:480px;flex-shrink:0;}}
.auth-card{width:100%;max-width:400px;}
.auth-logo-mobile{display:flex;align-items:center;gap:10px;font-size:1.5rem;font-weight:900;color:var(--gd);margin-bottom:32px;justify-content:center;}
.auth-logo-mobile i{color:var(--gm);}
@media(min-width:900px){.auth-logo-mobile{display:none;}}
.auth-title{font-size:1.7rem;font-weight:900;color:var(--gd);margin-bottom:6px;letter-spacing:-.5px;}
.auth-sub{font-size:.9rem;color:#9aab9a;margin-bottom:28px;font-weight:500;}
.flash-box{border-radius:14px;padding:13px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:.88rem;font-weight:600;border-left:4px solid;}
.flash-err{background:#fff5f5;border-color:#e63946;color:#9b1c1c;}
.flash-ok{background:#f0faf4;border-color:var(--gm);color:#1b4d3e;}
.field-wrap{position:relative;margin-bottom:14px;}
.field-label{font-size:.82rem;font-weight:700;color:#4a6050;margin-bottom:7px;display:block;}
.field-input{width:100%;border:2px solid #e8ede8;border-radius:14px;padding:13px 48px 13px 18px;font-family:'Outfit',sans-serif;font-size:.92rem;transition:.25s;background:#fafcf9;outline:none;color:var(--gd);}
.field-input:focus{border-color:var(--gm);background:#fff;box-shadow:0 0 0 3px rgba(64,145,108,.1);}
.field-input.valid{border-color:var(--gm);}
.field-input.invalid{border-color:#e63946;}
.field-icon{position:absolute;right:16px;top:50%;transform:translateY(-50%);color:#a8c5a0;}
.field-icon.eye{cursor:pointer;transition:.2s;pointer-events:all;}
.field-icon.eye:hover{color:var(--gm);}
/* STRENGTH BAR */
.pwd-wrap{margin-top:7px;}
.pwd-bars{display:flex;gap:4px;margin-bottom:4px;}
.pwd-bar-seg{flex:1;height:4px;border-radius:4px;background:#eee;transition:.4s;}
.pwd-bar-seg.weak{background:#ef4444;}
.pwd-bar-seg.medium{background:#f59e0b;}
.pwd-bar-seg.strong{background:var(--gm);}
.pwd-bar-seg.vstrong{background:#059669;}
.pwd-hint{font-size:.72rem;color:#9aab9a;font-weight:600;}
/* TERMS CHECK */
.terms-row{display:flex;align-items:flex-start;gap:10px;margin:16px 0;font-size:.83rem;color:#6b9080;}
.terms-row input{margin-top:2px;accent-color:var(--gm);width:16px;height:16px;}
.terms-row a{color:var(--gm);font-weight:700;text-decoration:none;}
.btn-auth{width:100%;background:linear-gradient(135deg,var(--gd),var(--gm));color:#fff;border:none;border-radius:14px;padding:16px;font-family:'Outfit',sans-serif;font-size:1rem;font-weight:800;cursor:pointer;transition:.3s;position:relative;overflow:hidden;margin-top:4px;}
.btn-auth::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,var(--gm),var(--gl));opacity:0;transition:.3s;}
.btn-auth:hover::before{opacity:1;}
.btn-auth span{position:relative;z-index:1;}
.btn-auth:disabled{opacity:.6;cursor:not-allowed;}
.auth-footer{text-align:center;margin-top:20px;font-size:.88rem;color:#9aab9a;}
.auth-link{color:var(--gm);font-weight:700;text-decoration:none;}
.auth-link:hover{color:var(--gd);}
.back-link{display:inline-flex;align-items:center;gap:7px;color:#9aab9a;font-size:.85rem;font-weight:600;text-decoration:none;margin-bottom:24px;transition:.2s;}
.back-link:hover{color:var(--gm);}
.ripple-a{position:absolute;border-radius:50%;background:rgba(255,255,255,.3);transform:scale(0);animation:rip .5s linear;pointer-events:none;}
@keyframes rip{to{transform:scale(5);opacity:0;}}
.row-2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
@media(max-width:480px){.row-2{grid-template-columns:1fr;}}
</style>
</head>
<body>
<!-- LEFT -->
<div class="auth-left">
<div class="auth-left-bg"></div>
<div class="auth-left-overlay">
<div class="auth-brand"><i class="fa-solid fa-leaf"></i>MariMatcha</div>
<div class="auth-tagline">Bergabung dengan ribuan pelanggan setia</div>
<div class="steps-visual">
<div class="sv-item"><div class="sv-num">1</div><div class="sv-text"><strong>Buat akun gratis</strong><span>Isi data hanya sekali</span></div></div>
<div class="sv-item"><div class="sv-num">2</div><div class="sv-text"><strong>Pilih menu favorit</strong><span>Dari katalog premium kami</span></div></div>
<div class="sv-item"><div class="sv-num">3</div><div class="sv-text"><strong>Pesan & nikmati</strong><span>Dikirim fresh ke pintumu</span></div></div>
</div>
</div>
<div class="auth-deco">🌿</div>
</div>

<!-- RIGHT -->
<div class="auth-right">
<div class="auth-card">
<div class="auth-logo-mobile"><i class="fa-solid fa-leaf"></i>MariMatcha</div>
<a href="<?= base_url('auth') ?>" class="back-link"><i class="fa-solid fa-arrow-left"></i>Sudah punya akun? Login</a>
<h1 class="auth-title">Buat Akun Baru 🎉</h1>
<p class="auth-sub">Daftar gratis dan mulai belanja matcha!</p>

<?php if($this->session->flashdata('error')):?>
<div class="flash-box flash-err"><i class="fa-solid fa-circle-exclamation"></i><?=$this->session->flashdata('error')?></div>
<?php endif;?>

<form action="<?= base_url('auth/do_register') ?>" method="post" id="regForm">

<div class="field-wrap">
<label class="field-label">Nama Lengkap</label>
<input type="text" name="full_name" id="full_name" class="field-input" placeholder="Nama kamu" required autocomplete="name">
<i class="fa-solid fa-id-card field-icon"></i>
</div>

<div class="field-wrap">
<label class="field-label">Username</label>
<input type="text" name="username" id="reg_username" class="field-input" placeholder="Pilih username unik" required autocomplete="username" oninput="checkUsername(this)">
<i class="fa-solid fa-at field-icon" id="uIcon"></i>
<div id="uNote" style="font-size:.72rem;color:#9aab9a;margin-top:4px;display:none;"></div>
</div>

<div class="field-wrap">
<label class="field-label">Password</label>
<input type="password" name="password" id="reg_pwd" class="field-input" placeholder="Min. 6 karakter" required oninput="checkStrength(this.value)">
<i class="fa-solid fa-eye field-icon eye" id="ep1" onclick="togglePass('reg_pwd','ep1')"></i>
<div class="pwd-wrap">
<div class="pwd-bars"><div class="pwd-bar-seg" id="b1"></div><div class="pwd-bar-seg" id="b2"></div><div class="pwd-bar-seg" id="b3"></div><div class="pwd-bar-seg" id="b4"></div></div>
<div class="pwd-hint" id="pwdHint">Masukkan password</div>
</div>
</div>

<div class="field-wrap">
<label class="field-label">Konfirmasi Password</label>
<input type="password" name="confirm" id="reg_conf" class="field-input" placeholder="Ulangi password" required oninput="checkMatch()">
<i class="fa-solid fa-eye field-icon eye" id="ep2" onclick="togglePass('reg_conf','ep2')"></i>
<div id="matchNote" style="font-size:.72rem;margin-top:4px;display:none;"></div>
</div>

<div class="terms-row">
<input type="checkbox" id="agreeTerms" required>
<label for="agreeTerms">Saya setuju dengan <a href="#">syarat & ketentuan</a> dan <a href="#">kebijakan privasi</a> MariMatcha.</label>
</div>

<button type="submit" class="btn-auth" id="btnReg">
<span><i class="fa-solid fa-user-plus me-2"></i>Buat Akun Sekarang</span>
</button>
</form>

<div class="auth-footer">Sudah punya akun? <a href="<?= base_url('auth') ?>" class="auth-link">Login di sini</a></div>
</div>
</div>

<script>
function togglePass(id, iconId) {
    var inp = document.getElementById(id), ico = document.getElementById(iconId);
    inp.type = inp.type === 'password' ? 'text' : 'password';
    ico.className = 'fa-solid fa-eye'+(inp.type==='text'?'-slash':'')+' field-icon eye';
    ico.setAttribute('onclick',"togglePass('"+id+"','"+iconId+"')");
}
function checkStrength(v) {
    var segs=[document.getElementById('b1'),document.getElementById('b2'),document.getElementById('b3'),document.getElementById('b4')];
    var hint=document.getElementById('pwdHint');
    segs.forEach(function(s){s.className='pwd-bar-seg';});
    if(v.length===0){hint.textContent='Masukkan password';return;}
    var score=0;
    if(v.length>=6)score++;
    if(v.length>=10)score++;
    if(/[A-Z]/.test(v)||/\d/.test(v))score++;
    if(/[^A-Za-z0-9]/.test(v))score++;
    var cls=['weak','medium','strong','vstrong'];
    var lbl=['Lemah','Cukup','Kuat','Sangat Kuat'];
    for(var i=0;i<score;i++)segs[i].classList.add(cls[score-1]);
    hint.textContent='Kekuatan: '+lbl[score-1];
    hint.style.color=score>=3?'var(--gm)':score===2?'#f59e0b':'#ef4444';
}
function checkMatch() {
    var p=document.getElementById('reg_pwd').value, c=document.getElementById('reg_conf').value;
    var note=document.getElementById('matchNote');
    if(!c){note.style.display='none';return;}
    note.style.display='block';
    if(p===c){note.textContent='✓ Password cocok';note.style.color='var(--gm)';}
    else{note.textContent='✗ Password tidak cocok';note.style.color='#e63946';}
}
function checkUsername(inp){
    var note=document.getElementById('uNote');
    note.style.display='block';
    if(inp.value.length<3){note.textContent='Min. 3 karakter';note.style.color='#f59e0b';}
    else if(/\s/.test(inp.value)){note.textContent='Tanpa spasi';note.style.color='#e63946';}
    else{note.textContent='✓ Username valid';note.style.color='var(--gm)';}
}
document.getElementById('btnReg').addEventListener('click',function(e){
    var r=this.getBoundingClientRect(),sz=Math.max(r.width,r.height);
    var rp=document.createElement('span');rp.className='ripple-a';
    rp.style.cssText='width:'+sz+'px;height:'+sz+'px;left:'+(e.clientX-r.left-sz/2)+'px;top:'+(e.clientY-r.top-sz/2)+'px;';
    this.appendChild(rp);setTimeout(function(){rp.remove();},600);
});
document.getElementById('regForm').addEventListener('submit',function(){
    var btn=document.getElementById('btnReg');
    btn.disabled=true;
    btn.innerHTML='<span><i class="fa-solid fa-spinner fa-spin me-2"></i>Membuat akun...</span>';
});
</script>
</body>
</html>
