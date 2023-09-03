<?php require_once "site.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>MedSmart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/home.css">
    <link rel="stylesheet" href="./assets/css/carousel.css">
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
</head>

<body>
    <?php renderMainMenu() ?>
    <div id="site-banner">
        <div id="banner-title">
            <h3>Redefining the role <br>of a pharmacy...</h3>
            <p>Getting your medication delivered<br> got a whole lot simpler!</p>
        </div>
    </div>
    <div id="search-bar">
        <div class="content">
            <img src="./assets/images/icons/search.svg" width="30px" alt="">
            <input type="search" name="search" placeholder="Enter Product Name">
        </div>
    </div>
    <main>

        <?php

        /** displays a product in the promo carousel
         * @param array $product product details
         */
        function displayProduct($product)
        {
            $discounted_price = $product["price"] - $product["discount"];
            echo "<div class='item'>
                    <a class='promo-card' href='./productview.php?proviewid={$product['id']}'>
                        <div class='product-image' style='background-image: url(\"./uploads/products/{$product['image']}\");'>
                        </div>
                        <span class='product-name'>{$product["name"]}</span>
                        <span class='product-price'>
                            <span class='old-price'>
                                Rs. {$product["price"]}
                            </span>
                            <span class='new-price'>
                                Rs. $discounted_price
                            </span>
                        </span>
                        <span class='product-buy button' data-product-id='{$product['id']}'>Add To Cart</span>
                    </a>
                </div>";
        }


        $con = connectDB();
        $sql = "SELECT id, name, price, discount, image FROM `product` WHERE discount != 0";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            echo '<h2 id="promo-title">Promotions</h2>
                <div class="carousel" id="promo-carousel">
                    <ul class="carousel-contents">';
            while ($row = $result->fetch_assoc()) {
                displayProduct($row);
            }
            echo '</ul></div>';
        }



        $con->close();
        ?>
        <div id="site-about">
            <h2>About Us<h2>
                    <p>MedSmart (Pvt) Ltd., (established in 2020) provides a platform
                        to make it easier for customers to find necessary medical
                        products. We provide a range of quality medications,
                        medical devices and instruments which we deliver
                        to your doorstep. We have a friendly experienced
                        staff to serve you at all times. Our aim is to deliver
                        the best customer service & healthcare products
                        because we value our customers and their essential
                        health needs as our first priority.</p>
        </div>

    </main>
    <?php renderFooter() ?>
    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/carousel.js"></script>
    <script>
        const promoCarousel = document.querySelector("#promo-carousel");
        if (promoCarousel !== null) {
            initCarousel(promoCarousel, 4, {
                hasControls: true,
                center: true,
                speed: 2500
            });
        }

        const search = document.querySelector("input[name='search']");
        if (search) {
            search.addEventListener("keypress", (e) => {
                if (e.key.toLocaleLowerCase() === 'enter' && search.value !== "") {
                    window.location = "./store.php?submit=&search=" + encodeURIComponent(search.value);
                }
            })
        }
    </script>

</body>

</html>