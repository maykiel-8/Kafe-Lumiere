
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> — Kafé Lumière</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root {
    --kafe-cream:#FAF7F2; --kafe-brown:#4A2C17; --kafe-caramel:#C8874A;
    --kafe-blush:#E8D5C4; --kafe-sage:#7A8C6E; --kafe-gold:#D4A853;
    --kafe-pearl:#F5EFE6; --sidebar-w:260px;
    --font-serif:'Playfair Display',Georgia,serif; --font-sans:'DM Sans',sans-serif;
}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:var(--font-sans);background:var(--kafe-cream);color:#1C1008;min-height:100vh;}
#sidebar{position:fixed;top:0;left:0;width:var(--sidebar-w);height:100vh;background:var(--kafe-brown);color:#fff;display:flex;flex-direction:column;z-index:100;}
.sidebar-brand{padding:1.8rem 1.5rem 1.4rem;border-bottom:1px solid rgba(255,255,255,0.12);}
.brand-name{font-family:var(--font-serif);font-size:1.4rem;font-style:italic;color:var(--kafe-gold);}
.brand-sub{font-size:0.68rem;color:rgba(255,255,255,0.5);letter-spacing:.12em;text-transform:uppercase;margin-top:3px;}
.sidebar-nav{flex:1;overflow-y:auto;padding:.75rem 0;}
.nav-section-label{font-size:.65rem;color:rgba(255,255,255,0.4);letter-spacing:.14em;text-transform:uppercase;padding:.6rem 1.5rem .25rem;}
.nav-link-item{display:flex;align-items:center;gap:10px;padding:.6rem 1.5rem;color:rgba(255,255,255,0.78);font-size:.875rem;border-left:3px solid transparent;transition:all .18s;text-decoration:none;width:100%;}
.nav-link-item:hover,.nav-link-item.active{background:rgba(212,168,83,0.15);color:var(--kafe-gold);border-left-color:var(--kafe-gold);}
.nav-link-item i{font-size:1rem;width:18px;}
.sidebar-footer{padding:1rem 1.5rem;border-top:1px solid rgba(255,255,255,0.12);display:flex;align-items:center;gap:10px;}
.user-avatar{width:34px;height:34px;border-radius:50%;background:var(--kafe-caramel);display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:600;color:#fff;flex-shrink:0;overflow:hidden;}
.user-avatar img{width:100%;height:100%;object-fit:cover;}
#main{margin-left:var(--sidebar-w);display:flex;flex-direction:column;min-height:100vh;}
.topbar{background:#fff;border-bottom:1px solid rgba(74,44,23,0.12);padding:0 2rem;height:64px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50;}
.topbar-title{font-family:var(--font-serif);font-size:1.2rem;color:var(--kafe-brown);font-style:italic;}
.content-area{padding:2rem;flex:1;}
.kafe-card{background:#fff;border:1px solid rgba(74,44,23,0.1);border-radius:14px;}
.kafe-card-header{padding:1rem 1.5rem;border-bottom:1px solid rgba(74,44,23,0.08);display:flex;align-items:center;justify-content:space-between;}
.kafe-card-body{padding:1.5rem;}
.stat-card{background:#fff;border:1px solid rgba(74,44,23,0.1);border-radius:14px;padding:1.4rem 1.5rem;}
.stat-label{font-size:.72rem;color:#888;text-transform:uppercase;letter-spacing:.1em;margin-bottom:6px;}
.stat-value{font-family:var(--font-serif);font-size:1.8rem;font-weight:600;color:var(--kafe-brown);}
.stat-change{font-size:.75rem;margin-top:5px;}
.stat-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;}
.section-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;}
.section-title{font-family:var(--font-serif);font-size:1.5rem;color:var(--kafe-brown);font-style:italic;}
.btn-kafe{background:var(--kafe-brown);color:#fff;border:none;padding:.5rem 1.2rem;border-radius:8px;font-family:var(--font-sans);font-size:.85rem;font-weight:500;cursor:pointer;transition:background .18s;display:inline-flex;align-items:center;gap:6px;}
.btn-kafe:hover{background:#3a2110;color:#fff;}
.btn-kafe-outline{background:transparent;color:var(--kafe-brown);border:1.5px solid var(--kafe-brown);padding:.5rem 1.2rem;border-radius:8px;font-family:var(--font-sans);font-size:.85rem;font-weight:500;cursor:pointer;transition:all .18s;display:inline-flex;align-items:center;gap:6px;}
.btn-kafe-outline:hover{background:var(--kafe-brown);color:#fff;}
.btn-gold{background:var(--kafe-gold);color:#1C1008;border:none;padding:.5rem 1.2rem;border-radius:8px;font-size:.85rem;font-weight:500;cursor:pointer;}
.btn-icon{width:32px;height:32px;border-radius:7px;border:1px solid rgba(74,44,23,0.15);background:#fff;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-size:.85rem;color:var(--kafe-brown);transition:all .15s;}
.btn-icon:hover{background:var(--kafe-pearl);}
.btn-icon.danger{border-color:rgba(192,57,43,.25);color:#c0392b;}
.btn-icon.danger:hover{background:#fdf0ee;}
.badge-kafe{padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:500;}
.badge-active{background:rgba(122,140,110,.15);color:var(--kafe-sage);}
.badge-inactive{background:rgba(192,57,43,.1);color:#c0392b;}
.badge-pending{background:rgba(212,168,83,.18);color:#a07020;}
.badge-completed{background:rgba(122,140,110,.15);color:var(--kafe-sage);}
.badge-cancelled{background:rgba(192,57,43,.1);color:#c0392b;}
.table-kafe thead th{background:var(--kafe-pearl);color:var(--kafe-brown);font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.08em;border-color:rgba(74,44,23,0.12);}
.table-kafe tbody td{font-size:.875rem;vertical-align:middle;border-color:rgba(74,44,23,0.07);}
.table-kafe tbody tr:hover td{background:rgba(250,247,242,0.8);}
.form-label-kafe{font-size:.8rem;font-weight:500;color:var(--kafe-brown);margin-bottom:5px;display:block;}
.form-control-kafe{width:100%;padding:.55rem .9rem;border:1.5px solid rgba(74,44,23,0.18);border-radius:9px;font-family:var(--font-sans);font-size:.875rem;background:#fff;transition:border-color .18s;outline:none;}
.form-control-kafe:focus{border-color:var(--kafe-caramel);}
.upload-zone{border:2px dashed rgba(74,44,23,0.2);border-radius:12px;padding:1.5rem;text-align:center;cursor:pointer;transition:all .2s;background:var(--kafe-pearl);}
.upload-zone:hover{border-color:var(--kafe-caramel);}
.alert-kafe-success{background:rgba(122,140,110,.1);border:1px solid rgba(122,140,110,.3);border-radius:10px;padding:.75rem 1rem;color:#3d5c35;font-size:.85rem;}
.alert-kafe-error{background:rgba(192,57,43,.08);border:1px solid rgba(192,57,43,.25);border-radius:10px;padding:.75rem 1rem;color:#8b1a1a;font-size:.85rem;}
.modal-kafe .modal-header{background:var(--kafe-brown);color:#fff;border:none;}
.modal-kafe .modal-title{font-family:var(--font-serif);font-style:italic;}
.modal-kafe .modal-header .btn-close{filter:invert(1);}
::-webkit-scrollbar{width:5px;} ::-webkit-scrollbar-thumb{background:rgba(74,44,23,0.2);border-radius:3px;}
</style>
<?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

<aside id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-name">☕ Kafé Lumière</div>
        <div class="brand-sub">Management System</div>
    </div>
    <nav class="sidebar-nav">

        
        <?php if(auth()->user()->isCustomer()): ?>
            <div class="nav-section-label">My Account</div>
            <a href="<?php echo e(route('customer.dashboard')); ?>" class="nav-link-item <?php echo e(request()->routeIs('customer.*') ? 'active' : ''); ?>">
                <i class="bi bi-grid-1x2"></i> My Dashboard
            </a>

            <div class="nav-section-label" style="margin-top:.75rem;">Account</div>
            <a href="<?php echo e(route('admin.profile.show')); ?>" class="nav-link-item <?php echo e(request()->routeIs('admin.profile*') ? 'active' : ''); ?>">
                <i class="bi bi-person-circle"></i> My Profile
            </a>

        
        <?php else: ?>
            <?php if(auth()->user()->isAdmin()): ?>
            <div class="nav-section-label">Main</div>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            <?php endif; ?>

            <a href="<?php echo e(route('cashier.orders.index')); ?>" class="nav-link-item <?php echo e(request()->routeIs('cashier.*') ? 'active' : ''); ?>">
                <i class="bi bi-bag-check"></i> New Order
            </a>
            <a href="<?php echo e(route('home')); ?>" class="nav-link-item">
                <i class="bi bi-house"></i> Menu / Home
            </a>

            <?php if(auth()->user()->isAdmin()): ?>
            <div class="nav-section-label" style="margin-top:.75rem;">Catalog</div>
            <a href="<?php echo e(route('admin.products.index')); ?>" class="nav-link-item <?php echo e(request()->routeIs('admin.products*') ? 'active' : ''); ?>">
                <i class="bi bi-cup-hot"></i> Products
            </a>
            <a href="<?php echo e(route('admin.reviews.index')); ?>" class="nav-link-item <?php echo e(request()->routeIs('admin.reviews*') ? 'active' : ''); ?>">
                <i class="bi bi-star"></i> Reviews
            </a>

            <div class="nav-section-label" style="margin-top:.75rem;">Transactions</div>
            <a href="<?php echo e(route('admin.transactions.index')); ?>" class="nav-link-item <?php echo e(request()->routeIs('admin.transactions*') ? 'active' : ''); ?>">
                <i class="bi bi-receipt"></i> Transactions
            </a>
            <a href="<?php echo e(route('admin.reports.index')); ?>" class="nav-link-item <?php echo e(request()->routeIs('admin.reports*') ? 'active' : ''); ?>">
                <i class="bi bi-bar-chart-line"></i> Reports
            </a>

            <div class="nav-section-label" style="margin-top:.75rem;">Administration</div>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="nav-link-item <?php echo e(request()->routeIs('admin.users*') ? 'active' : ''); ?>">
                <i class="bi bi-people"></i> Users
            </a>
            <?php endif; ?>

            <div class="nav-section-label" style="margin-top:.75rem;">Account</div>
            <a href="<?php echo e(route('admin.profile.show')); ?>" class="nav-link-item <?php echo e(request()->routeIs('admin.profile*') ? 'active' : ''); ?>">
                <i class="bi bi-person-circle"></i> My Profile
            </a>
        <?php endif; ?>

    </nav>
    <div class="sidebar-footer">
        <div class="user-avatar">
            <?php if(auth()->user()->photo): ?>
                <img src="<?php echo e(auth()->user()->photo_url); ?>" alt="">
            <?php else: ?>
                <?php echo e(strtoupper(substr(auth()->user()->first_name, 0, 1))); ?>

            <?php endif; ?>
        </div>
        <div style="flex:1;min-width:0;">
            <div style="font-size:.82rem;font-weight:500;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?php echo e(auth()->user()->full_name); ?></div>
            <div style="font-size:.7rem;color:rgba(255,255,255,0.5);"><?php echo e(ucfirst(auth()->user()->role)); ?></div>
        </div>
        <form action="<?php echo e(route('logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button class="btn-icon" style="background:transparent;border-color:rgba(255,255,255,0.2);color:rgba(255,255,255,0.6);" title="Logout">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </form>
    </div>
</aside>

<div id="main">
    <header class="topbar">
        <div class="topbar-title"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></div>
        <div class="d-flex align-items-center gap-3">
            <span style="font-size:.8rem;color:#888;"><?php echo e(now()->format('D, M d Y')); ?></span>
            
            <?php if(auth()->user()->isCustomer()): ?>
                <a href="<?php echo e(route('customer.dashboard')); ?>" class="btn-kafe">
                    <i class="bi bi-grid-1x2"></i> My Dashboard
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('cashier.orders.index')); ?>" class="btn-kafe">
                    <i class="bi bi-plus-lg"></i> New Order
                </a>
            <?php endif; ?>
        </div>
    </header>

    <div class="content-area">
        <?php if(session('success')): ?>
            <div class="alert-kafe-success mb-3"><i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error') || $errors->any()): ?>
            <div class="alert-kafe-error mb-3">
                <i class="bi bi-exclamation-circle"></i>
                <?php echo e(session('error') ?? $errors->first()); ?>

            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
</script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\admin\kafe-lumiere\resources\views/layouts/admin.blade.php ENDPATH**/ ?>