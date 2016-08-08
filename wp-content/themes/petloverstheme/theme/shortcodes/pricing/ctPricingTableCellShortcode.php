<?php

/**
 * Paragraph shortcode
 */
class ctPricingTableCellShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Pricing Table Cell';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'pricing_table_cell';
	}

	/**
	 * Returns shortcode type
	 * @return mixed|string
	 */

	public function getShortcodeType() {
		return self::TYPE_SHORTCODE_ENCLOSING;
	}

	/**
	 * Parent shortcode name
	 * @return null
	 */

	public function getParentShortcodeName() {
		return 'pricing_table_item';
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
		extract( shortcode_atts( $this->extractShortcodeAttributes( $atts ), $atts ) );




			return do_shortcode( '<tr><td class="ct-textLeft">
<i class="fa fa-check ct-tableIcon '.$icon.'"></i>
<span>'.$content.'</span>
</td></tr>' );

		}


	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'icon' => array(
				'label'   => __( 'icon', 'ct_theme' ),
				'default' => 'success',
				'type'    => 'select',
				'choices' => array(
					'ct-tableIcon--success' => __( 'green success', 'ct_theme' ),
					'ct-tableIcon--danger' => __( 'red success', 'ct_theme' ) ),
			),

			'content'           => array(
				'label'   => __( 'Cell', 'ct_theme' ),
				'default' => '',
				'type'    => "input"
			),
			'class'             => array(
				'label'   => __( 'Custom class', 'ct_theme' ),
				'default' => '',
				'type'    => 'input'
			),
		);
	}

	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-table' ) );
	}
}

new ctPricingTableCellShortcode();