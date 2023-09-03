<?php
require_once './check_login.php';
http_response_code(301);
header("Location: ./addproduct.php");
