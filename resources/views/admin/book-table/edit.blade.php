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
                <h4 class="page-title">Table Number</h4>
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
                                        <h3 class="header-title m-t-0"><small class="text-primary"><b>Table Number Edit</b></small></h3>

                                        <div class="m-t-20">
                                            {!! Form::model($editTable,['method' => 'PUT', 'route' => ['table-number.update',$editTable->id], 'files' => true,'id'=>'book-table-update']) !!}

                                            <div class="form-group">
                                                {!! Form::label('table_name', 'Table Number') !!}<span class="text-primary">*</span>
                                                {!! Form::text('table_name', old('table_name'), ['class' => 'form-control', 'placeholder' => 'Enter Table Number','id'=>'table_name','maxlength' => "100"]) !!}
                                                <span class="table-name-error text-primary"></span>
                                            </div>

                                            <div class="form-group">
                                                {!! Form::label('number_of_people', 'Number of People') !!}<span class="text-primary">*</span>
                                                {!! Form::text('number_of_people', old('number_of_people'), ['class' => 'form-control only-numeric', 'placeholder' => 'Enter Number of People','id'=>'number_of_people','maxlength' => "2"]) !!}
                                                <span class="people-error text-primary"></span>
                                            </div>

                                            <div class="form-group">
                                                <div>
                                                    {!! Form::label('duration', 'Duration') !!} (In Minutes)<span class="text-primary">*</span>
                                                    {!! Form::text('duration', old('duration'), ['class' => 'form-control only-numeric','id'=>'duration' ,'maxlength' => "3"]) !!}
                                                    <span class="duration-error text-primary"></span>
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
                    var tableName = $('#table_name').val();
                    var numberOfPeople = $('#number_of_people').val();
                    var duration = $('#duration').val();


                    $('.table-name-error').html("");
                    $('.people-error').html("");
                    $('.duration-error').html("");

                    if (tableName.trim() == "") {
                        $('.table-name-error').html("Please enter Table Number");
                        temp++;
                    }

                    if (numberOfPeople == "") {
                        $('.people-error').html("Please enter Number of People");
                        temp++;
                    }

                    if (duration == "") {
                        $('.duration-error').html("Please enter Duration (In Minutes)");
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