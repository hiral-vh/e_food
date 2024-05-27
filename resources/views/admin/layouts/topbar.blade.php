 <!-- Top Bar Start -->
 <div class="topbar">
   <!-- LOGO -->
   <div class="topbar-left">
     <div class="text-center">
       <a href="javascript:void(0);" class="logo"><img src="{{asset('logo.png')}}" alt="" height="85"></a>
       <a href="javascript:void(0);" class="logo-sm"><img src="{{asset('favicon.png')}}" alt="" height="28"></a>
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
             <i class="fa fa-bell"></i> @if($unreadNotification !=0) <span class="badge badge-xs badge-danger"></span> @endif
           </a>
           <ul class="dropdown-menu dropdown-menu-lg">
             <li class="text-center notifi-title">Notification <span class="badge badge-xs badge-success">{{$unreadNotification}}</span></li>
             <li class="list-group">

               @forelse($notifications as $rwData)
               @if($rwData->data['type'] == 1)
               <a href="javascript:void(0);" class="dropdown-item notify-item mt-2">
                 <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>
                 <p class="notify-details">{{$rwData->data['message']}}<span class="text-muted">{{date('Y-m-d', strtotime($rwData->data['date&time']))}}</span></p>
               </a>
               @elseif($rwData->data['type'] == 3)
               <a href="javascript:void(0);" class="dropdown-item notify-item mt-2">
                 <div class="notify-icon bg-success"><i class="mdi mdi-message-text-outline"></i></div>
                 <p class="notify-details">{{$rwData->data['message']}}<span class="text-muted">{{date('Y-m-d', strtotime($rwData->data['date&time']))}}</span></p>
               </a>
               @elseif($rwData->data['type'] == 2)
               <a href="{{ route('order-report.show', $rwData->data['orderId']) }}" class="dropdown-item notify-item mt-2">
                 <div class="notify-icon bg-success"><i class="mdi mdi-message-text-outline"></i></div>
                 <p class="notify-details">{{$rwData->data['userName']}} {{$rwData->data['message']}}<span class="text-muted"></span></p>
               </a>
               @elseif($rwData->data['type'] == 4)
               <a href="javascript:void(0);" class="dropdown-item notify-item mt-2">
                 <div class="notify-icon bg-success"><i class="mdi mdi-message-text-outline"></i></div>
                 <p class="notify-details">{{$rwData->data['userName']}} {{$rwData->data['message']}} {{$rwData->data['tableName']}} {{$rwData->data['bookingDate']}}<span class="text-muted"></span></p>
               </a>
               @endif
               @empty
               <a href="javascript:void(0);" class="dropdown-item notify-item mt-2">
                 <center>
                   <p class="notify-details">Data not available<span class="text-muted"></span></p>
                 </center>
               </a>
               @endforelse
               <!-- last list item -->
               <a href="{{route('notifications')}}" class="list-group-item text-center">
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
             @if(isset(Auth::user()->restaurant_image))
             <img src="{{asset('/')}}{{Auth::user()->restaurant_image}}" alt="user-img" class="rounded-circle">
             @else
             <img src="{{asset('admin/images/users/avatar-1.jpg')}}" alt="user-img" class="rounded-circle">
             @endif
             <span class="profile-username">
               <span class="mdi mdi-chevron-down font-15"></span>
             </span>
           </a>
           <ul class="dropdown-menu">
             <li><a href="{{asset('/')}}profile" class="dropdown-item"> Profile</a></li>
             <li><a href="{{route('change-password')}}" class="dropdown-item"> Change Password</a></li>
             <li class="dropdown-divider"></li>
             <li><a href="{{route('logout')}}" class="dropdown-item"> Logout</a></li>
           </ul>
         </li>
       </ul>
     </div>
   </nav>
 </div>
 <!-- Top Bar End -->