const gallery = [];
let currGallery = "";

document.addEventListener("DOMContentLoaded", function () {
  //  let url = "https://www.randyconnolly.com/funwebdev/3rd/api/art/galleries.php";
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
          map.style.height = "56vh";
          let galleryMap = document.querySelector("#galleryMap");
          galleryMap.style.gridRow = "2/3";
          galleryMap.style.gridColumn = "2/3";
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
    containerGallery.style.gridTemplateColumns = "75px 3fr 4fr";
    expandList.style.display = "block";
  });

  expandList.addEventListener("click", (e) => {
    listOfGalleries.style.border = "none";
    listGalleryHeader.style.display = "flex";
    listOfGalleriesArea.style.display = "block";
    containerGallery.style.gridTemplateColumns = "2fr 3fr 4fr";
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

        if (sort == "paintHeadArtist") {
          paintingList.sort((a, b) => sortPaintingList(a.LastName, b.LastName));
        } else if (sort == "paintHeadTitle") {
          paintingList.sort((a, b) => sortPaintingList(a.Title, b.Title));
        } else if (sort == "paintHeadYear") {
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
      });
  }

  function addHeading(paintingHeading) {
    paintingHeading.innerHTML = "";
    emptyFlex = document.createElement("span");
    emptyFlex.setAttribute("id", "emptyFlex");
    artist = document.createElement("span");
    artist.setAttribute("id", "paintHeadArtist");
    title = document.createElement("span");
    title.setAttribute("id", "paintHeadTitle");
    creationYear = document.createElement("span");
    creationYear.setAttribute("id", "paintHeadYear");

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
    console.log("painting" + painting.ImageFileName + ".jpg was displayed");
    let imageItem = document.createElement("img");
    node.appendChild(imageItem);
    imageItem.setAttribute("width", "100px");
    imageItem.setAttribute(
      "src",
      `f2020-assign2/images/paintings/square/${painting.FullImageFileName}`
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

addListeners = () => {
        document.querySelector("#login").addEventListener('click', (e) => login(e));
        document.querySelector("#join").addEventListener('click', (e) => join(e));
}

login = e => {
    console.log("Login Clicked!");
}

join = e => {
    console.log("Join Clicked!")
}