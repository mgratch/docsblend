/**
 * Controls default value
 */
(function($){
    "use strict";
    $(window).on('load',function(){
        var api = wp.customize;
        var settingsArray = $('#customize-theme-controls').children().find('label');

        jQuery.each(settingsArray,function(){
            var $button = $(this).find('.ct-default');
            if($button) {
                var $prev = $button.prev();
                var defaultvalue = $prev.data('default-value');
                if (defaultvalue) {
                    $($button).on('click', function () {
                        var name = $prev.data('customize-setting-link');
                        api.instance(name).set(defaultvalue);
                        api.previewer.refresh();
                    })
                }
            }
        });
    })
})(jQuery);


(function($) {
  "use strict";

  $(window).on('load', function () {
    $('#customize-controls input[type="range"]').each(function () {
      var $this = $(this),
        $prev = $this.prev(),
        $next = $this.next();

      $prev.html($(this).val());

      $this.on('change input', function () {
        $prev.html($(this).val())
      });

      $next.on('click', function () {
        $prev.html($this.data('default-value'));
      });

    });
  });

})(jQuery);
