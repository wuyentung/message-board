<?php
session_start();
echo nl2br("{$_POST['title']}\n");
echo nl2br("{$_POST['content']}\n");

require "../config/dbConfig.php";
if (isset($_SESSION["root_id"])) {
    $parent_id = $_SESSION["root_id"];
} else {
    $parent_id = "NULL";
}
$ins_query = "INSERT INTO messages (u_id, topic_id, parent_id, title, content) VALUES ({$_SESSION["u_id"]}, {$_SESSION["topic_id"]}, {$parent_id}, :title, :content)";
// echo $ins_query;
$ins_stmt = $db->prepare($ins_query);
$ins_stmt->bindParam("title", $_POST["title"], PDO::PARAM_STR);
$ins_stmt->bindParam("content", $_POST["content"], PDO::PARAM_STR);
if ($ins_stmt->execute()) {
    echo "successfully inserted";
    if (isset($_SESSION["root_id"])) {
        $redirect = "./message-select.php?message_id={$_SESSION["root_id"]}";
    } else {
        $inserted_id = $db->lastInsertId();
        $redirect = "./message-select.php?message_id={$inserted_id}";
    }
    header("location: $redirect");
}
?>