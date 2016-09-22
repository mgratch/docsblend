<?php
/*
  Plugin Name: 	Product Enquiry Pro for WooCommerce (A.K.A QuoteUp)
  Description: 	Allows prospective customers to make enquiry about a WooCommerce product. Analyze product demands right from your dashboard.
  Version: 	4.1.0
  Author: 	WisdmLabs
  Author URI: 	https://wisdmlabs.com/
  Plugin URI: 	https://wisdmlabs.com/
  License: 	GPL
  Text Domain: 	quoteup
 */

/**
 * This file's name has underscore because making it (-) spaced will create an issue for existing users.
 * Plugin won't be activated automatically for them.
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

require_once('functions.php');

if (! defined('QUOTEUP_PLUGIN_DIR')) {
    define('QUOTEUP_PLUGIN_DIR', quoteupPluginDir());
}

if (! defined('QUOTEUP_PLUGIN_URL')) {
    define('QUOTEUP_PLUGIN_URL', quoteupPluginUrl());
}

if (! defined('MPDF_ALL_FONTS_URL')) {
    define('MPDF_ALL_FONTS_URL', 'https://wisdmlabs.com/all-fonts/');
}

if (! defined('QUOTEUP_VERSION')) {
    define('QUOTEUP_VERSION', '4.1.0');
}
if (!defined('EDD_WPEP_STORE_URL')) {
    define('EDD_WPEP_STORE_URL', 'https://wisdmlabs.com');
}
if (!defined('EDD_WPEP_ITEM_NAME')) {
    define('EDD_WPEP_ITEM_NAME', 'Product Enquiry Pro');
}

require_once(QUOTEUP_PLUGIN_DIR . '/install.php');


$quoteup_plugin_data = array(
    'plugin_short_name' => EDD_WPEP_ITEM_NAME, //Plugins short name appears on the License Menu Page
    'plugin_slug' => 'pep', //this slug is used to store the data in db. License is checked using two options viz edd_<slug>_license_key and edd_<slug>_license_status
    'plugin_version' => QUOTEUP_VERSION, //Current Version of the plugin. This should be similar to Version tag mentioned in Plugin headers
    'plugin_name' => EDD_WPEP_ITEM_NAME, //Under this Name product should be created on WisdmLabs Site
    'store_url' => EDD_WPEP_STORE_URL, //Url where program pings to check if update is available and license validity
    'author_name' => 'WisdmLabs', //Author Name
);

$quoteup_enough_stock = true;
$quoteup_enough_stock_product_id = "";
$quoteup_enough_stock_variation_details = "";


require_once(QUOTEUP_PLUGIN_DIR . '/includes/class-quoteup-add-data-in-db.php');
new Combined\Includes\QuoteupAddDataInDB($quoteup_plugin_data);

/**
 * This code checks if new version is available
 */
if (! class_exists('Combined\Includes\QuoteupPluginUpdater')) {
    require_once(QUOTEUP_PLUGIN_DIR . '/includes/class-quoteup-plugin-updater.php');
}

$l_key = trim(get_option('edd_' . $quoteup_plugin_data[ 'plugin_slug' ] . '_license_key'));

// setup the updater
new Combined\Includes\QuoteupPluginUpdater($quoteup_plugin_data[ 'store_url' ], __FILE__, array(
    'version'    => $quoteup_plugin_data[ 'plugin_version' ], // current version number
    'license'    => $l_key, // license key (used get_option above to retrieve from DB)
    'item_name'  => $quoteup_plugin_data[ 'plugin_name' ], // name of this plugin
    'author'     => $quoteup_plugin_data[ 'author_name' ], //author of the plugin
));

add_action('admin_init', 'quoteupCheckDependency');

function quoteupCheckDependency()
{
    if (function_exists('phpversion')) {
        $php_version = phpversion();
    } elseif (defined('PHP_VERSION')) {
        $php_version = PHP_VERSION;
    }
    if (! is_plugin_active('woocommerce/woocommerce.php') || version_compare($php_version, '5.3.0', '<')) {
        deactivate_plugins(plugin_basename(__FILE__));
        unset($_GET[ 'activate' ]);
        add_action('admin_notices', 'quoteupMustShowAdminNotices');
    }
    
    //Deactivate PE Free if it is active
    if (is_plugin_active('product-enquiry-for-woocommerce/product-enquiry-for-woocommerce.php')) {
        deactivate_plugins('product-enquiry-for-woocommerce/product-enquiry-for-woocommerce.php');
    }
}

if (! in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    return;
}

function quoteupMustShowAdminNotices()
{
    if (! is_plugin_active('woocommerce/woocommerce.php')) {
        ?>
		<div class='error'><p>
				<?php echo __("WooCommerce plugin is not active. In order to make the 'QuoteUp' plugin work, you need to install and activate WooCommerce first.", 'quoteup');
                ?>
			</p></div>

		<?php
    }
    if (function_exists('phpversion')) {
        $php_version = phpversion();
    } elseif (defined('PHP_VERSION')) {
        $php_version = PHP_VERSION;
    }

    //Notice for PHP VERSION
    if (version_compare($php_version, '5.3.0', '<')) {
        ?>
		<div class='error'><p>
				<?php echo __("QuoteUp requires PHP VERSION 5.3 or greater. Please update your PHP.", 'quoteup');
                ?>
			</p></div>

		<?php
    }

    if (is_plugin_active('product-enquiry-pro/product_enquiry_pro.php')) {
        ?>
		<div class='error'><p>
				<?php echo __("In order to make the 'QuoteUp' plugin work, Product Enquiry Pro needs to be deactivated.", 'quoteup');
                ?>
			</p></div>

		<?php
    }
}
/**
 * ***********************************
 *
 * Flow is like this after installation:
 *  1.  Create these tables: wp_enquiry_detail_new, wp_enquiry_thread, wp_enquiry_quotation,
 *      wp_enquiry_history,
 *  2.  Create folder QuoteUp_PDF in uploads directory
 *  3.  Convert Multiple Product Enquiry Settings Dropdown to Checkbox because
 *      in versions before 4.0 'Enable Multiproduct Enquiry and Quote Request' setting was dropdown
 *  4.  Set option quoteup_settings_convert_to_checkbox to 1 because conversion of
 *      dropdown to checkbox of settings is done.
 *  5.  Convert dropdown 'Enable Enquiry Button' shown on single product (which were there before 4.0) to checkbox for all existing products
 *  6.  Set 'quoteup_convert_per_product_pep_dropdown' to 1 which confirms 'Enable Enquiry Button' dropdown is converted to checkbox
 *  7.  Convert dropdown 'Show Add to Cart button' shown on single product to checkbox for all existing products.
 *  8.  Set 'quoteup_convert_per_product_add_to_cart_dropdown' to 1 which confirms 'Enable Enquiry Button' dropdown is converted to checkbox
 *  9.  Set _enable_add_to_cart, _enable_price, _enable_pep meta fields to all those products who
 *      does not have those meta fields set. On fresh install, these meta fields are
 *      set to all products.
 *  10. Change order history messages from present tense to past tense.
 *  11. Set quoteup_convert_history_status to 1 which confirms that all history statuses have been changed
 *  12. Change all checkboxes on settings page to 1/0. They are 1/unavailable before this transformation
 *  13. Set default settings to newly introduced configuration.
 *  14. Add new QuoteUp version number in database
 *
 * Steps to be performed on new installation: 1, 2, 9, 12, 13
 *
 * *************************************
 */
//Hooks which creates all the necessary tables.
register_activation_hook(__FILE__, 'quoteupCreateTables');

//Hooks which updates MPE Settings from yes to 1
register_activation_hook(__FILE__, 'quoteupConvertMpeSettings');

//Hook which toggles _disable_quoteup to _enable_quoteup.
register_activation_hook(__FILE__, 'quoteupTogglePerProductDisablePepSettings');

//Hook which toggles _disable_quoteup to _enable_quoteup.
register_activation_hook(__FILE__, 'quoteupConvertPerProductAddToCart');

//Hook which sets the per-product 'Add To Cart' settings on activation.
register_activation_hook(__FILE__, 'quoteupSetAddToCartPepPriceOnActivation');

//Hooks which updated history of previous enquiries.
register_activation_hook(__FILE__, 'quoteupUpdateHistoryStatus');

//Hooks converts checkboxes from 1/unavailable to 1/0.
register_activation_hook(__FILE__, 'quoteupConvertOldCheckboxes');

//Set Default settings 
register_activation_hook(__FILE__, 'quoteupSetDefaultSettings');

//Updates new database version in database
register_activation_hook(__FILE__, 'quoteupUpdateVersionInDb');

// Hook for cron job to delete PDF
register_activation_hook(__FILE__, 'quoteupRegisterDeletePdfs');

// Hook to disable cron job of delete PDF
register_deactivation_hook(__FILE__, 'quoteDeregisterDeletePdfs');

// Hook for cron job to set quotes expired
register_activation_hook(__FILE__, 'quoteupRegisterExpireQuotes');

// Hook to disable cron job to set quotes expired
register_deactivation_hook(__FILE__, 'quoteDeregisterExpireQuotes');




//Includes all required files for plugin
if (file_exists(QUOTEUP_PLUGIN_DIR . '/includes/class-quoteup-wpml-compatibility.php')) {
    require_once(QUOTEUP_PLUGIN_DIR . '/includes/class-quoteup-wpml-compatibility.php');
    $WPML_comp = new Combined\Includes\QuoteUpWPMLCompatibility();
}

require_once(QUOTEUP_PLUGIN_DIR . '/file-includes.php');


//global $fields;
add_action('init', 'quoteupLoadTextDomain');

function quoteupLoadTextDomain()
{
    load_plugin_textdomain('quoteup', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}


add_action('admin_enqueue_scripts', 'quoteupEnqueueScriptsStyles', 10, 1);

//Enqueue styles and scripts on individual product create/edit screen
function quoteupEnqueueScriptsStyles($hook)
{
    $screen = get_current_screen();
    if (($hook == 'post.php' || $hook == 'post-new.php') && $screen->id == 'product') {
                wp_enqueue_script('price-add-to-cart-relation', QUOTEUP_PLUGIN_URL . '/js/admin/single-product.js', array( 'jquery' ));
                wp_enqueue_style('wdm_style_for_individual_product_screen', QUOTEUP_PLUGIN_URL . '/css/admin/dashboard-single-product.css', false, false, false);
    }
}



