<!-- Related Product Section Begin -->
<section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Related Product</h2>
                    </div>
                </div>
            </div>
            <div class="row">
               <?php
                foreach($related_product as $product)
                {
                    echo <<<HTML
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{$product['img_url']}">
                                    <ul class="product__item__pic__hover">
                                        <li><a href="./addCart.php?productId={$product['product_id']}&quantity=1"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="./detail.php?productId={$product['product_id']}">{$product['name']}</a></h6>
                                    <h5>{$product['price']}</h5>
                                </div>
                            </div>
                        </div>
                    HTML;
                }
               ?>
            </div>
        </div>
        </section>
        <!-- Related Product Section End -->  