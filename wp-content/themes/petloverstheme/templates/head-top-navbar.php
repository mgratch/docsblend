<?php if (ct_is_woocommerce_active()) {
    global $woocommerce;
    $basketCounter = sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'ct_theme'), $woocommerce->cart->cart_contents_count);
}
?>

<?php echo do_shortcode('[socials]') ?>
<?php if (ct_get_context_option('header_top')=='yes'){?>

    <div class="ct-headerTop">
    <div class="container">
        <div class="ct-headerTop-inner">
            <p><?php echo ct_get_context_option('header_top_text')?></p>

            <ul class="ct-socialsList">
               <?php echo do_shortcode('[socials use_global="yes" type="2"]') ?>
            </ul>
        </div>
    </div>
</div>
<?php
}
?>


<nav
    class="navbar ct-navbar <?php echo ct_get_context_option('pages_navbar_type', 'navbar-default'); ?>  ct-navbar--fadeIn"
    role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand " href="<?php echo esc_url(home_url()); ?>">
                <img class="ct-logoDark" src="<?php echo esc_url(ct_get_context_option('general_logo_standard')); ?>" alt="">
                <img class="ct-logoLight" src="<?php echo esc_url(ct_get_context_option('general_logo_standard2')); ?>" alt="">
                <img class="ct-logoMobileDark" src="<?php echo esc_url(ct_get_context_option('general_logo_mobile')); ?>" alt="">
                <img class="ct-logoMobileLight" src="<?php echo esc_url(ct_get_context_option('general_logo_mobile2')); ?>" alt="">
            </a>
        </div>
            <ul class="nav navbar-nav">

                <?php if (ct_is_location_contains_menu('primary_navigation')) {
                    wp_nav_menu(
                        array(
                            'items_wrap' => '<ul class="%2$s" id="%1$s">%3$s</ul>',
                            'theme_location' => 'primary_navigation',
                            'menu_class' => 'nav navbar-nav',
                            'menu_id' => 'nav'
                        )
                    );
                }
                ?>
                <?php if (ct_is_woocommerce_active()) { ?>
                    <li>
                        <a href="<?php echo $woocommerce->cart->get_cart_url(); ?>"
                           title="<?php _e('View your shopping cart', 'woothemes'); ?>"><i
                                class="fa fa-fw fa-shopping-cart"></i>
                            <span class="ct-wooCart-numberItems"><?php echo esc_html($basketCounter) ?></span>
                        </a>
                        <ul class="dropdown-menu  ct-wooCart-cartBox">
                            <li>
                                <?php if (version_compare(WOOCOMMERCE_VERSION, "2.0.0") >= 0) {
                                    the_widget('Custom_WooCommerce_Widget_Cart', 'title=');
                                } else {
                                    the_widget('WooCommerce_Widget_Cart', 'title=');
                                } ?>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        <!-- /.navbar-collapse -->


       <!-- --><?php /*get_template_part('templates/head-top-navbar', 'searchform'); */?>
    </div>
    <!-- / container -->
</nav>
