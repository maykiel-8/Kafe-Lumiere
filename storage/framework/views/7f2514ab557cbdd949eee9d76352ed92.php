

<?php $__env->startSection('title','Edit Product'); ?>
<?php $__env->startSection('page-title','Edit Product'); ?>
 
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.products.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
<?php $__env->stopSection(); ?>
 

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\admin\kafe-lumiere\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>