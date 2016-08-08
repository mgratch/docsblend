<?php

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}
require_once CT_ADVANCED_CUSTOMIZER_PATH . '/controls/ctControl.class.php';

/**
 * ${DESCRIPTION}$
 */
class ctSelectShowControl extends ctControl /*implements ctControlsFilterableInterface */{


	public function  __construct( $wp_customize, $settingId, $options ) {
		$options['type'] = 'select';


		$options['choices']["1"] = esc_html__('show','ct_theme');
		$options['choices']["0"] = esc_html__('hide','ct_theme');


		parent::__construct( $wp_customize, $settingId, $options );
	}

	/**
	 * @param string $val value from form
	 * @param $options
	 *
	 * @return mixed
	 */
	/*
	public function filter( $val ) {
		$val = (int) $val;
		$val = $val . $this->suffix;

		return $val;
	}
	*/
}