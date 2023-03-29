<?php
session_start();
session_unset();
session_destroy();
// Redirect to login page
header("location: /home/tung/www/html/message-board/account/login.php");
exit;
?>