<?= $this->extend('theme/template') ?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&display=swap">
<?= $this->section('content') ?>
<div class="content-wrapper dashboard-page">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="dash-header">
            <h1 class="m-0">POS</h1>
            <div class="dash-subtitle">New sale</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-5">
          <div class="card dash-card">
            <div class="card-header border-0">
              <h3 class="card-title d-flex align-items-center">
                <span class="dash-card-icon">
                  <i class="fas fa-search"></i>
                </span>
                Products
              </h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label>Filter products</label>
                <input type="text" id="posSearch" class="form-control" placeholder="Filter by name or SKU...">
              </div>

              <div class="table-responsive">
                <table class="table table-sm table-bordered" id="posSearchTable">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th class="text-right">Price</th>
                      <th class="text-right">Stock</th>
                      <th class="text-center">Add</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="4" class="text-center text-muted">Loading products...</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-7">
          <div class="card dash-card">
            <div class="card-header border-0">
              <h3 class="card-title d-flex align-items-center">
                <span class="dash-card-icon">
                  <i class="fas fa-shopping-cart"></i>
                </span>
                Cart
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-sm btn-secondary px-3" id="btnClearCart">
                  <i class="fas fa-eraser mr-1"></i> Clear
                </button>
              </div>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-sm table-bordered" id="cartTable">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th class="text-right">Price</th>
                      <th class="text-center">Qty</th>
                      <th class="text-right">Total</th>
                      <th class="text-center">Remove</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="5" class="text-center text-muted">No items yet</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group mb-2">
                    <label>Discount (PHP)</label>
                    <input type="number" min="0" step="0.01" id="discountTotal" class="form-control" value="0">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-2">
                    <label>Subtotal</label>
                    <input type="text" id="subtotalDisplay" class="form-control" readonly value="₱0.00">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group mb-2">
                    <label>Total</label>
                    <input type="text" id="grandTotalDisplay" class="form-control" readonly value="₱0.00">
                  </div>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                  <button type="button" class="btn btn-primary btn-block" id="btnCheckout" data-toggle="modal" data-target="#CheckoutModal" disabled>
                    <i class="fas fa-cash-register mr-1"></i> Checkout
                  </button>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="CheckoutModal" tabindex="-1">
        <div class="modal-dialog">
          <form id="checkoutForm">
            <?= csrf_field() ?>
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-receipt"></i> Checkout</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label>Payment Method</label>
                  <select id="paymentMethod" class="form-control">
                    <option value="Cash">Cash</option>
                    <option value="GCash">GCash</option>
                    <option value="Maya">Maya</option>
                    <option value="Other E-Wallet">Other E-Wallet</option>
                  </select>
                </div>
                <div class="form-group" id="paymentReferenceGroup" style="display:none;">
                  <label>Reference</label>
                  <input type="text" id="paymentReference" class="form-control">
                </div>
                <div class="form-group">
                  <label>Amount Tendered</label>
                  <input type="number" min="0" step="0.01" id="amountTendered" class="form-control" value="0">
                </div>
                <div class="form-group mb-0">
                  <label>Change</label>
                  <input type="text" id="changeDisplay" class="form-control" readonly value="₱0.00">
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="btnConfirmCheckout">Confirm</button>
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
<script src="<?= base_url('js/pos/pos.js') ?>"></script>
<?= $this->endSection() ?>