<?php
include 'config.inc.php';
include 'assignment2-db-classes.inc.php';

    session_start();
    if (! isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }
    echo "<h1>UserID =" . $_SESSION['user'] . "</h1>";
?>
