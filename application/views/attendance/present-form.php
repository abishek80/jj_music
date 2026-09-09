<section class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <form id="attendanceForm" method="post" class="card px-3 pb-3">
            <div class="d-flex justify-content-between align-items-center border-bottom mb-3 pt-3 pb-3 sticky-head flex-wrap gap-3">
                <div class="d-flex gap-2 align-items-center">
                    <a href="<?php echo base_url() . 'attendance-list/' . $year . '/' . $month; ?>" class="fw-bold text-black"><i class="bx bx-chevron-left fs-2 fw-bold text-black"></i></a>
                    <h4 class="fw-bold mb-0 text-black"><?php echo $formTitle; ?></h4>
                </div>
                <div class="d-flex gap-3 justify-content-end">
                    <a href="<?php echo base_url() . 'attendance-list/' . $year . '/' . $month; ?>" class="btn btn-danger px-4 py-2 rounded border-0 fw-bold text-white">Cancel</a>
                    <button type="submit" class="btn btn-success px-4 py-2 rounded border-0 fw-bold text-white">Save</button>
                </div>
            </div>
            <input name="attendance_id" id="attendance_id" type="hidden" value="<?php echo $attendanceId; ?>">
            <div class="row g-3">
                <div class="col-lg-3 col-md-6 col-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Date <span class="text-danger">*</span></label>
                    <input name="present_date" id="present_date" type="date" class="form-control date-picker presentDate" placeholder="YYYY - MM - DD" value="<?php echo $presentDate; ?>">
                </div>
                <div class="col-lg-3 col-md-6 col-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Location</label>
                    <select name="location_id" id="location_id" class="form-select locationFilter">
                        <option value="">All Locations</option>
                        <?php foreach ($locationList as $loc) { ?>
                            <option value="<?php echo $loc->id; ?>"><?php echo $loc->location_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-12">
                    <div class="mt-2 table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Student Name</th>
                                    <th>Class</th>
                                    <th>Location</th>
                                    <th>Attendance Type</th>
                                </tr>
                            </thead>
                            <tbody id="studentTableBody">
                                <tr>
                                    <td colspan="5" class="text-center">Select a date to view attendance</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>


<script>
    function loadAttendanceStudents() {
        var selectedAttendanceDate = $('.presentDate').val();
        var selectedLocationId = $('.locationFilter').val();

        if (selectedAttendanceDate !== '') {
            var tbody = $('#studentTableBody');
            tbody.html('<tr><td colspan="5" class="text-center">Loading...</td></tr>');

            $.ajax({
                url: "<?php echo base_url('attendanceStudentList'); ?>",
                type: "POST",
                dataType: "json",
                data: {
                    attendanceDate: selectedAttendanceDate,
                    locationId: selectedLocationId
                },
                success: function (data) {
                    tbody.empty();

                    if (Array.isArray(data) && data.length > 0) {
                        $.each(data, function (index, row) {
                            var html = '<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + (row.student_name || 'N/A') + '</td>' +
                                '<td>' + (row.class || 'N/A') + '</td>' +
                                '<td>' + (row.location_name || 'N/A') + '</td>' +
                                '<td>' +
                                    '<input name="student_id[]" value="' + row.id + '" type="hidden">' +
                                    '<select name="attendance_type[]" class="form-select">' +
                                        '<option value="">Select Attendance</option>' +
                                        '<option value="present">Present</option>' +
                                        '<option value="absent">Absent</option>' +
                                    '</select>' +
                                '</td>' +
                            '</tr>';
                            tbody.append(html);
                        });
                    } else {
                        tbody.append('<tr><td colspan="5" class="text-center">No student found</td></tr>');
                    }
                },
                error: function () {
                    tbody.html('<tr><td colspan="5" class="text-danger text-center">Error loading data</td></tr>');
                }
            });
        }
    }

    $(document).on("change", ".presentDate, .locationFilter", function () {
        loadAttendanceStudents();
    });


    // Save Attendance Form
    $("#attendanceForm").validate({
        rules: {
            present_date: {
                required: true
            }
        },
        messages: {
            present_date: {
                required: "Please Select Date",
            }
        },
        submitHandler: function(form) {
            var data = new FormData($('#attendanceForm').get(0));

            $.ajax({
                url: '<?php echo base_url(); ?>studentAttendanceSaveForm',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                method: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    $(".loader").show();
                },
                success: function(data) {
                    toastr.options = {
                        'closeButton': true,
                        'debug': false,
                        'newestOnTop': false,
                        'progressBar': false,
                        'positionClass': 'toast-top-right',
                        'preventDuplicates': false,
                        'showDuration': '1000',
                        'hideDuration': '1000',
                        'timeOut': '5000',
                        'extendedTimeOut': '1000',
                        'showEasing': 'swing',
                        'hideEasing': 'linear',
                        'showMethod': 'fadeIn',
                        'hideMethod': 'fadeOut',
                    }
                    $(".loader").hide();
                    if (data['isError']) {
                        toastr.error(data['message']);
                    }
                    else {
                        oneClickSubmitBtn();
                        toastr.success(data['message']);
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() . 'attendance-list/' . $year . '/' . $month; ?>";
                        }, 1500);
                    }
                }
            });
            return false;
        }
    });
</script>