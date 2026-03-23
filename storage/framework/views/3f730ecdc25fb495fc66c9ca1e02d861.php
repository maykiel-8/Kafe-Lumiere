

<?php $__env->startSection('title','Users'); ?>
<?php $__env->startSection('page-title','User Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="section-header">
    <div>
        <div class="section-title">Users</div>
        <div style="font-size:.8rem;color:#888;">Manage staff accounts and roles</div>
    </div>
    <a href="<?php echo e(route('admin.users.create')); ?>" class="btn-kafe"><i class="bi bi-person-plus"></i> Add User</a>
</div>

<div class="kafe-card">
    <div class="kafe-card-body" style="padding:0;">
        <table class="table table-kafe mb-0" id="usersTable">
            <thead>
                <tr><th>Photo</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Verified</th><th>Joined</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="user-row-<?php echo e($user->id); ?>">
                <td>
                    <div style="width:36px;height:36px;border-radius:50%;overflow:hidden;background:var(--kafe-caramel);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:600;font-size:.8rem;">
                        <?php if($user->photo): ?>
                            <img src="<?php echo e(asset('storage/'.$user->photo)); ?>" style="width:100%;height:100%;object-fit:cover;">
                        <?php else: ?>
                            <?php echo e(strtoupper(substr($user->first_name,0,1))); ?>

                        <?php endif; ?>
                    </div>
                </td>
                <td><strong><?php echo e($user->full_name); ?></strong></td>
                <td style="font-size:.82rem;"><?php echo e($user->email); ?></td>
                <td>
                    
                    <select class="form-control-kafe" style="width:115px;padding:4px 8px;font-size:.78rem;"
                            onchange="updateRole(<?php echo e($user->id); ?>, this.value)"
                            <?php echo e($user->id === auth()->id() ? 'disabled' : ''); ?>>
                        <option value="admin"    <?php echo e($user->role === 'admin'    ? 'selected' : ''); ?>>Admin</option>
                        <option value="cashier"  <?php echo e($user->role === 'cashier'  ? 'selected' : ''); ?>>Cashier</option>
                        <option value="customer" <?php echo e($user->role === 'customer' ? 'selected' : ''); ?>>Customer</option>
                    </select>
                </td>
                <td>
                    <button class="badge-kafe <?php echo e($user->status === 'active' ? 'badge-active' : 'badge-inactive'); ?>"
                            style="border:none;cursor:pointer;background:none;"
                            onclick="toggleStatus(<?php echo e($user->id); ?>, this)"
                            <?php echo e($user->id === auth()->id() ? 'disabled' : ''); ?>>
                        <?php echo e(ucfirst($user->status)); ?>

                    </button>
                </td>
                <td>
                    <?php if($user->email_verified_at): ?>
                        <span style="color:var(--kafe-sage);font-size:.82rem;"><i class="bi bi-check-circle-fill"></i> Verified</span>
                    <?php else: ?>
                        <span style="color:#888;font-size:.82rem;"><i class="bi bi-clock"></i> Pending</span>
                    <?php endif; ?>
                </td>
                <td style="font-size:.8rem;"><?php echo e($user->created_at->format('M d, Y')); ?></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn-icon" title="Edit"><i class="bi bi-pencil"></i></a>
                        <?php if($user->id !== auth()->id()): ?>
                        <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST"
                              onsubmit="return confirm('Delete this user?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn-icon danger" title="Delete"><i class="bi bi-trash"></i></button>
                        </form>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3"><?php echo e($users->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function () {
    $('#usersTable').DataTable({
        pageLength: 15,
        columnDefs: [{ orderable: false, targets: [0, 3, 4, 7] }],
        language: {
            search: '<i class="bi bi-search"></i>',
            searchPlaceholder: 'Search...',
            paginate: { previous: '‹', next: '›' }
        }
    });
});

function toggleStatus(id, btn) {
    const current   = btn.textContent.trim().toLowerCase();
    const newStatus = current === 'active' ? 'inactive' : 'active';
    $.ajax({
        url: '/admin/users/' + id + '/status',
        method: 'PATCH',
        data: { status: newStatus },
        success(res) {
            btn.textContent = res.status.charAt(0).toUpperCase() + res.status.slice(1);
            btn.className   = 'badge-kafe ' + (res.status === 'active' ? 'badge-active' : 'badge-inactive');
            btn.style.cssText = 'border:none;cursor:pointer;background:none;';
        }
    });
}

function updateRole(id, role) {
    $.ajax({
        url: '/admin/users/' + id + '/role',
        method: 'PATCH',
        data: { role },
        success() { showToast('Role updated to ' + role); }
    });
}

function showToast(msg) {
    const t = document.createElement('div');
    t.style.cssText = 'position:fixed;bottom:24px;right:24px;background:var(--kafe-brown);color:#fff;padding:12px 20px;border-radius:10px;font-size:.85rem;z-index:9999;';
    t.textContent = '✓ ' + msg;
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 2800);
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\admin\kafe-lumiere\resources\views/admin/users/index.blade.php ENDPATH**/ ?>