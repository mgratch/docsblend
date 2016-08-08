<?php
/**
 * ${DESCRIPTION}$
 * @author createit
 */
require_once CT_CHARTS_JS_PATH . '/shortcodes/ctChartModelShortcode.class.php';


abstract class ctChartMultipledataModelShortcode extends ctChartModelShortcode {

	protected function getInlineJS( $attributes, $id, $json ) {
		extract( $attributes );
		$labels = $attributes['labels'];
		$labels = explode( ',', $labels );


		return '
var ctx_' . $id . ' = jQuery("#' . $id . '").get(0).getContext("2d");
var data_' . $id . ' = {
    labels: ' . json_encode( $labels ) . ',
    datasets: ' . $json . '
};
var options_' . $id . ' = ' . $this->getChartOptionsFromAttributes( $attributes ) . ';
var ' . $id . ' = new Chart(ctx_' . $id . ').' . $this->getJSFuctionName() . '(data_' . $id . ', options_' . $id . ');
  ';
	}

	public function getAttributes() {
		$attributes           = parent::getAttributes();

		return $attributes;
	}


}