<?php global $post; ?>


<div class="ct-u-paddingBoth40 ct-u-borderBottomGrayLighter">

<?php if (ct_get_context_option("posts_index_show_image", 1)): ?>
    <!-- Media -->
    <div class="ct-articleBox-media">
        <?php get_template_part('templates/post/content-gallery', 'gallery'); ?>
    </div>

<?php endif; ?>



<!-- Title Box -->
<div class="ct-articleBox-titleBox">
    <?php if (ct_get_context_option("posts_index_show_title", 1)): ?>
        <h4><a href="<?php echo (esc_url(get_permalink($post->ID))) ?>"><?php echo esc_html(ct_get_blog_item_title()) ?></a></h4>
    <?php endif; ?>
    <!-- Meta -->
    <?php get_template_part('templates/post/content-meta'); ?>
</div>

<!-- Description -->
<?php if (ct_get_context_option("posts_index_show_excerpt_fulltext", 'post_excerpt') != 'post_none'): ?>
    <div class="ct-articleBox-description">
        <?php
        if (ct_get_context_option("posts_index_show_excerpt_fulltext", 'post_excerpt') == 'post_excerpt') {
            echo esc_html(ct_get_excerpt_by_id($post->ID, 100));
        } else {
            the_content();
        }
        ?>

    </div>
<?php endif; ?>

<!-- Tags -->
<?php /*get_template_part('templates/post/content-meta','tags'); */?>

    <?php if (ct_get_context_option("posts_index_show_more", 1)): ?>
        <a href="<?php echo(get_permalink($post->ID)) ?>"
           class="btn btn-motive ct-u-marginTop30"><span><?php _e(ct_get_context_option('posts_index_more_label','Read More'), 'ct_theme') ?>

                <i class="fa fa-location-arrow"></i></span></a>

        <div class="clearfix"></div>
    <?php endif; ?>


</div>