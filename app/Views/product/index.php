<?= $this->extend('theme/template') ?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&display=swap">
<?= $this->section('content') ?>
<div class="content-wrapper dashboard-page">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="dash-header">
            <h1 class="m-0">Products</h1>
            <div class="dash-subtitle">Manage products and stock</div>
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
                  <i class="fas fa-box"></i>
                </span>
                Product List
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-sm btn-primary px-3" data-toggle="modal" data-target="#AddProductModal">
                  <i class="fa fa-plus-circle mr-1"></i> Add New
                </button>
              </div>
            </div>

            <div class="card-body">
              <table id="productTable" class="table table-bordered table-hover table-sm dash-table">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th style="display:none;">ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="AddProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <form id="addProductForm">
            <?= csrf_field() ?>
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-plus-circle"></i> Add Product</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label>SKU</label>
                    <input type="text" name="sku" class="form-control">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Category</label>
                    <select name="category_id" class="form-control">
                      <option value="">— None —</option>
                      <?php foreach (($categories ?? []) as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= esc($c['name']) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Unit</label>
                    <input type="text" name="unit" class="form-control" placeholder="pcs, pack, bottle">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label>Cost</label>
                    <input type="number" name="cost" step="0.01" min="0" class="form-control" value="0">
                  </div>
                  <div class="form-group col-md-3">
                    <label>Price</label>
                    <input type="number" name="price" step="0.01" min="0" class="form-control" value="0" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Stock Qty</label>
                    <input type="number" name="stock_qty" min="0" class="form-control" value="0" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Reorder Level</label>
                    <input type="number" name="reorder_level" min="0" class="form-control" value="0">
                  </div>
                </div>

                <div class="form-group mb-0">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="add_is_active" name="is_active" value="1" checked>
                    <label class="custom-control-label" for="add_is_active">Active</label>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="modal fade" id="EditProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <form id="editProductForm">
            <?= csrf_field() ?>
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><i class="far fa-edit"></i> Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="id" id="edit_product_id">

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Name</label>
                    <input type="text" name="name" id="edit_product_name" class="form-control" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label>SKU</label>
                    <input type="text" name="sku" id="edit_product_sku" class="form-control">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Category</label>
                    <select name="category_id" id="edit_product_category" class="form-control">
                      <option value="">— None —</option>
                      <?php foreach (($categories ?? []) as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= esc($c['name']) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Unit</label>
                    <input type="text" name="unit" id="edit_product_unit" class="form-control">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label>Cost</label>
                    <input type="number" name="cost" id="edit_product_cost" step="0.01" min="0" class="form-control">
                  </div>
                  <div class="form-group col-md-3">
                    <label>Price</label>
                    <input type="number" name="price" id="edit_product_price" step="0.01" min="0" class="form-control" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Stock Qty</label>
                    <input type="number" name="stock_qty" id="edit_product_stock" min="0" class="form-control" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Reorder Level</label>
                    <input type="number" name="reorder_level" id="edit_product_reorder" min="0" class="form-control">
                  </div>
                </div>

                <div class="form-group mb-0">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="edit_is_active" name="is_active" value="1">
                    <label class="custom-control-label" for="edit_is_active">Active</label>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
          </form>
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
<script src="<?= base_url('js/product/product.js') ?>"></script>
<?= $this->endSection() ?>
