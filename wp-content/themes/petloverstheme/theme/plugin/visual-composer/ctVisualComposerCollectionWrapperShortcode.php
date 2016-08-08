<?php
/**
 * Class which allows to add nested elements
 * Adds support for collections
 */

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {

	class ctVisualComposerCollectionWrapperShortcode extends WPBakeryShortCodesContainer {

		/**
		 * @var ctShortcode
		 */

		protected $shortcodeObject;

		/**
		 * Creates shortcode which has nested children
		 *
		 * @param ctShortcode $shortcode
		 * @param array $options - VS structure
		 */
		public function __construct( $shortcode, $options = array() ) {
			$this->shortcodeObject   = $shortcode;
			$options['is_container'] = true;

			if ( ! isset( $options['show_settings_on_create'] ) ) {
				$attibutes = $shortcode->getAttributes(); //without any plugins
				if ( count( $attibutes ) == 1 && isset( $attibutes['class'] ) ) {
					$options['show_settings_on_create'] = false;
				}
			}

			if ( ! isset( $options['show_settings_on_create'] ) ) {
				$options['show_settings_on_create'] = true;
			}

			//createIT framework - get info about child shortcodes
			if ( $child = $shortcode->getChildShortcode() ) {
				$options['as_parent'] = array( 'only' => $child->getShortcodeName() );
			}
			$options["content_element"] = true;
//			$options["show_settings_on_create"] = false;
			$options['js_view'] = 'VcColumnView';

			//map it so VS knows about it
			//var_dump($options);exit;
			if (function_exists('vc_map')) {
				vc_map($options);
			} else {
				wpb_map($options);
			}


			parent::__construct( $options );


			//for legacy compatibility
			if(apply_filters('ct_dynamic_vc_extension',true)) {

				$name = 'WPBakeryShortCode_' . $options['base'];

				// register class for VC - it's just a simple class for VS to recognise it's container

				if (!class_exists($name)) {
					eval("class $name extends WPBakeryShortCodesContainer{}");
				}
			}
		}
	}
}