<!-- 
This page uses php sql javascript and html for its functionality, the javascript
is fairly important as it allows us to use event handlers for the description,
details and colors.  The rest of the page is formatted using html and php to 
access the database and run sql queries from assignment-2-db-classes.php
to keep and run the querries when the information is returned it is a simple 
process of using php to call the right data from the array given to us from the 
database and then putting it in the right sections.     
 -->

<?php

// This calls for all the information from the database we will need later 
// checking if any passed variables exist before searching for them as 
// they can cause errors if not handled properly.  
require 'assignment2-db-classes.inc.php';
require "config.inc.php";
require 'favoritesHelper.php';
session_start();
$conn = DatabaseHelper::createConnection(array(
    DBCONNSTRING,
    DBUSER, DBPASS
));

if (isset($_GET['paintingid'])) {
    $paint = new PaintingsDB($conn);
    $painting = $paint->getPainting($_GET['paintingid']);

    $art = new ArtistDB($conn);
    $artist = $art->getArtist($painting['ArtistID']);

    $mues = new GalleriesDB($conn);
    $museum = $mues->getGallery($painting['GalleryID']);

    $paintingJson = $painting['JsonAnnotations'];
    $pJson = json_decode($paintingJson, true);
} 

?>
<!DOCTYPE html>
<html lang=en>

<head>
    <title>single painting</title>
    <meta charset="utf-8" />
    <title>Assignment 02</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/galleries.css">
    <link rel="stylesheet" href="style/reset.css">
    <link rel="stylesheet" href="CSS/single-painting-tab.css">
    <script src="js/single-painting-tab.js"></script>
</head>


<!-- this file uses javascript as a means of hiding and displaying the different
divs for description, details and colors. It makes use of event handlers to do so.  -->


<body>
    <?php
    include("pagenav.inc.php");
    /*  THis include runs the nav bar creation code it made sense to use includes as
    it is callled more than once and this makes it accessable in each file.*/
    ?>
    
            <div id="header" class="section" >
                <img style="max-height:400px" src="images/paintings/square/<?= $painting['FullImageFileName'] ?>" alt="<?= $painting['FullImageFileName'] ?>">
                <div id="info">
                    <h3><?= $painting['Title'] ?></h3>
                    <?php
// checks to see if the favourites session exists and by extention, checking if the user is logged in                     
        if (isset($_SESSION['userFavorites'])) {
            if (isInFavorites($painting['PaintingID']) == true) {
                echo "<button>Painting Is Favorited</button>";
            } else {
                echo "<button><a href='favorites.php?paintingid=" . $painting['PaintingID'] . "'>Add To Favorites</a></button>";
            }
        }
        ?>
                    <p><?= $artist['FirstName'] . " " . $artist['LastName'] ?></p>
                    <p><?= $museum['GalleryName'] . " Year: " . $painting['YearOfWork'] ?></p>
                </div>
            </div>
            
            <div id="header">
                <section id="Tabs">
<!-- This is the actual tabs that can be clicked each tab has its own information
where it is inside a div to keep the info organized.  -->
                    <h2 id="title1">Desciption</h2>
                    <h2 id="title2">Details</h2>
                    <h2 id="title3">Colors</h2>
                </section>
                <section id="Description" style="display:block">
                    <p id="descriptionText"><?= $painting['Description'] ?></p>
                </section>
                <section id="Details" style="display:none">
                    <p id="Medium">Medium: <?= $painting['Medium'] ?></p>
                    <p id="width">Width: <?= $painting['Width'] ?></p>
                    <p id="height">Height: <?= $painting['Height'] ?></p>
                    <p id="copyright">Copyright: <?= $painting['CopyrightText'] ?></p>
                    <a id="wikiLink" href="<?= $painting['WikiLink'] ?>">Wiki Link</a>
                    <a id="museumLink" href="<?= $painting['MuseumLink'] ?>">Museum Link</a>
                </section>
                <section id="Colors" style="display:none">
                    <?php
 // this is the php to get into the colors array and go through each color printing the 
 //name and hex while also providing a background color of that same color.  
                    echo "<div id='colorContainer'>";
                    foreach ($pJson['dominantColors'] as $p) {
                        echo "<div class='color' style='background-color:" . $p['web'] . "' id='Colour_1'><p class='name'>" . $p['name'] . "</p><p class='hex'>" . $p['web'] . "</p></div>";
                    }
                    echo "</div><p id='return'></p>"

                    ?>
                </section>
          
        </body>
        <?php

        ?>