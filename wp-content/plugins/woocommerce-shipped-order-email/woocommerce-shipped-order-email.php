<?php
/**
 * Plugin Name: WooCommerce Custom Shipped Order Email
 * Plugin URI: http://www.skyverge.com/blog/how-to-add-a-custom-woocommerce-email/
 * Description: Plugin for adding a custom WooCommerce email that sends customers an email when an order designated as shipped.
 * Author: SkyVerge & Marc Gratch
 * Author URI: http://www.skyverge.com & https://marcgratch.com
 * Version: 0.1
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class WC_Shipped_Order {


	/**
	 * Plugin version.
	 *
	 * @since 0.0.2
	 * @var string $version Plugin version number.
	 */
	public $version = '0.0.2';


	/**
	 * Plugin file.
	 *
	 * @since 0.0.2
	 * @var string $file Plugin file path.
	 */
	public $file = __FILE__;


	/**
	 * Instance of WC_Shipped_Order.
	 *
	 * @since 0.0.2
	 * @access private
	 * @var object $instance The instance of WC_Shipped_Order.
	 */
	private static $instance;

	/**
	 * Constructor.
	 *
	 * @since 0.0.2
	 */
	public function __construct() {

		if ( ! function_exists( 'is_plugin_active_for_network' ) ) :
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		endif;

		// Check if WooCommerce is active
		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) :
			if ( ! is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) :
				return;
			endif;
		endif;

		$this->init();

	}


	/**
	 * Instance.
	 *
	 * An global instance of the class. Used to retrieve the instance
	 * to use on other files/plugins/themes.
	 *
	 * @since 0.0.2
	 * @return object Instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) :
			self::$instance = new self();
		endif;

		return self::$instance;

	}


	/**
	 * Init.
	 *
	 * Initialize plugin parts.
	 *
	 * @since 0.0.2
	 */
	public function init() {

		if ( is_admin() ) :

			/**
			 * Admin panel
			 */
			require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-shipped-order-status.php';
			$this->Shipped_Status = new WC_Add_Shipped_Order_Status();

		endif;

		// Add the availability chart

		// Add Shipped Email
		add_filter( 'woocommerce_locate_template', array( $this, 'theme_customisations_wc_get_template' ), 11, 3 );
		add_filter( 'woocommerce_email_classes', array( $this, 'add_shipped_order_woocommerce_email' ) );
	}

	/**
	 *  Add a custom email to the list of emails WooCommerce should load
	 *
	 * @since 0.1
	 *
	 * @param array $email_classes available email classes
	 *
	 * @return array filtered available email classes
	 */
	public function add_shipped_order_woocommerce_email( $email_classes ) {

		// include our custom email class
		require_once( 'includes/class-wc-shipped-order-email.php' );

		// add the email class to the list of email classes that WooCommerce loads
		$email_classes['WC_Shipped_Order_Email'] = new WC_Shipped_Order_Email();

		return $email_classes;

	}

	/**
	 * Look in this plugin for WooCommerce template overrides.
	 *
	 * For example, if you want to override woocommerce/templates/cart/cart.php, you
	 * can place the modified template in <plugindir>/custom/templates/woocommerce/cart/cart.php
	 *
	 * @param $template
	 * @param string $template_name is the name of the template (ex: cart/cart.php).
	 *
	 * @param $template_path
	 *
	 * @return string $located is the newly located template if one was found, otherwise
	 *                         it is the previously found template.
	 * @internal param string $located is the currently located template, if any was found so far.
	 */
	public function theme_customisations_wc_get_template( $template, $template_name, $template_path ) {

		$plugin_template_path     = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/templates/' . $template_name;

		if ( file_exists( $plugin_template_path ) ) {
			$template = $plugin_template_path;
		}

		return $template;
	}

}
/**
 * The main function responsible for returning the WC_Shipped_Order object.
 *
 * @since 0.0.2
 *
 * @return object WC_Shipped_Order class object.
 */
function wc_shipped_order() {
	return WC_Shipped_Order::instance();
}

add_action( 'plugins_loaded', 'wc_shipped_order' );
