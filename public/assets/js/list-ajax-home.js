jQuery.ajax({
    type : 'GET',
    url : '/list-cagory-ajax',
    contentType : false,
    processData : false
				
    }).done(function(response){
			
        //console.log(response);return false;
        var input = document.getElementById("show-input-list-search");
        autocomplete({
            input: input,
            minLength: 1,
            emptyMsg: 'Aucun élément trouvé',
            fetch: function(text, update) {
                text = text.toLowerCase();
                // you can also use AJAX requests instead of preloaded data
                var suggestions = response.filter(n => n.label.toLowerCase().startsWith(text))
                update(suggestions);
            },
            onSelect: function(item) {
                input.value = item.label;
                inputCreate(item.value);
            }

        });
	            
    }).fail(function(){
        // Here you should treat the http errors (e.g., 403, 40
        alert('serveur internal error!!')					
        }).always(function(){
            console.log("AJAX request finished!");
        });

//Function to create element input
function inputCreate(id) {
    var parentDiv = document.getElementById('group-form-spcial-input-hidden');
    parentDiv.innerHTML = '<input type="hidden" name="metier_ask_devis" value="' + id +'">';
    document.getElementById('group-form-spcial-input-hidden');
    var form_dev = document.getElementById('form-ask-devis-home');
    //submit the form post devis from home
    form_dev.submit();

}
//END FORM FRONT SEARCH Category