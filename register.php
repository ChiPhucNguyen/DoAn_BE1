    <?php
    session_start();
    require_once './models/UserModel.php';

    $userModel = new UserModel();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        handleError('Phương thức không được hỗ trợ');
    }

    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;
    $repeatPassword = $_POST['repeatPassword'] ?? null;

    if (!$username || !$password || !$repeatPassword) {
        handleError('Vui lòng điền đầy đủ thông tin');
    }

    if ($password !== $repeatPassword) {
        handleError('Mật khẩu không khớp');
    }

    if ($userModel->checkUsernameAvailability($username)) {
        handleError('Tên đăng nhập đã tồn tại');
    }

   // $password = password_hash($password, PASSWORD_BCRYPT);

    if ($userModel->registerUsers($username, $password)) {
        handleSuccess('Đăng ký thành công');
    } else {
        handleError('Đăng ký thất bại');
    }

    function handleError($message) {
        global $userModel;
        $referer = $_SERVER['HTTP_REFERER'] ?? null;
        $userModel->redirectWithMessage($referer, 'registerError', $message);
        exit();
    }

    function handleSuccess($message) {
        global $userModel;
        $referer = $_SERVER['HTTP_REFERER'] ?? null;
        $userModel->redirectWithMessage($referer, 'registerSuccess', $message);
        exit();
    }
?>