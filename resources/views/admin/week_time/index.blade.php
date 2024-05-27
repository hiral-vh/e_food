@extends('admin.master')
@section('title','Food-Category')
@section('css')
<!-- <link href="{{ asset('admin/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet"> -->
@endsection
@section('content')
<div class="content-page">
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Week Schedule</h4>
            </div>
        </div>
        <div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h4 class="m-t-0 m-b-30">Settings</h4>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="setting-data-main">

                                            @foreach ($days as $data)
                                            @php
                                            $btnName="Set Time";
                                            @endphp
                                            @if(isset($dayArr[$data]))
                                            @php $btnName = "Update Time"; @endphp
                                            @endif
                                            <div class="d-flex justify-content-between settings-data">
                                                <label class="mb-0">{{ $data }}</label>
                                                <button type="submit" class="btn btn-primary waves-effect waves-light" onclick="openModal('{{ $data }}')">{{$btnName}}</button>
                                            </div>
                                            <hr>
                                            @endforeach
                                        </div>
                                    </div>
                                </diV>
                            </div>
                            <!-- <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="mb-0 mt-0">Break Time</h4>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light"
                                                        onclick="openModal('{{ $data }}')">Add Break Time</button>
                                    </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div id="setTimeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="myModalLabel">Update Schedule</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="{{route('add-weekly-schedule')}}" id="scheduleCreateForm" method="post">
                        @csrf
                        <input type="hidden" id="restaurantId" name="restaurantId" value="{{$time->id}}">
                        <input type="hidden" id="day" name="day" value="">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Start Time<span class="error">*</span></label>
                            <input type="text" class="form-control" id="open_time" name="open_time" placeholder="" value="{{$time->restaurant_open_time}}" autofocus>
                            <span id="open_time_error" style="color:red;"><span>
                                    <span class="error" id="startTimeSpan">{{ $errors->teamMember->first('start_time') }}</span>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">End Time<span class="error">*</span></label>
                            <input type="text" class="form-control" id="close_time" name="close_time" placeholder="" value="{{$time->restaurant_close_time}}" autofocus>
                            <span id="close_time_error" style="color:red;"><span>
                                    <span class="error" id="endTimeSpan">{{ $errors->teamMember->first('end_time') }}</span>
                        </div>

                        <h4>Break Time</h4>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Break Start Time<span class="error">*</span></label>
                            <input type="text" class="form-control" id="break_start_time" name="break_start_time" placeholder="" value="{{$time->break_start_time}}" autofocus>
                            <span id="break_start_time_error" style="color:red;"><span>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Break End Time<span class="error">*</span></label>
                            <input type="text" class="form-control" id="break_end_time" name="break_end_time" placeholder="" value="{{$time->break_end_time}}" autofocus>
                            <span id="break_end_time_error" style="color:red;"><span>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary waves-effect waves-light" id="setSchedule">Update</button>
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        </div>

                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <footer class="footer">
        © 2019 - 2020 Hexzy <span class="d-none d-md-inline-block"> - Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign.</span>
    </footer>

</div>
@endsection
@section('js')
<script>
    var success = "{{ Session::get('success') }}";
    var error = "{{ Session::get('error') }}";
</script>
<script src="{{asset('admin/plugins/input-mask/jquery.inputmask.bundle.js')}}"></script>
<script>
    // $('#open_time').timepicker({
    //     defaultTIme: false
    // });

    // $('#close_time').timepicker({
    //     defaultTIme: false
    // });

    // $('#break_start_time').timepicker({
    //     defaultTIme: false
    // });

    // $('#break_end_time').timepicker({
    //     defaultTIme: false
    // });

    function openModal(day) {
        $('#setTimeModal').modal('show');
        $('#day').val(day);
    }

    $('input[id$="open_time"]').inputmask(
        "hh:mm:ss", {
            placeholder: "00:00:00",
            insertMode: false,
            showMaskOnHover: false,
            //  hourFormat: 12
        }
    );

    $('input[id$="close_time"]').inputmask(
        "hh:mm:ss", {
            placeholder: "00:00:00",
            insertMode: false,
            showMaskOnHover: false,
            //  hourFormat: 12
        }
    );

    $('input[id$="break_start_time"]').inputmask(
        "hh:mm:ss", {
            placeholder: "00:00:00",
            insertMode: false,
            showMaskOnHover: false,
            //  hourFormat: 12
        }
    );

    $('input[id$="break_end_time"]').inputmask(
        "hh:mm:ss", {
            placeholder: "00:00:00",
            insertMode: false,
            showMaskOnHover: false,
            //  hourFormat: 12
        }
    );

    $("#setSchedule").click(function(e) {
        var temp = 0;
        var open_time = $("#open_time").val();
        var close_time = $("#close_time").val();
        var break_start_time = $("#break_start_time").val();
        var break_end_time = $("#break_end_time").val();

        if (open_time.trim() == '') {
            $("#open_time_error").html("Please enter Restaurant Open Time");
            temp++;
        } else {
            $("#open_time_error").html("");
        }

        if (close_time.trim() == '') {
            $("#close_time_error").html("Please enter Restaurant Close Time");
            temp++;
        } else if (close_time < open_time) {
            $("#close_time_error").html("Restaurant close time should be greater than restaurant open time");
            temp++;
        } else {
            $("#close_time_error").html("");
        }

        if (break_start_time.trim() == '') {
            $("#break_start_time_error").html("Please enter Restaurant break start time.");
            temp++;
        } else {
            $("#break_start_time_error").html("");
        }

        if (break_end_time.trim() == '') {
            $("#break_end_time_error").html("Please enter Restaurant break end time.");
            temp++;
        } else if (break_end_time <= break_start_time) {
            $("#break_end_time_error").html("End time should be greater than or equal to start time.");
            temp++;
        } else {
            $("#break_end_time_error").html("");
        }

        if (temp == 0) {
            return true;
        } else {
            return false;
        }
    });
</script>
@endsection