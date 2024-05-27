<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Set password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{asset('favicon.png')}}">

    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('admin/css/toastr.min.css') }}">

</head>


<body>

    <!-- <body data-layout="horizontal"> -->

    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page">
        <div class="card card-pages">

            <div class="card-body">
                <div class="text-center m-t-0 m-b-15">
                    <img src="{{asset('logo.png')}}" alt="" height="100">
                </div>
                <h4 class="text-muted text-center m-t-0"><b>Sign In</b></h4>

                <form action="<?php echo URL::to('/') ?>/reset_password/<?php echo $otp; ?>" onsubmit="return validation1();" method="post" class="form">
                    @csrf

                    <div class="form-group">
                        <div class="col-12">
                            <input class="form-control" type="password" id="password" name="password" placeholder="Enter Password">
                            <span class="error" id='new_password_error'></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-12">
                            <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password">
                            <span class="error" id='confirm_password_error'></span>
                        </div>
                    </div>



                    <div class="form-group text-center m-t-40">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">CONTINUE</button>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('password.request') }}" class="btn btn-transparent w-100 waves-effect waves-light" type="submit">CANCEL</a>
                        </div>
                    </div>


                </form>
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
    <script>
        function validation1() {
            var temp = 0;
            var new_password = $('#new_password').val();
            var confirm_password = $('#confirm_password').val();


            $('#new_password_error').html(" ");
            $('#confirm_password_error').html(" ");


            if (new_password.trim() == '') {
                $('#new_password_error').html("Please enter Password");
                cnt = 1;
            }
            if (new_password != '') {
                if (new_password.length < 6) {
                    $('#new_password_error').html("Password atleast 6 character allowed");
                    temp++;
                }
            }
            if (confirm_password.trim() == '') {
                $('#confirm_password_error').html("Please enter Confirm Password");
                temp++;
            } else {
                if (new_password != confirm_password) {
                    $('#confirm_password_error').html("Password and Confirm Password does not match");
                    temp++;
                } else {
                    $('#confirm_password_error').html("");
                }
            }


            if (temp == 0) {
                return true;
            } else {
                return false;
            }


        }
    </script>
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

</body>




</html>