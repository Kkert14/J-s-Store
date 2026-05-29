<?php $role = session()->get('role'); ?>
<aside class="main-sidebar elevation-0" id="mainSidebar">

  <!-- Brand -->
  <a href="<?= base_url('dashboard') ?>" class="brand-link" id="brandLink">
    <div class="brand-logo-wrap">
      <img src="<?= base_url('assets/adminlte/dist/img/J_icon.png') ?>"
           alt="J's Store Logo"
           class="brand-image">
    </div>
    <div class="brand-text-wrap">
      <span class="brand-name">J's Store</span>
      <span class="brand-tagline">Management Suite</span>
    </div>
  </a>

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview" role="menu" data-accordion="false">

        <!-- Dashboard -->
        <li class="nav-item">
          <a href="<?= base_url('dashboard') ?>"
             class="nav-link <?= is_active(1, 'dashboard') ?>">
            <span class="nav-icon-wrap"><i class="nav-icon fas fa-th-large"></i></span>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Section: People -->
        <?php if (in_array($role, ['Admin', 'Doctor'])): ?>
          <li class="nav-section-label">People</li>
          <li class="nav-item">
            <a href="<?= base_url('users') ?>"
               class="nav-link <?= is_active(1, 'users') ?>">
              <span class="nav-icon-wrap"><i class="nav-icon fas fa-user-shield"></i></span>
              <p>Users</p>
            </a>
          </li>
        <?php endif; ?>

        <!-- Section: System (Admin only) -->
        <?php if ($role === 'Admin'): ?>
          <li class="nav-section-label">System</li>
          <li class="nav-item">
            <a href="<?= base_url('log') ?>"
               class="nav-link <?= is_active(1, 'log') ?>">
              <span class="nav-icon-wrap"><i class="nav-icon fas fa-list-alt"></i></span>
              <p>Activity Logs</p>
            </a>
          </li>
        <?php endif; ?>

        <!-- Section: POS -->
        <?php if (in_array($role, ['Admin', 'Cashier'])): ?>
          <?php $posSegments = ['pos', 'sales', 'product', 'stock', 'category']; ?>
          <li class="nav-section-label">Point of Sale</li>
          <li class="nav-item has-treeview <?= is_menu_open(1, $posSegments) ?>">
            <a href="#"
               class="nav-link <?= in_array(service('uri')->getSegment(1), $posSegments) ? 'active' : '' ?>">
              <span class="nav-icon-wrap"><i class="nav-icon fas fa-cash-register"></i></span>
              <p>POS <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('pos') ?>"
                   class="nav-link <?= is_active(1, 'pos') ?>">
                  <span class="nav-icon-wrap"><i class="nav-icon fas fa-shopping-cart"></i></span>
                  <p>Checkout</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('sales') ?>"
                   class="nav-link <?= is_active(1, 'sales') ?>">
                  <span class="nav-icon-wrap"><i class="nav-icon fas fa-receipt"></i></span>
                  <p>Sales</p>
                </a>
              </li>
              <?php if ($role === 'Admin'): ?>
                <li class="nav-item">
                  <a href="<?= base_url('product') ?>"
                     class="nav-link <?= is_active(1, 'product') ?>">
                    <span class="nav-icon-wrap"><i class="nav-icon fas fa-box"></i></span>
                    <p>Products</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('stock') ?>"
                     class="nav-link <?= is_active(1, 'stock') ?>">
                    <span class="nav-icon-wrap"><i class="nav-icon fas fa-warehouse"></i></span>
                    <p>Stock</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('category') ?>"
                     class="nav-link <?= is_active(1, 'category') ?>">
                    <span class="nav-icon-wrap"><i class="nav-icon fas fa-tags"></i></span>
                    <p>Categories</p>
                  </a>
                </li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>

      </ul>
    </nav>
  </div>

  <!-- User footer -->
  <div class="sidebar-user-footer">
    <div class="user-pill">
      <div class="user-avatar">
        <?= strtoupper(substr(session()->get('name') ?? 'U', 0, 1)) ?>
      </div>
      <div class="user-info">
        <div class="user-name"><?= esc(session()->get('name')) ?></div>
        <div class="user-role"><?= esc($role) ?></div>
      </div>
      <div class="user-status-dot"></div>
    </div>
  </div>

</aside>
