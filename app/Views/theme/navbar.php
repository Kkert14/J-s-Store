<?php $role = session()->get('role'); ?>
<nav class="main-header navbar navbar-expand navbar-dark" id="mainNavbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars" style="color: #fff;"></i>
            </a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= base_url('dashboard') ?>" class="nav-link" style="color: #fff; text-decoration: underline;">
                <!-- <i class="fas fa-clinic-medical"></i> -->
              <strong> Home </strong>
            </a>
        </li>
        

        
    </ul>

    <ul class="navbar-nav ml-auto">
        <!-- darkTheme toggle -->
        <li class="nav-item">
            <a class="nav-link" href="#" id="themeToggle" style="color: #fff;">
                <i class="fas fa-sun"></i>
            </a>
        </li>
<!-- email or name in session get-->
        <li class="nav-item">
            <a style="color: #fff;" class="nav-link" href="#">
               <strong> <?= ucfirst($role) ?> | <?= session()->get('name') ?></strong>
                <i class="far fa-user-circle" style="color: #fff; margin-left: 5px;"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/logout') ?>" style="color: #fff;">
               <strong> Logout </strong>
            <i class="fa fa-sign-out-alt fa-fw"></i>
            </a>
        </li>
    </ul>
</nav>