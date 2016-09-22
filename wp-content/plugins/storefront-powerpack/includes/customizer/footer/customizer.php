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

if ( ! class_exists( 'SP_Customizer_Footer' ) ) :

	/**
	 * The Frontend class.
	 */
	class SP_Customizer_Footer extends SP_Customizer {
		/**
		 * The id of this section.
		 *
		 * @const string
		 */
		const POWERPACK_FOOTER_SECTION = 'sp_footer_section';

		/**
		 * Returns an array of the Storefront Powerpack setting defaults.
		 *
		 * @return array
		 * @since 1.0.0
		 */
		public function setting_defaults() {
			return $args = array(
				'sp_handheld_footer_bar' => true,
			);
		}

		/**
		 * Customizer Controls and Settings
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.0.0
		 */
		public function customize_register( $wp_customize ) {
			/**
			* Footer Section
			*/
			$wp_customize->add_section( self::POWERPACK_FOOTER_SECTION, array(
				'title'    => __( 'Footer', 'storefront-powerpack' ),
				'panel'    => self::POWERPACK_PANEL,
				'priority' => 50,
			) );

			/**
			 * Turn off handheld footer bar
			 */
			$wp_customize->add_setting( 'sp_handheld_footer_bar', array(
				'sanitize_callback' => 'storefront_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sp_handheld_footer_bar', array(
				'label'    => __( 'Handheld Footer Bar', 'storefront-powerpack' ),
				'description' => __( 'Toggles the display of the footer bar when viewed on handheld devices.', 'storefront-powerpack' ),
				'section'  => self::POWERPACK_FOOTER_SECTION,
				'settings' => 'sp_handheld_footer_bar',
				'type'     => 'checkbox',
				'priority' => 10,
				)
			) );
		}
	}

endif;

return new SP_Customizer_Footer();