<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="<?php echo base_url(); ?>themes/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>JJ Harmony and Arts Academy | Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>themes/images/fav-icon.png" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/demo.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/toast.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/sweetalert.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/vendor/css/page-auth.css" />

    <script src="<?php echo base_url(); ?>themes/datatable/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/validate.js"></script>
</head>

<body>
    <div class="loader">
        <div class="spinner-border text-danger" role="status"></div>
        <img class="loader-img" src="<?php echo base_url(); ?>themes/images/fav-icon.png" alt="loader">
    </div>

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="login-logo-img mx-auto mb-4" style="background-image: url('<?php echo base_url(); ?>themes/images/jjxerox-logo.png');"></div>
                        <h4 class="my-2 text-center">Welcome 👋</h4>
                        <p class="mb-4 text-center">Please Login to Your Account.</p>
                        <form action="#" method="post" id="login" class="login">
                            <div class="form-group mb-50">
                                <div class="mb-3">
                                    <p class="mb-1">User ID or Mobile Number</p>
                                    <input type="text" id="username" name="username" class="form-control" placeholder="User ID or Mobile No">
                                </div>
                                <div class="mb-3 position-relative">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <p class="mb-0">Password</p>
                                        <a href="javascript:void(0);" onclick="togglePasswordVisibility()">
                                            <i class="fs-12 bx bx-hide"></i>
                                            <i class="fs-12 bx bx-show-alt" style="display: none;"></i>
                                        </a>
                                    </div>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                </div>
                                <div class="d-flex justify-content-between align-items-end">
                                    <button class="btn px-4 btn-danger mt-2" id="loginform">Login</button>
                                    <div>
                                        <a href="<?php echo base_url(); ?>login/admin-complaint" class="a-hover">Add Complaint</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(window).on('load', function() {
            $('.loader').hide();
        });

        function oneClickSubmitBtn() {
            $('form').on('submit', function(event) {
                const submitButton = $(this).find('button[type="submit"]'); // Select the submit button within the form
                submitButton.prop('disabled', true); // Disable the button
                submitButton.text('Submitting...'); // Optional: Change button text
            });
        }

        // View Password
        function togglePasswordVisibility() {
        var passwordInput = $('#password');
        var eyeIcon = $('.bx-hide');
        var eyeSlashIcon = $('.bx-show-alt');

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            eyeIcon.hide();
            eyeSlashIcon.show();
        } else {
            passwordInput.attr('type', 'password');
            eyeIcon.show();
            eyeSlashIcon.hide();
        }
        }

        //Login Form Submission 
        $("#login").validate({
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                username: {
                    required: "Please Enter User ID or Mobile no",
                },
                password: {
                    required: "Please Enter Password",
                }
            },
            submitHandler: function (form) {
                var data = new FormData($('form').get(0));
                $.ajax({
                    url: '<?php echo base_url(); ?>login/checklogin',
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
                                window.location = '<?php echo base_url(); ?>';
                            }, 1500);
                        }
                    }
                });
                return false;
            }
        });
    </script>



    <script src="<?php echo base_url(); ?>themes/js/toastr.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/admin.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/jquery.sweet-alert.custom.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/sweetalert.min.js"></script>

    <script src="<?php echo base_url(); ?>themes/vendor/js/helpers.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/config.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/jquery.ajax.js"></script>
    <script src="<?php echo base_url(); ?>themes/vendor/js/menu.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/main.js"></script>
    <script src="<?php echo base_url(); ?>themes/vendor/libs/jquery/jquery.js"></script>
    <script src="<?php echo base_url(); ?>themes/vendor/libs/popper/popper.js"></script>
    <script src="<?php echo base_url(); ?>themes/vendor/js/bootstrap.js"></script>
</body>

</html>