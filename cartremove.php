<?php
require_once "./site.php";

checkLogin();

$user = $_SESSION['user_id'];

$id = $_GET["id"];

if (is_numeric($id)) {
    $con = connectDB();
    $sql = "DELETE FROM `cart` WHERE user_id=$user AND id=$id";

    if (!$con->query($sql)) {
        die("<script>
        alert('Failed to remove item from cart');
        window.location = './cart.php'
        </script>");
    }
}

http_response_code(301);
header("Location: ./cart.php");
