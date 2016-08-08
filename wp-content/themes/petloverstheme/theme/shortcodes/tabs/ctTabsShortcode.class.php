<?php

/**
 * Tabs shortcode
 */
class ctTabsShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Tabs';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'tabs';
    }


    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */
    public static $full;
    public function handle($atts, $content = null)
    {
        $attributes = shortcode_atts($this->extractShortcodeAttributes($atts), $atts);
        extract($attributes);
        $mainContainerAtts = array(
            'class' => array(
                'list-unstyled text-uppercase ct-fw-600" role="tablist',
                $class
            )
        );

$ini='';
        $end='';
        if($full=='yes'){

            self::$full='yes';
            $ini = '';
            $end = '';



        }


        //parse shortcode before filters
        $itemsHtml = do_shortcode($content);

        $tabs = ''.$ini.'<div class="ct-tabHeader ct-tabHeader--'.$style.'" role="tabpanel"><ul ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>';
        $tabs .= $this->callPreFilter(''); //reference
        $tabs .= '</ul></div>'.$end.'';

        //clean current tab cache
        $this->cleanData('tab');


        $tabs =  $tabs . '<div class="tab-content ct-u-paddingBottom80">' . $itemsHtml . '</div>




        ';


        return do_shortcode($tabs);

    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(

            'full' => array('label' => __('Full', 'ct_theme'),
                'default' => 'no',
                'type' => 'select', 'choices' => array(
                    'no' => __('no', 'ct_theme'),
                    'yes' => __('yes', 'ct_theme')),),


            'style' => array('label' => __('Style', 'ct_theme'),
                'default' => 'motive',
                'type' => 'select', 'choices' => array(
                    'motive' => __('Motive', 'ct_theme'),
                    'success' => __('Success', 'ct_theme'),
                    'danger' => __('Danger', 'ct_theme'),
                    'warning' => __('Warning', 'ct_theme'),
                    'info' => __('Info', 'ct_theme')),),


            'class' => array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );
    }

    /**
     * Child shortcode info
     * @return array
     */

    public function getChildShortcodeInfo()
    {
        return array('name' => 'tab', 'min' => 1, 'max' => 20, 'default_qty' => 1);
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo() {
        return new ctVisualComposerInfo( $this, array(
	        'icon' => 'fa-list-alt',
	        'description' => __( "Tabbed content", 'ct_theme')
	        ) );
    }

}

new ctTabsShortcode();