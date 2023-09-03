<?php
require_once './check_login.php';
include '../config.php';
$id = $_GET['updateid'];
if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['psw'];

    $sql = "update `user` set id = $id, firstname='$fname', lastname='$lname', email='$email', mobile='$mobile', password='$password' where id = $id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        //echo "updated successfully";
        header('location:displaylogin.php');
    } else {
        die(mysqli_error($con));
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/register.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <script type="text/javascript" src="../assets/js/register.js"></script>
</head>

<body>
    <div class="navbar">
        <ul>
            <li><a href="addproduct.php">Manage Product</a> </li>
            <li><a href="prescription.php">Manage Prescription</a> </li>
            <li><a href="displaylogin.php">Manage Users</a></li>
            <li><a href="contactdisplay.php">Messages</a></li>
        </ul>
    </div>

    <form method="POST" name="myform2">
        <?php

        include '../config.php';

        $sql = "SELECT * FROM `user` WHERE id={$_GET['updateid']}";
        $result = $con->query($sql);
        if (!$result || $result->num_rows  < 1) {
            echo "Unable to find user";
        } else {
            $row = $result->fetch_assoc();
            echo '<div class="container">
            <label for="fname">First name</label>
            <input type="text" placeholder="Enter First Name" name="fname" id="fname" value="' . $row["firstname"] . '" autocomplete="off" required>

            <label for="fname">Last name</label>
            <input type="text" placeholder="Enter Last Name" name="lname" id="lname" value="' . $row["lastname"] . '" autocomplete="off" required>

            <label for="email">Email</label>
            <input type="text" placeholder="Enter Email" name="email" id="email" value="' . $row["email"] . '" autocomplete="off" required>

            <label for="mobile">Mobile</label>
            <input type="text" placeholder="Enter Mobile no" name="mobile" value="' . $row["mobile"] . '" id="mobile" maxlength="10" autocomplete="off" required>

            <label for="psw">Password</label>
            <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

            <button type="submit" name="submit" onclick="return val ();"> update </button>
        </div>';
        }

        $con->close();


        ?>

    </form>
</body>

</html>