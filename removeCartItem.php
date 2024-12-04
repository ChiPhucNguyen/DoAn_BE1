<?php
    require_once './models/CartModel.php';
    require_once './models/UserModel.php';
    $cartModel = new CartModel();
    $userModel = new UserModel();
    session_start();
    if($_SERVER['REQUEST_METHOD'] !== 'GET') {
        header("Location: index.php");
        exit;
    }
    if(isset($_GET['productId'])) {
        $product_id = $_GET['productId'];
        $referer = $_SERVER['HTTP_REFERER'] ?? "cart.php";
        if(!isset($_SESSION['user_id'])) {
            $userModel->redirectWithMessage($referer, 'loginError', 'Vui lòng đăng nhập để xoá sản phẩm khỏi giỏ hàng');
        }
        $userid = $_SESSION['user_id'];
        $cartModel->removeItemFromCart($userid ,$product_id);
        header("Location: $referer");
        exit;
    }
?>