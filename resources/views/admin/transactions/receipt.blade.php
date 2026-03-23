{{-- resources/views/admin/transactions/receipt.blade.php --}}
@extends('layouts.admin')
@section('title', 'Receipt '.$transaction->order_number)
@section('page-title', 'Order Receipt')

@section('content')
<div class="row justify-content-center">
<div class="col-md-6 col-lg-5">

<div style="background:#fff;border-radius:16px;border:1px solid rgba(74,44,23,0.1);padding:2rem;font-family:var(--font-sans);">

    {{-- Header --}}
    <div style="text-align:center;border-bottom:2px dashed rgba(74,44,23,0.18);padding-bottom:1.2rem;margin-bottom:1.2rem;">
        <div style="font-family:var(--font-serif);font-size:1.6rem;font-style:italic;color:var(--kafe-brown);">☕ Kafé Lumière</div>
        <div style="font-size:.75rem;color:#888;margin-top:4px;">123 Brew Street, Manila · (02) 8888-1234</div>
        <div style="font-size:.75rem;color:#888;">kafelumiere@email.com</div>
        <div style="margin-top:.75rem;font-size:.8rem;">
            Order: <strong style="font-family:var(--font-serif);">{{ $transaction->order_number }}</strong>
            · {{ $transaction->created_at->format('M d, Y H:i') }}
        </div>
        <div style="font-size:.78rem;color:#888;margin-top:4px;">
            Cashier: {{ $transaction->cashier->full_name ?? '—' }}
        </div>
    </div>

    {{-- Customer --}}
    <div style="display:flex;justify-content:space-between;font-size:.85rem;padding:4px 0;">
        <span style="color:#888;">Customer</span>
        <span>{{ $transaction->customer_name }}</span>
    </div>
    <div style="display:flex;justify-content:space-between;font-size:.85rem;padding:4px 0;">
        <span style="color:#888;">Payment</span>
        <span style="text-transform:uppercase;font-weight:500;">{{ $transaction->payment_method }}</span>
    </div>

    {{-- Items --}}
    <div style="border-top:1px dashed rgba(74,44,23,0.18);margin:1rem 0 .5rem;"></div>
    @foreach($transaction->orderItems as $item)
    <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:6px 0;font-size:.85rem;">
        <div>
            <div style="font-weight:500;">{{ $item->product_name }}</div>
            <div style="font-size:.72rem;color:#888;">{{ $item->size }}
                @if($item->addons->count())
                    · {{ $item->addons->pluck('addon_name')->join(', ') }}
                @endif
            </div>
        </div>
        <div style="text-align:right;">
            <div>₱{{ number_format($item->unit_price,2) }} × {{ $item->quantity }}</div>
            <div style="font-weight:600;">₱{{ number_format($item->subtotal,2) }}</div>
        </div>
    </div>
    @endforeach

    {{-- Totals --}}
    <div style="border-top:1px dashed rgba(74,44,23,0.18);margin:1rem 0 .5rem;"></div>
    <div style="display:flex;justify-content:space-between;font-size:.82rem;padding:3px 0;color:#888;">
        <span>Subtotal</span><span>₱{{ number_format($transaction->subtotal,2) }}</span>
    </div>
    <div style="display:flex;justify-content:space-between;font-size:.82rem;padding:3px 0;color:#888;">
        <span>VAT (12%)</span><span>₱{{ number_format($transaction->tax,2) }}</span>
    </div>
    @if($transaction->amount_tendered)
    <div style="display:flex;justify-content:space-between;font-size:.82rem;padding:3px 0;color:#888;">
        <span>Tendered</span><span>₱{{ number_format($transaction->amount_tendered,2) }}</span>
    </div>
    <div style="display:flex;justify-content:space-between;font-size:.82rem;padding:3px 0;color:#888;">
        <span>Change</span><span>₱{{ number_format($transaction->change,2) }}</span>
    </div>
    @endif
    <div style="border-top:2px solid var(--kafe-brown);margin-top:8px;padding-top:10px;display:flex;justify-content:space-between;">
        <span style="font-family:var(--font-serif);font-size:1rem;font-weight:600;">TOTAL</span>
        <span style="font-family:var(--font-serif);font-size:1.2rem;color:var(--kafe-brown);font-weight:600;">₱{{ number_format($transaction->total,2) }}</span>
    </div>

    {{-- Footer --}}
    <div style="text-align:center;margin-top:1.5rem;font-size:.75rem;color:#aaa;border-top:1px dashed rgba(74,44,23,0.15);padding-top:1rem;">
        Thank you for visiting Kafé Lumière! ★ ★ ★<br>
        <span style="color:var(--kafe-sage);">Please come again</span>
    </div>
</div>

<div class="d-flex gap-2 mt-3 justify-content-center">
    <a href="{{ route('admin.transactions.pdf', $transaction) }}" class="btn-kafe">
        <i class="bi bi-file-earmark-pdf"></i> Download PDF
    </a>
    <a href="{{ route('admin.transactions.index') }}" class="btn-kafe-outline">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

</div>
</div>
@endsection