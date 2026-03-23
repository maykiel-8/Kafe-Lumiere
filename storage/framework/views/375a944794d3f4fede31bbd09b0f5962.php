

<?php $__env->startSection('title','Transactions'); ?>
<?php $__env->startSection('page-title','Transactions'); ?>

<?php $__env->startSection('content'); ?>
<div class="section-header">
    <div>
        <div class="section-title">Transactions</div>
        <div style="font-size:.8rem;color:#888;">Order history — update status, view and email receipts</div>
    </div>
    <div class="d-flex gap-2 align-items-center">
        
        <form method="GET" class="d-flex gap-2 align-items-center">
            <input type="date" name="from" class="form-control-kafe" style="width:140px;" value="<?php echo e(request('from')); ?>">
            <span style="font-size:.8rem;color:#888;">to</span>
            <input type="date" name="to"   class="form-control-kafe" style="width:140px;" value="<?php echo e(request('to')); ?>">
            <select name="status" class="form-control-kafe" style="width:130px;">
                <option value="">All Statuses</option>
                <option value="pending"   <?php echo e(request('status')==='pending'   ?'selected':''); ?>>Pending</option>
                <option value="completed" <?php echo e(request('status')==='completed' ?'selected':''); ?>>Completed</option>
                <option value="cancelled" <?php echo e(request('status')==='cancelled' ?'selected':''); ?>>Cancelled</option>
            </select>
            <button class="btn-kafe"><i class="bi bi-funnel"></i> Filter</button>
        </form>
        <a href="<?php echo e(route('admin.reports.export', request()->only('from','to'))); ?>" class="btn-kafe-outline">
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
            <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><strong style="font-family:var(--font-serif);"><?php echo e($t->order_number); ?></strong></td>
                <td>
                    <?php echo e($t->customer_name); ?>

                    <?php if($t->customer_email): ?>
                        <div style="font-size:.72rem;color:#888;"><?php echo e($t->customer_email); ?></div>
                    <?php endif; ?>
                </td>
                <td style="font-size:.82rem;"><?php echo e($t->orderItems->count()); ?> item(s)</td>
                <td><strong>₱<?php echo e(number_format($t->total, 2)); ?></strong></td>
                <td><span style="font-size:.78rem;text-transform:uppercase;font-weight:500;"><?php echo e($t->payment_method); ?></span></td>
                <td>
                    <select class="form-control-kafe" style="width:125px;padding:4px 8px;font-size:.78rem;"
                            onchange="updateStatus(<?php echo e($t->id); ?>, this.value)">
                        <option value="pending"   <?php echo e($t->status==='pending'   ?'selected':''); ?>>Pending</option>
                        <option value="completed" <?php echo e($t->status==='completed' ?'selected':''); ?>>Completed</option>
                        <option value="cancelled" <?php echo e($t->status==='cancelled' ?'selected':''); ?>>Cancelled</option>
                    </select>
                </td>
                <td style="font-size:.82rem;"><?php echo e($t->cashier->full_name ?? '—'); ?></td>
                <td style="font-size:.8rem;"><?php echo e($t->created_at->timezone('Asia/Manila')->format('M d, Y H:i')); ?></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="<?php echo e(route('admin.transactions.receipt', $t)); ?>" class="btn-icon" title="View Receipt" target="_blank"><i class="bi bi-receipt"></i></a>
                        <a href="<?php echo e(route('admin.transactions.pdf', $t)); ?>" class="btn-icon" title="Download PDF"><i class="bi bi-file-earmark-pdf"></i></a>
                        <button class="btn-icon" title="Email Receipt"
                                onclick="emailReceipt(<?php echo e($t->id); ?>, '<?php echo e($t->customer_email); ?>')">
                            <i class="bi bi-envelope"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3"><?php echo e($transactions->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\admin\kafe-lumiere\resources\views/admin/transactions/index.blade.php ENDPATH**/ ?>