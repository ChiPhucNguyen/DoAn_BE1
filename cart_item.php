 <?php
    require_once './models/CartModel.php';
    require_once './models/UserModel.php';
    $cartModel = new CartModel();
    $userModel = new UserModel();
    $isLoggedIn = $userModel->isUserLoggedIn();
    $carts = null;
    if($isLoggedIn)
    {
        $userId = $_SESSION['user_id'];
        $carts = $cartModel->getCartItemByUserId($userId);
    }
    $totalPriceItem = 0;


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
                                    if($isLoggedIn)
                                    {
                                        foreach($carts as $cart)
                                        {
                                            $totalPriceItem += $cart['price'] * $cart['quantity'];
                                            echo <<<HTML
                                                <tr>
                                                    <td class="shoping__cart__item">
                                                        <img src="{$cart['img_url']}" alt="">
                                                        <h5>{$cart['name']}</h5>
                                                    </td>
                                                    <td class="shoping__cart__price">
                                                        {$cart['price']}
                                                    </td>
                                                    <td class="shoping__cart__quantity">
                                                        <div class="quantity">
                                                            <div class="pro-qty">
                                                                <input type="text" value="{$cart['quantity']}">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="shoping__cart__total">
                                                        $totalPriceItem
                                                    </td>
                                                    <td class="shoping__cart__item__close">
                                                        <a href="./removeCartItem.php?productId={$cart['product_id']}"><span class="icon_close"></span></a>
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
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Total <span><?php echo $totalPriceItem ?></span></li>
                        </ul>
                        <a href="./order.php?cartid=<?php echo $carts[0]['cart_id'] ?>" class="primary-btn">THANH TOÁN</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->