<?php
    session_start();
    require_once '../../models/UserModel.php';
    require_once '../../models/CategoryModel.php';
    require_once '../../models/ProductModel.php';
    
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
        $productModel = new ProductModel();
        $product_id = $_GET['id'];
        $productModel->deleteProduct($product_id);       
        header("Location: list.php");
        exit;
    }
?>