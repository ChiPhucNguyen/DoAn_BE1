<?php
    session_start();
    require_once '../../models/UserModel.php';
    require_once '../../models/CartModel.php';
    
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
        $cart_id = $_GET['id'];
        $cartModel = new CartModel();
        $cartModel->deleteItemInCart($cart_id);
        header("Location: list.php");
        exit;
    }
?>