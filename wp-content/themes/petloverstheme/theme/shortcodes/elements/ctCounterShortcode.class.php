<?php

/**
 * Bar shortcode
 */
class ctCounterShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Counter';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'counter';
    }


    public function enqueueScripts()
    {
        wp_register_script('countTo', CT_THEME_ASSETS . '/js/counter/jquery.countTo.js', array('jquery'), false, true);
        wp_enqueue_script('countTo');

        wp_register_script('countTo-init', CT_THEME_ASSETS . '/js/counter/init.js', array('countTo'), false, true);
        wp_enqueue_script('countTo-init');
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

        $mainContainerAtts = array(
            'class' => array(
                'ct-counterBox',
                $type,
                $class
            ),
        );

        //$iconHtml = $this->buildRelatedShortcode('icon', $atts, 'icon_rel');

        if ($type == 'ct-counterBox--default') {
            $html = ' <div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
                    <span class="ct-counterBox-number ct-js-counter"
                          data-ct-to="' . $this->normalizeNum($to) . '" data-ct-speed="' . $speed . '" ' . ct_esc_attr('data-color', str_replace('#', '', $counter_color)) . '>0</span>
                    <h5 class="ct-counterBox-title text-uppercase ct-fw-700">' . $header . '</h5>
                    <span class="ct-counterBox-icon"><i ' . ct_esc_attr('data-color', str_replace('#', '', $icon_color)) . ' style="" class="fa ' . $icon . '"></i> </span>

                </div>



                ';
        } else {
            $html = '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
                    <div class="pull-left">
                        <span class="ct-counterBox-number ct-fw-700 ct-u-colorDarkGray ct-js-counter" data-ct-to="' . $this->normalizeNum($to) . '"
                             data-ct-speed="' . $speed . '">'.(!is_numeric($to)?$to:'0').'</span>
                    </div>
                   <h5 class="ct-counterBox-title ct-fw-700 ct-js-color" ' . ct_esc_attr('data-color', str_replace('#', '', $color)) . '>' . $header . '</h5>
                    <span class="ct-counterBox-text text-uppercase ct-fw-600 ct-u-colorDarkGray " >' . $sub_header . '</span>
                </div>
            ';
        }

        return $html;
    }


    /**
     * Normalize number
     *
     * @param $num
     *
     * @return mixed
     */

    protected function normalizeNum($num)
    {
        return str_replace(array(' ', ','), '', $num);
    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        $items = array(
            'type' => array('label' => __('with icon', 'ct_theme'), 'default' => 'icon', 'type' => 'select',
                'choices' => array(
                    'ct-counterBox--default' => 'with icon',
                    'ct-counterBox--socials' => 'text'
                ), 'help' => __("Select type of a counter", 'ct_theme')),

            'icon' => array('label' => __('Icon', 'ct_theme'), 'type' => "icon", 'default' => '', 'link' => CT_THEME_ASSETS . '/shortcode/awesome/index.html', 'dependency' => array(
                'element' => 'type',
                'value' => array('ct-counterBox--default')
            )),
            'header' => array('label' => __('Header', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'sub_header' => array('label' => __('Sub Header', 'ct_theme'), 'default' => '', 'type' => 'input',
                'dependency' => array(
                    'element' => 'type',
                    'value' => array('ct-counterBox--socials')
                )),

            'value' => array(
	            'label' => __('Value', 'ct_theme'), 'default' => 0,
	            'type' => 'input',
	            'help' => __("By default minimum value is 0", 'ct_theme')
	            ),
            'to' => array(
	            'label' => __('Count to', 'ct_theme'),
	            'default' => 0,
	            'type' => 'input',
	            'help' => __("Maximum counter value", 'ct_theme')
            ),
            'speed' => array('label' => __('Speed', 'ct_theme'), 'default' => '6000', 'type' => 'input'),

            'color' => array(
                'label' => __('Header Color', 'ct_theme'),
                'type' => "colorpicker",
                'default' => ''
            ),

           /* 'sub_color' => array(
                'label' => __('Subheader Color', 'ct_theme'),
                'type' => "colorpicker",
                'default' => '',
                'dependency' => array(
                    'element' => 'type',
                    'value' => array('ct-counterBox--socials')
                )
            ),*/

            'icon_color' => array(
                'label' => __('Icon Color', 'ct_theme'),
                'type' => "colorpicker",
                'default' => '#d30000',
                'dependency' => array(
                    'element' => 'type',
                    'value' => array('ct-counterBox--default')
                )
            ),

            'counter_color' => array(
                'label' => __('Counter Color', 'ct_theme'),
                'type' => "colorpicker",
                'default' => '',
                'dependency' => array(
                    'element' => 'type',
                    'value' => array('ct-counterBox--default')
                )
            ),


            'class' => array(
                'label' => __("Custom class", 'ct_theme'),
                'default' => '',
                'type' => 'input',
                'help' => __("Custom class name", 'ct_theme')
            ),
        );

       // return $this->mergeShortcodeAttributes($items, 'icon', 'icon_rel', __('Icon', 'ct_theme'));
       return $items;

    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
	        'icon' => 'fa-pie-chart',
	        'description' => __( "Create a custom counter", 'ct_theme')
	        ));
    }
}

new ctCounterShortcode();



