<?php

/**
 * Pricelist shortcode
 */
class ctCountDownRowShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Countdown Row';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'countdown_row';
	}

	/**
	 * Returns shortcode type
	 * @return mixed|string
	 */

	public function getShortcodeType() {
		return self::TYPE_SHORTCODE_ENCLOSING;
	}


	public function enqueueScripts() {
		wp_register_script( 'countdown', CT_THEME_ASSETS . '/js/countdown/jquery.mb-comingsoon.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'countdown' );


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





		return '
<div class="row centered text-center " id="counter"></div>

  <script type="text/javascript">


  	jQuery( document ).ready(function() {
	    jQuery("#counter").mbComingsoon({expiryDate: new Date("'.$year.'", "'.$month.'", "'.$day.'", "'.$hour.'", "'.$minute.'"), speed: 950});
});
</script>';




	}


	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'year' => array(
				'label'   => __( 'Year', 'ct_theme' ),
				'default' => '2015',
				'type'    => 'input',
			),
			'month' => array(
				'label'   => __( 'month', 'ct_theme' ),
				'default' => '1',
				'type'    => 'input',
			),
			'day' => array(
				'label'   => __( 'day', 'ct_theme' ),
				'default' => '24',
				'type'    => 'input',
			),
			'hour' => array(
				'label'   => __( 'hour', 'ct_theme' ),
				'default' => '9',
				'type'    => 'input',
			),
			'minute' => array(
				'label'   => __( 'minute', 'ct_theme' ),
				'default' => '00',
				'type'    => 'input',
			),




			'class'      => array(
				'label'   => __( "Custom class", 'ct_theme' ),
				'default' => '',
				'type'    => 'input',
				'help'    => __( 'Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme' )
			),
		);
	}

	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-clock-o' ) );
	}
}


new ctCountDownRowShortcode();



