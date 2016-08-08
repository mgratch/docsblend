<?php
/**
 * Helper functions for theme
 */



/**
 * Enqueue scripts
 */
if ( ! function_exists( 'ct_theme_scripts' ) ) {
	/**
	 * Load additional scripts per item
	 */
	function ct_theme_scripts() {
		wp_register_script('ct_device', CT_THEME_ASSETS . '/js/device.min.js', array('jquery'), null, true);
		wp_enqueue_script('ct_device');

		wp_register_script('ct_snap', CT_THEME_ASSETS . '/js/snap.min.js', array('jquery'), null, true);
		wp_enqueue_script('ct_snap');

        wp_register_script('mp', CT_THEME_ASSETS . '/js/magnific-popup/jquery.magnific-popup.min.js', array('jquery'), null, true);
        wp_enqueue_script('mp');

        wp_register_script('ct-init-mp', CT_THEME_ASSETS . '/js/magnific-popup/init.js', array('jquery'), null, true);
        wp_enqueue_script('ct-init-mp');


		if(apply_filters('ct_theme_loader.load_styles',true)) {
			if (file_exists(CT_THEME_DIR . '/assets/css/style2.css')) {
				wp_enqueue_style('ct_theme2', CT_THEME_DIR_URI . '/assets/css/style2.css', array('ct_theme'), null);
			} elseif (file_exists(CT_THEME_DIR . '/assets/less/style2.less')) {
				wp_enqueue_style('ct_theme2', CT_THEME_DIR_URI . '/ct/css.php?file=css/style2.css', array('ct_theme'), null);
			}
			if (file_exists(CT_THEME_DIR . '/assets/css/style3.css')) {
				wp_enqueue_style('ct_theme3', CT_THEME_DIR_URI . '/assets/css/style3.css', array('ct_theme'), null);
			} elseif (file_exists(CT_THEME_DIR . '/assets/less/style3.less')) {
				wp_enqueue_style('ct_theme3', CT_THEME_DIR_URI . '/ct/css.php?file=css/style3.css', array('ct_theme'), null);
			}
			if (file_exists(CT_THEME_DIR . '/assets/css/style4.css')) {
				wp_enqueue_style('ct_theme4', CT_THEME_DIR_URI . '/assets/css/style4.css', array('ct_theme'), null);
			} elseif (file_exists(CT_THEME_DIR . '/assets/less/style4.less')) {
				wp_enqueue_style('ct_theme4', CT_THEME_DIR_URI . '/ct/css.php?file=css/style4.css', array('ct_theme'), null);
			}
		}
	}

}
add_action( 'wp_enqueue_scripts', 'ct_theme_scripts' ,0);



 if(ct_get_context_option('pages_navbar_type')=='navbar-transparent' && ct_get_context_option('pages_fixed_menu')=='ct-js-navbarMakeSmaller'){
	$x= 'ct-navbar-isTransparent-toDefault';
}

/**
 * @param $classes
 *
 * @return array
 */
function ct_custom_body_class( $classes ) {
	$classes[] = 'withAnimation';
	$classes[] = ct_get_context_option( 'pages_fixed_menu');


	if ( ct_get_context_option( 'navbar_type' ) == 'ct-navbar--transparent' ) {
		$classes[] = ct_get_context_option( 'navbar_transitions' );
	}

	if ( ct_get_context_option( 'general_layout_type' ) == 'boxed' ) {
		$classes[] = 'boxed';
		$ptn       = ct_get_context_option( 'general_boxed_pattern', '' );
		if ( (int) $ptn > 0 && (int) $ptn <= 5 ) {
			$classes[] = 'ptn' . $ptn;
		}
	}

	if((ct_get_context_option('pages_navbar_type')=='navbar-transparent' && ct_get_context_option('pages_fixed_menu')=='ct-js-navbarMakeSmaller') || (ct_get_context_option('pages_navbar_type')=='navbar-transparent' && ct_get_context_option('pages_fixed_menu')=='ct-navbar--fixedTop')){
		$classes[] = 'ct-navbar-isTransparent-toDefault';
	}


	return $classes;
}
add_filter( 'body_class', 'ct_custom_body_class', 10, 2 );






/*function add_classes_wpse_130358($classes, $item, $args) {

	$classes = array('dropdown');
	return $classes;
}
add_filter('nav_menu_css_class','add_classes_wpse_130358',1,3);*/


if ( ! function_exists( 'ct_import_demo_blocks' ) ) {

    /**
     * Blocks names
     *
     * @param $dirs
     *
     * @return array
     */

    function ct_import_demo_blocks( $blocks, $dirs ) {
        $logoBase = CT_THEME_ASSETS . '/shortcode/1click';

        $groups = array();
        foreach ( $dirs as $d ) {
            $name = basename( $d );
            $ex   = explode( '-', $name );
            if ( ! isset( $ex[1] ) ) {
                continue;
            }

            if ( ! isset( $groups[ $ex[1] ] ) ) {
                $groups[ $ex[1] ] = array(
                    'name'    => ucfirst( $ex[1] ),
                    'logo'    => $logoBase . '/' . $ex[1] . '.png',
                    'buttons' => array()
                );
            }

            $groups[ $ex[1] ]['buttons'][] = array( 'dir' => $name, 'label' => $ex[0] );
        }

        return array_merge( $blocks, $groups );
    }

}
add_filter( 'ct_import.options.demos.blocks', 'ct_import_demo_blocks', 10, 2 );



function faCssPath($cssPath){
	$cssPath = '/fonts/fontawesome/css/font-awesome.min.css';
	return $cssPath;
}

add_filter('ct.cs_font_awesome_path','faCssPath');


function enqueuePortfolioScripts() {

	wp_register_script('isotope', CT_THEME_ASSETS . '/js/portfolio/jquery.isotope.min.js', array('jquery'), null, true);
	wp_enqueue_script('isotope');

	wp_register_script('imagesloaded', CT_THEME_ASSETS . '/js/portfolio/imagesloaded.js', array('jquery'), null, true);
	wp_enqueue_script('imagesloaded');

	wp_register_script('infinitescroll', CT_THEME_ASSETS . '/js/portfolio/infinitescroll.min.js', array('jquery'), null, true);
	wp_enqueue_script('infinitescroll');

	wp_register_script('init-portfolio', CT_THEME_ASSETS . '/js/portfolio/init.js', array('jquery'), null, true);
	wp_enqueue_script('init-portfolio');

	wp_register_script('init-portfolio-ajax', CT_THEME_ASSETS . '/js/ct-portfolioAjax/init.js', array('jquery'), null, true);
	wp_enqueue_script('init-portfolio-ajax');




}
