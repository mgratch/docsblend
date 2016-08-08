(function($) {
    "use strict";
    $(document).ready(function ($) {
        var $form = $('.variations_form');

        $form.on('found_variation', function (event, variation) {
            fixMainImage();
            var listItem = $('.woo_flexslider li:not(.clone) img[src="' + variation.image_src + '"]').closest('li');
            var index = $('.woo_flexslider li:not(.clone)').index(listItem);

            if(index!=-1){
                $('.woo_flexslider').flexslider(index);
            }
        });

        function fixMainImage() {

            $('div.images img[data-o_src]').each(function () {
                var $i = $(this);
                $i.attr('src', $i.attr('data-o_src'));
            });
        }

        fixMainImage();
    });
})(jQuery);