<?php $role = session()->get('role'); ?>
<nav class="main-header navbar navbar-expand navbar-dark" id="mainNavbar">

  <ul class="navbar-nav">
    <!-- Hamburger -->
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>

    <!-- Breadcrumb -->
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= base_url('dashboard') ?>" class="nav-link">
        Ian's Store &rsaquo; <strong><?= ucfirst(service('uri')->getSegment(1) ?: 'Dashboard') ?></strong>
      </a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">

    <!-- Dark / Light toggle -->
    <li class="nav-item">
      <a class="nav-link" href="#" id="themeToggle" title="Toggle theme">
        <i class="fas fa-sun"></i>
      </a>
    </li>

    <!-- User info -->
    <li class="nav-item">
      <a class="nav-link" href="#" style="pointer-events:none;">
        <i class="far fa-user-circle" style="margin-right:5px;"></i>
         <strong><?= esc(session()->get('name')) ?></strong>
      </a>
    </li>

    <!-- Logout -->
    <li class="nav-item">
      <a class="nav-link" href="<?= base_url('/logout') ?>">
        <i class="fas fa-sign-out-alt" style="margin-right:4px;"></i> Logout
      </a>
    </li>

  </ul>
</nav>