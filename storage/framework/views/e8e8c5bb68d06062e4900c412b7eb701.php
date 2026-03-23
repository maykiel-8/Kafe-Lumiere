
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Kafé Lumière — Our Menu</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root{--kafe-cream:#FAF7F2;--kafe-brown:#4A2C17;--kafe-caramel:#C8874A;--kafe-blush:#E8D5C4;--kafe-sage:#7A8C6E;--kafe-gold:#D4A853;--kafe-pearl:#F5EFE6;--font-serif:'Playfair Display',serif;--font-sans:'DM Sans',sans-serif;}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:var(--font-sans);background:var(--kafe-cream);color:#1C1008;}

/* Navbar */
nav{background:var(--kafe-brown);padding:1rem 2rem;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100;}
.nav-brand{font-family:var(--font-serif);font-size:1.4rem;font-style:italic;color:var(--kafe-gold);text-decoration:none;}
.nav-links{display:flex;align-items:center;gap:16px;}
.nav-links a{color:rgba(255,255,255,0.75);text-decoration:none;font-size:.85rem;transition:color .15s;}
.nav-links a:hover{color:#fff;}
.btn-nav{background:var(--kafe-gold);color:var(--kafe-brown);border:none;padding:.45rem 1.1rem;border-radius:8px;font-family:var(--font-sans);font-size:.82rem;font-weight:600;cursor:pointer;text-decoration:none;}

/* Hero */
.hero{background:linear-gradient(135deg,var(--kafe-brown) 0%,#6B3E20 100%);padding:4rem 2rem;text-align:center;color:#fff;}
.hero-title{font-family:var(--font-serif);font-size:3rem;font-style:italic;color:var(--kafe-gold);margin-bottom:.5rem;}
.hero-sub{font-size:1rem;opacity:.75;margin-bottom:2rem;}
.search-wrap{display:flex;max-width:520px;margin:0 auto;background:#fff;border-radius:50px;overflow:hidden;padding:5px 5px 5px 20px;box-shadow:0 6px 24px rgba(0,0,0,0.25);}
.search-wrap input{border:none;outline:none;flex:1;font-family:var(--font-sans);font-size:.9rem;color:#1C1008;background:transparent;}
.search-wrap button{background:var(--kafe-caramel);color:#fff;border:none;padding:10px 22px;border-radius:40px;font-family:var(--font-sans);font-weight:600;cursor:pointer;white-space:nowrap;}
.search-wrap button:hover{background:#a0632c;}

/* Filters */
.filter-bar{background:#fff;border-bottom:1px solid rgba(74,44,23,.1);padding:.85rem 2rem;display:flex;align-items:center;gap:10px;flex-wrap:wrap;position:sticky;top:60px;z-index:90;}
.chip{padding:5px 15px;border-radius:20px;font-size:.78rem;cursor:pointer;border:1.5px solid rgba(74,44,23,.15);color:var(--kafe-brown);background:#fff;transition:all .15s;white-space:nowrap;text-decoration:none;}
.chip:hover,.chip.active{background:var(--kafe-brown);color:#fff;border-color:var(--kafe-brown);}
.price-filter{display:flex;align-items:center;gap:8px;margin-left:auto;}
.price-filter label{font-size:.75rem;color:#888;}
.price-filter input[type=range]{width:100px;}
.price-filter span{font-size:.78rem;font-weight:500;color:var(--kafe-brown);min-width:40px;}

/* Products */
.main-content{max-width:1280px;margin:0 auto;padding:2rem;}
.section-title{font-family:var(--font-serif);font-size:1.6rem;font-style:italic;color:var(--kafe-brown);margin-bottom:1.2rem;}

.product-card{background:#fff;border:1px solid rgba(74,44,23,.1);border-radius:14px;overflow:hidden;transition:all .2s;}
.product-card:hover{box-shadow:0 6px 24px rgba(74,44,23,.1);transform:translateY(-3px);}
.product-img{height:160px;display:flex;align-items:center;justify-content:center;background:var(--kafe-pearl);font-size:3rem;position:relative;overflow:hidden;}
.product-img img{width:100%;height:100%;object-fit:cover;}
.product-img .cat-tag{position:absolute;top:8px;left:8px;background:rgba(74,44,23,.75);color:#fff;font-size:.65rem;padding:2px 8px;border-radius:10px;}
.product-body{padding:1rem;}
.product-name{font-weight:600;font-size:.9rem;color:var(--kafe-brown);margin-bottom:2px;}
.product-desc{font-size:.75rem;color:#888;margin-bottom:.75rem;line-height:1.4;}
.product-footer{display:flex;align-items:center;justify-content:space-between;}
.product-price{font-family:var(--font-serif);font-size:1.1rem;color:var(--kafe-caramel);font-weight:600;}
.btn-add{background:var(--kafe-brown);color:#fff;border:none;padding:6px 14px;border-radius:7px;font-size:.78rem;font-weight:500;cursor:pointer;transition:background .15s;}
.btn-add:hover{background:#3a2110;}

/* Review form */
.review-section{background:var(--kafe-pearl);border-radius:14px;padding:1.5rem;margin-top:1.5rem;}
.stars{font-size:1.6rem;color:var(--kafe-gold);cursor:pointer;letter-spacing:3px;}

/* Footer */
footer{background:var(--kafe-brown);color:rgba(255,255,255,.65);text-align:center;padding:1.5rem;font-size:.8rem;margin-top:3rem;}
footer .brand{font-family:var(--font-serif);font-style:italic;color:var(--kafe-gold);font-size:1.1rem;display:block;margin-bottom:.4rem;}

/* No-results */
.no-results{text-align:center;padding:4rem 2rem;color:#aaa;}
.no-results i{font-size:3rem;display:block;margin-bottom:1rem;}
</style>
</head>
<body>


<nav>
    <a href="<?php echo e(route('home')); ?>" class="nav-brand">☕ Kafé Lumière</a>
    <div class="nav-links">
        <?php if(auth()->guard()->check()): ?>
            <?php if(auth()->user()->isAdmin()): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
            <?php endif; ?>
            <a href="<?php echo e(route('cashier.orders.index')); ?>">New Order</a>
            <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline;">
                <?php echo csrf_field(); ?>
                <button style="background:none;border:none;color:rgba(255,255,255,0.75);cursor:pointer;font-size:.85rem;" type="submit">Logout</button>
            </form>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>">Staff Login</a>
            <a href="<?php echo e(route('register')); ?>" class="btn-nav">Register</a>
        <?php endif; ?>
    </div>
</nav>


<div class="hero">
    <div class="hero-title">Kafé Lumière</div>
    <div class="hero-sub">Premium milk teas brewed with love</div>
    <form action="<?php echo e(route('home.search')); ?>" method="GET" class="search-wrap">
        <input type="text" name="q" value="<?php echo e($query ?? ''); ?>"
               placeholder="Search drinks, flavors, categories…" autocomplete="off">
        <button type="submit"><i class="bi bi-search"></i> Search</button>
    </form>
    <?php if(isset($query)): ?>
        <div style="margin-top:.75rem;font-size:.82rem;opacity:.7;">
            Results for: <strong><?php echo e($query); ?></strong>
            <a href="<?php echo e(route('home')); ?>" style="color:var(--kafe-gold);margin-left:8px;">✕ Clear</a>
        </div>
    <?php endif; ?>
</div>


<div class="filter-bar">
    <a href="<?php echo e(route('home')); ?>" class="chip <?php echo e(!request('category') ? 'active' : ''); ?>">All</a>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('home', array_merge(request()->query(), ['category' => $cat->id]))); ?>"
           class="chip <?php echo e(request('category') == $cat->id ? 'active' : ''); ?>"><?php echo e($cat->name); ?></a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <div class="price-filter">
        <label>Max Price:</label>
        <input type="range" id="priceRange" min="0" max="<?php echo e($maxProductPrice); ?>" step="10"
               value="<?php echo e(request('max_price', $maxProductPrice)); ?>"
               oninput="document.getElementById('priceVal').textContent='₱'+this.value;filterByPrice(this.value)">
        <span id="priceVal">₱<?php echo e(request('max_price', $maxProductPrice)); ?></span>
    </div>
</div>


<div class="main-content">

    <?php if(isset($query) && $products->total() === 0): ?>
        <div class="no-results">
            <i class="bi bi-search"></i>
            <div style="font-size:1.1rem;font-weight:500;margin-bottom:.5rem;">No results for "<?php echo e($query); ?>"</div>
            <div style="font-size:.85rem;">Try a different search term or browse all products below.</div>
            <a href="<?php echo e(route('home')); ?>" style="display:inline-block;margin-top:1rem;color:var(--kafe-caramel);text-decoration:none;">← Browse all products</a>
        </div>
    <?php else: ?>
        <div class="section-title">
            <?php echo e(isset($query) ? 'Search Results' : 'Our Menu'); ?>

            <span style="font-size:.85rem;color:#888;font-family:var(--font-sans);font-style:normal;font-weight:400;margin-left:8px;"><?php echo e($products->total()); ?> drinks</span>
        </div>

        <div class="row g-3" id="productGrid">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="product-card">
                    <div class="product-img" id="img_<?php echo e($product->id); ?>">
                        <span class="cat-tag"><?php echo e($product->category->name); ?></span>
                        <?php
                            $allPhotos = $product->photos->pluck('path')->toArray();
                            if (empty($allPhotos) && $product->main_photo) $allPhotos = [$product->main_photo];
                            $mainPhoto = $product->main_photo ?? ($allPhotos[0] ?? null);
                        ?>
                        <?php if($mainPhoto): ?>
                            
                            <img src="<?php echo e(asset('storage/'.$mainPhoto)); ?>"
                                 alt="<?php echo e($product->name); ?>"
                                 id="mainImg_<?php echo e($product->id); ?>"
                                 style="width:100%;height:100%;object-fit:cover;"
                                 data-photos='<?php echo json_encode(array_map(fn($p) => asset("storage/".$p), $allPhotos), 512) ?>'
                                 data-current="0">
                            <?php if(count($allPhotos) > 1): ?>
                                
                                <button onclick="changePhoto(event, 'mainImg_<?php echo e($product->id); ?>', -1)"
                                        style="position:absolute;left:6px;top:50%;transform:translateY(-50%);width:26px;height:26px;border-radius:50%;background:rgba(0,0,0,0.45);border:none;color:#fff;font-size:.85rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .15s;z-index:2;"
                                        onmouseover="this.style.background='rgba(74,44,23,0.85)'"
                                        onmouseout="this.style.background='rgba(0,0,0,0.45)'"
                                        title="Previous photo">&#8249;</button>
                                
                                <button onclick="changePhoto(event, 'mainImg_<?php echo e($product->id); ?>', 1)"
                                        style="position:absolute;right:6px;top:50%;transform:translateY(-50%);width:26px;height:26px;border-radius:50%;background:rgba(0,0,0,0.45);border:none;color:#fff;font-size:.85rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .15s;z-index:2;"
                                        onmouseover="this.style.background='rgba(74,44,23,0.85)'"
                                        onmouseout="this.style.background='rgba(0,0,0,0.45)'"
                                        title="Next photo">&#8250;</button>
                                
                                <div style="position:absolute;bottom:6px;right:8px;background:rgba(0,0,0,0.45);color:#fff;border-radius:8px;padding:1px 7px;font-size:.62rem;">
                                    <span id="photoNum_<?php echo e($product->id); ?>">1</span>/<?php echo e(count($allPhotos)); ?>

                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            ☕
                        <?php endif; ?>
                    </div>
                    <div class="product-body">
                        <div class="product-name"><?php echo e($product->name); ?></div>
                        <div class="product-desc"><?php echo e(Str::limit($product->description, 60)); ?></div>
                        <div class="product-footer">
                            <div>
                                <div class="product-price">₱<?php echo e(number_format($product->price_tall,2)); ?></div>
                                <?php if($product->price_grande): ?>
                                    <div style="font-size:.7rem;color:#888;">Grande: ₱<?php echo e(number_format($product->price_grande,2)); ?></div>
                                <?php endif; ?>
                            </div>
                            <?php if(auth()->guard()->check()): ?>
                                <button class="btn-add" onclick="quickOrder(<?php echo e($product->id); ?>)">
                                    <i class="bi bi-plus-lg"></i> Order
                                </button>
                            <?php else: ?>
                                <a href="<?php echo e(route('login')); ?>" class="btn-add">Order</a>
                            <?php endif; ?>
                        </div>
                        <?php if($product->avg_rating > 0): ?>
                        <div style="margin-top:6px;font-size:.72rem;color:var(--kafe-gold);">
                            <?php echo e(str_repeat('★', round($product->avg_rating))); ?><?php echo e(str_repeat('☆', 5 - round($product->avg_rating))); ?>

                            <span style="color:#888;"><?php echo e($product->avg_rating); ?>/5</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="no-results">
                    <i class="bi bi-cup-hot"></i>
                    <div>No products available right now.</div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        
        <div class="mt-4 d-flex justify-content-center">
            <?php echo e($products->appends(request()->query())->links()); ?>

        </div>
    <?php endif; ?>

    
    <?php if(auth()->guard()->check()): ?>
    <?php if(isset($userTransactions) && $userTransactions->count()): ?>
    <div class="review-section mt-4">
        <div class="section-title" style="font-size:1.2rem;">Leave a Review</div>
        <form action="<?php echo e(route('reviews.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row g-3">
                <div class="col-md-5">
                    <label style="font-size:.8rem;font-weight:500;color:var(--kafe-brown);display:block;margin-bottom:4px;">Product</label>
                    <select name="product_id" class="form-control" style="border-radius:9px;border:1.5px solid rgba(74,44,23,.18);" required>
                        <option value="">-- Select a product you purchased --</option>
                        <?php $__currentLoopData = $userTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $t->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->product_id); ?>" data-txn="<?php echo e($t->id); ?>"><?php echo e($item->product_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <input type="hidden" name="transaction_id" id="txnId">
                </div>
                <div class="col-md-2">
                    <label style="font-size:.8rem;font-weight:500;color:var(--kafe-brown);display:block;margin-bottom:4px;">Rating</label>
                    <div class="stars" id="starPicker">☆☆☆☆☆</div>
                    <input type="hidden" name="rating" id="ratingVal" value="0">
                </div>
                <div class="col-md-5">
                    <label style="font-size:.8rem;font-weight:500;color:var(--kafe-brown);display:block;margin-bottom:4px;">Comment *</label>
                    <textarea name="comment" rows="2" required placeholder="Share your experience…"
                              style="width:100%;padding:.55rem .9rem;border:1.5px solid rgba(74,44,23,.18);border-radius:9px;font-family:var(--font-sans);font-size:.875rem;resize:none;outline:none;"></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" style="background:var(--kafe-brown);color:#fff;border:none;padding:.5rem 1.4rem;border-radius:8px;font-family:var(--font-sans);font-size:.85rem;font-weight:500;cursor:pointer;">
                        <i class="bi bi-star"></i> Submit Review
                    </button>
                </div>
            </div>
        </form>
    </div>
    <?php endif; ?>
    <?php endif; ?>

</div>

<footer>
    <span class="brand">Kafé Lumière</span>
    123 Brew Street, Manila · (02) 8888-1234 · kafelumiere@email.com<br>
    &copy; <?php echo e(date('Y')); ?> Kafé Lumière Management System. All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Price range filter — submits form with max_price param
function filterByPrice(val) {
    clearTimeout(window._priceTimer);
    window._priceTimer = setTimeout(() => {
        const url = new URL(window.location.href);
        url.searchParams.set('max_price', val);
        window.location = url.toString();
    }, 600);
}

// Star picker
const stars = document.getElementById('starPicker');
if (stars) {
    stars.addEventListener('click', e => {
        const idx = Array.from(stars.children || [...stars.textContent].map((_,i)=>i)).indexOf(e.target);
        if (idx < 0) return;
        const val = idx + 1;
        stars.textContent = '★'.repeat(val) + '☆'.repeat(5 - val);
        document.getElementById('ratingVal').value = val;
    });
}

// Set transaction_id when product is selected
const productSelect = document.querySelector('select[name="product_id"]');
if (productSelect) {
    productSelect.addEventListener('change', e => {
        const opt = e.target.options[e.target.selectedIndex];
        document.getElementById('txnId').value = opt.dataset.txn || '';
    });
}

// Quick order redirect
function quickOrder(id) {
    window.location = '<?php echo e(route("cashier.orders.index")); ?>';
}
</script>
<script>
// Prev/Next photo navigation for multi-photo products
function changePhoto(e, imgId, dir) {
    e.stopPropagation(); // prevent card click
    const img = document.getElementById(imgId);
    if (!img) return;
    const photos  = JSON.parse(img.dataset.photos);
    let current   = parseInt(img.dataset.current) || 0;
    current       = (current + dir + photos.length) % photos.length;
    img.src              = photos[current];
    img.dataset.current  = current;
    // Update counter
    const productId = imgId.replace('mainImg_', '');
    const counter   = document.getElementById('photoNum_' + productId);
    if (counter) counter.textContent = current + 1;
}
</script>
</body>
</html><?php /**PATH C:\Users\admin\kafe-lumiere\resources\views/home.blade.php ENDPATH**/ ?>