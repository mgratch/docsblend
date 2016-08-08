<?php
require_once CT_THEME_LIB_WIDGETS.'/ctShortcodeWidget.class.php';

/**
 * Recent posts widget
 * @author hc
 */

class ctRecentPostsWidget extends ctShortcodeWidget {
	/**
	 * Creates wordpress
	 */
	function __construct() {
		$widget_ops = array('classname' => 'ct-widget-latestPosts', 'description' => __('Displays recent posts.', 'ct_theme'));
		parent::__construct('recent_posts', 'CT - ' . __('Recent posts', 'ct_theme'), $widget_ops);
	}

	/**
	 * Returns shortcode class
	 * @return mixed
	 */
	protected function getShortcodeName() {
		return 'recent_postswidget';
	}
}

register_widget('ctRecentPostsWidget');
