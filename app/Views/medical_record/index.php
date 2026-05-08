<?= $this->extend('theme/template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">

    <!-- HEADER -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Medical Records</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <section class="content">
        <div class="container-fluid">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Patient Consultation Records</h3>

                    <div class="float-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#AddNewModal">
                            <i class="fa fa-plus-circle"></i> Add Record
                        </button>
                    </div>
                </div>

                <div class="card-body">

                    <table id="example1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th style="display:none;">ID</th>
                                <th>Staff</th>          
                                <th>Patient</th>         
                                <th>Chief Complaint</th>
                                <th>Diagnosis</th>
                                <th>Treatment</th>
                                <!-- <th>Remarks</th>          -->
                                <th>Date Consulted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>

            </div>

        </div>
    </section>

</div>

<!-- ================= ADD MODAL ================= -->
<div class="modal fade" id="AddNewModal">
    <div class="modal-dialog">

        <form id="addMedicalForm">
            <?= csrf_field() ?>

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">New Medical Record</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                 
                    <div class="form-group">
                        <label>Patient</label>
                        <select name="patient_id" class="form-control" required>
                            <option value="">-- Select Patient --</option>
                            <?php foreach ($patients as $p): ?>
                                <option value="<?= $p['patient_id'] ?>">
                                    <?= $p['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                  
                    <div class="form-group">
                        <label>Attending Staff</label>
                        <select name="user_id" class="form-control" required>
                            <option value="">-- Select Doctor/Nurse --</option>
                            <?php foreach ($users as $u): ?>
                                <option value="<?= $u['id'] ?>">
                                    <?= $u['name'] ?> (<?= $u['role'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                   
                    <div class="form-group">
                        <label>Chief Complaint</label>
                        <input type="text" name="chief_complaint" class="form-control" required>
                    </div>

                   
                    <div class="form-group">
                        <label>Diagnosis</label>
                        <input type="text" name="diagnosis" class="form-control">
                    </div>

                  
                    <div class="form-group">
                        <label>Treatment</label>
                        <input type="text" name="treatment" class="form-control">
                    </div>

                    <!-- REMARKS -->
                    <!-- <div class="form-group">
                        <label>Remarks</label>
                        <input type="text" name="remarks" class="form-control">
                    </div> -->

                
                    <div class="form-group">
                        <label>Date Consulted</label>
                        <input type="datetime-local" name="date_consulted" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </div>
        </form>

    </div>
</div>

<!-- ================= EDIT MODAL ================= -->
<div class="modal fade" id="editMedicalModal">
    <div class="modal-dialog">

        <form id="editMedicalForm">
            <?= csrf_field() ?>

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Medical Record</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="record_id" id="record_id">

                 
                    <div class="form-group">
                        <label>Patient</label>
                        <select name="patient_id" id="patient_id" class="form-control">
                            <option value="">-- Select Patient --</option>
                            <?php foreach ($patients as $p): ?>
                                <option value="<?= $p['patient_id'] ?>">
                                    <?= $p['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                 
                    <div class="form-group">
                        <label>Attending Staff</label>
                        <select name="user_id" id="user_id" class="form-control">
                            <option value="">-- Select Doctor/Nurse --</option>
                            <?php foreach ($users as $u): ?>
                                <option value="<?= $u['id'] ?>">
                                    <?= $u['name'] ?> (<?= $u['role'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

               
                    <div class="form-group">
                        <label>Chief Complaint</label>
                        <input type="text" name="chief_complaint" id="chief_complaint" class="form-control">
                    </div>

              
                    <div class="form-group">
                        <label>Diagnosis</label>
                        <input type="text" name="diagnosis" id="diagnosis" class="form-control">
                    </div>

                 
                    <div class="form-group">
                        <label>Treatment</label>
                        <input type="text" name="treatment" id="treatment" class="form-control">
                    </div>

             
                    <!-- <div class="form-group">
                        <label>Remarks</label>
                        <input type="text" name="remarks" id="remarks" class="form-control">
                    </div> -->

              
                    <div class="form-group">
                        <label>Date Consulted</label>
                        <input type="datetime-local" name="date_consulted" id="date_consulted" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>

            </div>
        </form>

    </div>
</div>

<!-- ================= VIEW MODAL ================= -->
<div class="modal fade" id="viewModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Medical Record Details</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>Patient</th>
                        <td id="name"></td>        
                    </tr>
                    <tr>
                        <th>Attending Staff</th>
                        <td id="doctor_name"></td> 
                    </tr>
                    <tr>
                        <th>Chief Complaint</th>
                        <td id="chief_complaint"></td>
                    </tr>
                    <tr>
                        <th>Diagnosis</th>
                        <td id="diagnosis"></td>
                    </tr>
                    <tr>
                        <th>Treatment</th>
                        <td id="treatment"></td>
                    </tr>
                    <!-- <tr>
                        <th>Remarks</th>
                        <td id="remarks"></td>
                    </tr> -->
                    <tr>
                        <th>Date Consulted</th>
                        <td id="date_consulted"></td>
                    </tr>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    const baseUrl = "<?= base_url() ?>";
</script>
<script src="<?= base_url('js/medical_record/medical_record.js') ?>"></script>
<?= $this->endSection() ?>