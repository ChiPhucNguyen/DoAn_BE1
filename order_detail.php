<?php
    include_once './header.php';
    include_once './hero.php';
    require_once './models/OrderModel.php';
    require_once './models/UserModel.php';
    $orderModel = new OrderModel();
    $userModel = new UserModel();
    $isLoggedIn = $userModel->isUserLoggedIn();
    $orders = null;
    $totalOrderPrice = 0;

    if ($isLoggedIn) {
        $userId = $_SESSION['user_id'];
        if(isset($_GET['orderId']))
        {
            $orders = $orderModel->getOrderDetailByOrderId($_GET['orderId'], $userId);
        }
       
    }
?>

<!-- Shoping Cart Section Begin -->
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th class="shoping__product">Products</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($isLoggedIn && $orders) {
                                    foreach ($orders as $order) {
                                        $orderTotal = $order['price'] * $order['quantity'];
                                        $totalOrderPrice += $orderTotal;
                                        echo <<<HTML
                                            <tr>
                                                <td class="shoping__cart__item">
                                                    <img src="{$order['img_url']}" alt="">
                                                    <h5>{$order['name']}</h5>
                                                </td>
                                                <td class="shoping__cart__price">
                                                    {$order['price']} VND
                                                </td>
                                                <td class="shoping__cart__quantity">
                                                    {$order['quantity']}
                                                </td>
                                                <td class="shoping__cart__total">
                                                    $orderTotal VND
                                                </td>
                                            </tr>
                                        HTML;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-end">
            <div class="col-lg-6">
                <div class="shoping__checkout">
                    <h5>Order Total</h5>
                    <ul>
                        <li>Total <span><?php echo $totalOrderPrice ?> VND</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shoping Cart Section End -->
<?php include_once './footer.php'; ?>