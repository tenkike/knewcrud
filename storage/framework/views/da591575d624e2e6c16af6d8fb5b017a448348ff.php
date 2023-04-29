<?php $__env->startSection('content'); ?>

<?php if(\Request::segment(2) == 'dashboard'): ?>
    <?php echo e($title); ?>

<?php endif; ?>

<?php echo $__env->yieldContent('admin'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<?php echo $__env->yieldContent('js_form'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/knewsweb.org/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>