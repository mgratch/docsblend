<?php
/**
 * ${DESCRIPTION}$
 * @author createit
 */

require_once CT_CHARTS_JS_PATH . '/shortcodes/ctChartMultipledataModelShortcode.class.php';

class ctChartBarShortcode extends ctChartMultipledataModelShortcode {


	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-bar-chart' ) );
	}


	public function getAttributes() {
		$atts = parent::getAttributes();

		$atts['scale_begin_at_zero'] = array(
			'label'   => esc_html__( 'Scale begin at zero', 'ct_theme' ),
			'default' => 'true',
			'type'    => 'select',
			'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
			'help'    => esc_html__( 'Whether the scale should start at zero, or an order of magnitude down from the lowest value', 'ct_theme' ),
		);
		$atts['scale_show_grid_lines'] = array(
					'label'   => esc_html__( 'Scale show grid lines', 'ct_theme' ),
					'default' => 'true',
					'type'    => 'select',
					'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
					'help'    => esc_html__( 'Whether grid lines are shown across the chart', 'ct_theme' ),
				);
		$atts['scale_grid_line_color'] = array(
			'label'   => esc_html__( 'Scale grid line color', 'ct_theme' ),
			'default' => '',
			'type'    => 'colorpicker',
			'help'    => esc_html__('Colour of the grid lines', 'ct_theme'),
		);
		$atts['bar_show_stroke'] = array(
			'label'   => esc_html__( 'Bar show stroke', 'ct_theme' ),
			'default' => 'true',
			'type'    => 'select',
			'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
			'help'    => esc_html__( 'If there is a stroke on each bar', 'ct_theme' ),
		);
		return $atts;
	}

	public function getChildShortcodeInfo() {
		return array( 'name' => 'chart_bar_item', 'min' => 1, 'max' => 1000, 'default_qty' => 3 );
	}

	public function getJSFuctionName() {
		return 'Bar';
	}

}

new ctChartBarShortcode();