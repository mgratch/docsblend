<?php
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

/*
 * This function will register menu page for admin of first order discount.
 * Date: 15-08-2017
 * Author: Vidish Purohit
 */
function fodw_register_submenu_page() {
    add_submenu_page( 'woocommerce', __('First Order Discount'), __('First Order Discount'), 'manage_options', 'first-order-discount-woocommerce', 'fodw_discount' ); 
}
add_action('admin_menu', 'fodw_register_submenu_page');

/*
 * This function will manage display of admin interface.
 * Date: 15-08-2017
 * Author: Vidish Purohit
 */
function fodw_discount() {

	global $wpdb;

	notify_coupon_status();

	if(isset($_POST) && !empty($_POST)) {
		fodw_save_discount();
	}
	$arrData = unserialize(get_option('_fodw_configuration'));

	echo '<h2>First Order Discount Woocommerce Configuration</h2>';
	?><form method="POST">
		<table>
			<tr>
				<th style="width:250px;text-align:left;"><?php _e('Choose type of discount');?></th>
				<td>
					<input type="radio" name="rdoDiscType" value="free_shipping" id="rdoFreeShipping" onclick="javascript:checkFreeProduct();" <?php echo isset($arrData['type']) && $arrData['type'] == 'free_shipping'?" checked='checked'":'';?>><label for="rdoFreeShipping">Free Shipping</label>
				</td>
				<td rowspan="11" style="vertical-align:top;padding-left:100px;">
					<a href="https://www.wooextend.com/product/order-promotion-woocommerce-pro/" target="_blank"><img src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/images/banner.jpg';?>" alt="Order Promotion Woocommerce Pro" style="border-radius:5px;border:1px solid black;"></a>
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<input disabled type="radio" name="rdoDiscType" value="free_product" id="rdoFreeProduct" onclick="javascript:checkFreeProduct();" <?php echo isset($arrData['type']) && $arrData['type'] == 'free_product'?" checked='checked'":'';?>><label for="rdoFreeProduct">Free Product</label>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="radio" name="rdoDiscType" value="fix_discount" id="rdoFixedDisc" onclick="javascript:checkFreeProduct();" <?php echo isset($arrData['type']) && $arrData['type'] == 'fix_discount'?" checked='checked'":'';?>><label for="rdoFixedDisc">Fixed Discount</label>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="radio" name="rdoDiscType" value="percentage_discount" id="rdoPerDisc" onclick="javascript:checkFreeProduct();" <?php echo isset($arrData['type']) && $arrData['type'] == 'percentage_discount'?" checked='checked'":'';?>><label for="rdoPerDisc">Percentage Discount</label>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="radio" name="rdoDiscType" value="disable" id="rdoDisable" onclick="javascript:checkFreeProduct();"><label for="rdoDisable" <?php echo isset($arrData['type']) && $arrData['type'] == 'disable'?" checked='checked'":'';?>>Disable</label>
				</td>
			</tr><?php

			// Get products
			$strProduct = "SELECT post_title, ID FROM {$wpdb->prefix}posts WHERE post_type = 'product' AND post_status = 'publish'";
			$arrProduct = $wpdb->get_results($strProduct);
    		
			?><tr id="trFreeProduct" style="display:none;">
				<th style="width:250px;text-align:left;">
					<label for="txtAmount"><?php _e('Select free product');?></label>
					<span class="help tooltip">?<span class="tooltiptext">We recommend using simple products for giving free.</span></span>
				</th>
				<td>
					<select id="selFreeProduct" name="selFreeProduct" style="width:200px;">
						<option value="">Please choose product</option><?php
						foreach ($arrProduct as $key => $value) {
							echo '<option value="' .$value->ID  . '"' . (isset($arrData['freeProduct']) && $arrData['freeProduct'] == $value->ID?' selected="selected"':'') . '>' . $value->post_title . '</option>';
						}
					?></select>
				</td>
			</tr>
			<tr id="trDiscountValue">
				<th style="width:250px;text-align:left;"><label for="txtAmount"><?php _e('Discount value');?></label></th>
				<td>
					<input type="text" name="txtAmount" value="<?php echo isset($arrData['discValue'])?$arrData['discValue']:'';?>" id="txtAmount" placeholder="Discount value">
				</td>
			</tr>
			<tr>
				<th style="width:250px;text-align:left;">
					<label for="chkIndividualUseOnly"><?php _e('Individual use only');?></label>
					<span class="help tooltip">?<span class="tooltiptext">Check this box if the coupon cannot be used in conjunction with other coupons.</span></span>
				</th>
				<td>
					<input type="checkbox" name="chkIndividualUseOnly" <?php echo isset($arrData['isIndUseOnly']) && $arrData['isIndUseOnly'] == 'yes'?'checked="checked"':'';?> value="yes" id="chkIndividualUseOnly" onclick="javascript:checkVisible();">
				</td>
			</tr>
			<tr>
				<th style="width:250px;text-align:left;"><label for="chkEnableMinCartAmt"><?php _e('Enable minimum cart amount');?></label>
					<span class="help tooltip">?<span class="tooltiptext">Purchase PRO version to use this feature.</span></span>
				</th>
				<td>
					<input type="checkbox" name="chkEnableMinCartAmt" checked="checked" value="yes" id="chkEnableMinCartAmt" onclick="javascript:checkVisible();">
				</td>
			</tr>
			<tr id="trMinCart" style="display:none;">
				<th style="width:250px;text-align:left;">
					<label for="txtMinCartAmount"><?php _e('Minimum cart value');?></label>
					<span class="help tooltip">?<span class="tooltiptext">This is minimum cart value to apply discount. Purchase PRO version to use this feature.</span></span>
				</th>
				<td>
					<input type="text" name="txtMinCartAmount" value="0" id="txtMinCartAmount" placeholder="Minimum cart amount" readonly="readonly">
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Save" class="button button-primary"></td>
			</tr>
		</table>
	</form><?php

}

// notify admin to enable coupon
function notify_coupon_status() {
	
	if(get_option('woocommerce_enable_coupons') == 'yes') {
		return;
	}

	echo '<div class="notice notice-error is-dismissible"> 
		<p><strong>This plugin needs coupons enabled in order to work.</strong></p>
		<button type="button" class="notice-dismiss">
			<span class="screen-reader-text">Dismiss this notice.</span>
		</button>
	</div>';
	
}

add_action( 'admin_enqueue_scripts', 'fodw_load_admin_script' );
function fodw_load_admin_script() {
    wp_register_script( 'fodw_select2', plugin_dir_url( __FILE__ ) . 'assets/js/select2.full.js', array(), false, '1.0.0' );
    wp_enqueue_script( 'fodw_select2' );

    wp_register_script( 'fodw_discount_admin_js', plugin_dir_url( __FILE__ ) . 'assets/js/fodw_control.js', array(), false, '1.0.0' );
    wp_enqueue_script( 'fodw_discount_admin_js' );

    wp_enqueue_style( 'fodw_css', plugin_dir_url( __FILE__ ) . 'assets/css/fodw_admin.css');
    wp_enqueue_style( 'fodw_select2', plugin_dir_url( __FILE__ ) . 'assets/css/select2.min.css');

    // Localize the script
    $translation_array = array(
        'admin_url' => admin_url('admin-ajax.php')
    );
    wp_localize_script( 'fodw_discount_admin_js', 'fodw_obj', $translation_array );
}


function fodw_save_discount() {

	$arrData = array();
	$arrData['type'] = sanitize_title($_POST['rdoDiscType']);
	$arrData['discValue'] = sanitize_title($_POST['txtAmount']);
	$arrData['freeProduct'] = sanitize_title($_POST['selFreeProduct']);
	$arrData['enableMinCart'] = sanitize_title($_POST['chkEnableMinCartAmt']);
	$arrData['minCartValue'] = sanitize_title($_POST['txtMinCartAmount']);
	$arrData['isIndUseOnly'] = sanitize_title($_POST['chkIndividualUseOnly']);
	

	// Update coupon
	$intCouponId = get_option('_fodw_coupon_id');

	// update shipping
	if($arrData['type'] == 'free_shipping') {
		update_post_meta( $intCouponId, 'free_shipping', 'yes' );
		$arrData['discValue'] = 0;
	} else {
		update_post_meta( $intCouponId, 'free_shipping', 'no' );
	}

	// update discount type
	if($arrData['type'] == 'percentage_discount') {
		update_post_meta( $intCouponId, 'discount_type', 'percent' );
	} else if($arrData['type'] == 'fix_discount') {
		update_post_meta( $intCouponId, 'discount_type', 'fixed_cart' );
	} 
	update_post_meta( $intCouponId, 'coupon_amount', $arrData['discValue'] );

	update_post_meta( $intCouponId, 'minimum_amount', '' );

	if(isset($arrData['isIndUseOnly']) && $arrData['isIndUseOnly'] == 'yes') {
		update_post_meta( $intCouponId, 'individual_use', 'yes' );
	} else {
		update_post_meta( $intCouponId, 'individual_use', 'no' );
	}
	update_option('_fodw_configuration', serialize($arrData));
}