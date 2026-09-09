<section class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex gap-3 flex-wrap mb-3">
            <a href="<?php echo base_url() . 'attendance-view/' . $year . '/all/' . $studentId; ?>" class="d-block card px-5 py-2 text-center <?php echo ($month == 'all') ? 'bg-primary' : 'bg-white'; ?> shadow shadow-sm lh-1 rounded-2 border-primary border border-3 border-end-0 border-start-0 border-top-0">
                <p class="mb-0 <?php echo ($month == 'all') ? 'text-white' : 'text-black'; ?>">All</p>
            </a>
            <?php 
                $currentMonth = strtolower(date('F'));
                $existingMonths = array_map(function($r) { return $r->month; }, $attendanceMonthList);
                foreach ($attendanceMonthList as $row) { 
            ?>
                <a href="<?php echo base_url() . 'attendance-view/' . $year . '/' . $row->month . '/' . $studentId; ?>" class="d-block card px-5 py-2 text-center <?php echo ($month == $row->month) ? 'bg-primary' : 'bg-white'; ?> shadow shadow-sm lh-1 rounded-2 border-primary border border-3 border-end-0 border-start-0 border-top-0">
                    <p class="mb-0 text-capitalize <?php echo ($month == $row->month) ? 'text-white' : 'text-black'; ?>"><?php echo $row->month?></p>
                </a>
            <?php } ?>
            <?php if (!in_array($currentMonth, $existingMonths) && $year == date('Y')) { ?>
                <a href="<?php echo base_url() . 'attendance-view/' . $year . '/' . $currentMonth . '/' . $studentId; ?>" class="d-block card px-5 py-2 text-center <?php echo ($month == $currentMonth) ? 'bg-primary' : 'bg-white'; ?> shadow shadow-sm lh-1 rounded-2 border-primary border border-3 border-end-0 border-start-0 border-top-0">
                    <p class="mb-0 text-capitalize <?php echo ($month == $currentMonth) ? 'text-white' : 'text-black'; ?>"><?php echo $currentMonth; ?></p>
                </a>
            <?php } ?>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-lg-3 col-6">
                <div class="card p-3 text-center h-100">
                    <h5 class="mb-2 fw-semibold text-capitalize"><?php echo $studentName; ?></h5>
                    <h6 class="mb-0 fw-semibold text-capitalize"><?php echo $class; ?></h6>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card p-3 text-center h-100">
                    <p class="mb-2">Class Count</p>
                    <h5 class="mb-0 fw-semibold amount-format"><?php echo count($studentClassList); ?></h5>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card p-3 text-center h-100">
                    <p class="mb-2">Present Count</p>
                    <h5 class="mb-0 fw-semibold amount-format"><?php echo count($studentPresentList); ?></h5>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card p-3 text-center h-100">
                    <p class="mb-2">Leave Count</p>
                    <h5 class="mb-0 fw-semibold amount-format"><?php echo count($studentLeaveList); ?></h5>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item me-2">
                    <button type="button" class="px-5 nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#present_list" aria-controls="present_list" aria-selected="true"> Present List </button>
                </li>
                <li class="nav-item me-2">
                    <button type="button" class="px-5 nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#leave_list" aria-controls="leave_list" aria-selected="true"> Leave List </button>
                </li>
            </ul>
            <?php if($status == 'active' && $deleteStatus == 0) { ?>
                <a href="<?php echo base_url() . 'leave-add/' . $year . '/' . $month . '/' . $studentId; ?>" class="btn btn-primary px-4 py-2 rounded text-white">Add Leave</a>
            <?php } ?>
        </div>
        <div class="card tab-content p-3">
            <div class="tab-pane fade show active" id="present_list" role="tabpanel">
                <div class="d-flex gap-2 align-items-center border-bottom mb-3 pb-3">
                    <a href="<?php echo base_url() . 'attendance-list' . '/' . $year . '/' . $month; ?>" class="fw-bold text-black"><i class="bx bx-chevron-left fs-2 fw-bold text-black"></i></a>
                    <h4 class="fw-bold mb-0 text-black text-capitalize"><?php echo ($month == 'all') ? 'Overall' : $month; ?> - Present List</h4>
                </div>
                <div class="table-responsive">
                    <table class="zero_config table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S. No</th>
                                <th>Date</th>
                                <?php if($status == 'active' && $deleteStatus == 0) { ?>
                                    <th class="w-min-50">Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                foreach ($studentPresentList as $row) { ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row->present_dateFormat; ?></td>
                                    <?php if($status == 'active' && $deleteStatus == 0) { ?>
                                        <td class="px-2">
                                            <a href="javascript:void(0);" data-rowid="<?php echo $row->id; ?>" data-tablename="attendance" data-link="<?php echo base_url() . 'attendance-view/' . $year . '/' . $month . '/' . $studentId; ?>" class="box-hover trashItem" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="bx bx-trash"></i> </a>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="leave_list" role="tabpanel">
                <div class="d-flex gap-2 align-items-center border-bottom mb-3 pb-3">
                    <a href="<?php echo base_url() . 'attendance-list' . '/' . $year . '/' . $month; ?>" class="fw-bold text-black"><i class="bx bx-chevron-left fs-2 fw-bold text-black"></i></a>
                    <h4 class="fw-bold mb-0 text-black text-capitalize"><?php echo ($month == 'all') ? 'Overall' : $month; ?> - Leave List</h4>
                </div>
                <div class="table-responsive">
                    <table class="zero_config table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="w-px-10">S. No</th>
                                <th>Leave Date</th>
                                <th>Leave Reason</th>
                                <th>Status</th>
                                <?php if($status == 'active' && $deleteStatus == 0) { ?>
                                    <th class="w-min-50">Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i=1;
                                foreach ($studentLeaveList as $row) { 
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row->leave_dateFormat; ?></td>
                                <td><?php echo $row->reason; ?></td>
                                <td><?php echo $row->status == 'approved' ? '<span class="text-success">Approved</span>' : '<span class="text-danger">Not Approved</span>'; ?></td>
                                <?php if($status == 'active' && $deleteStatus == 0) { ?>
                                    <td class="px-2">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="<?php echo base_url() . 'leave-edit/' . $row->leave_id; ?>" class="box-hover" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="bx bx-edit-alt"></i> </a>
                                            <a href="javascript:void(0);" data-rowid="<?php echo $row->leave_id; ?>" data-tablename="leave_detail" data-link="<?php echo base_url() . 'attendance-view/' . $year . '/' . $month . '/' . $studentId; ?>" class="box-hover trashLeaveItem" data-toggle="tooltip" data-placement="top" title="Delete Overall Record"> <i class="bx bx-trash"></i> </a>
                                        </div>
                                    </td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>