<?php $__env->startSection('admin'); ?>
<div class="container">

	<?php if(\Request::segment(2) == 'grid'): ?>
	<div class="table-responsive-md">
		
		<?php echo $grid; ?>

	</div>
	<?php endif; ?>

	

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/knewsweb.org/resources/views/admin/grid.blade.php ENDPATH**/ ?>