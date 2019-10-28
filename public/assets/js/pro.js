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

    // Form select nature in pro space add images
    jQuery('.category_id_pro').select2({
        //theme: 'bootstrap',
        width: '100%',
        language: 'fr',
        placeholder: 'Choisissez un categorie ?'
        //allowClear: true
			
    });

    //Show contenair of add service form
    jQuery('.btn-show-form-service').click(function() {
        jQuery('.cantainer-add-service').toggleClass('d-none');
    })
  

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
                // background: 'rgb(119, 119, 119)',
                backdrop: `rgba(0,0,123,0.4)`,
                confirmButtonColor: 'rgb(255, 144, 0)'
                })
				
            }).fail(function(){
            // Here you should treat the http errors (e.g., 403, 40
                Swal.fire({
                    title: 'Reponse',
                    text: 'Erreur dans le serveur interne!!',
                    type: 'error',
                    // background: 'rgb(119, 119, 119)',
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
                // background: 'rgb(119, 119, 119)',
                backdrop: `rgba(0,0,123,0.4)`,
                confirmButtonColor: 'rgb(255, 144, 0)'
                })
				
            }).fail(function(){
            // Here you should treat the http errors (e.g., 403, 40
                Swal.fire({
                    title: 'Reponse',
                    text: 'Erreur dans le serveur interne!!',
                    type: 'error',
                    // background: 'rgb(119, 119, 119)',
                    backdrop: `rgba(0,0,123,0.4)`,
                    confirmButtonColor: 'rgb(255, 144, 0)'
                    })
					
                }).always(function(){
                    console.log("AJAX request finished!");
                })


    })

    // To do valid accept devis
    jQuery('.btn-valid-devis').click(function() {
        
        jQuery.ajax({
            type: 'GET',
            url: '/pro/do-valid-project/?devisAcceptId=' + jQuery(this).data('id'),  
            contentType: false,
            processData: false,
            cache:false
				
        }).done(function(response){
            
            Swal.fire({
                title: 'Reponse',
                html:'<span class="text-success font-weight-bol">' + response.infos + '</span>',
                type: 'success',
                // background: 'rgb(119, 119, 119)',
                backdrop: `rgba(0,0,123,0.4)`,
                confirmButtonColor: 'rgb(255, 144, 0)'
                })
				
            }).fail(function(){
            // Here you should treat the http errors (e.g., 403, 40
                Swal.fire({
                    title: 'Reponse',
                    text: 'Erreur dans le serveur interne!!',
                    type: 'error',
                    // background: 'rgb(119, 119, 119)',
                    backdrop: `rgba(0,0,123,0.4)`,
                    confirmButtonColor: 'rgb(255, 144, 0)'
                    })
					
                }).always(function(){
                    console.log("AJAX request finished!");
                })

    })

    // To do Finish valid devis
    jQuery('.btn-termine-devis').click(function() {
        
        jQuery.ajax({
            type: 'GET',
            url: '/pro/do-finish-project/?devisFinishId=' + jQuery(this).data('id'),  
            contentType: false,
            processData: false,
            cache:false
				
        }).done(function(response){
            
            Swal.fire({
                title: 'Reponse',
                html:'<span class="text-success font-weight-bol">' + response.infos + '</span>',
                type: 'success',
                // background: 'rgb(119, 119, 119)',
                backdrop: `rgba(0,0,123,0.4)`,
                confirmButtonColor: 'rgb(255, 144, 0)'
                })
				
            }).fail(function(){
            // Here you should treat the http errors (e.g., 403, 40
                Swal.fire({
                    title: 'Reponse',
                    text: 'Erreur dans le serveur interne!!',
                    type: 'error',
                    // background: 'rgb(119, 119, 119)',
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

    //POST Image PROFIL
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profile-pic').attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $(".file-upload").on('change', function(){
        readURL(this);
        var form_imgs = $('#form-upload-profil')[0];
        var file_data =  $(this).prop('files')[0];

        if(file_data != undefined) {
			
            jQuery.ajax({
                type: 'POST',
                url: '/pro/edit-profil-pros',
                contentType: false,
                processData: false,
                cache:false,
                dataType:'json',
                data: new FormData(form_imgs)
				
            }).done(function(response){
				
                Swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: response.info,
                    showConfirmButton: false,
                    timer: 3000,
                    backdrop: 'rgba(44, 221, 71, 0.4)'
                    })

                }).fail(function(){
                    Swal.fire({
                        position: 'top-end',
                        type: 'error',
                        title: 'Eurrer de serveur interne!',
                        showConfirmButton: false,
                        timer: 3000,
                        backdrop: 'rgba(255, 0, 0, 0.4)'
                        })

                    }).always(function(){
                        console.log("AJAX request finished!");
                    });
        }
        return false;

    });
    
    $(".upload-button").on('click', function() {
    $(".file-upload").click();
    });

    //Filter periodity of result projects
    jQuery('.radio').click(function() {

        //alert(jQuery(this).children().val());

        jQuery.ajax({
            type: 'GET',
            url: '/pro/lists-projects-disponible/?switch_periodity=' + jQuery(this).children().val(),  
            contentType: false,
            processData: false,
            cache:false
				
        }).done(function(response){
                var elemList = '';
                // console.log(response);return false;
               response.forEach(post => {
                   elemList += '<li class="list-group-item">' +
                   '<div class="d-block">' +
                       '<div class="d-flex flex-row align-items-center justify-content-around">' +
                            '<div class="">' +
                               '<div class="rounded-circle d-block" style="width: 80px; height: 80px; background: orange;">' +
                                   '<span class="lnr lnr-clock" style="font-size: 64px; line-height: 80px;"></span>' +
                               '</div>' +
                           '</div>' +
                           '<div class="px-2 info-ads-detail">'+
                               '<a href="lists-projects-disponible/"' + post.id + '" class="text-reset"><h3 class="d-block text-left">' +  post.title+'</h3></a>' +
                               '<p class="d-block text-dark text-left">' +
                                    post.firstname + ' - à ' + post.city + '<br>' +
                                   '<span class="text-secondary">' + post.description + '</span>' +
                               '</p>' +
                          ' </div>' +
                      ' </div>' +
                   '</div>' +
                   '<div class="d-block text-center float-left">' + post.date + '</div>' +
                '</li>';
               });

               jQuery('#append-filter-posted-lists').html(elemList);
            
            }).fail(function(){
            // Here you should treat the http errors (e.g., 403, 40
                Swal.fire({
                    title: 'Reponse',
                    text: 'Erreur dans le serveur interne!!',
                    type: 'error',
                    // background: 'rgb(119, 119, 119)',
                    backdrop: `rgba(0,0,123,0.4)`,
                    confirmButtonColor: 'rgb(255, 144, 0)'
                    })
					
                }).always(function(){
                    console.log("AJAX request finished!");
                })

    })

    // EDIT COORDONE PROS
    jQuery('.btn-edit-pros').click( function() {

        var form_record = jQuery('#form-edit-pros');
        //Verify each input type is validity here
        var curInputs = form_record.find("input[type='text'],input[type='email'], select, input[type='tel'], input[type='number'], input[type='password']");
        for(var i=0; i<curInputs.length; i++) {
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

        //AJAX TO EDIT USERS PROS HERE
        jQuery.ajax({
            type: 'POST',
            url: '/pro/coordonation-edit',
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

    //AJAX POST PARTICULAR PASSWORD  UPDATE
    jQuery('.btn-update-password-pro').click(function() {
		
        var form_record = jQuery('#form-update-password-pro');
        jQuery.ajax({
            type: 'POST',
            url: '/pro/password-edit',
            contentType: false,
            processData: false,
            cache:false,
            dataType:'json',
            data: new FormData(form_record[0])
				
        }).done(function(response){
			
            form_record[0].reset();

            Swal.fire({
                title: 'Reponse',
                html:'<span class="text-success font-weight-bol">' + response.info + '</span>',
                type: 'success',
                // background: 'rgb(119, 119, 119)',
                backdrop: `rgba(0,0,123,0.4)`,
                confirmButtonColor: 'rgb(255, 144, 0)'
                })
				
            }).fail(function(){
            // Here you should treat the http errors (e.g., 403, 40
                Swal.fire({
                    title: 'Reponse',
                    text: 'Erreur dans le serveur interne!!',
                    type: 'error',
                    // background: 'rgb(119, 119, 119)',
                    backdrop: `rgba(0,0,123,0.4)`,
                    confirmButtonColor: 'rgb(255, 144, 0)'
                    })
					
                }).always(function(){
                    console.log("AJAX request finished!");
                })

    })

        //AJAX POST Particular COMMENTS
        jQuery('#btn-add-comment').click(function() {
            
            var form_record = jQuery('#form-add-comment');
            jQuery.ajax({
                type: 'POST',
                url: '/pro/talk-us',
                contentType: false,
                processData: false,
                cache:false,
                dataType:'json',
                data: new FormData(form_record[0])
                    
            }).done(function(response){
                
                form_record[0].reset();

                Swal.fire({
                    title: 'Reponse',
                    html:'<span class="text-success font-weight-bol">' + response.info + '</span>',
                    type: 'success',
                    // background: 'rgb(119, 119, 119)',
                    backdrop: `rgba(0,0,123,0.4)`,
                    confirmButtonColor: 'rgb(255, 144, 0)'
                    })
                    
                }).fail(function(){
                // Here you should treat the http errors (e.g., 403, 40
                    Swal.fire({
                        title: 'Reponse',
                        text: 'Erreur dans le serveur interne!!',
                        type: 'error',
                        // background: 'rgb(119, 119, 119)',
                        backdrop: `rgba(0,0,123,0.4)`,
                        confirmButtonColor: 'rgb(255, 144, 0)'
                        })
                        
                    }).always(function(){
                        console.log("AJAX request finished!");
                    })

        })

        //ADD SERVICE PROS
        jQuery('.btn-record-service-pro').click(function() {
            
            var form_record = jQuery('#form-add-service-pro');
            jQuery.ajax({
                type: 'POST',
                url: '/pro/add-service',
                contentType: false,
                processData: false,
                cache:false,
                dataType:'json',
                data: new FormData(form_record[0])
                    
            }).done(function(response){
                
                form_record[0].reset();

                Swal.fire({
                    title: 'Reponse',
                    html:'<span class="text-success font-weight-bol">' + response.info + '</span>',
                    type: 'success',
                    // background: 'rgb(119, 119, 119)',
                    backdrop: `rgba(0,0,123,0.4)`,
                    confirmButtonColor: 'rgb(255, 144, 0)'
                    })
                    
                    location.reload(true);
                    
                }).fail(function(){
                // Here you should treat the http errors (e.g., 403, 40
                    Swal.fire({
                        title: 'Reponse',
                        text: 'Erreur dans le serveur interne!!',
                        type: 'error',
                        // background: 'rgb(119, 119, 119)',
                        backdrop: `rgba(0,0,123,0.4)`,
                        confirmButtonColor: 'rgb(255, 144, 0)'
                        })
                        
                    }).always(function(){
                        console.log("AJAX request finished!");
                    })

        })


        //how camera icon btn profil update
        jQuery('.card-profil').mouseover( function (){
            jQuery('span.upload-button').removeClass('d-none');
        }).mouseleave( function() {
            jQuery('span.upload-button').addClass('d-none');
        })

        $(".upload-button").on('click', function() {
            $(".file-upload").click();
        });



})