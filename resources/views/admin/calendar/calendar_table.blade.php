@extends('admin.master')
@section('title','Food-Category')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" class="href">
<style>
    span.time-from {
        border-right: 1px solid #ef5c6adb;
        padding: 14px 0px;
    }

    span.category-section.ml-3.from-time {
        margin-right: 15px;
    }

    .card-tools {
        padding-top: 15px;
    }

    table {
        table-layout: fixed;
    }

    table td {
        word-wrap: break-word;
        max-width: 400px;
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
                <h4 class="page-title">Calendar Table Detail</h4>
            </div>
        </div>
        <div class="page-content-wrapper ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <!-- <div class="card-tools">
                                <div class="mb-3 ml-3 mt-0 pr-md-5 text-right">

                                </div>
                            </div> -->

                            <div class="card-body" style="display: block;">
                                <div class="offset-md-9 col-3">
                                    <select class="form-control mb-3" id="list_type" name="list_type" onchange="location = this.value;">
                                        <option selected>Table View</option>
                                        <option value="{{ route('calendar') }}">Calender View</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                                        <div class="row">
                                            <div class="col-lg-12 col-sm-12 col-12">
                                                <table id="menu-table" class="table table-striped table-bordered dt-responsive" style="border-collapse: collapse; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <!-- <th>Table Number</th> -->
                                                            <th>User Name</th>
                                                            <th>User Email</th>
                                                            <th>User Mobile</th>
                                                            <th>Number of People</th>
                                                            <th>Booking Reference ID</th>
                                                            <th>Booking Date</th>
                                                            <th>Booking Time</th>
                                                            <th>Booking Notes</th>
                                                            <th>Booking Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($event as $rwData)
                                                        <tr>
                                                            <!-- <td>{{isset($rwData->tableName->table_name) ? $rwData->tableName->table_name : 'N/A'}}</td> -->
                                                            <td>{{$rwData->user->first_name !="" ? $rwData->user->first_name : 'N/A'}} {{$rwData->user->last_name !="" ? $rwData->user->last_name : ''}}</td>
                                                            <td>{{$rwData->user->email !="" ? $rwData->user->email : 'N/A'}}</td>
                                                            <td>+{{$rwData->user->country_code !="" ? $rwData->user->country_code : 'N/A'}} {{$rwData->user->mobile_no !="" ? $rwData->user->mobile_no : ''}}</td>
                                                            <td>{{$rwData->number_of_people !="" ? $rwData->number_of_people : 'N/A'}}</td>
                                                            <td>{{$rwData->booking_ref_id !="" ? $rwData->booking_ref_id : 'N/A'}}</td>
                                                            <td>{{$rwData->book_date !="" ? date("d/m/Y",strtotime($rwData->book_date)) : 'N/A'}}</td>
                                                            <td>{{isset($rwData->book_time) ? date("h:i A",strtotime($rwData->book_time)) : 'N/A'}}</td>
                                                            <td>{{$rwData->booking_notes !="" ? $rwData->booking_notes : 'N/A'}}</td>
                                                            <td>@if($rwData->table_status == 0)<span class="badge badge-primary ml-3">Cancelled</span>@else<span class="badge badge-success ml-3">Confirmed</span>@endif</td>
                                                            <!-- <td>@if(empty($rwData->deleted_at))<span class="badge badge-success ml-3">Confirmed</span>@else<span class="badge badge-primary ml-3">Cancelled</span>@endif</td> -->
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                    <div style="height: 300px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                </div><!-- container -->

            </div> <!-- Page content Wrapper -->

        </div> <!-- content -->
    </div> <!-- content -->



</div>

@endsection
@section('js')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#menu-table').DataTable({
            responsive: true,
            "searching": false,
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }]
        });
    });
</script>
@endsection