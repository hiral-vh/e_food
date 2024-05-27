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
                <h4 class="page-title">Notifications</h4>
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


                                    </div> <!-- End row -->
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12">
                                            @forelse($getNotifications as $rwData)
                                            @if($rwData->data['type'] == 1)
                                            <div class="dropdown-item notify-item mt-2">
                                                <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>
                                                <p class="notify-details">{{$rwData->data['message']}} <span class="text-muted">@if(isset($rwData->data['url'])) <a href="{{$rwData->data['url']}}">Click Here</a> @else N/A @endif <br> {{date('Y-m-d', strtotime($rwData->data['date&time']))}}</span></p>
                                            </div>
                                            @elseif($rwData->data['type'] == 3)
                                            <div class="dropdown-item notify-item mt-2">
                                                <div class="notify-icon bg-success"><i class="mdi mdi-message-text-outline"></i></div>
                                                <p class="notify-details">{{$rwData->data['message']}}<span class="text-muted">{{date('Y-m-d', strtotime($rwData->data['date&time']))}}</span></p>
                                            </div>
                                            @elseif($rwData->data['type'] == 2)
                                            <div class="dropdown-item notify-item mt-2">
                                                <a href="{{ route('order-report.show', $rwData->data['orderId']) }}">
                                                    <div class="notify-icon bg-success"><i class="mdi mdi-message-text-outline"></i></div>
                                                    <p class="notify-details">{{$rwData->data['userName']}} {{$rwData->data['message']}}<span class="text-muted"></span></p>
                                                </a>
                                            </div>
                                            @elseif($rwData->data['type'] == 4)
                                            <div class="dropdown-item notify-item mt-2">
                                                <div class="notify-icon bg-success"><i class="mdi mdi-message-text-outline"></i></div>
                                                <p class="notify-details">{{$rwData->data['userName']}} {{$rwData->data['message']}} {{$rwData->data['tableName']}} {{$rwData->data['bookingDate']}}<span class="text-muted"></span></p>
                                            </div>
                                            @endif
                                            @empty
                                            <div class="dropdown-item notify-item mt-2">
                                                <center>
                                                    <p class="notify-details">Data not available<span class="text-muted"></span></p>
                                                </center>
                                            </div>
                                            @endforelse
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
        $('#menu-table').DataTable({
            "processing": false,
            "serverSide": true,
            "searching": false,
            "ajax": {
                url: "{{route('app-user-data')}}?",
                method: "get"
            },
            "fnDrawCallback": function() {
                $(function() {
                    $('.updateStatus').bootstrapToggle()
                });
            }
        });
    }
</script>
@endsection