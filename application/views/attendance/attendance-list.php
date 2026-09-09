<section class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Year Tabs -->
        <div class="d-flex gap-3 flex-wrap mb-3">
            <?php 
                $startYear = 2026;
                $endYear = date('Y') + 1;
                for($y = $startYear; $y <= $endYear; $y++) {
            ?>
                <a href="<?php echo base_url() . 'attendance-list/' . $y . '/all'; ?>" class="d-block card px-5 py-2 text-center <?php echo ($year == $y) ? 'bg-primary' : 'bg-white'; ?> shadow shadow-sm lh-1 rounded-2 border-primary border border-3 border-end-0 border-start-0 border-top-0">
                    <p class="mb-0 text-capitalize <?php echo ($year == $y) ? 'text-white' : 'text-black'; ?>"><?php echo $y; ?></p>
                </a>
            <?php } ?>
        </div>

        <!-- Month Tabs -->
        <div class="d-flex gap-3 flex-wrap mb-3">
            <a href="<?php echo base_url() . 'attendance-list/' . $year . '/all'; ?>" class="d-block card px-5 py-2 text-center <?php echo ($month == 'all') ? 'bg-primary' : 'bg-white'; ?> shadow shadow-sm lh-1 rounded-2 border-primary border border-3 border-end-0 border-start-0 border-top-0">
                <p class="mb-0 <?php echo ($month == 'all') ? 'text-white' : 'text-black'; ?>">All</p>
            </a>
            <?php 
                $currentMonth = strtolower(date('F'));
                $existingMonths = array_map(function($r) { return $r->month; }, $presentMonthList);
                foreach ($presentMonthList as $row) { 
            ?>
                <a href="<?php echo base_url() . 'attendance-list/' . $year . '/' . $row->month; ?>" class="d-block card px-5 py-2 text-center <?php echo ($month == $row->month) ? 'bg-primary' : 'bg-white'; ?> shadow shadow-sm lh-1 rounded-2 border-primary border border-3 border-end-0 border-start-0 border-top-0">
                    <p class="mb-0 text-capitalize <?php echo ($month == $row->month) ? 'text-white' : 'text-black'; ?>"><?php echo $row->month?></p>
                </a>
            <?php } ?>
            <?php if (!in_array($currentMonth, $existingMonths) && $year == date('Y')) { ?>
                <a href="<?php echo base_url() . 'attendance-list/' . $year . '/' . $currentMonth; ?>" class="d-block card px-5 py-2 text-center <?php echo ($month == $currentMonth) ? 'bg-primary' : 'bg-white'; ?> shadow shadow-sm lh-1 rounded-2 border-primary border border-3 border-end-0 border-start-0 border-top-0">
                    <p class="mb-0 text-capitalize <?php echo ($month == $currentMonth) ? 'text-white' : 'text-black'; ?>"><?php echo $currentMonth; ?></p>
                </a>
            <?php } ?>
        </div>
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center border-bottom mb-3 pb-3 flex-wrap gap-3">
                <h4 class="fw-bold mb-0 text-black text-capitalize"><?php echo ($month == 'all') ? 'Overall' : $month; ?> - Attendance List</h4>
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
</section>