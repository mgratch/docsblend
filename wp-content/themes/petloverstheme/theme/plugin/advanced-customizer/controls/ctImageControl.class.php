<?php

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}
require_once CT_ADVANCED_CUSTOMIZER_PATH.'/controls/ctControl.class.php';

/**
 * ${DESCRIPTION}$
 */
class ctImageControl extends WP_Customize_Image_Control /*implements ctControlsFilterableInterface */{


	protected $suffix;
	protected $step;
	protected $min = 0;
	protected $max = 30;

	public function  __construct( $wp_customize, $settingId, $options ) {

		 parent::__construct( $wp_customize, $settingId, $options );
		//$obj->render_content();
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