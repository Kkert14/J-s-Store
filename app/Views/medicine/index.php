<?= $this->extend('theme/template') ?>
<?= $this->section('content') ?>
<div class="content-wrapper dashboard-page">

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="dash-header">
            <h1 class="m-0">Clinic Medicines</h1>
            <div class="dash-subtitle">Manage and view all clinic medicines</div>
          </div>
        </div>
        <div class="col-sm-6 d-flex align-items-center justify-content-sm-end">
          <div class="dash-date">
            <i class="far fa-calendar-alt"></i>
            <?= date('F d, Y') ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      <!-- ── Low Stock Alert Banner ── -->
      <?php if (!empty($low_stock)): ?>
        <div class="alert alert-warning alert-dismissible fade show shadow-sm mb-3" role="alert">
          <div class="d-flex align-items-start">
            <i class="fas fa-exclamation-triangle fa-lg mr-3 mt-1 text-warning"></i>
            <div>
              <strong>Low Stock Warning!</strong>
              The following medicines are running low (less than 5 units):
              <ul class="mb-0 mt-1">
                <?php foreach ($low_stock as $m): ?>
                  <li>
                    <strong><?= esc($m['medicine_name']) ?></strong>
                    — only <span class="badge badge-danger"><?= $m['quantity'] ?></span> left
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <!-- ── Expired Alert Banner ── -->
      <?php if (!empty($expired)): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-3" role="alert">
          <div class="d-flex align-items-start">
            <i class="fas fa-times-circle fa-lg mr-3 mt-1 text-danger"></i>
            <div>
              <strong>Expired Medicines!</strong>
              The following medicines have already expired and should be removed:
              <ul class="mb-0 mt-1">
                <?php foreach ($expired as $m): ?>
                  <li>
                    <strong><?= esc($m['medicine_name']) ?></strong>
                    — expired on <span class="badge badge-danger"><?= esc($m['expiry_date']) ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <!-- ── Expiring Soon Alert Banner ── -->
      <?php if (!empty($expiring_soon)): ?>
        <div class="alert alert-orange alert-dismissible fade show shadow-sm mb-3" style="background-color:#fff3cd; border-color:#fd7e14; color:#7d3c00;" role="alert">
          <div class="d-flex align-items-start">
            <i class="fas fa-clock fa-lg mr-3 mt-1" style="color:#fd7e14;"></i>
            <div>
              <strong>Expiring Soon!</strong>
              The following medicines expire within 7 days:
              <ul class="mb-0 mt-1">
                <?php foreach ($expiring_soon as $m): ?>
                  <li>
                    <strong><?= esc($m['medicine_name']) ?></strong>
                    — expires on <span class="badge badge-warning"><?= esc($m['expiry_date']) ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <div class="row">
        <div class="col-12">
          <div class="card dash-card">
            <div class="card-header border-0">
              <h3 class="card-title d-flex align-items-center">
                <span class="dash-card-icon">
                  <i class="fas fa-pills"></i>
                </span>
                List of Medicines
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-sm btn-primary px-3" data-toggle="modal" data-target="#AddNewModal">
                  <i class="fa fa-plus-circle mr-1"></i> Add New
                </button>
              </div>
            </div>

            <div class="card-body">
              <table id="example1" class="table table-bordered table-hover table-sm dash-table">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th style="display:none;">id</th>
                    <th>Medicine Name</th>
                    <th>Quantity</th>
                    <th>Expiry Date</th>
                    <th>Date Received</th>
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

    <!-- ── Add New Modal ── -->
    <div class="modal fade" id="AddNewModal" tabindex="-1">
      <div class="modal-dialog">
        <form id="addUserForm">
          <?= csrf_field() ?>
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><i class="fa fa-plus-circle"></i> Add New Medicine</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

              <div class="form-group">
                <label>Medicine Name</label>
                <select class="form-control" id="add_medicine_name_select" name="medicine_name_select">
                  <option value="Biogesic">Biogesic (Paracetamol 500mg - fever & pain)</option>
                  <option value="Bioflu">Bioflu (Flu, colds, fever, antihistamine)</option>
                  <option value="Neozep">Neozep (Colds, sinus, nasal congestion)</option>
                  <option value="Decogesic">Decolgen (Colds, headache, fever)</option>
                  <option value="Alaxan">Alaxan FR (Body pain, muscle pain)</option>
                  <option value="Flanax">Flanax (Naproxen - pain & inflammation)</option>
                  <option value="Ponstan">Ponstan (Mefenamic acid - menstrual pain)</option>
                  <option value="Dolfenal">Dolfenal (Mefenamic acid - pain relief)</option>
                  <option value="Biogesic_forte">Biogesic Forte (Higher strength paracetamol)</option>
                  <option value="Diatabs">Diatabs (Diarrhea)</option>
                  <option value="Imodium">Imodium (Loperamide - diarrhea control)</option>
                  <option value="Kremil_s">Kremil-S (Acidity, hyperacidity, stomach pain)</option>
                  <option value="Maalox">Maalox (Acid reflux, stomach discomfort)</option>
                  <option value="Gaviscon">Gaviscon (Acid reflux, heartburn)</option>
                  <option value="Solmux">Solmux (Cough with phlegm)</option>
                  <option value="Robitussin">Robitussin (Cough relief)</option>
                  <option value="Tuseran">Tuseran (Dry cough & colds)</option>
                  <option value="Bioflu_kids">Biogesic Kids (Pediatric fever & pain)</option>
                  <option value="Tempra">Tempra (Paracetamol for kids)</option>
                  <option value="Cetirizine">Cetirizine (Allergy, antihistamine)</option>
                  <option value="Loratadine">Loratadine (Allergy relief)</option>
                  <option value="Other">Other (specify below)</option>
                </select>
              </div>
              <div class="form-group" id="add_other_name_field" style="display:none;">
                <label>Specify Medicine Name</label>
                <input type="text" id="add_medicine_name_other" class="form-control" placeholder="Type medicine name...">
              </div>
              <!-- hidden field that actually gets submitted -->
              <input type="hidden" name="medicine_name" id="add_medicine_name_final">

              <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" class="form-control" min="1" required>
              </div>

              <div class="form-group">
                <label>Expiry Date</label>
                <input type="date" name="expiry_date" class="form-control" required>
              </div>

              <div class="form-group">
                <label>Date Received</label>
                <input type="date" name="date_received" class="form-control" required>
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

    <!-- ── Edit Modal ── -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="far fa-edit fa-fw"></i> Edit Record</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <form id="editUserForm">
            <?= csrf_field() ?>
            <div class="modal-body">

              <input type="hidden" id="userId" name="medicine_id">

              <div class="form-group">
                <label>Medicine Name</label>
                <select class="form-control" id="edit_medicine_name_select" name="medicine_name_select">
                  <option value="Biogesic">Biogesic (Paracetamol 500mg - fever & pain)</option>
                  <option value="Bioflu">Bioflu (Flu, colds, fever, antihistamine)</option>
                  <option value="Neozep">Neozep (Colds, sinus, nasal congestion)</option>
                  <option value="Decogesic">Decolgen (Colds, headache, fever)</option>
                  <option value="Alaxan">Alaxan FR (Body pain, muscle pain)</option>
                  <option value="Flanax">Flanax (Naproxen - pain & inflammation)</option>
                  <option value="Ponstan">Ponstan (Mefenamic acid - menstrual pain)</option>
                  <option value="Dolfenal">Dolfenal (Mefenamic acid - pain relief)</option>
                  <option value="Biogesic_forte">Biogesic Forte (Higher strength paracetamol)</option>
                  <option value="Diatabs">Diatabs (Diarrhea)</option>
                  <option value="Imodium">Imodium (Loperamide - diarrhea control)</option>
                  <option value="Kremil_s">Kremil-S (Acidity, hyperacidity, stomach pain)</option>
                  <option value="Maalox">Maalox (Acid reflux, stomach discomfort)</option>
                  <option value="Gaviscon">Gaviscon (Acid reflux, heartburn)</option>
                  <option value="Solmux">Solmux (Cough with phlegm)</option>
                  <option value="Robitussin">Robitussin (Cough relief)</option>
                  <option value="Tuseran">Tuseran (Dry cough & colds)</option>
                  <option value="Bioflu_kids">Biogesic Kids (Pediatric fever & pain)</option>
                  <option value="Tempra">Tempra (Paracetamol for kids)</option>
                  <option value="Cetirizine">Cetirizine (Allergy, antihistamine)</option>
                  <option value="Loratadine">Loratadine (Allergy relief)</option>
                  <option value="Other">Other (specify below)</option>
                </select>
              </div>
              <div class="form-group" id="edit_other_name_field" style="display:none;">
                <label>Specify Medicine Name</label>
                <input type="text" id="edit_medicine_name_other" class="form-control" placeholder="Type medicine name...">
              </div>
              <input type="hidden" name="medicine_name" id="edit_medicine_name_final">

              <div class="form-group">
                <label>Quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control" min="0" required>
              </div>

              <div class="form-group">
                <label>Expiry Date</label>
                <input type="date" id="expiry_date" name="expiry_date" class="form-control" required>
              </div>

              <div class="form-group">
                <label>Date Received</label>
                <input type="date" id="date_received" name="date_received" class="form-control" required>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='fas fa-times-circle'></i> Cancel</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- ── Adjust Stock Modal ── -->
    <div class="modal fade" id="adjustStockModal" tabindex="-1">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-boxes"></i> Adjust Stock</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body text-center">
            <p class="mb-1"><strong id="adjust_medicine_name"></strong></p>
            <p class="mb-3">Current stock: <span class="badge badge-info px-2 py-1" id="adjust_current_qty"></span></p>
            <div class="input-group justify-content-center">
              <div class="input-group-prepend">
                <button class="btn btn-danger" id="btnSubtract" type="button"><i class="fas fa-minus"></i></button>
              </div>
              <input type="number" id="adjust_amount" class="form-control text-center" style="max-width:80px;" value="1" min="1">
              <div class="input-group-append">
                <button class="btn btn-success" id="btnAdd" type="button"><i class="fas fa-plus"></i></button>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>
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
<script src="<?= base_url('js/medicine/medicine.js') ?>"></script>
<?= $this->endSection() ?>