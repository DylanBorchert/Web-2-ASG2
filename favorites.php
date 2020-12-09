<?php
//If the credentials entered by the user are valid, the server creates a new session. 
//The server generates a unique random number, which is called a session id. 
//It also creates a new file on the server which is used to store the session-specific information.
require_once 'config.inc.php';
require_once 'assignment2-db-classes.inc.php';
require_once 'favoritesHelper.php';
require_once 'sessionDemo.php';
$connection = DatabaseHelper::createConnection([DBCONNSTRING, DBUSER, DBPASS]);
// now retrieve galleries 
$galleryGate = new GalleriesDB($connection);
$paintingGate = new PaintingsDB($connection);
$galleries = $galleryGate->getAll();
$paintings = $paintingGate->getAll();
?>

<!DOCTYPE html>
<html>

<head>
  <script type="text/javascript" src="js/favorites.js"></script>
  <meta charset="utf-8" />
  <title>COMP 3512 Assign 2</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="CSS/reset.css">
  <link rel="stylesheet" href="CSS/homepage.css">
</head>

<body>
  <?php
  include("pagenav.inc.php");
  ?>
  <?php
  if (isset($_GET['paintingid'])) {
    addFavorite($_GET['paintingid']);
    header("Location: single-painting-tab.php?paintingid=" . $_GET['paintingid'] . "&added=yes");
  }
  if (isset($_GET['paintingid-search'])) {
    addFavorite($_GET['paintingid']);
    header("Location: favorites.php?paintingid-search=" . $p['PaintingID'] . "&title=" . $_GET['title'] . "&artist=" . $_GET['artist'] . "&museum=" . $_GET['museum']);
  }
  //Array of paintings selected to be deleted.
  $selectedP = array();


  //Populate selectedP with paintings that are checked to be removed when the "Remove Favorite" button is pressed. 
  if (!empty($_POST["favPainting"])) {
    foreach ($_POST['favPainting'] as $sp) {
      $selectedP[] = $sp;
      deleteFavorites($selectedP);
    }
  }

  //Clear the selected paintings array. 
  $selectedP = array();
  ?>

  <button id="selectAll" name="selectAll">Select All</button>
  <button id="deselectAll" name="deselectAll">Deselect All</button>
  <table>
    <tr>
      <th>Check To Remove</th>
      <th>Painting</th>
      <th>Title</th>
    </tr>
    <form action="" method="post">
      <button name="formSubmit" type="submit" value="paintingID">Remove From Favorites</button>
      <?php

      //Array of paintings that are checked 
      //to be removed from the userFavorites SESSION array.
      $pToRemove = array();

      //Set checkboxs to unchecked.
      $allSelected = false;

      //If user has favorites, Display them.
      if (count($_SESSION['userFavorites']) > 0) {
        //Generate Favorites List.
        displayFavorites($paintingGate);
      } else {
        //User Has No Favorites Yet.
        echo "<p>Your Favorite Paintings Will Appear Here When You Find Them!</p>";
      }
      //Remove Current Session Data.
      session_unset();
      ?>
    </form>
  </table>
</body>

</html>