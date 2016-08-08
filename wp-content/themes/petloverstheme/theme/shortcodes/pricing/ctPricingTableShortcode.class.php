<?php

/**
 * Tabs shortcode
 */
class ctPricingTableShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {
	public static $featured;

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Pricing Table';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'pricing_table';
	}


	/**
	 * Handles shortcode
	 *
	 * @param $atts
	 * @param null $content
	 *
	 * @return string
	 */

	public function handle( $atts, $content = null ) {
		$attributes = shortcode_atts( $this->extractShortcodeAttributes( $atts ), $atts );
		extract( $attributes );

		$mainContainerAtts = array(
			'class' => array(
				'table',
				$class
			),
		);
		$html              = '
                <div ' . $this->buildContainerAttributes( $mainContainerAtts, $atts ) . '>
                <div class="row">

                ' . $content . '

                </div>

                </div>';


		return do_shortcode( $html );
	}


	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'class' => array(
				'label'   => __( 'Custom class', 'ct_theme' ),
				'default' => '',
				'type'    => 'input',
				'help'    => __( 'Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme' )
			),

		);
	}


	/**
	 * Child shortcode info
	 * @return array
	 */

	public function getChildShortcodeInfo() {
		return array( 'name' => 'pricing_table_item', 'min' => 2, 'max' => 50, 'default_qty' => 1 );
	}

	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array(
			'container' => true,
			'icon'      => 'fa-table'
		) );
	}
}

new ctPricingTableShortcode();

//#28144
if(class_exists('WPBakeryShortCodesContainer')){
	class WPBakeryShortcode_pricing_table extends WPBakeryShortCodesContainer{}
}