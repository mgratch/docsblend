(function ($) {

    $(document).ready(function ($) {

        $("#place_order").on("click", function (e) {
            e.preventDefault();
            var $this = this;
            var $form = $($this).parents("form");
            var $fields = $form.find("input,select");
            $.each($fields, function () {
                var _$this = this;
                $(_$this).attr("disabled", false);
            });
            $form.submit();
        });

        $(document.body).bind("updated_checkout", '', function (e) {
            $("#place_order").on("click", function (e) {
                e.preventDefault();
                var $this = this;
                var $form = $($this).parents("form");
                var $fields = $form.find("input,select");
                $.each($fields, function () {
                    var _$this = this;
                    $(_$this).attr("disabled", false);
                });
                $form.submit();
            });
        });

        $(document.body).bind("checkout_error", '', function (e) {
                var $form = $('.woocommerce-shipping-fields');
                var $fields = $form.find("input,select");
                $.each($fields, function () {
                    var $this = $(this);
                    if ('' !== $this.val()){
                        $this.attr("disabled", true);
                    }
                });
        });


    });

})(jQuery);
