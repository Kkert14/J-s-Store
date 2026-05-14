<?= $this->extend('theme/template') ?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&display=swap">
<?= $this->section('content') ?>
<div class="content-wrapper dashboard-page">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="dash-header">
            <h1 class="m-0">Sales</h1>
            <div class="dash-subtitle">View sales history and reprint receipts</div>
          </div>
        </div>
        <!-- <div class="col-sm-6 d-flex align-items-center justify-content-sm-end">
          <div class="dash-date">
            <i class="far fa-calendar-alt"></i>
            <?= date('F d, Y') ?>
          </div>
        </div> -->
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card dash-card">
            <div class="card-header border-0">
              <h3 class="card-title d-flex align-items-center">
                <span class="dash-card-icon">
                  <i class="fas fa-receipt"></i>
                </span>
                Sales History
              </h3>
              <div class="card-tools">
                <a href="<?= base_url('pos') ?>" class="btn btn-sm btn-primary px-3">
                  <i class="fas fa-cash-register mr-1"></i> New Sale
                </a>
              </div>
            </div>
            <div class="card-body">
              <table id="salesTable" class="table table-bordered table-hover table-sm dash-table">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Receipt</th>
                    <th>Date</th>
                    <th>Cashier</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<div class="modal fade" id="VoidSaleModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="voidSaleForm">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-ban"></i> Void Sale</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="sale_id" id="void_sale_id">
          <div class="mb-2">
            <div class="font-weight-bold" id="void_receipt_no"></div>
            <div class="text-muted" style="font-size: 12px;">Voiding will restore product stock.</div>
          </div>
          <div class="form-group mb-0">
            <label>Reason</label>
            <textarea class="form-control" name="void_reason" id="void_reason" rows="3" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger" id="btnVoidConfirm">Void</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  const baseUrl = "<?= base_url() ?>";
</script>
<script src="<?= base_url('js/sales/sales.js') ?>"></script>
<?= $this->endSection() ?>
