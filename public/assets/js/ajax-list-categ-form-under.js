//AJAX FOR FORM UNDER IN SPACE FIND PROS
jQuery.ajax({
    type : 'GET',
    url : '/list-cagory-ajax',
    contentType : false,
    processData : false
				
    }).done(function(response){
			
        //console.log(response);return false;
        var input = document.getElementById("show-input-list-search-under-find");
        autocomplete({
            input: input,
            minLength: 2,
            emptyMsg: 'Aucun élément trouvé',
            fetch: function(text, update) {
                text = text.toLowerCase();
                // you can also use AJAX requests instead of preloaded data
                var suggestions = response.filter(n => n.label.toLowerCase().startsWith(text))
                update(suggestions);
            },
            onSelect: function(item) {
                input.value = item.label;
                inputCreate2(item.value);
            }

        });
	            
    }).fail(function(){
        // Here you should treat the http errors (e.g., 403, 40
        alert('serveur internal error!!')					
        }).always(function(){
            console.log("AJAX request finished!");
        });

//Function to create element input
function inputCreate2(id) {
    var parentDiv = document.getElementById('form-hidden-under-find');
    //console.log(parentDiv);
    parentDiv.innerHTML = '<input type="hidden" name="metier_ask_devis" value="' + id +'">';
    var form_dev = document.getElementById('form-ask-devis-pros-under');
    //submit the form post devis from home
    form_dev.submit();
}
//END AJAX FOR FORM UNDER IN SPACE FIND PROS