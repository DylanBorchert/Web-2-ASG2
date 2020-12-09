<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>COMP 3512 Assign 2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/general.css">
    <link rel="stylesheet" href="CSS/index.css">
    <script src="js/general.js"></script>
</head>

<body>
    <?php
    include("pagenav.inc.php");
    ?>

    <main>
        <div>
            <section>
                <button id="login" onclick="location.href='login.php'">Login</button>
                <button id="join">Join</button>
                <button id="searchbutton" type="submit">Search</button>

                <input type="text" name="title" class="searchbox" placeholder="Search BOX FOR Painting ">


            </section>
        </div>
    </main>

    <footer>
        <p class="copyright">© Group Name: Webberinos - Web 2: December 2020</p>



    </footer>


    </div>
    <div class="containerView">
        <template id="paintingViewTemplate">
            <div id="paintingViewImg">
                <figure>
                    <img>
                    <p id="imageSize"><span id="Width"></span> x <span id="Height"></span></p>
                    <figcaption id="Copyright"></figcaption>
                </figure>
            </div>
            <div id="paintingViewText">
                <h2 id="Title"></h2>
                <p id="Artist"></p>
                <p id="Medium"></p>
                <p id="Year"></p>
                <p id="Description"></p>
                <p id="GalleryName"></p>
                <p id="GalleryCity"></p>
                <a id="MuseumLink"></a>
                <div id="colorContainer">
                    <div class="color" id="Colour_1">
                        <p class="name"></p>
                        <p class="hex"></p>
                    </div>
                    <div class="color" id="Colour_2">
                        <p class="name"></p>
                        <p class="hex"></p>
                    </div>
                    <div class="color" id="Colour_3">
                        <p class="name"></p>
                        <p class="hex"></p>
                    </div>
                    <div class="color" id="Colour_4">
                        <p class="name"></p>
                        <p class="hex"></p>
                    </div>
                    <div class="color" id="Colour_5">
                        <p class="name"></p>
                        <p class="hex"></p>
                    </div>
                    <div class="color" id="Colour_6">
                        <p class="name"></p>
                        <p class="hex"></p>
                    </div>
                </div>
                <p id="return"></p>
            </div>
        </template>
        <div id="paintingView"></div>
    </div>
    </div>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRm7Dyqq8GWu-nGW5OhUdc3kq0jacKuds&callback=initMap" type="text/javascript"></script>
</body>