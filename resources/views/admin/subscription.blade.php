<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Subscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="{{asset('favicon.png')}}">
    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('admin/css/toastr.min.css') }}">
    <link href="{{ asset('admin/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/carousel/owl.carousel.css')}}" rel="stylesheet">
    <style>
        /* Style the list */
        .price {
            list-style-type: none;
            /* border: 1px solid #eee; */
            margin: 0;
            padding: 0;
            -webkit-transition: 0.3s;
            transition: 0.3s;
            background: #fff;
            min-height: 519px;
        }

        /* Add shadows on hover */
        .price:hover {
            box-shadow: 0 8px 12px 0 rgba(0, 0, 0, 0.2)
        }

        /* Pricing header */
        .price .headermain {
            background-color: #111;
            color: white;
            font-size: 25px;
        }

        /* List items */
        .price li {

            padding: 10px;
            text-align: center;
            font-size: 15px;
        }

        /* Grey list item */
        .price .grey {
            font-size: 20px;
            padding: 40px 0 65px;
        }

        /* The "Sign Up" button */
        .button1 {
            background-color: #27c4b5;
            border: none;
            color: #fff !important;
            padding: 5px 25px;
            text-align: center;
            text-decoration: none;
            font-size: 17px;
        }

        .price .header-main {
            padding-top: 30px;
            padding-bottom: 60px;
            background: #27c4b5;
            position: relative;
        }

        .price li:nth-child(2) {
            padding-top: 60px;
        }

        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header-main p {
            font-size: 22px;
            font-weight: 900;
            color: #fff
        }

        .mh-88px {
            min-height: 88px;
        }

        /* .header-main:after {
            content: '';
            border-left: 39px solid transparent;
            border-right: 70px solid transparent;
            border-bottom: 73px solid #71778f;
            display: flex;
            position: absolute;
            top: 0;
            right: -39px;
            transform: rotate(180deg);
        } */

        .columns {
            position: relative;
            overflow: hidden;
            border-radius: 25px;
        }

        .price-round {
            font-size: 17px;
            background: #27c4b5;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-weight: 800;
            padding: 21px;
            bottom: -52px;
            width: 120px;
            height: 120px;
            position: absolute;
            border: 6px solid #fff;
        }

        /* .grey::before {
            content: '';
            border-left: 39px solid transparent;
            border-right: 70px solid transparent;
            border-bottom: 73px solid #71778f;
            display: flex;
            position: absolute;
            bottom: 0px;
            left: -39px;
            transform: rotate(1deg);
        } */

        /* .price-red .header-main:after {
            content: '';
            border-left: 39px solid transparent;
            border-right: 70px solid transparent;
            border-bottom: 73px solid #c12c4eab;
        } */

        .price-red .header-main .header .price-round {
            background: #d57288;
        }

        .price.price-red .header-main {
            background: #d57288;
        }

        .price.price-blue .header-main {
            background: #1579cf;
        }

        .price-red .header-main .header p {
            color: #fff;
        }

        .price-red li.grey .button1 {
            background: #d57288;
        }

        .price-red li.grey::before {
            border-bottom: 73px solid #d57288;
        }

        /* .price-blue .header-main:after {
            content: '';
            border-left: 39px solid transparent;
            border-right: 70px solid transparent;
            border-bottom: 73px solid #1579cf;
        } */

        .price-blue .header-main .header .price-round {
            background: #1579cf;
        }

        .price-blue .header-main .header p {
            color: #fff;
        }

        .price-blue li.grey .button1 {
            background: #1579cf;
        }

        .price-blue li.grey::before {
            border-bottom: 73px solid #1579cf;
        }

        .wrapper-page {
            width: 80% !important;
        }

        .cus-wrapper {
            margin: 0.5% auto !important;
        }

        .card-border {
            background: transparent;
            border: none !important;
        }

        .card {
            box-shadow: none !important;
        }

        .card-body {
            padding: 0px;
        }

        .subscription .owl-dots {
            display: flex;
            justify-content: center;
            padding-top: 20px;
        }

        .subscription .owl-dot {
            display: flex;
            background: #989494 !important;
            width: 11px;
            height: 11px;
            border-radius: 50%;
            margin: 0 7px;
        }

        .subscription .owl-dot.active {
            background: #3e445e !important;
        }
    </style>
</head>

<body>

    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page cus-wrapper">
        <div class="text-center m-t-0">
            <img src="{{asset('logo.png')}}" alt="" height="100">
        </div>
        <div class="card card-pages card-border ">

            <div class="card-body">
                <div class="owl-carousel owl-theme subscription mt-3">
                    <!-- <div class="row d-flex justify-content-center"> -->
                    @if(count($getAllsubscription) > 0)
                    @php $i=0; @endphp
                    @foreach($getAllsubscription as $key)
                    @php
                    $class = 'price';
                    if($i == 0){
                    $class= 'price';
                    }else if($i == 1){
                    $class= 'price price-red';
                    }else if($i == 2){
                    $class= 'price price-blue';
                    } @endphp
                    <div class="item">
                        <!-- <div class="col-sm-3 mt-3"> -->
                        <div class="columns">
                            <ul class="{{$class}}">
                                <li class="header-main">
                                    <div class="header">
                                        <p>{{$key->plan_name}}</p>
                                        <div class="price-round">$ {{$key->plan_price}} / Month</div>
                                    </div>
                                </li>
                                <li>{{$key->plan_duration}} Month</li>
                                <li>{{$key->allowed_order}} Allowed Order</li>
                                <li class="mh-88px">{{substr($key->plan_description, 0, 100)}}...</li>
                                <li class="grey"><a href="{{url('subscription-purchase')}}?id={{$key->id}}" class="button1">Select</a></li>
                            </ul>
                        </div>
                        <!-- </div> -->
                    </div>

                    @php $i++; @endphp
                    @endforeach
                    @endif

                </div>
            </div>

            <!-- <h4 class="text-muted text-center m-t-0"><b>Subscription</b></h4> -->

        </div>

    </div>
    </div>



    <!-- jQuery  -->
    <script src="{{asset('admin/js/jquery.min.js')}}"></script>
    <script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('admin/js/modernizr.min.js')}}"></script>
    <script src="{{asset('admin/js/detect.js')}}"></script>
    <script src="{{asset('admin/js/fastclick.js')}}"></script>
    <script src="{{asset('admin/js/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('admin/js/jquery.blockUI.js')}}"></script>
    <script src="{{asset('admin/js/waves.js')}}"></script>
    <script src="{{asset('admin/js/wow.min.js')}}"></script>
    <script src="{{asset('admin/js/jquery.nicescroll.js')}}"></script>
    <script src="{{asset('admin/js/jquery.scrollTo.min.js')}}"></script>

    <script src="{{asset('admin/js/app.js')}}"></script>
    <script src="{{asset('admin/js/toastr.min.js') }}"></script>
    <script src="{{asset('admin/plugins/timepicker/bootstrap-timepicker.js')}}"></script>
    <script src="{{asset('admin/plugins/carousel/owl.carousel.js')}}"></script>
    @if(Session::has('success'))
    <script>
        Command: toastr["success"]('<?php echo Session::get('success') ?>')
    </script>
    @endif

    @if(Session::has('error'))
    <script>
        Command: toastr["error"]('<?php echo Session::get('error') ?>')
    </script>
    @endif
    <script>
        $('.subscription').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,

                },
                600: {
                    items: 1,

                },
                1000: {
                    items: 4,
                    loop: false
                }
            }
        })
    </script>
</body>

</html>