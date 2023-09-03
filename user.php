<?php
require_once "site.php";
checkLogin();

if (isset($_POST["action"])) {
    $action = $_POST["action"];
    if ($action == "updateDetails") {
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];


        $con = connectDB();

        $sql = $con->prepare("UPDATE `user` SET firstname=?, lastname=?, email=?, mobile=? WHERE id={$_SESSION['user_id']}");
        if (!$sql->execute([$firstName, $lastName, $email, $phone])) {
            die($sql->error);
        }

        $con->close();
    } else if ($action == "changePassword") {
        $password = $_POST["password"];
        $password = password_hash($password, PASSWORD_DEFAULT);

        $con = connectDB();
        $sql = "UPDATE `user` SET password='$password' WHERE id='{$_SESSION['user_id']}'";
        if (!$con->query($sql)) {
            die($con->error);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/user.css">
</head>

<body>
    <?php renderMainMenu() ?>

    <main>
        <h2>Profile</h2>

        <form id="user-details" class="user-details-card" action="user.php" method="post">
            <h3>User Details<br><br></h3>
            <?php

            $con = connectDB();
            $sql = "SELECT * FROM `user` WHERE id={$_SESSION['user_id']}";
            $result = $con->query($sql);
            if (!$result || $result->num_rows  < 1) {
                echo "Unable to find user";
            } else {
                $row = $result->fetch_assoc();
                echo '<div class="field">
                <div class="name">First Name</div>
                <div class="value">' . $row["firstname"] . '</div>
                <input class="value-edit" name="firstName" type="text" value="' . $row["firstname"] . '" required>
            </div>

            <div class="field">
                <div class="name">Last Name</div>
                <div class="value">' . $row["lastname"] . '</div>
                <input class="value-edit" name="lastName" type="text" value="' . $row["lastname"] . '" required>
            </div>

            <div class="field">
                <div class="name">Email</div>
                <div class="value">' . $row["email"] . '</div>
                <input class="value-edit" name="email" type="email" value="' . $row["email"] . '" required>
            </div>

            <div class="field">
                <div class="name">Phone number</div>
                <div class="value">' . $row["mobile"] . '</div>
                <input class="value-edit" name="phone" type="text" value="' . $row["mobile"] . '" required maxlength="10">
            </div>';
            }

            $con->close();


            ?>

            <div class="button-bar">
                <span class="button edit-button">Edit</span>
            </div>
            <input type="hidden" name="action" value="updateDetails">
            <div class="button-bar-edit">
                <button type="reset" class="button cancel-button">Cancel</button>
                <button type="submit" class="button save-button">Save</button>
            </div>

        </form>

        <form id="user-password" class="user-details-card edit" action="user.php" method="post">
            <h3>Password</h3>
            <div class="field">
                <div class="name">Password</div>
                <input class="value-edit" name="password" type="password" required>
            </div>

            <div class="field">
                <div class="name">Re-enter Password</div>
                <input class="value-edit" name="passwordConfirm" type="password" required>
            </div>
            <input type="hidden" name="action" value="changePassword">
            <div class="button-bar-edit">
                <button type="submit" class="button save-button">Update</button>
            </div>
        </form>
    </main>

    <?php renderFooter() ?>
    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/user.js"></script>
</body>