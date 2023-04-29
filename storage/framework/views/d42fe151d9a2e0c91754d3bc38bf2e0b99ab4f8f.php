<?php $__env->startSection('admin'); ?>
<div class="container">
<h1> <?php echo e($title); ?> </h1>

	<?php if(\Request::segment(2) == 'grid'): ?>
	<div class="table-responsive-md">
		
	</div>
	<?php endif; ?>

	

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/knewsweb.org/resources/views/admin/index.blade.php ENDPATH**/ ?>