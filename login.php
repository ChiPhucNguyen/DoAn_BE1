<?php
    session_start();
    require_once './models/UserModel.php';
    require_once './models/CartModel.php';
    $userModel = new UserModel();  
    $cartModel = new CartModel();

    if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $userModel->redirectWithMessage($_SERVER['HTTP_REFERER'], 'registerError', 'Phương thức không được hỗ trợ');
    }
    if(isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $referer = $_SERVER['HTTP_REFERER'] ?? "index.php";

        //$password = password_hash($password, PASSWORD_BCRYPT);

        if(!$userModel->checkUsernameAvailability($username)) {
            $userModel->redirectWithMessage($referer, 'loginError', 'Tên đăng nhập chưa tồn tại');
        }
        $user = $userModel->loginUsers($username, $password);
        $user = $user[0];
        if($user != null) {
            $_SESSION['user_id'] = $user['user_id']; // ID của người dùng từ cơ sở dữ liệu
            $_SESSION['username'] = $user['username']; // Tên đăng nhập
            if(!$cartModel->checkUserCart($user['user_id'])) {
                $cartModel-> createUserCart($user['user_id']);
            }
            header("Location: {$referer}");
        } else {
            $userModel->redirectWithMessage($referer, 'loginError', 'Đăng nhập thất bại. Sai tài khoản hoặc mật khẩu');
        }
    }
?>