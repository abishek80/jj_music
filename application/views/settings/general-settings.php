<section class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <form id="settingsForm" enctype="multipart/form-data" method="post" class="card px-3 pb-3">
            <div class="d-flex justify-content-between align-items-center border-bottom mb-3 pt-3 pb-3 sticky-head flex-wrap gap-3">
                <h4 class="fw-bold mb-0">General Settings</h4>
                <button type="submit" class="btn btn-primary subBtn">Save Settings</button>
            </div>
            <div class="row g-3">
                <div class="col-lg-4 col-md-6 text-center border-right">
                    <label class="w-100 fw-bold text-black mb-3">Company Logo  <span class="text-danger">*</span></label>
                    <div class="mb-3">
                        <?php $logo = !empty($settings->company_logo) ? base_url('uploads/images/' . $settings->company_logo) : base_url('assets/img/avatars/1.png'); ?>
                        <img src="<?php echo $logo; ?>" alt="logo" class="d-block rounded mb-3 mx-auto" height="150" width="150" id="logoPreview">
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload Logo</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" id="company_logo" name="company_logo" class="account-file-input" hidden accept="image/png, image/jpeg" onchange="previewImage(this)">
                            </label>
                            <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 2MB</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-6">
                    <div class="row g-3">
                        <div class="col-lg-6 col-12">
                            <label class="w-100 fw-bold text-black mb-2 fs-14px">Company Name  <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo $settings->company_name ?? ''; ?>" placeholder="Enter Company Name">
                        </div>
                        <div class="col-lg-6 col-12">
                            <label class="w-100 fw-bold text-black mb-2 fs-14px">Company Email  <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="company_email" name="company_email" value="<?php echo $settings->company_email ?? ''; ?>" placeholder="Enter Company Email">
                        </div>
                        <div class="col-lg-6 col-12">
                            <label class="w-100 fw-bold text-black mb-2 fs-14px">Company Phone  <span class="text-danger">*</span></label>
                            <input type="text" class="form-control decimal" id="company_phone" name="company_phone" value="<?php echo $settings->company_phone ?? ''; ?>" placeholder="Enter Company Phone">
                        </div>
                        <div class="col-12">
                            <label class="w-100 fw-bold text-black mb-2 fs-14px">Company Address  <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="company_address" name="company_address" rows="3" placeholder="Enter Company Address"><?php echo $settings->company_address ?? ''; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#logoPreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function() {
        $('#settingsForm').on('submit', function(e) {
            e.preventDefault();
            $('.subBtn').prop('disabled', true).html('Saving...');

            var company_name = $('#company_name').val();
            var company_email = $('#company_email').val();
            var company_phone = $('#company_phone').val();
            var company_address = $('#company_address').val();

            if(company_name == '') {
                toastr.error('Company Name is required');
                $('.subBtn').prop('disabled', false).html('Save Settings');
                return;
            }

            if(company_email == '') {
                toastr.error('Company Email is required');
                $('.subBtn').prop('disabled', false).html('Save Settings');
                return;
            }

            if(company_phone == '') {
                toastr.error('Company Phone is required');
                $('.subBtn').prop('disabled', false).html('Save Settings');
                return;
            }

            if(company_address == '') {
                toastr.error('Company Address is required');
                $('.subBtn').prop('disabled', false).html('Save Settings');
                return;
            }
            
            var formData = new FormData(this);
            
            $.ajax({
                url: '<?php echo base_url(); ?>saveGeneralSettings',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(data) {
                    if(data.isError) {
                        toastr.error(data.message);
                    } else {
                        toastr.success(data.message);
                    }
                    $('.subBtn').prop('disabled', false).html('Save Settings');
                },
                error: function() {
                    toastr.error('Something went wrong');
                    $('.subBtn').prop('disabled', false).html('Save Settings');
                }
            });
        });
    });
</script>
