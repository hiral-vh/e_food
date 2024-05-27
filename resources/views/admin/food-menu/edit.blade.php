@extends('admin.master')
@section('title','Food-Category')
@section('css')
<style>
    .bootstrap-touchspin-up {
        height: 40px;
        margin-top: 150px;
    }

    #category-update {
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
                                        <h3 class="header-title m-t-0"><small class="text-primary"><b>Food Menu Edit</b></small></h3>

                                        <div class="m-t-20">
                                            {!! Form::model($menuEdit,['method' => 'PUT', 'route' => ['food-menu.update',$menuEdit->id], 'files' => true,'id'=>'category-update']) !!}
                                            {{ Form::hidden('menu_category_id', $menuEdit->menu_category_id, array('id' => 'menu_category_id')) }}
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('category', 'Category') !!}<span class="text-primary">*</span>
                                                    <select class="form-control select2" id="category" name="category[]" multiple>
                                                        @foreach ($menuCategory as $key=>$value)
                                                        <option value="{{$value->id}}" {{in_array($value->id,$categories)?'selected':''}}>{{$value->food_category_name}}</option>
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
                                                    <span class="text-primary">@error ('image') {{$message}}@enderror</span>
                                                    <span id="imageerror" class="image-error text-primary"></span>
                                                    <input type="hidden" id="oldImage" value="{{$menuEdit->image}}" />
                                                    @if($menuEdit->image !='')
                                                    <img src="{{asset($menuEdit->image)}}" height="50px" width="50px" />
                                                    @endif
                                                </div>

                                            </div>


                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label('price', 'Price') !!} (&#163;)<span class="text-primary">*</span>
                                                    {!! Form::text('price', old('price'), ['class' => 'form-control number','placeholder' => 'Enter Price','id'=>'price' , "maxlength" => '5']) !!}
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
                                                    {!! Form::radio('is_attribute', '0', (count($menuEdit->menuAttribute) < 0 || count($menuEdit->menuExtraItem) < 0) ? true : false ,['onclick'=> 'openAttributeDiv(0)']) !!} No
                                                            {!! Form::radio('is_attribute', '1', (count($menuEdit->menuAttribute) > 0 || count($menuEdit->menuExtraItem) > 0) ? true : false ,['onclick' => 'openAttributeDiv(1)']) !!} Yes
                                                            <span class="text-primary">@error ('price') {{$message}}@enderror</span>
                                                            <span id="priceerror" class="image-error text-primary"></span>
                                                </div>
                                            </div>
                                            @php $id =''; @endphp
                                            @php $diVdata = 'none'; @endphp
                                            @if(count($menuEdit->menuAttribute)>0)
                                            @php $diVdata = 'block'; @endphp
                                            @endif
                                            <div class="col-md-12" id="extraAttribute" style="display:{{$diVdata}};">
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
                                                    <input type="hidden" id="deletedIdall" name="deletedIdall" />
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
                                                                        @if(count($menuDataAttibute) > 0)
                                                                        @php $id = 1; @endphp
                                                                        @foreach($menuDataAttibute as $mkey)
                                                                        <tr id="row_{{$id}}">
                                                                            <input type="hidden" name="oldID" value="{{$mkey->id}}" />
                                                                            <td>{{$mkey->attribute_name}}
                                                                                <input type="hidden" name="attribute_name[]" value="{{$mkey->attribute_name}}" />
                                                                            </td>
                                                                            <td>&#163; {{$mkey->attribute_price}}
                                                                                <input type="hidden" name="attribute_price[]" value="{{$mkey->attribute_price}}" />
                                                                            </td>
                                                                            <td><a href="javascript:void(0);" onclick="deleteAttributeByData({{$id}});"><i title="Delete" class="fa fa-trash text-primary"></i></a></td>
                                                                        </tr>
                                                                        @php $id++; @endphp
                                                                        @endforeach
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @php $id =''; @endphp
                                            @php $divItem = 'none'; @endphp
                                            @if(count($menuEdit->menuExtraItem)>0)
                                            @php $divItem = 'block'; @endphp
                                            @endif
                                            <div class="col-md-12" id="extraItems" style="display:{{$divItem}};">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::label('item_name', 'Extra Item Name') !!}<span class="text-primary">*</span>
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
                                                    <input type="hidden" id="deletedItemIdall" name="deletedItemIdall" />
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <td><b>Extra Item Name</b></td>
                                                                            <td><b>Extra tem Price (&#163;)</b></td>
                                                                            <td><b>Action</b></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="itemDataadd">
                                                                        @if(count($menuDataExtraItem) > 0)
                                                                        @php $id = 1; @endphp
                                                                        @foreach($menuDataExtraItem as $mkey)
                                                                        <tr id="rowItem_{{$id}}">
                                                                            <input type="hidden" name="oldID" value="{{$mkey->id}}" />
                                                                            <td>{{$mkey->item_name}}
                                                                                <input type="hidden" name="item_name[]" value="{{$mkey->item_name}}" />
                                                                            </td>
                                                                            <td>&#163; {{$mkey->item_price}}
                                                                                <input type="hidden" name="item_price[]" value="{{$mkey->item_price}}" />
                                                                            </td>
                                                                            <td><a href="javascript:void(0);" onclick="deleteItemByData({{$id}});"><i title="Delete" class="fa fa-trash text-primary"></i></a></td>
                                                                        </tr>
                                                                        @php $id++; @endphp
                                                                        @endforeach
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @php $id =''; @endphp
                                            @php $divIngredients = 'none'; @endphp
                                            @if(count($menuEdit->removeIngredients)>0)
                                            @php $divIngredients = 'block'; @endphp
                                            @endif
                                            <div class="col-md-12" id="removeIngredients" style="display:{{$divIngredients}};">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                {!! Form::label('ingredients_name', 'Remove Ingredients Name') !!}<span class="text-primary">*</span>
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
                                                    <span id="items_error" class="image-error text-primary"></span>
                                                    <input type="hidden" id="deletedIngredientsIdall" name="deletedIngredientsIdall" />
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <td><b>Remove Ingredients Name</b></td>
                                                                            <td><b>Action</b></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="ingredientsDataadd">
                                                                        @if(count($removeIngredients) > 0)
                                                                        @php $id = 1; @endphp
                                                                        @foreach($removeIngredients as $mkey)
                                                                        <tr id="rowIngredients_{{$id}}">
                                                                            <input type="hidden" name="oldID" value="{{$mkey->id}}" />
                                                                            <td>{{$mkey->ingredients_name}}
                                                                                <input type="hidden" name="ingredients_name[]" value="{{$mkey->ingredients_name}}" />
                                                                            </td>
                                                                            <td><a href="javascript:void(0);" onclick="deleteIngredientsByData({{$id}});"><i title="Delete" class="fa fa-trash text-primary"></i></a></td>
                                                                        </tr>
                                                                        @php $id++; @endphp
                                                                        @endforeach
                                                                        @endif
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
                        </div>
                    </div>

                    <!-- end row -->

                </div><!-- container-fluid -->



                @endsection

                @section('js')
                <script>
                    function validation() {
                        var temp = 0;
                        var name = $('#name').val();

                        $('.name-error').html("");
                        if (name == "") {
                            $('.name-error').html("Please enter Food menu category name ");
                            temp++;
                        }

                        if (temp == 0) {
                            return true;
                        } else {
                            return false;
                        }

                    }
                </script>
                <script>
                    $(document).ready(function() {
                        var tval = $('textarea').val(),
                            tlength = tval.length,
                            set = 255,
                            remain = parseInt(set - tlength);
                        $('p').text(remain);
                        if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
                            $('textarea').val((tval).substring(0, tlength - 1));
                            return false;
                        }
                    });
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

                    function openAttributeDiv(id) {
                        if (id == 1) {
                            $("#extraAttribute").css('display', 'block');
                            $("#extraItems").css('display', 'block');
                            $("#removeIngredients").css('display', 'block');
                        } else {
                            $("#attribute_name").val('');
                            $("#attribute_price").val('');
                            $("#bankDataadd").html("");
                            $("#extraAttribute").css('display', 'none');
                            $("#extraItems").css('display', 'none');
                            $("#removeIngredients").css('display', 'none');
                        }
                    }
                    <?php if ($id != '') { ?>
                        var id = <?php echo $id ?>;
                    <?php } else { ?>
                        var id = 1;
                    <?php } ?>


                    function addAttributes() {
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
                            $("#attribute_priceerror").html('');
                        }




                        if (temp == 0) {
                            if (attribute_name != '' && attribute_price != '') {

                                var quote_str = "'" + attribute_name + "','" + attribute_price + "'";

                                $("#bankDataadd").prepend('<tr id="row_' + id + '"><input type="hidden" name="oldID" value="" /><td>' + attribute_name + '<input type="hidden" name="attribute_name[]" value="' + attribute_name + '" /></td><td>&#163; ' + attribute_price + ' <input type="hidden" name="attribute_price[]" value="' + attribute_price + '" /></td><td><a href="javascript:void(0);" onclick="deleteAttribute(' + id + ');"><i title="Delete" class="fa fa-trash text-primary"></i></a></td></tr>');

                                $("#attribute_name").val('');
                                $("#attribute_price").val('');

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
                    var deleteID = [];

                    function deleteAttributeByData(id) {
                        if (confirm("Are you sure you want to delete this?")) {
                            $("#row_" + id).remove();
                            deleteID.push(id);
                            $("#deletedIdall").val(deleteID);
                        } else {
                            return false;
                        }
                    }

                    function addItems() {
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
                            $("#item_priceerror").html('');
                        }




                        if (temp == 0) {
                            if (item_name != '' && item_price != '') {

                                var quote_str = "'" + item_name + "','" + item_price + "'";

                                $("#itemDataadd").prepend('<tr id="rowItems_' + id + '"><input type="hidden" name="oldID" value="" /><td>' + item_name + '<input type="hidden" name="item_name[]" value="' + item_name + '" /></td><td> &#163; ' + item_price + ' <input type="hidden" name="item_price[]" value="' + item_price + '" /></td><td><a href="javascript:void(0);" onclick="deleteItem(' + id + ');"><i title="Delete" class="fa fa-trash text-primary"></i></a></td></tr>');

                                $("#item_name").val('');
                                $("#item_price").val('');

                                id++;
                            }

                            return true;



                        } else {
                            return false;
                        }

                    }

                    function deleteItem(id) {
                        if (confirm("Are you sure you want to delete this?")) {
                            $("#rowItems_" + id).remove();
                        } else {
                            return false;
                        }
                    }
                    var deleteID = [];

                    function deleteItemByData(id) {
                        if (confirm("Are you sure you want to delete this?")) {
                            $("#rowItem_" + id).remove();
                            deleteID.push(id);
                            $("#deletedItemIdall").val(deleteID);
                        } else {
                            return false;
                        }
                    }

                    function addIngredients() {
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

                                $("#ingredientsDataadd").prepend('<tr id="rowIngredients_' + id + '"><input type="hidden" name="oldID" value="" /><td>' + ingredients_name + '<input type="hidden" name="ingredients_name[]" value="' + ingredients_name + '" /></td><td><a href="javascript:void(0);" onclick="deleteIngredients(' + id + ');"><i title="Delete" class="fa fa-trash text-primary"></i></a></td></tr>');

                                $("#ingredients_name").val('');

                                id++;
                            }

                            return true;



                        } else {
                            return false;
                        }

                    }

                    function deleteIngredients(id) {
                        if (confirm("Are you sure you want to delete this?")) {
                            $("#rowIngredients_" + id).remove();
                        } else {
                            return false;
                        }
                    }
                    var deleteID = [];

                    function deleteIngredientsByData(id) {
                        if (confirm("Are you sure you want to delete this?")) {
                            $("#rowIngredients_" + id).remove();
                            deleteID.push(id);
                            $("#deletedIngredientsIdall").val(deleteID);
                        } else {
                            return false;
                        }
                    }

                    function validation() {
                        var regex = /(?:\d*\.\d{1,2}|\d+)$/;
                        var category = $("#category").val();
                        var name = $("#name").val();
                        var image = $("#image").val();
                        var image_pic = image.split(/\\/);
                        var price = $("#price").val();
                        var oldImage = $("#oldImage").val();
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
                        if (oldImage == '') {
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
                                $("#items_error").html("Please enter Item data");
                                temp++;
                            } else {
                                $("#items_error").html("");
                            }
                        } else {
                            $("#attribute_error").html("");
                            $("#items_error").html("");
                        }
                        if (temp == 0) {
                            $("#category-update").submit();
                            return true;
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