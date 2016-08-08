<?php
$sections[] = array(
    'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_280_settings.png',
    'group' => __("General", 'ct_theme'),
    'title' => __('Main', 'ct_theme'),
    'desc' => __('Main settings', 'ct_theme'),
    'fields' => array(
    )
);


$sections[] = array(
    'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_001_leaf.png',
    'group' => __("General", 'ct_theme'),
    'title' => __('Automatic Update', 'ct_theme'),
    'desc' => __('Automatic theme update will check every 12 hours for any new theme updates. A notification in Themes menu will appear (just like any other update info).<br/>In order for automatic updates to work, license key is required. <br/><strong>All your settings will be saved</strong>.<br/><br/><strong>WARNING</strong><br/>If you modified source code, it will be overwritten!', 'ct_theme'),
    'fields' => array(
        array(
            'id' => 'general_envato_license',
            'type' => 'text',
            'title' => __('Envato license', 'ct_theme'),
            'desc' => '<a target="_blank" href="http://outsourcing.createit.pl/envato_license.html">' . __('Click here for instructions how to find license', 'ct_theme') . '</a>'
        ))
);