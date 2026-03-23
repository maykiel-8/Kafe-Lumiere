{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Sign In — Kafé Lumière</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root{--kafe-brown:#4A2C17;--kafe-caramel:#C8874A;--kafe-gold:#D4A853;--kafe-pearl:#F5EFE6;
      --font-serif:'Playfair Display',serif;--font-sans:'DM Sans',sans-serif;}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:var(--font-sans);min-height:100vh;display:flex;}
.auth-left{width:42%;background:var(--kafe-brown);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:3rem;color:#fff;position:relative;overflow:hidden;}
.auth-left::before{content:'☕';font-size:20rem;position:absolute;top:-4rem;right:-5rem;opacity:.05;line-height:1;}
.brand-name{font-family:var(--font-serif);font-size:2.6rem;font-style:italic;color:var(--kafe-gold);}
.brand-sub{font-size:.85rem;opacity:.6;margin-top:.4rem;}
.auth-right{flex:1;display:flex;align-items:center;justify-content:center;padding:2rem;background:#FAF7F2;}
.auth-card{background:#fff;border-radius:20px;border:1px solid rgba(74,44,23,.1);padding:2.5rem;width:100%;max-width:410px;box-shadow:0 8px 40px rgba(74,44,23,.06);}
.form-title{font-family:var(--font-serif);font-size:1.4rem;color:var(--kafe-brown);font-style:italic;margin-bottom:.25rem;}
.form-sub{font-size:.8rem;color:#888;margin-bottom:1.5rem;}
label.lbl{font-size:.78rem;font-weight:500;color:var(--kafe-brown);display:block;margin-bottom:5px;}
input.inp{width:100%;padding:.6rem .9rem;border:1.5px solid rgba(74,44,23,.18);border-radius:10px;font-family:var(--font-sans);font-size:.875rem;outline:none;transition:border-color .18s;background:#fff;}
input.inp:focus{border-color:var(--kafe-caramel);}
input.inp.err{border-color:#c0392b;}
.btn-primary{width:100%;padding:.75rem;background:var(--kafe-brown);color:#fff;border:none;border-radius:10px;font-family:var(--font-sans);font-size:.9rem;font-weight:500;cursor:pointer;margin-top:.5rem;display:flex;align-items:center;justify-content:center;gap:8px;}
.btn-primary:hover{background:#3a2110;}
 
/* Error alert */
.alert-error{background:rgba(192,57,43,.08);border:1px solid rgba(192,57,43,.3);border-radius:10px;padding:.85rem 1rem;color:#8b1a1a;font-size:.82rem;margin-bottom:1rem;display:flex;align-items:flex-start;gap:8px;}
.alert-error i{flex-shrink:0;margin-top:1px;}
 
/* Success alert */
.alert-success{background:rgba(122,140,110,.1);border:1px solid rgba(122,140,110,.3);border-radius:10px;padding:.85rem 1rem;color:#3d5c35;font-size:.82rem;margin-bottom:1rem;display:flex;align-items:flex-start;gap:8px;}
.alert-success i{flex-shrink:0;margin-top:1px;}
 
/* Verify-nudge box — shown when user hasn't verified yet */
.verify-nudge{background:rgba(212,168,83,.1);border:1px solid rgba(212,168,83,.35);border-radius:10px;padding:.85rem 1rem;margin-bottom:1rem;}
.verify-nudge p{font-size:.82rem;color:#7a5a10;margin:0 0 .5rem;}
.verify-nudge form{margin:0;}
.verify-nudge button{background:var(--kafe-brown);color:#fff;border:none;padding:5px 14px;border-radius:7px;font-size:.78rem;font-weight:500;cursor:pointer;}
.verify-nudge button:hover{background:#3a2110;}
 
a.link{color:var(--kafe-caramel);text-decoration:none;font-size:.8rem;}
a.link:hover{text-decoration:underline;}
.row-flex{display:flex;justify-content:space-between;align-items:center;margin-bottom:.75rem;}
@media(max-width:768px){.auth-left{display:none;}}
</style>
</head>
<body>
 
<div class="auth-left">
    <div class="brand-name">Kafé Lumière</div>
    <div class="brand-sub">Milk Tea Shop Management System</div>
    <div style="max-width:260px;text-align:center;margin-top:2.5rem;">
        <div style="font-family:var(--font-serif);font-size:1.05rem;font-style:italic;color:rgba(255,255,255,.8);">"Every cup tells a story."</div>
        <div style="font-size:.78rem;color:rgba(255,255,255,.5);margin-top:.5rem;">Manage orders, staff, products, and sales in one system.</div>
    </div>
</div>
 
<div class="auth-right">
    <div class="auth-card">
        <div class="form-title">Welcome back</div>
        <div class="form-sub">Sign in to access your dashboard</div>
 
        {{-- ── Success flash (e.g. after logout or after registration) ──────── --}}
        @if(session('success'))
            <div class="alert-success">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
 
        {{-- ── Errors ────────────────────────────────────────────────────────── --}}
        @if($errors->any())
            @php
                $emailError = $errors->first('email');
                $isVerifyError = str_contains(strtolower($emailError ?? ''), 'verify');
            @endphp
 
            @if($isVerifyError)
                {{--
                    BUG FIX: When the user hasn't verified their email yet,
                    show a friendly box with a "Resend verification email" button.
                    This way they don't have to navigate away to fix the problem.
                --}}
                <div class="verify-nudge">
                    <p><strong><i class="bi bi-envelope-exclamation"></i> Email not verified yet.</strong><br>
                    Please click the link we sent to <strong>{{ old('email') }}</strong> before logging in.</p>
                    <p style="margin-bottom:.6rem;font-size:.78rem;color:#888;">Didn't get it? Check your spam folder, or click below to resend.</p>
 
                    {{-- Temporary login to resend — we use a hidden form that POSTs
                         to a special resend-without-auth route defined below --}}
                    <form action="{{ route('verification.resend.email') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ old('email') }}">
                        <button type="submit">
                            <i class="bi bi-send"></i> Resend Verification Email
                        </button>
                    </form>
                </div>
            @else
                <div class="alert-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span>{{ $emailError }}</span>
                </div>
            @endif
        @endif
 
        {{-- ── Login form ────────────────────────────────────────────────────── --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div style="margin-bottom:1rem;">
                <label class="lbl">Email Address</label>
                <input class="inp @error('email') err @enderror"
                       name="email" type="email"
                       value="{{ old('email') }}"
                       placeholder="your@email.com"
                       autocomplete="email"
                       required>
            </div>
            <div style="margin-bottom:.5rem;">
                <label class="lbl">Password</label>
                <input class="inp"
                       name="password"
                       type="password"
                       placeholder="Your password"
                       autocomplete="current-password"
                       required>
            </div>
            <div class="row-flex">
                <label style="font-size:.78rem;color:#888;display:flex;align-items:center;gap:5px;cursor:pointer;">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
                </label>
                <a href="#" class="link">Forgot password?</a>
            </div>
            <button class="btn-primary" type="submit">
                <i class="bi bi-box-arrow-in-right"></i> Sign In
            </button>
        </form>
 
        <div style="text-align:center;margin-top:1.2rem;font-size:.78rem;color:#888;">
            Don't have an account? <a href="{{ route('register') }}" class="link">Register here</a>
        </div>
        <div style="text-align:center;margin-top:.75rem;font-size:.74rem;color:#aaa;">
            <i class="bi bi-shield-check" style="color:#7A8C6E;"></i>
            Only email-verified accounts can log in.
        </div>
    </div>
</div>
 
</body>
</html>
 
