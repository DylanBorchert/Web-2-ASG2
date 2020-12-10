<?php
if (isset($_POST['login'])) {
    header('Location: login.php');
} else if (isset($_POST['title'])) {
    header('Location: browse-paintings.php?title=' . $_POST['title'] . "&artist=0&museum=0&filter=filter");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>COMP 3512 Assign 2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/general.css">
    <link rel="stylesheet" href="CSS/index.css">
    <script src="js/general.js"></script>
</head>

<body>
    <?php
    include("pagenav.inc.php");
    ?>

    <main>
        <div id="indexhome">
            <form method="post">
                <input type="submit" name="login" value="Login" />
                <input type="submit" name="search" value="Search" />
                <input type="text" name="title" class="searchbox" placeholder="Search By Painting Title ">
            </form>
        </div>
    </main>

    <footer>
        <p class="copyright">© Group Name: Webberinos - Web 2: December 2020</p>

    </footer>
</body>