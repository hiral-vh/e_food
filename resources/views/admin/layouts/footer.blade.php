</div>
<!-- End Right content here -->

</div>
<!-- END wrapper -->

<!-- jQuery  -->
<script src="{{asset('admin/js/jquery.min.js')}}"></script>
<script src="{{asset('admin/js/moment.min.js')}}"></script>
<script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('admin/js/modernizr.min.js')}}"></script>
<script src="{{asset('admin/js/detect.js')}}"></script>
<script src="{{asset('admin/js/fastclick.js')}}"></script>
<script src="{{asset('admin/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('admin/js/jquery.blockUI.js')}}"></script>
<script src="{{asset('admin/js/waves.js')}}"></script>
<script src="{{asset('admin/js/wow.min.js')}}"></script>
<script src="{{asset('admin/js/jquery.nicescroll.js')}}"></script>
<script src="{{asset('admin/js/jquery.scrollTo.min.js')}}"></script>
<script src="{{asset('admin/js/daterangepicker.min.js')}}"></script>

<!--Morris Chart-->
<script src="{{asset('admin/plugins/morris/morris.min.js')}}"></script>
<script src="{{asset('admin/plugins/raphael/raphael.min.js')}}"></script>

<!--Full calendar Js -->
<script src="{{asset('admin/plugins/moment/moment.js')}}"></script>
<script src="{{asset('admin/plugins/fullcalendar/js/fullcalendar.min.js')}}"></script>

<!-- KNOB JS -->
<script src="{{asset('admin/plugins/jquery-knob/excanvas.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-knob/jquery.knob.js')}}"></script>

<script src="{{asset('admin/plugins/flot-chart/jquery.flot.min.js')}}"></script>
<script src="{{asset('admin/plugins/flot-chart/jquery.flot.tooltip.min.js')}}"></script>
<script src="{{asset('admin/plugins/flot-chart/jquery.flot.resize.js')}}"></script>
<script src="{{asset('admin/plugins/flot-chart/jquery.flot.pie.js')}}"></script>
<script src="{{asset('admin/plugins/flot-chart/jquery.flot.selection.js')}}"></script>
<script src="{{asset('admin/plugins/flot-chart/jquery.flot.stack.js')}}"></script>
<script src="{{asset('admin/plugins/flot-chart/jquery.flot.crosshair.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


<script src="{{asset('admin/pages/dashboard.js')}}"></script>

<script src="{{asset('admin/js/app.js')}}"></script>
<script src="{{asset('admin/plugins/select2/js/select2.min.js')}} "></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>

<script>
    $(function() {

        @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
        @endif

        @if(Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
        @endif

        @if(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
        @endif

        @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
        @endif
    });
</script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2();
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {

        $(".only-numeric").bind("keypress", function(e) {

            var keyCode = e.which ? e.which : e.keyCode



            if (!(keyCode >= 48 && keyCode <= 57)) {

                $(".error").css("display", "inline");

                return false;

            } else {

                $(".error").css("display", "none");

            }

        });

    });
    $(document).ready(function() {
        $('.only-numeric').on("cut copy paste", function(e) {
            e.preventDefault();
        });
    });
    $('.number').keypress(function(event) {
        var $this = $(this);
        if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
            ((event.which < 48 || event.which > 57) &&
                (event.which != 0 && event.which != 8))) {
            event.preventDefault();
        }

        var text = $(this).val();
        if ((event.which == 46) && (text.indexOf('.') == -1)) {
            setTimeout(function() {
                if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                    $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
                }
            }, 1);
        }

        if ((text.indexOf('.') != -1) &&
            (text.substring(text.indexOf('.')).length > 2) &&
            (event.which != 0 && event.which != 8) &&
            ($(this)[0].selectionStart >= text.length - 2)) {
            event.preventDefault();
        }
    });

    $('.number').bind("paste", function(e) {
        var text = e.originalEvent.clipboardData.getData('Text');
        if ($.isNumeric(text)) {
            if ((text.substring(text.indexOf('.')).length > 3) && (text.indexOf('.') > -1)) {
                e.preventDefault();
                $(this).val(text.substring(0, text.indexOf('.') + 3));
            }
        } else {
            e.preventDefault();
        }
    });
</script>
<script>
     var firebaseConfig = {
            apiKey: "AIzaSyD2g5YhnYOP39NmDMuneGzVEODLBDgzDsY",
            authDomain: "food-services-696c0.firebaseapp.com",
            projectId: "food-services-696c0",
            storageBucket: "food-services-696c0.appspot.com",
            messagingSenderId: "691422152161",
            appId: "1:691422152161:web:607d5fa187705eac51fea0",
            measurementId: "G-474F1FL5KE"
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
        
      messaging.onMessage(function(payload) {
           
           const noteTitle = payload.notification.title;
           const noteOptions = {
               body: payload.notification.body,
               icon: payload.notification.icon,
           };
           new Notification(noteTitle, noteOptions);
       });
</script>
@yield('js')
</body>

</html>