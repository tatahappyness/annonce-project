
//Create site FORM POST AJAX
jQuery('.btn-create-site').click(function() {
        
    var form_record = jQuery('#form-create-site');

    jQuery.ajax({
        type: 'POST',
        url: '/sites-create',
        contentType: false,
        processData: false,
        cache:false,
        dataType:'json',
        data: new FormData(form_record[0])
        
    }).done(function(response){
        
        Swal.fire({
            title: 'Reponse',
            text: response.info,
            type: 'success',
            // background: 'rgb(119, 119, 119)',
            backdrop: `rgba(0,0,123,0.4)`,
            confirmButtonColor: 'rgb(255, 144, 0)'
            });
                
            form_record[0].reset();
                
        }).fail(function(){
        // Here you should treat the http errors (e.g., 403, 40
            Swal.fire({
                title: 'Reponse',
                text: 'Erreur dans le serveur interne!!',
                type: 'error',
                // background: 'rgb(119, 119, 119)',
                backdrop: `rgba(0,0,123,0.4)`,
                confirmButtonColor: 'rgb(255, 144, 0)'
                });
    
            
            }).always(function(){
                console.log("AJAX request finished!");
            });

})