<?php

/**
 * Pricelist shortcode
 */
class ctImageBoxShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Image box';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'image_box';
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




        $buttonHtml = $this->buildRelatedShortcode('button', $atts, 'button_rel');








        $html = '
                  	<div class="text-center ct-u-paddingBottom80">
                <img class="ct-u-paddingBottom20" src="' . esc_url($src) . '" alt="Team Member">
                <h5 class="ct-u-size24">'.$title.'</h5>
                <p>'.$content.'</p>
                '.$buttonHtml.'
            </div>
            ';

        return do_shortcode($html);
    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        $items = array();


        $items['title'] = array(
            'label' => __('Title', 'ct_theme'),
            'default' => '',
            'type' => 'input',

        );

        $items['content'] = array('label' => __('Content', 'ct_theme'), 'default' => '', 'type' => "textarea");

        $items['src'] = array('label' => __("image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image source", 'ct_theme'));



        $items['new_window'] = array('label' => __('Open link in new Window?', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'choices' => array('yes' => __('yes', 'ct_theme'), 'no' => __('no', 'ct_theme')));
        $items['class'] = array('label' => __("Custom class", 'ct_theme'),
            'default' => '',
            'type' => 'input',
            'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')
        );




        //merge with related icon
        return $this->mergeShortcodeAttributes($items, 'button', 'button_rel', __('Button', 'ct_theme'));

    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
            'icon' => 'fa-caret-square-o-up',
        ) );
    }
}

new ctImageBoxShortcode();



