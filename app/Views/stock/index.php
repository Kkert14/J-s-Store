<?= $this->extend('theme/template') ?>
<?= $this->section('content') ?>
<div class="content-wrapper dashboard-page">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="dash-header">
            <h1 class="m-0">Stock Management</h1>
            <div class="dash-subtitle">Track inventory levels and adjustments</div>
          </div>
        </div>
        <div class="col-sm-6 d-flex align-items-center justify-content-sm-end">
          <a href="<?= base_url('product') ?>" class="btn btn-sm btn-primary px-3">
            <i class="fas fa-box mr-1"></i> Products
          </a>
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
                <span class="dash-card-icon"><i class="fas fa-exclamation-triangle"></i></span>
                Low Stock
              </h3>
            </div>
            <div class="card-body">
              <table id="lowStockTable" class="table table-bordered table-hover table-sm dash-table">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th style="display:none;">ID</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Reorder</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-12">
          <div class="card dash-card">
            <div class="card-header border-0">
              <h3 class="card-title d-flex align-items-center">
                <span class="dash-card-icon"><i class="fas fa-clipboard-list"></i></span>
                Stock Movements
              </h3>
            </div>
            <div class="card-body">
              <table id="movementTable" class="table table-bordered table-hover table-sm dash-table">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Qty</th>
                    <th>Unit Cost</th>
                    <th>Reason</th>
                    <th>User</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="AdjustStockModal" tabindex="-1">
        <div class="modal-dialog">
          <form id="adjustStockForm">
            <?= csrf_field() ?>
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-warehouse"></i> Adjust Stock</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="product_id" id="adjust_product_id">

                <div class="mb-2">
                  <div class="font-weight-bold" id="adjust_product_name"></div>
                  <div class="text-muted" style="font-size: 12px;">Current stock: <span id="adjust_current_stock"></span></div>
                </div>

                <div class="form-group">
                  <label>Action</label>
                  <select class="form-control" name="action" id="adjust_action">
                    <option value="in">Stock In</option>
                    <option value="out">Stock Out</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Quantity</label>
                  <input type="number" class="form-control" name="qty" id="adjust_qty" min="1" value="1" required>
                </div>

                <div class="form-group">
                  <label>Unit Cost</label>
                  <input type="number" class="form-control" name="unit_cost" id="adjust_unit_cost" step="0.01" min="0" placeholder="Optional">
                </div>

                <div class="form-group mb-0">
                  <label>Reason</label>
                  <input type="text" class="form-control" name="reason" id="adjust_reason" placeholder="Optional">
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="btnAdjustStockSave">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
  const baseUrl = "<?= base_url() ?>";
</script>
<script src="<?= base_url('js/stock/stock.js') ?>"></script>
<?= $this->endSection() ?>

