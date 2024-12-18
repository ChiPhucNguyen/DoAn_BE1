
<?php
    require_once  $_SERVER['DOCUMENT_ROOT'] . '/store/admin/models/UserModel.php';
    $userModel = new UserModel();
    if(isset($_SESSION['user_id'])) {
        $user = $userModel->getUserById($_SESSION['user_id']);
    }
?>
<!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<!-- Sidebar Toggle (Topbar) -->
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
</button>


<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">


    <!-- Nav Item - Alerts -->

    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="btn btn-primary mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $user['username'] ?></span>
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="userDropdown">
            <a class="dropdown-item" href="<?php echo BASE_URL; ?>logout.php">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
            </a>
        </div>
    </li>

</ul>

</nav>
<!-- End of Topbar -->