<?php

/**
 * Big Tabs shortcode
 */
class ctTeTabsShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Media Tabs';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'te_tabs';
    }


    public function enqueueScripts()
    {
        wp_register_script('ct-tabs', CT_THEME_ASSETS . '/js/ct/tabs.js', array('jquery'), false, true);
        wp_enqueue_script('ct-tabs');
    }

    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */

    public function handle($atts, $content = null)
    {

        $attributes = shortcode_atts($this->extractShortcodeAttributes($atts), $atts);
        extract($attributes);

        $mainContainerAtts = array(
            'class' => array(
                'nav',
                'nav-tabs',
                'nav-stacked'!='left'?'nav-stacked':'',
                'ct-mediaTabs ct-u-paddingBottom15'
            ),
            'role'=>"tablist"
        );

        //parse shortcode before filters
        $itemsHtml = do_shortcode($content);


            $tabs = '<div class="ct-tabs--'.$side.'Carousel pull-'.$side.'"><div role="tabpanel"><ul' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>';
            $tabs .= $itemsHtml;
            $tabs .= '</ul></div></div>';
            $tabs .= ''.$this->callPreFilter($content).''; //reference






        //clean current tab cache
        $this->cleanData('te_tab');

        return do_shortcode($tabs);
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'widgetmode' => array('default' => 'false', 'type' => false),
            'side' => array('label' => __('Side', 'ct_theme'), 'default' => 'left', 'type' => 'select', 'choices' => array('left' => __('left', 'ct_theme'), 'right' => __('right', 'ct_theme')),),


            'class' => array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );

    }

    /**
     * Child shortcode info
     * @return array
     */

    public function getChildShortcodeInfo()
    {
        return array('name' => 'te_tab', 'min' => 1, 'max' => 4, 'default_qty' => 4);
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
	        'icon' => 'fa-list-alt',
	        'description' => __( "Add a child element of the tabs", 'ct_theme')
	        ));
    }

}

new ctTeTabsShortcode();




