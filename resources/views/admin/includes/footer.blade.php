<!--**********************************
   Footer start
  ***********************************-->
<div class="footer out-footer style-2">
    <div class="copyright">
        <p>Copyright © Developed by <a href="https://dexignlab.com/" target="_blank">Warastra Adhiguna</a> 2023
        </p>
    </div>
</div>

</div>


<!--**********************************
        Main wrapper end
    ***********************************-->

<!--***********************************-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Recent Student title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label mb-2">Student Name</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1"
                                placeholder="James">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2" class="form-label mb-2">Email</label>
                            <input type="email" class="form-control" id="exampleFormControlInput2"
                                placeholder="hello@example.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label mb-2">Gender</label>
                            <select class="default-select wide" aria-label="Default select example">
                                <option selected>Select Option</option>
                                <option value="1">Male</option>
                                <option value="2">Women</option>
                                <option value="3">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput4" class="form-label mb-2">Entery Year</label>
                            <input type="number" class="form-control" id="exampleFormControlInput4"
                                placeholder="EX: 2023">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput5" class="form-label mb-2">Student ID</label>
                            <input type="number" class="form-control" id="exampleFormControlInput5"
                                placeholder="14EMHEE092">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput6" class="form-label mb-2">Phone Number</label>
                            <input type="number" class="form-control" id="exampleFormControlInput6"
                                placeholder="+123456">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!--**********************************
  Modal
 ***********************************-->
<!--**********************************
        Scripts
    ***********************************-->
<!-- Required vendors -->
<script src="{{ asset('admingym/vendor/global/global.min.js') }}"></script>
<script src="{{ asset('admingym/vendor/chart.js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('admingym/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<!-- Apex Chart -->
<script src="{{ asset('admingym/vendor/apexchart/apexchart.js') }}"></script>
<!-- Chart piety plugin files -->
<script src="{{ asset('admingym/vendor/peity/jquery.peity.min.js') }}"></script>
<script src="{{ asset('admingym/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
<!--swiper-slider-->
<script src="{{ asset('admingym/vendor/swiper/js/swiper-bundle.min.js') }}"></script>


<!-- Datatable -->
<script src="{{ asset('admingym/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admingym/js/plugins-init/datatables.init.js') }}"></script>

<!-- Dashboard 1 -->
<script src="{{ asset('admingym/js/dashboard/dashboard-1.js') }}"></script>
<script src="{{ asset('admingym/vendor/wow-master/dist/wow.min.js') }}"></script>
<script src="{{ asset('admingym/vendor/bootstrap-datetimepicker/js/moment.js') }}"></script>
<script src="{{ asset('admingym/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('admingym/vendor/bootstrap-select-country/js/bootstrap-select-country.min.js') }}"></script>

<script src="{{ asset('admingym/js/dlabnav-init.js') }}"></script>
<script src="{{ asset('admingym/js/custom.min.js') }}"></script>
<script src="{{ asset('custom/js/jquery.mask.min.js') }}"></script>

<!-- Required vendors -->
<script src="{{ asset('admingym/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('admingym/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('admingym/vendor/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('admingym/js/plugins-init/select2-init.js') }}"></script>
<script src="{{ asset('admingym/js/dlabnav-init.js') }}"></script>

<!-- Daterangepicker -->
<!-- momment js is must -->
<script src="{{ asset('admingym/vendor/moment/moment.min.js') }}"></script>
<script src="{{ asset('admingym/vendor/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- clockpicker -->
<script src="{{ asset('admingym/vendor/clockpicker/js/bootstrap-clockpicker.min.js') }}"></script>
<!-- asColorPicker -->
<script src="{{ asset('admingym/vendor/jquery-asColor/jquery-asColor.min.js') }}"></script>
<script src="{{ asset('admingym/vendor/jquery-asGradient/jquery-asGradient.min.js') }}"></script>
<script src="{{ asset('admingym/vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js') }}"></script>
<!-- Material color picker -->
<script src="{{ asset('admingym/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}">
</script>
<!-- pickdate -->
<script src="{{ asset('admingym/vendor/pickadate/picker.js') }}"></script>
<script src="{{ asset('admingym/vendor/pickadate/picker.time.js') }}"></script>
<script src="{{ asset('admingym/vendor/pickadate/picker.date.js') }}"></script>



<!-- Daterangepicker -->
<script src="{{ asset('admingym/js/plugins-init/bs-daterange-picker-init.js') }}"></script>
<!-- Clockpicker init -->
<script src="{{ asset('admingym/js/plugins-init/clock-picker-init.js') }}"></script>
<!-- asColorPicker init -->
<script src="{{ asset('admingym/js/plugins-init/jquery-asColorPicker.init.js') }}"></script>
<!-- Material color picker init -->
<script src="{{ asset('admingym/js/plugins-init/material-date-picker-init.js') }}"></script>
<!-- Material color picker -->
<script src="{{ asset('admingym/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}">
</script>
<!-- Pickdate -->
<script src="{{ asset('admingym/js/plugins-init/pickadate-init.js') }}"></script>
<script src="{{ asset('admingym/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('admingym/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
<!-- clockpicker -->
<script src="{{ asset('admingym/vendor/clockpicker/js/bootstrap-clockpicker.min.js') }}"></script>

{{-- Datatables --}}
<script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        let table = new DataTable('#myTable', {
            // Code below useless
            order: [
                [1, 'asc']
            ] // 1 is the column index, 'asc' is for ascending order
        });
    });
</script>


<script>
    @if (Session::has('success'))
        toastr.success("{{ Session::get('success') }}")
    @endif
</script>

<script>
    $(document).ready(function() {
        $('.rupiah').mask("#,##0", {
            reverse: true
        });
    });
</script>

<script>
    function openTrainerSessionDetail(id) {
        var width = 500;
        var height = 400;
        var url = "<?php echo URL::to('/trainer-session/'); ?>" + id;

        var leftPosition, topPosition;
        //Allow for borders.
        leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
        //Allow for title and status bars.
        topPosition = (window.screen.height / 2) - ((height / 2) + 50);
        //Open the window.
        window.open(url, "Window2",
            "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" +
            leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" +
            topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no");
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
    };
</script>

<script>
    // Add this script to handle automatic data saving
    $(document).ready(function() {
        $('#memberCode').on('input', function() {
            // Get the member code value
            var memberCode = $(this).val();

            // Make an AJAX request to save the member code
            $.ajax({
                url: '{{ route('member-check-in.store') }}',
                method: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'member_code': memberCode
                },
                success: function(response) {
                    console.log(response);
                    // You can handle success actions if needed
                },
                error: function(error) {
                    console.log(error);
                    // You can handle error actions if needed
                }
            });
        });
    });
</script>

{{-- <script>
    var loadFile = function(event) {
        var output = document.getElementById('outputEdit');
        output.src = URL.createObjectURL(event.target.files[0]);
    };
</script> --}}

@if (Session::has('message'))
    <script>
        toastr.options = {
            "progressBar": true,
        }
        toastr.success("{{ Session::get('message') }}");
    </script>
@endif

@if (Session::has('error'))
    <script>
        toastr.options = {
            "progressBar": true,
        }
        toastr.error("{{ Session::get('error') }}");
    </script>
@endif

<script>
    document.addEventListener("keydown", e => {
        if (e.key.toLowerCase() === "`") {
            document.getElementById('checkInButton').click();
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('#single-select3').change(function() {
            var numberOfSessions = $(this).find(':selected').data('session');

            $('#remaining-session-input').val(numberOfSessions);
        });
    });
</script>

<!-- Add this script at the end of your HTML body or in a script section -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Set default date value
        var defaultDate = new Date(); // You can set your desired default date here
        var formattedDate = defaultDate.getFullYear() + '-' + ('0' + (defaultDate.getMonth() + 1)).slice(-2) +
            '-' + ('0' + defaultDate.getDate()).slice(-2);
        document.getElementsByClassName("editDate")[0].value = formattedDate;

        // Set default time value
        var defaultTime = defaultDate.getHours() + ':' + ('0' + defaultDate.getMinutes()).slice(-2);
        document.getElementsByClassName("editTime")[0].value = defaultTime;
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Set default date value
        var defaultDate = new Date(); // You can set your desired default date here
        var formattedDate = defaultDate.getFullYear() + '-' + ('0' + (defaultDate.getMonth() + 1)).slice(-2) +
            '-' + ('0' + defaultDate.getDate()).slice(-2);
        document.getElementById("mdate2").value = formattedDate;

        // Set default time value
        var defaultTime = defaultDate.getHours() + ':' + ('0' + defaultDate.getMinutes()).slice(-2);
        document.getElementsByName("start_time2")[0].value = defaultTime;
    });
</script>

<script>
    function showForm(formId) {
        // Hide all forms
        document.getElementById('memberForm').style.display = 'none';
        document.getElementById('memberRegistrationForm').style.display = 'none';
        document.getElementById('trainerSessionForm').style.display = 'none';

        // Show the selected form
        document.getElementById(formId).style.display = 'block';
    }
</script>

<script>
    $('#checkIn2').on('shown.bs.modal', function() {
        $(this).find('[autofocus]').focus();
    });
</script>

{{-- <script>
    $('.checkIn2').on('shown.bs.modal', function() {
        $(this).find('[autofocus]').focus();
    });
</script> --}}


</body>

</html>
