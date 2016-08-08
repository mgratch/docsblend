<?php

/**
 * List shortcode
 */
class ctListIconShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'List Icon';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'list_icon';
	}

	/**
	 * Returns shortcode type
	 * @return mixed|string
	 */
	public function getShortcodeType() {
		return self::TYPE_SHORTCODE_ENCLOSING;
	}


	/**
	 * Handles shortcode
	 *
	 * @param $atts
	 * @param null $content
	 *
	 * @return string
	 */

	public static $type;


	public function handle( $atts, $content = null ) {
		extract( shortcode_atts( $this->extractShortcodeAttributes( $atts ), $atts ) );



		switch ($type) {
			default:
			case 'simple':
				self::$type = 'simple';
				$html = '<ul class="list-unstyled">' . do_shortcode($content) . '</ul>';
				break;

			case 'simple_bold':
				self::$type = 'simple_bold';
				$html = '<ul class="list-unstyled ct-fw-600">' . do_shortcode($content) . '</ul>';
				break;



			case 'fancy_container':
				self::$type = 'fancy_container';
				$html = '<ul class="list-unstyled">' . do_shortcode($content) . '</ul>';
				break;

			case 'list_group_simple':
				self::$type = 'list_group_simple';
				$html = '<ul class="list-group">' . do_shortcode($content) . '</ul>';
				break;

			case 'list_group':
				self::$type = 'list_group';
				$html = '<ul class="list-group">' . do_shortcode($content) . '</ul>';
				break;
		}

		return do_shortcode( $html );
	}

	/**
	 * Child shortcode info
	 * @return array
	 */

	public function getChildShortcodeInfo() {
		return array( 'name' => 'list_icon_item', 'min' => 1, 'max' => 20, 'default_qty' => 2 );
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(

			'type' => array('label' => __('type', 'ct_theme'),
				'default' => 'ordered',
				'type' => 'select',
				'options' => array(
					'simple' => 'simple',
					'simple_bold' => __('simple bold', 'ct_theme'),
					'fancy_container' => __('fancy container', 'ct_theme'),
					'list_group_simple' => __('list group simple', 'ct_theme'),
					'list_group' =>	__('list group', 'ct_theme'))),


			'class'   => array(
				'label'   => __( 'Custom class', 'ct_theme' ),
				'type'    => 'input',
				'default' => '',
				'help'    => __("Set custom class to element",'ct_theme')
			),

		);
	}

	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array(
			'icon'        => 'fa-list',
			'description' => __( "Add list group", 'ct_theme' )
		) );
	}
}

new ctListIconShortcode();

//#28144
if(class_exists('WPBakeryShortCodesContainer')){
	class WPBakeryShortcode_list_icon extends WPBakeryShortCodesContainer{}
}