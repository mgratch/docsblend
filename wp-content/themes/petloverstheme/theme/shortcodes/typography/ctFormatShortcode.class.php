<?php

/**
 * Header shortcode
 */
class ctFormatShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Format';
	}


	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'format';
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
		$style = '';
		extract( shortcode_atts( $this->extractShortcodeAttributes( $atts ), $atts ) );

		$mainContainerAtts = array(
			'class' => array(
				$class,
				$additional_class
			),
		);

		$html = '<' . $tag . $this->buildContainerAttributes( $mainContainerAtts, $atts ) . '>' . do_shortcode( $content ) . '</' . $tag . '>';

		return do_shortcode( $html );
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'tag'              => array(
				'label'   => __( 'Select tag', 'ct_theme' ),
				'default' => 'span',
				'type'    => 'select',
				'options' => array(
					'span'  => 'span',
					'small' => 'small',
					'big'   => 'big',
					'cite'  => 'cite',
					'div'   => 'div',
				)
			),
			'content'          => array( 'label'   => __( 'Content', 'ct_theme' ),
			                             'default' => '',
			                             'type'    => "textarea"
			),
			'class'            => array(
				'label'   => __( "Header custom class", 'ct_theme' ),
				'default' => '',
				'type'    => 'input',
				'help'    => __( "custom class, adding custom class allows you to set diverse styles in css to the element. type in name of class, which you defined in css. you can add as much classes as you like.", 'ct_theme' )
			),
			'additional_class' => array('type'=>false,'help'=>"test")
		);
	}

	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array(
			'icon' => 'fa-header',
			'description' => __( "Add custom styles to your text", 'ct_theme')
			) );
	}

}

new ctFormatShortcode();