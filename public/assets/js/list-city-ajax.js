
//INITIALITE CITY LISTS SELECT
jQuery('.show-city-search').select2({
    //theme: 'bootstrap',
    width: '65%',
    language: 'fr',
    placeholder: 'Votre ville ?'
    //allowClear: true
			
});

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
           
           //Attache city to select2 here
           var elemList = '<option></option>';
           var i = 1;
           // console.log(response);return false;
            response.forEach(city => {
            if (i < 2) {
                elemList += '<option selected="selected" value="' + city.value + '">' + city.label + '</option>';
            } 
            else {
                elemList += '<option value="' + city.value + '">' + city.label + '</option>';
            }

            });
           jQuery('.show-city-search').html(elemList);

        }).fail(function(){
            // Here you should treat the http errors (e.g., 403, 40
            alert('serveur internal error!!')					
            }).always(function(){
                console.log("AJAX request finished!");
            });
            

})


