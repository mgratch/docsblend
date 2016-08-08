<?php
/**
 * ${DESCRIPTION}$
 * @author createit
 */

require_once CT_CHARTS_JS_PATH . '/shortcodes/ctChartModelItemShortcode.class.php';


class ctChartPolarAreaItemShortcode extends ctChartModelItemShortcode
{

    /**
     * Returns shortcode label
     * @return mixed
     */
    public function getName()
    {
        return 'Chart Polar Area Item';
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-area-chart' ) );
    }

    public function getParentShortcodeName()
    {
   		return 'chart_polararea';
   	}
}

new ctChartPolarAreaItemShortcode();