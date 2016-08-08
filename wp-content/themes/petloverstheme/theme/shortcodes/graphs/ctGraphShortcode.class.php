<?php

/**
 * Pricelist shortcode
 */
class ctGraphShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Graph';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'graph';
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


        $mainContainerAtts = array(
            'class' => array(
                'ct-graphBox-graph'
            )
        );

        $html = '
            <div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
            <canvas width="' . esc_attr($width) . '" height="' . esc_attr($height) . '" class="ct-js-pieChart" data-ct-percentage="' . esc_attr($percentage) . '"
            data-ct-middlespace="' . esc_attr($middlespace) . '" data-ct-secondcolor="'.$secondary_bar_color.'" data-ct-firstcolor="'.$percentage_bar_color.'"></canvas>
            <span class="ct-graphBox-graphPercentage">' . $percentage . '%</span>
            </div>
            ';
        return $html;
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'width' => array('label' => __('Width (in px)', 'ct_theme'), 'default' => '195', 'type' => 'input'),
            'height' => array('label' => __('Height (in px)', 'ct_theme'), 'default' => '195', 'type' => 'input'),
            'percentage' => array('label' => __('Percentage', 'ct_theme'), 'default' => '0', 'type' => 'input'),
            'middlespace' => array('label' => __('Middlespace', 'ct_theme'), 'default' => '85', 'type' => 'input'),
            'percentage_bar_color' => array('label' => __('Percentage Bar color', 'ct_theme'), 'type' => "colorpicker", 'default' => '#00c5f9'),
            'secondary_bar_color' => array('label' => __('Secondary Bar color', 'ct_theme'), 'type' => "colorpicker", 'default' => '#222222'),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
	        'icon' => 'fa-circle-o-notch',
	        'description' => __( "Add custom graph", 'ct_theme')
	        ));
    }
}

new ctGraphShortcode();
