(function ($) {
    "use strict";

    $.fn.magnificinfinitescroll = function(options) {
        if(jQuery().magnificPopup){
            jQuery('.ct-js-magnificPortfolioPopupGroup').each(function() { // the containers for all your galleries
                jQuery(this).magnificPopup({
                    type: 'image',
                    delegate: '.ct-js-magnificPortfolioPopup',
                    disableOn: 700,
                    mainClass: 'ct-magnificPopup--image',
                    removalDelay: 160,
                    preloader: true,

                    fixedContentPos: false,
                    gallery:{
                        enabled: true
                    }
                });
            });

            $('.ct-js-magnificPopupMedia').magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: true,

                fixedContentPos: false
            });
            $('.ct-js-magnificPopupImage').magnificPopup({
                disableOn: 700,
                type: 'image',
                mainClass: 'ct-magnificPopup--image',
                removalDelay: 160,
                preloader: true,

                fixedContentPos: false,
                gallery:{
                    enabled: false
                }
            });
        }
    };
    $(document).ready(function(){
        $('.ct-gallery').magnificinfinitescroll();
    })
}(jQuery));