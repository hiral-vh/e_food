@extends('admin.master')
@section('title','Discount Create')
@section('css')
<link href="{{ asset('admin/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<style>
    #food-menu-add {
        width: 100%;
    }

    .input-daterange input {
        text-align: left;
    }
</style>
@endsection

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">

        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Discount</h4>
            </div>
        </div>

        <div class="page-content-wrapper ">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">



                            <div class="card-body">


                                <div class="row">
                                    <div class="col-sm-12">
                                        <h3 class="header-title m-t-0"><small class="text-primary"><b>Discount Edit</b></small></h3>

                                        <div class="m-t-20">
                                            {!! Form::model($menuEdit,['method' => 'PUT', 'route' => ['discount.update',$menuEdit->id], 'autocomplete' => 'off','files' => true,'id'=>'category-update']) !!}

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('discount_name', 'Discount Name') !!}<span class="text-primary">*</span>
                                                    {!! Form::text('discount_name', old('discount_name'), ['class' => 'form-control', 'placeholder' => 'Enter Discount Name','id'=>'discount_name']) !!}
                                                    <span class="text-primary">@error ('discount_name') {{$message}}@enderror</span>
                                                    <span id="discount_nameerror" class="name-error text-primary"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('discount_code', 'Discount Code') !!}<span class="text-primary">*</span>
                                                    {!! Form::text('discount_code', old('discount_code'), ['class' => 'form-control', 'placeholder' => 'Enter Discount Code','id'=>'discount_code']) !!}
                                                    <span class="text-primary">@error ('discount_code') {{$message}}@enderror</span>
                                                    <span id="discount_codeerror" class="name-error text-primary"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('discount_type', 'Discount Type') !!}<span class="text-primary">*</span>
                                                    {!! Form::select('discount_type', [null => 'Select Discount Type','Amount' => 'Amount','Percentage' => 'Percentage'],old('discount_type'), ['class' => 'form-control','id'=>'discount_type','onchange' => "divShowHide(this.value)"]) !!}
                                                    <span class="text-primary">@error ('discount_type') {{$message}}@enderror</span>
                                                    <span id="discount_typeerror" class="image-error text-primary"></span>
                                                </div>
                                            </div>
                                            @php if($menuEdit->discount_type == 'Amount'){
                                            $divShowstatusamount = 'block';
                                            $divShowstatuspercentage = 'none';
                                            }else{
                                            $divShowstatusamount = 'none';
                                            $divShowstatuspercentage = 'block';
                                            }

                                            @endphp
                                            <div class="col-md-12" id="discount_percentageDiv" style="display:{{$divShowstatuspercentage}};">
                                                <div class="form-group">
                                                    {!! Form::label('discount_percentage', 'Discount Percentage') !!}<span class="text-primary">*</span>
                                                    {!! Form::text('discount_percentage', old('discount_percentage'), ['class' => 'form-control number','placeholder' => 'Enter Discount Percentage','id'=>'discount_percentage']) !!}
                                                    <span class="text-primary">@error ('discount_percentage') {{$message}}@enderror</span>
                                                    <span id="discount_percentageerror" class="image-error text-primary"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12" id="discount_amountDiv" style="display:{{$divShowstatusamount}};">
                                                <div class="form-group">
                                                    {!! Form::label('discount_amount', 'Discount Amount') !!}<span class="text-primary">*</span>
                                                    {!! Form::text('discount_amount', $menuEdit->discount_percentage, ['class' => 'form-control number','placeholder' => 'Enter Discount Amount','id'=>'discount_amount','maxlength' => "5"]) !!}
                                                    <span class="text-primary">@error ('discount_percentage') {{$message}}@enderror</span>
                                                    <span id="discount_amounterror" class="image-error text-primary"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('discount_start_date', 'Date Range') !!}<span class="text-primary">*</span>
                                                    <div class="input-daterange input-group" id="date-range">
                                                        <input type="text" id="discount_start_date" class="form-control" value='{{$menuEdit->discount_start_date !="" ? date("d-m-Y",strtotime($menuEdit->discount_start_date)) : "N/A"}}' name="discount_start_date" placeholder="Discount Start Date" />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text bg-primary text-white b-0">to</span>
                                                        </div>
                                                        <input type="text" id="discount_end_date" class="form-control" placeholder="Discount End Date" name="discount_end_date" value='{{$menuEdit->discount_end_date !="" ? date("d-m-Y",strtotime($menuEdit->discount_end_date)) : "N/A"}}' />
                                                    </div>
                                                    <span class="text-primary">@error ('discount_percentage') {{$message}}@enderror</span>
                                                    <span id="daterangeerror" class="image-error text-primary"></span>
                                                </div>
                                                </div>



                                                <div class="form-group">
                                                    <div>
                                                        <button type="submit" onclick="return validation();" class="btn btn-primary waves-effect waves-light">
                                                            Submit
                                                        </button>

                                                    </div>
                                                </div>
                                                {!! Form::close() !!}


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
                            var regex = /(?:\d*\.\d{1,2}|\d+)$/;
                            var discount_name = $("#discount_name").val();
                            var discount_code = $("#discount_code").val();
                            var discount_percentage = $("#discount_percentage").val();
                            var discount_start_date = $("#discount_start_date").val();
                            var discount_end_date = $("#discount_end_date").val();
                            var discount_type = $("#discount_type").val();
                            var discount_amount = $("#discount_amount").val();
                            var temp = 0;

                            if (discount_name.trim() == '') {
                                $("#discount_nameerror").html("Please enter Discount Name");
                                temp++;
                            } else {
                                $.ajax({
                                    async: false,
                                    global: false,
                                    url: "<?php echo URL::to('/'); ?>/check_discount_name",
                                    type: "POST",
                                    data: {
                                        discount_name: discount_name,
                                        id: "{{$menuEdit->id}}",
                                        _token: "<?php echo csrf_token(); ?>"
                                    },
                                    success: function(response) {

                                        if (response == 1) {
                                            $('#discount_nameerror').html("");
                                        } else {
                                            $('#discount_nameerror').html("Discount Name is already exist");
                                            temp++;
                                        }
                                    }
                                });

                            }
                            if (discount_code == '') {
                                $("#discount_codeerror").html("Please enter Discount Code");
                                temp++;
                            } else {
                                $.ajax({
                                    async: false,
                                    global: false,
                                    url: "<?php echo URL::to('/'); ?>/check_discount_code",
                                    type: "POST",
                                    data: {
                                        discount_code: discount_code,
                                        id: "{{$menuEdit->id}}",
                                        _token: "<?php echo csrf_token(); ?>"
                                    },
                                    success: function(response) {

                                        if (response == 1) {
                                            $('#discount_codeerror').html("");
                                        } else {
                                            $('#discount_codeerror').html("Discount Code is already exist");
                                            temp++;
                                        }
                                    }
                                });
                            }
                            if (discount_type == '') {
                                $("#discount_typeerror").html("Please select Discount Type");
                                temp++;
                            } else {
                                $("#discount_typeerror").html("");
                            }
                            if (discount_type == 'Percentage') {
                                if (discount_percentage == '') {
                                    $("#discount_percentageerror").html("Please enter Discount Percentage");
                                    temp++;
                                } else {
                                    if (discount_percentage < 1 || discount_percentage > 99) {
                                        $("#discount_percentageerror").html("Please enter valid Discount Percentage");
                                        temp++;
                                    } else {
                                        $("#discount_percentageerror").html("");
                                    }

                                }
                            } else {
                                if (discount_amount == '') {
                                    $("#discount_amounterror").html("Please enter Discount Amount");
                                    temp++;
                                } else {
                                    if (regex.test(discount_amount)) {
                                        $("#discount_amounterror").html("");
                                    } else {
                                        $("#discount_amounterror").html("Please enter valid Discount Amount");
                                        temp++;
                                    }
                                }
                            }

                            if (discount_start_date == '' && discount_end_date == '') {
                                $("#daterangeerror").html("Please enter Discount Start Date and End DatPlease enter Discount Start Date and Discount End Date");
                                temp++;
                            } else {
                                $("#daterangeerror").html("");
                            }
                            if (temp == 0) {
                                $("#category-update").submit();
                                return true;
                            } else {
                                return false;
                            }
                        }
                    </script>
                    <script src="{{asset('admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
                    <script>
                        jQuery('#date-range').datepicker({
                            toggleActive: true,
                            format: "dd-mm-yyyy",
                            startDate: '-0m',
                            todayHighlight: 'TRUE',
                            autoclose: true,
                        });
                    </script>
                    <script>
                        function divShowHide(val) {

                            if (val == 'Amount') {
                                $("#discount_amountDiv").css('display', 'block');
                                $("#discount_percentageDiv").css('display', 'none');
                            } else if (val == 'Percentage') {
                                $("#discount_percentageDiv").css('display', 'block');
                                $("#discount_amountDiv").css('display', 'none');
                            } else {
                                $("#discount_amountDiv").css('display', 'none');
                                $("#discount_percentageDiv").css('display', 'none');
                            }
                        }
                    </script>

                    @endsection