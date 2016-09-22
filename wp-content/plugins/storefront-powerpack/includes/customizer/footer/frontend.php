<?php
/**
 * Storefront Powerpack Frontend Footer Class
 *
 * @author   WooThemes
 * @package  Storefront_Powerpack
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'SP_Frontend_Footer' ) ) :

	/**
	 * The Frontend class.
	 */
	class SP_Frontend_Footer extends SP_Frontend {

		/**
		 * Setup class.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'wp', array( $this, 'remove_handheld_footer_bar' ), 99 );
		}

		/**
		 * Initialize custom header.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function remove_handheld_footer_bar() {
			$handheld_footer_bar = get_theme_mod( 'sp_handheld_footer_bar', true );

			if ( true !== $handheld_footer_bar ) {
				remove_action( 'storefront_footer', 'storefront_handheld_footer_bar', 999 );
			}
		}
	}

endif;

return new SP_Frontend_Footer();