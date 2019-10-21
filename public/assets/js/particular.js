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

	 //how camera icon btn profil update
	 jQuery('.card-profil').mouseover( function (){
		jQuery('span.upload-button').removeClass('d-none');
	 }).mouseleave( function() {
		jQuery('span.upload-button').addClass('d-none');
	 })
	 
	 //Bouttons action in liste dashbord particular
	 jQuery('li.accept').mouseover( function () {
		jQuery('.btn-action-particular-' + jQuery(this).data('id')).removeClass('d-none').addClass('d-inline');
	 }).mouseleave( function() {
			jQuery('.btn-action-particular-' + jQuery(this).data('id')).removeClass('d-inline').addClass('d-none');
	 })

	 jQuery('li.valid').mouseover( function () {
		jQuery('.btn-action-particular-' + jQuery(this).data('id')).removeClass('d-none').addClass('d-inline');
	}).mouseleave( function() {
			jQuery('.btn-action-particular-' + jQuery(this).data('id')).removeClass('d-inline').addClass('d-none');
	})

	jQuery('li.finish').mouseover( function () {
		jQuery('.btn-action-particular-' + jQuery(this).data('id')).removeClass('d-none').addClass('d-inline');
	}).mouseleave( function() {
			jQuery('.btn-action-particular-' + jQuery(this).data('id')).removeClass('d-inline').addClass('d-none');
	})
	 
	 //show message by pro candidate
	 jQuery('.btn-link-view-letter-pro').click(function() {
		Swal.fire({
		  title: 'MESSAGE',
		  html: '<div class="d-flex justify-content-center">'+
					'<span class="lnr lnr-envelope text-secondary"></span>'+
					'<p class=" p-2 text-left text-small text-secondary">'
						+ jQuery(this).data('message') +
					'</p>'+
				'</div>',
		  //text: 'Modal with a custom image.',
		  confirmButtonColor: 'rgb(255, 144, 0)',
		  //customClass: {icon: 'lnr lnr-envelope'},
		  animation: false
		});
	 })

	//show form to evaluate pro candidate
	jQuery('.btn-show-form-add-avis').click(function() {
		jQuery('#user_pros_id').val(jQuery(this).data('id'));
		jQuery('#modal-form-evaluation').modal('show');

	})

	//AJAX POST PRO EVALUATE
	jQuery('.btn-record-evaluation').click(function() {
		
		var form_record = jQuery('#form-add-evaluation');
		jQuery.ajax({
			type: 'POST',
			url: '/particulier/post-evaluations',
			contentType: false,
			processData: false,
			cache:false,
			dataType:'json',
			data: new FormData(form_record[0])
				
		}).done(function(response){
			
			jQuery('#modal-form-evaluation').modal('hide');

			Swal.fire({
				title: 'Reponse',
				html:'<span class="text-success font-weight-bol">' + response.info + '</span>',
				type: 'success',
				background: 'rgb(119, 119, 119)',
				backdrop: `rgba(0,0,123,0.4)`,
				confirmButtonColor: 'rgb(255, 144, 0)'
				})
				
			}).fail(function(){
			// Here you should treat the http errors (e.g., 403, 40
				Swal.fire({
					title: 'Reponse',
					text: 'Erreur dans le serveur interne!!',
					type: 'error',
					background: 'rgb(119, 119, 119)',
					backdrop: `rgba(0,0,123,0.4)`,
					confirmButtonColor: 'rgb(255, 144, 0)'
					})
					
				}).always(function(){
					console.log("AJAX request finished!");
				})

	})

	//AJAX POST PRO EVALUATE
	jQuery('.btn-update-psswd').click(function() {
		
		var form_record = jQuery('#form-update-password');
		jQuery.ajax({
			type: 'POST',
			url: '/particulier/part-password-edit',
			contentType: false,
			processData: false,
			cache:false,
			dataType:'json',
			data: new FormData(form_record[0])
				
		}).done(function(response){
			
			form_record[0].reset();

			Swal.fire({
				title: 'Reponse',
				html:'<span class="text-success font-weight-bol">' + response.info + '</span>',
				type: 'success',
				background: 'rgb(119, 119, 119)',
				backdrop: `rgba(0,0,123,0.4)`,
				confirmButtonColor: 'rgb(255, 144, 0)'
				})
				
			}).fail(function(){
			// Here you should treat the http errors (e.g., 403, 40
				Swal.fire({
					title: 'Reponse',
					text: 'Erreur dans le serveur interne!!',
					type: 'error',
					background: 'rgb(119, 119, 119)',
					backdrop: `rgba(0,0,123,0.4)`,
					confirmButtonColor: 'rgb(255, 144, 0)'
					})
					
				}).always(function(){
					console.log("AJAX request finished!");
				})

	})

	//AJAX POST Particular COMMENTS
	jQuery('.btn-add-comment').click(function() {
		
		var form_record = jQuery('#form-add-comment');
		jQuery.ajax({
			type: 'POST',
			url: '/particulier/post-comments-particular',
			contentType: false,
			processData: false,
			cache:false,
			dataType:'json',
			data: new FormData(form_record[0])
				
		}).done(function(response){
			
			form_record[0].reset();

			Swal.fire({
				title: 'Reponse',
				html:'<span class="text-success font-weight-bol">' + response.info + '</span>',
				type: 'success',
				background: 'rgb(119, 119, 119)',
				backdrop: `rgba(0,0,123,0.4)`,
				confirmButtonColor: 'rgb(255, 144, 0)'
				})
				
			}).fail(function(){
			// Here you should treat the http errors (e.g., 403, 40
				Swal.fire({
					title: 'Reponse',
					text: 'Erreur dans le serveur interne!!',
					type: 'error',
					background: 'rgb(119, 119, 119)',
					backdrop: `rgba(0,0,123,0.4)`,
					confirmButtonColor: 'rgb(255, 144, 0)'
					})
					
				}).always(function(){
					console.log("AJAX request finished!");
				})

	})



	//POST Image PROFIL
	var readURL = function(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('.profile-pic').attr('src', e.target.result);
			}
    
			reader.readAsDataURL(input.files[0]);
		}
	}
    
	$(".file-upload").on('change', function(){
		readURL(this);
		var form_imgs = $('#form-upload-profil')[0];
		var file_data =  $(this).prop('files')[0];

		if(file_data != undefined) {
			
			jQuery.ajax({
				type: 'POST',
				url: '/particulier/edit-profil',
				contentType: false,
				processData: false,
				cache:false,
				dataType:'json',
				data: new FormData(form_imgs)
				
			}).done(function(response){
				
				Swal.fire({
					position: 'top-end',
					type: 'success',
					title: response.info,
					showConfirmButton: false,
					timer: 3000,
					backdrop: 'rgba(44, 221, 71, 0.4)'
					})

				}).fail(function(){
					Swal.fire({
						position: 'top-end',
						type: 'error',
						title: 'Eurrer de serveur interne!',
						showConfirmButton: false,
						timer: 3000,
						backdrop: 'rgba(255, 0, 0, 0.4)'
						})

					}).always(function(){
						console.log("AJAX request finished!");
					});
		}
		return false;

	});
    
	$(".upload-button").on('click', function() {
	$(".file-upload").click();
	});

	//Refresh page
	//location.reload(true);

 })
 
