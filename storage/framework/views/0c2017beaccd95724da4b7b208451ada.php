


<?php $__env->startSection('title', isset($product) ? 'Edit Product' : 'Add Product'); ?>
<?php $__env->startSection('page-title', isset($product) ? 'Edit Product' : 'Add Product'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
<div class="col-xl-10">

<form action="<?php echo e(isset($product) ? route('admin.products.update', $product) : route('admin.products.store')); ?>"
      method="POST" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<?php if(isset($product)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

<div class="row g-3">
    
    <div class="col-lg-8">
        <div class="kafe-card mb-3">
            <div class="kafe-card-header"><span style="font-weight:500;">Product Details</span></div>
            <div class="kafe-card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label-kafe">Product Name *</label>
                        <input class="form-control-kafe <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               name="name" value="<?php echo e(old('name', $product->name ?? '')); ?>"
                               placeholder="e.g. Brown Sugar Milk Tea" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger" style="font-size:.75rem;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-kafe">Category *</label>
                        <select class="form-control-kafe <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="category_id" required>
                            <option value="">-- Select category --</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->id); ?>" <?php echo e(old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : ''); ?>>
                                    <?php echo e($cat->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-kafe">Size Options</label>
                        <select class="form-control-kafe" name="size">
                            <?php $__currentLoopData = ['Tall (16oz)', 'Grande (22oz)', 'Both']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($sz); ?>" <?php echo e(old('size', $product->size ?? 'Both') == $sz ? 'selected' : ''); ?>><?php echo e($sz); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-kafe">Price — Tall (₱) *</label>
                        <input class="form-control-kafe <?php $__errorArgs = ['price_tall'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               name="price_tall" type="number" step="0.01" min="0"
                               value="<?php echo e(old('price_tall', $product->price_tall ?? '')); ?>" required>
                        <?php $__errorArgs = ['price_tall'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger" style="font-size:.75rem;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-kafe">Price — Grande (₱)</label>
                        <input class="form-control-kafe" name="price_grande" type="number" step="0.01" min="0"
                               value="<?php echo e(old('price_grande', $product->price_grande ?? '')); ?>" placeholder="Optional">
                    </div>
                    <div class="col-12">
                        <label class="form-label-kafe">Description</label>
                        <textarea class="form-control-kafe" name="description" rows="3"
                                  placeholder="Brief product description…"><?php echo e(old('description', $product->description ?? '')); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="kafe-card">
            <div class="kafe-card-header"><span style="font-weight:500;">Available Add-ons</span></div>
            <div class="kafe-card-body">
                <div class="row g-2">
                    <?php $__currentLoopData = $addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 col-6">
                        <label style="display:flex;align-items:center;gap:8px;font-size:.85rem;cursor:pointer;padding:8px 12px;border:1.5px solid rgba(74,44,23,0.15);border-radius:8px;transition:all .15s;"
                               onmouseover="this.style.background='var(--kafe-pearl)'" onmouseout="this.style.background=''">
                            <input type="checkbox" name="addon_ids[]" value="<?php echo e($addon->id); ?>"
                                <?php echo e(in_array($addon->id, old('addon_ids', isset($product) ? $product->addons->pluck('id')->toArray() : [])) ? 'checked' : ''); ?>>
                            <span><?php echo e($addon->name); ?></span>
                            <span style="font-size:.72rem;color:#888;margin-left:auto;">+₱<?php echo e($addon->price); ?></span>
                        </label>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-lg-4">
        <div class="kafe-card">
            <div class="kafe-card-header"><span style="font-weight:500;">Product Photos</span></div>
            <div class="kafe-card-body">
                <div class="upload-zone" onclick="document.getElementById('photoInput').click()">
                    <i class="bi bi-images" style="font-size:2rem;color:var(--kafe-caramel);display:block;margin-bottom:8px;"></i>
                    <p style="font-size:.82rem;color:#888;margin:0;">Click to upload photos<br><span style="font-size:.72rem;">Multiple files — first photo becomes the main</span></p>
                </div>
                <input type="file" id="photoInput" name="photos[]" multiple accept="image/*" style="display:none;" onchange="previewPhotos(event)">

                
                <?php if(isset($product) && $product->photos->count()): ?>
                    <div style="margin-top:10px;">
                        
                        <div style="font-size:.75rem;color:#888;margin-bottom:6px;">
                            Saved photos (<span id="savedPhotoCount"><?php echo e($product->photos->count()); ?></span>)
                        </div>
                        
                        <div id="photoGallery" style="display:flex;flex-wrap:wrap;gap:6px;">
                            <?php $__currentLoopData = $product->photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="photo-thumb" id="photoThumb_<?php echo e($photo->id); ?>"
                                     style="position:relative;flex-shrink:0;">
                                    <?php $bc = $photo->is_main ? 'var(--kafe-caramel)' : 'rgba(74,44,23,0.1)'; ?>
                                    <img src="<?php echo e(asset('storage/'.$photo->path)); ?>"
                                         style="width:75px;height:75px;border-radius:8px;object-fit:cover;border:2px solid <?php echo e($bc); ?>;">
                                    <?php if($photo->is_main): ?>
                                        <span style="position:absolute;bottom:2px;left:0;right:0;text-align:center;font-size:.55rem;background:var(--kafe-caramel);color:#fff;border-radius:0 0 6px 6px;">MAIN</span>
                                    <?php endif; ?>
                                    
                                    <button type="button"
                                            onclick="deletePhoto(<?php echo e($photo->id); ?>, this)"
                                            style="position:absolute;top:2px;right:2px;width:20px;height:20px;border-radius:50%;background:#c0392b;color:#fff;border:none;cursor:pointer;font-size:.7rem;line-height:1;display:flex;align-items:center;justify-content:center;"
                                            title="Remove photo">×</button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php else: ?>
                    
                    <div id="photoGallery" style="display:flex;flex-wrap:wrap;gap:6px;margin-top:10px;">
                        <div style="font-size:.75rem;color:#888;margin-bottom:6px;width:100%;">
                            Saved photos (<span id="savedPhotoCount">0</span>)
                        </div>
                    </div>
                <?php endif; ?>

                
                <div id="photoPreview" style="display:flex;flex-wrap:wrap;gap:6px;margin-top:8px;"></div>
            </div>
        </div>

        <?php if(isset($product)): ?>
        <div class="kafe-card mt-3">
            <div class="kafe-card-body">
                <label class="form-label-kafe">Availability</label>
                <div style="display:flex;gap:12px;margin-top:4px;">
                    <label style="font-size:.85rem;cursor:pointer;display:flex;align-items:center;gap:5px;">
                        <input type="radio" name="is_available" value="1" <?php echo e($product->is_available ? 'checked' : ''); ?>> Available
                    </label>
                    <label style="font-size:.85rem;cursor:pointer;display:flex;align-items:center;gap:5px;">
                        <input type="radio" name="is_available" value="0" <?php echo e(!$product->is_available ? 'checked' : ''); ?>> Unavailable
                    </label>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="d-flex gap-2 mt-3">
    <button type="submit" class="btn-kafe"><i class="bi bi-check2"></i> <?php echo e(isset($product) ? 'Update Product' : 'Create Product'); ?></button>
    <a href="<?php echo e(route('admin.products.index')); ?>" class="btn-kafe-outline">Cancel</a>
</div>
</form>

</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// ── Delete photo via AJAX (avoids nested form bug) ───────
function deletePhoto(photoId, btn) {
    if (!confirm('Remove this photo?')) return;

    const formData = new FormData();
    formData.append('_token',  document.querySelector('meta[name="csrf-token"]').content);
    formData.append('_method', 'DELETE');

    fetch('/admin/product-photos/' + photoId, {
        method:  'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body:    formData
    })
    .then(r => {
        if (r.ok || r.redirected) {
            // Remove just this photo thumbnail from the DOM
            const thumb = document.getElementById('photoThumb_' + photoId);
            if (thumb) thumb.remove();

            // Update the "Saved photos (N)" counter
            const countEl = document.getElementById('savedPhotoCount');
            if (countEl) {
                const newCount = parseInt(countEl.textContent) - 1;
                countEl.textContent = newCount;
            }
        } else {
            alert('Failed to delete photo. Please try again.');
        }
    })
    .catch(() => alert('Error deleting photo. Please try again.'));
}

// ── Preview newly selected photos before upload ──────────
function previewPhotos(e) {
    const preview  = document.getElementById('photoPreview');
    const countEl  = document.getElementById('savedPhotoCount');
    const files    = Array.from(e.target.files);
    preview.innerHTML = ''; // clear old previews

    // Show label above preview
    if (files.length) {
        const lbl = document.createElement('div');
        lbl.style = 'font-size:.72rem;color:#888;width:100%;margin-bottom:4px;';
        lbl.textContent = 'New photos to upload (' + files.length + '):';
        preview.appendChild(lbl);
    }

    files.forEach((file, i) => {
        const wrap = document.createElement('div');
        wrap.style = 'position:relative;display:inline-block;';
        const img  = document.createElement('img');
        img.src    = URL.createObjectURL(file);
        img.style  = 'width:70px;height:70px;border-radius:8px;object-fit:cover;border:2px solid ' + (i === 0 ? 'var(--kafe-caramel)' : 'rgba(74,44,23,0.1)') + ';';
        wrap.appendChild(img);
        if (i === 0) {
            const mainLbl    = document.createElement('span');
            mainLbl.textContent = 'NEW MAIN';
            mainLbl.style    = 'position:absolute;bottom:2px;left:0;right:0;text-align:center;font-size:.5rem;background:var(--kafe-caramel);color:#fff;border-radius:0 0 6px 6px;';
            wrap.appendChild(mainLbl);
        }
        preview.appendChild(wrap);
    });
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\admin\kafe-lumiere\resources\views/admin/products/create.blade.php ENDPATH**/ ?>