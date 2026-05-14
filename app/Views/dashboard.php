<?= $this->extend('theme/template') ?>
<?= $this->section('content') ?>
<div class="content-wrapper dashboard-page">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="dash-header">
            <h1 class="m-0">Dashboard</h1>
            <div class="dash-subtitle">Ian's Store overview</div>
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
        <div class="col-lg-3 col-6">
          <div class="small-box dash-stat dash-stat--patients">
            <div class="inner">
              <h3 style="color:white;"><?= (int) ($productCount ?? 0) ?></h3>
              <p style="color:white;">Total Products</p>
            </div>
            <div class="icon"><i class="fas fa-box"></i></div>
            <a href="<?= base_url('product') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box dash-stat dash-stat--today">
            <div class="inner">
              <h3 style="color:white;">₱<?= number_format((float) ($todayRevenue ?? 0), 2) ?></h3>
              <p style="color:white;">Today's Income</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-day"></i></div>
            <a href="<?= base_url('sales') ?>" class="small-box-footer">Sales <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box dash-stat dash-stat--week">
            <div class="inner">
              <h3 style="color:white;">₱<?= number_format((float) ($weekRevenue ?? 0), 2) ?></h3>
              <p style="color:white;">Last 7 Days</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-week"></i></div>
            <a href="<?= base_url('sales') ?>" class="small-box-footer">Sales <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box dash-stat dash-stat--records">
            <div class="inner">
              <h3 style="color:white;">₱<?= number_format((float) ($monthRevenue ?? 0), 2) ?></h3>
              <p style="color:white;">This Month</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-alt"></i></div>
            <a href="<?= base_url('sales') ?>" class="small-box-footer">Sales <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box dash-stat dash-stat--medicines">
            <div class="inner">
              <h3 style="color:white;">₱<?= number_format((float) ($yearRevenue ?? 0), 2) ?></h3>
              <p style="color:white;">This Year</p>
            </div>
            <div class="icon"><i class="fas fa-chart-line"></i></div>
            <a href="<?= base_url('sales') ?>" class="small-box-footer">Sales <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <?php if (($role ?? '') === 'Admin'): ?>
          <div class="col-lg-3 col-6">
            <div class="small-box dash-stat dash-stat--equipment">
              <div class="inner">
                <h3 style="color:white;"><?= (int) ($userCount ?? 0) ?></h3>
                <p style="color:white;">System Users</p>
              </div>
              <div class="icon"><i class="fas fa-user-shield"></i></div>
              <a href="<?= base_url('users') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <div class="row mt-3">
        <div class="col-lg-4">
          <div class="card dash-card">
            <div class="card-header border-0">
              <h3 class="card-title d-flex align-items-center">
                <span class="dash-card-icon"><i class="fas fa-chart-area"></i></span>
                Weekly Revenue
              </h3>
            </div>
            <div class="card-body">
              <div class="revenue-chart">
                <canvas id="revenueWeekChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card dash-card">
            <div class="card-header border-0">
              <h3 class="card-title d-flex align-items-center">
                <span class="dash-card-icon"><i class="fas fa-chart-bar"></i></span>
                Monthly Revenue
              </h3>
            </div>
            <div class="card-body">
              <div class="revenue-chart">
                <canvas id="revenueMonthChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card dash-card">
            <div class="card-header border-0">
              <h3 class="card-title d-flex align-items-center">
                <span class="dash-card-icon"><i class="fas fa-chart-line"></i></span>
                Yearly Revenue
              </h3>
            </div>
            <div class="card-body">
              <div class="revenue-chart">
                <canvas id="revenueYearChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php if (!empty($recentLogs)): ?>
        <div class="row mt-3">
          <div class="col-12">
            <div class="card dash-card">
              <div class="card-header border-0">
                <h3 class="card-title d-flex align-items-center">
                  <span class="dash-card-icon"><i class="fas fa-history"></i></span>
                  Recent Activity
                </h3>
                <div class="card-tools">
                  <a href="<?= base_url('log') ?>" class="btn btn-tool">View all</a>
                </div>
              </div>
              <div class="card-body table-responsive">
                <table class="table table-hover table-sm dash-table">
                  <thead>
                    <tr>
                      <th>User</th>
                      <th>Action</th>
                      <th>Date</th>
                      <th>Time</th>
                      <th>Type</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($recentLogs as $log): ?>
                      <tr>
                        <td><?= esc($log['USER_NAME'] ?? 'Unknown') ?></td>
                        <td><?= esc($log['ACTION'] ?? '') ?></td>
                        <td><?= esc($log['DATELOG'] ?? '') ?></td>
                        <td><?= esc($log['TIMELOG'] ?? '') ?></td>
                        <td><?= esc($log['identifier'] ?? '') ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  const weekLabels = <?= json_encode($chartWeek['labels'] ?? []) ?>;
  const weekData = <?= json_encode($chartWeek['data'] ?? []) ?>;
  const monthLabels = <?= json_encode($chartMonth['labels'] ?? []) ?>;
  const monthData = <?= json_encode($chartMonth['data'] ?? []) ?>;
  const yearLabels = <?= json_encode($chartYear['labels'] ?? []) ?>;
  const yearData = <?= json_encode($chartYear['data'] ?? []) ?>;

  function buildLineChart(canvasId, labels, data) {
    const el = document.getElementById(canvasId);
    if (!el) return;
    new Chart(el.getContext('2d'), {
      type: 'line',
      data: {
        labels,
        datasets: [{
          label: 'Revenue',
          data,
          borderColor: '#6f42c1',
          backgroundColor: 'rgba(111, 66, 193, 0.12)',
          tension: 0.25,
          fill: true,
          pointRadius: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) { return '₱' + value; }
            }
          }
        }
      }
    });
  }

  buildLineChart('revenueWeekChart', weekLabels, weekData);
  buildLineChart('revenueMonthChart', monthLabels, monthData);
  buildLineChart('revenueYearChart', yearLabels, yearData);
</script>
<?= $this->endSection() ?>
