<?php
add_filter('ct_customizer.style_names','extend_styles');
function extend_styles(){
    $stylesNames = array('style','style2','style3','style4');
    return $stylesNames;
}


require_once get_template_directory() . '/framework/createit/ctThemeLoader.php';

$c = new ctThemeLoader();
//order is important

$c->setDocumentationUrl( 'http://createit.support/documentation/petlovers' );

//initialize our framework
$c->init( 'petlovers' );

require_once 'theme/theme_functions.php';




add_filter('nav_menu_css_class', 'auto_custom_type_class', 10, 2 );
function auto_custom_type_class($classes, $item) {

    if ($item->type_label == "CUSTOM_TYPE_NAME"){
        $classes[] = "nav navbar-nav";
    }

    return $classes;
}


function ct_demo_dynamic_params( $value, $name ) {
    $params = array(
        'portfolio_space'                   => array('boxed', 'full'),
        'portfolio_masonry_columns'         => array('3', '4', '5'),
        'posts_show_index_as'               => array('content', 'content-secondary', 'content-masonry'),
        'posts_index_sidebar'               => array(1, 0),
        'posts_index_sidebar_side'          => array('right', 'left')
    );



    if ( ! isset( $params[ $name ] ) ) {
        return $value;
    }

    if ( ! isset( $_GET[ $name ] ) ) {
        return $value;
    }

    $data = $params[ $name ];
    $val  = false;
    if ( isset( $_GET[ $name ] ) ) {
        $val = $_GET[ $name ];
    }/* elseif (isset($_COOKIE[$name])) {
        $val = $_COOKIE[$name];
    }*/

    //to avoid array index problems
    if ( ! is_integer( $val ) && isset( $data[ $val ] ) ) {
        return $data[ $val ];
    }

    if ( $val != '' && array_search( $val, $data ) !== false ) {
        return $val;
    }

    return $value;
}

add_action( 'ct.options.get', 'ct_demo_dynamic_params', 10, 2 );
// end demo

function basicThemeSetup(){
    add_theme_support('title-tag');
}
add_action('after_setup_theme','basicThemeSetup');




