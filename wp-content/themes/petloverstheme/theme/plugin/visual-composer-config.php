<?php


if ( function_exists( 'vc_set_shortcodes_templates_dir' ) ) {
	/**
	 * Extends VCI Integration
	 */
	class ctVisualComposerConfig {
		/**
		 * Initializes object
		 */
		public function __construct() {
			//extend existing shortcodes


			add_filter( 'ct_visual_composer_integrator.expand_base_shortcodes', array(
				$this,
				'expandBaseShortcodes'
			) );


			//currently we do not support frontend
			add_filter( 'ct_visual_composer_integrator.disable_frontend', '__return_true' );

			add_filter('ct.vc_column.apply_section', '__return_true');

			add_filter('ct.vc_row.add_container_before', '__return_true');

		}

		/**
		 * Extend shortcodes
		 *
		 * @param $extensions
		 *
		 * @return mixed
		 */

		public function expandBaseShortcodes( $extensions ) {

			$extensions['vc_row']      =  array(
				'shortcode' => ctShortcodeHandler::getInstance()->getShortcode( 'section' ), //load these options
				'group'     => __( "Customization", 'ct_theme' ),
				'options'   => array( //optional, we want to have it as first tab
					'append' => true
				)
			);

			return $extensions;
		}
	}

	new ctVisualComposerConfig();
}