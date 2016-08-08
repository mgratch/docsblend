<?php

/**
 * Pricelist shortcode
 */
class ctCopyrightShortcode extends ctShortcode {


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Copyright';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'copyright';
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
                $class,
            ),
        );


        $html = '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>';


        $html .= '<div class="textwidget">
<a href="' . $linkc . '" >
<p class="ct-u-motiveDark ct-u-paddingBoth10 ct-u-size14 ct-fw-600">' . $text . '</p>
</a>
</div>
</div>';


        return do_shortcode($html);
    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'text' => array('label' => __('Text', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'linkc' => array('label' => __('Link', 'ct_theme'), 'default' => '', 'type' => 'input','help' => __("ex. http://www.google.com", 'ct_theme'),),


            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );
    }


}

new ctCopyrightShortcode();



