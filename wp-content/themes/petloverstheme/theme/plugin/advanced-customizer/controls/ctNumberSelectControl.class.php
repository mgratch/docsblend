<?php

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}
require_once CT_ADVANCED_CUSTOMIZER_PATH.'/controls/ctControl.class.php';

/**
 * ${DESCRIPTION}$
 * @author scyzoryck
 */
class ctNumberSelectControl extends ctControl /*implements ctControlsFilterableInterface */{


	protected $suffix;
	protected $step;
	protected $min = 0;
	protected $max = 30;

	public function  __construct( $wp_customize, $settingId, $options ) {
		$options['type'] = 'select';
		if ( isset( $options['min'] ) && isset( $options['max'] ) ) {
			$this->min    = isset($options['min'])? $options['min'] : 0 ;
			$this->max    = isset($options['max']) ? $options['max'] : 30;
			$this->suffix = isset( $options['suffix'] ) ? $options['suffix'] : '';
			$this->step   = isset( $options['step'] ) ? (float) $options['step'] : '1';
			for ( $i = $this->min; $i < $this->max; $i += $this->step ) {
				$options['choices'][ $i . $this->suffix ] = $i . $this->suffix;
			}
		}

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