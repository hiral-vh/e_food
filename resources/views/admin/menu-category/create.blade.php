@extends('admin.master')
@section('title','Menu Category')
@section('css')
<style>
    #food-category-add input {
        width: 100%;
    }
</style>
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
                                <h4 class="m-t-0 m-b-30">Menu Category</h4>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <h3 class="header-title m-t-0"><small class="text-primary"><b>Menu Category Add</b></small></h3>

                                        <div class="m-t-20">
                                            {!! Form::open(['method' => 'POST', 'route' => ['menu-category.store'], 'files' => true,'id'=>'menu-category-table-add']) !!}

                                            <div class="form-group">
                                                {!! Form::label('title', 'Title') !!}<span class="text-primary">*</span>
                                                {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => 'Enter Title ','id'=>'title']) !!}
                                                <span class="title-error text-primary"></span>
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
                    var tableName = $('#title').val();

                    $('.title-error').html("");

                    if (tableName.trim() == "") {
                        $('.title-error').html("Please enter Title ");
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