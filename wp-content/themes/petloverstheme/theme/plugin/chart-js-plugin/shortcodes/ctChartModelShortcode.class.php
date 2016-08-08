<?php

/*
 * Chart class model
 */

abstract class ctChartModelShortcode extends ctShortcode implements ctVisualComposerShortcodeInterface {

	/**
	 * Reterns string in camelcase or array with keys in camelcase e.g. "this_method_name" -> "thisMethodName"
	 *
	 * @param $data mixed (string or array)
	 *
	 * @return mixed (string or array)
	 *
	 */
	protected function underscoreToCamelcase( $data ) {
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

	/**
	 * Returns options for chart.js in json
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	protected function getChartOptionsFromAttributes( $atts ) {
		$remove_keys = array( 'labels', 'width', 'height' );
		foreach ( $remove_keys as $key ) {
			if ( array_key_exists( $key, $atts ) ) {
				unset( $atts[ $key ] );
			}
		}

		$options = new stdClass();
		foreach ( $atts as $key => $val ) {
			// change string to boolean
			$val                                             = ( $val === 'true' ) ? true : $val;
			$val                                             = ( $val === 'false' ) ? false : $val;
			$options->{$this->underscoreToCamelcase( $key )} = $val;
		}

		return json_encode( $options );
	}

	/**
	 * Returns shortcode label
	 * @return mixed
	 */
	public function getName() {
		return $this->getJSFuctionName() . 'Chart';
	}


	/**
	 * Returns shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'chart_' . strtolower( $this->getJSFuctionName() );
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
		$attributes = shortcode_atts( $this->extractShortcodeAttributes( $atts ), $atts );
		extract( $attributes );

		$id = $this->getShortcodeName() . rand( 100, 1000 );


		//parse shortcode before filters
		do_shortcode( $content );

		$json = json_encode( $this->callPreFilter( '' ) );
		//clean current tab cache
		$this->cleanData( '' . $this->getShortcodeName() . '_item' );
		$this->addInlineJS( $this->getInlineJS( $attributes, $id, $json ) );

		$html = '<canvas id="' . $id . '" width="' . $width . '" height="' . $height . '"></canvas>';


		return do_shortcode( $html );
	}

	public function getChildShortcodeInfo() {
		return array( 'name' => $this->getShortcodeName() . '_item', 'min' => 1, 'max' => 1000, 'default_qty' => 3 );
	}

	/**
	 * Returns config attributes
	 * @return array
	 */
	public function getAttributes() {
		return array(
			'width'             => array(
				'default' => '150',
				'type'    => 'input',
				'label'   => esc_html__( 'Width', 'ct_theme' )
			),
			'height'            => array(
				'default' => '150',
				'type'    => 'input',
				'label'   => esc_html__( 'Height', 'ct_theme' )
			),
			'labels'            => array(
				'label'   => esc_html__( 'Labels', 'ct_theme' ),
				'default' => '',
				'type'    => 'input',
				'help'    => esc_html__( 'Comma separated values ex. lab1,lab2', 'ct_theme' ),
			),
			'animation'         => array(
				'label'   => esc_html__( 'Animation', 'ct_theme' ),
				'default' => 'true',
				'type'    => 'select',
				'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
				'help'    => esc_html__( 'Whether to animate the chart', 'ct_theme' ),
			),
			'scale_font_family' => array(
				'label'   => esc_html__( 'Scale font family', 'ct_theme' ),
				'default' => 'Arial',
				'type'    => 'input',
				'help'    => esc_html__( 'Point label font declaration', 'ct_theme' ),
			),
			'scale_font_size'   => array(
				'label'   => esc_html__( 'Scale font size', 'ct_theme' ),
				'default' => '12',
				'type'    => 'input',
				'help'    => esc_html__( 'Scale font size in pixels', 'ct_theme' ),
			),
			'scale_font_color'  => array(
				'label'   => esc_html__( 'Point label font color', 'ct_theme' ),
				'default' => '#666',
				'type'    => 'colorpicker',
				'help'    => esc_html__( 'Scale font colour', 'ct_theme' ),
			),

		);
	}


	protected function getInlineJS( $attributes, $id, $json ) {
		extract( $attributes );

		return '
var ctx_' . $id . ' = jQuery("#' . $id . '").get(0).getContext("2d");
var data_' . $id . ' = ' . $json . '
var options_' . $id . ' = ' . $this->getChartOptionsFromAttributes( $attributes ) . ';
var ' . $id . ' = new Chart(ctx_' . $id . ').' . $this->getJSFuctionName() . '(data_' . $id . ', options_' . $id . ');
     ';
	}

	/**
	 *
	 */
	public function enqueueScripts() {
		wp_register_script( 'chart', CT_THEME_ASSETS . '/js/Chart.js', array( 'jquery' ), false, true );

		//wp_register_script( 'chart', CT_THEME_SETTINGS_MAIN_DIR_URI . '/plugin/chart.js/assets/Chart.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'chart' );
	}

	/**
	 * Returns name of JS function used for chart
	 * @return string
	 */
	public abstract function getJSFuctionName();
}