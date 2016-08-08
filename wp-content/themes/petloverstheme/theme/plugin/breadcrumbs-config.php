<?php
add_filter('ct.breadcrumbs.display', 'ct_add');


function ct_add($array)
{

    return array('wrapper_class' => "breadcrumb pull-left");
}


function ct_add_style_bread()
{
    wp_enqueue_style('ct_breadcrumbs_css', CT_THEME_SETTINGS_MAIN_DIR_URI . '/plugin/breadcrumbs.css');
}

add_action('wp_enqueue_scripts', 'ct_add_style_bread', 0);