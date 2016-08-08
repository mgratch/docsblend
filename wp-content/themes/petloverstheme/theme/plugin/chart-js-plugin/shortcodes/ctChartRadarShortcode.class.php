<?php
/**
 * ${DESCRIPTION}$
 * @author createit
 */

require_once CT_CHARTS_JS_PATH . '/shortcodes/ctChartMultipledataModelShortcode.class.php';

class ctChartRadarShortcode extends ctChartMultipledataModelShortcode {


	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-line-chart' ) );
	}


	public function getAttributes() {
		$atts                            = parent::getAttributes();
		$atts['scale_show_line']         = array(
			'label'   => esc_html__( 'Scale show line', 'ct_theme' ),
			'default' => 'true',
			'type'    => 'select',
			'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
			'help'    => esc_html__( 'Whether to show lines for each scale point', 'ct_theme' ),
		);
		$atts['angle_show_line_out']     = array(
			'label'   => esc_html__( 'Angle show line out', 'ct_theme' ),
			'default' => 'true',
			'type'    => 'select',
			'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
			'help'    => esc_html__( 'ther we show the angle lines out of the radar', 'ct_theme' ),
		);
		$atts['scale_show_labels']       = array(
			'label'   => esc_html__( 'Scale show labels', 'ct_theme' ),
			'default' => 'false',
			'type'    => 'select',
			'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
			'help'    => esc_html__( 'Whether to show labels on the scale', 'ct_theme' ),
		);
		$atts['scale_begin_at_zero']     = array(
			'label'   => esc_html__( 'Scale begin at zero', 'ct_theme' ),
			'default' => 'true',
			'type'    => 'select',
			'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
			'help'    => esc_html__( 'Whether the scale should begin at zero', 'ct_theme' ),
		);
		$atts['angle_line_color']        = array(
			'label'   => esc_html__( 'Angle line color', 'ct_theme' ),
			'default' => 'true',
			'type'    => 'colorpicker',
			'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
			'help'    => esc_html__( 'Colour of the angle line', 'ct_theme' ),
		);
		$atts['scale_begin_at_zero']     = array(
			'label'   => esc_html__( 'Scale begin at zero', 'ct_theme' ),
			'default' => 'true',
			'type'    => 'select',
			'choices' => array( 'true' => esc_html__( 'yes', 'ct_theme' ), 'false' => esc_html__( 'no', 'ct_theme' ) ),
			'help'    => esc_html__( 'Whether the scale should begin at zero', 'ct_theme' ),
		);
		$atts['point_label_font_family'] = array(
			'label'   => esc_html__( 'Points label font family', 'ct_theme' ),
			'default' => 'Arial',
			'type'    => 'input',
			'help'    => esc_html__( 'Point label font declaration', 'ct_theme' ),
		);
		$atts['point_label_font_size']   = array(
			'label'   => esc_html__( 'Point label font size', 'ct_theme' ),
			'default' => '10',
			'type'    => 'input',
			'help'    => esc_html__( 'Point label font size in pixels', 'ct_theme' ),
		);
		$atts['point_label_font_color']  = array(
			'label'   => esc_html__( 'Point label font color', 'ct_theme' ),
			'default' => '#666',
			'type'    => 'colorpicker',
			'help'    => esc_html__( 'Point label font colour', 'ct_theme' ),
		);

		return $atts;
	}

	public function getChildShortcodeInfo() {
		return array( 'name' => 'chart_radar_item', 'min' => 1, 'max' => 1000, 'default_qty' => 3 );
	}

	public function getJSFuctionName() {
		return 'Radar';
	}

}

new ctChartRadarShortcode();