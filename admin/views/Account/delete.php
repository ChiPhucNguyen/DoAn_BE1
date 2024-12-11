<?php
    session_start();
    require_once '../../models/UserModel.php';
    
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
        $user_id = $_GET['id'];
        $userModel->deleteUser($user_id);
        header("Location: list.php");
        exit;
    }
?>