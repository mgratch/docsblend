<?php
require_once CT_THEME_LIB_WIDGETS.'/ctShortcodeWidget.class.php';

/**
 * Recent posts widget
 * @author hc
 */

class ctListWidget extends ctShortcodeWidget {
	/**
	 * Creates wordpress
	 */
	function __construct() {
		$widget_ops = array('classname' => 'ct-widget-list', 'description' => __('List', 'ct_theme'));
		parent::__construct('list', 'CT - ' . __('list', 'ct_theme'), $widget_ops);
	}

	/**
	 * Returns shortcode class
	 * @return mixed
	 */
	protected function getShortcodeName() {
		return 'listWidget';
	}
}

register_widget('ctListWidget');
