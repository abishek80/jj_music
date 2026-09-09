<section class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card p-3 mb-4">
            <div class="row g-3">
                <div class="col-lg-3 col-6">
                    <p class="mb-2">Student Code</p>
                    <h6 class="mb-0"><?php echo $studentCode; ?></h6>
                </div>
                <div class="col-lg-3 col-6">
                    <p class="mb-2">Student Name</p>
                    <h6 class="mb-0"><?php echo $studentName; ?></h6>
                </div>
                <div class="col-lg-3 col-6">
                    <p class="mb-2">Student Class</p>
                    <h6 class="mb-0"><?php echo $studentClass; ?></h6>
                </div>
                <div class="col-lg-3 col-6">
                    <p class="mb-2">Aadhar Number</p>
                    <h6 class="mb-0"><?php echo $aadharNumber; ?></h6>
                </div>
                <div class="col-12 m-0"></div>
                <div class="col-lg-3 col-6">
                    <p class="mb-2">Parent Name & Type</p>
                    <h6 class="mb-2"><?php echo $parentName; ?></h6>
                    <h6 class="mb-0"><?php echo $parentType; ?></h6>
                </div>
                <div class="col-lg-3 col-6">
                    <p class="mb-2">Mobile Number & Email</p>
                    <a href="tel:<?php echo $mobileNumber; ?>" class="mb-1"><?php echo $mobileNumber; ?></a>
                    <a href="mailto:<?php echo $email; ?>" class="mb-0"><?php echo $email; ?></a>
                </div>
                <div class="col-lg-3 col-6">
                    <p class="mb-2">Address</p>
                    <h6 class="mb-0"><?php echo $address; ?></h6>
                </div>
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-lg-4 text-center col-6">
                <div class="card p-3">
                    <p class="mb-2">Joining Date</p>
                    <h5 class="mb-0"><?php echo $joiningDate; ?></h5>
                </div>
            </div>
            <div class="col-lg-4 text-center col-6">
                <div class="card p-3">
                    <p class="mb-2">Overall Paid Amount</p>
                    <h5 class="mb-0 amount-format"><?php echo $overallPaidAmount; ?></h5>
                </div>
            </div>
            <div class="col-lg-4 text-center col-6">
                <div class="card p-3">
                    <p class="mb-2">Overall Unpaid Amount</p>
                    <h5 class="mb-0 amount-format"><?php echo $overallUnPaidAmount; ?></h5>
                </div>
            </div>
        </div>
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center border-bottom mb-3 pb-3 flex-wrap gap-3">
                <div class="d-flex gap-2 align-items-center">
                    <a href="<?php echo base_url() . 'fees-list' . '/' . $selectedYear; ?>" class="fw-bold text-black"><i class="bx bx-chevron-left fs-2 fw-bold text-black"></i></a>
                    <h4 class="fw-bold mb-0 text-black">Fees History</h4>
                </div>
                <?php if($status == 'active' && $deleteStatus == 0) { ?>
                    <a href="<?php echo base_url() . 'fees-add/' . $selectedYear . '/' . $studentId; ?>" class="btn btn-primary px-4 py-2 rounded text-white">Add Fees</a>
                <?php } ?>
            </div>
            <div class="table-responsive">
                <table class="zero_config table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="w-min-40">S. No</th>
                            <th>Month</th>
                            <th>Payment Date</th>
                            <th>Fee Amount</th>
                            <th>Payment Method</th>
                            <th>Payment Status</th>
                            <th class="w-min-50">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i=1;
                            foreach ($feesList as $row) { 
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td class="text-capitalize"><?php echo $row->month; ?></td>
                            <td><?php echo $row->payment_date; ?></td>
                            <td><?php echo $row->fee_amount; ?></td>
                            <td><?php echo $row->payment_method; ?></td>
                            <td>
                                <?php if($row->status == 'paid') { ?>
                                    <span class="text-success">Paid</span>
                                <?php } elseif($row->status == 'unpaid') { ?>
                                    <span class="text-danger">Unpaid</span>
                                <?php } ?>
                            </td>
                            <td class="px-2">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="javascript:void(0);" data-student-id="<?php echo $studentId; ?>" data-month="<?php echo $row->month_name; ?>" data-year="<?php echo $selectedYear; ?>" data-feesid="<?php echo $row->id; ?>" class="box-hover getfeesId" data-bs-toggle="modal" data-bs-target="#view_modal" data-toggle="tooltip" data-placement="top" title="View"> <i class="bx bx-show-alt"></i> </a>
                                    <?php if($row->status == 'paid') { ?>
                                        <a href="<?php echo base_url(); ?>fees-invoice/<?php echo $row->id; ?>" target="_blank" class="box-hover ms-2" data-toggle="tooltip" data-placement="top" title="Invoice"> <i class="bx bx-printer"></i> </a>
                                    <?php } ?>
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
                    <div class="col-lg-3 col-md-4 col-sm-6 invoiceNo d-none">
                        <label class="w-100 fw-bold text-black mb-1">Invoice No</label>
                        <div id="invoiceNo" class="text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="w-100 fw-bold text-black mb-1">Student Name</label>
                        <div id="studentName" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="w-100 fw-bold text-black mb-1">Class</label>
                        <div id="class" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="w-100 fw-bold text-black mb-1">Aadhar Card</label>
                        <div id="aadharCard" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="w-100 fw-bold text-black mb-1">Joining Date</label>
                        <div id="joiningDate" class="text-capitalize text-black"></div>
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
                        <label class="w-100 fw-bold text-black mb-1">Mobile Number</label>
                        <div id="mobileNumber" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="w-100 fw-bold text-black mb-1">Email</label>
                        <div id="email" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="w-100 fw-bold text-black mb-1">Address</label>
                        <div id="address" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 feeAmount d-none">
                        <label class="w-100 fw-bold text-black mb-1">Fee Amount</label>
                        <div id="feeAmount" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 paymentDate d-none">
                        <label class="w-100 fw-bold text-black mb-1">Payment Date</label>
                        <div id="paymentDate" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 paymentMethod d-none">
                        <label class="w-100 fw-bold text-black mb-1">Payment Method</label>
                        <div id="paymentMethod" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 paymentStatus d-none">
                        <label class="w-100 fw-bold text-black mb-1">Payment Status</label>
                        <div id="paymentStatus" class="text-capitalize text-black"></div>
                    </div>
                    <div class="col-12 studentFeesForm">
                        <div class="border-top mb-3"></div>
                        <form id="studentFeesForm" class="row g-3">
                            <input type="hidden" name="fees_id" id="modal_fees_id">
                            <input type="hidden" name="student_id" id="modal_student_id">
                            <div class="col-lg-4 col-md-6">
                                <label class="w-100 fw-bold text-black mb-1">Month</label>
                                <input type="text" name="month" id="modal_month" class="form-control" readonly placeholder="Enter Month">
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label class="w-100 fw-bold text-black mb-1">Year</label>
                                <input type="text" name="year" id="modal_year" class="form-control" readonly placeholder="Enter Year">
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label class="w-100 fw-bold text-black mb-1">Fee Amount</label>
                                <input type="text" name="fee_amount" id="modal_fee_amount" class="form-control decimal" placeholder="Enter Fee Amount" value="1000">
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label class="w-100 fw-bold text-black mb-1">Payment Date</label>
                                <input type="text" name="payment_date" id="modal_payment_date" class="form-control date-picker" placeholder="YYYY - MM - DD" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label class="w-100 fw-bold text-black mb-1">Payment Method</label>
                                <select name="payment_method" id="modal_payment_method" class="form-select">
                                    <option value="">Select Payment Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="UPI">UPI</option>
                                    <option value="Bank">Bank</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label class="w-100 fw-bold text-black mb-1">Payment Status</label>
                                <select name="payment_status" id="modal_payment_status" class="form-select">
                                    <option value="">Select Payment Status</option>
                                    <option value="paid">Paid</option>
                                    <option value="unpaid">Unpaid</option>
                                </select>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-success px-4 subBtn">Save Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".getfeesId", function(e){
        var studentId = $(this).data("student-id");
        var feesId = $(this).data("feesid");
        var month = $(this).data("month");
        var year = $(this).data("year");
        
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>getFeesDetail',
            dataType: "json",
            data: {feesId, studentId, month, year},
            success: function (data) {
                $('#headingTitle').html('<h5 class="mb-0 text-black text-center lh-base fw-bold text-capitalize">' + data.month + ' - ' + data.year + ' Fees Details</h5>');
                $('#studentCode').html(data.studentCode);
                $('#studentName').html(data.studentName);
                $('#class').html(data.class);
                $('#parentName').html(data.parentName);
                $('#joiningDate').html(data.joiningDate);
                $('#parentType').html(data.parentType);
                $('#mobileNumber').html('<a href="tel:' + data.mobileNumber + '" class="a-hover">' + data.mobileNumber + '</a>');
                $('#email').html('<a href="mailto:' + data.email + '" class="a-hover">' + data.email + '</a>');
                $('#address').html(data.address);
                $('#aadharCard').html(data.aadharCard);
                
                if (data.feesId > 0 && data.paymentStatus == 'paid') {
                    $('.studentFeesForm').addClass('d-none');
                } else {
                    $('.studentFeesForm').removeClass('d-none');
                    $('#modal_fees_id').val(data.feesId);
                    $('#modal_student_id').val(data.studentId);
                    $('#modal_month').val(data.month);
                    $('#modal_year').val(data.year);
                    
                    if (data.feesId > 0) {
                        $('#modal_fee_amount').val(data.feeAmount);
                        $('#modal_payment_date').val(data.paymentDate);
                        $('#modal_payment_method').val(data.paymentMethod);
                        $('#modal_payment_status').val(data.paymentStatus);
                    } else {
                        $('#modal_fee_amount').val(1000);
                        $('#modal_payment_date').val('<?php echo date('Y-m-d'); ?>');
                        $('#modal_payment_method').val('');
                        $('#modal_payment_status').val('');
                    }
                }
                
                if (data.invoiceNumber && data.paymentStatus == 'paid') {
                    $('#invoiceNo').html(data.invoiceNumber);
                    $('.invoiceNo').removeClass('d-none');
                } else {
                    $('.invoiceNo').addClass('d-none');
                }

                if (data.feeAmount && data.paymentStatus == 'paid') {
                    $('#feeAmount').html(data.feeAmount);
                    $('.feeAmount').removeClass('d-none');
                } else {
                    $('.feeAmount').addClass('d-none');
                }
                
                if (data.paymentDate && data.paymentStatus == 'paid') {
                    $('#paymentDate').html(data.paymentDate);
                    $('.paymentDate').removeClass('d-none');
                } else {
                    $('.paymentDate').addClass('d-none');
                }
                
                if (data.paymentMethod && data.paymentStatus == 'paid') {
                    $('#paymentMethod').html(data.paymentMethod);
                    $('.paymentMethod').removeClass('d-none');
                } else {
                    $('.paymentMethod').addClass('d-none');
                }
                
                if (data.paymentStatus && data.paymentStatus == 'paid') {
                    $('[id="paymentStatus"]').html(data.paymentStatus);
                    $('.paymentStatus').removeClass('d-none');
                } else {
                    $('.paymentStatus').addClass('d-none');
                }
            }
        });
    });

    $('#studentFeesForm').on('submit', function(e) {
        e.preventDefault();
        var data = new FormData(this);
        if ($('#modal_fee_amount').val() == '') {
            toastr.error('Please Enter Fee Amount');
            return;
        }
        if ($('#modal_payment_date').val() == '') {
            toastr.error('Please Select Payment Date');
            return;
        }
        if ($('#modal_payment_method').val() == '') {
            toastr.error('Please Select Payment Method');
            return;
        }
        if ($('#modal_payment_status').val() == '') {
            toastr.error('Please Select Payment Status');
            return;
        }
        $.ajax({
            url: '<?php echo base_url(); ?>feesFormSave',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: "json",
            beforeSend: function () {
                $('.subBtn').prop('disabled', true).html('Saving...');
            },
            success: function (data) {
                if (data.isError) {
                    toastr.error(data.message);
                    $('.subBtn').prop('disabled', false).html('Save Payment');
                } else {
                    toastr.success(data.message);
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            }
        });
    });
</script>
