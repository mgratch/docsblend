<?php
/**
 * Woocommerce custom modifications
 */

add_theme_support('woocommerce');

if (!function_exists('ct_is_woocommerce_active')) {

    function ct_is_woocommerce_active()
    {
        return class_exists('WooCommerce');
    }
}

if (!ct_is_woocommerce_active()) {
    return;
}


function ct_woo_modify_body($classes)
{
    //@todo from alex move to plugin/wpml-plugin
    if (ct_is_woocommerce_active()) {
        $classes[] = 'ct-woocommerceActive';
    }
    return $classes;

}
add_filter('body_class', 'ct_woo_modify_body', 12, 2);


add_filter('roots-nice-search', '__return_false');

/**
 *
 * custom js
 *
 **/
if (!function_exists('ct_woo_scripts')) {
    function ct_woo_scripts()
    {
        wp_register_script('ct-woo-customjs', CT_THEME_DIR_URI . '/woocommerce/js/woocommerce.js', array('jquery'), false, true);
        wp_enqueue_script('ct-woo-customjs');

        if (is_product()) {
            wp_register_script('ct-woo-check-gallery', CT_THEME_DIR_URI . '/woocommerce/js/check-gallery.js', array('wc-add-to-cart-variation'), false, true);
            wp_enqueue_script('ct-woo-check-gallery');

            wp_register_script('ct-easing', CT_THEME_ASSETS . '/js/jquery.easing.1.3.js', array('jquery'), false, true);
            wp_enqueue_script('ct-easing');

            wp_register_script('ct-flex-slider', CT_THEME_ASSETS . '/js/flexslider/jquery.flexslider-min.js', array('jquery'), false, true);
            wp_enqueue_script('ct-flex-slider');

            wp_register_script('ct-flexslider_init', CT_THEME_ASSETS . '/js/flexslider/init.js', array('ct-flex-slider'), false, true);
            wp_enqueue_script('ct-flexslider_init');
        }
    }
}

add_action('wp_enqueue_scripts', 'ct_woo_scripts');

/**
 *
 *WP roots issue with - fix
 *http://wordpress.stackexchange.com/questions/95293/wp-enqueue-style-will-not-let-me-enforce-screen-only
 *    'media'   => 'only screen and (max-width: ' . apply_filters( 'woocommerce_style_smallscreen_breakpoint', $breakpoint = '768px' ) . ')'
 *
 **/
remove_filter('style_loader_tag', 'roots_clean_style_tag');

/**
 *
 *redirect to page on login
 *
 **/
add_filter('woocommerce_login_redirect', 'ras_login_redirect');
function ras_login_redirect($redirect_to)
{
    $redirect_to = home_url();

    return $redirect_to;
}

/**
 *
 *Remove woocommerce title
 *
 **/
add_filter('woocommerce_show_page_title', '__return_false');


/**
 *
 *Display 9 products per page
 *
 **/
add_filter('loop_shop_per_page', create_function('$cols', 'return 9;'), 20);


/**
 *
 *Change number or products per row to 3
 *
 **/
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
    function loop_columns()
    {
        return 3; // 3 products per row
    }
}

/**
 *
 *Overwrite default woocommerce cart widget
 *
 **/
if (!function_exists('override_woocommerce_widgets')) {
    function override_woocommerce_widgets()
    {
        if (class_exists('WC_Widget_Cart')) {
            unregister_widget('WC_Widget_Cart');
            include_once(dirname(__FILE__) . '/woocommerce/widgets/class-wc-widget-cart.php');
            register_widget('Custom_WooCommerce_Widget_Cart');
        }
    }
}
add_action('widgets_init', 'override_woocommerce_widgets', 15);

/**
 *
 * Single Product Share
 *
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
add_action('ct_product_share', 'woocommerce_template_single_sharing');
add_action('woocommerce_share', 'ct_wooshare');
function ct_wooshare()
{
    global $post;

    $thumb_id = get_post_thumbnail_id();
    $thumb_url = wp_get_attachment_image_src($thumb_id, 'full', true);
    if (isset($thumb_url[0])) {
        $thumbSrc = $thumb_url[0];
    } else {
        $thumbSrc = '';
    }


    echo '
    <h4 class="color-motive uppercase">' . __('Share this product', 'ct_theme') . '</h4>
    <ul class="socials">
        <li>
            <a href="' . esc_url('http://www.facebook.com/sharer.php?u=' . get_permalink()) . '" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="Facebook"><i class="fa fa-facebook"></i></a>
        </li>
        <li>
            <a href="' . esc_url('https://twitter.com/share?url=' . get_permalink()) . '" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="Twitter"><i class="fa fa-twitter"></i></a>
        </li>
        <li>
            <a href="' . esc_url('https://plus.google.com/share?url=' . get_permalink()) . '" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="Google +"><i class="fa fa-google-plus"></i></a>
        </li>
        <li>
            <a href="' . esc_url('mailto:?subject=' . get_the_title() . '&body=' . apply_filters('woocommerce_short_description', $post->post_excerpt) . get_permalink()) . '" data-toggle="tooltip" data-placement="top" title="" data-original-title="' . __('Mail', 'ct_theme') . '"><i class="fa fa-envelope"></i></a>
        </li>
    </ul>';
}

/**
 *
 * Single Product Notices
 *
 */
remove_action('woocommerce_before_single_product', 'wc_print_notices', 10);
add_action('woocommerce_before_single_product_summary', 'wc_print_notices', 30);


/**
 *
 * Change number of related products on product page
 * Set your own value for 'posts_per_page'
 *
 */
function woo_related_products_limit()
{
    global $product;

    $args['posts_per_page'] = 4;

    return $args;
}

add_filter('woocommerce_output_related_products_args', 'ct_related_products_args');
function ct_related_products_args($args)
{

    $args['posts_per_page'] = 4; // 3 related products
    $args['columns'] = 4; // arranged in 3 columns
    return $args;
}

remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
add_action('woocommerce_after_single_product', 'woocommerce_output_related_products', 20);

/**
 *
 * Change number of upsell products on product page
 * Set your own value for 'posts_per_page'
 *
 */

remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
add_action('woocommerce_after_single_product', 'woocommerce_output_upsells', 15);

if (!function_exists('woocommerce_output_upsells')) {
    function woocommerce_output_upsells()
    {
        woocommerce_upsell_display(4, 4); // Display 3 products in rows of 3
    }
}


/**
 *
 * Remove single product title
 *
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);

/**
 *
 * Add responsive wrapper to Woocommerce tables
 *
 */
function ct_wrapper_woo_tables()
{
    echo '<div class="table-responsive">';
}

function ct_wrapper_woo_tables_end()
{
    echo '</div>';
}

add_action('woocommerce_before_cart_table', 'ct_wrapper_woo_tables', 10);
add_action('woocommerce_after_cart_table', 'ct_wrapper_woo_tables_end', 10);
add_action('yith_wcwl_before_wishlist', 'ct_wrapper_woo_tables', 10);
add_action('yith_wcwl_after_wishlist', 'ct_wrapper_woo_tables_end', 10);


add_action('ct_custom_breadcrumb', 'ct_woocommerce_breadcrumbs');
if (!function_exists('ct_woocommerce_breadcrumbs')) {
    //draw breadcrumbs for shop (needs ctBreadcrumbs class)
    function ct_woocommerce_breadcrumbs()
    {
        if (class_exists('ctBreadcrumbs')) {
            $breadcrumbs = new ctBreadcrumbs;
            echo $breadcrumbs->display(); //no escape required
        }
    }
}

/**
 *
 * Ensure cart contents update when products are added to the cart via AJAX
 *
 */
if (!function_exists('woocommerce_header_add_to_cart_fragment')) {
    function woocommerce_header_add_to_cart_fragment($fragments)
    {
        global $woocommerce;
        ob_start();
        ?>
        <span
            class="ct-wooCart-numberItems"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count); ?></span>
        <?php
        $fragments['.ct-wooCart-numberItems'] = ob_get_clean();
        return $fragments;
    }
}

add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

/**
 * Ensure that cart is empty after successful paypal payment
 */
if (!function_exists('ct_paypal_empty_cart')) {
    function ct_paypal_empty_cart($id)
    {

        $order = wc_get_order( $id );

        if (!$order->has_status( 'failed' )) {
            WC()->cart->empty_cart();
        }
    }
}

add_action('woocommerce_thankyou_paypal', 'ct_paypal_empty_cart');