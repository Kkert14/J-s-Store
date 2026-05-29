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

<!-- Void Modal -->
<div class="modal fade" id="VoidSaleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <?= csrf_field() ?>
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-ban mr-1"></i> Void Sale</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="void_sale_id">
        <p>Are you sure you want to void <strong id="void_receipt_no"></strong>?</p>
        <p class="text-muted mb-0" style="font-size: 12px;">This will mark the sale as voided and restore product stock.</p>
        <div class="form-group mt-3 mb-0">
          <label>Void Reason</label>
          <textarea class="form-control" id="void_reason" rows="3" placeholder="Required"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="btnVoidConfirm">Void</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="DeleteSaleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <?= csrf_field() ?>
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-trash mr-1"></i> Delete Sale</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="delete_sale_id">
        <p>Are you sure you want to permanently delete <strong id="delete_receipt_no"></strong>?</p>
        <p class="text-muted mb-0" style="font-size: 12px;"><i class="fas fa-exclamation-triangle text-warning mr-1"></i> Only <strong>voided</strong> sales can be deleted.</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="btnDeleteConfirm">Delete</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  const baseUrl = "<?= base_url() ?>";
  const userRole = "<?= esc(session()->get('role')) ?>";
</script>
<script src="<?= base_url('js/sales/sales.js') ?>"></script>
<?= $this->endSection() ?>
