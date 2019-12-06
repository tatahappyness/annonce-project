jQuery(document).ready(function() {
   
   //VERIFY FORM TO SEND DEVIS ASK
	
   var navListItems = $('div.setup-panel div a'),
   allWells = $('.setup-content'),
   allNextBtn = $('.nextbtn'),
allPrevBtn = $('.prevbtn');

//allWells.hide();

navListItems.click(function (e) {
e.preventDefault();
var $target = $($(this).attr('href')),
       $item = $(this);

if (!$item.hasClass('disabled')) {
   navListItems.removeClass('btn-success').addClass('disabled');
   $item.addClass('btn-success');
   allWells.addClass('d-none');
   $target.removeClass('d-none');
   $target.find('input:eq(0)').focus();
}
});

allPrevBtn.click(function(){
var curStep = $(this).closest(".setup-content"),
   curStepBtn = curStep.attr("id"),
   prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

   prevStepWizard.removeClass('disabled').trigger('click');
});

    allNextBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
        curInputs = curStep.find("input[type='text'], input[type='radio'], input[type='email'], select, input[type='tel'], textarea[required='required']"),
        isValid = true;

        $(".form-group").removeClass("has-error");
        for(var i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid || curInputs[i].value == ""){
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
                var result = curInputs[i].placeholder != undefined ? curInputs[i].placeholder : $('.select2-selection__placeholder').text();
                Swal.fire({
                    html: '<span class="h2 text-warning text-center">Info</span><br><span class="text-warning small text-center">Veillez definir ' + result+ '</span>',
                    type: 'warning',
                    // background: 'rgb(119, 119, 119)',
                    backdrop: `rgba(0,0,123,0.4)`,
                    confirmButtonColor: 'rgb(255, 144, 0)'
                });
            }
        }

        if (isValid) {
        nextStepWizard.removeClass('disabled').trigger('click');
        }
        
    });
    $('div.setup-panel div a.btn-success').trigger('click');

   
    //Verify each input ask devis here
    jQuery('#btn-post-ask-devis').click(function() {
        curInputs =  jQuery('#form-post-ask-devis').find("input[type='text'], input[type='radio'], input[type='email'], select, input[type='tel'], textarea[required='required']");
        $(".form-group").removeClass("has-error");
        for(var i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid || curInputs[i].value == ""){
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
                var result = curInputs[i].placeholder != undefined ? curInputs[i].placeholder : $('.select2-selection__placeholder').text();
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

        var form_record = jQuery('#form-post-ask-devis');
        jQuery.ajax({
            type: 'POST',
            url: '/post-ask-devis',
            contentType: false,
            processData: false,
            cache:false,
            dataType:'json',
            data: new FormData(form_record[0])
				
        }).done(function(response){
            jQuery('#step-2').addClass('d-none');
            jQuery('#step-3').removeClass('d-none');

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

})