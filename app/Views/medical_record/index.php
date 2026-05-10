<?= $this->extend('theme/template') ?>
<?= $this->section('content') ?>
<div class="content-wrapper dashboard-page">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <div class="dash-header">
                        <h1 class="m-0">Clinic Medical Records</h1>
                        <div class="dash-subtitle">Manage and view all registered medical records</div>
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
            <div class="card dash-card">
                <div class="card-header border-0">
                    <h3 class="card-title d-flex align-items-center">
                        <span class="dash-card-icon">
                            <i class="fas fa-file-medical-alt"></i>
                        </span>
                        List of Medical Records
                    </h3>
                    <div class="card-tools">
                        <button class="btn btn-sm btn-primary px-3" data-toggle="modal" data-target="#AddNewModal">
                            <i class="fa fa-plus-circle mr-1"></i> Add Record
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-hover table-bordered table-sm dash-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th style="display:none;">ID</th>
                                <th>Staff</th>
                                <th>Patient</th>
                                <th>Chief Complaint</th>
                                <th>Diagnosis</th>
                                <th>Treatment</th>
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
    <div class="modal-dialog modal-lg">
        <form id="addMedicalForm">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-plus-circle mr-1"></i> New Medical Record</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Patient</label>
                        <select name="patient_id" class="form-control" required>
                            <option value="">-- Select Patient --</option>
                            <?php foreach ($patients as $p): ?>
                                <option value="<?= $p['patient_id'] ?>"><?= $p['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Attending Staff</label>
                        <select name="user_id" class="form-control" required>
                            <option value="">-- Select Doctor/Nurse --</option>
                            <?php foreach ($users as $u): ?>
                                <option value="<?= $u['id'] ?>"><?= $u['name'] ?> (<?= $u['role'] ?>)</option>
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

                    <div class="form-group">
                        <label>Date Consulted</label>
                        <input type="datetime-local" name="date_consulted" class="form-control" required>
                    </div>

                    <!-- ── Medicines Given Section ── -->
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="mb-0 font-weight-bold">
                            <i class="fas fa-pills mr-1 text-primary"></i> Medicines Given
                        </label>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="addMedicineRowBtn">
                            <i class="fa fa-plus"></i> Add Medicine
                        </button>
                    </div>

                    <div id="addMedicineRows">
                        <!-- Rows injected by JS -->
                    </div>
                    <small class="text-muted">Only medicines with available stock are listed. Quantities will be automatically deducted from inventory.</small>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-1"></i> Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ================= EDIT MODAL ================= -->
<div class="modal fade" id="editMedicalModal">
    <div class="modal-dialog modal-lg">
        <form id="editMedicalForm">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="far fa-edit mr-1"></i> Edit Medical Record</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="record_id" id="record_id">

                    <div class="form-group">
                        <label>Patient</label>
                        <select name="patient_id" id="patient_id" class="form-control">
                            <option value="">-- Select Patient --</option>
                            <?php foreach ($patients as $p): ?>
                                <option value="<?= $p['patient_id'] ?>"><?= $p['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Attending Staff</label>
                        <select name="user_id" id="user_id" class="form-control">
                            <option value="">-- Select Doctor/Nurse --</option>
                            <?php foreach ($users as $u): ?>
                                <option value="<?= $u['id'] ?>"><?= $u['name'] ?> (<?= $u['role'] ?>)</option>
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

                    <div class="form-group">
                        <label>Date Consulted</label>
                        <input type="datetime-local" name="date_consulted" id="date_consulted" class="form-control">
                    </div>

                    <!-- ── Medicines Given Section ── -->
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="mb-0 font-weight-bold">
                            <i class="fas fa-pills mr-1 text-primary"></i> Medicines Given
                        </label>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="editAddMedicineRowBtn">
                            <i class="fa fa-plus"></i> Add Medicine
                        </button>
                    </div>

                    <div id="editMedicineRows">
                        <!-- Rows injected by JS -->
                    </div>
                    <small class="text-muted">Updating medicines will restore old stock and deduct the new quantities.</small>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-1"></i> Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ================= VIEW MODAL ================= -->
<div class="modal fade" id="viewModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-eye mr-1"></i> Medical Record Details</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm">
                    <tr><th width="160">Patient</th><td id="view_name"></td></tr>
                    <tr><th>Attending Staff</th><td id="view_doctor_name"></td></tr>
                    <tr><th>Chief Complaint</th><td id="view_chief_complaint"></td></tr>
                    <tr><th>Diagnosis</th><td id="view_diagnosis"></td></tr>
                    <tr><th>Treatment</th><td id="view_treatment"></td></tr>
                    <tr><th>Date Consulted</th><td id="view_date_consulted"></td></tr>
                </table>

                <hr>
                <h6 class="font-weight-bold"><i class="fas fa-pills mr-1 text-primary"></i> Medicines Given</h6>
                <table class="table table-bordered table-sm" id="viewMedicinesTable">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th width="120">Qty Given</th>
                        </tr>
                    </thead>
                    <tbody id="view_medicines_body">
                        <tr><td colspan="2" class="text-muted text-center">No medicines recorded.</td></tr>
                    </tbody>
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
    const baseUrl  = "<?= base_url() ?>";

    // Pass medicines list from PHP to JS
    const medicinesList = <?= json_encode(array_map(function($m) {
        return [
            'medicine_id'   => $m['medicine_id'],
            'medicine_name' => $m['medicine_name'],
            'quantity'      => $m['quantity'],
        ];
    }, $medicines)) ?>;
</script>
<script src="<?= base_url('js/medical_record/medical_record.js') ?>"></script>
<?= $this->endSection() ?>
