<?php

/**
 * ${DESCRIPTION}$
 * @author createit
 */

require_once CT_CHARTS_JS_PATH . '/shortcodes/ctChartMultipledataModelItemShortcode.class.php';


class ctChartBarItemShortcode extends ctChartMultipledataModelItemShortcode {
	/**
	 * Returns shortcode label
	 * @return mixed
	 */
	public function getName() {
		return 'Chart Bar Item';
	}

	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-bar-chart' ) );
	}

	public function getParentShortcodeName() {
		return 'chart_bar';
	}

	public function getAttributes() {
		// this type doesn't have options poinColor and pointStrokecolor
		$attributes  = parent::getAttributes();
		$remove_keys = array( 'point_color', 'point_stroke_color', 'point_highlight_fill', 'point_highlight_stroke' );
		foreach ( $remove_keys as $key ) {
			if ( array_key_exists( $key, $attributes ) ) {
				unset( $attributes[ $key ] );
			}
		}
		$attributes['highlight_fill']         = array(
			'label'   => esc_html__( 'Highlight Color', 'ct_theme' ),
			'default' => '',
			'type'    => 'colorpicker',
			'help'    => esc_html__( 'Fill colour of data series when highlighted', 'ct_theme' )

		);
		$attributes['point_highlight_stroke'] = array(
			'label'   => esc_html__( 'Highlight Stroke', 'ct_theme' ),
			'default' => '',
			'type'    => 'colorpicker',
			'help'    => esc_html__( 'Stroke colour of the data series when highlighted', 'ct_theme' )

		);

		return $attributes;
	}


}

new ctChartBarItemShortcode();