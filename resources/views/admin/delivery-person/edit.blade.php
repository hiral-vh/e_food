@extends('admin.master')
@section('title','Delivery-Person')
@section('css')
<style>
    #food-category-add input {
        width: 100%;
    }

    .iti-sdc-3 {
        width: 100% !important;
    }

    .hide {
        display: none;
    }

    #country_code+.intl-tel-input {
        width: 100% !important;
    }
</style>
@endsection

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">

        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Delivery Person</h4>
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
                                        <h3 class="header-title m-t-0"><small class="text-primary"><b>Delivery Person Edit</b></small></h3>

                                        <div class="m-t-20">
                                            {!! Form::model($category,['method' => 'PUT', 'route' => ['delivery-person.update',$category->id], 'files' => true,'id'=>'category-update','onsubmit' => "return validation()"]) !!}

                                            <div class="form-group">
                                                {!! Form::label('delivery_person_name', 'Delivery Person Name') !!}<span class="text-primary">*</span>
                                                {!! Form::text('delivery_person_name', old('delivery_person_name'), ['class' => 'form-control txtOnly', 'placeholder' => 'Enter Delivery Person Name','id'=>'delivery_person_name','maxlength' => "50"]) !!}
                                                <span class="text-primary">@error ('delivery_person_name') {{$message}}@enderror</span>
                                                <span id="delivery_person_name_error" class="text-primary"></span>
                                            </div>

                                            <div class="form-group">
                                                {!! Form::label('delivery_person_email', 'Delivery Person Email') !!}<span class="text-primary">*</span>
                                                {!! Form::text('delivery_person_email', old('delivery_person_email'), ['class' => 'form-control', 'placeholder' => 'Enter Delivery Person Email','id'=>'delivery_person_email']) !!}
                                                <span class="text-primary">@error ('delivery_person_email') {{$message}}@enderror</span>
                                                <span id="delivery_person_email_error" class="text-primary"></span>
                                            </div>
                                            @php
                                            $newEx = explode("+", $category->delivery_person_country_code);

                                            if ($newEx[0] == "+") {
                                            $newCode = $category->delivery_person_country_code;
                                            } else {
                                            $newCode = "+" . $category->delivery_person_country_code;
                                            } @endphp
                                            <div class="form-group">
                                                {!! Form::label('delivery_person_mobile', 'Delivery Person Mobile') !!}<span class="text-primary">*</span>
                                                <input type="hidden" id="country_code" value="{{$category->delivery_person_country_code}}" name="delivery_person_country_code" />

                                                {!! Form::text('delivery_person_mobile', $newCode, ['class' => 'form-control only-numeric', 'placeholder' => 'Enter Delivery Person Mobile','id'=>'phone_no']) !!}

                                                <span id="phoneerror" class="text-primary"></span>
                                                <span class="text-primary" id="mobileerror"></span>
                                            </div>

                                            <div class="form-group">
                                                <div>
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
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
                function ValidateEmail(email) {
                    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                    return expr.test(email);
                }

                function ValidateEmailfirstChar(email) {
                    var specialChar = /[^A-Za-z0-9]+/;
                    return specialChar.test(email);
                }

                function validation() {
                    var temp = 0;
                    var delivery_person_name = $('#delivery_person_name').val();
                    var delivery_person_email = $('#delivery_person_email').val();
                    var phone_no = $('#phone_no').val();
                    var mobileerror = $("#mobileerror").html();

                    if (delivery_person_name.trim() == "") {
                        $('#delivery_person_name_error').html("Please enter Delivery Person Name");
                        temp++;
                    } else {
                        $('#delivery_person_name_error').html("");
                    }


                    if (delivery_person_email.trim() == "") {
                        $('#delivery_person_email_error').html("Please enter Delivery Person Email");
                        temp++;
                    } else if (!ValidateEmail(delivery_person_email)) {
                        $('#delivery_person_email_error').html("Please enter valid Delivery Person Email");
                        temp++;
                    } else {

                        var firstLetter = $("#delivery_person_email").val().charAt(0);

                        if (ValidateEmailfirstChar(firstLetter)) {
                            $('#delivery_person_email_error').html("Please enter valid Delivery Person Email");
                            temp++;
                        } else {
                            $.ajax({
                                async: false,
                                global: false,
                                url: "<?php echo URL::to('/'); ?>/check_deliveryperson_register_email",
                                type: "POST",
                                data: {
                                    delivery_person_email: delivery_person_email,
                                    id: '{{$category->id}}',
                                    _token: "<?php echo csrf_token(); ?>"
                                },
                                success: function(response) {

                                    if (response == 1) {
                                        $('#delivery_person_email_error').html("");
                                    } else {
                                        $('#delivery_person_email_error').html("Delivery Person Email is already exist");
                                        temp++;
                                    }
                                }
                            });
                        }
                    }

                    if (phone_no == "") {
                        $('#phoneerror').html("Please enter Delivery Person Mobile");
                        temp++;
                    } else {
                        $.ajax({
                            async: false,
                            global: false,
                            url: "<?php echo URL::to('/'); ?>/check_deliveryperson_register_phone",
                            type: "POST",
                            data: {
                                phone_no: phone_no,
                                id: '{{$category->id}}',
                                _token: "<?php echo csrf_token(); ?>"
                            },
                            success: function(response) {

                                if (response == 1) {
                                    $('#phoneerror').html("");
                                } else {
                                    $('#phoneerror').html("Delivery Person Mobile is already exist");
                                    temp++;
                                }
                            }
                        });
                    }

                    if (mobileerror != '') {
                        $('#phoneerror').html("Please enter valid Delivery Person Mobile");
                        temp++;
                    }


                    if (temp == 0) {

                        return true;
                    } else {
                        return false;
                    }

                }
            </script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.7/js/intlTelInput.js"></script>
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/css/intlTelInput.css">

            <script>
                var telInput = $("#phone_no"),
                    errorMsg = $("#mobileerror").html('Please enter valid Delivery Person Mobile'),
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
                            $("#mobileerror").html('Please enter valid Delivery Person Mobile');
                            $("#phoneerror").html('');
                        }
                    }
                });

                setTimeout(function() {
                    var ccode = '<?= $category->delivery_person_country_code ?>';
                    var mobno = '<?= $category->delivery_person_mobile ?>';
                    var newString = mobno.replace(ccode, '');
                    var newString1 = newString.replace('+', '');
                    $("#phone_no").val(newString1.trim());
                }, 500);
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

                $('#delivery_person_name').on("cut copy paste", function(e) {
                    e.preventDefault();
                });
            </script>
            @endsection