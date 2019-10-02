 jQuery(document).ready(function () {
	 jQuery('.alert-pub').alert();
	 
	 //Selct nature for postule ads
	 $('.show-select-nature-particular').select2({
		//theme: 'bootstrap',
		width: '100%',
		language: 'fr',
		placeholder: 'Selectionez la nature de projet ?',
		//selectOnClose: true
			
	});

	// $( "#tags" ).autocomplete({
	// 	source: availableTags
	// 	});


	 //how pencil btn profil update
	 jQuery('.profil-particular').mouseover( function (){
		jQuery('span.lnr-pencil-edit-profil-particular').removeClass('d-none');
	 }).mouseleave( function() {
		jQuery('span.lnr-pencil-edit-profil-particular').addClass('d-none');
	 })
	 
	 //Bouttons action in liste dashbord particular
	 jQuery('.list-project-particular-1').mouseover( function () {
		jQuery('.btn-action-particular-1').removeClass('d-none').addClass('d-inline');
	 }).mouseleave( function() {
			jQuery('.btn-action-particular-1').removeClass('d-inline').addClass('d-none');
	 })
	  jQuery('.list-project-particular-2').mouseover( function () {
		jQuery('.btn-action-particular-2').removeClass('d-none');
	 }).mouseleave( function() {
			jQuery('.btn-action-particular-2').addClass('d-none');
	 })
	 jQuery('.list-project-particular-3').mouseover( function () {
		jQuery('.btn-action-particular-3').removeClass('d-none');
	 }).mouseleave( function() {
			jQuery('.btn-action-particular-3').addClass('d-none');
	 })
	 
	 //show message by pro candidate
	 jQuery('.btn-link-view-letter-pro').click(function() {
		Swal.fire({
		  title: 'MESSAGE',
		  html: '<div class="d-flex justify-content-center">'+
					'<span class="lnr lnr-envelope text-secondary"></span>'+
					'<p class=" p-2 text-left text-small text-secondary">'+
						'Bonjour!, je suis un professionnel.'+
						'Bonjour!, je suis un professionnel.'+
						'Bonjour!, je suis un professionnel.'+
						'Bonjour!, je suis un professionnel.'+
						'Bonjour!, je suis un professionnel.'+
					'</p>'+
				'</div>',
		  //text: 'Modal with a custom image.',
		  confirmButtonColor: 'rgb(255, 144, 0)',
		  //customClass: {icon: 'lnr lnr-envelope'},
		  animation: false
		});
	 })
 })
 
