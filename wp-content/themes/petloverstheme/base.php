<?php get_template_part('templates/header'); ?>
<?php if (is_page_template('page-blank.php') || is_page_template('page-comingsoon.php')):
    $pageTitle = $breadcrumbs = $color = '';
else:
    $breadcrumbs = ct_show_breadcrumbs() ? 'yes' : 'no';

    if (ct_get_context_option('pages_show_title_row') == 'yes') {
        $pageTitle = ct_get_title();
    } else {
        $pageTitle = '';
    }

endif ?>

<body <?php body_class(); ?>>
<div class="ct-preloader">
    <div class="ct-preloader-content">
        <div id="preloader">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>
<?php get_template_part('templates/ajax'); ?>
<?php do_action('ct_body_open') ?>

<?php if (!is_page_template('page-blank.php') && !is_page_template('page-comingsoon.php')): ?>
<?php get_template_part('templates/mobile/navigation'); ?>
<?php //get_template_part('templates/mobile/wooCartWidget'); ?>
<?php do_action('ct_before_main_wrapper') ?>

<div id="ct-js-wrapper" class="ct-pageWrapper">
    <?php get_template_part('templates/mobile/navbar'); ?>
    <?php do_action('ct_before_head_top_navbar'); ?>
    <?php get_template_part('templates/head-top-navbar'); ?>
    <?php do_action('ct_after_head_top_navbar'); ?>

    <?php
    if (ct_is_woocommerce_active()):
        if (!is_product()):
            if (is_shop() || is_post_type_archive('product') || is_tax(get_object_taxonomies('product'))) {
                ?>
                <header class="ct-breadcrumb--motive">
                    <div class="container ct-breadcrumb ct-breadcrumb--motive">
                        <ol class="breadcrumb">
                            <?php
                            woocommerce_breadcrumb(array('wrap_before' => '<li>', 'wrap_after' => '</li>'));
                            ?>
                        </ol>
                        <span class="ct-breadcrumb-title ct-breadcrumb--white"></span>
                    </div>
                </header>
                <?php
            } else {
                echo do_shortcode('[title_row  context="pages" header="' . $pageTitle . '" breadcrumbs="' . $breadcrumbs . '"]');
            }
        endif;
    else:
        echo do_shortcode('[title_row header="' . $pageTitle . '" breadcrumbs="' . $breadcrumbs . '" breadcrumbs_="' . $pageTitle . '"]');

    endif
    ?>
    <?php endif ?>

    <?php do_action('ct_before_container', $breadcrumbs, $pageTitle) ?>
    <div class="container"><?php include roots_template_path(); ?></div>

    <?php if (!is_page_template('page-blank.php') && !is_page_template('page-comingsoon.php')):
        do_action('ct_before_footer');
        get_template_part('templates/footer');
        do_action('ct_after_footer')
        ?>
    <?php endif ?>

    <a class="ct-ScrollUpButton ct-js-btnScrollUp" href="#"><span class="ct-ScrollUpButton--motive"><i
                class="fa fa-angle-up"></i></span></a>

</div>
<?php do_action('ct_after_main_wrapper') ?>
<?php wp_footer(); ?>

</body>
</html>

