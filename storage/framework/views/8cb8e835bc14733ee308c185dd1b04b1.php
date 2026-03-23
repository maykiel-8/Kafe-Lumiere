

<?php $__env->startSection('title','Edit User'); ?>
<?php $__env->startSection('page-title','Edit User'); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.users.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\admin\kafe-lumiere\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>