@extends('admin.master')
@section('title','Profile')
@section('css')
<style>
    #food-menu-add {
        width: 100%;
    }

    .input-group-append {
        height: 40px;
        margin-top: 15px;
    }

    .text-danger {
        color: red !important;
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

    .select2-container--default .select2-selection--single {
        background-color: #fafafa !important;
        border: 1px solid #f4f7Fa !important;
        border-radius: 4px !important;
        height: 36px !important;
    }

    .select2-container--default .select2-selection--multiple {
        background-color: #fafafa !important;
        border: 1px solid #f4f7Fa !important;
        border-radius: 4px !important;
        height: 36px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #6c757d !important;
        line-height: 37px !important;
    }

    .bootstrap-timepicker-widget table td input {
        width: 45px !important;
    }
</style>
<link href="{{ asset('admin/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('admin/plugins/select2/css/select2.min.css')}}">
@endsection
@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">

        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Profile</h4>
            </div>
        </div>

        <div class="page-content-wrapper ">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- <div class="row">
                                    <div class="col-sm-6"> -->
                                <h3 class="header-title m-t-0"><small class="text-primary"><b>Profile Update</b></small></h3>

                                <div class="m-t-20">

                                    {!! Form::model($userdata, ['method' => 'PUT', 'route' => ['profile.update', $userdata->id],'files' => true,'id'=>'profile-add','onsubmit'=>'return validate();' ]) !!}

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                {!! Form::label('name', 'Restaurant Name') !!}<span class="text-danger">*</span>
                                                {!! Form::text('restaurant_name', $userdata->restaurant_name, ['class' => 'form-control', 'placeholder' => 'Restaurant Name','id'=>'restaurant_name']) !!}
                                                <span class="text-primary">@error ('restaurant_nameerror') {{$message}}@enderror</span>
                                                <span id="restaurant_nameerror" style="color:red;"><span>
                                                        <span class="name-error text-primary"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">

                                                {!! Form::label('name', 'Owner Name') !!}<span class="text-danger">*</span>
                                                {!! Form::text('owner_name', old('name'), ['class' => 'form-control txtOnly', 'placeholder' => 'Owner Name','id'=>'owner_name']) !!}
                                                <span class="text-primary">@error ('owner_nameerror') {{$message}}@enderror</span>
                                                <span id="owner_nameerror" style="color:red;"><span>
                                                        <span class="name-error text-primary"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                {!! Form::label('name', 'Business Contact Number') !!}<span class="text-danger">*</span>
                                                {!! Form::text('business_number', old('name'), ['class' => 'form-control only-numeric', 'placeholder' => 'Business Number','id'=>'business_number' ,'maxlength'=>"10"]) !!}
                                                <span class="text-primary">@error ('business_numbererror') {{$message}}@enderror</span>
                                                <span id="business_numbererror" style="color:red;"><span>
                                                        <span class="name-error text-primary"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Email') !!}<span class="text-danger">*</span>
                                                {!! Form::text('email', old('name'), ['class' => 'form-control', 'placeholder' => 'Email','id'=>'email']) !!}
                                                <span class="text-primary">@error ('emailerror') {{$message}}@enderror</span>
                                                <span id="emailerror" style="color:red;"><span>
                                                        <span class="name-error text-primary"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- rest doc and image -->
                                    <div class="row">
                                        <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('restaurant_document', 'Restaurant Document') !!}

                                                {!! Form::file('restaurant_document', old('restaurant_document'), ['class' => 'form-control','id'=>'restaurant_document']) !!}

                                                @if(isset(Auth::user()->restaurant_document))
                                                <a href="{{asset('/')}}{{Auth::user()->restaurant_document}}" target="_blank">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                @endif
                                                <span class="text-primary">@error ('restaurant_document') {{$message}}@enderror</span>
                                                <br />
                                                <span id="restaurant_documenterror" style="color:red;"></span>
                                                <input type="hidden" id="restaurant_documentold" value="{{Auth::user()->restaurant_document}}" />
                                            </div>
                                        </div> -->


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('restaurant_image', 'Restaurant Image') !!}

                                                {!! Form::file('restaurant_image', ['class' => 'form-control', 'id' => 'restaurant_image','onchange'=>"preview(),validateSize(this)"]) !!}

                                                <img style="max-width: 50%; height: 50px;    width: 11%;" src="{{asset('/')}}{{Auth::user()->restaurant_image}}" onerror="this.onerror=null;this.src='{{asset("admin/images/users/avatar-1.jpg")}}';" alt="" id="output" class="rounded-circle img-thumbnail">


                                                <span class="text-primary">@error ('restaurant_imageerror') {{$message}}@enderror</span>
                                                <br />
                                                <span id="restaurant_imageerror" style="color:red;"></span>



                                                <input type="hidden" id="restaurant_imageold" value="{{Auth::user()->restaurant_image}}" />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- rest doc and image -->

                                    <!-- about us -->

                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'About Us') !!}<span class="text-danger">*</span>
                                                {!! Form::textarea('restaurant_aboutus',null,['class'=>'form-control', 'rows' => 2, 'cols' => 40,'id'=>'aboutus','placeholder' => "About Us"]) !!}
                                                <span class="text-primary">@error ('aboutuserror') {{$message}}@enderror</span>
                                                <span id="aboutuserror" style="color:red;"><span>
                                                        <span class="name-error text-primary"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- about us -->


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Street ') !!}<span class="text-danger">*</span>
                                                {!! Form::text('street', old('name'), ['class' => 'form-control', 'placeholder' => 'Street ','id'=>'street']) !!}
                                                <span class="text-primary">@error ('streeterror') {{$message}}@enderror</span>
                                                <span id="streeterror" style="color:red;"><span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'City ') !!}<span class="text-danger">*</span>
                                                {!! Form::text('city', old('name'), ['class' => 'form-control', 'placeholder' => 'City ','id'=>'city']) !!}
                                                <span class="text-primary">@error ('cityerror') {{$message}}@enderror</span>
                                                <span id="cityerror" style="color:red;"><span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                {!! Form::label('name', 'Phone') !!}<span class="text-danger">*</span>
                                                <input type="hidden" id="country_code" name="country_code" value="{{$userdata->country_code}}" />

                                                {!! Form::text('phone_no', "+".$userdata->country_code, ['class' => 'form-control only-numeric', 'placeholder' => 'Phone','id'=>'phone_no']) !!}
                                                <span id="mobileerror" style="color:red;"></span>
                                                <span class="name-error text-primary"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Address Line 1') !!}<span class="text-danger">*</span>
                                                {!! Form::text('address', old('name'), ['class' => 'form-control', 'placeholder' => 'Address Line 1','id'=>'address']) !!}
                                                <span class="text-primary">@error ('addresserror') {{$message}}@enderror</span>
                                                <span id="addresserror" style="color:red;"><span>
                                                        <span class="name-error text-primary"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display:none;" id="divLocation"></div>
                                    <input type="hidden" value="{{$userdata->restaurant_latitude}}" name="restaurant_latitude" id="flat" />
                                    <input type="hidden" value="{{$userdata->restaurant_longitude}}" name="restaurant_longitude" id="flng" />
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                {!! Form::label('name', 'Address Line 2 ') !!}
                                                {!! Form::text('addresslinetwo', old('name'), ['class' => 'form-control', 'placeholder' => 'Address Line 2 ','id'=>'addresslinetwo']) !!}
                                                <span class="text-primary">@error ('addresslinetwoerror') {{$message}}@enderror</span>
                                                <span id="addresslinetwoerror" style="color:red;"><span>
                                                        <span class="name-error text-primary"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Postcode') !!}
                                                {!! Form::text('pincode', old('name'), ['class' => 'form-control', 'placeholder' => 'Postcode','id'=>'pincode']) !!}
                                                <span class="text-primary">@error ('pincodeoerror') {{$message}}@enderror</span>
                                                <span id="pincodeoerror" style="color:red;"><span>
                                                        <span class="name-error text-primary"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                {!! Form::label('name', 'Restaurant Open Time') !!}<span class="text-danger">*</span>
                                                {!! Form::text('restaurant_open_time', $userdata->restaurant_open_time, ['class' => 'form-control', 'placeholder' => 'Restaurant Open Time','id'=>'starttime']) !!}
                                                <span class="text-primary">@error ('starttimeerror') {{$message}}@enderror</span>
                                                <span id="starttimeerror" style="color:red;"><span>
                                                        <span class="name-error text-primary"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Restaurant Close Time') !!}<span class="text-danger">*</span>
                                                {!! Form::text('restaurant_close_time', $userdata->restaurant_close_time, ['class' => 'form-control', 'placeholder' => 'Restaurant Close Time','id'=>'endtime']) !!}
                                                <span class="text-primary">@error ('endtimeerror') {{$message}}@enderror</span>
                                                <span id="endtimeerror" style="color:red;"><span>
                                                        <span class="name-error text-primary"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Restaurant Cusine<span style="color:red">*</span></label>
                                                <select id="cuisine_id" name="cuisine_id" class="form-control select2">
                                                    <option value="">Select Cusine</option>
                                                    @if(count($crusineData) > 0)
                                                    @foreach($crusineData as $ckey)
                                                    <option value="{{$ckey->id}}" @if($ckey->id == $userdata->cuisine_id) @php echo 'selected'; @endphp @endif>{{$ckey->cuisine_name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <?php /*<input class="form-control" type="text" id="cuisine_id" name="cuisine_id" value="{{$crusineData->cuisine_name}}" placeholder="Enter Restaurant Cuisine"> */ ?>

                                                <span id="cuisine_iderror" style="color:red;"><span>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                {!! Form::label('android_url', 'Android URL') !!}<span class="text-danger">*</span>
                                                {!! Form::text('android_url', $geturldata->android_url, ['class' => 'form-control', 'placeholder' => 'Android URL','id'=>'android_url']) !!}

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('ios_url', 'IOS URL') !!}<span class="text-danger">*</span>
                                                {!! Form::text('ios_url', $geturldata->ios_url, ['class' => 'form-control', 'placeholder' => 'IOS URL','id'=>'ios_url']) !!}

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                {!! Form::label('stripe_pk_key', 'Stripe Public Key') !!}<span class="text-danger">*</span>
                                                {!! Form::text('stripe_pk_key', $geturldata->stripe_pk_key, ['class' => 'form-control', 'placeholder' => 'Stripe Public Key','id'=>'stripe_pk_key']) !!}

                                                <span id="stripe_pk_keyerror" style="color:red;"><span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('stripe_sk_key', 'Stripe Secret Key') !!}<span class="text-danger">*</span>
                                                {!! Form::text('stripe_sk_key', $geturldata->stripe_sk_key, ['class' => 'form-control', 'placeholder' => 'Stripe Secret Key','id'=>'stripe_sk_key']) !!}

                                                <span id="stripe_sk_keyerror" style="color:red;"><span>
                                            </div>
                                        </div>
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
                            <!-- end row -->
                        </div>
                    </div>


                    <!-- end row -->

                </div><!-- container-fluid -->

                <!-- Modal show when strip key null -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Stripe Key</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{route('strip-key-update')}}" id="setStripKeys" method="post" autocomplete="off">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Stripe Public Key<span class="text-danger">*</span></label>
                                        <input type="text" name='strip_pk' id="strip_pk" class="form-control" placeholder="Enter Stripe Public Key">
                                        <span id="stripe_pk_error" style="color:red;"><span>
                                    </div>
                                    <div class="form-group">
                                        <label>Stripe Secret Key<span class="text-danger">*</span></label>
                                        <input type="text" name="strip_sk" id="strip_sk" class="form-control" placeholder="Enter Stripe Secret Key">
                                        <span id="stripe_sk_error" style="color:red;"><span>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="stripValidate">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end modal -->

                @endsection

                @section('js')
                <script src="{{asset('admin/plugins/select2/js/select2.min.js')}} "></script>
                <script src="{{asset('admin/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}"></script>
                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.7/js/intlTelInput.js"></script>
                <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/css/intlTelInput.css">
                <script src="{{asset('admin/plugins/timepicker/bootstrap-timepicker.js')}}"></script>


                <script>
                    $('#starttime').timepicker({
                        defaultTIme: false
                    });

                    $('#endtime').timepicker({
                        defaultTIme: false
                    });
                </script>

                <script>
                    $(window).on('load', function() {
                        var strip_pk = $('#stripe_pk_key').val();
                        var strip_sk = $('#stripe_sk_key').val();
                        if (strip_pk == '' || strip_sk == '') {
                            $('#exampleModal').modal('show');
                        }
                    });
                    let checkAPIKeyComplete = false;
                    let isValidAPIKey = false;

                    $(document).ready(function() {
                        $("#stripValidate").click(function() {
                            var stripe_pk_keyUpdate = $('#strip_pk').val();
                            var stripe_sk_keyUpdate = $('#strip_sk').val();
                            var temps = 0;

                            if (stripe_pk_keyUpdate.trim() == '') {
                                temps++;
                                $("#stripe_pk_error").html("Please enter Stripe Public Key");
                            } else {
                                Stripe.setPublishableKey(stripe_pk_keyUpdate);
                                Stripe.createToken({}, function(status, response) {
                                    checkAPIKeyComplete = true;
                                    if (status == 401) {
                                        temps++;
                                        $("#stripe_pk_error").html("Please enter valid Stripe Public Key");
                                    } else {
                                        isValidAPIKey = true;
                                        $("#stripe_pk_error").html("");
                                    }
                                });

                            }

                            if (stripe_sk_keyUpdate.trim() == '') {
                                temps++;
                                $("#stripe_sk_error").html("Please enter Stripe Secret Key");
                            } else {
                                $("#stripe_sk_error").html("");
                            }

                            if (temps == 0) {
                                setTimeout(() => {
                                    if (checkAPIKeyComplete && isValidAPIKey)
                                        $("#setStripKeys").submit();
                                    else
                                        checkForm();
                                }, 1000);
                            } else {
                                return false;
                            }
                        });
                    });
                </script>



                <script>
                    function ValidateEmail(email) {
                        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                        return expr.test(email);
                    }

                    function validate() {
                        var temp = 0;
                        var restaurant_name = $("#restaurant_name").val();
                        var owner_name = $("#owner_name").val();
                        var business_number = $("#business_number").val();
                        var email = $("#email").val();
                        var phone_no = $("#phone_no").val();
                        var address = $("#address").val();

                        var starttime = $('#starttime').val();
                        var endtime = $('#endtime').val();

                        var restaurant_imageold = $('#restaurant_imageold').val();
                        var restaurant_image = $('#restaurant_image').val();
                        var restaurant_image_pic = restaurant_image.split(/\\/);
                        // var restaurant_document = $('#restaurant_document').val();
                        // var restaurant_documentold = $('#restaurant_documentold').val();
                        // var restaurant_document_pic = restaurant_document.split(/\\/);
                        var aboutus = $("#aboutus").val();
                        var city = $('#city').val();
                        var street = $('#street').val();
                        var stripe_pk_key = $('#stripe_pk_key').val();
                        var stripe_sk_key = $('#stripe_sk_key').val();



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
                            $('#business_numbererror').html("Please enter Bussiness Contact Number");
                            temp++;
                        } else if (!business_number.match(number)) {
                            $('#business_numbererror').html("Must input numbers");
                            temp++;
                        } else {
                            $('#business_numbererror').html("");
                        }

                        if (email.trim() == "") {
                            $('#emailerror').html("Please enter Email");
                            temp++;
                        } else if (!ValidateEmail(email)) {
                            $('#emailerror').html("Invalid Email");
                            temp++;
                        } else {
                            $.ajax({
                                async: false,
                                global: false,
                                url: "{{ URL::to('/')}}/check_admin_register_email",
                                type: "POST",
                                data: {
                                    email: email,
                                    id: '{{$userdata->id}}',
                                    _token: "{{ csrf_token()}}"
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
                        // images and pdf 


                        // if (restaurant_documentold == '') {
                        //     if (restaurant_document_pic[2] == "" || restaurant_document == "") {
                        //         temp++;
                        //         $("#restaurant_documenterror").html("Please upload Restaurant Document");
                        //     } else {
                        //         ext = restaurant_document_pic[2].split(".");
                        //         if (ext[1].toUpperCase() == "DOC" || ext[1].toUpperCase() == "DOCX" || ext[1].toUpperCase() == "PDF") {
                        //             $("#restaurant_documenterror").html("");
                        //         } else {
                        //             temp++;
                        //             $("#restaurant_documenterror").html("File must Image!! Like: DOC, DOCX, and PDF");
                        //         }

                        //     }
                        // }
                        if (restaurant_imageold == '') {
                            if (restaurant_image_pic[2] == "" || restaurant_image == "") {
                                temp++;
                                $("#restaurant_imageerror").html("Please upload Restaurant Image");
                            } else {
                                ext = restaurant_image_pic[2].split(".");
                                if (ext[1].toUpperCase() == "PNG" || ext[1].toUpperCase() == "JPG" || ext[1].toUpperCase() == "JPEG" || ext[1].toUpperCase() == "BMP") {
                                    $("#restaurant_imageerror").html("");
                                } else {
                                    temp++;
                                    $("#restaurant_imageerror").html("File must Image!! Like: PNG, JPG, JPEG and BMP");
                                }

                            }
                        }


                        // images and pdf

                        // about us
                        if (aboutus.trim() == '') {
                            $('#aboutuserror').html("Please enter aboutus");
                            temp++;
                        } else {
                            $('#aboutuserror').html("");
                        }
                        // about us

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


                        if (phone_no.trim() == '') {
                            $("#mobileerror").removeClass("hide");
                            $("#mobileerror").addClass("show");
                            $("#mobileerror").html("Please enter Phone");
                            temp++;
                        } else if (mobileerror != '') {
                            $("#mobileerror").removeClass("hide");
                            $("#mobileerror").addClass("show");
                            $('#mobileerror').html("Invalid Phone");
                            temp++;
                        } else {

                            $.ajax({
                                async: false,
                                global: false,
                                url: "{{ URL::to('/')}}/check_admin_register_mobile",
                                type: "POST",
                                data: {
                                    mobile: phone_no,
                                    id: '{{$userdata->id}}',
                                    _token: "{{ csrf_token()}}"
                                },
                                success: function(response) {
                                    if (response == 1) {
                                        $('#mobileerror').html("");
                                    } else {
                                        $("#mobileerror").removeClass("hide");
                                        $("#mobileerror").addClass("show");
                                        $('#mobileerror').html("Mobile is already exist");
                                        temp++;
                                    }
                                }
                            });

                        }


                        if (address.trim() == '') {
                            $("#addresserror").html("Please enter Address Line 1");
                            temp++;
                        } else {
                            $("#addresserror").html("");
                        }




                        if (starttime.trim() == '') {
                            $("#starttimeerror").html("Please select restaurant open time");
                            temp++;
                        } else {
                            $("#starttimeerror").html("");
                        }

                        if (endtime.trim() == '') {
                            $("#endtimeerror").html("Please select restaurant close time");
                            temp++;
                        } else {
                            if (starttime.trim() == endtime.trim()) {
                                $("#endtimeerror").html("Please select another restaurant Close Time");
                                temp++;
                            } else {
                                $("#endtimeerror").html("");
                            }
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

                        if (stripe_pk_key.trim() == '') {
                            $("#stripe_pk_keyerror").html("Please enter Stripe Public Key");
                            temp++;
                        } else {
                            Stripe.setPublishableKey(stripe_pk_key);
                            Stripe.createToken({}, function(status, response) {
                                if (status == 401) {
                                    $("#stripe_pk_keyerror").html("Please enter valid Stripe Public Key");
                                    temp++;
                                } else {
                                    $("#stripe_pk_keyerror").html("");
                                }
                            });

                        }

                        if (stripe_sk_key.trim() == '') {
                            $("#stripe_sk_keyerror").html("Please enter Stripe Secret Key");
                            temp++;
                        } else {
                            $("#stripe_sk_keyerror").html("");
                        }

                        if (temp == 0) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                </script>
                <!-- validations -->

                <!-- phone -->
                <script>
                    setTimeout(function() {
                        $("#phone_no").val('<?= $userdata->phone_no ?>');
                    }, 500);


                    // Country code with phone number
                    var telInput = $("#phone_no"),
                        errorMsg = $("#mobileerror").html(''),
                        validMsg = $("#valid-msg");
                    errorMsg.addClass("hide");
                    telInput.intlTelInput({
                        preferredCountries: ['sg'],
                        separateDialCode: true,
                        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
                    });
                    var reset = function() {

                        telInput.removeClass("error");
                        errorMsg.addClass("hide");
                        validMsg.addClass("hide");
                    };

                    // on blur: validate
                    telInput.blur(function() {
                        reset();
                        if ($.trim(telInput.val())) {
                            if (telInput.intlTelInput("isValidNumber")) {
                                console.log("if");
                                validMsg.removeClass("hide");
                                var getCode = telInput.intlTelInput('getSelectedCountryData').dialCode;
                                $('#phone_code').val(getCode);
                                $("#mobileerror").html("");
                            } else {
                                console.log("else");
                                //telInput.addClass("error");
                                errorMsg.removeClass("hide");
                                $("#mobileerror").html('Invalid Phone');
                                temp++;
                            }
                        }
                    });
                </script>
                <script>
                    function preview() {
                        output.src = URL.createObjectURL(event.target.files[0]);
                    }
                </script>
                <!-- phone -->

                <script>
                    $.noConflict();
                    $(function() {
                        //Initialize Select2 Elements
                        $('.select2').select2();
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

                    function validateSize(input) {
                        const fileSize = input.files[0].size / 1024 / 1024; // in MiB
                        if (fileSize > 2) {
                            alert('File size exceeds 2 MiB');
                            $("#restaurant_image").val('');
                            $("#output").attr('src', '');
                        }
                    }


                    $('#restaurant_image').on("change", function() {
                        if ($(this).val() != '') {
                            var fileExtension = ['jpeg', 'jpg', 'png'];
                            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                                document.getElementById("fileUpload").value = '';
                                alert("Only .jpeg, .jpg, .png formats are allowed.");
                            }
                        }

                    })
                </script>
                <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

                @endsection