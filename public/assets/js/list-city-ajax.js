
jQuery('.zipcode').focusout( function() {
    //alert(jQuery(this).val());
    //FORM  SEARCH CITY
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

            var input = document.getElementById("show-city-search");
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

    //Function to create element input
    function inputCreateCity(id) {
        var parentDiv = document.getElementById('form-city-special-hidden');
        var input = document.createElement("input");
        input.type = 'hidden';
        input.value = id	
        input.name = 'city';
        parentDiv.append(input);
        //parentDiv.innerHTML = input;
    }
    //END FORM FRONT SEARCH CITY


})


