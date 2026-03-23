

<?php $__env->startSection('title','Archived Products'); ?>
<?php $__env->startSection('page-title','Product Archive'); ?>

<?php $__env->startSection('content'); ?>
<div class="section-header">
    <div>
        <div class="section-title">Archived Products</div>
        <div style="font-size:.8rem;color:#888;">Soft-deleted products — restore to bring them back</div>
    </div>
    <a href="<?php echo e(route('admin.products.index')); ?>" class="btn-kafe-outline">
        <i class="bi bi-arrow-left"></i> Back to Products
    </a>
</div>

<div class="kafe-card">
    <div class="kafe-card-body" style="padding:0;">
        <table class="table table-kafe mb-0" id="trashedTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Deleted On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            
            
            
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><strong><?php echo e($p->name); ?></strong></td>
                <td><?php echo e($p->category->name ?? '—'); ?></td>
                <td>₱<?php echo e(number_format($p->price_tall, 2)); ?></td>
                <td style="font-size:.82rem;"><?php echo e($p->deleted_at->format('M d, Y')); ?></td>
                <td>
                    <form action="<?php echo e(route('admin.products.restore', $p->id)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-kafe" style="font-size:.78rem;padding:4px 14px;">
                            <i class="bi bi-arrow-counterclockwise"></i> Restore
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function () {
    $('#trashedTable').DataTable({
        pageLength: 15,
        language: {
            emptyTable: 'No archived products.',
            search: '<i class="bi bi-search"></i>',
            searchPlaceholder: 'Search...',
            paginate: { previous: '‹', next: '›' }
        },
        columnDefs: [
            { targets: [4], orderable: false }
        ]
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\admin\kafe-lumiere\resources\views/admin/products/trashed.blade.php ENDPATH**/ ?>