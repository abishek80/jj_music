<section class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <form id="feesForm" method="post" class="card px-3 pb-3">
            <div class="d-flex justify-content-between align-items-center border-bottom mb-3 pt-3 pb-3 sticky-head flex-wrap gap-3">
                <div class="d-flex gap-2 align-items-center">
                    <?php if($year && $studentId) { ?>
                        <a href="<?php echo base_url() . 'fees-view/' . $year . '/' . $studentId; ?>" class="fw-bold text-black"><i class="bx bx-chevron-left fs-2 fw-bold text-black"></i></a>
                    <?php } else { ?>
                        <a href="<?php echo base_url(); ?>fees-list" class="fw-bold text-black"><i class="bx bx-chevron-left fs-2 fw-bold text-black"></i></a>
                    <?php } ?>
                    <h4 class="fw-bold mb-0 text-black"><?php echo $formTitle; ?></h4>
                </div>
                <div class="d-flex gap-3 justify-content-end">
                    <?php if($year && $studentId) { ?>
                        <a href="<?php echo base_url() . 'fees-view/' . $year . '/' . $studentId; ?>" class="btn btn-danger px-4 py-2 rounded border-0 fw-bold text-white">Cancel</a>
                    <?php } else { ?>
                        <a href="<?php echo base_url(); ?>fees-list" class="btn btn-danger px-4 py-2 rounded border-0 fw-bold text-white">Cancel</a>
                    <?php } ?>
                    <button type="submit" class="btn btn-success px-4 py-2 rounded border-0 fw-bold text-white">Save</button>
                </div>
            </div>
            <input name="fees_id" id="fees_id" type="hidden" value="<?php echo $feesId; ?>">
            <input name="student_id" id="student_id" type="hidden" value="<?php echo $studentId; ?>">
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
                <div class="col-lg-3 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Fees Year <span class="text-danger">*</span></label>
                    <select name="year" id="year" class="form-select">
                        <?php 
                        $currentYear = date('Y');
                        for($y = $currentYear - 2; $y <= $currentYear + 5; $y++) { ?>
                            <option value="<?php echo $y; ?>" <?php if($year == $y) { echo 'selected'; } ?>><?php echo $y; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Fees Month <span class="text-danger">*</span></label>
                    <select name="month" id="month" class="form-select">
                        <option value="">Select Month</option>
                        <?php 
                        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                        foreach($months as $m) { ?>
                            <option value="<?php echo $m; ?>" <?php if($_GET['month'] == $m) { echo 'selected'; } ?>><?php echo $m; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Fee Amount <span class="text-danger">*</span></label>
                    <input name="fee_amount" id="fee_amount" type="text" class="form-control decimal" placeholder="Enter Fee Amount" value="<?php echo $feeAmount; ?>">
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Payment Date <span class="text-danger">*</span></label>
                    <input name="payment_date" id="payment_date" type="text" class="form-control date-picker" placeholder="YYYY - MM - DD" value="<?php echo $paymentDate ?? date('Y-m-d'); ?>">
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Payment Method <span class="text-danger">*</span></label>
                    <select name="payment_method" id="payment_method" class="form-select">
                        <option value="">Select Payment Method</option>
                        <option value="Cash" <?php if($paymentMethod == 'Cash') { echo 'selected'; } ?>>Cash</option>
                        <option value="UPI" <?php if($paymentMethod == 'UPI') { echo 'selected'; } ?>>UPI</option>
                        <option value="Bank" <?php if($paymentMethod == 'Bank') { echo 'selected'; } ?>>Bank</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Payment Status <span class="text-danger">*</span></label>
                    <select name="payment_status" id="payment_status" class="form-select">
                        <option value="paid" <?php if($paymentStatus == 'paid') { echo 'selected'; } ?>>Paid</option>
                        <option value="unpaid" <?php if($paymentStatus == 'unpaid') { echo 'selected'; } ?>>Unpaid</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</section>


<script>
    var studentId = '<?php echo $studentId; ?>';
    $(document).ready(function() {
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
                        var res = data[0];
                        studentId = res.id;
                        $('#student_id').val(res.id);
                        $('#student_code').val(res.student_code);
                        $('#class').val(res.class);
                        if (res.fees_amount && parseFloat(res.fees_amount) > 0) {
                            $('#fee_amount').val(res.fees_amount);
                        }
                    }
                });
            }
        });
    });
    
    // Fees Save Function
    $("#feesForm").validate({
        rules: {
            student_name: {
                required: true
            },
            month: {
                required: true
            },
            year: {
                required: true
            },
            fee_amount: {
                required: true
            },
            payment_date: {
                required: true
            },
            payment_method: {
                required: true
            },
            payment_status: {
                required: true
            }
        },
        messages: {
            student_name: {
                required: "Please Select Student Name"
            },
            month: {
                required: "Please Select Fees Month"
            },
            year: {
                required: "Please Select Fees Year"
            },
            fee_amount: {
                required: "Please Enter Fee Amount"
            },
            payment_date: {
                required: "Please Enter Payment Date"
            },
            payment_method: {
                required: "Please Select Payment Method"
            },
            payment_status: {
                required: "Please Select Payment Status"
            }
        },
        submitHandler: function (form) {
            var data = new FormData($('#feesForm').get(0));
            $.ajax({
                url: '<?php echo base_url(); ?>feesFormSave',
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
                            if(studentId) {
                                window.location.href = "<?php echo base_url() . 'fees-view/' . $year . '/' . $studentId; ?>";
                            } else {
                                window.location.href = "<?php echo base_url(); ?>fees-list";
                            }
                        }, 1500);
                    }
                }
            });
            return false;
        }
    });
</script>