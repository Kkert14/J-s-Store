<?= $this->extend('theme/template') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">

<?= $this->section('content') ?>
<div class="content-wrapper dashboard-page">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <div class="dash-header">
                        <h1 class="m-0">Activity Logs</h1>
                        <div class="dash-subtitle">View and filter all system activity</div>
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

            <!-- ── Filter + View Toggle Bar ── -->
            <div class="card dash-card mb-3">
                <div class="card-body py-2">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">

                        <form id="dateFilterForm" method="get" class="d-flex align-items-center mb-0">
                            <label class="mb-0 mr-2 font-weight-bold text-nowrap">
                                <i class="far fa-calendar-alt mr-1"></i> Filter by Date:
                            </label>
                            <input type="date"
                                   id="filterDate"
                                   name="date"
                                   class="form-control form-control-sm"
                                   style="max-width:200px;"
                                   value="<?= esc($selectedDate ?? date('Y-m-d')) ?>">
                        </form>

                        <!-- View Toggle -->
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-secondary active" id="btnActivityView">
                                <i class="fas fa-history mr-1"></i> Activity Feed
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="btnTimelineView">
                                <i class="fas fa-stream mr-1"></i> Timeline
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <?php
            $logMeta = [
                'ADD'     => ['badge' => 'badge-success',   'icon' => 'fa-plus'],
                'UPDATED' => ['badge' => 'badge-primary',   'icon' => 'fa-edit'],
                'DELETED' => ['badge' => 'badge-danger',    'icon' => 'fa-trash'],
                'LOGIN'   => ['badge' => 'badge-info',      'icon' => 'fa-sign-in-alt'],
                'LOGOUT'  => ['badge' => 'badge-secondary', 'icon' => 'fa-sign-out-alt'],
            ];
            ?>

            <?php if (!empty($logs)): ?>

                <!-- ══════════════════════════════════════
                     ACTIVITY FEED VIEW (default)
                     ══════════════════════════════════════ -->
                <div id="activityFeedView">
                    <div class="card dash-card dash-side-card">
                        <div class="card-header border-0">
                            <h3 class="card-title d-flex align-items-center">
                                <span class="dash-card-icon">
                                    <i class="fas fa-history"></i>
                                </span>
                                Activity on <?= esc(date('F d, Y', strtotime($selectedDate ?? date('Y-m-d')))) ?>
                                <span class="badge badge-info ml-2"><?= count($logs) ?></span>
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <?php foreach ($logs as $log): ?>
                                    <?php
                                    $identifier = $log['identifier'] ?? '';
                                    $meta = $logMeta[$identifier] ?? ['badge' => 'badge-light', 'icon' => 'fa-info-circle'];
                                    ?>
                                    <li class="list-group-item dash-activity-item">
                                        <div class="dash-activity-icon <?= esc($meta['badge']) ?>">
                                            <i class="fas <?= esc($meta['icon']) ?>"></i>
                                        </div>
                                        <div class="dash-activity-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <strong class="dash-activity-user"><?= esc($log['USER_NAME'] ?? 'Unknown') ?></strong>
                                                <small class="text-muted ml-2 text-nowrap">
                                                    <i class="far fa-clock mr-1"></i><?= esc(date('h:i A', strtotime($log['TIMELOG']))) ?>
                                                </small>
                                            </div>
                                            <div class="dash-activity-action">
                                                <?= esc($log['ACTION']) ?>
                                                <?php if (!empty($identifier)): ?>
                                                    <span class="badge <?= esc($meta['badge']) ?> ml-1"><?= esc($identifier) ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <small class="text-muted">
                                                <i class="fas fa-network-wired mr-1"></i><?= esc($log['user_ip_address']) ?>
                                                &nbsp;|&nbsp;
                                                <i class="fas fa-desktop mr-1"></i>
                                                <?= esc(strlen($log['device_used']) > 60 ? substr($log['device_used'], 0, 60) . '…' : $log['device_used']) ?>
                                            </small>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- ══════════════════════════════════════
                     TIMELINE VIEW
                     ══════════════════════════════════════ -->
                <div id="timelineView" style="display:none;">
                    <div class="timeline timeline-inverse">
                        <?php foreach ($logs as $log): ?>
                            <?php
                            $identifier = $log['identifier'] ?? '';
                            $meta = $logMeta[$identifier] ?? ['badge' => 'badge-light', 'icon' => 'fa-info-circle'];
                            // Map badge class to timeline icon bg color
                            $bgMap = [
                                'badge-success'   => 'bg-success',
                                'badge-primary'   => 'bg-primary',
                                'badge-danger'    => 'bg-danger',
                                'badge-info'      => 'bg-info',
                                'badge-secondary' => 'bg-secondary',
                                'badge-light'     => 'bg-gray',
                            ];
                            $bgClass = $bgMap[$meta['badge']] ?? 'bg-info';
                            ?>
                            <div>
                                <i class="fas <?= esc($meta['icon']) ?> <?= esc($bgClass) ?>"></i>
                                <div class="timeline-item">
                                    <span class="time">
                                        <i class="far fa-clock"></i>
                                        <?= esc(date('h:i A', strtotime($log['TIMELOG']))) ?>
                                    </span>
                                    <h3 class="timeline-header">
                                        <?= esc($log['USER_NAME']) ?>
                                        <?php if (!empty($identifier)): ?>
                                            <span class="badge <?= esc($meta['badge']) ?> ml-1"><?= esc($identifier) ?></span>
                                        <?php endif; ?>
                                    </h3>
                                    <div class="timeline-body">
                                        <strong>Action:</strong> <?= esc($log['ACTION']) ?><br>
                                        <strong>IP Address:</strong> <?= esc($log['user_ip_address']) ?><br>
                                        <strong>Device:</strong> <?= esc(strlen($log['device_used']) > 80 ? substr($log['device_used'], 0, 80) . '…' : $log['device_used']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div>
                            <i class="fas fa-clock bg-gray"></i>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i>
                    No activity logs found for <?= esc(date('F d, Y', strtotime($selectedDate ?? date('Y-m-d')))) ?>.
                </div>
            <?php endif; ?>

        </div>
    </section>
</div>

<div class="toasts-top-right fixed" style="position: fixed; top: 1rem; right: 1rem; z-index: 9999;"></div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Auto-submit on date change
    document.getElementById('filterDate').addEventListener('change', function () {
        document.getElementById('dateFilterForm').submit();
    });

    // Restore last used view from localStorage
    const savedView = localStorage.getItem('logView') || 'activity';
    if (savedView === 'timeline') {
        switchView('timeline');
    }

    document.getElementById('btnActivityView').addEventListener('click', function () {
        switchView('activity');
    });

    document.getElementById('btnTimelineView').addEventListener('click', function () {
        switchView('timeline');
    });

    function switchView(view) {
        const activityEl  = document.getElementById('activityFeedView');
        const timelineEl  = document.getElementById('timelineView');
        const btnActivity = document.getElementById('btnActivityView');
        const btnTimeline = document.getElementById('btnTimelineView');

        if (view === 'activity') {
            activityEl  && (activityEl.style.display  = '');
            timelineEl  && (timelineEl.style.display  = 'none');
            btnActivity && btnActivity.classList.add('active');
            btnTimeline && btnTimeline.classList.remove('active');
        } else {
            activityEl  && (activityEl.style.display  = 'none');
            timelineEl  && (timelineEl.style.display  = '');
            btnActivity && btnActivity.classList.remove('active');
            btnTimeline && btnTimeline.classList.add('active');
        }

        localStorage.setItem('logView', view);
    }
</script>
<?= $this->endSection() ?>