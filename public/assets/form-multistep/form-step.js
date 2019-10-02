$(document).ready(function () {
	//Form Select Find Devis In Front
		$('.show-list-metier-nature-in-ask-form').select2({
			//theme: 'bootstrap',
			width: '65%',
			language: 'fr',
			placeholder: 'Quels travaux souhaitez-vous réaliser ?'
			//allowClear: true
			
		});
		//Form liste fonction userAgent
		$('.show-list-fonction-user-in-ask-form').select2({
		//	theme: 'bootstrap',
			width: '65%',
			language: 'fr',
			placeholder: 'Quel est votre fonction ?'
			//allowClear: true
			
		});
    
})

//Type project css active here
jQuery('.item-type').click(function() {
    jQuery('#ask_devis_type').val(jQuery(this).data('id'));
    jQuery('.item-type-' + jQuery(this).data('id')).css('background', 'rgb(255, 144, 0)').css('color', '#ffffff');
})
