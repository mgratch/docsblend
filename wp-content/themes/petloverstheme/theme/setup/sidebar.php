<?php

// Register widgetized areas
register_sidebar( array(
	'name'          => __( 'Primary Sidebar', 'ct_theme' ),
	'id'            => 'sidebar-primary',
	'description'   => __( 'Widgets placed in this area will appear on your Blog sidebar', 'ct_theme' ),
	'before_widget' => ' <div  id="%1$s" class="col-sm-6 col-md-12"><section class="widget %2$s"><div class="widget-inner">',
	'after_widget'  => '</div></section></div>',
	'before_title'  => '<h4 class="text-lowercase">',
	'after_title'   => '</h4>',
) );


register_sidebar( array(
	'name'          => __( 'Page Sidebar', 'ct_theme' ),
	'id'            => 'sidebar-page',
	'description'   => __( 'Widgets placed in this area will appear on your Blog sidebar', 'ct_theme' ),
	'before_widget' => ' <div  id="%1$s" class="col-sm-6 col-md-12"><section class="widget %2$s"><div class="widget-inner">',
	'after_widget'  => '</div></section></div>',
	'before_title'  => '<h4 class="text-lowercase">',
	'after_title'   => '</h4>',
) );


register_sidebar( array(
	'name'          => __( 'Products Listing', 'ct_theme' ),
	'id'            => 'products-listing',
	'description'   => __( 'Widgets placed in this area will appear on Products Listing.', 'ct_theme' ),
	'before_widget' => ' <div  id="%1$s" class="col-sm-6 col-md-12"><section class="widget %2$s"><div class="widget-inner">',
	'after_widget'  => '</div></section></div>',
	'before_title'  => '<h4 class="text-lowercase">',
	'after_title'   => '</h4>',
) );


register_sidebar( array(
	'name'          => __( 'Pre Footer', 'ct_theme' ),
	'id'            => 'post-footer1',
	'description'   => __( 'Widgets placed in this area will appear at the bottom of the main footer on the left hand side.', 'ct_theme' ),
	'before_widget' => '<div  id="%1$s" class=" %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h5 class="widget-title">',
	'after_title'   => '</h5>',
) );

register_sidebar( array(
	'name'          => __( 'Post Footer', 'ct_theme' ),
	'id'            => 'post-footer2',
	'description'   => __( 'Widgets placed in this area will appear at the bottom of the main footer on the right hand side.', 'ct_theme' ),
	'before_widget' => '<div  id="%1$s" class="%2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h5 class="widget-title">',
	'after_title'   => '</h5>',
) );