<?= $this->extend('theme/template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Clinic Patient Records</h1>
        </div>
        <!-- <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v1</li>
          </ol>
        </div> -->

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
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">List of Patients</h3>
              <div class="float-right">
                <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#AddNewModal">
                  <i class="fa fa-plus-circle fa fw"></i> Add New
                </button>
              </div>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th style="display:none;">id</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Sex</th>
                    <th>Age</th>
                    <th>Birthdate</th>
                    <th>Contact</th>
                    <th>Parent/Guardian</th>
                    <th>Department</th>
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
                <label>First Name</label>
                <input type="text" name="name" class="form-control" required>
              </div>

              <div class="form-group">
                <label>Middle Name</label>
                <input type="text" name="middle_name" class="form-control">
              </div>

              <div class="form-group">
                <label>Sex</label>
                <select class="form-control" name="sex">
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>

              <div class="form-group">
                <label>Age</label>
                <input type="number" name="age" class="form-control">
              </div>

              <div class="form-group">
                <label>Birthdate</label>
                <input type="date" name="birthdate" class="form-control">
              </div>

              <div class="form-group">
                <label>Contact</label>
                <input type="text" name="contact" class="form-control">
              </div>

              <div class="form-group">
                <label>Department</label>
                <select class="form-control" name="department">
                  <option value="Elementary">Elementary</option>
                  <option value="Highschool">Highschool</option>
                  <option value="Senior">Senior</option>
                  <option value="College">College</option>
                </select>
              </div>

              <!-- Parent/Guardian Section -->
              <hr>
              <h6 class="text-muted mb-2"><i class="fas fa-user-friends"></i> Parent / Guardian</h6>

              <div class="form-group">
                <label>Select Existing Parent</label>
                <select class="form-control" name="parent_id" id="add_parent_id">
                  <option value="">— None / Create New —</option>
                  <?php foreach ($parents ?? [] as $parent): ?>
                    <option value="<?= $parent['parent_id'] ?>">
                      <?= esc($parent['last_name']) ?>, <?= esc($parent['name']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label>Relationship</label>
                <select class="form-control" name="relationship" id="add_relationship">
                  <option value="">— Select —</option>
                  <option value="Mother">Mother</option>
                  <option value="Father">Father</option>
                  <option value="Guardian">Guardian</option>
                  <option value="Sibling">Sibling</option>
                  <option value="Other">Other</option>
                </select>
              </div>

              <div id="addNewParentFields" style="display:none;">
                <div class="alert alert-info py-2">Creating a new parent record</div>
                <div class="form-group">
                  <label>Parent Last Name</label>
                  <input type="text" name="new_parent_last_name" class="form-control">
                </div>
                <div class="form-group">
                  <label>Parent First Name</label>
                  <input type="text" name="new_parent_name" class="form-control">
                </div>
                <div class="form-group">
                  <label>Parent Middle Name</label>
                  <input type="text" name="new_parent_middle_name" class="form-control">
                </div>
                <div class="form-group">
                  <label>Parent Contact</label>
                  <input type="text" name="new_parent_contact" class="form-control">
                </div>
                <div class="form-group">
                  <label>Parent Address</label>
                  <input type="text" name="new_parent_address" class="form-control">
                </div>
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

          <input type="hidden" id="userId" name="patient_id">

          <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required />
          </div>

          <div class="form-group">
            <label>First Name</label>
            <input type="text" name="name" id="name" class="form-control" required />
          </div>

          <div class="form-group">
            <label>Middle Name</label>
            <input type="text" name="middle_name" id="middle_name" class="form-control" />
          </div>

          <div class="form-group">
            <label>Sex</label>
            <select class="form-control" id="sex" name="sex">
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>

          <div class="form-group">
            <label>Age</label>
            <input type="number" name="age" id="age" class="form-control" required />
          </div>

          <div class="form-group">
            <label>Birthdate</label>
            <input type="date" name="birthdate" id="birthdate" class="form-control" required />
          </div>

          <div class="form-group">
            <label>Contact</label>
            <input type="text" name="contact" id="contact" class="form-control" required />
          </div>


          <div class="form-group">
            <label>Department</label>
            <select class="form-control" name="department" id="department">
              <option value="Elementary">Elementary</option>
              <option value="Highschool">Highschool</option>
              <option value="Senior">Senior</option>
              <option value="College">College</option>
            </select>
          </div>

          <!-- Parent/Guardian Section -->
          <hr>
          <h6 class="text-muted mb-2"><i class="fas fa-user-friends"></i> Parent / Guardian</h6>

          <div class="form-group">
            <label>Select Existing Parent</label>
            <select class="form-control" name="parent_id" id="parent_id">
              <option value="">— None / Create New —</option>
              <?php foreach ($parents ?? [] as $parent): ?>
                <option value="<?= $parent['parent_id'] ?>">
                  <?= esc($parent['last_name']) ?>, <?= esc($parent['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Relationship</label>
            <select class="form-control" name="relationship">
              <option value="">— Select —</option>
              <option value="Mother">Mother</option>
              <option value="Father">Father</option>
              <option value="Guardian">Guardian</option>
              <option value="Sibling">Sibling</option>
              <option value="Other">Other</option>
            </select>
          </div>

          <!-- New Parent Form (shown when "None / Create New" is selected) -->
          <div id="newParentFields" style="display:none;">
            <div class="alert alert-info py-2">Creating a new parent record</div>

            <div class="form-group">
              <label>Parent Last Name</label>
              <input type="text" name="new_parent_last_name" class="form-control">
            </div>
            <div class="form-group">
              <label>Parent First Name</label>
              <input type="text" name="new_parent_name" class="form-control">
            </div>
            <div class="form-group">
              <label>Parent Middle Name</label>
              <input type="text" name="new_parent_middle_name" class="form-control">
            </div>
            <div class="form-group">
              <label>Parent Contact</label>
              <input type="text" name="new_parent_contact" class="form-control">
            </div>
            <div class="form-group">
              <label>Parent Address</label>
              <input type="text" name="new_parent_address" class="form-control">
            </div>
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

<div class="modal fade" id="viewModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fas fa-eye"></i> Patient Details
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <h6 class="text-muted"><i class="fas fa-user"></i> Patient Info</h6>
        <hr class="mt-1">
        <p><strong>Last Name:</strong> <span id="view_last_name"></span></p>
        <p><strong>First Name:</strong> <span id="view_name"></span></p>
        <p><strong>Middle Name:</strong> <span id="view_middle_name"></span></p>
        <p><strong>Sex:</strong> <span id="view_sex"></span></p>
        <p><strong>Age:</strong> <span id="view_age"></span></p>
        <p><strong>Birthdate:</strong> <span id="view_birthdate"></span></p>
        <p><strong>Contact:</strong> <span id="view_contact"></span></p>
        <p><strong>Department:</strong> <span id="view_department"></span></p>

        <h6 class="text-muted mt-3"><i class="fas fa-user-friends"></i> Parent / Guardian</h6>
        <hr class="mt-1">
        <div id="view_parent_section">
          <p><strong>Name:</strong> <span id="view_parent_name"></span></p>
          <p><strong>Contact:</strong> <span id="view_parent_contact"></span></p>
          <p><strong>Address:</strong> <span id="view_parent_address"></span></p>
          <p><strong>Relationship:</strong> <span id="view_relationship"></span></p>
        </div>
        <div id="view_no_parent" style="display:none;">
          <p class="text-muted"><i class="fas fa-times-circle"></i> No parent/guardian assigned.</p>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
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
<script src="<?= base_url('js/patient/patient.js') ?>"></script>
<?= $this->endSection() ?>
