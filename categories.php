  <?php
    require_once './models/CategoryModel.php';
    $start = 0;
    $limit = 4;
    $categoryModel = new CategoryModel();
    $categories = $categoryModel->getCategories($start, $limit);
  ?>
  <!-- Categories Section Begin -->
  <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    <?php
                        foreach($categories as $category)
                        {
                            echo <<<HTML
                                <div class="col-lg-3">
                                    <div class="categories__item set-bg" data-setbg="{$category['img_url']}">
                                        <h5><a href="./category.php?categoryId={$category['category_id']}">{$category['name']}</a></h5>
                                    </div>
                                </div>
                            HTML;
                        }

                    ?>
                    
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->