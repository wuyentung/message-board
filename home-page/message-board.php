<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../account/login.php");
    exit;
}

$selected_board = "message";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_board = $_POST["topic"];
    require "../config/dbConfig.php";
    $srch_query = "SELECT topic_id FROM topics 
        WHERE topic = ?";
    $srch_stmt = $db->prepare($srch_query);
    $srch_stmt->execute([$_POST["topic"]]);
    $result = $srch_stmt->fetch();
    $topic_id = $result["topic_id"];
    $_SESSION["topic"] = $_POST["topic"];
    $_SESSION["topic_id"] = $topic_id;

    $srch_query = "SELECT users.username, m.title, m.message_time, m.message_id FROM messages AS m 
        JOIN users ON m.u_id=users.u_id 
        WHERE m.topic_id = $topic_id and m.parent_id is NULL";
    $srch_stmt = $db->prepare($srch_query);
    $srch_stmt->execute();
    $results = $srch_stmt->fetchALL();
}
?>

<!DOCTYPE html>
<header>
    <?php
    echo /*html */ "<h1>Welcome to $selected_board board, {$_SESSION["username"]}</h1>";
    echo nl2br(/*html */ "<p><a href='../account/logout.php'>Here</a> to log out.\n</p>");
    ?>
</header>
<form method="post">
  <label for="topic">Choose a topic you want to disscuss:</label>
  <select id="topic" name="topic">
        <?php
        $topics = array("News", "Sports", "Movies", "Stocks");
        foreach ($topics as $topic) {
            echo /*html */ "<option value=$topic>$topic</option>";
        }
        ?>
  </select>
  <input type="submit" value="Go">
</form> 
<?php

unset($_SESSION["root_id"]);
unset($_SESSION["root_title"]);
$herf = "./leave-message.php";
echo /*html */ "<a href=$herf>Here</a> to leave a message.<br><br>";

if ($selected_board != "message" && empty($results)) {
    echo nl2br("There's no message in this topic yet.\nPost your first message!\n");
} else {
    $cols = array("username", "title", "message_time");
    echo /*html */ "<table><thead><tr>";
    foreach ($cols as $col) {
        echo /*html */ "<th>$col</th>";
    }
    echo /*html */ "</tr></thead><tbody>";
    foreach ($results as $result) {
        echo /*html */ "<tr>";
        echo /*html */ "<td>{$result[$cols[0]]}</td>";
        $herf = "message-select.php?message_id={$result['message_id']}";
        echo /*html */ "<td><a href=$herf>{$result[$cols[1]]}</a></td>";
        echo /*html */ "<td>{$result[$cols[2]]}</td>";
        echo /*html */ "</tr>";
    }
    echo /*html */ "</tbody></table>";
}
?>