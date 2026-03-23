

<?php $__env->startSection('title','Products'); ?>
<?php $__env->startSection('page-title','Product Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="section-header">
    <div>
        <div class="section-title">Products</div>
        <div style="font-size:.8rem;color:#888;">Manage your milk tea catalog</div>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('admin.products.trashed')); ?>" class="btn-kafe-outline">
            <i class="bi bi-archive"></i> Archive (<?php echo e(\App\Models\Product::onlyTrashed()->count()); ?>)
        </a>
        <button class="btn-kafe-outline" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="bi bi-file-earmark-excel"></i> Import Excel
        </button>
        <a href="<?php echo e(route('admin.products.export')); ?>" class="btn-kafe-outline">
            <i class="bi bi-download"></i> Export
        </a>
        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn-kafe">
            <i class="bi bi-plus-lg"></i> Add Product
        </a>
    </div>
</div>

<div class="kafe-card">
    <div class="kafe-card-body" style="padding:0;">
        <table class="table table-kafe mb-0" id="productsTable">
            <thead>
                <tr><th>Photo</th><th>Name</th><th>Category</th><th>Size</th><th>Price (Tall)</th><th>Price (Grande)</th><th>Add-ons</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>
                    <?php $thumb = $p->main_photo ?? optional($p->photos->first())->path; ?>
                    <?php if($thumb): ?>
                        <img src="<?php echo e(asset('storage/'.$thumb)); ?>" style="width:44px;height:44px;border-radius:8px;object-fit:cover;">
                    <?php else: ?>
                        <div style="width:44px;height:44px;border-radius:8px;background:var(--kafe-pearl);display:flex;align-items:center;justify-content:center;font-size:1.3rem;">☕</div>
                    <?php endif; ?>
                </td>
                <td>
                    <strong><?php echo e($p->name); ?></strong>
                    <div style="font-size:.75rem;color:#888;"><?php echo e(Str::limit($p->description, 50)); ?></div>
                    <?php if($p->photos->count() > 1): ?>
                        <span style="font-size:.7rem;color:var(--kafe-caramel);"><i class="bi bi-images"></i> <?php echo e($p->photos->count()); ?> photos</span>
                    <?php endif; ?>
                </td>
                <td><?php echo e($p->category->name); ?></td>
                <td style="font-size:.82rem;"><?php echo e($p->size); ?></td>
                <td><strong>₱<?php echo e(number_format($p->price_tall, 2)); ?></strong></td>
                <td><?php echo e($p->price_grande ? '₱'.number_format($p->price_grande,2) : '—'); ?></td>
                <td style="font-size:.78rem;"><?php echo e($p->addons->pluck('name')->join(', ') ?: '—'); ?></td>
                <td>
                    <span class="badge-kafe <?php echo e($p->is_available ? 'badge-active' : 'badge-inactive'); ?>">
                        <?php echo e($p->is_available ? 'Available' : 'Unavailable'); ?>

                    </span>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="<?php echo e(route('admin.products.edit', $p)); ?>" class="btn-icon" title="Edit"><i class="bi bi-pencil"></i></a>
                        <form action="<?php echo e(route('admin.products.destroy', $p)); ?>" method="POST" onsubmit="return confirm('Archive this product?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn-icon danger" title="Archive"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3"><?php echo e($products->links()); ?></div>


<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog modal-kafe">
        <div class="modal-content modal-kafe">
            <div class="modal-header"><h5 class="modal-title">Import Products from Excel</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body" style="padding:1.5rem;">
                <div style="background:var(--kafe-pearl);border-radius:10px;padding:1rem;font-size:.8rem;margin-bottom:1rem;">
                    <strong>Required columns:</strong> name, category, price_tall<br>
                    <strong>Optional:</strong> description, size, price_grande
                </div>
                <form action="<?php echo e(route('admin.products.import')); ?>" method="POST" enctype="multipart/form-data" id="importForm">
                    <?php echo csrf_field(); ?>
                    <div class="upload-zone" onclick="document.getElementById('excelFile').click()">
                        <i class="bi bi-file-earmark-excel" style="font-size:2rem;color:#1D6F42;display:block;margin-bottom:8px;"></i>
                        <p style="font-size:.82rem;color:#888;margin:0;">Click to select Excel file (.xlsx, .xls, .csv)</p>
                    </div>
                    <input type="file" id="excelFile" name="file" accept=".xlsx,.xls,.csv" style="display:none;" onchange="showFileName(this)">
                    <div id="fileName" style="font-size:.8rem;color:var(--kafe-sage);margin-top:8px;"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn-kafe-outline" data-bs-dismiss="modal">Cancel</button>
                <button class="btn-kafe" onclick="document.getElementById('importForm').submit()"><i class="bi bi-upload"></i> Import</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$('#productsTable').DataTable({ pageLength: 15, order: [[1,'asc']] });
function showFileName(input) {
    document.getElementById('fileName').textContent = input.files[0]?.name || '';
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\admin\kafe-lumiere\resources\views/admin/products/index.blade.php ENDPATH**/ ?>