<?= $this->extend('theme/template') ?>
<?= $this->section('content') ?>

<div class="content-wrapper dashboard-page">

    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <div class="dash-header">
                        <h1 class="m-0">Dashboard</h1>
                        <div class="dash-subtitle">Overview of clinic activity and records</div>
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

                <div class="<?= $role === 'Nurse' ? 'col-lg-4' : 'col-lg-3' ?> col-6">
                    <div class="small-box dash-stat dash-stat--patients">
                        <div class="inner">
                            <h3 style="color: white;"><?= $patientCount ?? 0 ?></h3>
                            <p style="color:white;">Clinic Records</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-notes-medical"></i>
                        </div>
                        <a href="<?= base_url('patient') ?>" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <?php if (in_array($role, ['Admin', 'Doctor'])): ?>
                    <div class="col-lg-3 col-6">
                        <div class="small-box dash-stat dash-stat--medicines">
                            <div class="inner">
                                <h3 style="color: white;"><?= $medicineCount ?? 0 ?></h3>
                                <p style="color: white;">Clinic Medicines</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-briefcase-medical"></i>
                            </div>
                            <a href="<?= base_url('medicine') ?>" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- ADMIN -->
                  <?php if ($role === 'Admin'): ?>
                    <div class="col-lg-3 col-6">
                        <div class="small-box dash-stat dash-stat--equipment">
                            <div class="inner">
                                <h3 style="color: white;"><?= $equipmentCount ?? 0 ?></h3>
                                <p style="color: white;">Clinic Equipment</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-stethoscope"></i>
                            </div>
                            <a href="<?= base_url("equipment") ?>" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box dash-stat dash-stat--records">
                            <div class="inner">
                                <h3 style="color: white;"><?= $totalRecords ?? 0 ?></h3>
                                <p style="color: white;">Medical Records</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-medical-alt"></i>
                            </div>
                            <a href="<?= base_url('medical_record') ?>" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box dash-stat dash-stat--records">
                            <div class="inner">
                                <h3 style="color: white;"><?= $totalAppointment ?></h3>
                                <p style="color: white;">Appointments</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-calendar-alt"></i>
                            </div>
                            <a href="<?= base_url('appointment') ?>" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($role === 'Doctor'): ?>
                    <div class="col-lg-3 col-6">
                        <div class="small-box dash-stat dash-stat--equipment">
                            <div class="inner">
                                <h3 style="color: white;"><?= $equipmentCount ?? 0 ?></h3>
                                <p style="color: white;">Clinic Equipment</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-stethoscope"></i>
                            </div>
                            <a href="<?= base_url("equipment") ?>" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box dash-stat dash-stat--records">
                            <div class="inner">
                                <h3 style="color: white;"><?= $totalRecords ?? 0 ?></h3>
                                <p style="color: white;">Medical Records</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-medical-alt"></i>
                            </div>
                            <a href="<?= base_url('medical_record') ?>" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <div class="small-box dash-stat dash-stat--records">
                            <div class="inner">
                                <h3 style="color: white;"><?= $totalAppointment ?></h3>
                                <p style="color: white;">Appointments</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-calendar-alt"></i>
                            </div>
                            <a href="<?= base_url('appointment') ?>" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($role === 'Nurse'): ?>
                    <div class="col-lg-4 col-6">
                        <div class="small-box dash-stat dash-stat--records">
                            <div class="inner">
                                <h3 style="color: white;"><?= $totalRecords ?></h3>
                                <p style="color: white;">Medical Records</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-medical-alt"></i>
                            </div>
                            <a href="<?= base_url('medical_record') ?>" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <div class="small-box dash-stat dash-stat--patients">
                            <div class="inner">
                                <h3 style="color: white;"><?= $totalAppointment ?></h3>
                                <p style="color: white;">Appointments</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-calendar-alt"></i>
                            </div>
                            <a href="<?= base_url('appointment') ?>" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($role === 'Admin'): ?>
                    <div class="col-lg-3 col-6">
                        <div class="small-box dash-stat dash-stat--equipment">
                            <div class="inner">
                                <h3 style="color: white;"><?= $userCount ?></h3>
                                <p style="color: white;">System Users</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-nurse"></i>
                            </div>
                            <a href="<?= base_url("users") ?>" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($role === 'Admin'): ?>
                    <div class="col-lg-3 col-6">
                        <div class="small-box dash-stat dash-stat--week">
                            <div class="inner">
                                <h3 style="color: white; height: 43px;"><?= $todayRecords ?></h3>
                                <p style="color: white;">Consultations Today</p>
                                <small class="text-light"><?= date('F d, Y') ?></small>
                            </div>
                            <div class="icon"><i class="fas fa-calendar-day"></i></div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box dash-stat dash-stat--today">
                            <div class="inner">
                                <h3 style="color: white; height: 43px;"><?= $weekRecords ?></h3>
                                <p style="color: white;">Consultations (Last 7 Days)</p>
                                <small style="color: white;">Since <?= date('M d', strtotime('-7 days')) ?></small>
                            </div>
                            <div class="icon"><i class="fas fa-calendar-week"></i></div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($role === 'Doctor'): ?>
                    <div class="col-lg-4 col-6">
                        <div class="small-box dash-stat dash-stat--today">
                            <div class="inner">
                                <h3 style="color: white; height: 43px;"><?= $todayRecords ?></h3>
                                <p style="color: white;">Consultations Today</p>
                                <small class="text-light"><?= date('F d, Y') ?></small>
                            </div>
                            <div class="icon"><i class="fas fa-calendar-day"></i></div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <div class="small-box dash-stat dash-stat--week">
                            <div class="inner">
                                <h3 style="color: white; height: 43px;"><?= $weekRecords ?></h3>
                                <p style="color: white;">Consultations (Last 7 Days)</p>
                                <small style="color: white;">Since <?= date('M d', strtotime('-7 days')) ?></small>
                            </div>
                            <div class="icon"><i class="fas fa-calendar-week"></i></div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <div class="row mt-3 align-items-stretch">
                <div class="<?= empty($recentLogs) ? 'col-lg-12' : 'col-lg-8' ?> d-flex flex-column">
                    <div class="card dash-card">
                        <div class="card-header border-0">
                            <h3 class="card-title d-flex align-items-center">
                                <span class="dash-card-icon">
                                    <i class="fas fa-notes-medical"></i>
                                </span>
                                Total Consultations Today — <?= date('F d, Y') ?> <span>&nbsp;</span>
                                <span class="badge badge-info"><?= count($recentRecords) ?></span>
                            </h3>
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table table-hover table-sm dash-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Patient</th>
                                        <th>Doctor/Nurse</th>
                                        <th>Chief Complaint</th>
                                        <th>Diagnosis</th>
                                        <th>Treatment</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (empty($recentRecords)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">
                                                <i class="fas fa-calendar-times mr-2"></i>No consultations recorded today.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($recentRecords as $record): ?>
                                            <tr>
                                                <td><?= esc($record['date_consulted']) ?></td>
                                                <td><?= esc($record['patient_name'] ?? 'Unknown Patient') ?></td>
                                                <td><?= esc($record['staff_name'] ?? 'N/A') ?></td>
                                                <td><?= esc($record['chief_complaint'] ?? 'N/A') ?></td>
                                                <td><?= esc($record['diagnosis']) ?></td>
                                                <td><?= esc($record['treatment']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card dash-card mt-3">
                        <div class="card-header border-0">
                            <h3 class="card-title d-flex align-items-center">
                                <span class="dash-card-icon">
                                    <i class="fas fa-calendar-week"></i>
                                </span>
                                Consultations (Last 7 Days) <span>&nbsp;</span>
                                <span class="badge badge-info"><?= esc($weekRecords ?? 0) ?></span>
                            </h3>
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table table-hover table-sm dash-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Patient</th>
                                        <th>Doctor/Nurse</th>
                                        <th>Chief Complaint</th>
                                        <th>Diagnosis</th>
                                        <th>Treatment</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (empty($weekRecentRecords)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">
                                                <i class="fas fa-calendar-times mr-2"></i>No consultations recorded in the last 7 days.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($weekRecentRecords as $record): ?>
                                            <tr>
                                                <td><?= esc($record['date_consulted']) ?></td>
                                                <td><?= esc($record['patient_name'] ?? 'Unknown Patient') ?></td>
                                                <td><?= esc($record['staff_name'] ?? 'N/A') ?></td>
                                                <td><?= esc($record['chief_complaint'] ?? 'N/A') ?></td>
                                                <td><?= esc($record['diagnosis'] ?? 'N/A') ?></td>
                                                <td><?= esc($record['treatment'] ?? 'N/A') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <?php if (!empty($recentLogs)): ?>
                    <div class="col-lg-4 d-flex">
                        <div class="card dash-card dash-side-card w-100">
                            <div class="card-header border-0">
                                <h3 class="card-title d-flex align-items-center">
                                    <span class="dash-card-icon">
                                        <i class="fas fa-history"></i>
                                    </span>
                                    Recent Activity
                                </h3>
                                <div class="card-tools">
                                    <!-- <a href="<?= base_url('log') ?>" class="btn btn-tool">View all</a> -->
                                </div>
                            </div>

                            <div class="card-body p-0 dash-side-scroll">
                                <ul class="list-group list-group-flush">
                                    <?php
                                    $logMeta = [
                                        'ADD'     => ['badge' => 'badge-success',   'icon' => 'fa-plus'],
                                        'UPDATED' => ['badge' => 'badge-primary',   'icon' => 'fa-edit'],
                                        'DELETED' => ['badge' => 'badge-danger',    'icon' => 'fa-trash'],
                                        'LOGIN'   => ['badge' => 'badge-info',      'icon' => 'fa-sign-in-alt'],
                                        'LOGOUT'  => ['badge' => 'badge-secondary', 'icon' => 'fa-sign-out-alt'],
                                    ];
                                    ?>
                                    <?php foreach ($recentLogs as $log): ?>
                                        <?php
                                        $identifier = $log['identifier'] ?? '';
                                        $meta = $logMeta[$identifier] ?? ['badge' => 'badge-light', 'icon' => 'fa-info-circle'];
                                        ?>
                                        <li class="list-group-item dash-activity-item">
                                            <div class="dash-activity-icon <?= esc($meta['badge']) ?>">
                                                <i class="fas <?= esc($meta['icon']) ?>"></i>
                                            </div>
                                            <div class="dash-activity-body">
                                                <div class="d-flex justify-content-between">
                                                    <strong class="dash-activity-user"><?= esc($log['USER_NAME'] ?? 'Unknown') ?></strong>
                                                    <small class="text-muted">
                                                        <?= esc(date('M d', strtotime($log['DATELOG']))) ?>
                                                        <?= esc(date('h:i A', strtotime($log['TIMELOG']))) ?>
                                                    </small>
                                                </div>
                                                <div class="dash-activity-action">
                                                    <?= esc($log['ACTION']) ?>
                                                    <?php if (!empty($identifier)): ?>
                                                        <span class="badge <?= esc($meta['badge']) ?> ml-1"><?= esc($identifier) ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </section>

</div>

<?= $this->endSection() ?>
