<?php
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

add_action( 'woocommerce_before_cart', 'fodw_apply_discount' );
add_action( 'woocommerce_checkout_init', 'fodw_apply_discount' );

function fodw_apply_discount() {
    
    global $wpdb;

    if(!is_user_logged_in() || fodw_has_bought()) {
    	return;
    }

    $strData = get_option('_fodw_configuration');
    $arrData = unserialize($strData);
    
    // if disabled, then don't do anything
    if($arrData['type'] == 'disable') {
    	return;
    }

    $productInCart = false;
    foreach( WC()->cart->get_cart() as $cart_item_key => $values ) {
		$_product = $values['data'];
	
		if( $arrData['freeProduct'] == $_product->get_id() ) {
			$productInCart = true;
		}
	}

    // Get coupon code
    $strCoupon = "SELECT post_title FROM {$wpdb->prefix}posts WHERE ID = '" . get_option('_fodw_coupon_id') . "'";
    $arrCoupon = $wpdb->get_results($strCoupon);
    $coupon_code = $arrCoupon[0]->post_title; 
 
 	// if coupon already applied
 	if(isset(WC()->cart->applied_coupons) && !empty(WC()->cart->applied_coupons) && isset($arrData['isIndUseOnly']) && $arrData['isIndUseOnly'] == 'yes') {
 		return;
 	}

	// Free shipping, fixed discount & % discount will be handled here 
    WC()->cart->add_discount( $coupon_code );
 
}

/*
 * This function will check if customer has purchased any product.
 * Date: 17-08-2017
 * Author: Vidish Purohit
 */
function fodw_has_bought() {

    $count = 0;
    $bought = false;

    // Get all customer orders
    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => 'shop_order', // WC orders post type
        'post_status' => 'wc-completed' // Only orders with status "completed"
    ) );

    // Going through each current customer orders
    foreach ( $customer_orders as $customer_order ) {
        $count++;
    }

    // return "true" when customer has already one order
    if ( $count > 0 ) {
        $bought = true;
    }
    return $bought;
}