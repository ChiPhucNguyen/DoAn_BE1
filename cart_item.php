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
                                    if(isset($_SESSION['user_id']))
                                    {
                                        $userId = $_SESSION['user_id'];
                                        $carts = getCartItemByUserId($userId);
                                        foreach($carts as $cart)
                                        {
                                            $totalPriceItem = $cart['price'] * $cart['quantity'];
                                            echo <<<HTML
                                                <tr>
                                                    <td class="shoping__cart__item">
                                                        <img src="img/cart/cart-1.jpg" alt="">
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="#" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                        <a href="#" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                            Upadate Cart</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Discount Codes</h5>
                            <form action="#">
                                <input type="text" placeholder="Enter your coupon code">
                                <button type="submit" class="site-btn">APPLY COUPON</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Subtotal <span>$454.98</span></li>
                            <li>Total <span>$454.98</span></li>
                        </ul>
                        <a href="#" class="primary-btn">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->