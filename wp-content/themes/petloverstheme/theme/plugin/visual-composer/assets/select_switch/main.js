jQuery(document).ready(function ($) {
    $('.ct-select-switch').change(function () {
        var $s = $(this).find(':selected');

        if($s.val() == ''){
            return true;
        }

        $('#vc_properties-panel').find('.ct-select-switched').removeClass('ct-select-switched');
        var json = $.parseJSON($s.attr('data-definition'));
        var $tabs = $('#vc_properties-panel .ui-tabs-nav');
        $.each(json, function (tabName, obj) {
            var link = $('a.ui-tabs-anchor', $tabs).filter(function (index) {
                return $(this).text() === tabName;
            });
            //we have our tab
            if (link) {
                var namespace = link.attr('href');

                var changed = false;
                $.each(obj, function (field, val) {
                    var $target = $('.' + field, namespace);
                    if ($target) {
                        if ($target.hasClass('checkbox')) {
                            $target.attr('checked', val);
                        }

                        if ($target.hasClass('dropdown')) {
                            $target.find('option[value="' + val + '"]').prop('selected', true);
                        }

                        if ($target.hasClass('textfield')) {
                            $target.val(val);
                        }

                        $target.closest('.vc_shortcode-param').addClass('ct-select-switched');
                        changed = true;
                    }
                });

                if (changed) {
                    link.closest('li').addClass('ct-select-switched');
                }
            }
        });
    });
});