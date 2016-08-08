<!DOCTYPE html>
<!--[if IE 8 ]>
<html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>
<html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <?php if (have_posts()) : ?>
        <link rel="alternate" type="application/rss+xml" title="<?php echo esc_attr(get_bloginfo('name')) ?> Feed"
              href="<?php echo esc_url(home_url()) ?>/feed/">
    <?php endif; ?>



    <!--[if lt IE 9]>

    <script src="<?php echo esc_url(CT_THEME_ASSETS.'/bootstrap/js/html5shiv.js')?>"></script>
    <script src="<?php echo esc_url(CT_THEME_ASSETS.'/bootstrap/js/respond.min.js')?>"></script>
    <![endif]-->
    <?php wp_head();?>
</head>
