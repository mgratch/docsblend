<?php

add_filter('ct.utility_class.compatible_shortcodes', 'ct_get_compatible_shortcodes');


/**
 * @return mixed|void
 */
function ct_get_compatible_shortcodes($shortcodes)
{

    $shortcodes=  array(
        'format',
        'section_header',
        'section',
        'icon',
        'header',
        'image_box'
    );
    return $shortcodes;
}


/*

add_filter('ct.utility_class.attr', 'backgrounds');

function backgrounds($shortcodes)
{
//var_dump($shortcodes);



    $shortcodes[] =   array(
        $attr['ct_u_bg_color'] = array(
            'label' => __('Background Colors', 'ct_theme'),
            'default' => '',
            'group' => $group,
            'type' => 'select',
            'choices' =>
                array(
                    "" => __("none", "ct_theme"),
                    "ct-u-dsadasdas" => __("whdasdasdasdasite", "ct_theme"),
                    "ct-u-backgrdasdasdasdasdasoundGray" => __("gdasasdasdasdasdasdray", "ct_theme"),
                    "ct-u-backgroundGray2" => __("gray 2", "ct_theme"),
                    "ct-u-backgroundDarkGray" => __("dark gray", "ct_theme"),
                    "ct-u-backgroundDarkGray2" => __("dark gray 2", "ct_theme"),
                    "ct-u-backgroundDarkGray3" => __("dark gray 3", "ct_theme"),
                    "ct-u-backgroundMotive" => __("motive", "ct_theme"),
                    "ct-u-backgroundDarkMotive" => __("dark motive", "ct_theme"),
                ),
            'help' => sprintf(__('Select background color', 'ct_theme')),
            'supported_by' => array(),
            'not_supported_by' => array('icon', 'section_header'),
        ),
    );
    return $shortcodes;
}*/
