$(document).ready(function(){

	//IMAGE UPLOAD
	$('input[class=fileImages]').change(function () {

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
				alert(response.infos);
				
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
		
		
		
	//VIDEO UPLOAD
	$('input[id=fileVideos]').change(function(){
		
		var file_data = $(this).prop('files')[0];
		var form = $('#form-upload-images')[0];
		//verify taill of videos file
		if( file_data.size > 8388608 ) {
			alert("Désolé, votre fichier est trop large, inférieur à 10Mo autorisé.");
			return false;
		}
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
			
			jQuery.ajax({
				type: 'POST',
				url: '/pro/video-chantier-realize-edit',
				contentType: false,
				processData: false,
				cache:false,
				dataType:'json',
				data: new FormData(form)
				
			}).done(function(response){
				
				progressBar.remove();
				cancelButton.remove();
				//var data = JSON.parse(response);
				alert(response.infos);
				var errorDiv = '<video class="format" width="120" height="80" controls style="margin-top: 0!important;">'+
								'<source src="/uploads/videos/' +response.infos+ '" type="video/mp4">'+
								'</video>';
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
	//END VIDEO UPLOAD
		
	
	
	//FILE DOC UPLOAD
	$('input[id=fileDocumentCompany]').change(function () {
	
		var formData = new FormData();
		var file_data = $(this).prop('files')[0];
		var document_title_data = $('input[id=document_title]').val();
			
		var block = $('<div class="block"></div>');
		var progressBar = $('<div class="progressBar"></div>');
		var cancelButton = $('<div class="cancelButton">x</div>');
		
		var that = this;

		cancelButton.click(function(){
			//upload cancelled
			block.fadeOut(400, function(){
				$(this).remove();
			});
		});

		block.append(progressBar).append(cancelButton);
		$('#uploads').append(block);
		
		if(file_data != undefined) {
			
			var form_data = new FormData();                  
			form_data.append('fileDocumentCompany', file_data);
			form_data.append('document_title',  document_title_data);
			
			progressBar.width(Math.floor(Math.random() * 100) + "%");
			
			jQuery.ajax({
				type: 'POST',
				url: './upload.php',
				//dataType: 'text',  // what to expect back from the PHP script, if anything
				//cache: false,
				contentType: false,
				processData: false,
				//enctype: 'multipart/form-data',
				data: form_data
				
			}).done(function(response){
				
				//upload successful
				progressBar.remove();
				cancelButton.remove();
				var data = JSON.parse(response);
				alert(data.title);
				var errorDiv = '<img class="format text-dark" src="{{ file_relative("/uploads/documents/"' +data+ '") }}" style="margin-top: 0!important;"></img>';
				this.block.append(errorDiv);
				
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
	//FILE DOC UPLOAD

	//LABEL QUALITY

	//LABEL QUALITY


});