<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Receipt · J's Store</title>
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      background: #e8e4dc;
      font-family: 'IBM Plex Mono', monospace;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 32px 16px 48px;
    }

    /* ── toolbar ── */
    .toolbar {
      width: 100%;
      max-width: 400px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
    }
    .btn-back, .btn-print {
      font-family: 'DM Sans', sans-serif;
      font-size: 13px;
      font-weight: 500;
      padding: 8px 16px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 6px;
      text-decoration: none;
      transition: background 0.15s, transform 0.1s;
    }
    .btn-back {
      background: #fff;
      color: #1a1916;
      border: 1px solid #d4d0c8;
    }
    .btn-back:hover { background: #f5f2eb; }
    .btn-print {
      background: #1a1916;
      color: #fff;
    }
    .btn-print:hover { background: #2e2d2a; }
    .btn-print:active, .btn-back:active { transform: scale(0.97); }

    /* ── receipt paper ── */
    .receipt {
      width: 100%;
      max-width: 360px;
      background: #fffef9;
      padding: 32px 28px 28px;
      position: relative;
      /* torn-edge top */
      clip-path: polygon(
        0% 8px, 3% 0%, 6% 8px, 9% 0%, 12% 8px, 15% 0%, 18% 8px,
        21% 0%, 24% 8px, 27% 0%, 30% 8px, 33% 0%, 36% 8px,
        39% 0%, 42% 8px, 45% 0%, 48% 8px, 51% 0%, 54% 8px,
        57% 0%, 60% 8px, 63% 0%, 66% 8px, 69% 0%, 72% 8px,
        75% 0%, 78% 8px, 81% 0%, 84% 8px, 87% 0%, 90% 8px,
        93% 0%, 96% 8px, 100% 0%,
        100% calc(100% - 8px), 97% 100%, 94% calc(100% - 8px),
        91% 100%, 88% calc(100% - 8px), 85% 100%, 82% calc(100% - 8px),
        79% 100%, 76% calc(100% - 8px), 73% 100%, 70% calc(100% - 8px),
        67% 100%, 64% calc(100% - 8px), 61% 100%, 58% calc(100% - 8px),
        55% 100%, 52% calc(100% - 8px), 49% 100%, 46% calc(100% - 8px),
        43% 100%, 40% calc(100% - 8px), 37% 100%, 34% calc(100% - 8px),
        31% 100%, 28% calc(100% - 8px), 25% 100%, 22% calc(100% - 8px),
        19% 100%, 16% calc(100% - 8px), 13% 100%, 10% calc(100% - 8px),
        7% 100%, 4% calc(100% - 8px), 0% 100%
      );
      box-shadow: 0 8px 40px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06);
    }

    /* slight paper texture */
    .receipt::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image: repeating-linear-gradient(
        0deg,
        transparent,
        transparent 23px,
        rgba(0,0,0,0.018) 23px,
        rgba(0,0,0,0.018) 24px
      );
      pointer-events: none;
    }

    /* ── header ── */
    .receipt-header {
      text-align: center;
      padding: 12px 0 20px;
    }
    .store-logo {
      width: 44px;
      height: 44px;
      border-radius: 10px;
      background: #1a1916;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 10px;
    }
    .store-logo-letter {
      font-family: 'IBM Plex Mono', monospace;
      font-size: 22px;
      font-weight: 600;
      color: #fffef9;
      line-height: 1;
    }
    .store-name {
      font-size: 16px;
      font-weight: 600;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: #1a1916;
      margin-bottom: 3px;
    }
    .store-sub {
      font-size: 10px;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: #a8a49c;
    }

    /* ── dividers ── */
    .dash-divider {
      border: none;
      border-top: 1px dashed #c8c4bc;
      margin: 14px 0;
    }
    .solid-divider {
      border: none;
      border-top: 1px solid #d4d0c8;
      margin: 14px 0;
    }

    /* ── meta row ── */
    .meta-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 8px 0;
      font-size: 10px;
      color: #6b6860;
    }
    .meta-grid .label {
      color: #a8a49c;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      font-size: 9px;
      margin-bottom: 1px;
    }
    .meta-grid .value {
      color: #1a1916;
      font-size: 11px;
      font-weight: 500;
    }
    .meta-right { text-align: right; }

    /* ── items table ── */
    .items-header {
      display: grid;
      grid-template-columns: 1fr 52px 36px 64px;
      font-size: 9px;
      letter-spacing: 0.07em;
      text-transform: uppercase;
      color: #a8a49c;
      padding: 4px 0;
      gap: 4px;
    }
    .items-header .r, .item-row .r { text-align: right; }

    .item-row {
      display: grid;
      grid-template-columns: 1fr 52px 36px 64px;
      font-size: 11px;
      color: #1a1916;
      padding: 5px 0;
      gap: 4px;
      border-bottom: 1px dashed #ede9e2;
      align-items: baseline;
    }
    .item-row:last-child { border-bottom: none; }
    .item-name {
      font-weight: 500;
      line-height: 1.3;
    }

    /* ── totals ── */
    .totals {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }
    .total-row {
      display: flex;
      justify-content: space-between;
      font-size: 11px;
      color: #6b6860;
    }
    .total-row.grand {
      font-size: 14px;
      font-weight: 600;
      color: #1a1916;
      padding: 6px 0 2px;
    }
    .total-row.change {
      font-size: 11px;
      color: #1a1916;
    }

    /* ── barcode ── */
    .barcode-wrap {
      text-align: center;
      padding: 12px 0 4px;
    }
    .barcode-lines {
      display: inline-flex;
      gap: 2px;
      height: 36px;
      align-items: flex-end;
    }
    .barcode-lines span {
      display: inline-block;
      background: #1a1916;
      border-radius: 1px;
    }
    .receipt-no-text {
      font-size: 9px;
      letter-spacing: 0.18em;
      color: #a8a49c;
      margin-top: 6px;
      text-transform: uppercase;
    }

    /* ── footer ── */
    .receipt-footer {
      text-align: center;
      padding-top: 4px;
    }
    .thank-you {
      font-size: 10px;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: #a8a49c;
      line-height: 1.8;
    }
    .thank-you strong {
      display: block;
      font-size: 12px;
      color: #1a1916;
      letter-spacing: 0.06em;
      margin-bottom: 2px;
    }

    /* ── print ── */
    @media print {
      .toolbar { display: none !important; }
      body { background: #fff !important; padding: 0 !important; }
      .receipt {
        box-shadow: none !important;
        max-width: 100% !important;
        clip-path: none !important;
      }
      .receipt::before { display: none; }
    }
  </style>
</head>
<body>

    <div class="toolbar no-print">
    <!-- Changed from <a> link to <button> with window.close() -->
    <button class="btn-back" onclick="window.close()">
      <i class="fas fa-times" style="font-size:11px;"></i> Close
    </button>
    <button class="btn-print" onclick="window.print()">
      <i class="fas fa-print" style="font-size:11px;"></i> Print
    </button>
  </div>

  <div class="receipt">

    <!-- Header -->
    <div class="receipt-header">
      <div class="store-logo">
        <span class="store-logo-letter">J</span>
      </div>
      <div class="store-name">J's Store</div>
      <div class="store-sub">Sales Receipt</div>
    </div>

    <hr class="solid-divider">

    <!-- Meta -->
    <div class="meta-grid">
      <div>
        <div class="label">Receipt No.</div>
        <div class="value"><?= esc($sale['receipt_no'] ?? '—') ?></div>
      </div>
      <div class="meta-right">
        <div class="label">Date &amp; Time</div>
        <div class="value"><?= esc($sale['sale_datetime'] ?? '—') ?></div>
      </div>
      <div style="margin-top:6px;">
        <div class="label">Payment</div>
        <div class="value"><?= esc($sale['payment_method'] ?? '—') ?></div>
      </div>
      <?php if (!empty($sale['payment_reference'])): ?>
        <div class="meta-right" style="margin-top:6px;">
          <div class="label">Reference</div>
          <div class="value"><?= esc($sale['payment_reference']) ?></div>
        </div>
      <?php endif; ?>
    </div>

    <hr class="dash-divider">

    <!-- Items -->
    <div class="items-header">
      <span>Item</span>
      <span class="r">Price</span>
      <span class="r">Qty</span>
      <span class="r">Total</span>
    </div>

    <div style="margin: 4px 0 10px;">
      <?php foreach (($items ?? []) as $it): ?>
        <div class="item-row">
          <span class="item-name"><?= esc($it['name_snapshot'] ?? '') ?></span>
          <span class="r">₱<?= number_format((float)($it['unit_price'] ?? 0), 2) ?></span>
          <span class="r"><?= (int)($it['qty'] ?? 0) ?>x</span>
          <span class="r">₱<?= number_format((float)($it['line_total'] ?? 0), 2) ?></span>
        </div>
      <?php endforeach; ?>
    </div>

    <hr class="dash-divider">

    <!-- Totals -->
    <div class="totals">
      <div class="total-row">
        <span>Subtotal</span>
        <span>₱<?= number_format((float)($sale['subtotal'] ?? 0), 2) ?></span>
      </div>
      <?php if ((float)($sale['discount_total'] ?? 0) > 0): ?>
        <div class="total-row">
          <span>Discount</span>
          <span>-₱<?= number_format((float)($sale['discount_total'] ?? 0), 2) ?></span>
        </div>
      <?php endif; ?>

      <hr class="solid-divider" style="margin: 6px 0;">

      <div class="total-row grand">
        <span>TOTAL</span>
        <span>₱<?= number_format((float)($sale['grand_total'] ?? 0), 2) ?></span>
      </div>
      <div class="total-row">
        <span>Cash Tendered</span>
        <span>₱<?= number_format((float)($sale['amount_tendered'] ?? 0), 2) ?></span>
      </div>
      <div class="total-row change">
        <span>Change</span>
        <span>₱<?= number_format((float)($sale['change_amount'] ?? 0), 2) ?></span>
      </div>
    </div>

    <hr class="dash-divider">

    <!-- Pseudo barcode -->
    <div class="barcode-wrap">
      <div class="barcode-lines">
        <?php
          $pattern = [3,1,2,1,4,1,2,3,1,2,1,3,2,1,3,1,2,1,4,2,1,3,1,2,4,1,2,1,3,2,1,2,4,1,3,1,2,1];
          foreach ($pattern as $i => $w):
            $h = ($i % 3 === 0) ? 36 : ($i % 3 === 1 ? 28 : 20);
        ?>
          <span style="width:<?= $w ?>px; height:<?= $h ?>px;"></span>
        <?php endforeach; ?>
      </div>
      <div class="receipt-no-text"><?= esc($sale['receipt_no'] ?? '') ?></div>
    </div>

    <hr class="dash-divider">

    <!-- Footer -->
    <div class="receipt-footer">
      <div class="thank-you">
        <strong>Thank you!</strong>
        We appreciate your business.<br>
        Please come again soon.
      </div>
    </div>

  </div>

</body>
</html>