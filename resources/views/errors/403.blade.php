{{-- resources/views/errors/403.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>403 — Unauthorized</title>
<style>
body{font-family:'DM Sans',Arial,sans-serif;background:#FAF7F2;min-height:100vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:2rem;}
.code{font-size:5rem;font-weight:700;color:#E8D5C4;line-height:1;}
.title{font-size:1.4rem;color:#4A2C17;margin:.5rem 0;}
.sub{color:#888;font-size:.9rem;margin-bottom:1.5rem;}
a{background:#4A2C17;color:#fff;padding:.6rem 1.4rem;border-radius:8px;text-decoration:none;font-size:.85rem;}
</style>
</head>
<body>
<div>
    <div class="code">403</div>
    <div class="title">Access Denied</div>
    <div class="sub">You are not authorized to view this page.</div>
    <a href="{{ url('/') }}">← Go Home</a>
</div>
</body>
</html>
