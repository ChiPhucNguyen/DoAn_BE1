
<?php
    session_start();
    require_once '../../models/UserModel.php';
    require_once '../../models/ProductModel.php';
    $userModel = new UserModel();
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit;
    }
    else
    {
        if (!$userModel->isAdmin($_SESSION['user_id'])) {
            session_destroy();
            header("Location: ../login.php");
            return;
        }
    }
    require_once '../../models/ConfigModel.php';

    $configModel = new ConfigModel();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Xử lý thay đổi logo
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '/store/img/';
            $logoName = basename($_FILES['logo']['name']);
            $logoPath = $_SERVER['DOCUMENT_ROOT'] . $uploadDir . $logoName;
    
            // Di chuyển file tải lên
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $logoPath)) {
                $logoUrl = $uploadDir . $logoName; // Lưu URL tương đối
                $configModel->updateConfig('logo', $logoUrl);
            }
        }
    
        // Xử lý thay đổi slider
        if (isset($_FILES['slider']) && $_FILES['slider']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '/store/img/slider/';
            $sliderName = basename($_FILES['slider']['name']);
            $sliderPath = $_SERVER['DOCUMENT_ROOT'] . $uploadDir . $sliderName;
    
            // Di chuyển file tải lên
            if (move_uploaded_file($_FILES['slider']['tmp_name'], $sliderPath)) {
                $sliderUrl = $uploadDir . $sliderName; // Lưu URL tương đối
                $configModel->updateConfig('slider_image', $sliderUrl);
            }
        }
    
        // Cập nhật giới hạn tải lên
        if (isset($_POST['upload_limit'])) {
            $uploadLimit = (int) $_POST['upload_limit'];
            $configModel->updateConfig('upload_limit', $uploadLimit);
        }
    }
    $currentConfig = $configModel->getAllConfig();
    
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

        <div class="container my-5">
        <h1 class="text-center mb-4">Website Configuration</h1>
        <form action="" method="post" enctype="multipart/form-data" class="border p-4 rounded shadow-sm">
            <div class="mb-4">
                <h3 class="mb-3">Change Logo</h3>
                <div class="mb-2">
                    <img src="<?php echo $currentConfig['logo'] ?? 'img/logo.png'; ?>" alt="Current Logo" class="img-thumbnail" style="width: 100px;">
                </div>
                <input type="file" name="logo" class="form-control">
            </div>
            
            <div class="mb-4">
                <h3 class="mb-3">Change Slider Image</h3>
                <div class="mb-2">
                    <img src="<?php echo $currentConfig['slider_image'] ?? 'img/hero/banner.jpg'; ?>" alt="Current Slider" class="img-thumbnail" style="width: 300px;">
                </div>
                <input type="file" name="slider" class="form-control">
            </div>

            <div class="mb-4">
                <h3 class="mb-3">Limit Upload File Size (MB)</h3>
                <input type="number" name="upload_limit" value="<?php echo $currentConfig['upload_limit'] ?? 2; ?>" min="1" max="100" class="form-control" placeholder="Enter file size limit">
            </div>

            <button type="submit" class="btn btn-primary w-100">Save Changes</button>
        </form>
    </div>

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