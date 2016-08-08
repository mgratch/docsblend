(function($) {
    "use strict";
    $(document).ready(function () {

        if(($.flexslider)){
            // The slider being synced must be initialized first
            $('.flexslider.woo_flexslider_thumbs').flexslider({
                animation: "slide",
                direction: "horizontal",
                controlNav: false,
                animationLoop: false,
                directionNav: false,
                slideshow: false,
                itemWidth: 125,
                itemHeight: 125,
                itemMargin: 15,
                prevText: "",
                nextText: "",
                asNavFor: '.flexslider.woo_flexslider'
            });
            $('.flexslider.woo_flexslider').flexslider({
                animation: "slide",
                direction: "horizontal",
                easing: "easeOutBounce",
                smoothHeight: false,
                controlNav: false,
                directionNav: true,
                animationLoop: true,
                slideshow: false,
                touch: false,
                prevText: "",
                nextText: "",
                sync: ".flexslider.woo_flexslider_thumbs"
            });
        }
    })
})(jQuery);