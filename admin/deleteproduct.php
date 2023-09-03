<?php 
require_once './check_login.php';
require '../config.php';
if (isset($_GET['deleteid'])) {
	$id = $_GET['deleteid'];
	$sql = "delete from product where id=$id";
	if ($con->query($sql)) {
		header('location:addproduct.php');
	} else {
		echo "Error" . $con->error;
	}
}
