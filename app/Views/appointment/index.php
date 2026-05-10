<?= $this->extend('theme/template') ?>
<?= $this->section('content') ?>
<div class="content-wrapper dashboard-page">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <div class="dash-header">
                        <h1 class="m-0">Appointments</h1>
                        <div class="dash-subtitle">Manage clinic appointments</div>
                    </div>
                </div>
                <div class="col-sm-6 d-flex align-items-center justify-content-sm-end">
                    <div class="dash-date">
                        <i class="far fa-calendar-alt"></i> <?= date('F d, Y') ?>
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
                                <span class="dash-card-icon"><i class="fa fa-calendar-alt"></i></span>
                                Appointments
                            </h3>
                            <div class="card-tools d-flex align-items-center gap-2">
                                <!-- View toggle -->
                                <div class="btn-group mr-2" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary active" id="btnTableView">
                                        <i class="fas fa-list"></i> Table
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btnCalendarView">
                                        <i class="fas fa-calendar"></i> Calendar
                                    </button>
                                </div>
                                <button type="button" class="btn btn-sm btn-primary px-3" data-toggle="modal" data-target="#AddNewModal">
                                    <i class="fa fa-plus-circle mr-1"></i> Add New
                                </button>
                            </div>
                        </div>

                        <div class="card-body">

                            <!-- TABLE VIEW -->
                            <div id="tableView">
                                <table id="example1" class="table table-bordered table-hover table-sm dash-table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th style="display:none;">ID</th>
                                            <th>Patient Name</th>
                                            <th>Doctor/Nurse</th>
                                            <th>Appointment Date</th>
                                            <th>Status</th>
                                            <th>Notes</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                            <!-- CALENDAR VIEW -->
                            <div id="calendarView" style="display:none;">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <button class="btn btn-sm btn-outline-secondary" id="calPrev">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <h5 class="mb-0" id="calTitle"></h5>
                                    <button class="btn btn-sm btn-outline-secondary" id="calNext">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                                <div id="calendarGrid"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ADD MODAL -->
        <div class="modal fade" id="AddNewModal">
            <div class="modal-dialog">
                <form id="addAppointmentForm">
                    <?= csrf_field() ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="fa fa-plus-circle"></i> Add Appointment</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">

                            <!-- Conflict warning -->
                            <div class="alert alert-warning d-none" id="addConflictAlert">
                                <strong><i class="fas fa-exclamation-triangle"></i> Conflict Detected!</strong>
                                <ul id="addConflictList" class="mb-0 mt-1"></ul>
                            </div>

                            <div class="form-group">
                                <label>Patient</label>
                                <select name="patient_id" class="form-control" required>
                                    <option value="">-- Select Patient --</option>
                                    <?php foreach ($patients as $p): ?>
                                        <option value="<?= $p['patient_id'] ?>">
                                            <?= esc($p['last_name']) ?>, <?= esc($p['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Doctor/Nurse</label>
                                <select name="user_id" class="form-control" required>
                                    <option value="">-- Select Doctor/Nurse --</option>
                                    <?php foreach ($users as $u): ?>
                                        <?php if ($u['role'] !== 'Admin'): ?>
                                            <option value="<?= $u['id'] ?>"><?= esc($u['name']) ?> — <?= esc($u['role']) ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Appointment Date & Time</label>
                                <input type="datetime-local" name="appointment_date" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Notes</label>
                                <input type="text" name="notes" class="form-control">
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

        <!-- EDIT MODAL -->
        <div class="modal fade" id="editAppointmentModal">
            <div class="modal-dialog">
                <form id="editAppointmentForm">
                    <?= csrf_field() ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="far fa-edit"></i> Edit Appointment</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">

                            <div class="alert alert-warning d-none" id="editConflictAlert">
                                <strong><i class="fas fa-exclamation-triangle"></i> Conflict Detected!</strong>
                                <ul id="editConflictList" class="mb-0 mt-1"></ul>
                            </div>

                            <input type="hidden" id="appointment_id" name="appointment_id">

                            <div class="form-group">
                                <label>Patient</label>
                                <select name="patient_id" id="patient_id" class="form-control" required>
                                    <option value="">-- Select Patient --</option>
                                    <?php foreach ($patients as $p): ?>
                                        <option value="<?= $p['patient_id'] ?>">
                                            <?= esc($p['last_name']) ?>, <?= esc($p['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Doctor/Nurse</label>
                                <select name="user_id" id="user_id" class="form-control" required>
                                    <option value="">-- Select Doctor/Nurse --</option>
                                    <?php foreach ($users as $u): ?>
                                        <option value="<?= $u['id'] ?>"><?= esc($u['name']) ?> — <?= esc($u['role']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Appointment Date & Time</label>
                                <input type="datetime-local" name="appointment_date" id="appointment_date" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Notes</label>
                                <input type="text" name="notes" id="notes" class="form-control">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>
</div>



<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const baseUrl = "<?= base_url() ?>";
</script>
<script src="<?= base_url('js/appointment/appointment.js') ?>"></script>
<?= $this->endSection() ?>
<style>
.badge-pending   { background:#fff3cd; color:#856404; }
.badge-confirmed { background:#cfe2ff; color:#084298; }
.badge-completed { background:#d1e7dd; color:#0a3622; }
.badge-cancelled { background:#f8d7da; color:#842029; }
tr.today-row     { background:#fffde7 !important; }
</style>