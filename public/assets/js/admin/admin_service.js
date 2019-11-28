
		function show_modal_delete_service($id){
         var xhttp = new XMLHttpRequest();
         xhttp.onreadystatechange = function() {
             if (xhttp.readyState == 4 && xhttp.status == 200) {
                document.getElementById("load_modal_delete_service").innerHTML = xhttp.responseText;
            }
         };

         xhttp.open("GET", "/admin/services/"+$id , true);
         xhttp.send();
     
}

function show_modal_show_service($id){
         var xhttp = new XMLHttpRequest();
         xhttp.onreadystatechange = function() {
             if (xhttp.readyState == 4 && xhttp.status == 200) {
                document.getElementById("load_modal_show_service").innerHTML = xhttp.responseText;
            }
         };

         xhttp.open("GET", "/admin/services/simple/"+$id , true);
         xhttp.send();
     
}


$('.nav-item').removeClass('active');
$('.nav_service').addClass('active');

$(function () {			
 $('.tooltip-viewport-bottom').tooltip({
    placement: 'bottom',html : true ,
    viewport: {
       selector: '.container-viewport',
       padding: 10
    }
 })
});