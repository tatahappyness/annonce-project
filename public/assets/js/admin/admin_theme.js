$(function () { $('#myModal').modal('hide')});	
	
$('.nav-item').removeClass('active');
$('.nav_theme').addClass('active');

$(document).ready(function() {
   $('table.display').DataTable();
  } );


function show_modal_affiche_theme_image($id){
    
         var xhttp = new XMLHttpRequest();
         xhttp.onreadystatechange = function() {
             if (xhttp.readyState == 4 && xhttp.status == 200) {
                document.getElementById("load_modal_affiche_image").innerHTML = xhttp.responseText;
            }
         };

         xhttp.open("GET", "/admin/theme/"+$id+"/image" , true);
         xhttp.send();
}


function show_modal_sup_theme($id){
    
   var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
       if (xhttp.readyState == 4 && xhttp.status == 200) {
          document.getElementById("load_modal_delete_theme").innerHTML = xhttp.responseText;
      }
   };

   xhttp.open("GET", "/admin/theme/"+$id+"/deletetheme" , true);
   xhttp.send();
}




function show_modal_add_theme(){
			
   var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
       if (xhttp.readyState == 4 && xhttp.status == 200) {
          document.getElementById("load_model_theme_add").innerHTML = xhttp.responseText;
      }
   };

   xhttp.open("GET", "/admin/theme/new", true);
   xhttp.send();
}


$(document).ready(function() {
    $('table.display').DataTable();
} );

