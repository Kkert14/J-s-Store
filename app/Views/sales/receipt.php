<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Receipt - Ian's Store</title>
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">
  <style>
    @media print {
      .no-print { display: none !important; }
      body { background: #fff !important; }
      .card { box-shadow: none !important; border: 0 !important; }
      .content-wrapper { margin: 0 !important; padding: 0 !important; }
    }
  </style>
</head>
<body class="hold-transition">
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3 no-print">
      <a href="<?= base_url('sales') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Back
      </a>
      <button class="btn btn-primary" onclick="window.print()">
        <i class="fas fa-print mr-1"></i> Print
      </button>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="text-center mb-4">
          <h3 class="mb-0"><strong>Ian's Store</strong></h3>
          <div class="text-muted">Sales Receipt</div>
        </div>

        <div class="row mb-3">
          <div class="col-sm-6">
            <div><strong>Receipt:</strong> <?= esc($sale['receipt_no'] ?? '') ?></div>
            <div><strong>Date:</strong> <?= esc($sale['sale_datetime'] ?? '') ?></div>
          </div>
          <div class="col-sm-6 text-sm-right">
            <div><strong>Payment:</strong> <?= esc($sale['payment_method'] ?? '') ?></div>
            <?php if (!empty($sale['payment_reference'])): ?>
              <div><strong>Reference:</strong> <?= esc($sale['payment_reference']) ?></div>
            <?php endif; ?>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-sm table-bordered">
            <thead>
              <tr>
                <th>Item</th>
                <th class="text-right">Price</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach (($items ?? []) as $it): ?>
                <tr>
                  <td><?= esc($it['name_snapshot'] ?? '') ?></td>
                  <td class="text-right">₱<?= number_format((float) ($it['unit_price'] ?? 0), 2) ?></td>
                  <td class="text-right"><?= (int) ($it['qty'] ?? 0) ?></td>
                  <td class="text-right">₱<?= number_format((float) ($it['line_total'] ?? 0), 2) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="row justify-content-end">
          <div class="col-sm-6">
            <table class="table table-sm">
              <tr>
                <th class="text-right">Subtotal</th>
                <td class="text-right">₱<?= number_format((float) ($sale['subtotal'] ?? 0), 2) ?></td>
              </tr>
              <tr>
                <th class="text-right">Discount</th>
                <td class="text-right">₱<?= number_format((float) ($sale['discount_total'] ?? 0), 2) ?></td>
              </tr>
              <tr>
                <th class="text-right">Total</th>
                <td class="text-right"><strong>₱<?= number_format((float) ($sale['grand_total'] ?? 0), 2) ?></strong></td>
              </tr>
              <tr>
                <th class="text-right">Tendered</th>
                <td class="text-right">₱<?= number_format((float) ($sale['amount_tendered'] ?? 0), 2) ?></td>
              </tr>
              <tr>
                <th class="text-right">Change</th>
                <td class="text-right">₱<?= number_format((float) ($sale['change_amount'] ?? 0), 2) ?></td>
              </tr>
            </table>
          </div>
        </div>

        <div class="text-center text-muted mt-4">
          Thank you for shopping at Ian's Store!
        </div>
      </div>
    </div>
  </div>
</body>
</html>

