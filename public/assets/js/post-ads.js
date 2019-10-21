jQuery(document).ready(function() {
    
    // Form select category
    jQuery('#post_category').select2({
        //theme: 'bootstrap',
        width: '100%',
        language: 'fr',
        placeholder: 'Séléctionnez la categorie de projet ?'
        //allowClear: true
			
    });
    // Form select nature 
    jQuery('#post_nature').select2({
        //theme: 'bootstrap',
        width: '100%',
        language: 'fr',
        placeholder: 'Séléctionnez la nature de projet ?'
        //allowClear: true
			
    });

    // Form select type
    jQuery('#post_type').select2({
        //theme: 'bootstrap',
        width: '100%',
        language: 'fr',
        placeholder: 'Séléctionnez le type de projet ?'
        //allowClear: true
			
    });

    //GET LIST ARTICLES BY ONE CATEGORY ID
    jQuery('#post_category').change(function() {

        jQuery.ajax({
            type : 'GET',
            url : '/particulier/list-articles-ajax/?categoryId=' + jQuery(this).val(),
            contentType : false,
            processData : false
                        
            }).done(function(response){
                    
                //console.log(response);return false;
                var options = '<option><option>';
                response.forEach(element => {
                    options += ' <option value="' + element.value + '">' + element.label + '</option>';
                });
            var el = document.getElementById("post_nature");
                el.innerHTML = options;
        
                }).fail(function(){
                    // Here you should treat the http errors (e.g., 403, 40
                    alert('serveur internal error!!')					
                    }).always(function(){
                        console.log("AJAX request finished!");
                });

    })

    //Verify Zipcode if it's valid or invalid
    jQuery('#post_zipcode').focusout(function() {
        
        jQuery.ajax({
            type : 'GET',
            url : '/list-city-ajax/?zipCode=' + jQuery(this).val(),
            contentType : false,
            processData : false
                            
            }).done(function(response){
                        
            if (response.info == false) {
                
                Swal.fire({
                    title: 'Erreur',
                    text: "Votre code postal invalide!",
                    type: 'error',
                    background: 'rgb(119, 119, 119)',
                    backdrop: `rgba(0,0,123,0.4)`,
                    confirmButtonColor: 'rgb(255, 144, 0)'
                    }); 
                return false;
            }
    
                var input = document.getElementById("post_city");
                autocomplete({
                    input: input,
                    minLength: 2,
                    emptyMsg: 'Aucune ville trouvé',
                    fetch: function(text, update) {
                        text = text.toLowerCase();
                        // you can also use AJAX requests instead of preloaded data
                        var suggestions = response.filter(n => n.label.toLowerCase().startsWith(text))
                        update(suggestions);
                    },
                    onSelect: function(item) {
                        input.value = item.label;
                        inputCreateCity(item.value);
                    }
    
                });
                            
            }).fail(function(){
                // Here you should treat the http errors (e.g., 403, 40
                alert('serveur internal error!!')					
                }).always(function(){
                    console.log("AJAX request finished!");
                });
    })

    //Function to create element input
    function inputCreateCity(id) {
        var parentDiv = document.getElementById('form-city-special-hidden');
        var input = document.createElement("input");
        input.type = 'hidden';
        input.value = id	
        input.name = 'city';
        parentDiv.append(input);
    }



    //POST ADS TO DATABASE
jQuery('.btn-post-ads').click(function() {


    //Verify input form each forms
    curInputs =  jQuery('#form-part-post-ads').find("input[type='text'],input[type='email'], select, input[type='tel'], textarea[required='required']");
    
    for(var i=0; i<curInputs.length; i++){
        if (!curInputs[i].validity.valid || curInputs[i].value == ""){
            isValid = false;
            $(curInputs[i]).closest(".form-group").addClass("has-error");
            var result = curInputs[i].placeholder != undefined ? curInputs[i].placeholder : $('.select2-selection__placeholder').text();
            Swal.fire({
                html: '<span class="h2 text-warning text-center">Attention!</span><br><span class="text-warning small text-center">Veillez definir ' + result+ ' exacte</span>',
                type: 'warning',
                background: 'rgb(119, 119, 119)',
                backdrop: `rgba(0,0,123,0.4)`,
                confirmButtonColor: 'rgb(255, 144, 0)'
            });

            return false;
        }
    }

    
    var form_record = jQuery('#form-part-post-ads');
    //AJAX TO REGISTER USERS HERE
    jQuery.ajax({
        type: 'POST',
        url: '/particulier/post-ads-project',
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
            background: 'rgb(119, 119, 119)',
            backdrop: `rgba(0,0,123,0.4)`,
            confirmButtonColor: 'rgb(255, 144, 0)'
            });

            form_record[0].reset();

            //Refresh page
            //location.reload(true);
				
        }).fail(function(){
        // Here you should treat the http errors (e.g., 403, 40
            Swal.fire({
                title: 'Reponse',
                text: 'Erreur dans le serveur interne!!',
                type: 'error',
                background: 'rgb(119, 119, 119)',
                backdrop: `rgba(0,0,123,0.4)`,
                confirmButtonColor: 'rgb(255, 144, 0)'
                });
            
					
            }).always(function(){
                console.log("AJAX request finished!");
            });


})



})