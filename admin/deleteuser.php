<?php
require_once './check_login.php';
include '../config.php';
if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    $sql = "delete from `user` where id=$id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        //echo "Deleted successfully";
        header('location:displaylogin.php');
    } else {
        die(mysqli_error($con));
    }
}
