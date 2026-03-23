
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Register — Kafé Lumière</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root{--kafe-brown:#4A2C17;--kafe-caramel:#C8874A;--kafe-gold:#D4A853;--kafe-pearl:#F5EFE6;--font-serif:'Playfair Display',serif;--font-sans:'DM Sans',sans-serif;}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:var(--font-sans);min-height:100vh;display:flex;}
.auth-left{width:38%;background:var(--kafe-brown);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:3rem;color:#fff;position:relative;overflow:hidden;}
.auth-left::before{content:'☕';font-size:20rem;position:absolute;top:-4rem;right:-5rem;opacity:.05;line-height:1;}
.brand-name{font-family:var(--font-serif);font-size:2.4rem;font-style:italic;color:var(--kafe-gold);}
.auth-right{flex:1;display:flex;align-items:center;justify-content:center;padding:2rem;background:#FAF7F2;}
.auth-card{background:#fff;border-radius:20px;border:1px solid rgba(74,44,23,.1);padding:2.5rem;width:100%;max-width:440px;box-shadow:0 8px 40px rgba(74,44,23,.06);}
.form-title{font-family:var(--font-serif);font-size:1.4rem;color:var(--kafe-brown);font-style:italic;}
.form-sub{font-size:.8rem;color:#888;margin-bottom:1.5rem;}
label.lbl{font-size:.78rem;font-weight:500;color:var(--kafe-brown);display:block;margin-bottom:4px;}
input.inp,select.inp{width:100%;padding:.6rem .9rem;border:1.5px solid rgba(74,44,23,.18);border-radius:9px;font-family:var(--font-sans);font-size:.875rem;outline:none;transition:border-color .18s;background:#fff;}
input.inp:focus,select.inp:focus{border-color:var(--kafe-caramel);}
input.inp.err{border-color:#c0392b;}
.err-msg{font-size:.72rem;color:#c0392b;margin-top:2px;}
.btn-primary{width:100%;padding:.75rem;background:var(--kafe-brown);color:#fff;border:none;border-radius:10px;font-family:var(--font-sans);font-size:.9rem;font-weight:500;cursor:pointer;margin-top:.5rem;}
.btn-primary:hover{background:#3a2110;}
.error-box{background:rgba(192,57,43,.08);border:1px solid rgba(192,57,43,.25);border-radius:10px;padding:.75rem 1rem;color:#8b1a1a;font-size:.82rem;margin-bottom:1rem;}
a.link{color:var(--kafe-caramel);text-decoration:none;font-size:.8rem;}
.photo-row{display:flex;align-items:center;gap:12px;margin-bottom:1rem;}
.avatar-placeholder{width:54px;height:54px;border-radius:50%;background:rgba(200,135,74,.15);display:flex;align-items:center;justify-content:center;font-size:1.3rem;cursor:pointer;border:2px dashed rgba(74,44,23,.2);overflow:hidden;flex-shrink:0;}
.avatar-placeholder img{width:100%;height:100%;object-fit:cover;}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:10px;}
.pass-strength-bar{height:3px;border-radius:2px;background:#eee;margin-top:4px;transition:all .3s;}
.info-note{background:rgba(122,140,110,.1);border:1px solid rgba(122,140,110,.2);border-radius:8px;padding:.6rem .9rem;font-size:.75rem;color:#4a6a40;margin-bottom:1rem;display:flex;align-items:center;gap:7px;}
@media(max-width:768px){.auth-left{display:none;}}
</style>
</head>
<body>
<div class="auth-left">
    <div class="brand-name">Kafé Lumière</div>
    <div style="font-size:.85rem;opacity:.6;margin-top:.4rem;">Milk Tea Shop Management System</div>
</div>
<div class="auth-right">
    <div class="auth-card">
        <div class="form-title">Create Account</div>
        <div class="form-sub">Join the Kafé Lumière team</div>
 
        <?php if($errors->any()): ?>
            <div class="error-box"><i class="bi bi-exclamation-circle"></i> <?php echo e($errors->first()); ?></div>
        <?php endif; ?>
 
        <form method="POST" action="<?php echo e(route('register')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            
            <div class="photo-row">
                <div class="avatar-placeholder" onclick="document.getElementById('photoInput').click()" id="avatarWrap">
                    <i class="bi bi-camera" style="color:var(--kafe-caramel);"></i>
                </div>
                <div>
                    <div style="font-size:.82rem;font-weight:500;color:var(--kafe-brown);">Profile Photo</div>
                    <div style="font-size:.72rem;color:#888;">Optional — JPG/PNG, max 2MB</div>
                </div>
                <input type="file" id="photoInput" name="photo" accept="image/*" style="display:none;" onchange="previewPhoto(event)">
            </div>
 
            <div class="grid2" style="margin-bottom:1rem;">
                <div>
                    <label class="lbl">First Name *</label>
                    <input class="inp <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> err <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="first_name" value="<?php echo e(old('first_name')); ?>" placeholder="First" required>
                    <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="err-msg"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="lbl">Last Name *</label>
                    <input class="inp <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> err <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="last_name" value="<?php echo e(old('last_name')); ?>" placeholder="Last" required>
                    <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="err-msg"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
 
            <div style="margin-bottom:1rem;">
                <label class="lbl">Email Address *</label>
                <input class="inp <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> err <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" type="email" value="<?php echo e(old('email')); ?>" placeholder="your@email.com" required>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="err-msg"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
 
            <div style="margin-bottom:1rem;">
                <label class="lbl">Password * <span style="font-weight:400;color:#aaa;">(min 8 characters)</span></label>
                <input class="inp <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> err <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" type="password" placeholder="Create a password" oninput="checkStrength(this.value)" required>
                <div class="pass-strength-bar" id="strengthBar"></div>
                <div id="strengthLabel" style="font-size:.7rem;color:#aaa;margin-top:2px;"></div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="err-msg"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
 
            <div style="margin-bottom:1rem;">
                <label class="lbl">Confirm Password *</label>
                <input class="inp" name="password_confirmation" type="password" placeholder="Repeat password" required>
            </div>
 
            <div class="info-note">
                <i class="bi bi-envelope-check"></i>
                A verification email will be sent. You must verify before logging in.
            </div>
 
            <button class="btn-primary" type="submit"><i class="bi bi-person-plus"></i> Create Account</button>
        </form>
        <div style="text-align:center;margin-top:1rem;font-size:.78rem;color:#888;">
            Already have an account? <a href="<?php echo e(route('login')); ?>" class="link">Sign in</a>
        </div>
    </div>
</div>
<script>
function previewPhoto(e) {
    const file = e.target.files[0];
    if (!file) return;
    const wrap = document.getElementById('avatarWrap');
    wrap.innerHTML = `<img src="${URL.createObjectURL(file)}">`;
}
function checkStrength(p) {
    let s = 0;
    if (p.length >= 8) s++;
    if (/[A-Z]/.test(p)) s++;
    if (/[0-9]/.test(p)) s++;
    if (/[^A-Za-z0-9]/.test(p)) s++;
    const colors = ['#c0392b','#e67e22','#f1c40f','#27ae60'];
    const labels = ['Weak','Fair','Good','Strong'];
    const bar = document.getElementById('strengthBar');
    bar.style.width = (s * 25) + '%';
    bar.style.background = colors[s-1] || '#eee';
    document.getElementById('strengthLabel').textContent = labels[s-1] || '';
    document.getElementById('strengthLabel').style.color = colors[s-1] || '#aaa';
}
</script>
</body>
</html>
 
<?php /**PATH C:\Users\admin\kafe-lumiere\resources\views/auth/register.blade.php ENDPATH**/ ?>