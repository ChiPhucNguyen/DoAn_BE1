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
        $orderId = (int)$_GET['id'];

        $orderModel = new OrderModel();

        $deleted = $orderModel->deleteOrder($orderId);
        header("Location: list.php");


    } else {
        echo "Không có ID đơn hàng.";
    }
?>
