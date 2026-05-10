<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Record - <?= esc($patient['last_name']) ?>, <?= esc($patient['name']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Jim+Nightshade&family=Manufacturing+Consent&display=swap" rel="stylesheet">

</head>

<body>
    <div class="clinic-header">
        <img src="<?= base_url('assets/img/KCC_Logo.jpg') ?>" class="logo" style="position: relative; bottom: 2px">
        <div class="clinic-info">
            <div class="clinic-name">
                <h3>Kabankalan Catholic College, Inc.</h3>
            </div>
            <div class="clinic-sub">Kabankalan City, Negros Occidental-6111 Philippines</div>
            <div class="clinic-sub">Tel No. 4712 479 Email Add: <span style="text-decoration: underline;">kcc_1927@yahoo.com.ph</span></div>
            <div class="clinic-sub"><strong>School Clinic</strong></div>
            <div class="clinic-sub"><strong>College Department</strong></div>
        </div>
        <img src="<?= base_url('assets/img/school_clinic_logo_kcc.png') ?>" class="logo" style="position: relative; bottom: 2px">
    </div>
    <!-- <hr class="header-divider"> -->

    <?php $primaryParent = $parents[0] ?? null; ?>

    <div class="top-meta">
        <div class="doc-code" style="position: relative; bottom: 100px">KCC-SDMDF-COL-02</div>
    </div>

    <div class="form-title" style="">Individual Treatment Record</div>

    <div class="form-section">
        <div class="row">
            <div class="field w-70">
                <div class="line">
                    <span class="label">Name:</span>
                    <span class="value"><?= esc($patient['last_name']) ?>, <?= esc($patient['name']) ?> <?= esc($patient['middle_name']) ?></span>
                </div>
                <div class="hint">Last Name / First Name / Middle Name</div>
            </div>
            <div class="field w-30">
                <div class="line">
                    <span class="label">Sex:</span>
                    <span class="checks">
                        (<?= ($patient['sex'] ?? '') === 'Male' ? 'x' : ' ' ?>) Male
                        (<?= ($patient['sex'] ?? '') === 'Female' ? 'x' : ' ' ?>) Female
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="field w-20">
                <div class="line">
                    <span class="label">Age:</span>
                    <span class="value"><?= esc($patient['age'] ?? '') ?></span>
                </div>
            </div>
            <div class="field w-40">
                <div class="line">
                    <span class="label">Date of Birth:</span>
                    <span class="value"><?= esc($patient['birthdate'] ?? '') ?></span>
                </div>
            </div>
            <div class="field w-40">
                <div class="line">
                    <span class="label">Contact #:</span>
                    <span class="value"><?= esc($patient['contact'] ?? '') ?></span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="field w-45">
                <div class="line">
                    <span class="label">Parent/Guardian:</span>
                    <span class="value">
                        <?= esc($primaryParent['last_name'] ?? '') ?>, <?= esc($primaryParent['name'] ?? '') ?>
                    </span>
                </div>
            </div>
            <div class="field w-30">
                <div class="line">
                    <span class="label">Relationship to student:</span>
                    <span class="value"><?= esc($primaryParent['relationship'] ?? '') ?></span>
                </div>
            </div>
            <div class="field w-25">
                <div class="line">
                    <span class="label">Contact #:</span>
                    <span class="value"><?= esc($primaryParent['contact'] ?? '') ?></span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="field w-100">
                <div class="line">
                    <span class="label">Address:</span>
                    <span class="value"><?= esc($primaryParent['address'] ?? '') ?></span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="field w-40">
                <div class="line">
                    <span class="label">Course/Department:</span>
                    <span class="value"><?= esc($patient['department'] ?? '') ?></span>
                </div>
            </div>
            <div class="field w-35">
                <div class="line">
                    <span class="label">Year:</span>
                    <span class="value"></span>
                </div>
            </div>
            <div class="field w-25">
                <div class="line">
                    <span class="label">Major:</span>
                    <span class="value"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="section-head">Personal Health History</div>

    <div class="box">
        <div class="box-row">
            <div class="box-label">Medical condition/s please specify:</div>
            <div class="box-value"><?= esc($patient['medical_condition'] ?? '') ?></div>
        </div>
        <div class="box-note">"If you are taking medicine/s for your medical condition/s please indicate below.</div>
    </div>

    <table class="grid-table">
        <thead>
            <tr>
                <th class="col-date">Date and Time</th>
                <th class="col-complaint">Chief Complaint/Vital Signs</th>
                <th class="col-treatment">Treatment/Charting</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($records)): ?>
                <?php foreach ($records as $r): ?>
                    <tr>
                        <td><?= esc($r['date_consulted'] ?? '') ?></td>
                        <td><?= esc($r['chief_complaint'] ?? '') ?></td>
                        <td><?= esc($r['treatment'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <tr class="empty-row">
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endfor; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <br><br>

    <!-- <div class="signatures">
        <div class="sig">
            <div class="sig-line"></div>
            <div class="sig-label">Patient / Guardian Signature</div>
        </div>
        <div class="sig">
            <div class="sig-line"></div>
            <div class="sig-label">Authorized Signatory</div>
        </div>
    </div> -->

    <div class="no-print" style="text-align:center; margin-top: 40px;">
        <button onclick="window.print()" class="pushable">
            <span class="shadow"></span>
            <span class="edge"></span>
            <span class="front"> Print Document </span>
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

    /* Font */
    @import url('https://fonts.googleapis.com/css2?family=Jim+Nightshade&family=Manufacturing+Consent&display=swap');

    h3 {
        font-family: "Manufacturing Consent", system-ui;
        font-weight: 400;
        font-style: normal;
    }

    /* Print Button */

    /* From Uiverse.io by PriyanshuGupta28 */
    .pushable {
        position: relative;
        background: transparent;
        padding: 0px;
        border: none;
        cursor: pointer;
        outline-offset: 4px;
        outline-color: deeppink;
        transition: filter 250ms;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    }

    .shadow {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: hsl(226, 25%, 69%);
        border-radius: 8px;
        filter: blur(2px);
        will-change: transform;
        transform: translateY(2px);
        transition: transform 600ms cubic-bezier(0.3, 0.7, 0.4, 1);
    }

    .edge {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        border-radius: 8px;
        background: linear-gradient(to right,
                hsl(243, 85%, 35%) 0%,
                hsl(248, 96%, 35%) 8%,
                hsl(248, 97%, 27%) 92%,
                hsl(248, 100%, 21%) 100%);
    }

    .front {
        display: block;
        position: relative;
        border-radius: 8px;
        background: hsl(248, 71%, 51%);
        padding: 16px 32px;
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 1rem;
        transform: translateY(-4px);
        transition: transform 600ms cubic-bezier(0.3, 0.7, 0.4, 1);
    }

    .pushable:hover {
        filter: brightness(110%);
    }

    .pushable:hover .front {
        transform: translateY(-6px);
        transition: transform 250ms cubic-bezier(0.3, 0.7, 0.4, 1.5);
    }

    .pushable:active .front {
        transform: translateY(-2px);
        transition: transform 34ms;
    }

    .pushable:hover .shadow {
        transform: translateY(4px);
        transition: transform 250ms cubic-bezier(0.3, 0.7, 0.4, 1.5);
    }

    .pushable:active .shadow {
        transform: translateY(1px);
        transition: transform 34ms;
    }

    .pushable:focus:not(:focus-visible) {
        outline: none;
    }


    /* ── CLINIC HEADER ── */
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

    img {
        margin-bottom: 20px;
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

    /* ── DIVIDER ── */
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

    .doc-code {
        color: #222;
    }

    .meta-right {
        color: #222;
    }

    .form-title {
        text-align: center;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 6px 0;
        /* border-top: 1px solid #000; */
        /* border-bottom: 1px solid #000; */
        /* margin-bottom: 10px; */
        font-size: 12px;
        position: relative;
        bottom: 30px
    }

    .form-title::before {
        content: "";
        position: absolute;
        top: 0;
        /* Use 0 to touch the edges, or negative values to stretch PAST the text box */
        left: 480px;
        right: 480px;

        /* Use 1px for consistent visibility; use opacity if you want it to look "thinner" */
        height: 1.5px;
        background: #000;

        /* Ensure it's visible */
        display: block;
    }


    .form-section {
        /* border: 1px solid #000; */
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

    .w-70 {
        width: 70%;
    }

    .w-45 {
        width: 45%;
    }

    .w-40 {
        width: 40%;
    }

    .w-35 {
        width: 35%;
    }

    .w-30 {
        width: 30%;
    }

    .w-25 {
        width: 25%;
    }

    .w-20 {
        width: 20%;
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

    .checks {
        flex: 1 1 auto;
        border-bottom: 1px solid #000;
        padding: 0 4px 2px;
        min-height: 14px;
    }

    .hint {
        font-size: 9px;
        color: #444;
        margin-left: 40px;
        margin-top: 2px;
    }

    .section-head {
        font-weight: 700;
        text-align: center;
        text-transform: uppercase;
        /* border: 1px solid #000; */
        padding: 5px 8px;
        margin: 10px 0 6px;
        font-size: 11px;
    }

    .box {
        border: 1px solid #000;
        padding: 8px;
        margin-bottom: 10px;
    }

    .box-row {
        display: flex;
        gap: 8px;
        align-items: flex-start;
        margin-bottom: 6px;
    }

    .box-label {
        width: 220px;
        flex: 0 0 auto;
    }

    .box-value {
        flex: 1 1 auto;
        min-height: 28px;
        /* border: 1px solid #000; */
        padding: 6px 8px;
    }

    .box-note {
        font-size: 10px;
        position: relative;
        /* Required for positioning the line */
        bottom: 1px;
        padding-top: 5px;
    }

    .box-note::before {
        content: "";
        position: absolute;
        top: 0;
        left: -9px;
        /* Stretch 10px to the left */
        right: -9px;
        /* Stretch 10px to the right */
        height: .5px;
        /* Thickness of the "border" */
        background: #000;
        /* Border color */
    }

    .grid-table {
        width: 99.9%;
        border-collapse: collapse;
        border: 1px solid #000;
        table-layout: fixed;
    }

    .grid-table th,
    .grid-table td {
        border: 1px solid #000;
        padding: 6px 8px;
        vertical-align: top;
        word-break: break-word;
    }

    .grid-table th {
        font-weight: 700;
        font-size: 10.5px;
        text-align: center;
    }

    .grid-table td {
        height: 32px;
    }

    /* ── EMPTY ROWS: hide horizontal dividers, keep vertical lines ── */
    .grid-table tr.empty-row td {
        border-top-color: transparent;
        border-bottom-color: transparent;
    }

    /* ── Restore bottom border on the last empty row ── */
    .grid-table tr.empty-row:last-child td {
        border-bottom-color: #000;
    }

    .col-date {
        width: 18%;
    }

    .col-complaint {
        width: 42%;
    }

    .col-treatment {
        width: 40%;
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

    /* ── FOOTER ── */
    .footer {
        margin-top: 60px;
        display: flex;
        justify-content: space-between;
    }

    .signature-block {
        text-align: center;
        width: 40%;
    }

    .signature-block .line {
        border-top: 1px solid #000;
        margin-bottom: 5px;
    }

    .signature-block p {
        font-size: 12px;
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