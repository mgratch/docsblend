<?php

/**
 * Pricelist shortcode
 */
class ctGraphBoxShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Graph Box';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'graph_box';
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

        $atts['header_rel_class'] = 'ct-graphBox-title text-lowercase ct-fw-600';


        $headerHtml = $this->buildRelatedShortcode('header', $atts, 'header_rel');
        $graphHtml = $this->buildRelatedShortcode('graph', $atts, 'graph_rel');


        $mainContainerAtts = array(
            'class' => array(
                'ct-graphBox',
                'ct-graphBox--default'
            )
        );

        $html = '
            <div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>' . $graphHtml .
            '
            <div class="ct-graphBox-content">' . $headerHtml . '
                        <p>
                           ' . $content . '
                        </p>
                    </div>

            </div>';
        return $html;
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        $items = array(
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
            'content' => array('label' => __('Content', 'ct_theme'), 'default' => '', 'type' => "textarea"),

        );
        $items = $this->mergeShortcodeAttributes($items, 'header', 'header_rel', __('Header', 'ct_theme'));
        return $this->mergeShortcodeAttributes($items, 'graph', 'graph_rel', __('Graph', 'ct_theme'));

    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
	        'icon' => 'fa-circle-o-notch',
	        'description' => __( "Create a box with graph", 'ct_theme')
	        ));
    }
}

new ctGraphBoxShortcode();
