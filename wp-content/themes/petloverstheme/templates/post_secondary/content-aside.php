<?php global $post; ?>
<div class="ct-u-borderBottomGrayLighter ct-u-paddingBoth40">
    <div class="row">


<!-- Meta -->

    <?php get_template_part('templates/post_secondary/content-meta'); ?>


<!-- Description -->
<?php if (ct_get_context_option("posts_index_show_excerpt_fulltext", 'post_excerpt') != 'post_none'): ?>
    <div class="ct-articleBox-description">
        <?php
        if (ct_get_context_option("posts_index_show_excerpt_fulltext", 'post_excerpt') == 'post_excerpt') {
            echo esc_html(ct_get_excerpt_by_id($post->ID, 50));
        } else {
            the_content();
        }
        ?>


    </div>

    <!-- Tags -->
  <!--  --><?php /*get_template_part('templates/post_secondary/content-meta', 'tags'); */?>
<?php endif; ?>
        <?php if (ct_get_context_option("posts_index_show_more", 1)): ?>
            <a href="<?php echo(get_permalink($post->ID)) ?>"
               class="btn btn-motive ct-u-marginTop30"><span><?php _e(ct_get_context_option('posts_index_more_label', 'Read More'), 'ct_theme') ?>

                    <i class="fa fa-location-arrow"></i></span></a>

            <div class="clearfix"></div>
        <?php endif; ?>

</div>
    </div>





