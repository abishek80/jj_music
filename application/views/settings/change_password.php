<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card p-4 mb-3">
            <div class="row g-3">
                <div class="col-lg-2 col-md-6 text-center">
                    <h6 class="mb-3 text-capitalize">Login Code</h6>
                    <h5 class="mb-0 text-capitalize"><?php echo $loginCode; ?></h5>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <h6 class="mb-3 text-capitalize">Name</h6>
                    <h5 class="mb-0 text-capitalize"><?php echo $username; ?></h5>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <h6 class="mb-3 text-capitalize">Mobile Number</h6>
                    <h5 class="mb-0 text-capitalize"><?php echo $mobile; ?></h5>
                </div>
                <div class="col-lg-4 col-md-6 text-center">
                    <h6 class="mb-3 text-capitalize">Email Id</h6>
                    <h5 class="mb-0"><?php echo $email; ?></h5>
                </div>
            </div>
        </div>

        <form id="changePassword" method="post" class="card px-3 pb-3">
            <div class="d-flex justify-content-between align-items-center border-bottom mb-3 pt-3 pb-3 sticky-head flex-wrap gap-3">
                <h4 class="fw-bold mb-0 text-black">Change Password</h4>
                <div class="d-flex gap-3 justify-content-end">
                    <a href="<?php echo base_url(); ?>admin/change_password" class="btn btn-danger px-4 py-2 rounded border-0 fw-bold text-white">Cancel</a>
                    <button type="submit" class="btn btn-success px-4 py-2 rounded border-0 fw-bold text-white">Save</button>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-lg-6 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">Old Password</label>
                    <input name="old_password" id="old_password" type="text" class="form-control" placeholder="Enter Old Password">
                </div>
                <div class="col-lg-6 col-md-6">
                    <label class="w-100 fw-bold text-black mb-2 fs-14px">New Password</label>
                    <input name="new_password" id="new_password" type="text" class="form-control" placeholder="Enter New Password">
                </div>
            </div>
        </form>
    </div>
</div>

<script>
  // Change Password Function
  $("#changePassword").validate({
        rules: {
            old_password: {
                required: true
            },
            new_password: {
                required: true
            }
        },
        messages: {
            old_password: {
                required: "Please Enter Old Password",
            },
            new_password: {
                required: "Please Enter New Password",
            }
        },
        submitHandler: function(form) {
            var data = new FormData($('#changePassword').get(0));
                  $.ajax({
                url: '<?php echo base_url(); ?>changePassword',
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
                        window.location.href = "<?php echo base_url(); ?>logout";
                        }, 1500);
                    }
                  }
              });
        return false;
        }
    });
</script>