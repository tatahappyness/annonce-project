$(document).ready(function(){

	//IMAGE UPLOAD
	$('input[id=fileImages]').change(function () {

		var form_imgs = $('#form-upload-images')[0];
		var file_data =  $(this).prop('files')[0];
		var block = $('<div class="block"></div>');
		var progressBar = $('<div class="progressBar"></div>');
		var cancelButton = $('<div class="cancelButton">x</div>');

		cancelButton.click(function() {
			//upload cancelled
			block.fadeOut(400, function() {
				$(this).remove();
			});
		});

		block.append(progressBar).append(cancelButton);
		$('#uploads').append(block);
		
		progressBar.width(Math.floor(Math.random() * 100) + "%");

		if(file_data != undefined) {
			
			jQuery.ajax({
				type: 'POST',
				url: '/pro/image-chantier-realize-edit',
				contentType: false,
				processData: false,
				cache:false,
				dataType:'json',
				data: new FormData(form_imgs)
				
			}).done(function(response){
				
				//upload successful
				progressBar.remove();
				cancelButton.remove();
				//var data = JSON.parse(response);
				//alert(response.infos);
				
				var errorDiv = '<img class="format text-dark" width="120" height="80" src="/uploads/images/' +  response.infos + '" style="margin-top: 0!important;"></img>';
				block.append(errorDiv);

				}).fail(function(){
				// Here you should treat the http errors (e.g., 403, 40
					progressBar.remove();
					cancelButton.remove();
					var errorDiv = $('<div class="error"></div>').text('Echoué!!');
					block.append(errorDiv);
					
					}).always(function(){
						console.log("AJAX request finished!");
					});
		}
		return false;
					

	});
	//END IMAGE UPLOAD


	//LOGO UPLOAD
	$('input[id=logo-upload]').change(function () {

		var form_imgs = $('#form-logo-pro')[0];
		var file_data =  $(this).prop('files')[0];
		var block = $('<div class="block"></div>');
		var progressBar = $('<div class="progressBar"></div>');
		var cancelButton = $('<div class="cancelButton">x</div>');

		cancelButton.click(function() {
			//upload cancelled
			block.fadeOut(400, function() {
				$(this).remove();
			});
		});

		block.append(progressBar).append(cancelButton);
		$('#uploads').append(block);
		
		progressBar.width(Math.floor(Math.random() * 100) + "%");

		if(file_data != undefined) {
			
			jQuery.ajax({
				type: 'POST',
				url: '/pro/edit-logo',
				contentType: false,
				processData: false,
				cache:false,
				dataType:'json',
				data: new FormData(form_imgs)
				
			}).done(function(response){
				
				//upload successful
				progressBar.remove();
				cancelButton.remove();
				//var data = JSON.parse(response);
				//alert(response.info);
				
				var errorDiv = '<img class="format text-dark" width="120" height="80" src="/uploads/logo/' +  response.info + '" style="margin-top: 0!important;"></img>';
				block.append(errorDiv);

				}).fail(function(){
				// Here you should treat the http errors (e.g., 403, 40
					progressBar.remove();
					cancelButton.remove();
					var errorDiv = $('<div class="error"></div>').text('Echoué!!');
					block.append(errorDiv);
					
					}).always(function(){
						console.log("AJAX request finished!");
					});
		}
		return false;
					

	});
	//END LOGO UPLOAD
		
		
		
	//VIDEO UPLOAD
	$('.btn-video-url-save').click(function() {
		
		var form = $('#form-upload-video');
			//console.log(form[0]); return false;
			jQuery.ajax({
				type: 'POST',
				url: '/pro/video-chantier-realize-edit',
				contentType: false,
				processData: false,
				cache:false,
				dataType:'json',
				data: new FormData(form[0])
				
			}).done(function(response) {
				
				Swal.fire({
					title: 'Reponse',
					text: response.infos,
					type: 'success',
					// background: 'rgb(119, 119, 119)',
					backdrop: `rgba(0,0,123,0.4)`,
					confirmButtonColor: 'rgb(255, 144, 0)'
					});
				
				}).fail(function() {
				// Here you should treat the http errors (e.g., 403, 40
				
				Swal.fire({
					title: 'Reponse',
					text: 'serveur interne euror!',
					type: 'error',
					// background: 'rgb(119, 119, 119)',
					backdrop: `rgba(0,0,123,0.4)`,
					confirmButtonColor: 'rgb(255, 144, 0)'
					});

					}).always(function(){
						console.log("AJAX request finished!");
					});
		
		
	});
	//END VIDEO UPLOAD
		
	
	
	//FILE DOC UPLOAD
	$('input[id=fileDocumentCompany]').change(function () {
	
		var form_data = $('#form-upload-documents');
		var file_data = $(this).prop('files')[0];
			
		var block = $('<div class="block"></div>');
		var progressBar = $('<div class="progressBar"></div>');
		var cancelButton = $('<div class="cancelButton">x</div>');

		cancelButton.click(function(){
			//upload cancelled
			block.fadeOut(400, function(){
				$(this).remove();
			});
		});

		block.append(progressBar).append(cancelButton);
		$('#uploads').append(block);
		
		if(file_data != undefined) {
                 
			progressBar.width(Math.floor(Math.random() * 100) + "%");
			
			jQuery.ajax({
				type: 'POST',
				url: '/pro/document-file-edit',
				contentType: false,
				processData: false,
				cache:false,
				dataType:'json',
				data: new FormData(form_data[0])
				
			}).done(function(response){
				
				//upload successful
				progressBar.remove();
				cancelButton.remove();
				var errorDiv = '<img class="format text-dark" src="/uploads/documents/' + response.info + '" style="margin-top: 0!important;"></img>';
				block.append(errorDiv);
				
				}).fail(function(){
				// Here you should treat the http errors (e.g., 403, 40
					progressBar.remove();
					cancelButton.remove();
					var errorDiv = $('<div class="error"></div>').text(response.info);
					block.append(errorDiv);
					
					}).always(function(){
						console.log("AJAX request finished!");
					});
			}
			return false;

	});
	//FILE DOC UPLOAD

	//LABEL QUALITY
	$('input[id=fileLabelQuality]').change(function () {
	
		var form_data = $('#form-upload-labels-quality');
		var file_data = $(this).prop('files')[0];
			
		var block = $('<div class="block-label"></div>');
		var progressBar = $('<div class="progressBar"></div>');
		var cancelButton = $('<div class="cancelButton">x</div>');

		cancelButton.click(function(){
			//upload cancelled
			block.fadeOut(400, function(){
				$(this).remove();
			});
		});

		block.append(progressBar).append(cancelButton);
		$('#uploads').append(block);
		
		if(file_data != undefined) {
                 
			progressBar.width(Math.floor(Math.random() * 100) + "%");
			
			jQuery.ajax({
				type: 'POST',
				url: '/pro/label-quality-edit',
				contentType: false,
				processData: false,
				cache:false,
				dataType:'json',
				data: new FormData(form_data[0])
				
			}).done(function(response){
				
				//upload successful
				progressBar.remove();
				cancelButton.remove();
				var errorDiv = '<img class="format text-dark" src="/uploads/profil/' + response.info + '" style="margin-top: 0!important;"></img>';
				block.append(errorDiv);
				
				}).fail(function(){
				// Here you should treat the http errors (e.g., 403, 40
					progressBar.remove();
					cancelButton.remove();
					var errorDiv = $('<div class="error"></div>').text(response.info);
					block.append(errorDiv);
					
					}).always(function(){
						console.log("AJAX request finished!");
					});
			}
			return false;

	});
	//LABEL QUALITY


});