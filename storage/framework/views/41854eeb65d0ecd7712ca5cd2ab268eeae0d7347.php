 <!-- Top Bar Start -->
 <div class="topbar">
   <!-- LOGO -->
   <div class="topbar-left">
     <div class="text-center">
       <a href="javascript:void(0);" class="logo"><img src="<?php echo e(asset('logo.png')); ?>" alt="" height="85"></a>
       <a href="javascript:void(0);" class="logo-sm"><img src="<?php echo e(asset('favicon.png')); ?>" alt="" height="28"></a>
     </div>
   </div>
   <!-- Button mobile view to collapse sidebar menu -->

   <nav class="navbar navbar-default">
     <div class="container-fluid">
       <ul class="list-inline menu-left mb-0">
         <li class="float-left">
           <button class="button-menu-mobile open-left waves-light waves-effect">
             <i class="mdi mdi-menu"></i>
           </button>
         </li>

       </ul>

       <ul class="nav navbar-right float-right list-inline">
         <li class="dropdown d-none d-sm-block">
           <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light notification-icon-box" data-toggle="dropdown" aria-expanded="true">
             <i class="fa fa-bell"></i> <?php if($unreadNotification !=0): ?> <span class="badge badge-xs badge-danger"></span> <?php endif; ?>
           </a>
           <ul class="dropdown-menu dropdown-menu-lg">
             <li class="text-center notifi-title">Notification <span class="badge badge-xs badge-success"><?php echo e($unreadNotification); ?></span></li>
             <li class="list-group">

               <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rwData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
               <?php if($rwData->data['type'] == 1): ?>
               <a href="javascript:void(0);" class="dropdown-item notify-item mt-2">
                 <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>
                 <p class="notify-details"><?php echo e($rwData->data['message']); ?><span class="text-muted"><?php echo e(date('Y-m-d', strtotime($rwData->data['date&time']))); ?></span></p>
               </a>
               <?php elseif($rwData->data['type'] == 3): ?>
               <a href="javascript:void(0);" class="dropdown-item notify-item mt-2">
                 <div class="notify-icon bg-success"><i class="mdi mdi-message-text-outline"></i></div>
                 <p class="notify-details"><?php echo e($rwData->data['message']); ?><span class="text-muted"><?php echo e(date('Y-m-d', strtotime($rwData->data['date&time']))); ?></span></p>
               </a>
               <?php elseif($rwData->data['type'] == 2): ?>
               <a href="<?php echo e(route('order-report.show', $rwData->data['orderId'])); ?>" class="dropdown-item notify-item mt-2">
                 <div class="notify-icon bg-success"><i class="mdi mdi-message-text-outline"></i></div>
                 <p class="notify-details"><?php echo e($rwData->data['userName']); ?> <?php echo e($rwData->data['message']); ?><span class="text-muted"></span></p>
               </a>
               <?php elseif($rwData->data['type'] == 4): ?>
               <a href="javascript:void(0);" class="dropdown-item notify-item mt-2">
                 <div class="notify-icon bg-success"><i class="mdi mdi-message-text-outline"></i></div>
                 <p class="notify-details"><?php echo e($rwData->data['userName']); ?> <?php echo e($rwData->data['message']); ?> <?php echo e($rwData->data['tableName']); ?> <?php echo e($rwData->data['bookingDate']); ?><span class="text-muted"></span></p>
               </a>
               <?php endif; ?>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
               <a href="javascript:void(0);" class="dropdown-item notify-item mt-2">
                 <center>
                   <p class="notify-details">Data not available<span class="text-muted"></span></p>
                 </center>
               </a>
               <?php endif; ?>
               <!-- last list item -->
               <a href="<?php echo e(route('notifications')); ?>" class="list-group-item text-center">
                 <small class="text-primary mb-0">View all </small>
               </a>
             </li>
           </ul>
         </li>
         <li class="d-none d-sm-block">
           <a href="#" id="btn-fullscreen" class="waves-effect waves-light notification-icon-box"><i class="fas fa-expand"></i></a>
         </li>

         <li class="dropdown">
           <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
             <?php if(isset(Auth::user()->restaurant_image)): ?>
             <img src="<?php echo e(asset('/')); ?><?php echo e(Auth::user()->restaurant_image); ?>" alt="user-img" class="rounded-circle">
             <?php else: ?>
             <img src="<?php echo e(asset('admin/images/users/avatar-1.jpg')); ?>" alt="user-img" class="rounded-circle">
             <?php endif; ?>
             <span class="profile-username">
               <span class="mdi mdi-chevron-down font-15"></span>
             </span>
           </a>
           <ul class="dropdown-menu">
             <li><a href="<?php echo e(asset('/')); ?>profile" class="dropdown-item"> Profile</a></li>
             <li><a href="<?php echo e(route('change-password')); ?>" class="dropdown-item"> Change Password</a></li>
             <li class="dropdown-divider"></li>
             <li><a href="<?php echo e(route('logout')); ?>" class="dropdown-item"> Logout</a></li>
           </ul>
         </li>
       </ul>
     </div>
   </nav>
 </div>
 <!-- Top Bar End --><?php /**PATH C:\xampp\htdocs\e_food\resources\views/admin/layouts/topbar.blade.php ENDPATH**/ ?>