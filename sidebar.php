<div class="sidebar">
    <div class="sidebar__item">
        <h4>Danh mục</h4>
        <ul>
            <?php
                $categories = getAllCategories();
                foreach($categories as $category)
                {
                    echo "<li><a href='./category.php?categoryId={$category['category_id']}'>{$category['name']}</a></li>";
                }

            ?>
        </ul>
    </div>
    <div class="sidebar__item">
        <div class="latest-product__text">
            <h4>Latest Products</h4>
            <div class="latest-product__slider owl-carousel">
                <div class="latest-prdouct__slider__item">
                    <?php
                        $start = 1;
                        $limit = 3;
                        $products = getLastestProducts($start, $limit);
                        foreach($products as $product)
                        {
                            echo <<<HTML
                                <a href="./detail.php?productId={$product['product_id']}" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-1.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>{$product['name']}</h6>
                                        <span>$ {$product['price']}</span>
                                    </div>
                                 </a>
                            HTML;
                        }
                    ?>
                   
                </div>
            </div>
        </div>
    </div>
</div>