<?php if (ct_is_woocommerce_active()) { ?>
    <div class="ct-cartMobile">
        <?php if (version_compare(WOOCOMMERCE_VERSION, "2.0.0") >= 0) {
            the_widget('Custom_WooCommerce_Widget_Cart', 'title=');
        } else {
            the_widget('WooCommerce_Widget_Cart', 'title=');
        }?>
    </div>
<?php } ?>