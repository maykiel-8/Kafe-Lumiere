
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title>My Account — Kafé Lumière</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root{--kafe-cream:#FAF7F2;--kafe-brown:#4A2C17;--kafe-caramel:#C8874A;--kafe-blush:#E8D5C4;
      --kafe-sage:#7A8C6E;--kafe-gold:#D4A853;--kafe-pearl:#F5EFE6;
      --font-serif:'Playfair Display',serif;--font-sans:'DM Sans',sans-serif;}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:var(--font-sans);background:var(--kafe-cream);color:#1C1008;}

/* NAV */
nav{background:var(--kafe-brown);padding:.9rem 2rem;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100;}
.nav-brand{font-family:var(--font-serif);font-size:1.3rem;font-style:italic;color:var(--kafe-gold);text-decoration:none;}
.nav-links{display:flex;align-items:center;gap:16px;}
.nav-links a{color:rgba(255,255,255,.75);text-decoration:none;font-size:.85rem;transition:color .15s;}
.nav-links a:hover{color:#fff;}

/* LAYOUT */
.main{max-width:1200px;margin:0 auto;padding:2rem 1.5rem;}

/* CARDS */
.kafe-card{background:#fff;border:1px solid rgba(74,44,23,.1);border-radius:14px;overflow:hidden;}
.kafe-card-header{padding:.9rem 1.3rem;border-bottom:1px solid rgba(74,44,23,.08);font-weight:500;font-size:.9rem;display:flex;align-items:center;justify-content:space-between;}
.kafe-card-body{padding:1.3rem;}

/* STATS */
.stat-card{background:#fff;border:1px solid rgba(74,44,23,.1);border-radius:12px;padding:1.1rem 1.3rem;}
.stat-label{font-size:.7rem;color:#888;text-transform:uppercase;letter-spacing:.1em;margin-bottom:5px;}
.stat-value{font-family:var(--font-serif);font-size:1.7rem;color:var(--kafe-brown);}

/* BUTTONS */
.btn-kafe{background:var(--kafe-brown);color:#fff;border:none;padding:.5rem 1.1rem;border-radius:8px;font-family:var(--font-sans);font-size:.83rem;font-weight:500;cursor:pointer;display:inline-flex;align-items:center;gap:6px;text-decoration:none;transition:background .18s;}
.btn-kafe:hover{background:#3a2110;color:#fff;}
.btn-outline{background:transparent;color:var(--kafe-brown);border:1.5px solid var(--kafe-brown);padding:.5rem 1.1rem;border-radius:8px;font-size:.83rem;font-weight:500;cursor:pointer;display:inline-flex;align-items:center;gap:6px;text-decoration:none;transition:all .18s;}
.btn-outline:hover{background:var(--kafe-brown);color:#fff;}

/* FORMS */
.form-lbl{font-size:.78rem;font-weight:500;color:var(--kafe-brown);display:block;margin-bottom:4px;}
.form-ctrl{width:100%;padding:.5rem .85rem;border:1.5px solid rgba(74,44,23,.18);border-radius:8px;font-family:var(--font-sans);font-size:.875rem;outline:none;transition:border-color .18s;background:#fff;}
.form-ctrl:focus{border-color:var(--kafe-caramel);}

/* PRODUCT TILES */
.product-tile{background:#fff;border:1.5px solid rgba(74,44,23,.1);border-radius:12px;padding:.85rem;cursor:pointer;transition:all .18s;text-align:center;}
.product-tile:hover{border-color:var(--kafe-caramel);box-shadow:0 4px 16px rgba(74,44,23,.1);transform:translateY(-2px);}
.product-tile .emoji{font-size:2rem;display:block;margin-bottom:5px;}
.product-tile .p-name{font-size:.8rem;font-weight:500;color:var(--kafe-brown);}
.product-tile .p-price{font-family:var(--font-serif);font-size:.95rem;color:var(--kafe-caramel);}

/* CART */
.cart-item{display:flex;align-items:center;gap:8px;padding:7px 0;border-bottom:1px solid rgba(74,44,23,.07);font-size:.82rem;}
.qty-btn{width:24px;height:24px;border-radius:6px;border:1px solid rgba(74,44,23,.2);background:#fff;cursor:pointer;font-size:.8rem;display:flex;align-items:center;justify-content:center;transition:all .15s;}
.qty-btn:hover{background:var(--kafe-brown);color:#fff;}

/* BADGES */
.badge-completed{background:rgba(122,140,110,.15);color:var(--kafe-sage);padding:3px 9px;border-radius:20px;font-size:.7rem;}
.badge-pending{background:rgba(212,168,83,.18);color:#a07020;padding:3px 9px;border-radius:20px;font-size:.7rem;}
.badge-cancelled{background:rgba(192,57,43,.1);color:#c0392b;padding:3px 9px;border-radius:20px;font-size:.7rem;}

/* STARS */
.star-picker span{font-size:1.5rem;cursor:pointer;color:var(--kafe-gold);}
.star-display{color:var(--kafe-gold);letter-spacing:1px;}

/* ALERTS */
.alert-s{background:rgba(122,140,110,.1);border:1px solid rgba(122,140,110,.3);border-radius:10px;padding:.7rem 1rem;color:#3d5c35;font-size:.82rem;margin-bottom:1rem;}
.alert-e{background:rgba(192,57,43,.08);border:1px solid rgba(192,57,43,.25);border-radius:10px;padding:.7rem 1rem;color:#8b1a1a;font-size:.82rem;margin-bottom:1rem;}

/* TABS */
.tab-group{display:flex;background:var(--kafe-pearl);border-radius:10px;padding:4px;margin-bottom:1.2rem;}
.tab-btn{flex:1;padding:.48rem;border:none;background:transparent;border-radius:7px;font-family:var(--font-sans);font-size:.83rem;font-weight:500;cursor:pointer;color:#888;transition:all .2s;}
.tab-btn.active{background:#fff;color:var(--kafe-brown);box-shadow:0 2px 8px rgba(74,44,23,.1);}
.tab-pane{display:none;}
.tab-pane.active{display:block;}

table th{background:var(--kafe-pearl);color:var(--kafe-brown);font-size:.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.08em;padding:.65rem 1rem;}
table td{font-size:.83rem;vertical-align:middle;padding:.65rem 1rem;border-bottom:1px solid rgba(74,44,23,.06);}
</style>
</head>
<body>

<nav>
    <a href="<?php echo e(route('home')); ?>" class="nav-brand">☕ Kafé Lumière</a>
    <div class="nav-links">
        <a href="<?php echo e(route('admin.profile.show')); ?>"><i class="bi bi-person-circle"></i> Profile</a>
        <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline;">
            <?php echo csrf_field(); ?>
            <button style="background:none;border:none;color:rgba(255,255,255,.75);cursor:pointer;font-size:.85rem;font-family:var(--font-sans);">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</nav>

<div class="main">

    
    <?php if(session('success')): ?>
        <div class="alert-s"><i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <div class="alert-e"><i class="bi bi-exclamation-circle"></i> <?php echo e($errors->first()); ?></div>
    <?php endif; ?>

    
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:1.8rem;">
        <div style="width:56px;height:56px;border-radius:50%;background:var(--kafe-caramel);display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:#fff;font-family:var(--font-serif);overflow:hidden;flex-shrink:0;">
            <?php if(auth()->user()->photo): ?>
                <img src="<?php echo e(auth()->user()->photo_url); ?>" style="width:100%;height:100%;object-fit:cover;">
            <?php else: ?>
                <?php echo e(strtoupper(substr(auth()->user()->first_name,0,1))); ?>

            <?php endif; ?>
        </div>
        <div>
            <div style="font-family:var(--font-serif);font-size:1.35rem;color:var(--kafe-brown);">
                Welcome, <?php echo e(auth()->user()->first_name); ?>!
            </div>
            <div style="font-size:.78rem;color:#888;"><?php echo e(auth()->user()->email); ?></div>
        </div>
    </div>

    
    <div class="row g-3 mb-4">
        <div class="col-4">
            <div class="stat-card">
                <div class="stat-label">My Orders</div>
                <div class="stat-value"><?php echo e($orders->total()); ?></div>
            </div>
        </div>
        <div class="col-4">
            <div class="stat-card">
                <div class="stat-label">Reviews Written</div>
                <div class="stat-value"><?php echo e($myReviews->count()); ?></div>
            </div>
        </div>
        <div class="col-4">
            <div class="stat-card">
                <div class="stat-label">To Review</div>
                <div class="stat-value"><?php echo e($pendingReviews->count()); ?></div>
            </div>
        </div>
    </div>

    
    <div class="tab-group">
        <button class="tab-btn active" onclick="switchTab('order')"><i class="bi bi-cup-hot"></i> Order Now</button>
        <button class="tab-btn" onclick="switchTab('history')"><i class="bi bi-clock-history"></i> Order History</button>
        <button class="tab-btn" onclick="switchTab('reviews')">
            <i class="bi bi-star"></i> Reviews
            <?php if($pendingReviews->count()): ?> <span style="background:var(--kafe-caramel);color:#fff;border-radius:50%;width:18px;height:18px;font-size:.65rem;display:inline-flex;align-items:center;justify-content:center;margin-left:4px;"><?php echo e($pendingReviews->count()); ?></span> <?php endif; ?>
        </button>
    </div>

    
    
    
    <div class="tab-pane active" id="tab-order">
        <div class="row g-3">
            
            <div class="col-lg-8">
                
                <div style="display:flex;gap:7px;flex-wrap:wrap;margin-bottom:1rem;align-items:center;">
                    <button class="btn-outline" style="font-size:.75rem;padding:4px 12px;" onclick="filterCat(null,this)">All</button>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button class="btn-outline" style="font-size:.75rem;padding:4px 12px;" onclick="filterCat(<?php echo e($cat->id); ?>,this)"><?php echo e($cat->name); ?></button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <input type="text" id="prodSearch" class="form-ctrl" placeholder="Search…" style="width:160px;margin-left:auto;" oninput="renderProducts()">
                </div>
                
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:1rem;flex-wrap:wrap;">
                    <span style="font-size:.75rem;color:#888;">Max Price:</span>
                    <input type="range" id="priceRange" min="0" max="<?php echo e($maxProductPrice); ?>" value="<?php echo e($maxProductPrice); ?>" step="10"
                           style="width:160px;accent-color:var(--kafe-caramel);"
                           oninput="document.getElementById('priceVal').textContent='₱'+this.value; renderProducts();">
                    <span id="priceVal" style="font-size:.78rem;font-weight:500;color:var(--kafe-brown);min-width:42px;">₱<?php echo e($maxProductPrice); ?></span>
                    <button onclick="document.getElementById('priceRange').value=<?php echo e($maxProductPrice); ?>;document.getElementById('priceVal').textContent='₱<?php echo e($maxProductPrice); ?>';renderProducts();"
                            style="font-size:.7rem;color:#aaa;background:none;border:none;cursor:pointer;padding:0;">Reset</button>
                </div>
                <div class="row g-2" id="productGrid">
                    <?php $__currentLoopData = $allProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $tile_photo  = $p->main_photo ?? optional($p->photos->first())->path;
                        $tile_addons = $p->addons->map(fn($a) => [
                            'id'    => $a->id,
                            'name'  => $a->name,
                            'price' => (float) $a->price,
                        ])->values();
                    ?>
                    <div class="col-6 col-md-4 product-row"
                         data-cat="<?php echo e($p->category_id); ?>"
                         data-name="<?php echo e(strtolower($p->name)); ?>"
                         data-price="<?php echo e($p->price_tall); ?>">
                        <div class="product-tile"
                             onclick='openAddonModal(
                                 <?php echo e($p->id); ?>,
                                 <?php echo json_encode($p->name, 15, 512) ?>,
                                 <?php echo e($p->price_tall); ?>,
                                 <?php echo e($p->price_grande ?? "null"); ?>,
                                 <?php echo $tile_addons->toJson(); ?>

                             )'>
                            <?php if($tile_photo): ?>
                                <img src="<?php echo e(asset('storage/'.$tile_photo)); ?>"
                                     alt="<?php echo e($p->name); ?>"
                                     style="width:100%;height:100px;object-fit:cover;border-radius:8px 8px 0 0;">
                            <?php else: ?>
                                <span class="emoji">☕</span>
                            <?php endif; ?>
                            <div style="padding:.5rem .6rem;">
                                <div class="p-name"><?php echo e($p->name); ?></div>
                                <div class="p-price">₱<?php echo e(number_format($p->price_tall,2)); ?></div>
                                <?php if($p->addons->count()): ?>
                                    <div style="font-size:.68rem;color:#888;margin-top:2px;">
                                        <?php echo e($p->addons->pluck('name')->join(', ')); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="col-lg-4">
                <div class="kafe-card" style="position:sticky;top:76px;">
                    <div class="kafe-card-header">
                        <span><i class="bi bi-bag"></i> My Order</span>
                        <button class="btn-outline" style="font-size:.72rem;padding:3px 10px;" onclick="clearCart()">Clear</button>
                    </div>
                    <div class="kafe-card-body" style="padding:1rem;">
                        <div id="cartItems">
                            <div style="text-align:center;padding:1.2rem;color:#aaa;font-size:.82rem;">
                                <i class="bi bi-bag" style="font-size:1.5rem;display:block;margin-bottom:5px;"></i>
                                No items yet — click a drink to add
                            </div>
                        </div>

                        <div id="cartTotals" style="display:none;border-top:1px solid rgba(74,44,23,.1);padding-top:.75rem;margin-top:.5rem;">
                            <div style="display:flex;justify-content:space-between;font-size:.8rem;color:#888;padding:2px 0;"><span>Subtotal</span><span id="cartSubtotal">₱0</span></div>
                            <div style="display:flex;justify-content:space-between;font-size:.8rem;color:#888;padding:2px 0;"><span>VAT 12%</span><span id="cartTax">₱0</span></div>
                            <div style="display:flex;justify-content:space-between;font-weight:600;font-family:var(--font-serif);font-size:1rem;border-top:2px solid var(--kafe-brown);margin-top:6px;padding-top:6px;">
                                <span>Total</span><span id="cartTotal" style="color:var(--kafe-brown);">₱0</span>
                            </div>

                            
                            <input type="hidden" id="payMethod" value="cash">
                            <div style="margin-top:.85rem;">
                                <label class="form-lbl">Payment — Cash</label>
                                <div style="background:var(--kafe-pearl);border-radius:8px;padding:.6rem .9rem;font-size:.82rem;color:var(--kafe-brown);font-weight:500;">
                                    <i class="bi bi-cash-coin"></i> Cash payment at counter
                                </div>
                            </div>
                            <div style="margin-top:.6rem;">
                                <label class="form-lbl">Amount Tendered (₱) *</label>
                                <input type="number" class="form-ctrl" id="tendered" placeholder="Enter amount" min="0" step="0.01" oninput="calcChange()">
                                <div id="tenderedError" style="font-size:.73rem;color:#c0392b;margin-top:3px;display:none;">
                                    <i class="bi bi-exclamation-circle"></i> Amount is less than the total.
                                </div>
                                <div style="display:flex;justify-content:space-between;font-size:.78rem;color:#888;margin-top:4px;">
                                    <span>Change</span><span id="changeAmt" style="color:var(--kafe-sage);font-weight:500;">₱0.00</span>
                                </div>
                            </div>

                            <button class="btn-kafe mt-3" style="width:100%;justify-content:center;padding:.65rem;" onclick="placeOrder()">
                                <i class="bi bi-check2-circle"></i> Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    
    
    <div class="tab-pane" id="tab-history">
        <div class="kafe-card">
            <div class="kafe-card-header">Order History</div>
            <?php if($orders->isEmpty()): ?>
                <div style="text-align:center;padding:2.5rem;color:#aaa;">
                    <i class="bi bi-bag" style="font-size:2.2rem;display:block;margin-bottom:.6rem;"></i>
                    No orders yet. Go to <strong>Order Now</strong> to place your first order!
                </div>
            <?php else: ?>
                <table class="table mb-0" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Order #</th><th>Items</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><strong style="font-family:var(--font-serif);"><?php echo e($order->order_number); ?></strong></td>
                        <td>
                            <div style="font-size:.78rem;color:#888;">
                                <?php $__currentLoopData = $order->orderItems->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($item->product_name); ?> ×<?php echo e($item->quantity); ?><br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($order->orderItems->count() > 2): ?>
                                    <span style="color:var(--kafe-caramel);">+<?php echo e($order->orderItems->count()-2); ?> more</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td><strong>₱<?php echo e(number_format($order->total,2)); ?></strong></td>
                        <td style="font-size:.78rem;text-transform:uppercase;"><?php echo e($order->payment_method); ?></td>
                        <td><span class="badge-<?php echo e($order->status); ?>"><?php echo e(ucfirst($order->status)); ?></span></td>
                        <td style="font-size:.78rem;color:#888;"><?php echo e($order->created_at->format('M d, Y H:i')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <div style="padding:1rem 1.3rem;"><?php echo e($orders->links()); ?></div>
            <?php endif; ?>
        </div>
    </div>

    
    
    
    <div class="tab-pane" id="tab-reviews">
        <div class="row g-3">

            
            <div class="col-lg-6">
                <div class="kafe-card">
                    <div class="kafe-card-header">
                        <span><i class="bi bi-star" style="color:var(--kafe-gold);"></i> Write a Review</span>
                    </div>
                    <div class="kafe-card-body">
                        <?php if($pendingReviews->isEmpty()): ?>
                            <div style="text-align:center;padding:1.5rem;color:#aaa;font-size:.85rem;">
                                <i class="bi bi-check-circle" style="font-size:1.8rem;display:block;margin-bottom:.5rem;color:var(--kafe-sage);"></i>
                                <?php if($purchasedItems->isEmpty()): ?>
                                    You haven't purchased any products yet.<br>Place an order first, then come back to review!
                                <?php else: ?>
                                    You've reviewed all your purchased products. Thank you!
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <form action="<?php echo e(route('reviews.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label class="form-lbl">Product *</label>
                                    <select class="form-ctrl" name="product_id" required onchange="setTxnId(this)">
                                        <option value="">— Select a product you ordered —</option>
                                        <?php $__currentLoopData = $pendingReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item['product_id']); ?>" data-txn="<?php echo e($item['transaction_id']); ?>">
                                                <?php echo e($item['product_name']); ?> — <?php echo e($item['order_number']); ?> (<?php echo e($item['date']); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <input type="hidden" name="transaction_id" id="txnId">
                                <div class="mb-3">
                                    <label class="form-lbl">Rating *</label>
                                    <div id="starPicker" style="line-height:1;">
                                        <span data-v="1">☆</span><span data-v="2">☆</span>
                                        <span data-v="3">☆</span><span data-v="4">☆</span>
                                        <span data-v="5">☆</span>
                                    </div>
                                    <input type="hidden" name="rating" id="ratingVal" value="0">
                                </div>
                                <div class="mb-3">
                                    <label class="form-lbl">Comment *</label>
                                    <textarea class="form-ctrl" name="comment" rows="3"
                                              placeholder="Share your experience…" required></textarea>
                                </div>
                                <button type="submit" class="btn-kafe" style="width:100%;justify-content:center;">
                                    <i class="bi bi-star-fill"></i> Submit Review
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-6">
                <div class="kafe-card">
                    <div class="kafe-card-header">My Reviews (<?php echo e($myReviews->count()); ?>)</div>
                    <?php if($myReviews->isEmpty()): ?>
                        <div style="text-align:center;padding:2rem;color:#aaa;font-size:.85rem;">
                            No reviews written yet.
                        </div>
                    <?php else: ?>
                        <?php $__currentLoopData = $myReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="padding:.9rem 1.2rem;border-bottom:1px solid rgba(74,44,23,.07);">
                            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:3px;">
                                <span style="font-size:.85rem;font-weight:500;color:var(--kafe-brown);">
                                    <?php echo e($rev->product->name ?? '(Deleted Product)'); ?>

                                </span>
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <span class="star-display" style="font-size:.85rem;">
                                        <?php echo e(str_repeat('★',$rev->rating)); ?><?php echo e(str_repeat('☆',5-$rev->rating)); ?>

                                    </span>
                                    <button onclick="toggleEditReview(<?php echo e($rev->id); ?>)"
                                            style="background:none;border:1px solid rgba(74,44,23,.2);border-radius:6px;padding:2px 8px;font-size:.7rem;cursor:pointer;color:var(--kafe-brown);">
                                        Edit
                                    </button>
                                </div>
                            </div>
                            <div style="font-size:.8rem;color:#666;"><?php echo e($rev->comment); ?></div>
                            <div style="font-size:.72rem;color:#aaa;margin-top:2px;"><?php echo e($rev->created_at->format('M d, Y')); ?></div>

                            
                            <div id="editReview_<?php echo e($rev->id); ?>" style="display:none;margin-top:.75rem;background:var(--kafe-pearl);border-radius:8px;padding:.85rem;">
                                <form action="<?php echo e(route('reviews.update', $rev)); ?>" method="POST">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                    <div style="margin-bottom:.5rem;">
                                        <label style="font-size:.75rem;font-weight:500;color:var(--kafe-brown);display:block;margin-bottom:3px;">Rating</label>
                                        <div class="star-picker-edit" data-review="<?php echo e($rev->id); ?>" style="font-size:1.4rem;cursor:pointer;color:var(--kafe-gold);">
                                            <?php for($s=1;$s<=5;$s++): ?>
                                                <span data-val="<?php echo e($s); ?>"><?php echo e($s <= $rev->rating ? '★' : '☆'); ?></span>
                                            <?php endfor; ?>
                                        </div>
                                        <input type="hidden" name="rating" id="editRating_<?php echo e($rev->id); ?>" value="<?php echo e($rev->rating); ?>">
                                    </div>
                                    <div style="margin-bottom:.5rem;">
                                        <label style="font-size:.75rem;font-weight:500;color:var(--kafe-brown);display:block;margin-bottom:3px;">Comment</label>
                                        <textarea name="comment" rows="2"
                                                  style="width:100%;padding:.45rem .75rem;border:1.5px solid rgba(74,44,23,.18);border-radius:7px;font-size:.82rem;font-family:var(--font-sans);resize:vertical;"
                                                  required><?php echo e($rev->comment); ?></textarea>
                                    </div>
                                    <div style="display:flex;gap:6px;">
                                        <button type="submit" class="btn-kafe" style="font-size:.78rem;padding:5px 14px;">Save</button>
                                        <button type="button" onclick="toggleEditReview(<?php echo e($rev->id); ?>)"
                                                class="btn-outline" style="font-size:.78rem;padding:5px 14px;">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

</div>



<div class="modal fade" id="addonModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog" style="max-width:420px;">
        <div class="modal-content" style="border-radius:14px;border:1px solid rgba(74,44,23,.1);">
            <div class="modal-header" style="background:var(--kafe-brown);color:#fff;border:none;border-radius:14px 14px 0 0;">
                <h5 class="modal-title" id="addonModalTitle" style="font-family:var(--font-serif);font-style:italic;">Customize</h5>
                <button type="button" class="btn-close" style="filter:invert(1);" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:1.5rem;">
                
                <div style="margin-bottom:1rem;">
                    <label style="font-size:.8rem;font-weight:500;color:var(--kafe-brown);display:block;margin-bottom:6px;">Size</label>
                    <div style="display:flex;gap:8px;">
                        <label id="cust_sizeTallLabel" style="flex:1;padding:.6rem;border:1.5px solid var(--kafe-caramel);background:rgba(200,135,74,.06);border-radius:8px;cursor:pointer;text-align:center;font-size:.85rem;">
                            <input type="radio" name="custSizeChoice" value="Tall (16oz)" checked style="display:none;">
                            <span>Tall (16oz)</span><br>
                            <span id="cust_priceTall" style="font-family:var(--font-serif);color:var(--kafe-caramel);font-size:.9rem;"></span>
                        </label>
                        <label id="cust_sizeGrandeLabel" style="flex:1;padding:.6rem;border:1.5px solid rgba(74,44,23,.15);border-radius:8px;cursor:pointer;text-align:center;font-size:.85rem;">
                            <input type="radio" name="custSizeChoice" value="Grande (22oz)" style="display:none;">
                            <span>Grande (22oz)</span><br>
                            <span id="cust_priceGrande" style="font-family:var(--font-serif);color:var(--kafe-caramel);font-size:.9rem;"></span>
                        </label>
                    </div>
                </div>
                
                <div id="cust_addonOptions">
                    <label style="font-size:.8rem;font-weight:500;color:var(--kafe-brown);display:block;margin-bottom:6px;">Add-ons <span style="font-weight:400;color:#aaa;">(optional)</span></label>
                    <div id="cust_addonList"></div>
                </div>
            </div>
            <div class="modal-footer" style="border-top:1px solid rgba(74,44,23,.1);">
                <button class="btn-outline" data-bs-dismiss="modal">Cancel</button>
                <button class="btn-kafe" onclick="confirmCustAddToCart()"><i class="bi bi-plus-lg"></i> Add to Order</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="receiptModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:14px;border:1px solid rgba(74,44,23,.1);">
            <div class="modal-header" style="background:var(--kafe-brown);color:#fff;border:none;border-radius:14px 14px 0 0;">
                <h5 class="modal-title" style="font-family:var(--font-serif);font-style:italic;">Order Placed!</h5>
                <button type="button" class="btn-close" style="filter:invert(1);" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="receiptBody" style="padding:1.5rem;"></div>
            <div class="modal-footer" style="border-top:1px solid rgba(74,44,23,.1);">
                <button class="btn-outline" data-bs-dismiss="modal">Close</button>
                <a id="pdfLink" href="#" class="btn-kafe" target="_blank"><i class="bi bi-file-earmark-pdf"></i> Receipt PDF</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ── TAB SWITCHING ──────────────────────────────────────
function switchTab(name) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    event.currentTarget.classList.add('active');
}

// ── PRODUCT FILTERING ──────────────────────────────────
let activeCat = null;
function filterCat(catId, btn) {
    activeCat = catId;
    document.querySelectorAll('[onclick^="filterCat"]').forEach(b => {
        b.classList.remove('btn-kafe');
        b.classList.add('btn-outline');
    });
    btn.classList.remove('btn-outline');
    btn.classList.add('btn-kafe');
    renderProducts();
}
function renderProducts() {
    const search   = (document.getElementById('prodSearch').value || '').toLowerCase();
    const maxPrice = parseInt(document.getElementById('priceRange').value);

    document.querySelectorAll('.product-row').forEach(row => {
        const matchCat    = !activeCat || row.dataset.cat == activeCat;
        const matchSearch = !search || row.dataset.name.includes(search);
        const price       = parseFloat(row.dataset.price) || 0;
        const matchPrice  = price <= maxPrice;
        row.style.display = matchCat && matchSearch && matchPrice ? '' : 'none';
    });
}

// ── CART ───────────────────────────────────────────────
let cart = [];
let custPending = null; // product pending addon selection

function openAddonModal(id, name, priceTall, priceGrande, addons) {
    custPending = { id, name, priceTall: parseFloat(priceTall), priceGrande: priceGrande ? parseFloat(priceGrande) : null, addons };
    document.getElementById('addonModalTitle').textContent = name;

    // Size prices
    document.getElementById('cust_priceTall').textContent = '₱' + parseFloat(priceTall).toFixed(2);
    const grandeLbl = document.getElementById('cust_sizeGrandeLabel');
    if (priceGrande) {
        document.getElementById('cust_priceGrande').textContent = '₱' + parseFloat(priceGrande).toFixed(2);
        grandeLbl.style.opacity = '1'; grandeLbl.style.pointerEvents = 'auto';
    } else {
        document.getElementById('cust_priceGrande').textContent = 'N/A';
        grandeLbl.style.opacity = '.4'; grandeLbl.style.pointerEvents = 'none';
    }

    // Reset to Tall
    document.querySelector('input[name="custSizeChoice"][value="Tall (16oz)"]').checked = true;
    highlightCustSize();

    // Addons
    const listEl = document.getElementById('cust_addonList');
    if (!addons || !addons.length) {
        listEl.innerHTML = '<div style="font-size:.82rem;color:#aaa;padding:.4rem 0;">No add-ons for this product.</div>';
    } else {
        listEl.innerHTML = addons.map(a => `
            <label style="display:flex;align-items:center;justify-content:space-between;padding:8px 12px;border:1.5px solid rgba(74,44,23,.12);border-radius:8px;cursor:pointer;margin-bottom:6px;transition:all .15s;" onclick="toggleCustAddon(this)">
                <div style="display:flex;align-items:center;gap:8px;">
                    <input type="checkbox" value="${a.id}" data-name="${a.name}" data-price="${a.price}" style="display:none;">
                    <i class="bi bi-circle" style="color:#ccc;font-size:1rem;"></i>
                    <span style="font-size:.85rem;">${a.name}</span>
                </div>
                <span style="font-size:.78rem;color:var(--kafe-caramel);font-weight:500;">+₱${parseFloat(a.price).toFixed(2)}</span>
            </label>
        `).join('');
    }

    new bootstrap.Modal(document.getElementById('addonModal')).show();
}

function toggleCustAddon(label) {
    const cb   = label.querySelector('input[type="checkbox"]');
    cb.checked = !cb.checked;
    label.style.borderColor = cb.checked ? 'var(--kafe-caramel)' : 'rgba(74,44,23,.12)';
    label.style.background  = cb.checked ? 'rgba(200,135,74,.06)' : '';
    const icon = label.querySelector('i');
    icon.className = cb.checked ? 'bi bi-check-circle-fill' : 'bi bi-circle';
    icon.style.color = cb.checked ? 'var(--kafe-caramel)' : '#ccc';
}

function highlightCustSize() {
    document.querySelectorAll('[name="custSizeChoice"]').forEach(r => {
        const lbl = r.closest('label');
        lbl.style.borderColor = r.checked ? 'var(--kafe-caramel)' : 'rgba(74,44,23,.15)';
        lbl.style.background  = r.checked ? 'rgba(200,135,74,.06)' : '';
    });
}
document.querySelectorAll('input[name="custSizeChoice"]').forEach(r => r.addEventListener('change', highlightCustSize));

function confirmCustAddToCart() {
    if (!custPending) return;
    const size   = document.querySelector('input[name="custSizeChoice"]:checked').value;
    const price  = size === 'Grande (22oz)' && custPending.priceGrande ? custPending.priceGrande : custPending.priceTall;
    const addons = [...document.querySelectorAll('#cust_addonList input[type="checkbox"]:checked')].map(cb => cb.dataset.name);

    const existing = cart.find(i => i.id === custPending.id && i.size === size);
    if (existing) { existing.qty++; }
    else { cart.push({ id: custPending.id, name: custPending.name, price, size, addons, qty: 1 }); }

    bootstrap.Modal.getInstance(document.getElementById('addonModal')).hide();
    renderCart();
}
function removeFromCart(idx) {
    cart.splice(idx, 1);
    renderCart();
}
function changeQty(idx, d) {
    if (cart[idx]) { cart[idx].qty = Math.max(1, cart[idx].qty + d); renderCart(); }
}
function clearCart() {
    cart = [];
    renderCart();
}
function renderCart() {
    const container = document.getElementById('cartItems');
    const totalsEl  = document.getElementById('cartTotals');
    if (!cart.length) {
        container.innerHTML = '<div style="text-align:center;padding:1.2rem;color:#aaa;font-size:.82rem;"><i class="bi bi-bag" style="font-size:1.5rem;display:block;margin-bottom:5px;"></i>No items yet — click a drink to add</div>';
        totalsEl.style.display = 'none';
        return;
    }
    container.innerHTML = cart.map((i,idx) => `
        <div class="cart-item">
            <div style="flex:1;min-width:0;">
                <div style="font-weight:500;font-size:.82rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">${i.name}</div>
                <div style="font-size:.72rem;color:#888;">${i.size}${i.addons && i.addons.length ? ' · '+i.addons.join(', ') : ''}</div>
                <div style="font-size:.72rem;color:#888;">₱${i.price.toFixed(2)} each</div>
            </div>
            <div style="display:flex;align-items:center;gap:4px;flex-shrink:0;">
                <button class="qty-btn" onclick="changeQty(${idx},-1)">−</button>
                <span style="min-width:18px;text-align:center;font-weight:600;font-size:.85rem;">${i.qty}</span>
                <button class="qty-btn" onclick="changeQty(${idx},1)">+</button>
                <button class="qty-btn" style="border-color:rgba(192,57,43,.25);color:#c0392b;" onclick="removeFromCart(${idx})">×</button>
            </div>
            <div style="min-width:56px;text-align:right;font-weight:600;font-size:.82rem;">₱${(i.price*i.qty).toFixed(2)}</div>
        </div>
    `).join('');
    const sub = cart.reduce((s,i) => s + i.price * i.qty, 0);
    const tax = sub * 0.12;
    document.getElementById('cartSubtotal').textContent = '₱' + sub.toFixed(2);
    document.getElementById('cartTax').textContent      = '₱' + tax.toFixed(2);
    document.getElementById('cartTotal').textContent    = '₱' + (sub + tax).toFixed(2);
    totalsEl.style.display = 'block';
    calcChange();
}
function calcChange() {
    const total    = cart.reduce((s,i) => s + i.price * i.qty, 0) * 1.12;
    const tendered = parseFloat(document.getElementById('tendered').value) || 0;
    const change   = tendered - total;
    const errEl    = document.getElementById('tenderedError');
    if (errEl) errEl.style.display = (tendered > 0 && change < 0) ? 'block' : 'none';
    document.getElementById('changeAmt').textContent = '₱' + Math.max(0, change).toFixed(2);
}

// ── PLACE ORDER ────────────────────────────────────────
function placeOrder() {
    if (!cart.length) { alert('Please add at least one item.'); return; }

    const total    = cart.reduce((s,i) => s + i.price * i.qty, 0) * 1.12;
    const tendered = parseFloat(document.getElementById('tendered').value) || 0;
    const errEl    = document.getElementById('tenderedError');

    // Validate: tendered must be >= total
    if (!tendered || tendered < total) {
        errEl.style.display = 'block';
        document.getElementById('tendered').focus();
        return;
    }
    errEl.style.display = 'none';

    const payload = {
        customer_name:   '<?php echo e(auth()->user()->full_name); ?>',
        customer_email:  '<?php echo e(auth()->user()->email); ?>',
        payment_method:  'cash',
        amount_tendered: tendered,
        items: cart.map(i => ({
            product_id: i.id,
            size:       i.size || 'Tall (16oz)',
            quantity:   i.qty,
            addons:     i.addons || [],
        }))
    };

    fetch('/cashier/orders', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(payload)
    })
    .then(r => r.json())
    .then(res => {
        if (!res.success) { alert('Error: ' + res.message); return; }
        const t = res.transaction;
        const now = new Date();
        const timeStr = now.toLocaleString('en-PH', {
            timeZone: 'Asia/Manila',
            month: 'short', day: 'numeric', year: 'numeric',
            hour: 'numeric', minute: '2-digit', hour12: true
        });
        let mailNote = '';
        if (res.mail_sent) {
            mailNote = `<div style="font-size:.75rem;color:#3d5c35;margin-top:.75rem;text-align:center;background:rgba(122,140,110,.1);padding:.5rem;border-radius:8px;"><i class="bi bi-envelope-check"></i> Receipt emailed to <strong><?php echo e(auth()->user()->email); ?></strong></div>`;
        } else if (res.mail_error) {
            mailNote = `<div style="font-size:.73rem;color:#c0392b;margin-top:.75rem;text-align:center;background:rgba(192,57,43,.08);padding:.5rem;border-radius:8px;"><i class="bi bi-exclamation-triangle"></i> Email not sent: ${res.mail_error}</div>`;
        } else {
            mailNote = `<div style="font-size:.75rem;color:#888;margin-top:.75rem;text-align:center;"><i class="bi bi-file-earmark-pdf"></i> Use Receipt PDF to save your receipt.</div>`;
        }

        document.getElementById('receiptBody').innerHTML = `
            <div style="text-align:center;padding:.5rem 0 1rem;">
                <div style="font-size:2rem;margin-bottom:.5rem;">✅</div>
                <div style="font-family:var(--font-serif);font-size:1.2rem;color:var(--kafe-brown);">${t.order_number}</div>
                <div style="font-size:.82rem;color:#888;margin-top:4px;">Order placed! Thank you.</div>
            </div>
            <div style="background:var(--kafe-pearl);border-radius:10px;padding:1rem;font-size:.85rem;">
                <div style="display:flex;justify-content:space-between;padding:3px 0;"><span style="color:#888;">Payment</span><span style="text-transform:uppercase;font-weight:500;">${t.payment_method}</span></div>
                <div style="display:flex;justify-content:space-between;padding:3px 0;"><span style="color:#888;">Date & Time</span><span style="font-weight:500;">${timeStr}</span></div>
                <div style="display:flex;justify-content:space-between;padding:6px 0 0;border-top:1px dashed rgba(74,44,23,.2);margin-top:6px;font-weight:600;font-family:var(--font-serif);"><span>Total</span><span>₱${parseFloat(t.total).toFixed(2)}</span></div>
            </div>
            ${mailNote}
        `;
        document.getElementById('pdfLink').href = res.receipt_url;
        new bootstrap.Modal(document.getElementById('receiptModal')).show();
        cart = [];
        renderCart();
        // Reload page after modal close so order history updates
        document.getElementById('receiptModal').addEventListener('hidden.bs.modal', () => location.reload(), { once: true });
    })
    .catch(() => alert('An error occurred. Please try again.'));
}

// ── REVIEW HELPERS ─────────────────────────────────────
function setTxnId(sel) {
    const opt = sel.options[sel.selectedIndex];
    document.getElementById('txnId').value = opt.dataset.txn || '';
}
// Toggle review edit form
function toggleEditReview(id) {
    const el = document.getElementById('editReview_' + id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
// Star pickers for edit forms
document.querySelectorAll('.star-picker-edit').forEach(picker => {
    picker.querySelectorAll('span').forEach(star => {
        star.addEventListener('click', function() {
            const val = parseInt(this.dataset.val);
            const reviewId = picker.dataset.review;
            document.getElementById('editRating_' + reviewId).value = val;
            picker.querySelectorAll('span').forEach((s, i) => s.textContent = i < val ? '★' : '☆');
        });
    });
});

document.getElementById('starPicker')?.addEventListener('click', function(e) {
    if (!e.target.dataset.v) return;
    const val = parseInt(e.target.dataset.v);
    document.getElementById('ratingVal').value = val;
    this.querySelectorAll('span').forEach((s,i) => s.textContent = i < val ? '★' : '☆');
});


</script>
</body>
</html><?php /**PATH C:\Users\admin\kafe-lumiere\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>