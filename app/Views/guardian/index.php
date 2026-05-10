<?= $this->extend('theme/template') ?>
<?= $this->section('content') ?>
<div class="content-wrapper dashboard-page">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="dash-header">
          <h1 class="m-0">Parents & Guardians</h1>
            <div class="dash-subtitle">Manage and view all registered Parent & Guardians</div>
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
                  <i class="fas fa-id-badge"></i>
                </span>
                List of Parents & Guardians
              </h3>
              </h3>
                  <div class="card-tools">
                <button type="button" class="btn btn-sm btn-primary px-3" data-toggle="modal" data-target="#AddNewModal">
                  <i class="fa fa-plus-circle fa fw"></i> Add New
                </button>
              </div>
            </div>

            <div class="card-body">
               <table id="example1" class="table table-hover table-bordered table-sm dash-table">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th style="display:none;">id</th>
                    <th>Last Name</th>
                    <th>Name</th>
                    <th>Middle Name</th>
                    <th>Contact</th>
                    <th>Address</th>
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
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Middle Name</label>
            <input type="text" name="middle_name" class="form-control">
          </div>

          <div class="form-group">
            <label>Contact</label>
            <input type="text" name="contact" class="form-control">
          </div>

          <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control">
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

            <input type="hidden" id="userId" name="record_id">

             <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" required />
              </div>

              <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" id="name" class="form-control" required />
              </div>

              <div class="form-group">
                <label>Middle Name</label>
                <input type="text" name="middle_name" id="middle_name" class="form-control" required />
              </div>


              <div class="form-group">
                <label>Contact</label>
                <input type="text" name="contact" id="contact" class="form-control" required />
              </div>

              <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" id="address" class="form-control" required />
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
<script src="<?= base_url('js/guardian/guardian.js') ?>"></script>
<?= $this->endSection() ?>
