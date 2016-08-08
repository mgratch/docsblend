<?php

global $wp_query;
global $post;
$arrgs = $wp_query->query_vars;

if (have_posts()) : ?>
    <?php while (have_posts()) :
        the_post(); ?>
        <?php
        $format = get_post_format();
        $format = $format ? $format : 'standard';
        if ($format == 'standard'):
            $class = 'ct-articleBox ct-articleBox--default ct-articleBox--single';
        else:
            $class = 'ct-articleBox ct-articleBox--default ct-articleBox-' . $format;
        endif?>




<?php
//adds no media class
        if (
            ($format == 'standard'
                && !has_post_thumbnail($post->ID)
                || !ct_get_context_option("posts_index_show_image", 1))
            || ($format == 'image'
                && !has_post_thumbnail($post->ID)
                || !ct_get_context_option("posts_index_show_image", 1))
            || $format == 'quote'
            || $format == 'link'
            || $format == 'aside'
            || $format == 'audio'
        ) {
            $class .= ' no-media';
        }
        ?>




        <?php
        /*--check if it is required--*/
        ct_update_post_counter($post->ID)
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
            <!-- Content -->
            <?php get_template_part('templates/post_single/content-' . $format); ?>


            <!-- Tags -->
            <?php get_template_part('templates/post_single/content-meta','tags'); ?>
            <!-- Share Box -->
            <?php get_template_part('templates/post_single/content-share'); ?>
            <!-- Author Box -->
            <?php get_template_part('templates/post_single/content-author'); ?>
            <!-- Prev next post navigation -->
            <?php get_template_part('templates/post_single/content-navigation'); ?>
            <!-- Comments -->
            <?php comments_template('/templates/comments.php'); ?>
        </article>
    <?php endwhile; ?>
<?php endif ?>