<?= $this->extend('theme/template') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">

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
                <label>Choose a medicine:</label>
                <select class="form-control" id="medicine_name" name="medicine_name">
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
                </select>
              </div>

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
                <label>Choose a medicine:</label>
                <select class="form-control" id="medicine_name" name="medicine_name">
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
                </select>
              </div>

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

  </section>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  const baseUrl = "<?= base_url() ?>";
</script>
<script src="<?= base_url('js/medicine/medicine.js') ?>"></script>
<?= $this->endSection() ?>