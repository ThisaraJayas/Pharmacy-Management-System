<?php require_once "site.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - MedSmart</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="./assets/css/main.css">
  <link rel="stylesheet" href="./assets/css/about.css">
</head>

<body>
  <?php renderMainMenu() ?>
  <div class="container">
    <div class="profile-section">
      <img class="profile-image" src="./assets/images/logo.png" alt="MedSmart Logo">
      <h1 class="profile-name">MedSmart</h1>
      <h2 class="profile-title">Online Pharmacy</h2>
    </div>
    <div class="aboutsection">
      <h3>About Us</h3>
      <p>MedSmart (Pvt) Ltd., (established in 2020) provides a platform to make it easier for customers to find necessary
        medical products. We provide a range of quality medications, medical devices and instruments which we deliver to
        our doorstep. We have a friendly experienced staff to serve you at all times. Our aim is to deliver the best customer
        service & healthcare products because we value our customers and their essential health needs as our first priority.</p>
    </div>
    <div class="contact-section">
      <h3>Contact Me</h3>
      <div class="contact-info">
        <p>Email: medsmart@gmail.com</p>
        <p>Phone: (+94) 456-7890</p>
        <p>Location: Malabe, Colombo</p>
      </div>
    </div>
  </div>
  <?php renderFooter() ?>
  <script src="./assets/js/main.js"></script>
</body>

</html>