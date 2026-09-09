<section class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex flex-wrap gap-2 gap-md-3 mb-3">
            <a href="<?php echo base_url(); ?>student-list" class="<?php echo ($activeLink == '') ? 'bg-primary text-white' : 'bg-white text-primary'; ?> px-4 py-2 px-md-5 shadow shadow-sm fw-bold lh-1 rounded-2 border-primary border border-3 border-end-0 border-start-0 border-top-0">All</a>
            <a href="<?php echo base_url(); ?>student-list/active" class="<?php echo ($activeLink == 'active') ? 'bg-success text-white' : 'bg-white text-success'; ?> px-4 py-2 px-md-5 shadow shadow-sm fw-bold lh-1 rounded-2 border-success border border-3 border-end-0 border-start-0 border-top-0">Active</a>
            <a href="<?php echo base_url(); ?>student-list/inactive" class="<?php echo ($activeLink == 'inactive') ? 'bg-danger text-white' : 'bg-white text-danger'; ?> px-4 py-2 px-md-5 shadow shadow-sm fw-bold lh-1 rounded-2 border-danger border border-3 border-end-0 border-start-0 border-top-0">Inactive</a>
        </div>
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center border-bottom mb-3 pb-3 flex-wrap gap-3">
                <h4 class="fw-bold mb-0 text-black">Student List</h4>
                <a href="<?php echo base_url(); ?>student-add" class="btn btn-primary px-4 py-2 rounded text-white">Add Student</a>
            </div>
            <div class="table-responsive">
                <table class="zero_config table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th class="w-min-40">S. No</th>
                        <th>Student Code</th>
                        <th>Student Name & Class</th>
                        <th>Parent Name & Type</th>
                        <th>Mobile Number & Email</th>
                        <th>status</th>
                        <th class="w-min-50">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i=1;
                            foreach ($studentList as $row) { 
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row->student_code; ?></td>
                            <td>
                                <p class="mb-1"><?php echo $row->student_name; ?></p>
                                <p class="mb-0"><?php echo $row->class; ?></p>
                            </td>
                            <td>
                                <p class="mb-1"><?php echo $row->parent_name; ?></p>
                                <p class="mb-0"><?php echo $row->parent_type; ?></p>
                            </td>
                            <td>
                                <a href="tel:<?php echo $row->mobile_number; ?>" class="d-block mb-1"><?php echo $row->mobile_number; ?></a>
                                <a href="mailto:<?php echo $row->email; ?>" class="d-block mb-0"><?php echo $row->email; ?></a>
                            </td>
                            <td>
                                <?php if($row->status == 'active') { ?>
                                    <a href="javascript:void(0);" data-value="inactive" data-tablename="student" data-rowid="<?php echo $row->id; ?>" data-link="<?php echo base_url(); ?>student-list" class="text-success changeStatus" data-toggle="tooltip" data-placement="top" title="Status Change"> Active </a>
                                <?php } elseif($row->status == 'inactive') { ?>
                                    <a href="javascript:void(0);" data-value="active" data-tablename="student" data-rowid="<?php echo $row->id; ?>" data-link="<?php echo base_url(); ?>student-list" class="text-danger changeStatus" data-toggle="tooltip" data-placement="top" title="Status Change"> Inactive </a>
                                <?php } ?>
                            </td>
                            <td class="px-2">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="javascript:void(0);" class="box-hover getstudentId" data-studentid="<?php echo $row->id; ?>" data-bs-toggle="modal" data-bs-target="#view_modal" data-toggle="tooltip" data-placement="top" title="View"> <i class="bx bx-show-alt"></i> </a>
                                    <a href="<?php echo base_url() . 'student-edit/' . $row->id; ?>" class="box-hover" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="bx bx-edit-alt"></i> </a>
                                    <a href="javascript:void(0);" data-rowid="<?php echo $row->id; ?>" data-tablename="student" data-link="<?php echo base_url(); ?>student-list" class="box-hover trashItem" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="bx bx-trash"></i> </a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="view_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mb-3 border-bottom pb-3">
                    <div class="float-end">
                        <a href="javascript:void(0);" class="w-px-30 h-px-30 bg-label-dark rounded-circle d-flex align-items-center justify-content-center" data-bs-dismiss="modal">
                            <i class="bx bx-x text-black"></i>
                        </a>
                    </div>
                    <div id="headingTitle"></div>
                </div>
                <div class="row g-3">
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="w-100 fw-bold text-black mb-1">Student Code</label>
                        <div id="studentCode" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="w-100 fw-bold text-black mb-1">Student Name</label>
                        <div id="studentName" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="w-100 fw-bold text-black mb-1">Class</label>
                        <div id="class" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 aadharNumber">
                        <label class="w-100 fw-bold text-black mb-1">Aadhar Number</label>
                        <div id="aadharNumber" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="w-100 fw-bold text-black mb-1">Joining Date</label>
                        <div id="joiningDate" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 email">
                        <label class="w-100 fw-bold text-black mb-1">Email</label>
                        <div id="email" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="w-100 fw-bold text-black mb-1">Phone Number</label>
                        <div id="mobileNumber" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="w-100 fw-bold text-black mb-1">Parent Name</label>
                        <div id="parentName" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="w-100 fw-bold text-black mb-1">Parent Type</label>
                        <div id="parentType" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="w-100 fw-bold text-black mb-1">Address</label>
                        <div id="address" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="w-100 fw-bold text-black mb-1">Status</label>
                        <div id="status" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="w-100 fw-bold text-black mb-1">Created By</label>
                        <div id="createdBy" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="w-100 fw-bold text-black mb-1">Created At</label>
                        <div id="createdAt" class="text-capitalize text-black"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".getstudentId", function(e){
        var studentId = $(this).data("studentid");
        $.ajax({
            type: "POST",
            headers: {
                "X-CSRFToken": csrftoken
            },
            url: '<?php echo base_url(); ?>getStudentDetail',
            dataType: "json",
            data: {studentId},
            success: function (data) {
                $('#headingTitle').html('<h5 class="mb-0 text-black text-center lh-base fw-bold text-capitalize">' + data.studentName + ' Details</h5>');
                $('#studentCode').html(data.studentCode);
                $('#studentName').html(data.studentName);
                $('#class').html(data.class);
                $('#aadharNumber').html(data.aadharNumber);
                $('#joiningDate').html(data.joiningDate);
                $('#email').html(data.email);
                $('#mobileNumber').html(data.mobileNumber);
                $('#parentName').html(data.parentName);
                $('#parentType').html(data.parentType);
                $('#address').html(data.address);
                $('#status').html(data.status);
                $('#createdBy').html(data.createdBy);
                $('#createdAt').html(data.createdAt);
                
                if (data.email) {
                    $('#email').html(data.email);
                    $('.email').removeClass('d-none');
                } else {
                    $('.email').addClass('d-none');
                }
                
                if (data.aadharNumber) {
                    $('#aadharNumber').html(data.aadharNumber);
                    $('.aadharNumber').removeClass('d-none');
                } else {
                    $('.aadharNumber').addClass('d-none');
                }
            }
        });
        e.preventDefault();
        return false;
    });
</script>