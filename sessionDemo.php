<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>

<body>

    <?php
    //Test Painting ID's.
    $_SESSION['userFavorites'] = array();
    array_push($_SESSION['userFavorites'], 23);
    array_push($_SESSION['userFavorites'], 5);
    array_push($_SESSION['userFavorites'], 39);
    array_push($_SESSION['userFavorites'], 41);
    array_push($_SESSION['userFavorites'], 37);
    addFavorite(48);
    addFavorite(46);
    ?>

</body>

</html>