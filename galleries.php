<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>COMP 3512 Assign 2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/reset.css">
    <link rel="stylesheet" href="CSS/galleries.css">
    <script src="JS/galleries.js"></script>
</head>

<body>
    <?php
    include("pagenav.inc.php");
    ?>
    <div class="container">

        <div class="containerGallery">

            <div id="listOfGalleries">
                <div id="expandList">
                    <svg>
                        <path d="M 48.6875 23.84375 L 25.34375 0.5 C 25.011719 0.167969 24.628906 0 24.191406 0 C 23.757812 0 23.375 0.167969 23.042969 0.5 L 20.535156 3.003906 C 20.203125 3.339844 20.035156 3.722656 20.035156 4.15625 C 20.035156 4.59375 20.203125 4.976562 20.535156 5.308594 L 40.222656 24.996094 L 20.539062 44.679688 C 20.203125 45.015625 20.035156 45.398438 20.035156 45.832031 C 20.035156 46.265625 20.203125 46.652344 20.539062 46.984375 L 23.042969 49.488281 C 23.375 49.824219 23.757812 49.988281 24.191406 49.988281 C 24.628906 49.988281 25.011719 49.820312 25.34375 49.488281 L 48.6875 26.148438 C 49.019531 25.8125 49.1875 25.429688 49.1875 24.996094 C 49.1875 24.5625 49.019531 24.175781 48.6875 23.84375 Z M 48.6875 23.84375 " />
                        <path d="M 29.953125 24.996094 C 29.953125 24.5625 29.785156 24.175781 29.453125 23.84375 L 6.109375 0.5 C 5.777344 0.167969 5.394531 0 4.960938 0 C 4.523438 0 4.140625 0.167969 3.808594 0.5 L 1.304688 3.003906 C 0.96875 3.339844 0.800781 3.722656 0.800781 4.15625 C 0.800781 4.59375 0.96875 4.976562 1.304688 5.308594 L 20.988281 24.996094 L 1.304688 44.679688 C 0.96875 45.015625 0.800781 45.398438 0.800781 45.832031 C 0.800781 46.265625 0.96875 46.652344 1.304688 46.984375 L 3.808594 49.488281 C 4.140625 49.824219 4.523438 49.988281 4.957031 49.988281 C 5.394531 49.988281 5.777344 49.820312 6.109375 49.488281 L 29.453125 26.148438 C 29.785156 25.8125 29.953125 25.429688 29.953125 24.996094 Z M 29.953125 24.996094 " />
                    </svg>
                </div>
                <div id="listGalleryHeader">
                    <h1>Pick A Gallery</h1>
                    <div id="collapseList">
                        <svg>
                            <path d="M 12.132812 1.769531 L 10.367188 0 L 2.867188 7.5 L 10.367188 15 L 12.132812 13.230469 L 6.402344 7.5 Z M 12.132812 1.769531  " />
                        </svg>
                    </div>
                </div>
                <div class="lds-roller" id="listLoader">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div id="listOfGalleriesArea"></div>
            </div>

            <div id="galleryInfo">
                <div id="galleryInfoList"></div>
            </div>

            <div id="galleryMap">
                <div id="map"></div>
            </div>

            <div id="paintings">
                <div class="lds-roller" id="paintingLoader">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div id="paintingHeading"></div>
                <div id="paintingArea">
                </div>
            </div>

        </div>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRm7Dyqq8GWu-nGW5OhUdc3kq0jacKuds&callback=initMap" type="text/javascript"></script>
</body>

</html>