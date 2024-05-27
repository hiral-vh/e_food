@extends('admin.master')
@section('title','Food-Menu')
@section('css')

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Menu</h4>
            </div>
        </div>
        <div class="page-content-wrapper ">
            <div class="page-content-wrapper ">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header" style="height: 52px;overflow: auto;">
                                                    @foreach ($menuData as $category)
                                                    <a href="{{route('createFoodMenu',$category->id)}}" class="btn btn-normal btn-primary btn-sm mb-2">{{((isset($category->title)!=null)?$category->title:'NA')}}</a>
                                                    @endforeach
                                                </div>
                                                <div class="card-body">
                                                    {!! Form::open(['class'=>'form-inline' ,'id'=>'menu-search']) !!}

                                                    <div class="form-group">
                                                        {!! Form::text('search_name', '', ['class' => 'form-control', 'placeholder' => 'Search Item Name','id'=>'search_name']) !!}
                                                    </div>

                                                    <div class="form-group m-l-10">
                                                        {!! Form::text('price', '', ['class' => 'form-control', 'placeholder' => 'Search Item Price (&#163;)','id'=>'price','oninput' => "this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')"]) !!}
                                                    </div>

                                                    <button type="button" class="btn btn-primary waves-effect waves-light m-l-10" id="searchData">Search</button>
                                                    <a href="javascript:void(0);" onclick="resetData();" class="btn btn-secondary waves-effect waves-light m-l-10">Clear</a>
                                                    {!! Form::close() !!}

                                                </div> <!-- card-body -->
                                            </div> <!-- card -->
                                        </div> <!-- col -->

                                    </div> <!-- End row -->
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12">
                                            <table id="menu-table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Item Name</th>
                                                        <th>Menu Category</th>
                                                        <th>Item Price (&#163;)</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- End Row -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    $(document).ready(function() {
        loadData();
        $.fn.dataTable.ext.errMode = 'none';
    });
    $(document).on('click', '#searchData', function() {
        $('#menu-table').DataTable().destroy();
        loadData();
    });

    function loadData() {
        var formData = $('#menu-search').serialize();
        $('#menu-table').DataTable({
            "processing": false,
            "serverSide": true,
            "searching": false,
            "ajax": {
                url: "{{route('food-menu-data')}}?" + formData,
                method: "get"
            },
            "fnDrawCallback": function() {
                $(function() {
                    $('.updateStatus').bootstrapToggle()
                });
            }
        });
    }


    $(document).on("change", ".updateStatus", function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var menuItemId = $(this).data('id');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '{{route("menu.updatestatus")}}',
            data: {
                'status': status,
                'menuItemId': menuItemId
            },
            success: function(data) {
                toastr.success(data.success);
                $('#menu-table').DataTable().destroy();
                loadData();
            }
        });
    });

    function resetData() {
        $("#search_name").val('');
        $("#price").val('');
        $('#menu-table').DataTable().destroy();
        loadData();
    }
</script>
@endsection