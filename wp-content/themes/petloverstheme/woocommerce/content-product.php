<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;


// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
    $woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
    return;
}


?>
<li <?php post_class( ); ?>>
    <div class="ct-productWrapper">
        <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
        <div class="ct-imgWrapper">
            <a href="<?php the_permalink(); ?>">

                <?php
                /**
                 * woocommerce_before_shop_loop_item_title hook
                 *
                 * @hooked woocommerce_show_product_loop_sale_flash - 10
                 * @hooked woocommerce_template_loop_product_thumbnail - 10
                 */
                do_action( 'woocommerce_before_shop_loop_item_title' );
                ?>
                <h3><?php the_title(); ?></h3>
        </div>
        <p class="ct-product-description"> <?php echo $post->post_excerpt?> </p>

        <div class="ct-rating-withPrice">

            <?php
            /**
             * woocommerce_after_shop_loop_item_title hook
             *
             * @hooked woocommerce_template_loop_price - 0
             * @hooked woocommerce_template_loop_rating - 5
             */
            do_action( 'woocommerce_after_shop_loop_item_title' );
            ?>
        </div>

        </a>
        <div class="ct-addToCart">
            <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
        </div>

    </div>
</li>