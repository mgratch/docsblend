<?php

class ctChartPolarAreaShortcode extends ctChartModelShortcode {


	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-area-chart' ) );
	}


	public function getAttributes() {
		$atts                              = parent::getAttributes();
		$atts['scale_show_label_backdrop'] = array(
			'label'   => esc_html__( 'Scale show label backdrop', 'ct_theme' ),
			'default' => 'false',
			'type'    => 'select',
			'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
			'help'    => esc_html__( 'Show a backdrop to the scale label', 'ct_theme' ),
		);
		$atts['scale_backdrop_color']      = array(
			'label'   => esc_html__( 'Scale backdrop clolour', 'ct_theme' ),
			'default' => 'rgba(255,255,255,0.75)',
			'type'    => 'colorpicker',
			'help'    => esc_html__( 'The colour of the label backdrop', 'ct_theme' ),
		);
		$atts['scale_begin_at_zero']       = array(
			'label'   => esc_html__( 'Scale begin at zero', 'ct_theme' ),
			'default' => 'true',
			'type'    => 'select',
			'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
			'help'    => esc_html__( 'Whether the scale should begin at zero', 'ct_theme' ),
		);
		$atts['scale_show_line']           = array(
			'label'   => esc_html__( 'Scale show line', 'ct_theme' ),
			'default' => 'true',
			'type'    => 'select',
			'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
			'help'    => esc_html__( 'Whether to show lines for each scale point', 'ct_theme' ),
		);
		$atts['segment_stroke_show']       = array(
			'label'   => esc_html__( 'Segment stroke show', 'ct_theme' ),
			'default' => 'true',
			'type'    => 'select',
			'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
			'help'    => esc_html__( 'Stroke a line around each segment in the chart', 'ct_theme' ),
		);
		$atts['segment_stroke_color']      = array(
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


	public function getJSFuctionName() {
		return 'PolarArea';
	}

}

new ctChartPolarAreaShortcode();