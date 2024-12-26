<?php
session_start();
require_once '../../models/UserModel.php';
require_once '../../models/OrderModel.php';

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

if (isset($_GET['id'])) {
    $orderId = $_GET['id'];
    $orderModel = new OrderModel();
    $order = $orderModel->getOrderById($orderId);
    if (count($order) == 0) {
        header("Location: list.php");
        exit;
    } else {
        $order = $order[0];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['orderId']) && isset($_POST['userId']) && isset($_POST['totalPrice']) && isset($_POST['status'])) {
        $orderId = $_POST['orderId'];
        $userId = $_POST['userId'];
        $totalPrice = $_POST['totalPrice'];
        $status = $_POST['status'];
        $orderModel = new OrderModel();
        $orderModel->updateOrder($orderId, $userId, $totalPrice, $status);
        header("Location: list.php");
        exit;
    }
}

$userModel = new UserModel();
$users = $userModel->getAllUsersForOrder(); // Lấy tất cả người dùng
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit Order</title>

    <!-- Custom fonts for this template -->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

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

            <h1 class="h3 mb-2 text-gray-800">Edit Order</h1>

            <form action="edit.php" method="POST" class="w-50">
                <input type="text" name="orderId" class="form-control form-control-user mb-3" value="<?php echo $order['order_id']; ?>" readonly>
                
                <select name="userId" class="form-select form-control mb-3">
                    <?php
                    foreach ($users as $user) {
                        $selected = ($user['user_id'] == $order['user_id']) ? 'selected' : '';
                        echo "<option value='{$user['user_id']}' $selected>{$user['user_id']} - {$user['username']}</option>";
                    }
                    ?>
                </select>

                <input type="number" name="totalPrice" class="form-control form-control-user mb-3" placeholder="Enter Total Price" value="<?php echo $order['total_price']; ?>">

                <select name="status" class="form-select form-control mb-3">
                    <option value="chờ xử lý" <?php echo ($order['status'] == 'chờ xử lý') ? 'selected' : ''; ?>>Chờ xử lý</option>
                    <option value="hoàn tất" <?php echo ($order['status'] == 'hoàn tất') ? 'selected' : ''; ?>>Hoàn tất</option>
                    <option value="đã hủy" <?php echo ($order['status'] == 'đã hủy') ? 'selected' : ''; ?>>Đã hủy</option>
                </select>

                <button type="submit" class="form-control btn btn-success">Update</button>
            </form>

        </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

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
