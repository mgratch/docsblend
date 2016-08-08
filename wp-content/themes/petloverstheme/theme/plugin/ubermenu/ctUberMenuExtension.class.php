<?php

/**
 * Adds Ubermenu compatibility
 * @author alex
 */
class ctUberMenuExtension {

	public function __construct() {
		remove_filter( 'nav_menu_css_class', 'roots_nav_menu_css_class', 10 );
		remove_filter( 'nav_menu_item_id', '__return_null' );

		add_filter( 'ct_menu.render_custom', array( $this, 'renderUberMenu' ), 10, 2 );
	}

	/**
	 * Renders menu
	 *
	 * @param $menu
	 * @param $args
	 *
	 * @return mixed
	 */

	public function renderUberMenu( $menu, $args ) {
		if ( ! isset( $args['theme_location'] ) ) {
			return $menu;
		}

		//we have ubermenu here
		if ( ubermenu_get_menu_instance_by_theme_location( $args['theme_location'] ) ) {
			remove_filter( 'wp_nav_menu_args', 'roots_nav_menu_args' );
			$args['echo'] = false;
			$menu         = wp_nav_menu( $args );
			add_filter( 'wp_nav_menu_args', 'roots_nav_menu_args' );
		}
		return $menu;
	}
}

if (function_exists('ubermenu_get_menu_instance_by_theme_location')){
    new ctUberMenuExtension();
}
