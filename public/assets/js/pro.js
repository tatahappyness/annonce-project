jQuery(document).ready(function () {
    
    // Form select nature in pro space add images
    jQuery('.imagesNatureTitle').select2({
        //theme: 'bootstrap',
        width: '100%',
        language: 'fr',
        placeholder: 'Sélectionnez  nature de votre image ?'
        //allowClear: true
			
    });
    // Form select nature in pro space add videos
    jQuery('.videosNatureTitle').select2({
        //theme: 'bootstrap',
        width: '100%',
        language: 'fr',
        placeholder: 'Sélectionnez  nature de votre video ?'
        //allowClear: true
			
    });

    //Ajax send message response to particular
    jQuery('.btn-send-message').click(function() {
        var form_message = jQuery('#form-response-message');
        jQuery.ajax({
            type: 'POST',
            url: '/pro/send-response-ads-project',
            contentType: false,
            processData: false,
            cache:false,
            dataType:'json',
            data: new FormData(form_message[0])
				
        }).done(function(response){
            var myimput = form_message.find('textarea').val('');
            Swal.fire({
                title: 'Reponse',
                html:'<span class="text-success font-weight-bol">' + response.infos + '</span>',
                type: 'success',
                background: 'rgb(119, 119, 119)',
                backdrop: `rgba(0,0,123,0.4)`,
                confirmButtonColor: 'rgb(255, 144, 0)'
                })
				
            }).fail(function(){
            // Here you should treat the http errors (e.g., 403, 40
                Swal.fire({
                    title: 'Reponse',
                    text: 'Erreur dans le serveur interne!!',
                    type: 'error',
                    background: 'rgb(119, 119, 119)',
                    backdrop: `rgba(0,0,123,0.4)`,
                    confirmButtonColor: 'rgb(255, 144, 0)'
                    })
					
                }).always(function(){
                    console.log("AJAX request finished!");
                })
    })

    //To accept devis
    jQuery('.btn-accept-devis').click(function() {

        jQuery.ajax({
            type: 'GET',
            url: '/pro/do-accept-project/?devisId=' + jQuery(this).data('id'),  
            contentType: false,
            processData: false,
            cache:false
				
        }).done(function(response){
            
            Swal.fire({
                title: 'Reponse',
                html:'<span class="text-success font-weight-bol">' + response.infos + '</span>',
                type: 'success',
                background: 'rgb(119, 119, 119)',
                backdrop: `rgba(0,0,123,0.4)`,
                confirmButtonColor: 'rgb(255, 144, 0)'
                })
				
            }).fail(function(){
            // Here you should treat the http errors (e.g., 403, 40
                Swal.fire({
                    title: 'Reponse',
                    text: 'Erreur dans le serveur interne!!',
                    type: 'error',
                    background: 'rgb(119, 119, 119)',
                    backdrop: `rgba(0,0,123,0.4)`,
                    confirmButtonColor: 'rgb(255, 144, 0)'
                    })
					
                }).always(function(){
                    console.log("AJAX request finished!");
                })


    })


    //Show form send message to particular
    jQuery('.btn-show-message-container').click(function() {
        jQuery('.massage-container').removeClass('d-none');
        jQuery(this).hide();
    })

})