<?php
/**
 * Plugin Name:       Theme Customisations
 * Description:       A handy little plugin to contain your theme customisation snippets.
 * Plugin URI:        http://github.com/woothemes/theme-customisations
 * Version:           1.0.0
 * Author:            WooThemes
 * Author URI:        https://www.woocommerce.com/
 * Requires at least: 3.0.0
 * Tested up to:      4.4.2
 *
 * @package Theme_Customisations
 * @todo setup shipping quote option on checkout page
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require __DIR__ . '/vendor/autoload.php';


/**
 * Main Theme_Customisations Class
 *
 * @class Theme_Customisations
 * @version    1.0.0
 * @since 1.0.0
 * @package    Theme_Customisations
 */
final class Theme_Customisations {

	private static $enquiry_details = array();

	/**
	 * Set up the plugin
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'theme_customisations_setup' ), - 1 );
		require_once( 'custom/functions.php' );
	}

	/**
	 * Setup all the things
	 */
	public function theme_customisations_setup() {

		add_action( 'wp_enqueue_scripts', array( $this, 'theme_customisations_css' ), 999 );

		//change product archive redirect if there is only 1 product
		add_filter( 'woocommerce_return_to_shop_redirect', array( $this, 'maybe_change_empty_cart_button_url' ) );

		//remove the storefront credit link
		remove_action( 'storefront_footer', 'storefront_credit', 20 );

	}

	public function maybe_change_empty_cart_button_url( $url ) {

		$count = wp_count_posts( 'product' );


		if ( 2 > absint( $count->publish ) ) {
			$products = get_posts( array( "post_type" => "product", "status" => "publish" ) );
			$url      = get_permalink( $products[0]->ID );
		}

		return $url;
	}

	/**
	 * Enqueue the CSS
	 *
	 * @return void
	 */
	public function theme_customisations_css() {
		wp_enqueue_style( 'custom-css', plugins_url( '/custom/style.css', __FILE__ ) );
	}

} // End Class

/**
 * The 'main' function
 *
 * @return void
 */
function theme_customisations_main() {
	new Theme_Customisations();
}

/**
 * Initialise the plugin
 */
add_action( 'plugins_loaded', 'theme_customisations_main' );
