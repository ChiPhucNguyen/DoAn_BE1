
<?php
    session_start();
    require_once '../../models/UserModel.php';
    require_once '../../models/ProductModel.php';
    require_once '../../models/PaginationModel.php';
    $userModel = new UserModel();
    $paginationModel = new PaginationModel();
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
    $productModel = new ProductModel();
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 1;
    if(isset($_GET['search']))
    {
        $products = $productModel->searchProductByName($_GET['search'], $page, $limit);
    }
    else
    {
        $products = $productModel->getProducts($page, $limit);
    }
    $productsTotal = $products['total'];
    $products = $products['items'];
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

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">QUẢN LÍ SẢN PHẨM</h1>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">SẢN PHẨM</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-header d-flex justify-content-between mb-2 mt-3">
                            <a href="./add.php" class="btn btn-success">Thêm</a>
                            <div>
                                <form method="get" action="./list.php"
                                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Tìm kiếm theo tên"
                                                aria-label="Search" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-search fa-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                </form>
                            </div>

                            </div>
                        </div>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Views</th>
                                    <th>Sold</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php
                                foreach ($products as $product) 
                                {
                                    echo <<<HTML
                                    <tr>
                                        <td>{$product['product_id']}</td>
                                        <td><img class="" style="height: 100px; width: 100px;" src="../../../{$product['img_url']}" alt=""></td>
                                        <td>{$product['name']}</td>
                                        <td>{$product['price']}</td>
                                        <td>{$product['stock']}</td>
                                        <td>{$product['views']}</td>
                                        <td>{$product['sold']}</td>
                                        <td>
                                            <a href="edit.php?id={$product['product_id']}" class="btn btn-primary">Sửa</a>
                                            <a href="delete.php?id={$product['product_id']}" class="btn btn-danger">Xóa</a>
                                        </td>
                                    HTML;
                                }
                               ?>
                            </tbody>
                        </table>
                        <?php
                             $url = $_SERVER['REQUEST_URI'];
                             $paginationModel->print_paginate($url, $productsTotal, $limit, $page);
                        ?>
                    </div>
                </div>
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