<script src="<?php echo esc_url(CT_THEME_ASSETS . '/js/masonry.min.js')?>"></script>
<script src="<?php echo esc_url(CT_THEME_ASSETS . '/js/blog/init.js')?>"></script>


<div class="row">
    <div class="ct-js-blogMasonry">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php $format = get_post_format();
                $format = $format ? $format : 'standard';
                $class = $format == 'standard' ? 'ct-articleBox ct-articleBox--thumbnail' : 'ct-articleBox ct-articleBox--thumbnail ct-articleBox--' . $format;
                if (($format == 'standard' && !has_post_thumbnail(get_the_id()) || !ct_get_context_option("posts_index_show_image", 1))
                    || ($format == 'image' && !has_post_thumbnail(get_the_id()) || !ct_get_context_option("posts_index_show_image", 1))
                    || $format == 'quote'
                    || $format == 'link'
                    || $format == 'aside'
                    || $format == 'audio'
                ) {
                    $class .= ' ct-articleBox--noMedia';
                } ?>

                <?php /*Dark motive article class modify*/
                if (ct_get_context_option('general_flavour') == 'ct--darkMotive') {
                    $class .= ' ct-articleBox--dark';
                } ?>

                <div class="col-sm-4 ct-js-blogMasonry-item">
                    <article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
                        <?php get_template_part('templates/post_masonry/content-' . $format); ?>
                    </article>
                </div>
            <?php endwhile; ?>

            <!-- / blog-list -->

        <?php endif; ?>
    </div>
</div>

<?php get_template_part('templates/post_masonry/content-post', 'pagination'); ?>