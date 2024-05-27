<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login</title>`
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="<?php echo e(asset('favicon.png')); ?>">

    <link href="<?php echo e(asset('admin/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('admin/css/icons.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('admin/css/style.css')); ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('admin/css/toastr.min.css')); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <style>
        .changeEye {
            margin-left: -30px;
            cursor: pointer;
        }

        .eye-icon {
            position: absolute;
            top: 6px;
            right: 20px;
        }
    </style>
</head>


<body>

    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page">
        <div class="card card-pages">

            <div class="card-body">
                <div class="text-center m-t-0 m-b-15">
                    <img src="<?php echo e(asset('logo.png')); ?>" alt="" height="100">
                </div>
                <h4 class="text-muted text-center m-t-0"><b>Sign In</b></h4>

                <form action="<?php echo e(route('verify_login')); ?>" method="POST" autocomplete="off" id="loginForm">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <div class="col-12">
                            <input class="form-control" type="text" id="email" name="email" placeholder="Enter Email">
                            <span id="emailerror" style="color:red;"><span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-12 position-relative">
                            <input class="form-control position-relative" type="password" id="password" name="password" placeholder="Enter Password">
                            <i class="bi bi-eye-slash changeEye eye-icon" id="togglePassword"></i>
                            <span id="passworderror" style="color:red;"><span>
                        </div>
                    </div>



                    <div class="form-group text-center m-t-40">
                        <div class="col-12">
                            <button id="signInbtn" class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Sign In</button>
                        </div>
                    </div>

                    <div class="form-group row m-t-30 m-b-0">
                        <div class="col-sm-7">
                            <a href="<?php echo e(route('password.request')); ?>" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                        </div>
                        <div class="col-sm-5 text-right">
                            <a href="<?php echo e(route('register-owner')); ?>" class="text-muted">Create an account</a>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>



    <!-- jQuery  -->
    <script src="<?php echo e(asset('admin/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/modernizr.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/detect.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/fastclick.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/jquery.slimscroll.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/jquery.blockUI.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/waves.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/jquery.nicescroll.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/jquery.scrollTo.min.js')); ?>"></script>

    <script src="<?php echo e(asset('admin/js/app.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/toastr.min.js')); ?>"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <script>
        function ValidateEmail(email) {
            var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            return expr.test(email);
        }

        
        $("#signInbtn").prop('disabled', false);
        $('#signInbtn').click(function(e){
            var temp = 0;
            var email = $("#email").val();
            var password = $("#password").val();
            if (email.trim() == "") {
                $('#emailerror').html("Please enter Email");
                temp++;
            } else if (!ValidateEmail(email)) {
                $('#emailerror').html("Please enter valid Email");
                temp++;
            } else {
                $('#emailerror').html("");
            }

            if (password.trim() == '') {
                $("#passworderror").html("Please enter Password");
                temp++;
            } else {
                $("#passworderror").html("");
            }

            if (temp == 0) {                
                $("#signInbtn").prop('disabled', true);                
                $("#loginForm").submit();                
                // $.ajax({
                //         url: '<?php echo e(url("verify-login")); ?>',
                //         type: 'POST',
                //         data : {_token : '<?php echo e(csrf_token()); ?>',email:email,password:password},
                //         dataType: 'JSON',
                //             success:function(response){
                //                 initFirebaseMessagingRegistration(response);
                //             },
                //             error: function(err) {
                           
                //             }
                //     });
            } else {
                return false;
            }
        });

         //token update
        function initFirebaseMessagingRegistration(sendData) {
        var firebaseConfig = {
            apiKey: "AIzaSyD2g5YhnYOP39NmDMuneGzVEODLBDgzDsY",
            authDomain: "food-services-696c0.firebaseapp.com",
            projectId: "food-services-696c0",
            storageBucket: "food-services-696c0.appspot.com",
            messagingSenderId: "691422152161",
            appId: "1:691422152161:web:607d5fa187705eac51fea0",
            measurementId: "G-474F1FL5KE"
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
            messaging
                .requestPermission()

                .then(function() {
                    return messaging.getToken()
                })
                .then(function(token) {
                    //console.log(token);
                    //console.log('here');
                    $.ajax({
                        url : '<?php echo e(route("save-token")); ?>',
                        type : 'POST',
                        data : {device_token: token },
                        success:function(response){
                            if(sendData.status == '1')
                                {
                                    window.location.href = sendData.route;
                                   
                                }else{
                                    window.location.href = sendData.route;
                                }
                        }
                    });

            }).catch(function(err) {

                console.log('User Chat Token Errorsss' + err);
            });
        }
    </script>

    <?php if(Session::has('success')): ?>
    <script>
        Command: toastr["success"]('<?php echo Session::get('success') ?>')
    </script>
    <?php endif; ?>

    <?php if(Session::has('error')): ?>
    <script>
        Command: toastr["error"]('<?php echo Session::get('error') ?>')
    </script>
    <?php endif; ?>

    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function() {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);

            // toggle the icon
            this.classList.toggle("bi-eye");
        });
    </script>
</body>

</html><?php /**PATH C:\xampp\htdocs\e_food\resources\views/auth/login.blade.php ENDPATH**/ ?>