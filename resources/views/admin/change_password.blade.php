@extends('admin.master')
@section('title','Change-Password')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
<style>
    #food-category-add input {
        width: 100%;
    }

    .eye-icon1 {
        position: absolute;
        top: 86px;
        right: 20px;
    }

    .eye-icon2 {
        position: absolute;
        top: 166px;
        right: 20px;
    }

    .eye-icon3 {
        position: absolute;
        top: 248px;
        right: 20px;
    }
</style>

@endsection

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">

        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Change Password</h4>
            </div>
        </div>

        <div class="page-content-wrapper ">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h3 class="header-title m-t-0"><small class="text-primary"><b>Password Update</b></small></h3>

                                        <div class="m-t-20">
                                            {!! Form::open(['method' => 'POST', 'route' => ['update_password'], 'files' => true,'id'=>'book-table-add']) !!}

                                            <div class="form-group">
                                                {!! Form::label('password', 'Current Password') !!}<span class="text-primary">*</span>
                                                {!! Form::password('current_password', ['class' => 'awesome form-control','placeholder' => 'Enter Current Password','id' => 'current_password']); !!}
                                                <i class="bi bi-eye-slash changeEye eye-icon1" id="togglePassword"></i>
                                                <span class="password-error text-primary"></span>
                                            </div>

                                            <div class="form-group">
                                                {!! Form::label('new_password', 'New Password') !!}<span class="text-primary">*</span>
                                                {!! Form::password('new_password', ['class' => 'awesome form-control','placeholder' => 'Enter New Password','id' => 'new_password']); !!}
                                                <i class="bi bi-eye-slash changeEye eye-icon2" id="toggleConfirmPassword"></i>
                                                <span class="new-password-error text-primary"></span>
                                            </div>

                                            <div class="form-group">
                                                <div>
                                                    {!! Form::label('retype_password', 'Retype Password') !!}<span class="text-primary">*</span>
                                                    {!! Form::password('retype_password', ['class' => 'awesome form-control','placeholder' => 'Enter Retype Password','id' => 'retype_password']); !!}
                                                    <i class="bi bi-eye-slash changeEye eye-icon3" id="toggleREConfirmPassword"></i>
                                                    <span class="retype-passoerd-error text-primary"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div>
                                                    <button type="submit" onclick="return validation();" class="btn btn-primary waves-effect waves-light">
                                                        Update
                                                    </button>

                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- end row -->

            </div><!-- container-fluid -->


            @endsection
            @section('js')
            <script>
                function validation() {
                    var temp = 0;
                    var current_password = $('#current_password').val();
                    var new_password = $('#new_password').val();
                    var retype_password = $('#retype_password').val();


                    $('.password-error').html("");
                    $('.new-password-error').html("");
                    $('.retype-error').html("");

                    if (current_password.trim() == "") {
                        $('.password-error').html("Please enter Current Password");
                        temp++;
                    } else {
                        $.ajax({
                            async: false,
                            global: false,
                            url: "<?php echo URL::to('/'); ?>/checkResturentpassword",
                            type: "POST",
                            data: {
                                current_password: current_password,
                                _token: "<?php echo csrf_token(); ?>"
                            },
                            success: function(response) {

                                if (response == 1) {
                                    $('.password-error').html("");
                                } else {
                                    $('.password-error').html("Current Password does not match");
                                    temp++;
                                }
                            }
                        });
                    }

                    if (new_password.trim() == "") {
                        $('.new-password-error').html("Please enter New Password");
                        temp++;
                    } else {
                        if (new_password.length < 6) {
                            $('.new-password-error').html("Please enter minimum 6 letter or number");
                            temp++;
                        } else {
                            $('.new-password-error').html("");
                        }
                    }

                    if (retype_password.trim() == "") {
                        $('.retype-passoerd-error').html("Please enter Retype Password");
                        temp++;
                    } else {
                        if (new_password != retype_password) {
                            $('.retype-passoerd-error').html("Retype Password must be the same as the New Password");
                            temp++;
                        } else {
                            $('.retype-passoerd-error').html("");
                        }
                    }


                    if (temp == 0) {
                        return true;
                    } else {
                        return false;
                    }

                }
            </script>
            <script>
                const togglePassword = document.querySelector("#togglePassword");
                const password = document.querySelector("#current_password");


                const toggletoggleConfirmPasswordPassword = document.querySelector("#toggleConfirmPassword");
                const confirm_password = document.querySelector("#new_password");

                const toggletoggleReConfirmPasswordPassword = document.querySelector("#toggleREConfirmPassword");
                const retype_password = document.querySelector("#retype_password");

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

                toggletoggleReConfirmPasswordPassword.addEventListener("click", function() {
                    // toggle the type attribute
                    const type = retype_password.getAttribute("type") === "password" ? "text" : "password";
                    retype_password.setAttribute("type", type);

                    // toggle the icon
                    this.classList.toggle("bi-eye");
                });
            </script>

            @endsection