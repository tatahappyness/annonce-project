//PAGE LOADER
$(document).ready(function() {
	
	$('form, .form-container-devis').addClass('animated slideInRight delay-1s');
	$('.card, .img-new-pro-container, .img-container-popular').addClass('animated fadeInUp delay-1s');
	$('h6, h4, h2, a, button, input, select, .icon').addClass('animated pulse delay-1s');
	$('.logo').addClass('animated fadeInLeft delay-1s');
	$('.free-img, .img, .pro-icon, .title-part').addClass('animated fadeInUp delay-1s');

	  //how form connexion user login
	   $('#my-form-particular-register').modal("hide");
	   $('#my-form-register').modal("show");

	// Form find pro space
	$('.show-input-list-metier-pro').select2({
		//theme: 'bootstrap',
		width: '100%',
		language: 'fr',
		placeholder: 'Quel métier ?',
		//selectOnClose: true
		
	});
	
	//Menu list Appartement type ajax
	$('.appartement_type').select2({
		//theme: 'bootstrap',
		width: '100%',
		language: 'fr',
		placeholder: 'Quel type de bâtiment ?',
		//selectOnClose: true
		
	});
	
	  
	 $(window).scroll(function(){
		 $(".animate").addClass('animated fadeIn delay-2s');
        var scroll = $(window).scrollTop();
        if (scroll > 50) {
			$(".navbar-menu").css("background" , "rgba(17, 20, 30, 50%)").addClass('fixed-top');
			$(".menu").css("background" , "rgba(17, 20, 30, 50%)");
        }
    
        else{
			$(".navbar-menu").css("background" , "rgb(255, 144, 0)").removeClass('fixed-top');
			$(".menu").css("background" , "rgb(255, 144, 0)");	
        }
    });
	
	//Swiper slide for accueil
	 var swiper = new Swiper('.swiper-container-front', {
		  lazy: true,
		  direction: 'horizontal',
		  effect: 'coverflow',
		  grabCursor: true,
		  centeredSlides: true,
		  slidesPerView: 'auto',
		  coverflowEffect: {
			rotate: 50,
			stretch: 0,
			depth: 100,
			modifier: 1,
			slideShadows : true,
		  },
		  spaceBetween: 30,
		  centeredSlides: true,
		  autoplay: {
			delay: 5500,
			disableOnInteraction: false,
		  },
		  pagination: {
			el: '.swiper-pagination',
			clickable: false,
		  },
    });
	
	//Swiper for gallery image of travaux pro
	var galleryThumbs = new Swiper('.gallery-thumbs', {
      spaceBetween: 10,
      slidesPerView: 3,
      loop: true,
      freeMode: true,
      loopedSlides: 5, //looped slides should be the same
      watchSlidesVisibility: true,
      watchSlidesProgress: true,
    });
    var galleryTop = new Swiper('.gallery-top', {
      spaceBetween: 10,
      loop:true,
      loopedSlides: 5, //looped slides should be the same
      thumbs: {
        swiper: galleryThumbs,
      },
    });
	
	//Swiper for gallery video of  pro detail info
	var galleryThumbs = new Swiper('.gallery-thumbs-video', {
      spaceBetween: 10,
      slidesPerView: 3,
      loop: true,
      freeMode: true,
      loopedSlides: 5, //looped slides should be the same
      watchSlidesVisibility: true,
      watchSlidesProgress: true,
    });
    var galleryTop = new Swiper('.gallery-top-video', {
		spaceBetween: 10,
		loop:true,
		loopedSlides: 5, //looped slides should be the same
		thumbs: {
			swiper: galleryThumbs,
		},
	});
	
	//Swipper sites galery 3D
	var mySwiper = new Swiper('.swiper-container-sites',{
		slidesPerView:3,
		loop:true,
		//Enable 3D Flow
		tdFlow: {
			rotate : 30,
			stretch :10,
			depth: 150,
			modifier : 1,
			shadows:true
		}
	});
	
	
	//Show btn popular devis
	 $('.popular-container-img-1').mouseover(function(){
		 $('.btn-popular-devis').removeClass('d-none');
	 }).mouseleave(function() {
		 $('.btn-popular-devis').addClass('d-none');
	 })
	 //show btn on travaux gallery pro
	 $('.swiper-slide-gallery').mouseover(function(){
		 $('.btn-popular-devis').removeClass('d-none');
	 }).mouseleave(function() {
		 $('.btn-popular-devis').addClass('d-none');
	 })
	 
	 //show form modal register particular and loogin form
	  $('.show-form-pro-mouseclick-11').click(function() {
		 document.location.href = "/login";
	 })
	 $('.show-form-pro-mouseclick').click(function() {
		  $('#my-form-particular-register').modal("hide");
		  $('#my-form-register').modal("show");
	 })
	 
	 $('.show-form-pro-mouseover').mouseover(function() {
		document.location.href = "/login";
	 })

	 $('.show-particular-inscription').click(function() {
		$('#my-form-register').modal("hide");
		$('#my-form-particular-register').modal("show");
	 })
	 $('.btn-annule').click(function() {
		$('#my-form-register').modal("hide");
	 })
	 
	 //show icon pro icon-pro-img-over on hover mouse
	 $('.img-new-pro-content').mouseover(function(){
		 $('.icon-pro-img-over').removeClass('d-none');
	 }).mouseleave(function() {
		 $('.icon-pro-img-over').addClass('d-none');
	 })
	 
	//SLIDER TOP POPULAR DEVIS
	$(document).ready(function() {
		$('.button-slid').click(function() {
			$(this).parents('.sliderComplete').children('button').removeClass('close').fadeIn(300);
	
			// The button, that was visible, goes on display none.
			$(this).addClass('close').fadeOut(300);
	
			// We do a fluid slider with the class '.turn'.
			$(this).parents('.sliderComplete').children('.wrapper').children('.slider').toggleClass('turn');
		});
	});

	
}); // END DoCUMENT READY


//PAGE SCROLL DOWN UP DETECTED
// Initial state
var scrollPos = 0;
// adding scroll event
window.addEventListener('scroll', function(){
	// detects new state and compares it with the new one
	if ((document.body.getBoundingClientRect()).top > scrollPos) {

		$('.img-new-pro-container, .img-container-popular').toggleClass('animated fadeInUp delay-1s');
		$('h6, h4, h2, h5, h1, a, button, input, select, .icon').toggleClass('animated pulse delay-1s');
		$('.logo').toggleClass('animated fadeInLeft delay-1s');
		$('.free-img, .img, .pro-icon, .title-part').toggleClass('animated fadeInUp delay-1s');
	}
	else {
		
		$('.img-new-pro-container, .img-container-popular').addClass('animated fadeInUp delay-1s');
		$('h6, h4, h2, a, button, input, select, .icon').addClass('animated pulse delay-1s');
		$('.logo').addClass('animated fadeInLeft delay-1s');
		$('.free-img, .img, .pro-icon, .title-part').addClass('animated fadeInUp delay-1s');
		// saves the new position for iteration.
		scrollPos = (document.body.getBoundingClientRect()).top;
	}

});

 
// When the user scrolls the page, execute myFunction 
window.onscroll = function() {myFunction()};

function myFunction() {
  var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
  var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  var scrolled = (winScroll / height) * 100;
  document.getElementById("myBar").style.width = scrolled + "%";
  
}

//ZOOM Image Gallery Pro
function zoom(e){
  var zoomer = e.currentTarget;
  e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX
  e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX
  x = offsetX/zoomer.offsetWidth*100
  y = offsetY/zoomer.offsetHeight*100
  zoomer.style.backgroundPosition = x + '% ' + y + '%';
}


//SEND NEW LETTER
jQuery('.btn-new-letter-send').click(function() {

	var form_record = jQuery('#form-new-letter');
	//AJAX TO REGISTER USERS HERE
	jQuery.ajax({
		type: 'POST',
		url: '/new-letter',
		contentType: false,
		processData: false,
		cache:false,
		dataType:'json',
		data: new FormData(form_record[0])
				
	}).done(function(response){
				
		Swal.fire({
			title: 'Reponse',
			text: response.info,
			type: 'success',
			// background: 'rgb(119, 119, 119)',
			backdrop: `rgba(0,0,123,0.4)`,
			confirmButtonColor: 'rgb(255, 144, 0)'
			});

			form_record[0].reset();

			//Refresh page
			//location.reload(true);
				
		}).fail(function(response){
		// Here you should treat the http errors (e.g., 403, 40
			Swal.fire({
				title: 'Reponse',
				text:  response.info,
				type: 'error',
				// background: 'rgb(119, 119, 119)',
				backdrop: `rgba(0,0,123,0.4)`,
				confirmButtonColor: 'rgb(255, 144, 0)'
				});
            
					
			}).always(function(){
				console.log("AJAX request finished!");
			});


})



//reCapchat
	grecaptcha.ready(function() {
      grecaptcha.execute('6Leez8MUAAAAAPSJV-XSed3I8osrCw4yCpSbA4F7', {action: 'homepage'}).then(function(token) {
          console.log(token);
      });
	});