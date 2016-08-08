<?php

/**
 * List shortcode
 */
class ctListWidgetShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'ListWidget';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'listWidget';
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
	public function handle( $atts, $content = null ) {
		extract( shortcode_atts( $this->extractShortcodeAttributes( $atts ), $atts ) );

		$mainContainerAtts = array(
			'class' => array(
'ct-u-paddingTop10 ct-u-paddingBottom40',
				$class
			),
		);

		



		$html = '
<h5 class="text-uppercase ct-fw-600 ct-u-motiveBody">'.$title.'</h5>
<div class="ct-list"><ul ' . $this->buildContainerAttributes( $mainContainerAtts, $atts ) . '>' . do_shortcode( $content ) . '</ul></div>';

		return do_shortcode( $html );
	}

	/**
	 * Child shortcode info
	 * @return array
	 */

	public function getChildShortcodeInfo() {
		return array( 'name' => 'list_itemwidget', 'min' => 1, 'max' => 20, 'default_qty' => 1 );
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(

			'title' => array(
			'label' => __('title', 'ct_theme'),
				'type'=> 'input',
				'default' => '',
			),

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

new ctListWidgetShortcode();