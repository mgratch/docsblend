<?php

/**
 * List shortcode
 */
class ctListShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'List';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'list';
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

		$mainContainerAtts = array(
			'class' => array(
				'ct-u-paddingTop10 ct-u-paddingBottom40',
				$class
			),
		);






		if ($type == 'default') {
			self::$type = 'default';
			$html = '<div class="ct-list"><ul ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>' . do_shortcode($content) . '</ul></div>';
		} else {
			self::$type = 'simple';
			$html = '<ul class="ct-simpleList list-unstyled ct-u-paddingTop10 ct-u-paddingBottom40">' . do_shortcode($content) . '</ul>';
		}




		return do_shortcode( $html );
	}

	/**
	 * Child shortcode info
	 * @return array
	 */

	public function getChildShortcodeInfo() {
		return array( 'name' => 'list_item', 'min' => 1, 'max' => 20, 'default_qty' => 2 );
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(

			'type' => array('label' => __('type', 'ct_theme'),
				'default' => 'default',
				'type' => 'select',
				'options' => array(
					'default' => 'default',
					'simple' => 'simple')),


			'class'   => array(
				'label'   => __( 'Custom class', 'ct_theme' ),
				'type'    => 'input',
				'default' => '',
				'help'    => "Set custom class to element"
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

new ctListShortcode();

//#28144
if(class_exists('WPBakeryShortCodesContainer')){
	class WPBakeryShortcode_list extends WPBakeryShortCodesContainer{}
}