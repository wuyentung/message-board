<?php
// Initialize the session
session_start();

include "account_utils.php";
echo nl2br(/*html */"<h1>Login Page</h1>\n");
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../home-page/welcome.php");
    exit;
}

// check authentication
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    $username_err = validate_username($_POST["username"]);
    if (!isset($username_err)) {
        require_once "../config/dbConfig.php";
        $srch_query = "SELECT u_id, username, psw FROM users WHERE username = ?";
        $srch_stmt = $db->prepare($srch_query);
        $srch_stmt->execute([$_POST["username"]]);
        $result = $srch_stmt->fetch(PDO::FETCH_OBJ);
        $username = $result->username;
        $psw = $result->psw;
        $u_id = $result->u_id;
        unset($db); // shutdown database

        if (!isset($username)) {
            $username_err = nl2br("Username ${_POST["username"]} not exist, please checkout your username and password one more time\n");
        }
        if(password_verify($_POST["psw"], $psw)){
            // Password is correct, so start a new session
            session_start();
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["u_id"] = $u_id;
            $_SESSION["username"] = $username;
            // Redirect user to welcome page
            unset($db); // shutdown database
            header("location: welcome.php");
        } else { // password incorrect
            $password_err = nl2br("Invalid password, please checkout your username and password one more time\n");
        }
    }
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

  <input type="submit" value="login">
</form> 
<p>Don't have an account? <a href="register.php">Sign up now</a>.</p>