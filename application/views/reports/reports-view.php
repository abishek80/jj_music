<section class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        
        <!-- Page Header & Title -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1 text-black">
                    <i class="bx bx-file-blank text-primary me-2 fs-3 align-middle"></i>Reports Dashboard
                </h4>
                <p class="text-muted mb-0 small">Consolidated Student, Attendance & Fees report by Location, Year, and Month</p>
            </div>
            <div class="d-flex gap-2">
                <a href="<?php echo base_url(); ?>reports_export_excel?location_id=<?php echo $selectedLocation; ?>&year=<?php echo $selectedYear; ?>&month=<?php echo $selectedMonth; ?>" 
                   class="btn btn-success px-3 py-2 text-white shadow-sm d-flex align-items-center gap-1">
                    <i class="bx bx-spreadsheet fs-5"></i> Export Excel
                </a>
                <a href="<?php echo base_url(); ?>reports_export_pdf?location_id=<?php echo $selectedLocation; ?>&year=<?php echo $selectedYear; ?>&month=<?php echo $selectedMonth; ?>" 
                   target="_blank" 
                   class="btn btn-danger px-3 py-2 text-white shadow-sm d-flex align-items-center gap-1">
                    <i class="bx bxs-file-pdf fs-5"></i> Export PDF
                </a>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 10px;">
            <div class="card-body p-4">
                <form method="get" action="<?php echo base_url(); ?>reports" class="row g-3 align-items-end">
                    
                    <!-- Location Filter -->
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="form-label fw-bold text-dark fs-14px mb-1">
                            <i class="bx bx-map-pin me-1 text-primary"></i>Location
                        </label>
                        <select name="location_id" class="form-select text-capitalize">
                            <option value="all" <?php echo ($selectedLocation == 'all') ? 'selected' : ''; ?>>All Locations</option>
                            <?php foreach ($locationList as $loc) { ?>
                                <option value="<?php echo $loc->id; ?>" <?php echo ($selectedLocation == $loc->id) ? 'selected' : ''; ?>>
                                    <?php echo $loc->location_name; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Year Filter -->
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="form-label fw-bold text-dark fs-14px mb-1">
                            <i class="bx bx-calendar me-1 text-primary"></i>Year
                        </label>
                        <select name="year" class="form-select">
                            <option value="all" <?php echo ($selectedYear == 'all') ? 'selected' : ''; ?>>All Years</option>
                            <?php foreach ($yearList as $y) { ?>
                                <option value="<?php echo $y; ?>" <?php echo ($selectedYear == $y) ? 'selected' : ''; ?>>
                                    <?php echo $y; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Month Filter -->
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <label class="form-label fw-bold text-dark fs-14px mb-1">
                            <i class="bx bx-calendar-event me-1 text-primary"></i>Month
                        </label>
                        <select name="month" class="form-select text-capitalize">
                            <option value="all" <?php echo ($selectedMonth == 'all') ? 'selected' : ''; ?>>All Months</option>
                            <?php foreach ($monthList as $m) { ?>
                                <option value="<?php echo $m; ?>" <?php echo ($selectedMonth == $m) ? 'selected' : ''; ?>>
                                    <?php echo ucfirst($m); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Actions -->
                    <div class="col-lg-3 col-md-12 col-sm-6 d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 py-2 w-100 fw-semibold">
                            <i class="bx bx-filter-alt me-1"></i> Filter
                        </button>
                        <a href="<?php echo base_url(); ?>reports" class="btn btn-outline-secondary px-3 py-2" title="Reset Filters">
                            <i class="bx bx-reset fs-5"></i>
                        </a>
                    </div>

                </form>
            </div>
        </div>

        <?php
            // Calculate Overview Summary Analytics
            $totalStudentsCount = count($reportData);
            $totalPresentSum = 0;
            $totalLeaveSum = 0;
            $totalExpectedFeesSum = 0;
            $totalPaidFeesSum = 0;

            foreach ($reportData as $r) {
                $totalPresentSum += $r->present_count;
                $totalLeaveSum += $r->leave_count;
                $totalExpectedFeesSum += floatval($r->student_fee_amount);
                $totalPaidFeesSum += floatval($r->total_paid_amount);
            }
        ?>

        <!-- Analytics Overview Cards -->
        <div class="row g-3 mb-4">
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 8px; background: #ffffff;">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3" style="width: 44px; height: 44px;">
                            <span class="avatar-initial rounded bg-label-primary d-flex align-items-center justify-content-center w-100 h-100">
                                <i class="bx bx-user fs-3"></i>
                            </span>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold display-block">Total Students</small>
                            <h4 class="fw-bold mb-0 text-dark"><?php echo number_format($totalStudentsCount); ?></h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12">
                <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 8px; background: #ffffff;">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3" style="width: 44px; height: 44px;">
                            <span class="avatar-initial rounded bg-label-info d-flex align-items-center justify-content-center w-100 h-100">
                                <i class="bx bx-calendar-check fs-3"></i>
                            </span>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold display-block">Total Present Days</small>
                            <h4 class="fw-bold mb-0 text-dark"><?php echo number_format($totalPresentSum); ?></h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12">
                <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 8px; background: #ffffff;">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3" style="width: 44px; height: 44px;">
                            <span class="avatar-initial rounded bg-label-warning d-flex align-items-center justify-content-center w-100 h-100">
                                <i class="bx bx-calendar-x fs-3"></i>
                            </span>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold display-block">Total Leave Days</small>
                            <h4 class="fw-bold mb-0 text-dark"><?php echo number_format($totalLeaveSum); ?></h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12">
                <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 8px; background: #ffffff;">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3" style="width: 44px; height: 44px;">
                            <span class="avatar-initial rounded bg-label-success d-flex align-items-center justify-content-center w-100 h-100">
                                <i class="bx bx-dollar-circle fs-3"></i>
                            </span>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold display-block">Total Fees Paid</small>
                            <h4 class="fw-bold mb-0 text-success">₹<?php echo number_format($totalPaidFeesSum, 2); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Report Table Card -->
        <div class="card border-0 shadow-sm" style="border-radius: 10px;">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-black mb-0">
                    Detailed Student, Attendance & Fees Report
                </h5>
                <span class="badge bg-label-primary px-3 py-2 rounded-pill">
                    <?php 
                        $locText = ($selectedLocation == 'all') ? 'All Locations' : 'Location Filter Active';
                        $yearText = ($selectedYear == 'all') ? 'All Years' : 'Year: ' . $selectedYear;
                        $monthText = ($selectedMonth == 'all') ? 'All Months' : 'Month: ' . ucfirst($selectedMonth);
                        echo "$locText | $yearText | $monthText";
                    ?>
                </span>
            </div>
            <div class="table-responsive text-nowrap p-3">
                <table class="table table-hover align-middle datatable-report" id="reportTable">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-bold">#</th>
                            <th class="fw-bold">Code</th>
                            <th class="fw-bold">Student Name</th>
                            <th class="fw-bold">Class</th>
                            <th class="fw-bold">Joining Date</th>
                            <th class="fw-bold">Parent Details</th>
                            <th class="fw-bold">Contact Info</th>
                            <th class="fw-bold">Address</th>
                            <th class="fw-bold">Location</th>
                            <th class="fw-bold text-center">Status</th>
                            <th class="fw-bold text-center">Present</th>
                            <th class="fw-bold text-center">Leave</th>
                            <th class="fw-bold text-end">Monthly Fee</th>
                            <th class="fw-bold text-center">Fee Status</th>
                            <th class="fw-bold text-end">Paid Amount</th>
                            <th class="fw-bold">Invoice / Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($reportData)) { ?>
                            <?php $sno = 1; foreach ($reportData as $row) { ?>
                                <tr>
                                    <td><?php echo $sno++; ?></td>
                                    <td>
                                        <span class="badge bg-label-secondary fw-semibold">
                                            <?php echo $row->student_code; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark"><?php echo $row->student_name; ?></div>
                                        <?php if (!empty($row->aadhar_number)) { ?>
                                            <small class="text-muted d-block"><i class="bx bx-id-card me-1"></i>Aadhar: <?php echo $row->aadhar_number; ?></small>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-label-info"><?php echo $row->class; ?></span>
                                    </td>
                                    <td>
                                        <?php echo $row->joining_date ? date('d/m/Y', strtotime($row->joining_date)) : '<span class="text-muted">-</span>'; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($row->parent_name)) { ?>
                                            <div class="fw-semibold text-dark"><?php echo $row->parent_name; ?></div>
                                            <small class="text-muted"><?php echo $row->parent_type ?: 'Parent'; ?></small>
                                        <?php } else { ?>
                                            <span class="text-muted">-</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <div class="text-dark"><i class="bx bx-phone text-primary me-1"></i><?php echo $row->mobile_number ?: 'N/A'; ?></div>
                                        <?php if (!empty($row->email)) { ?>
                                            <small class="text-muted d-block"><i class="bx bx-envelope me-1"></i><?php echo $row->email; ?></small>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <small class="text-wrap d-inline-block" style="max-width: 150px; line-height: 1.2;">
                                            <?php echo $row->address ? htmlspecialchars($row->address) : '<span class="text-muted">-</span>'; ?>
                                        </small>
                                    </td>
                                    <td>
                                        <i class="bx bx-map-pin text-danger me-1"></i>
                                        <?php echo $row->location_name ?: 'Unassigned'; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($row->student_status == 'active') { ?>
                                            <span class="badge bg-label-success">Active</span>
                                        <?php } else { ?>
                                            <span class="badge bg-label-danger">Inactive</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success px-2 py-1">
                                            <i class="bx bx-check me-1"></i><?php echo $row->present_count; ?> Days
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark px-2 py-1">
                                            <i class="bx bx-time me-1"></i><?php echo $row->leave_count; ?> Days
                                        </span>
                                    </td>
                                    <td class="text-end fw-semibold text-dark">
                                        ₹<?php echo number_format($row->student_fee_amount, 2); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($row->total_paid_amount > 0) { ?>
                                            <span class="badge bg-success px-3 py-1"><i class="bx bx-check-circle me-1"></i>Paid</span>
                                        <?php } else { ?>
                                            <span class="badge bg-danger px-3 py-1"><i class="bx bx-x-circle me-1"></i>Unpaid</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-end fw-bold text-success">
                                        ₹<?php echo number_format($row->total_paid_amount, 2); ?>
                                    </td>
                                    <td>
                                        <?php if ($row->invoice_number) { ?>
                                            <span class="badge bg-label-dark mb-1 d-block"><?php echo $row->invoice_number; ?></span>
                                        <?php } ?>
                                        <small class="text-muted"><?php echo $row->payment_date ? date('d/m/Y', strtotime($row->payment_date)) : '-'; ?></small>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="16" class="text-center py-4 text-muted">
                                    <i class="bx bx-folder-open fs-1 d-block mb-2 text-secondary"></i>
                                    No records found matching the selected filters.
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

<script>
    $(document).ready(function() {
        if ($.fn.DataTable && $('#reportTable tbody tr').length > 0 && !$('#reportTable td[colspan]').length) {
            $('#reportTable').DataTable({
                "pageLength": 25,
                "ordering": true,
                "searching": true,
                "responsive": true,
                "language": {
                    "search": "_INPUT_",
                    "searchPlaceholder": "Search report data..."
                }
            });
        }
    });
</script>
