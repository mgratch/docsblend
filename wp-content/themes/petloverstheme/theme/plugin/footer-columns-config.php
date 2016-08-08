<?php
/**
 * Footer settings
 */

if ( ! function_exists( 'ct_get_footer_settings' ) ) {
	/**
	 * Setup dynamic footer. This function is automatically called by plugin
	 * @see plugin/footer-columns
	 *
	 * @param $default
	 *
	 * @return array
	 */
	function ct_get_footer_settings( $default ) {
		return array_merge(
			$default,
			array(
				'before_widget' => '<div class="widget"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h5 class="text-uppercase">',
				'after_title'   => '</h5>',
				'numbers'       => array( 4, 3, 2, 1 )
			) );
	}
}
