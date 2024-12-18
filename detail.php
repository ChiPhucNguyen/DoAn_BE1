<?php
    include "header.php";
    include "hero.php";
    require_once './models/ProductModel.php';
    $productModel = new ProductModel();
    if(isset($_GET['productId']) && (int)$_GET['productId'] > 0)
    {
        $productsId = (int)$_GET['productId'];
        $product = $productModel->getProductsById($productsId);
        if($product == null) return;
        $product = $product[0];
        $limit = 4;
        $related_product = $productModel->getRelatedProducts($product['category_id'], $limit);
    }

?>
    <?php
    if(isset($_GET['productId']) && (int)$_GET['productId'] > 0)
    {
        echo <<<HTML
        <!-- Product Details Section Begin -->
        <section class="product-details spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="product__details__pic">
                            <div class="product__details__pic__item">
                                <img class="product__details__pic__item--large"
                                    src="{$product['img_url']}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="product__details__text">
                            <h3>{$product['name']}</h3>
                            <div class="product__details__rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o"></i>
                                <span>(18 reviews)</span>
                            </div>
                            <div class="product__details__price">$ {$product['price']}</div>
                            <p>Đã bán : {$product['sold']} cái.</p>
                            <div class="product__details__quantity">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1">
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="primary-btn">ADD TO CARD</a>
                            <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
                            <ul>
                                <li><b>Số lượng còn lại : {$product['stock']}</b></li>
                                <li><b>Số lượt xem : {$product['views']}</b></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                        aria-selected="true">Description</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                    <div class="product__details__tab__desc">
                                        <h6>Products Infomation</h6>
                                        <p>{$product['description']}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Product Details Section End -->
    HTML;
         include "related_product.php";

    }
    ?>
<?php include "footer.php"?>
