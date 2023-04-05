<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../account/login.php");
    exit;
}
echo nl2br(/*html */ "<h1>Leave a message on {$_SESSION["topic"]} board.</h1>\n");
if (isset($_SESSION["root_id"])) {
    $title_text = "<input type='text' name='title' value='{$_SESSION["root_title"]}' readonly><br><br>";
} else {
    $title_text = "<input type='text' name='title' placeholder='Say something...' required><br><br>";
}
?>
<!DOCTYPE html>
<form method="post" action="./insert-message.php">
    <label for="title">Title: </label>
        <?php
        echo $title_text;
        ?>

    <label for="content">Content:</label>
    <textarea name="content" rows="5" cols="40" required></textarea><br><br>

    <input type="submit" name="submit" value="post">
</form>