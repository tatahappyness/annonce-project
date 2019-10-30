jQuery(document).ready(function() {
    // jQuery('.selectize-input > input').addClass('form-control');
    // // Form select Ville in page front
    // jQuery('#select-beast').selectize();

})

//AJAX PAGINATION once more
jQuery('.btn-more-all-ajax').click(function() {
    jQuery(this).addClass('running');
    var category_id = jQuery(this).data('categoryid');
    var offset = 0;
    offset += 1;
    jQuery.ajax({
        type : 'GET',
        url : '/space-find-chantier?category_id=' + category_id + '&&offset=' + offset,
        contentType : false,
        processData : false
                    
        }).done(function(response){
                
           
                    
        }).fail(function(){
            // Here you should treat the http errors (e.g., 403, 40
            alert('serveur internal error!!')					
            }).always(function(){
                console.log("AJAX request finished!");
            });



})
//END PAGINATION AJAX



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
    var input = document.createElement("input");
    input.type = 'hidden';
    input.value = id
    input.name = 'CategoryId';
    parentDiv.append(input);
}
//END FORM FRONT SEARCH Category
