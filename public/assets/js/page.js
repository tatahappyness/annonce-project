jQuery(document).ready(function() {
   
    jQuery('.menu-panel ul li a').click(function() {
        jQuery('.item' + jQuery(this).data('id')).css('background', '#bfbfbf');
    })

    jQuery('.article-image-show ').mouseover(function() {
        jQuery('.item-article').addClass('d-none');
        jQuery('#item-' + jQuery(this).data('id')).removeClass('d-none');
    })
    jQuery('.article-image-show ').mouseleave(function() {
        jQuery('#item-' + jQuery(this).data('id')).addClass('d-none');
    })

})

//AJAX PAGINATION FIND CHANTIER
jQuery('.btn-more-all-ajax').click(function() {
    jQuery(this).addClass('running');
    var that = this;
    var category_id = jQuery(this).data('categoryid');
    var departement = jQuery(this).data('departement');
    var offset = 0;
    offset += 1;
    jQuery.ajax({
        type : 'GET',
        url : '/space-find-chantier/?category_id=' + category_id + '&&offset=' + offset + '&&numDepartement=' + departement,
        contentType : false,
        processData : false
                    
        }).done(function(response) {
                
           if (response == 0) {
            that.style.display = 'none';
           }
           else{
            jQuery('.container-show-more-ajax').append(response);
           }
           
        }).fail(function(){
            // Here you should treat the http errors (e.g., 403, 40
            alert('serveur internal error!!')					
            }).always(function(){
                console.log("AJAX request finished!");
            });



})
//END PAGINATION AJAX  FIND CHANTIER


//AJAX PAGINATION FIND PROS
jQuery('.btn-more-all-pros').click(function() {
    jQuery(this).addClass('running');
    var that = this;
    var category_id = jQuery(this).data('categoryid');
    var departement = jQuery(this).data('departement');
    var offset = 0;
    offset += 1;
    jQuery.ajax({
        type : 'GET',
        url : '/space-find-pro/?category_id=' + category_id + '&&offset=' + offset + '&&numDepartement=' + departement,
        contentType : false,
        processData : false
                    
        }).done(function(response) {
                
        if (response == 0) {
            that.style.display = 'none';
        }
        else{
            jQuery('.container-show-more-ajax').append(response);
        }
           
        }).fail(function(){
            // Here you should treat the http errors (e.g., 403, 40
            alert('serveur internal error!!')					
            }).always(function(){
                console.log("AJAX request finished!");
            });



})
//END PAGINATION AJAX  FIND PROS


jQuery.ajax({
    type : 'GET',
    url : '/list-cagory-ajax',
    contentType : false,
    processData : false
				
    }).done(function(response){
			
        //console.log(response);return false;
        var options = {

            data: response,
            placeholder: "Quel métier?",
            getValue: "label",

            list: {
		
                match: {
                enabled: true
                },
                onSelectItemEvent: function() {
                    var value = $("#show-input-list-search").getSelectedItemData().value;
                    //alert(value);
                    jQuery("#CategoryIdSearch").val(value).trigger("change");
                    // var form_dev = document.getElementById('form_search_category');
                    // //submit the form post devis from home
                    // form_dev.submit();
                }
            },

            theme: "square"
        };
        
        jQuery("#show-input-list-search").easyAutocomplete(options);
       

    }).fail(function(){
        // Here you should treat the http errors (e.g., 403, 40
        alert('serveur internal error!!')					
        }).always(function(){
            console.log("AJAX request finished!");
        });
//END FORM FRONT SEARCH Category


//AJAX PAGINATION FIND ARTICLES
jQuery('.btn-article-all-more').click(function() {
    jQuery(this).addClass('running');
    var that = this;
    var category_id = jQuery(this).data('categoryid');
    var offset = 0;
    offset += 1;
    jQuery.ajax({
        type : 'GET',
        url : '/view-all-travaux/?category_id=' + category_id + '&&offset=' + offset,
        contentType : false,
        processData : false
                    
        }).done(function(response) {
                
        if (response == 0) {
            that.style.display = 'none';
        }
        else{
            jQuery('.articles-container-page-ajax').append(response);
            jQuery('.btn-article-all-more').removeClass('running');
        }
           
        }).fail(function(){
            // Here you should treat the http errors (e.g., 403, 40
            alert('serveur internal error!!')					
            }).always(function(){
                console.log("AJAX request finished!");
            });



})
//END PAGINATION AJAX  FIND ARTICLES