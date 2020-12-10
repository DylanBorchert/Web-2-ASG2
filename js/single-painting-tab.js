



document.addEventListener("DOMContentLoaded", function () {

    let descriptionTitle = document.querySelector("#title1");
    let detailsTitle = document.querySelector("#title2");
    let colorTitle = document.querySelector("#title3");

    let description = document.querySelector("#Description");
    let details = document.querySelector("#Details");
    let color = document.querySelector("#Colors");



    descriptionTitle.addEventListener("click", function(){
        description.style.display = "block";
        color.style.display = "none";
        details.style.display = "none";
    });

    colorTitle.addEventListener("click", function(){
        description.style.display = "none";
        color.style.display = "block";
        details.style.display = "none";
    });

    detailsTitle.addEventListener("click", function(){
        description.style.display = "none";
        color.style.display = "none";
        details.style.display = "block";
    });
});