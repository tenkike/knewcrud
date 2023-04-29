<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark" aria-label="First navbar example">
    <div class="container-fluid">
        <a class="navbar-brand" href="/"><?php echo e(config('app.name')); ?></a>
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbars1" aria-controls="navbars1" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

    <div class="collapse navbar-collapse" id="navbars1" style="">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if(!empty($menu)): ?>
            <?php $__currentLoopData = $menu['parent']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                <?php if(!empty($val['count'])): ?> 
                <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="/<?php echo e($val['link']); ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo e(ucfirst($val['label'])); ?></a>
                     <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo e($val['link']); ?>">

                        <?php echo e(ucfirst($val['label'])); ?></a></li>
                
                <?php $__currentLoopData = $menu['submenu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                    
                        <?php if($rows['parent'] == $k): ?>

                        <li><a class="dropdown-item" href="<?php echo e($rows['link']); ?>"><?php echo e(ucfirst($rows['label'])); ?></a></li>
                    
                        <?php endif; ?>
                     
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </ul>
                    </li>

                <?php else: ?>

                 <?php if($val['label'] == 'home' ): ?>

                    <li class="nav-item">
                     <a class="nav-link active" aria-current="page" href="<?php echo e($val['link']); ?>"><?php echo e(ucfirst($val['label'])); ?></a>
                    </li>

                     <?php else: ?>

                     <li class="nav-item">
                     <a class="nav-link" href="<?php echo e($val['link']); ?>"><?php echo e(ucfirst($val['label'])); ?></a>
                    </li>

                      <?php endif; ?>

                <?php endif; ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        </ul>
        <form role="search">
        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
        </form>
    </div>
    </div>
  </nav>
</header><?php /**PATH /var/www/html/knewsweb.org/resources/views/pages/menu.blade.php ENDPATH**/ ?>