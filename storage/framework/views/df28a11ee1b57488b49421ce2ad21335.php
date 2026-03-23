

<?php $__env->startSection('title','Reports'); ?>
<?php $__env->startSection('page-title','Reports & Charts'); ?>
 
<?php $__env->startSection('content'); ?>
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-label"><?php echo e($year); ?> Total Revenue</div>
            <div class="stat-value">₱<?php echo e(number_format($totalRevenue,2)); ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-label"><?php echo e($year); ?> Total Orders</div>
            <div class="stat-value"><?php echo e(number_format($totalOrders)); ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-label">Average Order Value</div>
            <div class="stat-value">₱<?php echo e(number_format($avgOrder,2)); ?></div>
        </div>
    </div>
</div>
 

<div class="kafe-card mb-3">
    <div class="kafe-card-body" style="padding:1rem 1.5rem;">
        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
            <span style="font-size:.82rem;font-weight:500;color:var(--kafe-brown);">Date Range:</span>
            <input type="date" id="rptFrom" class="form-control-kafe" style="width:145px;" value="<?php echo e(now()->startOfYear()->toDateString()); ?>">
            <span style="font-size:.8rem;color:#888;">to</span>
            <input type="date" id="rptTo" class="form-control-kafe" style="width:145px;" value="<?php echo e(now()->toDateString()); ?>">
            <button class="btn-kafe" onclick="loadCharts()"><i class="bi bi-bar-chart"></i> Apply</button>
            <a href="<?php echo e(route('admin.reports.export')); ?>" class="btn-kafe-outline" id="exportLink">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
        </div>
    </div>
</div>
 
<div class="row g-3">
    
    <div class="col-12">
        <div class="kafe-card">
            <div class="kafe-card-header">
                <span style="font-weight:500;">Sales Bar Chart</span>
                <span id="chartPeriod" style="font-size:.75rem;color:#888;"></span>
            </div>
            <div class="kafe-card-body">
                <canvas id="barChart" height="90"></canvas>
            </div>
        </div>
    </div>
 
    
    <div class="col-md-6">
        <div class="kafe-card">
            <div class="kafe-card-header"><span style="font-weight:500;">Sales by Product — % of Total</span></div>
            <div class="kafe-card-body" style="position:relative;height:300px;">
                <canvas id="productPieChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="kafe-card">
            <div class="kafe-card-header"><span style="font-weight:500;">Revenue by Category</span></div>
            <div class="kafe-card-body" style="position:relative;height:300px;">
                <canvas id="categoryPieChart"></canvas>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
 
<?php $__env->startPush('scripts'); ?>
<script>
const COLORS = ['#4A2C17','#C8874A','#7A8C6E','#D4A853','#E8D5C4','#B4B2A9','#3d5c35','#8b4513'];
let barChart, productPie, catPie;
 
function loadCharts() {
    const from = document.getElementById('rptFrom').value;
    const to   = document.getElementById('rptTo').value;
 
    // Update export link
    document.getElementById('exportLink').href = `/admin/reports/export?from=${from}&to=${to}`;
    document.getElementById('chartPeriod').textContent = from + ' → ' + to;
 
    fetch(`/admin/reports/sales-data?from=${from}&to=${to}`)
        .then(r => r.json())
        .then(data => {
            renderBar(data.salesByMonth);
            renderProductPie(data.salesByProduct);
            renderCategoryPie(data.salesByCategory);
        });
}
 
function renderBar(salesByMonth) {
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    const revenues = Array(12).fill(0);
    const orders   = Array(12).fill(0);
    salesByMonth.forEach(row => {
        revenues[row.month - 1] = parseFloat(row.revenue);
        orders[row.month - 1]   = parseInt(row.orders);
    });
 
    if (barChart) barChart.destroy();
    barChart = new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Revenue (₱)',
                    data: revenues,
                    backgroundColor: 'rgba(200,135,74,0.8)',
                    borderColor: '#C8874A',
                    borderWidth: 1.5,
                    borderRadius: 5,
                    yAxisID: 'y',
                },
                {
                    label: 'Orders',
                    data: orders,
                    type: 'line',
                    borderColor: '#7A8C6E',
                    backgroundColor: 'rgba(122,140,110,0.1)',
                    borderWidth: 2,
                    pointBackgroundColor: '#7A8C6E',
                    tension: 0.4,
                    yAxisID: 'y1',
                }
            ]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { position: 'top' } },
            scales: {
                y:  { type: 'linear', position: 'left',  ticks: { callback: v => '₱' + v.toLocaleString() } },
                y1: { type: 'linear', position: 'right', grid: { drawOnChartArea: false }, ticks: { precision: 0 } }
            }
        }
    });
}
 
function renderProductPie(salesByProduct) {
    const labels = salesByProduct.map(p => p.product_name);
    const values = salesByProduct.map(p => parseFloat(p.revenue));
    if (productPie) productPie.destroy();
    productPie = new Chart(document.getElementById('productPieChart'), {
        type: 'pie',
        data: { labels, datasets: [{ data: values, backgroundColor: COLORS }] },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 11 }, padding: 10 } },
                tooltip: { callbacks: { label: ctx => ctx.label + ': ₱' + parseFloat(ctx.raw).toLocaleString() } }
            }
        }
    });
}
 
function renderCategoryPie(salesByCategory) {
    const labels = salesByCategory.map(c => c.category);
    const values = salesByCategory.map(c => parseFloat(c.revenue));
    if (catPie) catPie.destroy();
    catPie = new Chart(document.getElementById('categoryPieChart'), {
        type: 'doughnut',
        data: { labels, datasets: [{ data: values, backgroundColor: COLORS, hoverOffset: 8 }] },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 11 } } },
                tooltip: { callbacks: { label: ctx => ctx.label + ': ₱' + parseFloat(ctx.raw).toLocaleString() } }
            }
        }
    });
}
 
// Load on page ready
loadCharts();
</script>
<?php $__env->stopPush(); ?>
 

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\admin\kafe-lumiere\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>