<?php
require_once "site.php";
require 'config.php';

if (isset($_POST['submit'])) {
  $fname = $_POST['firstName'];
  $lname = $_POST['lastName'];
  $email = $_POST['Email'];
  $teleno = $_POST['telephoneNo'];
  $message = $_POST['message'];

  $sql = "insert into contact(fname,lname,email,telno,message) values('$fname','$lname','$email','$teleno','$message')";
  if ($con->query($sql)) {
    header("Location: ./index.php");
  } else {
    echo "error" . $con->error;
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Contact Us - MedSmart</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="./assets/css/main.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/contactstyle.css">
</head>

<body>
  <?php renderMainMenu() ?>
  <main>
    <div class="container">
      <div class="formbox">
        <h1>Contact Us</h1>

        <form method="POST" onsubmit="return checkDetails(event);">
          <label for="firstName">First Name:</label>
          <input type="text" id="firstName" name="firstName" required><br>

          <label for="lastName">Last Name:</label>
          <input type="text" id="lastName" name="lastName" required><br>

          <label for="workEmail">Email:</label>
          <input type="email" id="Email" name="Email" required><br>

          <label for="telephoneNo">Telephone Number:</label>
          <input type="tel" id="telephoneNo" name="telephoneNo" required><br>

          <label for="message">Message:</label>
          <textarea id="message" name="message" rows="5" required></textarea>

          <input type="submit" value="Submit" name="submit" class="button">
        </form>
      </div>
      <div class="contactinfo">
        <h2>Contact Information</h2><br>
        <p>☎ Phone No: +94 123 456 7890</p><br>
        <p>🖷 PAS: +94 123 456 2000</p><br>
        <p>✉ Email: MedSmart@gmail.com</p><br>
        <p>📍 Address: 303 Main Street, Malabe, Sri Lanka</p><br>
      </div>
    </div>
  </main>
  <?php renderFooter() ?>
  <script src="./assets/js/main.js"></script>
  <script src="./assets/js/contact.js"></script>
</body>

</html>