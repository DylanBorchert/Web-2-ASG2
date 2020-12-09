document.addEventListener("DOMContentLoaded", function() {
    checkRadios();
    document.getElementById("before").addEventListener("click", checkRadios);
    document.getElementById("after").addEventListener("click", checkRadios);
    document.getElementById("between").addEventListener("click", checkRadios);
    }); 
    
    function checkRadios() {
        let bI = document.getElementById("beforeInput");
        let aI = document.getElementById("afterInput");
        let betweenL = document.getElementById("betweenLow");
        let betweenH = document.getElementById("betweenHigh"); 
        radios = document.getElementsByName('year');
        
        for(let i=0; i < radios.length; i++) {
            if (radios[i].checked==false) {
              if (radios[i].getAttribute("id") == "before") {
                bI.setAttribute("disabled", "disabled");
                bI.value = "";
              }
              if (radios[i].getAttribute("id") == "after") {
                aI.setAttribute("disabled", "disabled");
                aI.value = "";
              }
              if (radios[i].getAttribute("id") == "between") {
                betweenL.setAttribute("disabled", "disabled");
                betweenL.value = "";
                betweenH.setAttribute("disabled", "disabled"); 
                betweenH.value = ""; 
              }
            } 
            if (radios[i].checked==true) {
                if (radios[i].getAttribute("id") == "before") {
                  bI.removeAttribute("disabled");
                }
                if (radios[i].getAttribute("id") == "after") {
                  aI.removeAttribute("disabled");
                }
                if (radios[i].getAttribute("id") == "between") {
                  betweenL.removeAttribute("disabled");
                  betweenH.removeAttribute("disabled");  
                }
              }
          }
    }
  