

<?php $__env->startSection('title', 'My Profile'); ?>
<?php $__env->startSection('page-title', 'My Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
<div class="col-lg-10">

<div class="row g-4">

    
    <div class="col-lg-4">
        <div class="kafe-card text-center">
            <div class="kafe-card-body" style="padding:2rem;">
                <div id="avatarPreview" style="width:110px;height:110px;border-radius:50%;background:var(--kafe-caramel);margin:0 auto 1rem;display:flex;align-items:center;justify-content:center;font-size:2.8rem;color:#fff;font-family:var(--font-serif);overflow:hidden;cursor:pointer;" onclick="document.getElementById('photoInput').click()">
                    <?php if(auth()->user()->photo): ?>
                        <img src="<?php echo e(auth()->user()->photo_url); ?>" style="width:100%;height:100%;object-fit:cover;" alt="Profile Photo">
                    <?php else: ?>
                        <?php echo e(strtoupper(substr(auth()->user()->first_name, 0, 1))); ?>

                    <?php endif; ?>
                </div>
                <div style="font-family:var(--font-serif);font-size:1.3rem;color:var(--kafe-brown);margin-bottom:4px;">
                    <?php echo e(auth()->user()->full_name); ?>

                </div>
                <span style="background:rgba(74,44,23,0.12);color:var(--kafe-brown);padding:3px 12px;border-radius:20px;font-size:.75rem;font-weight:500;">
                    <?php echo e(ucfirst(auth()->user()->role)); ?>

                </span>
                <div style="margin-top:4px;font-size:.75rem;color:#888;"><?php echo e(auth()->user()->email); ?></div>

                
                <form action="<?php echo e(route('admin.profile.update')); ?>" method="POST"
                      enctype="multipart/form-data" id="photoForm">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    
                    <input type="hidden" name="first_name" value="<?php echo e(auth()->user()->first_name); ?>">
                    <input type="hidden" name="last_name"  value="<?php echo e(auth()->user()->last_name); ?>">
                    <input type="hidden" name="email"      value="<?php echo e(auth()->user()->email); ?>">

                    <div class="upload-zone mt-3" onclick="document.getElementById('photoInput').click()">
                        <i class="bi bi-camera" style="font-size:1.6rem;color:var(--kafe-caramel);display:block;margin-bottom:6px;"></i>
                        <p style="font-size:.78rem;color:#888;margin:0;">Click to update photo</p>
                    </div>
                    <input type="file" id="photoInput" name="photo" accept="image/*"
                           style="display:none;" onchange="previewAndSubmit(event)">
                </form>

                <div style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid rgba(74,44,23,0.1);">
                    <div style="font-size:.75rem;color:#888;">Member since</div>
                    <div style="font-size:.85rem;font-weight:500;color:var(--kafe-brown);"><?php echo e(auth()->user()->created_at->format('F Y')); ?></div>
                </div>
                <div style="margin-top:.75rem;">
                    <div style="font-size:.75rem;color:#888;">Email verified</div>
                    <div style="font-size:.85rem;">
                        <?php if(auth()->user()->hasVerifiedEmail()): ?>
                            <span style="color:var(--kafe-sage);"><i class="bi bi-check-circle-fill"></i> Verified</span>
                        <?php else: ?>
                            <span style="color:#c0392b;"><i class="bi bi-x-circle"></i> Not verified</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-lg-8">
        <div class="kafe-card">
            <div class="kafe-card-header">
                <span style="font-weight:500;font-size:.95rem;">Edit Profile Information</span>
            </div>
            <div class="kafe-card-body">
                <form action="<?php echo e(route('admin.profile.update')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
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
                                   name="first_name"
                                   value="<?php echo e(old('first_name', auth()->user()->first_name)); ?>"
                                   required>
                            <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div style="font-size:.73rem;color:#c0392b;"><?php echo e($message); ?></div>
                            <?php unset($message);
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
                                   name="last_name"
                                   value="<?php echo e(old('last_name', auth()->user()->last_name)); ?>"
                                   required>
                            <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div style="font-size:.73rem;color:#c0392b;"><?php echo e($message); ?></div>
                            <?php unset($message);
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
                                   name="email" type="email"
                                   value="<?php echo e(old('email', auth()->user()->email)); ?>"
                                   required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div style="font-size:.73rem;color:#c0392b;"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-12">
                            <div style="border-top:1px solid rgba(74,44,23,0.1);padding-top:1rem;margin-top:.5rem;">
                                <div style="font-size:.82rem;font-weight:500;color:var(--kafe-brown);margin-bottom:.75rem;">
                                    Change Password <span style="font-weight:400;color:#888;">(leave blank to keep current)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-kafe">New Password</label>
                            <input class="form-control-kafe <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   name="password" type="password"
                                   placeholder="Min 8 characters"
                                   autocomplete="new-password">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div style="font-size:.73rem;color:#c0392b;"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-kafe">Confirm New Password</label>
                            <input class="form-control-kafe"
                                   name="password_confirmation" type="password"
                                   placeholder="Repeat new password"
                                   autocomplete="new-password">
                        </div>

                        <div class="col-12 pt-2">
                            <button type="submit" class="btn-kafe">
                                <i class="bi bi-check2"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="kafe-card mt-3" style="border-color:rgba(192,57,43,0.2);">
            <div class="kafe-card-header" style="background:rgba(192,57,43,0.04);">
                <span style="font-weight:500;font-size:.9rem;color:#8b1a1a;">Account Settings</span>
            </div>
            <div class="kafe-card-body">
                <div style="font-size:.82rem;color:#888;margin-bottom:1rem;">
                    Manage your session and account security.
                </div>
                <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <button class="btn-kafe-outline" style="border-color:rgba(192,57,43,0.4);color:#8b1a1a;"
                            onclick="return confirm('Log out?')">
                        <i class="bi bi-box-arrow-right"></i> Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function previewAndSubmit(e) {
    const file = e.target.files[0];
    if (!file) return;
    // Show preview immediately
    const wrap = document.getElementById('avatarPreview');
    wrap.innerHTML = `<img src="${URL.createObjectURL(file)}" style="width:100%;height:100%;object-fit:cover;">`;
    // Submit the photo-only form (includes hidden first_name, last_name, email)
    document.getElementById('photoForm').submit();
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\admin\kafe-lumiere\resources\views/admin/profile.blade.php ENDPATH**/ ?>