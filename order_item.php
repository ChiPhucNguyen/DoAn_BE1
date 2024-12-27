
<?php
    require_once './models/OrderModel.php';
    require_once './models/UserModel.php';
    require_once './models/CartModel.php';
    $orderModel = new OrderModel();
    $userModel = new UserModel();
    $cartModel = new CartModel();
    $isLoggedIn = $userModel->isUserLoggedIn();
    
    $orders = null;
    if($isLoggedIn)
    {
        if(isset($_GET['cartid']))
        {
           $orderModel->checkout($_SESSION['user_id'],$_GET['cartid']);
        }
        $userId = $_SESSION['user_id'];
        $orders = $orderModel->getOrderByUserId($userId);
    }


 ?>
 <!-- Order Section Begin -->
 <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Mã Đơn Hàng</th>
                                    <th>Ngày đặt</th>
                                    <th>Trạng thái</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php
                                    if($orders == null)
                                    {
                                        echo "<h3 class='text-center'>Không có đơn hàng nào</h3>";
                                        return;
                                    }
                                    foreach($orders as $order)
                                    {
                                        $orderId = $order['order_id'];
                                        $createdAt = $order['created_at'];
                                        $status = $order['status'];
                                        $total = $order['total_price'];
                                        echo <<<HTML
                                             <tr class="order-select" onclick="redirectToDetailPage($orderId)">
                                                <td class="shoping__cart__item ">
                                                    <h5 class="">$orderId</h5>
                                                </td>
                                                <td class="shoping__cart__price">
                                                   $createdAt
                                                </td>
                                                <td class="shoping__cart__quantity">
                                                    <div class="btn btn-success">$status</div>
                                                </td>
                                                <td class="shoping__cart__total">
                                                    $total Đ
                                                </td>
                                            </tr>
                                        HTML;
                                    }
                               ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
    <!-- Order Section End -->
    <script>
        function redirectToDetailPage(orderId) {
            // Chuyển hướng tới trang chi tiết đơn hàng
            window.location.href = `/store/order_detail.php?orderId=${orderId}`;
        }
    </script>