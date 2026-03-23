{{-- resources/views/admin/transactions/index.blade.php --}}
@extends('layouts.admin')
@section('title','Transactions')
@section('page-title','Transactions')

@section('content')
<div class="section-header">
    <div>
        <div class="section-title">Transactions</div>
        <div style="font-size:.8rem;color:#888;">Order history — update status, view and email receipts</div>
    </div>
    <div class="d-flex gap-2 align-items-center">
        {{-- Date filter --}}
        <form method="GET" class="d-flex gap-2 align-items-center">
            <input type="date" name="from" class="form-control-kafe" style="width:140px;" value="{{ request('from') }}">
            <span style="font-size:.8rem;color:#888;">to</span>
            <input type="date" name="to"   class="form-control-kafe" style="width:140px;" value="{{ request('to') }}">
            <select name="status" class="form-control-kafe" style="width:130px;">
                <option value="">All Statuses</option>
                <option value="pending"   {{ request('status')==='pending'   ?'selected':'' }}>Pending</option>
                <option value="completed" {{ request('status')==='completed' ?'selected':'' }}>Completed</option>
                <option value="cancelled" {{ request('status')==='cancelled' ?'selected':'' }}>Cancelled</option>
            </select>
            <button class="btn-kafe"><i class="bi bi-funnel"></i> Filter</button>
        </form>
        <a href="{{ route('admin.reports.export', request()->only('from','to')) }}" class="btn-kafe-outline">
            <i class="bi bi-file-earmark-excel"></i> Export
        </a>
    </div>
</div>

<div class="kafe-card">
    <div class="kafe-card-body" style="padding:0;">
        <table class="table table-kafe mb-0" id="transTable">
            <thead>
                <tr><th>Order #</th><th>Customer</th><th>Items</th><th>Total</th><th>Payment</th><th>Status</th><th>Cashier</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @foreach($transactions as $t)
            <tr>
                <td><strong style="font-family:var(--font-serif);">{{ $t->order_number }}</strong></td>
                <td>
                    {{ $t->customer_name }}
                    @if($t->customer_email)
                        <div style="font-size:.72rem;color:#888;">{{ $t->customer_email }}</div>
                    @endif
                </td>
                <td style="font-size:.82rem;">{{ $t->orderItems->count() }} item(s)</td>
                <td><strong>₱{{ number_format($t->total, 2) }}</strong></td>
                <td><span style="font-size:.78rem;text-transform:uppercase;font-weight:500;">{{ $t->payment_method }}</span></td>
                <td>
                    <select class="form-control-kafe" style="width:125px;padding:4px 8px;font-size:.78rem;"
                            onchange="updateStatus({{ $t->id }}, this.value)">
                        <option value="pending"   {{ $t->status==='pending'   ?'selected':'' }}>Pending</option>
                        <option value="completed" {{ $t->status==='completed' ?'selected':'' }}>Completed</option>
                        <option value="cancelled" {{ $t->status==='cancelled' ?'selected':'' }}>Cancelled</option>
                    </select>
                </td>
                <td style="font-size:.82rem;">{{ $t->cashier->full_name ?? '—' }}</td>
                <td style="font-size:.8rem;">{{ $t->created_at->timezone('Asia/Manila')->format('M d, Y H:i') }}</td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('admin.transactions.receipt', $t) }}" class="btn-icon" title="View Receipt" target="_blank"><i class="bi bi-receipt"></i></a>
                        <a href="{{ route('admin.transactions.pdf', $t) }}" class="btn-icon" title="Download PDF"><i class="bi bi-file-earmark-pdf"></i></a>
                        <button class="btn-icon" title="Email Receipt"
                                onclick="emailReceipt({{ $t->id }}, '{{ $t->customer_email }}')">
                            <i class="bi bi-envelope"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $transactions->links() }}</div>
@endsection

@push('scripts')
<script>
$('#transTable').DataTable({ pageLength:15, searching:true, ordering:true, columnDefs:[{orderable:false,targets:[2,5,8]}] });

function updateStatus(id, status) {
    $.ajax({
        url: `/admin/transactions/${id}/status`,
        method: 'PATCH',
        data: { status },
        success(res) {
            showToast(res.success ? 'Status updated! Email sent if customer address exists.' : 'Update failed.');
        }
    });
}

function emailReceipt(id, email) {
    if (!email) { showToast('No customer email on this order.'); return; }
    if (!confirm('Send receipt email to ' + email + '?')) return;
    $.ajax({
        url: `/admin/transactions/${id}/status`,
        method: 'PATCH',
        data: { status: 'completed' },
        success() { showToast('Receipt emailed to ' + email); }
    });
}

function showToast(msg) {
    const t = document.createElement('div');
    t.style.cssText = 'position:fixed;bottom:24px;right:24px;background:var(--kafe-brown);color:#fff;padding:12px 20px;border-radius:10px;font-size:.85rem;z-index:9999;';
    t.textContent = '✓ ' + msg;
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 3000);
}
</script>
@endpush