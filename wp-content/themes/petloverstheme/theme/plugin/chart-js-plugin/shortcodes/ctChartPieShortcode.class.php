<?php

class ctChartPieShortcode extends ctChartModelShortcode {


	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-pie-chart' ) );
	}


	public function getAttributes() {
		$atts                         = parent::getAttributes();
		$atts['segment_stroke_show']  = array(
			'label'   => esc_html__( 'Segment stroke show', 'ct_theme' ),
			'default' => 'true',
			'type'    => 'select',
			'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
			'help'    => esc_html__( 'Stroke a line around each segment in the chart', 'ct_theme' ),
		);
		$atts['segment_stroke_color'] = array(
			'label'   => esc_html__( 'Segment stroke clolour', 'ct_theme' ),
			'default' => 'rgba(255,255,255,0.75)',
			'type'    => 'colorpicker',
			'help'    => esc_html__( 'The colour of the segment stroke', 'ct_theme' ),
		);
		if ( array_key_exists( 'labels', $atts ) ) {
			unset( $atts['labels'] );
		}

		return $atts;
	}

	public function getChildShortcodeInfo() {
		return array( 'name' => 'chart_pie_item', 'min' => 1, 'max' => 1000, 'default_qty' => 3 );
	}

	public function getJSFuctionName() {
		return 'Pie';
	}

}

new ctChartPieShortcode();