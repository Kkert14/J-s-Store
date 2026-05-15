<?php $role = session()->get('role'); ?>
<aside class="main-sidebar elevation-0" id="mainSidebar">
  <a href="<?= base_url('dashboard') ?>" class="brand-link" id="brandLink" style="cursor:pointer;">
    <img src="<?= base_url('assets/adminlte/dist/img/i.png') ?>"
         alt="Ian's Store Logo"
         class="brand-image img-circle"
         style="opacity:.9; margin-left:8px;">
    <span class="brand-text">Ian's Store</span>
  </a>

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
          <a href="<?= base_url('dashboard') ?>" class="nav-link <?= is_active(1, 'dashboard') ?>">
            <i class="nav-icon fas fa-th-large"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <?php if (in_array($role, ['Admin', 'Doctor'])): ?>
          <li class="nav-item">
            <a href="<?= base_url('users') ?>" class="nav-link <?= is_active(1, 'users') ?>">
              <i class="nav-icon fas fa-user-shield"></i>
              <p>Users</p>
            </a>
          </li>
        <?php endif; ?>

        <?php if ($role === 'Admin'): ?>
          <li class="nav-item">
            <a href="<?= base_url('log') ?>" class="nav-link <?= is_active(1, 'log') ?>">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>Activity Logs</p>
            </a>
          </li>
        <?php endif; ?>

        <?php if (in_array($role, ['Admin', 'Cashier'])): ?>
          <?php $posSegments = ['pos', 'sales', 'product', 'category']; ?>
          <li class="nav-item has-treeview <?= is_menu_open(1, $posSegments) ?>">
            <a href="#" class="nav-link <?= in_array(service('uri')->getSegment(1), $posSegments) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-cash-register"></i>
              <p>
                POS
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('pos') ?>" class="nav-link <?= is_active(1, 'pos') ?>">
                  <i class="nav-icon fas fa-shopping-cart"></i>
                  <p>Checkout</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('sales') ?>" class="nav-link <?= is_active(1, 'sales') ?>">
                  <i class="nav-icon fas fa-receipt"></i>
                  <p>Sales</p>
                </a>
              </li>
              <?php if ($role === 'Admin'): ?>
                <li class="nav-item">
                  <a href="<?= base_url('product') ?>" class="nav-link <?= is_active(1, 'product') ?>">
                    <i class="nav-icon fas fa-box"></i>
                    <p>Products</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('category') ?>" class="nav-link <?= is_active(1, 'category') ?>">
                    <i class="nav-icon fas fa-tags"></i>
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

  <!-- User pill at the bottom -->
  <div class="sidebar-user-footer">
    <div class="user-pill">
      <div class="user-avatar"><?= strtoupper(substr(session()->get('name') ?? 'U', 0, 1)) ?></div>
      <div class="user-info">
        <div class="user-name"><?= esc(session()->get('name')) ?></div>
        <div class="user-role"><?= esc($role) ?></div>
      </div>
    </div>
  </div>
</aside>

<style>
/* ═══════════════════════════════════════════════
   SIDEBAR  —  Purple Deep Theme
   ═══════════════════════════════════════════════ */

#mainSidebar {
  background: linear-gradient(180deg, #5b21b6 0%, #3b0764 100%) !important;
  border-right: none !important;
  font-family: 'Outfit', 'Source Sans Pro', sans-serif !important;
  overflow: hidden;
}

/* subtle orb decorations */
#mainSidebar::before {
  content: '';
  position: absolute;
  width: 300px; height: 300px;
  border-radius: 50%;
  background: rgba(167, 139, 250, 0.07);
  top: -80px; right: -80px;
  pointer-events: none;
  z-index: 0;
}
#mainSidebar::after {
  content: '';
  position: absolute;
  width: 220px; height: 220px;
  border-radius: 50%;
  background: rgba(167, 139, 250, 0.05);
  bottom: -60px; left: -60px;
  pointer-events: none;
  z-index: 0;
}

/* brand link */
#brandLink {
  background: rgba(0, 0, 0, 0.25) !important;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
  padding: 14px 16px !important;
  position: relative; z-index: 1;
}
#brandLink .brand-text {
  color: #fff !important;
  font-weight: 900 !important;
  font-size: 15px !important;
  letter-spacing: -0.3px;
  font-family: 'Outfit', sans-serif !important;
}
#brandLink .brand-image {
  box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important;
  border-radius: 10px !important;
}

/* sidebar container */
.main-sidebar .sidebar {
  position: relative;
  z-index: 1;
}

/* nav items wrapper */
.nav-sidebar {
  padding: 8px !important;
}

/* every nav link */
.nav-sidebar .nav-link {
  color: rgba(221, 214, 254, 0.72) !important;
  font-weight: 600;
  font-size: 13.5px;
  border-radius: 10px !important;
  padding: 9px 12px !important;
  margin-bottom: 2px;
  position: relative;
  transition: background 0.18s, color 0.18s !important;
  font-family: 'Outfit', sans-serif;
}

.nav-sidebar .nav-link p {
  color: inherit !important;
  font-weight: inherit;
}

/* hover */
.nav-sidebar .nav-link:hover {
  background: rgba(255, 255, 255, 0.1) !important;
  color: #fff !important;
  box-shadow: none !important;
}

/* active */
.nav-sidebar .nav-link.active {
  background: rgba(167, 139, 250, 0.18) !important;
  color: #fff !important;
  font-weight: 700;
  box-shadow: none !important;
}

/* purple left accent bar */
.nav-sidebar .nav-link::before {
  content: '';
  position: absolute;
  left: 0; top: 18%; height: 64%;
  width: 3px;
  background: #a78bfa;
  border-radius: 0 3px 3px 0;
  transform: scaleY(0);
  transform-origin: center;
  transition: transform 0.2s ease;
}
.nav-sidebar .nav-link.active::before,
.nav-sidebar .nav-link:hover::before {
  transform: scaleY(1);
}

/* icons */
.nav-sidebar .nav-link .nav-icon {
  color: rgba(196, 167, 250, 0.55) !important;
  font-size: 15px !important;
  width: 20px;
  transition: color 0.18s;
}
.nav-sidebar .nav-link:hover .nav-icon,
.nav-sidebar .nav-link.active .nav-icon {
  color: #c4b5fd !important;
}

/* treeview arrow */
.nav-sidebar .nav-link .right {
  color: rgba(196, 167, 250, 0.5) !important;
  transition: transform 0.2s;
}

/* sub-nav items */
.nav-treeview {
  padding-left: 10px !important;
}
.nav-treeview .nav-link {
  font-size: 13px !important;
  padding: 7px 10px !important;
  color: rgba(196, 167, 250, 0.6) !important;
}
.nav-treeview .nav-link:hover,
.nav-treeview .nav-link.active {
  color: #fff !important;
  background: rgba(255, 255, 255, 0.08) !important;
}
.nav-treeview .nav-link .nav-icon {
  font-size: 13px !important;
}

/* dark mode — keep gradient, slightly deeper */
body.dark-mode #mainSidebar {
  background: linear-gradient(180deg, #1e0a35 0%, #0e0a1f 100%) !important;
  border-right: 1px solid rgba(196, 132, 252, 0.1) !important;
}
body.dark-mode .nav-sidebar .nav-link {
  color: rgba(196, 132, 252, 0.65) !important;
}
body.dark-mode .nav-sidebar .nav-link:hover,
body.dark-mode .nav-sidebar .nav-link.active {
  background: rgba(124, 58, 237, 0.22) !important;
  color: #e9d5ff !important;
}
body.dark-mode .nav-sidebar .nav-link .nav-icon {
  color: rgba(167, 139, 250, 0.5) !important;
}
body.dark-mode .nav-sidebar .nav-link:hover .nav-icon,
body.dark-mode .nav-sidebar .nav-link.active .nav-icon {
  color: #c4b5fd !important;
}

/* ── user footer pill ── */
.sidebar-user-footer {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  padding: 10px;
  border-top: 1px solid rgba(255, 255, 255, 0.07);
  background: rgba(0, 0, 0, 0.15);
  z-index: 2;
}

.user-pill {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 8px 10px;
  border-radius: 10px;
  background: rgba(255, 255, 255, 0.07);
  cursor: default;
  transition: background 0.18s;
}
.user-pill:hover { background: rgba(255, 255, 255, 0.12); }

.user-avatar {
  width: 32px; height: 32px;
  border-radius: 9px;
  background: linear-gradient(135deg, #a78bfa, #7c3aed);
  display: flex; align-items: center; justify-content: center;
  font-size: 13px; font-weight: 900; color: #fff;
  flex-shrink: 0;
  box-shadow: 0 3px 10px rgba(124,58,237,0.35);
}

.user-name {
  font-size: 12.5px;
  font-weight: 700;
  color: #fff;
  line-height: 1.2;
  font-family: 'Outfit', sans-serif;
}
.user-role {
  font-size: 10.5px;
  color: rgba(196, 167, 250, 0.6);
  font-family: 'Outfit', sans-serif;
}

/* push content up so it doesn't hide behind user pill */
.main-sidebar .sidebar {
  padding-bottom: 70px;
}
</style>