<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Record - <?= esc($record['patient_name']) ?></title>
    <link rel="icon" href="<?= base_url('favicon.ico') ?>">
</head>

<body>

    <div class="clinic-header">
        <img src="<?= base_url('assets/img/KCC_Logo.jpg') ?>" class="logo">
        <div class="clinic-info">
            <div class="clinic-name">Kabankalan Catholic College, Inc.</div>
            <div class="clinic-sub">Kabankalan City, Negros Occidental-6111 Philippines</div>
            <div class="clinic-sub">Tel No. 4712 479 Email Add: <span style="text-decoration:underline;">kcc_1927@yahoo.com.ph</span></div>
            <div class="clinic-sub"><strong>School Clinic</strong></div>
            <div class="clinic-sub"><strong>College Department</strong></div>
        </div>
        <img src="<?= base_url('assets/img/school_clinic_logo_kcc.png') ?>" class="logo">
    </div>
    <hr class="header-divider">

    <div class="top-meta">
        <div class="doc-code">Medical Record</div>
        <div class="meta-right">Record ID: #<?= esc($record['record_id']) ?></div>
    </div>

    <div class="form-title">Patient Consultation Report</div>

    <div class="form-section">
        <div class="row">
            <div class="field w-60">
                <div class="line">
                    <span class="label">Patient Name</span>
                    <span class="value"><?= esc($record['patient_name'] ?? '') ?></span>
                </div>
            </div>
            <div class="field w-40">
                <div class="line">
                    <span class="label">Date Consulted</span>
                    <span class="value"><?= esc($record['date_consulted'] ?? '') ?></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field w-100">
                <div class="line">
                    <span class="label">Attending Staff</span>
                    <span class="value"><?= esc($record['doctor_name'] ?? '') ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="section-head">Clinical Details</div>

    <div class="detail-box">
        <div class="detail-row">
            <div class="detail-label">Chief Complaint</div>
            <div class="detail-value"><?= esc($record['chief_complaint'] ?? '') ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Diagnosis</div>
            <div class="detail-value"><?= esc($record['diagnosis'] ?? '') ?></div>
        </div>
        <div class="detail-row">
            <div class="detail-label">Treatment</div>
            <div class="detail-value"><?= esc($record['treatment'] ?? '') ?></div>
        </div>
    </div>

    <!-- ── Medicines Given ── -->
    <?php if (!empty($record['medicines_given'])): ?>
        <div class="section-head">Medicines Given</div>
        <div class="detail-box">
            <div class="detail-row" style="background:#f5f5f5;">
                <div class="detail-label" style="font-weight:700;">Medicine</div>
                <div class="detail-value" style="font-weight:700; max-width:120px; width:120px; border-left:1px solid #000; padding-left:8px;">Qty Given</div>
            </div>
            <?php foreach ($record['medicines_given'] as $med): ?>
                <div class="detail-row">
                    <div class="detail-label" style="font-weight:normal;"><?= esc($med['medicine_name']) ?></div>
                    <div class="detail-value" style="max-width:120px; width:120px; border-left:1px solid #000; padding-left:8px;"><?= esc($med['quantity_given']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <br><br><br>

    <div class="signatures">
        <div class="sig">
            <div class="sig-line"></div>
            <div class="sig-label"><?= esc($record['doctor_name'] ?? '') ?></div>
            <div class="sig-label">Attending Staff</div>
        </div>
        <div class="sig">
            <div class="sig-line"></div>
            <div class="sig-label">Authorized Signatory</div>
        </div>
    </div>

    <div class="no-print" style="text-align:center; margin-top:40px;">
        <button onclick="window.print()" style="padding:10px 20px; cursor:pointer; font-size:14px;">
            Print Document
        </button>
    </div>

</body>

</html>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 11.5px;
        color: #000;
        padding: 32px;
    }

    .clinic-header {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        margin-bottom: 10px;
    }

    .clinic-header .logo {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 50%;
        background: #fff;
        flex: 0 0 auto;
    }

    .clinic-header .clinic-info {
        text-align: center;
    }

    .clinic-header .clinic-name {
        font-size: 15px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .clinic-header .clinic-sub {
        font-size: 11px;
        color: #444;
        margin-top: 3px;
    }

    .header-divider {
        border: none;
        border-top: 2px solid #000;
        margin-bottom: 10px;
    }

    .top-meta {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        font-size: 10px;
        margin-bottom: 8px;
    }

    .form-title {
        text-align: center;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 6px 0;
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
        margin-bottom: 10px;
        font-size: 12px;
    }

    .form-section {
        border: 1px solid #000;
        padding: 8px;
        margin-bottom: 10px;
    }

    .row {
        display: flex;
        gap: 10px;
        margin-bottom: 8px;
    }

    .field {
        min-width: 0;
    }

    .w-100 {
        width: 100%;
    }

    .w-60 {
        width: 60%;
    }

    .w-40 {
        width: 40%;
    }

    .line {
        display: flex;
        align-items: baseline;
        gap: 6px;
    }

    .label {
        white-space: nowrap;
    }

    .value {
        flex: 1 1 auto;
        border-bottom: 1px solid #000;
        padding: 0 4px 2px;
        min-height: 14px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .section-head {
        font-weight: 700;
        text-align: center;
        text-transform: uppercase;
        border: 1px solid #000;
        padding: 5px 8px;
        margin: 10px 0 6px;
        font-size: 11px;
    }

    .detail-box {
        border: 1px solid #000;
        margin-bottom: 10px;
    }

    .detail-row {
        display: flex;
        border-bottom: 1px solid #000;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        width: 180px;
        border-right: 1px solid #000;
        padding: 8px;
        font-weight: 700;
    }

    .detail-value {
        flex: 1 1 auto;
        padding: 8px;
        min-height: 34px;
        word-break: break-word;
    }

    .signatures {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        margin-top: 16px;
    }

    .sig {
        width: 48%;
        text-align: center;
    }

    .sig-line {
        border-top: 1px solid #000;
        margin-bottom: 6px;
        height: 1px;
    }

    .sig-label {
        font-size: 10.5px;
    }

    @media print {
        @page {
            margin: 12mm;
        }

        body {
            padding: 0;
        }

        .no-print {
            display: none;
        }
    }
</style>