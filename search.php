

<?php 
    include "header.php";
    require_once "function.php"
?>
    <!-- Hero Section Begin -->
    <?php include "hero.php" ?>
    <!-- Hero Section End -->


<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5">
              <?php include "sidebar.php"?>
            </div>
            <div class="col-lg-9 col-md-7">
                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="filter__sort">
                                <span>Sort By</span>
                                <select>
                                    <option value="0">Sắp xếp</option>
                                    <option value="1">Giảm dần</option>
                                    <option value="2">Tăng dần</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="filter__found">
                                <?php
                                if(isset($_GET['keyword']))
                                {
                                    $keyword = $_GET['keyword'];
                                    $page = isset($_GET['page']) && $_GET['page']> 0 ? $_GET['page'] : 1;
                                    $limit = 1;
                                    $getProducts = getProductsByKeyword($keyword, $page, $limit);
                                    $products = $getProducts['items'];
                                    $total = $getProducts['total'];
                                    echo  "<h6><span>{$total}</span> sản phẩm được tìm thấy</h6>";
                                }
                                ?>
                               
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-3">
                            <div class="filter__option">
                                <span class="icon_grid-2x2"></span>
                                <span class="icon_ul"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                    <?php
                        if(isset($_GET['keyword']))
                        {
                            foreach($products as $product)
                            {
                                echo <<<HTML
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="product__item">
                                        <div class="product__item__pic set-bg" data-setbg="{$product['img_url']}">
                                            <ul class="product__item__pic__hover">
                                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__item__text">
                                            <h6><a href="./detail.php?productId={$product['product_id']}">{$product['name']}</a></h6>
                                            <h5>$ {$product['price']}</h5>
                                        </div>
                                    </div>
                                </div>
                                HTML;
                            } 
                        }               
                    ?>
                </div>
                <?php
                    if(isset($_GET['keyword']))
                    {
                        $page = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1;    
                        echo print_paginate("./search.php?keyword={$keyword}", $total, $limit, $page, 2);
                    }
                ?>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->

<?php include "footer.php" ?>
