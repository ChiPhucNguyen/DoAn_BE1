<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] !== 'GET') {
        header("Location: index.php");
        exit;
    }
    if(isset($_GET['productId']) && isset($_GET['quantity'])) {
        require_once 'function.php';
        $product_id = $_GET['productId'];
        $quantity = $_GET['quantity'];
        $referer = $_SERVER['HTTP_REFERER'] ?? "index.php";
        if(!isset($_SESSION['user_id'])) {
            redirectWithMessage($referer, 'loginError', 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng');
        }
        $userid = $_SESSION['user_id'];
        addItemToCart($userid ,$product_id, $quantity);
        header("Location: $referer");
        exit;
        
    }
?>