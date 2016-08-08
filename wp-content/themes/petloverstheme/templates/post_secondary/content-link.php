<?php global $post; ?>
<div class="ct-u-borderBottomGrayLighter ct-u-paddingBoth40">
<!-- Title Box -->

    <?php if (ct_get_context_option("posts_index_show_title", 1)): ?>
        <a href="<?php echo(esc_url(get_permalink($post->ID))) ?>"><h5
                class="ct-fw-600"><?php echo esc_html(ct_get_blog_item_title()) ?></h5></a>
    <?php endif; ?>


    <?php get_template_part('templates/post_secondary/content-meta'); ?>


<?php if (ct_get_context_option("posts_index_show_excerpt", 1)): ?>
    <!-- Description -->
    <div class="ct-articleBox-description">
        <a href="<?php echo esc_url(get_post_meta($post->ID, 'link', true)) ?>"><?php _e(esc_html(ct_get_blog_item_title())) ?> <i class="fa fa-long-arrow-right"></i></a>

        <!-- Tags -->
     <!--   --><?php /*get_template_part('templates/post_secondary/content-meta','tags'); */?>

    </div>
<?php endif ?>

</div>

