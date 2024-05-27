@extends('admin.master')
@section('title','Food-Category Create')
@section('css')
<style>
    #food-menu-category-add {
        width: 100%;
    }

    .input-group-append {
        height: 40px;
        margin-top: 15px;
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
                                <h4 class="m-t-0 m-b-30">Food Menu Category</h4>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <h3 class="header-title m-t-0"><small class="text-primary"><b>Food Menu Category Add</b></small></h3>

                                        <div class="m-t-20">
                                            {!! Form::open(['method' => 'POST', 'files' => true ,'route' => ['food-menu-category.store'],'id'=>'food-menu-category-add']) !!}

                                            <div class="form-group">
                                                {!! Form::label('name', 'Category Name') !!}<span class="text-danger">*</span>
                                                {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Enter Food Category Name','id'=>'name']) !!}
                                                <span class="text-primary">@error ('name') {{$message}}@enderror</span>
                                                <span class="name-error text-primary"></span>
                                            </div>

                                            <h3 class="header-title m-t-0"><small class="text-primary"><b>Food Menu Sub Category Add</b></small></h3>
                                            <div class="row" id="appendrow">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        {!! Form::label('name', 'Category Name') !!}<span class="text-danger">*</span>
                                                        {!! Form::text('subcategory_name[]', old('subcategory_name'), ['class' => 'form-control', 'placeholder' => 'Enter Food Category Name','id'=>'subcategory_name']) !!}
                                                        <span class="text-primary">@error ('name') {{$message}}@enderror</span>
                                                        <span class="name-error text-primary"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        {!! Form::label('image', 'Image') !!}<span class="text-danger">*</span>
                                                        {!! Form::file('image[]', old('image'), ['id'=>'image','class' => 'form-control', 'placeholder' => 'Enter image','multiple' => true]) !!}
                                                        <span class="text-primary">@error ('image') {{$message}}@enderror</span>
                                                        <span class="name-error text-primary"></span>
                                                    </div>
                                                </div>
                                                <span class="input-group-btn input-group-append" id="multipleRow"><button class="btn btn-primary bootstrap-touchspin-up" type="button">+</button></span>
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
                    // function validation() {
                    // //     var temp = 0;
                    //     var name = $('#name').val();



                    //     $('.name-error').html("");

                    //     if (name == "") {
                    //         $('.name-error').html("Please enter Food Menu category name ");
                    //         temp++;
                    //     }


                    //     if (temp == 0) {
                    //         return true;
                    //     } else {
                    //         return false;
                    //     }

                    // }
                </script>
                <script>
                    $('#removerow').hide();
                    // $(document).on('click', '#multipleRow', function() {
                    //     var div = $("<tr class='add_row_tt' />");
                    //     div.html(GetDynamicTextBox());
                    //     $("#appendrow").append(div);
                    // });


                    // $(document).on('click', '#removerow', function() {
                    //     $(this).closest("#appendrow").remove();
                    // });



                    var i = 1;
                    $(function() {
                        $("#multipleRow").bind("click", function() {
                            var div = $("<tr class='row add_row_tt' />");
                            div.html(GetDynamicTextBox());
                            $("#appendrow").append(div);
                            // $('div select.myselect2').select2();
                            // $(".myselect2").select2("destroy").select2();
                            i++;
                        });
                        $("#appendrow").on("click", ".remove_row", function() {
                            $(this).closest("tr").remove();
                        });
                    });

                    function GetDynamicTextBox() {
                        return '<div class="col-md-5"> <div class="form-group">{!! Form::label("name", "Category Name") !!}<span class="text-danger">*</span>{!! Form::text("subcategory_name[]", old("subcategory_name"), ["class"=> "form-control", "placeholder"=> "Enter Food Category Name","id"=>"subcategory_name"]) !!}<span class="text-primary">@error ("name"){{$message}}@enderror</span> <span class="name-error text-primary"></span> </div></div><div class="col-md-5"> <div class="form-group">{!! Form::label("image", "Image") !!}<span class="text-danger">*</span>{!! Form::file("image[]", old("image"), ["id"=>"image","class"=> "form-control", "placeholder"=> "Enter image","multiple"=> true]) !!}<span class="text-primary">@error ("image"){{$message}}@enderror</span> <span class="name-error text-primary"></span> </div></div> <div><span class="input-group-btn input-group-append remove_row"><button class="btn btn-primary bootstrap-touchspin-up" type="button">-</button></span></div>';

                    }
                </script>


                @endsection