<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Consolidated Student, Attendance & Fees Report</title>
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>themes/images/fav-icon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>themes/vendor/css/core.css" />
    
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            background: #ffffff;
            color: #222222;
            padding: 15px;
            font-size: 11px;
        }
        .report-header {
            border-bottom: 2px solid #333333;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }
        .summary-card {
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 8px 12px;
            background: #f8f9fa;
        }
        .table-pdf {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }
        .table-pdf th, .table-pdf td {
            border: 1px solid #d0d0d0;
            padding: 6px 7px;
            vertical-align: middle;
        }
        .table-pdf th {
            background-color: #198754;
            color: #ffffff;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: 0.5px;
        }
        .table-pdf tr:nth-child(even) {
            background-color: #fafafa;
        }
        .badge-status {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 600;
        }
        .badge-paid {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .badge-unpaid {
            background-color: #f8d7da;
            color: #842029;
        }
        .no-print {
            margin-bottom: 20px;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
            }
            @page {
                size: A4 landscape;
                margin: 8mm;
            }
        }
    </style>
</head>
<body>

    <!-- Action Toolbar (No Print) -->
    <div class="no-print d-flex justify-content-between align-items-center bg-light p-3 rounded mb-4 border">
        <div>
            <h6 class="mb-0 fw-bold">PDF Print Preview</h6>
            <small class="text-muted">Use browser print (Ctrl+P) or save directly as PDF.</small>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print();" class="btn btn-primary px-4 fw-bold">
                <i class="bx bx-printer me-1"></i> Print / Save as PDF
            </button>
            <button onclick="window.close();" class="btn btn-outline-secondary px-3">
                Close Window
            </button>
        </div>
    </div>

    <!-- Printable Header -->
    <div class="report-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-1" style="color: #198754;">JJ HARMONY AND ARTS ACADEMY</h3>
            <h6 class="text-muted mb-0 fw-bold" style="letter-spacing: 1px;">STUDENT, ATTENDANCE & FEES CONSOLIDATED REPORT</h6>
        </div>
        <div class="text-end">
            <p class="mb-1"><strong>Generated Date:</strong> <?php echo date('d-m-Y h:i A'); ?></p>
            <p class="mb-0">
                <strong>Filters Applied:</strong> 
                Location: <span class="text-success fw-bold"><?php echo ($selectedLocation == 'all') ? 'All' : $selectedLocation; ?></span> | 
                Year: <span class="text-success fw-bold"><?php echo ($selectedYear == 'all') ? 'All' : $selectedYear; ?></span> | 
                Month: <span class="text-success fw-bold"><?php echo ($selectedMonth == 'all') ? 'All' : ucfirst($selectedMonth); ?></span>
            </p>
        </div>
    </div>

    <?php
        $totalStudents = count($reportData);
        $totalPresent = 0;
        $totalLeave = 0;
        $totalPaid = 0;

        foreach ($reportData as $r) {
            $totalPresent += $r->present_count;
            $totalLeave += $r->leave_count;
            $totalPaid += floatval($r->total_paid_amount);
        }
    ?>

    <!-- Overview Metrics Summary -->
    <div class="row g-3 mb-3">
        <div class="col-3">
            <div class="summary-card">
                <small class="text-muted d-block uppercase fw-bold">Total Students</small>
                <h5 class="fw-bold mb-0 mt-1"><?php echo $totalStudents; ?></h5>
            </div>
        </div>
        <div class="col-3">
            <div class="summary-card">
                <small class="text-muted d-block uppercase fw-bold">Total Present Days</small>
                <h5 class="fw-bold mb-0 mt-1 text-success"><?php echo $totalPresent; ?> Days</h5>
            </div>
        </div>
        <div class="col-3">
            <div class="summary-card">
                <small class="text-muted d-block uppercase fw-bold">Total Leave Days</small>
                <h5 class="fw-bold mb-0 mt-1 text-warning"><?php echo $totalLeave; ?> Days</h5>
            </div>
        </div>
        <div class="col-3">
            <div class="summary-card">
                <small class="text-muted d-block uppercase fw-bold">Total Fees Collected</small>
                <h5 class="fw-bold mb-0 mt-1 text-success">₹<?php echo number_format($totalPaid, 2); ?></h5>
            </div>
        </div>
    </div>

    <!-- PDF Data Table -->
    <table class="table-pdf">
        <thead>
            <tr>
                <th style="width: 25px;">#</th>
                <th>Code</th>
                <th>Student Name</th>
                <th>Class</th>
                <th>Aadhar No.</th>
                <th>Joining Date</th>
                <th>Mobile / Email</th>
                <th>Parent Details</th>
                <th>Address</th>
                <th>Location</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: center;">Present</th>
                <th style="text-align: center;">Leave</th>
                <th style="text-align: right;">Monthly Fee</th>
                <th style="text-align: center;">Fee Status</th>
                <th style="text-align: right;">Paid Amount</th>
                <th>Payment Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reportData)) { ?>
                <?php $sno = 1; foreach ($reportData as $row) { ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $sno++; ?></td>
                        <td><strong><?php echo $row->student_code; ?></strong></td>
                        <td><strong><?php echo $row->student_name; ?></strong></td>
                        <td><?php echo $row->class; ?></td>
                        <td><?php echo $row->aadhar_number ?: '-'; ?></td>
                        <td><?php echo $row->joining_date ? date('d-m-Y', strtotime($row->joining_date)) : '-'; ?></td>
                        <td>
                            <?php echo $row->mobile_number ?: '-'; ?>
                            <?php if ($row->email) { echo '<br><small style="color:#666;">' . $row->email . '</small>'; } ?>
                        </td>
                        <td>
                            <?php echo $row->parent_name ? $row->parent_name . ' (' . ($row->parent_type ?: 'Parent') . ')' : '-'; ?>
                        </td>
                        <td style="max-width: 120px; font-size: 9px;"><?php echo $row->address ?: '-'; ?></td>
                        <td><?php echo $row->location_name ?: '-'; ?></td>
                        <td style="text-align: center;"><?php echo ucfirst($row->student_status ?: 'active'); ?></td>
                        <td style="text-align: center; font-weight: bold; color: #198754;"><?php echo $row->present_count; ?></td>
                        <td style="text-align: center; font-weight: bold; color: #ffc107;"><?php echo $row->leave_count; ?></td>
                        <td style="text-align: right;">₹<?php echo number_format($row->student_fee_amount, 2); ?></td>
                        <td style="text-align: center;">
                            <?php if ($row->total_paid_amount > 0) { ?>
                                <span class="badge-status badge-paid">PAID</span>
                            <?php } else { ?>
                                <span class="badge-status badge-unpaid">UNPAID</span>
                            <?php } ?>
                        </td>
                        <td style="text-align: right; font-weight: bold; color: #198754;">
                            ₹<?php echo number_format($row->total_paid_amount, 2); ?>
                        </td>
                        <td><?php echo $row->payment_date ? date('d-m-Y', strtotime($row->payment_date)) : '-'; ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="17" style="text-align: center; padding: 20px;">No record found matching selected filters.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div style="margin-top: 25px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <small style="color: #777;">System Generated Report | JJ Harmony and Arts Academy</small>
        </div>
        <div style="text-align: right; border-top: 1px solid #aaa; padding-top: 5px; width: 180px;">
            <strong>Authorized Signatory</strong>
        </div>
    </div>

    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
