<section class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <form id="studentForm" method="post" class="card px-3 pb-3">
            <div class="d-flex justify-content-between align-items-center border-bottom mb-3 pt-3 pb-3 sticky-head flex-wrap gap-3">
                <div class="d-flex gap-2 align-items-center">
                    <a href="<?php echo base_url(); ?>student-list" class="fw-bold text-black"><i class="bx bx-chevron-left fs-2 fw-bold text-black"></i></a>
                    <h4 class="fw-bold mb-0 text-black"><?php echo $formTitle; ?></h4>
                </div>
                <div class="d-flex gap-3 justify-content-end">
                    <a href="<?php echo base_url(); ?>student-list" class="btn btn-danger px-4 py-2 rounded border-0 fw-bold text-white">Cancel</a>
                    <button type="submit" class="btn btn-success px-4 py-2 rounded border-0 fw-bold text-white">Save</button>
                </div>
            </div>
            <input name="token" id="token" type="hidden" value="<?php echo $token; ?>">
            <input name="student_id" id="student_id" type="hidden" value="<?php echo $studentId; ?>">
            <div class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Student Code <span class="text-danger">*</span></label>
                    <input name="student_code" id="student_code" type="text" class="form-control" readonly placeholder="Enter Student Code" value="<?php echo $studentCode; ?>">
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Student Name <span class="text-danger">*</span></label>
                    <input name="student_name" id="student_name" type="text" class="form-control generate_token" placeholder="Enter Student Name" value="<?php echo $studentName; ?>">
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Class <span class="text-danger">*</span></label>
                    <input name="class" id="class" type="text" class="form-control" placeholder="Enter Class" value="<?php echo $class; ?>">
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Aadhar Number </label>
                    <input name="aadhar_number" id="aadhar_number" type="text" class="form-control" placeholder="Enter Aadhar Number" value="<?php echo $aadharNumber; ?>">
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Joining Date <span class="text-danger">*</span></label>
                    <input name="joining_date" id="joining_date" type="date" class="form-control date-picker" placeholder="YYY  - MM - DD" value="<?php echo $joiningDate; ?>">
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Email</label>
                    <input name="email" id="email" type="email" class="form-control" placeholder="Enter Email" value="<?php echo $email; ?>">
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Phone Number <span class="text-danger">*</span></label>
                    <input name="mobile_number" id="mobile_number" type="text" class="form-control number-only" placeholder="Enter Phone Number" value="<?php echo $mobileNumber; ?>">
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Parent Name <span class="text-danger">*</span></label>
                    <input name="parent_name" id="parent_name" type="text" class="form-control" placeholder="Enter Parent Name" value="<?php echo $parentName; ?>">
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Parent Type <span class="text-danger">*</span></label>
                    <input name="parent_type" id="parent_type" type="text" class="form-control" placeholder="Enter Parent Type" value="<?php echo $parentType; ?>">
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Location <span class="text-danger">*</span></label>
                    <select name="location_id" id="location_id" class="form-select">
                        <option value="">Select Location</option>
                        <?php foreach ($locationList as $loc) { ?>
                            <option value="<?php echo $loc->id; ?>" data-fees="<?php echo $loc->fees_amount; ?>" <?php echo ($locationId == $loc->id) ? 'selected' : ''; ?>><?php echo $loc->location_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Fees Amount (₹) <span class="text-danger">*</span></label>
                    <input name="fees_amount" id="fees_amount" type="text" class="form-control bg-light text-dark fw-bold" placeholder="Fees Amount" value="<?php echo $feesAmount; ?>">
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Address <span class="text-danger">*</span></label>
                    <textarea name="address" id="address" class="form-control" placeholder="Enter Address" style="min-height: 100px;"><?php echo $address; ?></textarea>
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select">
                        <option value="active" <?php echo ($status == 'active') ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo ($status == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</section>


<script>
    $(document).on("change", "#location_id", function() {
        var selectedOpt = $(this).find('option:selected');
        var fees = selectedOpt.data('fees');
        if (fees !== undefined && fees !== '') {
            $('#fees_amount').val(fees);
        } else {
            $('#fees_amount').val('');
        }
    });

    // Student Save Function
    $("#studentForm").validate({
        rules: {
            student_code: {
                required: true
            },
            student_name: {
                required: true
            },
            class: {
                required: true
            },
            joining_date: {
                required: true
            },
            mobile_number: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            parent_name: {
                required: true
            },
            parent_type: {
                required: true
            },
            location_id: {
                required: true
            },
            address: {
                required: true
            }
        },
        messages: {
            student_code: {
                required: "Please Enter Student Code"
            },
            student_name: {
                required: "Please Enter Student Name"
            },
            class: {
                required: "Please Enter Student Class"
            },
            joining_date: {
                required: "Please Enter Joining Date"
            },
            mobile_number: {
                required: "Please Enter Phone Number"
            },
            parent_name: {
                required: "Please Enter Parent Name"
            },
            parent_type: {
                required: "Please Enter Parent Type"
            },
            location_id: {
                required: "Please Select Location"
            },
            address: {
                required: "Please Enter Address"
            }
        },
        submitHandler: function (form) {
            var data = new FormData($('#studentForm').get(0));
            $.ajax({
                url: '<?php echo base_url(); ?>studentFormSave',
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
                            window.location.href = "<?php echo base_url(); ?>student-list";
                        }, 1500);
                    }
                }
            });
            return false;
        }
    });
</script>