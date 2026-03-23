

<?php $__env->startSection('title', isset($user) ? 'Edit User' : 'Add User'); ?>
<?php $__env->startSection('page-title', isset($user) ? 'Edit User' : 'Add User'); ?>
 
<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
<div class="col-lg-7">
 
<form action="<?php echo e(isset($user) ? route('admin.users.update', $user) : route('admin.users.store')); ?>"
      method="POST" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<?php if(isset($user)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
 
<div class="kafe-card mb-3">
    <div class="kafe-card-header"><span style="font-weight:500;"><?php echo e(isset($user) ? 'Edit User Account' : 'New User Account'); ?></span></div>
    <div class="kafe-card-body">
 
        
        <div style="text-align:center;margin-bottom:1.5rem;">
            <div id="avatarPreview" style="width:90px;height:90px;border-radius:50%;background:var(--kafe-caramel);margin:0 auto 10px;display:flex;align-items:center;justify-content:center;font-size:2.2rem;color:#fff;font-family:var(--font-serif);overflow:hidden;cursor:pointer;" onclick="document.getElementById('photoInput').click()">
                <?php if(isset($user) && $user->photo): ?>
                    <img src="<?php echo e(asset('storage/'.$user->photo)); ?>" style="width:100%;height:100%;object-fit:cover;">
                <?php else: ?>
                    <i class="bi bi-person" style="font-size:2rem;"></i>
                <?php endif; ?>
            </div>
            <button type="button" class="btn-kafe-outline" style="font-size:.78rem;padding:4px 14px;" onclick="document.getElementById('photoInput').click()">
                <i class="bi bi-camera"></i> Upload Photo
            </button>
            <input type="file" id="photoInput" name="photo" accept="image/*" style="display:none;" onchange="previewAvatar(event)">
            <div style="font-size:.72rem;color:#888;margin-top:4px;">JPG/PNG, max 2MB. Email verification will be sent on creation.</div>
        </div>
 
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label-kafe">First Name *</label>
                <input class="form-control-kafe <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       name="first_name" value="<?php echo e(old('first_name', $user->first_name ?? '')); ?>" required>
                <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="font-size:.73rem;color:#c0392b;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label-kafe">Last Name *</label>
                <input class="form-control-kafe <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       name="last_name" value="<?php echo e(old('last_name', $user->last_name ?? '')); ?>" required>
                <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="font-size:.73rem;color:#c0392b;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-12">
                <label class="form-label-kafe">Email Address *</label>
                <input class="form-control-kafe <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       name="email" type="email" value="<?php echo e(old('email', $user->email ?? '')); ?>" required>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="font-size:.73rem;color:#c0392b;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label-kafe">Role *</label>
                <select class="form-control-kafe" name="role" required>
                    <option value="cashier" <?php echo e(old('role', $user->role ?? '') === 'cashier' ? 'selected':''); ?>>Cashier</option>
                    <option value="admin"   <?php echo e(old('role', $user->role ?? '') === 'admin'   ? 'selected':''); ?>>Admin</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label-kafe">Status</label>
                <select class="form-control-kafe" name="status">
                    <option value="active"   <?php echo e(old('status', $user->status ?? 'active')   === 'active'   ? 'selected':''); ?>>Active</option>
                    <option value="inactive" <?php echo e(old('status', $user->status ?? '') === 'inactive' ? 'selected':''); ?>>Inactive</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label-kafe">Password <?php echo e(isset($user) ? '(leave blank to keep)' : '*'); ?></label>
                <input class="form-control-kafe <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       name="password" type="password"
                       placeholder="<?php echo e(isset($user) ? 'New password…' : 'Min 8 characters'); ?>"
                       <?php echo e(isset($user) ? '' : 'required'); ?>>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="font-size:.73rem;color:#c0392b;"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6">
                <label class="form-label-kafe">Confirm Password</label>
                <input class="form-control-kafe" name="password_confirmation" type="password" placeholder="Repeat password">
            </div>
        </div>
    </div>
</div>
 
<div class="d-flex gap-2">
    <button type="submit" class="btn-kafe">
        <i class="bi bi-check2"></i> <?php echo e(isset($user) ? 'Update User' : 'Create User'); ?>

    </button>
    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn-kafe-outline">Cancel</a>
</div>
</form>
 
</div>
</div>
<?php $__env->stopSection(); ?>
 
<?php $__env->startPush('scripts'); ?>
<script>
function previewAvatar(e) {
    const file = e.target.files[0];
    if (!file) return;
    const wrap = document.getElementById('avatarPreview');
    wrap.innerHTML = `<img src="${URL.createObjectURL(file)}" style="width:100%;height:100%;object-fit:cover;">`;
}
</script>
<?php $__env->stopPush(); ?>
 

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\admin\kafe-lumiere\resources\views/admin/users/create.blade.php ENDPATH**/ ?>