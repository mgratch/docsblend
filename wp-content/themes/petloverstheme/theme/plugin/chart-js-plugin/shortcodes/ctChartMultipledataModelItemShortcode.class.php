<?php

/**
 * ${DESCRIPTION}$
 * @author createit
 */

require_once CT_CHARTS_JS_PATH . '/shortcodes/ctChartModelItemShortcode.class.php';

abstract class ctChartMultipledataModelItemShortcode extends ctChartModelItemShortcode {

	public function handle( $atts, $content = null ) {
		$attributes = shortcode_atts( $this->extractShortcodeAttributes( $atts ), $atts );
		extract( $attributes );

		$counter = ++ self::$counter;

		//remove not numeric chars from data array
		$data = explode( ',', $data );
		foreach ( $data as &$val ) {
			$val = preg_replace( "/[^0-9,.]/", "", $val );
			$val = (float) $val;
		}
		$attributes['data'] = $data;

		//add for pre filter data. Adds any data to this shortcode type
		$this->setData( $counter, $this->underscoreToCamelcase( $attributes ) );

		return '';
	}

	public function getAttributes() {
		//use underscore for keys in array. It will be changed to camelCase needed in chart.js
		return array(
			'data'                   => array(
				'label'   => esc_html__( 'Values', 'ct_theme' ),
				'default' => '',
				'type'    => 'input',
				'help'    => esc_html__( 'Comma separated values ex. 4,6', 'ct_theme' )
			),
			'label'                  => array(
				'label'   => esc_html__( 'Series label', 'ct_theme' ),
				'default' => '',
				'type'    => 'input',
				'help'    => esc_html__( 'Label for the data series', 'ct_theme' )
			),
			'fill_color'             => array(
				'label'   => esc_html__( 'Fill Color', 'ct_theme' ),
				'default' => '',
				'type'    => 'colorpicker',
				'help'    => esc_html__( 'Fill colour of the data series', 'ct_theme' )
			),
			'stroke_color'           => array(
				'label'   => esc_html__( 'Stroke Color', 'ct_theme' ),
				'default' => '',
				'type'    => 'colorpicker',
				'help'    => esc_html__( 'Stroke colour of the data series', 'ct_theme' )
			),
			'point_color'            => array(
				'label'   => esc_html__( 'Point Color', 'ct_theme' ),
				'default' => '',
				'type'    => 'colorpicker',
				'help'    => esc_html__( 'Fill colour of the points', 'ct_theme' )
			),
			'point_stroke_color'     => array(
				'label'   => esc_html__( 'Point stroke Color', 'ct_theme' ),
				'default' => '',
				'type'    => 'colorpicker',
				'help'    => esc_html__( 'Stroke colour of the points', 'ct_theme' )
			),
			'point_highlight_fill'   => array(
				'label'   => esc_html__( 'Point Highlight Color', 'ct_theme' ),
				'default' => '',
				'type'    => 'colorpicker',
				'help'    => esc_html__( 'Fill colour of the points when highlighted', 'ct_theme' )
			),
			'point_highlight_stroke' => array(
				'label'   => esc_html__( 'Point Highlight Stroke', 'ct_theme' ),
				'default' => '',
				'type'    => 'colorpicker',
				'help'    => esc_html__( 'Stroke colour of the points when highlighted', 'ct_theme' )
			),
		);
	}

}