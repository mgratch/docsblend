<?php

/**
 * BlockQuote shortcode
 */
class ctQuoteShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Quote';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'quote';
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
                'quote',
                ($align == 'left') ? 'pull-left' : '',
                ($align == 'right') ? 'pull-right' : '',
                $class,
            ),
        );

        $html = '<span ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>' . $content . '</span>';

        return do_shortcode($html);
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => "textarea"),
            'align' => array('label' => __('align', 'ct_theme'), 'default' => '', 'type' => 'select', 'options' => array('' => '', 'left' => __('Left', 'ct_theme'), 'right' => __('Right', 'ct_theme')), 'help' => __("Quote align", 'ct_theme')),
            'class' => array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input',)
        );
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo() {
        return new ctVisualComposerInfo( $this, array(
	        'icon' => 'fa-quote-left',
	        'description' => __( "Add a quote", 'ct_theme')
	        ) );
    }
}

new ctQuoteShortcode();