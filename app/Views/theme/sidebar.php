<?php $role = session()->get('role'); ?>
<aside class="main-sidebar sidebar-light-light sidebar-light elevation-5" id="mainSidebar">
  <div class="brand-link bg-warning" id="brandLink" style="cursor: default; border-bottom: 1px rgba(255, 255, 255);">
    <img src="<?= base_url('assets/adminlte/dist/img/KCC_Logo.png') ?>"
      alt="AdminLTE Logo"
      class="brand-image img-circle elevation-3"
      style="opacity: .8">
    <span class="brand-text font-weight-light" style="color: white; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"><strong>KCC Clinic</strong></span>
  </div>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
      <li class="nav-item">
          <a href="<?= base_url('dashboard') ?>" class="nav-link <?= is_active(1, 'dashboard') ?>">
            <i class="nav-icon fas fa-clinic-medical"></i>
            <p><strong>Dashboard</strong></p>
          </a>
        </li>


          <?php if (in_array($role, ['Admin', 'Doctor'])): ?>
          <!-- <li class="nav-item has-treeview <?= is_active(1, 'users') ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-shield"></i>
              <p>
                Staff
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview"> -->

          <li class="nav-item">
            <a href="<?= base_url('users') ?>" class="nav-link <?= is_active(1, 'users') ?>">
              <i class="nav-icon fas fa-user-shield"></i>
              <p><strong>Staff</strong></p>
            </a>
          </li>
        <?php endif; ?>

         <?php if ($role === 'Admin'): ?>
          <li class="nav-item">
            <a href="<?= base_url('log') ?>" class="nav-link <?= is_active(1, 'log') ?>">
              <i class="nav-icon fas fa-list-alt"></i>
              <p><strong>Activity Logs</strong></p>
            </a>
          </li>
        <?php endif; ?>


        <li class="nav-item has-treeview <?= is_active(1, 'patient') ?>">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book-medical"></i>
            <p>
              <strong>List</strong>
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <!--circle icon, far fa-circle nav-icon -->

          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="<?= base_url('patient') ?>" class="nav-link <?= is_active(1, 'patient') ?>">
                <i class="nav-icon fas fa-notes-medical"></i>
                <p><strong>Patients</strong></p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('guardian') ?>" class="nav-link <?= is_active(1, 'guardian') ?>">
                <i class="nav-icon fas fa-id-badge"></i>
                <p><strong>Parents / Guardians</strong></p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('appointment') ?>" class="nav-link <?= is_active(1, 'appointment') ?>">
                <i class="nav-icon fa fa-calendar-alt"></i>
                <p><strong>Appointments</strong></p>
              </a>
            </li>

            <li class="nav-item">
            <a href="<?= base_url('medical_record') ?>" class="nav-link <?= is_active(1, 'medical_record') ?>">
              <i class="nav-icon fas fa-file-medical-alt"></i>
              <p><strong>Medical Records</strong></p>
            </a>
          </li>

          </ul>
        </li>


        <?php if (in_array($role, ['Admin', 'Doctor'])): ?>
          <li class="nav-item has-treeview <?= is_active(1, 'medicine') || is_active(1, 'equipment') ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-boxes"></i>
              <p>
                <strong>Inventory</strong>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="<?= base_url('medicine') ?>" class="nav-link <?= is_active(1, 'medicine') ?>">
                  <i class="nav-icon fas fa-pills"></i>
                  <p><strong>Medicine</strong></p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?= base_url('equipment') ?>" class="nav-link <?= is_active(1, 'equipment') ?>">
                  <i class="nav-icon fas fa-stethoscope"></i>
                  <p><strong>Equipment</strong></p>
                </a>
              </li>

            </ul>
          </li>
        <?php endif; ?>

       

      

        <!-- <li class="nav-item">
            <a href="<?= base_url('medical_record') ?>" class="nav-link <?= is_active(1, 'medical_record') ?>">
              <i class="nav-icon fas fa-file-medical-alt"></i>
              <p><strong>Medical Records</strong></p>
            </a>
          </li> -->
        <!-- </ul>

          </li> -->

      </ul>
    </nav>
  </div>
</aside>

<style type="text/css">
  .nav-sidebar .nav-link {
    position: relative;
    transition: background 0.2s ease;
  }

  /* .main-sidebar {
    background: #f0f6ff;
  } */

  /* Orange left bar */
  .nav-sidebar .nav-link::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    background: #2c7be5;
    border-radius: 0 3px 3px 0;

    transform: scaleY(0);
    transform-origin: top;
    transition: transform 0.25s ease;
  }

  /* Show orange bar on hover & active */
  .nav-sidebar .nav-link.active::before,
  .nav-sidebar .nav-link:hover::before {
    transform: scaleY(1);
  }

  /* SUPER LIGHT GRADIENT */
  .nav-sidebar .nav-link:hover,
  .nav-sidebar .nav-link.active {
    background: linear-gradient(to right,
        rgba(255, 165, 0, 0.05),
        /* extremely light orange */
        rgba(255, 165, 0, 0.01)
        /* almost invisible */
      ) !important;
    box-shadow: none !important;
  }

  /* Submenu items same gradient */
  .nav-treeview .nav-link:hover,
  .nav-treeview .nav-link.active {
    background: linear-gradient(to right,
        rgba(255, 165, 0, 0.05),
        rgba(255, 165, 0, 0.01)) !important;
    box-shadow: none !important;
  }

  /* Sidebar links text and icons in dark mode */
  body.dark-mode .main-sidebar .nav-link {
    color: #fff !important;
  }

  body.dark-mode .main-sidebar .nav-link p {
    color: #fff !important;
  }

  body.dark-mode .main-sidebar .nav-icon {
    color: #fff !important;
  }

  /* General transition for all icons so they don't snap */
  .nav-sidebar .nav-link .nav-icon {
    transition: color 0.2s ease, transform 0.2s ease;
  }

  /* Change icon color to blue when the parent link is hovered or active */
  .nav-sidebar .nav-link:hover .nav-icon,
  .nav-sidebar .nav-link.active .nav-icon {
    color: #2c7be5 !important;
  }

  /* Specifically for the circle icons in submenus to make them solid or bright */
  .nav-treeview .nav-link:hover .far.fa-circle,
  .nav-treeview .nav-link.active .far.fa-circle {
    font-weight: 900;
    /* Makes it look slightly bolder when active */
  }

  /* Active or hovered link */
  body.dark-mode .main-sidebar .nav-link.active,
  body.dark-mode .main-sidebar .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
    /* slightly lighter bg on hover/active */
  }
</style>