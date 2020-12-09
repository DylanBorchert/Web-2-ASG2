const gallery = [];
let currGallery = "";

document.addEventListener("DOMContentLoaded", function () {
  //let url = "https://www.randyconnolly.com/funwebdev/3rd/api/art/galleries.php";
  let url = "api-galleries.php";

  let listLoader = document.querySelector("#listLoader");
  let paintingLoader = document.querySelector("#paintingLoader");
  let paintViewLoader = document.querySelector("#paintViewLoader");
  let listOfGalleries = document.querySelector("#listOfGalleries");
  const listGalleryHeader = document.querySelector("#listGalleryHeader");
  const listOfGalleriesArea = document.querySelector("#listOfGalleriesArea");
  let mapContainer = document.querySelector("#map");
  let galleryMap = document.querySelector("#galleryMap");
  let galleryInfo = document.querySelector("#galleryInfo");
  let paintings = document.querySelector("#paintings");
  let paintingHeading = document.querySelector("#paintingHeading");
  let paintingArea = document.querySelector("#paintingArea");
  let paintingView = document.querySelector("#paintingView");
  const containerGallery = document.querySelector(".containerGallery");
  const containerView = document.querySelector(".containerView");
  let largePainting = document.querySelector("#LargePainting");

  listLoader.style.display = "block";
  listOfGalleriesArea.style.display = "none";
  fetch(url)
    .then((resp) => resp.json())
    .then((gallery) => {
      gallery.sort((a, b) => {
        return a.GalleryName > b.GalleryName ? 1 : -1;
      });

      const list = document.createElement("ul");
      for (let g of gallery) {
        addMarker(g.Latitude, g.Longitude);
        let item = document.createElement("li");
        item.textContent = g.GalleryName;
        list.appendChild(item);
        listOfGalleriesArea.appendChild(list);
      }

      listOfGalleriesArea.addEventListener("click", (e) => {
        if (e.target.nodeName.toLowerCase() == "li") {
          let map = document.querySelector("#map");
          if (document.documentElement.clientWidth > 950) {
            map.style.height = "56vh";
          }
          let galleryMap = document.querySelector("#galleryMap");
          if (document.documentElement.clientWidth > 950) {
            galleryMap.style.gridRow = "2/3";
            galleryMap.style.gridColumn = "2/3";
          }
          galleryInfo.style.display = "block";
          paintings.style.display = "block";

          let nameList = e.target;
          let galleryInfoList = document.querySelector("#galleryInfoList");
          galleryInfoList.textContent = "";
          let ul = document.createElement("ul");
          galleryInfoList.appendChild(ul);

          for (let g of gallery) {
            // change to find
            if (g.GalleryName == nameList.textContent) {
              //<<<<<<<<<<<<<<<<<<<<<<<< template?
              addLI(`Gallery Name: ${g.GalleryName}`, ul);
              if (g.GalleryName != g.GalleryNativeName) {
                addLI(`Native Name: ${g.GalleryNativeName}`, ul);
              }
              addLI(`Located in: ${g.GalleryCity}, ${g.GalleryCountry}`, ul);
              addLI(`Address: ${g.GalleryAddress}`, ul);

              let listItem = document.createElement("li");
              let link = document.createElement("a");
              link.setAttribute("href", `${g.GalleryWebSite}`);
              link.textContent = "Gallery Web Site";
              listItem.appendChild(link);
              ul.appendChild(listItem);
              //>>>>>>>>>>>>>>>>>>
              changeLocation(g.Latitude, g.Longitude);

              paintingHeading.addEventListener("click", (e) => {
                if (e.target.nodeName == "SPAN") {
                  paintingCall(currGallery, e.target.id);
                }
              });
              paintingCall(g);
            }
          }
        }
      });
      listLoader.style.display = "none";
      listOfGalleriesArea.style.display = "block";
    })
    .catch((error) => console.error("Fetch Error :- " + error));

  let collapseList = document.querySelector("#collapseList");
  let expandList = document.querySelector("#expandList");

  collapseList.addEventListener("click", (e) => {
    listOfGalleries.style.border = "3px solid var(--color-secondary-1)";
    listGalleryHeader.style.display = "none";
    listOfGalleriesArea.style.display = "none";
    if (document.documentElement.clientWidth > 950) {
      containerGallery.style.gridTemplateColumns = "75px 3fr 4fr";
    }
    expandList.style.display = "block";
  });

  expandList.addEventListener("click", (e) => {
    listOfGalleries.style.border = "none";
    listGalleryHeader.style.display = "flex";
    listOfGalleriesArea.style.display = "block";
    if (document.documentElement.clientWidth > 950) {
      containerGallery.style.gridTemplateColumns = "2fr 3fr 4fr";
    }
    expandList.style.display = "none";
  });

  function addLI(content, ul) {
    let listItem = document.createElement("li");
    listItem.value = `${content}`;
    listItem.textContent = content;
    ul.appendChild(listItem);

    return listItem;
  }

  function paintingCall(gallery, sort) {
    currGallery = gallery;
    paintingHeading.style.display = "none";
    paintingArea.style.display = "none";
    paintingLoader.style.display = "block";
    //const galleryLink = `https://www.randyconnolly.com/funwebdev/3rd/api/art/paintings.php?gallery=${gallery.GalleryID}`;
    const galleryLink = `api-paintings.php?galleryid=${gallery.GalleryID}`;
    //const galleryLink = "api-paintings.php";
    console.log(galleryLink);
    fetch(galleryLink)
      .then((response) => response.json())
      .then((paintingList) => {
        paintingArea.textContent = "";
        //console.log(currGallery);
        const sortPaintingList = function sortPaintingList(
          paintingOne,
          paintingTwo
        ) {
          if (paintingOne > paintingTwo) {
            return 1;
          } else if (paintingOne < paintingTwo) {
            return -1;
          } else {
            return 0;
          }
        };

        if (sort == "artist") {
          paintingList.sort((a, b) => sortPaintingList(a.LastName, b.LastName));
        } else if (sort == "title") {
          paintingList.sort((a, b) => sortPaintingList(a.Title, b.Title));
        } else if (sort == "year") {
          paintingList.sort((a, b) =>
            sortPaintingList(a.YearOfWork, b.YearOfWork)
          );
        }

        addHeading(paintingHeading);
        for (let painting of paintingList) {
          let paintingDiv = document.createElement("div");
          paintingArea.appendChild(paintingDiv);
          addSquare(painting, paintingDiv);
          addPaintings(painting, paintingDiv);
        }
        tableClicks(paintingList);
      });
  }

  function addHeading(paintingHeading) {
    paintingHeading.innerHTML = "";
    emptyFlex = document.createElement("span");
    emptyFlex.setAttribute("id", "emptyFlex");
    artist = document.createElement("span");
    artist.setAttribute("id", "artist");
    title = document.createElement("span");
    title.setAttribute("id", "title");
    creationYear = document.createElement("span");
    creationYear.setAttribute("id", "year");

    artist.textContent = "Artist";
    title.textContent = "Title";
    creationYear.textContent = "Year";

    paintingHeading.appendChild(emptyFlex);
    paintingHeading.appendChild(artist);
    paintingHeading.appendChild(title);
    paintingHeading.appendChild(creationYear);
  }

  function addPaintings(painting, node) {
    let artistSpan = document.createElement("span");
    artistSpan.textContent = painting.LastName;
    artistSpan.setAttribute("id", "paintingArtist");

    let titleSpan = document.createElement("span");
    titleSpan.setAttribute("id", "paintingTitle");
    let titleLink = document.createElement("a");
    titleLink.textContent = painting.Title;
    console.log(painting);
    titleLink.setAttribute(
      "href",
      `single-painting-tab.php?paintingid=${painting.PaintingID}`
    );
    titleSpan.appendChild(titleLink);

    let yearSpan = document.createElement("span");
    yearSpan.textContent = painting.YearOfWork;
    yearSpan.setAttribute("id", "paintingYear");

    node.appendChild(artistSpan);
    node.appendChild(titleSpan);
    node.appendChild(yearSpan);
  }

  function addSquare(painting, node, size) {
    console.log("painting" + painting.FullImageFileName + ".jpg was displayed");
    let imageItem = document.createElement("img");
    node.appendChild(imageItem);
    imageItem.setAttribute("width", "100px");
    imageItem.setAttribute(
      "src",
      `../images/paintings/square/${painting.FullImageFileName}`
    );
    paintingLoader.style.display = "none";
    paintingHeading.style.display = "flex";
    paintingArea.style.display = "flex";
  }

  function loadImage(url) {
    img = new Image();
    return new Promise((resolve, reject) => {
      img.addEventListener("load", (e) => resolve(img));
      img.addEventListener("error", () => {
        reject(new Error(`Failed to load image's URL: ${url}`));
      });
      img.src = url;
    });
  }
});

var map;
function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 3,
    center: { lat: 40, lng: -20 },
    styles: [
      {
        featureType: "all",
        elementType: "labels.text.fill",
        stylers: [
          {
            saturation: 36,
          },
          {
            color: "#000000",
          },
          {
            lightness: 40,
          },
        ],
      },
      {
        featureType: "all",
        elementType: "labels.text.stroke",
        stylers: [
          {
            visibility: "on",
          },
          {
            color: "#000000",
          },
          {
            lightness: 16,
          },
        ],
      },
      {
        featureType: "all",
        elementType: "labels.icon",
        stylers: [
          {
            visibility: "off",
          },
        ],
      },
      {
        featureType: "administrative",
        elementType: "geometry.fill",
        stylers: [
          {
            lightness: 20,
          },
        ],
      },
      {
        featureType: "administrative",
        elementType: "geometry.stroke",
        stylers: [
          {
            color: "#000000",
          },
          {
            lightness: 17,
          },
          {
            weight: 1.2,
          },
        ],
      },
      {
        featureType: "administrative.province",
        elementType: "labels.text.fill",
        stylers: [
          {
            color: "#e3b141",
          },
        ],
      },
      {
        featureType: "administrative.locality",
        elementType: "labels.text.fill",
        stylers: [
          {
            color: "#e0a64b",
          },
        ],
      },
      {
        featureType: "administrative.locality",
        elementType: "labels.text.stroke",
        stylers: [
          {
            color: "#0e0d0a",
          },
        ],
      },
      {
        featureType: "administrative.neighborhood",
        elementType: "labels.text.fill",
        stylers: [
          {
            color: "#d1b995",
          },
        ],
      },
      {
        featureType: "landscape",
        elementType: "geometry",
        stylers: [
          {
            color: "#000000",
          },
          {
            lightness: 20,
          },
        ],
      },
      {
        featureType: "poi",
        elementType: "geometry",
        stylers: [
          {
            color: "#000000",
          },
          {
            lightness: 21,
          },
        ],
      },
      {
        featureType: "road",
        elementType: "labels.text.stroke",
        stylers: [
          {
            color: "#12120f",
          },
        ],
      },
      {
        featureType: "road.highway",
        elementType: "geometry.fill",
        stylers: [
          {
            lightness: "-77",
          },
          {
            gamma: "4.48",
          },
          {
            saturation: "24",
          },
          {
            weight: "0.65",
          },
        ],
      },
      {
        featureType: "road.highway",
        elementType: "geometry.stroke",
        stylers: [
          {
            lightness: 29,
          },
          {
            weight: 0.2,
          },
        ],
      },
      {
        featureType: "road.highway.controlled_access",
        elementType: "geometry.fill",
        stylers: [
          {
            color: "#f6b044",
          },
        ],
      },
      {
        featureType: "road.arterial",
        elementType: "geometry",
        stylers: [
          {
            color: "#4f4e49",
          },
          {
            weight: "0.36",
          },
        ],
      },
      {
        featureType: "road.arterial",
        elementType: "labels.text.fill",
        stylers: [
          {
            color: "#c4ac87",
          },
        ],
      },
      {
        featureType: "road.arterial",
        elementType: "labels.text.stroke",
        stylers: [
          {
            color: "#262307",
          },
        ],
      },
      {
        featureType: "road.local",
        elementType: "geometry",
        stylers: [
          {
            color: "#a4875a",
          },
          {
            lightness: 16,
          },
          {
            weight: "0.16",
          },
        ],
      },
      {
        featureType: "road.local",
        elementType: "labels.text.fill",
        stylers: [
          {
            color: "#deb483",
          },
        ],
      },
      {
        featureType: "transit",
        elementType: "geometry",
        stylers: [
          {
            color: "#000000",
          },
          {
            lightness: 19,
          },
        ],
      },
      {
        featureType: "water",
        elementType: "geometry",
        stylers: [
          {
            color: "#0f252e",
          },
          {
            lightness: 17,
          },
        ],
      },
      {
        featureType: "water",
        elementType: "geometry.fill",
        stylers: [
          {
            color: "#080808",
          },
          {
            gamma: "3.14",
          },
          {
            weight: "1.07",
          },
        ],
      },
    ],
  });
}

function addMarker(latValue, lngValue) {
  //custom icon https://developers.google.com/maps/documentation/javascript/examples/marker-symbol-custom
  const myMarker = {
    path:
      "M332.544,337.733c55.548-72.281,84.909-133.231,84.909-176.26C417.453,72.437,345.016,0,255.979,0   C166.942,0,94.505,72.437,94.505,161.474c0,43.364,29.434,104.498,85.12,176.79c30.295,39.33,60.813,72.044,76.333,88.069   C271.523,410.203,302.2,377.217,332.544,337.733z M163.973,159.446c0-50.732,41.273-92.006,92.006-92.006   c50.732,0,92.005,41.273,92.005,92.006s-41.273,92.006-92.005,92.006C205.247,251.452,163.973,210.179,163.973,159.446z",
    fillColor: "#ffb300",
    fillOpacity: 1,
    scale: 0.07,
    strokeColor: "#de9e48",
    strokeWeight: 1,
    // change anchor https://stackoverflow.com/questions/12093327/how-to-align-the-icon-of-a-marker-in-google-map
    anchor: new google.maps.Point(256, 500),
  };
  new google.maps.Marker({
    position: { lat: latValue, lng: lngValue },
    map: map,
    icon: myMarker,
  });
}

function changeLocation(latValue, lngValue) {
  myLatLng = new google.maps.LatLng({ lat: latValue, lng: lngValue });
  map.panTo(myLatLng);
  map.setZoom(18);
}
