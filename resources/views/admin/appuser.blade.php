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
                <h4 class="page-title">Customers</h4>
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
                                            <table id="menu-table" class="table table-striped table-bordered dt-responsive" style="border-collapse: collapse; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Mobile</th>
                                                        <th>Created Date Time</th>
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
