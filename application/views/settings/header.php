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
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/datatable/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/select2.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/lightbox.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/dropzone.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/flatpickr.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/css/magnifypopup.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/image-uploader/image-uploader.css">

    <script src="<?php echo base_url(); ?>themes/datatable/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>themes/js/validate.js"></script>
    <script src="<?php echo base_url(); ?>themes/image-uploader/image-uploader.js"></script>
</head>

<body>
    <div class="loader">
        <div class="spinner-border text-danger" role="status"></div>
        <img class="loader-img" src="<?php echo base_url(); ?>themes/images/fav-icon.png" alt="loader">
    </div>

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo justify-content-center">
                    <a href="<?php echo base_url(); ?>" class="app-brand-link">
                        <div class="logo-img" style="background-image: url('<?php echo base_url(); ?>themes/images/jjxerox-logo.png');"></div>
                    </a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-lg-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>
                <!-- <div class="menu-inner-shadow"></div> -->
                <ul class="menu-inner py-1">
                    <li class="menu-item <?php echo $menu_status == 'dashboard' ? 'active' : ''; ?>">
                        <a href="<?php echo base_url(); ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-alt"></i>
                            <div data-i18n="Dashboard">Dashboard</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo $menu_status == 'attendance' ? 'active' : ''; ?>">
                        <a href="<?php echo base_url() . 'attendance-list/' . date('Y') . '/' . strtolower(date('F')); ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-calendar"></i>
                            <div data-i18n="Attendance">Attendance</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo $menu_status == 'fees' ? 'active' : ''; ?>">
                        <a href="<?php echo base_url() . 'fees-list/' . date('Y'); ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-dollar-circle"></i>
                            <div data-i18n="Fees">Fees</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo $menu_status == 'student' ? 'active' : ''; ?>">
                        <a href="<?php echo base_url(); ?>student-list" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-user"></i>
                            <div data-i18n="Students">Students</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo $menu_status == 'location' ? 'active' : ''; ?>">
                        <a href="<?php echo base_url(); ?>location-list" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-map-pin"></i>
                            <div data-i18n="Location Master">Location Master</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo $menu_status == 'reports' ? 'active' : ''; ?>">
                        <a href="<?php echo base_url(); ?>reports" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-file-blank"></i>
                            <div data-i18n="Reports">Reports</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo $menu_status == 'general-settings' ? 'active' : ''; ?>">
                        <a href="<?php echo base_url(); ?>general-settings" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-cog"></i>
                            <div data-i18n="Settings">General Settings</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo $menu_status == 'change-password' ? 'active' : ''; ?>">
                        <a href="<?php echo base_url() . 'change-password'; ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-key"></i>
                            <div data-i18n="Change Password">Change Password</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo $menu_status == 'logout' ? 'active' : ''; ?>">
                        <a href="<?php echo base_url() . 'logout'; ?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-power-off"></i>
                            <div data-i18n="Logout">Logout</div>
                        </a>
                    </li>
                </ul>
            </aside>
            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="<?php echo base_url(); ?>themes/images/avatar.png" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>profile">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="<?php echo base_url(); ?>themes/images/avatar.png" alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block"><?php echo $this->session->userdata('username'); ?></span>
                                                    <small class="text-muted"><?php echo $this->session->userdata('logincode'); ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>general-settings">
                                            <i class="bx bx-cog me-2"></i>
                                            <span class="align-middle">General Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>change_password">
                                            <i class="bx bx-key me-2"></i>
                                            <span class="align-middle">Change Password</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>logout">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>