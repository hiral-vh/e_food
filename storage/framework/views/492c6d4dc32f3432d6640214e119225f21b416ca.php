<!-- ========== Left Sidebar Start ========== -->

<div class="left side-menu">
  <div class="sidebar-inner slimscrollleft">

    <div class="user-details">
      <div class="text-center">

        <?php if(isset(Auth::user()->restaurant_image)): ?>
        <img src="<?php echo e(asset('/')); ?><?php echo e(Auth::user()->restaurant_image); ?>" alt="" class="rounded-circle img-thumbnail">
        <?php else: ?>
        <img src="<?php echo e(asset('admin/images/users/avatar-1.jpg')); ?>" alt="user-img" class="rounded-circle">
        <?php endif; ?>
      </div>
      <div class="user-info">
        <div class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></a>
          <ul class="dropdown-menu">
            <li><a href="javascript:void(0)" class="dropdown-item"> Profile</a></li>
            <li><a href="javascript:void(0)" class="dropdown-item"><span class="badge badge-success float-right">5</span> Settings </a></li>
            <li><a href="javascript:void(0)" class="dropdown-item"> Lock screen</a></li>
            <li class="dropdown-divider"></li>
            <li><a href="javascript:void(0)" class="dropdown-item"> Logout</a></li>
          </ul>
        </div>

        <p class="text-muted m-0"><i class="far fa-dot-circle text-success"></i> Online</p>
      </div>
    </div>
    <!--- Divider -->

    <div id="sidebar-menu">
      <ul>
        <li class="menu-title">Main</li>

        <li>
          <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(Request::segment(1) == 'dashboard' ? 'waves-effect active' : ''); ?>"><i class="ti-home"></i><span> Dashboard </span></a>
        </li>

        <?php /*<li>
          <a href="{{route('food-category.index')}}" class="waves-effect"><i class="ti-calendar"></i><span> Food Category </span></a>
        </li>*/ ?>

        <!-- <li>
          <a href="<?php echo e(route('table-number.index')); ?>" class="<?php echo e(Request::segment(1) == 'table-number' ? 'waves-effect active' : ''); ?>"><i class="ti-calendar"></i><span> Seating Plan </span></a>
        </li> -->

        
        <li>
          <a href="<?php echo e(route('menu-category.index')); ?>" class="<?php echo e(Request::segment(1) == 'menu-category' ? 'waves-effect active' : ''); ?>"><i class="ti-calendar"></i><span> Menu Category </span></a>
        </li>
        <li>
          <a href="<?php echo e(route('food-menu.index')); ?>" class="<?php echo e(Request::segment(1) == 'food-menu' ? 'waves-effect active' : ''); ?>"><i class="ti-calendar"></i><span> Menu </span></a>
        </li>
        
        <!--
        <li>
          <a href="<?php echo e(route('delivery-person.index')); ?>" class="<?php echo e(Request::segment(1) == 'delivery-person' ? 'waves-effect active' : ''); ?>"><i class="ti-user"></i><span> Delivery Person </span></a>
        </li> -->
        <li>
          <a href="<?php echo e(route('discount.index')); ?>" class="<?php echo e(Request::segment(1) == 'discount' ? 'waves-effect active' : ''); ?>"><i class="fas fa-percentage"></i><span> Discount </span></a>
        </li>

        <?php /*<li>
          <a href="{{route('food-menu-category.index')}}" class="waves-effect"><i class="ti-calendar"></i><span> Food Menu Category </span></a>
        </li>*/ ?>
        <li>
          <a href="<?php echo e(route('calendar')); ?>" class="<?php echo e(Request::segment(1) == 'calendar' ? 'waves-effect active' : ''); ?>"><i class="ti-calendar"></i><span> Table Booking </span></a>
        </li>
        <li>
          <a href="<?php echo e(route('app-users')); ?>" class="<?php echo e(Request::segment(1) == 'app-users' ? 'waves-effect active' : ''); ?>"><i class="ti-user"></i><span> Customers </span></a>
        </li>
        <li>
          <a href="<?php echo e(route('order-report.index')); ?>" class="<?php echo e(Request::segment(1) == 'order-report' ? 'active' : ''); ?>"><i class="ti-settings"></i><span>Order Report</span></a>
        </li>
        <li>
          <a href="<?php echo e(route('subscription-details')); ?>" class="<?php echo e(Request::segment(1) == 'subscription-details' ? 'active' : ''); ?>"><i class="ti-settings"></i><span>Subscription</span></a>
        </li>
        <li>
          <a href="<?php echo e(route('weekTimeSet')); ?>" class="<?php echo e(Request::segment(1) == 'week-time-set' ? 'active' : ''); ?>"><i class="ti-settings"></i><span>Week Schedule</span></a>
        </li>
        <li>
          <a href="<?php echo e(route('notifications')); ?>" class="<?php echo e(Request::segment(1) == 'notifications' ? 'active' : ''); ?>"><i class="fa fa-bell"></i><span>Notification</span></a>
        </li>
        <li>
          <a href="<?php echo e(route('video-details')); ?>" class="<?php echo e(Request::segment(1) == 'video-details' ? 'active' : ''); ?>"><i class="fas fa-hands-helping"></i><span>How to use</span></a>
        </li>
      </ul>
    </div>
    <div class="clearfix"></div>
  </div>
  <!-- end sidebarinner -->
</div>
<!-- Left Sidebar End --><?php /**PATH C:\xampp\htdocs\e_food\resources\views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>