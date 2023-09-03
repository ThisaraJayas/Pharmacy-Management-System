<?php
$con = new mysqli('localhost', 'root', '', 'medsmart');
if ($con->connect_error) {
	die("Connection Failed" . $con->connect_error);
}
