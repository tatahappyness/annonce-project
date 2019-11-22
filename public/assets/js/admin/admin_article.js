
	
  $(function () { $('#myModal').modal('hide')});
        
  
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

    xhttp.open("GET", "/admin/article/pop/" + id + "/" + pop);
    xhttp.send();

}



		$('.nav-item').removeClass('active');
		$('.nav_objet_devis').addClass('active');
		
		
		function show_modal_affiche_article($id){			
                 var xhttp = new XMLHttpRequest();
                 xhttp.onreadystatechange = function() {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        document.getElementById("load_modal_affiche_article").innerHTML = xhttp.responseText;
                    }
                 };

                 xhttp.open("GET", "/admin/article/"+$id , true);
                 xhttp.send();
				 
        }
        
        


		$(function () {			
			$('.tooltip-viewport-bottom').tooltip({
				placement: 'bottom',html : true ,
				viewport: {
					selector: '.container-viewport',
					padding: 10
				}
			})
		})

        
		
		function show_modal_affiche_article_image($id){
			
                 var xhttp = new XMLHttpRequest();
                 xhttp.onreadystatechange = function() {
                     if (xhttp.readyState == 4 && xhttp.status == 200) {
                        document.getElementById("load_modal_affiche_image").innerHTML = xhttp.responseText;
                    }
                 };

                 xhttp.open("GET", "/admin/article/"+$id+"/image" , true);
                 xhttp.send();
		}
		
		
		
		function show_modal_affiche_article_icone($id){
			
                 var xhttp = new XMLHttpRequest();
                 xhttp.onreadystatechange = function() {
                     if (xhttp.readyState == 4 && xhttp.status == 200) {
                        document.getElementById("load_modal_affiche_icone").innerHTML = xhttp.responseText;
                    }
                 };

                 xhttp.open("GET", "/admin/article/"+$id+"/icone" , true);
                 xhttp.send();
		}

		$(document).ready(function() {
			$('table.display').DataTable();
		} );




		function show_modal_sup_article($id){
			
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                   document.getElementById("load_model_article_supprimer").innerHTML = xhttp.responseText;
               }
            };

            xhttp.open("GET", "/admin/article/delete/"+$id, true);
            xhttp.send();
   }