<?php
/**
 * Plugin Name: createIT PostTypes Plugin
 * Plugin URI: http://createit.pl
 * Description: Custom post types required for the theme
 * Version: 1.0
 * Author: createIT
 * Author URI: http://createit.pl
 */





/**
 * Class ctPostTypes
 */
class ctPostTypes
{


    /**
     *
     */
    private function setupConstants()
    {

        define('PLUGIN_VERSION', '1.0.0');

        if (!defined('CTPT_URL'))
            define('CTPT_URL', plugin_dir_url(__FILE__));

        if (!defined('CTPT_DIR'))
            define('CTPT_DIR', plugin_dir_path(__FILE__));

        if (!defined('CTPT_BASEDIR')) {
            define('CTPT_BASEDIR', dirname(plugin_basename(__FILE__)));
        }

        if (!defined('CTPT_POST_TYPES_DIR')) {
            define('CTPT_POST_TYPES_DIR', CTPT_DIR . '/includes/post-types');
        }

        if (!defined('CTPT_BASE_DIR')) {
            define('CTPT_BASE_DIR', CTPT_DIR . '/includes/post-types-base');
        }

        if (!defined('CTPT_ASSETS_DIR')) {
            define('CTPT_ASSETS_DIR', CTPT_DIR . '/assets');
        }

        if (!defined('CTPT_ASSETS_URL')) {
            define('CTPT_ASSETS_URL', CTPT_URL . '/assets');
        }

    }


    /**
     *
     */
    public function __construct()
    {

        $this->setupConstants();
        require_once CTPT_BASE_DIR . '/ctTypeBase.class.php';
        $this->loadFiles(CTPT_BASE_DIR);
        $this->loadFiles(CTPT_POST_TYPES_DIR);

    }


    /**
     * @param $path
     */
    public function loadFiles($path)
    {
        foreach (glob($path . '/*.php') as $filename) {
            include_once $filename;
        }
    }
}

new ctPostTypes();


