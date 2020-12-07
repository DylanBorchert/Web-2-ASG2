<?php


?>
<!DOCTYPE html>
<html lang=en>
<head>
    <title>Lab 14</title>
    <meta charset="utf-8"/>  
    <title>Assignment 02</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital@1&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="/style/reset.css"> -->
    <!-- <link rel="stylesheet" href="/style/index.css"> -->
</head>
<body>
    <img href="images/paintings/square-medium/001020.jpg" alt="image">
    <h2>paintings title</h2>
    <p>add to favorites</p>
    <p>Artist Name</p>
    <p>gallery name, year</p>
    <template id="tabTemplates">
        <section id="Tabs">
        <h2 id="title1">Desciption</h2>
        <h2 id="title2">Details</h2>
        <h2 id="title3">Colors</h2>
        </section>
        <section id="Description">
            <p id="descriptionText"></p>
        </section>
        <section id="Details">
            <p id="Medium"></p>
            <p id="width"></p>
            <p id="height"></p>
            <p id="copyright"></p>
            <a id="wikiLink">Wiki Link</a>
            <a id="museumLink">Museum Link</a>
        </section>
        <section id="Colors">

        </section>
    </template>
    <script src="./single-painting-tab.js"></script>
</body>
<?php

?>