<?php
require_once CT_THEME_LIB_WIDGETS.'/ctShortcodeWidget.class.php';

/**
 * Recent posts widget
 * @author hc
 */

class ctLogoSLider extends ctShortcodeWidget {
	/**
	 * Creates wordpress
	 */
	function __construct() {
		$widget_ops = array('classname' => 'ct-widget-logo', 'description' => __('Logo Slider', 'ct_theme'));
		parent::__construct('thumbnails_slider', 'CT - ' . __('slider', 'ct_theme'), $widget_ops);
	}

	/**
	 * Returns shortcode class
	 * @return mixed
	 */
	protected function getShortcodeName() {
		return 'thumbnails_slider';
	}
}

register_widget('ctLogoSLider');
