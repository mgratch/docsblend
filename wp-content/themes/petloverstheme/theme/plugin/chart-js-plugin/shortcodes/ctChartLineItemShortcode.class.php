<?php

/**
 * ${DESCRIPTION}$
 * @author createit
 */

require_once CT_CHARTS_JS_PATH . '/shortcodes/ctChartMultipledataModelItemShortcode.class.php';


class ctChartLineItemShortcode extends ctChartMultipledataModelItemShortcode {
	/**
	 * Returns shortcode label
	 * @return mixed
	 */
	public function getName() {
		return 'Chart Line Item';
	}

	/**
	 * Returns additional info about VC
	 * @return ctVisualComposerInfo
	 */
	public function getVisualComposerInfo() {
		return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-line-chart' ) );
	}

	public function getParentShortcodeName() {
		return 'chart_line';
	}
}

new ctChartLineItemShortcode();