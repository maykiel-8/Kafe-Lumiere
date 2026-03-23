{{-- resources/views/cashier/orders.blade.php --}}
@extends('layouts.admin')
@section('title','New Order')
@section('page-title','New Order')

@push('styles')
<style>
.product-tile{background:#fff;border:1.5px solid rgba(74,44,23,.1);border-radius:12px;overflow:hidden;cursor:pointer;transition:all .18s;position:relative;}
.product-tile:hover{border-color:var(--kafe-caramel);box-shadow:0 4px 18px rgba(74,44,23,.1);transform:translateY(-2px);}
.product-img{height:110px;background:var(--kafe-pearl);display:flex;align-items:center;justify-content:center;font-size:2.5rem;overflow:hidden;}
.product-img img{width:100%;height:100%;object-fit:cover;}
.product-body{padding:.75rem;}
.product-tile .p-name{font-size:.82rem;font-weight:500;color:var(--kafe-brown);margin-bottom:2px;}
.product-tile .p-price{font-family:var(--font-serif);font-size:.95rem;color:var(--kafe-caramel);font-weight:600;}
.product-tile .add-badge{position:absolute;top:6px;right:6px;background:var(--kafe-brown);color:#fff;border-radius:50%;width:20px;height:20px;font-size:.65rem;display:flex;align-items:center;justify-content:center;font-weight:700;}
.order-panel{background:#fff;border:1px solid rgba(74,44,23,.1);border-radius:14px;padding:1.5rem;position:sticky;top:76px;max-height:calc(100vh - 100px);overflow-y:auto;}
.cart-item{display:flex;align-items:flex-start;gap:8px;padding:8px 0;border-bottom:1px solid rgba(74,44,23,.07);font-size:.82rem;}
.qty-btn{width:26px;height:26px;border-radius:6px;border:1px solid rgba(74,44,23,.15);background:#fff;cursor:pointer;font-size:.85rem;display:flex;align-items:center;justify-content:center;transition:all .15s;flex-shrink:0;}
.qty-btn:hover{background:var(--kafe-brown);color:#fff;}
.filter-chip{padding:4px 14px;border-radius:20px;font-size:.78rem;cursor:pointer;border:1.5px solid rgba(74,44,23,.15);background:#fff;color:var(--kafe-brown);transition:all .15s;white-space:nowrap;}
.filter-chip.active,.filter-chip:hover{background:var(--kafe-brown);color:#fff;border-color:var(--kafe-brown);}
/* Addon modal */
.addon-check{display:flex;align-items:center;justify-content:space-between;padding:8px 12px;border:1.5px solid rgba(74,44,23,.12);border-radius:8px;cursor:pointer;transition:all .15s;margin-bottom:6px;}
.addon-check:hover,.addon-check.selected{border-color:var(--kafe-caramel);background:rgba(200,135,74,.06);}
.addon-check input{margin-right:8px;}
</style>
@endpush

@section('content')
<div class="row g-4">

    {{-- Left: Product Grid --}}
    <div class="col-lg-8">
        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:1rem;align-items:center;">
            <button class="filter-chip active" data-cat="">All</button>
            @foreach($categories as $cat)
                <button class="filter-chip" data-cat="{{ $cat->id }}">{{ $cat->name }}</button>
            @endforeach
            <input class="form-control-kafe" id="prodSearch" placeholder="Search drinks…"
                   style="width:180px;margin-left:auto;" oninput="loadProducts()">
        </div>
        <div class="row g-2" id="productGrid">
            <div style="padding:2rem;text-align:center;color:#888;width:100%;">Loading products…</div>
        </div>
    </div>

    {{-- Right: Order Panel --}}
    <div class="col-lg-4">
        <div class="order-panel">
            <div style="font-family:var(--font-serif);font-size:1.1rem;color:var(--kafe-brown);margin-bottom:1rem;">
                Current Order
            </div>
            <div class="mb-2">
                <label class="form-label-kafe">Customer Name</label>
                <input class="form-control-kafe" id="customerName" placeholder="Walk-in customer">
            </div>
            <div class="mb-3">
                <label class="form-label-kafe">Customer Email <span style="color:#aaa;font-weight:400;">(for receipt)</span></label>
                <input class="form-control-kafe" id="customerEmail" type="email" placeholder="optional@email.com">
            </div>

            <div id="cartContainer">
                <div style="text-align:center;padding:1.5rem;color:#aaa;font-size:.82rem;">
                    <i class="bi bi-basket2" style="font-size:1.5rem;display:block;margin-bottom:6px;"></i>
                    No items added yet
                </div>
            </div>

            <div id="cartTotals" style="display:none;border-top:1px solid rgba(74,44,23,.12);padding-top:.8rem;margin-top:.5rem;">
                <div style="display:flex;justify-content:space-between;font-size:.82rem;padding:3px 0;color:#888;"><span>Subtotal</span><span id="subtotalAmt">₱0.00</span></div>
                <div style="display:flex;justify-content:space-between;font-size:.82rem;padding:3px 0;color:#888;"><span>VAT (12%)</span><span id="taxAmt">₱0.00</span></div>
                <div style="display:flex;justify-content:space-between;border-top:2px solid var(--kafe-brown);margin-top:8px;padding-top:8px;font-weight:600;font-family:var(--font-serif);font-size:1rem;">
                    <span>Total</span><span id="totalAmt" style="color:var(--kafe-brown);">₱0.00</span>
                </div>
            </div>

            <div id="paymentSection" style="display:none;margin-top:.85rem;">
                <input type="hidden" id="paymentMethod" value="cash">
                <div class="mb-2">
                    <label class="form-label-kafe">Payment — Cash</label>
                    <div style="background:var(--kafe-pearl);border-radius:8px;padding:.6rem .9rem;font-size:.82rem;color:var(--kafe-brown);font-weight:500;">
                        <i class="bi bi-cash-coin"></i> Cash payment only
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label-kafe">Amount Tendered (₱) *</label>
                    <input class="form-control-kafe" id="tendered" type="number" step="0.01" min="0" placeholder="₱0.00" oninput="calcChange()">
                    <div id="tenderedError" style="font-size:.73rem;color:#c0392b;margin-top:3px;display:none;">
                        <i class="bi bi-exclamation-circle"></i> Amount tendered is less than the total.
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:.78rem;margin-top:4px;color:#888;">
                        <span>Change</span><span id="changeAmt" style="color:var(--kafe-sage);font-weight:500;">₱0.00</span>
                    </div>
                </div>
                <button class="btn-kafe" style="width:100%;justify-content:center;padding:.75rem;font-size:.95rem;" onclick="placeOrder()">
                    <i class="bi bi-check2-circle"></i> Place Order
                </button>
                <button class="btn-kafe-outline" style="width:100%;justify-content:center;margin-top:.5rem;" onclick="clearCart()">
                    <i class="bi bi-x-circle"></i> Clear
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Add-on Modal --}}
<div class="modal fade" id="addonModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-kafe">
        <div class="modal-content modal-kafe">
            <div class="modal-header">
                <h5 class="modal-title" id="addonModalTitle">Select Add-ons</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:1.5rem;">
                <div style="font-size:.82rem;color:#888;margin-bottom:.75rem;" id="addonProductName"></div>

                {{-- Size selection --}}
                <div style="margin-bottom:1rem;">
                    <label class="form-label-kafe">Size</label>
                    <div style="display:flex;gap:8px;">
                        <label id="sizeTallLabel" style="flex:1;padding:.6rem;border:1.5px solid rgba(74,44,23,.15);border-radius:8px;cursor:pointer;text-align:center;font-size:.85rem;transition:all .15s;">
                            <input type="radio" name="sizeChoice" value="Tall (16oz)" checked style="display:none;">
                            <span>Tall (16oz)</span><br>
                            <span id="priceTall" style="font-family:var(--font-serif);color:var(--kafe-caramel);font-size:.9rem;"></span>
                        </label>
                        <label id="sizeGrandeLabel" style="flex:1;padding:.6rem;border:1.5px solid rgba(74,44,23,.15);border-radius:8px;cursor:pointer;text-align:center;font-size:.85rem;transition:all .15s;" id="grandeLabelWrap">
                            <input type="radio" name="sizeChoice" value="Grande (22oz)" style="display:none;">
                            <span>Grande (22oz)</span><br>
                            <span id="priceGrande" style="font-family:var(--font-serif);color:var(--kafe-caramel);font-size:.9rem;"></span>
                        </label>
                    </div>
                </div>

                {{-- Add-ons list --}}
                <div id="addonList">
                    <label class="form-label-kafe">Add-ons <span style="font-weight:400;color:#aaa;">(optional)</span></label>
                    <div id="addonOptions"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-kafe-outline" data-bs-dismiss="modal">Cancel</button>
                <button class="btn-kafe" onclick="confirmAddToCart()"><i class="bi bi-plus-lg"></i> Add to Order</button>
            </div>
        </div>
    </div>
</div>

{{-- Receipt Modal --}}
<div class="modal fade" id="receiptModal" tabindex="-1">
    <div class="modal-dialog modal-kafe">
        <div class="modal-content modal-kafe">
            <div class="modal-header"><h5 class="modal-title">Order Placed!</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body" id="receiptBody" style="padding:1.5rem;"></div>
            <div class="modal-footer">
                <button class="btn-kafe-outline" data-bs-dismiss="modal">Close</button>
                <a id="pdfLink" href="#" class="btn-kafe" target="_blank"><i class="bi bi-file-earmark-pdf"></i> Download Receipt</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let cart = [];
let currentCatId = '';
let pendingProduct = null; // product being configured in addon modal

// ── Load & render products ─────────────────────────────
function loadProducts() {
    const search = document.getElementById('prodSearch').value;
    fetch(`/cashier/orders/products?category_id=${currentCatId}&search=${encodeURIComponent(search)}`)
        .then(r => r.json())
        .then(products => renderGrid(products));
}

function renderGrid(products) {
    const grid = document.getElementById('productGrid');
    if (!products.length) {
        grid.innerHTML = '<div style="padding:2rem;text-align:center;color:#aaa;width:100%;"><i class="bi bi-search" style="font-size:1.5rem;display:block;margin-bottom:6px;"></i>No products found.</div>';
        return;
    }
    grid.innerHTML = products.map(p => {
        const inCart = cart.find(i => i.product_id === p.id);
        const imgHtml = p.photo_url
            ? `<img src="${p.photo_url}" alt="${p.name}" style="width:100%;height:100%;object-fit:cover;">`
            : '☕';
        const addonText = p.addons.length ? `<div style="font-size:.68rem;color:#888;margin-top:2px;">${p.addons.map(a=>a.name).join(', ')}</div>` : '';
        return `
        <div class="col-6 col-md-4">
            <div class="product-tile" onclick="openAddonModal(${JSON.stringify(p).replace(/"/g,'&quot;')})">
                ${inCart ? `<div class="add-badge">${inCart.quantity}</div>` : ''}
                <div class="product-img">${imgHtml}</div>
                <div class="product-body">
                    <div class="p-name">${p.name}</div>
                    <div class="p-price">₱${parseFloat(p.price_tall).toFixed(2)}</div>
                    ${addonText}
                </div>
            </div>
        </div>`;
    }).join('');
}

// ── Category filter ────────────────────────────────────
document.querySelectorAll('.filter-chip').forEach(chip => {
    chip.addEventListener('click', () => {
        document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
        chip.classList.add('active');
        currentCatId = chip.dataset.cat;
        loadProducts();
    });
});

// ── Add-on modal ───────────────────────────────────────
function openAddonModal(product) {
    pendingProduct = product;
    document.getElementById('addonModalTitle').textContent = product.name;
    document.getElementById('addonProductName').textContent = product.name;

    // Size labels
    document.getElementById('priceTall').textContent = '₱' + parseFloat(product.price_tall).toFixed(2);
    const grandeLbl = document.getElementById('sizeGrandeLabel');
    if (product.price_grande) {
        document.getElementById('priceGrande').textContent = '₱' + parseFloat(product.price_grande).toFixed(2);
        grandeLbl.style.opacity = '1';
        grandeLbl.style.pointerEvents = 'auto';
    } else {
        document.getElementById('priceGrande').textContent = 'N/A';
        grandeLbl.style.opacity = '.4';
        grandeLbl.style.pointerEvents = 'none';
    }

    // Reset size to Tall
    document.querySelector('input[name="sizeChoice"][value="Tall (16oz)"]').checked = true;
    highlightSize();

    // Build add-ons list
    const optionsDiv = document.getElementById('addonOptions');
    if (!product.addons.length) {
        optionsDiv.innerHTML = '<div style="font-size:.82rem;color:#aaa;padding:.5rem 0;">No add-ons available for this product.</div>';
    } else {
        optionsDiv.innerHTML = product.addons.map(a => `
            <label class="addon-check" id="addonLabel_${a.id}" onclick="toggleAddon(this)">
                <div style="display:flex;align-items:center;gap:8px;">
                    <input type="checkbox" value="${a.id}" data-name="${a.name}" data-price="${a.price}" style="display:none;">
                    <i class="bi bi-circle" id="addonIcon_${a.id}" style="color:#ccc;font-size:1rem;flex-shrink:0;"></i>
                    <span style="font-size:.85rem;">${a.name}</span>
                </div>
                <span style="font-size:.78rem;color:var(--kafe-caramel);font-weight:500;">+₱${parseFloat(a.price).toFixed(2)}</span>
            </label>
        `).join('');
    }

    new bootstrap.Modal(document.getElementById('addonModal')).show();
}

function toggleAddon(label) {
    const cb = label.querySelector('input[type="checkbox"]');
    cb.checked = !cb.checked;
    label.classList.toggle('selected', cb.checked);
    const icon = label.querySelector('i');
    icon.className = cb.checked ? 'bi bi-check-circle-fill' : 'bi bi-circle';
    icon.style.color = cb.checked ? 'var(--kafe-caramel)' : '#ccc';
}

// Highlight selected size label
function highlightSize() {
    document.querySelectorAll('[name="sizeChoice"]').forEach(radio => {
        const lbl = radio.closest('label');
        lbl.style.borderColor = radio.checked ? 'var(--kafe-caramel)' : 'rgba(74,44,23,.15)';
        lbl.style.background  = radio.checked ? 'rgba(200,135,74,.06)' : '';
    });
}
document.querySelectorAll('input[name="sizeChoice"]').forEach(r => r.addEventListener('change', highlightSize));

function confirmAddToCart() {
    if (!pendingProduct) return;
    const size     = document.querySelector('input[name="sizeChoice"]:checked').value;
    const price    = size === 'Grande (22oz)' && pendingProduct.price_grande
        ? parseFloat(pendingProduct.price_grande)
        : parseFloat(pendingProduct.price_tall);
    const addons   = [...document.querySelectorAll('#addonOptions input[type="checkbox"]:checked')]
        .map(cb => cb.dataset.name);

    // If same product+size already in cart, increment qty
    const existing = cart.find(i => i.product_id === pendingProduct.id && i.size === size);
    if (existing) {
        existing.quantity++;
    } else {
        cart.push({
            product_id: pendingProduct.id,
            name:       pendingProduct.name,
            price,
            size,
            addons,
            quantity:   1,
        });
    }

    bootstrap.Modal.getInstance(document.getElementById('addonModal')).hide();
    renderCart();
    loadProducts();
}

// ── Cart ───────────────────────────────────────────────
function removeFromCart(idx) {
    cart.splice(idx, 1);
    renderCart();
    loadProducts();
}
function changeQty(idx, delta) {
    cart[idx].quantity = Math.max(1, cart[idx].quantity + delta);
    renderCart();
    loadProducts();
}
function clearCart() {
    cart = [];
    renderCart();
    loadProducts();
}

function renderCart() {
    const container = document.getElementById('cartContainer');
    const totalsEl  = document.getElementById('cartTotals');
    const payEl     = document.getElementById('paymentSection');

    if (!cart.length) {
        container.innerHTML = '<div style="text-align:center;padding:1.5rem;color:#aaa;font-size:.82rem;"><i class="bi bi-basket2" style="font-size:1.5rem;display:block;margin-bottom:6px;"></i>No items added yet</div>';
        totalsEl.style.display = 'none';
        payEl.style.display    = 'none';
        return;
    }

    container.innerHTML = cart.map((item, idx) => `
        <div class="cart-item">
            <div style="flex:1;min-width:0;">
                <div style="font-weight:500;">${item.name}</div>
                <div style="font-size:.72rem;color:#888;">${item.size}${item.addons.length ? ' · ' + item.addons.join(', ') : ''}</div>
                <div style="font-size:.75rem;color:#888;">₱${item.price.toFixed(2)} each</div>
            </div>
            <div style="display:flex;align-items:center;gap:4px;flex-shrink:0;">
                <button class="qty-btn" onclick="changeQty(${idx},-1)">−</button>
                <span style="font-weight:600;min-width:18px;text-align:center;">${item.quantity}</span>
                <button class="qty-btn" onclick="changeQty(${idx},1)">+</button>
                <button class="qty-btn" style="border-color:rgba(192,57,43,.25);color:#c0392b;" onclick="removeFromCart(${idx})">×</button>
            </div>
            <div style="min-width:60px;text-align:right;font-weight:600;font-size:.82rem;flex-shrink:0;">₱${(item.price*item.quantity).toFixed(2)}</div>
        </div>
    `).join('');

    const sub = cart.reduce((s,i) => s + i.price * i.quantity, 0);
    const tax = sub * 0.12;
    document.getElementById('subtotalAmt').textContent = '₱' + sub.toFixed(2);
    document.getElementById('taxAmt').textContent      = '₱' + tax.toFixed(2);
    document.getElementById('totalAmt').textContent    = '₱' + (sub + tax).toFixed(2);
    totalsEl.style.display = 'block';
    payEl.style.display    = 'block';
    calcChange();
}

function calcChange() {
    const total    = cart.reduce((s,i) => s + i.price * i.quantity, 0) * 1.12;
    const tendered = parseFloat(document.getElementById('tendered').value) || 0;
    const errEl    = document.getElementById('tenderedError');
    if (errEl) errEl.style.display = (tendered > 0 && tendered < total) ? 'block' : 'none';
    document.getElementById('changeAmt').textContent = '₱' + Math.max(0, tendered - total).toFixed(2);
}



// ── Place order ────────────────────────────────────────
function placeOrder() {
    if (!cart.length) { alert('Please add at least one item.'); return; }

    const total    = cart.reduce((s,i) => s + i.price * i.quantity, 0) * 1.12;
    const tendered = parseFloat(document.getElementById('tendered').value) || 0;
    const errEl    = document.getElementById('tenderedError');

    if (!tendered || tendered < total) {
        errEl.style.display = 'block';
        document.getElementById('tendered').focus();
        return;
    }
    errEl.style.display = 'none';

    const payload = {
        customer_name:   document.getElementById('customerName').value || 'Walk-in',
        customer_email:  document.getElementById('customerEmail').value || null,
        payment_method:  'cash',
        amount_tendered: tendered,
        items: cart.map(i => ({
            product_id: i.product_id,
            size:       i.size,
            quantity:   i.quantity,
            addons:     i.addons,
        }))
    };

    fetch('/cashier/orders', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: JSON.stringify(payload)
    })
    .then(r => r.json())
    .then(res => {
        if (!res.success) { alert('Error: ' + res.message); return; }
        const t = res.transaction;
        const emailNote = res.mail_sent
            ? `<div style="margin-top:.75rem;font-size:.75rem;color:#3d5c35;text-align:center;"><i class="bi bi-envelope-check"></i> Receipt emailed to ${t.customer_email}</div>`
            : (t.customer_email
                ? `<div style="margin-top:.75rem;font-size:.75rem;color:#c0392b;text-align:center;"><i class="bi bi-exclamation-circle"></i> Email failed: ${res.mail_error || 'Check mail config'}</div>`
                : `<div style="margin-top:.75rem;font-size:.75rem;color:#888;text-align:center;"><i class="bi bi-info-circle"></i> No customer email — enter email above to send receipt</div>`
              );

        document.getElementById('receiptBody').innerHTML = `
            <div style="text-align:center;padding:.5rem 0 1rem;">
                <div style="font-size:2rem;margin-bottom:.5rem;">✅</div>
                <div style="font-family:var(--font-serif);font-size:1.2rem;color:var(--kafe-brown);">${t.order_number}</div>
                <div style="font-size:.82rem;color:#888;margin-top:4px;">Order placed successfully!</div>
            </div>
            <div style="background:var(--kafe-pearl);border-radius:10px;padding:1rem;font-size:.85rem;">
                <div style="display:flex;justify-content:space-between;padding:3px 0;"><span style="color:#888;">Customer</span><span>${t.customer_name}</span></div>
                <div style="display:flex;justify-content:space-between;padding:3px 0;"><span style="color:#888;">Payment</span><span style="text-transform:uppercase;font-weight:500;">${t.payment_method}</span></div>
                <div style="display:flex;justify-content:space-between;padding:6px 0 0;border-top:1px dashed rgba(74,44,23,.2);margin-top:6px;font-weight:600;font-family:var(--font-serif);"><span>Total</span><span>₱${parseFloat(t.total).toFixed(2)}</span></div>
            </div>
            ${emailNote}
        `;
        document.getElementById('pdfLink').href = res.receipt_url;
        new bootstrap.Modal(document.getElementById('receiptModal')).show();
        cart = [];
        renderCart();
        document.getElementById('customerName').value  = '';
        document.getElementById('customerEmail').value = '';
        document.getElementById('tendered').value      = '';
    })
    .catch(() => alert('An error occurred. Please try again.'));
}

// Init
loadProducts();
</script>
@endpush