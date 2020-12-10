<?php
function displayFavorites($paintingGate)
{
    foreach ($_SESSION['userFavorites'] as $f) {
        $favPainting = $paintingGate->getFavPainting($f);
        echo "<tr id=" . $favPainting['PaintingID'] . ">
            <td><input type='checkbox' class='checkboxes' id=" . $favPainting['PaintingID'] . " value=" . $favPainting['PaintingID'] . " name='favPainting[]'></td>
      <td><a href='single-painting-tab.php?paintingid=" . $favPainting['PaintingID'] . "'><img src='images/paintings/square-medium/" . $favPainting['ImageFileName'] . ".jpg'></a></td><td><a href='single-painting-tab.php?paintingid=" . $favPainting['PaintingID'] . "'>" . $favPainting['Title'] . "</a></td></tr>";
    }
}
function displayHomeFavorites($paintingGate)
{
    foreach ($_SESSION['userFavorites'] as $f) {
        $favPainting = $paintingGate->getFavPainting($f);
        echo "<tr id=" . $favPainting['PaintingID'] . ">
      <td><a href='single-painting-tab.php?paintingid=" . $favPainting['PaintingID'] . "'><img src='images/paintings/square-medium/" . $favPainting['ImageFileName'] . ".jpg'></a></td></tr>";
    }
}
function addFavorite($pID)
{
    $duplicate = false;
    foreach ($_SESSION['userFavorites'] as $f) {
        if ($f == $pID) {
            $duplicate = true;
        }
    }
    if ($duplicate == false) {
        array_push($_SESSION['userFavorites'], $pID);
    }
}
function isInFavorites($pID)
{
    $duplicate = false;
    foreach ($_SESSION['userFavorites'] as $f) {
        if ($f == $pID) {
            return true;
        }
    }
    return false;
}

function deleteFavorites($array)
{
    foreach ($array as $p) {
        foreach ($_SESSION['userFavorites'] as $userF) {
            if ($userF == $p) {
                $remove = array($userF);
                $_SESSION['userFavorites'] = array_diff($_SESSION['userFavorites'], $remove);
            }
        }
    }
}

function getJson()
{
}
