{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')
 
@section('content')
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card d-flex justify-content-between align-items-start">
            <div>
                <div class="stat-label">Today's Sales</div>
                <div class="stat-value">₱{{ number_format($todaySales, 2) }}</div>
                <div class="stat-change" style="color:var(--kafe-sage);">{{ $todayOrders }} orders today</div>
            </div>
            <div class="stat-icon" style="background:rgba(200,135,74,0.12);color:var(--kafe-caramel);"><i class="bi bi-currency-exchange"></i></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card d-flex justify-content-between align-items-start">
            <div>
                <div class="stat-label">Monthly Revenue</div>
                <div class="stat-value">₱{{ number_format($monthRevenue, 2) }}</div>
                <div class="stat-change" style="color:#888;">{{ now()->format('F Y') }}</div>
            </div>
            <div class="stat-icon" style="background:rgba(212,168,83,0.15);color:var(--kafe-gold);"><i class="bi bi-graph-up"></i></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card d-flex justify-content-between align-items-start">
            <div>
                <div class="stat-label">Active Products</div>
                <div class="stat-value">{{ $activeProducts }}</div>
                <div class="stat-change" style="color:#888;">in catalog</div>
            </div>
            <div class="stat-icon" style="background:rgba(74,44,23,0.1);color:var(--kafe-brown);"><i class="bi bi-cup-hot"></i></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card d-flex justify-content-between align-items-start">
            <div>
                <div class="stat-label">Pending Orders</div>
                <div class="stat-value">{{ $pendingOrders }}</div>
                <div class="stat-change" style="color:{{ $pendingOrders > 0 ? '#a07020' : '#888' }};">
                    {{ $pendingOrders > 0 ? 'Needs attention' : 'All clear' }}
                </div>
            </div>
            <div class="stat-icon" style="background:rgba(192,57,43,0.08);color:#c0392b;"><i class="bi bi-clock"></i></div>
        </div>
    </div>
</div>
 
<div class="row g-3">
    <div class="col-lg-8">
        <div class="kafe-card">
            <div class="kafe-card-header">
                <span style="font-weight:500;">Monthly Sales — {{ now()->year }}</span>
                <a href="{{ route('admin.reports.index') }}" class="btn-kafe-outline" style="font-size:.78rem;padding:4px 12px;">Full Report</a>
            </div>
            <div class="kafe-card-body">
                <canvas id="salesChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="kafe-card h-100">
            <div class="kafe-card-header"><span style="font-weight:500;">Top Products</span></div>
            <div class="kafe-card-body" style="padding:1rem;">
                @foreach($topProducts as $p)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid rgba(74,44,23,0.07);">
                    <div style="font-size:.85rem;font-weight:500;">{{ $p->product_name }}</div>
                    <div style="font-size:.82rem;color:var(--kafe-caramel);font-weight:500;">₱{{ number_format($p->revenue, 0) }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="kafe-card">
            <div class="kafe-card-header">
                <span style="font-weight:500;">Recent Transactions</span>
                <a href="{{ route('admin.transactions.index') }}" class="btn-kafe-outline" style="font-size:.78rem;padding:4px 12px;">View All</a>
            </div>
            <div class="kafe-card-body" style="padding:0;">
                <table class="table table-kafe mb-0">
                    <thead><tr><th>Order #</th><th>Customer</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th></tr></thead>
                    <tbody>
                    @foreach($recentTransactions as $t)
                    <tr>
                        <td><strong style="font-family:var(--font-serif);">{{ $t->order_number }}</strong></td>
                        <td>{{ $t->customer_name }}</td>
                        <td><strong>₱{{ number_format($t->total, 2) }}</strong></td>
                        <td style="text-transform:uppercase;font-size:.78rem;">{{ $t->payment_method }}</td>
                        <td><span class="badge-kafe badge-{{ $t->status }}">{{ ucfirst($t->status) }}</span></td>
                        <td style="font-size:.8rem;">{{ $t->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
 
@push('scripts')
<script>
fetch('{{ route("admin.reports.sales-data") }}')
    .then(r => r.json())
    .then(data => {
        const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        const revenues = Array(12).fill(0);
        data.salesByMonth.forEach(row => { revenues[row.month - 1] = row.revenue; });
        new Chart(document.getElementById('salesChart'), {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Revenue (₱)',
                    data: revenues,
                    backgroundColor: 'rgba(200,135,74,0.75)',
                    borderColor: '#C8874A',
                    borderWidth: 1.5,
                    borderRadius: 5,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { ticks: { callback: v => '₱' + v.toLocaleString() } } }
            }
        });
    });
</script>
@endpush
 
