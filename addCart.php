<?php
    session_start();
    require_once './models/UserModel.php';
    require_once './models/CartModel.php';
    $userModel = new UserModel();
    $cartModel = new CartModel();
    if($_SERVER['REQUEST_METHOD'] !== 'GET') {
        header("Location: index.php");
        exit;
    }
    if(isset($_GET['productId']) && isset($_GET['quantity'])) {
        $product_id = $_GET['productId'];
        $quantity = $_GET['quantity'];
        $referer = $_SERVER['HTTP_REFERER'] ?? "index.php";
        if($userModel->isUserLoggedIn() === false) {
            $userModel->redirectWithMessage($referer, 'loginError', 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng');
            return;
        }
        $userid = $_SESSION['user_id'];
        $cartModel->addItemToCart($userid ,$product_id, $quantity);
        header("Location: $referer");
        exit;
        
    }
?>