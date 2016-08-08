(function (jQuery) {
    "use strict";
    jQuery(document).ready(function () {
        // menu for onepager
        jQuery("nav ul li a[href^='/#']").each(function () {
            var $this = jQuery(this);
            jQuery($this.parent()).removeClass("active").addClass("onepage");
            // remove unnecessary active classes
            $this.parent().removeClass("active");
        });

        if (jQuery("nav ul li").hasClass("onepage")) {
            if (jQuery().pageScroller) {

                if ($devicewidth < 768) {
                    jQuery('body').pageScroller({
                        navigation: '.ct-menuMobile .onepage', sectionClass: 'section', scrollOffset: -70
                    });
                } else {
                    jQuery('body').pageScroller({
                        navigation: '.nav.navbar-nav .onepage', sectionClass: 'section', scrollOffset: -70
                    });
                }
            }
        }
    })
})(jQuery);