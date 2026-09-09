<section class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <form id="locationForm" method="post" class="card px-3 pb-3">
            <div class="d-flex justify-content-between align-items-center border-bottom mb-3 pt-3 pb-3 sticky-head flex-wrap gap-3">
                <div class="d-flex gap-2 align-items-center">
                    <a href="<?php echo base_url(); ?>location-list" class="fw-bold text-black"><i class="bx bx-chevron-left fs-2 fw-bold text-black"></i></a>
                    <h4 class="fw-bold mb-0 text-black"><?php echo $formTitle; ?></h4>
                </div>
                <div class="d-flex gap-3 justify-content-end">
                    <a href="<?php echo base_url(); ?>location-list" class="btn btn-danger px-4 py-2 rounded border-0 fw-bold text-white">Cancel</a>
                    <button type="submit" class="btn btn-success px-4 py-2 rounded border-0 fw-bold text-white">Save</button>
                </div>
            </div>
            <input name="location_id" id="location_id" type="hidden" value="<?php echo $locationId; ?>">
            <div class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Location Name <span class="text-danger">*</span></label>
                    <input name="location_name" id="location_name" type="text" class="form-control" placeholder="Enter Location Name" value="<?php echo $locationName; ?>">
                </div>
                <div class="col-lg-4 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Fees Amount (₹) <span class="text-danger">*</span></label>
                    <input name="fees_amount" id="fees_amount" type="text" class="form-control decimal" placeholder="Enter Fees Amount" value="<?php echo $feesAmount; ?>">
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
    $("#locationForm").validate({
        rules: {
            location_name: {
                required: true
            },
            fees_amount: {
                required: true,
                number: true
            }
        },
        messages: {
            location_name: {
                required: "Please Enter Location Name"
            },
            fees_amount: {
                required: "Please Enter Fees Amount",
                number: "Please Enter a Valid Number"
            }
        },
        submitHandler: function (form) {
            var data = new FormData($('#locationForm').get(0));
            $.ajax({
                url: '<?php echo base_url(); ?>locationFormSave',
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
                    } else {
                        oneClickSubmitBtn();
                        toastr.success(data['message']);
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url(); ?>location-list";
                        }, 1500);
                    }
                }
            });
            return false;
        }
    });
</script>
