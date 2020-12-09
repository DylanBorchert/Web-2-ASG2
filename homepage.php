<?php
require_once 'config.inc.php';
require_once 'assignment2-db-classes.inc.php'; //!!!!! Some stuff isn't workiing as I tranfer your classes
session_start();
$_SESSION['userFavorites'] = array();

try {
    $connection = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $gate = new CustomerInfoDB($connection);
    //Query For user info to process welcome user section
    $customerInfo = $gate->getCustomerInfo($_SESSION['userID']);
    $connection = null;
} catch (PDOException $e) {
    die($e->getMessage());
}

function displayUserData($customerInfo)
{
    if (isset($customerInfo)) {
        echo "<h2> Welcome " . $customerInfo['FirstName'] . "</h2>";
        echo "<p>" . $customerInfo['FirstName'] . " " . $customerInfo['LastName'] . "</p>" . "<p>" . $customerInfo['City'] . "</p>" . "<p>" . $customerInfo['Country'] . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>COMP 3512 Assign 2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/homepage.css">
</head>
<?php
include("pagenav.inc.php");
?>

<body>
    <main class="container">
        <div class="box h">
            <header>
                <h1>
                    COMP 3512 Assign 2
                </h1>

            </header>
        </div>

        <div class="box WelcomeUser">
            <section>
                <?php
                function processOutputtingFirst15($dataFirst15)
                {
                    echo "<div class='box' id = 'Favorites'>";
                    echo "<h2> Sample Panintings </h2>";
                    echo "<div class = 'showPaintings'>";

                    for ($i = 0; $i < count($dataFirst15); $i++) {
                        if ($i == 0) {
                            echo "<div class = 'middle'> <img src='images/paintings/square-medium/" . $dataFirst15[$i]['ImageFileName'] . ".jpg'/> 
                        " . "<br>" . $dataFirst15[$i]['Title'] . "</div>";
                        }
                        if ($i % 2 && $i != 0) {

                            echo "<div class = 'odd'> <img src='images/paintings/square-medium/" . $dataFirst15[$i]['ImageFileName'] . ".jpg'/> 
                        " . "<br>" . $dataFirst15[$i]['Title'] . "</div>";
                        } else {
                            if ($i != 0) {
                                echo "<div class = 'even'> <img src='images/paintings/square-medium/" . $dataFirst15[$i]['ImageFileName'] . ".jpg'/> 
                            " . "<br>" . $dataFirst15[$i]['Title'] . "</div>";
                            }
                        }
                    }
                }

                displayUserData($customerInfo);
                ?>
            </section>
        </div>
        <div class="box searchFavorite">
            <form action="home-logged-in.php" method="get">

                <input type="text" name="checkSearch" class='searchFavoritesBox'>
                <button type="Submit">Search</button>
        </div>

        </div>
        </form>
        </div>
        <div class="box Results">
            <?php

            if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites'])) {
                $ArtistID = $_SESSION['favorites'][0]['ArtistID'];
                // $YoWStart = getThreshholdStart($_SESSION['favorites'][0]['YearOfWork']);
                //$YoWEnd = getThreshholdEnd($_SESSION['favorites'][0]['YearOfWork']);

            } else {

                try {
                    $conn = DatabaseHelper::createConnection(array(
                        DBCONNSTRING,
                        DBUSER,
                        DBPASS
                    ));

                    $paintingGate = new PaintingsDB($conn);

                    $dataFirst15 = $paintingGate->getTop15();
                    $conn = null;
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
            }


            //if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites']))
            if (count($_SESSION['userFavorites']) > 0) {

                echo "<h2>Paintings You May Like</h2>";

                try {
                    $conn = DatabaseHelper::createConnection(array(
                        DBCONNSTRING,
                        DBUSER,
                        DBPASS
                    ));
                    echo "<div class = 'showPaintings'>";

                    $paintingGate = new PaintingDB($conn);
                    $dataPaitingsMayLike = $paintingGate->getAllForArtistandEraMayLike($ArtistID, $YoWStart, $YoWEnd);
                    $conn = null;
                    for ($i = 0; $i < count($dataPaitingsMayLike); $i++) {
                        if ($i == 0) {
                            echo "<div class = 'middle'> <img src='images/paintings/square-medium/" . $dataPaitingsMayLike[$i]['ImageFileName'] . ".jpg'/> 
                                " . "<br>" . $dataPaitingsMayLike[$i]['Title'] . "</div>";
                        }
                        if ($i % 2 && $i != 0) {

                            echo "<div class = 'odd'> <img src='images/paintings/square-medium/" . $dataPaitingsMayLike[$i]['ImageFileName'] . ".jpg'/> 
                            " . "<br>" . $dataPaitingsMayLike[$i]['Title'] . "</div>";
                        } else {
                            if ($i != 0) {
                                echo "<div class = 'even'> <img src='images/paintings/square-medium/" . $dataPaitingsMayLike[$i]['ImageFileName'] . ".jpg'/> 
                                " . "<br>" . $dataPaitingsMayLike[$i]['Title'] . "</div>";
                            }
                        }
                    }

                    echo "</div>";
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
            }
            ?>

        </div>
        <?php
        if (isset($_GET["checkSearch"])) {
            if (isset($_SESSION['userFavorites']) && !empty($_SESSION['userFavorites'])) {
                echo "<div class='box' id ='Favorites'>";

                foreach ($_SESSION['userFavorites'] as $key => $value) {

                    if ($value['Title'] == $_GET['checkSearch']) {
                        echo "<h2> " . $value['Title'] . "</h2>";
                        echo " <img src='images/paintings/square-medium/" . $value['ImageFileName'] . ".jpg'/ height='700' width='710'>";
                        $imageFound = true;
                        break;
                    } else {
                        $imageFound = false;
                    }
                }
                if (!$imageFound) {
                    echo "<h2>No Result Found<h2> <i> Please Try searching for a Title again! </i></h2>";
                }
            } else {
                echo "<div class='box' id ='Favorites'>";
                echo "<h2> <i> You have no favorites <br>  Please Add to Favorites to use this feature! </i> </h2>";
            }
        } else {

            if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites'])) {

                echo "<div class='box' id ='Favorites'>";
                echo "<h2>Your Favorites</h2>";
                echo "<div class = 'showPaintings'>";

                for ($i = 0; $i < count($_SESSION['favorites']); $i++) {
                    if ($i == 0) {
                        echo "<div class = 'middle'> <img src='images/paintings/square-medium/" . $_SESSION['favorites'][$i]['ImageFileName'] . ".jpg'/> 
                            " . "<br>" . $_SESSION['favorites'][$i]['Title'] . "</div>";
                    }
                    if ($i % 2 && $i != 0) {

                        echo "<div class = 'odd'> <img src='images/paintings/square-medium/" . $_SESSION['favorites'][$i]['ImageFileName'] . ".jpg'/> 
                            " . "<br>" . $_SESSION['favorites'][$i]['Title'] . "</div>";
                    } else {
                        if ($i != 0) {
                            echo "<div class = 'even'> <img src='images/paintings/square-medium/" . $_SESSION['favorites'][$i]['ImageFileName'] . ".jpg'/> 
                                " . "<br>" . $_SESSION['favorites'][$i]['Title'] . "</div>";
                        }
                    }
                }
            } else {
                if (isset($dataFirst15)) {
                    processOutputtingFirst15($dataFirst15);
                }
            }

            echo "</div>";
            echo "</div>";
        }

        ?>
        </div>
    </main>
</body>

</html>
