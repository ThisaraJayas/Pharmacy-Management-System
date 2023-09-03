<?php require_once "site.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shopping Cart - MedSmart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/cart.css">
</head>

<body>
    <?php renderMainMenu() ?>

    <main>
        <?php
        $con = connectDB();

        $sql = "SELECT * FROM `cart` WHERE user_id={$_SESSION["user_id"]}";
        $result = $con->query($sql);

        $totalPrice = 0;
        $totalItems = 0;

        function displayItem($id, $itemID, $amount)
        {
            global $con, $totalPrice, $totalItems;

            $sql = "SELECT * FROM `product` WHERE id=$itemID";
            $result = $con->query($sql);
            if (!$result || $result->num_rows !== 1) {
                return;
            }

            $product = $result->fetch_assoc();

            $totalPrice += $product["price"] * $amount;
            $totalItems += $amount;

            echo '<div class="cart-item">
            <img class="item-image" src="./uploads/products/' . $product['image'] . '">
            <div class="item-info">
                <span class="item-name">' . $product['name'] . '</span>
                <span class="item-price">Price: Rs. ' . $product['price'] . '</span>
                <span class="item-amount">Amount: ' . $amount . '</span>
                <div class="item-bottom-row">
                    <span class="item-price-total">Rs. ' . $product['price'] * $amount . '</span>
                    <span class="item-remove"><a class="button" href="./cartremove.php?id=' . $id . '">Remove</a></span>
                </div>
            </div>
        </div>';
        }

        function displayPrescription($id, $presID)
        {
            global $con, $totalPrice, $totalItems;

            $sql = "SELECT * FROM `Prescription` WHERE Prescription_ID=$presID AND User_ID={$_SESSION["user_id"]}";
            $result = $con->query($sql);
            if (!$result || $result->num_rows !== 1) {
                return;
            }

            $product = $result->fetch_assoc();

            $totalPrice += $product["price"];
            $totalItems += 1;

            echo '<div class="cart-item">
            <img class="item-image" src="./assets/images/prescription.svg">
            <div class="item-info">
                <span class="item-name"> Prescription #' . $presID . ' </span>
                <div class="item-bottom-row">
                    <span class="item-price-total">Rs. ' . $product['Price'] . '</span>
                    <span class="item-remove"><a class="button" href="./cartremove.php?id=' . $id . '">Remove</a></span>
                </div>
            </div>
        </div>';
        }


        if (!$result || $result->num_rows === 0) {
            echo "No items in shopping cart";
        } else {
            echo ' <div class="container">
            <div class="cart-items">';

            while ($row = $result->fetch_assoc()) {
                if (is_null($row["product_id"])) {
                    displayPrescription($row["id"], $row["prescription_id"]);
                } else {
                    displayItem($row["id"], $row["product_id"], $row["amount"]);
                }
            }

            echo '</div>
            <div class="checkout-sidebar">
                <div class="row">
                    <span>Total:</span>
                    <span>Rs. ' . $totalPrice . '</span>
                </div>
                <div class="row">
                    <span>Number of Items:</span>
                    <span>' . $totalItems . '</span>
                </div>
                <span class="button-container">
                    <a class="button" href="./checkout.php">Proceed to checkout</a>
                </span>
            </div>
        </div>';
        }



        ?>



    </main>

    <?php renderFooter() ?>
    <script src="./assets/js/main.js"></script>
</body>