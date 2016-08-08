<?php

/**
 * Accordion shortcode
 */
class ctAccordionShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{

    static $id;

    public static function getParentId()
    {
        return ctAccordionShortcode::$id;
    }

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Accordion';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'accordion';
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
        $mainContainerAtts = array(
            'class' => array(
                'panel-group',
             /*   $type*/
            ),
            'id' => 'accordion' . rand(100, 1000)
        );
        ctAccordionShortcode::$id = $mainContainerAtts['id'];

        $accordion = '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>' . $content . '</div>';
        return do_shortcode($accordion);
    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
           /* 'type' => array(
                'label' => __("Dark version", 'ct_theme'),
                'type' => 'checkbox',
                'default' => '',
                'value' => 'ct-panelGroup--dark',
            ),*/
            'class' => array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),

        );


    }

    /**
     * Child shortcode info
     * @return array
     */

    public function getChildShortcodeInfo()
    {
        return array('name' => 'accordion_item', 'min' => 1, 'max' => 20, 'default_qty' => 2);
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
	        'icon' => 'fa-bars',
	        'container'=>true,
	        'description' => __( "Create an accordion", 'ct_theme')
        )  );
    }
}

new ctAccordionShortcode();

//#28144
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortcode_accordion extends WPBakeryShortCodesContainer{}
}