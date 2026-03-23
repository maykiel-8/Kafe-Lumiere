{{-- resources/views/auth/verify-email.blade.php --}}
{{--
    This page is shown at /email/verify when an authenticated but unverified
    user tries to access a protected route.
    It tells them to check their email and offers a resend button.
--}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Verify Your Email — Kafé Lumière</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;1,400&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root{--kafe-brown:#4A2C17;--kafe-caramel:#C8874A;--kafe-gold:#D4A853;--kafe-pearl:#F5EFE6;
      --kafe-sage:#7A8C6E;--font-serif:'Playfair Display',serif;--font-sans:'DM Sans',sans-serif;}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:var(--font-sans);background:var(--kafe-pearl);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem;}
.card{background:#fff;border-radius:20px;padding:2.5rem 2rem;max-width:440px;width:100%;text-align:center;border:1px solid rgba(74,44,23,.1);box-shadow:0 8px 40px rgba(74,44,23,.06);}
.brand{font-family:var(--font-serif);font-size:1.2rem;font-style:italic;color:var(--kafe-brown);margin-bottom:1.5rem;display:block;}
.icon-wrap{width:72px;height:72px;border-radius:50%;background:rgba(212,168,83,.12);display:flex;align-items:center;justify-content:center;margin:0 auto 1.2rem;}
.icon-wrap i{font-size:2rem;color:var(--kafe-gold);}
.title{font-family:var(--font-serif);font-size:1.35rem;color:var(--kafe-brown);margin-bottom:.5rem;}
.sub{font-size:.85rem;color:#777;line-height:1.6;margin-bottom:1.5rem;}
.email-pill{display:inline-block;background:var(--kafe-pearl);border:1px solid rgba(74,44,23,.15);border-radius:20px;padding:4px 14px;font-size:.82rem;font-weight:500;color:var(--kafe-brown);margin-bottom:1.2rem;}
.btn{display:flex;align-items:center;justify-content:center;gap:7px;width:100%;padding:.7rem;border:none;border-radius:10px;font-family:var(--font-sans);font-size:.9rem;font-weight:500;cursor:pointer;transition:background .18s;margin-bottom:.65rem;}
.btn-primary{background:var(--kafe-brown);color:#fff;}
.btn-primary:hover{background:#3a2110;}
.btn-outline{background:transparent;color:var(--kafe-brown);border:1.5px solid var(--kafe-brown);}
.btn-outline:hover{background:var(--kafe-brown);color:#fff;}
.alert-success{background:rgba(122,140,110,.1);border:1px solid rgba(122,140,110,.3);border-radius:10px;padding:.75rem 1rem;color:#3d5c35;font-size:.82rem;margin-bottom:1rem;display:flex;align-items:center;gap:8px;text-align:left;}
.steps{text-align:left;background:var(--kafe-pearl);border-radius:12px;padding:1rem 1.2rem;margin-bottom:1.2rem;}
.steps p{font-size:.78rem;color:#777;margin-bottom:.4rem;}
.steps ol{padding-left:1.2rem;font-size:.82rem;color:var(--kafe-brown);line-height:1.9;}
</style>
</head>
<body>
<div class="card">
    <span class="brand">☕ Kafé Lumière</span>
 
    <div class="icon-wrap">
        <i class="bi bi-envelope-check"></i>
    </div>
    <div class="title">Check Your Email</div>
 
    @if(auth()->check())
        <div class="email-pill">{{ auth()->user()->email }}</div>
    @endif
 
    <div class="sub">
        We sent a verification link to your email address.<br>
        Click the link in the email to activate your account.
    </div>
 
    {{-- Success flash --}}
    @if(session('success'))
        <div class="alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
 
    {{-- Steps guide --}}
    <div class="steps">
        <p><strong>What to do:</strong></p>
        <ol>
            <li>Open your email inbox</li>
            <li>Find the email from <strong>Kafé Lumière</strong></li>
            <li>Click the <em>"Verify Email Address"</em> button</li>
            <li>You will be logged in automatically</li>
        </ol>
    </div>
 
    {{-- Resend form (for authenticated users on this page) --}}
    <form action="{{ route('verification.send') }}" method="POST">
        @csrf
        <button class="btn btn-primary" type="submit">
            <i class="bi bi-send"></i> Resend Verification Email
        </button>
    </form>
 
    {{-- Logout --}}
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn btn-outline" type="submit">
            <i class="bi bi-arrow-left"></i> Back to Login
        </button>
    </form>
 
    <div style="margin-top:1rem;font-size:.73rem;color:#aaa;">
        <i class="bi bi-info-circle"></i>
        Check your spam or junk folder if you don't see the email within a few minutes.
    </div>
</div>
</body>
</html>
