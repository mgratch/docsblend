<?php

/**
 * Google maps shortcode
 */
class ctGoogleMapsShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Google maps';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'google_maps';
    }

    /**
     * Enqueue scripts
     */

    public function enqueueScripts()
    {

        wp_register_script('ct-gmap', CT_THEME_ASSETS . '/js/gmaps/gmap3.min.js', array('jquery'), false, true);
        wp_enqueue_script('ct-gmap');

        wp_register_script('ct-gmap-init', CT_THEME_ASSETS . '/js/gmaps/init.js', array('ct-gmap'), false, true);
        wp_enqueue_script('ct-gmap-init');

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
        $attributes = shortcode_atts($this->extractShortcodeAttributes($atts), $atts);
        extract($attributes);

        $id = ($id == '') ? 'gmap' . rand(100, 1000) : $id;
        $markerurl = CT_THEME_ASSETS . '/images/marker.png';
        echo '<input type="hidden" value="'.$markerurl.'" class="markerurl"/>';


        if (!is_numeric($height)) {
            $height = '286';
        }

        if ($attributes['map_draggable'] == 'yes') {
            $attributes['map_draggable'] = 'true';
        } else if ($attributes['map_draggable'] == 'no') {
            $attributes['map_draggable'] = 'false';
        }


        if (ct_is_browser_type('mobile') == true) {
            $attributes['map_draggable'] = 'false';
        }


   /*     $map = CT_THEME_ASSETS . '/images/marker.png'; ;
        var_dump($map);*/
//var_dump($attributes['custom_marker_icon']);
        $mainContainerAtts = array(
            'class' => array(
                'ct-googleMap',
            ),
            'data-height' => $height,
            'data-offset' => $offset,
            'data-location' => $location,
            'data-map_draggable' => $attributes['map_draggable'],
            'data-map_type' => $attributes['map_type'],
            'data-zoom' => $zoom,
          //  'data-marker_icon' => $attributes['custom_marker_icon'] ? esc_attr($attributes['custom_marker_icon']) : '',
            'id' => $id,
        );





            $html = do_shortcode( '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '></div>');



        return $html;

    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'id' => array(
                'label' => __('ID', 'ct_theme'),
                'default' => '',
                'type' => 'input',
                'help' => __("Custom map ID", 'ct_theme')
            ),
            'location' => array(
                'label' => __('Location', 'ct_theme'),
                'default' => '',
                'type' => 'input',
                'help' => __("Enter location eg town", 'ct_theme')
            ),
            'height' => array('label' => __('height', 'ct_theme'), 'default' => 460, 'type' => 'input'),
            'offset' => array(
                'label' => __('Map vertical offset (in px)', 'ct_theme'),
                'default' => '0',
                'type' => 'input'
            ),

            'map_type' => array(
                'label' => __('Select map type', 'ct_theme'),
                'default' => 'ROADMAP',
                'type' => 'select',
                'options' => array(
                    'ROADMAP' => 'Roadmap',
                    'SATELLITE' => 'Satellite',
                    'HYBRID' => 'Hybrid',
                    'TERRAIN' => 'Terrain',
                )
            ),
            'map_draggable' => array(
                'label' => __('Draggable', 'ct_theme'),
                'default' => 'true',
                'type' => 'select',
                'options' => array('true' => 'true', 'false' => 'false'),
                'help' => __("locked automatically on mobile devices", 'ct_theme')
            ),
            'zoom' => array(
                'label' => __("zoom", 'ct_theme'),
                'type' => 'input',
                'default' => 17,
                'help' => __('Zoom from 1 to 15', 'ct_theme')
            ),
            /*'roll' => array(
                'label' => __('Roll Map', 'ct_theme'),
                'default' => 'no',
                'type' => 'select',
                'choices' => array(
                    'yes' => __('yes', 'ct_theme'),
                    'no' => __('no', 'ct_theme')
                ),
            ),*/
            /*'expanded_label' => array(
                'label' => __('Expanded map label', 'ct_theme'),
                'default' => 'hide map',
                'type' => 'input',
            ),
            'collapsed_label' => array(
                'label' => __('Collapsed map label', 'ct_theme'),
                'default' => 'show map',
                'type' => 'input',
            ),*/
        );
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo($this, array(
	        'icon' => 'fa-globe',
	        'description' => __( "Create a Google Map", 'ct_theme')
	        ));
    }
}

new ctGoogleMapsShortcode();