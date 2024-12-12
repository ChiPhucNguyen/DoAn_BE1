 <?php
    if(!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    require_once $_SERVER['DOCUMENT_ROOT'] . '/store/admin/models/UserModel.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/store/admin/config/config.php';
    $userModel = new UserModel();
    $user_id = $_SESSION['user_id'];
    if(!$userModel->isAdmin($user_id)) {
        header("Location: ../index.php");
        exit;
    }
 ?>
 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo BASE_URL; ?>">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="<?php echo BASE_URL; ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    QUẢN LÝ CỬA HÀNG
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>QUẢN LÍ</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo BASE_URL; ?>Product/list.php">Sản phẩm</a>
            <a class="collapse-item" href="<?php echo BASE_URL; ?>Cart/list.php">Giỏ hàng</a>
            <a class="collapse-item" href="<?php echo BASE_URL; ?>Account/list.php">Tài khoản</a>
            <a class="collapse-item" href="<?php echo BASE_URL; ?>Category/list.php">Category</a>
        </div>
    </div>
</li>



<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->