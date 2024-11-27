<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirectWithMessage($_SERVER['HTTP_REFERER'], 'registerError', 'Phương thức không được hỗ trợ');
    }
    if(isset($_POST['username']) && isset($_POST['password'])) {
        require_once 'function.php';
        $username = $_POST['username'];
        $password = $_POST['password'];
        $referer = $_SERVER['HTTP_REFERER'] ?? null;

        //$password = password_hash($password, PASSWORD_BCRYPT);

        if(!checkUsernameAvailability($username)) {
            redirectWithMessage($referer, 'loginError', 'Tên đăng nhập chưa tồn tại');
        }
        $user = loginUsers($username, $password);
        $user = $user[0];
        if($user != null) {
            $_SESSION['user_id'] = $user['user_id']; // ID của người dùng từ cơ sở dữ liệu
            $_SESSION['username'] = $user['username']; // Tên đăng nhập
            if(checkUserCart($user['user_id'])) {
               createUserCart($user['user_id']);
            }
            redirectWithMessage($referer, 'loginSuccess', 'Đăng nhập thành công' . $user['username']);
        } else {
            redirectWithMessage($referer, 'loginError', 'Đăng nhập thất bại');
        }
    }
?>