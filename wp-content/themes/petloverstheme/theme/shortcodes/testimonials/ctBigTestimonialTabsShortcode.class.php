<?php

/**
 * Big Tabs shortcode
 */
class ctBigTestimonialTabsShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Big Testimonial Tabs';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'big_testimonial_tabs';
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



        //parse shortcode before filters
        $itemsHtml = do_shortcode($content);

        $tabs = ''.$this->callPreFilter($content).''; //reference
            $tabs .= '<div class="row">
									<ul class="list-unstyled" role="tablist">';
            $tabs .= $itemsHtml;
            $tabs .= '</ul></div>';







        //clean current tab cache
        $this->cleanData('big_testimonial_tab');

        return do_shortcode(' <div class="ct-testimonials">'.$tabs.'</div>');
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'widgetmode' => array('default' => 'false', 'type' => false),

            'class' => array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );

    }

    /**
     * Child shortcode info
     * @return array
     */

    public function getChildShortcodeInfo()
    {
        return array('name' => 'big_testimonial_tab', 'min' => 1, 'max' => 4, 'default_qty' => 4);
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

new ctBigTestimonialTabsShortcode();




