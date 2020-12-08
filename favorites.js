document.addEventListener("DOMContentLoaded", function() {

document.getElementById("selectAll").addEventListener("click", selectAll);
document.getElementById("deselectAll").addEventListener("click", deselectAll);

}); 
function selectAll() {
    checkboxes = document.getElementsByName('favPainting[]');
    for(let i=0; i < checkboxes.length; i++) {
        checkboxes[i].checked=true;
      }
}

function deselectAll() {
    checkboxes = document.getElementsByName('favPainting[]');
    
    for(let i=0; i < checkboxes.length; i++) {
        checkboxes[i].checked=false;
      }
}