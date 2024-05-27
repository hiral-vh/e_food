<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Forgot password</title>
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

<style>
    .forgot-text {
        padding: 0px 15px 13px;
        font-size: 14px;
    }
</style>

<body>

    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page">
        <div class="card card-pages">

            <div class="card-body">
                <div class="text-center m-t-0 m-b-15">
                    <img src="{{asset('logo.png')}}" alt="" height="100">
                </div>
                <div class="forgot-text">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                </div>
                <form method="POST" action="{{ url('forgotverify-email') }}" autocomplete="off" onsubmit="return validate()">
                    @csrf

                    <div class="form-group">
                        <div class="col-12">
                            <input class="form-control" type="text" id="email" name="email" placeholder="Enter Email">
                            <span id="emailerror" style="color:red;"><span>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-40">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Email Password Reset Link</button>
                        </div>
                    </div>

                    <div class="form-group row m-t-30 m-b-0">
                        <div class="col-sm-7">
                            <a href="{{ route('login') }}" class="text-muted"> back to login</a>
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
        function ValidateEmail(email) {
            var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            return expr.test(email);
        }

        function validate() {
            var temp = 0;
            var email = $("#email").val();
            if (email.trim() == "") {
                $('#emailerror').html("Please enter Email");
                temp++;
            } else if (!ValidateEmail(email)) {
                $('#emailerror').html("Please enter valid Email");
                temp++;
            } else {
                $('#emailerror').html("");
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