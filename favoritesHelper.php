<?php
function displayFavorites($paintingGate)
{
    foreach ($_SESSION['userFavorites'] as $f) {
        $favPainting = $paintingGate->getFavPainting($f);
        echo "<tr id=" . $favPainting['PaintingID'] . ">
            <td><input type='checkbox' id=" . $favPainting['PaintingID'] . " value=" . $favPainting['PaintingID'] . " name='favPainting[]'></td>
      <td><a href='single-painting-tab.php?paintingid=" . $favPainting['PaintingID'] . "'><img src='images/paintings/square-medium/" . $favPainting['ImageFileName'] . ".jpg'></a></td><td><a href='single-painting-tab.php?paintingid=" . $favPainting['PaintingID'] . "'>" . $favPainting['Title'] . "</a></td></tr>";
    }
}

function addFavorite($pID)
{
    array_push($_SESSION['userFavorites'], $pID);
}

function deleteFavorites($array)
{
    foreach ($array as $p) {
        foreach ($_SESSION['userFavorites'] as $userF) {
            if ($userF == $p) {
                echo "<li>$p and $userF are the same. To be deleted</li>";
                $remove = array($userF);
                $_SESSION['userFavorites'] = array_diff($_SESSION['userFavorites'], $remove);
            }
        }
    }
}


//Get painting ID's of the selected paintings
//Remove selected painting's ID's from the 'userFavorites' SESSION array
