//AJAX FOR FORM UNDER IN SPACE FIND PROS
jQuery.ajax({
    type : 'GET',
    url : '/list-cagory-ajax',
    contentType : false,
    processData : false
				
    }).done(function(response){
			
        //console.log(response);return false;
        var options = {

            data: response,
            placeholder: "Quel travaux souhaitez vou realiser ?",
            getValue: "label",

            list: {
		
                match: {
                enabled: true
                },
                onSelectItemEvent: function() {
                    var value = $("#show-input-list-search-under-find").getSelectedItemData().value;
                    //alert(value);
                    jQuery("#metier_ask_devis").val(value).trigger("change");
                    var form_dev = document.getElementById('form-ask-devis-pros-under');
                    //submit the form post devis from home
                    form_dev.submit();
                }
            },

            theme: "square"
        };
        
        jQuery("#show-input-list-search-under-find").easyAutocomplete(options);
     
    }).fail(function(){
        // Here you should treat the http errors (e.g., 403, 40
        alert('serveur internal error!!')					
        }).always(function(){
            console.log("AJAX request finished!");
        });
