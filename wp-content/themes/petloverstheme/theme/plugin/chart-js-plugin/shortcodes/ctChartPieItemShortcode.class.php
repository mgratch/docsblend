<?php
/**
 * ${DESCRIPTION}$
 * @author createit
 */

class ctChartPieItemShortcode extends ctChartModelItemShortcode
{

    /**
     * Returns shortcode label
     * @return mixed
     */
    public function getName()
    {
        return 'Chart Pie Item';
    }

    /**
     * Returns additional info about VC
     * @return ctVisualComposerInfo
     */
    public function getVisualComposerInfo()
    {
        return new ctVisualComposerInfo( $this, array( 'icon' => 'fa-pie-chart' ) );
    }

    public function getParentShortcodeName()
    {
   		return 'chart_pie';
   	}
}

new ctChartPieItemShortcode();