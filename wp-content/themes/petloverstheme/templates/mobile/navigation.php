<div class="ct-menuMobile ct-menuMobile--dark">
    <?php if (ct_is_location_contains_menu('primary_navigation')) {
        wp_nav_menu(
            array(
                'items_wrap' => '<ul id="%1$s" class="ct-menuMobile-navbar">%3$s</ul>',
                'theme_location' => 'primary_navigation',
                'menu_class' => 'ct-menuMobile-navbar',
                'menu_id' => 'nav'
            )
        );
    }
    ?>
</div>
<?php //get_template_part('templates/mobile/wooCartWidget'); ?>