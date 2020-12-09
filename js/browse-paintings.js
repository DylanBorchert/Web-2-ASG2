document.addEventListener("DOMContentLoaded", function() {
 console.log("EEEEEEEEEEEEEEEEEEEEEs");
    document.getElementById("before").addEventListener("click", selectAll);
    document.getElementById("after").addEventListener("click", selectAll);
    document.getElementById("between").addEventListener("click", selectAll);
    }); 
    function selectAll() {
        console.log("EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE");
        radios = document.getElementsByName('year');
        for(let i=0; i < radios.length; i++) {
            if (radios[i].checked=false) {
                console.log("EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE");
            }
          }
    }
  