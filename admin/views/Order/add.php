<?php
    session_start();
    require_once '../../models/UserModel.php';
    require_once '../../models/OrderModel.php';
    require_once '../../models/CartModel.php';
    require_once '../../function.php';

    $userModel = new UserModel();

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit;
    }

    if (!$userModel->isAdmin($_SESSION['user_id'])) {
        session_destroy();
        header("Location: ../login.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['userId']) && isset($_POST['totalPrice']) && isset($_POST['status'])) {
            $orderModel = new OrderModel();
            $userId = $_POST['userId'];
            $totalPrice = $_POST['totalPrice'];
            $status = $_POST['status'];
            $orderModel->createOrder($userId, $totalPrice, $status);
            header("Location: list.php");
            exit;
        }
    }

    $orderModel = new OrderModel();
    $cartModel = new CartModel();
    $carts = $cartModel->getAllUserCart();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">

<!-- Sidebar -->
<?php include '../sidebar.php'; ?>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <?php include '../topbar.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <h1 class="h3 mb-2 text-gray-800">THÊM ĐƠN HÀNG</h1>

        <form action="" class="w-50" method="post">
            <input type="number" name="totalPrice" class="form-control form-control-user mb-3" placeholder="Enter Total Price">
            <select name="userId" class="form-select form-control mb-3">
                <?php
                    foreach ($carts as $cart) {
                        echo "<option value='{$cart['user_id']}'>{$cart['username']}</option>";
                    }
                ?>
            </select>
            <select name="status" class="form-select form-control mb-3">
                <option value="chờ xử lý">Chờ xử lý</option>
                <option value="hoàn tất">Hoàn tất</option>
                <option value="đã hủy">Đã hủy</option>
            </select>
            <button type="submit" class="form-control btn btn-success">Add</button>
        </form>
        </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
   
    <!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->
    <?php include '../footer.php'; ?>
</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
<i class="fas fa-angle-up"></i>
</a>
            <!-- Bootstrap core JavaScript-->
            <script src="../../vendor/jquery/jquery.min.js"></script>
            <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="../../js/sb-admin-2.min.js"></script>

</body>

</html>
