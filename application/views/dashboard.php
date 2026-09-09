<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-3 mb-4">
        <!-- Analytics Info -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 8px; background-color: #ffffff;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar flex-shrink-0 me-3" style="width: 38px; height: 38px;">
                            <span class="avatar-initial rounded bg-label-primary d-flex align-items-center justify-content-center" style="width: 100%; height: 100%; border-radius: 6px !important;">
                                <i class="bx bx-group fs-4"></i>
                            </span>
                        </div>
                        <div>
                            <h5 class="fw-bold text-black mb-0" style="font-size: 14px; letter-spacing: -0.2px;">Active Students</h5>
                            <small class="text-muted" style="font-size: 12px;">Total Active Count</small>
                        </div>
                    </div>
                    <h3 class="fw-bold text-black mb-0 mt-3" style="font-size: 26px;"><?php echo $analytics['totalStudents']; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 8px; background-color: #ffffff;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar flex-shrink-0 me-3" style="width: 38px; height: 38px;">
                            <span class="avatar-initial rounded bg-label-success d-flex align-items-center justify-content-center" style="width: 100%; height: 100%; border-radius: 6px !important;">
                                <i class="bx bx-dollar-circle fs-4"></i>
                            </span>
                        </div>
                        <div>
                            <h5 class="fw-bold text-black mb-0" style="font-size: 14px; letter-spacing: -0.2px;">Overall Collection</h5>
                            <small class="text-muted" style="font-size: 12px;">Lifetime Paid Fees</small>
                        </div>
                    </div>
                    <h3 class="fw-bold text-black mb-0 mt-3" style="font-size: 26px;">₹<?php echo number_format($analytics['totalPaid'], 2); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 8px; background-color: #ffffff;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar flex-shrink-0 me-3" style="width: 38px; height: 38px;">
                            <span class="avatar-initial rounded bg-label-info d-flex align-items-center justify-content-center" style="width: 100%; height: 100%; border-radius: 6px !important;">
                                <i class="bx bx-book-open fs-4"></i>
                            </span>
                        </div>
                        <div>
                            <h5 class="fw-bold text-black mb-0" style="font-size: 14px; letter-spacing: -0.2px;">Overall Classes</h5>
                            <small class="text-muted" style="font-size: 12px;">Course Categories</small>
                        </div>
                    </div>
                    <h3 class="fw-bold text-black mb-0 mt-3" style="font-size: 26px;"><?php echo $analytics['classCount']; ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-3">
        <div class="d-flex justify-content-between align-items-center border-bottom mb-3 pb-3 flex-wrap gap-3">
            <h4 class="fw-bold mb-0 text-black">Fees List</h4>
            <a href="<?php echo base_url(); ?>fees-add" class="btn btn-primary px-4 py-2 rounded text-white">Add Fees</a>
        </div>
        <div class="table-responsive">
            <table class="zero_config table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="w-min-40">S. No</th>
                        <th>Student Details</th>
                        <?php foreach ($monthList as $m) { ?>
                            <th class="text-capitalize"><?php echo substr($m, 0, 3); ?></th>
                        <?php } ?>
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
                        <td>
                            <h6 class="mb-1 text-secondary"><?php echo $row->student_name; ?></h6>
                            <p class="mb-0 text-secondary"><?php echo $row->class; ?></p>
                        </td>
                        <?php 
                            $joiningYear = date('Y', strtotime($row->joining_date));
                            $joiningMonth = date('n', strtotime($row->joining_date));

                            foreach ($monthList as $idx => $m) { 
                                $monthNum = $idx + 1;
                                $payment = $row->months[$m];
                                $color = "";
                                $amount = "";

                                // Show months if (Selected Year > Joining Year) OR (Selected Year == Joining Year AND Month >= Joining Month)
                                $isActiveMonth = ($year > $joiningYear) || ($year == $joiningYear && $monthNum >= $joiningMonth);

                                if (!$isActiveMonth) {
                                    $amount = "-";
                                    $color = "text-muted";
                                } else {
                                    if ($payment) {
                                        $amount = $payment->fee_amount;
                                        $color = ($payment->payment_status == 'paid') ? "text-success" : "text-danger";
                                    } else {
                                        $amount = "1000";
                                        $color = "text-danger";
                                    }
                                }
                        ?>
                            <td class="<?php echo $color; ?>">
                                <?php if ($payment && $payment->payment_status == 'paid' && $amount != '-') { ?>
                                    <a href="<?php echo base_url() . 'fees-invoice/' . $payment->id; ?>" target="_blank" class="text-success fw-semibold"data-toggle="tooltip" data-placement="top" title="View Invoice">
                                        <?php echo $amount; ?>
                                    </a>
                                <?php } else { ?>
                                    <?php echo $amount; ?>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <td class="px-2 text-center">
                            <a href="<?php echo base_url() . 'fees-view/' . date('Y') . '/' . $row->id; ?>" class="box-hover" data-toggle="tooltip" data-placement="top" title="History"> <i class="bx bx-history"></i> </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-3 card p-3">
        <div class="d-flex justify-content-between align-items-center border-bottom mb-3 pb-3 flex-wrap gap-3">
            <h4 class="fw-bold mb-0 text-black text-capitalize"><?php echo $month; ?> - Attendance List</h4>
            <div class="d-flex gap-3">
                <a href="<?php echo base_url() . 'present-add/' . $year . '/' . $month; ?>" class="btn btn-primary px-4 py-2 rounded text-white">Add Attendance</a>
                <a href="<?php echo base_url() . 'leave-add/' . $year . '/' . $month; ?>" class="btn btn-primary px-4 py-2 rounded text-white">Add Leave</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="zero_config table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Student Name</th>
                        <th>class</th>
                        <th>Class Count</th>
                        <th>Present Count</th>
                        <th>Leave Count</th>
                        <th class="w-min-75">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i = 1;
                        foreach($studentAttendanceList as $row) {
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><a href="<?php echo base_url() . 'attendance-view/' . $year . '/' . $month . '/' . $row->student_id; ?>" class="a-hover"><?php echo $row->student_name; ?></a></td>
                        <td><?php echo $row->class; ?></td>
                        <td><?php echo $row->class_count; ?></td>
                        <td><?php echo $row->present_count; ?></td>
                        <td><?php echo $row->leave_count; ?></td>
                        <td class="px-2">
                            <a href="<?php echo base_url() . 'attendance-view/' . $year . '/' . $month . '/' . $row->student_id; ?>" class="box-hover" data-toggle="tooltip" data-placement="top" title="View"> <i class="bx bx-show"></i> </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>