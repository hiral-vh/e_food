<!-- ========== Left Sidebar Start ========== -->

<div class="left side-menu">
  <div class="sidebar-inner slimscrollleft">

    <div class="user-details">
      <div class="text-center">

        @if(isset(Auth::user()->restaurant_image))
        <img src="{{asset('/')}}{{Auth::user()->restaurant_image}}" alt="" class="rounded-circle img-thumbnail">
        @else
        <img src="{{asset('admin/images/users/avatar-1.jpg')}}" alt="user-img" class="rounded-circle">
        @endif
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
          <a href="{{route('dashboard')}}" class="{{Request::segment(1) == 'dashboard' ? 'waves-effect active' : ''}}"><i class="ti-home"></i><span> Dashboard </span></a>
        </li>

        <?php /*<li>
          <a href="{{route('food-category.index')}}" class="waves-effect"><i class="ti-calendar"></i><span> Food Category </span></a>
        </li>*/ ?>

        <!-- <li>
          <a href="{{route('table-number.index')}}" class="{{Request::segment(1) == 'table-number' ? 'waves-effect active' : ''}}"><i class="ti-calendar"></i><span> Seating Plan </span></a>
        </li> -->

        {{-- <li>
          <a href="{{route('cuisine.index')}}" class="waves-effect"><i class="ti-calendar"></i><span> Cuisine </span></a>
        </li> --}}
        <li>
          <a href="{{route('menu-category.index')}}" class="{{Request::segment(1) == 'menu-category' ? 'waves-effect active' : ''}}"><i class="ti-calendar"></i><span> Menu Category </span></a>
        </li>
        <li>
          <a href="{{route('food-menu.index')}}" class="{{Request::segment(1) == 'food-menu' ? 'waves-effect active' : ''}}"><i class="ti-calendar"></i><span> Menu </span></a>
        </li>
        {{-- <li>
            <a href="{{route('food-menu.index')}}" class="{{Request::segment(1) == 'food-menu' ? 'waves-effect active' : ''}}"><i class="ti-calendar"></i><span> Category </span></a>
        </li> --}}
        <!--
        <li>
          <a href="{{route('delivery-person.index')}}" class="{{Request::segment(1) == 'delivery-person' ? 'waves-effect active' : ''}}"><i class="ti-user"></i><span> Delivery Person </span></a>
        </li> -->
        <li>
          <a href="{{route('discount.index')}}" class="{{Request::segment(1) == 'discount' ? 'waves-effect active' : ''}}"><i class="fas fa-percentage"></i><span> Discount </span></a>
        </li>

        <?php /*<li>
          <a href="{{route('food-menu-category.index')}}" class="waves-effect"><i class="ti-calendar"></i><span> Food Menu Category </span></a>
        </li>*/ ?>
        <li>
          <a href="{{route('calendar')}}" class="{{Request::segment(1) == 'calendar' ? 'waves-effect active' : ''}}"><i class="ti-calendar"></i><span> Table Booking </span></a>
        </li>
        <li>
          <a href="{{route('app-users')}}" class="{{Request::segment(1) == 'app-users' ? 'waves-effect active' : ''}}"><i class="ti-user"></i><span> Customers </span></a>
        </li>
        <li>
          <a href="{{route('order-report.index')}}" class="{{Request::segment(1) == 'order-report' ? 'active' : ''}}"><i class="ti-settings"></i><span>Order Report</span></a>
        </li>
        <li>
          <a href="{{route('subscription-details')}}" class="{{Request::segment(1) == 'subscription-details' ? 'active' : ''}}"><i class="ti-settings"></i><span>Subscription</span></a>
        </li>
        <li>
          <a href="{{route('weekTimeSet')}}" class="{{Request::segment(1) == 'week-time-set' ? 'active' : ''}}"><i class="ti-settings"></i><span>Week Schedule</span></a>
        </li>
        <li>
          <a href="{{route('notifications')}}" class="{{Request::segment(1) == 'notifications' ? 'active' : ''}}"><i class="fa fa-bell"></i><span>Notification</span></a>
        </li>
        <li>
          <a href="{{route('video-details')}}" class="{{Request::segment(1) == 'video-details' ? 'active' : ''}}"><i class="fas fa-hands-helping"></i><span>How to use</span></a>
        </li>
      </ul>
    </div>
    <div class="clearfix"></div>
  </div>
  <!-- end sidebarinner -->
</div>
<!-- Left Sidebar End -->