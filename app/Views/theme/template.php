    <!DOCTYPE html>
    <html lang="en" style="font-size: 14px;">

    <head>
      <meta name="csrf-name" content="<?= csrf_token() ?>">
      <meta name="csrf-token" content="<?= csrf_hash() ?>">
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Ian's Store</title>
      <link rel="icon" href="<?= base_url('favicon.ico') ?>">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
      <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
      <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
      <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/jqvmap/jqvmap.min.css') ?>">
      <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">
      <!-- Custom CSS -->
      <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">
      <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') ?>">
      <!-- Custom CSS -->
      <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
      <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/daterangepicker/daterangepicker.css') ?>">
      <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/summernote/summernote-bs4.min.css') ?>">
      <!-- DataTables -->
      <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
      <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
      <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">
      <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/toastr/toastr.min.css') ?>">

    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
        <!--   <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="<?= base_url('assets/adminlte/dist/img/AdminLTELogo.png') ?>" alt="AdminLTELogo" height="60" width="60">
      </div> -->

        <?= $this->include('theme/navbar') ?>

        <?= $this->include('theme/sidebar') ?>

        <?= $this->renderSection('content') ?>

        <footer class="main-footer no-print">
          <strong>Copyright &copy; 2025 <a href="#">K Villahermosa</a> </strong>
          All rights reserved.
          <!-- <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> CI4.v1
          </div> -->
        </footer>
        <aside class="control-sidebar control-sidebar-dark">
          <!-- Add padding so content isn’t stuck to edges -->
          <div class="p-3">
            <h5>Settings</h5>
            <hr>
            <div class="form-group">
              <label>Option 1</label>
              <input type="checkbox" class="form-control">
            </div>
            <div class="form-group">
              <label>Option 2</label>
              <input type="checkbox" class="form-control">
            </div>
          </div>
        </aside>

      </div>
      <script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
      <script>
        $.widget.bridge('uibutton', $.ui.button)
      </script>
      <script src="<?= base_url('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/chart.js/Chart.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/sparklines/sparkline.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/jqvmap/jquery.vmap.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/jquery-knob/jquery.knob.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/moment/moment.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/daterangepicker/daterangepicker.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/summernote/summernote-bs4.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/dist/js/adminlte.js') ?>"></script>

      <script src="<?= base_url('assets/adminlte/dist/js/pages/dashboard.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/jszip/jszip.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/pdfmake/pdfmake.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/pdfmake/vfs_fonts.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>
      <script src="<?= base_url('assets/adminlte/plugins/toastr/toastr.min.js') ?>"></script>
      <?= $this->renderSection('scripts') ?>
    </body>

    </html>
  <!-- Drop this <script> block at the bottom of template.php,
     replacing your existing theme toggle script entirely -->
<script>
  const themeToggle = document.getElementById('themeToggle');
  const navbar      = document.getElementById('mainNavbar');
  const sidebar     = document.getElementById('mainSidebar');

  function applyTheme(dark) {
    if (dark) {
      document.body.classList.add('dark-mode');
      // Navbar: keep dark variant
      navbar.classList.remove('navbar-light');
      navbar.classList.add('navbar-dark');
      // Sidebar: dark-primary keeps AdminLTE from overriding our gradient
      sidebar.classList.remove('sidebar-light-primary', 'sidebar-light-light', 'sidebar-light');
      sidebar.classList.add('sidebar-dark-primary');
      if (themeToggle) themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
    } else {
      document.body.classList.remove('dark-mode');
      navbar.classList.remove('navbar-light');
      navbar.classList.add('navbar-dark');
      sidebar.classList.remove('sidebar-dark-primary');
      sidebar.classList.add('sidebar-light-primary');
      if (themeToggle) themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
    }
  }

  // Apply on load
  applyTheme(localStorage.getItem('adminlteTheme') === 'dark');

  // Toggle on click
  if (themeToggle) {
    themeToggle.addEventListener('click', function(e) {
      e.preventDefault();
      const isDark = !document.body.classList.contains('dark-mode');
      localStorage.setItem('adminlteTheme', isDark ? 'dark' : 'light');
      applyTheme(isDark);
    });
  }
</script>