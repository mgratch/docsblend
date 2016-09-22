(function ($) {

    $(document).ready(function ($) {

        if (typeof wc_add_to_cart_variation_params !== 'undefined') {

            $('.variations_form').each(function () {
                var $form = $(this),
                    $quoteForm = $(".quote-form"),
                    quote_form_button = $quoteForm.find(".single_add_to_cart_button");

                var button = $(quote_form_button)[0].outerHTML;

                button = button.replace("button","a");
                button = button.replace("/button","/a");
                $(quote_form_button).replaceWith(button);

                $quoteForm.insertAfter(".quantity");

                $form
                    .on('found_variation', function (event, variation) {
                        if (typeof variation !== 'undefined') {
                            var $button = $form.find("button.single_add_to_cart_button");

                            if ( false !== variation.hide_add_to_cart ) {
                                $button.hide();
                            } else {
                                $button.show();
                            }
                            if (false !== variation.show_quote_up){
                                $quoteForm.find(".single_add_to_cart_button").removeClass("disabled").show();
                                $quoteForm.show();
                            } else {
                                $quoteForm.hide();
                            }
                        }
                    });
            });
        }
    });
})(jQuery);
