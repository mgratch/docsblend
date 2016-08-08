<?php

/**
 * Pricelist shortcode
 */
class ctItemTestimonialShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Item testimonial';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'item_testimonial';
    }

    /**
     * Returns shortcode type
     * @return mixed|string
     */

    public function getShortcodeType()
    {
        return self::TYPE_SHORTCODE_ENCLOSING;
    }


    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */

    public function handle($atts, $content = null)
    {
        extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));

if(ctSliderTestimonialShortcode::$type=='1'){
        if ($image != '') {
            $a = '<img src="' . $image . '" alt="' . $name . '">';
            $x = 'ct-itemTestimonials--mediaObject';
        } else {
            $a = '';
            $x = '';
        }

        if ($name != '') {
            $b = '<p><span>- ' . $name . '</span></p>';
        } else {
            $b = '';
        }

        $html = '

          <div class="item ct-itemTestimonials ' . $x . '">
                ' . $a . '
                <div>
                    <p>' . $content . '</p>
                   ' . $b . '
                </div>
            </div>

';

        return do_shortcode($html);
}else{


$html='  <div class="ct-accordionSlider-item">
                <p>'.$content.'</p>
                <p class="ct-u-paddingTop10"><span>'.$name.'</span></p>
            </div>';
return do_shortcode($html);


}
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(

            'name' => array('label' => __('Name', 'ct_theme'), 'default' => '', 'type' => 'input'),

            'image' => array('label' => __("Image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image source", 'ct_theme')),

            'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => 'textarea',
            ),

            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Custom class name", 'ct_theme')),
        );
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
            'icon' => 'fa-user',
            'description' => __("Create single person box", 'ct_theme')
        ));
    }

}

new ctItemTestimonialShortcode();
