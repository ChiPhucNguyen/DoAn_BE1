
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
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['userid'])  && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['role'])) {
        $user_id = $_POST['userid'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $role = $_POST['role'];
        $currentUser = $userModel->getUserById($user_id);
        $currentUser = $currentUser[0];
        if ($username !== $currentUser['username'] && $userModel->isUsernameTaken($username)) {
            echo "<script>alert('Username đã tồn tại trong hệ thống');</script>";
            header("Location: edit.php?id=$user_id");
            exit;
        }
        if ($email !== $currentUser['email'] && $userModel->isEmailTaken($email)) {
            echo "<script>alert('Email này đã tồn tại trong hệ thống');</script>";
            header("Location: edit.php?id=$user_id");
            exit;
        }
        $userModel->editUser($user_id, $username, $password, $email, $phone, $address, $role);
        header("Location: list.php");
        exit;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['id'])) {
        $user_id = $_GET['id'];
        $user = $userModel->getUserById($user_id);
        if(count($user) == 0)
        {
            header("Location: list.php");
            exit;
        }
        else
        {
            $user = $user[0];
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>


<body id="page-top">
        <!-- Page Wrapper -->
        <div id="wrapper">

<!-- Sidebar -->
<?php include '../sidebar.php'; ?>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <?php include '../topbar.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <h1 class="h3 mb-2 text-gray-800">EDIT ACCOUNT</h1>
        <?php
        if($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            echo <<<HTML
            <form action="edit.php" class="w-50" method="post">
                <input type="text" name="userid" class="form-control form-control-user mb-3" value="{$user['user_id']}" readonly>
                <input type="text" name="username" class="form-control form-control-user mb-3" value="{$user['username']}" placeholder="Enter Username">
                <input type="text" name="password" class="form-control form-control-user mb-3" value="{$user['password']}" placeholder="Enter Password.">
                <input type="text" name="email" class="form-control form-control-user mb-3" value="{$user['email']}" placeholder="Enter Email.">
                <input type="text" name="phone" class="form-control form-control-user mb-3" value="{$user['phone']}" placeholder="Enter Phone.">
                <input type="text" name="address" class="form-control form-control-user mb-3" value="{$user['address']}" placeholder="Enter Address.">
                <div class="form-group mb-3">
                    <label for="role">Role</label>
                    <select class="form-control" name="role" id="">
            HTML;
            echo '<option value="user" ' . (($user['role'] == 'user') ? 'selected' : '') . '>User</option>';
            echo '<option value="admin" ' . (($user['role'] == 'admin') ? 'selected' : '') . '>Admin</option>';
            echo <<<HTML
                    </select>
                </div>
                <button type="submit" class="form-control btn btn-success">Update</button>
            </form>
            HTML;
        }
        
                
        ?>
        </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
   
    <!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->
    <?php include '../footer.php'; ?>
</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
<i class="fas fa-angle-up"></i>
</a>
            <!-- Bootstrap core JavaScript-->
            <script src="../../vendor/jquery/jquery.min.js"></script>
            <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="../../js/sb-admin-2.min.js"></script>

</body>

</html>