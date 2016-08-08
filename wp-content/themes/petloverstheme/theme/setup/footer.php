<?php
if ( ! function_exists( 'ct_footer_class' ) ) {
	/**
	 * @param $class
	 *
	 * @return string
	 */
	function ct_footer_class( $class ) {
		$class = 'ct-u-backgroundDarkGray ';

		return $class;
	}
}
add_filter( 'footer_class', 'ct_footer_class' );

