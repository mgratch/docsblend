<?php

/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 10/13/2016
 * Time: 9:14 PM
 */
class WC_Add_Shipped_Order_Status {

	private $wc_prefix = 'wc-';

	private $status = 'shipped';

	private $status_label = 'In Transit';

	public function __construct() {

		add_action( 'init', array( $this, 'register_awaiting_shipment_order_status' ) );

		add_filter( 'woocommerce_order_actions', array( $this, 'add_order_meta_box_actions' ) );
		//add_action( 'woocommerce_order_action_wc-awaiting-shipment', array( $this, 'order_shipped_callback' ), 10, 1 );

		add_filter( 'wc_order_statuses', array( $this, 'add_awaiting_shipment_to_order_statuses' ) );
		//add_action( 'woocommerce_order_status_wc-awaiting-shipment', array( $this,'order_status_shipped_callback' ), 10, 1 );

		add_action( 'wp_print_scripts', array( $this, 'add_custom_order_status_icon' ) );
		add_action( 'load-edit.php', array( $this, 'bulk_action_shipping_callback' ) );
		add_action( 'admin_footer', array( $this, 'add_shipped_in_bulk_action' ), 11 );
		add_filter( 'woocommerce_admin_order_actions', array( $this, 'add_shipped_action' ), 10, 2 );

		add_filter( 'woocommerce_email_actions', array( $this, 'so_27112461_woocommerce_email_actions' ) );


	}

	public function register_awaiting_shipment_order_status() {
		register_post_status( 'wc-' . $this->status, array(
			'label'                     => $this->status_label,
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( $this->status_label . ' <span class="count">(%s)</span>', $this->status_label . ' <span class="count">(%s)</span>' )
		) );
	}

	// Add to list of WC Order statuses
	public function add_awaiting_shipment_to_order_statuses( $order_statuses ) {

		$new_order_statuses = array();

		// add new order status after processing
		foreach ( $order_statuses as $key => $status ) {

			$new_order_statuses[ $key ] = $status;

			if ( 'wc-processing' === $key ) {
				$new_order_statuses[ 'wc-' . $this->status ] = $this->status_label;
			}
		}

		return $new_order_statuses;
	}

	// Add Order action to Order action meta box
	public function add_order_meta_box_actions( $actions ) {
		$actions['wc_shipped'] = __( 'Mark Shipped', 'theme-customisations' );

		return $actions;
	}

	//Add callback if Shipped action called
	public function order_shipped_callback( $order ) {
		$id   = $order;
		$that = "something";
	}

	//Add callback if Status changed to Shipping
	public function order_status_shipped_callback( $order_id ) {

		$id   = $order_id;
		$that = "something";
		//Here order id is sent as parameter
		//Add code for processing here
	}

	public function add_shipped_in_bulk_action() {
		global $post_type;

		if ( 'shop_order' == $post_type ) { ?>
			<script type="text/javascript">

				jQuery(function () {

					jQuery('<option>').val('mark_shipped').text('<?php _e( 'Mark Shipped', 'woocommerce' )?>').appendTo("select[name='action']");
					jQuery('<option>').val('mark_shipped').text('<?php _e( 'Mark Shipped', 'woocommerce' )?>').appendTo("select[name='action2']");

					//Add icon

					title_text = jQuery('.column-order_status .shipped').html();
					jQuery('.column-order_status .shipped').attr('alt', title_text);
					jQuery('.column-order_status .shipped').empty();
					jQuery('.column-order_status .shipped').append('<icon class="icon-local-shipping"></icon>')
					jQuery('.column-order_status .shipped').css('text-indent', '0');

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

				$new_status    = $this->status;
				$report_action = 'marked_shipped';
				break;

			default :
				return;
		}

		$post_ids = array_map( 'absint', (array) $_REQUEST['post'] );

		$changed = 0;
		foreach ( $post_ids as $post_id ) {
			$order = wc_get_order( $post_id );
			$order->update_status( 'wc-' . $new_status, __( 'Order status changed by bulk edit:', 'woocommerce' ) );
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
			.column-order_status mark.shipped,
			.column-order_status mark.building {
				content: url(<?php echo plugin_dir_url(__FILE__) . '../assetts/CustomOrderStatus.png'; ?>);
			}

			.order_actions .shipped {
				display: block;
				text-indent: -9999px;
				position: relative;
				padding: 0 !important;
				height: 2em !important;
				width: 2em;
			}

			.order_actions .shipped:after {
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

	public function add_shipped_action( $actions, $the_order ) {
		global $post;

		if ( $the_order->has_status( array( 'pending', 'on-hold', 'processing' ) ) ) {

			$actions[ $this->status ] = array(
				'url'    => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=shipped&order_id=' . $post->ID ), 'woocommerce-mark-order-status' ),
				'name'   => __( 'Mark Shipped', 'woocommerce' ),
				'action' => "shipped"
			);
		}
		if ( $the_order->has_status( array( $this->status ) ) ) {

			$actions['complete']   = array(
				'url'    => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=completed&order_id=' . $post->ID ), 'woocommerce-mark-order-status' ),
				'name'   => __( 'Complete', 'woocommerce' ),
				'action' => "complete"
			);
			$actions['processing'] = array(
				'url'    => wp_nonce_url( admin_url( 'admin-ajax.php?action=woocommerce_mark_order_status&status=processing&order_id=' . $post->ID ), 'woocommerce-mark-order-status' ),
				'name'   => __( 'Processing', 'woocommerce' ),
				'action' => "processing"
			);
		}


		return $actions;

	}

	public function so_27112461_woocommerce_email_actions( $actions ) {
		$new_actions = array(
			'woocommerce_order_status_pending_to_shipped',
			'woocommerce_order_status_on-hold_to_shipped',
			'woocommerce_order_status_processing_to_shipped',
			'woocommerce_order_status_shipped'
		);

		foreach ($new_actions as $action){
			$actions[] = $action;
		}

		return $actions;
	}


}