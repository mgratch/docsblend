<?php
/**
 * Created by PhpStorm.
 * User: Patryk
 * Date: 2015-01-26
 * Time: 16:00
 */


/**
 * @param $query
 */
function ct_pre_get_posts( $query ) {

    if ( is_post_type_archive( 'portfolio' ) && ! is_admin() && $query->is_main_query() ) {
        if ( ct_get_context_option( 'portfolio_index_show_pagination' ) ) {
            $query->set( 'posts_per_page', ct_get_context_option( 'portfolio_index_limit', 10 ) );
            $query->set( 'orderby', 'menu_order' );
        } else {

            $query->set( 'posts_per_page', - 1 );
            $query->set( 'orderby', 'menu_order' );
        }
    }
}

add_action( 'pre_get_posts', 'ct_pre_get_posts' );