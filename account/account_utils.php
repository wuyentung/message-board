<?php
// Validate username
function validate_username($_username, $registering=False) {
    if(empty(trim($_username))){
        $username_err = "Please enter a username.\n";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $_username)) {
        $username_err = "Username can only contain letters, numbers, and underscores.\n";
    }
    // if ($registering) {
    //     require_once "dbConfig.php";
    //     $srch_query = "SELECT username FROM users WHERE username = ?";
    //     $srch_stmt = $db->prepare($srch_query);
    //     $srch_stmt->execute([$_username]);
    //     $result = $srch_stmt->fetch(PDO::FETCH_OBJ);
    //     $username = $result->username;
    //     if (isset($username)) {
    //         $username_err = nl2br("Sorry, but  username $_username is taken, please try another one.\n");
    //     }
    // }
    return $username_err;
}
?>