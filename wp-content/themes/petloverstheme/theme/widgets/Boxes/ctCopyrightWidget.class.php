<?php
require_once CT_THEME_LIB_WIDGETS.'/ctShortcodeWidget.class.php';

/**
 * Flickr widget
 * @author hc
 */

class ctCopyrightWidget extends ctShortcodeWidget {
	/**
	 * Creates wordpress
	 */
	function __construct() {
		$widget_ops = array('classname' => 'copyright', 'description' => __('Displays copyright note', 'ct_theme'));
		parent::__construct('copyright', 'CT - ' . __('copyright', 'ct_theme'), $widget_ops);
	}


	/**
	 * Returns shortcode class
	 * @return mixed
	 */
	protected function getShortcodeName() {
		return 'copyright';
	}
}

register_widget('ctCopyrightWidget');