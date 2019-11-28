
    $(function() {
      $('.customSwitch').change(function() {

          setPopular($(this).data('id') , $(this).prop('checked'));
          //alert($(this).prop('checked') + ' ' + $(this).data('id') );

      })
  })


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
                
                  $('.mode_envoi_all').attr('style','display:none');
                $('.mode_envoi_3').removeAttr('style','display:none');
                
                      //location.reload(true);
                $('.envoyer_plus').click();
                  }
               };

               xhttp.open("GET", "/admin/setModeEmail3?id=" + id + "&&active=" + pop);
               xhttp.send();
           
    }
    
    $('.nav-item').removeClass('active');
    $('.nav_m_e_email').addClass('active');		
 
       $('#select_email').change(function(){		
          $('.confirmer_seul_pers').attr('style','display:none');		
          $('.form-control-email-seul-perso').val('');

          Lien($(this).val(), this );
          //alert( $(this).val()  );
          
          if ( $('.form-control-email-seul-perso').val() != '' ) {										
             $('.confirmer_seul_pers').removeAttr('style','display:none');
          }else{
             $('.confirmer_seul_pers').attr('style','display:none');		
          }
          

       });

       
    /*$('.confirmer_seul_pers').click(function (){			
       $x = $('.form-control-email-seul-perso').val();

       if ($x != '' ) {
          alert('not null form-control-email-seul-perso')
       }else{
          alert('nullable')
       }			
       
    });
    */
    
       function Lien() {
          i = document.x_1.x_2.selectedIndex;
          if (i == 0) return;

          selected = document.x_1.x_2.options[i].value;				
          x = $('.form-control-email-seul-perso').val(selected);
                   
                      
          document.getElementById("valider_email").innerHTML = `
             <a class="col nav-link btn btn-success" href="/admin/setUpdateServiceDisable/`+selected+`">						
                VALIDER						
             </a>					
             `;
          
       }
       
       /*

       function Lien(all, i) {
          
          //alert(iduser +" "+ idcategory);

          //i = document.x_1.x_2.selectedIndex;
          //if (i == 0) return;
          
          //email = document.x_1.x_2.options[i].text;
          email = $(i).text();

          x = $('.form-control-email-seul-perso').val(selected);
          
          $('.select_my_email').text(email);
          //parent.location.href = url;
          
          
          document.getElementById("valider_email").innerHTML = `
             <a class="col nav-link btn btn-success" href="/admin/setUpdateServiceActived/`+all+`">
                VALIDER						
             </a>
             `;
          
       }

       */
       

    function edit_service_one_email($email){
       alert("ACTIVER EMAIL = "+$email)

       var xhttp = new XMLHttpRequest();
       xhttp.onreadystatechange = function() {
             if (xhttp.readyState == 4 && xhttp.status == 200) {
          }
       };
       xhttp.open("GET", "{{ path('service') }}" , true);
       xhttp.send();
    }		
    
 
 
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
      $('#dataTables').DataTable();
      
      $('#dataTable_plus').DataTable();
      
      $('#dataTable').DataTable();
      
    });



    
    $('.envoyer_normale').click(function (){
       
       //$('.envoyer_normale_row').removeAttr('style','display:none');

       //$('.envoyer_one_row').attr('style','display:none');
       $('.envoyer_plus_row').attr('style','display:none');
       
    });
    
    
    $('.envoyer_one').click(function (){
       
       //$('.envoyer_one_row').removeAttr('style','display:none');

       //$('.envoyer_normale_row').attr('style','display:none');
       $('.envoyer_plus_row').attr('style','display:none');
       
    });
          
    $('.envoyer_plus').click(function (){
       
       $('.envoyer_plus_row').removeAttr('style','display:none');

       //$('.envoyer_one_row').attr('style','display:none');
       //$('.envoyer_normale_row').attr('style','display:none');
       
    });
    
    
    
    $(function () {
       $('.tooltip-viewport-bottom').tooltip({
          placement: 'bottom',html : true ,
          viewport: {
             selector: '.container-viewport',
             padding: 10
          }
       })
    });
 
    $(document).ready(function() {
       $('table.display').DataTable();
    } );
 