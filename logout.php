<?php

// delete the session
session_start(["use_strict_mode" => 1]);
session_unset();
session_destroy();


// redirect to home page.
http_response_code(301);
header("Location: ./index.php");
