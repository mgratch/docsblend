(function ($) {
    "use strict";
$(document).ready(function() {

    $(".owl-carousel-testimonials").owlCarousel({
        items : 1,
        margin:57,
        loop: true,
        slideBy: 1,

        nav: true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        navContainer: '.ct-owlContainer-nav',

        responsive:{
            0:{
                margin:0
            },
            768:{
                stagePadding: 190
            },
            992:{
                stagePadding: 300
            },
            1200: {
                stagePadding: 400
            }
        }

    });


    $(".ct-owlThumbnails").owlCarousel({
        loop: true,
        margin: 15,

        autoplay: true,
        slideBy: 3,
        autoplayHovePause: false,
        autoplayTimeout: 5000,

        responsive: {
            0: {
                items: 3
            },

            321: {
                items: 4
            },

            400: {
                items: 4
            },

            525: {
                items: 6
            },

            768: {
                items: 4
            },

            992: {
                items: 6
            }

        }

    });


    $(".owl-carousel-accordion").owlCarousel({
        items: 1,
        loop: true,

        nav: true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        navContainer: '.ct-owlContainer-nav2'
    });



    $('.featured-owl1').owlCarousel({
        loop:true,

        nav: false,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        navContainer: '.ct-owlContainer-nav',
        slideBy: 5,

        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:3,
                nav:false
            },
            1000:{
                items:5,
                nav:true,
                loop:false
            }
        }
    });

    $('.featured-owl2').owlCarousel({
        items:1,
        loop: true,
        autoHeight:true
    });


});

}(jQuery));