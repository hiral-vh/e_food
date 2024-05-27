@extends('admin.master')
@section('title','Order Report')
@section('css')
<style>
    .with-drops {
        width: 220px !important;
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
<link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('content')



<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Order Report</h4>
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
                                                    <h4 class="m-b-30 m-t-0">Order List</h4>
                                                </div>
                                                <div class="card-body">

                                                    {!! Form::open(['class'=>'form-inline' ,'id'=>'order-search-data']) !!}
                                                    <div class="form-group">
                                                        {!! Form::select('search_user', $userData, old('search_user'), ['class' => 'form-control with-drops select2 ','placeholder' => 'Please select User','id'=>'search_user']) !!}
                                                    </div>


                                                    <div class="form-group m-l-10">
                                                        {{ Form::select('search_ordertype',array('1' => 'Collection', '2' => 'Dine-in', '3' => 'Delivery'), old('search_ordertype'), ['class' => 'form-control with-drops select2 ','placeholder' => 'Please select Order Type','id' => 'search_ordertype']) }}
                                                    </div>
                                                    {{-- <div class="form-group m-l-10">
                                                        {{ Form::select('search_orderstatus',array('Accepted Order' => 'Accepted Order','Rejected Order' => 'Rejected Order','Order Confirmed' => 'Order Confirmed', 'Preparing your Order' => 'Preparing your Order', 'Your orders are on its way' => 'Your orders are on its way', 'Your Order is ready' => 'Your Order is ready', 'Order Collected' => 'Order Collected','Delivered' => 'Delivered'), old('search_ordertype'), ['class' => 'form-control with-drops select2','placeholder' => 'Please select Order Status','id' => 'search_orderstatus']) }}
                                                </div> --}}
                                                <div class="form-group m-l-10">
                                                    {!! Form::text('search_name', '', ['class' => 'form-control with-drops', 'placeholder' => 'Search by Order Number','id'=>'search_name']) !!}
                                                </div>
                                                <div class="form-group m-l-10">
                                                    <div id="reportrange" style="margin-top:15px;background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;height: 35px;margin-left: -10px;">
                                                        <i class="fa fa-calendar"></i>&nbsp;
                                                        <span></span> <i class="fa fa-caret-down"></i>
                                                    </div>
                                                    <input type="hidden" name="start_date" id="start_date" />
                                                    <input type="hidden" name="end_date" id="end_date" />
                                                </div>
                                                <div class="form-group m-t-10">
                                                    <button type="button" class="btn btn-primary waves-effect waves-light m-l-10 " id="searchData">Search</button>
                                                    <a href="javascript:void(0);" onclick="resetData();" class="btn btn-secondary waves-effect waves-light m-l-10">Clear</a>
                                                </div>
                                                {!! Form::close() !!}
                                            </div> <!-- card-body -->
                                        </div> <!-- card -->
                                    </div> <!-- col -->

                                </div>


                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <table id="category-table" class="table table-striped table-bordered dt-responsive" style="border-collapse: collapse; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Customer Name</th>
                                                    <th>Order Type</th>
                                                    <th>Order DateTime</th>
                                                    <th>Order Number</th>
                                                    <th>Delivery Charge</th>
                                                    <th>Total Amount (&#163;)</th>
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
    @endsection

    @section('js')
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            loadData();
        });
        $(document).on('click', '#searchData', function() {
            $('#category-table').DataTable().destroy();
            loadData();
        });

        function loadData() {
            var formData = $('#order-search-data').serialize();
            $('#category-table').DataTable({
                "processing": false,
                "serverSide": true,
                "searching": false,
                "ajax": {
                    url: "{{route('order-data')}}?" + formData,
                    method: "get"
                }

            });
        }
    </script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript">
        $(function() {

            var start = moment();
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $("#start_date").val(start.format('YYYY-MM-DD'));
                $("#end_date").val(end.format('YYYY-MM-DD'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

        });

        function resetData() {
            $("#search_user").val(null).trigger('change');
            $("#search_ordertype").val(null).trigger('change');
            $("#search_name").val('');
            $('#reportrange').data('daterangepicker').setStartDate(new Date);
            $('#reportrange').data('daterangepicker').setEndDate(new Date);
            $("#start_date").val("");
            $("#end_date").val("");
            $('#category-table').DataTable().destroy();
            loadData();
        }
    </script>
    @endsection