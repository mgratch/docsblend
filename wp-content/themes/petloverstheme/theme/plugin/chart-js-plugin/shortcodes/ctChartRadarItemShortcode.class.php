<?php

/**
 * ${DESCRIPTION}$
 * @author createit
 */



require_once CT_CHARTS_JS_PATH . '/shortcodes/ctChartMultipledataModelItemShortcode.class.php';


class ctChartRadarItemShortcode extends ctChartMultipledataModelItemShortcode {
	/**
	 * Returns shortcode label
	 * @return mixed
	 */
	public function getName() {
		return 'Chart Radar Item';
	}

	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-line-chart' ) );
	}

	public function getParentShortcodeName() {
		return 'chart_radar';
	}
}

new ctChartRadarItemShortcode();