<?php
/**
 * Plugin Name:       Theme Customisations
 * Description:       A handy little plugin to contain your theme customisation snippets.
 * Plugin URI:        http://github.com/woothemes/theme-customisations
 * Version:           1.0.0
 * Author:            WooThemes
 * Author URI:        https://www.woocommerce.com/
 * Requires at least: 3.0.0
 * Tested up to:      4.4.2
 *
 * @package Theme_Customisations
 * @todo setup shipping quote option on checkout page
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require __DIR__ . '/vendor/autoload.php';


/**
 * Main Theme_Customisations Class
 *
 * @class Theme_Customisations
 * @version    1.0.0
 * @since 1.0.0
 * @package    Theme_Customisations
 */
final class Theme_Customisations {

	private static $enquiry_details = array();

	/**
	 * Set up the plugin
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'theme_customisations_setup' ), - 1 );
		require_once( 'custom/functions.php' );
	}

	/**
	 * Setup all the things
	 */
	public function theme_customisations_setup() {

		add_action( 'register_post_status', array( $this, 'register_post_status' ) );
		add_action( 'init', array( $this, 'register_awaiting_shipment_order_status' ) );
		add_filter( 'woocommerce_order_actions', array( $this, 'add_order_meta_box_actions' ) );
		add_action( 'woocommerce_order_action_wc_awaiting_shipment', array( $this, 'order_shipped_callback' ), 10, 1 );

		add_filter( 'wc_order_statuses', array( $this, 'add_awaiting_shipment_to_order_statuses' ) );
		add_action( 'woocommerce_order_status_wc-awaiting-shipment', array(
			$this,
			'order_status_shipped_callback'
		), 10, 1 );

		add_action( 'wp_print_scripts', array( $this, 'add_custom_order_status_icon') );
		add_action( 'load-edit.php', array( $this, 'bulk_action_shipping_callback' ) );
		add_action( 'admin_footer', array( $this, 'add_shipped_in_bulk_action'),11);
		add_filter( 'woocommerce_admin_order_actions', array($this,'add_awaiting_shipping_action'), 10, 2  );

		add_action( 'wp_loaded', array( $this, 'hidden_product_purchase' ), 9 );
		add_filter( 'views_edit-product', array( $this, 'remove_views' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'theme_customisations_css' ), 999 );
		add_filter( 'template_include', array( $this, 'theme_customisations_template' ), 11 );
		add_filter( 'wc_get_template', array( $this, 'theme_customisations_wc_get_template' ), 11, 5 );
		add_filter( 'wc_shipping_enabled', '__return_true' );

		//turn off shipping message from quote-up
		add_filter( 'quoteup/show_shipping', '__return_false' );

		//change product archive redirect if there is only 1 product
		add_filter( 'woocommerce_return_to_shop_redirect', array( $this, 'maybe_change_empty_cart_button_url' ) );

		//remove the storefront credit link
		remove_action( 'storefront_footer', 'storefront_credit', 20 );

		//Ajax for submitting enquiry form
		add_action( 'wp_ajax_quoteup_shipping_submit', array(
			$this,
			'quoteup_submit_shipping_woo_enquiry_form'
		) );
		add_action( 'wp_ajax_nopriv_quoteup_shipping_submit', array(
			$this,
			'quoteup_submit_shipping_woo_enquiry_form'
		) );


		add_action( 'wp_enqueue_scripts', array( $this, 'theme_customisations_js' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'theme_customisations_js_shipping' ) );
		//add_action( 'woocommerce_cart_calculate_fees', array($this, 'update_shipping_fee') );
		add_action( 'woocommerce_new_order', array( $this, 'delete_shipping_fee' ) );

		add_action( 'woocommerce_checkout_update_order_review', array( $this, 'shipping_quote_button' ), 9999 );
		add_action( 'woocommerce_checkout_process', array( $this, 'checkout_update_packages' ), 9999 );

		// Variations
		if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3.0', '>=' ) ) {
			add_action( 'woocommerce_save_product_variation', array( $this, 'save_variation_settings' ), 10, 2 );
		}

		add_action( 'woocommerce_variation_options', array( &$this, 'variation_options' ), 10, 3 );
		add_action( 'woocommerce_process_product_meta', array( &$this, 'write_panel_save' ) );
		add_filter( 'woocommerce_available_variation', array( $this, 'available_variation' ), 10, 3 );

	}

	public function hidden_product_purchase() {
		add_filter( 'woocommerce_is_purchasable', function ( $purchasable, $product ) {
			$purchasable = 'hidden' == $product->post->post_status &&
			               'shipping' == strtolower( $product->post->post_title ) ? true : $purchasable;

			return $purchasable;
		}, 10, 2 );
	}

	public function register_post_status() {
		register_post_status( 'hidden', array(
			'label'                     => _x( 'Hidden', 'product' ),
			'public'                    => false,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => false,
			'show_in_admin_status_list' => false,
			'label_count'               => ""
		) );
	}


	public function checkout_update_packages() {
		global $quoteupPublicManageSesion;
		$quotationProduct = $quoteupPublicManageSesion->get( 'quotationProducts' );
		if ( ( ! empty( $quotationProduct ) && false !== $quotationProduct ) ) {
			$this->add_shipping_fee();
		}
	}

	public function remove_views( $views ) {
		unset( $views['hidden'] );

		return $views;
	}

	public function maybe_change_empty_cart_button_url( $url ) {

		$count = wp_count_posts( 'product' );


		if ( 2 > absint( $count->publish ) ) {
			$products = get_posts( array( "post_type" => "product", "status" => "publish" ) );
			$url      = get_permalink( $products[0]->ID );
		}

		return $url;
	}


	public function custom_override_force_shipping( $answer ) {
		return $answer = 1;
	}

	public function custom_override_checkout_fields( $field, $key, $args, $value ) {

		$enquiry_details = $this->get_enquiry_details();
		$address         = ! empty( $enquiry_details ) && isset( $enquiry_details['message'] ) ? $enquiry_details['message'] : '';
		$name            = ! empty( $enquiry_details ) && isset( $enquiry_details['name'] ) ? explode( " ", $enquiry_details['name'], 2 ) : array();

		if ( ! empty( $address ) ) {

			$dom = new DOMDocument;
			@$dom->loadHTML( $address, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
			$inputs = $dom->getElementsByTagName( "span" );

			foreach ( $inputs as $node ) {
				$value = $node->getAttribute( "data-shipping" );
			}

			$address_array = maybe_unserialize( $value );

			$street      = $address_array['street'];
			$street_2    = $address_array['street_2'];
			$state       = $address_array['state'];
			$city        = $address_array['city'];
			$country     = $address_array['country'];
			$postal_code = $address_array['postal_code'];
		}

		if ( ! empty( $name ) ) {
			list( $first_name, $last_name ) = $name;
		}

		switch ( $key ):
			case 'shipping_country':
				$field = str_replace( "selected='selected'", "", $field );

				$dom = new DOMDocument;
				@$dom->loadHTML( $field, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
				$inputs = $dom->getElementsByTagName( "option" );

				foreach ( $inputs as $node ) {
					$value = $node->getAttribute( "value" );
					if ( isset( $country ) && $country == $value ) {
						$node->setAttribute( "selected", "selected" );
					}
				}

				$inputs = $dom->getElementsByTagName( "select" );

				foreach ( $inputs as $node ) {
					$node->setAttribute( "disabled", "" );
				}

				$field = $dom->saveHtml();

				break;
			case 'shipping_state':
				$field = str_replace( "selected='selected'", "", $field );

				$dom = new DOMDocument;
				@$dom->loadHTML( $field, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
				$inputs = $dom->getElementsByTagName( "option" );

				if ( 0 < $inputs->length ) {
					foreach ( $inputs as $node ) {
						$value = $node->getAttribute( "value" );
						if ( isset( $state ) && $state == $value ) {
							$node->setAttribute( "selected", "selected" );
						}
					}

					$inputs = $dom->getElementsByTagName( "select" );

					foreach ( $inputs as $node ) {
						$node->setAttribute( "disabled", "" );
					}
				} else {
					$inputs = $dom->getElementsByTagName( "input" );
					foreach ( $inputs as $node ) {
						$node->setAttribute( "value", $state );
						$node->setAttribute( "disabled", "" );
					}
				}


				$field = $dom->saveHtml();

				break;
			case 'shipping_address_1':
				$dom = new DOMDocument;
				@$dom->loadHTML( $field, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
				$inputs = $dom->getElementsByTagName( "input" );

				foreach ( $inputs as $node ) {
					$node->setAttribute( "value", $street );
					$node->setAttribute( "disabled", "" );
				}

				$field = $dom->saveHtml();

				break;
			case 'shipping_address_2':
				$dom = new DOMDocument;
				@$dom->loadHTML( $field, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
				$inputs = $dom->getElementsByTagName( "input" );

				foreach ( $inputs as $node ) {
					$node->setAttribute( "value", $street_2 );
					$node->setAttribute( "disabled", "" );
				}

				$field = $dom->saveHtml();

				break;
			case 'shipping_city':
				$dom = new DOMDocument;
				@$dom->loadHTML( $field, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
				$inputs = $dom->getElementsByTagName( "input" );

				foreach ( $inputs as $node ) {
					$node->setAttribute( "value", $city );
					$node->setAttribute( "disabled", "" );
				}

				$field = $dom->saveHtml();

				break;
			case 'shipping_first_name':
				$dom = new DOMDocument;
				@$dom->loadHTML( $field, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
				$inputs = $dom->getElementsByTagName( "input" );

				foreach ( $inputs as $node ) {
					$node->setAttribute( "value", $first_name );
					$node->setAttribute( "disabled", "" );
				}

				$field = $dom->saveHtml();

				break;
			case 'shipping_last_name':
				$dom = new DOMDocument;
				@$dom->loadHTML( $field, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
				$inputs = $dom->getElementsByTagName( "input" );

				foreach ( $inputs as $node ) {
					$node->setAttribute( "value", $last_name );
					$node->setAttribute( "disabled", "" );
				}

				$field = $dom->saveHtml();

				break;
			case 'shipping_postcode':
				$dom = new DOMDocument;
				@$dom->loadHTML( $field, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
				$inputs = $dom->getElementsByTagName( "input" );

				foreach ( $inputs as $node ) {
					$node->setAttribute( "value", $postal_code );
					$node->setAttribute( "disabled", "" );
				}

				$field = $dom->saveHtml();

				break;
		endswitch;

		return $field;
	}

	/**
	 * @return array
	 */
	public function get_enquiry_details() {
		return self::$enquiry_details;
	}

	public function shipping_quote_button() {
		global $quoteupPublicManageSesion;
		$quotationProduct = $quoteupPublicManageSesion->get( 'quotationProducts' );
		if ( is_checkout() && ( empty( $quotationProduct ) || ! $quotationProduct ) ) {
			add_filter( 'woocommerce_cart_no_shipping_available_html', array( $this, 'replace_order_button_hooks' ) );
			add_filter( 'woocommerce_no_shipping_available_html', array( $this, 'replace_order_button_hooks' ) );
		} elseif ( ( ! empty( $quotationProduct ) && false !== $quotationProduct ) ) {
			add_filter( 'woocommerce_cart_no_shipping_available_html', array( $this, 'replace_shipping_message' ) );
			add_filter( 'woocommerce_no_shipping_available_html', array( $this, 'replace_shipping_message' ) );
			//add_action( 'woocommerce_cart_calculate_fees', array($this, 'add_shipping_fee') );
			$this->add_shipping_fee();
			//$zone = new WC_Shipping_Zone();
			//$zone->add_shipping_method('flat_rate');
			$as = 1;

		}
	}

	public function get_shipping_price( $total ) {
		$fee      = WC()->session->get( "custom_shipping_fee" );
		$subtotal = WC()->session->get( 'subtotal' );
		if ( isset( $fee ) && is_numeric( $fee ) ) {
			$total = str_replace( $subtotal, $subtotal + $fee, $total );
		} else {
			$this->add_shipping_fee();
			if ( isset( $fee ) && is_numeric( $fee ) ) {
				$total = str_replace( $subtotal, $subtotal + $fee, $total );
			}
		}

		return $total;
	}

	/**
	 * Replace shipping product as shipping fee
	 */
	public function add_shipping_fee() {
		foreach ( WC()->cart->cart_contents as $item => $values ) {
			$product = $values['data']->post->post_name;
			if ( 'shipping' == $product ) {
				$fee = $values['line_total'];
				WC()->session->set( "custom_shipping_fee", $fee );
				WC()->cart->remove_cart_item( $item );
			}
		}
		if ( isset( $fee ) && is_numeric( $fee ) ) {
			add_filter( 'woocommerce_shipping_packages', array( $this, 'update_packages' ) );
		}
		$fee = WC()->session->get( "custom_shipping_fee" );
		if ( isset( $fee ) && false !== $fee ) {
			add_filter( 'woocommerce_shipping_packages', array( $this, 'update_packages' ) );
		}

	}

	/**
	 * if there is a shipping fee make sure it is updated
	 */
	public function update_shipping_fee() {
		$fee = WC()->session->get( "custom_shipping_fee" );
		if ( isset( $fee ) && false !== $fee ) {
			WC()->cart->add_fee( 'Shipping Fee', $fee, true );
		}
	}

	public function delete_shipping_fee() {
		WC()->cart->empty_cart( true );
		$session_handler = new WC_Session_Handler();
		$session_handler->destroy_session();
	}

	public function update_packages( $packages ) {
		if ( 0 < count( $packages ) ) {
			for ( $i = 0, $count = count( $packages ); $i < $count; $i ++ ) {
				if ( empty( $packages[ $i ]['rates'] ) ) {
					$shipping_method                                   = new WC_Shipping_Rate( 'flat_rate_shipping_fee', 'Flat Rate Shipping', WC()->session->get( 'custom_shipping_fee' ), array(), 'flat_rate' );
					$packages[ $i ]['rates']['flat_rate_shipping_fee'] = $shipping_method;
				}
			}
		}

		return $packages;
	}


	/**
	 * Enqueue the CSS
	 *
	 * @return void
	 */
	public function theme_customisations_css() {
		wp_enqueue_style( 'custom-css', plugins_url( '/custom/style.css', __FILE__ ) );
	}

	/**
	 * Enqueue the Javascript
	 *
	 * @return void
	 */
	public function theme_customisations_js() {

		if ( ! is_checkout() ) {
			wp_enqueue_script( 'custom-js', plugins_url( '/custom/custom.js', __FILE__ ), array( 'wc-add-to-cart-variation' ), false, true );
		} else {
			wp_enqueue_script( 'custom-shipping-js', plugins_url( '/custom/custom-shipping.js', __FILE__ ), array( 'wc-add-to-cart-variation' ), false, true );
		}

	}

	/**
	 * Enqueue the Javascript
	 *
	 * @return void
	 */
	public function theme_customisations_js_shipping() {

		global $wpdb, $quoteupPublicManageSesion;
		$quotationProduct = $quoteupPublicManageSesion->get( 'quotationProducts' );

		if ( is_checkout() && ( empty( $quotationProduct ) || ! $quotationProduct ) ) {

			$this->add_pep_hooks();

			$cart_contents = WC()->cart->cart_contents;

			//remove anonymizing array keys
			$cart_contents = array_values( $cart_contents );

			$cart = array();

			for ( $i = 0, $count = count( $cart_contents ); $i < $count; $i ++ ) {
				$cart['product_id']     = isset( $cart_contents[ $i ]['product_id'] ) ? $cart_contents[ $i ]['product_id'] : null;
				$cart['quantity']       = isset( $cart_contents[ $i ]['quantity'] ) ? $cart_contents[ $i ]['quantity'] : null;
				$cart['variation']      = isset( $cart_contents[ $i ]['variation'] ) ? $cart_contents[ $i ]['variation'] : null;
				$cart['product_var_id'] = isset( $cart_contents[ $i ]['variation_id'] ) ? $cart_contents[ $i ]['variation_id'] : null;
				$cart['author_email']   = isset( $cart_contents[ $i ]['data']->post->post_author ) ? get_userdata( $cart_contents[ $i ]['data']->post->post_author )->user_email : null;
				$cart['remark']         = isset( $cart_contents[ $i ]['remark'] ) ? $cart_contents[ $i ]['remark'] : null;
				$this->quoteup_add_product_in_enq_cart( $cart );
				$this->quoteup_update_enq_cart_session( $cart );
			}


			global $quoteupDisplayQuoteButton;
			$form_data = get_option( 'wdm_form_data' );
			do_action( 'quoteup_create_custom_field' );

			wp_enqueue_style( 'modal_css1', QUOTEUP_PLUGIN_URL . '/css/wdm-bootstrap.css', false, false );
			wp_enqueue_style( 'wdm-mini-cart-css2', QUOTEUP_PLUGIN_URL . '/css/common.css' );
			wp_enqueue_style( 'wdm-quoteup-icon2', QUOTEUP_PLUGIN_URL . '/css/public/wdm-quoteup-icon.css' );

			wp_enqueue_script( 'phone_validate', QUOTEUP_PLUGIN_URL . '/js/public/phone-format.js', array( 'jquery' ), false, true );

			// jQuery based MutationObserver library to monitor changes in attributes, nodes, subtrees etc
			wp_enqueue_script( 'quoteup-jquery-mutation-observer', QUOTEUP_PLUGIN_URL . '/js/admin/jquery-observer.js', array( 'jquery' ) );

			wp_enqueue_script( 'qu-placeholder', plugins_url( '/custom/qoute-up-placeholder.js', __FILE__ ), array(
				'jquery',
				'phone_validate'
			), false, true );
			wp_enqueue_script( 'modal_validate', plugins_url( '/custom/shipping-quote.js', __FILE__ ), array( 'qu-placeholder' ), false, true );

			$redirect_url = $quoteupDisplayQuoteButton->getRedirectUrl( $form_data );

			if ( isset( $form_data['phone_country'] ) ) {
				$country = $form_data['phone_country'];
			} else {
				$country = '';
			}
			//echo "qwqww <pre>";print_r($p);echo "</pre>";exit;
			$data = getLocalizationDataForJs( $redirect_url, $country );

			wp_localize_script( 'modal_validate', 'wdm_data', $data );
		} elseif ( is_checkout() && ( ! empty( $quotationProduct ) && false !== $quotationProduct ) ) {
			wp_enqueue_script( 'custom-checkout', plugins_url( '/custom/custom-checkout.js', __FILE__ ), array( 'wc-checkout' ), false, true );

			//add_action( 'woocommerce_cart_calculate_fees', array($this, 'add_shipping_fee') );

			$this->add_shipping_fee();

			//add_filter( 'woocommerce_cart_subtotal', array( $this, 'get_shipping_price' ) );

			add_filter( 'woocommerce_form_field_country', array( $this, 'custom_override_checkout_fields' ), 10, 4 );
			add_filter( 'woocommerce_form_field_state', array( $this, 'custom_override_checkout_fields' ), 10, 4 );
			add_filter( 'woocommerce_form_field_text', array( $this, 'custom_override_checkout_fields' ), 10, 4 );
			add_filter( 'woocommerce_ship_to_different_address_checked', array(
				$this,
				'custom_override_force_shipping'
			), 1, 1 );

			$enquiry_id = isset( $quotationProduct[0]['enquiry_id'] ) ? sanitize_text_field( $quotationProduct[0]['enquiry_id'] ) : '';
			if ( ! empty( $enquiry_id ) ) {
				$table                 = $wpdb->prefix . "enquiry_detail_new";
				self::$enquiry_details = $wpdb->get_row( $wpdb->prepare( "SELECT enquiry_id, name, email, message, phone_number, subject, enquiry_ip, product_details, enquiry_date, product_sku, enquiry_hash, order_id, expiration_date FROM {$table} WHERE enquiry_id = %s", $enquiry_id ), ARRAY_A );
			}
		}
	}

	/**
	 * Modify Product Enquiry Pro modal fields
	 */
	private function add_pep_hooks() {
		add_filter( 'pep_fields_txtsubject', array( $this, 'pep_remove_shipping_fields' ), 10, 1 );
		add_filter( 'pep_fields_custname', array( $this, 'pep_update_custname_field' ), 10, 1 );
		add_filter( 'pep_fields_txtemail', array( $this, 'pep_update_email_field' ), 10, 1 );
		add_filter( 'pep_fields_txtphone', array( $this, 'pep_update_telephone_field' ), 10, 1 );
		add_action( 'pep_fields_txtmsg', array( $this, 'pep_add_shipping_fields' ), 10, 1 );
	}

	/**
	 * Add products in shopping cart to enquiry cart when checking out
	 *
	 * @param $cart
	 */
	private function quoteup_add_product_in_enq_cart( $cart ) {

		if ( ! isset( $_SESSION ) ) {
			@session_start();
		}
		$data = $cart;

		$product_id       = $cart['product_id'];
		$prod_quant       = $cart['quantity'];
		$title            = 'shipping' !== $product_id ? get_the_title( $product_id ) : "Shipping Fee";
		$remark           = isset( $cart['remark'] ) ? $cart['remark'] : '';
		$id_flag          = 0;
		$counter          = 0;
		$authorEmail      = isset( $cart['author_email'] ) ? $cart['author_email'] : get_the_author();
		$variation_id     = $cart['product_var_id'];
		$variation_detail = '';

		//Variable Product
		if ( $variation_id != '' ) {
			$var_product      = new WC_Product( $variation_id );
			$sku              = $var_product->get_sku();
			$variation_detail = $cart['variation'];

			if ( ! empty( $variation_detail ) ) {
				$newVariation = array();
				foreach ( $variation_detail as $key => $value ) {
					$key                          = str_replace( "attribute_", "", $key );
					$newVariation[ trim( $key ) ] = trim( $value );
				}
				$variation_detail = $newVariation;
			} else {
				$variation_detail = array();
			}

			$price = $var_product->get_price();
			$img   = wp_get_attachment_url( get_post_thumbnail_id( $variation_id ) );
			if ( $img != '' ) {
				$img_url = $img;
			} else {
				$img_url = wp_get_attachment_url( get_post_thumbnail_id( $product_id ) );
			}
		} elseif ( 'shipping' === $product_id ) {
			$price   = 0;
			$sku     = 'shipping';
			$img_url = WC()->plugin_url() . "/assets/images/woocommerce_logo.png";
		} else {
			$product = new WC_Product( $product_id );
			$price   = $product->get_price();
			$sku     = $product->get_sku();
			$img_url = wp_get_attachment_url( get_post_thumbnail_id( $product_id ) );
		}
		//End of Variable Product

		$flag_counter = setFlag( $product_id, $id_flag, $counter, $variation_detail, $variation_id );
		$id_flag      = $flag_counter['id_flag'];
		$counter      = $flag_counter['counter'];

		if ( $id_flag == 0 ) {
			$product_array   = array();
			$prod            = array(
				'id'           => $product_id,
				'title'        => $title,
				'price'        => $price,
				'quant'        => $prod_quant,
				'img'          => $img_url,
				'remark'       => $remark,
				'sku'          => $sku,
				'variation_id' => $variation_id,
				'variation'    => $variation_detail,
				'author_email' => $authorEmail
			);
			$product_array[] = apply_filters( 'wdm_filter_product_data', $prod, $data );
			if ( isset( $_SESSION['wdm_product_count'] ) ) {
				if ( $_SESSION['wdm_product_count'] != '' ) {
					$counter = $_SESSION['wdm_product_count'];
				}
			}
			$_SESSION['wdm_product_info'][ $counter ] = $product_array;
			if ( isset( $_SESSION['wdm_product_count'] ) && ! empty( $_SESSION['wdm_product_count'] ) ) {
				$_SESSION['wdm_product_count'] = $_SESSION['wdm_product_count'] + 1;
			} else {
				$_SESSION['wdm_product_count'] = 1;
			}
		} else {
			if ( $remark != '' ) {
				$_SESSION['wdm_product_info'][ $counter ][0]['remark'] = $remark;
			}
			$_SESSION['wdm_product_info'][ $counter ][0]['quant'] = $prod_quant;
			$_SESSION['wdm_product_info'][ $counter ][0]['price'] = $price;
		}
	}

	/**
	 * Callback for Update cart ajax.
	 *
	 * @param $cart
	 */
	private function quoteup_update_enq_cart_session( $cart ) {
		@session_start();
		$status           = false;
		$pid              = $cart['product_id'];
		$vid              = $cart['product_var_id'];
		$variation_detail = $cart['variation'];
		$status           = 'shipping' !== $pid ? isSoldIndividually( $pid ) : true;
		if ( $status == true ) {
			if ( isset( $cart['clickcheck'] ) && $cart['clickcheck'] == 'remove' ) {
				$quant = 0;
			} else {
				$quant = 1;
			}
		} else {
			$quant = $cart['quantity'];
		}
		if ( isset( $cart['remark'] ) ) {
			$remark = $cart['remark'];
		} else {
			$remark = null;
		}

		if ( "shipping" !== $pid ) {
			$product     = new WC_Product( $pid );
			$pri         = $product->get_price();
			$price       = $product->get_price_html();
			$priceStatus = get_post_meta( $pid, '_enable_price', true );
		} else {
			$product     = null;
			$pri         = 0;
			$price       = 0;
			$priceStatus = false;
		}

		for ( $search = 0; $search < count( $_SESSION['wdm_product_info'] ); ++ $search ) {
			if ( $pid == $_SESSION['wdm_product_info'][ $search ][0]['id'] ) {
				if ( $vid != '' ) {
					if ( $_SESSION['wdm_product_info'][ $search ][0]['variation_id'] == $vid && $_SESSION['wdm_product_info'][ $search ][0]['variation'] == $variation_detail ) {
						if ( $quant == 0 ) {
							array_splice( $_SESSION['wdm_product_info'], $search, 1 );
							$_SESSION['wdm_product_count'] = $_SESSION['wdm_product_count'] - 1;
						} else {
							$product = new WC_Product( $vid );
							$pri     = $product->get_price();
							$price   = wc_price( $pri * $quant );

							$_SESSION['wdm_product_info'][ $search ][0]['quant']  = $quant;
							$_SESSION['wdm_product_info'][ $search ][0]['price']  = $pri;
							$_SESSION['wdm_product_info'][ $search ][0]['remark'] = $remark;
						}
					}
				} else {
					if ( $quant == 0 ) {
						array_splice( $_SESSION['wdm_product_info'], $search, 1 );
						$_SESSION['wdm_product_count'] = $_SESSION['wdm_product_count'] - 1;
					} else {
						$price = wc_price( $pri * $quant );

						$_SESSION['wdm_product_info'][ $search ][0]['quant']  = $quant;
						$_SESSION['wdm_product_info'][ $search ][0]['price']  = $pri;
						$_SESSION['wdm_product_info'][ $search ][0]['remark'] = $remark;
					}
				}
			}
		}
	}

	/**
	 * Look in this plugin for template files first.
	 * This works for the top level templates (IE single.php, page.php etc). However, it doesn't work for
	 * template parts yet (content.php, header.php etc).
	 *
	 * Relevant trac ticket; https://core.trac.wordpress.org/ticket/13239
	 *
	 * @param  string $template template string.
	 *
	 * @return string $template new template string.
	 */
	public function theme_customisations_template( $template ) {
		if ( file_exists( untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/custom/templates/' . basename( $template ) ) ) {
			$template = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/custom/templates/' . basename( $template );
		}

		return $template;
	}

	/**
	 * Look in this plugin for WooCommerce template overrides.
	 *
	 * For example, if you want to override woocommerce/templates/cart/cart.php, you
	 * can place the modified template in <plugindir>/custom/templates/woocommerce/cart/cart.php
	 *
	 * @param string $located is the currently located template, if any was found so far.
	 * @param string $template_name is the name of the template (ex: cart/cart.php).
	 *
	 * @return string $located is the newly located template if one was found, otherwise
	 *                         it is the previously found template.
	 */
	public function theme_customisations_wc_get_template( $located, $template_name, $args, $template_path, $default_path ) {
		global $quoteupPublicManageSesion;

		$plugin_template_path     = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/custom/templates/woocommerce/' . $template_name;
		$plugin_shipping_template = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/custom/templates/woocommerce/shipping-quote/' . $template_name;
		$quotationProduct         = $quoteupPublicManageSesion->get( 'quotationProducts' );

		if ( file_exists( $plugin_template_path ) ) {
			if ( is_checkout() && ( empty( $quotationProduct ) || ! $quotationProduct ) ) {
				$located = $plugin_template_path;
			}
		}

		if ( file_exists( $plugin_shipping_template ) ) {
			if ( is_checkout() && ( ! empty( $quotationProduct ) || false !== $quotationProduct ) ) {
				$located = $plugin_shipping_template;
			}
		}

		return $located;
	}

	/**
	 * @param $loop
	 * @param $variation_data
	 * @param $variation
	 */
	public function variation_options( $loop, $variation_data, $variation ) {
		if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3.0', '>=' ) ) {
			$show_quote_up    = get_post_meta( $variation->ID, 'show_quote_up', true );
			$hide_add_to_cart = get_post_meta( $variation->ID, 'hide_add_to_cart', true );
			?>
			<label><input type="checkbox" class="checkbox show_quote_up"
			              name="show_quote_up[<?php echo $loop; ?>]" <?php if ( $show_quote_up ) {
					checked( $show_quote_up, 'yes' );
				} ?> /> <?php _e( 'Show Request Quote', 'theme-customisation' ); ?> <a class="tips"
			                                                                           data-tip="<?php _e( 'Enable this option to display a request for quote button when this variation is chosen', 'theme-customisation' ); ?>"
			                                                                           href="#">[?]</a></label>
			<label><input type="checkbox" class="checkbox hide_add_to_cart"
			              name="hide_add_to_cart[<?php echo $loop; ?>]" <?php if ( $hide_add_to_cart ) {
					checked( $hide_add_to_cart, 'yes' );
				} ?> /> <?php _e( 'Hide Add To Cart', 'theme-customisation' ); ?> <a class="tips"
			                                                                         data-tip="<?php _e( 'Enable this option to hide the Add To Cart button when this variation is chosen', 'theme-customisation' ); ?>"
			                                                                         href="#">[?]</a></label>
			<?php
		} else {
			?>

			<label><input type="checkbox" class="checkbox show_quote_up"
			              name="show_quote_up[<?php echo $loop; ?>]" <?php if ( isset( $variation_data['show_quote_up'][0] ) ) {
					checked( $variation_data['show_quote_up'][0], 'yes' );
				} ?> /> <?php _e( 'Show Request Quote', 'theme-customisation' ); ?> <a class="tips"
			                                                                           data-tip="<?php _e( 'Enable this option to display a request for quote button when this variation is chosen', 'theme-customisation' ); ?>"
			                                                                           href="#">[?]</a></label>

			<label><input type="checkbox" class="checkbox hide_add_to_cart"
			              name="hide_add_to_cart[<?php echo $loop; ?>]" <?php if ( isset( $variation_data['hide_add_to_cart'][0] ) ) {
					checked( $variation_data['hide_add_to_cart'][0], 'yes' );
				} ?> /> <?php _e( 'Hide Add To Cart', 'theme-customisation' ); ?> <a class="tips"
			                                                                         data-tip="<?php _e( 'Enable this option to hide the Add To Cart button when this variation is chosen', 'theme-customisation' ); ?>"
			                                                                         href="#">[?]</a></label>

			<?php
		}
	}

	/**
	 * @param $variation_id
	 * @param $i
	 */
	public function save_variation_settings( $variation_id, $i ) {
		$show_quote_up    = isset( $_POST['show_quote_up'] ) ? array_map( 'sanitize_text_field', $_POST['show_quote_up'] ) : null;
		$hide_add_to_cart = isset( $_POST['hide_add_to_cart'] ) ? array_map( 'sanitize_text_field', $_POST['hide_add_to_cart'] ) : null;

		if ( isset( $show_quote_up[ $i ] ) ) {
			update_post_meta( $variation_id, 'show_quote_up', 'yes' );

		} else {
			update_post_meta( $variation_id, 'show_quote_up', 'no' );

		}

		if ( isset( $hide_add_to_cart[ $i ] ) ) {
			update_post_meta( $variation_id, 'hide_add_to_cart', 'yes' );

		} else {
			update_post_meta( $variation_id, 'hide_add_to_cart', 'no' );

		}
	}

	/**
	 * @param $post_id
	 */
	function write_panel_save( $post_id ) {

		// variable product save 2.1 - 2.2
		if ( isset( $_POST['variable_post_id'] ) && defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3.0', '<' ) ) {

			$variable_post_id = $_POST['variable_post_id'];
			$show_quote_up    = isset( $_POST['show_quote_up'] ) ? array_map( 'sanitize_text_field', $_POST['show_quote_up'] ) : null;
			$hide_add_to_cart = isset( $_POST['hide_add_to_cart'] ) ? array_map( 'sanitize_text_field', $_POST['hide_add_to_cart'] ) : null;
			$max_loop         = max( array_keys( $_POST['variable_post_id'] ) );

			for ( $i = 0; $i <= $max_loop; $i ++ ) {

				if ( ! isset( $variable_post_id[ $i ] ) ) {
					continue;
				}

				$variation_id = absint( $variable_post_id[ $i ] );

				if ( isset( $show_quote_up[ $i ] ) ) {
					update_post_meta( $variation_id, 'show_quote_up', 'yes' );

				} else {
					update_post_meta( $variation_id, 'show_quote_up', 'no' );

				}

				if ( isset( $hide_add_to_cart[ $i ] ) ) {
					update_post_meta( $variation_id, 'hide_add_to_cart', 'yes' );

				} else {
					update_post_meta( $variation_id, 'hide_add_to_cart', 'no' );

				}
			}
		}
	}

	/**
	 * Adds variation hide/show `add to cart` button & `quote` button settings to the localized variation parameters to be used by JS
	 *
	 * @access public
	 *
	 * @param array $data
	 * @param object $product
	 * @param object $variation
	 *
	 * @return array $data
	 */
	function available_variation( $data, $product, $variation ) {
		$show_quote_up    = get_post_meta( $variation->variation_id, 'show_quote_up', true );
		$hide_add_to_cart = get_post_meta( $variation->variation_id, 'hide_add_to_cart', true );

		if ( 'no' === $show_quote_up || empty( $show_quote_up ) ) {
			$show_quote_up = false;

		} else {
			$show_quote_up = true;

		}

		if ( 'no' === $hide_add_to_cart || empty( $hide_add_to_cart ) ) {
			$hide_add_to_cart = false;

		} else {
			$hide_add_to_cart = true;

		}

		$data['hide_add_to_cart'] = $hide_add_to_cart;
		$data['show_quote_up']    = $show_quote_up;


		return $data;
	}

	/**
	 * Replace the order now button with the Request a Quote Button
	 *
	 * @param $html
	 *
	 * @return bool|string
	 */
	public function replace_order_button( $html ) {

		$cart_contents = WC()->cart->cart_contents;

		//remove anonymizing array keys
		$cart_contents = array_values( $cart_contents );

		$cart = array();

		for ( $i = 0, $count = count( $cart_contents ); $i < $count; $i ++ ) {
			$cart[] = 0 < absint( $cart_contents[ $i ]['variation_id'] ) ? absint( $cart_contents[ $i ]['variation_id'] ) : absint( $cart_contents[ $i ]['product_id'] );
		}

		$QuoteUpDisplayQuoteButton = \Frontend\Includes\QuoteUpDisplayQuoteButton::getInstance();

		$html = $this->display_modal( $cart, 'shipping', $QuoteUpDisplayQuoteButton );

		return $html;
	}

	/**
	 * Prepare data to build css/html for quote modal
	 *
	 * @param array $prod_ids
	 * @param $btn_class
	 * @param $instanceOfQuoteUpDisplayQuoteButton
	 *
	 * @return bool|string
	 */
	public function display_modal( $prod_ids = array(), $btn_class, $instanceOfQuoteUpDisplayQuoteButton ) {

		if ( empty( $prod_ids ) || 0 > $prod_ids ) {
			return false;
		}

		$form_data = get_option( 'wdm_form_data' );
		$color     = $instanceOfQuoteUpDisplayQuoteButton->getDialogColor( $form_data );
		$pcolor    = $instanceOfQuoteUpDisplayQuoteButton->getDialogTitleColor( $form_data );

		$email = $instanceOfQuoteUpDisplayQuoteButton->getUserEmail();
		$name  = $instanceOfQuoteUpDisplayQuoteButton->getUserName();

		$manual_css = 0;
		if ( isset( $form_data['button_CSS'] ) && $form_data['button_CSS'] == 'manual_css' ) {
			$manual_css = 1;
		}

		//Append CSS added in the settings page
		if ( isset( $form_data['user_custom_css'] ) ) {
			wp_add_inline_style( 'modal_css1', $form_data['user_custom_css'] );
		}

		$form = $this->css_html( $manual_css, $prod_ids, $color, $form_data, $btn_class, $instanceOfQuoteUpDisplayQuoteButton );

		unset( $pcolor );
		unset( $email );
		unset( $name );

		return $form;

	}

	/**
	 * Add CSS and HTML markup for quote form modal
	 *
	 * @param $manual_css
	 * @param $prod_ids
	 * @param $color
	 * @param $form_data
	 * @param $btn_class
	 * @param $instanceOfQuoteUpDisplayQuoteButton
	 *
	 * @return string
	 */
	private function css_html( $manual_css, $prod_ids, $color, $form_data, $btn_class, $instanceOfQuoteUpDisplayQuoteButton ) {
		global $wpdb, $product;
		$admin_url = get_admin_url();
		if ( isset( $form_data['button_CSS'] ) ) {
			if ( $form_data['button_CSS'] == 'manual_css' ) {
				$manual_css             = 1;
				$dialogue_product_color = $form_data['dialog_product_color'];
				$dialogue_text_color    = $form_data['dialog_text_color'];
				$color                  = $form_data['dialog_color'];
			} else {
				$color                  = '#FFFFFF';
				$dialogue_product_color = '#999';
				$dialogue_text_color    = '#000000';
			}
		} else {
			$color                  = '#FFFFFF';
			$dialogue_product_color = '#999';
			$dialogue_text_color    = '#000000';
		}

		$ids = is_array( $prod_ids ) ? json_encode( $prod_ids ) : absint( $prod_ids );

		$content = "
		<!--New modal-->
		<div class='wdm-modal wdm-fade' id='wdm-quoteup-modal-shipping' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display:none'>
	<div class='wdm-modal-dialog'>
		<div class='wdm-modal-content'";

		if ( ! empty( $color ) ) {
			$content .= " style='background-color:$color;'>";
		}
		$content .= "<div class='wdm-modal-header'>
				<button type='button' class='close' data-dismiss='wdm-modal' aria-hidden='true'>&times;</button>
				<h4 class='wdm-modal-title' id='myModalLabel'";

		if ( isset( $dialogue_text_color ) ) {
			$content .= " style='color:$dialogue_text_color;'";
		}

		$content .= "><span>";
		$content .= __( 'Send Enquiry for', 'quoteup' );
		$content .= "</span>";
		$content .= "<span class='pr_name'> Shipping Quote</span>";
		$content .= "</h4></div><div class='wdm-modal-body'>";
		$content .= "<form method='post' id='frm_enquiry' name='frm_enquiry' class='wdm-quoteup-form' >";

		$ajax_nonce = wp_create_nonce( 'nonce_for_enquiry' );

		$content .= "<input type='hidden' name='ajax_nonce' id='ajax_nonce' value='$ajax_nonce'>
					<input type='hidden' name='submit_value' id='submit_value'>";

		foreach ( $prod_ids as $prod_id ) {
			$product = new WC_Product( $prod_id );
			$price   = $product->get_price();
			$url     = get_permalink( $prod_id );
			$img_url = wp_get_attachment_url( get_post_thumbnail_id( $prod_id ) );
			$title   = get_the_title( $prod_id );

			$product_id = $prod_id;
			$query      = "select user_email from {$wpdb->posts} as p join {$wpdb->users} as u on p.post_author=u.ID where p.ID=%d";
			$uemail     = $wpdb->get_var( $wpdb->prepare( $query, $product_id ) );

			$content .= "<input type='hidden' name='product_name_shipping' id='product_name_shipping' value='$title'>";
			$content .= "<input type='hidden' name='product_type_shipping' id='product_type_shipping'>";
			$content .= "<input type='hidden' name='variation_shipping' id='variation_shipping' value='$prod_id'>";
			$content .= "<input type='hidden' name='product_id_shipping' id='product_id_shipping' value='shipping'>";
			$content .= "<input type='hidden' name='author_email' id='author_email' value='$uemail'>";
			$content .= "<input type='hidden' name='product_img_shipping' id='product_img_shipping' value='$img_url'>";
			$content .= "<input type='hidden' name='product_price_shipping' id='product_price_shipping' value='$price'>";
			$content .= "<input type='hidden' name='product_url_shipping' id='product_url_shipping' value='$url'>";
			/**
			 * @todo remove admin_url() this is moderately insecure
			 */
			$content .= "<input type='hidden' name='site_url' id='site_url' value='$admin_url'>";
			$content .= "<input type='hidden' name='tried' id='tried' value='yes' />";

		}

		ob_start();

		do_action( 'quoteup_add_hidden_fields_in_form', $prod_id );
		do_action( 'pep_add_hidden_fields_in_form', $prod_id );

		$hidden_fields = ob_get_contents();

		ob_end_clean();

		$content .= $hidden_fields;
		$content .= "<!--<div class='ck_msg wdm-enquiry-form-indication'><sup class='req'>*</sup>" . __( 'Indicates required fields', 'quoteup' ) . "</div> -->";
		$content .= "<div id='error' class='error' ></div>";
		$content .= "<div id='nonce_error' style='text-align: center; background-color: #f2dede; '>";
		$content .= "<div  class='wdmquoteup-err-display' style='background-color:transparent;'>";
		$content .= "<span class='wdm-quoteupicon wdm-quoteupicon-exclamation-circle'></span>";
		$content .= __( 'Unauthorized enquiry', 'quoteup' );
		$content .= "</div></div>";
		$content .= "<div class='wdm-quoteup-form-inner'>";

		ob_start();

		require_once( QUOTEUP_PLUGIN_DIR . '/file-includes.php' );

		do_action( 'quoteup_create_custom_field' );
		do_action( 'quoteup_add_custom_field_in_form' );
		do_action( 'pep_add_custom_field_in_form' );

		$inner_fields = ob_get_contents();

		ob_end_clean();

		$dom = new DOMDocument;
		@$dom->loadHTML( $inner_fields, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
		$inputs = $dom->getElementsByTagName( "input" );

		foreach ( $inputs as $node ) {
			$value = $node->getAttribute( "value" );
			if ( ! empty( $value ) ) {
				$node->setAttribute( "disabled", "" );
			}
		}

		$content .= $dom->saveHtml();
		$enable_mc = '';

		if ( isset( $form_data['enable_send_mail_copy'] ) ) {
			$enable_mc = $form_data['enable_send_mail_copy'];
		}

		$content .= $this->display_send_me_a_copy( $enable_mc );

		$css = 1 == $manual_css ? getManualCSS( $form_data ) : '';

		$content .= "</div>";
		$content .= "<div class='form_input btn_div wdm-enquiryform-btn-wrap wdm-quoteupform-btn-wrap'><div class='form-wrap'>";
		$content .= "<input type='submit' value='" . __( 'Send', 'quoteup' ) . "' name='btnSend'  id='btnSend_shipping' class='button_example' $css >";
		$content .= "<div class='wdmquoteup-loader' style='display: none'>";
		$url = QUOTEUP_PLUGIN_URL . '/images/loading.gif';
		$content .= "<img src='$url' ></div></div></div>";
		$content .= "<div class='form-errors-wrap single-enquiry-form'>";
		$content .= "<div class='form-errors'><ul class='error-list'></ul></div></div></form>";
		$content .= "<div id='success_shipping' class='wdmquoteup-success-wrap'><div class='success_msg'>";
		$content .= "<span class='wdm-quoteupicon wdm-quoteupicon-done'></span> <strong>";
		$content .= __( 'Enquiry email sent successfully!', 'quoteup' );
		$content .= "</strong></div></div></div>";

		$content .= "</div></div></div>";
		$content .= "<div class='quote-form shipping-quote-form'>";

		if ( isset( $form_data['show_button_as_link'] ) && $form_data['show_button_as_link'] == 1 ) {
			$content .= "<a id='wdm-quoteup-trigger-shipping' data-toggle='wdm-quoteup-modal' data-target='#wdm-quoteup-modal' data-pids='$ids' href='#' style='font-weight: bold;";
			if ( $form_data['button_text_color'] ) {
				$content .= 'color: ' . $form_data['button_text_color'] . ';';
			}
			$content .= "'>";
			$content .= $instanceOfQuoteUpDisplayQuoteButton->returnButtonText( $form_data );
			$content .= "</a>";
		} else {
			$content .= "<button class='$btn_class' id='wdm-quoteup-trigger-shipping' data-toggle='wdm-quoteup-modal' data-pids='$ids' data-target='#wdm-quoteup-modal' $css >";
			$content .= $instanceOfQuoteUpDisplayQuoteButton->returnButtonText( $form_data );
			$content .= "</button>";
		}
		$content .= "</div>";


		return $content;
	}

	/**
	 * CC Enquiry to Customer
	 *
	 * @param $enable_mc
	 * @param string $dialogue_text_color
	 *
	 * @return string
	 */
	private function display_send_me_a_copy( $enable_mc, $dialogue_text_color = '' ) {
		$content = '';
		if ( $enable_mc == 1 ) {
			$content .= "<div class='ck form_input'><label class='contact-cc-wrap'";
			$content .= ! empty( $dialogue_text_color ) ? " style=' color: " . $dialogue_text_color . ";'>" : ">";
			$content .= "<input type='checkbox' id='contact-cc'  name='cc' value='yes'  /><span class='contact-cc-txt'>";
			$content .= __( 'Send me a copy', 'quoteup' );
			$content .= "</span></label></div>";
		}

		return $content;
	}

	/**
	 * @param $message
	 *
	 * @return string
	 */
	public function replace_order_button_hooks( $message ) {
		add_filter( 'woocommerce_order_button_html', array( $this, 'replace_order_button' ), 11, 1 );
		$this->add_pep_hooks();

		$message = __( "There are no shipping methods available. Please double check your shipping address prior to requesting a quote." );

		return $message;
	}

	/**
	 * @param $message
	 *
	 * @return string
	 */
	public function replace_shipping_message( $message ) {
		$message = __( "Flat Rate Shipping" );

		return $message;
	}

	/**
	 * Callback for submitting enquiry form ajax from checkout shipping quote.
	 */
	public function quoteup_submit_shipping_woo_enquiry_form() {
		@session_start();
		global $woocommerce, $wpdb;

		if ( ! registered_meta_key_exists( 'post', '_qu_shipping_product' ) ) {
			$args = array(
				'sanitize_callback' => 'absint',
				'type'              => 'integer',
				'description'       => 'Stored Product id for Quote Up Shipping Product',
				'single'            => true,
				'show_in_rest'      => false
			);

			register_meta( 'post', '_qu_shipping_product', $args );

		}

		$table               = $wpdb->postmeta;
		$sql                 = $wpdb->prepare( "SELECT meta_value FROM {$table} WHERE meta_key = %s", '_qu_shipping_product' );
		$shipping_product_id = $wpdb->get_var( $sql );

		if ( ! $shipping_product_id && ( 'product_variation' !== get_post_type( $shipping_product_id ) || ! wc_get_product( $shipping_product_id ) ) ) {
			$data = array(
				'product' => array(
					'title'             => 'Shipping',
					'sku'               => 'qu_shipping',
					'type'              => 'simple',
					'regular_price'     => '0.00',
					'description'       => '',
					'short_description' => '',
					'categories'        => array(),
					'images'            => array(),
					'status'            => 'hidden'
				)
			);

			$legacy = new WC_Legacy_API();
			$legacy->includes();

			$api_server = new WC_API_Server( '/' );


			$product = new WC_API_Products( $api_server );
			if ( ! current_user_can( 'publish_products' ) ) {
				$current_user_id  = get_current_user_id();
				$checkout_page_id = get_option( 'woocommerce_checkout_page_id' );
				$author           = get_post_field( 'post_author', $checkout_page_id );
				wp_set_current_user( $author );
				$product = $product->create_product( $data, $product );

				wp_set_current_user( $current_user_id );
			} else {
				$product = $product->create_product( $data, $product );
			}

			if ( is_wp_error( $product ) ) {
				exit( $product->get_error_message );
			}

			add_post_meta( $product['product']['id'], '_qu_shipping_product', $product['product']['id'], true );
			delete_post_meta( $product['product']['id'], '_visibility' );
			$shipping_product_id = $product['product']['id'];
		}

		$cart             = array();
		$shipping_address = array();

		$shipping_address['street']      = ! empty( $_POST['street'] ) ? sanitize_text_field( $_POST['street'] ) : '';
		$shipping_address['street_2']    = ! empty( $_POST['street_2'] ) ? sanitize_text_field( $_POST['street_2'] ) : '';
		$shipping_address['city']        = ! empty( $_POST['city'] ) ? sanitize_text_field( $_POST['city'] ) : '';
		$shipping_address['state']       = ! empty( $_POST['state'] ) ? sanitize_text_field( $_POST['state'] ) : '';
		$shipping_address['country']     = ! empty( $_POST['country'] ) ? sanitize_text_field( $_POST['country'] ) : '';
		$shipping_address['postal_code'] = ! empty( $_POST['postal_code'] ) ? sanitize_text_field( $_POST['postal_code'] ) : '';

		$shipping_address_data = maybe_serialize( $shipping_address );

		$shipping_label = ! empty( $_POST['street'] ) ? sanitize_text_field( $_POST['street'] ) . "\n" : '';
		$shipping_label .= ! empty( $_POST['street_2'] ) ? sanitize_text_field( $_POST['street_2'] ) . "\n" : '';
		$shipping_label .= ! empty( $_POST['city'] ) ? sanitize_text_field( $_POST['city'] ) . ", " : '';
		$shipping_label .= ! empty( $_POST['state'] ) ? sanitize_text_field( $_POST['state'] ) . "\n" : '';
		$shipping_label .= ! empty( $_POST['country'] ) ? sanitize_text_field( $_POST['country'] ) . "\n" : '';
		$shipping_label .= ! empty( $_POST['postal_code'] ) ? sanitize_text_field( $_POST['postal_code'] ) : '';

		$shipping_address_html = "<span data-shipping='$shipping_address_data'>$shipping_label</span>";

		$cart['product_id']     = $shipping_product_id;
		$cart['quantity']       = 1;
		$cart['variation']      = array();
		$cart['product_var_id'] = null;
		$cart['author_email']   = null;
		$cart['remark']         = $shipping_address_html;

		$this->quoteup_add_product_in_enq_cart( $cart );
		$this->quoteup_update_enq_cart_session( $cart );

		if ( isset( $_POST['security'] ) && wp_verify_nonce( $_POST['security'], 'nonce_for_enquiry' )
		) {
			global $wpdb;
			$data_obtained_from_form = $_POST;
			$form_data_for_mail      = json_encode( $data_obtained_from_form );
			$name                    = wp_kses( $_POST['custname'], array() );
			$email                   = sanitize_email( $_POST['txtemail'] );
			$phone                   = phoneNumber();
			$subject                 = '';
			$authorEmail             = get_bloginfo( 'admin_email' );

			if ( isset( $_POST['txtsubject'] ) ) {
				$subject = wp_kses( $_POST['txtsubject'], array() );
			} else {
				$subject = '';
			}

			if ( isset( $_POST['txtmsg'] ) ) {
				$msg = $shipping_address_html;
			} else {
				$msg = '';
			}

			$product_table = '';
			$form_data     = get_option( 'wdm_form_data' );

			$form_data['enable_disable_mpe'] = "1";

			$product_table_and_details = emailAndDbDataOfProducts( $form_data, $product_table );
			$product_details           = setProductDetails( $product_table_and_details );
			if ( isset( $product_table_and_details['product_table'] ) ) {
				$product_table = $product_table_and_details['product_table'];
			} else {
				$product_table = '';
			}

			if ( isset( $product_table_and_details['customer_product_table'] ) ) {
				$customer_product_table = $product_table_and_details['customer_product_table'];
			} else {
				$customer_product_table = '';
			}

			$authorEmail = setAuthorEmail( $product_table_and_details );

			$address = getEnquiryIP();

			$type = 'Y-m-d H:i:s';
			$date = current_time( $type );
			$tbl  = $wpdb->prefix . 'enquiry_detail_new';

			if ( $wpdb->insert(
				$tbl,
				array(
					'name'            => $name,
					'email'           => $email,
					'phone_number'    => $phone,
					'subject'         => $subject,
					'enquiry_ip'      => $address,
					'product_details' => $product_details,
					'message'         => $msg,
					'enquiry_date'    => $date,
				),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
				)
			)
			) {
				do_action( 'mpe_form_entry_added_in_db', $wpdb->insert_id );
				do_action( 'quoteup_form_entry_added_in_db', $wpdb->insert_id );
				do_action( 'pep_form_entry_added_in_db', $wpdb->insert_id );
				do_action( 'quoteup_create_custom_field' );
				do_action( 'pep_create_custom_field' );
				do_action( 'quoteup_add_custom_field_in_db', $wpdb->insert_id );
				do_action( 'pep_add_custom_field_in_db', $wpdb->insert_id );

				$blg_name      = get_option( 'blogname' );
				$admin_emails  = array();
				$admin_subject = '';

				$email_data = get_option( 'wdm_form_data' );
				if ( $email_data['user_email'] != '' ) {
					$admin_emails = explode( ',', $email_data['user_email'] );
				}
				$admin_emails = array_map( 'trim', $admin_emails );

				//Send email to admin only if 'Send mail to Admin' settings is checked
				if ( isset( $email_data['send_mail_to_admin'] ) && $email_data['send_mail_to_admin'] == 1 ) {
					$admin = get_option( 'admin_email' );
					if ( ! in_array( $admin, $admin_emails ) ) {
						$admin_emails[] = $admin;
					}
				}

				//Send email to author only if 'Send mail to Author' settings is checked
				if ( isset( $email_data['send_mail_to_author'] ) && $email_data['send_mail_to_author'] == 1 ) {
					if ( ! empty( $authorEmail ) ) {
						$admin_emails = array_merge( $admin_emails, $authorEmail );
					}
				}

				$wdm_sitename  = '[' . trim( get_bloginfo( 'name' ) ) . '] ';
				$admin_subject = adminSubject( $subject, $email_data, $wdm_sitename );
				$admin_emails  = array_unique( $admin_emails );

				if ( empty( $admin_emails ) ) {
					return;
				}

				foreach ( $admin_emails as $admin_email ) {
					forEachAdminEmails( $admin_email, $blg_name, $form_data_for_mail, $product_table, $email, $name, $admin_subject );
				}
				do_action( 'wdm_after_send_admin_email' );

				sendCopyIfChecked( $name, $blg_name, $form_data_for_mail, $admin_subject, $email, $customer_product_table );

				$_SESSION['wdm_product_info']  = '';
				$_SESSION['wdm_product_count'] = 0;
				unset( $_SESSION['wdm_product_info'] );
			}
		}

		//Sending output to screen so that browsers other than Chrome wait till response received from the server.
		$_SESSION['wdm_product_info']  = '';
		$_SESSION['wdm_product_count'] = 0;
		unset( $_SESSION['wdm_product_info'] );
		$this->delete_shipping_fee();
		exit( json_encode( array(
			"completed" => true,
			"redirect"  => get_permalink( $this->insert_thankyou_page() )
		) ) );
		//wp_safe_redirect("")
	}

	private function insert_thankyou_page() {

		global $wpdb;

		$current_user_id  = get_current_user_id();
		$checkout_page_id = get_option( 'woocommerce_checkout_page_id' );
		$author           = get_post_field( 'post_author', $checkout_page_id );

		$data = array(
			'post_author'    => $author,
			'post_name'      => 'enquiry-thank-you',
			'post_type'      => 'page',
			'post_title'     => 'Enquiry Thank You',
			'post_content'   => __( "Thank You For Your Enquiry. We will be in touch shortly." ),
			'post_excerpt'   => '',
			'post_status'    => 'publish',
			'comment_status' => false,
			'ping_status'    => false
		);

		if ( ! registered_meta_key_exists( 'post', '_qu_shipping_thank_you' ) ) {
			$args = array(
				'sanitize_callback' => 'absint',
				'type'              => 'integer',
				'description'       => 'Stored Page id for Quote Up Shipping Thank You Page',
				'single'            => true,
				'show_in_rest'      => false
			);

			register_meta( 'post', '_qu_shipping_thank_you', $args );

		}

		$table = $wpdb->postmeta;
		$sql   = $wpdb->prepare( "SELECT meta_value FROM {$table} WHERE meta_key = %s", '_qu_shipping_thank_you' );
		$page  = $wpdb->get_var( $sql );

		if ( ! $page && 'page' !== get_post_type( $page ) ) {

			if ( ! current_user_can( 'publish_pages' ) ) {


				wp_set_current_user( $author );


				$page = wp_insert_post( $data );

				wp_set_current_user( $current_user_id );

			} else {

				$page = wp_insert_post( $data );

				wp_set_current_user( $current_user_id );

			}

			if ( is_wp_error( $page ) && is_admin() ) {
				wc_add_notice( $page->get_error_message() );
			} else {
				add_post_meta( $page, '_qu_shipping_thank_you', $page, true );
			}
		}

		return $page;

	}

	/**
	 * Remove Unnecessary quote fields
	 * @return array
	 * @internal param $enq_fields
	 *
	 */
	public function pep_remove_shipping_fields() {
		return array();
	}

	/**
	 * Add Shipping Quote Fields
	 *
	 * @param $enq_fields
	 *
	 * @return mixed
	 */
	public function pep_add_shipping_fields( $enq_fields ) {

		$street      = array(
			'id'                       => 'street',
			'class'                    => 'wdm-modal_text disabled',
			'type'                     => 'text',
			'placeholder'              => 'Street Address',
			'required'                 => 'no',
			'required_message'         => '',
			'validation'               => '',
			'validation_message'       => '',
			'include_in_admin_mail'    => 'yes',
			'include_in_customer_mail' => 'no',
			'label'                    => 'Street Address',
			'value'                    => isset( $_POST['s_address'] ) && ! empty( $_POST['s_address'] ) ? sanitize_text_field( $_POST['s_address'] ) : ''
		);
		$street_2    = array(
			'id'                       => 'street2',
			'class'                    => 'wdm-modal_text disabled',
			'type'                     => 'text',
			'placeholder'              => 'Street Address 2',
			'required'                 => 'no',
			'required_message'         => '',
			'validation'               => '',
			'validation_message'       => '',
			'include_in_admin_mail'    => 'yes',
			'include_in_customer_mail' => 'no',
			'label'                    => 'Street Address 2',
			'value'                    => isset( $_POST['s_address_2'] ) && ! empty( $_POST['s_address_2'] ) ? sanitize_text_field( $_POST['s_address_2'] ) : ''
		);
		$city        = array(
			'id'                       => 'city',
			'class'                    => 'wdm-modal_text disabled',
			'type'                     => 'text',
			'placeholder'              => 'City',
			'required'                 => 'no',
			'required_message'         => '',
			'validation'               => '',
			'validation_message'       => '',
			'include_in_admin_mail'    => 'yes',
			'include_in_customer_mail' => 'no',
			'label'                    => 'City',
			'value'                    => isset( $_POST['s_city'] ) && ! empty( $_POST['s_city'] ) ? sanitize_text_field( $_POST['s_city'] ) : ''
		);
		$postal_code = array(
			'id'                       => 'postal_code',
			'class'                    => 'wdm-modal_text disabled',
			'type'                     => 'text',
			'placeholder'              => 'Zip / Postal Code',
			'required'                 => 'no',
			'required_message'         => '',
			'validation'               => '',
			'validation_message'       => '',
			'include_in_admin_mail'    => 'yes',
			'include_in_customer_mail' => 'no',
			'label'                    => 'Zip / Postal Code',
			'value'                    => isset( $_POST['s_postcode'] ) && ! empty( $_POST['s_postcode'] ) ? sanitize_text_field( $_POST['s_postcode'] ) : ''
		);
		$country     = array(
			'id'                       => 'country',
			'class'                    => 'wdm-modal_text disabled',
			'type'                     => 'text',
			'placeholder'              => '',
			'required'                 => 'no',
			'required_message'         => '',
			'validation'               => '',
			'validation_message'       => '',
			'include_in_admin_mail'    => 'yes',
			'include_in_customer_mail' => 'no',
			'label'                    => 'Country',
			'value'                    => isset( $_POST['s_country'] ) && ! empty( $_POST['s_country'] ) ? sanitize_text_field( $_POST['s_country'] ) : ''
		);
		$state       = array(
			'id'                       => 'state',
			'class'                    => 'wdm-modal_text disabled',
			'type'                     => 'text',
			'placeholder'              => '',
			'required'                 => 'no',
			'required_message'         => '',
			'validation'               => '',
			'validation_message'       => '',
			'include_in_admin_mail'    => 'yes',
			'include_in_customer_mail' => 'no',
			'label'                    => 'State/Province',
			'value'                    => isset( $_POST['s_state'] ) && ! empty( $_POST['s_state'] ) ? sanitize_text_field( $_POST['s_state'] ) : ''
		);

		// ****** IMPORTANT********
		// the order of the fields specified will be decide the order in which fields will be displayed
		$enq_fields['value'] = ! empty( $street['value'] ) ? $street['value'] . "\n" : '';
		$enq_fields['value'] .= ! empty( $street_2['value'] ) ? $street_2['value'] . "\n" : '';
		$enq_fields['value'] .= ! empty( $city['value'] ) ? $city['value'] . ", " : '';
		$enq_fields['value'] .= ! empty( $state['value'] ) ? $state['value'] . "\n" : '';
		$enq_fields['value'] .= ! empty( $country['value'] ) ? $country['value'] . "\n" : '';
		$enq_fields['value'] .= ! empty( $postal_code['value'] ) ? $postal_code['value'] : '';
		$enq_fields['class'] = $enq_fields['class'] . ' hidden';

		$enq_fields = array( $street, $street_2, $city, $country, $state, $postal_code, $enq_fields );

		return $enq_fields;
	}

	/**
	 * Populate phone number if available
	 *
	 * @param $enq_fields
	 *
	 * @return mixed
	 */
	public function pep_update_telephone_field( $enq_fields ) {
		$enq_fields['value'] = WC()->checkout()->get_value( "billing_phone" ) ? sanitize_text_field( WC()->checkout()->get_value( "billing_phone" ) ) : '';

		return $enq_fields;
	}

	/**
	 * Populate email if available
	 *
	 * @param $enq_fields
	 *
	 * @return mixed
	 */
	public function pep_update_email_field( $enq_fields ) {
		$enq_fields['value'] = WC()->checkout()->get_value( "billing_email" ) ? sanitize_text_field( WC()->checkout()->get_value( "billing_email" ) ) : '';

		return $enq_fields;
	}

	/**
	 * Populate Full Name if available
	 *
	 * @param $enq_fields
	 *
	 * @return mixed
	 */
	public function pep_update_custname_field( $enq_fields ) {
		$first_name          = WC()->checkout()->get_value( "billing_first_name" ) ? sanitize_text_field( WC()->checkout()->get_value( "billing_first_name" ) ) : '';
		$last_name           = WC()->checkout()->get_value( "billing_last_name" ) ? sanitize_text_field( WC()->checkout()->get_value( "billing_last_name" ) ) : '';
		$enq_fields['value'] = ! empty( $first_name ) && ! empty( $last_name ) ? $first_name . " " . $last_name : $first_name . $last_name;

		return $enq_fields;
	}

	public function register_awaiting_shipment_order_status() {
		register_post_status( 'wc-awaiting-shipment', array(
			'label'                     => 'Awaiting shipment',
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( 'Awaiting shipment <span class="count">(%s)</span>', 'Awaiting shipment <span class="count">(%s)</span>' )
		) );
	}

	// Add to list of WC Order statuses
	public function add_awaiting_shipment_to_order_statuses( $order_statuses ) {

		$new_order_statuses = array();

		// add new order status after processing
		foreach ( $order_statuses as $key => $status ) {

			$new_order_statuses[ $key ] = $status;

			if ( 'wc-processing' === $key ) {
				$new_order_statuses['wc-awaiting-shipment'] = 'Awaiting shipment';
			}
		}

		return $new_order_statuses;
	}

	// Add Order action to Order action meta box
	public function add_order_meta_box_actions( $actions ) {
		$actions['wc_awaiting_shipment'] = __( 'Awaiting shipment', 'theme-customisations' );

		return $actions;
	}

	//Add callback if Shipped action called
	public function order_shipped_callback( $order ) {
		//Here order object is sent as parameter

		//Add code for processing here
	}

	//Add callback if Status changed to Shipping
	public function order_status_shipped_callback( $order_id ) {
		//Here order id is sent as parameter
		//Add code for processing here
	}

	public function add_shipped_in_bulk_action() {
		global $post_type;

		if ( 'shop_order' == $post_type ) { ?>
			<script type="text/javascript">

				jQuery(function () {

					jQuery('<option>').val('mark_shipped').text('<?php _e( 'Awaiting shipment', 'woocommerce' )?>').appendTo("select[name='action']");
					jQuery('<option>').val('mark_shipped').text('<?php _e( 'Awaiting shipment', 'woocommerce' )?>').appendTo("select[name='action2']");

					//Add icon

					title_text = jQuery('.column-order_status .awaiting-shipment').html();
					jQuery('.column-order_status .awaiting-shipment').attr('alt', title_text);
					jQuery('.column-order_status .awaiting-shipment').empty();
					jQuery('.column-order_status .awaiting-shipment').append('<icon class="icon-local-shipping"></icon>')
					jQuery('.column-order_status .awaiting-shipment').css('text-indent', '0');

				});
			</script>

			<?php

		}

	}

	public function bulk_action_shipping_callback() {
		$wp_list_table = _get_list_table( 'WP_Posts_List_Table' );
		$action        = $wp_list_table->current_action(); //wc-shipped

		switch ( $action ) {

			case 'mark_shipped' :

				$new_status    = 'wc-awaiting-shipment';
				$report_action = 'marked_shipped';
				break;

			default :
				return;
		}

		$post_ids = array_map( 'absint', (array) $_REQUEST['post'] );

		$changed = 0;
		foreach ( $post_ids as $post_id ) {
			$order = wc_get_order( $post_id );
			$order->update_status( $new_status, __( 'Order status changed by bulk edit:', 'woocommerce' ) );
			$changed ++;
		}

		$sendback = add_query_arg( array(
			'post_type'    => 'shop_order',
			$report_action => true,
			'changed'      => $changed,
			'ids'          => join( ',', $post_ids )
		), '' );

		wp_redirect( $sendback );
		exit();

	}

	public function add_custom_order_status_icon() {

		if ( ! is_admin() ) {
			return;
		}

		?>
		<style>
			/* Add custom status order icons */
			icon.icon-local-shipping,
			.column-order_status mark.awaiting-shipment,
			.column-order_status mark.building {
				content: url(<?php echo plugin_dir_url(__FILE__) . '/assetts/CustomOrderStatus.png'; ?>);
			}
			.order_actions .awaiting-shipment {
				display: block;
				text-indent: -9999px;
				position: relative;
				padding: 0!important;
				height: 2em!important;
				width: 2em;
			}
			.order_actions .awaiting-shipment:after {
				font-family: Dashicons;
				text-indent: 0;
				position: absolute;
				width: 100%;
				height: 100%;
				left: 0;
				line-height: 1.85;
				margin: 0;
				text-align: center;
				speak: none;
				font-variant: normal;
				text-transform: none;
				-webkit-font-smoothing: antialiased;
				top: 0;
				font-weight: 400;
				content: "\f466";
			}

			/* Repeat for each different icon; tie to the correct status */

		</style> <?php
	}

	public function add_awaiting_shipping_action($actions, $the_order){
		global $post;

		if ( $the_order->has_status( array( 'pending', 'on-hold', 'processing' ) ) ) {

			$actions['awaiting-shipment'] = array(
				'url'    => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=awaiting-shipment&order_id=' . $post->ID ), 'woocommerce-mark-order-status' ),
				'name'   => __( 'Awaiting Shipment', 'woocommerce' ),
				'action' => "awaiting-shipment"
			);
		}
		if ( $the_order->has_status( array( 'awaiting-shipment' ) ) ) {

			$actions['complete'] = array(
				'url'       => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=completed&order_id=' . $post->ID ), 'woocommerce-mark-order-status' ),
				'name'      => __( 'Complete', 'woocommerce' ),
				'action'    => "complete"
			);
			$actions['processing'] = array(
				'url'       => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=processing&order_id=' . $post->ID ), 'woocommerce-mark-order-status' ),
				'name'      => __( 'Processing', 'woocommerce' ),
				'action'    => "processing"
			);
		}


		return $actions;

	}


} // End Class

/**
 * The 'main' function
 *
 * @return void
 */
function theme_customisations_main() {
	new Theme_Customisations();
}

/**
 * Initialise the plugin
 */
add_action( 'plugins_loaded', 'theme_customisations_main' );
