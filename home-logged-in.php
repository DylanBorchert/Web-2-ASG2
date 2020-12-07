<?php
//session_start();

require_once 'config.inc.php';
require_once 'db-classes.inc.php';
?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8"/>
      <title>COMP 3512 Assign 2</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="CSS/homeLoggedIn.css" >
   </head>
   <nav class="nav">
        <div class="navlinks">
        <div class="logo">Insert Logo</div>
            <a href="home-logged-in.php">Home/Login</a>
            <a href="about.php">About</a>
            <a href="galleries.php">Galleries</a>
            <a href="browse-paintings.php">Search/Browse</a>
            <a href="single-painting.php">Single Painting</a>
            <a href="favorites.php">Favorites</a>
            <a href="profile.php">Profile</a>
        </div>
        <button class="hamburger">
        
        </button>
    </nav>
   <body>
      <main class="container"> 
         <div class = "box h">
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

    for ($i = 0;$i < count($dataFirst15);$i++)
    {
        if ($i == 0)
        {
            echo "<div class = 'middle'> <img src='/images/art/" . $dataFirst15[$i]['ImageFileName'] . ".jpg'/> 
                        " . "<br>" . $dataFirst15[$i]['Title'] . "</div>";
        }
        if ($i % 2 && $i != 0)
        {

            echo "<div class = 'odd'> <img src='images/art/" . $dataFirst15[$i]['ImageFileName'] . ".jpg'/> 
                        " . "<br>" . $dataFirst15[$i]['Title'] . "</div>";
        }
        else
        {
            if ($i != 0)
            {
                echo "<div class = 'even'> <img src='images/art/" . $dataFirst15[$i]['ImageFileName'] . ".jpg'/> 
                            " . "<br>" . $dataFirst15[$i]['Title'] . "</div>";
            }
        }
    }
}



function displayUserData($dataID)
{
    if (isset($dataID))
    {
        echo "<h2> Welcome " . $dataID[0]['firstname'] . "</h2>";
        echo ("<p>" . $dataID[0]['firstname'] . " " . $dataID[0]['lastname'] . "</p>" . "<p>" . $dataID[0]['city'] . "</p>" . "<p>" . $dataID[0]['country'] . "</p>");
    }
}

if (isset($_SESSION['ID']))
{

    try
    {
        $conn = DatabaseHelper::createConnection(array(
            DBCONNSTRING,
            DBUSER,
            DBPASS
        ));
        $customerGate = new Customer($conn);
        //Query For user info to process welcome user section
        $dataID = $customerGate->getByID($_SESSION['ID']);
        displayUserData($dataID);
        $conn = null;
    }
    catch(PDOException $e)
    {
        die($e->getMessage());
    }

}

?>
            </section>
         </div>
         <div class="box searchFavorite">
         <form action="home-logged-in.php" method="get">  
   
            <input type="text" name = "checkSearch" class = 'searchFavoritesBox'>
            <button type="Submit">Search</button>
        </div>

        </div>   
    </form>     
         </div>
         <div class = "box Results">
             <?php

if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites']))
{
    $ArtistID = $_SESSION['favorites'][0]['ArtistID'];
   // $YoWStart = getThreshholdStart($_SESSION['favorites'][0]['YearOfWork']);
    //$YoWEnd = getThreshholdEnd($_SESSION['favorites'][0]['YearOfWork']);

} else {

try
{
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER,
        DBPASS
    ));

    $paintingGate = new PaintingDB($conn);

    $dataFirst15 = $paintingGate->getTop15();
    $conn = null;
}
catch(PDOException $e)
{
    die($e->getMessage());
}
}


//if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites']))
if (count($_SESSION['favorites']) > 0) 
{

    echo "<h2>Paintings You May Like</h2>";

    try
    {
        $conn = DatabaseHelper::createConnection(array(
            DBCONNSTRING,
            DBUSER,
            DBPASS
        ));
        echo "<div class = 'showPaintings'>";

        $paintingGate = new PaintingDB($conn);
        $dataPaitingsMayLike = $paintingGate->getAllForArtistandEraMayLike($ArtistID, $YoWStart, $YoWEnd);
        $conn = null;
        for ($i = 0;$i < count($dataPaitingsMayLike);$i++)
        {
            if ($i == 0)
            {
                echo "<div class = 'middle'> <img src='images/art/" . $dataPaitingsMayLike[$i]['ImageFileName'] . ".jpg'/> 
                                " . "<br>" . $dataPaitingsMayLike[$i]['Title'] . "</div>";
            }
            if ($i % 2 && $i != 0)
            {

                echo "<div class = 'odd'> <img src='images/art/" . $dataPaitingsMayLike[$i]['ImageFileName'] . ".jpg'/> 
                            " . "<br>" . $dataPaitingsMayLike[$i]['Title'] . "</div>";
            }
            else
            {
                if ($i != 0)
                {
                    echo "<div class = 'even'> <img src='images/art/" . $dataPaitingsMayLike[$i]['ImageFileName'] . ".jpg'/> 
                                " . "<br>" . $dataPaitingsMayLike[$i]['Title'] . "</div>";
                }
            }
        }

        echo "</div>";
    }
    catch(PDOException $e)
    {
        die($e->getMessage());
    }
}
?>

        </div>
             <?php
if (isset($_GET["checkSearch"]))
{
    if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites']))
    {
        echo "<div class='box' id ='Favorites'>";

        foreach ($_SESSION['favorites'] as $key => $value)
        {

            if ($value['Title'] == $_GET['checkSearch'])
            {
                echo "<h2> " . $value['Title'] . "</h2>";
                echo " <img src='images/art/" . $value['ImageFileName'] . ".jpg'/ height='700' width='710'>";
                $imageFound = true;
                break;
            }
            else
            {
                $imageFound = false;
            }
        }
        if (!$imageFound)
        {
            echo "<h2>No Result Found<h2> <i> Please Try searching for a Title again! </i></h2>";

        }
    }
    else
    {
        echo "<div class='box' id ='Favorites'>";
        echo "<h2> <i> You have no favorites <br>  Please Add to Favorites to use this feature! </i> </h2>";
    }

    
}
else
{

    if (isset($_SESSION['favorites']) && !empty($_SESSION['favorites']))
    {

        echo "<div class='box' id ='Favorites'>";
        echo "<h2>Your Favorites</h2>";
        echo "<div class = 'showPaintings'>";

        for ($i = 0;$i < count($_SESSION['favorites']);$i++)
        {
            if ($i == 0)
            {
                echo "<div class = 'middle'> <img src='images/art" . $_SESSION['favorites'][$i]['ImageFileName'] . ".jpg'/> 
                            " . "<br>" . $_SESSION['favorites'][$i]['Title'] . "</div>";
            }
            if ($i % 2 && $i != 0)
            {

                echo "<div class = 'odd'> <img src='images/art" . $_SESSION['favorites'][$i]['ImageFileName'] . ".jpg'/> 
                            " . "<br>" . $_SESSION['favorites'][$i]['Title'] . "</div>";
            }
            else
            {
                if ($i != 0)
                {
                    echo "<div class = 'even'> <img src='images/art" . $_SESSION['favorites'][$i]['ImageFileName'] . ".jpg'/> 
                                " . "<br>" . $_SESSION['favorites'][$i]['Title'] . "</div>";
                }
            }
        }
    }
    else
    {
        if (isset($dataFirst15))
        {
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