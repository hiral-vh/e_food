@extends('admin.master')
@section('title','Food-Category')
@section('css')
@endsection

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">

        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Form Validation</h4>
            </div>
        </div>

        <div class="page-content-wrapper ">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">

                            <div class="card-body">
                                <h4 class="m-t-0 m-b-30">Food Category</h4>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <h3 class="header-title m-t-0"><small class="text-primary"><b>Food Category Edit</b></small></h3>

                                        <div class="m-t-20">
                                            {!! Form::model($cuisine,['method' => 'PUT', 'route' => ['cuisine.update',$cuisine->id], 'files' => true,'id'=>'book-table-update']) !!}

                                            <div class="form-group">
                                                {!! Form::label('cuisine_name', 'Cuisine Name') !!}<span class="text-primary">*</span>
                                                {!! Form::text('cuisine_name', old('cuisine_name'), ['class' => 'form-control', 'placeholder' => 'Enter Cuisine Name ','id'=>'cuisine_name']) !!}
                                                <span class="cuisine-name-error text-primary"></span>
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
                    var cuisineName = $('#cuisine_name').val();
                    $('.cuisine-name-error').html("");

                    if (cuisineName == "") {
                        $('.cuisine-name-error').html("Please enter Cuisine name ");
                        temp++;
                    }

                    if (temp == 0) {
                        return true;
                    } else {
                        return false;
                    }

                }
            </script>
            @endsection