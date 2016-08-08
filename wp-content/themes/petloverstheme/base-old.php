
<?php get_template_part('templates/header'); ?>
<?php if (is_page_template('page-blank.php') || is_page_template('page-comingsoon.php')):
    $pageTitle = $breadcrumbs = $color ='';
else:
    $breadcrumbs = ct_show_breadcrumbs() ? 'yes' : 'no';

    if(ct_get_context_option('pages_show_title_row')=='yes'){
        $pageTitle = ct_get_title();
    }else{
        $pageTitle = '';
    }

endif ?>

<body  <?php body_class(); ?>>
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
            echo do_shortcode('[title_row  context="pages" header="' . $pageTitle . '" breadcrumbs="' . $breadcrumbs . '"]');
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

    <a class="ct-ScrollUpButton ct-js-btnScrollUp" href="#"><span class="ct-ScrollUpButton--motive"><i class="fa fa-angle-up"></i></span></a>

</div>
<?php do_action('ct_after_main_wrapper') ?>
<?php wp_footer(); ?>

<!-- switcher -->
<script src="<?php echo get_template_directory_uri()?>/demo/js/demo.js"></script>
<script type="text/javascript">
    jQuery('head').append('<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/demo/css/demo.css">');
    jQuery('head').append('<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/demo/generator.php">');
</script>

<!--<link rel="stylesheet" type="text/css" href="../demo/css/demo.css">-->
<!--<link rel="stylesheet" type="text/css" href="../demo/generator.php">-->
<div id="stylechooser">

    <div class="easyBox flat">
        <p class="light h4">Accent <strong>Color</strong></p>
        <a href="#" class="halflings cog" id="styleToggle"><i class="fa fa-cogs"></i></a>
    </div>

    <div class="easyBox">
        <div class="mkSpace">
            <div class="title">
                <p class="light h5">Motive <strong>Color</strong></p>
            </div>
            <ul class="demoList clearfix">
                <li><a href="#" title="primary" data-value='default'><span class="demoColor" style="background:#1f8bf3;"></span></a></li>
                <li><a href="#" title="violet" data-value="violet"><span class="demoColor" style="background:#be4db7;"></span></a></li>
                <li><a href="#" title="red" data-value="red"><span class="demoColor" style="background:#d00110;"></span></a></li>
                <li><a href="#" title="orange" data-value="orange"><span class="demoColor" style="background:#ff8613;"></span></a></li>
                <li><a href="#" title="yellow" data-value="yellow"><span class="demoColor" style="background:#ffbc00;"></span></a></li>
                <li><a href="#" title="green" data-value="green"><span class="demoColor" style="background:#9fc62f;"></span></a></li>
                <li><a href="#" title="pink" data-value="pink"><span class="demoColor" style="background:#ed1380;"></span></a></li>
                <li><a href="#" title="brown" data-value="brown"><span class="demoColor" style="background:#8b5542;"></span></a></li>
            </ul>
        </div>
    </div>

    <!--<div class="easyBox">-->
        <!--<div class="mkSpace">-->
            <!--<div class="title">-->
                <!--<p class="light h5">Background <strong>Color</strong></p>-->
            <!--</div>-->
            <!--<ul class="demoList clearfix">-->
                <!--<li><a href="#" title="default" data-value='default'><span class="demoColor" style="background:#ce0000;"></span></a></li>-->
                <!--<li><a href="#" title="orange" data-value="orange"><span class="demoColor" style="background:#ff7f00;"></span></a></li>-->
                <!--<li><a href="#" title="yellow" data-value="yellow"><span class="demoColor" style="background:#ffd600;"></span></a></li>-->
                <!--<li><a href="#" title="green" data-value="green"><span class="demoColor" style="background:#8dc153;"></span></a></li>-->
                <!--<li><a href="#" title="cyan" data-value="cyan"><span class="demoColor" style="background:#22cbe8;"></span></a></li>-->
                <!--<li><a href="#" title="red" data-value="blue"><span class="demoColor" style="background:#2b8be9;"></span></a></li>-->
            <!--</ul>-->
        <!--</div>-->
    <!--</div>-->

</div>
<!-- end switcher -->
</body>
</html>
=======
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

<!-- switcher -->
<script src="<?php echo get_template_directory_uri()?>/demo/js/demo.js"></script>
<script type="text/javascript">
    jQuery('head').append('<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/demo/css/demo.css">');
    jQuery('head').append('<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/demo/generator.php">');
</script>

<!--<link rel="stylesheet" type="text/css" href="../demo/css/demo.css">-->
<!--<link rel="stylesheet" type="text/css" href="../demo/generator.php">-->
<div id="stylechooser">

    <div class="easyBox flat">
        <p class="light h4">Accent <strong>Color</strong></p>
        <a href="#" class="halflings cog" id="styleToggle"><i class="fa fa-cogs"></i></a>
    </div>

    <div class="easyBox">
        <div class="mkSpace">
            <div class="title">
                <p class="light h5">Motive <strong>Color</strong></p>
            </div>
            <ul class="demoList clearfix">
                <li><a href="#" title="primary" data-value='default'><span class="demoColor" style="background:#1f8bf3;"></span></a></li>
                <li><a href="#" title="violet" data-value="violet"><span class="demoColor" style="background:#be4db7;"></span></a></li>
                <li><a href="#" title="red" data-value="red"><span class="demoColor" style="background:#d00110;"></span></a></li>
                <li><a href="#" title="orange" data-value="orange"><span class="demoColor" style="background:#ff8613;"></span></a></li>
                <li><a href="#" title="yellow" data-value="yellow"><span class="demoColor" style="background:#ffbc00;"></span></a></li>
                <li><a href="#" title="green" data-value="green"><span class="demoColor" style="background:#9fc62f;"></span></a></li>
                <li><a href="#" title="pink" data-value="pink"><span class="demoColor" style="background:#ed1380;"></span></a></li>
                <li><a href="#" title="brown" data-value="brown"><span class="demoColor" style="background:#8b5542;"></span></a></li>
            </ul>
        </div>
    </div>

    <!--<div class="easyBox">-->
        <!--<div class="mkSpace">-->
            <!--<div class="title">-->
                <!--<p class="light h5">Background <strong>Color</strong></p>-->
            <!--</div>-->
            <!--<ul class="demoList clearfix">-->
                <!--<li><a href="#" title="default" data-value='default'><span class="demoColor" style="background:#ce0000;"></span></a></li>-->
                <!--<li><a href="#" title="orange" data-value="orange"><span class="demoColor" style="background:#ff7f00;"></span></a></li>-->
                <!--<li><a href="#" title="yellow" data-value="yellow"><span class="demoColor" style="background:#ffd600;"></span></a></li>-->
                <!--<li><a href="#" title="green" data-value="green"><span class="demoColor" style="background:#8dc153;"></span></a></li>-->
                <!--<li><a href="#" title="cyan" data-value="cyan"><span class="demoColor" style="background:#22cbe8;"></span></a></li>-->
                <!--<li><a href="#" title="red" data-value="blue"><span class="demoColor" style="background:#2b8be9;"></span></a></li>-->
            <!--</ul>-->
        <!--</div>-->
    <!--</div>-->

</div>
<!-- end switcher -->
</body>
</html>
>>>>>>> .r12309
