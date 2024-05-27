@extends('admin.master')
@section('title','Food-Category Create')
@section('css')
<style>
    #food-menu-add {
        width: 100%;
    }

    .input-group-append {
        height: 40px;
        margin-top: 15px;
    }

    .select2-container--default .select2-selection--single {
        background-color: #fafafa;
        border: 1px solid #f4f7Fa;
        border-radius: 4px;
        height: 36px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #6c757d;
        line-height: 37px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        top: 60% !important;
    }
</style>
@endsection

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">

        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Food Menu</h4>
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
                                        <h3 class="header-title m-t-0"><small class="text-primary"><b>Food Menu Add</b></small></h3>

                                        <div class="m-t-20">
                                            {!! Form::open(['method' => 'POST', 'files' => true ,'route' => ['food-menu.store'],'id'=>'food-menu-add']) !!}
                                            <div class="col-md-12">
                                                {{ Form::hidden('menu_category_id', $menu_category_id, array('id' => 'menu_category_id')) }}
                                                <div class="form-group">
                                                    {!! Form::label('category', 'Category') !!}<span class="text-primary">*</span>
                                                    <select class="form-control select2" id="category" name="category[]" multiple>
                                                        @foreach ($menuCategory as $value)
                                                        <option value="{{$value->id}}">{{$value->food_category_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="category_error" class="name-error text-primary"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('name', 'Item Name') !!}<span class="text-primary">*</span>
                                                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Enter Item Name','id'=>'name','maxlength' => "100"]) !!}
                                                    <span class="text-primary">@error ('name') {{$message}}@enderror</span>
                                                    <span id="nameerror" class="name-error text-primary"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('image', 'Image') !!}<span class="text-primary">*</span>
                                                    {!! Form::file('image', old('image'), ['class' => 'form-control','id'=>'image']) !!}
                                                    <br />
                                                    <span class="text-primary">@error ('image') {{$message}}@enderror</span>
                                                    <span id="imageerror" class="image-error text-primary"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('price', 'Price') !!} (&#163;)<span class="text-primary">*</span>
                                                    {!! Form::text('price', old('price'), ['class' => 'form-control number','placeholder' => 'Enter Price','id'=>'price', "maxlength" => '5']) !!}
                                                    <span class="text-primary">@error ('price') {{$message}}@enderror</span>
                                                    <span id="priceerror" class="image-error text-primary"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('description', 'Description') !!}<span class="text-primary">*</span>
                                                    {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'placeholder' => 'Enter Description','id'=>'description']) !!}
                                                    <p></p>
                                                    <span class="text-primary">@error ('description') {{$message}}@enderror</span>
                                                    <span id="description_error" class="name-error text-primary"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('is_attribute', 'Is Attribute') !!}<span class="text-primary">*</span>
                                                    {!! Form::radio('is_attribute', '0', true ,['onclick' => 'openAttributeDiv(0)']) !!} No
                                                    {!! Form::radio('is_attribute', '1',false ,['onclick' => 'openAttributeDiv(1)']) !!} Yes
                                                    <span class="text-primary">@error ('price') {{$message}}@enderror</span>
                                                    <span id="priceerror" class="image-error text-primary"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12" id="extraAttribute" style="display:none;">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::label('attribute_name', 'Variation Name') !!}<span class="text-primary">*</span>
                                                                {!! Form::text('', old('attribute_name'), ['class' => 'form-control', 'placeholder' => 'Enter Variation Name','maxlength'=>'25','id'=>'attribute_name']) !!}
                                                                <span id="attribute_nameerror" class="image-error text-primary"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::label('attribute_price', 'Variation Price') !!} (&#163;)<span class="text-primary">*</span>
                                                                {!! Form::text('', old('attribute_price'), ['class' => 'form-control number', 'placeholder' => 'Enter Variation Price','id'=>'attribute_price' , "maxlength" => '5']) !!}
                                                                <span id="attribute_priceerror" class="image-error text-primary"></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <button class="btn btn-success" type="button" onclick="return addAttributes();" style="margin-top: 31px;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <span id="attribute_error" class="image-error text-primary"></span>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <td><b>Variation Name</b></td>
                                                                            <td><b>Variation Price (&#163;)</b></td>
                                                                            <td><b>Action</b></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="bankDataadd">

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" id="extraItems" style="display:none;">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::label('item_name', 'Extra Items Name') !!}<span class="text-primary">*</span>
                                                                {!! Form::text('', old('item_name'), ['class' => 'form-control', 'placeholder' => 'Enter Item Name','maxlength'=>'25','id'=>'item_name']) !!}
                                                                <span id="item_nameerror" class="image-error text-primary"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::label('item_price', 'Extra Item Price') !!} (&#163;)<span class="text-primary">*</span>
                                                                {!! Form::text('', old('item_price'), ['class' => 'form-control number', 'placeholder' => 'Enter Item Price','id'=>'item_price' , "maxlength" => '5']) !!}
                                                                <span id="item_priceerror" class="image-error text-primary"></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <button class="btn btn-success" type="button" onclick="return addItems();" style="margin-top: 31px;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <span id="items_error" class="image-error text-primary"></span>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <td><b>Extra Item Name</b></td>
                                                                            <td><b>Extra Item Price (&#163;)</b></td>
                                                                            <td><b>Action</b></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="itemDataadd">

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12" id="removeIngredients" style="display:none;">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::label('ingredients_name', 'Removable Ingredients Name') !!}<span class="text-primary">*</span>
                                                                {!! Form::text('', old('ingredients_name'), ['class' => 'form-control', 'placeholder' => 'Enter Ingredients Name','maxlength'=>'25','id'=>'ingredients_name']) !!}
                                                                <span id="ingredients_nameerror" class="image-error text-primary"></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <button class="btn btn-success" type="button" onclick="return addIngredients();" style="margin-top: 31px;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <span id="ingredients_error" class="image-error text-primary"></span>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <td><b>Removable Ingredients Name</b></td>
                                                                            <td><b>Action</b></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="ingredientsDataadd">

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
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

                <script type="text/javascript">
                    // $(document).ready(function(e){
                    //     $('#category').select2({
                    //         multiple:true,
                    //         allowClear: true,
                    //         placeholder: 'Select Category',
                    //         tokenSeparators: [','],
                    //     });
                    // });
                    $('#description').keypress(function(e) {
                        var tval = $('textarea').val(),
                            tlength = tval.length,
                            set = 255,
                            remain = parseInt(set - tlength);
                        $('p').text(remain);
                        if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
                            $('textarea').val((tval).substring(0, tlength - 1));
                            return false;
                        }
                    })
                </script>

                <script>
                    function validation() {
                        var regex = /(?:\d*\.\d{1,2}|\d+)$/;
                        var category = $("#category").val();
                        var name = $("#name").val();
                        var image = $("#image").val();
                        var image_pic = image.split(/\\/);
                        var price = $("#price").val();
                        var description = $("#description").val();
                        var attributeVal = $("input[name='is_attribute']:checked").val();
                        var temp = 0;

                        if (category == '') {
                            $("#category_error").html("Please select Category");
                            temp++;
                        } else {
                            $("#category_error").html("");
                        }
                        if (name.trim() == '') {
                            $("#nameerror").html("Please enter Item Name");
                            temp++;
                        } else {
                            $("#nameerror").html("");
                        }
                        if (image_pic[2] == "" || image == "") {
                            temp++;
                            $("#imageerror").html("Please upload Image");
                        } else {
                            ext = image_pic[2].split(".");
                            if (ext[1].toUpperCase() == "PNG" || ext[1].toUpperCase() == "JPG" || ext[1].toUpperCase() == "JPEG" || ext[1].toUpperCase() == "BMP") {
                                $("#imageerror").html("");
                            } else {
                                temp++;
                                $("#imageerror").html("File must Image!! Like: PNG, JPG, JPEG and BMP");
                            }

                        }
                        if (price.trim() == '') {
                            $("#priceerror").html("Please enter Price");
                            temp++;
                        } else {
                            if (regex.test(price)) {
                                $("#priceerror").html("");
                            } else {
                                $("#priceerror").html("Please enter valid Price");
                                temp++;
                            }

                        }
                        if (description.trim() == '') {
                            $("#description_error").html("Please enter Description");
                            temp++;
                        } else {
                            $("#description_error").html("");
                        }

                        if (attributeVal == 1) {
                            var attributHtml = $("#bankDataadd").html();
                            var itemsHtml = $("#itemDataadd").html();
                            if (attributHtml.trim() == '') {
                                $("#attribute_error").html("Please enter Attribute data");
                                temp++;
                            } else {
                                $("#attribute_error").html("");
                            }
                            if (itemsHtml.trim() == '') {
                                $("#items_error").html("Please enter Extra Item data");
                                temp++;
                            } else {
                                $("#items_error").html("");
                            }
                        } else {
                            $("#attribute_error").html("");
                            $("#items_error").html("");
                        }
                        if (temp == 0) {
                            // alert("return true");
                            // $("#food-menu-add").submit();
                            return true;
                        } else {
                            return false;
                        }
                    }

                    function openAttributeDiv(id) {
                        if (id == 1) {
                            $("#extraAttribute").css('display', 'block');
                            $("#extraItems").css('display', 'block');
                            $("#removeIngredients").css('display', 'block');
                        } else {
                            $("#attribute_name").val('');
                            $("#attribute_price").val('');
                            $("#bankDataadd").html("");
                            $("#itemDataadd").html("");
                            $("#extraAttribute").css('display', 'none');
                            $("#extraItems").css('display', 'none');
                            $("#removeIngredients").css('display', 'none');
                        }
                    }
                    var id = 1;

                    function addAttributes() {
                        var regex = /(?:\d*\.\d{1,2}|\d+)$/;
                        var attribute_name = $("#attribute_name").val();
                        var attribute_price = $("#attribute_price").val();
                        var temp = 0;

                        if (attribute_name.trim() == '') {
                            $("#attribute_nameerror").html('Please enter Variation Name');
                            temp++;
                        } else {
                            $("#attribute_nameerror").html('');
                        }
                        if (attribute_price.trim() == '') {
                            $("#attribute_priceerror").html('Please enter Variation Price');
                            temp++;
                        } else {
                            if (regex.test(attribute_price)) {
                                $("#attribute_priceerror").html("");
                            } else {
                                $("#attribute_priceerror").html("Please enter valid Variation Price");
                                temp++;
                            }

                        }

                        if (temp == 0) {
                            if (attribute_name != '' && attribute_price != '') {

                                var quote_str = "'" + attribute_name + "','" + attribute_price + "'";

                                $("#bankDataadd").prepend('<tr id="row_' + id + '"><td>' + attribute_name + '<input type="hidden" name="attribute_name[]" value="' + attribute_name + '" /></td><td>&#163; ' + attribute_price + ' <input type="hidden" name="attribute_price[]" value="' + attribute_price + '" /></td><td><a href="javascript:void(0);" onclick="deleteAttribute(' + id + ');"><i title="Delete" class="fa fa-trash text-primary"></i></a></td></tr>');

                                $("#attribute_name").val('');
                                $("#attribute_price").val('');

                                id++;
                            }

                            return true;

                        } else {
                            return false;
                        }

                    }

                    function addItems() {
                        var regex = /(?:\d*\.\d{1,2}|\d+)$/;
                        var item_name = $("#item_name").val();
                        var item_price = $("#item_price").val();
                        var temp = 0;

                        if (item_name.trim() == '') {
                            $("#item_nameerror").html('Please enter Item Name');
                            temp++;
                        } else {
                            $("#item_nameerror").html('');
                        }
                        if (item_price.trim() == '') {
                            $("#item_priceerror").html('Please enter Item Price');
                            temp++;
                        } else {
                            if (regex.test(item_price)) {
                                $("#item_priceerror").html("");
                            } else {
                                $("#item_priceerror").html("Please enter valid Item Price");
                                temp++;
                            }

                        }

                        if (temp == 0) {
                            if (item_name != '' && item_price != '') {

                                var quote_str = "'" + item_name + "','" + item_price + "'";

                                $("#itemDataadd").prepend('<tr id="row_' + id + '"><td>' + item_name + '<input type="hidden" name="item_name[]" value="' + item_name + '" /></td><td> &#163; ' + item_price + ' <input type="hidden" name="item_price[]" value="' + item_price + '" /></td><td><a href="javascript:void(0);" onclick="deleteItems(' + id + ');"><i title="Delete" class="fa fa-trash text-primary"></i></a></td></tr>');

                                $("#item_name").val('');
                                $("#item_price").val('');

                                id++;
                            }

                            return true;

                        } else {
                            return false;
                        }

                    }

                    function deleteAttribute(id) {
                        if (confirm("Are you sure you want to delete this?")) {
                            $("#row_" + id).remove();
                        } else {
                            return false;
                        }
                    }

                    function deleteItems(id) {
                        if (confirm("Are you sure you want to delete this?")) {
                            $("#row_" + id).remove();
                        } else {
                            return false;
                        }
                    }

                    function addIngredients() {
                        var regex = /(?:\d*\.\d{1,2}|\d+)$/;
                        var ingredients_name = $("#ingredients_name").val();
                        var temp = 0;

                        if (ingredients_name.trim() == '') {
                            // $("#ingredients_nameerror").html('Please enter ingredients Name');
                            temp++;
                        } else {
                            // $("#ingredients_nameerror").html('');
                        }

                        if (temp == 0) {
                            if (ingredients_name != '') {

                                var quote_str = "'" + ingredients_name + "'";

                                $("#ingredientsDataadd").prepend('<tr id="row_' + id + '"><td>' + ingredients_name + '<input type="hidden" name="ingredients_name[]" value="' + ingredients_name + '" /></td><td><a href="javascript:void(0);" onclick="deleteingredients(' + id + ');"><i title="Delete" class="fa fa-trash text-primary"></i></a></td></tr>');

                                $("#ingredients_name").val('');

                                id++;
                            }

                            return true;

                        } else {
                            return false;
                        }

                    }

                    function deleteingredients(id) {
                        if (confirm("Are you sure you want to delete this?")) {
                            $("#row_" + id).remove();
                        } else {
                            return false;
                        }
                    }
                </script>
                <script>
                    $('#image').on("change", function() {
                        var fileExtension = ['jpeg', 'jpg', 'png'];
                        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                            document.getElementById("image").value = '';
                            alert("Only .jpeg, .jpg, .png formats are allowed.");
                        }
                    })
                </script>
                @endsection