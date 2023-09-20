<?php 
session_start();
require_once "pdo.php";
$salt = 'XyZzy12*_';


if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    unset($_SESSION['user_id']);
    unset($_SESSION['name']);

    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['error'] = "Email and password are required";
        header("Location: login.php");
        return;
    }
    else if (strpos($_POST['email'], "@") === false){
        $_SESSION['error'] = "Email must contain @";
        header("Location: login.php");
        return;
    }
    else {
        $check = hash('md5', $salt.$_POST['pass']);

        $stmt = $pdo->prepare('SELECT user_id, name FROM users
            WHERE email = :em AND password = :pw');
        $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ( $row !== false ) {
            $_SESSION['name'] = $row['name'];
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: index.php");
            return;
        }
        else {
            $_SESSION['error'] = "Incorrect password";
            error_log("Login fail ".$_POST['email']." $check");
            header("Location: login.php");
            return;
        }
    }
}


?>
<!DOCTYPE html>
<html>
<head>
<title>Muhammad Bilal Khan's Login Page</title>
</head>
<script type = "text/JavaScript" src = "validate.js"></script>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php

if ( isset($_SESSION['error'])) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>
<form method="POST">
<label for="name">User Name</label>
<input type="text" name="email" id="name"><br/>
<label for="password">Password</label>
<input type="password" name="pass" id="password"><br/>
<input type="submit" onclick="return doValidate();" value="Log In">
<a href="index.php">Cancel</a>
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is php123. -->
</p>
</div>
</body>