
<?php
    session_start();
    require_once '../../models/UserModel.php';
    require_once '../../models/CategoryModel.php';
    require_once '../../models/ProductModel.php';
    require_once '../../function.php';

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
        if (isset($_POST['productName']) && isset($_POST['price']) && isset($_POST['stock']) && isset($_POST['views']) && isset($_POST['categoryId']) && isset($_POST['sold'])) {

            $productModel = new ProductModel();
            $productName = $_POST['productName'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $views = $_POST['views'];
            $sold = $_POST['sold']; 
            $category_id = $_POST['categoryId'];
            $imgName = $_FILES['imageUpload']['name'] == null ? null : $_FILES['imageUpload']['name'];
            $imgLink = "./img/{$imgName}";
            $productModel->insertProduct($productName, $price, $imgLink, $category_id, $stock, $views, $sold);
            uploadImage($_FILES['imageUpload']);
            header("Location: list.php");
        }
    }
    $productModel = new ProductModel();
    $categoryModel = new CategoryModel();
    $categories = $categoryModel->getAllCategories();

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

        <h1 class="h3 mb-2 text-gray-800">CREATE ACCOUNT</h1>

        <form action="add.php" class="w-50" method="post" enctype="multipart/form-data">
            <input type="text" name="productName" class="form-control form-control-user mb-3" placeholder="Enter Product Name" >
            <div class="mb-3">
                <label for="formFile" class="form-label">Upload Image</label>
                <input name="imageUpload" class="form-control" type="file" id="formFile">
            </div>
            <input type="text" name="price" class="form-control form-control-user mb-3" placeholder="Enter Price.">
            <input type="text" name="stock" class="form-control form-control-user mb-3" placeholder="Enter Stock.">
            <input type="text" name="views" class="form-control form-control-user mb-3" placeholder="Enter Views.">
            <input type="text" name="sold" class="form-control form-control-user mb-3" placeholder="Enter Sold.">
            <select name="categoryId" class="form-select form-control mb-3">
                <?php
                    foreach($categories as $category)
                    {
                        echo "<option value='{$category['category_id']}'>{$category['name']}</option>";
                    }
                ?>
            </select>
           <button type="submit" class="form-control btn btn-success">Add</button>
        </form>
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