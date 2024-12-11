
<?php
    session_start();
    require_once '../../models/UserModel.php';
    require_once '../../models/CategoryModel.php';
    require_once '../../models/ProductModel.php';
    require_once '../../models/CartModel.php';
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
    $cart = [];
    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        if(isset($_GET['id']))
        {
            $cartModel = new CartModel();
            $cart_id = $_GET['id'];
            $cart = $cartModel->getItemInCartById($cart_id);
            if(count($cart) == 0)
            {
                header("Location: list.php");
                exit;
            }
            else
            {
                $cart = $cart[0];

            }
        }
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_POST['quantity']) && isset($_POST['cartId']) && isset($_POST['productId']))
        {
            $cartModel = new CartModel();
            $cart_item_id = $_POST['itemId'];
            $cart_id = $_POST['cartId'];
            $product_id = $_POST['productId'];
            $quantity = $_POST['quantity'];
            $cartModel->updateItemInCart($cart_item_id,$cart_id, $product_id, $quantity);
            header("Location: list.php");
        }
    }
    $productModel = new ProductModel();
    $categoryModel = new CategoryModel();
    $cartModel = new CartModel();
    $carts = $cartModel->getAllUserCart();
    $products = $productModel->getAllProducts();

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

        <h1 class="h3 mb-2 text-gray-800">CHỈNH SỬA GIỎ HÀNG</h1>

        <form action="edit.php" class="w-50" method="post" enctype="multipart/form-data">
            <input type="text" name="itemId" class="form-control form-control-user mb-3" placeholder="ID" value="<?php echo  $cart['cart_item_id']?>" readonly>
            <input type="text" name="quantity" class="form-control form-control-user mb-3" placeholder="Enter Quantity" value="<?php echo  $cart['quantity']?>">
            <select name="cartId" class="form-select form-control mb-3">
                <?php
                    foreach($carts as $c)
                    {
                        $selected = $c['cart_id'] ==  $cart_id ? 'selected' : '';
                        echo "<option value='{$c['cart_id']} ' {$selected}>{$c['cart_id']} - {$c['username']}</option>";
                    }
                ?>
            </select>
            <select name="productId" class="form-select form-control mb-3">
                <?php
                    foreach($products as $product)
                    {

                        $selected = $product['product_id'] == $cart['product_id'] ? 'selected' : '';
                        echo "<option value='{$product['product_id']} ' {$selected}>{$product['name']}</option>";
                    }
                ?>
            </select>
           <button type="submit" class="form-control btn btn-success">Update</button>
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