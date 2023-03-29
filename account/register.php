<?php
include "account_utils.php";
echo nl2br(/*html */"<h1>Register Page</h1>\n");
function back(){
        echo nl2br("<a href='register.php'>back</a>\n");
        unset($db); // shutdown database
        exit;
    }
// if ($_POST["username"]) {
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../config/dbConfig.php";

    // Validate username
    $username_err = validate_username($_POST["username"], True);
    $srch_query = "SELECT username FROM users WHERE username = ?";
    $srch_stmt = $db->prepare($srch_query);
    $srch_stmt->execute([$_POST["username"]]);
    $result = $srch_stmt->fetch(PDO::FETCH_OBJ);
    $username = $result->username;
    if (isset($username)) {
        $username_err = nl2br("Sorry, but  username $username is taken, please try another one.\n");
    } else $username = $_POST["username"];

    // validate password
    if ($_POST["psw"] != $_POST["repsw"]) {
        $password_err = nl2br("Your password should be the same.\n");
    }
    if (empty(trim($_POST["psw"]))) {
        $password_err = nl2br("Your password should not be empty.");
    } elseif (strlen(trim($_POST["psw"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    }

    // register to db
    if (!(isset($username_err) || isset($password_err))) {
        $ins_query = "INSERT INTO users (username, psw) VALUES (?, ?)";
        $ins_stmt = $db->prepare($ins_query);
        try {
            if ($ins_stmt->execute([$username, password_hash($_POST["psw"], PASSWORD_DEFAULT)])) {
                echo nl2br("Username: $username register successfully, please <a href='login.php' >login</a> again.\n");
                exit;
            } else {echo nl2br("There are something wrong.\n");}
        } catch (PDOException $e) {
            echo $e;
            echo nl2br("There are something wrong (with message).\n"); 
        }
    }
    unset($db); // shutdown database
}
?>

<!DOCTYPE html>
<?php
if (isset($username_err)) echo /*html */ "<p style='color:red;'>$username_err</p>";
if (isset($password_err)) echo /*html */ "<p style='color:red;'>$password_err</p>";
?>
<form method="post">
  <label for="username">User name:</label><br>
  <input type="text" id="username" name="username"><br>

  <label for="psw">Password:</label><br>
  <input type="password" id="psw" name="psw" ><br><br>

  <label for="repsw">Password Comfirm:</label><br>
  <input type="password" id="repsw" name="repsw" ><br><br>

  <input type="submit" value="Register">
</form> 
<p>Having an account? <a href="login.php">Here</a> to login.</p>