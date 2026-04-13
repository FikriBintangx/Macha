<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= isset($mode)&&$mode==='reset'?'Reset Password':'Lupa Password' ?> | MariMatcha</title>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
*{box-sizing:border-box;margin:0;padding:0;}
:root{--gd:#1b4d3e;--gm:#40916c;--gl:#95d5b2;--cream:#f5f0e8;}
body{font-family:'Outfit',sans-serif;min-height:100vh;background:linear-gradient(160deg,#0a1a12,#0f3024 40%,#1b4d3e 80%);display:flex;align-items:center;justify-content:center;padding:40px 20px;}
.forgot-card{background:#fff;border-radius:28px;box-shadow:0 32px 80px rgba(0,0,0,.3);width:100%;max-width:440px;overflow:hidden;}
.forgot-header{background:linear-gradient(135deg,var(--gd),var(--gm));padding:36px 36px 28px;text-align:center;position:relative;overflow:hidden;}
.forgot-header::before{content:'🔑';position:absolute;right:-10px;bottom:-20px;font-size:8rem;opacity:.08;}
.brand{font-size:1.4rem;font-weight:900;color:#fff;margin-bottom:16px;letter-spacing:-.5px;}
.brand i{color:var(--gl);margin-right:8px;}
.hdr-icon{width:64px;height:64px;border-radius:50%;background:rgba(255,255,255,.15);border:3px solid rgba(255,255,255,.25);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:1.8rem;backdrop-filter:blur(8px);}
.hdr-title{color:#fff;font-size:1.3rem;font-weight:900;margin-bottom:6px;letter-spacing:-.3px;}
.hdr-sub{color:rgba(255,255,255,.65);font-size:.85rem;font-weight:500;}
/* STEPS INDICATOR */
.steps-ind{display:flex;justify-content:center;align-items:center;gap:6px;margin-top:18px;}
.si-dot{width:8px;height:8px;border-radius:50%;background:rgba(255,255,255,.3);transition:.3s;}
.si-dot.active{background:var(--gl);transform:scale(1.4);}
/* BODY */
.forgot-body{padding:32px 36px;}
.flash-box{border-radius:14px;padding:13px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:.88rem;font-weight:600;border-left:4px solid;}
.flash-err{background:#fff5f5;border-color:#e63946;color:#9b1c1c;}
.flash-ok{background:#f0faf4;border-color:var(--gm);color:#1b4d3e;}
.field-wrap{margin-bottom:16px;}
.field-label{font-size:.82rem;font-weight:700;color:#4a6050;margin-bottom:7px;display:block;}
.field-input{width:100%;border:2px solid #e8ede8;border-radius:14px;padding:14px 48px 14px 18px;font-family:'Outfit',sans-serif;font-size:.95rem;transition:.25s;background:#fafcf9;outline:none;color:var(--gd);position:relative;}
.field-input:focus{border-color:var(--gm);background:#fff;box-shadow:0 0 0 3px rgba(64,145,108,.1);}
.field-group{position:relative;}
.field-ico{position:absolute;right:16px;top:50%;transform:translateY(-50%);color:#a8c5a0;}
.field-ico.eye{cursor:pointer;transition:.2s;pointer-events:all;}
.field-ico.eye:hover{color:var(--gm);}
.pwd-bars{display:flex;gap:4px;margin-top:7px;}
.pwd-bar-seg{flex:1;height:4px;border-radius:4px;background:#eee;transition:.4s;}
.pwd-hint{font-size:.72rem;color:#9aab9a;margin-top:4px;}
.btn-auth{width:100%;background:linear-gradient(135deg,var(--gd),var(--gm));color:#fff;border:none;border-radius:14px;padding:16px;font-family:'Outfit',sans-serif;font-size:1rem;font-weight:800;cursor:pointer;transition:.3s;position:relative;overflow:hidden;margin-top:8px;}
.btn-auth::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,var(--gm),var(--gl));opacity:0;transition:.3s;}
.btn-auth:hover::before{opacity:1;}
.btn-auth span{position:relative;z-index:1;}
.btn-auth:disabled{opacity:.6;cursor:not-allowed;}
.info-box{background:linear-gradient(135deg,#f0faf5,#e8f5e9);border:1.5px solid #c8e6c9;border-radius:14px;padding:14px 18px;margin-bottom:20px;display:flex;gap:12px;align-items:flex-start;font-size:.83rem;color:#2d6a4f;font-weight:600;line-height:1.6;}
.info-box i{color:var(--gm);margin-top:2px;flex-shrink:0;}
.forgot-footer{text-align:center;padding:0 0 28px;font-size:.85rem;color:#9aab9a;}
.auth-link{color:var(--gm);font-weight:700;text-decoration:none;}
.auth-link:hover{color:var(--gd);}
.ripple-a{position:absolute;border-radius:50%;background:rgba(255,255,255,.3);transform:scale(0);animation:rip .5s linear;pointer-events:none;}
@keyframes rip{to{transform:scale(5);opacity:0;}}
</style>
</head>
<body>
<div class="forgot-card">
<div class="forgot-header">
<div class="brand"><i class="fa-solid fa-leaf"></i>MariMatcha</div>
<?php $is_reset = isset($mode) && $mode === 'reset'; ?>
<div class="hdr-icon"><?= $is_reset ? '🔒' : '🔑' ?></div>
<div class="hdr-title"><?= $is_reset ? 'Buat Password Baru' : 'Lupa Password?' ?></div>
<div class="hdr-sub"><?= $is_reset ? 'Masukkan password baru untuk akunmu' : 'Masukkan username akunmu untuk melanjutkan' ?></div>
<div class="steps-ind">
<div class="si-dot <?= !$is_reset?'active':'' ?>"></div>
<div class="si-dot <?= $is_reset?'active':'' ?>"></div>
</div>
</div>

<div class="forgot-body">
<?php if($this->session->flashdata('error')):?>
<div class="flash-box flash-err"><i class="fa-solid fa-circle-exclamation"></i><?=$this->session->flashdata('error')?></div>
<?php endif;?>
<?php if($this->session->flashdata('success')):?>
<div class="flash-box flash-ok"><i class="fa-solid fa-check-circle"></i><?=$this->session->flashdata('success')?></div>
<?php endif;?>

<?php if (!$is_reset): ?>
<!-- STEP 1: CARI USERNAME -->
<div class="info-box"><i class="fa-solid fa-circle-info"></i>Masukkan username akun MariMatcha kamu. Kami akan membantu kamu mengatur ulang password.</div>
<form action="<?= base_url('auth/do_forgot') ?>" method="post" id="forgotForm">
<div class="field-wrap">
<label class="field-label">Username Akun</label>
<div class="field-group">
<input type="text" name="username" class="field-input" placeholder="Masukkan username kamu" required autocomplete="username">
<i class="fa-solid fa-user field-ico"></i>
</div>
</div>
<button type="submit" class="btn-auth" id="btnForgot">
<span><i class="fa-solid fa-magnifying-glass me-2"></i>Cari Akun Saya</span>
</button>
</form>

<?php else: ?>
<!-- STEP 2: SET PASSWORD BARU -->
<div class="info-box"><i class="fa-solid fa-shield-halved"></i>Akun ditemukan! Buat password baru yang kuat untuk melindungi akunmu.</div>
<form action="<?= base_url('auth/do_reset') ?>" method="post" id="resetForm">
<div class="field-wrap">
<label class="field-label">Password Baru</label>
<div class="field-group">
<input type="password" name="password" id="newPwd" class="field-input" placeholder="Min. 6 karakter" required oninput="checkStr(this.value)">
<i class="fa-solid fa-eye field-ico eye" id="ep1" onclick="togglePass('newPwd','ep1')"></i>
</div>
<div class="pwd-bars"><div class="pwd-bar-seg" id="b1"></div><div class="pwd-bar-seg" id="b2"></div><div class="pwd-bar-seg" id="b3"></div><div class="pwd-bar-seg" id="b4"></div></div>
<div class="pwd-hint" id="pwdHint">Masukkan password baru</div>
</div>
<div class="field-wrap">
<label class="field-label">Konfirmasi Password</label>
<div class="field-group">
<input type="password" name="confirm" id="confPwd" class="field-input" placeholder="Ulangi password baru" required oninput="checkMatch()">
<i class="fa-solid fa-eye field-ico eye" id="ep2" onclick="togglePass('confPwd','ep2')"></i>
</div>
<div id="matchNote" style="font-size:.72rem;margin-top:5px;display:none;"></div>
</div>
<button type="submit" class="btn-auth" id="btnReset">
<span><i class="fa-solid fa-lock me-2"></i>Simpan Password Baru</span>
</button>
</form>
<?php endif; ?>
</div>

<div class="forgot-footer">
<a href="<?= base_url('auth') ?>" class="auth-link"><i class="fa-solid fa-arrow-left me-1"></i>Kembali ke Login</a>
</div>
</div>

<script>
function togglePass(id,iconId){
    var inp=document.getElementById(id),ico=document.getElementById(iconId);
    inp.type=inp.type==='password'?'text':'password';
    ico.className='fa-solid fa-eye'+(inp.type==='text'?'-slash':'')+' field-ico eye';
    ico.setAttribute('onclick',"togglePass('"+id+"','"+iconId+"')");
}
function checkStr(v){
    var segs=[document.getElementById('b1'),document.getElementById('b2'),document.getElementById('b3'),document.getElementById('b4')];
    var hint=document.getElementById('pwdHint');
    if(!segs[0])return;
    segs.forEach(function(s){s.className='pwd-bar-seg';});
    if(!v.length){hint.textContent='Masukkan password baru';return;}
    var score=0;
    if(v.length>=6)score++;if(v.length>=10)score++;
    if(/[A-Z]/.test(v)||/\d/.test(v))score++;if(/[^A-Za-z0-9]/.test(v))score++;
    var cls=['weak','medium','strong','vstrong'],lbl=['Lemah','Cukup','Kuat','Sangat Kuat'];
    var colors={weak:'#ef4444',medium:'#f59e0b',strong:'var(--gm)',vstrong:'#059669'};
    for(var i=0;i<score;i++)segs[i].style.background=colors[cls[score-1]];
    hint.textContent='Kekuatan: '+lbl[score-1];
    hint.style.color=colors[cls[score-1]];
}
function checkMatch(){
    var p=document.getElementById('newPwd')&&document.getElementById('newPwd').value;
    var c=document.getElementById('confPwd').value;
    var n=document.getElementById('matchNote');
    if(!n)return;
    n.style.display='block';
    if(p===c&&c){n.textContent='✓ Password cocok';n.style.color='var(--gm)';}
    else{n.textContent='✗ Belum cocok';n.style.color='#e63946';}
}
// Ripple & loading
['btnForgot','btnReset'].forEach(function(id){
    var btn=document.getElementById(id);
    if(!btn)return;
    btn.addEventListener('click',function(e){
        var r=this.getBoundingClientRect(),sz=Math.max(r.width,r.height);
        var rp=document.createElement('span');rp.className='ripple-a';
        rp.style.cssText='width:'+sz+'px;height:'+sz+'px;left:'+(e.clientX-r.left-sz/2)+'px;top:'+(e.clientY-r.top-sz/2)+'px;';
        this.appendChild(rp);setTimeout(function(){rp.remove();},600);
    });
});
['forgotForm','resetForm'].forEach(function(id){
    var f=document.getElementById(id);
    if(!f)return;
    f.addEventListener('submit',function(){
        var btn=f.querySelector('.btn-auth');
        btn.disabled=true;
        btn.innerHTML='<span><i class="fa-solid fa-spinner fa-spin me-2"></i>Memproses...</span>';
    });
});
</script>
</body>
</html>
