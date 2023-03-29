<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../account/login.php");
    exit;
}
echo nl2br(/*html */ "<h1>Welcome, {$_SESSION["username"]}</h1>\n");
echo nl2br(/*html */ "<p><a href='../account/logout.php'>Here</a> to log out.\n</p>");
?>