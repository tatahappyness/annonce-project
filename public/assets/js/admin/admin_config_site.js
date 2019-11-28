
		function show_modal_edit_site($id){
         var xhttp = new XMLHttpRequest();
         xhttp.onreadystatechange = function() {
             if (xhttp.readyState == 4 && xhttp.status == 200) {
                document.getElementById("load_modal_edit_site").innerHTML = xhttp.responseText;
            }
         };

         xhttp.open("GET", "../configsite/"+$id+"/edit" , true);
         xhttp.send();
}


$(function () { $('#myModal').modal('hide')});
/*$(function () { $('#myModal').on('hide.bs.modal', function () {
 alert('Hey, I heard you like modals...');})
});*/


	
$('.nav-item').removeClass('active');
$('.nav_config_site').addClass('active');

$('.visualiser').click(function (){
   //$('.email_org').text('modifier').addClass('text-success').removeClass('text-primary');			
   //$('.numtel_org').text('modifier').addClass('text-success').removeClass('text-primary');
   //$('.email_new').text('modifier').addClass('text-success').removeClass('text-primary');			
   //$('.numtel_new').text('modifier').addClass('text-success').removeClass('text-primary');
   
   $('.email_org').attr('style','display:none');
   $('.numtel_org').attr('style','display:none');
   
   var $email_config = $('#email_config').val();
   var $num_config = $('#numtel_config').val();
   
   $('.email_new').removeAttr('style','display:none').text($email_config);		
   $('.numtel_new').removeAttr('style','display:none').text($num_config);
   
});


$('.original').click(function (){			
   $('.email_org').removeAttr('style','display:none');
   $('.numtel_org').removeAttr('style','display:none');
   
   $('.email_new').attr('style','display:none');		
   $('.numtel_new').attr('style','display:none');
   
});
