"use strict";
jQuery(document).on('ready', function() {
	/* -------------------------------------
			COLLAPSE MENU SMALL DEVICES
	-------------------------------------- */
	function collapseMenu(){
		jQuery('.menu-item-has-children').prepend('<span class="tg-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>');
		jQuery('.menu-item-has-children span').on('click', function() {
			jQuery(this).next().next().slideToggle(300);
			jQuery(this).parent('.menu-item-has-children').toggleClass('tg-open');
		});
	}
	collapseMenu();
	/* -------------------------------------
			SCROLLBAR
	-------------------------------------- */
	jQuery('.tg-themescrollbar, .tg-emailnavscroll').mCustomScrollbar({
		axis:"y",
	});
	jQuery('.tg-horizontalthemescrollbar').mCustomScrollbar({
		axis:"x",
	});
	/* -------------------------------------
			THEME ACCORDION
	-------------------------------------- */
	jQuery('.tg-panelcontent').hide();
	jQuery('.tg-accordion .tg-accordionheading:first').addClass('tg-active').next().slideDown('slow');
	jQuery('.tg-accordion .tg-accordionheading').on('click',function() {
		if(jQuery(this).next().is(':hidden')) {
			jQuery('.tg-accordion .tg-accordionheading').removeClass('tg-active').next().slideUp('slow');
			jQuery(this).toggleClass('tg-active').next().slideDown('slow');
		}
	});
	/* -------------------------------------
			FEATURED PROFILE SLIDER
	-------------------------------------- */
	var _tg_featuredprofileslider = jQuery('#tg-featuredprofileslider');
	_tg_featuredprofileslider.owlCarousel({
		items:1,
		nav:true,
		loop:true,
		autoplay:false,
		smartSpeed:450,
		navClass: ['tg-btnprev', 'tg-btnnext'],
		animateOut: 'fadeOut',
		animateIn: 'fadeIn',
		navContainerClass: 'tg-featuredprofilesbtns',
		navText: [
					'<span><em>prev</em><i class="fa fa-angle-left"></i></span>',
					'<span><i class="fa fa-angle-right"></i><em>next</em></span>',
				],
	});
	/* -------------------------------------
			TESTIMONIALS SLIDER
	-------------------------------------- */
	var sync1 = jQuery("#tg-testimonialcontentslider");
	var sync2 = jQuery("#tg-testimonialnavigationslider");
	var slidesPerPage = 5;
	var syncedSecondary = true;
	sync1.owlCarousel({
		items : 1,
		loop: true,
		nav: false,
		dots: false,
		autoplay: true,
		slideSpeed : 2000,
		responsiveRefreshRate : 200,
		navText: ['<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>','<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
	}).on('changed.owl.carousel', syncPosition);
	sync2.on('initialized.owl.carousel', function () {
		sync2.find(".owl-item").eq(0).addClass("current");
	})
	.owlCarousel({
		items : slidesPerPage,
		dots: false,
		nav: false,
		margin: 5,
		smartSpeed: 200,
		slideSpeed : 500,
		slideBy: slidesPerPage,
		responsiveRefreshRate : 100,
		
	}).on('changed.owl.carousel', syncPosition2);
	function syncPosition(el) {
		var count = el.item.count-1;
		var current = Math.round(el.item.index - (el.item.count/2) - .5);
		if(current < 0) {
			current = count;
		}
		if(current > count) {
			current = 0;
		}
		sync2
		.find(".owl-item")
		.removeClass("current")
		.eq(current)
		.addClass("current")
		var onscreen = sync2.find('.owl-item.active').length - 1;
		var start = sync2.find('.owl-item.active').first().index();
		var end = sync2.find('.owl-item.active').last().index();
		var currentValue = jQuery("#tg-testimonialnavigationslider .owl-item.current figure img").attr('src');
		jQuery('.tg-clientlargedp').find('img').attr('src', currentValue);
		if (current > end) {
			sync2.data('owl.carousel').to(current, 100, true);
		}
		if (current < start) {
			sync2.data('owl.carousel').to(current - onscreen, 100, true);
		}
	}
	function syncPosition2(el) {
		if(syncedSecondary) {
			var number = el.item.index;
			sync1.data('owl.carousel').to(number, 100, true);
		}
	}
	sync2.on("click", ".owl-item", function(e){
		e.preventDefault();
		var number = jQuery(this).index();
		sync1.data('owl.carousel').to(number, 300, true);
	});
	jQuery('#tg-testimonialnavigationslider .owl-item figure img').on('click', function(){
		var _this = jQuery(this).attr('src');
		jQuery('.tg-clientlargedp').find('img').attr('src', _this);
	});
	/* -------------------------------------
			PRETTY PHOTO GALLERY
	-------------------------------------- */
	jQuery("a[data-rel]").each(function () {
		jQuery(this).attr("rel", jQuery(this).data("rel"));
	});
	jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
		animation_speed: 'normal',
		theme: 'dark_square',
		slideshow: 3000,
		autoplay_slideshow: false,
		social_tools: false
	});
	/* -------------------------------------
			ONE SLIDE SLIDER SHORTCODE
	-------------------------------------- */
	var _tg_oneslideslidershortcode = jQuery('.tg-oneslideslidershortcode');
	_tg_oneslideslidershortcode.owlCarousel({
		loop: true,
		margin: 0,
		nav: true,
		items : 1,
		navText: [
					'<span class="tg-btnroundsmallprev"><i class="fa fa-angle-left"></i></span>',
					'<span class="tg-btnroundsmallnext"><i class="fa fa-angle-right"></i></span>',
		],
	});
	/* -------------------------------------
			TIMESLOT DELETE
	-------------------------------------- */
	jQuery(document).on("click",".tg-radiotimeslot .tg-btndelete", function (e) {
		e.preventdefault;
		jQuery(this).parents('.tg-radiotimeslot').fadeOut(300);
	});
	/* -------------------------------------
			REFINE SEARCH TOGGLE
	-------------------------------------- */
	var _tg_btnadvancefilters = jQuery('#tg-btnadvancefilters');
	_tg_btnadvancefilters.on('click', function(event) {
		event.preventDefault();
		jQuery('.tg-advancedfilters').slideToggle(1000);
	});
	/* -------------------------------------
			SHOW EMAIL AND NUMBER
	-------------------------------------- */
	var _clickelement = jQuery('ul.tg-companycontactinfo li');
	_clickelement.on('click', 'span', function() {
		jQuery(this).find('em').text(jQuery(this).data('last') );
	});
	/* -------------------------------------
			THEME TOOLTIP
	-------------------------------------- */
	jQuery('[data-toggle="tooltip"]').tooltip()
	/* -------------------------------------
			CALENDAR
	-------------------------------------- */
	jQuery('#tg-datepicker')
	.datepicker({
		format: 'mm/dd/yyyy'
	})
	/* --------------------------------------
			SHORT DESCRIPTION				
	-------------------------------------- */
	var _readmore = jQuery('.tg-introduction .tg-description');
	_readmore.readmore({
		speed: 500,
		collapsedHeight: 140,
		moreLink: '<a class="tg-btntext" href="#">more...</a>',
		lessLink: '<a class="tg-btntext" href="#">less...</a>',
	});
	/* --------------------------------------
			LOAD MORE FEEDBACK
	-------------------------------------- */
	function loadMoreFeedback() {
		jQuery(".tg-feedback").slice(0, 3).show();
		jQuery(".tg-btnloadmore").on('click', function (e) {
			e.preventDefault();
			jQuery(".tg-feedback:hidden").slice(0, 3).slideDown();
			if (jQuery(".tg-feedback:hidden").length == 0) {
				jQuery(".tg-btnloadmore").fadeOut('slow');
			}
			jQuery('html,body').animate({
				scrollTop: jQuery(this).offset().top -30
			}, 1500);
		});
	}
	loadMoreFeedback();
	/* -------------------------------------
			Google Map
	-------------------------------------- */
	jQuery("#tg-officelocationmap").gmap3({
		marker: {
			address: "1600 Elizabeth St, Melbourne, Victoria, Australia",
			options: {
				title: "Service Providers",
				icon: "images/map-marker2.png",
			}
		},
		map: {
			options: {
				zoom: 16,
				scrollwheel: false,
				disableDoubleClickZoom: true,
			}
		}
	});
	/* --------------------------------------
			FORM STEP PROGRESS
	-------------------------------------- */
	function formSteps(){
		jQuery('.tg-btnnext').on('click', function () {
			jQuery('.tg-current').removeClass('tg-current').hide().next().show().addClass('tg-current');
			jQuery('.tg-formprogressbar li.tg-active').next().addClass('tg-active');
			if (jQuery('.tg-formprogressbar')) {};
		});
		jQuery('.tg-btnprevious').on('click', function () {
			jQuery('.tg-current').removeClass('tg-current').hide().prev().show().addClass('tg-current');
			jQuery('.tg-formprogressbar li.tg-active').removeClass('tg-active').prev().addClass('tg-active');
		});
	}
	formSteps();
	/*--------------------------------------
			Google Map
	--------------------------------------*/
	jQuery("#tg-locationmap").gmap3({
		marker: {
			address: "1600 Elizabeth St, Melbourne, Victoria, Australia",
			options: {
				title: "Robert Frost Elementary School",
				icon: "images/icons/markerseven.png",
			}
		},
		map: {
			options: {
				zoom: 20,
				scrollwheel: false,
				disableDoubleClickZoom: true,
			}
		}
	});
	/*--------------------------------------
			JOB LOCATION Map
	--------------------------------------*/
	jQuery("#tg-joblocationmap").gmap3({
		marker: {
			address: "1600 Elizabeth St, Melbourne, Victoria, Australia",
			options: {
				title: "Robert Frost Elementary School",
				icon: "images/icons/markertwo.png",
			}
		},
		map: {
			options: {
				zoom: 18,
				scrollwheel: false,
				disableDoubleClickZoom: true,
			}
		}
	});
	/* -------------------------------------
			CURRENT DAY
	-------------------------------------- */
	function currentDay(){
		var d = new Date();
		var n = d.getDay();
		n = n > 0 ? n - 1 : 6; // zero is sunday, not monday in javascript
		$('.tg-widgetbusinesshours .tg-widgetcontent ul li').eq(n).addClass('tg-currentday');
	}
	currentDay();
	/* -------------------------------------
			FEE RANGE SLIDER
	-------------------------------------- */
	function rangeBySalerySlider(){
		jQuery("#tg-filterbysalary").slider({
			range: true,
			min: 0,
			max: 500,
			values: [ 75, 300 ],
			slide: function( event, ui ) {
				jQuery( "#tg-salaryamount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
			}
		});
		jQuery( "#tg-salaryamount" ).val( "$" + jQuery( "#tg-filterbysalary" ).slider( "values", 0 ) + " - $" + jQuery( "#tg-filterbysalary" ).slider( "values", 1 ) );
	}
	rangeBySalerySlider();
	/* --------------------------------------
			GEO LOCATION SLIDER
	-------------------------------------- */
	var _geo_distance = jQuery( "#geo_distance" );
	_geo_distance.slider({
		range: "min",
		min:1,
		max:300,
		value:50,
		animate:"slow",
		orientation: "horizontal",
		slide: function( event, ui ) {
		jQuery( ".distance-ml span" ).html( ui.value );
		jQuery( ".geo_distance" ).val( ui.value );
		}	
	});
	
	//Toogle Radius Search
	jQuery(document).on('click','.geodistance',function(){
		jQuery('.geodistance_range').toggle();
	});
	/* --------------------------------------
			COUNTER
	-------------------------------------- */
	function expireyCounter(){
		var note = jQuery('#tg-note'),
			ts = new Date(2017, 12, 31),
			newYear = true;
		if((new Date()) > ts){
			ts = (new Date()).getTime() + 10*24*60*60*1000;
			newYear = false;
		}
		jQuery('#tg-countdown').countdown({
			timestamp	: ts,
			callback	: function(days, hours, minutes, seconds){
				var message = "";
				message += days + " day" + ( days==1 ? '':'s' ) + ", ";
				message += hours + " hour" + ( hours==1 ? '':'s' ) + ", ";
				message += minutes + " minute" + ( minutes==1 ? '':'s' ) + " and ";
				message += seconds + " second" + ( seconds==1 ? '':'s' ) + " <br />";
				/*if(newYear){
					message += "left until the new year!";
				}
				else {
					message += "left to 10 days from now!";
				}*/
				note.html(message);
			}
		});
	}
	expireyCounter();
	/* -------------------------------------
			DASHBOARD LEFT NAV TOGGLE
	-------------------------------------- */
	jQuery('.tg-btntoggle').on('click', function(event) {
		event.preventDefault();
		var _this	= jQuery(this);
		_this.parents('li').toggleClass('tg-openmenu');
		_this.parents('li').find('.tg-emailmenu').slideToggle('slow');
	});
	/* -------------------------------------
			STICKY DIV IN PARENT
	-------------------------------------- */
	jQuery(window).scroll(function(){
		if (jQuery(this).scrollTop() > 350) {
			jQuery('#tg-updateall').fadeIn();
			jQuery('#tg-updateall').addClass('tg-show');
		} else {
			jQuery('#tg-updateall').fadeOut();
		}
	});
	
});
/* -------------------------------------
		PRELOADER
-------------------------------------- */
jQuery(window).load(function() {
	jQuery(".preloader-outer").delay(2000).fadeOut();
	jQuery(".pins").delay(2000).fadeOut("slow");
});