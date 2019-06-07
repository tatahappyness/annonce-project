$( document ).ready(function() {
    jQuery('#tg-featuredprofileslider').owlCarousel({
        items:1,
        nav:true,
        loop:true,
        autoplay:true,
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
});