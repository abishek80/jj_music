<section class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <form id="studentLeaveForm" method="post" class="card px-3 pb-3">
            <div class="d-flex justify-content-between align-items-center border-bottom mb-3 pt-3 pb-3 sticky-head flex-wrap gap-3">
                <div class="d-flex gap-2 align-items-center">
                    <?php if($studentId) { ?>
                        <a href="<?php echo base_url() . 'attendance-view/' . $year . '/' . $month . '/' . $studentId; ?>" class="fw-bold text-black"><i class="bx bx-chevron-left fs-2 fw-bold text-black"></i></a>
                    <?php } else { ?>
                        <a href="<?php echo base_url() . 'attendance-list/' . $year . '/' . $month; ?>" class="fw-bold text-black"><i class="bx bx-chevron-left fs-2 fw-bold text-black"></i></a>
                    <?php } ?>
                    <h4 class="fw-bold mb-0 text-black"><?php echo $formTitle; ?></h4>
                </div>
                <div class="d-flex gap-3 justify-content-end">
                    <?php if($studentId) { ?>
                        <a href="<?php echo base_url() . 'attendance-view/' . $year . '/' . $month . '/' . $studentId; ?>" class="btn btn-danger px-4 py-2 rounded border-0 fw-bold text-white">Cancel</a>
                    <?php } else { ?>
                        <a href="<?php echo base_url() . 'attendance-list/' . $year . '/' . $month; ?>" class="btn btn-danger px-4 py-2 rounded border-0 fw-bold text-white">Cancel</a>
                    <?php } ?>
                    <button type="submit" class="btn btn-success px-4 py-2 rounded border-0 fw-bold text-white">Save</button>
                </div>
            </div>
            <input name="leave_id" id="leave_id" type="hidden" value="<?php echo $leaveId; ?>">
            <div class="row g-3">
                <div class="col-lg-3 col-md-4">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Student Name <span class="text-danger">*</span></label>
                    <select name="student_name" id="student_name" class="form-select select2 selectStudentName">
                        <option value="">Select Student Name</option>
                        <?php foreach ($studentDropdown as $row) { ?>
                            <option value="<?php echo $row->id; ?>" <?php if($studentId == $row->id) { echo 'selected'; } ?>><?php echo $row->student_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-3 col-md-4">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Student Code</label>
                    <input name="student_code" id="student_code" readonly type="text" class="studentCode form-control" placeholder="Enter Student Code" value="<?php echo $studentCode; ?>">
                </div>
                <div class="col-lg-3 col-md-4">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Student Class</label>
                    <input name="class" id="class" readonly type="text" class="studentClass form-control" placeholder="Enter Student Class" value="<?php echo $class; ?>">
                </div>
                <div class="col-lg-3 col-md-4">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Start Date <span class="text-danger">*</span></label>
                    <input name="leave_date" id="leave_date" type="date" class="form-control date-picker leaveDate" placeholder="YYYY - MM - DD" value="<?php echo $leaveDate; ?>">
                </div>
                <div class="col-lg-3 col-md-4">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">End Date <span class="text-danger">*</span></label>
                    <input name="joining_date" id="joining_date" type="date" class="form-control date-picker joiningDate" placeholder="YYYY - MM - DD" value="<?php echo $joiningDate; ?>">
                </div>
                <div class="col-lg-3 col-md-4">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Leave Count <span class="text-danger">*</span></label>
                    <input name="leave_count" id="leave_count" type="text" readonly class="form-control number-only leaveCount" placeholder="Enter Leave Count" value="<?php echo $leaveCount; ?>">
                </div>
                <div class="col-lg-3 col-md-4">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Reason <span class="text-danger">*</span></label>
                    <input name="reason" id="reason" type="text" class="form-control" placeholder="Enter Reason" value="<?php echo $reason; ?>">
                </div>
                <div class="col-lg-3 col-md-4">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="approved" <?php if($status == 'approved') { echo 'selected'; } ?>>Approved</option>
                        <option value="not_approved" <?php if($status == 'not_approved') { echo 'selected'; } ?>>Not Approved</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    $(document).ready(function () {
        // Clear joining date when leave date changes
        $('.leaveDate').change(function () {
            $('.joiningDate').val(''); // Clear the joining date input
            $('.leaveCount').val(''); // Reset leave count
        });

        $('.joiningDate').change(function () {
            var leaveDate = $('.leaveDate').val();
            var joiningDate = $(this).val();

            if (leaveDate && joiningDate) {
                // Convert string dates to Date objects
                var startDate = new Date(leaveDate);
                var endDate = new Date(joiningDate);

                // Calculate the difference in days
                var timeDifference = endDate - startDate;
                var dayDifference = timeDifference / (1000 * 60 * 60 * 24); // Convert milliseconds to days

                if (dayDifference >= 0) {
                    $('.leaveCount').val(dayDifference + 1); // Always add 1 extra day
                } else {
                    $('.leaveCount').val('Invalid Date'); // Handle incorrect date selections
                }
            } else {
                $('.leaveCount').val('');
            }
        });

        
        $('.selectStudentName').change(function () {
            var selectedStudentName = $(this).val();
            if (selectedStudentName !== '') {
                $.ajax({
                    url: "<?php echo base_url('studentDetail'); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        studentId: selectedStudentName
                    },
                    success: function (data) {
                        studentId = data[0].id;
                        studentClass = data[0].class;
                        studentCode = data[0].student_code;
                        $('.studentId').val(studentId);
                        $('.studentCode').val(studentCode);
                        $('.studentClass').val(studentClass);
                    }
                });
            }
        });
    });

    // PAN Save Function
    $("#studentLeaveForm").validate({
        rules: {
            student_name: {
                required: true
            },
            leave_date: {
                required: true
            },
            joining_date: {
                required: true
            },
            leave_count: {
                required: true
            },
            reason: {
                required: true
            }
        },
        messages: {
            student_name: {
                required: "Please Select Student Name",
            },
            leave_date: {
                required: "Please Select Leave Date",
            },
            joining_date: {
                required: "Please Select Joining Date",
            },
            leave_count: {
                required: "Please Enter Leave Count",
            },
            reason: {
                required: "Please Enter Reason",
            }
        },
        submitHandler: function (form) {
            var data = new FormData($('#studentLeaveForm').get(0));
            $.ajax({
                url: '<?php echo base_url(); ?>studentLeaveFormSave',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                method: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    $(".loader").show();
                },
                success: function (data) {
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
                            <?php if($studentId) { ?>
                                window.location.href = "<?php echo base_url() . 'attendance-view/' . $year . '/' . $month . '/' . $studentId; ?>";
                            <?php } else { ?>
                                window.location.href = "<?php echo base_url() . 'attendance-list/' . $year . '/' . $month; ?>";
                            <?php } ?>
                        }, 1500);
                    }
                }
            });
            return false;
        }
    });
</script>