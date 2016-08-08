<div class="ct-navbarMobile ct-navbarMobile--inverse">
    <?php if (ct_is_woocommerce_active()): ?>
        <?php
        global $woocommerce;
        $basketCounter = sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'ct_theme'), $woocommerce->cart->cart_contents_count); ?>
        <a href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>"
           title="<?php _e('View your shopping cart', 'woothemes'); ?>" class="ct-wooCart">
<!--        <button class="ct-wooCart" type="button">-->

            <i class="fa fa-fw fa-shopping-cart"></i>
            <span class="ct-wooCart-numberItems"><?php echo esc_html($basketCounter) ?></span>
<!--        </button>-->
        </a>
    <?php endif ?>

    <a class="navbar-brand"
       href="<?php echo esc_url(home_url()); ?>"> <?php if (ct_get_context_option('general_logo_mobile') != ''): ?><img
            src="<?php echo esc_url(ct_get_context_option('general_logo_mobile')) ?>"
            alt="<?php echo __('mobile logo', 'ct_theme') ?>"><?php endif; ?>
    </a>

    <button type="button" class="navbar-toggle">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
</div>