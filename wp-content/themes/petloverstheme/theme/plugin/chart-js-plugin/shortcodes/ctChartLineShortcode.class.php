<?php
/**
 * ${DESCRIPTION}$
 * @author createit
 */

require_once CT_CHARTS_JS_PATH . '/shortcodes/ctChartMultipledataModelShortcode.class.php';

class ctChartLineShortcode extends ctChartMultipledataModelShortcode {


	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-line-chart' ) );
	}


	public function getAttributes() {
		$atts = parent::getAttributes();
		$atts['scale_show_grid_lines'] = array(
			'label'   => esc_html__( 'Scale show grid lines', 'ct_theme' ),
			'default' => true,
			'type'    => 'select',
			'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
			'help'    => esc_html__( 'Whether grid lines are shown across the chart','ct_theme' ),
		);
		$atts['scale_grid_line_color'] = array(
			'label'   => esc_html__( 'Scale grid line color', 'ct_theme' ),
			'default' => '',
			'type'    => 'colorpicker',
			'help'    => 'Colour of the grid lines',
		);
		$atts['bezier_curve'] = array(
			'label'   => esc_html__( 'Beizer curve', 'ct_theme' ),
			'default' => 'true',
			'type'    => 'select',
			'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
			'help'    => esc_html__('Whether the line is curved between points', 'ct_theme'),
		);
		$atts['point_dot'] = array(
					'label'   => esc_html__( 'Point dot', 'ct_theme' ),
					'default' => 'true',
					'type'    => 'select',
					'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
					'help'    => esc_html__('Whether to show a dot for each point', 'ct_theme'),
				);
		$atts['dataset_fill'] = array(
					'label'   => esc_html__( 'Dataset fill', 'ct_theme' ),
					'default' => 'true',
					'type'    => 'select',
					'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
					'help'    => esc_html__('Whether to fill the dataset with a colour', 'ct_theme'),
				);
		return $atts;
	}

	public function getChildShortcodeInfo() {
		return array( 'name' => 'chart_line_item', 'min' => 1, 'max' => 1000, 'default_qty' => 3 );
	}

	public function getJSFuctionName() {
		return 'Line';
	}

}

new ctChartLineShortcode();