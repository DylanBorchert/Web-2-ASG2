<?php

require 'assignment2-db-classes.inc.php';
require 'config.inc.php';
require 'favoritesHelper.php';

session_start();
$conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));


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
    <link rel="stylesheet" href="CSS/reset.css">
    <link rel="stylesheet" href="CSS/default.css">
    <link rel="stylesheet" href="CSS/browse-paintings.css">
    <script type="text/javascript" src="js/browse-paintings.js"></script>

</head>

<body>
    <?php
    include("pagenav.inc.php");
    ?>

    <section id="header">
        <h3>Browse Painting</h3>
    </section>

    <section id="filterBox">
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

                <p>Year:</p>

                <input type="radio" class="rad" id="before" name="year" value="">
                <label for="before">Before</label>
                <input type="text" id="beforeInput" name="beforeInput">
                <br>

                <input type="radio" class="rad" id="after" name="year" value="">
                <label for="after">After</label>
                <input type="text" id="afterInput" name="afterInput">
                <br>

                <input type="radio" class="rad" id="between" name="year" value="">
                <label for="between">Between</label>
                </br>
                <input type="text" id="betweenLow" name="betweenLow">
                <input type="text" id="betweenHigh" name="betweenHigh">
                </br>
                <input type="submit" title="filter" name="filter" value="filter">
                <input type="submit" value="Clear" formaction="./browse-paintings.php">


            </form>
        </div>

        <div id="view">
            <?php

            $baseSQL = "SELECT * FROM Paintings";
            $value = 0;
            if (isset($_GET['title'])) {
                if (!$_GET['title'] == "") {
                    $baseSQL .= " WHERE Title LIKE '%" . $_GET['title'] . "%'";
                    $value++;
                }
            }
            if (isset($_GET['artist'])) {
                if (!$_GET['artist'] == 0) {
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

                    if ($value >= 1) {

                        $baseSQL .= " AND GalleryID = " . $_GET['museum'];
                        $value++;
                    } else {
                        $baseSQL .= " WHERE GalleryID = " . $_GET['museum'];
                        $value++;
                    }
                }
            }
            if (isset($_GET['beforeInput'])) {
                if (!$_GET['beforeInput'] == "") {
                    if ($value >= 1) {
                        $baseSQL .= " AND YearOfWork < " . $_GET['beforeInput'];
                        var_dump($baseSQL);
                        $value++;
                    } else {
                        $baseSQL .= " WHERE YearOfWork < " . $_GET['beforeInput'];
                        $value++;
                    }
                }
            }
            if (isset($_GET['afterInput'])) {
                if (!$_GET['afterInput'] == "") {
                    if ($value >= 1) {
                        $baseSQL .= " AND YearOfWork > " . $_GET['afterInput'];
                        $value++;
                    } else {
                        $baseSQL .= " WHERE YearOfWork > " . $_GET['afterInput'];
                        $value++;
                    }
                }
            }
            if (isset($_GET['betweenLow'])) {
                if (!$_GET['betweenLow'] == "" && !$_GET['betweenHigh'] == "") {
                    if ($value >= 1) {
                        $baseSQL .= " AND YearOfWork > " . $_GET['betweenLow'] . " AND YearOfWork < " . $_GET['betweenHigh'];
                        var_dump($baseSQL);
                        $value++;
                    } else {
                        $baseSQL .= " WHERE YearOfWork > " . $_GET['betweenLow'] . " AND YearOfWork < " . $_GET['betweenHigh'];
                        $value++;
                    }
                }
            }
            if (isset($_GET['title']) or isset($_GET['artist']) or isset($_GET['museum'])) {


                $searchedPaintings = $paint->returnSearch($baseSQL);

            ?>

                <table>
                    <h3>Paintings</h3>
                    <div id="headings">
                        <th></th>
                        <th><span id="head">Artist</span></th>
                        <th><span id="head">Title</span></th>
                        <th><span id="head">Year</span></th>
                    </div>
                    <div id="paintings">
                        <?php
                        foreach ($searchedPaintings as $p) {
                        ?>
                            <tr>
                                <div id="painting">
                                    <td><img src="images/paintings/square-medium/<?= $p['ImageFileName'] ?>.jpg"></td>

                                    <?php
                                    foreach ($artists as $a) {
                                        if ($p['ArtistID'] == $a['ArtistID']) {
                                    ?>
                                            <td>
                                                <p><?= $a['FirstName'] . " " . $a['LastName'] ?></p>
                                            </td>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <td>
                                        <p><?= $p['Title'] ?></p>
                                    </td>
                                    <td>
                                        <p><?= $p['YearOfWork'] ?></p>
                                    </td>
                                    <?php
                                    if (isset($_SESSION['userFavorites'])) {
                                        if (isInFavorites($p['PaintingID']) == true) {
                                            echo "<td><button>Painting Is Favorited</button></td>";
                                        } else {
                                            echo "<td><button><a href='favorites.php?paintingid-search=" . $p['PaintingID'] . "&title=" . $_GET['title'] . "&artist=" . $_GET['artist'] . "&museum=" . $_GET['museum'] . "'>Add To Favorites</a></button></td>";
                                        }
                                    }
                                    echo "<td><button><a href='single-painting-tab.php?paintingid=" . $p['PaintingID'] . "'>View</a></button></td>";
                                    ?>
                            </tr>

                    </div>
                <?php
                        }
                ?>
        </div>
    <?php
            }

    ?>
    </div>
    </div>
    </table>
    <?php

    ?>

    </section>

</body>