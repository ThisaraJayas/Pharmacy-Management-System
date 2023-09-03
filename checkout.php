<?php require_once "site.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Checkout - MedSmart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/checkout.css">
</head>

<body>
    <?php renderMainMenu() ?>

    <main>
        <form class="form-card" action="#" method="post">
            <h3>User Details<br><br></h3>

            <div class="field">
                <div class="name">First Name</div>
                <input class="value-edit" name="firstName" type="text" required>
            </div>

            <div class="field">
                <div class="name">Last Name</div>
                <input class="value-edit" name="lastName" type="text" required>
            </div>

            <div class="field">
                <div class="name">Address</div>
                <textarea class="value-edit" name="address" required></textarea>
            </div>

            <hr>
            <h3>Payment details<br><br></h3>


            <div class="field">
                <div class="name">Card Holder Name</div>
                <input class="value-edit" name="carName" type="text" required>
            </div>
            <div class="field">
                <div class="name">Card number</div>
                <input class="value-edit" name="cardNumber" type="text" required>
            </div>
            <div class="field">
                <div class="name">Expiring Date</div>
                <input class="value-edit" name="cardExp" type="text" required>
            </div>
            <div class="field">
                <div class="name">CVC</div>
                <input class="value-edit" name="cardCVC" type="text" required>
            </div>

            <div class="button-bar-edit">
                <a class="button cancel-button" href="./cart.php">Cancel</a>
                <button type="submit" class="button save-button">Complete Purchase</button>
            </div>

        </form>
    </main>

    <?php renderFooter() ?>
    <script src="./assets/js/main.js"></script>
</body>