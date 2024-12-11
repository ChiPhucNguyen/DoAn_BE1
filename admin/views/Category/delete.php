<?php
    session_start();
    require_once '../../models/UserModel.php';
    require_once '../../models/CategoryModel.php';
    
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
        $categoryModel = new CategoryModel();
        $category_id = $_GET['id'];
        $categoryModel->deleteCategory($category_id);       
        header("Location: list.php");
        exit;
    }
?>