<?php

abstract class ctChartModelItemShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {
	protected static $counter = 0;


	/**
	 * Reterns string in camelcase or array with keys in camelcase e.g. "this_method_name" -> "thisMethodName"
	 *
	 * @param $data mixed (string or array)
	 *
	 * @return mixed (string or array)
	 *
	 */
	public function underscoreToCamelcase( $data ) {
		if ( is_array( $data ) ) {
			$camelCase = array();
			foreach ( $data as $key => $val ) {
				$camelCase[ $this->underscoreToCamelcase( $key ) ] = $val;
			}

			return $camelCase;
		}
		$words  = explode( '_', $data );
		$return = '';
		foreach ( $words as $key => $word ) {
			if ( $key != 0 ) {
				$return .= ucfirst( $word );
			} else {
				$return .= $word;
			}
		}

		return $return;
	}

	public function __construct() {
		parent::__construct();
		//connect for additional code
		//remember - method must be PUBLIC!
		$this->connectPreFilter( $this->getParentShortcodeName(), array( $this, 'handlePreFilter' ) );
	}

	public function getShortcodeName() {
		return $this->getParentShortcodeName() . '_item';
	}

	/**
	 * Handles shortcode
	 *
	 * @param $atts
	 * @param null $content
	 *
	 * @return mixed
	 */
	public function handle( $atts, $content = null ) {
		extract( shortcode_atts( $this->extractShortcodeAttributes( $atts ), $atts ) );
		$counter = ++ self::$counter;

		//add for pre filter data. Adds any data to this shortcode type
		$this->setData( $counter,
			array(
				'value'     => (float) $value,
				'label'     => $legend,
				'color'     => $color,
				'highlight' => $highlight,
			) );

		return '';
	}

	/**
	 * Returns config attributes
	 * @return array
	 */
	public function getAttributes() {
		return array(
			'value'     => array(
				'label'   => esc_html__( 'Value', 'ct_theme' ),
				'default' => 0,
				'type'    => 'input',
				'help'    => esc_html__( 'Value of the the piece of the chart', 'ct_theme' )
			),
			'legend'    => array(
				'label'   => esc_html__( 'Legend label', 'ct_theme' ),
				'default' => '',
				'type'    => 'input',
				'help'    => esc_html__( 'Legend label for the piece', 'ct_theme' )
			),
			'color'     => array(
				'label'   => esc_html__( 'Color', 'ct_theme' ),
				'default' => '',
				'type'    => 'colorpicker',
				'help'    => esc_html__( 'Colour of the piece', 'ct_theme' )
			),
			'highlight' => array(
				'label'   => esc_html__( 'Highlight color', 'ct_theme' ),
				'default' => '',
				'type'    => 'colorpicker',
				'help'    => esc_html__( 'Colour of piece when highlighted', 'ct_theme' )
			),
		);
	}

	/**
	 * Adds content before filters
	 *
	 * @param string $content
	 *
	 * @return string
	 */
	public function handlePreFilter( $content ) {
		$values = array();
		//here - add all available content
		foreach ( $this->getAllData() as $data ) {
			$values[] = $data;
		}

		return $values;
	}
}
