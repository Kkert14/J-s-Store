<?= $this->extend('theme/template') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
<?= $this->section('content') ?>
<div class="content-wrapper dashboard-page">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="dash-header">
          <h1 class="m-0">Clinic Equipments</h1>
          <div class="dash-subtitle">Manage and view all clinic equipments</div>
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
      <div class="row">
        <div class="col-12">

          <div class="card dash-card">
            <div class="card-header border-0">
              <h3 class="card-title d-flex align-items-center">
                <span class="dash-card-icon">
                  <i class="fas fa-stethoscope"></i>
                </span>
                List of Equipments
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
                    <th>Equipment Name</th>
                    <th>Quantity</th>
                    <th>Condition</th>
                    <th>Date Acquired</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

   

    <!-- ✅ Add New Modal -->
   <div class="modal fade" id="AddNewModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="addUserForm">
      <?= csrf_field() ?>
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">
            <i class="fa fa-plus-circle"></i> Add New
          </h5>
          <button type="button" class="close" data-dismiss="modal">
            &times;
          </button>
        </div>

        <div class="modal-body">

          <div class="form-group">
            <label>Equipment Name</label>
            <input type="text" name="equipment_name" class="form-control" required>
          </div>

            <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Condition</label>
            <select class="form-control" id="item_status" name="item_status">
              <option value="Good">Good</option>
              <option value="Damaged">Damaged</option>
              <option value="Needs Repair">Needs Repair</option>
            </select>
          </div>

          <div class="form-group">
            <label>Date Acquired</label>
            <input type="date" name="date_acquired" class="form-control" required>
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">
            Cancel
          </button>

          <button type="submit" class="btn btn-primary">
            Save
          </button>
        </div>

      </div>
    </form>
  </div>
</div>
      </form>
    </div>
  </div>

   <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editUserModalLabel"><i class="far fa-edit fa fw"></i> Edit Record</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editUserForm">
           <?= csrf_field() ?>
          <div class="modal-body">

            <input type="hidden" id="userId" name="equipment_id">

             <div class="form-group">
            <label>Equipment Name</label>
            <input type="text" id="equipment_name" name="equipment_name" class="form-control" required>
          </div>

            <div class="form-group">
            <label>Quantity</label>
            <input type="number" id="quantity" name="quantity" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Condition</label>
            <select class="form-control" id="item_status" name="item_status">
              <option value="Good">Good</option>
              <option value="Damaged">Damaged</option>
              <option value="Needs Repair">Needs Repair</option>
            </select>
          </div>
          <div class="form-group">
            <label>Date Acquired</label>
            <input type="date" id="date_acquired" name="date_acquired" class="form-control" required>
          </div>

            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class='fas fa-times-circle'></i> Cancel</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>

</section>
</div>
<div class="toasts-top-right fixed" style="position: fixed; top: 1rem; right: 1rem; z-index: 9999;"></div>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script> const baseUrl = "<?= base_url() ?>"; </script>
<script src="<?= base_url('js/equipment/equipment.js') ?>"></script>
<?= $this->endSection() ?>
