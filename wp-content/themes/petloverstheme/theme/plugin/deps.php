<?php
/**
 * Array of plugin arrays. Required keys are name and slug.
 * If the source is NOT from the .org repo, then source is also required.
 */
$plugins = array(


    array(
        'name' => 'Contact Form 7 (free)', // The plugin name
        'slug' => 'contact-form-7', // The plugin slug (typically the folder name)
        'external_url ' => 'http://wordpress.org/plugins/contact-form-7/', // The plugin source
        'required' => false, // If false, the plugin is only 'recommended' instead of required
        'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
        'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
    ),

    array(
        'name' => 'Visual Composer: Page Builder for WordPress (included)', // The plugin name
        'slug' => 'js_composer', // The plugin slug (typically the folder name)
        'source' => CT_THEME_DIR . '/vendor/visual-composer/js_composer.zip', // The plugin source
        'required' => false, // If false, the plugin is only 'recommended' instead of required
        'version' => '4.11.2.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
        'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
        'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
    ),
    array(
        'name' => 'createIT Post Types Plugin',
        'slug' => 'ct-post-types',
        'source' => CT_THEME_DIR . '/vendor/ct-post-types/ct-post-types.zip',
        'required' => false,
        'force_activation' => false,
        'force_deactivation' => false,
        'version' => '',
    ),

 /*   array(
        'name' => 'Custom Sidebars (included)', // The plugin name
        'slug' => 'custom-sidebars', // The plugin slug (typically the folder name)
        'source' => CT_THEME_DIR . '/vendor/custom-sidebars/custom-sidebars.zip', // The plugin source
        'required' => false, // If false, the plugin is only 'recommended' instead of required
        'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
        'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
        'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
    ),*/



);