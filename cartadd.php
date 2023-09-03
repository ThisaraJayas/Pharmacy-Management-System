<?php
require_once "./site.php";

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    die(json_encode(["success" => false, "error" => "Not logged in"]));
}

$user = $_SESSION['user_id'];

$type = $_POST["type"];
$id = $_POST["id"];
$amount = $_POST["amount"];

if (!is_numeric($id) || !is_numeric($amount)) {
    http_response_code(400);
    die(json_encode(["success" => false, "error" => "Invalid product id or amount"]));
}


if ($type === "product") {
    $exist_check_sql = "SELECT * FROM `product` WHERE id=$id";
    $remove_duplicate_sql = "DELETE FROM `cart` WHERE user_id=$user AND product_id=$id";
    $add_sql = "INSERT INTO cart (user_id, product_id, amount) VALUES ($user, $id,  $amount)";
} else if ($type === "prescription") {
    $exist_check_sql = "SELECT * FROM `Prescription` WHERE Prescription_ID=$id AND User_ID=$user AND Approved=1";
    $remove_duplicate_sql = "DELETE FROM `cart` WHERE user_id=$user AND prescription_id=$id";
    $add_sql = "INSERT INTO cart (user_id, prescription_id, amount) VALUES ($user,  $id,  1)";
} else {

    http_response_code(400);
    die(json_encode(["success" => false, "error" => "Invalid type"]));
}

$con = connectDB();

// check if the item exists.
if (!$con->query($exist_check_sql)) {
    http_response_code(400);
    die(json_encode(["success" => false, "error" => "$type $id does not exist"]));
}

// remove duplicate items from cart
if (!$con->query($remove_duplicate_sql)) {
    http_response_code(500);
    die(json_encode(["success" => false, "error" => "Failed to remove duplicates for $type $id"]));
}

// add items to cart
if (!$con->query($add_sql)) {
    http_response_code(500);
    die(json_encode(["success" => false, "error" => "Failed to Add to db: $type $id"]));
}

// returns success message
http_response_code(200);
die(json_encode(["success" => true, "cart_items" => getCartItems()]));
