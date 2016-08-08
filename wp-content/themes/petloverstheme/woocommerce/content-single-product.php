<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();//no escape required
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo esc_attr(woocommerce_get_product_schema()); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 ct-col--withPadding ct-u-paddingTop10">
                <?php
                /**
                 * woocommerce_before_single_product_summary hook
                 *
                 * @hooked woocommerce_show_product_sale_flash - 10
                 * @hooked woocommerce_show_product_images - 20
                 */
                do_action( 'woocommerce_before_single_product_summary' );
                ?>
                <div class="ct-u-paddingTop30 ct-u-paddingBottom20 text-center">
                    <?php do_action( 'woocommerce_product_thumbnails' ); ?>
                </div>
            </div>
            <div class="col-sm-6">
                    <div class="summary entry-summary">
                        <h5 class="ct-fw-600 text-uppercase"><?php echo esc_html(get_the_title()); ?></h5>
                        <?php
                        /**
                         * woocommerce_single_product_summary hook
                         *
                         * @hooked woocommerce_template_single_title - 5
                         * @hooked woocommerce_template_single_rating - 10
                         * @hooked woocommerce_template_single_price - 10
                         * @hooked woocommerce_template_single_excerpt - 20
                         * @hooked woocommerce_template_single_add_to_cart - 30
                         * @hooked woocommerce_template_single_meta - 40
                         * @hooked woocommerce_template_single_sharing - 50
                         */
                        do_action( 'woocommerce_single_product_summary' );
                        ?>
                    </div><!-- .summary -->
                    <div class="clearfix"></div>
                <?php
                /**
                 * woocommerce_after_single_product_summary hook
                 *
                 * @hooked woocommerce_output_product_data_tabs - 10
                 * @hooked woocommerce_upsell_display - 15
                 * @hooked woocommerce_output_related_products - 20
                 */
                do_action( 'woocommerce_after_single_product_summary' );
                ?>
            </div>
            <meta itemprop="url" content="<?php the_permalink(); ?>" />
        </div>
    </div>
    <div class="container">
        <div class="row">
            <?php do_action( 'woocommerce_after_single_product' ); ?>
        </div>
    </div>
</div><!-- #product-<?php the_ID(); ?> -->

