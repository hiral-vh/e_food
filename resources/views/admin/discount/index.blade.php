@extends('admin.master')
@section('title','Discount')
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
                <h4 class="page-title">Discount</h4>
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
                                                    <a href="{{route('discount.create')}}" class="btn btn-normal btn-primary btn-sm float-right"><i class="fa fa-fw fa-plus-square"></i> Add</a>
                                                    <h4 class="m-b-30 m-t-0">Discount List</h4>
                                                </div>
                                                <div class="card-body">
                                                    {!! Form::open(['class'=>'form-inline' ,'id'=>'menu-search']) !!}

                                                    <div class="form-group">
                                                        {!! Form::text('search_name', '', ['class' => 'form-control', 'placeholder' => 'Search Discount Name','id'=>'search_name']) !!}
                                                    </div>
                                                    <div class="form-group m-l-10">
                                                        {!! Form::text('search_code', '', ['class' => 'form-control', 'placeholder' => 'Search Discount Code','id'=>'search_code']) !!}
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
                                                        <th>No</th>
                                                        <th>Discount Name</th>
                                                        <th>Discount Code</th>
                                                        <th>Discount Type</th>
                                                        <th>Discount Value</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
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
                url: "{{route('discount-data')}}?" + formData,
                method: "get"
            },

        });
    }




    function resetData() {
        $("#search_name").val('');
        $("#search_code").val('');
        $('#menu-table').DataTable().destroy();
        loadData();
    }
</script>
@endsection