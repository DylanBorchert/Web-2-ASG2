<?php
session_start(); //!!!!TALK TO HUDSON
include 'config.inc.php';
include 'assignment2-db-classes.inc.php';

$msg = "Log In";
if (checkForLogin()) {
    try {
        //Check for email
        $connection = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
        $gate = new CustomerLoginDB($connection);
        $data = $gate->getUserName($_POST['email']);
        $connection = null;

        if (isset($data['Pass'])) {
            //Check password
            if (password_verify($_POST['pass'], $data['Pass'])) {
                $_SESSION['userID'] = $data['CustomerID'];
                $_SESSION['userFavorites'] = array();
                header('Location: homepage.php');
                exit();
            } else {
                $msg = "Incorrect Password";
            }
        } else {
            $msg = "Incorrrect Email";
        }
    } catch (Exception $e) {
        die($e->getMessage());
    }
}


function checkForLogin()
{
    if (isset($_POST['email']) && isset($_POST['pass'])) {
        return true;
    } else {
        return false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>A page</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/reset.css">
    <link rel="stylesheet" href="CSS/login.css">
</head>

<body>
    <div class="loginForm">
        <p><?= $msg ?></p>
        <form method="post" action="login.php">
            <label for="email">Email</label>
            <input type="email" name="email">
            </br>
            <label for="password">Password</label>
            <input type="password" name="pass">
            </br>
            <input type="submit" value="Login">
        </form>
    </div>
</body>

</html>