<?php
/*
 * Plugin Name: First Order Discount Woocommerce
 * Author: WooExtend
 * Author URI: https://www.wooextend.com
 * Version: 1.1
 * Requires at least: 4.0
 * Tested up to: 4.4
 * Description: "First Order Discount Woocommerce" allows administrator to offer customers tempting promotions on their first purchase. Admin can offer either flat discount in terms of money or offer some products for free.
 */
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}
/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    
    require_once ('fodw-admin.php');
    require_once ('fodw-coupon.php');

    /*
     * This function will create coupon for promotion on activation of plugin.
     * Date: 15-08-2017
     * Author: Vidish Purohit
     */
    function fodw_activate() {

	    $coupon_code = 'First Order Discount'; // Code
		$amount = '0'; // Amount
		$discount_type = 'fixed_cart'; // Type: fixed_cart, percent, fixed_product, percent_product
							
		$coupon = array(
			'post_title' => $coupon_code,
			'post_content' => '',
			'post_status' => 'publish',
			'post_author' => 1,
			'post_type'		=> 'shop_coupon'
		);
							
		$new_coupon_id = wp_insert_post( $coupon );
							
		// Add meta
		update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
		update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
		update_post_meta( $new_coupon_id, 'individual_use', 'no' );
		update_post_meta( $new_coupon_id, 'product_ids', '' );
		update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
		update_post_meta( $new_coupon_id, 'usage_limit', '' );
		update_post_meta( $new_coupon_id, 'expiry_date', '' );
		update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
		update_post_meta( $new_coupon_id, 'free_shipping', 'no' );

		update_option('_fodw_coupon_id', $new_coupon_id);
	}
	register_activation_hook( __FILE__, 'fodw_activate' );

	/*
	 * This plugin will remove coupon which was generated for promotion.
	 * Date: 15-08-2017
	 * Author: Vidish Purohit
	 */
	function fodw_deactivate() {

		$couponId = get_option('_fodw_coupon_id');
		wp_delete_post( $couponId, true ); 
		delete_option($couponId);
	}
	register_deactivation_hook( __FILE__, 'fodw_deactivate' );
}

?>