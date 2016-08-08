<?php

/**
 * ${DESCRIPTION}$
 * @author createit
 */
class ctControlsFactory {

	static private $instance = null;

	protected $wp_customize;

	protected $types = array();

	protected function __construct( $wp_customize ) {
		ctThemeLoader::getFilesLoader()->getFilesByPattern( CT_ADVANCED_CUSTOMIZER_PATH.'/controls');
		$this->wp_customize = $wp_customize;
		self::$instance     = $this;
		$this->register( 'input', 'WP_Customize_Control' )
		     ->register( 'color', 'WP_Customize_Color_Control' )
		     ->register( 'font', 'ctGoogleFontControl' )
			 ->register( 'fontset', 'ctSubsetFontControl')
		     ->register( 'numberselect', 'ctNumberSelectControl' )
		     ->register( 'select', 'ctSelectControl' )
		     ->register( 'image', 'ctImageControl' )
		     ->register( 'posts', 'ctPostDropdownControl' )
		     ->register( 'range', 'ctRangeControl' )
		     ->register( 'textarea', 'ctTextAreaControl' )
		     ->register( 'radio', 'ctRadioControl' )
		     ->register( 'show', 'ctSelectShowControl' );
	}

	public function register( $typename, $classname ) {
		$this->types[ $typename ] = $classname;

		return $this;
	}

	public function remove( $typename ) {
		if ( array_key_exists( $typename, $this->types ) ) {
			unset( $this->types[ $typename ] );
		}

		return $this;
	}

	public function get( $settingId, $type = 'input', $options = array() ) {
		if ( ! array_key_exists( $type, $this->types ) ) {
			$type = 'input';
		}

		return new $this->types[$type]( $this->wp_customize, $settingId, $options );

	}

	public function filter( $val, $object ) {
		if ( $object instanceof ctControlsFilterableInterface ) {
			$object->filter($val);
			$val = apply_filters( 'ct_customizer_value_' . $object->type, $val, $object);
		}

		return $val;
	}

	public static function getInstance( $wp_customize ) {
		if ( self::$instance === null ) {
			new ctControlsFactory( $wp_customize );
		}

		return self::$instance;
	}

	public function getTypes(){
	return $this->types;
}
}