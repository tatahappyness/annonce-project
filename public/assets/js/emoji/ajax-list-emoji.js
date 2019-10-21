$(function () {
    //EMOJI MESSAGE
    jQuery.ajax({
        type : 'GET',
        url : '/particulier/get-list-emojis',
        contentType : false,
        processData : false
                    
        }).done(function(response){
                
            $('.message').emoji({
                button:'&#x1F642;',
                place:'after',
                rowSize: 10,
                listCSS: {
                        position:'absolute',
                        border:'1px solid gray',
                        background:'#fff',
                        display:'none'
                        },
                        emojis: response.emojis

            });
                    
        }).fail(function(){
            // Here you should treat the http errors (e.g., 403, 40
            alert('serveur internal error!!')					
            }).always(function(){
                console.log("AJAX request finished!");
            });

    //EMOJI STAR
    $('.star').emoji({
        button:'&#x2B50;',
        place:'after',
        rowSize: 10,
        listCSS: {
                position:'absolute',
                border:'1px solid gray',
                background:'#fff',
                display:'none'
                },
                emojis: ['&#x2B50;','&#x1F929;','&#x1F4AB;','&#x1F31F;']  

    });
    
    })
    