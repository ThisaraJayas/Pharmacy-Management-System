<?php
// sachintha
include '../config.php';
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['psw'];

    $sql = "SELECT password, id  FROM `admin` WHERE username='$username'";
    $result = mysqli_query($con, $sql);

    if (!$result || $result->num_rows == 0) {
        echo "user does not exit";
    } else {
        $row = $result->fetch_assoc();
        $password_hash = $row["password"];
        $admin_id = $row["id"];
        if (password_verify($password, $password_hash)) {
            session_start();

            $_SESSION["admin_id"] = $admin_id;
            http_response_code(301);
            header("Location: ./addproduct.php");
        } else {
            echo "Incorrect password try again!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Log in</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <script type="text/javascript" src="../assets/js/login.js"></script>
</head>

<body>

    <main>

        <form method="POST" name="myform">
            <div class="imgcontainer">
                <img src="../assets/images/man.png" alt="avatar" class="avatar">
            </div>

            <div class="container">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" autocomplete="off" required>

                <label for="psw">Password</label>
                <input type="password" name="psw" id="psw" required>

                <button type="submit" name="submit"> Sign in </button>

            </div>

        </form>

    </main>
</body>