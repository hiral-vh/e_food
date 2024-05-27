@extends('admin.master')
@section('title','Calendar')
@section('css')
<style>
    .fc-event-container .fc-time {
        display: none;
    }

    .fc th.fc-widget-header {
        background: #ef5c6a !important;
        color: #fff;
    }

    .fc-event {
        cursor: pointer;
    }
</style>
@endsection
@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">

        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Table Booking</h4>
            </div>
        </div>

        <div class="page-content-wrapper ">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="offset-md-9 col-3">
                                    <select class="form-control mb-3" id="list_type" name="list_type" onchange="location = this.value;">
                                        <option selected>Calender View</option>
                                        <option value="{{route('calendar-table-list')}}">Table View</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div id='calendar' class="col-xl-12 col-md-9"></div>
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div><!-- container-fluid -->

        </div> <!-- Page content Wrapper -->

    </div> <!-- content -->

    <div id="detailsModal" class="modal fade bs-example-modal-lg bookig-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title m-0" id="timeslotsModalLabel">Booking Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered mb-0" id="detailsTable">
                        <thead>
                            <tr>
                                <th scope="col">Reference Id</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Start Time</th>
                                <th scope="col">End Time</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
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
<script type="text/javascript">
    ! function($) {
        "use strict";

        var CalendarPage = function() {};

        CalendarPage.prototype.init = function() {

                //checking if plugin is available
                if ($.isFunction($.fn.fullCalendar)) {
                    /* initialize the external events */
                    $('#external-events .fc-event').each(function() {
                        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                        // it doesn't need to have a start or end
                        var eventObject = {
                            title: $.trim($(this).text()) // use the element's text as the event title
                        };

                        // store the Event Object in the DOM element so we can get to it later
                        $(this).data('eventObject', eventObject);

                        // make the event draggable using jQuery UI
                        $(this).draggable({
                            zIndex: 999,
                            revert: true, // will cause the event to go back to its
                            revertDuration: 0 //  original position after the drag
                        });

                    });

                    /* initialize the calendar */

                    var date = new Date();
                    var d = date.getDate();
                    var m = date.getMonth();
                    var y = date.getFullYear();

                    $('#calendar').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'agendaDay,agendaWeek,month'
                        },
                        editable: false,
                        eventLimit: true, // allow "more" link when too many events
                        droppable: false, // this allows things to be dropped onto the calendar !!!
                        allDaySlot: false,

                        events: function(start, end, timezone, callback) {

                            $.ajax({
                                url: "{{route('calendar_event')}}",
                                type: 'POST',
                                data: {
                                    start: start.format(),
                                    end: end.format(),
                                    _token: "{{csrf_token()}}"
                                },
                                success: function(doc) {

                                    var events = [];
                                    if (!!doc) {

                                        $.map(doc.totalRecord, function(r) {
                                            events.push({
                                                id: r.book_date,
                                                title: r.bookDateCount,
                                                start: r.book_date,
                                            });
                                        });
                                    }
                                    callback(events);
                                }
                            });
                        },
                        eventClick: function(event, element) {
                            /* $('#detailsModal').modal('show');
                             getDataList(event.id);*/

                            window.location.href = '{{url("/table-report/")}}' + '/' + event.id;
                        }
                    });
                } else {
                    alert("Calendar plugin is not installed");
                }
            },
            //init
            $.CalendarPage = new CalendarPage, $.CalendarPage.Constructor = CalendarPage
    }(window.jQuery),

    //initializing
    function($) {
        "use strict";
        $.CalendarPage.init()
    }(window.jQuery);

    function getDataList(id) {
        var id = id;
        $.ajax({
            url: "{{route('calendar_event_users')}}",
            type: 'GET',
            data: {
                id,
                id
            },
            success: function(response) {
                if (response) {
                    $("#detailsTable tbody").html('');
                    $.each(response, function(index, val) {
                        i++;
                        var userName = val.user.first_name + ' ' + val.user.last_name;
                        var startDate = moment(val.book_date, 'YYYY-MM-DD').format("DD/MM/YYYY");
                        var startTime = moment(val.table_time.time_from, 'h:mm A').format("HH:mm");
                        var endTime = moment(val.table_time.time_to, 'h:mm A').format("HH:mm");
                        var new_row = "<tr><td>" + val.booking_ref_id + "</td><td>" + userName + "</td><td>" + startDate + "</td><td>" + startTime + "</td><td>" + endTime + "</td></tr>";
                        $("#detailsTable tbody").append(new_row);
                    });
                }
            }
        });
    }
</script>
@endsection