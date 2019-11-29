$(function () { $('#myModal').modal('hide')});	


//To set Category is popularing
$('.customSwitch').change(function() {
   //alert($(this).data('id') +" "+ $(this).prop('checked'))            
   setPopular($(this).data('id') , $(this).prop('checked'));
    
   //alert($(this).prop('checked') + ' ' + $(this).data('id') );

});

function setPopular(id, pop){			

   var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (xhttp.readyState == 4 && xhttp.status == 200) {
         Swal.fire({
               position: 'top-end',
               icon: 'success',
               title: xhttp.responseText,
               showConfirmButton: false,
               timer: 1500
         })

         location.reload(true);

      }
   };

   xhttp.open("GET", "/admin/category/top/" + id + "/" + pop);
   xhttp.send();

}

	
$('.nav-item').removeClass('active');
$('.nav_objet_devis').addClass('active');


function show_modal_affiche_categorie($id){
    
         var xhttp = new XMLHttpRequest();
         xhttp.onreadystatechange = function() {
             if (xhttp.readyState == 4 && xhttp.status == 200) {
                document.getElementById("load_modal_affiche_cat").innerHTML = xhttp.responseText;
            }
         };

         xhttp.open("GET", "/admin/category/"+$id , true);
         xhttp.send();
         
}



function show_modal_affiche_categorie_image($id){
    
         var xhttp = new XMLHttpRequest();
         xhttp.onreadystatechange = function() {
             if (xhttp.readyState == 4 && xhttp.status == 200) {
                document.getElementById("load_modal_affiche_image").innerHTML = xhttp.responseText;
            }
         };

         xhttp.open("GET", "/admin/category/"+$id+"/image" , true);
         xhttp.send();
}


function show_modal_affiche_categorie_icone($id){
    
         var xhttp = new XMLHttpRequest();
         xhttp.onreadystatechange = function() {
             if (xhttp.readyState == 4 && xhttp.status == 200) {
                document.getElementById("load_modal_affiche_icone").innerHTML = xhttp.responseText;
            }
         };

         xhttp.open("GET", "/admin/category/"+$id+"/icone" , true);
         xhttp.send();
}


$(document).ready(function() {
    $('table.display').DataTable();
} );

