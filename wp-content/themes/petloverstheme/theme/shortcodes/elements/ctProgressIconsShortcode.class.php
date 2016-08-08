<?php

/**
 * progress icons shortcode
 */
class ctProgressIconsShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Progress Icons';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'progress_icons';
    }

    public function enqueueScripts()
    {
        wp_register_script('ct-progressicons', CT_THEME_ASSETS . '/js/progressicons/init.js', array('jquery'), false, true);
        wp_enqueue_script('ct-progressicons');
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
        $id = 'iconCounter' . rand(100, 1000);
        //$IconHtml = $this->buildRelatedShortcodeIf('icon', $atts, 'content', 'format1');


        $mainContainerAtts = array(
            'class' => array(
                'progress-icons',
                $class
            ),
            'data-font-size' => $icon_size,
            'data-icon-color' => '#' . str_replace('#', '', $icon_color),
            'data-active' => $this->normalizeNum($active),
            'data-total' => $this->normalizeNum($total),
            'data-icon' => $name,
            'data-delay' => $delay,
            'id' => $id
        );


        $html = '
                    <div class="ct-u-marginBottom40">
                       <div' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '></div>
                    </div>
		';

        return do_shortcode($html);

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
        return array(
            'name' => array(
                'label' => __('Icon name', 'ct_theme'),
                'type' => "icon",
                'default' => '',
                'link' => CT_THEME_ASSETS . '/shortcode/awesome/index.html'
            ),
            'icon_color' => array(
                'label' => __('Icon color', 'ct_theme'),
                'type' => "colorpicker",
                'default' => '#d30000'
            ),
            'icon_size' => array('label' => __('Icon Size', 'ct_theme'), 'type' => "input", 'default' => 25),
            'total' => array(
                'label' => __('Total icons', 'ct_theme'),
                'default' => '',
                'type' => 'input',
                'help' => __("The total number of icons", 'ct_theme')
            ),
            'delay' => array(
                'label' => __('Delay', 'ct_theme'),
                'default' => '600',
                'type' => 'input',
                'help' => __("The time to start icons activation", 'ct_theme')
            ),
            'active' => array(
                'label' => __('Active icons', 'ct_theme'),
                'default' => '',
                'type' => 'input',
                'help' => __("The number of active icons", 'ct_theme')
            ),
            'class' => array(
                'label' => __("Custom class", 'ct_theme'),
                'default' => '',
                'type' => 'input',
                'help' => __("Custom class name", 'ct_theme')
            ),
        );
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
	        'icon' => 'fa-pie-chart',
	        'description' => __( "Create progress bar with icons", 'ct_theme')
	        ));
    }
}

new ctProgressIconsShortcode();


