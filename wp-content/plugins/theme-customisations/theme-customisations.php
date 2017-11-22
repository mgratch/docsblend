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

		//add widget area(s)
		add_action( 'widgets_init', array( $this, 'register_sidebar' ) );

		//storefront powerpack header customizer filter
		add_filter( 'sp_header_components', array( $this, 'add_extra_header_controls' ) );
		//add_action( 'db_storefront_header_widget', array( $this, 'db_storefront_header_widget_render' ) );

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

	public function register_sidebar() {
		register_sidebar( array(
			'name'          => __( 'Header Widget', 'storefront' ),
			'id'            => 'header-widget',
			'description'   => __( 'Add widgets here to appear in your header.', 'storefront' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="gamma widget-title">',
			'after_title'   => '</span>'
		) );
	}

	public function add_extra_header_controls( $components ) {

		$components['header_widget'] = array(
			'title' => __( 'Header Widget', 'storefront-powerpack' ),
			'hook'  => 'db_storefront_header_widget'
		);

		return $components;
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

function db_storefront_header_widget() {
	if ( function_exists( 'storefront_is_woocommerce_activated' ) ) {
		if ( storefront_is_woocommerce_activated() ) {
			?>
            <div class="storefront-header-widget">
				<?php if ( is_active_sidebar( 'header-widget' ) ) : ?>
					<?php dynamic_sidebar( 'header-widget' ); ?>
				<?php endif; ?>
            </div>
			<?php
		}

	}
}


/**
 * Initialise the plugin
 */
add_action( 'plugins_loaded', 'theme_customisations_main' );


//add_action( 'gform_after_submission_2', 'add_wc_coupon_after_submission', 10, 2 );

function add_wc_coupon_after_submission( $entry, $form ) {
	WC()->cart->add_discount( 'DOCSBLENDSUPPORT' );
}