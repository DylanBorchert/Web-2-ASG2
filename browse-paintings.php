<?php

require 'assignment2-db-classes.inc.php';
require 'config.inc.php';
require 'favoritesHelper.php';

$conn = DatabaseHelper::createConnection(array(
    DBCONNSTRING,
    DBUSER, DBPASS
));


// $paint = new PaintingsDB($conn);
// $painting = $paint->getPainting($_GET['paintingid']);

$art = new ArtistDB($conn);
$artists = $art->getAllArtist();

$gal = new GalleriesDB($conn);
$galleries = $gal->getAll();

$paint = new PaintingsDB($conn);
$paintings = $paint->getAll();
?>

<!DOCTYPE html>
<html lang=en>

<head>
    <title>browse painting</title>
    <meta charset="utf-8" />
    <title>Assignment 02</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital@1&display=swap" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="/asg2/Web-2-ASG-2/style/reset.css">  -->
    <!-- <link rel="stylesheet" href="/asg2/Web-2-ASG2/style/index.css">
    <link rel="stylesheet" href="/asg2/Web-2-ASG2/style/browse-paintings.css"> -->

</head>

<body>
    <?php
    include("pagenav.inc.php");
    ?>


    <table>
        <tr>
            <section id="header">
                <h3>Browse Painting</h3>
            </section>
        </tr>
        <tr>
            <td>
                <div id="filter">
                    <form action="./browse-paintings.php" method="get">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title"><br>

                        <label>Artist: </label>
                        <select class="ui fluid dropdown" name="artist">
                            <option value='0'>Select Artist</option>
                            <?php
                            // output all the retrieved galleries (hint: set value attribute of <option> to the GalleryID field)
                            foreach ($artists as $a) {
                            ?>
                                <option value="<?= $a['ArtistID'] ?>"><?= $a['FirstName'] . " " . $a['LastName'] ?></option>
                            <?php
                            }
                            ?>
                        </select><br>

                        <label>Gallery: </label>
                        <select class="ui fluid dropdown" name="museum">
                            <option value='0'>Select Museum</option>
                            <?php
                            // output all the retrieved galleries (hint: set value attribute of <option> to the GalleryID field)
                            foreach ($galleries as $g) {
                            ?>
                                <option value="<?= $g['GalleryID'] ?>"><?= $g['GalleryName'] ?></option>
                            <?php
                            }
                            ?>
                        </select><br>
                        <table>
                            <tr>
                                <p>Year:</p>
                            </tr>
                            <tr>
                                <input type="radio" id="before" name="year" value="before">
                                <label for="before">Before</label>
                                <input type="text" id="beforeInput" name="beforeInput">
                                <br>
                            </tr>
                            <tr>
                                <input type="radio" id="after" name="year" value="after">
                                <label for="after">After</label>
                                <input type="text" id="afterInput" name="afterInput">
                                <br>
                            </tr>
                            <tr>
                                <input type="radio" id="Between" name="year" value="between">
                                <label for="between">Between</label>
                                <input type="text" id="betweenLow" name="betweenLow">
                                </br>
                            </tr>
                            <tr>
                                <input type="text" id="betweenHigh" name="betweenHigh">
                                </br>
                                <input type="submit" title="filter" name="filter" value="filter">
                                <input type="reset" title="clear" name="clear" value="clear">
                            </tr>
                        </table>
                    </form>
                </div>
            </td>
            <td>
                <div id="view">
                    <?php

                    $baseSQL = "SELECT * FROM paintings";
                    $value = 0;
                    if (isset($_GET['title'])) {
                        if (!$_GET['title'] == "") {
                            $baseSQL .= " WHERE Title = '" . $_GET['title'] . "'";
                            $value++;
                        }
                    }
                    if (isset($_GET['artist'])) {
                        if (!$_GET['artist'] == 0) {
                            //$baseSQL .= " WHERE ArtistID = '" . $_GET['artist'] . "' AND";
                            if ($value == 1) {
                                $baseSQL .= " AND ArtistID = " . $_GET['artist'];
                                $value++;
                            } else {
                                $baseSQL .= " WHERE ArtistID = " . $_GET['artist'];
                                $value++;
                            }
                        }
                    }
                    if (isset($_GET['museum'])) {
                        if (!$_GET['museum'] == 0) {

                            //$baseSQL .= " WHERE Title GalleryID = '" . $_GET['museum'] . `'`;
                            if ($value >= 1) {

                                $baseSQL .= " AND GalleryID = " . $_GET['museum'];
                                $value++;
                            } else {
                                $baseSQL .= " WHERE GalleryID = " . $_GET['museum'];
                                $value++;
                            }
                        }
                    }
                    if (isset($_GET['title']) or isset($_GET['artist']) or isset($_GET['museum'])) {

                        // $searchedPaintings;
                        // $statement = DatabaseHelper::runQuery($conn, $baseSQL, null);
                        // $searchedPaintings = $statement->fetchAll();

                        $searchedPaintings = $paint->returnSearch($baseSQL);

                    ?>
                        <div>
                            <h3>Paintings</h3>
                            <div id="headings">
                                <span id="head">Artist</span>
                                <span id="head">Title</span>
                                <span id="head">Year</span>
                            </div>
                            <div id="paintings">
                                <?php
                                echo "here";
                                foreach ($searchedPaintings as $p) {
                                ?>
                                    <div id="painting">
                                        <img id="squareImage" src="/images/paintings/square/<?= $p['ImageFileName'] ?>">
                                        <!-- find artist name -->
                                        <p><?= $p['Title'] ?></p>
                                        <p><?= $p['YearOfWork'] ?></p>
                                        <?php if (isset($_GET['addedSearch'])) {
                                            echo "<button>Painting Is Favorited</button>";
                                        } else {
                                            echo "<button><a href='favorites.php?paintingid-search=" . $p['PaintingID'] . "&title=" . $_GET['title'] . "&artist=" . $_GET['artist'] . "&museum=" . $_GET['museum'] . "'>Add To Favorites</a></button>";
                                        }
                                        echo "<button><a href='single-paintin.php?paintingid=" . $p['PaintingID'] . "'>View</a></button>";
                                        ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
            </td>
        </tr>
    </table>


</body>