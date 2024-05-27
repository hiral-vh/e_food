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
                                            {!! Form::model($category,['method' => 'PUT', 'route' => ['food-category.update',$category->id], 'files' => true,'id'=>'category-update']) !!}

                                            <div class="form-group">
                                                {!! Form::label('food_category_name', 'Category Name') !!}<span class="text-danger">*</span>
                                                {!! Form::text('food_category_name', old('food_category_name'), ['class' => 'form-control', 'placeholder' => 'Enter Title','id'=>'title']) !!}
                                                <span class="text-primary">@error ('food_category_name') {{$message}}@enderror</span>
                                                <span class="name-error text-primary"></span>
                                            </div>

                                            <div class="form-group">

                                                <div>
                                                    {!! Form::label('food_category_image', 'Image') !!}<span class="text-danger">*</span>
                                                    {!! Form::file('food_category_image', old('food_category_image'), ['class' => 'form-control','id'=>'image']) !!}
                                                    <div class="img-fluid" style="display: inline-block;text-align: center;"><img src="{{ asset($category->food_category_image) }}" class="img-fluid setimg" height="50px" width="50px"></div>

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
                    var name = $('#food_category_name').val();



                    $('.title-error').html("");

                    if (name == "") {
                        $('.name-error').html("Please enter Food category name ");
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