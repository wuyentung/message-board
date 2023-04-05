<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../account/login.php");
    exit;
}
$herf = "./message-board.php";
echo /*html */ "<a href=$herf>Back</a> to message board";
$root_id = $_GET['message_id'];
require_once "../config/dbConfig.php";
$srch_query = "SELECT users.username, m.title, m.content, m.message_time, m.message_id FROM messages AS m 
    JOIN users ON m.u_id=users.u_id 
    WHERE m.message_id = ? OR m.parent_id = ?";
$srch_stmt = $db->prepare($srch_query);
$srch_stmt->execute([$root_id, $root_id]);
$results = $srch_stmt->fetchALL();

echo /*html */ "<table><tr>";
echo /*html */ "<th colspan='2'>{$results[0]["title"]}</th>";
foreach ($results as $row) {
    // identify root message
    if ($row["message_id"] == $root_id) {
        echo /*html */ "<th>{$row["username"]}</th>";
        echo /*html */ "<th>{$row["message_time"]}</th>";
        echo /*html */ "</tr>";
        echo /*html */ "<tr>";
        echo /*html */ "<th colspan='4'>{$row["content"]}</th>";
        echo /*html */ "</tr>";
    } else {
        echo /*html */ "<tr>";
        foreach (["username", "content", "message_time"] as $value) {
            echo /*html */ "<td>{$row[$value]}</td>";
        }
        echo /*html */ "</tr>";
    }
}
echo /*html */ "</table><br>";

// leave a message
$herf = "./leave-message.php";
$_SESSION["root_id"] = $root_id;
$_SESSION["root_title"] = $results[0]["title"];
echo /*html */ "<a href=$herf>Here</a> to leave a message";
?>