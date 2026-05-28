<?= $this->extend('theme/template') ?>
<?= $this->section('content') ?>
<div class="content-wrapper dashboard-page">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <div class="dash-header">
            <h1 class="m-0">Dashboard</h1>
            <div class="dash-subtitle">J's Store overview</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box dash-stat dash-stat--patients">
            <div class="inner">
              <h3><?= (int) ($productCount ?? 0) ?></h3>
              <p>Total Products</p>
            </div>
            <div class="icon"><i class="fas fa-box"></i></div>
            <a href="<?= base_url('product') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box dash-stat dash-stat--today">
            <div class="inner">
              <h3>₱<?= number_format((float) ($todayRevenue ?? 0), 2) ?></h3>
              <p>Today's Income</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-day"></i></div>
            <a href="<?= base_url('sales') ?>" class="small-box-footer">Sales <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box dash-stat dash-stat--week">
            <div class="inner">
              <h3>₱<?= number_format((float) ($weekRevenue ?? 0), 2) ?></h3>
              <p>Last 7 Days</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-week"></i></div>
            <a href="<?= base_url('sales') ?>" class="small-box-footer">Sales <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box dash-stat dash-stat--records">
            <div class="inner">
              <h3>₱<?= number_format((float) ($monthRevenue ?? 0), 2) ?></h3>
              <p>This Month</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-alt"></i></div>
            <a href="<?= base_url('sales') ?>" class="small-box-footer">Sales <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box dash-stat dash-stat--medicines">
            <div class="inner">
              <h3>₱<?= number_format((float) ($yearRevenue ?? 0), 2) ?></h3>
              <p>This Year</p>
            </div>
            <div class="icon"><i class="fas fa-chart-line"></i></div>
            <a href="<?= base_url('sales') ?>" class="small-box-footer">Sales <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <?php if (($role ?? '') === 'Admin'): ?>
          <div class="col-lg-3 col-6">
            <div class="small-box dash-stat dash-stat--equipment">
              <div class="inner">
                <h3><?= (int) ($userCount ?? 0) ?></h3>
                <p>System Users</p>
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
  const weekLabels = <?= json_encode($chartWeek['labels']  ?? []) ?>;
  const weekData = <?= json_encode($chartWeek['data']    ?? []) ?>;

  const monthLabels = <?= json_encode($chartMonth['labels'] ?? []) ?>;
  const monthData = <?= json_encode($chartMonth['data']   ?? []) ?>;

  const yearLabels = <?= json_encode($chartYear['labels']  ?? []) ?>;
  const yearData = <?= json_encode($chartYear['data']    ?? []) ?>;


  // /* ── Kill AdminLTE's global Chart.js overrides ── */
  // if (window.Chart) {
  //   Chart.defaults.plugins.legend.display = false;
  //   Chart.defaults.scales.linear.ticks.display = true; // keep y ticks
  //   Chart.defaults.plugins.tooltip.callbacks = {};

  //   // Wipe any globally registered scale defaults that force x ticks on
  //   if (Chart.defaults.scales.category) {
  //     Chart.defaults.scales.category.ticks = { display: false };
  //     Chart.defaults.scales.category.grid  = { display: false, drawBorder: false };
  //     Chart.defaults.scales.category.border = { display: false };
  //   }
  // }
  /* ── Theme-aware color resolver ── */
  function chartColors() {
    const dark = document.body.classList.contains('dark-mode');

    return {
      line: dark ? '#f5f4f0' : '#1a1916',
      fill: dark ? 'rgba(245,244,240,0.07)' : 'rgba(26,25,22,0.06)',
      bar: dark ? 'rgba(245,244,240,0.15)' : 'rgba(26,25,22,0.08)',
      barHover: dark ? 'rgba(245,244,240,0.28)' : 'rgba(26,25,22,0.18)',
      grid: dark ? 'rgba(255,255,255,0.04)' : 'rgba(26,25,22,0.05)',
      tick: dark ? '#5c5a55' : '#b0ada5',
      tooltipBg: dark ? '#1f1e1b' : '#1a1916',
      tooltipText: dark ? '#c8c5bc' : '#f5f4f0',
      point: dark ? '#f5f4f0' : '#1a1916',
      pointHover: dark ? '#1a1916' : '#ffffff',
    };
  }

  /* ── Shared Chart Options ── */
  function sharedOpts(c) {
    return {
      responsive: true,
      maintainAspectRatio: false,

      plugins: {
        legend: {
          display: false
        },

        tooltip: {
          backgroundColor: c.tooltipBg,
          titleColor: c.tooltipText,
          bodyColor: c.tooltipText,
          padding: 10,
          cornerRadius: 8,
          borderColor: 'rgba(255,255,255,0.06)',
          borderWidth: 1,

          callbacks: {
            // ← suppress the date from showing as tooltip title
            title: () => null,
            label: ctx => ' ₱' + ctx.parsed.y.toLocaleString()
          }
        }
      },

      scales: {
        x: {
          ticks: {
            color: c.tick,

            font: {
              family: "'DM Sans', sans-serif",
              size: 10
            },

            minRotation: 90,
            maxRotation: 90,

            autoSkip: false
          },

          grid: {
            display: false,
            drawBorder: false
          }
        },

        y: {
          beginAtZero: true,

          grid: {
            color: c.grid,
            drawBorder: false
          },

          ticks: {
            color: c.tick,

            font: {
              family: "'DM Sans', sans-serif",
              size: 11
            },

            callback: v =>
              '₱' + (v >= 1000 ?
                (v / 1000).toFixed(0) + 'k' :
                v)
          }
        }
      }
    };
  }

  const chartInstances = {};

  /* ── Line Chart ── */
  function buildLineChart(canvasId, labels, data) {

    const el = document.getElementById(canvasId);

    if (!el) return;

    const c = chartColors();

    chartInstances[canvasId] = new Chart(el.getContext('2d'), {

      type: 'line',

      data: {
        labels,

        datasets: [{
          label: 'Revenue',
          data,

          borderColor: c.line,
          backgroundColor: c.fill,

          borderWidth: 2,
          tension: 0.4,
          fill: true,

          pointRadius: 3,
          pointBackgroundColor: c.point,
          pointBorderColor: c.point,

          pointHoverRadius: 5,
          pointHoverBackgroundColor: c.pointHover,
          pointHoverBorderColor: c.point,
          pointHoverBorderWidth: 2
        }]
      },

      options: sharedOpts(c)
    });
  }

  /* ── Bar Chart ── */
  function buildBarChart(canvasId, labels, data) {

    const el = document.getElementById(canvasId);

    if (!el) return;

    const c = chartColors();

    chartInstances[canvasId] = new Chart(el.getContext('2d'), {

      type: 'bar',

      data: {
        labels,

        datasets: [{
          label: 'Revenue',
          data,

          backgroundColor: c.bar,
          hoverBackgroundColor: c.barHover,

          borderRadius: 6,
          borderSkipped: false
        }]
      },

      options: {
        ...sharedOpts(c),

        scales: {
          ...sharedOpts(c).scales,

          x: {
            ...sharedOpts(c).scales.x,

           

            grid: {
              display: false,
              drawBorder: false
            }
          }
        }
      }
    });
  }

  /* ── Build Charts ── */
  buildLineChart(
    'revenueWeekChart',
    weekLabels,
    weekData
  );

  buildBarChart(
    'revenueMonthChart',
    monthLabels,
    monthData
  );

  buildLineChart(
    'revenueYearChart',
    yearLabels,
    yearData
  );

  /* ── Rebuild charts when theme changes ── */
  document.getElementById('themeToggle')?.addEventListener('click', () => {

    setTimeout(() => {

      Object.values(chartInstances).forEach(ch => ch.destroy());

      buildLineChart(
        'revenueWeekChart',
        weekLabels,
        weekData
      );

      buildBarChart(
        'revenueMonthChart',
        monthLabels,
        monthData
      );

      buildLineChart(
        'revenueYearChart',
        yearLabels,
        yearData
      );

    }, 50);

  });
</script>
<?= $this->endSection() ?>