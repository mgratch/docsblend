<?php
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {

	/**
	 * Registers custom param types
	 * @author alex
	 */
	class ctVisualComposerCustomParams {

		protected static $fontAwesome;

		public function __construct() {
			//@see also $mapType at ctVisualComposerIntegrator to map new values

			if (function_exists('vc_add_shortcode_param')){
				vc_add_shortcode_param( 'icon', array(
				$this,
				'icon'
			), CT_THEME_SETTINGS_MAIN_DIR_URI . '/plugin/visual-composer/assets/fontpicker/js/jquery.fonticonpicker.min.js' );

			vc_add_shortcode_param( 'toggable', array( $this, 'toggable' ) );
			vc_add_shortcode_param( 'select_switch', array(
				$this,
				'selectSwitch'
			), CT_THEME_SETTINGS_MAIN_DIR_URI . '/plugin/visual-composer/assets/select_switch/main.js' );;
			}else{
				add_shortcode_param( 'icon', array(
				$this,
				'icon'
			), CT_THEME_SETTINGS_MAIN_DIR_URI . '/plugin/visual-composer/assets/fontpicker/js/jquery.fonticonpicker.min.js' );

			add_shortcode_param( 'toggable', array( $this, 'toggable' ) );
			add_shortcode_param( 'select_switch', array(
				$this,
				'selectSwitch'
			), CT_THEME_SETTINGS_MAIN_DIR_URI . '/plugin/visual-composer/assets/select_switch/main.js' );;
			}

		}

		public function toggable( $settings, $value ) {
			return '<div class="vc_col-sm-12 ct_advanced vc_shortcode-param"><div class="wpb_element_label"><h3>' . $settings['heading'] . '</h3></div></div>';
		}

		/**
		 * Switches elements in other tabs
		 *
		 * @param $param
		 * @param $param_value
		 *
		 * @return string
		 */

		public function selectSwitch( $param, $param_value ) {
			$param_line = '';

			$css_option = vc_get_dropdown_option( $param, $param_value );

			$param_line .= '<select name="' . $param['param_name'] . '" class="wpb_vc_param_value wpb-input wpb-select ct-select-switch ' . $param['param_name'] . ' ' . $param['type'] . ' ' . $css_option . '" data-option="' . $css_option . '">';
			$groupedSwitches = $this->getGroupedSwitches( $param['switches'] );
			foreach ( $param['value'] as $text_val => $val ) {
				if ( is_numeric( $text_val ) && ( is_string( $val ) || is_numeric( $val ) ) ) {
					$text_val = $val;
				}
				$selected = '';
				if ( $param_value !== '' && (string) $val === (string) $param_value ) {
					$selected = ' selected="selected"';
				}

				$d = isset( $groupedSwitches[ $val ] ) ? $groupedSwitches[ $val ] : array();

				$dataDefinition = $d ? ' data-definition="' . esc_attr( json_encode( $d ) ) . '"' : '';

				$param_line .= '<option' . $dataDefinition . ' class="' . $val . '" value="' . $val . '"' . $selected . '>' . htmlspecialchars( $text_val ) . '</option>';
			}
			$param_line .= '</select>';


			return $param_line;
		}

		/**
		 * Groups switches
		 *
		 * @param $switches
		 *
		 * @return array
		 */

		protected function getGroupedSwitches( $switches ) {
			$gr = array();
			foreach ( $switches as $group => $fields ) {
				foreach ( $fields as $fieldName => $data ) {
					foreach ( $data as $option => $fieldValue ) {
						$gr[ $option ][ $group ][ $fieldName ] = $fieldValue;
					}
				}
			}

			return $gr;
		}

		/**
		 * Icon
		 *
		 * @param $settings
		 * @param $value
		 *
		 * @return string
		 */

		public function icon( $settings, $value ) {
			if ( ! isset( $settings['font_types'] ) ) {
				$settings['font_types'] = array( 'awesome' );
			}


			//pre parse + connect proper events
			foreach ( $settings['font_types'] as $type ) {
				$typeMethod = 'getOptionsForIcon' . ucfirst( strtolower( $type ) );
				$this->$typeMethod();
			}

			$pre = apply_filters( 'ct_visual_composer_integrator.icon.pre_parsed', '' );

			$html = $pre . '<div class="ct_icon_block">'
			        . '<select name="' . $settings['param_name']
			        . '" class="wpb_vc_param_value ct-icon-select '
			        . $settings['param_name'] . ' ' . $settings['type'] . '_field">';
			foreach ( $settings['font_types'] as $type ) {
				$typeMethod = 'getOptionsForIcon' . ucfirst( strtolower( $type ) );
				$options    = $this->$typeMethod();

				foreach ( $options as $name ) {
					$html .= '<option ' . selected( $name['class'], $value, false ) . ' value="' . esc_attr( $name['class'] ) . '">' . esc_attr( $name['class'] ) . '</option>';
				}
			}

			$html .= '</select></div>';

			//load any additional styles
			do_action( 'ct_visual_composer_integrator.icon.post_parsed' );


			return $html;
		}

		/**
		 * Return font awesome options
		 */

		protected function getOptionsForIconEtline() {
			$helper = new ctFontEtLineHelper();

			return $helper->getFonts();
		}

		/**
		 * Return font awesome options
		 */

		protected function getOptionsForIconAwesome() {
			$helper = new ctFontAwesomeHelper();

			return $helper->getFonts();
		}

	}

	new ctVisualComposerCustomParams();
}