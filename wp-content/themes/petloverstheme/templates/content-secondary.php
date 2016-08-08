<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php
        $format = get_post_format();
        $format = $format ? $format : 'standard';
        $class = $format == 'standard' ? 'ct-articleBox ct-articleBox--secondary' : 'ct-articleBox ct-articleBox--secondary ct-articleBox--' . $format;

        if (($format == 'standard' && !has_post_thumbnail(get_the_id()) || !ct_get_context_option("posts_index_show_image", 1))
            || ($format == 'image' && !has_post_thumbnail(get_the_id()) || !ct_get_context_option("posts_index_show_image", 1))
            || $format == 'quote'
            || $format == 'link'
            || $format == 'aside'
            || $format == 'audio'
        ) {
            $class .= ' ct-articleBox--noMedia';
        }
        ?>
        <article id="post-<?php the_ID(); ?>">
            <?php get_template_part('templates/post_secondary/content-' . $format); ?>

        </article>
    <?php endwhile; ?>
    <!-- / blog-list -->

    <?php get_template_part('templates/post_secondary/content-post', 'pagination'); ?>
<?php endif; ?>
