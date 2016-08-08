<?php

/**
 * Pricelist shortcode
 */
class ctVerticalRoundedImageBoxShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Verical Article Image';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'vertical_rounded_image';
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
     *
     * @param $atts
     * @param null $content
     *
     * @return string
     */

    public function handle($atts, $content = null)
    {
        extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));



        // <h4 class="ct-iconBox-title text-lowercase ct-fw-600">



        if($text_side=='left'){

       $html = '

<div class="ct-verticalRoundedImage">
        <div class="row">
            <div class="ct-u-marginTop30">
                <div class="col-sm-4 col-xs-7 ct-u-doubleBorderTop">
                    <h3 class="text-uppercase">'.$title.'</h3>
                </div>
                <div class="col-sm-4 col-sm-push-4 col-xs-5"><img src="' . esc_url($src).'" alt="'.$title.'"></div>
                <div class="col-sm-4 col-sm-pull-4 col-xs-12 ct-u-doubleBorderTop ct-u-paddingBoth40">
                    '.$content.'
                </div>
            </div>
        </div>


';

}else{

            $html= '
            <div class="ct-verticalRoundedImage text-right">
        <div class="row">
            <div class="col-sm-4 col-xs-5"><img src="' . esc_url($src).'" alt="'.$title.'"></div>
            <div class="ct-u-marginTop30">
                <div class="col-sm-4 col-sm-push-4 col-xs-7 ct-u-doubleBorderTop">
                    <h3 class="text-uppercase">'.$title.'</h3>
                </div>
                <div class="col-sm-4 col-sm-pull-4 col-xs-12 ct-u-doubleBorderTop ct-u-paddingBoth40">
                     '.$content.'
                </div>
            </div>
        </div>
    </div>
            ';
        }




        return do_shortcode($html);
    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        $items = array();


        $items['text_side'] = array(
            'label' => __('text side', 'ct_theme'),
            'default' => 'left',
            'type' => 'select',
            'options' => array(
                'left' => 'left ',
                'right' => 'right'),

    );

        $items['title'] = array(
            'label' => __('title', 'ct_theme'),
            // 'group' => '',
            'type' => 'input',

        );
        $items['content'] = array('label' => __('Content', 'ct_theme'), 'default' => '', 'type' => "textarea");

        $items['src'] = array(
            'label' => __("image", 'ct_theme'),
            'default' => '', 'type' => 'image',
            'help' => __("Image source", 'ct_theme'),

        );

     /*   $items['border'] = array(
            'label' => __('border top', 'ct_theme'),
            'default' => '',
            'type' => 'select',
            'options' => array(
                '' => 'no',
                'ct-u-doubleBorderTop' => 'yes'),

        );*/


        $items['class'] = array('label' => __("Custom class", 'ct_theme'),
            'default' => '',
            'type' => 'input',
            'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')
        );

        //add related header attributes




        //merge with related icon
       return $items;

    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
	        'icon' => 'fa-caret-square-o-up',
            'container'=>true
        ) );
    }
}

new ctVerticalRoundedImageBoxShortcode();



