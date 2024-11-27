<div class="hero__categories">
<div class="hero__categories__all">
        <i class="fa fa-bars"></i>
        <span>DANH MỤC</span>
    </div>
    <ul>
        <?php
            $categories = getAllCategories();
            foreach($categories as $item)
            {
                echo <<<HTML
                    <li><a href="./category.php?categoryId={$item['category_id']}">{$item['name']}</a></li>
                HTML;
            }
        ?>
    </ul>
</div>