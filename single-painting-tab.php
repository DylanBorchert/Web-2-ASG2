<?php

require 'assignment2-db-classes.inc.php';
require "config.inc.php";

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
} else echo "broken";

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
    <!-- <link rel="stylesheet" href="/asg2/Web-2-ASG-2/style/reset.css">  -->
    <link rel="stylesheet" href="style/index.css">
    <link rel="stylesheet" href="style/single-painting-tab.css">
    <script src="single-painting-tab.js"></script>
</head>

<body>
    <div id="header">
        <img style="max-height:400px" src="f2020-assign2/images/paintings/square/<?= $painting['FullImageFileName'] ?>" alt="<?= $painting['FullImageFileName'] ?>">
        <div id="info">
            <h3><?= $painting['Title'] ?></h3>
            <p>add to favorites</p>
            <p><?= $artist['FirstName'] . " " . $artist['LastName'] ?></p>
            <p><?= $museum['GalleryName'] . " Year: " . $painting['YearOfWork'] ?></p>
        </div>
    </div>
    <!-- <template id="tabTemplates"> -->
    <div id="header">
        <section id="Tabs">
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
            // foreach($painting['Color'] as $p){
            //     echo "$p";

            // }
            ?>
        </section>
        <!-- </template> -->
    </div>
</body>
<?php

?>