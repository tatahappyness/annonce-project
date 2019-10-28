jQuery(document).ready( function() {

    //Check email if existe or invalid or valid
    jQuery('.email').focusout(function() {
       
        jQuery.ajax({
            type : 'GET',
            url : '/register-verify-email',
            data : '_email=' + $(this).val(),
            contentType : false,
            processData : false
				
        }).done(function(response){
                if(response.code == 401)
                {
                    //alert(response.infos);
                    jQuery('.infos-message').html(response.infos).css('color', 'red').next().find('input[id="email"]').css('border', '1px').css('border-color', 'red').fadeIn();
                }
                else { jQuery('.infos-message').html(response.infos).css('color', 'green').next().find('input[id="email"]').css('border-color', 'green'); }
            
            }).fail(function(){
            // Here you should treat the http errors (e.g., 403, 40
               alert('serveur internal error!!')					
                }).always(function(){
                    console.log("AJAX request finished!");
                });

    })

    //CHECK ZIP CODE HERE

    // })// END Zipcode validation

    //comfirmation password verify
    jQuery('.password-comfirm').focusout( function() {

        if(jQuery(this).val() !== jQuery('.password').val()) {
            Swal.fire({
                title: 'Erreur',
                html: '<span class="text-danger font-weight-bold">Comfirmation de votre mot passe n\'est pas identique</span>',
                type: 'error',
                // background: 'rgb(119, 119, 119)',
                backdrop: `rgba(0,0,123,0.4)`,
                confirmButtonColor: 'rgb(255, 144, 0)'
                });
        }
    })

    // SAVE User Register
    jQuery('.btn-register-user').click( function() {

        var form_record = jQuery('.form-register-user');
        //Verify each input type is validity here
        var curInputs = form_record.find("input[type='text'],input[type='email'], select, input[type='tel'], input[type='number'], input[type='password']");
        for(var i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid || curInputs[i].value == ""){
                isValid = false;
                jQuery(curInputs[i]).closest(".form-group").addClass("has-error");
                var result = curInputs[i].placeholder != undefined ? curInputs[i].placeholder : jQuery('.select2-selection__placeholder').text();
                Swal.fire({
                html: '<span class="h2 text-warning text-center">Attention!</span><br><span class="text-warning small text-center">Veillez definir ' + result+ ' exacte</span>',
                type: 'warning',
                // background: 'rgb(119, 119, 119)',
                backdrop: `rgba(0,0,123,0.4)`,
                confirmButtonColor: 'rgb(255, 144, 0)'
                }); 
                return false;
            }
        }

        //AJAX TO REGISTER USERS HERE
        jQuery.ajax({
            type: 'POST',
            url: '/register',
            contentType: false,
            processData: false,
            cache:false,
            dataType:'json',
            data: new FormData(form_record[0])
				
        }).done(function(response){
				
            Swal.fire({
                title: 'Reponse',
                text: response.infos,
                type: 'success',
                // background: 'rgb(119, 119, 119)',
                backdrop: `rgba(0,0,123,0.4)`,
                confirmButtonColor: 'rgb(255, 144, 0)'
                });

                var form_record = jQuery('.form-register-user');
                //Verify each input type is validity here
                var curInputs = form_record.find("input[type='text'],input[type='email'], select, input[type='tel'], input[type='number'], input[type='password']");
                for(var i=0; i<curInputs.length; i++){
                    curInputs[i].value = '';
                }

				
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

    
})