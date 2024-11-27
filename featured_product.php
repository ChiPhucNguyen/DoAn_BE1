   <?php 
    require_once "function.php"
   ?>
   <!-- Featured Section Begin -->
   <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Featured Product</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*">All</li>
                            <?php
                                $categories = getAllCategories();
                                foreach($categories as $category)
                                {
                                    echo <<<HTML
                                        <li data-filter=".category-{$category['category_id']}">{$category['name']}</li>
                                    HTML;
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                <?php
                    $start = 1;
                    $limit = 10;
                    $products = getProducts($start, $limit);
                    foreach($products as $product)
                    {
                        echo <<<HTML
                        <div class="col-lg-3 col-md-4 col-sm-6 mix oranges category-{$product['category_id']}">
                            <div class="featured__item">
                                <div class="featured__item__pic set-bg" data-setbg="img/featured/feature-1.jpg">
                                    <ul class="featured__item__pic__hover">
                                        <li><a href="./addCart.php?productId={$product['product_id']}&quantity=1"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="featured__item__text">
                                    <h6><a href="./detail.php?productId={$product['product_id']}">{$product["name"]}</a></h6>
                                    <h5>$ {$product["price"]}</h5>
                                </div>
                            </div>
                        </div>
                        HTML;
                    }
                   
                ?>
              
            </div>
        </div>
    </section>
    <!-- Featured Section End -->
