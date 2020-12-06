



document.addEventListener("DOMContentLoaded", function () {
    // let tabTemplates = document.querySelector("#tabTemplates");
    // let tab = tabTemplates.content.cloneNode(true);
    // console.log(tab);

    // tab.querySelector("#Tabs").style.display = "inline-block";
    // tab.querySelector("#Description").style.display = "inline-block";
    // tab.querySelector("#Colors").style.display = "none";
    // tab.querySelector("#Details").style.display = "none";

    // tab.querySelector("#title1").textContent = "Description";
    // tab.querySelector("#title2").textContent = "Details";
    // tab.querySelector("#title3").textContent = "Colors";

    // tab.querySelector("#descriptionText").textContent = "test";

    // tab.querySelector("#Medium").textContent = "test";
    // tab.querySelector("#width").textContent = "test";
    // tab.querySelector("#height").textContent = "test";
    // tab.querySelector("#copyright").textContent = "test";
    // tab.querySelector("#wikiLink").textContent = "test";
    // tab.querySelector("#museumLink").textContent = "test";

    // console.log(tab.querySelector("#copyright"));
    let description = document.querySelector("#Description");
    let color = document.querySelector("#Colors");
    let details = document.querySelector("#Details");

    description.addEventListener("onclick", function(){
        description.style.display = "block";
        color.style.display = "none";
        details.style.display = "none";
    });

    color.addEventListener("onclick", function(){
        description.style.display = "none";
        color.style.display = "block";
        details.style.display = "none";
    });

    details.addEventListener("onclick", function(){
        description.style.display = "none";
        color.style.display = "none";
        details.style.display = "block";
    });
});