$(document).ready(function() {
	  
	  $('[data-toggle="tooltip"]').tooltip();

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
	  
	  
	 $(window).scroll(function(){
		 $(".animate").addClass('animated fadeIn delay-2s');
        var scroll = $(window).scrollTop();
        if (scroll > 50) {
            $(".navbar-menu").css("background" , "rgba(17, 20, 30, 50%) !important").addClass('fixed-top');
        }
    
        else{
            $(".navbar-menu").css("background" , "#ccc6c6").removeClass('fixed-top');	
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
	 
	//AJAX  AND NOTIFICATION
	 
	 
}); // END DoCUMENT READY

//page loading before
 window.onload = function () {
	
   
  };
  
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

//reCapchat
	grecaptcha.ready(function() {
      grecaptcha.execute('6Lcr-qsUAAAAAPrCqD5Yk1iDIw9xBtzP6KSackqm', {action: 'homepage'}).then(function(token) {
          console.log(token);
      });
	});