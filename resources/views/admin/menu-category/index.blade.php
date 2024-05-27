@extends('admin.master')
@section('title','Menu Category')
@section('css')
<link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('content')



<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Menu Category</h4>
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
                                                <div class="card-header">
                                                    <a href="{{route('menu-category.create')}}" class="btn btn-normal btn-primary btn-sm float-right"><i class="fa fa-fw fa-plus-square"></i> Add</a>
                                                    <h4 class="m-b-30 m-t-0">Menu Category List</h4>
                                                </div>
                                                <div class="card-body">

                                                    {!! Form::open(['class'=>'form-inline' ,'id'=>'menu-category-search-table']) !!}
                                                    <div class="form-group">

                                                        {!! Form::text('search_menu_category_name', '', ['class' => 'form-control', 'placeholder' => 'Search Menu Category','id'=>'search_menu_category_name']) !!}
                                                    </div>

                                                    <button type="button" class="btn btn-primary waves-effect waves-light m-l-10 " id="searchData">Search</button>
                                                    <a href="javascript:void(0);" onclick="resetData();" class="btn btn-secondary waves-effect waves-light m-l-10">Clear</a>
                                                    {!! Form::close() !!}
                                                </div> <!-- card-body -->
                                            </div> <!-- card -->
                                        </div> <!-- col -->

                                    </div> <!-- End row -->


                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12">
                                            <table id="menu-category-table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {

        loadData();
    });

    $(document).on('click', '#searchData', function() {
        $('#menu-category-table').DataTable().destroy();
        loadData();
    });

    function loadData() {
        var formData = $('#menu-category-search-table').serialize();
        $('#menu-category-table').DataTable({
            "processing": false,
            "serverSide": true,
            "searching": false,
            "ajax": {
                url: "{{route('menu-category-data')}}?" + formData,
                method: "get"
            }
        });
    }

    function resetData() {
        $("#search_menu_category_name").val('');
        $('#menu-category-table').DataTable().destroy();
        loadData();
    }
</script>
@endsection
