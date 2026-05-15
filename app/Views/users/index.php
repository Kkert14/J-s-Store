<?= $this->extend('theme/template') ?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&display=swap">
<?= $this->section('content') ?>
<div class="content-wrapper dashboard-page">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="dash-header">
            <h1 class="m-0">Clinic Staffs</h1>
            <div class="dash-subtitle">Manage and view all Staff</div>
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
                  <i class="fas fa-user-shield"></i>
                </span>
                List of User Accounts
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-sm btn-primary px-3" data-toggle="modal" data-target="#AddNewModal">
                  <i class="fa fa-plus-circle mr-1"></i> Add New
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-md-3">
                  <select id="roleFilter" class="form-control">

                    <?php if ($role === 'Admin'): ?>

                      <option value="" <?= $role == '' ? 'selected' : '' ?>>All Staff</option>
                      <option value="Admin" <?= $role == 'Admin' ? 'selected' : '' ?>>Admin</option>
                      <option value="Cashier" <?= $role == 'Cashier' ? 'selected' : '' ?>>Cashier</option>
                      <!-- <option value="Doctor" <?= $role == 'Doctor' ? 'selected' : '' ?>>Doctor</option>
                      <option value="Nurse" <?= $role == 'Nurse' ? 'selected' : '' ?>>Nurse</option> -->

                    <!-- <?php elseif ($role === 'Doctor'): ?>
                      
                      <option value="Doctor" <?= $role == 'Doctor' ? 'selected' : '' ?>>Doctor</option>
                      <option value="Nurse" <?= $role == 'Nurse' ? 'selected' : '' ?>>Nurse</option>

                    <?php elseif ($role === 'Nurse'): ?>

                      <option value="Nurse" <?= $role == 'Nurse' ? 'selected' : '' ?>>Nurse</option>

                    <?php endif; ?> -->

                  </select>
                </div>
              </div>
              <table id="example1" class="table table-hover table-bordered table-sm dash-table">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th style="display:none;">id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Phone</th>
                    <th>Created At</th>
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
    <div class="modal fade" id="AddNewModal" tabindex="-1" role="dialog" aria-labelledby="AddNewModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form id="addUserForm">
          <?= csrf_field() ?>
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><i class="fa fa-plus-circle fa fw"></i> Add New</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required />
              </div>

              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required />
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required />
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" name="role">
                       <?php if ($role === 'Admin'): ?>
                      <option value="Admin">Admin</option>
                      <option value="Cashier">Cashier</option>
                      <?php endif; ?>
                     
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                      <option value="Active">Active</option>
                      <option value="In Active">In Active</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" required />
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

              <input type="hidden" id="userId" name="id">

              <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" id="name" class="form-control" required />
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Role</label>
                    <select class="form-control" name="role" id="role">
                       <?php if ($role === 'Admin'): ?>
                      <option value="Admin">Admin</option>
                      <option value="Cashier">Cashier</option>
                      <?php endif; ?>
                    
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status" id="status">
                      <option value="Active">Active</option>
                      <option value="In Active">In Active</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" id="phone" class="form-control" required />
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
<script>
  const baseUrl = "<?= base_url() ?>";
</script>
<script src="<?= base_url('js/users/users.js') ?>"></script>
<?= $this->endSection() ?>
