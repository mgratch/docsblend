/**
 * Created by createit on 2015-02-16.
 */

(function($){

  "use strict";
    jQuery(window).load(function(){
        var logo,  dochref, docstring, title, brandurl;
        brandurl = $('#brandurl').val();
        logo = $('#logosrc').val();
        dochref = $('#dochref').val();
        docstring = $('#docstring').val();
        title = $('#imgtitle').val();
        var div = $('#customize-theme-controls > ul');
        if(div.length > 0) {
            div.addClass('ct-themeSection');
        }
        $(function(){
            $('#customize-theme-controls').before('' +
            '<div class="ct-customizerInfo">' +
            '<a class="ct-customizerInfo-logo" href="'+ brandurl + '" target="_blank" title="'+title+'">' +
            '<img alt="" src="'+logo+'"/>' +
            '</a>' +
            '<div class="ct-customizerInfo-content">' +
            'Need help?<br/>Read the <a target="_blank" href="'+dochref+'"  target="_blank">'+docstring+'</a> or ask our <a target="_blank" href="http://createit.support">Support</a>' +
            '</div>' +
            '</div>');

        });

        $('.slider').each(function(){
            var slider = $(this);
            slider.noUiSlider({
                start: slider.data('startat'),
                handles: 1,
                animate:false,
                step: parseInt(slider.data('step')) ,
                range: {
                    'min': slider.data('min'),
                    'max': slider.data('max')

                },
                orientation: 'horizontal',
                behaviour: 'tap-drag'


            }).change(function(){
                slider.prev('input').val(parseInt(slider.val()));
                slider.next('span').html(parseInt(slider.val()));
            });
        })
    })

}(jQuery));