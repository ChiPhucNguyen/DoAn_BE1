<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirectWithMessage($_SERVER['HTTP_REFERER'], 'registerError', 'Phương thức không được hỗ trợ');
    }
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['repeatPassword'])) {
        require_once 'function.php';
        $username = $_POST['username'];
        $password = $_POST['password'];
        $repeatPassword = $_POST['repeatPassword'];
        $referer = $_SERVER['HTTP_REFERER'] ?? null;
        if($password != $repeatPassword) {
           redirectWithMessage($referer, 'registerError', 'Mật khẩu không khớp');
        }
        if(checkUsernameAvailability($username)) {
            redirectWithMessage($referer, 'registerError', 'Tên đăng nhập đã tồn tại');
        }

        //$password = password_hash($password, PASSWORD_BCRYPT);

        if(registerUsers($username, $password)) {
            redirectWithMessage($referer, 'registerSuccess', 'Đăng ký thành công');
        } else {
            redirectWithMessage($referer, 'registerError', 'Đăng ký thất bại');
        }
    }
?>
