<?php
register_nav_menus( array(
	'primary_navigation' => __( 'Primary Navigation', 'ct_theme' ),
) );




if ( ! function_exists( 'ct_is_location_contains_menu' ) ) {
	/**
	 * @param null $location
	 *
	 * @todo from alex: move to setup/navigation
	 * @return bool
	 */
	function ct_is_location_contains_menu( $location = null ) {
		$menus = ( get_nav_menu_locations() );

		return isset( $menus[ $location ] ) && is_object( wp_get_nav_menu_object( $menus[ $location ] ) );
	}
}