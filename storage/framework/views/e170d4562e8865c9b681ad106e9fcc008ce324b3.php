<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
    
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <base href="/app_web">
  
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-route.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-resource.js"></script>

  <script src="<?php echo e(asset('js/app_web.js')); ?>"></script>
 

<title><?php echo e(config('app.name')); ?></title>


</head>
  <body>

  <main>
    <div class="container">
      <div ng-app="app_web">
        <ng-view></ng-view>
      </div>    
    </div>
  </maim>
  </body>

</html>
<?php /**PATH /var/www/html/knewsweb.org/resources/views/layouts/appweb.blade.php ENDPATH**/ ?>