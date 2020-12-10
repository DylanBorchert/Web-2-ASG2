<?php
require_once 'config.inc.php';
require_once 'assignment2-db-classes.inc.php';
require_once 'favoritesHelper.php';
session_start();
//var_dump($_SESSION['userFavorites']);
try {
    $connection = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));
    $gate = new CustomerInfoDB($connection);
    $paintingGate = new PaintingsDB($connection);
    //Query For user info to process welcome user section
    $customerInfo = $gate->getCustomerInfo($_SESSION['userID']);
    $connection = null;
} catch (PDOException $e) {
    die($e->getMessage());
}

function displayUserData($customerInfo)
{
    echo "<h1>User Info: </h1>";
    echo "<br>";
    if (isset($customerInfo)) {
        echo "<h2> Welcome " . $customerInfo['FirstName'] . "</h2>";
        echo "<br>";
        echo "<p> Name: " . $customerInfo['FirstName'] . " "  . $customerInfo['LastName'] . "<br>" . "</p>" . "<p> City: " . $customerInfo['City'] . "<br>" . "</p>" . "<p> Country: " . $customerInfo['Country'] . "</p>";
    }
}

if (isset($_POST['title'])) {
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
    <link rel="stylesheet" href="CSS/reset.css">
    <link rel="stylesheet" href="CSS/homepage.css">
</head>
<?php
include("pagenav.inc.php");
?>

<body>
    <main class="container">

        <div class="box WelcomeUser">
            <section>
                <?php
                function processOutputtingFirst15($dataFirst15)
                {
                    echo "<div class='box' id = 'Favorites'>";
                    echo "<h2> Paintings You May Like </h2>";
                    echo "<br>";
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
                //processOutputtingFirst15($dataFirst15);
                ?>
            </section>
        </div>
        <div class="box searchFavorite">
            <form method="post">
                <input type="text" name="title" class="searchbox" placeholder="Search By Painting Title ">
                <input type="submit" name="search" value="Search" />
        </div>

        </div>
        </form>
        </div>
        <div class="box Results">
            <?php

            if (isset($_SESSION['userFavorites']) && !empty($_SESSION['userFavorites'])) {

                echo "<h2>Favorite Paintings</h2>";
                displayHomeFavorites($paintingGate);
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

            if (isset($_SESSION['favorites'])) {

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
                    //processOutputtingFirst15($dataFirst15);
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