<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - <?php echo $month . "/" . $year . "-" . $studentName; ?></title>
    <!-- Use Google Fonts for premium look -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        :root {
            --primary-color: #2e165a;
            --text-main: #323232;
            --text-muted: #8592a3;
            --border-color: #ddddddff;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            color: var(--text-main);
            background-color: #fff;
            line-height: 1.5;
        }

        .invoice-wrapper {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid var(--border-color);
            padding: 20px;
            position: relative;
        }

        @media print {
            body { padding: 0; background-color: #fff; }
            .invoice-wrapper { border: none; box-shadow: none; margin: 0; padding: 0; }
            .no-print { display: none !important; }
            .container { max-width: 100% !important; padding: 0 !important; margin: 0 !important; }
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .company-info h1 {
            margin: 0;
            font-size: 20px;
            color: var(--primary-color);
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .company-info p {
            margin: 0;
            color: var(--text-muted);
            font-size: 14px;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: #566a7f;
        }

        .invoice-meta {
            margin-top: 10px;
            font-size: 14px;
            color: var(--text-muted);
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 15px;
            margin-bottom: 15px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .detail-block h4 {
            margin: 0 0 10px 0;
            font-size: 12px;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .detail-block p {
            margin: 2px 0;
            font-size: 15px;
            font-weight: 600;
        }

        .table-wrapper {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #f8f9fa;
            color: #566a7f;
            text-transform: uppercase;
            font-size: 12px;
            text-align: left;
            padding: 12px 0px;
            border-bottom: 2px solid var(--border-color);
        }

        td {
            padding: 15px 0px;
            font-size: 14px;
        }

        .text-right { text-align: right; }

        .fees-summary {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .summary-row {
            display: flex;
            gap: 20px;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 15px;
        }

        .summary-row.total {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: var(--text-muted);
        }

        .signature-block {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            border-top: 1px solid var(--text-main);
            margin-top: 20px;
            padding-top: 10px;
        }

        .print-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-family: inherit;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(232, 219, 255, 1);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }

        .print-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px #2e165a81;
            background: #2e165a;
        }

        .download-btn {
            background: #23272e;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-family: inherit;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(35, 39, 46, 0.3);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }

        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(35, 39, 46, 0.4);
            background: #1a1d23;
        }

        .actions-wrapper {
            position: fixed;
            z-index: 9999;
            bottom: 20px;
            right: 20px;
            display: flex;
            gap: 15px;
        }
    </style>
</head>
<body>

    <div class="actions-wrapper no-print">
        <button class="download-btn" onclick="downloadInvoice()">
            <i class="bx bx-download"></i>
            <span>Download</span>
        </button>
        <button class="print-btn" onclick="window.print()">
            <i class="bx bx-printer"></i>
            <span>Print Now</span>
        </button>
    </div>

    <section class="container-fluid">
        <div class="invoice-wrapper">
            <div class="row g-4">
                <div class="col-sm-9 col-md-8">
                    <div class="company-info d-flex flex-column flex-sm-row align-items-center gap-3">
                        <?php if(!empty($settings->company_logo)) { ?>
                            <img src="<?php echo base_url('uploads/images/' . $settings->company_logo); ?>" alt="logo" height="60">
                        <?php } ?>
                        <div class="text-center text-sm-start">
                            <h1 class="fw-semibold"><?php echo $settings->company_name ?? 'JJ Harmony and Arts Academy'; ?></h1>
                            <p><?php echo $settings->company_address ?? 'Nungambakkam, Chennai - 600034'; ?></p>
                            <p>Phone: <?php echo $settings->company_phone ?? '+91 90038 11107'; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 col-md-4">
                    <div class="invoice-title text-center text-sm-end">
                        <h2>INVOICE</h2>
                        <div class="invoice-meta">
                            #<?php echo $invoiceNumber ?? str_pad($feesId, 5, '0', STR_PAD_LEFT); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="details-grid">
                <div class="detail-block">
                    <h4>Bill To</h4>
                    <p class="mb-1"><?php echo $studentCode; ?></p>
                    <p class="mb-1"><?php echo $studentName; ?></p>
                    <p class="mb-0"><?php echo $studentClass; ?></p>
                </div>
                <div class="detail-block text-right">
                    <h4>Payment Info</h4>
                    <p class="mb-1"><?php echo date('d M, Y', strtotime($paymentDate)); ?></p>
                    <p class="mb-1"><?php echo ucfirst($paymentMethod); ?></p>
                </div>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Monthly Fees for <?php echo $month; ?> <?php echo $year; ?></td>
                            <td class="text-right">₹ <?php echo number_format($amount, 2); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="fees-summary">
                <div class="summary-row total">
                    <span>Total Amount : </span>
                    <span>₹ <?php echo number_format($amount, 2); ?></span>
                </div>
            </div>

            <div class="footer">
                <div class="contact-info">
                    <p>Thank you for your payment!</p>
                    <?php if(!empty($settings->company_email)) { ?>
                        <p>For any queries, contact us at <?php echo $settings->company_email; ?></p>
                    <?php } ?>
                </div>
                <div class="signature-block">
                    <div class="signature-line">Authorized Signatory</div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function downloadInvoice() {
            const element = document.querySelector('.invoice-wrapper');
            const opt = {
                margin: [0.5, 0.5],
                filename: 'Invoice - <?php echo $month . "/" . $year . "-" . $studentName; ?>.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            };
            
            // Show loading state or something if needed
            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>
</html>
