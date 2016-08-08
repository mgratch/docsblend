<?php
/**
 * ${DESCRIPTION}$
 * @author createit
 */

require_once CT_CHARTS_JS_PATH . '/shortcodes/ctChartModelItemShortcode.class.php';


class ctChartDoughnutItemShortcode extends ctChartModelItemShortcode
{

    /**
     * Returns shortcode label
     * @return mixed
     */
    public function getName()
    {
        return 'Chart Doughnut Item';
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo() {
   		return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-pie-chart' ) );
   	}

    public function getParentShortcodeName()
    {
   		return 'chart_doughnut';
   	}
}

new ctChartDoughnutItemShortcode();