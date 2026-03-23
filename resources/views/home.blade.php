{{-- resources/views/home.blade.php --}}
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

{{-- Navbar --}}
<nav>
    <a href="{{ route('home') }}" class="nav-brand">☕ Kafé Lumière</a>
    <div class="nav-links">
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            @endif
            <a href="{{ route('cashier.orders.index') }}">New Order</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button style="background:none;border:none;color:rgba(255,255,255,0.75);cursor:pointer;font-size:.85rem;" type="submit">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Staff Login</a>
            <a href="{{ route('register') }}" class="btn-nav">Register</a>
        @endauth
    </div>
</nav>

{{-- Hero + Search (MP8: no datatable search) --}}
<div class="hero">
    <div class="hero-title">Kafé Lumière</div>
    <div class="hero-sub">Premium milk teas brewed with love</div>
    <form action="{{ route('home.search') }}" method="GET" class="search-wrap">
        <input type="text" name="q" value="{{ $query ?? '' }}"
               placeholder="Search drinks, flavors, categories…" autocomplete="off">
        <button type="submit"><i class="bi bi-search"></i> Search</button>
    </form>
    @if(isset($query))
        <div style="margin-top:.75rem;font-size:.82rem;opacity:.7;">
            Results for: <strong>{{ $query }}</strong>
            <a href="{{ route('home') }}" style="color:var(--kafe-gold);margin-left:8px;">✕ Clear</a>
        </div>
    @endif
</div>

{{-- Filter bar (MP6: filter by category + price) --}}
<div class="filter-bar">
    <a href="{{ route('home') }}" class="chip {{ !request('category') ? 'active' : '' }}">All</a>
    @foreach($categories as $cat)
        <a href="{{ route('home', array_merge(request()->query(), ['category' => $cat->id])) }}"
           class="chip {{ request('category') == $cat->id ? 'active' : '' }}">{{ $cat->name }}</a>
    @endforeach
    <div class="price-filter">
        <label>Max Price:</label>
        <input type="range" id="priceRange" min="0" max="{{ $maxProductPrice }}" step="10"
               value="{{ request('max_price', $maxProductPrice) }}"
               oninput="document.getElementById('priceVal').textContent='₱'+this.value;filterByPrice(this.value)">
        <span id="priceVal">₱{{ request('max_price', $maxProductPrice) }}</span>
    </div>
</div>

{{-- Main content --}}
<div class="main-content">

    @if(isset($query) && $products->total() === 0)
        <div class="no-results">
            <i class="bi bi-search"></i>
            <div style="font-size:1.1rem;font-weight:500;margin-bottom:.5rem;">No results for "{{ $query }}"</div>
            <div style="font-size:.85rem;">Try a different search term or browse all products below.</div>
            <a href="{{ route('home') }}" style="display:inline-block;margin-top:1rem;color:var(--kafe-caramel);text-decoration:none;">← Browse all products</a>
        </div>
    @else
        <div class="section-title">
            {{ isset($query) ? 'Search Results' : 'Our Menu' }}
            <span style="font-size:.85rem;color:#888;font-family:var(--font-sans);font-style:normal;font-weight:400;margin-left:8px;">{{ $products->total() }} drinks</span>
        </div>

        <div class="row g-3" id="productGrid">
            @forelse($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="product-card">
                    <div class="product-img" id="img_{{ $product->id }}">
                        <span class="cat-tag">{{ $product->category->name }}</span>
                        @php
                            $allPhotos = $product->photos->pluck('path')->toArray();
                            if (empty($allPhotos) && $product->main_photo) $allPhotos = [$product->main_photo];
                            $mainPhoto = $product->main_photo ?? ($allPhotos[0] ?? null);
                        @endphp
                        @if($mainPhoto)
                            {{-- Store all photo URLs as JSON data attribute for JS navigation --}}
                            <img src="{{ asset('storage/'.$mainPhoto) }}"
                                 alt="{{ $product->name }}"
                                 id="mainImg_{{ $product->id }}"
                                 style="width:100%;height:100%;object-fit:cover;"
                                 data-photos='@json(array_map(fn($p) => asset("storage/".$p), $allPhotos))'
                                 data-current="0">
                            @if(count($allPhotos) > 1)
                                {{-- Prev button --}}
                                <button onclick="changePhoto(event, 'mainImg_{{ $product->id }}', -1)"
                                        style="position:absolute;left:6px;top:50%;transform:translateY(-50%);width:26px;height:26px;border-radius:50%;background:rgba(0,0,0,0.45);border:none;color:#fff;font-size:.85rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .15s;z-index:2;"
                                        onmouseover="this.style.background='rgba(74,44,23,0.85)'"
                                        onmouseout="this.style.background='rgba(0,0,0,0.45)'"
                                        title="Previous photo">&#8249;</button>
                                {{-- Next button --}}
                                <button onclick="changePhoto(event, 'mainImg_{{ $product->id }}', 1)"
                                        style="position:absolute;right:6px;top:50%;transform:translateY(-50%);width:26px;height:26px;border-radius:50%;background:rgba(0,0,0,0.45);border:none;color:#fff;font-size:.85rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .15s;z-index:2;"
                                        onmouseover="this.style.background='rgba(74,44,23,0.85)'"
                                        onmouseout="this.style.background='rgba(0,0,0,0.45)'"
                                        title="Next photo">&#8250;</button>
                                {{-- Photo counter --}}
                                <div style="position:absolute;bottom:6px;right:8px;background:rgba(0,0,0,0.45);color:#fff;border-radius:8px;padding:1px 7px;font-size:.62rem;">
                                    <span id="photoNum_{{ $product->id }}">1</span>/{{ count($allPhotos) }}
                                </div>
                            @endif
                        @else
                            ☕
                        @endif
                    </div>
                    <div class="product-body">
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-desc">{{ Str::limit($product->description, 60) }}</div>
                        <div class="product-footer">
                            <div>
                                <div class="product-price">₱{{ number_format($product->price_tall,2) }}</div>
                                @if($product->price_grande)
                                    <div style="font-size:.7rem;color:#888;">Grande: ₱{{ number_format($product->price_grande,2) }}</div>
                                @endif
                            </div>
                            @auth
                                <button class="btn-add" onclick="quickOrder({{ $product->id }})">
                                    <i class="bi bi-plus-lg"></i> Order
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn-add">Order</a>
                            @endauth
                        </div>
                        @if($product->avg_rating > 0)
                        <div style="margin-top:6px;font-size:.72rem;color:var(--kafe-gold);">
                            {{ str_repeat('★', round($product->avg_rating)) }}{{ str_repeat('☆', 5 - round($product->avg_rating)) }}
                            <span style="color:#888;">{{ $product->avg_rating }}/5</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="no-results">
                    <i class="bi bi-cup-hot"></i>
                    <div>No products available right now.</div>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Pagination (Scout + standard) --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @endif

    {{-- Review section (for logged-in verified users) --}}
    @auth
    @if(isset($userTransactions) && $userTransactions->count())
    <div class="review-section mt-4">
        <div class="section-title" style="font-size:1.2rem;">Leave a Review</div>
        <form action="{{ route('reviews.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-5">
                    <label style="font-size:.8rem;font-weight:500;color:var(--kafe-brown);display:block;margin-bottom:4px;">Product</label>
                    <select name="product_id" class="form-control" style="border-radius:9px;border:1.5px solid rgba(74,44,23,.18);" required>
                        <option value="">-- Select a product you purchased --</option>
                        @foreach($userTransactions as $t)
                            @foreach($t->orderItems as $item)
                                <option value="{{ $item->product_id }}" data-txn="{{ $t->id }}">{{ $item->product_name }}</option>
                            @endforeach
                        @endforeach
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
    @endif
    @endauth

</div>

<footer>
    <span class="brand">Kafé Lumière</span>
    123 Brew Street, Manila · (02) 8888-1234 · kafelumiere@email.com<br>
    &copy; {{ date('Y') }} Kafé Lumière Management System. All rights reserved.
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
    window.location = '{{ route("cashier.orders.index") }}';
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
</html>