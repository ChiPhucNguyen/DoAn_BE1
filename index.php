<?php 
    include "header.php";
?>
  <!-- Hero Section Begin -->
  <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <?php include "hero_categories.php"?>
                </div>
                <div class="col-lg-9">
                    <?php include "hero_search.php" ?>
                    <div class="hero__item set-bg" data-setbg="img/hero/banner.jpg">
                        <div class="hero__text">
                            <span>FRUIT FRESH</span>
                            <h2>Vegetable <br />100% Organic</h2>
                            <p>Free Pickup and Delivery Available</p>
                            <a href="#" class="primary-btn">SHOP NOW</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->
<?php
    include "categories.php";
    include "featured_product.php";
    include "latest_product.php";

    include "footer.php";
    
?>