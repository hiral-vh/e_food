<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="<?php echo e(asset('favicon.png')); ?>">
    <link href="<?php echo e(asset('admin/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('admin/css/icons.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('admin/css/style.css')); ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('admin/css/toastr.min.css')); ?>">
    <link href="<?php echo e(asset('admin/plugins/timepicker/bootstrap-timepicker.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/select2/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <style>
        .iti-sdc-3 {
            width: 100% !important;
        }

        .hide {
            display: none;
        }

        #country_code+.intl-tel-input {
            width: 100% !important;
        }

        .wrapper-page {
            width: 50% !important;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fafafa;
            border: 1px solid #f4f7Fa;
            border-radius: 4px;
            height: 36px;
        }

        .select2-container--default .select2-selection--multiple {
            background-color: #fafafa;
            border: 1px solid #f4f7Fa;
            border-radius: 4px;
            height: 36px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #6c757d;
            line-height: 37px;
        }

        .eye-icon {
            position: absolute;
            top: 33px;
            right: 20px;
        }

        .bootstrap-timepicker-widget table td input {
            width: 45px !important;
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
                <h4 class="text-muted text-center m-t-0"><b>Register</b></h4>

                <form method="POST" action="<?php echo e(url('verify-register')); ?>" autocomplete="off" onsubmit="return validate()" enctype="multipart/form-data" autocomplete="off">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Restaurant Name <span style="color:red">*</span></label>
                                <input class="form-control" type="text" id="restaurant_name" name="restaurant_name" placeholder="Enter Restaurant Name">
                                <span id="restaurant_nameerror" style="color:red;"><span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Owner Name <span style="color:red">*</span></label>
                                <input class="form-control txtOnly" type="text" id="owner_name" name="owner_name" placeholder="Enter Owner Name">
                                <span id="owner_nameerror" style="color:red;"><span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Business Contact Number <span style="color:red">*</span></label>
                                <input class="form-control" type="text" id="business_number" name="business_number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10" placeholder="Enter Business Contact  Number">
                                <span id="business_numbererror" style="color:red;"><span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email <span style="color:red">*</span></label>
                                <input class="form-control" type="text" id="email" name="email" placeholder="Enter Email">
                                <span id="emailerror" style="color:red;"><span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password <span style="color:red">*</span></label>
                                <input class="form-control" type="password" id="password" name="password" placeholder="Enter Password">
                                <i class="bi bi-eye-slash changeEye eye-icon" id="togglePassword"></i>
                                <span id="passworderror" style="color:red;"><span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirm Password <span style="color:red">*</span></label>
                                <input class="form-control" type="password" id="confirm_password" placeholder="Enter Confirm Password">
                                <i class="bi bi-eye-slash changeEye eye-icon" id="toggleConfirmPassword"></i>
                                <span id="confirm_passworderror" style="color:red;"><span>
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Address Line 1 <span style="color:red">*</span></label>
                                <input class="form-control" type="text" id="address" name="address" placeholder="Enter Address Line 1">
                                <span id="addresserror" style="color:red;"><span>
                            </div>
                        </div>
                    </div>
                    <div style="display:none;" id="divLocation"></div>
                    <input type="hidden" name="restaurant_latitude" id="flat" />
                    <input type="hidden" name="restaurant_longitude" id="flng" />
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Address Line 2 <span style="color:red">*</span></label>
                                <input class="form-control" type="text" id="addresslinetwo" name="addresslinetwo" placeholder="Enter Address Line 2">
                                <span id="addresslinetwoerror" style="color:red;"><span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Street <span style="color:red">*</span></label>
                                <input class="form-control" type="text" id="street" name="street" placeholder="Enter Street">
                                <span id="streeterror" style="color:red;"><span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>City <span style="color:red">*</span></label>
                                <input class="form-control" type="text" id="city" name="city" placeholder="Enter City">
                                <span id="cityerror" style="color:red;"><span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone <span style="color:red">*</span></label>
                                <input type="hidden" id="country_code" name="country_code" />
                                <input class="form-control" type="text" id="phone_no" name="phone_no" placeholder="Enter Phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                <span id="phoneerror" style="color:red;"></span>
                                <span style="color:red;" id="mobileerror"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Postcode </label>
                                <input class="form-control" type="text" id="pincode" name="pincode" placeholder="Enter Postcode">
                                <span id="pincodeoerror" style="color:red;"><span>
                            </div>
                        </div>
                    </div>



                    <!-- start time and end time -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Restaurant Open Time<span style="color:red">*</span></label>
                                <input class="form-control" onkeypress="return false;" type="text" id="starttime" name="starttime" placeholder="Enter Restaurant Open Time">
                                <span id="starttimeerror" style="color:red;"><span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Restaurant Close Time<span style="color:red">*</span></label>
                                <input class="form-control" onkeypress="return false;" type="text" id="endtime" name="endtime" placeholder="Enter Restaurant Close Time">
                                <span id="endtimeerror" style="color:red;"><span>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Restaurant Cuisine<span style="color:red">*</span></label>
                                <select id="cuisine_id" name="cuisine_id" class="form-control select2">
                                    <option value="">Select Cuisine</option>
                                    <?php if(count($crusineData) > 0): ?>
                                    <?php $__currentLoopData = $crusineData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ckey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($ckey->id); ?>"><?php echo e($ckey->cuisine_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                                <?php /*<input class="form-control" type="text" id="cuisine_id" name="cuisine_id" placeholder="Enter Restaurant Cuisine"> */ ?>

                                <span id="cuisine_iderror" style="color:red;"><span>
                            </div>
                        </div>



                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Restaurant Image<span style="color:red">*</span></label>
                                <input type="file" id="fileUpload" name="restaurant_image" class="filestyle" data-buttonname="btn-primary" onchange="validateSize(this)">
                                <span id="restaurant_imageerror" style="color:red;"><span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                        <input id="checkbox-signup" type="checkbox" id="terms_and_conditions"
                            name="terms_and_conditions">
                            <label for="checkbox-signup">
                            I accept  <a href="<?php echo e(route('terms-conditions')); ?>" target="_blank">Terms and Conditions &</a>
                                <a href="<?php echo e(route('privacy-policy')); ?>" target="_blank">Privacy&Policy and</a>
                                <a href="<?php echo e(route('cookies')); ?>" target="_blank">Cookies</a>
                            </label>
                            

                        </div>
                        <span id="terms_and_conditionserror" style="color:red;"><span>
                    </div>
                    <!-- start time and end time -->

                    <div class="form-group text-center m-t-40">
                        <div class="col-12">
                            <button id="registerBtn" class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Register</button>
                        </div>
                    </div>

                    <div class="form-group row m-t-30 m-b-0">
                        <div class="col-sm-7">
                            <a href="<?php echo e(route('login')); ?>" class="text-muted"><i class="fa fa-lock m-r-5"></i> Login?</a>
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
    <script src="<?php echo e(asset('admin/plugins/timepicker/bootstrap-timepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/plugins/select2/js/select2.min.js')); ?> "></script>
    <script src="<?php echo e(asset('admin/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')); ?>"></script>

    <script>
        $('#starttime').timepicker({
            defaultTIme: false
        });

        $('#endtime').timepicker({
            defaultTIme: false
        });

        function ValidateEmail(email) {
            var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            return expr.test(email);
        }

        function ValidateEmailfirstChar(email) {
            var specialChar = /[^A-Za-z0-9]+/;
            return specialChar.test(email);
        }

        function validate() {
            var temp = 0;

            var restaurant_name = $("#restaurant_name").val();
            var owner_name = $("#owner_name").val();
            var business_number = $("#business_number").val();
            var email = $("#email").val();
            var password = $("#password").val();
            var confirm_password = $("#confirm_password").val();
            var phone_no = $("#phone_no").val();
            var address = $("#address").val();
            var addresslinetwo = $("#addresslinetwo").val();
            var street = $("#street").val();
            var city = $("#city").val();
            var cuisine_id = $("#cuisine_id").val();
            var restaurant_image = $('#fileUpload').val();
            var restaurant_image_pic = restaurant_image.split(/\\/);
            var starttime = $('#starttime').val();
            var endtime = $('#endtime').val();

            var starttimeerror = $("#starttimeerror").html();
            var endtimeerror = $("#endtimeerror").html();
            let isChecked = $('input[name=terms_and_conditions]:checked').val();



            var mobileerror = $("#mobileerror").html();
            if (restaurant_name.trim() == '') {
                $('#restaurant_nameerror').html("Please enter Restaurant Name");
                temp++;
            } else {
                $('#restaurant_nameerror').html("");
            }
            if (owner_name.trim() == '') {
                $('#owner_nameerror').html("Please enter Owner Name");
                temp++;
            } else {
                $('#owner_nameerror').html("");
            }
            var number = /^[0-9]+$/;

            $('#business_numbererror').html("");
            if (business_number.trim() == '') {
                $('#business_numbererror').html("Please enter Business Contact  Number");
                temp++;
            } else if (!business_number.match(number)) {
                $('#business_numbererror').html("Please enter only number in Business Contact Number");
                temp++;
            } else {
                $.ajax({
                    async: false,
                    global: false,
                    url: "<?php echo URL::to('/'); ?>/check_owner_register_business_number",
                    type: "POST",
                    data: {
                        business_number: business_number,
                        _token: "<?php echo csrf_token(); ?>"
                    },
                    success: function(response) {

                        if (response == 1) {
                            $('#business_numbererror').html("");
                        } else {
                            $('#business_numbererror').html("Business Number is already exist");
                            temp++;
                        }
                    }
                });
            }

            if (email.trim() == "") {
                $('#emailerror').html("Please enter Email");
                temp++;
            } else if (!ValidateEmail(email)) {
                $('#emailerror').html("Please enter valid Email");
                temp++;
            } else {

                var firstLetter = $("#email").val().charAt(0);

                if (ValidateEmailfirstChar(firstLetter)) {
                    $('#emailerror').html("Please enter valid Email");
                    temp++;
                } else {

                    $.ajax({
                        async: false,
                        global: false,
                        url: "<?php echo URL::to('/'); ?>/check_owner_register_email",
                        type: "POST",
                        data: {
                            email: email,
                            _token: "<?php echo csrf_token(); ?>"
                        },
                        success: function(response) {

                            if (response == 1) {
                                $('#emailerror').html("");
                            } else {
                                $('#emailerror').html("Email is already exist");
                                temp++;
                            }
                        }
                    });
                }


            }
            if (password.trim() == '') {
                $("#passworderror").html("Please enter Password");
                temp++;
            } else {
                if (password.length < 6) {
                    $('#passworderror').html("Please enter minimum 6 letter or number");
                    temp++;
                } else {
                    $("#passworderror").html("");
                }

            }
            if (confirm_password.trim() == '') {
                $("#confirm_passworderror").html("Please enter Confirm Password");
                temp++;
            } else {
                if (password != confirm_password) {
                    $("#confirm_passworderror").html("Confirm Password must be the same as the Password");
                    temp++;
                } else {
                    $("#confirm_passworderror").html("");
                }

            }

            if (phone_no.trim() == '') {
                $("#phoneerror").html("Please enter Phone");
                temp++;
            } else {
                if (mobileerror != '') {
                    temp++;
                } else {
                    $.ajax({
                        async: false,
                        global: false,
                        url: "<?php echo URL::to('/'); ?>/check_owner_register_phone",
                        type: "POST",
                        data: {
                            phone_no: phone_no,
                            _token: "<?php echo csrf_token(); ?>"
                        },
                        success: function(response) {

                            if (response == 1) {
                                $('#phoneerror').html("");
                            } else {
                                $('#phoneerror').html("Phone is already exist");
                                temp++;
                            }
                        }
                    });
                }

            }

            if (address.trim() == '') {
                $("#addresserror").html("Please enter Address Line 1");
                temp++;
            } else {
                $("#addresserror").html("");
            }

            if (addresslinetwo.trim() == '') {
                $("#addresslinetwoerror").html("Please enter Address Line 2");
                temp++;
            } else {
                $("#addresslinetwoerror").html("");
            }

            if (street.trim() == '') {
                $("#streeterror").html("Please enter Street");
                temp++;
            } else {
                $("#streeterror").html("");
            }

            if (city.trim() == '') {
                $("#cityerror").html("Please enter City");
                temp++;
            } else {
                $("#cityerror").html("");
            }
            if (cuisine_id == '') {
                $("#cuisine_iderror").html("Please select Cuisine");
                temp++;
            } else {
                $("#cuisine_iderror").html("");
            }

            if (starttime.trim() == '') {
                $("#starttimeerror").html("Please select Restaurant Open Time");
                temp++;
            } else {
                $("#starttimeerror").html("");
            }

            if (endtime.trim() == '') {
                $("#endtimeerror").html("Please select Restaurant Close Time");
                temp++;
            } else {
                if (starttime.trim() == endtime.trim()) {
                    $("#endtimeerror").html("Please select another Restaurant Close Time");
                    temp++;
                } else {
                    $("#endtimeerror").html("");
                }

            }

            if (isChecked != "on") {
                $('#terms_and_conditionserror').html('Please accept Terms and Conditions');
                temp++;
            } else {
                $('#terms_and_conditionserror').html('');
            }


            var timefrom = new Date();
            timestart = $('#starttime').val().split(":");
            timefrom.setHours((parseInt(timestart[0]) - 1 + 24) % 24);
            timefrom.setMinutes(parseInt(timestart[1]));

            var timeto = new Date();
            timestart = $('#endtime').val().split(":");
            timeto.setHours((parseInt(timestart[0]) - 1 + 24) % 24);
            timeto.setMinutes(parseInt(timestart[1]));

            //convert both time into timestamp
            var stt = new Date("November 13, 2013 " + starttime);
            stt = stt.getTime();

            var endt = new Date("November 13, 2013 " + endtime);
            endt = endt.getTime();


            if (stt > endt) {
                $("#endtimeerror").html("Restaurant close time should be greater than restaurant open time");
                temp++;
            } else {
                $("#endtimeerror").html("");
            }

            if (restaurant_image == "") {
                temp++;
                $("#restaurant_imageerror").html("Please upload Restaurant Image");
            } else {
                var regex = new RegExp("(.*?)\.(jpg|png|jpeg|JPG|PNG|JPEG|svg|SVG)$");
                if (!(regex.test(restaurant_image))) {
                    temp++;
                    $('#restaurant_imageerror').html("File must Image!! Like: JPG, JPEG, PNG and SVG");
                   
                } else {
                    $('#restaurant_imageerror').html("");
                }
            }

            // if (restaurant_image_pic[2] == "" || restaurant_image == "") {
            //     temp++;
            //     $("#restaurant_imageerror").html("Please upload Restaurant Image");
            // } else {
            //     ext = restaurant_image_pic[2].split(".");
            //     if (ext[1].toUpperCase() == "PNG" || ext[1].toUpperCase() == "JPG" || ext[1].toUpperCase() == "JPEG") {
            //         $("#restaurant_imageerror").html("");
            //     } else {
            //         temp++;
            //         $("#restaurant_imageerror").html("File must Image!! Like: PNG, JPG, JPEG");
            //     }

            // }

            if (temp == 0) {
                return true;
            } else {
                return false;
            }
        }

        function validateSize(input) {
            const fileSize = input.files[0].size / 1024 / 1024; // in MiB
            if (fileSize > 2) {
                alert('File size exceeds 2 MiB');
                $("#fileUpload").val('');
            }
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

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.7/js/intlTelInput.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/css/intlTelInput.css">

    <script>
        var telInput = $("#phone_no"),
            errorMsg = $("#mobileerror").html('Please enter valid Phone'),
            validMsg = $("#valid-msg");
        errorMsg.addClass("hide");
        telInput.intlTelInput({
            preferredCountries: ['us'],
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
        });

        var reset = function() {
            telInput.removeClass("error");
            errorMsg.addClass("hide");
            validMsg.addClass("hide");
        };
        telInput.blur(function() {

            reset();
            if ($.trim(telInput.val())) {
                if (telInput.intlTelInput("isValidNumber")) {
                    validMsg.removeClass("hide");
                    var getCode = telInput.intlTelInput('getSelectedCountryData').dialCode;
                    $('#country_code').val(getCode);
                    $("#mobileerror").html("");
                    $("#phoneerror").html("");
                } else {

                    //telInput.addClass("error");
                    errorMsg.removeClass("hide");
                    $("#mobileerror").html('Please enter valid Phone');
                    $("#phoneerror").html('');
                }
            }
        });
    </script>
    <script>
        $.noConflict();
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>
    <script>
        $('#fileUpload').on("change", function() {
            if ($(this).val() != '') {
                var fileExtension = ['jpeg', 'jpg', 'png'];
                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    document.getElementById("fileUpload").value = '';
                    alert("Only .jpeg, .jpg, .png formats are allowed.");
                }
            }

        })
    </script>
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");


        const toggletoggleConfirmPasswordPassword = document.querySelector("#toggleConfirmPassword");
        const confirm_password = document.querySelector("#confirm_password");

        togglePassword.addEventListener("click", function() {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);

            // toggle the icon
            this.classList.toggle("bi-eye");
        });

        toggleConfirmPassword.addEventListener("click", function() {
            // toggle the type attribute
            const type = confirm_password.getAttribute("type") === "password" ? "text" : "password";
            confirm_password.setAttribute("type", type);

            // toggle the icon
            this.classList.toggle("bi-eye");
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".txtOnly").keypress(function(e) {
                var key = e.keyCode;
                if (key >= 48 && key <= 57) {
                    e.preventDefault();
                }
            });
        });

        $('#owner_name').on("cut copy paste", function(e) {
            e.preventDefault();
        });
    </script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwr1n4QpMo-f6fjd8THMLRyqrFk7iZcA8&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
    <script>
        function initAutocomplete() {

            var address = document.getElementById('address');
            var autocomplete = new google.maps.places.Autocomplete(address);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                var htmldiv = $("#divLocation").html(place.adr_address);
                var to_aadress_short = place.name;
                var to_aadress_full = place.formatted_address;
                var locality = $(".locality").html();
                var country_name = $(".country-name").html();
                var postcode = $(".postal-code").html();
                $("#address").val(to_aadress_full);
                $("#city").val(locality);
                $("#pincode").val(postcode);

                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();
                document.getElementById('flat').value = latitude;
                document.getElementById('flng').value = longitude;
            });
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".txtOnly").keypress(function(e) {
                var key = e.keyCode;
                if (key >= 48 && key <= 57) {
                    e.preventDefault();
                }
            });
        });

        $('#owner_name').on("cut copy paste", function(e) {
            e.preventDefault();
        });
    </script>

</body>

</html><?php /**PATH C:\xampp\htdocs\e_food\resources\views/auth/register.blade.php ENDPATH**/ ?>