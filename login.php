<?php require_once "site.php" ?>

<?php // sachintha
include 'config.php';
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['psw'];

    $sql = "SELECT password, id  FROM `user` WHERE email='$email'";
    $result = mysqli_query($con, $sql);

    if (!$result || $result->num_rows == 0) {
        echo "user does not exit";
    } else {
        $row = $result->fetch_assoc();
        $password_hash = $row["password"];
        $user_id = $row["id"];
        if (password_verify($password, $password_hash)) {
            session_start();

            $_SESSION["user_id"] = $user_id;

            $url = "./index.php";
            if (isset($_REQUEST["redirect"])) {
                $url = $_REQUEST["redirect"];

                // prevent redirecting to different sites 
                if (!is_string($url) || ($url[0]  != "/" && $url[0] != ".")) {
                    $url = "/";
                }
            }

            // redirect to given url or home page.
            http_response_code(301);
            header("Location: " . $url);
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
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/login.css">
    <script type="text/javascript" src="./assets/js/login.js"></script>
</head>

<body>
    <?php renderMainMenu() ?>

    <main>

        <form method="POST" name="myform">
            <div class="imgcontainer">
                <img src="./assets/images/man.png" alt="avatar" class="avatar">
            </div>

            <div class="container">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" autocomplete="off" required>

                <label for="psw">Password</label>
                <input type="password" name="psw" id="psw" required>

                <label>
                    <input type="checkbox" name="remember" id="remeber" checked="checked">
                    Remember me
                </label>

                <button type="submit" name="submit" onclick="return val ();"> Sign in </button>

                <span class="reg">is this your first time <a href="register.php">Register</a></span>
            </div>



            <div class="container">
                <button type="button" class="canclebtn"><a href="index.php">Cancel</a></button>
                <span class="psw">Forgot <a href="#">password</a></span>
            </div>
        </form>

    </main>

    <?php renderFooter() ?>
    <script src="./assets/js/main.js"></script>
</body>