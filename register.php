<?php require_once "site.php" ?>

<?php
include 'config.php';
if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['psw'];
    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "insert into `user` (firstname,lastname,email,mobile,password) values('$fname','$lname','$email','$mobile','$password')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header('location:login.php');
    } else {
        die(mysqli_error($con));
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/register.css">
    <script type="text/javascript" src="./assets/js/register.js"></script>
</head>

<body>
    <?php renderMainMenu() ?>

    <main>

        <form method="POST" name="myform2">

            <div class="container">
                <h1>Register</h1>
                <p>Please fill in this form to create an account.</p>
                <hr>

                <label for="fname">First name</label>
                <input type="text" placeholder="Enter First Name" name="fname" id="fname" autocomplete="off" required>

                <label for="fname">Last name</label>
                <input type="text" placeholder="Enter Last Name" name="lname" id="lname" autocomplete="off" required>

                <label for="email">Email</label>
                <input type="email" placeholder="Enter Email" name="email" id="email" autocomplete="off" required>

                <label for="mobile">Mobile</label>
                <input type="text" placeholder="Enter Mobile no" name="mobile" id="mobile" maxlength="10" autocomplete="off" required>

                <label for="psw">Password</label>
                <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

                <p>By creating an account you agree to our <a href="#">Terms & Privacy</a></p>

                <button type="submit" name="submit" onclick="return val (event);"> Register </button>


            </div>
        </form>

    </main>

    <?php renderFooter() ?>
    <script src="./assets/js/main.js"></script>
</body>