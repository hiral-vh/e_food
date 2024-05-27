@extends('admin.master')
@section('title','Book-Table')
@section('css')

<link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('content')

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Seating Plan</h4>
            </div>
        </div>
        <!-- End row -->




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
                                                    <a href="{{route('table-number.create')}}" class="btn btn-normal btn-primary btn-sm float-right"><i class="fa fa-fw fa-plus-square"></i> Add</a>
                                                </div>
                                                <div class="card-body">
                                                    {!! Form::open(['class'=>'form-inline' ,'id'=>'book-search-table']) !!}
                                                    <div class="form-group">

                                                        {!! Form::text('search_table_name', '', ['class' => 'form-control', 'placeholder' => 'Search Table Number','id'=>'search_table_name']) !!}
                                                    </div>

                                                    <div class="form-group m-l-10">

                                                        {!! Form::text('search_number_of_people', '', ['class' => 'form-control', 'placeholder' => 'Search Number of People','id'=>'search_number_of_people','oninput' => "this.value=this.value.replace(/[^\d]/,'')"]) !!}
                                                    </div>

                                                    <div class="form-group m-l-10">

                                                        {!! Form::text('search_duration', '', ['class' => 'form-control', 'placeholder' => 'Search Duration','id'=>'search_duration','oninput' => "this.value=this.value.replace(/[^\d]/,'')"]) !!}
                                                    </div>


                                                    <button type="button" class="btn btn-primary waves-effect waves-light m-l-10 " id="searchData">Search</button>
                                                    <a href="javascript:void(0);" onclick="resetData();" class="btn btn-secondary waves-effect waves-light m-l-10">Clear</a>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12">

                                            <table id="book-table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Table Number</th>
                                                        <th>Number of People</th>
                                                        <th>Duration</th>
                                                    </tr>
                                                </thead>


                                                <tbody>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div> <!-- card-body -->
                            </div> <!-- card -->
                        </div> <!-- col -->

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
        $('#book-table').DataTable().destroy();
        loadData();
    });

    function loadData() {
        var formData = $('#book-search-table').serialize();
        $('#book-table').DataTable({
            "processing": false,
            "serverSide": true,
            "searching": false,
            "ajax": {
                url: "{{route('book-table-data')}}?" + formData,
                method: "get"
            }
        });
    }

    function resetData() {
        $("#search_table_name").val('');
        $("#search_number_of_people").val('');
        $("#search_duration").val('');
        $('#book-table').DataTable().destroy();
        loadData();
    }
</script>
@endsection
